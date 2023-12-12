<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ajout évaluation</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

    <!-- Script -->
    <script type="text/javascript" src="../../js/commun.js"></script>
    <script type="text/javascript" src="../../js/functions.js"></script>
    <script type="text/javascript" src='../../js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body onbeforeunload="return confirm()">

<!-- Script permettant d'éviter le pop-up d'avertissement de changement de page lors du clique sur le bouton "Enregistrer" -->
<script>
    $(document).on("submit", "form", function (event) {
        window.onbeforeunload = null;
    });
</script>
<!-- Page Content -->
<!--div class="container"-->

<?php
//Récupération de l'id Patient
$idPatient = $_GET['idPatient'];

require '../header.php';
?>

<?php

// TROUVER LA DATE MAX
$idPatient = $_GET['idPatient'];

// date du jour
$date = date("Y-m-d");

// Calcul fc_max_theo
$fc_max_theo = 220 - $age;

//Trouver les id de chaque evaluation (id max)
$evaluation_ids = array_fill(1, 14, null);
for ($i = 1; $i <= 14; $i++) {
    //$data["id_eval"] = null;
    $query = '
        SELECT
        MAX(id_evaluation) as id_eval
        FROM evaluations
        WHERE id_patient = :idPatient
          AND id_type_eval = :id_type_eval';
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':idPatient', $idPatient, PDO::PARAM_STR);
    $stmt->bindValue(':id_type_eval', $i);
    $stmt->execute();
    $data = $stmt->fetch();

    $evaluation_ids[$i] = $data["id_eval"];
}
?>

