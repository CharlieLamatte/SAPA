<?php

require '../../../bootstrap/bootstrap.php';
require '../../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

function getYear($date) {
    $debut = new DateTime($date);
    return $debut->format('Y');
}

function getMonth($date) {
    $debut = new DateTime($date);
    return $debut->format('F');
}

function prevKey($key) {
    $parts = explode(' ', $key);

    switch ($parts[0]) {
        case 'January':
            return null;
        case 'February':
            return 'January ' . $parts[1];
        case 'March':
            return 'February ' . $parts[1];
        case 'April':
            return 'March ' . $parts[1];
        case 'May':
            return 'April ' . $parts[1];
        case 'June':
            return 'May ' . $parts[1];
        case 'July':
            return 'June ' . $parts[1];
        case 'August':
            return 'July ' . $parts[1];
        case 'September':
            return 'August ' . $parts[1];
        case 'October':
            return 'September ' . $parts[1];
        case 'November':
            return 'October ' . $parts[1];
        case 'December':
            return 'November ' . $parts[1];
        default:
            return null;
    }
}

/**
 * Initialise tous les mois de l'année
 * @param $array
 * @param $year l'année
 */
function initYear(&$array, $year) {
    $array['January '.$year] = 0;
    $array['February '.$year] = 0;
    $array['March '.$year] = 0;
    $array['April '.$year] = 0;
    $array['May '.$year] = 0;
    $array['June '.$year] = 0;
    $array['July '.$year] = 0;
    $array['August '.$year] = 0;
    $array['September '.$year] = 0;
    $array['October '.$year] = 0;
    $array['November '.$year] = 0;
    $array['December '.$year] = 0;
}

function format_data($array) {
    $a = [];

    foreach($array as $key => $val) {
        $a[] = [
            'category' => $key,
            'amount' => $val,
        ];
    }

    return $a;
}

if (!empty($input_data->id_territoire) &&
    !empty($input_data->year)) {
    $id_territoire = $input_data->id_territoire;
    $year = $input_data->year;

    ////////////////////////////////////////////////////
    // Recuperation de tous les patients (de la file active?)
    ////////////////////////////////////////////////////
    $query = 'SELECT DISTINCT
                id_patient,
                date_admission
                FROM patients
                WHERE patients.id_territoire = :id_territoire 
                  AND year(date_admission) = :year
                ORDER BY date_admission';// . $_SESSION['id_territoire'];

    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_territoire', $id_territoire);
    $stmt->bindValue(':year', $year);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $patient_data = [];

        $current_year = '';
        $current_month = '';
        $current_total = 0;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($current_year != getYear($row['date_admission'])) {
                initYear($patient_data, getYear($row['date_admission']));
                $current_year = getYear($row['date_admission']);
                $current_total = 0;
            }

            $current_total++;

            $patient_data[getMonth($row['date_admission']). ' ' . getYear($row['date_admission'])] = $current_total;
        }

        $reversed = array_reverse($patient_data, true);

        // on enlève les mois en trop
        foreach ($reversed as $key => $value) {
            if ($value == 0) {
                unset($reversed[$key]);
            } else {
                break;
            }
        }

        $patient_data = array_reverse($reversed, true);

        foreach ($patient_data as $key => $value) {
            if ($value == 0 && prevKey($key) != null) {
                $patient_data[$key] = $patient_data[prevKey($key)];
            }
        }

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(format_data($patient_data));
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