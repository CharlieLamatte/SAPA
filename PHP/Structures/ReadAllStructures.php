<?php

use Sportsante86\Sapa\Model\Structure;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"), true);
// paramètre optionnel
$id_territoire = empty($input_data['id_territoire']) ? null : $input_data['id_territoire'];

$structure = new Structure($bdd);
$item = $structure->readAll($_SESSION, $id_territoire);

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
            'error_message' => $structure->getErrorMessage(),
            'data' => json_encode($input_data),
        ]
    );
}