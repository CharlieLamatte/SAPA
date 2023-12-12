<?php
/**
 * Traitement de la suppression d'une prescription
 */

use Sportsante86\Sapa\Outils\FilesManager;

require '../../bootstrap/bootstrap.php';

force_connected();

$idPatient = $_GET['idPatient']; // Récupération idPatient
$idPrescription = $_GET['idPrescription']; // Récupération idPrescription

// Suppression du fichier stocké dans le répertoire fichiersPatients
$query = $bdd->prepare("SELECT prescription_medecin FROM prescription WHERE id_prescription= :idPrescription");
$query->bindValue(':idPrescription', $idPrescription, PDO::PARAM_STR);
$query->execute();
while ($data = $query->fetch()) {
    $nomFichier = $data['prescription_medecin']; // Récupération du nom du fichier dans la bdd
}
if (!empty($nomFichier)) {
    FilesManager::delete_file($root . "/uploads/prescriptions/" . $nomFichier);
}

// MAJ BDD
$query = $bdd->prepare("DELETE FROM prescription WHERE id_prescription= :idPrescription");
$query->bindValue(':idPrescription', $idPrescription, PDO::PARAM_STR);
$query->execute();

header("location: Prescription.php?idPatient=$idPatient"); // Redirection
