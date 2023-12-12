<?php

use Sportsante86\Sapa\Model\Questionnaire;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"), true);

if (!empty($input_data['id_patient']) &&
    !empty($input_data['id_questionnaire']) &&
    !empty($input_data['id_user'])) {
    $questionnaire = new Questionnaire($bdd);
    $id_questionnaire_instance = $questionnaire->create([
        'id_patient' => $input_data['id_patient'],
        'id_questionnaire' => $input_data['id_questionnaire'],
        'id_user' => $input_data['id_user'],
        'date' => date("Y-m-d"),
        'reponses' => $input_data['reponses'],
    ]);

    if ($id_questionnaire_instance) {
        $result = $questionnaire->readReponses($id_questionnaire_instance);

        // set response code - 201 Created
        http_response_code(201);
        echo json_encode($result);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $questionnaire->getErrorMessage(),
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