<div class="panel-body">
    <!-- The toast -->
    <div id="toast"></div>

    <center>
        <legend style="color:black">
            <a href="Evaluation.php?idPatient=<?php
            echo $idPatient ?>" style="color: black; margin-right: 50px;"
               class="btn btn-success btn-xs"><span class="glyphicon glyphicon-arrow-left"></span></a>Retour
        </legend>
        <br>
    </center>

    <!-- 1er tableau : informations -->
    <div style="size : 1px; color:red; margin-left:10%;">Les champs marqués par un * sont obligatoires.</div>
    <?php
    echo "<form data-id_patient=\"$idPatient\" id=\"main-form\" method=\"POST\" action=\"Evaluation/CreateEvaluation.php?idPatient=" . $idPatient . "\">";
    echo '<font size="2"  color="#012678">'; ?>
    <div id="cadrerose">

        <table width=100% cellspacing="5" cellpading="8" padding="3">
            <br>
            <!-- 1er ligne -->
            <tr style="text-align : center;">
                <td><?php
                    echo '<span class="obligatoire">*</span><label for="date_eval"> Date de l\'évaluation : </label>'; ?></td>
                <td><?php
                    echo '<input type="date" name="date_eval" id="date_eval" required="required" value=' . $date . ' placeholder="" max=' . $date . '>'; ?></td>
                <td colspan=2>
                    <?php

                    echo '<span class="obligatoire">*</span><label for="evaluation"> Evaluation : </label> ';
                    echo ' <select name="eval_etat" id="eval_etat" style="width : 180px;"> ';

                    for ($i = 1; $i <= 14; $i++) {
                        $option = "";
                        if (empty($evaluation_ids[$i])) {
                            $option = "<option value=$i>";
                            if ($i == 1) {
                                $option .= "Initiale";
                            } elseif ($i == 14) {
                                $option .= "Finale";
                            } else {
                                $option .= "Intermédiaire " . ($i - 1) . " mois";
                            }
                            $option .= "</option>";
                        }

                        echo $option;
                    }
                    echo '</select>';
                    ?>
                </td>
                <td>

                </td>
            </tr>
        </table>
        <div></div>
        <br>
    </div>

    <br>


    <!-- 2e tableau : démographie -->

    <center>
        <label for="auto"> Le test physiologique a été réalisé : </label>
        <input type="radio" id="radio_y0" name="auto0" checked value=1><label>Oui</label>
        <input type="radio" id="radio_n0" name="auto0" class="no" value=2><label>Non</label>
    </center>

    <div name="cadreform_testphysio" id="cadreform_testphysio">
        <div id="cadrevert">
            <table width=100% cellspacing="5" cellpading="8" padding="1">
                <br>

                <!-- 1e ligne -->

                <tr style="text-align: center ;">
                    <td><label for="poids"> Poids (kg) : </label></td>
                    <td><input autocomplete="off" type="number" name="poids" id="poids" step="0.1" min="0" max="300"
                               value="" placeholder="0-300 kg"></td>
                    <td><label for="taille"> Taille (cm) : </label></td>
                    <td><input autocomplete="off" type="number" name="taille" id="taille" value="" step="0.1" min="0"
                               max="250" placeholder="0-250 cm"></td>
                    <td><label for="IMC"> IMC : </label></td>
                    <td><input type="text" name="IMC" id="IMC" readonly class="gris" value="" placeholder="" size=14>
                    </td>

                </tr>

                <!-- 2e ligne -->

                <tr style="text-align : center;">
                    <td><label for="tour_taille"> Tour de taille (cm) : </label></td>
                    <td><input type="number" name="tour_taille" id="tour_taille" value="" step="0.1"
                               placeholder="10-200 cm" min="10" max="200"></td>
                    <td><label for="satrepos"> Saturation de repos (% SpO2) : </label></td>
                    <td><input type="number" name="satrepos" id="satrepos" value="" min="60" max="100"
                               placeholder="60-100 %" step="1"></td>
                    <td></td>
                    <td></td>
                </tr>

                <!-- 3e ligne -->
                <tr style="text-align : center;">
                    <td><label for="fcrepos"> FC au repos (bpm) : </label></td>
                    <td><input type="number" name="fcrepos" id="fcrepos" value="" min="20" max="220"
                               placeholder="20-220 bpm"></td>
                    <td><label for="fcmax"> FC max mesurée (bpm) : </label></td>
                    <td><input type="number" name="fcmax" id="fcmax" value="" min="20" max="220"
                               placeholder="20-220 bpm"></td>
                    <td><label for="fc_max_theo"> FC max théorique (bpm) : </label></td>
                    <td><?php
                        echo $fc_max_theo; ?></td>
                </tr>
            </table>
            <br>
            <div class="panel panel-default panel-body" style="margin: 5px">
                <div>
                    <label for="borgrepos" class="main-questions-enonce">Borg de repos :</label>
                    <div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="borgrepos-1" name="borgrepos" value="1">
                                1: Aucun effort
                                <div class="help-block">Je suis en pleine détente</div>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="borgrepos-2" name="borgrepos" value="2">
                                2: Extrêmement facile
                                <div class="help-block">Je peux maintenir ce rythme très longtemps</div>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="borgrepos-3" name="borgrepos" value="3">
                                3: Très facile
                                <div class="help-block">Je suis dans ma zone de confort et tout va bien</div>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="borgrepos-4" name="borgrepos" value="4">
                                4: Facile
                                <div class="help-block">Je commence à être légèrement essouflé</div>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="borgrepos-5" name="borgrepos" value="5">
                                5: Modéré
                                <div class="help-block">Légèrement fatiguant, je respire plus rapidement</div>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="borgrepos-6" name="borgrepos" value="6">
                                6: Moyennement difficile
                                <div class="help-block">Je peux parler mais en prenant des pauses</div>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="borgrepos-7" name="borgrepos" value="7">
                                7: Difficile
                                <div class="help-block">Je suis essouflé</div>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="borgrepos-8" name="borgrepos" value="8">
                                8: Très difficile
                                <div class="help-block">Je sors de ma zone de confort</div>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="borgrepos-9" name="borgrepos" value="9">
                                9: Extrêmement difficile
                                <div class="help-block">Je peux tenir ce rythme sur une très courte période</div>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id="borgrepos-10" name="borgrepos" value="10">
                                10: Effort maximal
                                <div class="help-block">Je ne peux pas parler</div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div name="cadremotif_testphysio" id="cadremotif_testphysio" class="toggle_off">
        <center>

            <label for="motif_test_physio"> Le test physiologique n'a pas été effectué car : </label>
            <select name="motif_test_physio" id="motif_test_physio" class="select" style="width : 180px;">
                <option value=""> Pourquoi ?</option>
                <option value=1> Problème d'espace</option>
                <option value=2> Problème de matériel</option>
                <option value=3> Incapacité pour le patient</option>
                <option value=4> Manque de temps</option>
            </select>

        </center>
    </div>
    <br>
</div>

<!-- Partie Evaluation -->

<!-- APTITUDE AEROBIE -->

