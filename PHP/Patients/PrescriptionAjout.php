<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);

$idPatient = $_GET['idPatient']; // Récupération idPatient
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ajout prescription</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">

    <!--Fonction java-->
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/commun.js"></script>
    <script type="text/javascript" src="../../js/functions.js"></script>
</head>

<body onbeforeunload="return confirm()">
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

<!----- Formulaire d'ajout d'une prescription par un coordinateur ----->
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
    echo '<form id="PrescriptionAjout" class="form-horizontal" method="POST" action="PrescriptionAjoutTraitement.php?idPatient=' . $idPatient . '" enctype="multipart/form-data" onsubmit="return verif_fichier()">'
    ?>
    <fieldset style="border:2px solid #ff751a; border-radius:2%;">
        <legend style="background-color:#ff751a; text-align:center; width:50%">Prescription</legend>
        <br>
        <table style="margin-left:100px;">
            <tr>
                <td>
                    <div class="form-group">
                        <label for="prescriptionAp">Prescription d'activité physique :</label>
                        <input type="radio" id="prescriptionAp" name="prescriptionAp" value="Oui"
                               onclick="formulaire_visible('zone_fichier')"> Oui
                        <input type="radio" id="prescriptionAp" name="prescriptionAp" value="Non"
                               onclick="formulaire_cache('zone_fichier')" checked> Non<br>
                        <div id="zone_fichier" name="zone_fichier" style="display:none">
                            <label for="prescriptionMedecin" style="color:#E1AF5D; font-style:italic">>> Possibilité de
                                joindre un document</label>
                            <input type="file" id="prescriptionMedecin" name="prescriptionMedecin"
                                   accept=".png, .jpg, .jpeg, .pdf">
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
                        echo '<input type="date" id="prescriptionDate" name="prescriptionDate" class="form-control input-md" style="width:150px;" max="' . $dateJour . '" required>';
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <label for="actAPrivilegier">Type(s) d'activité(s) à privilégier :</label><br>
                        <input type="checkbox" id="actAPrivilegier" name="actAPrivilegier[]"
                               value="Endurance cardio-respiratoire"> Endurance cardio-respiratoire<br>
                        <input type="checkbox" id="actAPrivilegier" name="actAPrivilegier[]"
                               value="Renforcement musculaire"> Renforcement musculaire<br>
                        <input type="checkbox" id="actAPrivilegier" name="actAPrivilegier[]" value="Souplesse">
                        Souplesse<br>
                        <input type="checkbox" id="actAPrivilegier" name="actAPrivilegier[]"
                               value="Aptitudes neuromotrices"> Aptitudes neuromotrices<br>
                        <input type="checkbox" id="actAPrivilegier" name="actAPrivilegier[]" value="Autres"> Autres
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label for="intensiteRecommandee">Intensité(s) recommandée(s) :</label><br>
                        <input type="checkbox" id="intensiteRecommandee" name="intensiteRecommandee[]" value="Légère">
                        Légère<br>
                        <input type="checkbox" id="intensiteRecommandee" name="intensiteRecommandee[]" value="Modérée">
                        Modérée<br>
                        <input type="checkbox" id="intensiteRecommandee" name="intensiteRecommandee[]" value="Elevée">
                        Elevée
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <label for="effortsNon">Effort(s) à ne pas réaliser :</label><br>
                        <input type="checkbox" id="effortsNon" name="effortsNon[]" value="Endurance"> Endurance<br>
                        <input type="checkbox" id="effortsNon" name="effortsNon[]" value="Vitesse"> Vitesse<br>
                        <input type="checkbox" id="effortsNon" name="effortsNon[]" value="Résistance"> Résistance
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label for="fcMax">Fréquence cardiaque à ne pas dépasser (bpm):</label><br>
                        <input placeholder="30-250 " type="number" id="fcMax" name="fcMax" class="form-control input-md"
                               style="width:70%" min="30" max="250" step="1">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <label for="articulationNon">Articulation(s) à ne pas solliciter :</label><br>
                        <input type="checkbox" id="articulationNon" name="articulationNon[]" value="Rachis"> Rachis<br>
                        <input type="checkbox" id="articulationNon" name="articulationNon[]" value="Genou"> Genou<br>
                        <input type="checkbox" id="articulationNon" name="articulationNon[]" value="Epaule"> Epaule<br>
                        <input type="checkbox" id="articulationNon" name="articulationNon[]" value="Cheville">
                        Cheville<br>
                        <input type="checkbox" id="articulationNon" name="articulationNon[]" value="Hanche"> Hanche
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label for="actionNon">Action(s) à ne pas réaliser :</label><br>
                        <input type="checkbox" id="actionNon" name="actionNon[]" value="Courir"> Courir<br>
                        <input type="checkbox" id="actionNon" name="actionNon[]" value="Sauter"> Sauter<br>
                        <input type="checkbox" id="actionNon" name="actionNon[]" value="Marcher"> Marcher<br>
                        <input type="checkbox" id="actionNon" name="actionNon[]" value="Porter"> Porter<br>
                        <input type="checkbox" id="actionNon" name="actionNon[]" value="Pousser"> Pousser<br>
                        <input type="checkbox" id="actionNon" name="actionNon[]" value="Tirer"> Tirer<br>
                        <input type="checkbox" id="actionNon" name="actionNon[]" value="S'allonger sur le sol">
                        S'allonger sur le sol<br>
                        <input type="checkbox" id="actionNon" name="actionNon[]" value="Se relever du sol"> Se relever
                        du sol<br>
                        <input type="checkbox" id="actionNon" name="actionNon[]" value="Mettre la tête en arrière">
                        Mettre la tête en arrière
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <label for="arretSi">Arrêt en cas de :</label><br>
                        <input type="checkbox" id="arretSi" name="arretSi[]" value="Fatigue"> Fatigue<br>
                        <input type="checkbox" id="arretSi" name="arretSi[]" value="Douleur"> Douleur<br>
                        <input type="checkbox" id="arretSi" name="arretSi[]" value="Essoufflement"> Essoufflement
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <label for="remarque">Autre :</label><br>
                        <textarea rows="6" cols="80" id="remarque" name="remarque" style="resize:none;"
                                  class="form-control input-md" maxlength="1500"></textarea>
                    </div>
                </td>
            </tr>
        </table>
        <center><input type="submit" name="enregistrer" value="Enregistrer" class="btn btn-success btn-xs"></center>
        <br><br>
    </fieldset>
    </form>
</div>

<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>