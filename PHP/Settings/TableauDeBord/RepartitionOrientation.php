<?php

/**
 * Permet de récupérer le nombre d'orientations par territoire et par an
 */

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';
require './functions_tableau.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $id_territoire = $input_data->id_territoire;

    $query = '
    SELECT type_parcours,
           COUNT(*) as nb_type_parcours
    FROM orientation
             JOIN patients p on orientation.id_patient = p.id_patient
             JOIN antenne a on p.id_antenne = a.id_antenne
             JOIN type_parcours tp on orientation.id_type_parcours = tp.id_type_parcours
    WHERE p.id_territoire = :id_territoire ';

    if ($input_data->year != null && $input_data->year != '-1') {
        $query .= ' AND year(p.date_admission) = :year ';
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $query .= ' AND a.id_structure = :id_structure ';
    }

    $query .= ' GROUP BY type_parcours ORDER BY nb_type_parcours DESC';

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $id_territoire);
    if ($input_data->year != null && $input_data->year != '-1') {
        $stmt->bindValue(':year', $input_data->year);
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $stmt->bindValue(':id_structure', $input_data->id_structure);
    }
    $stmt->execute();

    $item = [
        'labels' => [],
        'values' => []
    ];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        add(
            $item,
            $row['type_parcours'],
            $row['nb_type_parcours']
        );
    }

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