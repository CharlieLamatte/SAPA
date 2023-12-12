<?php

use Sportsante86\Sapa\Model\JournalAcces;
use Sportsante86\Sapa\Model\Patient;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_patient)) {
    $p = new Patient($bdd);
    $patient = $p->readOne($input_data->id_patient);
    $delete = $p->delete($input_data->id_patient);

    if ($delete) {
        \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
            'User ' . $_SESSION['email_connecte'] . ' deleted patient successfully (id was '. $input_data->id_patient. ')',
            [
                'event' => 'delete:patient',
                'deleted_data' => json_encode($patient)
            ]
        );

        // enregistrement de la suppression d'un patient
        $journal = new JournalAcces($bdd);
        $journal->create([
            'nom_acteur' => $_SESSION['nom_connecte'] . " " . $_SESSION['prenom_connecte'],
            'type_action' => "delete",
            'type_cible' => "patient",
            'nom_cible' => $patient['nom_naissance'] . " " . $patient["premier_prenom_naissance"],
            'id_user_acteur' => $_SESSION['id_user'],
        ]);

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(["message" => 'ok']);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $p->getErrorMessage(),
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