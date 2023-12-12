<?php

use Sportsante86\Sapa\Model\Intervenant;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

// get posted data
$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_intervenant) &&
    !empty($input_data->nom_intervenant) &&
    !empty($input_data->prenom_intervenant) &&
    !empty($input_data->id_statut_intervenant) &&
    !empty($input_data->id_territoire)) {
    $intervenant = new Intervenant($bdd);

    $success = $intervenant->update([
        'id_intervenant' => $input_data->id_intervenant,
        'nom_intervenant' => $input_data->nom_intervenant,
        'prenom_intervenant' => $input_data->prenom_intervenant,
        'id_statut_intervenant' => $input_data->id_statut_intervenant,
        'id_territoire' => $input_data->id_territoire,
        'mail_intervenant' => $input_data->mail_intervenant,
        'tel_portable_intervenant' => $input_data->tel_portable_intervenant,
        'tel_fixe_intervenant' => $input_data->tel_fixe_intervenant,
        'numero_carte' => $input_data->numero_carte,
        'diplomes' => $input_data->diplomes,
        'structures' => $input_data->structures
    ]);

    if ($success) {
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(["message" => "Intervenant was updated."]);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $intervenant->getErrorMessage(),
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