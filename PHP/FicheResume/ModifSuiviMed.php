<?php
/**
 * Modification du suivi médical d'un patient
 */

use Sportsante86\Sapa\Model\JournalAcces;
use Sportsante86\Sapa\Model\Patient;

require '../../bootstrap/bootstrap.php';

force_connected();

$p = new Patient($bdd);
$update_ok = $p->updateSuiviMedical([
    'id_patient' => $_POST['id_patient'],
    'id_med' => $_POST['id_med'],
    'id_med_traitant' => $_POST['id_med_traitant'],
    'id_autre' => $_POST['id_autre'],
    'id_mutuelle' => $_POST['id_mutuelle'],
    'id_caisse_assurance_maladie' => $_POST['id_caisse_assurance_maladie'],
    'code_postal_assurance_maladie' => $_POST['cp_cpam'],
    'ville_cpam' => $_POST['ville_cpam'],
]);

if ($update_ok) {
    // enregistrement de la modification d'un patient
    $patient = $p->readOne($_POST['id_patient']);
    $journal = new JournalAcces($bdd);
    $journal->create([
        'nom_acteur' => $_SESSION['nom_connecte'] . " " . $_SESSION['prenom_connecte'],
        'type_action' => "modify",
        'type_cible' => "patient",
        'nom_cible' => $patient["nom_naissance"] . " " . $patient["premier_prenom_naissance"],
        'id_user_acteur' => $_SESSION['id_user'],
        'id_cible' => $_POST['id_patient']
    ]);

    header("Location: ../Patients/AccueilPatient.php?idPatient=" . $_POST['id_patient']);
} else {
    // TODO afficher un message d'erreur
    \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
        [
            'error_message' => $p->getErrorMessage(),
            'data' => $_POST,
            'session' => $_SESSION,
        ]
    );
    header("Location: ../Patients/AccueilPatient.php?idPatient=" . $_POST['id_patient']);
}