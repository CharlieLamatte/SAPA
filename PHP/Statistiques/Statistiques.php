<?php

use Sportsante86\Sapa\Model\StatistiquesStructure;
use Sportsante86\Sapa\Model\Structure;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_statistiques')) {
    erreur_permission();
}

$s = new Structure($bdd);
$structure = $s->readOne($_SESSION['id_structure']);

$stat = new StatistiquesStructure($bdd);
$statsCreneaux = $stat->getAssiduiteAllCreaneaux($_SESSION['id_structure']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Statistiques</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link href="../../css/settings.css" rel="stylesheet">
    <link href="../../css/design.css" rel="stylesheet">
    <link href="../../css/sante.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">

    <!-- jQuery -->
    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../js/bootstrap.min.js"></script>

    <script type="text/javascript" src="../../js/chart.min.js"></script>
</head>

<body>
<?php
require '../header-accueil.php'; ?>

<div class="container">
    <br>
    <div style="text-align:center" class="retour">
        <a href="../Settings/Settings.php" style="color: black;"><span
                    class="glyphicon glyphicon-arrow-left"></span></a> Retour
    </div>
    <div style="text-align: center">
        <h3>Statistiques de la structure <?= $structure['nom_structure']; ?></h3>
    </div>
    <div class="row">
        <div class="col-md-6">
            <fieldset class="section-noir">
                <legend class="section-titre-noir">Nombre de bénéficiaires</legend>
                <span id="nombre-beneficiaires"></span>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="section-noir">
                <legend class="section-titre-noir">Actifs</legend>
                <span id="nombre-beneficiaires-actifs"></span>
            </fieldset>
        </div>
    </div>
    <fieldset class="section-noir">
        <legend class="section-titre-noir">Informations bénéficiaires</legend>
        <div class="row">
            <div class="col-md-3">
                <canvas id="repartition-status-actif-chart"></canvas>
            </div>
            <div class="col-md-3">
                <canvas id="repartition-age-chart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="assiduite-chart"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <h4>Pourcentage de présence cette semaine: <span id="pourcentage-presence-semaine"></span></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <h4>Taux de variation de présence: <span id="taux-variation"></span></h4>
            </div>
        </div>
    </fieldset>
    <fieldset class="section-noir">
        <legend class="section-titre-noir">Informations employés</legend>
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <canvas id="repartition-role-chart"></canvas>
        </div>
    </fieldset>
    <fieldset class="section-noir">
        <legend class="section-titre-noir">Créneaux</legend>
        <div class="row">
            <div class="col-md-12">
                <table id="table-assiduite-creneaux" class="stripe hover row-border compact nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Heure de début</td>
                        <td>Heure de fin</td>
                        <td>Jour</td>
                        <td>Assiduité</td>
                    </tr>
                    </thead>
                    <?php
                    foreach ($statsCreneaux as $statsCreneau): ?>
                        <tr>
                            <td>
                                <?= $statsCreneau['nom_creneau']; ?>
                            </td>
                            <td>
                                <?= $statsCreneau['heure_commence']; ?>
                            </td>
                            <td>
                                <?= $statsCreneau['heure_fin']; ?>
                            </td>
                            <td>
                                <?= $statsCreneau['nom_jour']; ?>
                            </td>
                            <td>
                                <?= $statsCreneau['assiduite'] ? $statsCreneau['assiduite'] . " %" : "Pas de données"; ?>
                            </td>
                        </tr>
                    <?php
                    endforeach; ?>
                </table>
            </div>
    </fieldset>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/satistiques.js"></script>
<script src="../../js/fixHeader.js"></script>
</body>
</html>
