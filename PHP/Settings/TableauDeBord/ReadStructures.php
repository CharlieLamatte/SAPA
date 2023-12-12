<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $input_data->year = $input_data->year ?? null;
    $is_year_present = $input_data->year != null && $input_data->year != '-1';

    $query = "
            SELECT DISTINCT 
            s.id_structure,
            s.nom_structure
            FROM patients
            JOIN antenne a on patients.id_antenne = a.id_antenne
            JOIN structure s on a.id_structure = s.id_structure
            WHERE patients.id_territoire = :id_territoire ";

    if ($is_year_present) {
        $query .= ' AND year(patients.date_admission) = :year ';
    }
    $query .= ' ORDER BY s.nom_structure ';

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $input_data->id_territoire);
    if ($is_year_present) {
        $stmt->bindValue(':year', $input_data->year);
    }
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $rep = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rep[] = [
                'id' => $row['id_structure'],
                'nom' => $row['nom_structure']
            ];
        }

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($rep);
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