<div class="blocgeneral">

		<span class="bloc1">

			<div id="blocphoto1">
			</div>

			<div class="bloctitre">
				Aptitudes Aérobie
			</div>
            <br>
            <div class="blocphrase">
				Test 6 minutes marche active
                <br>
                <br>
                <label for="auto1"> Le test d'aptitude aerobie a été réalisé : </label>
				<input type="radio" name="auto1" id="radio_y1" checked value="1"><label>Oui</label>
				<input type="radio" name="auto1" id="radio_n1" class="no" value="2"><label>Non</label>
                <!-- <input type="checkbox" name="auto1_" id="auto1_" value="1" onclick="formulaire_cache_visible2('cadreform_aa','cadremotif_aa')"> <label for="auto1_">Non</label> -->
			</div>
		</span>

    <div name="cadreform_aa" id="cadreform_aa">

        <div class="bloc2">

            <span class="obligatoire">*</span><label for="dp"> Distance parcourue (m): </label>
            <input required type="number" id="dp" name="dp" placeholder="0-800 m" step="1" min="0" max="800"
                   autocomplete="off" value="">
            <?php
            //Passage des champs en hidden pour récupérer les valeurs de l'age et le sexe contenu dans le header
            echo '<input type="hidden" id="age_recup" name="age_recup" value=' . $age . '>';
            echo '<input type="hidden" id="sexe_recup" name="sexe_recup" value=' . $patient['sexe_patient'] . '>';
            echo '<label> Pourcentage de la distance théorique :</label>';
            echo '<input type="text" name="distance_theo" id="distance_theo" readonly size=55>';
            ?>

            <!--TABLEAU TDM6-->
            <!---- TABLEAU AVEC LA FC ET LA SAT -->
            <table>
                <tr>
                    <td></td>
                    <td style="text-align : center;">FC (bpm)</td>
                    <td style="text-align : center;">Saturation (% SpO2)</td>
                    <td style="text-align : center;" colspan=12>Echelle de Borg</td>
                </tr>
                <tr>
                    <td colspan=3></td>
                    <td style="text-align : center;" width="150">1: Aucun effort</td>
                    <td style="text-align : center;" width="150">2: Extrêmement facile</td>
                    <td style="text-align : center;" width="150">3: Très facile</td>
                    <td style="text-align : center;" width="150">4: Facile</td>
                    <td style="text-align : center;" width="150">5: Modéré</td>
                    <td style="text-align : center;" width="150">6: Moyennement difficile</td>
                    <td style="text-align : center;" width="150">7: Difficile</td>
                    <td style="text-align : center;" width="150">8: Très difficile</td>
                    <td style="text-align : center;" width="150">9: Extrêmement difficile</td>
                    <td style="text-align : center;" width="150">10: Effort maximal</td>
                </tr>
                <!-- Ligne 1 min -->
                <tr style="background-color:rgba(37,100,250,0.5);">
                    <td style="text-align : center;" width="150">1 min</td>
                    <td style="text-align : center;"><input type="number" name="fc1" id="fc1" value=""
                                                            placeholder="20-220 bpm" min="0" max="220"></td>
                    <td style="text-align : center;"><input type="number" name="sat1" id="sat1" value=""
                                                            placeholder="60-100 %" step="1" min="60" max="100"></td>
                    <!--Echelle de borg-->
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<td style="text-align : center;">';
                        echo '<input type="radio" name="borg1" value="' . $i . '">';
                        echo '</td>';
                    }
                    ?>
                </tr>
                <!-- Ligne 2 min -->
                <tr>
                    <td style="text-align : center;">2 min</td>
                    <td style="text-align : center;"><input type="number" name="fc2" id="fc2" value=""
                                                            placeholder="20-220 bpm" min="0" max="220"></td>
                    <td style="text-align : center;"><input type="number" name="sat2" id="sat2" value=""
                                                            placeholder="60-100 %" step="1" min="60" max="100"></td>
                    <!--Echelle de borg-->
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<td style="text-align : center;">';
                        echo '<input type="radio" name="borg2" value="' . $i . '">';
                        echo '</td>';
                    }
                    ?>
                </tr>
                <!-- Ligne 3 min -->
                <tr style="background-color:rgba(37,100,250,0.5);">
                    <td style="text-align : center;">3 min</td>
                    <td style="text-align : center;"><input type="number" name="fc3" id="fc3" value=""
                                                            placeholder="20-220 bpm" min="0" max="220"></td>
                    <td style="text-align : center;"><input type="number" name="sat3" id="sat3" value=""
                                                            placeholder="60-100 %" step="1" min="60" max="100"></td>
                    <!--Echelle de borg-->
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<td style="text-align : center;">';
                        echo '<input type="radio" name="borg3" value="' . $i . '">';
                        echo '</td>';
                    }
                    ?>
                </tr>
                <!-- Ligne 4 min -->
                <tr>
                    <td style="text-align : center;">4 min</td>
                    <td style="text-align : center;"><input type="number" name="fc4" id="fc4" value=""
                                                            placeholder="20-220 bpm" min="0" max="220"></td>
                    <td style="text-align : center;"><input type="number" name="sat4" id="sat4" value=""
                                                            placeholder="60-100 %" step="1" min="60" max="100"></td>
                    <!--Echelle de borg-->
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<td style="text-align : center;">';
                        echo '<input type="radio" name="borg4" value="' . $i . '">';
                        echo '</td>';
                    }
                    ?>
                </tr>
                <!-- Ligne 5 min -->
                <tr style="background-color:rgba(37,100,250,0.5);">
                    <td style="text-align : center;">5 min</td>
                    <td style="text-align : center;"><input type="number" name="fc5" id="fc5" value=""
                                                            placeholder="20-220 bpm" min="0" max="220"></td>
                    <td style="text-align : center;"><input type="number" name="sat5" id="sat5" value=""
                                                            placeholder="60-100 %" step="1" min="60" max="100"></td>
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<td style="text-align : center;">';
                        echo '<input type="radio" name="borg5" value="' . $i . '">';
                        echo '</td>';
                    }
                    ?>
                </tr>
                <!-- Ligne 6 min -->
                <tr>
                    <td style="text-align : center;">6 min<span class="obligatoire">*</span></td>
                    <td style="text-align : center;"><input required type="number" name="fc6" id="fc6" class="data_aa"
                                                            value="" placeholder="0-220 bpm" min="0" max="220"></td>
                    <td style="text-align : center;"><input required type="number" name="sat6" id="sat6" class="data_aa"
                                                            value="" placeholder="60-100 %" step="1" min="60"
                                                            max="100"></td>
                    <!--Echelle de borg-->
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<td style="text-align : center;">';
                        echo '<input type="radio" name="borg6" value="' . $i . '">';
                        echo '</td>';
                    }
                    ?>
                </tr>
                <!-- Ligne 7 min -->
                <tr style="background-color:rgba(37,100,250,0.5);">
                    <td style="text-align : center;">7 min dont 1 min de repos<span class="obligatoire">*</span></td>
                    <td style="text-align : center;"><input required type="number" name="fc7" id="fc7" class="data_aa"
                                                            value="" placeholder="0-220 bpm" min="0" max="220"></td>
                    <td style="text-align : center;"><input required type="number" name="sat7" id="sat7" class="data_aa"
                                                            value="" placeholder="60-100 %" step="1" min="60"
                                                            max="100"></td>
                    <!--Echelle de borg-->
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<td style="text-align : center;">';
                        echo '<input type="radio" name="borg7" value="' . $i . '">';
                        echo '</td>';
                    }
                    ?>
                </tr>
                <!-- Ligne 8 min -->
                <tr>
                    <td style="text-align : center;">8 min dont 2 min de repos <span class="obligatoire">*</span></td>
                    <td style="text-align : center;"><input required type="number" name="fc8" id="fc8" class="data_aa"
                                                            value="" placeholder="0-220 bpm" min="0" max="220"></td>
                    <td style="text-align : center;"><input required type="number" name="sat8" id="sat8" class="data_aa"
                                                            value="" placeholder="60-100 %" step="1" min="60"
                                                            max="100"></td>
                    <!--Echelle de borg-->
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<td style="text-align : center;">';
                        echo '<input type="radio" name="borg8" value="' . $i . '">';
                        echo '</td>';
                    }
                    ?>
                </tr>
                <!-- Ligne 9 min -->
                <tr style="background-color:rgba(37,100,250,0.5);">
                    <td style="text-align : center;">9 min dont 3 min de repos<span class="obligatoire">*</span></td>
                    <td style="text-align : center;"><input required type="number" name="fc9" id="fc9" class="data_aa"
                                                            value="" placeholder="0-220 bpm" min="0" max="220"></td>
                    <td style="text-align : center;"><input required type="number" name="sat9" id="sat9" class="data_aa"
                                                            value="" placeholder="60-100 %" step="1" min="60"
                                                            max="100"></td>
                    <!--Echelle de borg-->
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo '<td style="text-align : center;">';
                        echo '<input type="radio" name="borg9" value="' . $i . '">';
                        echo '</td>';
                    }
                    ?>
                </tr>
            </table>
            <!--FIN TABLEAU FC ET SAT -->

        </div>

        <div class="bloc3">
            <div class="bloccom">
            </div>
            <br>

            <input type="textarea" name="com_aa" id="com_aa" size=125 value="">
        </div>
    </div>
