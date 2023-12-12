<?php

use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);

$idPatient = $_GET['idPatient'];

$p = new Patient($bdd);
$patient = $p->readOne($idPatient);
if (!$patient) {
    erreur_invalid_page();
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

    <title>Modification Autres Infos</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/ModifAutresInfos.css">
    <link rel="stylesheet" href="../../css/Ajout_Benef.css">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>

<!-- Page Content -->
<?php
require '../header.php'; ?>
<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <div class="panel-body">
        <div style="text-align: center">
            <legend style="color:black">
                <a href="AccueilPatient.php?idPatient=<?php
                echo $idPatient ?>"
                   style="color: black; margin-right: 50px;" class="btn btn-success btn-xs"><span
                        class="glyphicon glyphicon-arrow-left"></span></a>Retour
            </legend>
            <form class="form-horizontal" method="POST"
                  action="UpdatePatientAutresInfos.php?idPatient=<?php
                  echo $idPatient ?>">
                <div class="row" style="text-align: center">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6">
                        <fieldset class="group-section">
                            <legend class="group-section-titre">Autres informations</legend>
                            <input id="id_patient" name="id_patient" value="<?= $idPatient; ?>"
                                   class="form-control input-md" type="hidden">
                            <?php
                            if (!$permissions->hasRole(Permissions::COORDONNATEUR_PEPS)): ?>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center">
                                        <legend class="legend_petit_titre">
                                            Programme PEPS
                                        </legend>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-6" style="text-align: right">
                                        <label class="control-label" for="est-non-peps">Extérieur au programme PEPS:
                                            <span style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-3" style="text-align: left">
                                        <input type="checkbox" id="est-non-peps" name="est-non-peps"
                                               value="checked" <?php
                                        if ($patient['est_non_peps'] == 1) {
                                            echo 'checked';
                                        } ?>>
                                    </div>
                                </div>
                            <?php
                            endif; ?>
                            <div class="row">
                                <div class="col-md-12" style="text-align: center">
                                    <legend class="legend_petit_titre">
                                        Prise en charge financière
                                    </legend>
                                </div>
                            </div>
                            <input id="id_patient" name="id_patient" value="<?= $idPatient; ?>"
                                   class="form-control input-md" type="hidden">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <label class="control-label" for="est-pris-en-charge">Pris en charge financièrement:</label>
                                </div>
                                <div class="col-md-3" style="text-align: left">
                                    <input type="checkbox" id="est-pris-en-charge" name="est-pris-en-charge"
                                           value="checked" <?php
                                    if ($patient['est_pris_en_charge_financierement'] != null && $patient['est_pris_en_charge_financierement'] == 1) {
                                        echo 'checked';
                                    } ?>>
                                </div>
                            </div>
                            <div class="row"
                                 id="prise-en-charge-tr" <?php
                            if ($patient['est_pris_en_charge_financierement'] != null && $patient['est_pris_en_charge_financierement'] == 0) {
                                echo 'hidden="hidden"';
                            } ?>>
                                <div class="col-md-1"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <label class="control-label" for="hauteur-prise-en-charge">Hauteur de la prise en
                                        charge en
                                        charge (en %): <span style="color: red">*</span></label>

                                </div>
                                <div class="col-md-3" style="text-align: left">
                                    <input type="number" id="hauteur-prise-en-charge" name="hauteur-prise-en-charge"
                                           max="100"
                                           min="0" step="1" placeholder="0-100"
                                           value="<?php
                                           if ($patient['est_pris_en_charge_financierement'] != null && $patient['est_pris_en_charge_financierement'] == 1) {
                                               echo $patient['hauteur_prise_en_charge_financierement'];
                                           } ?>"
                                           required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align: center">
                                    <legend class="legend_petit_titre">
                                        Situations particulières
                                    </legend>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <label for="sit_part_prevention_chute">Prévention de la chute</label>
                                </div>
                                <div class="col-md-3" style="text-align: left">
                                    <input type="checkbox" name="sit_part_prevention_chute"
                                           id="sit_part_prevention_chute"
                                           value="checked" <?php
                                    if ($patient['sit_part_prevention_chute'] != null && $patient['sit_part_prevention_chute'] == 1) {
                                        echo 'checked';
                                    } ?>>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <label for="sit_part_education_therapeutique">Education thérapeutique du
                                        patient</label>
                                </div>
                                <div class="col-md-3" style="text-align: left">
                                    <input type="checkbox" name="sit_part_education_therapeutique"
                                           id="sit_part_education_therapeutique"
                                           value="checked" <?php
                                    if ($patient['sit_part_education_therapeutique'] != null && $patient['sit_part_education_therapeutique'] == 1) {
                                        echo 'checked';
                                    } ?>>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <label for="sit_part_grossesse">Activité physique liée à la grossesse</label>
                                </div>
                                <div class="col-md-3" style="text-align: left">
                                    <input type="checkbox" name="sit_part_grossesse" id="sit_part_grossesse"
                                           value="checked" <?php
                                    if ($patient['sit_part_grossesse'] != null && $patient['sit_part_grossesse'] == 1) {
                                        echo 'checked';
                                    } ?>>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <label for="sit_part_sedentarite">Sédentarité ou inactivité physique (sans autres
                                        pathologies)</label>
                                </div>
                                <div class="col-md-3" style="text-align: left">
                                    <input type="checkbox" name="sit_part_sedentarite" id="sit_part_sedentarite"
                                           value="checked" <?php
                                    if ($patient['sit_part_sedentarite'] != null && $patient['sit_part_sedentarite'] == 1) {
                                        echo 'checked';
                                    } ?>>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <label for="sit_part_autre">Autre:</label>
                                </div>
                                <div class="col-md-3" style="text-align: left">
                        <textarea type="text" name="sit_part_autre" id="sit_part_autre"
                                  placeholder="Veuillez saisir les autres situation particulières"
                                  style="width:100%; max-width:100%; resize: none;"><?php
                            if ($patient['sit_part_autre'] != null) {
                                echo $patient['sit_part_autre'];
                            } ?></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12" style="text-align: center">
                                    <legend class="legend_petit_titre">Zone</legend>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <label for="qpv">Le bénéficiaire habite-t-il dans une QPV?</label>
                                </div>
                                <div class="col-md-3" style="text-align: left">
                                    <input type="checkbox" id="qpv" name="qpv"
                                           value="checked" <?php
                                    if ($patient['est_dans_qpv'] != null && $patient['est_dans_qpv'] == 1) {
                                        echo 'checked';
                                    } ?>>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <label for="zrr">Le bénéficiaire habite-t-il dans une ZRR?</label>
                                </div>
                                <div class="col-md-3" style="text-align: left">
                                    <input type="checkbox" id="zrr" name="zrr"
                                           value="checked" <?php
                                    if ($patient['est_dans_zrr'] != null && $patient['est_dans_zrr'] == 1) {
                                        echo 'checked';
                                    } ?>>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" name="enregistrer" value="Enregistrer les modifications"
                                           class="btn btn-success btn-xs">
                                </div>
                            </div>
                            <br>
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../js/confirmExitPage.js"></script>
<script src="../../js/ModifAutresInfos.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>