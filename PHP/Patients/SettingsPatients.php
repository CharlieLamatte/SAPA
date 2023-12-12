<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_settings_patient')) {
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

    <title>Bénéficiaires</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/separator.css">

    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/moment.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">
</head>

<body>
<?php
require '../header-accueil.php'; ?>

<form method="POST" class="form-horizontal" id="form-patient">
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <fieldset class="can-disable">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="modal-title">Modal title</h3>
                    </div>
                    <div class="modal-body">
                        <!--Partie du modal pour la suppression d'un patient -->
                        <div id="section-suppr-patient">
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Supprimer</legend>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="add-patient">Choisir un bénéficiaire:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input id="add-patient" name="add-patient" class="form-control"
                                               placeholder="Taper les premières lettres du nom" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom">Nom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nom" name="nom" value="" class="form-control input-md" required
                                               type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="prenom">Prénom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="prenom" name="prenom" value="" class="form-control input-md"
                                               required
                                               type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="id-patient">Id<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="id-patient" name="id-patient"
                                               class="form-control input-md" type="text" required readonly>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <!--Partie du modal pour la fusion de bénéficiaires -->
                        <div id="section-fusion-patient">
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Fusion</legend>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="add-patient-1">Ajouter le bénéficiaire 1:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input id="add-patient-1" name="add-patient-1" class="form-control"
                                               placeholder="Taper les premières lettres du nom" type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom-1">Nom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nom-1" name="nom-1" value="" class="form-control input-md" required
                                               type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="prenom-1">Prénom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="prenom-1" name="prenom-1" value="" class="form-control input-md"
                                               required
                                               type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="id-patient-1">Id<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="id-patient-1" name="id-patient-1"
                                               class="form-control input-md" type="text" required readonly>
                                    </div>
                                </div>

                                <hr class="solid-pink">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="add-patient-2">Ajouter le bénéficiaire 2:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input id="add-patient-2" name="add-patient-2" class="form-control"
                                               placeholder="Taper les premières lettres du nom" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom-2">Nom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nom-2" name="nom-2" value="" class="form-control input-md" required
                                               type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="prenom-2">Prénom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="prenom-2" name="prenom-2" value="" class="form-control input-md"
                                               required
                                               type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="id-patient-2">Id<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="id-patient-2" name="id-patient-2"
                                               class="form-control input-md" type="text" required readonly>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </fieldset>
                <div class="modal-footer">
                    <!-- Boutons à droite -->
                    <button id="enregistrer-modifier" type="submit" name="valid-entInitial"
                            class="btn btn-success">Modifier
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
                Bénéficiaires
            </legend>
        </div>

        <div style="text-align:center">
            <br>
            <?php
            if ($permissions->hasPermission('can_fuse_patient')): ?>
                <input value="Fusionner deux bénéficiaires"
                       id="fusion-modal-patient" type="button" data-toggle="modal" data-target="#modal"
                       data-backdrop="static"
                       data-keyboard="false">
            <?php
            endif; ?>
        </div>
        <div style="text-align:center">
            <br>
            <?php
            if ($permissions->hasPermission('can_delete_patient')): ?>
                <input value="Supprimer un bénéficiaire"
                       id="suppr-modal-patient" type="button" data-toggle="modal" data-target="#modal"
                       data-backdrop="static"
                       data-keyboard="false">
            <?php
            endif; ?>
        </div>
        <br>
    </div>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/SettingsPatient.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>