<?php

use Sportsante86\Sapa\Model\Creneau;
use Sportsante86\Sapa\Model\Seance;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

// get posted data
$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_creneau) &&
    !empty($input_data->nom_creneau) &&
    !empty($input_data->type_creneau) &&
    !empty($input_data->jour) &&
    !empty($input_data->heure_debut) &&
    !empty($input_data->heure_fin) &&
    !empty($input_data->id_structure) &&
    !empty($input_data->nom_adresse) &&
    !empty($input_data->code_postal) &&
    !empty($input_data->nom_ville) &&
    !empty($input_data->pathologie) &&
    !empty($input_data->type_seance) &&
    (is_array($input_data->intervenant_ids) && !empty($input_data->intervenant_ids)) &&
    ($input_data->activation == "0" || $input_data->activation == "1")) {
    $creneau = new Creneau($bdd);
    $update_ok = $creneau->update([
        'id_creneau' => $input_data->id_creneau,
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
        'activation' => $input_data->activation,

        'tarif' => $input_data->tarif,
        'paiement' => $input_data->paiement,
        'description' => $input_data->description,
        'nb_participant' => $input_data->nb_participant,
        'public_vise' => $input_data->public_vise,
        'complement_adresse' => $input_data->complement_adresse,
    ]);

    if (!$update_ok) {
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

    ////////////////////////////////////////////////////
    // on met aussi à jour les séances qui se passent après aujourd'hui
    ////////////////////////////////////////////////////
    $date = new DateTime();
    $today = $date->format(DATE_ATOM);

    $seance = new Seance($bdd);
    $update_seance_ok = $seance->updateSeancesAfter($today, $input_data->id_creneau);

    if (!$update_seance_ok) {
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $seance->getErrorMessage(),
                'data' => json_encode($input_data)
            ]
        );
    }

    if ($update_ok) {
        $item = $creneau->readOne($input_data->id_creneau);

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($item);
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