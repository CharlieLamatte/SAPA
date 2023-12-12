<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_creneaux')) {
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

    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/moment.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">
</head>

<body>
<?php
require '../header-accueil.php';
require 'modalCreneau.php'; ?>

<br>
<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <div style="text-align:center" class="retour">
        <a href="../Settings/Settings.php" style="color: black;"><span
                    class="glyphicon glyphicon-arrow-left"></span></a> Retour
    </div>
    <div id="ConteneurGauche" style="float: left; width : 100%;border: 3px #1E1B7A solid;">
        <div style="text-align:center">
            <legend id="legendPatient" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                Créneaux
            </legend>
        </div>

        <?php
        if ($permissions->hasPermission('can_add_creneau')): ?>
            <br>
            <div style="text-align:center">
                <input value="Ajouter un créneau"
                       id="creneau-modal" type="button" data-toggle="modal" data-target="#modal" data-backdrop="static"
                       data-keyboard="false">
            </div>
        <?php
        endif; ?>

        <div class="body" style="width: 100%;border : 3px #fdfefe solid;">
            <table id="table_creneau" class="stripe hover row-border compact nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>Nom Créneau</th>
                    <th>Type de Parcours</th>
                    <th>Localisation du Créneau</th>
                    <th>Jour</th>
                    <th>Durée</th>
                    <th>Nom de la Structure</th>
                    <th>Intervenant</th>
                    <th>Participants</th>
                    <th>Détails</th>
                </tr>
                </thead>
                <tbody id="body-creneaux"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/autocomplete.js"></script>
<script src="../../js/modalCreneau.js"></script>
<script src="../../js/tableauCreneau.js"></script>
<script src="../../js/ListeCreneau.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>

</html>
