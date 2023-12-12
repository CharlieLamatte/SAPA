<?php

use Sportsante86\Sapa\Model\Seance;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_seance) &&
    !empty($input_data->date) &&
    !empty($input_data->heure_debut) &&
    !empty($input_data->heure_fin)) {
    $commentaire = $input_data->commentaire ?? null;

    $seance = new Seance($bdd);
    $update_ok = $seance->update([
        'id_seance' => $input_data->id_seance,
        'date' => $input_data->date,
        'heure_debut' => $input_data->heure_debut,
        'heure_fin' => $input_data->heure_fin,
        'commentaire' => $commentaire,
    ]);

    // on ne modifie pas la liste des participants si le paramètre n'est pas fournie
    $add_participants_ok = true;
    if (isset($input_data->participants)) {
        $add_participants_ok = false;
        if ($update_ok) {
            $add_participants_ok = $seance->updateParticipantsSeance([
                'id_seance' => $input_data->id_seance,
                'participants' => $input_data->participants,
            ]);
        }
    }

    if ($update_ok && $add_participants_ok) {
        $item = $seance->readOne($input_data->id_seance);

        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($item);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $seance->getErrorMessage(),
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