<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_tableau_de_bord')) {
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

    <title>Tableau de bord</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/sante.css">
    <link rel="stylesheet" href="../../css/Loader.css">

    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">

    <script type="text/javascript" src="../../js/storage.js"></script>
    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/chart.min.js"></script>
</head>

<body>

<div id="preloader"></div>
<?php
require '../header-accueil.php'; ?>
<br>
<!-- Page Content -->
<div>
    <div class="container" style="margin-left : 5%; width: 90%; margin-right: 5%;">
        <!-- The toast -->
        <div id="toast"></div>

        <div style="text-align:center" class="retour">
            <a href="../Settings/Settings.php" style="color: black;"><span
                        class="glyphicon glyphicon-arrow-left"></span></a> Retour
        </div>

        <?php
        $can_select_region = 0;
        $row_filter_region_visibility = 'style="visibility: hidden;"';
        if ($permissions->hasRole(Permissions::SUPER_ADMIN)) {
            $can_select_region = 1;
            $row_filter_region_visibility = '';
        }
        $can_select_territoire = 0;
        $row_filter_territoire_visibility = 'style="visibility: hidden;"';
        if ($permissions->hasPermission('can_select_territoire')) {
            $can_select_territoire = 1;
            $row_filter_territoire_visibility = '';
        }
        $can_select_structure = 0;
        $row_filter_structure_visibility = 'style="visibility: hidden;"';
        if ($permissions->hasPermission('can_select_structure')) {
            $can_select_structure = 1;
            $row_filter_structure_visibility = '';
        }
        ?>

        <div class="row">
            <div class="col-lg-2">
                <form id="select-section">
                    <div class="btn-group-vertical" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="options" value="informations-territoires" checked>Informations
                            territoires
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" value="informations-orientations">Informations
                            orientations
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" value="informations-dossiers">Informations
                            dossiers
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" value="informations-patients"> Informations bénéficiaires
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" value="professionnels-sante"> Professionnels de santé
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" value="mutuelles"> Mutuelles
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" value="activites-patients"> Activités des bénéficiaires
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" value="orientation"> Orientation
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" value="evaluation"> Évaluations
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" value="questionnaires"> Questionnaires
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="options" value="objectifs"> Objectifs
                        </label>
                    </div>
                </form>
            </div>

            <div class="col-lg-10">
                <div id="filtres" style="display: none">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-3" style="text-align: right">
                            <label for="id_region">Region</label>
                        </div>
                        <div class="col-md-3">
                            <select id="id_region" data-can_select_region="<?= $can_select_region; ?>"
                                    data-id_region="<?= $_SESSION['id_region']; ?>"
                                    class="form-control"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-3" style="text-align: right">
                            <label for="id_territoire">Territoire</label>
                        </div>
                        <div class="col-md-3">
                            <select id="id_territoire" data-can_select_territoire="<?= $can_select_territoire; ?>"
                                    data-id_territoire="<?= $_SESSION['id_territoire']; ?>"
                                    class="form-control"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-3" style="text-align: right">
                            <label for="year">Année</label>
                        </div>
                        <div class="col-md-3">
                            <select id="year" class="form-control">
                                <option value="-1">Toutes les années</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-3" style="text-align: right">
                            <label for="structure-dossier">Struture</label>
                        </div>
                        <div class="col-md-3">
                            <select id="structure-dossier" class="form-control"
                                    data-can_select_structure="<?= $can_select_structure; ?>"
                                    data-id_structure="<?= $_SESSION['id_structure']; ?>">
                                <option value="-1">Toutes les structures</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>

                <fieldset class="section-noir" id="informations-territoires">
                    <legend class="section-titre-noir">Informations territoires</legend>
                    <table id="tableau-bord" class="stripe hover row-border compact nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>Territoire</th>
                            <th>Nb coordinateurs</th>
                            <th>Nb bénéficiaires</th>
                            <th>Nb structures</th>
                            <th>Nb intervenants</th>
                            <th>Nb créneaux</th>
                        </tr>
                        </thead>
                        <tbody id="tableau-body">
                        <!-- Les lignes sont insérées ici -->
                        </tbody>
                    </table>
                </fieldset>

                <fieldset class="section-noir" id="informations-orientations" style="display: none">
                    <legend class="section-titre-noir">Informations orientations</legend>

                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="nombre-orientations" style="max-height: 400px"></canvas>
                        </div>
                    </div>
                    <br>
                    <table id="nombre-orientations-table" class="stripe hover row-border compact nowrap"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>Nom de la structure</th>
                            <th>Nombre de bénéficiaires orientés vers la structure</th>
                        </tr>
                        </thead>
                        <tbody id="nombre-orientations-table-body"></tbody>
                    </table>
                </fieldset>

                <fieldset class="section-noir" id="informations-dossiers" style="display: none">
                    <legend class="section-titre-noir">Informations dossiers</legend>

                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="prise-en-charge-mois-chart" style="max-height: 400px"></canvas>
                        </div>
                    </div>
                    <br>
                    <table id="prise-en-charge-mois-table" class="stripe hover row-border compact nowrap"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>Mois</th>
                            <th>Nombre de nouveaux dossiers</th>
                        </tr>
                        </thead>
                        <tbody id="prise-en-charge-mois-table-body"></tbody>
                    </table>
                </fieldset>

                <fieldset class="section-noir" id="informations-patients" style="display: none">
                    <legend class="section-titre-noir">Informations bénéficiaires</legend>

                    <div class="row" id="main">
                        <div class="col-md-3">
                            <canvas id="repartition-sexe-chart"></canvas>
                        </div>
                        <div class="col-md-3">
                            <canvas id="repartition-age-chart"></canvas>
                        </div>
                        <div class="col-md-3">
                            <canvas id="repartition-ald-chart"></canvas>
                        </div>
                        <div class="col-md-3">
                            <canvas id="repartition-part-ald-chart"></canvas>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="section-noir" id="professionnels-sante" style="display: none">
                    <legend class="section-titre-noir">Professionnels de santé</legend>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="specialite">Spécialités</label>
                        </div>
                        <div class="col-md-3">
                            <select id="specialite" class="form-control">
                                <option value="-1">Toutes les spécialités</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="nombre-prescriptions" style="max-height: 400px"></canvas>
                        </div>
                    </div>
                    <br>
                    <table id="nombre-prescriptions-table" class="stripe hover row-border compact nowrap"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>Professionnel de santé</th>
                            <th>Nombre de prescriptions</th>
                        </tr>
                        </thead>
                        <tbody id="nombre-prescriptions-table-body"></tbody>
                    </table>
                </fieldset>

                <fieldset class="section-noir" id="mutuelles" style="display: none">
                    <legend class="section-titre-noir">Mutuelles</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="repartition-mutuelles" style="max-height: 400px"></canvas>
                        </div>
                    </div>
                    <br>
                    <table id="repartition-mutuelles-table" class="stripe hover row-border compact nowrap"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>Mutuelle</th>
                            <th>Nombre de bénéficiaires ayant souscrit à la mutuelle</th>
                        </tr>
                        </thead>
                        <tbody id="repartition-mutuelles-table-body"></tbody>
                    </table>
                </fieldset>

                <fieldset class="section-noir" id="activites-patients" style="display: none">
                    <legend class="section-titre-noir">Activités des bénéficiaires</legend>

                    <div class="row">
                        <div class="col-md-3">
                            <canvas id="repartition-activite-avant"></canvas>
                        </div>
                        <div class="col-md-3">
                            <canvas id="repartition-activite-autonomie"></canvas>
                        </div>
                        <div class="col-md-3">
                            <canvas id="repartition-activite-encadree"></canvas>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="section-noir" id="orientation" style="display: none">
                    <legend class="section-titre-noir">Orientation</legend>

                    <div class="row">
                        <div class="col-md-3">
                            <canvas id="repartition-orientation"></canvas>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="section-noir" id="evaluation" style="display: none">
                    <legend class="section-titre-noir">Évaluations</legend>

                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="amelioration-phys" style="max-height: 300px"></canvas>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="amelioration-distance-parcourue"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="amelioration-force-mb-sup"></canvas>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="amelioration-equilibre-statique"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="amelioration-souplesse"></canvas>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="evolution-mobilite-scapulo-humerale"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="evolution-endurance-mb-inf"></canvas>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="section-noir" id="questionnaires" style="display: none">
                    <legend class="section-titre-noir">Questionnaires</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <canvas id="repartition-epices" style="max-height: 400px"></canvas>
                        </div>
                        <div class="col-md-8">
                            <canvas id="repartition-amelioration-questionnaire" style="max-height: 400px"></canvas>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="section-noir" id="objectifs" style="display: none">
                    <legend class="section-titre-noir">Objectifs</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="repartition-objectif" style="max-height: 400px"></canvas>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <br>
        <br>
        <br>
    </div>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/TableauDeBord.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
<script type="text/javascript" src="../../js/graph.js"></script>

<script>
    const loader = document.getElementById("preloader");
    window.addEventListener("load", function () {
        loader.style.display = "none";
    });
</script>

</body>
</html>