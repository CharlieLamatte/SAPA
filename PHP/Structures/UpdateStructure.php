<?php

use Sportsante86\Sapa\Model\Structure;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

// get posted data
$input_data = json_decode(file_get_contents("php://input"), true);

if (!empty($input_data['nom_structure']) &&
    !empty($input_data['id_structure']) &&
    !empty($input_data['id_statut_structure']) &&
    !empty($input_data['nom_adresse']) &&
    !empty($input_data['code_postal']) &&
    !empty($input_data['nom_ville']) &&
    !empty($input_data['id_statut_juridique'])) {

    $structure = new Structure($bdd);
    $update_ok = $structure->update([
        'id_structure' => $input_data['id_structure'],
        'nom_structure' => $input_data['nom_structure'],
        'id_statut_structure' => $input_data['id_statut_structure'],
        'nom_adresse' => $input_data['nom_adresse'],
        'code_postal' => $input_data['code_postal'],
        'nom_ville' => $input_data['nom_ville'],
        'id_statut_juridique' => $input_data['id_statut_juridique'],

        'complement_adresse' => $input_data['complement_adresse'],
        'id_territoire' => $input_data['id_territoire'],
        'intervenants' => $input_data['intervenants'],
        'antennes' => $input_data['antennes'],
        'lien_ref_structure' => $input_data['lien_ref_structure'],
        'code_onaps' => $input_data['code_onaps'],

        'nom_representant' => $input_data['nom_representant'],
        'prenom_representant' => $input_data['prenom_representant'],
        'email' => $input_data['email'],
        'tel_fixe' => $input_data['tel_fixe'],
        'tel_portable' => $input_data['tel_portable'],
    ]);

    if (!$update_ok) {
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

        die();
    }

    $save_ok = $structure->saveLogo([
        'id_statut_structure' => $input_data['id_statut_structure'],
        'id_structure' => $input_data['id_structure'],
        'logo_est_present' => $input_data['logo']['est_present'] ?? false,
        'logo_data' => $input_data['logo']['data'] ?? null,
    ]);

    if ($save_ok) {
        $item = $structure->readOne($input_data['id_structure']);
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