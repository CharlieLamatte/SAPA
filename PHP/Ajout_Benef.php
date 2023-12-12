<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);

$idPatient = isset($_GET['idPatient']) ? $_GET['idPatient'] : null;
const PAGE_AJOUT_BENEF = 'PAGE_AJOUT_BENEF'; // permet de détecter que l'on est sur la page ajout de bénef

$dateJour = date("Y-m-d");
$dateJourMoins150ans = date('Y-m-d', strtotime($dateJour . '-150 year'));
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ajout d'un bénéficiaire</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/Ajout_Benef.css">
    <link href="../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/design.css">
    <link rel="stylesheet" href="../css/modal-details.css">
    <link rel="stylesheet" href="../css/sante.css">

    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/commun.js"></script>
    <script type="text/javascript" src="../js/functions.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
</head>

<body onbeforeunload="return confirm()">

<?php
require 'header-accueil.php';
require './Medecins/ModalMedecin.php';
require './Mutuelles/modalMutuelle.php';
require 'partials/warning_modal.php';
?>

<div style="text-align: center">
    <legend style="color:black">
        <a href="Accueil_liste.php?idPatient=<?php
        echo $idPatient ?>" style="color: black; margin-right: 50px;"
           class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-left"></span></a>Retour
    </legend>
    <br>
</div>
<legend class="legend_Ajout_beneficiaire">Ajout d'un bénéficiaire</legend>
<br><br>
<!-- The toast -->
<div id="toast"></div>