</div>

<div name="cadremotif_aa" id="cadremotif_aa" class="toggle_off">
    <center>
        <label for="motif_apt_aerobie"> Le test d'aptitude aerobie n'a pas été effectué car : </label>
        <select name="motif_apt_aerobie" id="motif_apt_aerobie" class="select" style="width : 180px;">
            <option value=""> Pourquoi ?</option>
            <option value=1> Problème d'espace</option>
            <option value=2> Problème de matériel</option>
            <option value=3> Incapacité pour le patient</option>
            <option value=4> Manque de temps</option>
        </select>'

    </center>

    <div class="blocgeneral">
		<span class="bloc1">
			<div class="bloctitre">
				Test times UP and GO
			</div>
            <br>
            <div class="blocphrase">
                <label for="auto1"> Le test times UP and GO a été réalisé : </label>
				<input type="radio" name="auto-up-and-go" id="radio-up-and-go-yes" checked value="1"><label
                        for="radio-up-and-go-yes">Oui</label>
				<input type="radio" name="auto-up-and-go" id="radio-up-and-go-no" class="no" value="2"><label
                        for="radio-up-and-go-no">Non</label>
                <br><br>
            </div>
            <div>
                <div class="bloc2" id="cadreform-up-and-go">
                    <label for="duree-up-and-go"> Durée (en secondes) : </label>
                    <input type="number" name="duree-up-and-go"
                           id="duree-up-and-go" value=""
                           placeholder="0-100000" step="1" min="0"
                           max="100000">
                    <br><br>
                    			<div class="bloc3">
				<div class="bloccom">
				</div><br>
                                    <input type="text" name="com-up-and-go" id="com-up-and-go" size=125 value="">
			</div>
                </div>
            </div>
		</span>
    </div>
    <div id="cadremotif-up-and-go" class="toggle_off" style="text-align: center">
        <label for="motif-up-and-go"> Le test times UP and GO n'a pas été effectué car : </label>
        <select name="motif-up-and-go" id="motif-up-and-go" class="select" style="width : 180px;">
            <option value=""> Pourquoi ?</option>
            <option value=1> Problème d'espace</option>
            <option value=2> Problème de matériel</option>
            <option value=3> Incapacité pour le patient</option>
            <option value=4> Manque de temps</option>
        </select>'
    </div>
