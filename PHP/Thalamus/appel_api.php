<?php
/**
 * Fichier utilisé pour tester l'appel de l'API thalamus
 */

use Sportsante86\Sapa\Model\Export;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"), true);

////////////////////////////////////////////////////
/// Authentification, créer token d'authentification
////////////////////////////////////////////////////
$response = false;
$error = "";
$http_code = -1;

$ch = curl_init();
try {
    $url = $_ENV['THALAMUS_URL_AUTHENTICATION'];
    $payload = [];
    $payload['grant_type'] = "password";
    $payload['client_id'] = "Vno403_wX-gdD5_3rPI8jU-yayfYExS4d59QrBxol5E";
    $payload['scope'] = "mss";
    // TODO verifier si il y a aura un compte pour SAPA ou alors s'il y aura un compte pour chaque MSS
    $payload['username'] = $_ENV['THALAMUS_USERNAME'];
    $payload['password'] = $_ENV['THALAMUS_PASSWORD'];
    $payload['client_secret'] = "mIbty4-sugvap-ciqdix";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
    }
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
} catch (Exception $e) {
    $error = $e->getMessage();
} finally {
    curl_close($ch);
}

if (!$response || $http_code != 200) {
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access the thalamus api',
        [
            'response' => $response,
            'data' => json_encode($input_data),
            'line' => __LINE__
        ]
    );

    // set response code - 500 Internal Server Error
    http_response_code(500);
    echo json_encode([
        "error" => $error,
        "http_code" => $http_code,
        "message" => "Une erreur inconnue s'est produite."
    ]);
    die();
}


// L'appel à l'API thalamus s'est effectué correctement
$thalamus_response = json_decode($response, true);

$token_type = $thalamus_response['token_type'];
$access_token = $thalamus_response['access_token'];
$refresh_token = $thalamus_response['refresh_token'];

////////////////////////////////////////////////////
/// Envoie des données mss
////////////////////////////////////////////////////
$response = false;
$error = "";
$http_code = -1;

$ch = curl_init();
try {
    $url = $_ENV['THALAMUS_URL_IMPORT_MSS'];
    $payload = [];

//    $session = [
//        'role_user_ids' => ['2'],
//        'est_coordinateur_peps' => true,
//        'id_structure' => '1',
//        'id_territoire' => '1',
//        'id_statut_structure' => '2',
//    ];

    // récupération des données 
    $export = new Export($bdd);
    $patients = $export->readOnapsDataForThalamus($_SESSION, $input_data["year"] ?? null);

    $payload['data'] = [
        'type' => 'node--mss_document',
        'lines' => $patients, // un tableau contenant un tableau pour chaque ligne à insérer
    ];


    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/vnd.api+json",
        "Accept: application/vnd.api+json",
        "Authorization: " . $token_type . " " . $access_token
    ]);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
    }
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
} catch (Exception $e) {
    $error = $e->getMessage();
} finally {
    curl_close($ch);
}

if (!$response || ($http_code != 200 && $http_code != 201)) {
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access the thalamus api',
        [
            'response' => $response,
            'data' => json_encode($input_data),
            'line' => __LINE__
        ]
    );

    // set response code - 500 Internal Server Error
    http_response_code(500);
    echo json_encode([
        "error" => $error,
        "http_code" => $http_code,
        "response" => json_decode($response),
        "message" => "Une erreur inconnue s'est produite."
    ]);
    die();
}

// set response code - 200 ok
http_response_code(200);
echo json_encode([
    "message" => "ok"
]);
die();
