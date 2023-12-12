<?php

use Sportsante86\Sapa\Model\ActivitePhysique;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

// get posted data
$input_data = json_decode(file_get_contents("php://input"), true);

if (isset(
    $input_data['id_user'],
    $input_data['id_patient'],
    $input_data['activite_physique_autonome'],
    $input_data['activite_physique_encadree'],
    $input_data['activite_anterieure'],
    $input_data['disponibilite'],
    $input_data['frein_activite'],
    $input_data['activite_envisagee'],
    $input_data['point_fort_levier'],
    $input_data['a_activite_anterieure'],
    $input_data['a_activite_autonome'],
    $input_data['a_activite_encadree'],
    $input_data['a_activite_envisagee'],
    $input_data['a_activite_frein'],
    $input_data['a_activite_point_fort_levier'],
    $input_data['est_dispo_lundi'],
    $input_data['est_dispo_mardi'],
    $input_data['est_dispo_mercredi'],
    $input_data['est_dispo_jeudi'],
    $input_data['est_dispo_vendredi'],
    $input_data['est_dispo_samedi'],
    $input_data['est_dispo_dimanche'],
)) {
    $activitePhysique = new ActivitePhysique($bdd);
    $id_activite_physique = $activitePhysique->create([
        'id_user' => $input_data['id_user'],
        'id_patient' => $input_data['id_patient'],

        'a_activite_anterieure' => $input_data['a_activite_anterieure'],
        'a_activite_autonome' => $input_data['a_activite_autonome'],
        'a_activite_encadree' => $input_data['a_activite_encadree'],
        'a_activite_envisagee' => $input_data['a_activite_envisagee'],
        'a_activite_frein' => $input_data['a_activite_frein'],
        'a_activite_point_fort_levier' => $input_data['a_activite_point_fort_levier'],

        'activite_physique_autonome' => $input_data['activite_physique_autonome'],
        'activite_physique_encadree' => $input_data['activite_physique_encadree'],
        'activite_anterieure' => $input_data['activite_anterieure'],
        'disponibilite' => $input_data['disponibilite'],
        'frein_activite' => $input_data['frein_activite'],
        'activite_envisagee' => $input_data['activite_envisagee'],
        'point_fort_levier' => $input_data['point_fort_levier'],

        'est_dispo_lundi' => $input_data['est_dispo_lundi'],
        'est_dispo_mardi' => $input_data['est_dispo_mardi'],
        'est_dispo_mercredi' => $input_data['est_dispo_mercredi'],
        'est_dispo_jeudi' => $input_data['est_dispo_jeudi'],
        'est_dispo_vendredi' => $input_data['est_dispo_vendredi'],
        'est_dispo_samedi' => $input_data['est_dispo_samedi'],
        'est_dispo_dimanche' => $input_data['est_dispo_dimanche'],

        'heure_debut_lundi' => $input_data['heure_debut_lundi'],
        'heure_debut_mardi' => $input_data['heure_debut_mardi'],
        'heure_debut_mercredi' => $input_data['heure_debut_mercredi'],
        'heure_debut_jeudi' => $input_data['heure_debut_jeudi'],
        'heure_debut_vendredi' => $input_data['heure_debut_vendredi'],
        'heure_debut_samedi' => $input_data['heure_debut_samedi'],
        'heure_debut_dimanche' => $input_data['heure_debut_dimanche'],

        'heure_fin_lundi' => $input_data['heure_fin_lundi'],
        'heure_fin_mardi' => $input_data['heure_fin_mardi'],
        'heure_fin_mercredi' => $input_data['heure_fin_mercredi'],
        'heure_fin_jeudi' => $input_data['heure_fin_jeudi'],
        'heure_fin_vendredi' => $input_data['heure_fin_vendredi'],
        'heure_fin_samedi' => $input_data['heure_fin_samedi'],
        'heure_fin_dimanche' => $input_data['heure_fin_dimanche'],
    ]);

    if ($id_activite_physique) {
        $item = $activitePhysique->readOne($id_activite_physique);

        // set response code - 201 Created
        http_response_code(201);
        echo json_encode($item);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $activitePhysique->getErrorMessage(),
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