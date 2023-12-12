<?php

use Sportsante86\Sapa\Model\Intervenant;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';
require '../../GestionErreurs/object/GestionErreurs.php';

// get posted data
$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->nom_intervenant) &&
    !empty($input_data->prenom_intervenant) &&
    !empty($input_data->id_statut_intervenant) &&
    !empty($input_data->id_territoire)) {
    $intervenant = new Intervenant($bdd);
    $id_intervenant = $intervenant->create([
        'nom_intervenant' => $input_data->nom_intervenant,
        'prenom_intervenant' => $input_data->prenom_intervenant,
        'id_statut_intervenant' => $input_data->id_statut_intervenant,
        'id_territoire' => $input_data->id_territoire,
        'mail_intervenant' => $input_data->mail_intervenant,
        'tel_portable_intervenant' => $input_data->tel_portable_intervenant,
        'tel_fixe_intervenant' => $input_data->tel_fixe_intervenant,
        'numero_carte' => $input_data->numero_carte,
        'structures' => $input_data->structures,
        'diplomes' => $input_data->diplomes,

        'id_api' => $input_data->id_api ?? null,
        'id_api_structure' => $input_data->id_api_structure ?? null,
    ]);

    if ($id_intervenant != false) {
        $item = $intervenant->readOne($id_intervenant);

        // set response code - 201 created
        http_response_code(201);
        echo json_encode($item);
    } else {
        $error_message = $intervenant->getErrorMessage();

        if ($error_message != 'Error: element déja importé') {
            $gestionErreur = new GestionErreurs($bdd);
            $gestionErreur->id_api = empty($input_data->id_api) ? '' : $input_data->id_api;
            $gestionErreur->nom_element = $input_data->nom_intervenant . ' ' . $input_data->prenom_intervenant;
            $gestionErreur->type_element = 'intervenant';
            $gestionErreur->data = json_encode($input_data);
            $gestionErreur->description = $error_message;
            $gestionErreur->date = date('Y-m-d H:i:s');
            $gestionErreur->create();
        }

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