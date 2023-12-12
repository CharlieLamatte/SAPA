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

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class SapaMailer
{
    public const TYPE_MAILER_LOG = "LOG";
    public const TYPE_MAILER_MAIL = "MAIL";

    private function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public static function sendAccountRecoveryMail($email, $token)
    {
        $subject = "Réinitialisation du mot de passe SAPA";

        if ($_ENV['MAIL_MAILER'] == self::TYPE_MAILER_MAIL) {
            self::sendMail(
                $email,
                "Réinitialisation du mot de passe SAPA",
                self::getEmailRecoveryHtmlFormat($token),
                self::getEmailRecoverySimpleTextFormat($token)
            );
        } elseif ($_ENV['MAIL_MAILER'] == self::TYPE_MAILER_LOG) {
            SapaLogger::get()->info(
                'Sending email via log',
                [
                    'event' => 'email_sent_via_log:' . $email,
                    'email_receiver' => $email,
                    'subject' => $subject,
                    'body_html' => self::getEmailRecoveryHtmlFormat($token),
                    'body_simple_text' => self::getEmailRecoverySimpleTextFormat($token),
                ]
            );
        }
    }

    public static function sendAccountCreationMail($email, $token)
    {
        //TODO
    }

    /**
     * @throws Exception
     */
    private static function sendMail($email, $subject, $htmlBody, $body)
    {
        //Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        //SMTP::DEBUG_OFF = off (for production use)
        //SMTP::DEBUG_CLIENT = client messages
        //SMTP::DEBUG_SERVER = client and server messages
        $mail->SMTPDebug = SMTP::DEBUG_OFF;

        //Set the hostname of the mail server
        $mail->Host = $_ENV['MAIL_HOST'];
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = $_ENV['MAIL_PORT'];

        //Set the encryption mechanism to use:
        // - SMTPS (implicit TLS on port 465) or
        // - STARTTLS (explicit TLS on port 587)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
        $mail->Username = $_ENV['MAIL_USERNAME'];
        //Password to use for SMTP authentication
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        //Set who the message is to be sent from
        $mail->setFrom($_ENV['MAIL_USERNAME']);
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        $mail->addAddress($email);
        //Set the subject line
        $mail->Subject = mb_convert_encoding($subject, 'ISO-8859-1');
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML(mb_convert_encoding($htmlBody, 'ISO-8859-1'));
        //Replace the plain text body with one created manually
        $mail->AltBody = $body;

        //send the message, check for errors
        if (!$mail->send()) {
            throw new Exception($mail->ErrorInfo);
        }
    }

    public static function getEmailRecoveryHtmlFormat($token)
    {
        $recovery_link = base_url(true) .
            'PHP/account_recovery/recover_account.php?t=' . $token;

        return '
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                <title>Réinitialisation du mot de passe SAPA</title>
            </head>
            <body>
            <div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
                <h3>Réinitialisation du mot de passe de votre compte SAPA</h3>
                <p>
                    Cliquez sur le lien suivant pour réinitialiser votre mot de passe:
                    <a href="' . $recovery_link . '">Lien de
                        réinitialisation</a>
                </p>
                <p>Le lien est valable 60 minutes.</p>
                <p>Si le lien n\'est pas cliquable, copiez/collez le lien suivant dans votre naviguateur:</p>
                <p>' . $recovery_link . '</p>
            </div>
            </body>
            </html>';
    }

    public static function getEmailRecoverySimpleTextFormat($token): string
    {
        $recovery_link = base_url(true) .
            'PHP/account_recovery/recover_account.php?t=' . $token;

        return '
            Réinitialisation du mot de passe de votre compte SAPA

            Copiez/collez le lien suivant dans votre naviguateur:
            
            ' . $recovery_link . '
            
            Le lien est valable 60 minutes.';
    }
}