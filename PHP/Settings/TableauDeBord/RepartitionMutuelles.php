<?php

/**
 * Permet de récupérer le nombre de patients qui ont souscrit à chaque mutuelle
 */

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $id_territoire = $input_data->id_territoire;

    $query = '
    SELECT
        nom_coordonnees,
        COUNT(*) as nb_patient
    FROM mutuelles
    JOIN coordonnees c on c.id_coordonnees = mutuelles.id_coordonnees
    JOIN patients p on mutuelles.id_mutuelle = p.id_mutuelle
    JOIN antenne a on p.id_antenne = a.id_antenne
    WHERE p.id_territoire = :id_territoire ';

    if ($input_data->year != null && $input_data->year != '-1') {
        $query .= ' AND year(p.date_admission) = :year ';
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $query .= ' AND a.id_structure = :id_structure ';
    }
    $query .= ' GROUP BY nom_coordonnees ORDER BY nb_patient DESC';

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $input_data->id_territoire);
    if ($input_data->year != null && $input_data->year != '-1') {
        $stmt->bindValue(':year', $input_data->year);
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $stmt->bindValue(':id_structure', $input_data->id_structure);
    }
    $stmt->execute();

    $result = [
        'labels' => [],
        'values' => []
    ];

    $total = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result['values'][] = intval($row["nb_patient"]);
        $result['labels'][] = $row["nom_coordonnees"];
        $total += intval($row["nb_patient"]);
    }

    // ajout du total
    $result['total'] = $total;

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