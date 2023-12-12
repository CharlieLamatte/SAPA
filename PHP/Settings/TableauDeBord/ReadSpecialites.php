<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $query = "
        SELECT DISTINCT id_specialite_medecin,
                        nom_specialite_medecin
        FROM medecins
                 JOIN specialite_medecin USING (id_specialite_medecin)
                 JOIN prescrit on medecins.id_medecin = prescrit.id_medecin
                 JOIN patients p on p.id_patient = prescrit.id_patient
        WHERE p.id_territoire = :id_territoire
        ORDER BY id_specialite_medecin";

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $input_data->id_territoire);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $rep = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rep[] = [
                'id' => $row['id_specialite_medecin'],
                'nom' => $row['nom_specialite_medecin']
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