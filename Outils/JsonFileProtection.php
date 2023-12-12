<?php

/**
 * Ce fichier permet de bloquer l'accès aux pages qui renvoient du json
 * aux utilisateurs non connectés
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");

if (!isset($_SESSION)) {
    session_start();
}
if (empty($_SESSION['is_connected'])) {
    // set response code - 403 Forbidden
    http_response_code(403);
    echo json_encode(["message" => "Vous ne pouvez pas accéder à cette page si vous n'êtes pas connecté"]);
    \Sportsante86\Sapa\Outils\SapaLogger::get()->critical('Not connected user attempted to access JSON data');
    die();
}