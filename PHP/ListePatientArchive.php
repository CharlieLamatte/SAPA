<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../bootstrap/bootstrap.php';

force_connected();

// permet de détecter que l'on est sur la page qui liste les patients archivés
const PAGE_PATIENTS_ARCHIVES = 'PAGE_PATIENTS_ARCHIVES';
$page = 'PAGE_PATIENTS_ARCHIVES';

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient')) {
    erreur_permission();
}

$idPatient = isset($_GET['id_patient']) ? $_GET['id_patient'] : null;
$id_structure = $_SESSION['id_structure'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bénéficiaires archivés</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/portfolio-item.css">
    <link rel="stylesheet" href="../css/design.css">
    <link rel="stylesheet" href="../css-peps-mobile/css-header.css">
    <link rel="stylesheet" href="../css-peps-mobile/liste.css">
    <link rel="stylesheet" href="../css/modal-details.css">
    <link rel="stylesheet" href="../css/portfolio-item.css">

    <script type="text/javascript" src="../js/storage.js"></script>
    <script type="text/javascript" src='../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../js/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/moment.min.js"></script>
    <script type="text/javascript" src="../js/datetime-moment.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap-multiselect.js"></script>

    <link rel="stylesheet" type="text/css" href="../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../js/DataTables/media/css/customTables.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-multiselect.css">
</head>

<body>
<?php
require 'header-accueil.php'; ?>

<div class="container" id="main-div" data-archive="tableau-beneficiaires-archives">
    <!-- The toast -->
    <div id="toast"></div>
    <br>
    <div id="ConteneurGauche" style="float: left; width : 100%;border: 3px #1E1B7A solid;">
        <center>
            <legend id="legendPatient" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                <center>Bénéficiaires archivés</center>
            </legend>
        </center>
        <br>
        <div style="text-align: center">
            <button type="submit" id="file-active" onclick="location.href='Accueil_liste.php'">File
                active
            </button>
        </div>
        <?php
        require 'tableau_beneficiaires.php'; ?>
    </div>
</div>

<script type="text/javascript" src="../js/commun.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script type="text/javascript" src="../js/ListePatient.js"></script>
<script type="text/javascript" src="../js/fixHeader.js"></script>
</body>
</html>