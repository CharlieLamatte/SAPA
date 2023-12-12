<?php

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$query = $bdd->prepare('SELECT * from intervenants
    JOIN coordonnees USING (id_coordonnees)');
$query->execute();
$resultats = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    array_push($resultats, $row['nom_coordonnees'] . ' - ' . $row['id_intervenant']);
}
echo json_encode($resultats);