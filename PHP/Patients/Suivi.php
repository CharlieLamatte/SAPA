<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_suivi')) {
    erreur_permission();
}

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

    <title>Suivi</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/programme.css">
    <link rel="stylesheet" href="../../css/objectifs.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">

    <script type="text/javascript" src='../../js/jquery.js'></script>

    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/moment.min.js"></script>
</head>

<body>
<?php
require '../header.php'; ?>

<div class="panel-body">
    <!-- The toast -->
    <div id="toast"></div>

    <!---------- Orientation ---------->
    <div id='orientation'>
        <p class='titre'>Fin du programme: 1 an</p>
        <div id="div-1-an"></div>
        <br>
        <input id="orientation-button" type="submit" value="Ajout" class='btn btn-success btn-s bouton'
               data-toggle="modal" data-target="#modal" data-backdrop="static"
               data-keyboard="false">
    </div>
    <br>
    <hr> <!-- Ligne séparatrice -->
    <br>
    <!---------- Fin de prise en charge ---------->
    <div id='fin_prise_en_charge'>
        <p class='titre'>Fin du programme: 2 ans</p>
        <div id="div-2-ans"></div>
        <br>
        <input id="fin-button" type="submit" value="Ajout" class='btn btn-success btn-s bouton'
               data-toggle="modal" data-target="#modal" data-backdrop="static"
               data-keyboard="false">
    </div>
    <hr> <!-- Ligne séparatrice -->
    <br>
    <!---------- Motif de sortie ---------->
    <div id='motif_sortie'>
        <p class='titre'>Motif de sortie</p>
        <div id="div-sortie"></div>
        <br>
        <input id="sortie-button" type="submit" value="Ajout" class='btn btn-success btn-s bouton'
               data-toggle="modal" data-target="#modal" data-backdrop="static"
               data-keyboard="false">
    </div>
</div>

<!---------- Modal ---------->
<form class="form-horizontal" id="form-user" data-id_questionnaire="" data-id_user="<?= $_SESSION['id_user']; ?>"
      data-id_patient="<?= $patient['id_patient']; ?>" data-est_archive="<?= $patient['est_archive']; ?>">
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
                    <div class="row" style="margin-left: 0; margin-right: 0">
                        <div class="col-md-12" id="main"></div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <!-- Boutons à droite -->
                    <button id="enregistrer-modifier" type="submit" name="valid-entInitial"
                            class="btn btn-success">Ajout
                    </button>

                    <!-- Boutons à gauche -->
                    <button id="close" type="button" data-dismiss="modal" class="btn btn-warning pull-left">Abandon
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

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

<script src="../../js/questionnaire_common.js"></script>
<script src="../../js/programme.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>