</div>
<!-- Force musculaire membre sup -->


<div class="blocgeneral">

		<span class="bloc1">

			<div id="blocphoto2">
			</div>

			<div class="bloctitre">
				Force musculaire membres supérieurs
			</div>
            <br>
            <div class="blocphrase">
				Mesure de la force de préhension (en kg) <br>
                Le bénéficiaire est :
                <!-- on regarde si ce champs a déjà été rempli-->
				<?php
                $requete = "SELECT main_forte FROM eval_force_musc_mb_sup JOIN evaluations USING (id_evaluation) WHERE id_patient='$idPatient' AND main_forte IS NOT NULL ORDER BY main_forte DESC LIMIT 1";
                $main_recup = $bdd->prepare($requete);
                $main_recup->execute();
                $data = $main_recup->fetch(PDO::FETCH_ASSOC);
                $main_forte_r = $data['main_forte'] ?? null;

                if (!empty($main_forte_r)) {
                    echo ucfirst($main_forte_r);
                    echo '<input hidden type="text" name="main_forte" value="' . $main_forte_r . '"/>';
                    echo '<br>';
                } else {
                    echo '<input id="gaucher" type="radio" name="main_forte" value="gaucher"><label>Gaucher</label>';
                    echo '<input id="droitier" type="radio" name="main_forte" value="droitier" checked required><label>Droitier</label>';
                    echo '<br>';
                }
                echo '<label for="auto2"> Le test de force musculaire des membres supérieurs a été réalisé : </label>';
                echo '<input id="radio_y2" type="radio" name="auto2" checked value=1><label>Oui</label>';
                echo '<input id="radio_n2" type="radio" name="auto2" class="no" value=2><label>Non</label>';
                ?>
			</div>
		</span>

    <div name="cadreform_fmms" id="cadreform_fmms">
        <div class="bloc2">

            <label for="md"> Main Droite (kg) : </label> <input type="number" name="md" id="md" value=""
                                                                placeholder="0-300 kg" step="0.1" min="0" max="300">
            <label for="mg"> Main Gauche (kg) : </label> <input type="number" name="mg" id="mg" value=""
                                                                placeholder="0-300 kg" step="0.1" min="0" max="300">
        </div>

        <div class="bloc3">
            <div class="bloccom">
            </div>
            <br>
            <input type="textarea" name="com_fmms" id="com_fmms" size=125 value="">
        </div>
    </div>

</div>

