<?php

use Sportsante86\Sapa\Model\Creneau;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';
require '../../GestionErreurs/object/GestionErreurs.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->nom_creneau) &&
    !empty($input_data->type_creneau) &&
    !empty($input_data->jour) &&
    !empty($input_data->heure_debut) &&
    !empty($input_data->heure_fin) &&
    (!empty($input_data->id_structure) || !empty($input_data->id_api_structure)) &&
    !empty($input_data->code_postal) &&
    !empty($input_data->nom_ville) &&
    !empty($input_data->pathologie) &&
    !empty($input_data->type_seance) &&
    ((is_array($input_data->intervenant_ids) && !empty($input_data->intervenant_ids)) || !empty($input_data->id_api_intervenant))
) {
    $creneau = new Creneau($bdd);
    $id_creneau = $creneau->create([
        'nom_creneau' => $input_data->nom_creneau,
        'code_postal' => $input_data->code_postal,
        'nom_ville' => $input_data->nom_ville,
        'nom_adresse' => $input_data->nom_adresse,
        'jour' => $input_data->jour,
        'heure_debut' => $input_data->heure_debut,
        'heure_fin' => $input_data->heure_fin,
        'type_creneau' => $input_data->type_creneau,
        'id_structure' => $input_data->id_structure,
        'intervenant_ids' => $input_data->intervenant_ids,
        'pathologie' => $input_data->pathologie,
        'type_seance' => $input_data->type_seance,
        'tarif' => $input_data->tarif,
        'paiement' => $input_data->paiement,
        'description' => $input_data->description,
        'nb_participant' => $input_data->nb_participant,
        'public_vise' => $input_data->public_vise,
        'complement_adresse' => $input_data->complement_adresse,

        'id_api' => $input_data->id_api ?? null,
        'id_api_intervenant' => $input_data->id_api_intervenant ?? null,
        'id_api_structure' => $input_data->id_api_structure ?? null,
    ]);

    if ($id_creneau) {
        $item = $creneau->readOne($id_creneau);

        // set response code - 201 created
        http_response_code(201);
        echo json_encode($item);
    } else {
        $error_message = $creneau->getErrorMessage();

        if ($error_message != 'Error: element déja importé') {
            $gestionErreur = new GestionErreurs($bdd);
            $gestionErreur->id_api = empty($input_data->id_api) ? '' : $input_data->id_api;
            $gestionErreur->nom_element = $input_data->nom_creneau;
            $gestionErreur->type_element = 'créneau';
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
                'error_message' => $creneau->getErrorMessage(),
                'data' => json_encode($input_data)
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