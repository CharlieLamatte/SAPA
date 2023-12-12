<?php

use Sportsante86\Sapa\Model\Prescription;
use Sportsante86\Sapa\Outils\Permissions;

use function Sportsante86\Sapa\Outils\format_date;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_prescription')) {
    erreur_permission();
}

$idPatient = $_GET['idPatient']; // Récupération idPatient

$prescription = new Prescription($bdd);
$prescriptions = $prescription->readAllPatient($idPatient);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Prescription</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

    <script type="text/javascript" src='../../js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>
<?php
require '../header.php'; ?>

<!----- Affichage de la/des prescription(s) si existe(nt) ----->
<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <?php
    foreach ($prescriptions as $p) {
        echo("<table id='table_prescription'>");
        echo("<tr>");
        echo("<td id='prescription_td_date'>");
        echo("Prescription du <br>" . format_date($p['prescription_date']) . "<br>");
        echo("</td>");
        echo("<td id='prescription_td_fichier'>");
        if ($p['prescription_ap'] == 'Oui') {
            if ($p['prescription_medecin'] != null) {
                echo '
                    <a class="btn btn-primary" href="../../Outils/DownloadPrescription.php?filename=' . $p['prescription_medecin'] . '" download="">Prescription du médecin</a>
                ';
            } else {
                echo("<i>Aucun fichier joint</i><br>");
            }
        } else {
            echo("Aucune prescription jointe<br>");
        }
        echo("</td>");
        echo("<td id='prescription_td_avis'>");
        if ($p['act_a_privilegier'] == !null) {
            echo("<b>Type(s) d'activité(s) à privilégier </b>: " . $p['act_a_privilegier'] . "<br>");
        }
        if ($p['intensite_recommandee'] == !null) {
            echo("<b>Intensité(s) recommandée(s) </b>: " . $p['intensite_recommandee'] . "<br>");
        }
        if ($p['efforts_non'] == !null) {
            echo("<b>Effort(s) à ne pas réaliser </b>: " . $p['efforts_non'] . "<br>");
        }
        if ($p['fc_max'] == !null) {
            echo("<b>Fréquence cardiaque à ne pas dépasser </b>: " . $p['fc_max'] . " bpm<br>");
        }
        if ($p['articulation_non'] == !null) {
            echo("<b>Articulation(s) à ne pas solliciter </b>: " . $p['articulation_non'] . "<br>");
        }
        if ($p['action_non'] == !null) {
            echo("<b>Action(s) à ne pas réaliser </b>: " . $p['action_non'] . "<br>");
        }
        if ($p['arret_si'] == !null) {
            echo("<b>Arrêt en cas de </b>: " . $p['arret_si'] . "<br>");
        }
        if ($p['remarque'] == !null) {
            echo("<b>Autre </b>: " . $p['remarque'] . "<br>");
        }
        echo("</td>");
        echo("<td id='prescription_td_boutons'>");
        echo("<a href='PrescriptionModif.php?idPatient=$idPatient&amp;idPrescription=" . ($p['id_prescription']) . "' name='Modifier' id='Modifier' class='btn btn-warning btn-sm'>Modifier</a><br><br>");
        echo("<a href='PrescriptionSuppressionTraitement.php?idPatient=$idPatient&amp;idPrescription=" . ($p['id_prescription']) . "' name='Supprimer' id='Supprimer' class='btn btn-danger btn-sm' onclick=\"return confirm('Voulez-vous vraiment supprimer cette prescription ?');\">Supprimer</a>");
        echo("</td>");
        echo("</tr>");
        echo("</table>");
    }
    echo("<center>");
    echo("<br><a href='PrescriptionAjout.php?idPatient=$idPatient' name='Ajout' id='Ajout' class='btn btn-success'>Nouvelle prescription</a>");
    echo("</center>");
    ?>
</div>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>