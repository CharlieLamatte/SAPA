<?php

use Sportsante86\Sapa\Model\Pathologie;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

// get posted data
$input_data = json_decode(file_get_contents("php://input"));

if (isset(
    $input_data->id_patient,
    $input_data->a_patho_cardio,
    $input_data->a_patho_respiratoire,
    $input_data->a_patho_metabolique,
    $input_data->a_patho_osteo_articulaire,
    $input_data->a_patho_psycho_social,
    $input_data->a_patho_neuro,
    $input_data->a_patho_cancero,
    $input_data->a_patho_circulatoire,
    $input_data->a_patho_autre
)) {
    $patho = new Pathologie($bdd);
    $update_ok = $patho->update([
        'id_pathologie' => $input_data->id_pathologie,
        'a_patho_cardio' => $input_data->a_patho_cardio,
        'a_patho_respiratoire' => $input_data->a_patho_respiratoire,
        'a_patho_metabolique' => $input_data->a_patho_metabolique,
        'a_patho_osteo_articulaire' => $input_data->a_patho_osteo_articulaire,
        'a_patho_psycho_social' => $input_data->a_patho_psycho_social,
        'a_patho_neuro' => $input_data->a_patho_neuro,
        'a_patho_cancero' => $input_data->a_patho_cancero,
        'a_patho_circulatoire' => $input_data->a_patho_circulatoire,
        'a_patho_autre' => $input_data->a_patho_autre,

        'cardio' => $input_data->cardio,
        'respiratoire' => $input_data->respiratoire,
        'metabolique' => $input_data->metabolique,
        'osteo_articulaire' => $input_data->osteo_articulaire,
        'psycho_social' => $input_data->psycho_social,
        'neuro' => $input_data->neuro,
        'cancero' => $input_data->cancero,
        'circulatoire' => $input_data->circulatoire,
        'autre' => $input_data->autre,
    ]);

    if ($update_ok) {
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(["message" => "OK"]);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $patho->getErrorMessage(),
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