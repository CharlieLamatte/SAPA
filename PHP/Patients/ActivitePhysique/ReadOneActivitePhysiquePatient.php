<?php

use Sportsante86\Sapa\Model\ActivitePhysique;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

// get posted data
$input_data = json_decode(file_get_contents("php://input"), true);

if (!empty($input_data['id_patient'])) {
    $activitePhysique = new ActivitePhysique($bdd);
    $item = $activitePhysique->readOnePatient($input_data['id_patient']);

    if ($item) {
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($item);
    } else {
        // set response code - 404 Not found
        http_response_code(404);
        echo json_encode(["message" => "No data found."]);
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