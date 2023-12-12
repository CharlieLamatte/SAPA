<?php

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$query = $bdd->prepare('SELECT * from structure WHERE id_territoire= ?');
$query->execute(array($_SESSION['id_territoire']));
$resultats = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    array_push($resultats, $row['nom_structure'] . ' - ' . $row['id_structure']);
}
echo json_encode($resultats);