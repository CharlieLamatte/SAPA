<?php

use Sportsante86\Sapa\Model\User;
use Sportsante86\Sapa\Model\SuiviDossier;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_patient)) {
    $id_patient = $input_data->id_patient;

    $user = new User($bdd);
    $coordos = $user->readAllCoordosPEPS($_SESSION);

    if (is_array($coordos)) {
        //on ne retourne que les coordonnateurs PEPS qui ne suivent pas déjà le bénéficiaire
        //et qui ne sont pas l'utilisateur connecté
        $s = new SuiviDossier($bdd);
        $liste = [];
        foreach ($coordos as $c) {
            if ($c['id_user'] != $_SESSION['id_user']) {
                $checkSuivi = $s->checkSuiviDossier($c['id_user'], $id_patient);
                if (!$checkSuivi) {
                    $liste[] = $c;
                }
            }
        }
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($liste);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $user->getErrorMessage(),
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

