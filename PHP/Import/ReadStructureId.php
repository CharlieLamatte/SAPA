<?php

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$query = "SELECT id_api FROM structure";

$stmt = $bdd->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $id_structures= array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['id_api'] != null) {
            array_push($id_structures, $row['id_api']);
        }
    }

    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($id_structures);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "Pas de structures trouvées."));
}