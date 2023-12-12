<?php

use Sportsante86\Sapa\Model\Intervenant;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_intervenant)) {
    $intervenant = new Intervenant($bdd);
    $deleted_intervenant = $intervenant->readOne($input_data->id_intervenant);
    $delete_ok = $intervenant->delete($input_data->id_intervenant);

    if ($delete_ok) {
        \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
            'User ' . $_SESSION['email_connecte'] . ' deleted intervenant successfully (id was '. $input_data->id_intervenant. ')',
            [
                'event' => 'delete:intervenant',
                'deleted_data' => json_encode($deleted_intervenant)
            ]
        );

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(["message" => "Ok"]);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $intervenant->getErrorMessage(),
                'data' => json_encode($input_data),
            ]
        );
    }
} else {
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(["message" => "Data is incomplete."]);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'User ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource using incomplete data',
        [
            'data' => json_encode($input_data)
        ]
    );
}