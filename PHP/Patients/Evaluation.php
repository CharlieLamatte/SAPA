<?php

use Sportsante86\Sapa\Outils\Permissions;

use function Sportsante86\Sapa\Outils\format_date;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_evaluation')) {
    erreur_permission();
}

$idPatient = $_GET['idPatient'];

// si une évaluation vient d'être créée
$newEvalNonFinal = "0";
if (isset($_SESSION['new_eval_non_finale'])) {
    if ($_SESSION['new_eval_non_finale']) {
        //cette valeur veut dire qu'on va proposer la programmation de la date d'évaluation suivante
        $newEvalNonFinal = "1";
        unset($_SESSION['new_eval_non_finale']);
    }
}
?>

<!-- Cette page permet d'ajouter une nouvelle évaluation pour un patient. On arrivera sur un formulaire avec 7 box au titre prédéfini avec une mini liste déroulante pour indiquer si le test à été effectué au cours de l'entretien. Un espace de texte libre est aussi mis à disposition pour renseigner les résultats -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Évaluations</title>

    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/sante.css">
    <link rel="stylesheet" href="../../css/synthese.css">
    <link rel="stylesheet" href="../../css/evaluation.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">

    <script type="text/javascript" src='../../js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>
<?php
require '../header.php'; ?>
<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <?php
    if ($_ENV['ENVIRONNEMENT'] === 'TEST'): ?>
        <div style="text-align: center">
            <button id="delete-evaluations" class="btn btn-danger btn-sm">Supprimer toutes les évaluations</button>
            <script>
                const deleteButton = document.getElementById("delete-evaluations");
                deleteButton.onclick = () => {
                    fetch('./Evaluation/DeleteEvaluationsPatient.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            id_patient: "<?= $idPatient; ?>",
                        })
                    })
                        .finally(() => {
                            location.reload();
                        });
                }
            </script>
        </div>
    <?php
    endif; ?>

    <?php
    //trouver les id de chaque evaluation (id max)

    $trouverideval = $bdd->prepare(
        'SELECT id_evaluation FROM evaluations WHERE id_patient = :idPatient ORDER BY id_type_eval'
    );
    $trouverideval->bindValue(':idPatient', $idPatient, PDO::PARAM_STR);
    $trouverideval->execute();

    while ($data = $trouverideval->fetch(PDO::FETCH_ASSOC)) {
        $id_evalini = $data['id_evaluation'];

        //Récupération des données de la table : evaluation
        $query = $bdd->prepare(
            "SELECT date_eval, nom_coordonnees, prenom_coordonnees, nom_structure, id_structure, type_eval, evaluations.id_user FROM evaluations JOIN users using(id_user) JOIN coordonnees USING(id_coordonnees) JOIN structure USING(id_structure) JOIN type_eval USING(id_type_eval) WHERE id_evaluation = :id_evalini"
        );
        $query->bindValue(":id_evalini", $id_evalini);
        $query->execute();
        $info_evalini = $query->fetch();

        $date_eval = format_date($info_evalini['date_eval']);
        $nom_eval = $info_evalini['nom_coordonnees'];
        $prenom_eval = $info_evalini['prenom_coordonnees'];
        $nom_struc = $info_evalini['nom_structure'];
        $id_structure = $info_evalini['id_structure'];
        $type_eval = $info_evalini['type_eval'];
        $id_eval = $info_evalini['id_user'];

        //Recupération de la commune
        $requete = $bdd->prepare(
            "SELECT nom_ville from villes join se_localise_a using(id_ville) join se_situe_a using(id_adresse) where id_structure = :id_structure"
        );
        $requete->bindValue(":id_structure", $id_structure);
        $requete->execute();
        $info_commune = $requete->fetch();

        $commune = $info_commune['nom_ville'];
        ?>
        <center>
            <div style="margin-top:5%;border:solid;height:auto;color:red; width : 80%">
                <center>
                    <div style="font-size: 20px;display: inline; background-color: rgb(255, 0, 0); color: #fff; "><?php
                        echo $type_eval ?> </div>
                </center>
            </div>
        </center>

        <!-- Bouton de modification -->
        <div style="text-align: center; margin-bottom: 5px; margin-top: 5px">
            <?php
            if (!$permissions->hasRole(Permissions::INTERVENANT) ||
                $permissions->isIntervenantAndOtherRole() ||
                ($permissions->hasRole(Permissions::INTERVENANT) && $_SESSION['id_user'] == $id_eval)) {
                echo "<button class=\"btn btn-success btn-xs\"><a style=\"color: white\" href=\"../Patients/ModifEval.php?idPatient=$idPatient&id_eval=$id_evalini\">Modifier l'évaluation</a></button>";
            }
            ?>
            <button id="open-modal" class="btn btn-success btn-xs open-modal" data-toggle="modal" data-target="#modal"
                    data-id_evaluation="<?php
                    echo $id_evalini ?>">
                Détails évaluation
            </button>
        </div>

        <center>
            <div style="border:solid;height:auto;border-color:red; width : 80%">
                <!-- Formulaire d'affichage -->
                <table width=100%>
                    <!-- 1er ligne -->
                    <tr style="text-align : center;" class="spaceUnder">
                        <td>
                            <?php
                            echo '<label for="evaluateur"> Evaluateur :  </label> ';
                            echo $nom_eval;
                            echo "  ";
                            echo $prenom_eval;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo '<label for="nom_struc"> Nom de la structure : </label> ' . $nom_struc . '';
                            ?>
                        </td>
                        <td>
                            <?php
                            echo '<label for="commune"> Commune : </label> ' . $commune . ' ';
                            ?>
                        </td>
                        <td>
                            <?php
                            echo '<label for="date_eval"> Date de l\'évaluation : </label> ' . $date_eval . '';
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </center>
        <?php
    } //fin du while
    //echo '</div>';
    ?>

    <!-- Bouton pour ajouter une évaluation ou message -->
    <div style="margin-left : 5%; margin-right : 5%">
        <div style="text-align: center">
            <?php
            $query = 'SELECT type_eval
                        FROM evaluations
                        JOIN type_eval te on evaluations.id_type_eval = te.id_type_eval
                        WHERE id_patient = :idPatient
                        ORDER BY evaluations.id_type_eval DESC
                        LIMIT 1';
            $stmt = $bdd->prepare($query);
            $stmt->bindValue(':idPatient', $idPatient);
            $stmt->execute();

            $diplay_button = true;

            if ($stmt->rowCount() > 0) {
                $data_ = $stmt->fetch();

                if ($data_['type_eval'] == 'Entretien Final') {
                    $diplay_button = false;
                }
            }

            if ($diplay_button) {
                echo '<button id="add-evaluation" class="btn btn-success btn-xs" style="margin-top:20px" onclick="window.location.href=\'../Patients/AjoutEvaluation.php?idPatient=' . $idPatient . '\'">Ajouter une evaluation</button>';
            } else {
                echo "<div style='margin-top:20px'>
                        L'évaluation finale a déjà été saisie.<br>
                        Il n'est plus possible d'ajouter d'autres évaluations.                            
                        </div>";
            }
            ?>
        </div>
    </div>

    <form method="POST" class="form-horizontal" id="form-creneau">
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
                            <div id="section-eval-suiv" data-new-eval="<?= $newEvalNonFinal ?>">
                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Prochaine évaluation</legend>
                                    <div id="eval_suiv">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label" for="date_eval_suiv">Date de la prochaine
                                                    évaluation :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input id="date_eval_suiv" name="date_eval_suiv"
                                                       min="<?= date("Y-m-d"); ?>"
                                                       class="form-control input-md"
                                                       type="date">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div id="section-creneau">
                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Test physiologique</legend>
                                    <div id="test_physio_fait">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_physio_poids">Poids</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_physio_poids" name="test_physio_poids" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_physio_taille">Taille</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_physio_taille" name="test_physio_taille" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_physio_imc">IMC</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_physio_imc" name="test_physio_imc" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_physio_tour_taille">Tour de
                                                    taille</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_physio_tour_taille" name="test_physio_tour_taille"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_physio_saturation_repos">Saturation
                                                    de
                                                    repos</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_physio_saturation_repos"
                                                       name="test_physio_saturation_repos"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_physio_borg_repos">Borg de
                                                    repos</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_physio_borg_repos" name="test_physio_borg_repos"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_physio_fc_repos">FC de
                                                    repos</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_physio_fc_repos" name="test_physio_fc_repos" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_physio_fc_max_mesuree">FC max
                                                    mesurée</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_physio_fc_max_mesuree" name="test_physio_fc_max_mesuree"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_physio_fc_max_theorique">FC max
                                                    théorique</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_physio_fc_max_theorique"
                                                       name="test_physio_fc_max_theorique"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test_physio_nonfait">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label" for="test_physio_motif">Le test n'a pas été
                                                    réalisé pour le motif suivant</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="test_physio_motif" name="test_physio_motif" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Aptitudes Aérobie</legend>
                                    <div id="test_aptitude_aerobie_fait">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="control-label" for="test_aptitude_aerobie_distance">Distance
                                                    parcourue (m)</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_aptitude_aerobie_distance"
                                                       name="test_aptitude_aerobie_distance"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label"
                                                       for="test_aptitude_aerobie_distance_theorique">Pourcentage
                                                    de la distance théorique</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_aptitude_aerobie_distance_theorique"
                                                       name="test_aptitude_aerobie_distance_theorique" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table id="test_aptitude_aerobie-body-tableau"
                                                           class="table table-bordered table-striped table-hover table-condensed"
                                                           style="width:100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>FC</th>
                                                            <th>Saturation (% SpO2)</th>
                                                            <th>Echelle de Borg</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="test_aptitude_aerobie_body">
                                                        <tr>
                                                            <td>1 min</td>
                                                            <td id="test_aptitude_aerobie_fc1">fc1</td>
                                                            <td id="test_aptitude_aerobie_sat1">sat1</td>
                                                            <td id="test_aptitude_aerobie_borg1">borg1</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2 min</td>
                                                            <td id="test_aptitude_aerobie_fc2">fc2</td>
                                                            <td id="test_aptitude_aerobie_sat2">sat2</td>
                                                            <td id="test_aptitude_aerobie_borg2">borg2</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3 min</td>
                                                            <td id="test_aptitude_aerobie_fc3">fc3</td>
                                                            <td id="test_aptitude_aerobie_sat3">sat3</td>
                                                            <td id="test_aptitude_aerobie_borg3">borg3</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4 min</td>
                                                            <td id="test_aptitude_aerobie_fc4">fc4</td>
                                                            <td id="test_aptitude_aerobie_sat4">sat4</td>
                                                            <td id="test_aptitude_aerobie_borg4">borg4</td>
                                                        </tr>
                                                        <tr>
                                                            <td>5 min</td>
                                                            <td id="test_aptitude_aerobie_fc5">fc5</td>
                                                            <td id="test_aptitude_aerobie_sat5">sat5</td>
                                                            <td id="test_aptitude_aerobie_borg5">borg5</td>
                                                        </tr>
                                                        <tr>
                                                            <td>6 min</td>
                                                            <td id="test_aptitude_aerobie_fc6">fc6</td>
                                                            <td id="test_aptitude_aerobie_sat6">sat6</td>
                                                            <td id="test_aptitude_aerobie_borg6">borg6</td>
                                                        </tr>
                                                        <tr>
                                                            <td>7 min dont 1 min de repos</td>
                                                            <td id="test_aptitude_aerobie_fc7">fc7</td>
                                                            <td id="test_aptitude_aerobie_sat7">sat7</td>
                                                            <td id="test_aptitude_aerobie_borg7">borg7</td>
                                                        </tr>
                                                        <tr>
                                                            <td>8 min dont 2 min de repos</td>
                                                            <td id="test_aptitude_aerobie_fc8">fc8</td>
                                                            <td id="test_aptitude_aerobie_sat8">sat8</td>
                                                            <td id="test_aptitude_aerobie_borg8">borg8</td>
                                                        </tr>
                                                        <tr>
                                                            <td>9 min dont 3 min de repos</td>
                                                            <td id="test_aptitude_aerobie_fc9">fc9</td>
                                                            <td id="test_aptitude_aerobie_sat9">sat9</td>
                                                            <td id="test_aptitude_aerobie_borg9">borg9</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_aptitude_aerobie_commentaires">Commentaires</label>
                                            </div>
                                            <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_aptitude_aerobie_commentaires"
                                                  name="test_aptitude_aerobie_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test_aptitude_aerobie_nonfait">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label" for="test_aptitude_aerobie_motif">Le test
                                                    n'a
                                                    pas été
                                                    réalisé pour le motif suivant</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="test_aptitude_aerobie_motif"
                                                       name="test_aptitude_aerobie_motif"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal" id="test_up_and_go_fieldset" hidden>
                                    <legend class="group-modal-titre">Test times UP and GO</legend>
                                    <div id="test_up_and_go_fait">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_up_and_go_duree">Durée
                                                    (s)</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_up_and_go_duree" name="test_up_and_go_duree" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label"
                                                       for="test_up_and_go_commentaires">Commentaires</label>
                                            </div>
                                            <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_up_and_go_commentaires"
                                                  name="test_up_and_go_commentaires" class="form-control input-md"
                                                  readonly></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test_up_and_go_nonfait">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label" for="test_up_and_go_motif">Le test n'a pas
                                                    été
                                                    réalisé pour le motif suivant</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="test_up_and_go_motif" name="test_up_and_go_motif" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Force musculaire membres supérieurs</legend>
                                    <div id="test_membre_sup_fait">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_membre_sup_main_dominante">Main
                                                    dominante</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_membre_sup_main_dominante"
                                                       name="test_membre_sup_main_dominante"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_membre_sup_main_droite">Main
                                                    Droite
                                                    (kg)</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_membre_sup_main_droite"
                                                       name="test_membre_sup_main_droite"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_membre_sup_main_gauche">Main
                                                    Gauche
                                                    (kg)</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_membre_sup_main_gauche"
                                                       name="test_membre_sup_main_gauche"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label"
                                                       for="test_membre_sup_commentaires">Commentaires</label>
                                            </div>
                                            <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_membre_sup_commentaires"
                                                  name="test_membre_sup_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test_membre_sup_nonfait">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label" for="test_membre_sup_motif">Le test n'a pas
                                                    été
                                                    réalisé pour le motif suivant</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="test_membre_sup_motif" name="test_membre_sup_motif" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Equilibre statique</legend>
                                    <div id="test_equilibre_fait">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_equilibre_pied_dominant">Pied
                                                    dominant</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_equilibre_pied_dominant"
                                                       name="test_equilibre_pied_dominant"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_equilibre_pied_gauche">Pied
                                                    gauche au
                                                    sol
                                                    (sec)</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_equilibre_pied_gauche" name="test_equilibre_pied_gauche"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_equilibre_pied_droit">Pied droit
                                                    au
                                                    sol
                                                    (sec) </label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_equilibre_pied_droit" name="test_equilibre_pied_droit"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label"
                                                       for="test_equilibre_commentaires">Commentaires</label>
                                            </div>
                                            <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_equilibre_commentaires"
                                                  name="test_equilibre_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test_equilibre_nonfait">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label" for="test_equilibre_motif">Le test n'a pas
                                                    été
                                                    réalisé pour le motif suivant</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="test_equilibre_motif" name="test_equilibre_motif" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Souplesse</legend>
                                    <div id="test_souplesse_fait">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_souplesse_distance">Distance
                                                    majeur
                                                    au
                                                    sol</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_souplesse_distance" name="test_souplesse_distance"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label"
                                                       for="test_souplesse_commentaires">Commentaires</label>
                                            </div>
                                            <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_souplesse_commentaires"
                                                  name="test_souplesse_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test_souplesse_nonfait">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label" for="test_souplesse_motif">Le test n'a pas
                                                    été
                                                    réalisé pour le motif suivant</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="test_souplesse_motif" name="test_souplesse_motif" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Mobilité scapulo-humérale</legend>
                                    <div id="test_mobilite_fait">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_mobilite_main_gauche">Main Gauche
                                                    en
                                                    haut
                                                    (cm)</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_mobilite_main_gauche" name="test_mobilite_main_gauche"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_mobilite_main_droite">Main Droite
                                                    en
                                                    haut
                                                    (cm)</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_mobilite_main_droite" name="test_mobilite_main_droite"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label"
                                                       for="test_mobilite_commentaires">Commentaires</label>
                                            </div>
                                            <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_mobilite_commentaires"
                                                  name="test_mobilite_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test_mobilite_nonfait">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label" for="test_mobilite_motif">Le test n'a pas
                                                    été
                                                    réalisé pour le motif suivant</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="test_mobilite_motif" name="test_mobilite_motif" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Endurance musculaire membres inférieurs</legend>
                                    <div id="test_membre_inf_fait">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_membre_inf_nombre">Nombre de
                                                    levers</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_membre_inf_nombre" name="test_membre_inf_nombre"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_membre_inf_fc_30">FC à 30
                                                    sec</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_membre_inf_fc_30" name="test_membre_inf_fc_30"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_membre_inf_sat_30">Saturation à
                                                    30
                                                    sec</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_membre_inf_sat_30" name="test_membre_inf_sat_30"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label" for="test_membre_inf_borg_30">Borg à 30
                                                    sec</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input id="test_membre_inf_borg_30" name="test_membre_inf_borg_30"
                                                       value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label class="control-label"
                                                       for="test_membre_inf_commentaires">Commentaires</label>
                                            </div>
                                            <div class="col-md-10">
                                        <textarea style="width: 100%" id="test_membre_inf_commentaires"
                                                  name="test_membre_inf_commentaires"
                                                  class="form-control input-md" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test_membre_inf_nonfait">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="control-label" for="test_membre_inf_motif">Le test n'a pas
                                                    été
                                                    réalisé pour le motif suivant</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input id="test_membre_inf_motif" name="test_membre_inf_motif" value=""
                                                       class="form-control input-md"
                                                       type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal" hidden>
                                    <legend class="group-modal-titre">Questionnaire ONAPS</legend>
                                    <div class="row">

                                    </div>

                                </fieldset>
                            </div>
                        </div>
                    </fieldset>

                    <div class="modal-footer">
                        <!-- Boutons à droite-->
                        <button id="enregistrer-modifier" type="submit" name="valid-entInitial"
                                class="btn btn-success pull-right" data-id_patient="<?= $idPatient ?>">Enregistrer
                        </button>
                        <!-- Boutons à gauche -->
                        <button id="close" type="button" data-dismiss="modal" class="btn btn-warning pull-left">Quitter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal With Warning -->
<div id="warning" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <p id="warning-text">Programmer la prochaine évaluation ?</p>
                <button id="confirmclosed" type="button" class="btn btn-danger">Oui</button>
                <button id="refuseclosed" type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>

<br><br>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
<script type="text/javascript" src="../../js/calculsEvaluation.js"></script>
<script type="text/javascript" src="../../js/evaluation.js"></script>
</body>
</html>