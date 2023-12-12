<?php

use Sportsante86\Sapa\Model\Seance;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_creneau) &&
    !empty($input_data->id_user) &&
    !empty($input_data->date)) {
    $recurs = $input_data->recurs;

    $seance = new Seance($bdd);
    if ($recurs === 'false') {
        if (!$seance->isDateValid($input_data->id_creneau, $input_data->date)) {
            // set response code - 400 bad request
            http_response_code(400);
            echo json_encode(
                ["message" => "Échec de l'ajout. Cause: la date choisie n'est pas disponible pour le créneau."]
            );
            die();
        }

        $id_seance = $seance->create([
            'id_creneau' => $input_data->id_creneau,
            'id_user' => $input_data->id_user,
            'date' => $input_data->date,
            'commentaire' => $input_data->commentaire,
        ]);
        $ids = [$id_seance];

        $success = $id_seance != false;
    } else {
        $ids = $seance->createBetweenTwoDates([
            'id_creneau' => $input_data->id_creneau,
            'id_user' => $input_data->id_user,
            'date_start' => $input_data->date,
            'date_end' => $input_data->date_fin,
            'commentaire' => $input_data->commentaire,
        ]);

        // si aucune séance a été créée
        if (is_array($ids) && empty($ids)) {
            // set response code - 400 bad request
            http_response_code(400);
            echo json_encode(
                ["message" => "Échec de l'ajout. Cause: il n'y a pas de date possible dans l'interval donné"]
            );
            die();
        }

        $success = $ids != false;
    }

    if ($success) {
        $output = $seance->readMultiple($ids);

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