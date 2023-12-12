<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';
require './functions_tableau.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $query = '
    SELECT all_patient_count - patient_avec_activite as non,
           patient_avec_activite                     as oui
    FROM (SELECT COUNT(id_patient) all_patient_count
          FROM patients p
          JOIN antenne a on p.id_antenne = a.id_antenne
          WHERE id_territoire = :id_territoire_1 ';
    if ($input_data->year != null && $input_data->year != '-1') {
        $query .= ' AND YEAR(p.date_admission) = :year_1 ';
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $query .= ' AND a.id_structure = :id_structure_1 ';
    }
    $query .= ') as py
         JOIN
     (SELECT COUNT(*) as patient_avec_activite
      FROM (SELECT DISTINCT p.id_patient
            FROM activites_physiques
                     JOIN patients p on activites_physiques.id_patient = p.id_patient
                     JOIN antenne a on p.id_antenne = a.id_antenne
            WHERE p.id_territoire = :id_territoire_2
              AND activite_physique_autonome IS NOT NULL ';
    if ($input_data->year != null && $input_data->year != '-1') {
        $query .= ' AND YEAR(p.date_admission) = :year_2 ';
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $query .= ' AND a.id_structure = :id_structure_2 ';
    }
    $query .= ') as pz) as px ';

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire_1', $input_data->id_territoire);
    $stmt->bindValue(':id_territoire_2', $input_data->id_territoire);
    if ($input_data->year != null && $input_data->year != '-1') {
        $stmt->bindValue(':year_1', $input_data->year);
        $stmt->bindValue(':year_2', $input_data->year);
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $stmt->bindValue(':id_structure_1', $input_data->id_structure);
        $stmt->bindValue(':id_structure_2', $input_data->id_structure);
    }
    $stmt->execute();
    $data = $stmt->rowCount();

    if ($data > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $rows_cols = [
            'oui' => 'Oui',
            'non' => 'Non'
        ];
        $item = [
            'labels' => [],
            'values' => []
        ];

        foreach ($rows_cols as $col => $label) {
            $val = intval($row[$col]);
            add($item, $label, $val);
        }

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($item);
    } else {
        // set response code - 404 Not found
        http_response_code(404);
        echo json_encode(["message" => "No data found."]);
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