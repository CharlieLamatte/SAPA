<?php

use Sportsante86\Sapa\Outils\FilesManager;
use Sportsante86\Sapa\Model\Synthese;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id_synthese)) {
    $synth = new Synthese($bdd);
    $synthese = $synth->readOne($data->id_synthese);

    if ($synthese) {
        $result = $synth->deleteSynthese($data->id_synthese);

        if ($result) {
            FilesManager::delete_file($root . '/uploads/syntheses/' . $synthese['synthese']);
            // set response code - 200 OK
            http_response_code(200);
            echo json_encode($result);
        } else {
            // set response code - 500 Internal Server Error
            http_response_code(500);
            echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
            \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
                'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
                [
                    'error_message' => $synth->getErrorMessage(),
                    'data' => json_encode($data),
                ]
            );
        }
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $synth->getErrorMessage(),
                'data' => json_encode($data),
            ]
        );

        // set response code - 404 Not found
        http_response_code(404);
        echo json_encode(["message" => "Not found"]);
    }
} else {
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(["message" => "Data is incomplete."]);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'User ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource using incomplete data',
        [
            'data' => json_encode($data)
        ]
    );
}