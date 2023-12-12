<?php
/**
 * Script qui permet de décrypter les fichiers des patients
 * (remplace les fichiers cryptés par une version non cryptée)
 */

use Sportsante86\Sapa\Outils\EncryptionManager;

try {
    $root = dirname(__FILE__, 2);
    require $root . '/bootstrap/bootstrap.php';

    $files_to_encrypt = glob($root . "/uploads/prescriptions/prescription_*.*");
    $files_to_encrypt_count = count($files_to_encrypt);

    foreach ($files_to_encrypt as $file) {
        // rename encrypted file
        rename($file, $file . "_temp");
        // decrypt file
        EncryptionManager::decrypt_file($file . "_temp", $file);
        // remove encrypted file
        unlink($file . "_temp");
    }

    echo '<html lang="fr">';;
    echo "Nombre de fichiers à décrypter = " . ($files_to_encrypt_count) . "<br>";;
    echo "Script exécuté avec succès<br>";
} catch (Exception $e) {
    echo '<html lang="fr">';;
    echo "Une erreur s'est produite cause:" . $e->getMessage() . ' line' . $e->getLine();
}
?>
</html>
