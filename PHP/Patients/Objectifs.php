<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_objectifs')) {
    erreur_permission();
}

$idPatient = $_GET['idPatient'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Objectifs</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../../css/design.css" rel="stylesheet">
    <link href="../../css/objectifs.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">

    <!--Fonction java-->
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/commun.js"></script>
    <script type="text/javascript" src="../../js/functions.js"></script>
</head>

<body>
<?php
require '../header.php'; ?>

<!-- Modal principal -->
<form method="POST" class="form-horizontal" id="form-user" data-id_patient="<?php
echo($idPatient); ?>">
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
                    <fieldset class="group-modal" id="main-field">
                        <legend class="group-modal-titre">Informations générales</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="nom">Nom<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="nom" name="nom" value="" class="form-control input-md" required
                                       type="text" maxlength="200">
                            </div>
                            <div class="col-md-2">
                                <label class="control-label" for="date-debut">Date<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="date-debut" name="date-debut" value="" class="form-control input-md" required
                                       type="date">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="description">Description<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <textarea id="description" name="description" class="form-control" type="text"
                                          maxlength="1000"
                                          required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="pratique">Pratique<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <select name="pratique" id="pratique" class="form-control no-arrows">
                                    <option value="1">Encadrée</option>
                                    <option value="2">Autonome</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal" id="field-autonomie">
                        <legend class="group-modal-titre">Informations objectif en autonomie</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="type-activite">Type activité<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" id="type-activite" name="type-activite"
                                       type="text" maxlength="200">
                            </div>
                            <div class="col-md-2">
                                <label class="control-label" for="duree">Durée<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" id="duree" name="duree"
                                       type="time">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-10">
                                <p class="help-block">Exemples: Natation, Yoga, Futsal</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="frequence">Fréquence<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" id="frequence" name="frequence"
                                       type="text" maxlength="200">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-10">
                                <p class="help-block">Exemples: 2 fois par jour, 3 fois par semaine</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="infos-complementaires">Informations
                                    complémentaires</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" id="infos-complementaires" name="infos-complementaires"
                                       type="text" maxlength="1000">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal" id="avancement">
                        <legend class="group-modal-titre">Avancement de l'objectif</legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="tableau-creneaux"
                                           class="table table-bordered table-striped table-hover table-condensed"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Etat</th>
                                            <th>Commentaire</th>
                                            <th>Supprimer</th>
                                        </tr>
                                        </thead>
                                        <tbody id="body-avancement">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal can-disable" id="avancement-add" style="background: lightgrey">
                        <legend class="group-modal-titre">Ajout Avancement</legend>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="control-label" for="date-avancement">Date avancement<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="date-avancement" name="date-avancement" class="form-control input-md"
                                       required
                                       type="date">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="etat">Etat<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <div class="radio">
                                    <label class="radio-inline">
                                        <input type="radio" name="etat" id="inlineRadio1" value="Atteint" required>Atteint
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="etat" id="inlineRadio2" value="Partiellement Atteint">Partiellement
                                        Atteint
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="etat" id="inlineRadio3" value="Non Atteint">Non
                                        Atteint
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="commentaire">Commentaire</label>
                            </div>
                            <div class="col-md-10">
                                <textarea id="commentaire" name="commentaire" class="form-control"
                                          type="text" maxlength="1000"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10" style="text-align: center">
                                <button id="avancement-add-button" type="submit" name="avancement-add-button"
                                        class="btn btn-success">Ajout
                                </button>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <!-- Boutons à droite -->
                    <button id="enregistrer-modifier" type="submit" name="valid-entInitial"
                            class="btn btn-success">Enregistrer
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

<!----- Affichage du/des objectif(s) si existe(nt) ----->
<div class="panel-body" id="main-panel" data-id_patient="<?php
echo($idPatient); ?>">
    <!-- The toast -->
    <div id="toast"></div>
    <div style="text-align: center">
        <input value="Ajouter un objectif" class='btn btn-success'
               id="ajout-modal" type="button" data-toggle="modal" data-target="#modal" data-backdrop="static"
               data-keyboard="false">
    </div>

    <!----- Objectifs encadrés ----->
    <div id='objectifs-encadres'>
        <p class='titre'>Objectifs encadrés</p>
    </div>

    <hr> <!-- Ligne séparatrice -->

    <!----- Objectifs en autonomie ----->
    <div id='objectifs-autonomie'>
        <p class='titre'>Objectifs en autonomie</p>
    </div>

    <hr> <!-- Ligne séparatrice -->

    <!----- Objectifs terminés ----->
    <div id='objectifs-termines'>
        <p class='titre'>Objectifs terminés</p>
    </div>
</div>

<script type="text/javascript" src="../../js/objectif.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>