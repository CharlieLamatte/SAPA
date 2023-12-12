<?php

/**
 * Ce fichier permet de télécharger une synthèse si l'utilisateur est connecté
 */

use Sportsante86\Sapa\Outils\EncryptionManager;

require '../bootstrap/bootstrap.php';

force_connected();

if (empty($_GET['filename'])) {
    erreur_file_not_found(null);
} else {
    $filename = $_GET['filename'];
    $encrypted_file_path = $root . "/uploads/syntheses/" . $filename;
    $unencrypted_file_path = $root . "/temp/" . $filename;
    $mime_type = "application/octet-stream";

    if (!file_exists($encrypted_file_path)) {
        erreur_file_not_found($_POST['filename']);
    }

    EncryptionManager::decrypt_file($encrypted_file_path, $unencrypted_file_path);

    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename="' . basename($encrypted_file_path) . '"');
    header('Content-Type: ' . $mime_type);
    header('Content-Length: ' . filesize($unencrypted_file_path));

    readfile($unencrypted_file_path);
    unlink($unencrypted_file_path); // suppression du fichier décrypté temp

    \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
        'User ' . $_SESSION['email_connecte'] . ' downloaded the file ' . $filename,
        ['event' => 'download_complete:' . $_SESSION['email_connecte'] . ',' . $filename]
    );
}