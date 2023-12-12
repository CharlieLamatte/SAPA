<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_strutures')) {
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

    <title>Structures</title>

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
require 'modalStructure.php'; ?>

<!-- Modal With Warning -->
<div id="warning" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <p id="warning-text">Quitter sans enregistrer?</p>
                <button id="confirmclosed" type="button" class="btn btn-danger">Oui</button>
                <button id="refuseclosed" type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>

<br>
<!-- Page Content -->
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
                Structures
            </legend>
        </div>
        <div style="text-align:center">
            <br>
            <input value="Ajouter une structure"
                   id="ajout-modal-structure" type="button" data-toggle="modal" data-target="#modalStructure"
                   data-backdrop="static"
                   data-keyboard="false">
            <?php
            if ($permissions->hasPermission('can_fuse_structure')): ?>
                <input value="Fusionner deux structures"
                       id="fusion-modal-structure" type="button" data-toggle="modal" data-target="#modalStructure"
                       data-backdrop="static"
                       data-keyboard="false">
            <?php
            endif; ?>
        </div>
        <div class="body" style="width: 100%;border : 3px #fdfefe solid;">
            <!-- Tableau regroupant l'ensemble des structures -->
            <table id="table_id" class="stripe hover row-border compact nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Adresse</th>
                    <th>Territoire</th>
                    <th>Détails</th>
                </tr>
                </thead>
                <tbody id="body-structure"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/autocomplete.js"></script>
<script src="../../js/modalStructure.js"></script>
<script src="../../js/ListeStructures.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>