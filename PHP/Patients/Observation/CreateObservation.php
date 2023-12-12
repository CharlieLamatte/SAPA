<?php

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\ObservationChangedNotifier;
use Sportsante86\Sapa\Model\Observation;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_patient) &&
    !empty($input_data->observation) &&
    !empty($input_data->id_user) &&
    !empty($input_data->id_type_observation)) {
    $o = new Observation($bdd);
    $id_observation = $o->create([
        'observation' => $input_data->observation,
        'id_patient' => $input_data->id_patient,
        'id_user' => $input_data->id_user,
        'id_type_observation' => $input_data->id_type_observation
    ]);

    if ($id_observation) {
        $new_observation = $o->readOne($id_observation);

        // envoi de notifications si c'est une observation de santé
        if ($input_data->id_type_observation == Observation::TYPE_OBSERVATION_SANTE) {
            $eventManager = new EventManager();
            $observationChangedNotifier = new ObservationChangedNotifier($eventManager);

            $eventArgs = new BasicEventArgs($_SESSION, $bdd);
            $eventArgs->setArgs([
                'id_patient' => $input_data->id_patient,
            ]);
            $eventManager->dispatchEvent(ObservationChangedNotifier::onObservationSanteCreated, $eventArgs);
        }

        // set response code - 201 created
        http_response_code(201);
        echo json_encode($new_observation);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $o->getErrorMessage(),
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