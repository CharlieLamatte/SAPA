<?php

use function Sportsante86\Sapa\Outils\age;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_evaluation)) {
    $id_evaluation = $input_data->id_evaluation;

    $evaluation = [];

    ////////////////////////////////////////////////////
    // Evaluation infos générales
    ////////////////////////////////////////////////////
    $query = 'SELECT
                evaluations.id_evaluation,
                evaluations.date_eval,
                type_eval,
                c.prenom_coordonnees,
                c.nom_coordonnees,
                c.mail_coordonnees,
                date_naissance,
                sexe
                FROM evaluations
                JOIN patients p on evaluations.id_patient = p.id_patient
                JOIN users u on evaluations.id_user = u.id_user
                JOIN coordonnees c on c.id_coordonnees = u.id_coordonnees
                JOIN type_eval on evaluations.id_type_eval = type_eval.id_type_eval
                WHERE evaluations.id_evaluation = :id_evaluation';
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_evaluation', $id_evaluation);

    $stmt->execute();
    $data = $stmt->fetch();

    $evaluation['id_evaluation'] = $data['id_evaluation'];
    $evaluation['date_eval'] = $data['date_eval'];
    $evaluation['type_eval'] = $data['type_eval'];
    $evaluation['age'] = age($data['date_naissance']);
    $evaluation['sexe'] = $data['sexe'];
    $evaluation['nom_evaluateur'] = $data['nom_coordonnees'];
    $evaluation['prenom_evaluateur'] = $data['prenom_coordonnees'];
    $evaluation['mail_evaluateur'] = $data['mail_coordonnees'];

    ////////////////////////////////////////////////////
    // Test physio
    ////////////////////////////////////////////////////
    $query = "SELECT
            e.id_evaluation,
            tp.IMC,
            tp.saturation_repos,
            tp.fc_repos,
            tp.borg_repos,
            tp.fc_max_mesuree,
            tp.fc_max_theo,
            tp.motif_test_physio,
            tp.poids,
            tp.taille,
            tp.tour_taille,
            m.nom_motif
            FROM evaluations e
            LEFT JOIN test_physio tp on e.id_evaluation = tp.id_evaluation
            LEFT JOIN motifs m on tp.motif_test_physio = m.id_motif
            WHERE e.id_evaluation = :id_evaluation";
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_evaluation', $id_evaluation);

    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        $evaluation['test_physio'] = array(
            'fait' => false,
            'motif' => 'Aucun'
        );
    } else {
        $data = $stmt->fetch();

        $evaluation['test_physio'] = array(
            'fait' => $data['motif_test_physio'] == null,
            'motif' => $data['nom_motif'],
            'IMC' => $data['IMC'],
            'saturation_repos' => $data['saturation_repos'],
            'fc_repos' => $data['fc_repos'],
            'borg_repos' => $data['borg_repos'],
            'fc_max_mesuree' => $data['fc_max_mesuree'],
            'fc_max_theo' => $data['fc_max_theo'],
            'poids' => $data['poids'],
            'taille' => $data['taille'],
            'tour_taille' => $data['tour_taille'],
        );
    }

    ////////////////////////////////////////////////////
    // Test Aptitudes Aérobie
    ////////////////////////////////////////////////////
    $query_eval_apt_aerobie = 'SELECT
                *
                FROM eval_apt_aerobie eaa 
                LEFT JOIN motifs on eaa.motif_apt_aerobie = motifs.id_motif
                WHERE eaa.id_evaluation = :id_evaluation';
    $stmt_eval_apt_aerobie = $bdd->prepare($query_eval_apt_aerobie);
    $stmt_eval_apt_aerobie->bindValue(':id_evaluation', $id_evaluation);
    $stmt_eval_apt_aerobie->execute();

    if ($stmt_eval_apt_aerobie->rowCount() == 0) {
        $evaluation['test_aptitude_aerobie'] = array(
            'fait' => false,
            'motif' => 'Aucun'
        );
    } else {
        $row_eval_apt_aerobie = $stmt_eval_apt_aerobie->fetch();
        $evaluation['test_aptitude_aerobie'] = array(
            'fait' => $row_eval_apt_aerobie['motif_apt_aerobie'] == null,
            'motif' => $row_eval_apt_aerobie['nom_motif'],
            'distance_parcourue' => $row_eval_apt_aerobie['distance_parcourue'],
            'fc1' => $row_eval_apt_aerobie['fc1'],
            'fc2' => $row_eval_apt_aerobie['fc2'],
            'fc3' => $row_eval_apt_aerobie['fc3'],
            'fc4' => $row_eval_apt_aerobie['fc4'],
            'fc5' => $row_eval_apt_aerobie['fc5'],
            'fc6' => $row_eval_apt_aerobie['fc6'],
            'fc7' => $row_eval_apt_aerobie['fc7'],
            'fc8' => $row_eval_apt_aerobie['fc8'],
            'fc9' => $row_eval_apt_aerobie['fc9'],
            'sat1' => $row_eval_apt_aerobie['sat1'],
            'sat2' => $row_eval_apt_aerobie['sat2'],
            'sat3' => $row_eval_apt_aerobie['sat3'],
            'sat4' => $row_eval_apt_aerobie['sat4'],
            'sat5' => $row_eval_apt_aerobie['sat5'],
            'sat6' => $row_eval_apt_aerobie['sat6'],
            'sat7' => $row_eval_apt_aerobie['sat7'],
            'sat8' => $row_eval_apt_aerobie['sat8'],
            'sat9' => $row_eval_apt_aerobie['sat9'],
            'borg1' => $row_eval_apt_aerobie['borg1'],
            'borg2' => $row_eval_apt_aerobie['borg2'],
            'borg3' => $row_eval_apt_aerobie['borg3'],
            'borg4' => $row_eval_apt_aerobie['borg4'],
            'borg5' => $row_eval_apt_aerobie['borg5'],
            'borg6' => $row_eval_apt_aerobie['borg6'],
            'borg7' => $row_eval_apt_aerobie['borg7'],
            'borg8' => $row_eval_apt_aerobie['borg8'],
            'borg9' => $row_eval_apt_aerobie['borg9'],
            'commentaires' => $row_eval_apt_aerobie['com_apt_aerobie']
        );
    }

    ////////////////////////////////////////////////////
    // Test up and go
    ////////////////////////////////////////////////////
    $query_eval_up_and_go = 'SELECT
                *
                FROM eval_up_and_go euag
                LEFT JOIN motifs on euag.id_motif = motifs.id_motif
                WHERE euag.id_evaluation = :id_evaluation';
    $stmt_eval_up_and_go = $bdd->prepare($query_eval_up_and_go);
    $stmt_eval_up_and_go->bindValue(':id_evaluation', $id_evaluation);
    $stmt_eval_up_and_go->execute();

    if ($stmt_eval_up_and_go->rowCount() == 0) {
        $evaluation['test_up_and_go'] = array(
            'fait' => false,
            'motif' => 'Aucun'
        );
    } else {
        $row_eval_up_and_go = $stmt_eval_up_and_go->fetch();
        $evaluation['test_up_and_go'] = array(
            'fait' => $row_eval_up_and_go['id_motif'] == null,
            'motif' => $row_eval_up_and_go['nom_motif'],
            'duree' => $row_eval_up_and_go['duree'],
            'commentaires' => $row_eval_up_and_go['commentaire']
        );
    }

    ////////////////////////////////////////////////////
    // Test Force musculaire membres supérieurs
    ////////////////////////////////////////////////////
    $query_eval_force_musc_mb_sup = 'SELECT
                *
                FROM eval_force_musc_mb_sup efmms
                LEFT JOIN motifs on efmms.motif_fmms = motifs.id_motif
                WHERE efmms.id_evaluation = :id_evaluation';
    $stmt_eval_force_musc_mb_sup = $bdd->prepare($query_eval_force_musc_mb_sup);
    $stmt_eval_force_musc_mb_sup->bindValue(':id_evaluation', $id_evaluation);
    $stmt_eval_force_musc_mb_sup->execute();

    if ($stmt_eval_force_musc_mb_sup->rowCount() == 0) {
        $evaluation['test_membre_sup'] = array(
            'fait' => false,
            'motif' => 'Aucun'
        );
    } else {
        $row_eval_force_musc_mb_sup = $stmt_eval_force_musc_mb_sup->fetch();
        $evaluation['test_membre_sup'] = array(
            'fait' => $row_eval_force_musc_mb_sup['motif_fmms'] == null,
            'motif' => $row_eval_force_musc_mb_sup['nom_motif'],
            'main_forte' => ucfirst($row_eval_force_musc_mb_sup['main_forte']),
            'mg' => $row_eval_force_musc_mb_sup['mg'],
            'md' => $row_eval_force_musc_mb_sup['md'],
            'commentaires' => $row_eval_force_musc_mb_sup['com_fmms']
        );
    }

    ////////////////////////////////////////////////////
    // Test Equilibre statique
    ////////////////////////////////////////////////////
    $query_eval_eq_stat = 'SELECT
                *
                FROM eval_eq_stat ees
                LEFT JOIN motifs on ees.motif_eq_stat = motifs.id_motif
                WHERE ees.id_evaluation = :id_evaluation';
    $stmt_eval_eq_stat = $bdd->prepare($query_eval_eq_stat);
    $stmt_eval_eq_stat->bindValue(':id_evaluation', $id_evaluation);
    $stmt_eval_eq_stat->execute();

    if ($stmt_eval_eq_stat->rowCount() == 0) {
        $evaluation['test_equilibre'] = array(
            'fait' => false,
            'motif' => 'Aucun'
        );
    } else {
        $row_eval_eq_stat = $stmt_eval_eq_stat->fetch();
        $evaluation['test_equilibre'] = array(
            'fait' => $row_eval_eq_stat['motif_eq_stat'] == null,
            'motif' => $row_eval_eq_stat['nom_motif'],
            'pied_gauche_sol' => $row_eval_eq_stat['pied_gauche_sol'],
            'pied_droit_sol' => $row_eval_eq_stat['pied_droit_sol'],
            'pied_dominant' => ucfirst($row_eval_eq_stat['pied_dominant']),
            'commentaires' => $row_eval_eq_stat['com_eq_stat']
        );
    }

    ////////////////////////////////////////////////////
    // Test Souplesse
    ////////////////////////////////////////////////////
    $query_eval_soupl = 'SELECT
                *
                FROM eval_soupl es
                LEFT JOIN motifs on es.motif_soupl = motifs.id_motif
                WHERE es.id_evaluation = :id_evaluation';
    $stmt_eval_soupl = $bdd->prepare($query_eval_soupl);
    $stmt_eval_soupl->bindValue(':id_evaluation', $id_evaluation);
    $stmt_eval_soupl->execute();

    if ($stmt_eval_soupl->rowCount() == 0) {
        $evaluation['test_souplesse'] = array(
            'fait' => false,
            'motif' => 'Aucun'
        );
    } else {
        $row_eval_soupl = $stmt_eval_soupl->fetch();
        $evaluation['test_souplesse'] = array(
            'fait' => $row_eval_soupl['motif_soupl'] == null,
            'motif' => $row_eval_soupl['nom_motif'],
            'distance' => $row_eval_soupl['distance'],
            'commentaires' => $row_eval_soupl['com_soupl']
        );
    }

    ////////////////////////////////////////////////////
    // Test Mobilité scapulo-humérale
    ////////////////////////////////////////////////////
    $query_eval_mobilite_scapulo_humerale = 'SELECT
                *
                FROM eval_mobilite_scapulo_humerale emsh
                LEFT JOIN motifs on emsh.motif_mobilite_scapulo_humerale = motifs.id_motif
                WHERE emsh.id_evaluation = :id_evaluation';
    $stmt_eval_mobilite_scapulo_humerale = $bdd->prepare($query_eval_mobilite_scapulo_humerale);
    $stmt_eval_mobilite_scapulo_humerale->bindValue(':id_evaluation', $id_evaluation);
    $stmt_eval_mobilite_scapulo_humerale->execute();

    if ($stmt_eval_mobilite_scapulo_humerale->rowCount() == 0) {
        $evaluation['test_mobilite'] = array(
            'fait' => false,
            'motif' => 'Aucun'
        );
    } else {
        $row_eval_mobilite_scapulo_humerale = $stmt_eval_mobilite_scapulo_humerale->fetch();
        $evaluation['test_mobilite'] = array(
            'fait' => $row_eval_mobilite_scapulo_humerale['motif_mobilite_scapulo_humerale'] == null,
            'motif' => $row_eval_mobilite_scapulo_humerale['nom_motif'],
            'main_gauche_haut' => $row_eval_mobilite_scapulo_humerale['main_gauche_haut'],
            'main_droite_haut' => $row_eval_mobilite_scapulo_humerale['main_droite_haut'],
            'commentaires' => $row_eval_mobilite_scapulo_humerale['com_mobilite_scapulo_humerale']
        );
    }

    ////////////////////////////////////////////////////
    // Test Endurance musculaire membres inférieurs
    ////////////////////////////////////////////////////
    $query_eval_endurance_musc_mb_inf = 'SELECT
                *
                FROM eval_endurance_musc_mb_inf eemmi 
                LEFT JOIN motifs on eemmi.motif_end_musc_mb_inf = motifs.id_motif
                WHERE eemmi.id_evaluation = :id_evaluation';
    $stmt_eval_endurance_musc_mb_inf = $bdd->prepare($query_eval_endurance_musc_mb_inf);
    $stmt_eval_endurance_musc_mb_inf->bindValue(':id_evaluation', $id_evaluation);
    $stmt_eval_endurance_musc_mb_inf->execute();

    if ($stmt_eval_endurance_musc_mb_inf->rowCount() == 0) {
        $evaluation['test_membre_inf'] = array(
            'fait' => false,
            'motif' => 'Aucun'
        );
    } else {
        $row_eval_endurance_musc_mb_inf = $stmt_eval_endurance_musc_mb_inf->fetch();
        $evaluation['test_membre_inf'] = array(
            'fait' => $row_eval_endurance_musc_mb_inf['motif_end_musc_mb_inf'] == null,
            'motif' => $row_eval_endurance_musc_mb_inf['nom_motif'],
            'nb_lever' => $row_eval_endurance_musc_mb_inf['nb_lever'],
            'fc30' => $row_eval_endurance_musc_mb_inf['fc30'],
            'sat30' => $row_eval_endurance_musc_mb_inf['sat30'],
            'borg30' => $row_eval_endurance_musc_mb_inf['borg30'],
            'commentaires' => $row_eval_endurance_musc_mb_inf['com_end_musc_mb_inf']
        );
    }

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($evaluation);
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