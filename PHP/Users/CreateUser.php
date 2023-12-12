<?php

use Sportsante86\Sapa\Model\User;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->nom_user) &&
    !empty($input_data->prenom_user) &&
    !empty($input_data->role_user_ids) &&
    !empty($input_data->email_user) &&
    !empty($input_data->id_territoire) &&
    !empty($input_data->mdp)) {
    $user = new User($bdd);
    $id_user = $user->create([
        'nom_user' => $input_data->nom_user,
        'prenom_user' => $input_data->prenom_user,
        'email_user' => $input_data->email_user,
        'id_territoire' => $input_data->id_territoire,
        'id_structure' => $input_data->structure->id_structure,
        'role_user_ids' => $input_data->role_user_ids,
        'mdp' => $input_data->mdp,
        'tel_f_user' => $input_data->tel_f_user,
        'tel_p_user' => $input_data->tel_p_user,

        'est_coordinateur_peps' => $input_data->est_coordinateur_peps,

        'id_intervenant' => $input_data->id_intervenant,
        'id_statut_intervenant' => $input_data->id_statut_intervenant,
        'diplomes' => $input_data->diplomes,
        'numero_carte' => $input_data->numero_carte,

        'nom_fonction' => $input_data->nom_fonction,
    ]);

    if ($id_user) {
        $item = $user->readOne($id_user);

        \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
            'User ' . $_SESSION['email_connecte'] . ' created user ' . $item['email_user'] . ' successfully (role '. $item['role_user']. ')',
            ['event' => 'create:user']
        );

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
                'error_message' => $user->getErrorMessage(),
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