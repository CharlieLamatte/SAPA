<?php
/**
 * Script qui permet de générer une clé
 */

use Sportsante86\Sapa\Outils\EncryptionManager;

$root = dirname(__FILE__, 2);

include $root . '/bootstrap/bootstrap.php';

$key = EncryptionManager::generate_key();
if (!$key) {
    die("Une erreur inconnue s'est produite");
}

echo $key;