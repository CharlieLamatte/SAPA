<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_utilisateur')) {
    erreur_permission();
}

const PAGE_NAME = 'liste_user'; // la page actuelle
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Utilisateurs</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">

    <link rel="stylesheet" type="text/css" href="../../css/bootstrap-multiselect.css">
    <script type="text/javascript" src="../../js/bootstrap-multiselect.js"></script>
</head>

<body>
<?php
require '../header-accueil.php'; ?>

<?php
function createHiddenField($name, $value)
{
    if (is_array($value)) {
        $hiddenFiels = '';

        foreach ($value as $array_value) {
            $hiddenFiels .= '<input type="hidden" name="post_' . $name . '[]" value="' . $array_value . '">';
        }

        return $hiddenFiels;
    } else {
        return '<input type="hidden" name="post_' . $name . '" value="' . $value . '">';
    }
}

function createHiddenForm($data, $id)
{
    $form = '<form id="' . $id . '">';

    foreach ($data as $key => $value) {
        $form .= createHiddenField($key, $value);
    }

    $form .= '</form>';

    return $form;
}

//creation d'un form hidden si on reçoit des données en POST d'un intervenant
if (count($_POST) > 0 && isset($_POST['id_intervenant'])) {
    echo createHiddenForm($_POST, 'create_intervenant');
}
?>

<?php
require 'modalUser.php'; ?>

<!-- Modal With Warning -->
<div id="warning" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <p id="warning-text">Quitter sans enregistrer?</p>
                <button id="confirmclosed" type="button" class="btn btn-danger">Oui</button>
                <button id="refuseclosed" type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>

<br>
<!-- Page Content -->
<div class="container" id="main-div" data-page="<?= PAGE_NAME; ?>">
    <!-- The toast -->
    <div id="toast"></div>

    <div style="text-align:center" class="retour">
        <a href="../Settings/Settings.php" style="color: black;"><span
                    class="glyphicon glyphicon-arrow-left"></span></a> Retour
    </div>
    <div id="ConteneurGauche" style="float: left; width : 100%;border: 3px #1E1B7A solid;">
        <div style="text-align:center">
            <legend id="legendPatient" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                Utilisateurs
            </legend>
        </div>

        <?php
        if ($permissions->hasPermission('can_add_utilisateur')): ?>
            <br>
            <div style="text-align:center">
                <input value="Ajouter un utilisateur"
                       id="ajout-modal" type="button" data-toggle="modal" data-target="#modal-user"
                       data-backdrop="static"
                       data-keyboard="false">
            </div>
        <?php
        endif; ?>

        <div class="body" style="width: 100%;border : 3px #fdfefe solid;">
            <table id="table_id" class="stripe hover row-border compact nowrap" style="width:100%">
                <thead>
                <tr>
                    <?php
                    if ($permissions->hasPermission('can_edit_territoire_utilisateur')): ?>
                        <th>Territoire</th>
                    <?php
                    endif; ?>
                    <th>Rôle</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone 1</th>
                    <th>Téléphone 2</th>
                    <th>Email</th>
                    <th>Nom de la structure</th>
                    <th>Type de structure</th>
                    <th>Détails</th>
                </tr>
                </thead>
                <tbody id="body-user"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/modalUser.js"></script>
<script src="../../js/ListeUser.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>