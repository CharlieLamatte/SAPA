<?php

/**
 * Permet de récupérer le nombre d'objectifs de patients du territoire concerné par type de statut
 */

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';
require './functions_tableau.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $id_territoire = $input_data->id_territoire;

    $query = "SELECT COUNT(IF(att = 'Non Atteint',1,NULL)) count_nonatteint,
       COUNT(IF(att = 'Partiellement Atteint',1,NULL)) count_partatteint,
       COUNT(IF(att = 'Atteint',1,NULL)) count_atteint
    FROM (SELECT avancement_obj.atteinte as att FROM avancement_obj JOIN objectif_patient ON avancement_obj.id_obj_patient = objectif_patient.id_obj_patient
    JOIN patients p ON objectif_patient.id_patient = p.id_patient
    JOIN antenne a on p.id_antenne = a.id_antenne
    WHERE p.id_territoire = :id_territoire ";

    if ($input_data->year != null && $input_data->year != '-1') {
        $query .= ' AND year(p.date_admission) = :year ';
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $query .= ' AND a.id_structure = :id_structure ';
    }
    $query .= ') as req_atteint';

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $id_territoire);
    if ($input_data->year != null && $input_data->year != '-1') {
        $stmt->bindValue(':year', $input_data->year);
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $stmt->bindValue(':id_structure', $input_data->id_structure);
    }
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $item = [
        'labels' => [],
        'values' => []
    ];

    add($item, 'Non atteints', $row['count_nonatteint']);
    add($item, 'Partiellement atteints', $row['count_partatteint']);
    add($item, 'Atteints', $row['count_atteint']);

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($item);
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