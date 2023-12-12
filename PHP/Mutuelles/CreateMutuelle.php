<?php

use Sportsante86\Sapa\Model\Mutuelle;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->nom) &&
    !empty($input_data->code_postal) &&
    !empty($input_data->nom_ville)) {
    $mutuelle = new Mutuelle($bdd);
    $id_mutuelle = $mutuelle->create([
        'nom' => $input_data->nom,
        'code_postal' => $input_data->code_postal,
        'nom_ville' => $input_data->nom_ville,

        'nom_adresse' => $input_data->nom_adresse,
        'tel_fixe' => $input_data->tel_fixe,
        'complement_adresse' => $input_data->complement_adresse,
        'email' => $input_data->mail,
        'tel_portable' => $input_data->tel_portable,
    ]);

    if ($id_mutuelle) {
        $item = $mutuelle->readOne($id_mutuelle);
        // set response code - 201 created
        http_response_code(201);
        echo json_encode($item);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $mutuelle->getErrorMessage(),
                'data' => json_encode($input_data),
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