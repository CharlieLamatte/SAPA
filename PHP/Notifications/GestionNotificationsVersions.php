<?php

use Sportsante86\Sapa\Model\Notification;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_gestion_notifications_maj')) {
    erreur_permission();
}

$n = new Notification($bdd);
$notifications = $n->readAllMaj() ?? [];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestions notifications de MAJ</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">
</head>

<body>
<?php
require '../header-accueil.php';
require '../partials/warning_modal.php'; ?>

<br>
<!-- Page Content -->
<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <div style="text-align:center" class="retour">
        <a href="../Settings/Settings.php" style="color: black;"><span
                    class="glyphicon glyphicon-arrow-left"></span></a> Retour
    </div>

    <div style="float: left; width : 100%;border: 3px #1E1B7A solid;">
        <div style="text-align:center">
            <legend style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A;">
                Liste des notifications de MAJ
            </legend>
        </div>
        <br>
        <div style="text-align: center">
            <input value="Ajouter une notification"
                   id="ajout-modal" type="button" data-toggle="modal" data-target="#modal" data-backdrop="static"
                   data-keyboard="false">

            <div class="body" style="width: 100%;border : 3px #fdfefe solid;">
                <table id="table-notifications" class="stripe hover row-border compact nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Texte</th>
                        <th>Détails</th>
                    </tr>
                    </thead>
                    <tbody id="body-notifications"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<br>

<form method="POST" class="form-horizontal" id="form-notification">
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="modal-title">Modal title</h3>
                </div>
                <div class="modal-body">
                    <fieldset class="group-modal can-disable">
                        <legend class="group-modal-titre">Notification</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="texte-notification">Texte<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <textarea id="texte-notification" name="texte-notification"
                                          class="form-control input-md can-disable" required></textarea>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal">
                        <legend class="group-modal-titre">Preview</legend>
                        <div class="panel panel-primary" style="margin: 4px;">
                            <div class="panel-heading">
                                <div id="title-preview" class="panel-title">14/06/2022 09:11 Mise à jour SAPA</div>
                            </div>
                            <div id="body-preview" class="panel-body"></div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <!-- Boutons à droite -->
                    <button id="enregistrer-modifier" type="submit" name="valid-entInitial"
                            class="btn btn-success pull-right">Modifier
                    </button>

                    <button id="delete" type="submit" name="delete"
                            class="btn btn-danger pull-right" style="margin-right: 10px">
                        <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                        Supprimer
                    </button>

                    <!-- Boutons à gauche -->
                    <button id="close" type="button" data-dismiss="modal" class="btn btn-warning pull-left">Abandon
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="../../js/commun.js"></script>
<script src="../../js/gestion_notifications_maj.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>