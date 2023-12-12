<?php

use Sportsante86\Sapa\Outils\FilesManager;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_logs')) {
    erreur_permission();
}

$logs = FilesManager::find_all_files($root . '/logs/');
$logs = array_filter($logs, function ($var)  {
    return basename($var)[0] != '.'; // on enlève les fichiers dont le nom commence par '.'
});
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fichiers de logs</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>
<?php
require '../header-accueil.php';
require '../partials/warning_modal.php'; ?>

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
            <legend style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A;">
                Fichiers de logs
            </legend>
        </div>
        <br>
        <div style="text-align: center">
            <?php foreach ($logs as $log): ?>
                <a href="../../Outils/DownloadLog.php?filename=<?= basename($log); ?>" onclick="window.open(this.href); return false;">Télécharger: <?= basename($log); ?></a><br>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<br>

<script src="../../js/commun.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>