<div name="cadremotif_fmms" id="cadremotif_fmms" class="toggle_off">
    <center>
        <label for="motif_fmms"> Le test de force musculaire membre supérieur n'a pas été effectué car : </label>
        <select name="motif_fmms" id="motif_fmms" class="select" style="width : 180px;">
            <option value=0> Pourquoi ?</option>
            <option value=1> Problème d'espace</option>
            <option value=2> Problème de matériel</option>
            <option value=3> Incapacité pour le patient</option>
            <option value=4> Manque de temps</option>
        </select>
    </center>

</div>

<!-- Equilibre statique -->


<div class="blocgeneral">
		<span class="bloc1">
			<div id="blocphoto3">
			</div>
			<div class="bloctitre">
				Equilibre statique
			</div>
            <br>
            <div class="blocphrase">
				Test d’équilibre sur une jambe pendant 30 secondes
                <br>
                <label for="auto3"> Le test d'équilibre statique a été réalisé : </label>
				<input type="radio" name="auto3" id="radio_y3" checked value=1><label>Oui</label>
				<input type="radio" name="auto3" id="radio_n3" class="no" value=2><label>Non</label>
			</div>
		</span>

    <div name="cadreform_eq" id="cadreform_eq">
        <div class="bloc2">
            <label>Pied dominant:</label>
            <?php
            $query = "
                SELECT pied_dominant
                FROM eval_eq_stat
                    JOIN evaluations USING (id_evaluation)
                WHERE id_patient= :id_patient
                  AND pied_dominant IS NOT NULL
                ORDER BY pied_dominant DESC
                LIMIT 1";
            $stmt = $bdd->prepare($query);
            $stmt->bindValue(':id_patient', $idPatient);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $pied_dominant = $data['pied_dominant'] ?? null;
            ?>

            <?php
            if (!empty($pied_dominant)): ?>
                <?= ucfirst($pied_dominant); ?>
                <input hidden type="text" name="pied-dominant" value="<?= $pied_dominant; ?>"/>
            <?php
            else: ?>
                <input id="pied-gauche-dominant" type="radio" name="pied-dominant" value="gauche"><label
                        for="pied-gauche-dominant">Gauche</label>
                <input id="pied-droit-dominant" type="radio" name="pied-dominant" value="droit" checked><label
                        for="pied-droit-dominant">Droit</label>
            <?php
            endif; ?>
            <br>
            <label for="pd"> Pied droit au sol (sec) : </label> <input type="number" name="pd" id="pd" value=""
                                                                       placeholder="0-30 sec" step="1" min="0" max="30">
            <label for="pg"> Pied gauche au sol (sec) : </label> <input type="number" name="pg" id="pg" value=""
                                                                        placeholder="0-30 sec" step="1" min="0"
                                                                        max="30">
        </div>

        <div class="bloc3">
            <div class="bloccom">
            </div>
            <br>
            <input type="textarea" name="com_eq" id="com_eq" size=125 value="">

        </div>

    </div>

</div>

<div name="cadremotif_eq" id="cadremotif_eq" class="toggle_off">

    <center>

        <label for="motif_eq_stat"> Le test d'equilibre statique n'a pas été effectué car : </label>
        <select name="motif_eq_stat" id="motif_eq_stat" class="select" style="width : 180px;">
            <option value=0> Pourquoi ?</option>
            <option value=1> Problème d'espace</option>
            <option value=2> Problème de matériel</option>
            <option value=3> Incapacité pour le patient</option>
            <option value=4> Manque de temps</option>
        </select>

    </center>

</div>

<!-- Souplesse -->

<div class="blocgeneral">

		<span class="bloc1">

			<div id="blocphoto4">
			</div>

			<div class="bloctitre">
				Souplesse
			</div>
            <br>
            <div class="blocphrase">
				Test de flexion du tronc vers l’avant (Test de Schöber) en cm
                <br>
                <label for="auto4"> Le test de souplesse a été réalisé : </label>
				<input type="radio" name="auto4" id="radio_y4" checked value=1> <label>Oui</label>
				<input type="radio" name="auto4" id="radio_n4" class="no" value=2> <label>Non</label>
			</div>
		</span>

    <div name="cadreform_soupl" id="cadreform_soupl">

        <div class="bloc2">
            <div class="help-block">
                Valeur négative si éloignement des doigts par rapport au sol. Valeur positive si les doigts touchent le
                sol (monter sur une marche)
            </div>
            <label for="distance"> Distance majeur au sol (cm) : </label> <input type="number" name="distance"
                                                                                 id="distance" value=""
                                                                                 placeholder="-100 à 50 cm" step="1"
                                                                                 min=-100 max=50>
            <!--ou <label> Doigt au sol : </label><input type="radio" name="membre" id="membre" value="Doigt au sol">
            ou <label> Poing au sol : </label><input type="radio" name="membre" id="membre" value="Poing au sol">
            ou <label> Main à plat : </label><input type="radio" name="membre" id="membre" value="Main à plat">-->

        </div>

        <div class="bloc3">
            <div class="bloccom">
            </div>
            <br>

            <input type="textarea" name="com_soupl" id="com_soupl" size=125 value="">


        </div>

    </div>
