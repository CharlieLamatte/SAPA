<?php

/**
 * Permet de récupérer le nombre prescription pour chaque médecin
 */

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_territoire)) {
    $id_territoire = $input_data->id_territoire;

    ////////////////////////////////////////////////////
    // Recuperation du nombre prescription pour chaque médecin
    ////////////////////////////////////////////////////
    $query = '
    SELECT distinct nom_coordonnees,
                    prenom_coordonnees,
                    nom_specialite_medecin,
                    count(*) as nb_prescription
    FROM coordonnees
    JOIN medecins USING (id_medecin)
    JOIN specialite_medecin USING (id_specialite_medecin)
    JOIN prescrit on medecins.id_medecin = prescrit.id_medecin
    JOIN patients p on prescrit.id_patient = p.id_patient
    JOIN antenne a on p.id_antenne = a.id_antenne
    WHERE
      p.id_territoire = :id_territoire ';

    if ($input_data->year != null && $input_data->year != '-1') {
        $query .= ' AND year(p.date_admission) = :year ';
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $query .= ' AND a.id_structure = :id_structure ';
    }
    if ($input_data->id_specialite_medecin != null && $input_data->id_specialite_medecin != '-1') {
        $query .= ' AND medecins.id_specialite_medecin = :id_specialite_medecin ';
    }
    $query .= '
    GROUP BY nom_coordonnees, prenom_coordonnees, nom_specialite_medecin
    ORDER BY nb_prescription DESC';

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $id_territoire);
    if ($input_data->year != null && $input_data->year != '-1') {
        $stmt->bindValue(':year', $input_data->year);
    }
    if ($input_data->id_structure != null && $input_data->id_structure != '-1') {
        $stmt->bindValue(':id_structure', $input_data->id_structure);
    }
    if ($input_data->id_specialite_medecin != null && $input_data->id_specialite_medecin != '-1') {
        $stmt->bindValue(':id_specialite_medecin', $input_data->id_specialite_medecin);
    }
    $stmt->execute();

    $result = [
        'labels' => [],
        'values' => []
    ];

    $total = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $result['values'][] = intval($row["nb_prescription"]);
        $result['labels'][] = $row['nom_coordonnees'] . ' ' . $row['prenom_coordonnees'];
        $total += intval($row['nb_prescription']);
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