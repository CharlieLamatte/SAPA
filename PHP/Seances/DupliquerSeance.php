<?php

use Sportsante86\Sapa\Model\Seance;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_seance) &&
    !empty($input_data->dateFin)) {
    $seance = new Seance($bdd);
    $ids = $seance->duplicateSeance([
        'id_seance' => $input_data->id_seance,
        'date_end' => $input_data->dateFin,
    ]);

    // si aucune séance a été créée
    if (is_array($ids) && empty($ids)) {
        // set response code - 400 bad request
        http_response_code(400);
        echo json_encode(array("message" => "Échec de l'ajout. Cause: il n'y a pas de date possible dans l'interval donné"));
        die();
    }

    if (is_array($ids)) {
        $output = $seance->readMultiple($ids);
        $output = $output == false ? [] : $output;

        // set response code - 201 created
        http_response_code(201);
        echo json_encode($output);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $seance->getErrorMessage(),
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