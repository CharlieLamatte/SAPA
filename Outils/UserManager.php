<?php
/**
 * This class requires the following environnement variables to be defined :
 * $_ENV['ENVIRONNEMENT']
 * $_ENV['MAIL_HOST']
 * $_ENV['MAIL_PORT']
 * $_ENV['MAIL_USERNAME']
 * $_ENV['MAIL_PASSWORD']
 */

namespace Sportsante86\Sapa\Outils;

use DateTime;
use Exception;
use PDO;

class UserManager
{
    private PDO $pdo;
    private string $errorMessage = "";

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return string the error message of the last operation
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @param $email
     * @return bool
     */
    public function send_recovery_email($email): bool
    {
        $auth = new Authentification($this->pdo);
        if (!$auth->user_exists($email)) {
            $this->errorMessage = "Error: user doesn't exist";
            return false;
        }

        $token = $this->generate_token();
        if (!$token) {
            $this->errorMessage = "Error when generating token";
            return false;
        }

        try {
            $this->pdo->beginTransaction();

            $query = '
                UPDATE users
                SET recovery_token            = :recovery_token,
                    recovery_token_created_at = NOW()
                WHERE identifiant = :identifiant';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(":identifiant", $email);
            $stmt->bindValue(":recovery_token", $token);
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            $this->errorMessage = $e->getMessage();
            return false;
        }

        try {
            // envoie du mail
            SapaMailer::sendAccountRecoveryMail($email, $token);
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }

        return true;
    }

    /**
     * @param string $token
     * @return bool if the token exists and was created less than 1 hour ago
     */
    public function is_token_valid(string $token): bool
    {
        try {
            $query = '
                SELECT recovery_token_created_at
                FROM users
                WHERE recovery_token = :recovery_token';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(":recovery_token", $token);
            $stmt->execute();
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }

        if ($stmt->rowCount() == 0) {
            $this->errorMessage = "Error: recovery_token not found";
            return false;
        }

        if ($stmt->rowCount() > 1) {
            $this->errorMessage = "Error: more than 1 recovery_token exist";
            return false;
        }

        $recovery_token_created_at = $stmt->fetchColumn();
        if (empty($recovery_token_created_at)) {
            $this->errorMessage = "Error: recovery_token_created_at is null";
            return false;
        }

        return $this->is_less_than_1_hour_ago($recovery_token_created_at);
    }

    /**
     * @param string $datetime a date in the format "Y-m-d H:i:s"
     * @return bool
     */
    public function is_less_than_1_hour_ago(string $datetime): bool
    {
        try {
            date_default_timezone_set("Europe/Paris");
            $now = new DateTime();
            $date = new DateTime($datetime);

            $minutes = ($now->getTimestamp() - $date->getTimestamp()) / 60;

            // si $minutes est négatif $datetime est dans le futur par rapport à la date actuelle
            if ($minutes < 0) {
                $this->errorMessage = "Error: the date is in the future";
                return false;
            }

            return $minutes < 60;
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }

    /**
     * Updates the password and resets recovery_token and recovery_token_created_at
     *
     * @param string $token
     * @param string $new_password
     * @return array['ok' => bool, 'email' => string]
     *
     */
    public function update_password(string $token, string $new_password): array
    {
        $result = [
            'ok' => false,
            'email' => ""
        ];

        if (empty($token) || empty($new_password)) {
            $this->errorMessage = "Error: the date is in the future";
            return $result;
        }

        if (!$this->is_token_valid($token)) {
            return $result;
        }

        try {
            $this->pdo->beginTransaction();

            $mdp = password_hash($new_password, PASSWORD_DEFAULT);

            // recupération de l'adresse mail
            $query = '
                SELECT identifiant
                FROM users
                WHERE recovery_token = :recovery_token';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(":recovery_token", $token);
            $stmt->execute();
            $result['email'] = $stmt->fetchColumn();

            // update du mot de passe
            $query = "
                UPDATE users
                SET pswd                      = :pswd,
                    recovery_token            = NULL,
                    recovery_token_created_at = NULL
                WHERE recovery_token = :recovery_token";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':recovery_token', $token);
            $stmt->bindValue(':pswd', $mdp);
            $stmt->execute();
            $this->pdo->commit();

            $result['ok'] = true;
            return $result;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            $this->errorMessage = $e->getMessage();
            return $result;
        }
    }

    /**
     * @param int $length an int greater than 0, default is 24
     * @return false|string a string of length $length or false on failure
     */
    public function generate_token(int $length = 24)
    {
        if ($length <= 0) {
            $this->errorMessage = 'Le paramètre $length doit être supérieur à 0';
            return false;
        }

        try {
            $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pieces = [];
            $max = mb_strlen($stringSpace, '8bit') - 1;
            if (is_bool($max)) {
                return false;
            }

            for ($i = 0; $i < $length; ++$i) {
                $pieces[] = $stringSpace[random_int(0, $max)];
            }

            return implode('', $pieces);
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
            return false;
        }
    }
}