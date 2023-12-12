<?php

use Sportsante86\Sapa\Model\StatistiquesStructure;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_structure)) {
    $date = new DateTime();
    $today = $date->format(DATE_ATOM);

    $stat = new StatistiquesStructure($bdd);
    $repartition_status_beneficiaire = $stat->getRepartitionStatusBeneficiaire($input_data->id_structure);
    $total = ($repartition_status_beneficiaire["values"][0] ?? 0) + ($repartition_status_beneficiaire["values"][1] ?? 0);

    $result = [
        'beneficiaire_count' => $total,
        'beneficiaire_actif_count' => $repartition_status_beneficiaire["values"][0] ?? 0,
        'repartition_age' => $stat->getRepartitionAge($input_data->id_structure),
        'repartition_role' => $stat->getRepartitionRole($input_data->id_structure),
        'repartition_status_beneficiaire' => $repartition_status_beneficiaire,
        'assiduite' => $stat->getAssiduite($input_data->id_structure, $today),
    ];

    // set response code - 20O OK
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