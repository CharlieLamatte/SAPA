<?php

use Sportsante86\Sapa\Model\StatistiquesTerritoire;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $s = new StatistiquesTerritoire($bdd);
    $stats_all = $s->getEvolutionTestMobiliteScapuloHumerale(
        $input_data->id_territoire,
        $input_data->year,
        $input_data->id_structure,
        "-1"
    );
    $stats_hommes = $s->getEvolutionTestMobiliteScapuloHumerale(
        $input_data->id_territoire,
        $input_data->year,
        $input_data->id_structure,
        "M"
    );
    $stats_femmes = $s->getEvolutionTestMobiliteScapuloHumerale(
        $input_data->id_territoire,
        $input_data->year,
        $input_data->id_structure,
        "F"
    );

    if (is_array($stats_all) && is_array($stats_hommes) && is_array($stats_femmes)) {
        $result = [];
        $result["stats_all"] = $stats_all;
        $result["stats_hommes"] = $stats_hommes;
        $result["stats_femmes"] = $stats_femmes;

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($result);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'data' => json_encode($input_data),
                'session' => $_SESSION
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