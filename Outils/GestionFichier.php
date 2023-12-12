<?php

/**
 * Sauvegarde une image
 *
 * @param $image string l'image au format suivant: "data:image/png;base64,*" où * est l'image au format base64
 * @param $path string chemin du dossier au serra sauvegarder l'image
 * @param $filename string le nom du fichier sans l'extension
 * @return false|string The function returns the name of the file created (including the extension), or false on failure.
 */
function save_image_from_base64($image, $path, $filename) {
    $image_parts = explode(";base64,", $image);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_en_base64 = base64_decode($image_parts[1]);
    $file = $path . $filename . '.' . $image_type;

    $success = file_put_contents($file, $image_en_base64);
    if (!$success) {
        return false;
    }

    return $filename . '.' . $image_type;
}