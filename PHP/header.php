<?php

use Sportsante86\Sapa\Outils\Permissions;

use function Sportsante86\Sapa\Outils\age;

if (empty($patient)) {
    $p = new \Sportsante86\Sapa\Model\Patient($bdd);
    $patient = $p->readOne($idPatient);
    if (!$patient) {
        erreur_invalid_page();
    }
}
$age = age($patient['date_naissance']);

// REQUETE PATIENT pour récupérer son statut sous forme texte
$query = "
    SELECT type_eval
    from type_eval JOIN evaluations using (id_type_eval)
    where id_patient = :idPatient
    ORDER BY (id_evaluation)
    DESC LIMIT 1";
$stmt = $bdd->prepare($query);
$stmt->bindValue(':idPatient', $idPatient);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$typeEval = $data['type_eval'] ?? "";

// si le patient vient d'être créé $isPatientNew = "1" sinon "0"
$isPatientNew = "0";
if (isset($_SESSION['new_id_patient=' . $idPatient])) {
    $isPatientNew = "1";
    unset($_SESSION['new_id_patient=' . $idPatient]);
}
?>
<!-- Navigation -->
<!-- Ce header permet d'obtenir le chapeau en haut de la page web. -->
<nav id="main-navbar" class="navbar navbar-inverse navbar-fixed-top" role="navigation"
     style="width:auto; background-color: #191970;"
     data-id_patient="<?= $idPatient; ?>"
     data-is_new="<?= $isPatientNew; ?>"
     data-consentement-initial="<?= $patient["consentement"]; ?>">

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <div class="navbar-left" href="#">
            <!-- Après avoir inclus les classes nav, on importe le logo de l'application -->
            <img src="/../images/logo-sapa-2.png" style="max-height: 100px; margin-right: 1px" alt="logoSapa"/><img
                    src="/../images/logo_na_horiz_QUADRI_2019.jpg" style="max-height: 100px; margin-right: 1px"
                    alt="logoSapa"/><?php
            if ($_SESSION['est_en_nouvelle_aquitaine']): ?><img
                    src="/../images/LogoPEPS.jpg" style="max-height: 100px; margin-right: 1px" alt="logoPeps"/>
            <?php
            endif; ?><?php
            if (!empty($_SESSION['logo_fichier'])): ?><img
                src="/../Outils/DownloadLogo.php?filename=<?= $_SESSION['logo_fichier']; ?>" style="max-height: 100px"
                alt="logo-structure"/>
            <?php
            endif; ?>
        </div>

        <p class="navbar-text">
            <i style="font-variant: small-caps;font-size: 18px; color: white">
                <b>Bonjour <?= $_SESSION['prenom_connecte']; ?> <?= $_SESSION['nom_connecte']; ?> <?= $_SESSION['id_type_territoire'] == \Sportsante86\Sapa\Model\Territoire::TYPE_TERRITOIRE_DEPARTEMENT ? "du département" : "de la région" ?> <?= $_SESSION['nom_territoire']; ?></b>
            </i>
            <br>
            <span style="font-size: 18px; color: white">
                <?= $patient['prenom_patient'] . ' ' . $patient['nom_patient'] . ' ' . $age . ' ans  Sexe : ' . $patient['sexe_patient'] .
                '  N° de dossier  : ' . $idPatient . ' ' ?> <i><?= $typeEval; ?></i>
            </span>
            <br>
            <?php
            if ($permissions->hasPermission('can_view_page_patient_donnees_sante')): ?>
                <span id="open-modal-consentement" type="button" data-toggle="modal"
                      data-target="#modal-consentement" data-backdrop="static"
                      data-keyboard="false"
                      style="font-size: 18px; color: white">
                    Consentement :
                    <a id="logo-consentement" role="button">
                        <img id="logo-consentement-ok" class="logo-consentement" src="/../images/green_checkmark.png"
                             style="display: <?= $patient['consentement'] == "1" ? "inline" : "none"; ?>"
                             alt="logo-consentement-ok"/>
                        <img id="logo-consentement-not-ok" class="logo-consentement" src="/../images/red_crossmark.png"
                             style="display: <?= $patient['consentement'] == "0" ? "inline" : "none"; ?>"
                             alt="logo-consentement-not-ok"/>
                        <img id="logo-consentement-attente" class="logo-consentement" src="/../images/question.png"
                             style="display: <?= is_null(
                                 $patient['consentement']
                             ) ? "inline" : "none"; ?>" alt="logo-consentement-attente"/>
                    </a>
                </span>
            <?php
            endif; ?>
        </p>

        <!-- Inclusion des divers icones ainsi que leur liens : paramètres, accueil et déconnexion -->
        <ul class="nav navbar-nav navbar-right" style="margin-right: 5px">
            <li>
                <a id="version-info" tabindex="0" role="button" data-toggle="popover" title="À propos de SAPA"
                   data-content="
                   Version: <?= $_ENV['VERSION']; ?> <br>
                   Date: <?= $_ENV['DATE']; ?> <br>
                   Développé avec le soutien de la région Nouvelle-Aquitaine">
                    <span class="glyphicon glyphicon-info-sign text-center"></span></a>
            </li>
            <?php
            require 'partials/notification_icon.php'; ?>
            <li>
                <a href="../../PHP/Settings/Settings.php" id="administration-link">
                    <span class="glyphicon glyphicon-cog text-center"></span>
                </a>
            </li>
            <?php
            if ($permissions->hasPermission('can_view_page_patient') &&
                !$permissions->hasRole(Permissions::RESPONSABLE_STRUCTURE)):
                ?>
                <li>
                    <a href="../../PHP/Accueil_liste.php" id="accueil-link">
                        <span class="glyphicon glyphicon-home text-center"></span>
                    </a>
                </li>
            <?php
            endif; ?>
            <?php
            if ($permissions->hasRole(Permissions::RESPONSABLE_STRUCTURE)):
                ?>
                <li>
                    <a href="../../PHP/ResponsableStructure/Accueil.php" id="accueil-link">
                        <span class="glyphicon glyphicon-home text-center"></span>
                    </a>
                </li>
            <?php
            endif; ?>
            <?php
            if ($permissions->hasRole(Permissions::SUPER_ADMIN)):
                ?>
                <li>
                    <a href="/../PHP/Settings/TableauDeBord.php" id="accueil-link">
                        <span class="glyphicon glyphicon-home text-center"></span>
                    </a>
                </li>
            <?php
            endif; ?>
            <li>
                <a href="../../PHP/deconnexion.php" id="deconnexion-link"
                   onclick="return confirm('Etes-vous sûr de vouloir vous déconnecter ?');">
                    <span class="glyphicon glyphicon-off text-center"></span>
                </a>

            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->

    <!-- /.container -->
    <!-- Les lignes qui suivent permettront d'inclure une barre d'onglet et de mettre en valeur l'onglet dans lequel se trouve l'utilisateur par rapport aux autres onglets. (références : Patients/onglets.php) -->

    <div style="text-align: center">
        <ul class="nav nav-tabs" style="margin-top: 0; height:0; font-size: 15px; background-color: blue;">
            <?php
            //Le processus est le même pour chaque onglet. Si le script server est celui traité dans la condition, on retourne un onglet coloré. Sinon, sa classe sera "enabled". On inclut aussi les liens des onglets avec les id du patient à transmettre à la page suivante.
            //Server['SCRIPT_NAME'] est une commande défini dans PHP et permet d'obtenir la page courante.
            //"enabled" permet d'obtenir un onglet décoloré, mais il sera toujours possible d'accéder au lien qui lui est assigné via l'echo.

            // onglet Bénéficiaire
            if ($permissions->hasPermission('can_view_page_patient_accueil')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/AccueilPatient.php' ||
                    $_SERVER['SCRIPT_NAME'] == '/PHP/Patients/modifbenef.php' ||
                    $_SERVER['SCRIPT_NAME'] == '/PHP/Patients/ModifAutresInfos.php' ||
                    $_SERVER['SCRIPT_NAME'] == '/PHP/Patients/modifmed.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo " <li role=\"presentation\" " . $class . "><a id=\"accueil-patient-link\" href=\"AccueilPatient.php?idPatient=" . $idPatient . "\">Bénéficiaire</a></li>";
            }

            // onglet Prescription
            if ($permissions->hasPermission('can_view_page_patient_prescription')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/Prescription.php' ||
                    $_SERVER['SCRIPT_NAME'] == '/PHP/Patients/PrescriptionAjout.php' ||
                    $_SERVER['SCRIPT_NAME'] == '/PHP/Patients/PrescriptionModif.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo "<li role=\"presentation\" " . $class . "><a id=\"prescription-link\" href=\"Prescription.php?idPatient=" . $idPatient . "\">Prescription</a></li>";
            }

            // onglet Sante
            if ($permissions->hasPermission('can_view_page_patient_sante')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/Sante.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo " <li role=\"presentation\" " . $class . "><a id=\"sante-link\" href=\"Sante.php?idPatient=" . $idPatient . "\">Santé</a></li>";
            }

            // onglet activité physique
            if ($permissions->hasPermission('can_view_page_patient_activite_physique')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/Ap.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo " <li role=\"presentation\" " . $class . "><a id=\"activite-physique-link\" href=\"Ap.php?idPatient=" . $idPatient . "\">Activité Physique</a></li>";
            }

            // onglet évaluation
            if ($permissions->hasPermission('can_view_page_patient_evaluation')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/Evaluation.php' ||
                    $_SERVER['SCRIPT_NAME'] == '/PHP/Patients/AjoutEvaluation.php' ||
                    $_SERVER['SCRIPT_NAME'] == '/PHP/Patients/ModifEval.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo " <li role=\"presentation\" " . $class . "><a id=\"evaluation-link\" href=\"Evaluation.php?idPatient=" . $idPatient . "\">Évaluations</a></li>";
            }

            // onglet questionnaire
            if ($permissions->hasPermission('can_view_page_patient_questionnaire')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/Questionnaires.php' ||
                    $_SERVER['SCRIPT_NAME'] == '/PHP/Patients/AjoutQuestionnaire.php' ||
                    $_SERVER['SCRIPT_NAME'] == '/PHP/Patients/ModifierQuestionnaire.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo " <li role=\"presentation\" " . $class . "><a id=\"questionnaires-link\" href=\"Questionnaires.php?idPatient=" . $idPatient . "\">Questionnaires</a></li>";
            }

            // onglet Objectifs
            if ($permissions->hasPermission('can_view_page_patient_objectifs')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/Objectifs.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo " <li role=\"presentation\" " . $class . "><a id=\"objectifs-link\" href=\"Objectifs.php?idPatient=" . $idPatient . "\">Objectifs</a></li>";
            }

            // onglet Orientation
            if ($permissions->hasPermission('can_view_page_patient_orientation')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/Orientation.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo " <li role=\"presentation\" " . $class . "><a id=\"orientation-link\" href=\"Orientation.php?idPatient=" . $idPatient . "\">Orientation</a></li>";
            }

            // onglet suivi
            if ($permissions->hasPermission('can_view_page_patient_suivi')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/Suivi.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo " <li role=\"presentation\" " . $class . "><a id=\"programme-link\" href=\"Suivi.php?idPatient=" . $idPatient . "\">Suivi</a></li>";
            }

            // onglet Synthese
            if ($permissions->hasPermission('can_view_page_patient_synthese')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/Synthese.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo " <li role=\"presentation\" " . $class . "><a id=\"synthese-link\" href=\"Synthese.php?idPatient=" . $idPatient . "\">Synthèse</a></li>";
            }

            // onglet Progression
            if ($permissions->hasPermission('can_view_page_patient_progression')) {
                if ($_SERVER['SCRIPT_NAME'] == '/PHP/Patients/Progression.php') {
                    $class = "class=\"nav-tabs active\"";
                } else {
                    $class = "class=\"enabled\"";
                }
                echo " <li role=\"presentation\" " . $class . "><a id=\"progression-link\" href=\"Progression.php?idPatient=" . $idPatient . "\">Progression</a></li>";
            }
            ?>
        </ul>
    </div>
