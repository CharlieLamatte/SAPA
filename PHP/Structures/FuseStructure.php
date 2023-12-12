<?php

use Sportsante86\Sapa\Model\Structure;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

// get posted data
$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_structure_1) &&
    !empty($input_data->id_structure_2)) {
    $structure = new Structure($bdd);
    $success = $structure->fuse(
        $input_data->id_structure_1,
        $input_data->id_structure_2
    );

    if ($success) {
        \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
            'User ' . $_SESSION['email_connecte'] . ' fused structure successfully (ids were ' . $input_data->id_structure_1 . ' and ' . $input_data->id_structure_2 . ')',
            ['event' => 'fuse:structure']
        );

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(["message" => "Structures were fused."]);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $structure->getErrorMessage(),
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