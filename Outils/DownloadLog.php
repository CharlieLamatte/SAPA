<?php

/**
 * Ce fichier permet de télécharger un fichier de log si l'utilisateur connecté a la permission 'can_view_page_logs'
 */

use Sportsante86\Sapa\Outils\Permissions;

require '../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_logs')) {
    erreur_permission();
}

if (empty($_GET['filename'])) {
    erreur_file_not_found(null);
} else {
    $filename = $_GET['filename'];
    $path = "../logs/";
    $complete_path = $path . $filename;
    if (!file_exists($complete_path)) {
        erreur_file_not_found($_GET['filename']);
    }
    $mime_type = mime_content_type($complete_path);

    header('Content-Description: File Transfer');
    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: attachment; filename="' . basename($complete_path) . '"');
    header('Cache-Control: public, max-age=604800, must-revalidate');
    header('Content-Length: ' . filesize($complete_path));
    readfile($complete_path);

    \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
        'User ' . $_SESSION['email_connecte'] . ' downloaded the file ' . $filename,
        ['event' => 'download_complete:' . $_SESSION['email_connecte'] . ',' . $filename]
    );
}