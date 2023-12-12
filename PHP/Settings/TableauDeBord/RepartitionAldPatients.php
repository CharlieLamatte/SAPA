<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';
require './functions_tableau.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $query = "
        SELECT
           SUM(IF(id_type_pathologie = 1 , 1, 0)) count_surpoids,
           SUM(IF(id_type_pathologie = 2 , 1, 0)) count_cardio,
           SUM(IF(id_type_pathologie = 3 , 1, 0)) count_diabete,
           SUM(IF(id_type_pathologie = 4 , 1, 0)) count_cancer,
           SUM(IF(id_type_pathologie = 5 , 1, 0)) count_hemato,
           SUM(IF(id_type_pathologie = 6 , 1, 0)) count_neuro,
           SUM(IF(id_type_pathologie = 7 , 1, 0)) count_psychiatrie,
           SUM(IF(id_type_pathologie = 8 , 1, 0)) count_osteo,
           SUM(IF(id_type_pathologie = 9 , 1, 0)) count_respiratoire,
           SUM(IF(id_type_pathologie = 10 , 1, 0)) count_infectieuse,
           SUM(IF(id_type_pathologie = 11 , 1, 0)) count_renale,
           SUM(IF(id_type_pathologie = 12 , 1, 0)) count_inflammatoire,
           SUM(IF(id_type_pathologie = 13 , 1, 0)) count_fonctionnel,
           SUM(IF(id_type_pathologie = 14 , 1, 0)) count_transplante,
           SUM(IF(id_type_pathologie = 15, 1, 0)) count_autre,
           SUM(IF(id_type_pathologie = 16, 1, 0)) count_vieillissement,
           SUM(IF(id_type_pathologie = 17, 1, 0)) count_grossesse
           FROM
        (SELECT
            tp.id_type_pathologie
            FROM souffre_de
            JOIN pathologie_ou_etat poe on souffre_de.id_pathologie_ou_etat = poe.id_pathologie_ou_etat
            JOIN type_pathologie tp on poe.id_type_pathologie = tp.id_type_pathologie
            JOIN patients p on souffre_de.id_patient = p.id_patient
            JOIN antenne a on p.id_antenne = a.id_antenne
            WHERE poe.id_pathologie_ou_etat != -1
              AND p.id_territoire = :id_territoire ";

    if ($input_data->year != null && $input_data->year != '-1') {
        $query .= ' AND YEAR(p.date_admission) = :year ';
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $query .= ' AND a.id_structure = :id_structure ';
    }
    $query .= ' ) as py';

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
            'count_surpoids' => 'Surpoids ou Obésité',
            'count_cardio' => 'Cardiovasculaires',
            'count_diabete' => 'Diabètes',
            'count_cancer' => 'Cancers',
            'count_hemato' => 'Hématologiques',
            'count_neuro' => 'Neurologiques',
            'count_psychiatrie' => 'Psychiatrie',
            'count_osteo' => 'Ostéoarticulaires',
            'count_respiratoire' => 'Respiratoires',
            'count_infectieuse' => 'Infectieuses',
            'count_renale' => 'Rénales',
            'count_inflammatoire' => 'Intestinales chroniques inflammatoires',
            'count_fonctionnel' => 'Symptomes fonctionnels',
            'count_transplante' => 'Transplantés',
            'count_autre' => 'Autres',
            'count_vieillissement' => 'Vieillissement',
            'count_grossesse' => 'Grossesse non pathologique',
        ];
        $item = [
            'labels' => [],
            'values' => []
        ];

        foreach ($rows_cols as $col => $label) {
            $val = intval($row[$col]);

            // on
            if ($val > 0) {
                add($item, $label, $val);
            }
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