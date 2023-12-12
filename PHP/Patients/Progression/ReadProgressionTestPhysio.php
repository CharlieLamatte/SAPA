<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';
require 'ProgressionTestPhysio.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_patient) &&
    !empty($input_data->column)) {
    try {
        $progression = new ProgessionTestPhysio($bdd, $input_data->column, $input_data->id_patient);
        $result = $progression->getProgression();

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($result);
    } catch (Exception $exception) {
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $exception->getMessage(),
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