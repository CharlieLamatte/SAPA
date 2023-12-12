<?php
/**
 * Suppression de toutes les séances d'un utilisateur
 * Uniquement possible si en environnement 'TEST'
 */

use Sportsante86\Sapa\Model\Seance;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

if ($_ENV['ENVIRONNEMENT'] !== 'TEST') {
    // set response code - 403 Forbidden
    http_response_code(403);
    echo json_encode(["message" => 'Forbidden']);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
        'User ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource without entitlement',
        [
            'event' => 'authz_fail:' . $_SESSION['email_connecte'],
        ]
    );
    die();
}

$input_data = json_decode(file_get_contents("php://input"));

try {
    $s = new Seance($bdd);
    $bdd->beginTransaction();
    $s->deleteAllSeancesUser($input_data->id_user);
    $bdd->commit();

    // set response code - 200 ok
    http_response_code(200);
    echo json_encode(['message' => 'ok']);
} catch (Exception $exception) {
    $bdd->rollBack();

    // set response code - 500 Internal Server Error
    http_response_code(500);
    echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
        [
            'error_message' => $s->getErrorMessage(),
            'data' => json_encode($input_data),
        ]
    );
}