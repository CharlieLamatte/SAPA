<?php

use Sportsante86\Sapa\Model\Questionnaire;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_patient) &&
    !empty($input_data->id_questionnaire)) {
    $questionnaire = new Questionnaire($bdd);
    $ids = $questionnaire->getQuestionnairesInstancesPatient($input_data->id_patient, $input_data->id_questionnaire);

    $result = [];
    foreach ($ids as $id_questionnaire_instance) {
        $item = $questionnaire->readReponses($id_questionnaire_instance);
        if ($item) {
            $result[] = $item;
        }
    }

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($result);
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