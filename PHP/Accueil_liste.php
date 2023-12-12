<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../bootstrap/bootstrap.php';

force_connected();

// permet de détecter que l'on est sur la page qui liste les patients non archivés
$page = 'PAGE_PATIENTS_NON_ARCHIVES';

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient')) {
    erreur_permission();
}

//On récupère la valeur idPatient qu'on a transmise dans le lien pour ne pas perdre l'id du patient lors des manipulations
$idPatient = isset($_GET['id_patient']) ? $_GET['id_patient'] : null;
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
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/portfolio-item.css">
    <link rel="stylesheet" href="../css/design.css">
    <link rel="stylesheet" href="../css-peps-mobile/css-header.css">
    <link rel="stylesheet" href="../css-peps-mobile/liste.css">
    <link rel="stylesheet" href="../css/modal-details.css">
    <link rel="stylesheet" href="../css/portfolio-item.css">
    <link rel="stylesheet" href="../css/fullCalendar.css">
    <link rel="stylesheet" href="../css/Loader.css">

    <script type="text/javascript" src="../js/storage.js"></script>
    <script type="text/javascript" src='../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../js/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/moment.min.js"></script>
    <script type="text/javascript" src="../js/datetime-moment.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/fullCalendar/fullCalendar.js"></script>
    <script type="text/javascript" src="../js/bootstrap-multiselect.js"></script>

    <link rel="stylesheet" type="text/css" href="../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../js/DataTables/media/css/customTables.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-multiselect.css">
</head>
<body>
<div id="preloader"></div>
<?php
require 'header-accueil.php';
require 'modalAjoutSeance.php';
require 'Seances/modalDetailsSeance.php';
require 'partials/warning_modal.php';
?>

<!-------------------------- Container --------------------------------->
<div class="container" id="main-div" data-archive="tableau-beneficiaires-non-archives">
    <!-- The toast -->
    <div id="toast"></div>
    <div style="text-align: center;">
        <?php
        if ($permissions->hasRole($permissions::INTERVENANT)):
        ?>
        <button id="liste-beneficiaires" onclick="calendrier.displayTableauBeneficiaires()">Liste des
            bénéficiaires
        </button>
        <button id="calendrier-seance" onclick="calendrier.displayCalendrier()">Calendrier de séances</button>
    </div>
    <?php
    if ($_ENV['ENVIRONNEMENT'] === 'TEST'): ?>
        <div id="supprButton" style="text-align: center;margin-top: 5px">
            <button id="delete-seances" class="btn btn-danger btn-sm">Supprimer les séances</button>
            <script>
                const deleteButton = document.getElementById("delete-seances");
                deleteButton.onclick = () => {
                    fetch('./Seances/DeleteSeancesUser.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            id_user: "<?= $_SESSION['id_user']; ?>",
                        })
                    })
                        .finally(() => {
                            location.reload();
                        });
                }
            </script>
        </div>
    <?php
    endif;
    endif; ?>
    <?php
    if ($permissions->hasPermission('can_view_calendar')): ?>
        <div id="div_cal">
            <form id="structure-choice">
                <div class="radio">
                    <label>
                        <input type="radio" name="structureOption" value="all" checked>
                        Toutes
                    </label>
                </div>
            </form>
            <button id="ajout-modal" type="submit" data-toggle="modal" data-target="#modal" data-backdrop="static"
                    data-keyboard="false">Ajout de séance
            </button>
            <div id="calendar"></div>
            <br>
        </div>
    <?php
    endif; ?>

    <div id="ConteneurGauche" style="float: left; width : 100%;border: 3px #1E1B7A solid; margin-top: 8px">
        <div style="text-align: center">
            <legend id="legendPatient" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                <center>Bénéficiaires</center>
            </legend>
        </div>
        <br>
        <div style="text-align: center">
            <?php
            if ($permissions->hasPermission('can_archive_patient')): ?>
                <button type="submit" id="archive" onclick="location.href='ListePatientArchive.php'">
                    Archive
                </button>
            <?php
            endif; ?>
            <?php
            if ($permissions->hasPermission('can_add_patient')): ?>
                <!-- Bouton permettant de rediriger vers la version de cette page Accueil ou un formulaire dajout est affiché sur la droite-->
                <input type="button" id="boutonAutre" value="Ajouter un bénéficiaire"
                       onclick="self.location.href='Ajout_Benef.php'">
            <?php
            endif; ?>
        </div>

        <?php
        require 'tableau_beneficiaires.php'; ?>
    </div>
</div>

<script type="text/javascript" src="../js/commun.js"></script>
<script type="text/javascript" src="../js/autocomplete.js"></script>
<script type="text/javascript" src="../js/fixHeader.js"></script>
<script type="text/javascript" src="../js/modalDetailsSeance.js"></script>
<script type="text/javascript" src="../js/seance.js"></script>
<script type="text/javascript" src="../js/ListePatient.js"></script>

<script>
    const loader = document.getElementById("preloader");
    window.addEventListener("load", function () {
        loader.style.display = "none";
    });
</script>
</body>
</html>