<?php
/**
 *
 */

use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"), true);

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission("can_call_tls_ins")) {
    // set response code - 403 Forbidden
    http_response_code(403);
    echo json_encode(["message" => 'Forbidden']);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
        'User ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource without entitlement',
        [
            'event' => 'authz_fail:' . $_SESSION['email_connecte'],
        ]
    );
    die();
}

if ($input_data['type_appel'] == "find_ins") {
    $url = $_ENV['FIND_INS_URL'];
} else {
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(["message" => "Les données sont incomplètes."]);

    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'User ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource using invalid data',
        ['data' => json_encode($input_data)]
    );
    die();
}

$response = false;
$error = "";
$http_code = -1;

$ch = curl_init();
try {
    $p = new Patient($bdd);
    $patient = $p->readOne($input_data['id_patient']);

    $payload = [];
    $payload['prenom'] = $patient['premier_prenom_naissance'];
    $payload['nomNaissance'] = $patient['nom_naissance'];
    $payload['sexe'] = $patient['sexe_patient'];
    $payload['dateNaissance'] = $patient['date_naissance'];

    if (!empty($patient['liste_prenom_naissance'])) {
        $payload['listePrenom'] = explode(" ", $patient['liste_prenom_naissance']);
    }
    if (!empty($patient['code_insee_naissance'])) {
        $payload['lieuNaissance'] = $patient['code_insee_naissance'];
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Cache-Control: no-cache",
        "content-type:application/json;charset=utf-8"
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

if (!$response || $http_code != 200) {
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access the tls ins',
        [
            'response' => $response,
            'data' => json_encode($input_data),
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


// L'appel au TLS INS s'est effectué correctement
$ins_response = json_decode($response, true);

// s'il n'y a pas de réponse unique
if ($ins_response["compteRendu"]["codeCR"] !== "00") {
    $message = "Erreur: Le téléservice INSi n'est actuellement pas disponible"; // message par défaut
    if ($ins_response["compteRendu"]["codeCR"] === "01") {
        $message = "Erreur: L'identité du patient n'a pas été trouvée";
    } elseif ($ins_response["compteRendu"]["codeCR"] === "02") {
        $message = "Erreur: Plusieurs identités ont été trouvées";
    }

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode([
        "success" => false,
        "message" => $message
    ]);
    die();
}

$listePrenomArray = is_array($ins_response["individu"]["traitsIdentite"]["listePrenom"]) ? $ins_response["individu"]["traitsIdentite"]["listePrenom"] : [];
$listePrenomString = implode(" ", $listePrenomArray);

$update_ok = $p->updateInsData([
    'id_patient' => $input_data['id_patient'],
    'nom_naissance' => $ins_response["individu"]["traitsIdentite"]["nomNaissance"] ?? $patient['nom_naissance'],
    'premier_prenom_naissance' => $ins_response["individu"]["traitsIdentite"]["prenom"] ?? $patient['premier_prenom_naissance'],
    'sexe_patient' => $ins_response["individu"]["traitsIdentite"]["sexe"] ?? $patient['sexe_patient'],
    'date_naissance' => $ins_response["individu"]["traitsIdentite"]["dateNaissance"] ?? $patient['date_naissance'],

    'liste_prenom_naissance' => $listePrenomString,
    'code_insee_naissance' => $ins_response["individu"]["traitsIdentite"]["lieuNaissance"] ?? null,
    'matricule_ins' => $ins_response["individu"]["insActif"]["matricule"]["numIdentifiant"],
    'oid' => $ins_response["individu"]["insActif"]["oid"],
    'historique' => $ins_response["individu"]["insHistorique"],
    'cle' => $ins_response["individu"]["insActif"]["matricule"]["cle"],
]);

if (!$update_ok) {
    // set response code - 500 Internal Server Error
    http_response_code(500);
    echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
        [
            'error_message' => $p->getErrorMessage(),
            'data' => json_encode([
                'input_data' => $input_data,
                'ins_response' => $ins_response,
            ]),
        ]
    );
    die();
}

// set response code - 200 OK
http_response_code(200);
echo json_encode([
    "success" => true,
    "message" => "L'identité du bénéficiaire a été récupérée avec succès.",
    "patient" => $p->readOne($input_data['id_patient'])
]);
