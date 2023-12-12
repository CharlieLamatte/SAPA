<?php
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_import')) {
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

    <title>Import des données</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

    <script type="text/javascript" src='../../js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/moment.min.js"></script>
</head>

<body>
<?php require '../header-accueil.php'; ?>
<br>
<!-- Page Content -->
<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <div style="text-align:center" class="retour">
        <a href="../Settings/Settings.php" style="color: black;"><span
                    class="glyphicon glyphicon-arrow-left"></span></a> Retour
    </div>
    <div id="ConteneurGauche" style="width : 100%;border: 3px #1E1B7A solid;">
        <div style="text-align:center">
            <legend id="legendPatient" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                Import des données
            </legend>
        </div>
        <br>
        <form id="form" style="max-width: 250px; text-align: center; margin: auto">
            <label for="login">Login:</label>
            <input id="login" class="form-control" type="text" required>
            <br>
            <label for="pw">Mot de passe:</label>
            <input id="pw" class="form-control" type="password" required>
            <br><br>
            <div style="text-align: center">
                <button type="submit" class="btn btn-primary" id="import-structures">Importer les structures</button>
            </div>
            <br><br><br>
            <div style="text-align: center">
                <button type="submit" class="btn btn-primary" id="import-intervenants">Importer les intervenants
                </button>
            </div>
            <br><br><br>
            <div style="text-align: center">
                <button type="submit" class="btn btn-primary" id="import-creneaux">Importer les créneaux</button>
            </div>
            <br><br><br>
            <div style="text-align: center" hidden>
                <button type="submit" class="btn btn-primary" id="affiche-diplomes" disabled >Afficher la liste des
                    diplomes
                </button>
            </div>
            <br><br><br>
        </form>
    </div>
</div>

<script src="../../js/Import.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>

