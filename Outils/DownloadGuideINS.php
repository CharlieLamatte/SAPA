<?php

/**
 * Ce fichier permet de télécharger un guide INS si l'utilisateur est connecté
 */

require '../bootstrap/bootstrap.php';

force_connected();

if (empty($_GET['filename'])) {
    erreur_file_not_found(null);
} else {
    $filename = $_GET['filename'];
    $path = "../uploads/";
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
}