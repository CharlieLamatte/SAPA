<?php

use Sportsante86\Sapa\Model\JournalAcces;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_export_journal_activite')) {
    // set response code - 403 Forbidden
    http_response_code(403);
    echo json_encode(["message" => 'Forbidden']);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->critical(
        'User ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource without entitlement',
        [
            'event' => 'authz_fail:' . $_SESSION['email_connecte'] . ',' . 'journal_activite',
        ]
    );
    die();
}

$journal = new JournalAcces($bdd);
$activites = $journal->readAll();

if (is_array($activites)) {
    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($activites);
} else {
    // set response code - 500 Internal Server Error
    http_response_code(500);
    echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
    );
}