<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $query = "
            SELECT * FROM
            (SELECT
                DISTINCT (case when date_admission is not null then YEAR(date_admission) end) year
            FROM patients
               WHERE patients.id_territoire = :id_territoire) as py
            WHERE year is not null AND year > 2000 
            ORDER BY year DESC";

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $input_data->id_territoire);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $rep = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rep[] = $row['year'];
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