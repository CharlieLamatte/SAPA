<?php

/**
 * Permet de récupérer pour chaque date, le nombre de patient admis est compté
 */

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $id_territoire = $input_data->id_territoire;

    ////////////////////////////////////////////////////
    // Recuperation de tous les patients (de la file active?)
    ////////////////////////////////////////////////////
    $query = "
        SELECT
      SUM(CASE MONTH(date_admission) WHEN 1 THEN 1 ELSE 0 END) AS January,
      SUM(CASE MONTH(date_admission) WHEN 2 THEN 1 ELSE 0 END) AS February,
      SUM(CASE MONTH(date_admission) WHEN 3 THEN 1 ELSE 0 END) AS March,
      SUM(CASE MONTH(date_admission) WHEN 4 THEN 1 ELSE 0 END) AS April,
      SUM(CASE MONTH(date_admission) WHEN 5 THEN 1 ELSE 0 END) AS May,
      SUM(CASE MONTH(date_admission) WHEN 6 THEN 1 ELSE 0 END) AS June,
      SUM(CASE MONTH(date_admission) WHEN 7 THEN 1 ELSE 0 END) AS July,
      SUM(CASE MONTH(date_admission) WHEN 8 THEN 1 ELSE 0 END) AS August,
      SUM(CASE MONTH(date_admission) WHEN 9 THEN 1 ELSE 0 END) AS September,
      SUM(CASE MONTH(date_admission) WHEN 10 THEN 1 ELSE 0 END) AS October,
      SUM(CASE MONTH(date_admission) WHEN 11 THEN 1 ELSE 0 END) AS November,
      SUM(CASE MONTH(date_admission) WHEN 12 THEN 1 ELSE 0 END) AS December,
      COUNT(*) as Total
    FROM
        patients
    JOIN antenne a on patients.id_antenne = a.id_antenne
    WHERE
      patients.id_territoire = :id_territoire ";

    if ($input_data->year != null && $input_data->year != '-1') {
        $query .= ' AND YEAR(date_admission) = :year ';
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $query .= ' AND a.id_structure = :id_structure ';
    }

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $id_territoire);
    if ($input_data->year != null && $input_data->year != '-1') {
        $stmt->bindValue(':year', $input_data->year);
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $stmt->bindValue(':id_structure', $input_data->id_structure);
    }
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $rows_cols = [
            'January' => 'Janvier',
            'February' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre',
        ];

        $item = [
            'labels' => [],
            'values' => [],
            'total' => $row['Total'],
        ];

        foreach ($rows_cols as $col => $label) {
            $val = intval($row[$col]);
            $item['values'][] = $val;
            $item['labels'][] = $label;
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