<?php

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\PatientChangedNotifier;
use Sportsante86\Sapa\Model\SuiviDossier;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (isset($input_data->id_patient) && isset($input_data->id_user)) {
    $id_patient = $input_data->id_patient;
    $id_user = $input_data->id_user;

    $suivi = new SuiviDossier($bdd);
    $return = $suivi->createSuiviDossier($id_user, $id_patient);

    if ($return) {
        $eventManager = new EventManager();
        $evaluationChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($_SESSION, $bdd);
        $eventArgs->setArgs([
            'id_patient' => $id_patient,
            'id_destinataire' => $id_user
        ]);

        $eventManager->dispatchEvent(PatientChangedNotifier::onPartageDossier, $eventArgs);

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($return);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $suivi->getErrorMessage(),
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
