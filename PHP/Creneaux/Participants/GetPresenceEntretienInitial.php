<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_patient)) {
    $id_patient = $input_data->id_patient;

    $query = 'SELECT 
                count(*) as nombre
                FROM evaluations
                WHERE id_patient = :id_patient and id_type_eval = 1 ';
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_patient', $id_patient);
    $stmt->execute();

    $data = $stmt->fetch();

    $info = array(
        "nombre" => $data['nombre'],
    );

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($info);
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