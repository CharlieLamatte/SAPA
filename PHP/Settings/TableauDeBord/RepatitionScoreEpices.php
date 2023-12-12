<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';
require './functions_tableau.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $query = "
    SELECT
        SUM(IF(score_epices <= 30, 1, 0)) as count_sub30,
        SUM(IF(score_epices > 30, 1, 0)) as count_sup30
    FROM
    (SELECT id_questionnaire_instance,
           SUM(CASE
                   WHEN ordre = 1 AND valeur_bool = 1 THEN 10.06
                   WHEN ordre = 2 AND valeur_bool = 1 THEN -11.83
                   WHEN ordre = 3 AND valeur_bool = 1 THEN -8.28
                   WHEN ordre = 4 AND valeur_bool = 1 THEN -8.28
                   WHEN ordre = 5 AND valeur_bool = 1 THEN 14.80
                   WHEN ordre = 6 AND valeur_bool = 1 THEN -6.51
                   WHEN ordre = 7 AND valeur_bool = 1 THEN -7.10
                   WHEN ordre = 8 AND valeur_bool = 1 THEN -7.10
                   WHEN ordre = 9 AND valeur_bool = 1 THEN -9.47
                   WHEN ordre = 10 AND valeur_bool = 1 THEN -9.47
                   WHEN ordre = 11 AND valeur_bool = 1 THEN -7.10
               END) + 75.14 as score_epices
    FROM reponse_questionnaire
             JOIN question q on reponse_questionnaire.id_question = q.id_question
             JOIN reponse_possible rp on q.id_reponse_possible = rp.id_reponse_possible
             JOIN type_reponse tr on rp.id_type_reponse = tr.id_type_reponse
             JOIN reponse_instance ri
                  on reponse_questionnaire.id_reponse_instance = ri.id_reponse_instance
    WHERE reponse_questionnaire.id_questionnaire_instance IN (
        SELECT DISTINCT id_questionnaire_instance
        FROM questionnaire_instance
                 JOIN question q on questionnaire_instance.id_questionnaire = q.id_questionnaire
                 JOIN patients p on p.id_patient = questionnaire_instance.id_patient
                 JOIN antenne a on p.id_antenne = a.id_antenne
        WHERE p.id_territoire = :id_territoire AND q.id_questionnaire = 2 ";

    if ($input_data->year != null && $input_data->year != '-1') {
        $query .= ' AND year(p.date_admission) = :year ';
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $query .= ' AND a.id_structure = :id_structure ';
    }
    $query .= ' ) GROUP BY id_questionnaire_instance) as score_per_questionnaire';

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
            'count_sub30' => 'Score inférieur ou égal à 30',
            'count_sup30' => 'Score supérieur à 30'
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