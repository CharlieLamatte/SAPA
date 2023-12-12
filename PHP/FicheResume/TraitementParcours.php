<?php
/**
 * Modification du parcours d'un patient
 */

use Sportsante86\Sapa\Model\Patient;

require '../../bootstrap/bootstrap.php';

force_connected();

$patient = new Patient($bdd);
if ($_POST['dateEvalSuiv'] == "") {
    $_POST['dateEvalSuiv'] = null;
}
$update_ok = $patient->updateParcours([
    'id_patient' => $_GET['idPatient'],
    'date_debut_programme' => $_POST['dateDebPrevue'],
    'intervalle' => $_POST['intervalle'],
    'date_admission' => $_POST['da'],
    'date_eval_suiv' => $_POST['dateEvalSuiv']
]);

if (!$update_ok) {
    // TODO afficher un message d'erreur
    \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
        [
            'error_message' => $patient->getErrorMessage(),
            'data' => array_merge($_POST, $_GET),
            'session' => $_SESSION,
        ]
    );
}
header("Location: ../Patients/AccueilPatient.php?idPatient=" . $_GET['idPatient']);