<?php

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_patient)) {
    $id_patient = $input_data->id_patient;

    $stmt = $bdd->prepare(
        'select coordonnees.nom_coordonnees as nom, coordonnees.prenom_coordonnees as prenom
                            from patients join coordonnees ON coordonnees.id_coordonnees = patients.id_coordonnee where patients.id_patient = :id_patient'
    );
    $stmt->bindValue(':id_patient', $id_patient);
    $stmt->execute();
    $num_creneaux = $stmt->rowCount();

    if ($num_creneaux > 0) {
        $row = $stmt->fetch();
        $patient = array(
            "nom" => $row['nom'],
            "prenom" => $row['prenom']
        );

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($patient);
    } else {
        // set response code - 404 Not found
        http_response_code(404);
        echo json_encode(["message" => "Pas de patient trouvés."]);
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