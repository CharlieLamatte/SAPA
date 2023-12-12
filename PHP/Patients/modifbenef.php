<?php

use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);

//Récupérer l'id du patient
$idPatient = $_GET['idPatient'];

$p = new Patient($bdd);
$patient = $p->readOne($idPatient);
if (!$patient) {
    erreur_invalid_page();
}

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

    <title>Modifier coordonnées</title>
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
    <script type="text/javascript" src="../../js/autocomplete.js"></script>
</head>

<body>
<?php
require '../header.php'; ?>

<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <div class="panel-body">
        <div style="text-align: center">
            <legend style="color:black">
                <a href="AccueilPatient.php?idPatient=<?php
                echo $idPatient ?>" style="color: black; margin-right: 50px;" class="btn btn-success btn-xs"><span
                            class="glyphicon glyphicon-arrow-left"></span></a>Retour
            </legend>
            <br>
        </div>
        <div id="ficheResume" class="tab-pane fade active in" style="text-align: center">
            <form class="form-horizontal" method="POST"
                  action="../FicheResume/ModifFiche.php?idPatient=<?= $idPatient; ?>"
                  onsubmit=" return verif_coordonnees()">
                <input id="id_patient" name="id_patient" value="<?= $idPatient; ?>" class="form-control input-md"
                       type="hidden">
                <div class="row" style="text-align: left">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <fieldset class="section-orange">
                            <legend class="section-titre-orange">Coordonnées du bénéficiaire</legend>
                            <input type="hidden" name="id_territoire" value="<?= $_SESSION['id_territoire']; ?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nom-patient">Nom de naissance : </label><span
                                            style="color: red">*</span>
                                </div>
                                <div class="col-md-6">
                                    <input id="nom-patient" name="nom-patient" type="text"
                                           value="<?= $patient['nom_naissance']; ?>" required maxlength="50"
                                           pattern="^[A-zÀ-ž]+(?:[\-' ][A-zÀ-ž]+)*$">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="prenom-patient">Premier prénom de naissance : </label><span
                                            style="color: red">*</span>
                                </div>
                                <div class="col-md-6">
                                    <input id="prenom-patient" name="prenom-patient" type="text"
                                           value="<?= $patient['premier_prenom_naissance']; ?>" required maxlength="50"
                                           pattern="^[A-zÀ-ž]+(?:[\-' ][A-zÀ-ž]+)*$">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="liste_prenom_naissance">Liste des prénoms de naissance : </label>
                                </div>
                                <div class="col-md-6">
                                    <input id="liste_prenom_naissance"
                                           value="<?= $patient['liste_prenom_naissance']; ?>"
                                           name="liste_prenom_naissance" type="text"
                                           pattern="^[A-zÀ-ž]+(?:[\-' ][A-zÀ-ž]+)*$" maxlength="100">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nom_utilise">Nom utilisé (obligatoire si différent du nom de naissance)
                                        : </label>
                                </div>
                                <div class="col-md-6">
                                    <input id="nom_utilise" value="<?= $patient['nom_utilise']; ?>" name="nom_utilise"
                                           type="text" maxlength="100">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="prenom_utilise">Prénom utilisé (obligatoire si différent du prénom de
                                        naissance) : </label>
                                </div>
                                <div class="col-md-6">
                                    <input id="prenom_utilise" value="<?= $patient['prenom_utilise']; ?>"
                                           name="prenom_utilise" type="text" maxlength="100">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="sexe">Sexe : </label><span style="color: red">*</span>
                                </div>
                                <div class="col-md-6">
                                    <select name="sexe" id="sexe_patient">
                                        <option value="F" <?php
                                        if ($patient['sexe_patient'] == "F") {
                                            echo "selected";
                                        } ?>>Femme
                                        </option>
                                        <option value="M" <?php
                                        if ($patient['sexe_patient'] == "M") {
                                            echo "selected";
                                        } ?>>Homme
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="dn">Date de naissance : </label><span style="color: red">*</span>
                                </div>
                                <div class="col-md-6">
                                    <input id="dn" name="dn"
                                           value="<?= $patient['date_naissance']; ?>" class="form-control input-md"
                                           style="width:200px" type="date" min="<?= $dateJourMoins150ans; ?>"
                                           max="<?= $dateJour; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="code_insee_naissance">Code INSEE naissance : </label>
                                </div>
                                <div class="col-md-6">
                                    <input id="code_insee_naissance"
                                           value="<?= $patient['code_insee_naissance']; ?>"
                                           name="code_insee_naissance" type="text" maxlength="5">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tel_f">Téléphone 1 :</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="tel_f" name="tel_f" type="text" pattern="[0-9]*" minlength="10"
                                           maxlength="10"
                                           placeholder="0XXXXXXXXX" value="<?= $patient['tel_fixe_patient']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tel_p">Téléphone 2 :</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="tel_p" name="tel_p" type="text" pattern="[0-9]*" minlength="10"
                                           maxlength="10"
                                           placeholder="0XXXXXXXXX" value="<?= $patient['tel_portable_patient']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email-patient">Email : </label>
                                </div>
                                <div class="col-md-6">
                                    <input id="email-patient" name="email-patient" type="email" maxlength="100"
                                           placeholder="xxxxx@xxxx.xxx"
                                           class="form-control"
                                           pattern="[a-zA-Z0-9._\-]+[@][a-zA-Z0-9._\-]+[.][a-zA-Z.]{2,15}"
                                           value="<?= $patient['email_patient']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="adresse-patient">Adresse : </label><span style="color: red">*</span>
                                </div>
                                <div class="col-md-6">
                                    <input id="adresse-patient" name="adresse-patient" type="text" maxlength="200"
                                           value="<?= $patient['nom_adresse']; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="complement-adresse-patient">Complément d'adresse : </label>
                                </div>
                                <div class="col-md-6">
                                    <input id="complement-adresse-patient" name="complement-adresse-patient" type="text"
                                           maxlength="100"
                                           placeholder="Appartement,...(facultatif)"
                                           value="<?= $patient['complement_adresse']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="code-postal-patient">Code Postal : </label><span
                                            style="color: red">*</span>
                                </div>
                                <div class="col-md-6">
                                    <input autocomplete="off" id="code-postal-patient" type="text"
                                           name="code-postal-patient"
                                           maxlength="5"
                                           required pattern="^[0-9]+$" value="<?= $patient['code_postal']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="ville-patient">Ville : </label><span style="color: red">*</span>
                                </div>
                                <div class="col-md-6">
                                    <input id="ville-patient" name="ville-patient" type="text" maxlength="50"
                                           value="<?= $patient['nom_ville']; ?>" required readonly>
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
                                           pattern="^[A-zÀ-ž]+(?:[-' ][A-zÀ-ž]+)*$"
                                           value="<?= $patient['nom_contact_urgence']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="prenom_urgence">Prénom : </label>
                                </div>
                                <div class="col-md-6">
                                    <input id="prenom_urgence" name="prenom_urgence" type="text" maxlength="50"
                                           pattern="^[A-zÀ-ž]+(?:[-' ][A-zÀ-ž]+)*$"
                                           value="<?= $patient['prenom_contact_urgence']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="id_lien">Le contact est son/sa : </label>
                                </div>
                                <div class="col-md-6">
                                    <select name="id_lien" type="text" style="width:200px" value="" id="id_lien">
                                        <?php
                                        //Requete liens select dans la table avec return de l'id et du type. La valeur récupérée sera l'id_lien
                                        $query = $bdd->prepare(
                                            'SELECT id_lien, type_lien FROM liens ORDER BY type_lien'
                                        );
                                        $query->execute();
                                        while ($data = $query->fetch()) {
                                            if ($data['id_lien'] == $patient['id_lien']) {
                                                echo '<option value="' . $data['id_lien'] . '" selected>' . $data['type_lien'] . '</option>';
                                            } else {
                                                echo '<option value="' . $data['id_lien'] . '">' . $data['type_lien'] . '</option>';
                                            }
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
                                    <input id="tel_urgence_f" name="tel_urgence_f" pattern="[0-9]*" type="text"
                                           minlength="10"
                                           maxlength="10" placeholder="0XXXXXXXXX"
                                           value="<?= $patient['tel_fixe_contact_urgence']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tel_urgence_p">Téléphone 2 :</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="tel_urgence_p" name="tel_urgence_p" pattern="[0-9]*" type="text"
                                           minlength="10"
                                           maxlength="10" placeholder="0XXXXXXXXX"
                                           value="<?= $patient['tel_portable_contact_urgence']; ?>">
                                </div>
                            </div>
                            <br>

                            <div style="text-align: center">
                                <input type="submit" name="enregistrer" value="Enregistrer les modifications"
                                       class="btn btn-success btn-xs">
                            </div>

                            <br>
                        </fieldset>
                    </div>
                </div>
        </div>
    </div>
</div>
<script>
    function verif_coordonnees() {
        let new_tel_p = document.getElementById("tel_p").value;
        let new_tel_f = document.getElementById("tel_f").value;
        let new_email = document.getElementById("email-patient").value;
        let tel_p_U = document.getElementById("tel_urgence_p").value;
        let tel_f_U = document.getElementById("tel_urgence_f").value;

        if ((new_tel_p == "") && (new_tel_f == "") && (new_email == "")) {
            alert("PATIENT : Vous devez saisir un numéro de téléphone ou une adresse mail");
            return false;
        } else if ((new_tel_p != "") && (new_tel_f != "") && (new_tel_p == new_tel_f)) {
            alert("PATIENT : Les numéros de téléphone doivent être différents");
            return false;
        } else if ((tel_f_U != "") && (tel_p_U != "") && (tel_f_U == tel_p_U)) {
            alert("CONTACT D'URGENCE : Les deux numéros de téléphone doivent être différents")
            return false;
        } else if ((new_tel_p != "") && (tel_p_U != "") && (new_tel_p == tel_p_U)) {
            alert("Les numéros de téléphone du patient et du contact d'urgence doivent être différents");
            return false;
        } else if ((new_tel_p != "") && (tel_p_U != "") && (new_tel_f == tel_p_U)) {
            alert("Les numéros de téléphone du patient et  portable du contact d'urgence doivent être différents");
            return false;
        } else if ((new_tel_p != "") && (tel_f_U != "") && (new_tel_p == tel_f_U)) {
            alert("Les numéros de téléphone du patient et fixe du contact d'urgence doivent être différents");
            return false;
        }
        return true;
    }
</script>

<script type="text/javascript" src="../../js/modifBenef.js"></script>
<script type="text/javascript" src="../../js/confirmExitPage.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>

</html>