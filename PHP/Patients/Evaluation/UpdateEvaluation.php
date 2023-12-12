<?php
/**
 * Update d'une évaluation
 */

use Sportsante86\Sapa\Model\Evaluation;

require '../../../bootstrap/bootstrap.php';

force_connected();

$evaluation = new Evaluation($bdd);
$id_evaluation = $evaluation->update([
    'id_evaluation' => $_GET['id_eval'],
    'date_eval' => $_POST['date_eval'],
    'id_type_eval' => $_POST['eval_etat'],

    // test physio
    'auto0' => $_POST['auto0'],
    'poids' => $_POST['poids'],
    'taille' => $_POST['taille'],
    'IMC' => $_POST['IMC'],
    'tour_taille' => $_POST['tour_taille'],
    'fcrepos' => $_POST['fcrepos'],
    'satrepos' => $_POST['satrepos'],
    'borgrepos' => $_POST['borgrepos'],
    'fcmax' => $_POST['fcmax'],
    'motif_test_physio' => $_POST['id_motif_test_physio'],

    // test Aptitude aerobie
    'auto1' => $_POST['auto1'],
    'dp' => $_POST['dp'],
    'fc1' => $_POST['fc1'],
    'fc2' => $_POST['fc2'],
    'fc3' => $_POST['fc3'],
    'fc4' => $_POST['fc4'],
    'fc5' => $_POST['fc5'],
    'fc6' => $_POST['fc6'],
    'fc7' => $_POST['fc7'],
    'fc8' => $_POST['fc8'],
    'fc9' => $_POST['fc9'],
    'sat1' => $_POST['sat1'],
    'sat2' => $_POST['sat2'],
    'sat3' => $_POST['sat3'],
    'sat4' => $_POST['sat4'],
    'sat5' => $_POST['sat5'],
    'sat6' => $_POST['sat6'],
    'sat7' => $_POST['sat7'],
    'sat8' => $_POST['sat8'],
    'sat9' => $_POST['sat9'],
    'borg1' => $_POST['borg1'],
    'borg2' => $_POST['borg2'],
    'borg3' => $_POST['borg3'],
    'borg4' => $_POST['borg4'],
    'borg5' => $_POST['borg5'],
    'borg6' => $_POST['borg6'],
    'borg7' => $_POST['borg7'],
    'borg8' => $_POST['borg8'],
    'borg9' => $_POST['borg9'],
    'com_aa' => $_POST['com_aa'],
    'motif_apt_aerobie' => $_POST['id_motif_apt_aerobie'],

    // test up and go
    'auto-up-and-go' => $_POST['auto-up-and-go'],
    'com-up-and-go' => $_POST['com-up-and-go'],
    'duree-up-and-go' => $_POST['duree-up-and-go'],
    'motif-up-and-go' => $_POST['motif-up-and-go'],

    // test Force musculaire membres supérieurs
    'auto2' => $_POST['auto2'],
    'com_fmms' => $_POST['com_fmms'],
    'main_forte' => $_POST['main_forte'],
    'mg' => $_POST['mg'],
    'md' => $_POST['md'],
    'motif_fmms' => $_POST['id_motif_fmms'],

    // test Equilibre statique
    'auto3' => $_POST['auto3'],
    'com_eq' => $_POST['com_eq'],
    'pied-dominant' => $_POST['pied-dominant'],
    'pg' => $_POST['pg'],
    'pd' => $_POST['pd'],
    'motif_eq_stat' => $_POST['id_motif_eq_stat'],

    // test Souplesse
    'auto4' => $_POST['auto4'],
    'com_soupl' => $_POST['com_soupl'],
    //'membre' => "Majeur au sol",
    'distance' => $_POST['distance'],
    'motif_soupl' => $_POST['id_motif_soupl'],

    // test Mobilité Scapulo-Humérale
    'auto5' => $_POST['auto5'],
    'com_msh' => $_POST['com_msh'],
    'mgh' => $_POST['mgh'],
    'mdh' => $_POST['mdh'],
    'motif_mobilite_scapulo_humerale' => $_POST['id_motif_msh'],

    // test Endurance musculaire membres inférieurs
    'auto6' => $_POST['auto6'],
    'com_emmi' => $_POST['com_emmi'],
    'nb_lever' => $_POST['nb_lever'],
    'fc30' => $_POST['fc30'],
    'sat30' => $_POST['sat30'],
    'borg30' => $_POST['borg30'],
    'motif_end_musc_mb_inf' => $_POST['id_motif_end_musc_mb_inf']
]);

if ($id_evaluation) {
    header("Location: ../Evaluation.php?idPatient=" . $_GET['idPatient']);
} else {
    \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to update an evaluation',
        [
            'error_message' => $evaluation->getErrorMessage(),
            'data' => $_POST,
            'session' => $_SESSION,
        ]
    );
    // TODO afficher un message d'erreur
    header("Location: ../Evaluation.php?idPatient=" . $_GET['idPatient']);
}