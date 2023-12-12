<?php

use Sportsante86\Sapa\Model\Medecin;
use Sportsante86\Sapa\Model\Mutuelle;
use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Model\SuiviDossier;
use Sportsante86\Sapa\Model\JournalAcces;
use Sportsante86\Sapa\Outils\Permissions;

use function Sportsante86\Sapa\Outils\format_date;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_accueil')) {
    erreur_permission();
}

//Récupérer l'id du patient
$idPatient = $_GET['idPatient'];

$p = new Patient($bdd);
$patient = $p->readOne($idPatient);
if (!$patient) {
    erreur_invalid_page();
}

$s = new SuiviDossier($bdd);
$suivi_patient = $s->checkSuiviDossier($_SESSION['id_user'], $idPatient);
if ($suivi_patient) {
    //Bénéficiaire trouvé : le bénéficiaire est suivi
    $est_suivi = 1;
} else {
    //Bénéficiaire non trouvé : le bénéficiaire n'est pas suivi
    $est_suivi = 0;
}

// enregistrement de l'accès en lecture de cette page
$journal = new JournalAcces($bdd);
$journal->create([
    'nom_acteur' => $_SESSION['nom_connecte'] . " " . $_SESSION['prenom_connecte'],
    'type_action' => "read",
    'type_cible' => "patient",
    'nom_cible' => $patient["nom_naissance"] . " " . $patient["premier_prenom_naissance"],
    'id_user_acteur' => $_SESSION['id_user'],
    'id_cible' => $idPatient
]);

if (!empty($patient['id_mutuelle'])) {
    $m = new Mutuelle($bdd);
    $mutuelle = $m->readOne($patient['id_mutuelle']);
}

$m = new Medecin($bdd);
$medecin_prescripteur = $m->readMedecinPrescripteurPatient($idPatient);
$medecin_traitant = $m->readMedecinTraitantPatient($idPatient);
$autres_professionnels_sante = $m->readAutresProfessionnelsSantePatient($idPatient);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bénéficiaire</title>
    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/Ajout_Benef.css">
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/sante.css">

    <script type="text/javascript" src='../../js/jquery.js'></script>

    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/commun.js"></script>
    <script type="text/javascript" src="../../js/functions.js"></script>

    <script language="Javascript">
        function formulaire_visible(elem) {
            etat = document.getElementById(elem).style.display;
            if (etat == "none") {
                document.getElementById(elem).style.display = "block";
            } else {
                document.getElementById(elem).style.display
            }
        }

        function formulaire_cache(elem) {
            etat = document.getElementById(elem).style.display;
            if (etat == "block") {
                document.getElementById(elem).style.display = "none";
            } else {
                document.getElementById(elem).style.display
            }
        }

        function bascule(elem) {
            etat = document.getElementById(elem).style.display;
            if (etat == "none") {
                document.getElementById(elem).style.display = "block";
            } else {
                document.getElementById(elem).style.display = "none";
            }
        }
    </script>
</head>

<?php
// formatter le numéro de téléphone
function format_telephone($str)
{
    if (strlen($str) == 9) {
        $res = "";
        $res .= '0' . substr($str, 0, 1) . ' ';
        $res .= substr($str, 1, 2) . ' ';
        $res .= substr($str, 3, 2) . ' ';
        $res .= substr($str, 5, 2) . ' ';
        $res .= substr($str, 7, 2) . ' ';

        return $res;
    } elseif (strlen($str) == 10) {
        $res = substr($str, 0, 2) . ' ';
        $res .= substr($str, 2, 2) . ' ';
        $res .= substr($str, 4, 2) . ' ';
        $res .= substr($str, 6, 2) . ' ';
        $res .= substr($str, 8, 2);
        return $res;
    }

    return "";
}

