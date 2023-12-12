<?php
/**
 * Création d'un patient
 */

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\PatientChangedNotifier;
use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Model\SuiviDossier;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$patient = new Patient($bdd);

$est_non_peps = $_POST["est-non-peps"] ?? 'NON';
if ($_POST['date_eval_suiv'] == "") {
    $_POST['date_eval_suiv'] = null;
}
$id_patient = $patient->create(new Permissions($_SESSION), [
    'date_admission' => $_POST['da'],
    'nature_entretien' => $_POST['nature_e'],
    'nom_naissance' => $_POST['nom-patient'],
    'premier_prenom_naissance' => $_POST["prenom-patient"],
    'sexe_patient' => $_POST['sexe'],
    'date_naissance' => $_POST['dn'],
    'adresse_patient' => $_POST["adresse-patient"],
    'complement_adresse_patient' => $_POST['complement-adresse-patient'],
    'code_postal_patient' => $_POST['code-postal-patient'],
    'ville_patient' => $_POST["ville-patient"],
    'tel_fixe_patient' => $_POST['tel_f'],
    'tel_portable_patient' => $_POST['tel_p'],
    'email_patient' => $_POST['email-patient'],
    'regime_assurance_maladie' => $_POST['TypeRegime'],
    'ville_assurance_maladie' => $_POST['ville_cpam'],
    'code_postal_assurance_maladie' => $_POST['cp_cpam'],
    'id_structure' => $_SESSION['id_structure'],
    'id_user' => $_SESSION['id_user'],
    'id_territoire' => $_POST['id_territoire'],
    'est_non_peps' => $est_non_peps,
    'est_pris_en_charge' => $_POST["est-pris-en-charge"] ?? 'NON',
    'hauteur_prise_en_charge' => $_POST["hauteur-prise-en-charge"],
    'sit_part_prevention_chute' => $_POST['sit_part_prevention_chute'] ?? 'NON',
    'sit_part_education_therapeutique' => $_POST['sit_part_education_therapeutique'] ?? 'NON',
    'sit_part_grossesse' => $_POST['sit_part_grossesse'] ?? 'NON',
    'sit_part_sedentarite' => $_POST['sit_part_sedentarite'] ?? 'NON',
    'sit_part_autre' => $_POST['sit_part_autre'],
    'qpv' => $_POST['qpv'] ?? 'NON',
    'zrr' => $_POST['zrr'] ?? 'NON',
    'id_mutuelle' => $_POST['id_mutuelle'],
    'intervalle' => $_POST['intervalle'],
    'date_eval_suiv' => $_POST['date_eval_suiv'],
    'id_medecin' => $_POST['id_med'],
    'meme_med' => $_POST['meme_med'],
    'id_med_traitant' => $_POST['id_med_traitant'],
    'id_autre' => $_POST['id_autre'],
    'nom_urgence' => $_POST['nom_urgence'],
    'prenom_urgence' => $_POST['prenom_urgence'],
    'id_lien' => $_POST['id_lien'],
    'tel_portable_urgence' => $_POST['tel_urgence_p'],
    'tel_fixe_urgence' => $_POST['tel_urgence_f'],

    //'code_insee_naissance' => $_POST['code_insee_naissance'],
    'nom_utilise' => $_POST['nom_utilise'],
    'prenom_utilise' => $_POST['prenom_utilise'],
    'liste_prenom_naissance' => $_POST['liste_prenom_naissance'],
]);

if ($id_patient) {
    // date de début du programme est par défaut la date du jour
    $today = date("Y-m-d");
    $update_ok = $patient->updateParcours([
        'id_patient' => $id_patient,
        'date_debut_programme' => $today,
    ]);
    if (!$update_ok) {
        \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to set patient date_debut_programme',
            [
                'error_message' => $patient->getErrorMessage(),
                'data' => [
                    'id_patient' => $id_patient,
                    'date_debut_programme' => $today,
                ],
                'session' => $_SESSION,
            ]
        );
    }

    if($_POST['suivi']){
        $suivi = new SuiviDossier($bdd);
        $status_suivi = $suivi->createSuiviDossier($_SESSION['id_user'],$id_patient);
        if(!$status_suivi){
            \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
                'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to follow this dossier',
                [
                    'data' => [
                        'id_patient' => $id_patient,
                    ],
                    'session' => $_SESSION,
                ]
            );
        }
    }

    $eventManager = new EventManager();
    $patientChangedNotifier = new PatientChangedNotifier($eventManager);

    $eventArgs = new BasicEventArgs($_SESSION, $bdd);
    $eventArgs->setArgs([
        'id_patient' => $id_patient,
        'est_non_peps' => $est_non_peps,
    ]);
    $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

    // variable qui serra utilisée pour déterminer si le patient vient d'être créé
    $_SESSION['new_id_patient=' . $id_patient] = true;

    header("Location: ../Patients/AccueilPatient.php?idPatient=" . $id_patient);
} else {
    \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to create a patient',
        [
            'error_message' => $patient->getErrorMessage(),
            'data' => $_POST,
            'session' => $_SESSION,
        ]
    );
    // TODO afficher un message d'erreur
    header("Location: ../Accueil_liste.php");
}