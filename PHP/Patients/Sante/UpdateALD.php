<?php

use Sportsante86\Sapa\Model\Ald;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

// get posted data
$input_data = json_decode(file_get_contents("php://input"), true);

if (!empty($input_data['id_patient']) &&
    is_array($input_data['liste_alds'])) {
    $ald = new Ald($bdd);
    $update_ok = $ald->update([
        'id_patient' => $input_data['id_patient'],
        'liste_alds' => $input_data['liste_alds'],
    ]);

    if ($update_ok) {
        $alds = $ald->readAllPatient($input_data['id_patient']);

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($alds);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $ald->getErrorMessage(),
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