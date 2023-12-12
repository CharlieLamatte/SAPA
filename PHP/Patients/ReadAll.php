<?php

use Sportsante86\Sapa\Model\Patient;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

$est_archive = isset($input_data->est_archive) ?
    ($input_data->est_archive ? "1" : "0") :
    "0";

$patient = new Patient($bdd);
$patients = $patient->readAll($_SESSION, $est_archive);

if (is_array($patients)) {
    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($patients);
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