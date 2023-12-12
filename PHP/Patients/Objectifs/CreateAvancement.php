<?php

use Sportsante86\Sapa\Model\Objectif;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->date_avancement) &&
    !empty($input_data->atteinte) &&
    !empty($input_data->id_obj_patient)) {
    $objectif = new Objectif($bdd);
    $id_avancement_obj = $objectif->createAvancement([
        'id_obj_patient' => $input_data->id_obj_patient,
        'atteinte' => $input_data->atteinte,
        'date_avancement' => $input_data->date_avancement,
        'commentaires' => $input_data->commentaires,
    ]);

    if ($id_avancement_obj) {
        $item = $objectif->readOneAvancement($id_avancement_obj);
        // set response code - 201 created
        http_response_code(201);
        echo json_encode($item);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $objectif->getErrorMessage(),
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