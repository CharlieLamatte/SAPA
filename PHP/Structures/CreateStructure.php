<?php

use Sportsante86\Sapa\Model\Structure;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';
require '../../GestionErreurs/object/GestionErreurs.php';

$input_data = json_decode(file_get_contents("php://input"), true);

if (!empty($input_data['nom_structure']) &&
    !empty($input_data['id_statut_structure']) &&
    !empty($input_data['nom_adresse']) &&
    !empty($input_data['code_postal']) &&
    !empty($input_data['nom_ville']) &&
    !empty($input_data['id_statut_juridique'])) {
    $structure = new Structure($bdd);
    $id_structure = $structure->create([
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

        'id_api' => $input_data['id_api'] ?? null,
    ]);

    if (!$id_structure) {
        $error_message = $structure->getErrorMessage();

        if ($error_message != 'Error: element déja importé') {
            $gestionErreur = new GestionErreurs($bdd);
            $gestionErreur->id_api = empty($input_data['id_api']) ? '' : $input_data['id_api'];
            $gestionErreur->nom_element = $input_data['nom_structure'];
            $gestionErreur->type_element = 'structure';
            $gestionErreur->data = json_encode($input_data);
            $gestionErreur->description = $error_message;
            $gestionErreur->date = date('Y-m-d H:i:s');

            $gestionErreur->create();
        }

        // set response code - 400 bad request
        http_response_code(400);
        echo json_encode(["message" => $error_message]);
        die();
    }

    $save_ok = $structure->saveLogo([
        'id_statut_structure' => $input_data['id_statut_structure'],
        'id_structure' => $id_structure,
        'logo_est_present' => $input_data['logo']['est_present'] ?? false,
        'logo_data' => $input_data['logo']['data'] ?? null,
    ]);

    if ($save_ok) {
        $item = $structure->readOne($id_structure);

        // set response code - 201 created
        http_response_code(201);
        echo json_encode($item);
    } else {
        $error_message = $structure->getErrorMessage();

        if ($error_message != 'Error: element déja importé') {
            $gestionErreur = new GestionErreurs($bdd);
            $gestionErreur->id_api = empty($input_data['id_api']) ? '' : $input_data['id_api'];
            $gestionErreur->nom_element = $input_data['nom_structure'];
            $gestionErreur->type_element = 'structure';
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