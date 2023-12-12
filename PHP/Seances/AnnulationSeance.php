<?php

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\SeanceChangedNotifier;
use Sportsante86\Sapa\Model\Seance;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_seance) &&
    !empty($input_data->id_motif_annulation)) {
    $seance = new Seance($bdd);
    $cancel_ok = $seance->cancelSeance([
        'motif_annulation' => $input_data->id_motif_annulation,
        'id_seance' => $input_data->id_seance,
    ]);

    if ($cancel_ok) {
        $eventManager = new EventManager();
        $patientChangedNotifier = new SeanceChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($_SESSION, $bdd);
        $eventArgs->setArgs([
            'id_seance' => $input_data->id_seance,
        ]);
        $eventManager->dispatchEvent(SeanceChangedNotifier::onSeanceCanceled, $eventArgs);

        // set response code - 200 Ok
        http_response_code(200);
        echo json_encode(["message" => "Ok"]);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $seance->getErrorMessage(),
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