<?php

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\PatientChangedNotifier;
use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Model\SuiviDossier;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_patient) &&
    isset($input_data->is_archived)) {
    $p = new Patient($bdd);
    $update_status_ok = $p->setArchiveStatus($input_data->id_patient, $input_data->is_archived);

    if ($update_status_ok) {
        if ($input_data->is_archived) {
            $patient = $p->readOne($input_data->id_patient);

            $eventManager = new EventManager();
            $patientChangedNotifier = new PatientChangedNotifier($eventManager);

            $eventArgs = new BasicEventArgs($_SESSION, $bdd);
            $eventArgs->setArgs([
                'id_patient' => $input_data->id_patient,
                'est_non_peps' => $patient['est_non_peps'] == "1" ? "checked" : "NON",
            ]);
            $eventManager->dispatchEvent(PatientChangedNotifier::onPatientArchived, $eventArgs);

            $suivi = new SuiviDossier($bdd);
            $deleteSuivi = $suivi->deleteAllSuiviDossier($input_data->id_patient);
            if (!$deleteSuivi) {
                // set response code - 500 Internal Server Error
                http_response_code(500);
                echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
                \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
                    'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
                    [
                        'error_message' => $suivi->getErrorMessage(),
                        'data' => json_encode($input_data),
                    ]
                );
            }
        }

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(["message" => "Ok"]);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $p->getErrorMessage(),
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