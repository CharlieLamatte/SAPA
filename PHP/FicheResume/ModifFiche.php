<?php
/**
 * Modification des coordonnées d'un patient
 */

use Sportsante86\Sapa\Model\JournalAcces;
use Sportsante86\Sapa\Model\Patient;

require '../../bootstrap/bootstrap.php';

force_connected();

$patient = new Patient($bdd);
$update_ok = $patient->updateCoordonnees([
    'id_patient' => $_POST['id_patient'],
    'nom_naissance' => $_POST['nom-patient'],
    'premier_prenom_naissance' => $_POST['prenom-patient'],
    'sexe_patient' => $_POST['sexe'],
    'date_naissance' => $_POST['dn'],
    'adresse_patient' => $_POST['adresse-patient'],
    'complement_adresse_patient' => $_POST['complement-adresse-patient'],
    'code_postal_patient' => $_POST['code-postal-patient'],
    'ville_patient' => $_POST['ville-patient'],
    'tel_fixe_patient' => $_POST['tel_f'],
    'tel_portable_patient' => $_POST['tel_p'],
    'email_patient' => $_POST['email-patient'],

    'nom_urgence' => $_POST['nom_urgence'],
    'prenom_urgence' => $_POST['prenom_urgence'],
    'id_lien' => $_POST['id_lien'],
    'tel_portable_urgence' => $_POST['tel_urgence_p'],
    'tel_fixe_urgence' => $_POST['tel_urgence_f'],

    'code_insee_naissance' => $_POST['code_insee_naissance'],
    'nom_utilise' => $_POST['nom_utilise'],
    'prenom_utilise' => $_POST['prenom_utilise'],
    'liste_prenom_naissance' => $_POST['liste_prenom_naissance'],
]);

if ($update_ok) {
    // enregistrement de la modification d'un patient
    $journal = new JournalAcces($bdd);
    $journal->create([
        'nom_acteur' => $_SESSION['nom_connecte'] . " " . $_SESSION['prenom_connecte'],
        'type_action' => "modify",
        'type_cible' => "patient",
        'nom_cible' => $_POST['nom'] . " " . $_POST["prenom"],
        'id_user_acteur' => $_SESSION['id_user'],
        'id_cible' => $_POST['id_patient']
    ]);

    header("Location: ../Patients/AccueilPatient.php?idPatient=" . $_POST['id_patient']);
} else {
    // TODO afficher un message d'erreur
    \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
        [
            'error_message' => $patient->getErrorMessage(),
            'data' => $_POST,
            'session' => $_SESSION,
        ]
    );
    header("Location: ../Patients/AccueilPatient.php?idPatient=" . $_POST['id_patient']);
}