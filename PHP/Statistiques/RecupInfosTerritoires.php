<?php

use Sportsante86\Sapa\Model\StatistiquesTerritoire;

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$stat = new StatistiquesTerritoire($bdd);
$stats = $stat->getNombreEntitites($_SESSION);

// set response code - 200 OK
http_response_code(200);
echo json_encode($stats);