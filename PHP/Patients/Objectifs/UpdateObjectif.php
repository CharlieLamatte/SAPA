<?php

use Sportsante86\Sapa\Model\Objectif;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_obj_patient) &&
    !empty($input_data->date_objectif_patient) &&
    !empty($input_data->nom_objectif) &&
    !empty($input_data->pratique) &&
    !empty($input_data->desc_objectif)) {
    $objectif = new Objectif($bdd);
    $update_ok = $objectif->update([
        'id_obj_patient' => $input_data->id_obj_patient,
        'nom_objectif' => $input_data->nom_objectif,
        'date_objectif_patient' => $input_data->date_objectif_patient,
        'desc_objectif' => $input_data->desc_objectif,
        'pratique' => $input_data->pratique,

        'type_activite' => $input_data->type_activite,
        'duree' => $input_data->duree,
        'frequence' => $input_data->frequence,
        'infos_complementaires' => $input_data->infos_complementaires,
    ]);

    if ($update_ok) {
        $item = $objectif->readOne($input_data->id_obj_patient);
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