//
function generate_champs_medecin($array)
{
    ?>
    <div class="row">
        <div class="col-md-6">
            <label for="nom_med">Nom : </label>
        </div>
        <div class="col-md-6">
            <input id="nom_med" name="nom_med" type="text" readonly value="<?php
            if (!empty($array['nom'])) {
                echo htmlspecialchars($array['nom']);
            } else {
                echo 'Non renseigné';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="prenom_med">Prénom : </label>
        </div>
        <div class="col-md-6">
            <input id="prenom_med" name="prenom_med" type="text" readonly value="<?php
            if (!empty($array['prenom'])) {
                echo htmlspecialchars($array['prenom']);
            } else {
                echo 'Non renseigné';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="spe_med">Spécialité : </label>
        </div>
        <div class="col-md-6">
            <input id="spe_med" name="spe_med" type="text" readonly value="<?php
            if (!empty($array['specialite'])) {
                echo htmlspecialchars($array['specialite']);
            } else {
                echo 'Non renseignée';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="tel_med"> N° de téléphone : </label>
        </div>
        <div class="col-md-6">
            <input id="tel_med" name="tel_med" type="text" readonly value="<?php
            if (!empty($array['telephone'])) {
                echo format_telephone($array['telephone']);
            } else {
                echo 'Non renseigné';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="mail_med"> Mail : </label>
        </div>
        <div class="col-md-6">
            <input id="mail_med" name="mail_med" type="text" readonly value="<?php
            if (!empty($array['mail'])) {
                echo htmlspecialchars($array['mail']);
            } else {
                echo 'Non renseignée';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="adresse_med">Adresse : </label>
        </div>
        <div class="col-md-6">
            <input id="adresse_med" name="adresse_med" type="text" readonly value="<?php
            if (!empty($array['adresse'])) {
                echo htmlspecialchars($array['adresse']);
            } else {
                echo 'Non renseignée';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="complement_med">Complément d'adresse : </label>
        </div>
        <div class="col-md-6">
            <input id="complement_med" name="complement_med" type="text" readonly value="<?php
            if (!empty($array['complement'])) {
                echo htmlspecialchars($array['complement']);
            } else {
                echo 'Non renseigné';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="cp_med">Code Postal : </label>
        </div>
        <div class="col-md-6">
            <input id="cp_med" name="cp_med" type="text" readonly value="<?php
            if (!empty($array['code_postal'])) {
                echo htmlspecialchars($array['code_postal']);
            } else {
                echo 'Non renseigné';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="ville_med">Ville : </label>
        </div>
        <div class="col-md-6">
            <input id="ville_med" name="ville_med" type="text" readonly value="<?php
            if (!empty($array['ville'])) {
                echo htmlspecialchars($array['ville']);
            } else {
                echo 'Non renseignée';
            }
            ?>">
        </div>
    </div>
    <?php
} ?>

<!-- Page Content -->
<body>
<?php
require '../header.php'; ?>


<div class="container" id="main-container" data-id_patient="<?= $idPatient; ?>"
     data-meme_territoire="<?= $patient["id_territoire"] == $_SESSION['id_territoire'] ? "1" : "0" ?>">
    <!-- The toast -->
    <div id="toast"></div>
    <div style="text-align: center">
        <?php
        if ($permissions->hasPermission('can_archive_patient')):
            $est_archive = $patient['est_archive'] ?? "0";
            $button_description = ($est_archive == "0") ? "Archiver le patient" : "Restaurer le patient" ?>
            <button id="archive" class="btn btn-default" data-id_patient="<?= $idPatient; ?>"
                    data-value="<?= $est_archive; ?>"><?= $button_description ?>
            </button>
        <?php
        endif;
        ?>
    </div>
    <div style="text-align: center">
        <?php
        if ($permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_PEPS) ||
            $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_MSS)) {
            $suivi_description = ($est_suivi == 0) ? "Suivre ce bénéficiaire" : "Ne plus suivre ce bénéficiaire" ?>
            <button style="display: inline;margin-top: 5px" id="suivre" class="btn btn-default"
                    data-id_patient="<?= $idPatient; ?>"
                    data-value="<?= $est_suivi; ?>"><?= $suivi_description ?>
            </button>

            <?php
        }
        if ($permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_PEPS)) { ?>
            <button style="display: inline;vertical-align: bottom" id="partage" class="btn btn-default"
                    data-id_patient="<?= $idPatient; ?>">Partager ce dossier
            </button>
            <?php
        }
        ?>
    </div>
    <div>
        <!-- Inclure la partie parcours-->
        <?php
        require '../FicheResume/parcours.php'; ?>
    </div>

    <div>
        <div class="row">
            <div class="col-md-6">
                <fieldset class="section-orange">
                    <legend class="section-titre-orange">Coordonnées</legend>
                    <div class="row">
                        <div class="col-md-8">
                            <label style="font-weight: normal" for="guide_ins">Guide pour les fonctions liées à l'INS : </label>
                            <a id="guide_ins" style="text-decoration: underline"
                               href="../../Outils/DownloadGuideINS.php?filename=Fiche pratique INS - SAPA.pdf">Cliquer ici</a>
                        </div>
                    </div>
                    <?php
                    if ($patient['id_type_statut_identite'] == 1): ?>
                        <div id="recherche-ins-row" class="row">
                            <div class="col-md-6">
                                <label for="matricule_ins">Recherche INS : </label>
                            </div>
                            <div class="col-md-6">
                                <button id="recherche-ins" class="btn btn-primary">Recherche INS</button>
                            </div>
                        </div>
                    <?php
                    endif; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="statut_confiance">Statut de confiance de l'identité :</label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="statut_confiance" id="statut_confiance" disabled>
                                <?php
                                foreach ($p->getTypeStatutIdentite() as $statut) : ?>
                                    <option value="<?= $statut['id_type_statut_identite']; ?>"
                                            <?php
                                            $style = "";
                                            switch ($statut['id_type_statut_identite'] ) {
                                                case 1:
                                                    $style =  "background-color: #d01515;color: white;";
                                                    break;
                                                case 2:
                                                case 3:
                                                    $style =  "background-color: orange;color: black;";
                                                    break;
                                                case 4:
                                                    $style =  "background-color: green;color: white;";
                                                    break;
                                            }
                                            ?>
                                        style="<?= $style; ?>"
                                        <?= $patient['id_type_statut_identite'] == $statut['id_type_statut_identite'] ? "selected" : ""; ?>>
                                        <?= $statut['nom']; ?>
                                    </option>
                                <?php
                                endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div id="ins-section"
                         class="row" <?= $patient['id_type_statut_identite'] == 1 ? 'style="display: none"' : 'style="display: inline;"'; ?>>
                        <div class="col-md-12"
                             style="box-sizing: border-box; border: solid 2px black;border-radius: 5px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="matricule_ins">Matricule INS : </label>
                                </div>
                                <div class="col-md-6">
                                    <input id="matricule_ins"
                                           value="<?= $patient['matricule_ins'] ?? 'Non renseigné'; ?>"
                                           name="matricule_ins"
                                           type="text" maxlength="15" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nature-oid">Nature : </label>
                                </div>
                                <div class="col-md-6">
                                    <select id="nature-oid" name="nature-oid" class="form-control" disabled>
                                        <option value="1" <?= $patient['nature_oid'] == "1" ? "selected" : ""; ?>>NIA
                                        </option>
                                        <option value="2" <?= $patient['nature_oid'] == "2" ? "selected" : ""; ?>>NIR
                                        </option>
                                        <option value="3" <?= $patient['nature_oid'] == "3" ? "selected" : ""; ?>>
                                            INCONNU
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="type_piece_identite"><b>Pièce d'identité :</b></label>
                                </div>
                                <div class="col-md-6">
                                    <select name="type_piece_identite" id="type_piece_identite" class="form-control"
                                        <?= $patient['id_type_piece_identite'] != "1" ? "disabled" : ""; ?>>
                                        <?php
                                        foreach ($p->getTypePieceIdentite() as $piece_identite) : ?>
                                            <option value="<?= $piece_identite['id_type_piece_identite']; ?>"
                                                <?= $patient['id_type_piece_identite'] == $piece_identite['id_type_piece_identite'] ? "selected" : ""; ?>>
                                                <?= $piece_identite['nom']; ?>
                                            </option>
                                        <?php
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nom-patient">Nom de naissance : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="nom-patient" name="nom-patient" type="text" readonly
                                   value="<?php
                                   echo($patient['nom_naissance']); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="prenom-patient">Premier prénom de naissance: </label>
                        </div>
                        <div class="col-md-6">
                            <input id="prenom-patient" name="prenom-patient" type="text" readonly
                                   value="<?php
                                   echo htmlspecialchars($patient['premier_prenom_naissance']); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="liste_prenom_naissance">Liste des prénoms de naissance : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="liste_prenom_naissance"
                                   value="<?= $patient['liste_prenom_naissance'] ?? 'Non renseigné'; ?>"
                                   name="liste_prenom_naissance" type="text" maxlength="100" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nom_utilise">Nom utilisé : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="nom_utilise" value="<?= $patient['nom_utilise'] ?? 'Non renseigné'; ?>"
                                   name="nom_utilise"
                                   type="text" maxlength="100" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="prenom_utilise">Prénom utilisé : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="prenom_utilise" value="<?= $patient['prenom_utilise'] ?? 'Non renseigné'; ?>"
                                   name="prenom_utilise"
                                   type="text" maxlength="100" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="sexe">Sexe : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="sexe" name="sexe" type="text" readonly
                                   data-raw-value="<?= $patient['sexe_patient']; ?>"
                                   value="<?php
                                   if ($patient['sexe_patient'] == "F") {
                                       echo 'Femme';
                                   } elseif ($patient['sexe_patient'] == "M") {
                                       echo 'Homme';
                                   } else {
                                       echo 'Indéterminé';
                                   }
                                   ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="dn">Date de naissance : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="dn" name="dn" type="text" readonly
                                   data-raw-value="<?= $patient['date_naissance']; ?>"
                                   value="<?php
                                   if (!empty($patient['date_naissance'])) {
                                       echo format_date($patient['date_naissance']);
                                   } else {
                                       echo 'Non renseignée';
                                   }
                                   ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="code_insee_naissance">Code INSEE naissance : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="code_insee_naissance"
                                   value="<?= $patient['code_insee_naissance'] ?? 'Non renseigné'; ?>"
                                   name="code_insee_naissance" type="text" maxlength="5" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_f">Téléphone 1 :</label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_f" name="tel_f" type="text" readonly value="<?php
                            if (!empty($patient['tel_fixe_patient'])) {
                                echo format_telephone($patient['tel_fixe_patient']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_p">Téléphone 2 :</label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_p" name="tel_p" type="text" readonly value="<?php
                            if (!empty($patient['tel_portable_patient'])) {
                                echo format_telephone($patient['tel_portable_patient']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="email">Email : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="email" name="email" type="text" readonly value="<?php
                            if (!empty($patient['email_patient'])) {
                                echo htmlspecialchars($patient['email_patient']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="adresse-patient">Adresse : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="adresse-patient" name="adresse-patient" type="text" readonly value="<?php
                            if (!empty($patient['nom_adresse'])) {
                                echo htmlspecialchars($patient['nom_adresse']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="complement-adresse-patient">Complément d'adresse : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="complement-adresse-patient" name="complement-adresse-patient" type="text"
                                   readonly value="<?php
                            if (!empty($patient['complement_adresse'])) {
                                echo htmlspecialchars($patient['complement_adresse']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="code-postal-patient">Code Postal : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="code-postal-patient" name="code-postal-patient" type="text" readonly value="<?php
                            if (!empty($patient['code_postal'])) {
                                echo htmlspecialchars($patient['code_postal']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ville-patient">Ville : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="ville-patient" name="ville-patient" type="text" readonly value="<?php
                            if (!empty($patient['nom_ville'])) {
                                echo htmlspecialchars($patient['nom_ville']);
                            } else {
                                echo 'Non renseignée';
                            }
                            ?>">
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
                            <input id="nom_urgence" name="nom_urgence" type="text" readonly value="<?php
                            if (!empty($patient['nom_contact_urgence'])) {
                                echo htmlspecialchars($patient['nom_contact_urgence']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="prenom_urgence">Prénom : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="prenom_urgence" name="prenom_urgence" type="text" readonly value="<?php
                            if (!empty($patient['prenom_contact_urgence'])) {
                                echo htmlspecialchars($patient['prenom_contact_urgence']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="id_lien">Le contact est son/sa : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="id_lien" name="id_lien" type="text" readonly value="<?php
                            if (!empty($patient['type_lien'])) {
                                echo $patient['type_lien'];
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_urgence_f">Téléphone 1 :</label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_urgence_f" name="tel_urgence_f" type="text" readonly value="<?php
                            if (!empty($patient['tel_fixe_contact_urgence'])) {
                                echo format_telephone($patient['tel_fixe_contact_urgence']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_urgence_p">Téléphone 2 :</label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_urgence_p" name="tel_urgence_p" type="text" readonly value="<?php
                            if (!empty($patient['tel_portable_contact_urgence'])) {
                                echo format_telephone($patient['tel_portable_contact_urgence']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <br>
                    <?php
                    if ($permissions->hasPermission('can_modify_patient')): ?>
                        <div class="row">
                            <div class="col-md-12" style="text-align: center">
                                <a href='modifbenef.php?idPatient=<?php
                                echo $idPatient; ?>' name="Modifier"
                                   id="Modifier" class="btn btn-success btn-xs">Modifier</a>
                            </div>
                        </div>
                        <br>
                    <?php
                    endif; ?>
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
                        <div class="row">
                            <div class="col-md-6">
                                <label for="est-non-peps">Extérieur au programme PEPS:</label>
                            </div>
                            <div class="col-md-6">
                                <input id="est-non-peps" name="est-non-peps" type="text" readonly value="<?php
                                if (is_null($patient['est_non_peps'])) {
                                    echo 'Inconnu';
                                } elseif ($patient['est_non_peps'] == 1) {
                                    echo 'OUI';
                                } else {
                                    echo 'NON';
                                } ?>">
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
                            <input id="est-pris-en-charge" name="est-pris-en-charge" type="text" readonly value="<?php
                            if (is_null($patient['est_pris_en_charge_financierement'])) {
                                echo 'Inconnu';
                            } elseif ($patient['est_pris_en_charge_financierement'] == 1) {
                                echo 'OUI';
                            } else {
                                echo 'NON';
                            } ?>">
                        </div>
                    </div>
                    <?php
                    if ($patient['est_pris_en_charge_financierement'] != null && $patient['est_pris_en_charge_financierement'] == 1): ?>
                        <div class="row" id="prise-en-charge-tr">
                            <div class="col-md-6">
                                <label for="hauteur-prise-en-charge">Hauteur de la prise en charge en charge (en %):
                                    <span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-6">
                                <input id="hauteur-prise-en-charge" name="hauteur-prise-en-charge" type="text" readonly
                                       value="<?php
                                       if (is_null($patient['hauteur_prise_en_charge_financierement'])) {
                                           echo 'Inconnu';
                                       } else {
                                           echo $patient['hauteur_prise_en_charge_financierement'];
                                       }
                                       ?>">
                            </div>
                        </div>
                    <?php
                    endif; ?>
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
                            <input id="sit_part_prevention_chute" name="sit_part_prevention_chute" type="text" readonly
                                   value="<?php
                                   if (is_null($patient['sit_part_prevention_chute'])) {
                                       echo 'Inconnu';
                                   } elseif ($patient['sit_part_prevention_chute'] == 1) {
                                       echo 'OUI';
                                   } else {
                                       echo 'NON';
                                   } ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sit_part_education_therapeutique">Education thérapeutique du
                                patient</label>
                        </div>
                        <div class="col-md-6">
                            <input id="sit_part_education_therapeutique" name="sit_part_education_therapeutique"
                                   type="text" readonly value="<?php
                            if (is_null($patient['sit_part_education_therapeutique'])) {
                                echo 'Inconnu';
                            } elseif ($patient['sit_part_education_therapeutique'] == 1) {
                                echo 'OUI';
                            } else {
                                echo 'NON';
                            } ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sit_part_grossesse">Activité physique liée à la grossesse</label>
                        </div>
                        <div class="col-md-6">
                            <input id="sit_part_grossesse" name="sit_part_grossesse" type="text" readonly value="<?php
                            if (is_null($patient['sit_part_grossesse'])) {
                                echo 'Inconnu';
                            } elseif ($patient['sit_part_grossesse'] == 1) {
                                echo 'OUI';
                            } else {
                                echo 'NON';
                            } ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sit_part_sedentarite">Sédentarité ou inactivité physique (sans autres
                                pathologies)</label>
                        </div>
                        <div class="col-md-6">
                            <input id="sit_part_sedentarite" name="sit_part_sedentarite" type="text" readonly
                                   value="<?php
                                   if (is_null($patient['sit_part_sedentarite'])) {
                                       echo 'Inconnu';
                                   } elseif ($patient['sit_part_sedentarite'] == 1) {
                                       echo 'OUI';
                                   } else {
                                       echo 'NON';
                                   } ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sit_part_autre">Autre:</label>
                        </div>
                        <div class="col-md-6">
                        <textarea type="text" name="sit_part_autre" id="sit_part_autre" class="form-control"
                                  style="width:100%; max-width:100%; resize: none;" readonly><?php
                            if (is_null($patient['sit_part_autre'])) {
                                echo 'Inconnu';
                            } else {
                                echo htmlspecialchars($patient['sit_part_autre']);
                            } ?></textarea>
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
                            <input id="qpv" name="qpv" type="text" readonly value="<?php
                            if (is_null($patient['est_dans_qpv'])) {
                                echo 'Inconnu';
                            } elseif ($patient['est_dans_qpv'] == 1) {
                                echo 'OUI';
                            } else {
                                echo 'NON';
                            } ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="zrr">Le bénéficiaire habite-t-il dans une ZRR?</label>
                        </div>
                        <div class="col-md-6">
                            <input id="zrr" name="zrr" type="text" readonly value="<?php
                            if (is_null($patient['est_dans_zrr'])) {
                                echo 'Inconnu';
                            } elseif ($patient['est_dans_zrr'] == 1) {
                                echo 'OUI';
                            } else {
                                echo 'NON';
                            } ?>">
                        </div>
                    </div>
                    <br>
                    <?php
                    if ($permissions->hasPermission('can_modify_patient')): ?>
                        <div class="row">
                            <div class="col-md-12" style="text-align: center">
                                <a href='ModifAutresInfos.php?idPatient=<?php
                                echo $idPatient; ?>' id="Modifier"
                                   class="btn btn-success btn-xs">Modifier</a>
                            </div>
                        </div>
                        <br>
                    <?php
                    endif; ?>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="section-rouge-2">
                    <legend class="section-titre-rouge-2">Suivi médical</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Médecin prescripteur actuel</legend>
                        </div>
                    </div>
                    <?php
                    generate_champs_medecin([
                        'nom' => $medecin_prescripteur ? $medecin_prescripteur['nom_coordonnees'] : null,
                        'prenom' => $medecin_prescripteur ? $medecin_prescripteur['prenom_coordonnees'] : null,
                        'specialite' => $medecin_prescripteur ? $medecin_prescripteur['nom_specialite_medecin'] : null,
                        'telephone' => $medecin_prescripteur ? $medecin_prescripteur['tel_fixe_coordonnees'] : null,
                        'mail' => $medecin_prescripteur ? $medecin_prescripteur['mail_coordonnees'] : null,
                        'adresse' => $medecin_prescripteur ? $medecin_prescripteur['nom_adresse'] : null,
                        'complement' => $medecin_prescripteur ? $medecin_prescripteur['complement_adresse'] : null,
                        'code_postal' => $medecin_prescripteur ? $medecin_prescripteur['code_postal'] : null,
                        'ville' => $medecin_prescripteur ? $medecin_prescripteur['nom_ville'] : null
                    ]); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Medecin traitant</legend>
                        </div>
                    </div>

                    <?php
                    $idMedecin = $medecin_prescripteur ? $medecin_prescripteur['id_medecin'] : null;
                    $idMedecinTraitant = $medecin_traitant ? $medecin_traitant['id_medecin'] : null;
                    if ($idMedecin != $idMedecinTraitant): ?>
                        <div id="med_traitant">
                            <?php
                            generate_champs_medecin([
                                'nom' => $medecin_traitant ? $medecin_traitant['nom_coordonnees'] : null,
                                'prenom' => $medecin_traitant ? $medecin_traitant['prenom_coordonnees'] : null,
                                'specialite' => $medecin_traitant ? $medecin_traitant['nom_specialite_medecin'] : null,
                                'telephone' => $medecin_traitant ? $medecin_traitant['tel_fixe_coordonnees'] : null,
                                'mail' => $medecin_traitant ? $medecin_traitant['mail_coordonnees'] : null,
                                'adresse' => $medecin_traitant ? $medecin_traitant['nom_adresse'] : null,
                                'complement' => $medecin_traitant ? $medecin_traitant['complement_adresse'] : null,
                                'code_postal' => $medecin_traitant ? $medecin_traitant['code_postal'] : null,
                                'ville' => $medecin_traitant ? $medecin_traitant['nom_ville'] : null
                            ]); ?>
                        </div>
                    <?php
                    else: ?>
                        <div id="med_traitant" class="row" style="text-align: center">
                            <div class="col-md-12">
                                Même que le médecin prescripteur actuel
                            </div>
                        </div>
                    <?php
                    endif; ?>

                    <?php
                    if ($permissions->hasRole(Permissions::COORDONNATEUR_PEPS) ||
                        $permissions->hasRole(Permissions::COORDONNATEUR_NON_MSS) ||
                        $permissions->hasRole(Permissions::COORDONNATEUR_MSS) ||
                        $permissions->hasRole(Permissions::EVALUATEUR) ||
                        $permissions->hasRole(Permissions::SUPER_ADMIN)): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <legend class="legend_petit_titre">Autres professionnels de santé</legend>

                                <?php
                                if (empty($autres_professionnels_sante)) {
                                    echo '
                                        <div id="med_traitant" class="row" style="text-align: center">
                                            <div class="col-md-12">
                                                Aucun professionnel de santé supplémentaire
                                            </div>
                                        </div>';
                                } else {
                                    $nb_pro = count($autres_professionnels_sante);

                                    foreach ($autres_professionnels_sante as $autre_professionnel_sante) {
                                        if ($nb_pro > 1) {
                                            echo '<div class="section-noir">';
                                        }
                                        generate_champs_medecin([
                                            'nom' => $autre_professionnel_sante['nom_coordonnees'],
                                            'prenom' => $autre_professionnel_sante['prenom_coordonnees'],
                                            'specialite' => $autre_professionnel_sante['nom_specialite_medecin'],
                                            'telephone' => $autre_professionnel_sante['tel_fixe_coordonnees'],
                                            'mail' => $autre_professionnel_sante['mail_coordonnees'],
                                            'adresse' => $autre_professionnel_sante['nom_adresse'],
                                            'complement' => $autre_professionnel_sante['complement_adresse'],
                                            'code_postal' => $autre_professionnel_sante['code_postal'],
                                            'ville' => $autre_professionnel_sante['nom_ville']
                                        ]);
                                        if ($nb_pro > 1) {
                                            echo '</div>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    endif; ?>

                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre ">Mutuelle</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nom_mutuelle">Mutuelle : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="nom_mutuelle" name="nom_mutuelle" type="text" readonly value="<?php
                            if (!empty($mutuelle['nom'])) {
                                echo htmlspecialchars($mutuelle['nom']);
                            } else {
                                echo 'Non renseignée';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tel_mutuelle">N° de téléphone : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="tel_mutuelle" name="tel_mutuelle" type="text" maxlength="10" readonly
                                   value="<?php
                                   if (!empty($mutuelle['tel_fixe'])) {
                                       echo format_telephone($mutuelle['tel_fixe']);
                                   } else {
                                       echo 'Non renseigné';
                                   }
                                   ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="mail_mutuelle">Adresse mail : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="mail_mutuelle" name="mail_mutuelle" type="text" readonly value="<?php
                            if (!empty($mutuelle['email'])) {
                                echo $mutuelle['email'];
                            } else {
                                echo 'Non renseignée';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="adresse_mutuelle">Adresse :</label>
                        </div>
                        <div class="col-md-6">
                            <input id="adresse_mutuelle" name="adresse_mutuelle" type="text" readonly value="<?php
                            if (!empty($mutuelle['nom_adresse'])) {
                                echo $mutuelle['nom_adresse'];
                            } else {
                                echo 'Non renseignée';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="complement_mutuelle">Complement d'adresse :</label>
                        </div>
                        <div class="col-md-6">
                            <input id="complement_mutuelle" name="complement_mutuelle" type="text" readonly value="<?php
                            if (!empty($mutuelle['complement_adresse'])) {
                                echo $mutuelle['complement_adresse'];
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cp_mutuelle">Code Postal : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="cp_mutuelle" name="cp_mutuelle" type="text" readonly value="<?php
                            if (!empty($mutuelle['code_postal'])) {
                                echo htmlspecialchars($mutuelle['code_postal']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ville_mutuelle">Ville : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="ville_mutuelle" name="ville_mutuelle" type="text" readonly value="<?php
                            if (!empty($mutuelle['nom_ville'])) {
                                echo htmlspecialchars($mutuelle['nom_ville']);
                            } else {
                                echo 'Non renseignée';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <legend class="legend_petit_titre">Caisse d'assurance maladie</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="TypeRegime">Régime : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="TypeRegime" name="TypeRegime" type="text" readonly value="<?php
                            if (!empty($patient['nom_regime'])) {
                                echo htmlspecialchars($patient['nom_regime']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ville_cpam">Ville : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="ville_cpam" name="ville_cpam" type="text" readonly value="<?php
                            if (!empty($patient['nom_ville_cam'])) {
                                echo htmlspecialchars($patient['nom_ville_cam']);
                            } else {
                                echo 'Non renseignée';
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cp_cpam">Code Postal : </label>
                        </div>
                        <div class="col-md-6">
                            <input id="cp_cpam" name="cp_cpam" type="text" readonly value="<?php
                            if (!empty($patient['code_postal_cam'])) {
                                echo htmlspecialchars($patient['code_postal_cam']);
                            } else {
                                echo 'Non renseigné';
                            }
                            ?>">
                        </div>
                    </div>
                    <br>
                    <?php
                    if ($permissions->hasPermission('can_modify_patient')): ?>
                        <div class="row">
                            <div class="col-md-12" style="text-align: center">
                                <a href='modifmed.php?idPatient=<?php
                                echo $idPatient; ?>' id="Modifier"
                                   class="btn btn-success btn-xs">Modifier</a>
                            </div>
                        </div>
                        <br>
                    <?php
                    endif; ?>
                </fieldset>
            </div>
        </div>

        <?php
        if ($permissions->hasPermission('can_delete_patient')): ?>
            <div class="row">
                <div class="col-md-12" style="text-align: center">
                    <button id="delete" type="submit" name="delete"
                            class="btn btn-danger">
                        <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                        Supprimer le patient
                    </button>
                </div>
            </div>
            <br>
        <?php
        endif; ?>
    </div>

    <!-- Modal With Warning -->
    <div id="warning" class="modal fade" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <p id="warning-text">Quitter sans enregistrer?</p>
                    <button id="confirmclosed" type="button" class="btn btn-danger">Oui</button>
                    <button id="refuseclosed" type="button" class="btn btn-primary" data-dismiss="modal">Non
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php
    if ($permissions->hasRole(Permissions::COORDONNATEUR_PEPS)) {
        ?>
        <!-- Modal pour le partage de dossiers entre Coordonnateur PEPS -->
        <form method="POST" class="form-horizontal" id="form-partage">
            <div class="modal fade" id="modal_partage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <fieldset class="can-disable">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title" id="modal-title-partage">Modal title</h3>
                            </div>
                            <div class="modal-body">
                                <div id="section_partage">
                                    <fieldset class="group-modal">
                                        <legend class="group-modal-titre">Choix du coordonnateur PEPS</legend>
                                        <div id="partage">
                                            <div id="listing_coordos_peps">
                                                <div class="col-md-3">
                                                    <label class="control-label" for="champ_partage"
                                                           style="margin: 5px">Partager
                                                        le dossier avec : </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="champ_partage" id="champ_partage"
                                                            style="padding: 7px 0;margin: 5px;width:auto;text-align: left">
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="aucun_coordos_peps" style="margin: 5px">
                                                Aucun autre coordonnateur régional PEPS n'a été trouvé dans votre région
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </fieldset>
                        <div class="modal-footer">
                            <!-- Boutons à droite -->
                            <button id="enregistrer-partage" type="submit" name="valid-entInitial"
                                    class="btn btn-success" style="display: block">Valider
                            </button>

                            <!-- Boutons à gauche -->
                            <button id="close-partage" type="button" data-dismiss="modal"
                                    class="btn btn-warning pull-left">
                                Abandon
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
    }
    ?>

    <!-- Loader Modal -->
    <div id="loader-modal" class="modal" role="dialog" data-backdrop="false">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="recherche-ins-title">Recherche de l'INS du bénéficaire en cours...</h3>
                </div>
                <div class="modal-body" style="text-align: center">
                    <div id="loading-section">
                        <img id="loader-modal-img" src="../../images/icon-loader.gif" alt="loader"
                             style="max-height: 100px">
                    </div>
                    <div id="ok-result-section" hidden="">
                        <div class="row">
                            <div class="col-md-1">
                                <img id="ok-img" src="../../images/green_checkmark.png" alt="ok-img"
                                     style="max-height: 30px">
                            </div>
                            <div class="col-md-11" style="text-align: left">
                                <p id="ok-result-txt"></p>
                            </div>
                        </div>
                    </div>
                    <div id="error-result-section" hidden="">
                        <div class="row">
                            <div class="col-md-1">
                                <img id="error-img" src="../../images/red_crossmark.png"
                                     alt="error-img"
                                     style="max-height: 30px">
                            </div>
                            <div class="col-md-11" style="text-align: left">
                                <p id="error-result-txt"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="ins-modal-footer">
                    <button id="ins-close" type="button" class="btn btn-warning pull-left">Fermer</button>
                    </divc>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../../js/fixHeader.js"></script>
    <script type="text/javascript" src="../../js/AccueilPatient.js"></script>
</body>
</html>