<?php
/**
 * Traitement du formulaire d'ajout d'une prescription
 */

use Sportsante86\Sapa\Outils\EncryptionManager;

require '../../bootstrap/bootstrap.php';

force_connected();

$idPatient = $_GET['idPatient']; // Récupération idPatient

if (isset($_POST['enregistrer'])) {
    // Permet d'éviter que l'insertion ne se fasse pas dans le cas où on ne rentre aucune FcMax
    if ($_POST["fcMax"] == "") {
        $_POST["fcMax"] = null;
    }

    // Récupération des cases cochées, pour chaque checkbox
    if (isset($_POST['actAPrivilegier'])) {
        $actAPrivilegierComplet = implode(', ', $_POST['actAPrivilegier']);
    }
    if (isset($_POST['intensiteRecommandee'])) {
        $intensiteRecommandeeComplet = implode(', ', $_POST['intensiteRecommandee']);
    }
    if (isset($_POST['effortsNon'])) {
        $effortsNonComplet = implode(', ', $_POST['effortsNon']);
    }
    if (isset($_POST['articulationNon'])) {
        $articulationNonComplet = implode(', ', $_POST['articulationNon']);
    }
    if (isset($_POST['actionNon'])) {
        $actionNonComplet = implode(', ', $_POST['actionNon']);
    }
    if (isset($_POST['arretSi'])) {
        $arretSiComplet = implode(', ', $_POST['arretSi']);
    }

    // Upload du fichier
    if ($_FILES['prescriptionMedecin']['error'] != UPLOAD_ERR_NO_FILE) {
        $dossier = $root . '/uploads/prescriptions/';
        $extension = strrchr($_FILES['prescriptionMedecin']['name'], '.'); // Récupération de l'extension
        $filename = "prescription_" . $idPatient . "_" . date("YmdHis") . $extension; // Renommage du fichier

        $encrypted_file_path = $root . "/uploads/prescriptions/" . $filename;
        $unencrypted_file_path = $root . "/temp/" . $filename . "_temp";

        move_uploaded_file(
            $_FILES['prescriptionMedecin']['tmp_name'],
            $unencrypted_file_path
        ); // enregistrement du fichier non crypté
        EncryptionManager::encrypt_file($unencrypted_file_path, $encrypted_file_path);
        unlink($unencrypted_file_path); // suppression du fichier crypté temp

        \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
            'User ' . $_SESSION['email_connecte'] . ' uploaded the file ' . $filename,
            ['event' => 'upload_complete:' . $_SESSION['email_connecte'] . ',' . $filename]
        );
    }

    // Insertion dans la BDD
    $data = [
        'idPatient' => $idPatient,
        'prescriptionAp' => $_POST["prescriptionAp"],
        'prescriptionMedecin' => $filename ?? null,
        'prescriptionDate' => $_POST["prescriptionDate"],
        'fcMax' => $_POST["fcMax"],
        'remarque' => htmlspecialchars($_POST["remarque"]),
        'actAPrivilegier' => $actAPrivilegierComplet ?? null,
        'intensiteRecommandee' => $intensiteRecommandeeComplet ?? null,
        'effortsNon' => $effortsNonComplet ?? null,
        'articulationNon' => $articulationNonComplet ?? null,
        'actionNon' => $actionNonComplet ?? null,
        'arretSi' => $arretSiComplet ?? null,
    ];
    $req = "INSERT INTO prescription (id_patient, prescription_ap, prescription_medecin, prescription_date, fc_max, remarque, act_a_privilegier, intensite_recommandee, efforts_non, articulation_non, action_non, arret_si) VALUES (:idPatient, :prescriptionAp, :prescriptionMedecin, :prescriptionDate, :fcMax, :remarque, :actAPrivilegier, :intensiteRecommandee, :effortsNon, :articulationNon, :actionNon, :arretSi)";
    $requete = $bdd->prepare($req);
    $requete->execute($data);

    header("location: Prescription.php?idPatient=$idPatient"); // Redirection
}