<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_export')) {
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

    <title>Export des données</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/colvis_button.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/moment.min.js"></script>
</head>

<body>
<?php
require '../header-accueil.php'; ?>
<br>
<!-- Page Content -->
<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <div style="text-align:center" class="retour">
        <a href="../Settings/Settings.php" style="color: black;"><span
                    class="glyphicon glyphicon-arrow-left"></span></a> Retour
    </div>
    <div id="main-div" style="float: left; width : 100%;border: 3px #1E1B7A solid;"
         data-id_territoire="<?= $_SESSION['id_territoire']; ?>">
        <div style="text-align:center">
            <legend id="legendPatient" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                Export des données ONAPS
            </legend>
        </div>
        <br>
        <div style="text-align: left">
            <form id="export-patient-data-sante">
                <div class="row">
                    <div class="col-md-1" style="text-align: right">
                        <label for="year-patient-data-sante" class="control-label">Année</label>
                    </div>
                    <div class="col-md-3">
                        <select id="year-patient-data-sante" name="year" class="form-control">
                            <option value="-1">Toutes les années</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Télécharger données (en csv)
                        </button>
                    </div>
                </div>
            </form>

            <br><br><br>
        </div>
        <br>
    </div>
    <br>
</div>

<br>

<?php
if ($permissions->hasPermission('can_export_medecins_prescripteur_data')): ?>
    <div class="container">
        <div style="float: left; width : 100%;border: 3px #1E1B7A solid;">
            <div style="text-align:center">
                <legend id="legendPatient" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                    Export données médecins prescripteurs
                </legend>
            </div>
            <br>
            <div style="text-align: center">
                <div class="body" style="width: 100%;border : 3px #fdfefe solid;">
                    <table id="table-medecins" class="stripe hover row-border compact nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>Nombre de prescription</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléphone portable</th>
                            <th>Téléphone fixe</th>
                            <th>Email</th>
                            <th>Poste</th>
                            <th>Spécialité</th>
                            <th>Adresse</th>
                            <th>Complement d'adresse</th>
                            <th>Code postal</th>
                            <th>Ville</th>
                        </tr>
                        </thead>
                        <tbody id="body-medecins"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
endif; ?>

<br>

<?php
if ($permissions->hasPermission('can_export_patient_data')): ?>
    <div class="container">
        <div style="float: left; width : 100%;border: 3px #1E1B7A solid;">
            <div style="text-align:center">
                <legend id="legendPatient" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                    Export données bénéficiaires
                </legend>
            </div>
            <br>
            <div class="body" style="width: 100%;border : 3px #fdfefe solid;">
                <table id="table-patient" class="stripe hover row-border compact nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone portable</th>
                        <th>Téléphone fixe</th>
                        <th>Email</th>
                        <th>Ville</th>
                        <th>Adresse</th>
                        <th>Médecin prescripteur</th>
                        <th>Médecin traitant</th>
                        <th>Orientation</th>
                        <th>Antenne</th>
                        <th>ALDs</th>
                        <th>Date d'inclusion</th>
                    </tr>
                    </thead>
                    <tbody id="body-patient"></tbody>
                </table>
            </div>
        </div>
    </div>
<?php
endif; ?>

<script src="../../js/ExportStats.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>

