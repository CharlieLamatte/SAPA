<?php

use Sportsante86\Sapa\Model\Export;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

$export = new Export($bdd);
$patients = $export->readPatientData($_SESSION);

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
            'data' => json_encode($input_data),
            'session' => $_SESSION,
            'error_message' => $export->getErrorMessage(),
        ]
    );
}