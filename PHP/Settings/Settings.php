<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);

$id_user = $_SESSION['id_user'];

const PAGE_NAME = 'settings'; // la page actuelle
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administration</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/settings.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap-multiselect.css">

    <!-- jQuery -->
    <script src="../../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/moment.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap-multiselect.js"></script>
</head>

<body>
<?php
require '../header-accueil.php';
require '../Structures/modalStructure.php';
require '../Users/modalUser.php'; ?>

<!-- Modal With Warning -->
<div id="warning" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <p id="warning-text">Quitter sans enregistrer?</p>
                <button id="confirmclosed" type="button" class="btn btn-danger">Oui</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>

<!-- Page Content -->
<div class="container" id="main-div" data-page="<?= PAGE_NAME; ?>">
    <!-- The toast -->
    <div id="toast"></div>
    <!-------------------------- Container, permet de regrouper l'ensemble des icones --------------------------------->
    <div id="conteneurInterieur">
        <br>

        <div style="text-align:center" class="retour">
            Administration
        </div>

        <div style="text-align:center">
            <?php
            if ($permissions->hasPermission('can_view_page_utilisateur') && !$permissions->hasPermission(
                    'can_view_button_mes_utilisateurs'
                )) {
                echo '<button type="button" class="settings" id="boutonAutre" onclick="self.location.href=\'../Users/ListeUser.php\'">Utilisateurs</button>';
            }

            if ($permissions->hasPermission('can_view_page_medecins')) {
                echo '<button type="button" class="settings" id="boutonMedecin" onclick="self.location.href=\'../Medecins/ListeMedecin.php\'">Professionnels de santé</button>';
            }

            if ($permissions->hasPermission('can_view_page_strutures')) {
                echo '<button type="button" class="settings" id="boutonStructure" onclick="self.location.href=\'../Structures/ListeStructure.php\'">Structures</button>';
            }

            if ($permissions->hasPermission('can_view_page_intervenants')) {
                echo '<button type="button" class="settings" id="boutonEducateur" onclick="self.location.href=\'../Intervenants/ListeIntervenant.php\'">Intervenants</button>';
            }

            if ($permissions->hasPermission('can_view_page_creneaux')) {
                echo '<button type="button" class="settings" id="boutonCreneaux" onclick="self.location.href=\'../Creneaux/ListeCreneau.php\'">Créneaux</button>';
            }

            if ($permissions->hasPermission('can_view_page_settings_patient')) {
                echo '<button type="button" class="settings" id="boutonSettingsPatient" onclick="self.location.href=\'../Patients/SettingsPatients.php\'">Bénéficiaires</button>';
            }

            if ($permissions->hasPermission('can_view_page_calendrier_creneaux_types')) {
                echo '<button type="button" class="settings" id="boutonCreneauxTypes" onclick="self.location.href=\'../Creneaux/CreneauxTypes.php\'">Créneaux types</button>';
            }

            if ($permissions->hasRole(Permissions::RESPONSABLE_STRUCTURE)) {
                echo '<button type="button" class="settings" id="boutonBeneficiaires" onclick="self.location.href=\'../Accueil_liste.php\'">Bénéficiaires</button>';
            }
            ?>

            <br>

            <?php
            if ($permissions->hasPermission('can_view_page_statistiques')) {
                echo '<button type="button" class="settings" id="boutonStats" onclick="self.location.href=\'../Statistiques/Statistiques.php\'">Statistiques</button>';
            }

            if ($permissions->hasPermission('can_view_page_tableau_de_bord')) {
                echo '<button type="button" class="settings" id="boutonTableauDeBord" onclick="self.location.href=\'TableauDeBord.php\'">Tableau de bord</button>';
            }

            if ($permissions->hasPermission('can_view_page_export')) {
                echo '<button type="button" class="settings" id="export" onclick="self.location.href=\'../Export/ExportStats.php\'">Export des données</button>';
            }

            if ($permissions->hasPermission('can_view_page_import')) {
                echo '<button type="button" class="settings" id="import" onclick="self.location.href=\'../Import/Import.php\'">Import des données</button>';
            }

            if ($permissions->hasPermission('can_view_page_journal_activite')) {
                echo '<button type="button" class="settings" id="journal_activite" onclick="self.location.href=\'../JournalActivite/JournalActivite.php\'">Journal d\'activité</button>';
            }

            if ($permissions->hasPermission('can_view_page_gestion_notifications_maj')) {
                echo '<button type="button" class="settings" id="notification-version" onclick="self.location.href=\'../Notifications/GestionNotificationsVersions.php\'">Gestions notifications de MAJ</button>';
            }
            ?>

            <?php
            if ($permissions->hasPermission('can_view_page_logs')) {
                echo '<br><button type="button" class="settings" id="boutonStats" onclick="self.location.href=\'../Logs/Logs.php\'">Logs</button>';
            }
            ?>

            <br><br><br>

            <!-- Icone Mon compte -->
            <button type="button" class="settings" id="mon-compte" data-toggle="modal" data-target="#modal-user"
                    data-backdrop="static"
                    data-keyboard="false">Mon compte
            </button>
            <?php
            if ($permissions->hasPermission('can_view_page_mes_creneaux')) {
                echo '<button type="button" class="settings" id="mes-creneaux" onclick="self.location.href=\'../Creneaux/MesCreneaux.php\'">Mes Créneaux</button>';
            }
            ?>

            <?php
            if ($permissions->hasPermission('can_view_button_ma_structure')) : ?>
                <button type="button" class="settings" id="ma-structure" data-toggle="modal"
                        data-target="#modalStructure"
                        data-backdrop="static"
                        data-keyboard="false">Ma structure
                </button>
            <?php
            endif; ?>

            <?php
            if ($permissions->hasPermission('can_view_button_mes_utilisateurs')) : ?>
                <button type="button" class="settings" id="boutonAutre"
                        onclick="self.location.href='../Users/ListeUser.php'">Mes utilisateurs
                </button>
            <?php
            endif; ?>
        </div>
    </div>
</div>
<!-- /content -->

<script src="../../js/commun.js"></script>
<script src="../../js/autocomplete.js"></script>
<script src="../../js/modalStructure.js"></script>
<script src="../../js/modalUser.js"></script>
<script src="../../js/Settings.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>
