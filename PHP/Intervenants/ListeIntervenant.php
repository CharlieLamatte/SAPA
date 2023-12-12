<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_intervenants')) {
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

    <title>Intervenants</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/separator.css">

    <script type="text/javascript" src='../../js/DataTables/media/js/jquery.js'></script>
    <script type="text/javascript" src="../../js/DataTables/media/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/moment.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../js/DataTables/media/css/customTables.css">
</head>

<body>
<?php
require '../header-accueil.php'; ?>

<form method="POST" class="form-horizontal" id="form-intervenant">
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <fieldset class="can-disable">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="modal-title">Modal title</h3>
                    </div>
                    <div class="modal-body">
                        <div id="section-update-or-create">
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Coordonnées</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="id_territoire">Territoire<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="id_territoire" id="id_territoire" class="form-control"
                                            <?php
                                            if (!$permissions->hasPermission('can_edit_territoire_intervenant')) {
                                                echo('disabled');
                                            } ?>
                                        >
                                            <?php
                                            $territoire = new \Sportsante86\Sapa\Model\Territoire($bdd);

                                            $territoires = $territoire->readAll(
                                                $_SESSION,
                                                \Sportsante86\Sapa\Model\Territoire::TYPE_TERRITOIRE_DEPARTEMENT
                                            ) ?? [];
                                            foreach ($territoires as $data) {
                                                echo '<option value="' . $data["id_territoire"] . '"';
                                                if (!$permissions->hasRole(Permissions::SUPER_ADMIN)) {
                                                    if ($data['id_territoire'] == $_SESSION['id_territoire']) {
                                                        echo ' selected="selected"';
                                                    }
                                                }
                                                echo '>' . $data["nom_territoire"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button id="create_user" class="btn btn-success" style="display: none">Créer
                                            comme
                                            utilisateur
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom">Nom <span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nom" name="nom" value="" class="form-control input-md" required
                                               type="text" maxlength="50">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="prenom">Prénom <span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="prenom" name="prenom" value="" class="form-control input-md" required
                                               type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="tel-portable">Téléphone 1</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="tel-portable" name="tel" value="" class="form-control input-md"
                                               type="text" minlength="10" maxlength="10" placeholder="0XXXXXXXXX">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="tel-fixe">Téléphone 2</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="tel-fixe" name="telF" value="" class="form-control input-md"
                                               type="text"
                                               minlength="10" maxlength="10" placeholder="0XXXXXXXXX">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="email">Email</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input id="email" name="email" value="" class="form-control" type="email"
                                               maxlength="100" placeholder="xxxxx@xxxx.xxx"
                                               pattern="[a-zA-Z0-9._\-]+[@][a-zA-Z0-9._\-]+[.][a-zA-Z.]{2,15}">
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Données professionnelles</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="statut">Statut<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="statut" id="statut" class="form-control">
                                            <?php
                                            $query = $bdd->prepare(
                                                'SELECT id_statut_intervenant, nom_statut_intervenant FROM statuts_intervenant ORDER BY nom_statut_intervenant'
                                            );
                                            $query->execute();
                                            while ($data = $query->fetch()) {
                                                echo '<option value="' . $data['id_statut_intervenant'] . '">' . $data['nom_statut_intervenant'] . '</option>';
                                            }
                                            $query->CloseCursor();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="numero_carte">Numéro de carte</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="numero_carte" name="numero_carte" value=""
                                               class="form-control input-md"
                                               type="text" maxlength="11">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Diplômes</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div id="liste-diplome"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="diplome">Ajouter un diplôme</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="diplome" id="diplome" class="form-control">
                                            <option value="-1"></option>
                                            <?php
                                            $query = $bdd->prepare(
                                                'SELECT id_diplome, nom_diplome FROM diplome ORDER BY nom_diplome'
                                            );
                                            $query->execute();
                                            while ($data = $query->fetch()) {
                                                echo '<option value="' . $data['id_diplome'] . '">' . $data['nom_diplome'] . '</option>';
                                            }
                                            $query->CloseCursor();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-success" id="add-diplome">Add</button>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="group-modal" id="row-structtures">
                                <legend class="group-modal-titre">Structures d'intervention</legend>
                                <div id="liste-structure">

                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="add-structure">Ajouter une structure:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input id="add-structure" name="add-structure" class="form-control"
                                               placeholder="Taper les premières lettres du nom de la structure"
                                               type="text">
                                    </div>
                                </div>
                                <br>
                            </fieldset>

                            <fieldset class="group-modal" id="creneaux">
                                <legend class="group-modal-titre">Créneaux de l'intervenant</legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="tableau-creneaux"
                                                   class="table table-bordered table-striped table-hover table-condensed"
                                                   style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Type</th>
                                                    <th>Jour</th>
                                                    <th>Heure début</th>
                                                    <th>Durée</th>
                                                </tr>
                                                </thead>
                                                <tbody id="body-creneaux"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div id="section-fusion-intervenant">
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Fusion</legend>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="add-intervenant-1">Ajouter l'intervenant 1:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input id="add-intervenant-1" name="add-intervenant-1" class="form-control"
                                               placeholder="Taper les premières lettres de l'intervenant" type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom-1">Nom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nom-1" name="nom-1" value="" class="form-control input-md" required
                                               type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="prenom-1">Prénom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="prenom-1" name="prenom-1" value="" class="form-control input-md"
                                               required
                                               type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="id-intervenant-1">Id<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="id-intervenant-1" name="id-intervenant-1"
                                               class="form-control input-md" type="text" required readonly>
                                    </div>
                                </div>

                                <hr class="solid-pink">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="add-intervenant-2">Ajouter l'intervenant 2:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input id="add-intervenant-2" name="add-intervenant-2" class="form-control"
                                               placeholder="Taper les premières lettres de l'intervenant" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom-2">Nom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nom-2" name="nom-2" value="" class="form-control input-md" required
                                               type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="prenom-2">Prénom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="prenom-2" name="prenom-2" value="" class="form-control input-md"
                                               required
                                               type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="id-intervenant-2">Id<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="id-intervenant-2" name="id-intervenant-2"
                                               class="form-control input-md" type="text" required readonly>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </fieldset>
                <div class="modal-footer">
                    <!-- Boutons à droite -->
                    <button id="enregistrer-modifier" type="submit" name="valid-entInitial"
                            class="btn btn-success">Modifier
                    </button>

                    <?php
                    if ($permissions->hasPermission('can_delete_intervenants')) : ?>
                        <button id="delete" type="submit" name="delete"
                                class="btn btn-danger pull-right">
                            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                            Supprimer
                        </button>
                    <?php
                    endif; ?>

                    <!-- Boutons à gauche -->
                    <button id="close" type="button" data-dismiss="modal" class="btn btn-warning pull-left">Abandon
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

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
<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <div style="text-align:center" class="retour">
        <a href="../Settings/Settings.php" style="color: black;"><span
                    class="glyphicon glyphicon-arrow-left"></span></a> Retour
    </div>
    <div id="ConteneurGauche" style="float: left; width : 100%;border: 3px #1E1B7A solid;">
        <div style="text-align:center">
            <legend id="legendPatient" style="border-bottom: 1px solid #1E1B7A;background-color: #1E1B7A; ">
                Intervenants
            </legend>
        </div>

        <div style="text-align:center">
            <br>
            <input value="Ajouter un intervenant"
                   id="ajout-modal" type="button" data-toggle="modal" data-target="#modal" data-backdrop="static"
                   data-keyboard="false">
            <?php
            if ($permissions->hasPermission('can_fuse_intervenant')): ?>
                <input value="Fusionner deux intervenants"
                       id="fusion-modal-intervenant" type="button" data-toggle="modal" data-target="#modal"
                       data-backdrop="static"
                       data-keyboard="false">
            <?php
            endif; ?>
        </div>

        <div class="body" style="width: 100%;border : 3px #fdfefe solid;">
            <table id="table_id" class="stripe hover row-border compact nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone 1</th>
                    <th>Téléphone 2</th>
                    <th>E-mail</th>
                    <th>Utilisateur?</th>
                    <th>Structure</th>
                    <th>Détails</th>
                </tr>
                </thead>
                <tbody id="body-intervenant"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="../../js/commun.js"></script>
<script src="../../js/ListeIntervenant.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>