<?php

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\PatientChangedNotifier;
use Sportsante86\Sapa\Model\Orientation;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"), true);

if (!empty($input_data['id_patient']) && is_array($input_data['activites'])) {
    $orientation = new Orientation($bdd);
    $update_ok = $orientation->updateActivitesChoisies([
        'id_patient' => $input_data['id_patient'],
        'activites' => $input_data['activites'],
    ]);

    if ($update_ok) {
        $eventManager = new EventManager();
        $intervAffectation = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($_SESSION, $bdd);
        $eventArgs->setArgs([
            'id_patient' => $input_data['id_patient'],
        ]);
        $eventManager->dispatchEvent(PatientChangedNotifier::onAffectationCreneau, $eventArgs);

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(["message" => "Ok"]);
    } else {
        $bdd->rollBack();

        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $orientation->getErrorMessage(),
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