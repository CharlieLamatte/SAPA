<?php

use Sportsante86\Sapa\Model\Notification;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_gestion_notifications_maj')) {
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

$input_data = json_decode(file_get_contents("php://input"));

if (!empty($input_data->id_notification) &&
    !empty($input_data->text_notification)) {
    $notification = new Notification($bdd);
    $update_ok = $notification->updateMaj([
        'id_notification' => $input_data->id_notification,
        'text_notification' => $input_data->text_notification,
    ]);

    if ($update_ok) {
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(["message" => "Ok"]);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $notification->getErrorMessage(),
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