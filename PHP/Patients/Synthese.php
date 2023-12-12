<?php

use Sportsante86\Sapa\Model\SettingsSynthese;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_synthese')) {
    erreur_permission();
}

$idPatient = $_GET['idPatient'];
$settingsSynthese = new SettingsSynthese($bdd);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Synthèse</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/programme.css">
    <link rel="stylesheet" href="../../css/objectifs.css">
    <link rel="stylesheet" href="../../css/synthese.css">
    <link rel="stylesheet" href="../../css/sante.css">

    <script type="text/javascript" src='../../js/jquery.js'></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.12.313/build/pdf.min.js"></script>
</head>

<body>

<?php
require '../header.php'; ?>

<div class="panel-body">
    <!-- The toast -->
    <div id="toast"></div>

    <!--
        <fieldset class="section">
            <legend class="section-titre">Historique des synthèses</legend>
            En construction
        </fieldset>
    -->
    <div class="row">
        <div class="col-md-6">
            <fieldset class="section" id="recup_synthese">
                <legend class="section-titre">Synthèses du bénéficiaire</legend>
                <label for="filtre_user_tous">Toutes les synthèses</label>
                <input type="radio" name="filtre_user" id="filtre_user_tous" value=false checked>
                <label for="filtre_user_soi">Mes synthèses</label>
                <input type="radio" name="filtre_user" id="filtre_user_soi" value=true><br>
                <div id="liste_synthese"></div>
            </fieldset>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <fieldset class="section">
                <legend class="section-titre">Synthèse</legend>

                <form id="form" data-id_patient="<?php
                echo $idPatient ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <input value="Options" type="button" class="btn btn-primary"
                                   id="open-modal-options-synthese"
                                   data-toggle="modal" data-target="#modal-options-synthese"
                                   data-backdrop="static"
                                   data-keyboard="false">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="version-synthese">Version :<span
                                        style="color: red">*</span></label>
                        </div>
                        <div class="col-md-2">
                            <select id="version-synthese" class="form-control">
                                <option value="beneficiaire">
                                    Bénéficiaire
                                </option>
                                <option value="medecin">
                                    Médecin
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary" id="preview">Prévisualiser le résultat</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date-synthese">Date :<span
                                        style="color: red">*</span></label>
                        </div>
                        <div class="col-md-2">
                            <input id="date-synthese" class="form-control" type="date" value="<?php
                            echo date('Y-m-d'); ?>"
                                   required/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <span id="titre"></span><span id="nom-patient"></span>,
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="introduction">Phrase d'introduction:</label>
                        </div>
                        <div class="col-md-10" style="text-align: left">
                            <textarea id="introduction" class="form-control"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date-bilan">Date du bilan :<span
                                        style="color: red">*</span></label>
                        </div>
                        <div class="col-md-2">
                            <input id="date-bilan" class="form-control" type="date"
                                   placeholder="Date de la dernière évaluation"
                                   required/>
                        </div>
                        <div class="col-md-4">
                            <!--                            <label for="evaluations-precedentes">Bilan précédent (utlisé pour le calcul de l'évolution)-->
                            <!--                                :</label>-->
                            <input id="nom_bilan_precedent" class="form-control" type="text" value="Date d'inclusion">
                        </div>
                        <div class="col-md-4">
                            <select id="evaluations-precedentes" class="form-control">
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="type-bilan">Type de bilan :<span
                                        style="color: red">*</span></label>
                        </div>
                        <div class="col-md-4">
                            <input id="type-bilan" class="form-control" type="text"
                                   placeholder="Type de la dernière évaluation"
                                   required/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="conclusion">Conclusion:</label>
                        </div>
                        <div class="col-md-10" style="text-align: left">
                            <textarea id="conclusion" class="form-control"></textarea>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-12 text-italique bottom-padding" style="text-align: left">
                            L'entretien nous a permis de mettre en évidence certains éléments. Ainsi nous avons fixés
                            les
                            objectifs suivants :
                        </div>
                    </div>
                    <div id="list-objectifs" class="col-md-12 bottom-padding" style="text-align: left"></div>

                    <div id="objectifs-text-div" class="row" style="display:none;">
                        <div class="col-md-4" style="text-align: left">
                            <label for="objectifs-text">Objectifs proposés :</label>
                        </div>
                        <div class="col-md-8 bottom-padding" style="text-align: left">
                            <textarea id="objectifs-text" class="form-control bottom-padding"
                                      type=""></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4" style="text-align: left">
                            <label for="commentaires-objectifs">Commentaires en lien avec les objectifs :</label>
                        </div>
                        <div class="col-md-8 bottom-padding" style="text-align: left">
                            <textarea id="commentaires-objectifs" class="form-control bottom-padding"
                                      type=""></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4" style="text-align: left">
                            <label for="preconisations">Préconisations :</label>
                        </div>
                        <div class="col-md-8 bottom-padding" style="text-align: left">
                            <textarea id="preconisations" class="form-control bottom-padding"
                                      type=""></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4" style="text-align: left">
                            <label for="point-vigilances">Point(s) de vigilances (douleurs/difficultés) :</label>
                        </div>
                        <div class="col-md-8 bottom-padding" style="text-align: left">
                            <textarea id="point-vigilances" class="form-control bottom-padding"
                                      type=""></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-italique bottom-padding" style="text-align: left">
                            Suite à nos échanges, nous vous proposons les activités suivantes // et vous encourageons à
                            poursuivre les activités suivantes :
                        </div>
                    </div>
                    <div id="list-activites" class="col-md-12 bottom-padding" style="text-align: left"></div>

                    <div id="activites-text-div" class="row" style="display:none;">
                        <div class="col-md-4" style="text-align: left">
                            <label for="activites-text">Activités proposées :</label>
                        </div>
                        <div class="col-md-8 bottom-padding" style="text-align: left">
                            <textarea id="activites-text" class="form-control bottom-padding"
                                      type=""></textarea>
                        </div>
                    </div>

                    <br><br>
                    <div class="row">
                        <div class="col-md-12 text-italique" style="text-align: left">
                            Sur le plan de l’activité physique :
                        </div>
                    </div>
                    <br>

                    <div id="section-creneau">
                        <fieldset class="group-modal">
                            <legend class="group-modal-titre">Test physiologique</legend>
                            <div id="test_physio_fait">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_physio_poids">Poids</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_poids" name="test_physio_poids" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_physio_taille">Taille</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_taille" name="test_physio_taille" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_physio_imc">IMC</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_imc" name="test_physio_imc" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_physio_tour_taille">Tour de
                                            taille</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_tour_taille" name="test_physio_tour_taille"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_physio_borg_repos">Borg de
                                            repos</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_borg_repos" name="test_physio_borg_repos"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_physio_fc_max_mesuree">FC max
                                            mesurée</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_fc_max_mesuree" name="test_physio_fc_max_mesuree"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_fc_max_mesuree_checkbox" type="checkbox">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_physio_fc_max_theorique">FC max
                                            théorique</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_fc_max_theorique"
                                               name="test_physio_fc_max_theorique"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_fc_max_theorique_checkbox" type="checkbox">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_physio_saturation_repos">Saturation
                                            de
                                            repos</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_saturation_repos"
                                               name="test_physio_saturation_repos"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_saturation_repos_checkbox" type="checkbox">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_physio_fc_repos">FC de
                                            repos</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_fc_repos" name="test_physio_fc_repos" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_physio_fc_repos_checkbox" type="checkbox">
                                    </div>
                                </div>
                            </div>

                            <div id="test_physio_nonfait">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="test_physio_motif">Le test n'a pas été
                                            réalisé pour le motif suivant</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="test_physio_motif" name="test_physio_motif" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal">
                            <legend class="group-modal-titre">Aptitudes Aérobie</legend>
                            <div id="test_aptitude_aerobie_fait">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label" for="test_aptitude_aerobie_distance">Distance
                                            parcourue (m)</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_aptitude_aerobie_distance"
                                               name="test_aptitude_aerobie_distance"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label"
                                               for="test_aptitude_aerobie_distance_theorique">Pourcentage
                                            de la distance théorique</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_aptitude_aerobie_distance_theorique"
                                               name="test_aptitude_aerobie_distance_theorique" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="test_aptitude_aerobie-body-tableau"
                                                   class="table table-bordered table-striped table-hover table-condensed"
                                                   style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>FC</th>
                                                    <th>Saturation (% SpO2)</th>
                                                    <th>Échelle de Borg</th>
                                                </tr>
                                                </thead>
                                                <tbody id="test_aptitude_aerobie_body">
                                                <tr>
                                                    <td>1 min</td>
                                                    <td id="test_aptitude_aerobie_fc1">fc1</td>
                                                    <td id="test_aptitude_aerobie_sat1">sat1</td>
                                                    <td id="test_aptitude_aerobie_borg1">borg1</td>
                                                </tr>
                                                <tr>
                                                    <td>2 min</td>
                                                    <td id="test_aptitude_aerobie_fc2">fc2</td>
                                                    <td id="test_aptitude_aerobie_sat2">sat2</td>
                                                    <td id="test_aptitude_aerobie_borg2">borg2</td>
                                                </tr>
                                                <tr>
                                                    <td>3 min</td>
                                                    <td id="test_aptitude_aerobie_fc3">fc3</td>
                                                    <td id="test_aptitude_aerobie_sat3">sat3</td>
                                                    <td id="test_aptitude_aerobie_borg3">borg3</td>
                                                </tr>
                                                <tr>
                                                    <td>4 min</td>
                                                    <td id="test_aptitude_aerobie_fc4">fc4</td>
                                                    <td id="test_aptitude_aerobie_sat4">sat4</td>
                                                    <td id="test_aptitude_aerobie_borg4">borg4</td>
                                                </tr>
                                                <tr>
                                                    <td>5 min</td>
                                                    <td id="test_aptitude_aerobie_fc5">fc5</td>
                                                    <td id="test_aptitude_aerobie_sat5">sat5</td>
                                                    <td id="test_aptitude_aerobie_borg5">borg5</td>
                                                </tr>
                                                <tr>
                                                    <td>6 min</td>
                                                    <td id="test_aptitude_aerobie_fc6">fc6</td>
                                                    <td id="test_aptitude_aerobie_sat6">sat6</td>
                                                    <td id="test_aptitude_aerobie_borg6">borg6</td>
                                                </tr>
                                                <tr>
                                                    <td>7 min dont 1 min de repos</td>
                                                    <td id="test_aptitude_aerobie_fc7">fc7</td>
                                                    <td id="test_aptitude_aerobie_sat7">sat7</td>
                                                    <td id="test_aptitude_aerobie_borg7">borg7</td>
                                                </tr>
                                                <tr>
                                                    <td>8 min dont 2 min de repos</td>
                                                    <td id="test_aptitude_aerobie_fc8">fc8</td>
                                                    <td id="test_aptitude_aerobie_sat8">sat8</td>
                                                    <td id="test_aptitude_aerobie_borg8">borg8</td>
                                                </tr>
                                                <tr>
                                                    <td>9 min dont 3 min de repos</td>
                                                    <td id="test_aptitude_aerobie_fc9">fc9</td>
                                                    <td id="test_aptitude_aerobie_sat9">sat9</td>
                                                    <td id="test_aptitude_aerobie_borg9">borg9</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_aptitude_aerobie_commentaires">Commentaires</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_aptitude_aerobie_commentaires"
                                                  name="test_aptitude_aerobie_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="test_aptitude_aerobie_nonfait">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="test_aptitude_aerobie_motif">Le test
                                            n'a
                                            pas été
                                            réalisé pour le motif suivant</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="test_aptitude_aerobie_motif"
                                               name="test_aptitude_aerobie_motif"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal" id="test_up_and_go_fieldset" hidden>
                            <legend class="group-modal-titre">Test times UP and GO</legend>
                            <div id="test_up_and_go_fait">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_up_and_go_duree">Durée
                                            (s)</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_up_and_go_duree" name="test_up_and_go_duree" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label"
                                               for="test_up_and_go_commentaires">Commentaires</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_up_and_go_commentaires"
                                                  name="test_up_and_go_commentaires" class="form-control input-md"
                                                  readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="test_up_and_go_nonfait">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="test_up_and_go_motif">Le test n'a pas
                                            été
                                            réalisé pour le motif suivant</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="test_up_and_go_motif" name="test_up_and_go_motif" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal">
                            <legend class="group-modal-titre">Force musculaire membres supérieurs</legend>
                            <div id="test_membre_sup_fait">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_membre_sup_main_dominante">Main
                                            dominante</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_membre_sup_main_dominante"
                                               name="test_membre_sup_main_dominante"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_membre_sup_main_droite">Main
                                            Droite
                                            (kg)</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_membre_sup_main_droite"
                                               name="test_membre_sup_main_droite"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_membre_sup_main_gauche">Main
                                            Gauche
                                            (kg)</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_membre_sup_main_gauche"
                                               name="test_membre_sup_main_gauche"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label"
                                               for="test_membre_sup_commentaires">Commentaires</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_membre_sup_commentaires"
                                                  name="test_membre_sup_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="test_membre_sup_nonfait">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="test_membre_sup_motif">Le test n'a pas
                                            été
                                            réalisé pour le motif suivant</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="test_membre_sup_motif" name="test_membre_sup_motif" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal">
                            <legend class="group-modal-titre">Équilibre statique</legend>
                            <div id="test_equilibre_fait">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_equilibre_pied_dominant">Pied
                                            dominant</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_equilibre_pied_dominant"
                                               name="test_equilibre_pied_dominant"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_equilibre_pied_gauche">Pied
                                            gauche au
                                            sol
                                            (sec)</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_equilibre_pied_gauche" name="test_equilibre_pied_gauche"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_equilibre_pied_droit">Pied droit
                                            au
                                            sol
                                            (sec) </label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_equilibre_pied_droit" name="test_equilibre_pied_droit"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label"
                                               for="test_equilibre_commentaires">Commentaires</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_equilibre_commentaires"
                                                  name="test_equilibre_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="test_equilibre_nonfait">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="test_equilibre_motif">Le test n'a pas
                                            été
                                            réalisé pour le motif suivant</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="test_equilibre_motif" name="test_equilibre_motif" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal">
                            <legend class="group-modal-titre">Souplesse</legend>
                            <div id="test_souplesse_fait">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_souplesse_distance">Distance
                                            majeur
                                            au
                                            sol</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_souplesse_distance" name="test_souplesse_distance"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label"
                                               for="test_souplesse_commentaires">Commentaires</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_souplesse_commentaires"
                                                  name="test_souplesse_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="test_souplesse_nonfait">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="test_souplesse_motif">Le test n'a pas
                                            été
                                            réalisé pour le motif suivant</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="test_souplesse_motif" name="test_souplesse_motif" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal">
                            <legend class="group-modal-titre">Mobilité scapulo-humérale</legend>
                            <div id="test_mobilite_fait">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_mobilite_main_gauche">Main Gauche
                                            en
                                            haut
                                            (cm)</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_mobilite_main_gauche" name="test_mobilite_main_gauche"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_mobilite_main_droite">Main Droite
                                            en
                                            haut
                                            (cm)</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_mobilite_main_droite" name="test_mobilite_main_droite"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label"
                                               for="test_mobilite_commentaires">Commentaires</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_mobilite_commentaires"
                                                  name="test_mobilite_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="test_mobilite_nonfait">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="test_mobilite_motif">Le test n'a pas
                                            été
                                            réalisé pour le motif suivant</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="test_mobilite_motif" name="test_mobilite_motif" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal">
                            <legend class="group-modal-titre">Endurance musculaire membres inférieurs</legend>
                            <div id="test_membre_inf_fait">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_membre_inf_nombre">Nombre de
                                            levers</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_membre_inf_nombre" name="test_membre_inf_nombre"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_membre_inf_fc_30">FC à 30
                                            sec</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_membre_inf_fc_30" name="test_membre_inf_fc_30"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_membre_inf_fc_30_checkbox" type="checkbox">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_membre_inf_sat_30">Saturation à
                                            30
                                            sec</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_membre_inf_sat_30" name="test_membre_inf_sat_30"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_membre_inf_sat_30_checkbox" type="checkbox">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="test_membre_inf_borg_30">Borg à 30
                                            sec</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input id="test_membre_inf_borg_30" name="test_membre_inf_borg_30"
                                               value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label"
                                               for="test_membre_inf_commentaires">Commentaires</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_membre_inf_commentaires"
                                                  name="test_membre_inf_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="test_membre_inf_nonfait">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="test_membre_inf_motif">Le test n'a pas
                                            été
                                            réalisé pour le motif suivant</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="test_membre_inf_motif" name="test_membre_inf_motif" value=""
                                               class="form-control input-md"
                                               type="text" readonly>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal" hidden>
                            <legend class="group-modal-titre">Questionnaire ONAPS</legend>
                            <div class="row">

                            </div>

                        </fieldset>
                    </div>
                    <br>

                    <!--            <div class="row">
                                    <div class="col-md-12 sous-titre" style="text-align: left">
                                        Analyse comportementale et motivationnelle :
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 intitule" style="text-align: left">
                                        Évaluation du niveau d’activité physique et de sédentarité :
                                    </div>
                                    <div class="col-md-8" style="text-align: left">
                                        // AJOUTER ICI les commentaires du test
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 intitule" style="text-align: left">
                                        Évaluation du niveau de motivation :
                                    </div>
                                    <div class="col-md-8" style="text-align: left">
                                        // AJOUTER ICI les commentaires du test
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 intitule" style="text-align: left">
                                        Évaluation de la qualité de vie :
                                    </div>
                                    <div class="col-md-8" style="text-align: left">
                                        // AJOUTER ICI les commentaires du test
                                    </div>
                                </div>
                                <br><br>-->

                    <div class="row">
                        <div class="col-md-2">
                            <label for="remerciements">Remerciements:</label>
                        </div>
                        <div class="col-md-10" style="text-align: left">
                            <textarea id="remerciements" class="form-control"></textarea>
                        </div>
                    </div>

                    <fieldset class="group-modal">
                        <legend class="group-modal-titre">Coordonnées évaluateur</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="affichage-coordonnees-evaluateur">Affichage des coordonnées de l'évaluateur
                                    (en fin de synthèse)</label>
                            </div>
                            <div class="col-md-2">
                                <input id="affichage-coordonnees-evaluateur" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="nom-evaluateur">Nom<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="nom-evaluateur" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="prenom-evaluateur">Prénom<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="prenom-evaluateur" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="fonction-evaluateur">Fonction<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="fonction-evaluateur" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="mail-evaluateur">Mail<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="mail-evaluateur" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="telephone-evaluateur">Téléphone</label>
                            </div>
                            <div class="col-md-4">
                                <input id="telephone-evaluateur" type="text" class="form-control">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal">
                        <legend class="group-modal-titre">Coordonnées du coordonnateur territorial PEPS</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="affichage-coordonnees-coordonnateur">Affichage des coordonnées du
                                    coordonnateur territorial PEPS (en fin de synthèse)</label>
                            </div>
                            <div class="col-md-2">
                                <input id="affichage-coordonnees-coordonnateur" type="checkbox">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="nom-coordonnateur">Nom</label>
                            </div>
                            <div class="col-md-4">
                                <input id="nom-coordonnateur" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="prenom-coordonnateur">Prénom</label>
                            </div>
                            <div class="col-md-4">
                                <input id="prenom-coordonnateur" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="fonction-coordonnateur">Fonction</label>
                            </div>
                            <div class="col-md-4">
                                <input id="fonction-coordonnateur" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="mail-coordonnateur">Mail</label>
                            </div>
                            <div class="col-md-4">
                                <input id="mail-coordonnateur" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="telephone-coordonnateur">Téléphone</label>
                            </div>
                            <div class="col-md-4">
                                <input id="telephone-coordonnateur" type="text" class="form-control">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal">
                        <legend class="group-modal-titre">Coordonnées personnes supplémentaires</legend>
                        <div id="personnes-supplemantaires-body"></div>

                        <div style="text-align: center; margin-top: 7px; margin-bottom: 7px;">
                            <button type="button" class="btn btn-primary" id="ajout-personnes-supplemantaires">
                                Ajouter une personne supplémentaire
                            </button>
                        </div>
                    </fieldset>

                    <fieldset class="section-bleu">
                        <legend class="section-titre-bleu">Options</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="affichage-page">Affichage du numéro de page</label>
                            </div>
                            <div class="col-md-1">
                                <input id="affichage-page" type="checkbox">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="affichage-paaco-globule">Affichage de l'information concernant
                                    Paaco-Globule</label>
                            </div>
                            <div class="col-md-1">
                                <input id="affichage-paaco-globule" type="checkbox">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="affichage-saut-page-conclusion">Saut de page après la conclusion</label>
                            </div>
                            <div class="col-md-1">
                                <input id="affichage-saut-page-conclusion" type="checkbox">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="affichage-details-patient-infos-supplementaires">Afficher les données
                                    patients supplémentaires (nom utilisé, etc.) en plus des données INS
                                    obligatoire.</label>
                            </div>
                            <div class="col-md-1">
                                <input id="affichage-details-patient-infos-supplementaires" type="checkbox">
                            </div>
                            <div class="col-md-6 help-block">
                                Les données INS ne sont affichées que dans les synthèses pour les médecins si le statut
                                de l'identité du bénéficiaire est "Qualifié".
                            </div>
                        </div>
                    </fieldset>

                    <br><br>
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <button id="download" type="submit" class="btn btn-success">Télécharger la synthèse en pdf
                            </button>
                            <button id="save" type="button" class="btn btn-success">Enregistrer la synthèse
                            </button>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="section">
                <legend class="section-titre">Résultat</legend>
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-12">
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group">
                                <button id="prev" class="btn btn-default">
                                    <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                                </button>
                                <button id="next" class="btn btn-default">
                                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                                </button>
                            </div>

                            <div class="input-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="page-span">Page:</span>
                                    <input id="page_num" type="text" class="form-control" placeholder="/"
                                           aria-describedby="page-span" style="max-width: 60px" readonly>
                                </div>
                            </div>

                            <div class="btn-group">
                                <button id="zoom-plus" class="btn btn-default">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                                <button id="zoom-minus" class="btn btn-default">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                </button>
                            </div>

                            <div class="input-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="zoom-span">Zoom:</span>
                                    <input id="zoom_value" type="text" class="form-control" placeholder="%"
                                           aria-describedby="zoom-span" style="max-width: 80px" readonly>
                                </div>
                            </div>

                            <div class="btn-group">
                                <div class="checkbox">
                                    <label>
                                        <input id="border-checkbox" type="checkbox" checked>Bordure
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <canvas id="the-canvas" class="border-hidden"></canvas>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <br>

    <form method="POST" class="form-horizontal" id="form-options-synthese"
          data-id_settings_synthese="<?= $settingsSynthese->getIdSettingsSynthese($_SESSION['id_structure']); ?>"
          data-id_structure="<?= $_SESSION['id_structure']; ?>">
        <!-- Modal -->
        <div class="modal fade" id="modal-options-synthese" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="modal-title-user">Options</h3>
                    </div>
                    <div class="modal-body">
                        <fieldset class="group-modal can-disable">
                            <legend class="group-modal-titre">Pré-remplissage des champs textes</legend>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div id="plus-text">
                                        <p class="help-block">
                                            Il y a des chaînes de caractères spéciales qui seront remplacées par les
                                            données
                                            d'un patient qui sont:</p>
                                        <ul class="help-block">
                                            <li>(date_naissance)</li>
                                            <li>(titre_civilite)</li>
                                            <li>(prenom_beneficiaire)</li>
                                            <li>(nom_beneficiaire)</li>
                                            <li>(nee)</li>
                                        </ul>
                                        <p class="help-block">Exemple d'utilisation:</p>
                                        <p>Synthèse de (titre_civilite) (nom_beneficiaire) (prenom_beneficiaire) (nee)
                                            le
                                            (date_naissance)</p>
                                        <p class="help-block">Permet d'obtenir:</p>
                                        <p>Synthèse de Mme XXXX Josiane née le 05/05/1980</p>
                                    </div>
                                    <div style="text-align: center">
                                        <button id="voir-plus" class="btn btn-sm btn-default">Voir plus d'information
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="introduction-medecin">Introduction médecin</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea id="introduction-medecin" name="introduction-medecin"
                                              class="form-control input-md"
                                              type="text" maxlength="2000"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="introduction-beneficiaire">Introduction
                                        bénéficiaire</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea id="introduction-beneficiaire" name="introduction-beneficiaire"
                                              class="form-control input-md"
                                              type="text" maxlength="2000"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="remerciements-medecin">Remerciements
                                        médecin</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea id="remerciements-medecin" name="remerciements-medecin"
                                              class="form-control input-md"
                                              type="text" maxlength="2000"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="remerciements-beneficiaire">Remerciements
                                        bénéficiaire</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea id="remerciements-beneficiaire" name="remerciements-beneficiaire"
                                              class="form-control input-md"
                                              type="text" maxlength="2000"></textarea>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                    <div class="modal-footer">
                        <!-- Boutons à droite -->
                        <button id="enregistrer" type="submit" name="valid-entInitial"
                                class="btn btn-success">Enregistrer
                        </button>

                        <!-- Boutons à gauche -->
                        <button id="close" type="button" class="btn btn-warning pull-left">Abandon
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
</div>

<script src="../../js/calculsEvaluation.js"></script>
<script src="../../js/Synthese.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>