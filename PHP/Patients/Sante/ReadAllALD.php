<?php

use Sportsante86\Sapa\Model\Ald;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$ald = new Ald($bdd);
$all_ald = $ald->readAll();

if (is_array($all_ald)) {
    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($all_ald);
} else {
    // set response code - 500 Internal Server Error
    http_response_code(500);
    echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
        [
            'error_message' => $ald->getErrorMessage(),
        ]
    );
}