</div>

<div name="cadremotif_soupl" id="cadremotif_soupl" class="toggle_off">
    <center>

        <label for="motif_soupl"> Le test de souplesse n'a pas été effectué car : </label>
        <select name="motif_soupl" id="motif_soupl" class="select" style="width : 180px;">
            <option value=0> Pourquoi ?</option>
            <option value=1> Problème d'espace</option>
            <option value=2> Problème de matériel</option>
            <option value=3> Incapacité pour le patient</option>
            <option value=4> Manque de temps</option>
        </select>
    </center>

</div>

<!-- Mobilité scapulo-humérale -->
<div class="blocgeneral">

		<span class="bloc1">

			<div id="blocphoto5">
			</div>

			<div class="bloctitre">
				Mobilité scapulo-humérale
			</div>
            <br>
            <div class="blocphrase">
				Estimation visuelle de la mobilité des épaules
                <br>
                <label for="auto5"> Le test de mobilité scapulo-humérale a été réalisé : </label>
				<input type="radio" name="auto5" id="radio_y5" checked value=1> <label>Oui</label>
				<input type="radio" name="auto5" id="radio_n5" class="no" value=2> <label>Non</label>
			</div>
		</span>

    <div name="cadreform_msh" id="cadreform_msh">
        <div class="help-block">
            Valeur négative si les doigts ne se touchent pas. Valeur positive si les doigts se chevauchent.
        </div>
        <div class="bloc2">
            <label for="mdh"> Main Droite en haut (cm) : </label> <input type="number" name="mdh" id="mdh" value=""
                                                                         placeholder="-60 à 20 cm" step="1" min="-60"
                                                                         max="20">
            <label for="mgh"> Main Gauche en haut (cm) : </label> <input type="number" name="mgh" id="mgh" value=""
                                                                         placeholder="-60 à 20 cm" step="1" min="-60"
                                                                         max="20">
        </div>
        <div class="bloc3">
            <div class="bloccom">
            </div>
            <br>
            <input type="textarea" name="com_msh" id="com_msh" size=125 value="">
        </div>
    </div>
</div>
<div name="cadremotif_msh" id="cadremotif_msh" class="toggle_off">
    <center>

        <label for="motif_mobilite_scapulo_humerale"> Le test de mobilité scapulo-humérale n'a pas été effectué car
            : </label>
        <select name="motif_mobilite_scapulo_humerale" id="motif_mobilite_scapulo_humerale" class="select"
                style="width : 180px;">
            <option value=0> Pourquoi ?</option>
            <option value=1> Problème d'espace</option>
            <option value=2> Problème de matériel</option>
            <option value=3> Incapacité pour le patient</option>
            <option value=4> Manque de temps</option>
        </select>
    </center>
</div>
<!-- Endurance musculaire membres inférieurs -->

