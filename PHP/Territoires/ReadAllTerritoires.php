<?php

use Sportsante86\Sapa\Model\Territoire;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

$id_type_territoire = null;
if (!empty($input_data->id_type_territoire)) {
    $id_type_territoire = $input_data->id_type_territoire;
}
$id_region = null;
if (!empty($input_data->id_region)) {
    $id_region = $input_data->id_region;
}

$territoire = new Territoire($bdd);
$item = $territoire->readAll($_SESSION, $id_type_territoire, $id_region);

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
            'error_message' => $territoire->getErrorMessage(),
        ]
    );
}