<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_journal_activite')) {
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

    <title>Journal d'activité</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

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

    <div style="float: left; width : 100%;border: 3px #1E1B7A solid;">
        <div style="text-align:center">
            <legend id="legend-journal" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                Journal d'activité
            </legend>
        </div>
        <br>
        <div style="text-align: center">
            <div class="body" style="width: 100%;border : 3px #fdfefe solid;">
                <table id="table-journal" class="stripe hover row-border compact nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th>id_journal_activite</th>
                        <th>id_user_acteur</th>
                        <th>nom_acteur</th>
                        <th>type_action</th>
                        <th>type_cible</th>
                        <th>nom_cible</th>
                        <th>id_cible</th>
                        <th>date_action</th>
                    </tr>
                    </thead>
                    <tbody id="body-journal"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<br>

<script src="../../js/journal_activite.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>

