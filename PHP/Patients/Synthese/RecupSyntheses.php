<?php
//Récupère toutes les synthèses d'un bénéficiaire

use Sportsante86\Sapa\Model\Synthese;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id_patient) && !empty($data->filter_id_user)) {
    $id_patient = $data->id_patient;
    $filter_id_user = filter_var($data->filter_id_user, FILTER_VALIDATE_BOOLEAN);

    $synth = new Synthese($bdd);
    $result = $synth->fetchSyntheses($id_patient, $_SESSION['id_user'], $filter_id_user);

    if (is_array($result)) {
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($result);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $synth->getErrorMessage(),
                'data' => json_encode($data),
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
            'data' => json_encode($data)
        ]
    );
}