<div class="blocgeneral">

		<span class="bloc1">

			<div id="blocphoto6">
			</div>
			<div class="bloctitre">
				Endurance musculaire membres inférieurs
			</div>
            <br>
            <div class="blocphrase">
				Test de levers de chaises
                <br>
                <label for="auto6"> Le test d'endurance musculaire membres inférieurs a été réalisé : </label>
				<input type="radio" name="auto6" id="radio_y6" checked value=1> <label>Oui</label>
				<input type="radio" name="auto6" id="radio_n6" class="no" value=2> <label>Non</label>
			</div>
		</span>
    <div name="cadreform_emmi" id="cadreform_emmi">

        <div class="bloc2">
            <table>
                <tr>
                    <td style="text-align : center;" width=200><label for="nb_lever"> Nombre de levers : </label><input
                                type="number" name="nb_lever" id="nb_lever" value="" placeholder="0 à 50 lever(s)"
                                min="0" max="50"></td>
                    <td style="text-align : center;" width=200><label for="fc30"> FC à 30 sec (bpm) : </label><input
                                type="number" name="fc30" id="fc30" value="" placeholder="20-220 bpm" min="20"
                                max="220"></td>
                    <td style="text-align : center;" width=200><label for="sat30"> Saturation à 30 sec (% SpO2)
                            : </label><input type="number" name="sat30" id="sat30" value="" placeholder="60-100 %"
                                             step="1" min="60" max="100"></td>
                </tr>
            </table>
            <div class="panel panel-default panel-body" style="margin: 5px">
                <label for="borg30" class="main-questions-enonce"> Borg à 30 sec :</label>
                <div>
                    <table>
                        <tbody>
                        <tr>
                            <td style="text-align : center;" width="150">1: Aucun effort</td>
                            <td style="text-align : center;" width="150">2: Extrêmement facile</td>
                            <td style="text-align : center;" width="150">3: Très facile</td>
                            <td style="text-align : center;" width="150">4: Facile</td>
                            <td style="text-align : center;" width="150">5: Modéré</td>
                            <td style="text-align : center;" width="150">6: Moyennement difficile</td>
                            <td style="text-align : center;" width="150">7: Difficile</td>
                            <td style="text-align : center;" width="150">8: Très difficile</td>
                            <td style="text-align : center;" width="150">9: Extrêmement difficile</td>
                            <td style="text-align : center;" width="150">10: Effort maximal</td>
                        </tr>
                        <tr>
                            <td style="text-align : center;"><input type="radio" id="borg30-1" name="borg30" value="1">
                            </td>
                            <td style="text-align : center;"><input type="radio" id="borg30-2" name="borg30" value="2">
                            </td>
                            <td style="text-align : center;"><input type="radio" id="borg30-3" name="borg30" value="3">
                            </td>
                            <td style="text-align : center;"><input type="radio" id="borg30-4" name="borg30" value="4">
                            </td>
                            <td style="text-align : center;"><input type="radio" id="borg30-5" name="borg30" value="5">
                            </td>
                            <td style="text-align : center;"><input type="radio" id="borg30-6" name="borg30" value="6">
                            </td>
                            <td style="text-align : center;"><input type="radio" id="borg30-7" name="borg30" value="7">
                            </td>
                            <td style="text-align : center;"><input type="radio" id="borg30-8" name="borg30" value="8">
                            </td>
                            <td style="text-align : center;"><input type="radio" id="borg30-9" name="borg30" value="9">
                            </td>
                            <td style="text-align : center;"><input type="radio" id="borg30-10" name="borg30"
                                                                    value="10"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="bloc3">
            <div class="bloccom">
            </div>
            <br>
            <input type="textarea" name="com_emmi" id="com_emmi" size=125 value="" placeholder="">
        </div>
    </div>
</div>

<div name="cadremotif_emmi" id="cadremotif_emmi" class="toggle_off">
    <center>

        <label for="motif_end_musc_mb_inf"> Le test d'endurance musculaire membre inférieur n'a pas été effectué car
            : </label>
        <select name="motif_end_musc_mb_inf" id="motif_end_musc_mb_inf" class="select" style="width : 180px;">
            <option value=0> Pourquoi ?</option>
            <option value=1> Problème d'espace</option>
            <option value=2> Problème de matériel</option>
            <option value=3> Incapacité pour le patient</option>
            <option value=4> Manque de temps</option>
        </select>

    </center>
</div>


<?php
$verif_eval_num = $bdd->query("SELECT MAX(id_type_eval) FROM evaluations WHERE id_patient ='$idPatient'");
$fetch_eval_num = $verif_eval_num->fetch();
$eval_num = $fetch_eval_num[0];
?>
<div class="blocgeneral">
        <span class="bloc1">
            <div class="blocphrase">
    <input type="text" hidden name="verif" id="verif" value="1">
            </div>
        </span>
</div>

<!-- Bouton enregistrer -->
<center>
    <input type="submit" name="valider" id="valider" value="Enregistrer les informations" class='boutonvert'>
    </form>
</center>

<!-- Bouton pour revenir aux précédentes evaluations -->
<div style="margin-left : 5%; margin-right : 5%">
    <hr style="border-top: 1px solid #fff; margin-top: 10px;"> <!-- Pour un espace verticale -->
    <center>
        <a href="Evaluation.php?idPatient=<?php
        echo $idPatient ?>" class="btn btn-success btn-xs">Précédentes
            évaluations</span></a>
    </center>
</div>
</div>

<br>
<script src="../Patients/toggleFormAjout.js"></script>
<!--	<script src="../Patients/VerifForm.js"></script>-->
<script src="../Patients/VerifSelectAjout.js"></script>
<script src="../../js/TestAerobie.js"></script>
<script src="../../js/calculsEvaluation.js"></script>
<script src="../../js/AjoutEvaluation.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>

</html>