<form class="form_Ajout_beneficiaire" action="../PHP/Patients/TraitementAjout.php" method="post"
      onsubmit="return verif_coordonnees()">
    <div class="container-fluid">
        <div class="row" style="text-align: center">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <fieldset class="group-section">
                    <legend class="group-section-titre">Date d'admission<span class="infobulle"
                                                                              aria-label="Date de la première entrevue avec le bénéficiaire"><img
                                    src="../../images/help.png" width="5%"/> </span></legend>
                    <br>
                    <div class="row" style="text-align: center">
                        <div class="col-md-12">
                            <input class="center-block" id='da' name='da' style='width:200px' type='date'
                                   value='<?= $dateJour; ?>' max='<?= $dateJour; ?>' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <legend style="color: black; font-size:15px;">Nature de l'entretien</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="radio" name="nature_e" value="tel"><label>Téléphonique</label>
                            <input type="radio" name="nature_e" value="present" checked><label>Présentiel</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <fieldset class="section-orange">
                    <legend class="section-titre-orange">Coordonnées du bénéficiaire</legend>
                    <br>
                    <input type="hidden" name="id_territoire" value="<?= $_SESSION['id_territoire']; ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nom-patient">Nom de naissance : </label><span style="color: red">*</span>
                        </div>
                        <div class="col-md-6">
                            <input id="nom-patient" name="nom-patient" type="text" required maxlength="100"
                                   pattern="^[A-zÀ-ž]+(?:[\-' ][A-zÀ-ž]+)*$">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="prenom-patient">Premier prénom de naissance : </label><span
                                    style="color: red">*</span>
                        </div>
                        <div class="col-md-6">
                            <input id="prenom-patient" name="prenom-patient" type="text" required maxlength="100"
                                   pattern="^[A-zÀ-ž]+(?:[\-' ][A-zÀ-ž]+)*$">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="liste_prenom_naissance">Liste des prénoms de naissance : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="liste_prenom_naissance" name="liste_prenom_naissance" type="text"
                                   maxlength="100" pattern="^[A-zÀ-ž]+(?:[\-' ][A-zÀ-ž]+)*$">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nom_utilise">Nom utilisé (obligatoire si différent du nom de naissance)
                                : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="nom_utilise" name="nom_utilise" type="text" maxlength="100">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="prenom_utilise">Prénom utilisé (obligatoire si différent du prénom de naissance)
                                : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="prenom_utilise" name="prenom_utilise" type="text" maxlength="100">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="sexe">Sexe : </label><span style="color: red">*</span>
                        </div>
                        <div class="col-md-6">
                            <select name="sexe" id="sexe_patient">
                                <option value="F">Femme</option>
                                <option value="M">Homme</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="dn">Date de naissance : </label><span style="color: red">*</span>
                        </div>
                        <div class="col-md-6">
                            <input id='dn' name='dn' style='width:200px' type='date' min='<?= $dateJourMoins150ans; ?>'
                                   max='<?= $dateJour; ?>' required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_f">Téléphone 1 :</label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_f" name="tel_f" type="text" pattern="[0-9]*" minlength="10" maxlength="10"
                                   placeholder="0XXXXXXXXX">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_p">Téléphone 2 :</label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_p" name="tel_p" type="text" pattern="[0-9]*" minlength="10" maxlength="10"
                                   placeholder="0XXXXXXXXX">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="email-patient">Email : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="email-patient" name="email-patient" type="email" class="form-control"
                                   maxlength="100"
                                   pattern="[a-zA-Z0-9._\-]+[@][a-zA-Z0-9._\-]+[.][a-zA-Z.]{2,15}"
                                   placeholder="xxxxx@xxxx.xxx">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="adresse-patient">Adresse : </label><span style="color: red">*</span>
                        </div>
                        <div class="col-md-6">
                            <input id="adresse-patient" name="adresse-patient" type="text" maxlength="200" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="complement-adresse-patient">Complément d'adresse : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="complement-adresse-patient" name="complement-adresse-patient" type="text"
                                   maxlength="100"
                                   placeholder="Appartement,...(facultatif)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="code-postal-patient">Code Postal : </label><span style="color: red">*</span>
                        </div>
                        <div class="col-md-6">
                            <input autocomplete="off" id="code-postal-patient" type="text" name="code-postal-patient"
                                   maxlength="5"
                                   required pattern="^[0-9]+$">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ville-patient">Ville : </label><span style="color: red">*</span>
                        </div>
                        <div class="col-md-6">
                            <input id="ville-patient" name="ville-patient" type="text" maxlength="50" required readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Contact d'urgence</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nom_urgence">Nom : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="nom_urgence" name="nom_urgence" type="text" maxlength="50"
                                   pattern="^[A-zÀ-ž]+(?:[-' ][A-zÀ-ž]+)*$">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="prenom_urgence">Prénom : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="prenom_urgence" name="prenom_urgence" type="text" maxlength="50"
                                   pattern="^[A-zÀ-ž]+(?:[-' ][A-zÀ-ž]+)*$">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="id_lien">Le contact est son/sa : </label>
                        </div>
                        <div class="col-md-6">
                            <select name="id_lien" type="text" style="width:200px" id="id_lien">
                                <?php
                                //Requete liens select dans la table avec return de l'id et du type. La valeur récupérée sera l'id_lien
                                $query = $bdd->prepare('SELECT id_lien, type_lien FROM liens ORDER BY type_lien');
                                $query->execute();
                                while ($data = $query->fetch()) {
                                    echo '<option value="' . $data['id_lien'] . '">' . $data['type_lien'] . '</option>';
                                    $id_lien = $data['id_lien'];
                                }
                                $query->CloseCursor();
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_urgence_f">Téléphone 1 :</label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_urgence_f" name="tel_urgence_f" pattern="[0-9]*" type="text" minlength="10"
                                   maxlength="10" placeholder="0XXXXXXXXX">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_urgence_p">Téléphone 2 :</label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_urgence_p" name="tel_urgence_p" pattern="[0-9]*" type="text" minlength="10"
                                   maxlength="10" placeholder="0XXXXXXXXX">
                        </div>
                    </div>
                    <br>
                </fieldset>

                <br>

                <fieldset class="section-orange">
                    <legend class="section-titre-orange">Autres informations</legend>
                    <br>
                    <?php
                    if (!$permissions->hasRole(Permissions::COORDONNATEUR_PEPS)): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <legend class="legend_petit_titre">Programme PEPS</legend>
                            </div>
                        </div>
                        <div class="row" id="prise-en-charge-row">
                            <div class="col-md-6">
                                <label for="est-non-peps">Extérieur au programme PEPS: <span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-6">
                                <input type="checkbox" id="est-non-peps" name="est-non-peps" value="checked">
                            </div>
                        </div>
                    <?php
                    endif; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Prise en charge financière</legend>
                        </div>
                    </div>
                    <div class="row" id="prise-en-charge-row">
                        <div class="col-md-6">
                            <label for="est-pris-en-charge">Pris en charge financièrement:</label>
                        </div>
                        <div class="col-md-6">
                            <input type="checkbox" id="est-pris-en-charge" name="est-pris-en-charge" value="checked">
                        </div>
                    </div>
                    <div class="row" id="prise-en-charge-tr" hidden="hidden">
                        <div class="col-md-6">
                            <label for="hauteur-prise-en-charge">Hauteur de la prise en charge en charge (en %): <span
                                        style="color: red">*</span></label>
                        </div>
                        <div class="col-md-6">
                            <input type="number" id="hauteur-prise-en-charge" name="hauteur-prise-en-charge" max="100"
                                   min="0" step="1" placeholder="0-100">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Situations particulières</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sit_part_prevention_chute">Prévention de la chute</label>
                        </div>
                        <div class="col-md-6">
                            <input type="checkbox" name="sit_part_prevention_chute"
                                   id="sit_part_prevention_chute" value="YES">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sit_part_education_therapeutique">Education thérapeutique du
                                patient</label>
                        </div>
                        <div class="col-md-6">
                            <input type="checkbox" name="sit_part_education_therapeutique"
                                   id="sit_part_education_therapeutique" value="YES">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sit_part_grossesse">Activité physique liée à la grossesse</label>
                        </div>
                        <div class="col-md-6">
                            <input type="checkbox" name="sit_part_grossesse" id="sit_part_grossesse" value="YES">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sit_part_sedentarite">Sédentarité ou inactivité physique (sans autres
                                pathologies)</label>
                        </div>
                        <div class="col-md-6">
                            <input type="checkbox" name="sit_part_sedentarite" id="sit_part_sedentarite" value="YES">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sit_part_autre">Autre:</label>
                        </div>
                        <div class="col-md-6">
                        <textarea type="text" name="sit_part_autre" id="sit_part_autre"
                                  placeholder="Veuillez saisir les autres situation particulières"
                                  style="width:100%; max-width:100%; resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Zone</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="qpv">Le bénéficiaire habite-t-il dans une QPV?</label>
                        </div>
                        <div class="col-md-6">
                            <input type="checkbox" id="qpv" name="qpv" value="YES">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="zrr">Le bénéficiaire habite-t-il dans une ZRR?</label>
                        </div>
                        <div class="col-md-6">
                            <input type="checkbox" id="zrr" name="zrr" value="YES">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Autre</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="intervalle">Intervalle entre les évaluations:</label>
                        </div>
                        <div class="col-md-6">
                            <select id="intervalle" name="intervalle">
                                <option value="3">3 mois</option>
                                <option value="6">6 mois</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="date_eval_suiv">Date de la prochaine évaluation:</label>
                        </div>
                        <div class="col-md-6">
                            <input id='date_eval_suiv' name='date_eval_suiv' class='form-control input-md'
                                   type='date' style='width:150px' min='<?php
                            echo date("Y-m-d"); ?>'>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="section-rouge-2">
                    <legend class="section-titre-rouge-2">Suivi médical du bénéficiaire</legend>
                    <br>
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <button id="recherche-open" type="button" class="btn btn-sm btn-default">Rechercher</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Médecin prescripteur
                            </legend>
                            <div style="text-align: center">
                                <input value="+" class="ajout-medecins"
                                       type="button" data-toggle="modal" data-target="#modal" data-backdrop="static"
                                       data-keyboard="false">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="cadre" style="text-align: center">
                                <label for="choix_prescrip">Choisissez un médecin : </label><input autocomplete="off"
                                                                                                   id="choix_prescrip"
                                                                                                   name="choix_prescrip"
                                                                                                   type="text"
                                                                                                   placeholder="Tapez les premières lettres du nom du médecin">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nom_med">Nom : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="nom_med" name="nom_med" type="text" readonly>
                            <input type="hidden" id="id_med" name="id_med">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="prenom_med">Prénom : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="prenom_med" name="prenom_med" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="spe_med">Spécialité : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="spe_med" name="spe_med" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_med"> N° de téléphone : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_med" name="tel_med" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="mail_med"> Mail : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="mail_med" name="mail_med" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="adresse_med">Adresse : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="adresse_med" name="adresse_med" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="complement_med">Complément d'adresse : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="complement_med" name="complement_med" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cp_med">Code Postal : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="cp_med" name="cp_med" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ville_med">Ville : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="ville_med" name="ville_med" type="text" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Medecin traitant
                            </legend>
                            <div style="text-align: center">
                                <input value="+" class="ajout-medecins"
                                       type="button" data-toggle="modal" data-target="#modal" data-backdrop="static"
                                       data-keyboard="false">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="cadre" style="text-align: center">
                                <label for="neme_med">Même que le médecin prescripteur ? </label>
                                <input type="radio" name="meme_med" value="oui"
                                       onclick="formulaire_cache('med_traitant')"
                                       checked><label>Oui</label>
                                <input type="radio" name="meme_med" value="non"
                                       onclick="formulaire_visible('med_traitant')"><label>Non</label>
                            </div>
                        </div>
                    </div>
                    <div name="med_traitant" id="med_traitant" style="display:none">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="cadre">
                                    <label for="choix_traitant">Choisissez un médecin : </label>

                                    <input autocomplete="off" id="choix_traitant" name="choix_traitant" type="text"
                                           placeholder="Tapez les premières lettres du nom du médecin">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nom_med_traitant">Nom : </label><span style="color: red">*</span>
                            </div>
                            <div class="col-md-6">
                                <input id="nom_med_traitant" name="nom_med_traitant" type="text" readonly>
                                <input type="hidden" id="id_med_traitant" name="id_med_traitant">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="prenom_med_traitant">Prénom : </label>
                            </div>
                            <div class="col-md-6">
                                <input id="prenom_med_traitant" name="prenom_med_traitant" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="spe_med_traitant">Spécialité : </label>
                            </div>
                            <div class="col-md-6">
                                <input id="spe_med_traitant" name="spe_med_traitant" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tel_med_traitant"> N° de téléphone : </label>
                            </div>
                            <div class="col-md-6">
                                <input id="tel_med_traitant" name="tel_med_traitant" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="mail_med_traitant"> Mail : </label>
                            </div>
                            <div class="col-md-6">
                                <input id="mail_med_traitant" name="mail_med_traitant" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="adresse_med_traitant">Adresse : </label>
                            </div>
                            <div class="col-md-6">
                                <input id="adresse_med_traitant" name="adresse_med_traitant" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="complement_med_traitant">Complément d'adresse : </label>
                            </div>
                            <div class="col-md-6">
                                <input id="complement_med_traitant" name="complement_med_traitant" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="cp_med_traitant">Code Postal : </label>
                            </div>
                            <div class="col-md-6">
                                <input id="cp_med_traitant" name="cp_med_traitant" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="ville_med_traitant">Ville : </label>
                            </div>
                            <div class="col-md-6">
                                <input id="ville_med_traitant" name="ville_med_traitant" type="text" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Autre professionnel de santé</legend>
                            <div style="text-align: center">
                                <input value="+" class="ajout-autre-professionnel"
                                       type="button" data-toggle="modal"
                                       data-target="#modal" data-backdrop="static" data-keyboard="false">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="autres-pro-sup"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button class="center-block" type="button" onclick="addItem();">
                                Ajout d'un professionnel de santé supplémentaire
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre ">Mutuelle</legend>
                            <div style="text-align: center">
                                <input value="+"
                                       id="ajout-mutuelle" type="button" data-toggle="modal"
                                       data-target="#modal-mutuelle"
                                       data-backdrop="static" data-keyboard="false">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="cadre" style="text-align: center">
                                <label for="choix_mutuelle">Choisissez une mutuelle: </label>
                                <input autocomplete="off" id="choix_mutuelle" name="choix_mutuelle" type="text"
                                       placeholder="Tapez les premières lettres de la mutuelle">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nom_mutuelle">Mutuelle : </label>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" id="id_mutuelle" name="id_mutuelle">
                            <input id="nom_mutuelle" name="nom_mutuelle" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_mutuelle">N° de téléphone : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_mutuelle" name="tel_mutuelle" type="text" maxlength="10" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="mail_mutuelle">Adresse mail : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="mail_mutuelle" name="mail_mutuelle" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="adresse_mutuelle">Adresse: </label>
                        </div>
                        <div class="col-md-6">
                            <input id="adresse_mutuelle" name="adresse_mutuelle" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="complement_mutuelle">Complement d'adresse : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="complement_mutuelle" name="complement_mutuelle" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cp_mutuelle">Code Postal : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="cp_mutuelle" name="cp_mutuelle" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ville_mutuelle">Ville : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="ville_mutuelle" name="ville_mutuelle" type="text" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Régime d'assurance maladie</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="TypeRegime">Régime : </label>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $req = $bdd->prepare("SELECT * FROM caisse_assurance_maladie ORDER BY nom_regime");
                            $req->execute();
                            echo('<select name="TypeRegime" id="TypeRegime" style="width:100%">');
                            while ($data = $req->fetch()) {
                                $idRegime = $data['id_caisse_assurance_maladie'];
                                $nomRegime = $data['nom_regime'];
                                echo('<option value="' . $idRegime . '">' . $nomRegime . '</option>');
                            }
                            echo('</select>');
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cp_cpam">Code Postal : </label><span style="color: red">*</span>
                        </div>
                        <div class="col-md-6">
                            <input id="cp_cpam" name="cp_cpam" type="text" maxlength="6" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ville_cpam">Ville : </label><span style="color: red">*</span>
                        </div>
                        <div class="col-md-6">
                            <input autocomplete="off" id="ville_cpam" type="text" name="ville_cpam" maxlength="20"
                                   readonly required>
                        </div>
                    </div>
                    <br>
                </fieldset>
            </div>
        </div>
        <?php
        if ($permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_PEPS) ||
            $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_MSS)) {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div style="text-align: center">
                        <label for="suivi">Suivre ce dossier : </label>
                        <input type="checkbox" name="suivi" id="suivi" value=false>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div style="text-align: center">
                    <input type="submit" name="enregistrer" value="Enregistrer" class="btn btn-success btn-xs">
                </div>
            </div>
        </div>
        <br><br>
    </div>
</form>

<script src="../js/autocomplete.js"></script>
<script src="../js/modalMedecin.js"></script>
<script src="../js/modalMutuelle.js"></script>
<script src="../js/AjoutBeneficiaire.js"></script>
<script type="text/javascript" src="../js/fixHeader.js"></script>
</body>
</html>