<?php

use Sportsante86\Sapa\Model\Orientation;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_orientation')) {
    erreur_permission();
}

$idPatient = $_GET['idPatient'];

$orientation = new Orientation($bdd);
$map_url = $orientation->getMapUrl($idPatient);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Orientation</title>

    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/sante.css">
    <link rel="stylesheet" href="../../css/synthese.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">

    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">
</head>

<body>
<?php
require '../header.php';
require '../Structures/modalStructure.php';
require '../Creneaux/modalCreneau.php'; ?>

<!-- Page Content -->
<div class="panel-body" style="margin-left: 20px; margin-right: 20px;" id="main-div">
    <!-- The toast -->
    <div id="toast"></div>

    <!--cette div correspond à la carte de référencement-->
    <div style="overflow: hidden; border-top: solid; position: relative; padding-top: 56.25%;">
        <iframe src='<?= $map_url; ?>' style='position: absolute; width:100%; height:100%; top: -120px'>
            <p>
                <a href='<?= $map_url; ?>'>
                    Un lien à utiliser dans les cas où les navigateurs ne supportent
                    pas les <i>iframes</i>.
                </a>
            </p>
        </iframe>
    </div>

    <div style="text-align: center">
        <button type="button" class="btn btn-primary" id="ajout-modal-structure" data-toggle="modal"
                data-target="#modalStructure"
                data-backdrop="static"
                data-keyboard="false">Ajouter une nouvelle structure
        </button>
        <button id="creneau-modal" class="btn btn-primary" data-toggle="modal" data-target="#modal"
                data-backdrop="static" data-keyboard="false">
            Ajouter un créneau hors dispositif PEPS
        </button>
    </div>

    <form id="form" data-id_patient="<?php
    echo $idPatient; ?>">
        <fieldset class="section-bleu">
            <legend class="section-titre-bleu">Activités
                choisies
            </legend>

            <div id="abody"></div>

            <div style="text-align: center">
                <button type="button" class="btn btn-primary" id="ajout-activite">
                    Ajouter une nouvelle activité
                </button>
            </div>
        </fieldset>

        <br>

        <div style="text-align: center">
            <input type="submit" name="soumettre" value="Valider" class="btn btn-success">
        </div>
    </form>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/autocomplete.js"></script>
<script src="../../js/modalCreneau.js"></script>
<script src="../../js/modalStructure.js"></script>
<script src="../../js/Orientation.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>