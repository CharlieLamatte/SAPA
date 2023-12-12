<?php

use Sportsante86\Sapa\Model\SettingsSynthese;

require '../../../../bootstrap/bootstrap.php';
require '../../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_settings_synthese)) {
    $settingsSynthese = new SettingsSynthese($bdd);
    $update_ok = $settingsSynthese->update([
        'id_settings_synthese' => $input_data->id_settings_synthese,
        'introduction_medecin' => $input_data->introduction_medecin,
        'introduction_beneficiaire' => $input_data->introduction_beneficiaire,
        'remerciements_medecin' => $input_data->remerciements_medecin,
        'remerciements_beneficiaire' => $input_data->remerciements_beneficiaire,
    ]);

    if ($update_ok) {
        $item = $settingsSynthese->readOne($input_data->id_settings_synthese);
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($item);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $settingsSynthese->getErrorMessage(),
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