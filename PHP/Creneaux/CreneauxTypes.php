<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_calendrier_creneaux_types')) {
    erreur_permission();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Créneaux</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/fullCalendar.css">
    <link rel="stylesheet" href="../../css/Loader.css">

    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/moment.min.js"></script>
    <script type="text/javascript" src="../../js/fullCalendar/fullCalendar.js"></script>

    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">
</head>

<body>
<!-- The toast -->
<div id="toast"></div>
<?php
require '../header-accueil.php';
require 'modalCreneau.php'; ?>

<div class="container" id="main-div">
    <div style="text-align:center" class="retour">
        <a href="../Settings/Settings.php" style="color: black;"><span
                    class="glyphicon glyphicon-arrow-left"></span></a> Retour
    </div>

    <div style="text-align:center"><h3>Créneaux Types</h3></div>
    <br>
    <div class="row">
        <div class="col-md-2">
            <input type="radio" id="actif" name="filtre-activation" value="actif" checked>
            <label for="actif">Actif</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <input type="radio" id="non-actif" name="filtre-activation" value="non-actif">
            <label for="non-actif">Non Actif</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <input type="radio" id="tous" name="filtre-activation" value="tous">
            <label for="tous">Tous</label>
        </div>
    </div>
    <div id='calendar-type'></div>
    <br>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/autocomplete.js"></script>
<script type="text/javascript" src="../../js/modalCreneau.js"></script>
<script type="text/javascript" src="../../js/creneauxTypes.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>

</body>
</html>

