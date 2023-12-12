<?php

use Sportsante86\Sapa\Model\StatistiquesTerritoire;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';
require './functions_tableau.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $year = (isset($input_data->year) && $input_data->year != '-1') ? $input_data->year : null;
    $id_structure = (isset($input_data->id_structure) && $input_data->id_structure != '-1') ? $input_data->id_structure : null;

    $stat = new StatistiquesTerritoire($bdd);
    $repartition_age_beneficiaire = $stat->getRepartitionAge($input_data->id_territoire, $year, $id_structure);

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($repartition_age_beneficiaire);
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