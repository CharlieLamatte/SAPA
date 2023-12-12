<?php

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\PatientChangedNotifier;
use Sportsante86\Sapa\Model\Antenne;
use Sportsante86\Sapa\Model\Patient;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

// get posted data
$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_patient) &&
    !empty($input_data->id_antenne)) {
    $patient = new Patient($bdd);
    $update_ok = $patient->updateAntenne([
        'id_patient' => $input_data->id_patient,
        'id_antenne' => $input_data->id_antenne,
    ]);

    if ($update_ok) {
        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($_SESSION, $bdd);
        $eventArgs->setArgs([
            'id_antenne' => $input_data->id_antenne,
            'id_patient' => $input_data->id_patient
        ]);
        $eventManager->dispatchEvent(PatientChangedNotifier::onAntenneChanged, $eventArgs);

        $antenne = new Antenne($bdd);
        $item = $antenne->readOne($input_data->id_antenne);

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($item);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $patient->getErrorMessage(),
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