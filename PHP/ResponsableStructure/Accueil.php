<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_tableau_seance')) {
    erreur_permission();
}

$id_structure = $_SESSION['id_structure'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Accueil</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/portfolio-item.css">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css-peps-mobile/css-header.css">
    <link rel="stylesheet" href="../../css-peps-mobile/liste.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">
    <link rel="stylesheet" href="../../css/fullCalendar.css">
    <link rel="stylesheet" href="../../css/Loader.css">

    <script type="text/javascript" src="../../js/storage.js"></script>
    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../../js/moment.min.js"></script>
    <script type="text/javascript" src="../../js/datetime-moment.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/bootstrap-multiselect.js"></script>

    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">
</head>
<body>
<div id="preloader"></div>
<?php
require '../header-accueil.php'; ?>

<!-------------------------- Container --------------------------------->
<div class="container" id="main-div">
    <!-- The toast -->
    <div id="toast"></div>

    <?php
    if ($permissions->hasPermission('can_view_tableau_seance')) {
        ?>
        <div id="ConteneurGauche" style="float: left; width : 100%;border: 3px #1E1B7A solid;margin-bottom: 10px;">
            <center>
                <legend id="legendSeance" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                    <center>
                        Séances
                    </center>
                </legend>
            </center>
            <?php
            require 'tableau_seances.php';
            require 'modal_responsable_structure.php';
            require '../Seances/modalDetailsSeance.php';
            require '../partials/warning_modal.php';
            ?>
        </div>
        <?php
    }
    ?>
</div>

<script type="text/javascript" src="../../js/commun.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
<script type="text/javascript" src="../../js/modalDetailsSeance.js"></script>
<script type="text/javascript" src="../../js/modalResponsableStructure.js"></script>
<script type="text/javascript" src="../../js/AccueilResponsableStructure.js"></script>

<script>
    const loader = document.getElementById("preloader");
    window.addEventListener("load", function () {
        loader.style.display = "none";
    });
</script>

</body>
</html>