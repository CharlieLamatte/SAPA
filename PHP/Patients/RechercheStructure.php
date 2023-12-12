<?php

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$query = $bdd->prepare('SELECT nom_structure, complement_adresse, nom_adresse, code_postal, nom_ville FROM structure JOIN se_situe_a USING(id_structure) JOIN adresse USING(id_adresse) JOIN se_localise_a USING(id_adresse) JOIN villes USING(id_ville) WHERE id_territoire= ?');
$query->execute(array($_SESSION['id_territoire']));
$resultats = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    array_push($resultats, $row['nom_structure'] . ' - ' . $row['complement_adresse'] . ' - ' . $row['nom_adresse'] . ' - ' . $row['code_postal'] . ' - ' . $row['nom_ville']);
}
echo json_encode($resultats);