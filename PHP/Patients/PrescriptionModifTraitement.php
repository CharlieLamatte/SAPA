<?php
/**
 * Traitement du formulaire de modification d'une prescription
 */

use Sportsante86\Sapa\Outils\EncryptionManager;
use Sportsante86\Sapa\Outils\FilesManager;

require '../../bootstrap/bootstrap.php';

force_connected();

$idPatient = $_GET['idPatient']; // Récupération idPatient
$idPrescription = $_GET['idPrescription']; // Récupération idPrescription

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

    // Récupération du nom du fichier qui est dans la bdd et de la valeur du bouton radio (prescriptionAp)
    $query = $bdd->prepare("SELECT prescription_medecin FROM prescription WHERE id_prescription= :idPrescription");
    $query->bindValue(':idPrescription', $idPrescription, PDO::PARAM_STR);
    $query->execute();
    while ($data = $query->fetch()) {
        $nomFichierBDD = $data['prescription_medecin'];
    }
    $prescriptionAp = $_POST['prescriptionAp'];
    // Si radio = "Oui"
    if ($prescriptionAp == "Oui") {
        // Si un nouveau fichier est joint
        if ($_FILES['prescriptionMedecin']['error'] != UPLOAD_ERR_NO_FILE) {
            // Si déjà un fichier enregistré -> Suppression du fichier précédent
            if (!empty($nomFichierBDD)) {
                FilesManager::delete_file($root . "/uploads/prescriptions/" . $nomFichierBDD);
            }

            $extension = strrchr($_FILES['prescriptionMedecin']['name'], '.'); // Récupération de l'extension
            $filename = "prescription_" . $idPatient . "_" . date("YmdHis") . $extension; // Renommage du fichier

            $encrypted_file_path = $root . "/uploads/prescriptions/" . $filename;
            $unencrypted_file_path = $root . "/temp/" . $filename . "_temp";

            move_uploaded_file(
                $_FILES['prescriptionMedecin']['tmp_name'],
                $unencrypted_file_path
            ); // enregistrement du fichier non crypté dans dossier temo
            EncryptionManager::encrypt_file($unencrypted_file_path, $encrypted_file_path);
            unlink($unencrypted_file_path); // suppression fichier non crypté

            \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
                'User ' . $_SESSION['email_connecte'] . ' uploaded the file ' . $filename,
                ['event' => 'upload_complete:' . $_SESSION['email_connecte'] . ',' . $filename]
            );
        } else {
            $filename = $nomFichierBDD;
        }
        // Si radio = "Non"
    } else {
        // Si déjà un fichier enregistré -> Suppression du fichier précédent
        if (!empty($nomFichierBDD)) {
            FilesManager::delete_file($root . "/uploads/prescriptions/" . $nomFichierBDD);
        }
        $filename = null;
    }

    // MAJ BDD
    $data = [
        'prescriptionAp' => $prescriptionAp,
        'prescriptionMedecin' => $filename,
        'prescriptionDate' => $_POST["prescriptionDate"],
        'fcMax' => $_POST["fcMax"],
        'remarque' => htmlspecialchars($_POST["remarque"]),
        'actAPrivilegier' => $actAPrivilegierComplet ?? null,
        'intensiteRecommandee' => $intensiteRecommandeeComplet ?? null,
        'effortsNon' => $effortsNonComplet ?? null,
        'articulationNon' => $articulationNonComplet ?? null,
        'actionNon' => $actionNonComplet ?? null,
        'arretSi' => $arretSiComplet ?? null,
        'idPrescription' => $idPrescription
    ];
    $req = "UPDATE prescription SET prescription_ap= :prescriptionAp, prescription_medecin= :prescriptionMedecin, prescription_date= :prescriptionDate, fc_max= :fcMax, remarque= :remarque, act_a_privilegier= :actAPrivilegier, intensite_recommandee= :intensiteRecommandee, efforts_non= :effortsNon, articulation_non= :articulationNon, action_non= :actionNon, arret_si= :arretSi WHERE id_prescription= :idPrescription";
    $requete = $bdd->prepare($req);
    $requete->execute($data);

    header("location: Prescription.php?idPatient=$idPatient"); // Redirection
}
