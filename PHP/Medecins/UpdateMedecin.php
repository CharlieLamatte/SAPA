<?php

use Sportsante86\Sapa\Model\Medecin;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_medecin) &&
    !empty($input_data->nom_coordonnees) &&
    !empty($input_data->prenom_coordonnees) &&
    !empty($input_data->tel_fixe_coordonnees) &&
    !empty($input_data->id_territoire) &&
    !empty($input_data->poste_medecin) &&
    !empty($input_data->id_specialite_medecin) &&
    !empty($input_data->id_lieu_pratique) &&
    !empty($input_data->nom_adresse) &&
    !empty($input_data->code_postal) &&
    !empty($input_data->nom_ville)) {
    $medecin = new Medecin($bdd);
    $update_ok = $medecin->update([
        'id_medecin' => $input_data->id_medecin,
        'nom_coordonnees' => $input_data->nom_coordonnees,
        'prenom_coordonnees' => $input_data->prenom_coordonnees,
        'poste_medecin' => $input_data->poste_medecin,
        'id_specialite_medecin' => $input_data->id_specialite_medecin,
        'id_lieu_pratique' => $input_data->id_lieu_pratique,
        'nom_adresse' => $input_data->nom_adresse,
        'code_postal' => $input_data->code_postal,
        'nom_ville' => $input_data->nom_ville,
        'id_territoire' => $input_data->id_territoire,
        'tel_fixe_coordonnees' => $input_data->tel_fixe_coordonnees,

        'complement_adresse' => $input_data->complement_adresse,
        'mail_coordonnees' => $input_data->mail_coordonnees,
        'tel_portable_coordonnees' => $input_data->tel_portable_coordonnees,
    ]);

    if ($update_ok) {
        $item = $medecin->readOne($input_data->id_medecin);
        // set response code - 20O OK
        http_response_code(200);
        echo json_encode($item);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $medecin->getErrorMessage(),
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