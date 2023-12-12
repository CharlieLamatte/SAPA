<?php

use Sportsante86\Sapa\Model\Creneau;
use Sportsante86\Sapa\Model\Seance;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"), true);

if (!empty($input_data['id_creneau']) && isset($input_data['participants'])) {
    $creneau = new Creneau($bdd);
    $update_ok = $creneau->updateParticipants($input_data['id_creneau'], $input_data['participants']);

    if (!$update_ok) {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $creneau->getErrorMessage(),
                'data' => json_encode($input_data)
            ]
        );
        die();
    }

    ////////////////////////////////////////////////////
    // on met aussi à jour la liste des participants des séances qui se passent après aujourd'hui
    ////////////////////////////////////////////////////

    $date = new DateTime();
    $today = $date->format(DATE_ATOM);

    $seance = new Seance($bdd);
    $update_ok = $seance->updateParticipantsSeancesAfter($today, $input_data['id_creneau']);

    if ($update_ok) {
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(["message" => "Participants were updated."]);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $seance->getErrorMessage(),
                'data' => json_encode($input_data)
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