<?php
/**
 * Script qui permet de crypter les fichiers des patients
 * (remplace les fichiers non cryptés par une version cryptée)
 */

use Sportsante86\Sapa\Outils\EncryptionManager;

try {
    $root = dirname(__FILE__, 2);
    require $root . '/bootstrap/bootstrap.php';

    $files_to_encrypt = glob($root . "/uploads/prescriptions/prescription_*.*");
    $files_to_encrypt_count = count($files_to_encrypt);

    foreach ($files_to_encrypt as $file) {
        // rename unencrypted file
        rename($file, $file . "_temp");
        // encrypt file
        EncryptionManager::encrypt_file($file . "_temp", $file);
        // remove unencrypted file
        unlink($file . "_temp");
    }

    echo '<html lang="fr">';;
    echo "Nombre de fichiers à crypter = " . ($files_to_encrypt_count) . "<br>";;
    echo "Script exécuté avec succès<br>";
} catch (Exception $e) {
    echo '<html lang="fr">';;
    echo "Une erreur s'est produite cause:" . $e->getMessage() . ' line' . $e->getLine();
}
?>
</html>
