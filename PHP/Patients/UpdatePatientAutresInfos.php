<?php
/**
 * Modification des autres informations d'un patient
 */

use Sportsante86\Sapa\Model\JournalAcces;
use Sportsante86\Sapa\Model\Patient;

require '../../bootstrap/bootstrap.php';

$p = new Patient($bdd);
$update_ok = $p->updateAutresInformations([
    'id_patient' => $_POST['id_patient'],
    'est_non_peps' => $_POST["est-non-peps"],
    'est_pris_en_charge' => $_POST["est-pris-en-charge"],
    'hauteur_prise_en_charge' => $_POST["hauteur-prise-en-charge"],
    'sit_part_prevention_chute' => $_POST['sit_part_prevention_chute'],
    'sit_part_education_therapeutique' => $_POST['sit_part_education_therapeutique'],
    'sit_part_grossesse' => $_POST['sit_part_grossesse'],
    'sit_part_sedentarite' => $_POST['sit_part_sedentarite'],
    'sit_part_autre' => $_POST['sit_part_autre'],
    'qpv' => $_POST['qpv'],
    'zrr' => $_POST['zrr'],
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
    \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to update a patient',
        [
            'error_message' => $p->getErrorMessage(),
            'data' => $_POST,
            'session' => $_SESSION,
        ]
    );
    // TODO afficher un message d'erreur
    header("Location: ../Patients/AccueilPatient.php?idPatient=" . $_POST['id_patient']);
}