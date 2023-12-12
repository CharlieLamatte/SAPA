<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';
require './functions_tableau.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $query = "
    SELECT sum(case when sexe like 'F' then 1 else 0 end) femmeCount,
           sum(case when sexe like 'M' then 1 else 0 end) hommeCount
    FROM (SELECT sexe
          FROM patients
                   JOIN antenne a on patients.id_antenne = a.id_antenne
          WHERE id_territoire = :id_territoire ";

    if ($input_data->year != null && $input_data->year != '-1') {
        $query .= ' AND year(patients.date_admission) = :year ';
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $query .= ' AND a.id_structure = :id_structure ';
    }
    $query .= ') as patients_filtered';

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $input_data->id_territoire);
    if ($input_data->year != null && $input_data->year != '-1') {
        $stmt->bindValue(':year', $input_data->year);
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $stmt->bindValue(':id_structure', $input_data->id_structure);
    }
    $stmt->execute();
    $data = $stmt->rowCount();

    if ($data > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $rows_cols = [
            'hommeCount' => 'Homme',
            'femmeCount' => 'Femme'
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