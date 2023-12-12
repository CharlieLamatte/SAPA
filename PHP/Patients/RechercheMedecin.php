<?php

require '../../bootstrap/bootstrap.php';
require '../../Outils/JsonFileProtection.php';

$query = $bdd->prepare('SELECT nom_coordonnees,prenom_coordonnees,tel_fixe_coordonnees,mail_coordonnees,nom_specialite_medecin,id_medecin,nom_adresse,complement_adresse,nom_ville,code_postal 
FROM coordonnees 
JOIN medecins USING (id_medecin) 
JOIN specialite_medecin USING (id_specialite_medecin)
JOIN siege using (id_medecin) 
JOIN adresse USING (id_adresse)
JOIN se_localise_a using (id_adresse) 
JOIN villes using (id_ville)');

$query->execute();
$resultats = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    array_push($resultats, $row['nom_coordonnees'] . ' - ' . $row['prenom_coordonnees'] . ' - ' . $row['tel_fixe_coordonnees'] . ' - ' . $row['mail_coordonnees'] . ' - ' . $row['nom_specialite_medecin'] . ' - ' . $row['id_medecin'] . ' - ' . $row['nom_adresse'] . ' - ' . $row['complement_adresse'] . ' - ' . $row['nom_ville'] . ' - ' . $row['code_postal']);
}
echo json_encode($resultats);