<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_prescription')) {
    erreur_permission();
}

$idPatient = $_GET['idPatient'];
$idPrescription = $_GET['idPrescription'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Modification prescription</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

    <!--Fonction java-->
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/commun.js"></script>
    <script type="text/javascript" src="../../js/functions.js"></script>
</head>

<body onbeforeunload="return confirm()">
<!-- The toast -->
<div id="toast"></div>

<?php
require '../header.php'; ?>

<!-- Script permettant l'affichage d'un message d'erreur pour le fichier -->
<script>
    $(document).on("submit", "form", function (event) {
        window.onbeforeunload = null;
    });

    function formulaire_visible(elem) {
        etat = document.getElementById(elem).style.display;
        if (etat == "none") {
            document.getElementById(elem).style.display = "block";
        } else {
            document.getElementById(elem).style.display
        }
    }

    function formulaire_cache(elem) {
        etat = document.getElementById(elem).style.display;
        if (etat == "block") {
            document.getElementById(elem).style.display = "none";
        } else {
            document.getElementById(elem).style.display
        }
    }

    function verif_fichier() {
        let prescriptionMedecin = document.getElementById("prescriptionMedecin").value;
        let extensions_possibles = ['png', 'jpg', 'jpeg', 'pdf', 'PNG', 'JPG', 'JPEG', 'PDF'];
        let extension_fichier = prescriptionMedecin.slice((prescriptionMedecin.lastIndexOf('.') - 1 >>> 0) + 2);
        let taille_max = 20; // taille max en Mo

        // s'il y a un fichier
        if (document.getElementById('prescriptionMedecin').files[0]) {
            let taille_fichier = document.getElementById('prescriptionMedecin').files[0].size;
            let sizeInMB = (taille_fichier / (1024 * 1024)).toFixed(2);

            if (extensions_possibles.includes(extension_fichier)) {
                if (sizeInMB > taille_max) {
                    alert("Le fichier est trop lourd (la taille maximum autorisée est 20 Mo)");
                    return false;
                }

                return true;
            } else {
                alert("Le type de fichier est invalide (les types autorisées sont: .png, .jpg, .jpeg et .pdf)");
                return false;
            }
        }

        return true;
    }
</script>

<!----- Affichage du formulaire avec les champs préremplis ----->
<div class="panel-body">
    <center>
        <legend style="color:black">
            <a href="Prescription.php?idPatient=<?php
            echo $idPatient ?>" style="color: black; margin-right: 50px;"
               class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-left"></span></a>Retour
        </legend>
        <br>
    </center>
    <?php
    $query = $bdd->prepare(
        'SELECT * FROM prescription WHERE id_patient = :idPatient AND id_prescription = :idPrescription ORDER BY prescription_date DESC'
    );
    $query->bindValue(':idPatient', $idPatient, PDO::PARAM_STR);
    $query->bindValue(':idPrescription', $idPrescription, PDO::PARAM_STR);
    $query->execute();
    while ($data = $query->fetch()) {
        $idPrescription = $data['id_prescription'];
        $prescriptionAp = $data['prescription_ap'];
        $prescriptionMedecin = $data['prescription_medecin'];
        $prescriptionDate = $data['prescription_date'];
        $fcMax = $data['fc_max'];
        $remarque = $data['remarque'];
        $actAPrivilegier = $data['act_a_privilegier'] ?? "";
        $intensiteRecommandee = $data['intensite_recommandee'] ?? "";
        $effortsNon = $data['efforts_non'] ?? "";
        $articulationNon = $data['articulation_non'] ?? "";
        $actionNon = $data['action_non'] ?? "";
        $arretSi = $data['arret_si'] ?? "";
    }
    echo '<form id="" class="form-horizontal" method="POST" action="PrescriptionModifTraitement.php?idPatient=' . $idPatient . '&amp;idPrescription=' . $idPrescription . '" enctype="multipart/form-data" onsubmit="return verif_fichier()">'
    ?>
    <fieldset style="border:2px solid #ff751a; border-radius:2%;">
        <legend style="background-color:#ff751a; text-align:center; width:50%">Prescription</legend>
        <br>
        <table style="margin-left:100px;">
            <tr>
                <td>
                    <div class="form-group">
                        <label for="prescriptionAp">Prescription d'activité physique :</label>
                        <?php
                        if ($prescriptionAp == "Oui") {
                            echo('<input type="radio" id="prescriptionAp" name="prescriptionAp" value="Oui" onclick="formulaire_visible(\'zone_fichier\')" checked> Oui');
                            echo('<input type="radio" id="prescriptionAp" name="prescriptionAp" value="Non" onclick="formulaire_cache(\'zone_fichier\')"> Non<br>');
                        } else {
                            echo('<input type="radio" id="prescriptionAp" name="prescriptionAp" value="Oui" onclick="formulaire_visible(\'zone_fichier\')"> Oui');
                            echo('<input type="radio" id="prescriptionAp" name="prescriptionAp" value="Non" onclick="formulaire_cache(\'zone_fichier\')" checked> Non<br>');
                        }
                        echo('<div id="zone_fichier" name="zone_fichier" style="display:none">');
                        if ($prescriptionAp == "Oui") {
                            if ($prescriptionMedecin != null) {
                                // Prescription + fichier -> Affichage puis proposition de le remplacer
                                echo('<a id="lien_fichier" href="../../Outils/DownloadPrescription.php?filename=' . $prescriptionMedecin . '" onclick="window.open(this.href); return false;" class="btn btn-primary">Consulter le fichier joint</a><br>'); // Ouverture du fichier dans un nouvel onglet
                                echo('<label for="prescriptionMedecin" style="color:#E1AF5D; font-style:italic">>> Remplacer le document déjà joint</label>');
                                echo('<input type="file" id="prescriptionMedecin" name="prescriptionMedecin" accept=".png, .jpg, .jpeg, .pdf">');
                            } else {
                                // Prescription mais pas de fichier -> Proposition d'ajout de fichier
                                echo('<label for="prescriptionMedecin" style="color:#E1AF5D; font-style:italic">>> Joindre un document</label>');
                                echo('<input type="file" id="prescriptionMedecin" name="prescriptionMedecin" accept=".png, .jpg, .jpeg, .pdf">');
                            }
                        } else {
                            // Pas de prescription
                            echo('<label for="prescriptionMedecin" style="color:#E1AF5D; font-style:italic">>> Possibilité de joindre un document</label>');
                            echo('<input type="file" id="prescriptionMedecin" name="prescriptionMedecin" accept=".png, .jpg, .jpeg, .pdf">');
                        }
                        ?>
                    </div>
</div>
</td>
<td></td>
<td>
    <div class="form-group">
        <label for="prescriptionDate">Date de la prescription :</label><br>
        <?php
        // Ordonnance valable 1 an, donc limite sur la date (entre aujourd'hui et il y a pile 1 an)
        $dateJour = date("Y-m-d");
        $dateJour1an = date('Y-m-d', strtotime($dateJour . '-1 year'));
        echo('<input type="date" id="prescriptionDate" name="prescriptionDate" class="form-control input-md" style="width:150px;" value="' . $prescriptionDate . '" max="' . $dateJour . '" required>');
        ?>
    </div>
</td>
</tr>
<tr>
    <td>
        <div class="form-group">
            <label for="actAPrivilegier">Type(s) d'activité(s) à privilégier :</label><br>
            <?php
            if (isset($actAPrivilegier)) {
                $actAPrivilegier = explode(', ', $actAPrivilegier);
            }
            // -> Retourne un tableau des valeurs cochées à l'enregistrement -> Formulaire :
            echo('<input type="checkbox" id="actAPrivilegier" name="actAPrivilegier[]" value="Endurance cardio-respiratoire"');
            if (in_array("Endurance cardio-respiratoire", $actAPrivilegier)) {
                echo('checked="checked"');
            }
            echo('> Endurance cardio-respiratoire<br>');
            echo('<input type="checkbox" id="actAPrivilegier" name="actAPrivilegier[]" value="Renforcement musculaire"');
            if (in_array("Renforcement musculaire", $actAPrivilegier)) {
                echo('checked="checked"');
            }
            echo('> Renforcement musculaire<br>');
            echo('<input type="checkbox" id="actAPrivilegier" name="actAPrivilegier[]" value="Souplesse"');
            if (in_array("Souplesse", $actAPrivilegier)) {
                echo('checked="checked"');
            }
            echo('> Souplesse<br>');
            echo('<input type="checkbox" id="actAPrivilegier" name="actAPrivilegier[]" value="Aptitudes neuromotrices"');
            if (in_array("Aptitudes neuromotrices", $actAPrivilegier)) {
                echo('checked="checked"');
            }
            echo('> Aptitudes neuromotrices<br>');
            echo('<input type="checkbox" id="actAPrivilegier" name="actAPrivilegier[]" value="Autres"');
            if (in_array("Autres", $actAPrivilegier)) {
                echo('checked="checked"');
            }
            echo('> Autres');
            ?>
        </div>
    </td>
    <td>
        <div class="form-group">
            <label for="intensiteRecommandee">Intensité(s) recommandée(s) :</label><br>
            <?php
            if (isset($intensiteRecommandee)) {
                $intensiteRecommandee = explode(', ', $intensiteRecommandee);
            }
            echo('<input type="checkbox" id="intensiteRecommandee" name="intensiteRecommandee[]" value="Légère"');
            if (in_array("Légère", $intensiteRecommandee)) {
                echo('checked="checked"');
            }
            echo('> Légère<br>');
            echo('<input type="checkbox" id="intensiteRecommandee" name="intensiteRecommandee[]" value="Modérée"');
            if (in_array("Modérée", $intensiteRecommandee)) {
                echo('checked="checked"');
            }
            echo('> Modérée<br>');
            echo('<input type="checkbox" id="intensiteRecommandee" name="intensiteRecommandee[]" value="Elevée"');
            if (in_array("Elevée", $intensiteRecommandee)) {
                echo('checked="checked"');
            }
            echo('> Elevée');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td>
        <div class="form-group">
            <label for="effortsNon">Effort(s) à ne pas réaliser :</label><br>
            <?php
            if (isset($effortsNon)) {
                $effortsNon = explode(', ', $effortsNon);
            }
            // -> Retourne un tableau des valeurs cochées à l'enregistrement -> Formulaire :
            echo('<input type="checkbox" id="effortsNon" name="effortsNon[]" value="Endurance"');
            if (in_array("Endurance", $effortsNon)) {
                echo('checked="checked"');
            }
            echo('> Endurance<br>');
            echo('<input type="checkbox" id="effortsNon" name="effortsNon[]" value="Vitesse"');
            if (in_array("Vitesse", $effortsNon)) {
                echo('checked="checked"');
            }
            echo('> Vitesse<br>');
            echo('<input type="checkbox" id="effortsNon" name="effortsNon[]" value="Résistance"');
            if (in_array("Résistance", $effortsNon)) {
                echo('checked="checked"');
            }
            echo('> Résistance<br>');
            ?>
        </div>
    </td>
    <td>
        <div class="form-group">
            <label for="fcMax">Fréquence cardiaque à ne pas dépasser (bpm) :</label><br>
            <?php
            if ($fcMax != null) {
                echo(' <input type="number" id="fcMax" name="fcMax" class="form-control input-md" style="width:70%;" value="' . $fcMax . '" min="0" max="250" step="1"> ');
            } else {
                echo(' <input type="number" id="fcMax" name="fcMax" class="form-control input-md" style="width:70%;" min="0" max="250" step="1"> ');
            }
            ?>
        </div>
    </td>
</tr>
<tr>
    <td>
        <div class="form-group">
            <label for="articulationNon">Articulation(s) à ne pas solliciter :</label><br>
            <?php
            if (isset($articulationNon)) {
                $articulationNon = explode(', ', $articulationNon);
            }
            // -> Retourne un tableau des valeurs cochées à l'enregistrement -> Formulaire :
            echo('<input type="checkbox" id="articulationNon" name="articulationNon[]" value="Rachis"');
            if (in_array("Rachis", $articulationNon)) {
                echo('checked="checked"');
            }
            echo('> Rachis<br>');
            echo('<input type="checkbox" id="articulationNon" name="articulationNon[]" value="Genou"');
            if (in_array("Genou", $articulationNon)) {
                echo('checked="checked"');
            }
            echo('> Genou<br>');
            echo('<input type="checkbox" id="articulationNon" name="articulationNon[]" value="Epaule"');
            if (in_array("Epaule", $articulationNon)) {
                echo('checked="checked"');
            }
            echo('> Epaule<br>');
            echo('<input type="checkbox" id="articulationNon" name="articulationNon[]" value="Cheville"');
            if (in_array("Cheville", $articulationNon)) {
                echo('checked="checked"');
            }
            echo('> Cheville<br>');
            echo('<input type="checkbox" id="articulationNon" name="articulationNon[]" value="Hanche"');
            if (in_array("Hanche", $articulationNon)) {
                echo('checked="checked"');
            }
            echo('> Hanche<br>');
            ?>
        </div>
    </td>
    <td>
        <div class="form-group">
            <label for="actionNon">Action(s) à ne pas réaliser :</label><br>
            <?php
            if (isset($actionNon)) {
                $actionNon = explode(', ', $actionNon);
            }
            // -> Retourne un tableau des valeurs cochées à l'enregistrement -> Formulaire :
            echo('<input type="checkbox" id="actionNon" name="actionNon[]" value="Courir"');
            if (in_array("Courir", $actionNon)) {
                echo('checked="checked"');
            }
            echo('> Courir<br>');
            echo('<input type="checkbox" id="actionNon" name="actionNon[]" value="Sauter"');
            if (in_array("Sauter", $actionNon)) {
                echo('checked="checked"');
            }
            echo('> Sauter<br>');
            echo('<input type="checkbox" id="actionNon" name="actionNon[]" value="Marcher"');
            if (in_array("Marcher", $actionNon)) {
                echo('checked="checked"');
            }
            echo('> Marcher<br>');
            echo('<input type="checkbox" id="actionNon" name="actionNon[]" value="Porter"');
            if (in_array("Porter", $actionNon)) {
                echo('checked="checked"');
            }
            echo('> Porter<br>');
            echo('<input type="checkbox" id="actionNon" name="actionNon[]" value="Pousser"');
            if (in_array("Pousser", $actionNon)) {
                echo('checked="checked"');
            }
            echo('> Pousser<br>');
            echo('<input type="checkbox" id="actionNon" name="actionNon[]" value="Tirer"');
            if (in_array("Tirer", $actionNon)) {
                echo('checked="checked"');
            }
            echo('> Tirer<br>');
            echo('<input type="checkbox" id="actionNon" name="actionNon[]" value="S\'allonger sur le sol"');
            if (in_array("S'allonger sur le sol", $actionNon)) {
                echo('checked="checked"');
            }
            echo('> S\'allonger sur le sol<br>');
            echo('<input type="checkbox" id="actionNon" name="actionNon[]" value="Se relever du sol"');
            if (in_array("Se relever du sol", $actionNon)) {
                echo('checked="checked"');
            }
            echo('> Se relever du sol<br>');
            echo('<input type="checkbox" id="actionNon" name="actionNon[]" value="Mettre la tête en arrière"');
            if (in_array("Mettre la tête en arrière", $actionNon)) {
                echo('checked="checked"');
            }
            echo('> Mettre la tête en arrière<br>');
            ?>
        </div>
    </td>
    <td>
        <div class="form-group">
            <label for="arretSi">Arrêt en cas de :</label><br>
            <?php
            if (isset($arretSi)) {
                $arretSi = explode(', ', $arretSi);
            }
            // -> Retourne un tableau des valeurs cochées à l'enregistrement -> Formulaire :
            echo('<input type="checkbox" id="arretSi" name="arretSi[]" value="Fatigue"');
            if (in_array("Fatigue", $arretSi)) {
                echo('checked="checked"');
            }
            echo('> Fatigue<br>');
            echo('<input type="checkbox" id="arretSi" name="arretSi[]" value="Douleur"');
            if (in_array("Douleur", $arretSi)) {
                echo('checked="checked"');
            }
            echo('> Douleur<br>');
            echo('<input type="checkbox" id="arretSi" name="arretSi[]" value="Essoufflement"');
            if (in_array("Essoufflement", $arretSi)) {
                echo('checked="checked"');
            }
            echo('> Essoufflement<br>');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td>
        <div class="form-group">
            <label for="remarque">Autre :</label><br>
            <?php
            if ($remarque != "") {
                echo('<textarea rows="6" cols="80" maxlength="1500" id="remarque" name="remarque" style="resize:none;" class="form-control input-md" value="">' . $remarque . '</textarea>');
            } else {
                echo('<textarea rows="6" cols="80" maxlength="1500" id="remarque" name="remarque" style="resize:none;" class="form-control input-md"></textarea>');
            }
            ?>
        </div>
    </td>
</tr>
</table>
<center>
    <input type="submit" name="enregistrer" value="Enregistrer" class="btn btn-success btn-xs"></center>
<br><br>
</fieldset>
</form>
</div>

<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>