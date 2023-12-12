<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_sante')) {
    erreur_permission();
}

$idUser = $_SESSION['id_user'];
$idPatient = $_GET['idPatient']; // Récupération idPatient
?>

<!-- Cette page concerne l'onglet santé dans le dossier du bénéficiaire. Le coordinateur hésitait a la supprimer. Les données ici sont relatives au bénéficiaire qu'importe son statut. On trouvera aussi un  pour ajouter un test de données physiologique.-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Santé</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/sante.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">

    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">
</head>

<body>
<?php
require '../header.php'; ?>

<div class="container" id="main"
     data-id_patient="<?= $idPatient; ?>"
     data-id_user="<?= $idUser; ?>">
    <div style="margin-left : 5%; width: 90%; margin-right: 5%;">
        <!-- The toast -->
        <div id="toast"></div>

        <form class="form-horizontal" id="form-sante-pathologies" data-id_patient="<?= $idPatient; ?>">
            <!--Modal-->
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <fieldset class="can-disable">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title" id="modal-title">Données pathologies</h3>
                            </div>
                            <div class="modal-body">
                                <fieldset class="group-modal" id="fieldset-ald">
                                    <legend class="group-modal-titre">Affections de longue durée du patient</legend>
                                    <div class="row">
                                        <div class="col-md-5" style="text-align: right">
                                            <label class="control-label" for="a_une_ald">Le patient a une ALD:</label>
                                        </div>

                                        <div class="col-md-7" id="radio-div">
                                            <div>
                                                <label for="a_une_ald-oui" style="float: left; padding-right: 5px">
                                                    <input type="radio" id="a_une_ald-oui" name="a_une_ald" value="oui"
                                                           required>
                                                    Oui
                                                </label>
                                            </div>
                                            <div>
                                                <label for="a_une_ald-non" style="float: left; padding-right: 5px">
                                                    <input type="radio" id="a_une_ald-non" name="a_une_ald" value="non">
                                                    Non
                                                </label>
                                            </div>
                                            <div>

                                                <label for="a_une_ald-nspp" style="float: left">
                                                    <input type="radio" id="a_une_ald-nspp" name="a_une_ald"
                                                           value="nspp">
                                                    Ne se prononce pas
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <br>
                                    <div id="conteneur-ald">
                                    </div>
                                </fieldset>
                            </div>
                        </fieldset>
                        <div class="modal-footer">
                            <!-- Boutons à droite -->
                            <button id="enregistrer-modifier" type="submit" name="enregistrer-modifier"
                                    class="btn btn-success">Modifier
                            </button>
                            <!-- Boutons à gauche -->
                            <button id="close" type="button" data-dismiss="modal" class="btn btn-warning pull-left">
                                Abandon
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--Modal With Warning-->
        <div id="warning" class="modal fade" role="dialog" data-backdrop="false">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <p>Quitter sans enregistrer?</p>
                        <button id="confirmclosed" type="button" class="btn btn-danger">Oui</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
                    </div>
                </div>
            </div>
        </div>

        <fieldset class="section-noir">
            <legend class="section-titre-noir">Observations santé
                <span class="infobulle"
                      aria-label="Toutes informations complémentaires sur l'état de santé du bénéficiaire">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
            <div class="row">
                <div class="col-md-12">
                    <textarea readonly rows="6" cols="80" name="obs" id="obs"
                              style="width : 100%; resize: none;"></textarea>
                </div>
            </div>
            <br>
            <div class="row">
                <form id="form-observation">
                    <div class="col-md-10">
                        <input type="text" id="observation" name="observation"
                               placeholder="Veuillez saisir vos observations" required="required" style="width: 100%"/>
                    </div>
                    <div class="col-md-2">
                        <button id=ajouterobservation type="submit" value="ajouterobservation" name="ajouterobservation"
                                class="btn btn-success">Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </fieldset>

        <?php
        if ($permissions->hasPermission('can_view_page_patient_donnees_sante')): ?>
            <!-- Les données de santé du patient -->
            <div class="can-be-hidden-2" style="display: <?= $patient['consentement'] == "1" ? "block" : "none"; ?>">
                <fieldset class="section-noir">
                    <legend class="section-titre-noir">Affections de longue durée
                        <span class="infobulle" aria-label="Toutes les affections de longue durée du patient">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <input value="Modifier les affections longue durée"
                                   id="open-modal-ald" type="button" data-toggle="modal" class="btn btn-danger"
                                   data-target="#modal" data-backdrop="static"
                                   data-keyboard="false">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                    <textarea readonly rows="5" cols="8" name="detail-ald" id="detail-ald"
                              style="width : 100%; resize: none;"></textarea>
                        </div>
                    </div>
                </fieldset>

                <form id="form-details-pathologies" data-id_patient="<?= $idPatient; ?>">
                    <fieldset class="section-bleu">
                        <legend class="section-titre-bleu">Pathologies<span class="infobulle"
                                                                            aria-label="Toutes informations complémentaires sur l'état de santé du bénéficiaire">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="section-rouge">
                                    <legend class="section-titre-rouge">Cardiaque
                                        <span class="infobulle"
                                              aria-label="Par exemple : hypertension artérielle, infarctus,...">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-cardio"
                                                           id="a-patho-cardio-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-cardio"
                                                           id="a-patho-cardio-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-cardio-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea class="field-patho" rows="5" cols="8" name="detail-cardio"
                                              id="detail-cardio"
                                              style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <fieldset class="section-rouge">
                                    <legend class="section-titre-rouge">Respiratoires
                                        <span class="infobulle" aria-label="Par exemple : asthme, BPCO, pneumonie,...">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-respi"
                                                           id="a-patho-respi-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-respi"
                                                           id="a-patho-respi-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-respi-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea class="field-patho" rows="5" cols="8" name="detail-respi"
                                              id="detail-respi"
                                              style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="section-bleu">
                                    <legend class="section-titre-bleu">Métaboliques et/ou endocrinologiques
                                        <span class="infobulle" aria-label="Par exemple : anémie, diabète, obésité,...">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-metabo"
                                                           id="a-patho-metabo-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-metabo"
                                                           id="a-patho-metabo-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-metabo-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea class="field-patho" rows="5" cols="8" name="detail-metabo"
                                              id="detail-metabo"
                                              style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <fieldset class="section-bleu">
                                    <legend class="section-titre-bleu">Ostéo-articulaires
                                        <span class="infobulle"
                                              aria-label="Par exemple : prothèses, fractures, entorses,...">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-osteo"
                                                           id="a-patho-osteo-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-osteo"
                                                           id="a-patho-osteo-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-osteo-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea class="field-patho" rows="5" cols="8" name="detail-osteo"
                                              id="detail-osteo"
                                              style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="section-vert">
                                    <legend class="section-titre-vert">Neurologiques
                                        <span class="infobulle"
                                              aria-label="Par exemple : AVC, épilepsie, maladie d'Alzheimer,Parkinson,...">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-neuro"
                                                           id="a-patho-neuro-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-neuro"
                                                           id="a-patho-neuro-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-neuro-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea class="field-patho" rows="5" cols="8" name="detail-neuro"
                                              id="detail-neuro"
                                              style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <fieldset class="section-vert">
                                    <legend class="section-titre-vert">Psycho-sociales
                                        <span class="infobulle"
                                              aria-label="Par exemple : autisme, dépression, schizophrénie,...">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-psycho"
                                                           id="a-patho-psycho-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-psycho"
                                                           id="a-patho-psycho-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-psycho-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea class="field-patho" rows="5" cols="8" name="detail-psycho"
                                              id="detail-psycho"
                                              style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="section-rouge">
                                    <legend class="section-titre-rouge">Cancéreuses
                                        <span class="infobulle" aria-label="Tout cancer">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-cancero"
                                                           id="a-patho-cancero-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-cancero"
                                                           id="a-patho-cancero-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-cancero-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea class="field-patho" rows="5" cols="8" name="detail-cancero"
                                              id="detail-cancero"
                                              style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <fieldset class="section-rouge">
                                    <legend class="section-titre-rouge">Circulatoires
                                        <span class="infobulle" aria-label="Anévrismes, varices, ...">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-circul"
                                                           id="a-patho-circul-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-circul"
                                                           id="a-patho-circul-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-circul-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea class="field-patho" rows="5" cols="8" name="detail-circul"
                                              id="detail-circul"
                                              style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="section-noir">
                                    <legend class="section-titre-noir">Autres<span class="infobulle"
                                                                                   aria-label="Maladies infectieuses, maladies rares, ...">
                          <img src="../../images/help.png" class="help" alt="help"/>
                        </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-autre"
                                                           id="a-patho-autre-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-patho" name="a-patho-autre"
                                                           id="a-patho-autre-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-autre-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea class="field-patho" rows="6" cols="80" name="detail-autre"
                                              id="detail-autre"
                                              style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row" style="text-align: center">
                            <div class="col-md-12">
                                <input value="Enregistrer les modifications"
                                       id="modifier-pathologie" type="button" class="btn btn-success">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        <?php
        endif; ?>
    </div>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/observation.js"></script>
<script src="../../js/sante.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>