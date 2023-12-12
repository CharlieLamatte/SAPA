<?php

use Sportsante86\Sapa\Model\Questionnaire;

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';
require './functions_tableau.php';

$input_data = json_decode(file_get_contents("php://input"));

function getAmelioration($bdd, $id_territoire, $year, $id_structure, $nom_questionnaire)
{
    $is_year_present = $year != null && $year != '-1';
    $is_id_structure_present = $id_structure != null && $id_structure != '-1';

    $questionnaires = [
        'opaq' => 1,
        'sedendarite' => 1,
        'epices' => 2,
        'garnier' => 4,
        'proschaska' => 3,
    ];

    $sum = 0;
    $number_of_patients = 0;

    $query = "SELECT DISTINCT p.id_patient
        FROM questionnaire_instance
        JOIN patients p on p.id_patient = questionnaire_instance.id_patient
        JOIN antenne a on p.id_antenne = a.id_antenne
        WHERE p.id_territoire = :id_territoire AND id_questionnaire = :id_questionnaire ";

    if ($is_year_present) {
        $query .= ' AND year(p.date_admission) = :year ';
    }
    if ($is_id_structure_present) {
        $query .= ' AND a.id_structure = :id_structure ';
    }

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $id_territoire);
    $stmt->bindValue(':id_questionnaire', $questionnaires[$nom_questionnaire]);
    if ($is_year_present) {
        $stmt->bindValue(':year', $year);
    }
    if ($is_id_structure_present) {
        $stmt->bindValue(':id_structure', $id_structure);
    }
    $stmt->execute();

    while ($row_patient = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $query2 = 'SELECT id_questionnaire_instance, MIN(date) as min_date
                    FROM questionnaire_instance
                    JOIN patients p on p.id_patient = questionnaire_instance.id_patient
                    WHERE p.id_patient = :id_patient AND id_questionnaire = :id_questionnaire
                    GROUP BY id_questionnaire_instance
                    ORDER BY min_date
                    limit 1';

        $stmt2 = $bdd->prepare($query2);
        $stmt2->bindValue(':id_patient', $row_patient['id_patient']);
        $stmt2->bindValue(':id_questionnaire', $questionnaires[$nom_questionnaire]);
        $stmt2->execute();

        $d = $stmt2->fetch(PDO::FETCH_ASSOC);
        $id_questionnaire_instance_min = $d['id_questionnaire_instance'];

        $query3 = 'SELECT id_questionnaire_instance, MAX(date) as max_date
                    FROM questionnaire_instance
                    JOIN patients p on p.id_patient = questionnaire_instance.id_patient
                    WHERE p.id_patient = :id_patient AND id_questionnaire = :id_questionnaire
                    GROUP BY id_questionnaire_instance
                    ORDER BY max_date desc
                    limit 1';

        $stmt3 = $bdd->prepare($query3);
        $stmt3->bindValue(':id_patient', $row_patient['id_patient']);
        $stmt3->bindValue(':id_questionnaire', $questionnaires[$nom_questionnaire]);
        $stmt3->execute();

        $d = $stmt3->fetch(PDO::FETCH_ASSOC);
        $id_questionnaire_instance_max = $d['id_questionnaire_instance'];

        if ($id_questionnaire_instance_min != $id_questionnaire_instance_max) {
            $quest = new Questionnaire($bdd);
            if ($nom_questionnaire == "opaq") {
                $first_score = $quest->getScoreOpaq($id_questionnaire_instance_min);
                if ($first_score['niveau_activite_physique_mets'] == 0) {
                    continue;
                }
                $last_score = $quest->getScoreOpaq($id_questionnaire_instance_max);

                $variation = $last_score['niveau_activite_physique_mets'] - $first_score['niveau_activite_physique_mets'];
                $variation = ($variation / $first_score['niveau_activite_physique_mets']) * 100;
            } elseif ($nom_questionnaire == "epices") {
                $first_score = $quest->getScoreEpices($id_questionnaire_instance_min);
                if ($first_score['epices'] == 0) {
                    continue;
                }
                $last_score = $quest->getScoreEpices($id_questionnaire_instance_max);

                $variation = $last_score['epices'] - $first_score['epices'];
                $variation = ($variation / $first_score['epices']) * 100;
            } elseif ($nom_questionnaire == "garnier") {
                $first_score = $quest->getScoreGarnier($id_questionnaire_instance_min);
                if ($first_score['perception_sante'] == 0) {
                    continue;
                }
                $last_score = $quest->getScoreGarnier($id_questionnaire_instance_max);

                $variation = $last_score['perception_sante'] - $first_score['perception_sante'];
                $variation = ($variation / $first_score['perception_sante']) * 100;
            } elseif ($nom_questionnaire == "proschaska") {
                $first_score = $quest->getScoreProcheska($id_questionnaire_instance_min);
                if ($first_score['proshenska'] == 0) {
                    continue;
                }
                $last_score = $quest->getScoreProcheska($id_questionnaire_instance_max);

                $variation = $last_score['proshenska'] - $first_score['proshenska'];
                $variation = ($variation / $first_score['proshenska']) * 100;
            } elseif ($nom_questionnaire == "sedendarite") {
                $first_score = $quest->getScoreOpaq($id_questionnaire_instance_min);
                $last_score = $quest->getScoreOpaq($id_questionnaire_instance_max);

                if ($last_score['niveau_sendentarite'] == null || $first_score['niveau_sendentarite'] == null || $first_score['niveau_sendentarite'] == 0) { // prise en compte des cas où le score n'est pas calculable
                    continue;
                }

                $variation = $last_score['niveau_sendentarite'] - $first_score['niveau_sendentarite'];
                $variation = ($variation / $first_score['niveau_sendentarite']) * 100;
            } else {
                // erreur param manquant ou inconnu
                return null;
            }

            $sum += $variation;
            $number_of_patients++;
        }
    }

    return $number_of_patients == 0 ? null : $sum / $number_of_patients;
}

if (!empty($input_data->id_territoire)) {
    $input_data->year = $input_data->year ?? null;
    $input_data->id_structure = $input_data->id_structure ?? null;

    $am_epices = getAmelioration(
        $bdd,
        $input_data->id_territoire,
        $input_data->year,
        $input_data->id_structure,
        "epices"
    );
    $am_opaq = getAmelioration($bdd, $input_data->id_territoire, $input_data->year, $input_data->id_structure, "opaq");
    $am_garnier = getAmelioration(
        $bdd,
        $input_data->id_territoire,
        $input_data->year,
        $input_data->id_structure,
        "garnier"
    );
    $am_proschaska = getAmelioration(
        $bdd,
        $input_data->id_territoire,
        $input_data->year,
        $input_data->id_structure,
        "proschaska"
    );
    $am_sedendarite = getAmelioration(
        $bdd,
        $input_data->id_territoire,
        $input_data->year,
        $input_data->id_structure,
        "sedendarite"
    );

    $item = [
        'labels' => [],
        'values' => []
    ];

    add($item, 'Score épices', round($am_epices, 2));
    add($item, 'Niveau activite physique (mets)', round($am_opaq, 2));
    add($item, 'Niveau sédendarité', round($am_sedendarite, 2));
    add($item, 'Score garnier', round($am_garnier, 2));
    add($item, 'Score proschaska', round($am_proschaska, 2));

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($item);
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