</nav>

<?php
if ($permissions->hasPermission('can_view_page_patient_donnees_sante')): ?>
    <form class="form-horizontal" id="form-consentement"
          data-id_patient="<?= $idPatient; ?>"
          data-consentement="<?= $patient['consentement'] ?? "attente"; ?>">
        <!--Modal-->
        <div class="modal fade" id="modal-consentement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <fieldset class="can-disable">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="modal-title-consentement">Consentement</h3>
                        </div>
                        <div class="modal-body">
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Consentement</legend>
                                <form id="form-accord">
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: left">
                                            <div>Personne informée de la collecte et du partage des données (Avec les
                                                intervenants qui
                                                participent à sa prise en charge):<span style="color: red">*</span>
                                            </div>
                                            <br>
                                            <div>
                                                <input type="radio" id="accord-oui" name="accord" value="1" required
                                                    <?= $patient['consentement'] == "1" ? "checked" : ""; ?>>
                                                <label class="radio-inline label-float-unset" for="accord-oui">Informée
                                                    et ne s’oppose
                                                    pas</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="accord-non" name="accord" value="0"
                                                    <?= $patient['consentement'] == "0" ? "checked" : ""; ?>>
                                                <label class="radio-inline label-float-unset" for="accord-non">Informée
                                                    et s’oppose</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="accord-attente" name="accord" value="attente"
                                                    <?= is_null($patient['consentement']) ? "checked" : ""; ?>>
                                                <label class="radio-inline label-float-unset" for="accord-attente">Démarche
                                                    en cours</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: left">
                                        <div class="section-noir" style="text-align: left">
                                            <i>Rappel des Conditions Générales d'Utilisation (extrait) :</i>
                                            <br><br>
                                            <b>INFORMATION DE LA PERSONNE PRISE EN CHARGE</b>
                                            <br><br>
                                            <p>
                                                La personne prise en charge (ou son représentant légal) doit être
                                                informée
                                                du partage et
                                                de
                                                l’hébergement de données à caractère personnel la concernant, et de ses
                                                droits de refus,
                                                d’accès et de rectification de ces données. L’utilisateur en informe la
                                                personne d’une
                                                manière claire et adaptée à son degré de compréhension, ou s’assure
                                                qu’un
                                                autre
                                                professionnel l’en a déjà informée.
                                            </p>

                                            <div id="plus-text-consentement" style="display: none;">
                                                <p>Les informations recueillies sur ce formulaire sont enregistrées dans
                                                    un
                                                    fichier
                                                    informatisé. Les données collectées seront communiquées aux seuls
                                                    destinataires
                                                    suivants
                                                    : Professionnels de santé et de coordination.</p>
                                                <p>Les données sont conservées pendant trois ans.</p>
                                                <p>Vous pouvez accéder aux données vous concernant, les rectifier,
                                                    demander
                                                    leur
                                                    effacement
                                                    ou exercer votre droit à la limitation du traitement de vos données
                                                    (Vous pouvez
                                                    retirer
                                                    à tout moment votre consentement au traitement de vos données ; Vous
                                                    pouvez
                                                    également
                                                    vous opposer au traitement de vos données ; Vous pouvez également
                                                    exercer votre
                                                    droit à
                                                    la portabilité de vos données).</p>
                                                <p>Consultez le site cnil.fr pour plus d’informations sur vos
                                                    droits.</p>
                                                <p>Si vous estimez, après nous avoir contactés, que vos droits «
                                                    Informatique et
                                                    Libertés »
                                                    ne sont pas respectés, vous pouvez adresser une réclamation à la
                                                    CNIL.</p>
                                            </div>

                                            <div style="text-align: center">
                                                <button id="voir-plus-consentement" class="btn btn-sm btn-default">Voir
                                                    plus
                                                    d'information
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="can-be-hidden-1" hidden id="td-doc">

                                </div>
                                <div class="row can-be-hidden-1" hidden id="td-doc">
                                    <div class="col-md-12" style="text-align: center">

                                    </div>
                                </div>
                            </fieldset>

                        </div>
                    </fieldset>
                    <div class="modal-footer">
                        <!-- Boutons à droite -->
                        <button id="modifier-consentement" type="submit" name="modifier-consentement"
                                value="modifier-consentement" class="btn btn-success">Enregistrer
                        </button>
                        <!-- Boutons à gauche -->
                        <button id="close-consentement" type="button" data-dismiss="modal"
                                class="btn btn-warning pull-left">
                            Abandon
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php
endif; ?>

<div id="notification-menu" class="sidenava">
    <a href="javascript:void(0)" class="closebtn" id="close-notification">&times;</a>
    <?php
    if ($_ENV['ENVIRONNEMENT'] === 'TEST'): ?>
        <a href="javascript:void(0)" class="deletebtn" id="delete-notifications">Vider</a>
    <?php
    endif; ?>
</div>

<script type="text/javascript" src="/js/notification.js"></script>
<script type="text/javascript" src="/js/version.js"></script>
<script type="text/javascript" src="/js/modalConsentement.js"></script>