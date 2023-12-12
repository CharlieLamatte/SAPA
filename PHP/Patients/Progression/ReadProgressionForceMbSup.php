<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';
require '../../Settings/TableauDeBord/functions_tableau.php';

$input_data = json_decode(file_get_contents("php://input"));

$columns = [
    'md',
    'mg',
];

if (!empty($input_data->id_patient) &&
    !empty($input_data->column)) {
    try {
        if (!in_array($input_data->column, $columns)) {
            throw new Exception("Nom de colonne invalide.");
        }

        $query = "
        SELECT 
               $input_data->column as value,
               DATE_FORMAT(date_eval, '%d/%m/%Y') as date_eval
        FROM evaluations
        JOIN patients p on evaluations.id_patient = p.id_patient
        JOIN eval_force_musc_mb_sup efmms on evaluations.id_evaluation = efmms.id_evaluation
        WHERE p.id_patient = :id_patient AND $input_data->column IS NOT NULL
        ORDER BY date_eval";

        $stmt = $bdd->prepare($query);
        $stmt->bindValue(':id_patient', $input_data->id_patient);
        $stmt->execute();

        $result = array(
            'labels' => array(),
            'values' => array()
        );

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            add($result, $row['date_eval'], $row['value']);
        }

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($result);
    } catch (Exception $exception) {
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $exception->getMessage(),
                'data' => json_encode($input_data),
            ]
        );
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