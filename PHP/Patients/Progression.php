<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_progression')) {
    erreur_permission();
}

$idUser = $_SESSION['id_user'];
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

    <title>Progression</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/design.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/sante.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

    <script type="text/javascript" src='../../js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/chart.min.js"></script>
</head>

<body>
<?php
require '../header.php'; ?>

<div class="container" id="main"
     data-id_patient="<?php
     echo $idPatient; ?>"
     data-id_user="<?php
     echo $idUser; ?>">
    <!-- The toast -->
    <div id="toast"></div>

    <div class="row">
        <div class="col-md-2">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <label>
                    <input type="checkbox" id="tout-1-checkbox" style="margin-bottom: 15px">
                    Tout cocher/décocher
                </label>
                <br>
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                               aria-expanded="true" aria-controls="collapseOne">
                                Test physiologique
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="headingOne">
                        <div class="panel-body">
                            <label>
                                <input type="checkbox" class="multi_checkbox" id="tout-2-checkbox"
                                       style="margin-bottom: 15px">
                                Tout
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="poids-checkbox">
                                Graphe poids
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="tour_taille-checkbox">
                                Graphe tour de taille
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="IMC-checkbox">
                                Graphe IMC
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="fc_repos-checkbox">
                                Graphe FC de repos
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="fc_max_mesuree-checkbox">
                                Graphe FC max mesurée
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="saturation_repos-checkbox">
                                Graphe saturation de repos
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Aptitudes Aérobie
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <label>
                                <input type="checkbox" id="distance_parcourue-checkbox">
                                Graphe distance parcourue
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Force musculaire membres supérieurs
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingThree">
                        <div class="panel-body">
                            <label>
                                <input type="checkbox" class="multi_checkbox" id="tout-3-checkbox"
                                       style="margin-bottom: 15px">
                                Tout
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="mg-checkbox">
                                Graphe force main gauche
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="md-checkbox">
                                Graphe force main droite
                            </label>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingFour">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Equilibre statique
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingFour">
                        <div class="panel-body">
                            <label>
                                <input type="checkbox" class="multi_checkbox" id="tout-4-checkbox"
                                       style="margin-bottom: 15px">
                                Tout
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="pied_droit_sol-checkbox">
                                Graphe pied droit
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="pied_gauche_sol-checkbox">
                                Graphe pied gauche
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingFive">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Souplesse
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingFive">
                        <div class="panel-body">
                            <label>
                                <input type="checkbox" id="distance-checkbox">
                                Graphe distance majeur au sol
                            </label>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingSix">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Mobilité scapulo-humérale
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                        <div class="panel-body">
                            <label>
                                <input type="checkbox" class="multi_checkbox" id="tout-5-checkbox"
                                       style="margin-bottom: 15px">
                                Tout
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="main_gauche_haut-checkbox">
                                Graphe main gauche en haut
                            </label>
                            <label>
                                <input type="checkbox" id="main_droite_haut-checkbox">
                                Graphe main droite en haut
                            </label>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingSeven">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                Endurance musculaire membres inférieurs
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingSeven">
                        <div class="panel-body">
                            <label>
                                <input type="checkbox" class="multi_checkbox" id="tout-6-checkbox"
                                       style="margin-bottom: 15px">
                                Tout
                            </label>
                            <br>
                            <label>
                                <input type="checkbox" id="nb_lever-checkbox">
                                Graphe nombre de levers
                            </label>
                            <label>
                                <input type="checkbox" id="fc30-checkbox">
                                Graphe FC à 30 sec
                            </label>
                            <label>
                                <input type="checkbox" id="sat30-checkbox">
                                Graphe saturation à 30 sec
                            </label>
                            <label>
                                <input type="checkbox" id="borg30-checkbox">
                                Graphe borg à 30 sec
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $query = $bdd->prepare(
            "SELECT count(presence) as nbrpresent from a_participe_a where id_patient = $idPatient and presence = 1"
        );
        $query->execute();
        $data = $query->fetch();

        $nbrpresent = $data['nbrpresent'];

        $query->closeCursor();

        $query = $bdd->prepare(
            "SELECT count(presence) as nbrabsent from a_participe_a where id_patient = $idPatient and presence = 0"
        );
        $query->execute();
        $data = $query->fetch();

        $nbrabsent = $data['nbrabsent'];

        $query->closeCursor();

        $nbrseances = $nbrpresent + $nbrabsent;

        if ($nbrseances != 0) {
            ?>
            <div class="col-md-10">
                <fieldset class="section-noir">
                    <legend class="section-titre-noir">Assiduité aux séances d'activité physique</legend>
                    <h4> Présence : <?php
                        echo $nbrpresent ?> / <?php
                        echo($nbrseances) ?> (<?php
                        echo round((($nbrpresent / ($nbrseances) * 100)), 0) ?>%)</h4>
                </fieldset>
            </div>
            <?php
        } else {
            ?>
            <div class="col-md-10">
                <fieldset class="section-noir">
                    <legend class="section-titre-noir">Assiduité aux séances d'activité physique</legend>
                    <h4>Ce patient n'a pas encore eu de séances </h4>
                </fieldset>
            </div>
            <?php
        }
        ?>
        <div class="col-md-10">
            <fieldset class="section-noir">
                <legend class="section-titre-noir">Observations progression
                    <span class="infobulle"
                          aria-label="Toutes informations complémentaires sur la progression du bénéficiaire">
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
                                   placeholder="Veuillez saisir vos observations" required="required"
                                   style="width: 100%"/>
                        </div>
                        <div class="col-md-2">
                            <button id=ajouterobservation type="submit" value="ajouterobservation"
                                    name="ajouterobservation"
                                    class="btn btn-success">Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </fieldset>

            <fieldset class="section-noir">
                <legend class="section-titre-noir">Graphes de progression</legend>
                <div class="row graph-div">
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-poids"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-tour_taille"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-IMC"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-fc_repos"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-saturation_repos"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-fc_max_mesuree"></canvas>
                    </div>
                </div>

                <div class="row graph-div">
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-distance_parcourue"></canvas>
                    </div>
                </div>

                <div class="row graph-div">
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-md"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-mg"></canvas>
                    </div>
                </div>

                <div class="row graph-div">
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-pied_gauche_sol"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-pied_droit_sol"></canvas>
                    </div>
                </div>

                <div class="row graph-div">
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-distance"></canvas>
                    </div>
                </div>

                <div class="row graph-div">
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-main_droite_haut"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-main_gauche_haut"></canvas>
                    </div>
                </div>

                <div class="row graph-div">
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-nb_lever"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-fc30"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-sat30"></canvas>
                    </div>
                    <div class="col-md-4" style="display: none">
                        <canvas id="evolution-borg30"></canvas>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/observation.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
<script type="text/javascript" src="../../js/progression.js"></script>
</body>
</html>
