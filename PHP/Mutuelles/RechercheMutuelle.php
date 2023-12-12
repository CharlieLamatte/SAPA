<?php

use Sportsante86\Sapa\Model\Mutuelle;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$mutuelle = new Mutuelle($bdd);
$item = $mutuelle->readAll();

if (is_array($item)) {
    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($item);
} else {
    // set response code - 500 Internal Server Error
    http_response_code(500);
    echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
        [
            'error_message' => $mutuelle->getErrorMessage(),
        ]
    );
}