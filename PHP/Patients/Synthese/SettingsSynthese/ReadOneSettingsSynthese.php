<?php

use Sportsante86\Sapa\Model\SettingsSynthese;

require '../../../../bootstrap/bootstrap.php';
require '../../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_settings_synthese)) {
    $settingsSynthese = new SettingsSynthese($bdd);
    $item = $settingsSynthese->readOne($input_data->id_settings_synthese);

    if ($item) {
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($item);
    } else {
        // set response code - 404 not found
        http_response_code(404);
        echo json_encode(["message" => "Not Found"]);
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