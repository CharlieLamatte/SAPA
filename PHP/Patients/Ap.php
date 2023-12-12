<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_activite_physique')) {
    erreur_permission();
}

$idPatient = $_GET['idPatient']; // Récupération idPatient
$iduser = $_SESSION['id_user'];//recuperation iduser

$heuresOptions = "";
$stmt = $bdd->prepare('SELECT id_heure, heure  FROM heures');
$stmt->execute();
while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $heuresOptions .= '<option value="' . $data['id_heure'] . '">' . $data['heure'] . '</option>';
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

    <title>Activité physique</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/design.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/sante.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">

    <script type="text/javascript" src='../../js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>
<?php
require '../header.php'; ?>

<!-- ==========================================================================POUR ACTIVITE PHYSIQUE ANTERIEURE ===================================================================== -->
<div class="container" id="main" data-id_patient="<?php
echo $idPatient; ?>">
    <form class="form-horizontal" id="form-activite-physique" data-id_patient="<?php
    echo $idPatient ?>">
        <div style="margin-left : 5%; width: 90%; margin-right: 5%;">
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="section-bleu">
                        <legend class="section-titre-bleu">
                            Activité physique antérieure
                        </legend>
                        <div class="row text-center">
                            <div class="radio">
                                <div class="col-md-12">
                                    <label class="radio-inline">
                                        <input type="radio" class="field-activite-physique" name="a-activite-anterieure"
                                               id="a-activite-anterieure-oui"
                                               value="1" required>Oui
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" class="field-activite-physique" name="a-activite-anterieure"
                                               id="a-activite-anterieure-non"
                                               value="0" checked>Non
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="detail-anterieure-row" style="display: none">
                            <div class="col-md-12">
                        <textarea id="activite_anterieure_textarea" class="field-activite-physique" rows="6" cols="80"
                                  style="width : 100%; resize: none;"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <!-- ========================================================================== POUR ACTIVITE PHYSIQUE AUTONOME ===================================================================== -->
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="section-bleu">
                        <legend class="section-titre-bleu">
                            Activité physique actuelle<span class="infobulle"
                                                            aria-label="Interrogez les bénéficiaires sur les pratiques d'AP d'aujourd'hui"><img
                                        src="../../images/help.png" width="25px"/> </span></legend>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="section-bleu">
                                    <legend class="section-titre-bleu">
                                        Autonome<span class="infobulle"
                                                      aria-label="Pratique qui ne dépend de personne, réalisée sans structure"><img
                                                    src="../../images/help.png" width="25px"/> </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-activite-physique"
                                                           name="a-activite-autonome"
                                                           id="a-activite-autonome-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-activite-physique"
                                                           name="a-activite-autonome"
                                                           id="a-activite-autonome-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-autonome-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea id="activite_physique_autonome_textarea" class="field-activite-physique"
                                              rows="6" cols="95" style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <!-- ========================================================================== POUR ACTIVITE PHYSIQUE ENCADREE ===================================================================== -->
                            <div class="col-md-6">
                                <fieldset class="section-bleu">
                                    <legend class="section-titre-bleu">
                                        Encadrée<span class="infobulle"
                                                      aria-label="AP pratiquée en structure avec un éducateur/enseignant"><img
                                                    src="../../images/help.png" width="25px"/> </span></legend>
                                    <div class="row text-center">
                                        <div class="radio">
                                            <div class="col-md-12">
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-activite-physique"
                                                           name="a-activite-encadree"
                                                           id="a-activite-encadree-oui"
                                                           value="1" required>Oui
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" class="field-activite-physique"
                                                           name="a-activite-encadree"
                                                           id="a-activite-encadree-non"
                                                           value="0" checked>Non
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="detail-encadree-row" style="display: none">
                                        <div class="col-md-12">
                                    <textarea id="activite_physique_encadree_textarea" class="field-activite-physique"
                                              rows="6" cols="95" style="width : 100%; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <!-- ========================================================================== POUR DISPONIBILITE ===================================================================== -->
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="section-bleu">
                        <legend class="section-titre-bleu">
                            Disponibilité<span class="infobulle"
                                               aria-label="Horaires préférentiels des bénéficiaires pour pratiquer l'AP"><img
                                        src="../../images/help.png" width="25px"/> </span></legend>
                        <div class="row" id="detail-disponibilite-row" style="display: none; margin-bottom: 10px">
                            <div class="col-md-2"><label class="control-label">Données précédentes:</label></div>
                            <div class="col-md-8">
                        <textarea id="disponibilite_textarea" class="field-activite-physique" rows="4"
                                  style="width : 100%; resize: none;" disabled></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label><input id="jour-lundi" name="jour-lundi" type="checkbox"
                                                  value="1">Lundi</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="heures-lundi-row" style="display: none">
                                <div class="input-group">
                                    <span class="input-group heures-span">
                                        <label class="input-group-addon" for="heure-debut-lundi">De</label>
                                        <select name="heure-debut-lundi" id="heure-debut-lundi" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                        <label class="input-group-addon" for="heure-fin-lundi">à</label>
                                        <select name="heure-fin-lundi" id="heure-fin-lundi" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label><input id="jour-mardi" name="jour-mardi" type="checkbox"
                                                  value="1">Mardi</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="heures-mardi-row" style="display: none">
                                <div class="input-group">
                                    <span class="input-group heures-span">
                                        <label class="input-group-addon" for="heure-debut-mardi">De</label>
                                        <select name="heure-debut-mardi" id="heure-debut-mardi" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                        <label class="input-group-addon" for="heure-fin-mardi">à</label>
                                        <select name="heure-fin-mardi" id="heure-fin-mardi" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label><input id="jour-mercredi" name="jour-mercredi" type="checkbox" value="1">Mercredi</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="heures-mercredi-row" style="display: none">
                                <div class="input-group">
                                    <span class="input-group heures-span">
                                        <label class="input-group-addon" for="heure-debut-mercredi">De</label>
                                        <select name="heure-debut-mercredi" id="heure-debut-mercredi"
                                                class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                        <label class="input-group-addon" for="heure-fin-mercredi">à</label>
                                        <select name="heure-fin-mercredi" id="heure-fin-mercredi" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label><input id="jour-jeudi" name="jour-jeudi" type="checkbox"
                                                  value="1">Jeudi</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="heures-jeudi-row" style="display: none">
                                <div class="input-group">
                                    <span class="input-group heures-span">
                                        <label class="input-group-addon" for="heure-debut-jeudi">De</label>
                                        <select name="heure-debut-jeudi" id="heure-debut-jeudi" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                        <label class="input-group-addon" for="heure-fin-jeudi">à</label>
                                        <select name="heure-fin-jeudi" id="heure-fin-jeudi" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label><input id="jour-vendredi" name="jour-vendredi" type="checkbox" value="1">Vendredi</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="heures-vendredi-row" style="display: none">
                                <div class="input-group">
                                    <span class="input-group heures-span">
                                        <label class="input-group-addon" for="heure-debut-vendredi">De</label>
                                        <select name="heure-debut-vendredi" id="heure-debut-vendredi"
                                                class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                        <label class="input-group-addon" for="heure-fin-vendredi">à</label>
                                        <select name="heure-fin-vendredi" id="heure-fin-vendredi" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label><input id="jour-samedi" name="jour-samedi" type="checkbox"
                                                  value="1">Samedi</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="heures-samedi-row" style="display: none">
                                <div class="input-group">
                                    <span class="input-group heures-span">
                                        <label class="input-group-addon" for="heure-debut-samedi">De</label>
                                        <select name="heure-debut-samedi" id="heure-debut-samedi" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                        <label class="input-group-addon" for="heure-fin-samedi">à</label>
                                        <select name="heure-fin-samedi" id="heure-fin-samedi" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label><input id="jour-dimanche" name="jour-dimanche" type="checkbox" value="1">Dimanche</label>
                                </div>
                            </div>
                            <div class="col-md-6" id="heures-dimanche-row" style="display: none">
                                <div class="input-group">
                                    <span class="input-group heures-span">
                                        <label class="input-group-addon" for="heure-debut-dimanche">De</label>
                                        <select name="heure-debut-dimanche" id="heure-debut-dimanche"
                                                class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                        <label class="input-group-addon" for="heure-fin-dimanche">à</label>
                                        <select name="heure-fin-dimanche" id="heure-fin-dimanche" class="form-control">
                                            <?= $heuresOptions; ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <!-- ========================================================================== POUR ACTIVITES PHYSIQUE ENVISAGEE ===================================================================== -->
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="section-bleu">
                        <legend class="section-titre-bleu">
                            Activité physique envisagée<span class="infobulle"
                                                             aria-label="Interrogez les bénéficiaires sur les pratiques d'AP qu'ils souhaitent ou aimeraient faire"><img
                                        src="../../images/help.png" width="25px"/> </span></legend>
                        <div class="row text-center">
                            <div class="radio">
                                <div class="col-md-12">
                                    <label class="radio-inline">
                                        <input type="radio" class="field-activite-physique" name="a-activite-envisagee"
                                               id="a-activite-envisagee-oui"
                                               value="1" required>Oui
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" class="field-activite-physique" name="a-activite-envisagee"
                                               id="a-activite-envisagee-non"
                                               value="0" checked>Non
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="detail-envisagee-row" style="display: none">
                            <div class="col-md-12">
                        <textarea id="activite_envisagee_textarea" class="field-activite-physique" rows="6" cols="95"
                                  style="width : 100%; resize: none;"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <!-- ========================================================================== POUR FREINS A L'ACTIVITE ===================================================================== -->
            <div class="row">
                <div class="col-md-6">
                    <fieldset class="section-bleu">
                        <legend class="section-titre-bleu">
                            Freins à l'activité physique<span class="infobulle"
                                                              aria-label="Les contraintes éventuelles liées à l'environnement, le travail, les croyances,..."><img
                                        src="../../images/help.png" width="25px"/> </span></legend>
                        <div class="row text-center">
                            <div class="radio">
                                <div class="col-md-12">
                                    <label class="radio-inline">
                                        <input type="radio" class="field-activite-physique" name="a-activite-frein"
                                               id="a-activite-frein-oui"
                                               value="1" required>Oui
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" class="field-activite-physique" name="a-activite-frein"
                                               id="a-activite-frein-non"
                                               value="0" checked>Non
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="detail-frein-row" style="display: none">
                            <div class="col-md-12">
                        <textarea id="frein_activite_textarea" class="field-activite-physique" rows="6" cols="95"
                                  style="width : 100%; resize: none;"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <!-- ========================================================================== POUR POINTS FORT ===================================================================== -->
                <div class="col-md-6">
                    <fieldset class="section-bleu">
                        <legend class="section-titre-bleu">
                            Points forts / Ressources / Leviers <span class="infobulle"
                                                                      aria-label="Moyen d'action permettant la pratique de l'AP"><img
                                        src="../../images/help.png" width="25px"/> </span></legend>
                        <div class="row text-center">
                            <div class="radio">
                                <div class="col-md-12">
                                    <label class="radio-inline">
                                        <input type="radio" class="field-activite-physique"
                                               name="a-activite-point-fort-levier"
                                               id="a-point-fort-levier-oui"
                                               value="1" required>Oui
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" class="field-activite-physique"
                                               name="a-activite-point-fort-levier"
                                               id="a-point-fort-levier-non"
                                               value="0" checked>Non
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="detail-point-fort-levier-row" style="display: none">
                            <div class="col-md-12">
                        <textarea id="point_fort_levier_textarea" rows="6" cols="80" class="field-activite-physique"
                                  style="width : 100%; resize: none;"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <div class="row" style="text-align: center">
                <div class="col-md-12">
                    <input value="Enregistrer les modifications"
                           id="modifier-pathologie" type="button" class="btn btn-success">
                </div>
            </div>

            <br>
        </div>
    </form>

    <!-- The toast -->
    <div id="toast"></div>
</div>

<script type="text/javascript" src="../../js/ActivitePhysique.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>
