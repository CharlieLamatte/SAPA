<?php

session_start();

$root = __DIR__ . '/..';

require $root . '/vendor/autoload.php';
require $root . '/BDD/functions.php';
require $root . '/BDD/connexion.php';
require $root . '/BDD/constants.php';

$dotenv = Dotenv\Dotenv::createImmutable($root);
$dotenv->load();
$dotenv->required([
    'ENVIRONNEMENT',
    'VERSION',
    'DATE',
    'KEY',
]);