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

    <title>Modifier évaluation</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">
    <link rel="stylesheet" href="../../css/modal-details.css">

    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body onbeforeunload="return confirm()">

<!-- Script permettant d'éviter le pop-up d'avertissement de changement de page lors du clique sur le bouton "Enregistrer" -->
<script>
    $(document).on("submit", "form", function (event) {
        window.onbeforeunload = null;
    });
</script>

<?php
//Récupérer id du bénéficiaire
$idPatient = $_GET['idPatient'];
$id_eval = $_GET['id_eval'];

require '../header.php';

//Récupérer le type eval
$stmt = $bdd->prepare(
    "
SELECT
type_eval, id_type_eval
FROM type_eval
JOIN evaluations USING(id_type_eval)
WHERE id_evaluation = :id_eval"
);
$stmt->bindValue(':id_eval', $id_eval);
$stmt->execute();
$info_eval = $stmt->fetch();
$type_eval = $info_eval['type_eval'];
$id_type_eval = $info_eval['id_type_eval'];
$stmt->CloseCursor();

//Récupération des données de la table : evaluation
$stmt = $bdd->prepare(
    "
SELECT
date_eval,
nom_coordonnees,
prenom_coordonnees,
nom_structure,
id_structure
FROM evaluations
JOIN users using(id_user)
JOIN coordonnees USING(id_coordonnees)
JOIN structure USING(id_structure)
WHERE id_evaluation = :id_eval"
);
$stmt->bindValue(':id_eval', $id_eval);
$stmt->execute();
$info_evalini = $stmt->fetch();

$date_eval = $info_evalini['date_eval'];
$nom_evaluateur = $info_evalini['nom_coordonnees'];
$prenom_evaluateur = $info_evalini['prenom_coordonnees'];
$nom_struc = $info_evalini['nom_structure'];
$id_structure = $info_evalini['id_structure'];

//Recupération de la commune
$stmt = $bdd->prepare(
    "
SELECT
nom_ville
from villes
join se_localise_a using(id_ville)
join se_situe_a using(id_adresse)
where id_structure = :id_structure"
);
$stmt->bindValue(':id_structure', $id_structure);
$stmt->execute();
$info_commune = $stmt->fetch();

$commune = $info_commune['nom_ville'];

//Récupération des données de la table : test_imc
$stmt = $bdd->prepare(
    "
SELECT *
FROM test_physio
WHERE id_evaluation = :id_eval"
);
$stmt->bindValue(':id_eval', $id_eval);
$stmt->execute();
$info_eval = $stmt->fetch();

$poids = $info_eval['poids'];
$taille = $info_eval['taille'];
$IMC = $info_eval['IMC'];
$tour_taille = $info_eval['tour_taille'];
$fcrepos = $info_eval['fc_repos'];
$borgrepos = $info_eval['borg_repos'];
//$borgrepos = $borgrepos + 0;
$satrepos = $info_eval['saturation_repos'];
$fcmax = $info_eval['fc_max_mesuree'];
$fc_max_theo = $info_eval['fc_max_theo'];
if (empty($fc_max_theo)) {
    $fc_max_theo = 220 - $age;
}
$id_motif_test_physio = $info_eval['motif_test_physio'];
if (!empty($id_motif_test_physio)) {
    $stmt = $bdd->prepare(
        "
    SELECT *
    FROM test_physio
    JOIN motifs ON motifs.id_motif=test_physio.motif_test_physio
    WHERE id_evaluation = :id_eval"
    );
    $stmt->bindValue(':id_eval', $id_eval);
    $stmt->execute();
    $info_eval = $stmt->fetch();

    $motif_test_physio = $info_eval['nom_motif'];
    $id_motif_test_physio = $info_eval['id_motif'];
}

//Récupération des données de la table : eval_fmms
$stmt = $bdd->prepare("SELECT * FROM eval_force_musc_mb_sup WHERE id_evaluation = :id_eval");
$stmt->bindValue(':id_eval', $id_eval);
$stmt->execute();
$info_eval = $stmt->fetch();

$main_forte = $info_eval['main_forte'];
$mg = $info_eval['mg'];
$md = $info_eval['md'];
$com_fmms = $info_eval['com_fmms'];
$id_motif_fmms = $info_eval['motif_fmms'];

if (!empty($id_motif_fmms)) {
    $stmt = $bdd->prepare(
        "
    SELECT *
    FROM eval_force_musc_mb_sup
    JOIN motifs ON motifs.id_motif=eval_force_musc_mb_sup.motif_fmms
    WHERE id_evaluation = :id_eval"
    );
    $stmt->bindValue(':id_eval', $id_eval);
    $stmt->execute();
    $info_eval = $stmt->fetch();

    $motif_fmms = $info_eval['nom_motif'];
}

//Récupération des données de la table : eval_eq
$stmt = $bdd->prepare("SELECT * FROM eval_eq_stat WHERE id_evaluation = :id_eval");
$stmt->bindValue(':id_eval', $id_eval);
$stmt->execute();
$info_eval = $stmt->fetch();

$pg = $info_eval['pied_gauche_sol'];
$pd = $info_eval['pied_droit_sol'];
$com_eq = $info_eval['com_eq_stat'];
$id_motif_eq_stat = $info_eval['motif_eq_stat'];
$pied_dominant = $info_eval['pied_dominant'];

if (!empty($id_motif_eq_stat)) {
    $stmt = $bdd->prepare(
        "
    SELECT *
    FROM eval_eq_stat
    JOIN motifs ON motifs.id_motif=eval_eq_stat.motif_eq_stat
    WHERE id_evaluation = :id_eval"
    );
    $stmt->bindValue(':id_eval', $id_eval);
    $stmt->execute();
    $info_eval = $stmt->fetch();

    $motif_eq_stat = $info_eval['nom_motif'];
}

//Récupération des données de la table : eval_msh
$stmt = $bdd->prepare("SELECT * FROM eval_mobilite_scapulo_humerale WHERE id_evaluation = :id_eval");
$stmt->bindValue(':id_eval', $id_eval);
$stmt->execute();
$info_eval = $stmt->fetch();

$mgh = $info_eval['main_gauche_haut'];
$mdh = $info_eval['main_droite_haut'];
$com_msh = $info_eval['com_mobilite_scapulo_humerale'];
$id_motif_msh = $info_eval['motif_mobilite_scapulo_humerale'];

if (!empty($id_motif_msh)) {
    $stmt = $bdd->prepare(
        "
    SELECT *
    FROM eval_mobilite_scapulo_humerale
    JOIN motifs ON motifs.id_motif=eval_mobilite_scapulo_humerale.motif_mobilite_scapulo_humerale
    WHERE id_evaluation = :id_eval"
    );
    $stmt->bindValue(':id_eval', $id_eval);
    $stmt->execute();
    $info_eval = $stmt->fetch();

    $motif_mobilite_scapulo_humerale = $info_eval['nom_motif'];
    $id_motif_msh = $info_eval['id_motif'];
}

//Récupération des données de la table : eval_soupl
$stmt = $bdd->prepare("SELECT * FROM eval_soupl WHERE id_evaluation = :id_eval");
$stmt->bindValue(':id_eval', $id_eval);
$stmt->execute();
$info_eval = $stmt->fetch();

$distance = $info_eval['distance'];
$membre = $info_eval['membre'];
$com_soupl = $info_eval['com_soupl'];
$id_motif_soupl = $info_eval['motif_soupl'];

if (!empty($id_motif_soupl)) {
    $stmt = $bdd->prepare(
        "
    SELECT *
    FROM eval_soupl
    JOIN motifs ON motifs.id_motif = eval_soupl.motif_soupl
    WHERE id_evaluation = :id_eval"
    );
    $stmt->bindValue(':id_eval', $id_eval);
    $stmt->execute();
    $info_eval = $stmt->fetch();

    $motif_soupl = $info_eval['nom_motif'];
    $id_motif_soupl = $info_eval['id_motif'];
}

//Récupération des données de la table : eval_emmi
$stmt = $bdd->prepare("SELECT * FROM eval_endurance_musc_mb_inf WHERE id_evaluation = :id_eval");
$stmt->bindValue(':id_eval', $id_eval);
$stmt->execute();
$info_eval = $stmt->fetch();

$lever = $info_eval['nb_lever'] ?? "";
$fc30 = $info_eval['fc30'] ?? "";
$sat30 = $info_eval['sat30'] ?? "";
$borg30 = $info_eval['borg30'] ?? "";
$com_emmi = $info_eval['com_end_musc_mb_inf'] ?? "";
$id_motif_end_musc_mb_inf = $info_eval['motif_end_musc_mb_inf'] ?? "";

if (!empty($id_motif_end_musc_mb_inf)) {
    $stmt = $bdd->prepare(
        "
    SELECT *
    FROM eval_endurance_musc_mb_inf
    JOIN motifs ON motifs.id_motif=eval_endurance_musc_mb_inf.motif_end_musc_mb_inf
    WHERE id_evaluation = :id_eval"
    );
    $stmt->bindValue(':id_eval', $id_eval);
    $stmt->execute();
    $info_eval = $stmt->fetch();

    $motif_end_musc_mb_inf = $info_eval['nom_motif'];
    $id_motif_end_musc_mb_inf = $info_eval['id_motif'];
}

//Récupération des données de la table : eval_aa
$stmt = $bdd->prepare("SELECT * FROM eval_apt_aerobie WHERE id_evaluation = :id_eval");
$stmt->bindValue(':id_eval', $id_eval);
$stmt->execute();
$info_eval = $stmt->fetch();

$dp = $info_eval['distance_parcourue'];
$fc1 = $info_eval['fc1'];
$fc2 = $info_eval['fc2'];
$fc3 = $info_eval['fc3'];
$fc4 = $info_eval['fc4'];
$fc5 = $info_eval['fc5'];
$fc6 = $info_eval['fc6'];
$fc7 = $info_eval['fc7'];
$fc8 = $info_eval['fc8'];
$fc9 = $info_eval['fc9'];
$sat1 = $info_eval['sat1'];
$sat2 = $info_eval['sat2'];
$sat3 = $info_eval['sat3'];
$sat4 = $info_eval['sat4'];
$sat5 = $info_eval['sat5'];
$sat6 = $info_eval['sat6'];
$sat7 = $info_eval['sat7'];
$sat8 = $info_eval['sat8'];
$sat9 = $info_eval['sat9'];
$borg1 = $info_eval['borg1'];
$borg2 = $info_eval['borg2'];
$borg3 = $info_eval['borg3'];
$borg4 = $info_eval['borg4'];
$borg5 = $info_eval['borg5'];
$borg6 = $info_eval['borg6'];
$borg7 = $info_eval['borg7'];
$borg8 = $info_eval['borg8'];
$borg9 = $info_eval['borg9'];
$com_aa = $info_eval['com_apt_aerobie'];
$id_motif_apt_aerobie = $info_eval['motif_apt_aerobie'];

if (!empty($id_motif_apt_aerobie)) {
    $stmt = $bdd->prepare(
        "
    SELECT *
    FROM eval_apt_aerobie
    JOIN motifs ON motifs.id_motif=eval_apt_aerobie.motif_apt_aerobie
    WHERE id_evaluation = :id_eval"
    );
    $stmt->bindValue(':id_eval', $id_eval);
    $stmt->execute();
    $info_eval = $stmt->fetch();

    $motif_apt_aerobie = $info_eval['nom_motif'];
}

$stmt = $bdd->prepare(
    '
SELECT id_eval_up_and_go,
eval_up_and_go.id_motif,
duree,
commentaire,
nom_motif
FROM eval_up_and_go
LEFT JOIN motifs USING(id_motif)
WHERE id_evaluation = :id_evaluation'
);
$stmt->bindValue('id_evaluation', $id_eval);
$stmt->execute();
$data = $stmt->fetch();

$id_eval_up_and_go = $data['id_eval_up_and_go'] ?? "";
$id_motif_up_and_go = $data['id_motif'] ?? "";
$duree_up_and_go = $data['duree'] ?? "";
$commentaire_up_and_go = $data['commentaire'] ?? "";
$nom_motif_up_and_go = $data['nom_motif'] ?? "";

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

// creation des lignes du tableau borg
function create_borg_tds($name, $checked_value)
{
    for ($i = 1; $i <= 10; $i++) {
        echo "<td>";
        echo '<input type="radio" name="' . $name . '"  value="' . $i . '" ' . ($checked_value == $i ? 'checked' : '') . '>';
        echo "</td>";
    }
}

// motifs de non rélisation d'un test
$options_motif = [
    [
        'value' => '1',
        'label' => 'Problème d\'espace'
    ],
    [
        'value' => '2',
        'label' => 'Problème de matériel'
    ],
    [
        'value' => '3',
        'label' => 'Incapacité pour le patient'
    ],
    [
        'value' => '4',
        'label' => 'Manque de temps'
    ]
];

function generate_select($array)
{ ?>
    <label for="<?php
    echo $array['name']; ?>"><?php
        echo $array['label']; ?></label>
    <select name="<?php
    echo $array['name']; ?>" id="<?php
    echo $array['name']; ?>" style="width : 180px;">
        <?php
        foreach ($array['options'] as $option) {
            $selected = $option['value'] == $array['selected_value'] ? 'selected="selected"' : '';;
            echo '<option value="' . $option['value'] . '" ' . $selected . '>' . $option['label'] . '</option>';
        }
        ?>
    </select>
    <?php
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

    <font size="2" color="#012678">
        <?php
        echo "<form method=\"POST\" id=\"main-form\" action=\"Evaluation/UpdateEvaluation.php?idPatient=" . $idPatient . "&id_eval=" . $id_eval . "\" >"; ?>

        <!-- 1er tableau : informations -->
        <div class="cadrelegend" style="margin-top:2%;">
            <div style="text-align: center; margin-top: 5px">
                <label for="evaluation"> Evaluation : </label>
                <select name="eval_etat" id="eval_etat" style="width : 180px;">
                    <?php
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

                    // ajout du type d'éval actuel
                    $option = "<option selected value=$id_type_eval>";
                    if ($id_type_eval == 1) {
                        $option .= "Initiale";
                    } elseif ($id_type_eval == 14) {
                        $option .= "Finale";
                    } else {
                        $option .= "Intermédiaire " . ($id_type_eval - 1) . " mois";
                    }
                    $option .= "</option>";
                    echo $option; ?>
                </select>
            </div>
        </div>
        <div class="cadrerouge">
            <table width=100% cellspacing="5" cellpading="8" padding="3">
                <br>
                <!-- 1er ligne -->
                <tr style="text-align : center;">
                    <td>
                        <?php
                        echo '<label for="evaluateur"> Evaluateur :  </label> ';
                        echo $nom_evaluateur;
                        echo "  ";
                        echo $prenom_evaluateur;
                        ?>
                    </td>
                    <td><?php
                        echo '<label for="nom_struc"> Nom de la structure : </label> ' . $nom_struc . ''; ?></td>
                    <td><?php
                        echo '<label for="commune"> Commune : </label> ' . $commune . ' '; ?></td>
                    <td><label for="date_eval"><span class="obligatoire">*</span>Date de l'évaluation :</label>
                        <input type="date" name="date_eval" id="date_eval" required="required" value="<?php
                        echo $date_eval; ?>">
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <!-- 2e tableau : démographie -->
            <div>
                <center>
                    <label for="auto0"> Le test physiologique a été réalisé : </label>
                    <input type="radio" name="auto0" id="radio_y0" value=1> <label>Oui</label>
                    <input type="radio" name="auto0" id="radio_n0" value=2> <label>Non</label>
                </center>

                <div id="cadreform_testphysio" class="cadretestphysio">
                    <table width=100% cellspacing="5" cellpading="8" padding="1">
                        <br>
                        <!-- 1e ligne test physio-->
                        <tr style="text-align: center ;">
                            <td><?php
                                echo '<label for="poids"> Poids (kg) : </label>'; ?></td>
                            <td><?php
                                echo '<input type="number" name="poids" id="poids" step="0.1" min="0" max="300" value="' . $poids . '" placeholder="0-300 kg">'; ?></td>
                            <td><?php
                                echo '<label for="taille"> Taille (cm) : </label>'; ?></td>
                            <td><?php
                                echo '<input type="number" name="taille" id="taille" value="' . $taille . '" min="0" max="250" step="0.1" placeholder="0-250 cm">'; ?></td>
                            <td><?php
                                echo '<label for="IMC"> IMC : </label> ';
                                echo '<td><input type="text" name="IMC" id="IMC" readonly class="gris" value="' . $IMC . '" >';
                                ?>
                            </td>
                        </tr>

                        <!-- 2e ligne test physio-->
                        <tr style="text-align : center;">
                            <td><?php
                                echo '<label for="tour_taille"> Tour de taille (cm) : </label> '; ?></td>
                            <td><?php
                                echo '<input type="number" name="tour_taille" id="tour_taille" step="0.1" value="' . $tour_taille . '" placeholder="10-200 cm"  min="10" max="200" >'; ?></td>
                            <td><?php
                                echo '<label for="satrepos"> Saturation de repos (% SpO2) : </label>'; ?></td>
                            <td><?php
                                echo '<input type="number" name="satrepos" id="satrepos" value="' . $satrepos . '" min="60" max="100" placeholder="60-100 %"  step="1" >'; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!-- 3e ligne -->

                        <tr style="text-align : center;">

                            <td>
                                <?php
                                echo '<label for="fcrepos"> FC de repos (bpm) : </label> ';
                                ?>
                            </td>
                            <td>
                                <?php
                                echo '<input type="number" name="fcrepos" id="fcrepos" value="' . $fcrepos . '"  min="20" max="220" placeholder="20-220 bpm" >';
                                ?>
                            </td>
                            <td>
                                <?php
                                echo '<label for="fcmax"> FC max mesurée (bpm) : </label>';
                                ?>
                            </td>
                            <td>
                                <?php
                                echo '<input type="number" name="fcmax" id="fcmax" value="' . $fcmax . '" min="20" max="220" placeholder="20-220 bpm" >';
                                ?>
                            </td>
                            <td>
                                <?php
                                echo '<label for="fc_max_theo"> FC max théorique (bpm) : </label> ';
                                ?>
                            </td>
                            <td>
                                <?php
                                echo '<input type="text" name="fc_max_theo" id="fc_max_theo" readonly class="gris" value="' . $fc_max_theo . '">';
                                ?>
                            </td>
                        </tr>
                    </table>
                    <div class="panel panel-default panel-body" style="margin: 5px">
                        <div>
                            <label for="borgrepos" class="main-questions-enonce">Borg de repos :</label>
                            <div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="borgrepos-1" name="borgrepos"
                                               value="1" <?= ($borgrepos == "1" ? 'checked' : ''); ?>>
                                        1: Aucun effort
                                        <div class="help-block">Je suis en pleine détente</div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="borgrepos-2" name="borgrepos"
                                               value="2" <?= ($borgrepos == "2" ? 'checked' : ''); ?>>
                                        2: Extrêmement facile
                                        <div class="help-block">Je peux maintenir ce rythme très longtemps</div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="borgrepos-3" name="borgrepos"
                                               value="3" <?= ($borgrepos == "3" ? 'checked' : ''); ?>>
                                        3: Très facile
                                        <div class="help-block">Je suis dans ma zone de confort et tout va bien</div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="borgrepos-4" name="borgrepos"
                                               value="4" <?= ($borgrepos == "4" ? 'checked' : ''); ?>>
                                        4: Facile
                                        <div class="help-block">Je commence à être légèrement essouflé</div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="borgrepos-5" name="borgrepos"
                                               value="5" <?= ($borgrepos == "5" ? 'checked' : ''); ?>>
                                        5: Modéré
                                        <div class="help-block">Légèrement fatiguant, je respire plus rapidement</div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="borgrepos-6" name="borgrepos"
                                               value="6" <?= ($borgrepos == "6" ? 'checked' : ''); ?>>
                                        6: Moyennement difficile
                                        <div class="help-block">Je peux parler mais en prenant des pauses</div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="borgrepos-7" name="borgrepos"
                                               value="7" <?= ($borgrepos == "7" ? 'checked' : ''); ?>>
                                        7: Difficile
                                        <div class="help-block">Je suis essouflé</div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="borgrepos-8" name="borgrepos"
                                               value="8" <?= ($borgrepos == "8" ? 'checked' : ''); ?>>
                                        8: Très difficile
                                        <div class="help-block">Je sors de ma zone de confort</div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="borgrepos-9" name="borgrepos"
                                               value="9" <?= ($borgrepos == "9" ? 'checked' : ''); ?>>
                                        9: Extrêmement difficile
                                        <div class="help-block">Je peux tenir ce rythme sur une très courte période
                                        </div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="borgrepos-10" name="borgrepos"
                                               value="10" <?= ($borgrepos == "10" ? 'checked' : ''); ?>>
                                        10: Effort maximal
                                        <div class="help-block">Je ne peux pas parler</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <div id="cadremotif_testphysio">
                    <div style="text-align: center" <?php
                    if (!empty($id_motif_test_physio)) {
                        echo 'class="cadremotif toggle_choice0"';
                    } ?>>
                        <?php
                        generate_select([
                            'name' => 'id_motif_test_physio',
                            'label' => 'Le test physiologique n\'a pas été réalisé pour le motif suivant : ',
                            'selected_value' => $id_motif_test_physio,
                            'options' => $options_motif
                        ]);
                        ?>
                    </div>
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
								<input type="radio" name="auto1" id="radio_y1" value="1"> <label>Oui</label>
								<input type="radio" name="auto1" id="radio_n1" value="2"> <label>Non</label>
							</div>
						</span>

                    <div name="cadreform_aa" id="cadreform_aa">
                        <div class="bloc2">
                            <?php
                            echo '<span class="obligatoire">*</span><label for="dp"> Distance parcourue (m) : </label> 
				<input id="dp" name="dp" class="data_aa" value="' . $dp . '" placeholder="0-800 m" type="number" step="1" min="0" max="800">';

                            echo '<input type="hidden" id="age_recup" name="age_recup" value=' . $age . '>';
                            echo '<input type="hidden" id="sexe_recup" name="sexe_recup" value=' . $patient['sexe_patient'] . '>';
                            echo '<label> Pourcentage de la distance théorique :</label>';
                            echo '<input type="text" name="distance_theo" id="distance_theo" readonly size=55>';
                            ?>

                            <table>
                                <!-- Ligne avec le nom des colonnes -->
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
                                    <td style="text-align : center;" width=150>1 min</td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number" name="fc1" id="fc1" value="' . $fc1 . '" placeholder="20-220 bpm"  min="0" max="220">';
                                        ?></td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number" name="sat1" id="sat1" value="' . $sat1 . '" placeholder="60-100 %" step="1" min="60" max="100"  >';
                                        ?></td>
                                    <?php
                                    create_borg_tds('borg1', $borg1);
                                    ?>
                                </tr>
                                <!-- Ligne 2 min -->
                                <tr>
                                    <td style="text-align : center;">2 min</td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number" name="fc2" id="fc2" value="' . $fc2 . '" placeholder="20-220 bpm" min="0" max="220">';
                                        ?></td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input  type="number" name="sat2" id="sat2" value="' . $sat2 . '" placeholder="60-100 %"  step="1" min="60" max="100" >';
                                        ?></td>
                                    <?php
                                    create_borg_tds('borg2', $borg2);
                                    ?>
                                </tr>
                                <!-- Ligne 3 min -->
                                <tr style="background-color:rgba(37,100,250,0.5);">
                                    <td style="text-align : center;">3 min</td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number" name="fc3" id="fc3" value="' . $fc3 . '" placeholder="20-220 bpm" min="0" max="220" >';
                                        ?></td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number"  name="sat3" id="sat3" value="' . $sat3 . '" placeholder="60-100 %"  step="1" min="60" max="100" >';
                                        ?></td>
                                    <?php
                                    create_borg_tds('borg3', $borg3);
                                    ?>
                                </tr>
                                <!-- Ligne 4 min -->
                                <tr>
                                    <td style="text-align : center;">4 min</td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number" name="fc4" id="fc4" value="' . $fc4 . '" placeholder="20-220 bpm"  min="0" max="220" >';
                                        ?></td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input  type="number"  name="sat4" id="sat4" value="' . $sat4 . '" placeholder="60-100 %" step="1" min="60" max="100" >';
                                        ?></td>
                                    <?php
                                    create_borg_tds('borg4', $borg4);
                                    ?>
                                </tr>
                                <!-- Ligne 5 min -->
                                <tr style="background-color:rgba(37,100,250,0.5);">
                                    <td style="text-align : center;">5 min</td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number" name="fc5" id="fc5" value="' . $fc5 . '" placeholder="20-220 bpm"  min="0" max="220">';
                                        ?></td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input  type="number"  name="sat5" id="sat5" value="' . $sat5 . '" placeholder="60-100 %"  step="1" min="60" max="100" >';
                                        ?></td>
                                    <?php
                                    create_borg_tds('borg5', $borg5);
                                    ?>
                                </tr>
                                <!-- Ligne 6 min -->
                                <tr>
                                    <td style="text-align : center;">6 min<span class="obligatoire">*</span></td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number" name="fc6" id="fc6" class="data_aa" value="' . $fc6 . '" placeholder="20-220 bpm"  min="0" max="220">';
                                        ?></td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input  type="number" name="sat6" id="sat6" class="data_aa" value="' . $sat6 . '" placeholder="60-100 %"  step="1" min="60" max="100" >';
                                        ?></td>
                                    <?php
                                    create_borg_tds('borg6', $borg6);
                                    ?>
                                </tr>
                                <!-- Ligne 7 min -->
                                <tr style="background-color:rgba(37,100,250,0.5);">
                                    <td style="text-align : center;">7 min dont 1 min de repos<span class="obligatoire">*</span>
                                    </td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number" name="fc7" id="fc7" class="data_aa" value="' . $fc7 . '" placeholder="20-220 bpm"   min="0" max="220" >';
                                        ?></td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input  type="number" name="sat7" id="sat7" class="data_aa" value="' . $sat7 . '" placeholder="60-100 %"  step="1" min="60" max="100" >';
                                        ?></td>
                                    <?php
                                    create_borg_tds('borg7', $borg7);
                                    ?>
                                </tr>
                                <!-- Ligne 8 min -->
                                <tr>
                                    <td style="text-align : center;">8 min dont 2 min de repos<span class="obligatoire">*</span>
                                    </td>
                                    <td style="text-align : center;"><?php
                                        echo ' 
					<input type="number" name="fc8" id="fc8" class="data_aa" value="' . $fc8 . '" placeholder="20-220 bpm"  min="0" max="220"  >';
                                        ?></td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number" name="sat8" id="sat8" class="data_aa" value="' . $sat8 . '" placeholder="60-100 %" step="1" min="60" max="100"  >';
                                        ?></td>
                                    <?php
                                    create_borg_tds('borg8', $borg8);
                                    ?>
                                </tr>
                                <!-- Ligne 9 min -->
                                <tr style="background-color:rgba(37,100,250,0.5);">
                                    <td style="text-align : center;">9 min dont 3 min de repos<span class="obligatoire">*</span>
                                    </td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input type="number" name="fc9" id="fc9" class="data_aa" value="' . $fc9 . '" placeholder="20-220 bpm"  min="0" max="220"  >';
                                        ?></td>
                                    <td style="text-align : center;"><?php
                                        echo '
					<input  type="number"  name="sat9" id="sat9" class="data_aa" value="' . $sat9 . '" placeholder="60-100 %"  step="1" min="60" max="100" >';
                                        ?></td>
                                    <?php
                                    create_borg_tds('borg9', $borg9);
                                    ?>
                                </tr>

                            </table>
                        </div>

                        <div class="bloc3">
                            <div class="bloccom">
                            </div>
                            <br>
                            <?php
                            echo '<input type="textarea" name="com_aa"  id="com_aa" size=125 value="' . $com_aa . '" placeholder="">';
                            ?>
                        </div>
                    </div>
                </div>

                <div name="cadremotif_aa" id="cadremotif_aa">
                    <div style="text-align: center" <?php
                    if (!empty($id_motif_apt_aerobie)) {
                        echo 'class="cadremotif toggle_choice1"';
                    } ?>>
                        <?php
                        generate_select([
                            'name' => 'id_motif_apt_aerobie',
                            'label' => 'Le test d\'aptitude aerobie n\'a pas été réalisé pour le motif suivant : ',
                            'selected_value' => $id_motif_apt_aerobie,
                            'options' => $options_motif
                        ]);
                        ?>
                    </div>

                    <div class="blocgeneral">
		<span class="bloc1">
			<div class="bloctitre">
				Test times UP and GO
			</div>
            <br>
             <div class="blocphrase">
                 <label for="auto1"> Le test times UP and GO a été réalisé : </label>
                 <input type="radio" name="auto-up-and-go" id="radio-up-and-go-yes"
                        value="1" <?php
                 if (empty($nom_motif_up_and_go)) {
                     echo 'checked';
                 } ?>><label
                         for="radio-up-and-go-yes">Oui</label>
				<input type="radio" name="auto-up-and-go" id="radio-up-and-go-no" class="no"
                       value="2" <?php
                if (!empty($nom_motif_up_and_go)) {
                    echo 'checked';
                } ?>><label
                         for="radio-up-and-go-no">Non</label>
                <br><br>
             </div>
            <div>
                <div class="bloc2" id="cadreform-up-and-go">

                    <label for="duree-up-and-go"> Durée (en secondes) : </label>
                    <?php
                    echo '<input type="number" name="duree-up-and-go"
                           id="duree-up-and-go" value="' . $duree_up_and_go . '"
                           placeholder="0-100000" step="1" min="0"
                           max="100000">';
                    ?>
                    <br><br>
                    			<div class="bloc3">
				<div class="bloccom">
				</div><br>
                                    <input type="text" name="com-up-and-go" id="com-up-and-go" size=125
                                           value="<?php
                                           echo $commentaire_up_and_go; ?>">
			</div>
                </div>
            </div>
		</span>
                    </div>

                    <span id="cadremotif-up-and-go" class="<?php
                    if (!empty($id_motif_up_and_go)) {
                        echo 'toggle_on';
                    } else {
                        echo 'toggle_off';
                    } ?>" style="margin-left : 10%">
                            <div style="text-align: center" <?php
                            if (!empty($id_motif_up_and_go)) {
                                echo 'class="cadremotif toggle_choice7"';
                            } ?>>
                         <span class="bloc1">
                                <label for="motif-up-and-go">Le test times UP and GO n'a pas été réalisé pour le motif suivant : </label>
                                <select name="motif-up-and-go" id="motif-up-and-go" class="select"
                                        style="width : 180px;">
                                    <option value=1 <?php
                                    if (!empty($id_motif_up_and_go) && $id_motif_up_and_go == 1) {
                                        echo 'selected';
                                    } ?>> Problème d'espace</option>
                                    <option value=2 <?php
                                    if (!empty($id_motif_up_and_go) && $id_motif_up_and_go == 2) {
                                        echo 'selected';
                                    } ?>> Problème de matériel</option>
                                    <option value=3 <?php
                                    if (!empty($id_motif_up_and_go) && $id_motif_up_and_go == 3) {
                                        echo 'selected';
                                    } ?>> Incapacité pour le patient</option>
                                    <option value=4 <?php
                                    if (!empty($id_motif_up_and_go) && $id_motif_up_and_go == 4) {
                                        echo 'selected';
                                    } ?>> Manque de temps</option>
                                </select>
                            </span>
                    </div>
                            </span>
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
								<?php
                                echo '<br>';
                                echo '<label for="auto2"> Le test de force musculaire des membres supérieurs a été réalisé : </label>';
                                echo '<input type="radio" name="auto2" id="radio_y2" value=1> <label>Oui</label>';
                                echo '<input type="radio" name="auto2" id="radio_n2" value=2> <label>Non</label>';
                                ?>
							</div>
						</span>
                <div name="cadreform_fmms" id="cadreform_fmms">

                    <div class="bloc2">
                        Le beneficiaire est :
                        <?php
                        $requete = "SELECT main_forte FROM eval_force_musc_mb_sup JOIN evaluations USING (id_evaluation) WHERE id_patient='$idPatient' AND main_forte IS NOT NULL ORDER BY main_forte DESC LIMIT 1";
                        $main_recup = $bdd->prepare($requete);
                        $main_recup->execute();
                        while ($data = $main_recup->fetch(PDO::FETCH_ASSOC)) {
                            $main_forte_r = $data['main_forte'];
                        }

                        $is_droitier = !empty($main_forte_r) && $main_forte_r == 'droitier';
                        $is_gaucher = !empty($main_forte_r) && $main_forte_r == 'gaucher';
                        // si main forte inconnue, la valeur par défaut est la main droite
                        if (!$is_droitier && !$is_gaucher) {
                            $is_droitier = true;
                        }
                        echo '<input id="droitier" type="radio" name="main_forte" value="droitier" ' . ($is_droitier ? 'checked' : '') . '><label>Droitier</label> ';
                        echo '<input id="gaucher" type="radio" name="main_forte" value="gaucher" ' . ($is_gaucher ? 'checked' : '') . '><label>Gaucher</label>';
                        echo '<br>';
                        ?>

                        <?php
                        echo '<label for="md"> Main Droite (kg) : </label> <input type="number" name="md" id="md" value="' . $md . '" placeholder="0-300 kg"  step="0.1" min="0" max="300">
							  <label for="mg"> Main Gauche (kg) : </label> <input type="number" name="mg" id="mg" value="' . $mg . '" placeholder="0-300 kg"  step="0.1" min="0" max="300">';
                        ?>
                    </div>
                    <div class="bloc3">
                        <div class="bloccom">
                        </div>
                        <br>
                        <?php
                        echo '<input  type="textarea" name="com_fmms" id="com_fmms" size=125 value="' . $com_fmms . '" placeholder="">';
                        ?>
                    </div>
                </div>
            </div>

            <div name="cadremotif_fmms" id="cadremotif_fmms">
                <div style="text-align: center" <?php
                if (!empty($id_motif_fmms)) {
                    echo 'class="cadremotif toggle_choice2"';
                } ?>>
                    <?php
                    generate_select([
                        'name' => 'id_motif_fmms',
                        'label' => 'Le test de force musculaire des membres supérieurs n\'a pas été réalisé pour le motif suivant : ',
                        'selected_value' => $id_motif_fmms,
                        'options' => $options_motif
                    ]);
                    ?>
                </div>
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
								<input type="radio" name="auto3" id="radio_y3" value=1> <label>Oui</label>
								<input type="radio" name="auto3" id="radio_n3" value=2> <label>Non</label>
							</div>
						</span>

                <div name="cadreform_eq" id="cadreform_eq">

                    <div class="bloc2">
                        <label>Pied dominant:</label>
                        <input id="pied-droit-dominant" type="radio" name="pied-dominant"
                               value="droit" <?php
                        if (!empty($pied_dominant) && $pied_dominant == 'droit') {
                            echo 'checked';
                        } ?>><label for="pied-droit-dominant">Droit</label>
                        <input id="pied-gauche-dominant" type="radio" name="pied-dominant"
                               value="gauche" <?php
                        if (!empty($pied_dominant) && $pied_dominant == 'gauche') {
                            echo 'checked';
                        } ?>><label for="pied-gauche-dominant">Gauche</label>
                        <br><br>
                        <?php
                        echo '<label for="pd"> Pied droit au sol (sec) :  </label> <input type="number" name="pd" id="pd" value="' . $pd . '" placeholder="0-30 sec"  step="1" min="0" max="30" >';
                        echo '<label for="pg"> Pied gauche au sol (sec) :  </label> <input type="number" name="pg" id="pg" value="' . $pg . '" placeholder="0-30 sec" step="1" min="0" max="30" >';
                        ?>
                    </div>

                    <div class="bloc3">
                        <div class="bloccom">
                        </div>
                        <br>
                        <?php
                        echo '<input  type="textarea" name="com_eq" id="com_eq" size=125 value="' . $com_eq . '" >';
                        ?>
                    </div>

                </div>
            </div>

            <div name="cadremotif_eq" id="cadremotif_eq">
                <div style="text-align: center" <?php
                if (!empty($id_motif_eq_stat)) {
                    echo 'class="cadremotif toggle_choice3"';
                } ?>>
                    <?php
                    generate_select([
                        'name' => 'id_motif_eq_stat',
                        'label' => 'Le test d\'équilibre statique n\'a pas été réalisé pour le motif suivant : ',
                        'selected_value' => $id_motif_eq_stat,
                        'options' => $options_motif
                    ]);
                    ?>
                </div>
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
								<input type="radio" name="auto4" id="radio_y4" value=1> <label>Oui</label>
								<input type="radio" name="auto4" id="radio_n4" value=2> <label>Non</label>
							</div>
						</span>
                <div name="cadreform_soupl" id="cadreform_soupl">
                    <div class="bloc2">
                        <div class="help-block">
                            Valeur négative si éloignement des doigts par rapport au sol. Valeur positive si les doigts
                            touchent le sol (monter sur une marche)
                        </div>
                        <?php
                        echo '<label for="distance"> Distance majeur au sol (cm) :  </label> <input type="number" name="distance" id="distance" value="' . $distance . '" placeholder="-100 à 50 cm" step="1" min="-100" max="50">';
                        ?>
                        <!--                                ou <label> Doigt au sol : </label><input type="radio" name="membre" id="membre"  value="Doigt au sol">
                                    ou <label> Poing au sol : </label><input type="radio" name="membre" id="membre" value="Poing au sol">
                                    ou <label> Main à plat : </label><input type="radio" name="membre" id="membre" value="Main à plat">-->

                    </div>
                    <div class="bloc3">
                        <div class="bloccom">
                        </div>
                        <br>
                        <?php
                        echo '<input  type="textarea" name="com_soupl" id="com_soupl" size=125 value="' . $com_soupl . '" >';
                        ?>
                    </div>
                </div>
            </div>

            <div name="cadremotif_soupl" id="cadremotif_soupl">
                <div style="text-align: center" <?php
                if (!empty($id_motif_soupl)) {
                    echo 'class="cadremotif toggle_choice4"';
                } ?>>
                    <?php
                    generate_select([
                        'name' => 'id_motif_soupl',
                        'label' => 'Le test de souplesse n\'a pas été réalisé pour le motif suivant : ',
                        'selected_value' => $id_motif_soupl,
                        'options' => $options_motif
                    ]);
                    ?>
                </div>
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
								<input type="radio" name="auto5" id="radio_y5" value=1> <label>Oui</label>
								<input type="radio" name="auto5" id="radio_n5" value=2> <label>Non</label>
							</div>
						</span>

                <div name="cadreform_msh" id="cadreform_msh">
                    <div class="help-block">
                        Valeur négative si les doigts ne se touchent pas. Valeur positive si les doigts se chevauchent.
                    </div>
                    <div class="bloc2">
                        <?php
                        echo '<label for="mdh"> Main Droite en haut  (cm) :  </label> <input type="number" name="mdh" id="mdh" value="' . $mdh . '" placeholder="-60 à 20 cm" step="1" min="-60" max="20">
			                  <label for="mgh"> Main Gauche en haut (cm) :  </label> <input  type="number" name="mgh" id="mgh" value="' . $mgh . '" placeholder="-60 à 20 cm"  step="1"  min="-60" max="20">';
                        ?>
                    </div>

                    <div class="bloc3">
                        <div class="bloccom">
                        </div>
                        <br>
                        <?php
                        echo '<input type="textarea" name="com_msh" id="com_msh" size=125 value="' . $com_msh . '">';
                        ?>
                    </div>
                </div>
            </div>

            <div name="cadremotif_msh" id="cadremotif_msh">
                <div style="text-align: center" <?php
                if (!empty($id_motif_msh)) {
                    echo 'class="cadremotif toggle_choice5"';
                } ?>>
                    <?php
                    generate_select([
                        'name' => 'id_motif_msh',
                        'label' => 'Le test de mobilité scapulo-humérale n\'a pas été réalisé pour le motif suivant : ',
                        'selected_value' => $id_motif_msh,
                        'options' => $options_motif
                    ]);
                    ?>
                </div>
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
								<label for="auto6"> Le test d'endurance musculaire des membres inférieurs a été réalisé : </label>
								<input type="radio" name="auto6" id="radio_y6" value=1> <label>Oui</label>
								<input type="radio" name="auto6" id="radio_n6" value=2> <label>Non</label>
							</div>
						</span>

                <div name="cadreform_emmi" id="cadreform_emmi">

                    <div class="bloc2">

                        <table>
                            <tr>
                                <td><label for="nb_lever"> Nombre de levers
                                        : </label> <?php
                                    echo '<input  type="number" name="nb_lever" id="nb_lever" value="' . $lever . '" placeholder="0 à 50 lever(s)"  min="0" max="50"   >'; ?>
                                </td>
                                <td><label for="fc30"> FC à 30 sec (bpm)
                                        : </label> <?php
                                    echo '<input type="number" name="fc30" id="fc30" value="' . $fc30 . '" placeholder="20-220 bpm"  min="20" max="220" >'; ?>
                                </td>
                                <td><label for="sat30"> Saturation à 30 sec (% SpO2)
                                        : </label> <?php
                                    echo '<input  type="number" name="sat30" id="sat30" value="' . $sat30 . '" placeholder="60-100 %"  step="1" min="60" max="100" >'; ?>
                                </td>
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
                                        <td style="text-align : center;"><input type="radio" id="borg30-1" name="borg30"
                                                                                value="1" <?= ($borg30 == "1" ? 'checked' : ''); ?>>
                                        </td>
                                        <td style="text-align : center;"><input type="radio" id="borg30-2" name="borg30"
                                                                                value="2" <?= ($borg30 == "2" ? 'checked' : ''); ?>>
                                        </td>
                                        <td style="text-align : center;"><input type="radio" id="borg30-3" name="borg30"
                                                                                value="3" <?= ($borg30 == "3" ? 'checked' : ''); ?>>
                                        </td>
                                        <td style="text-align : center;"><input type="radio" id="borg30-4" name="borg30"
                                                                                value="4" <?= ($borg30 == "4" ? 'checked' : ''); ?>>
                                        </td>
                                        <td style="text-align : center;"><input type="radio" id="borg30-5" name="borg30"
                                                                                value="5" <?= ($borg30 == "5" ? 'checked' : ''); ?>>
                                        </td>
                                        <td style="text-align : center;"><input type="radio" id="borg30-6" name="borg30"
                                                                                value="6" <?= ($borg30 == "6" ? 'checked' : ''); ?>>
                                        </td>
                                        <td style="text-align : center;"><input type="radio" id="borg30-7" name="borg30"
                                                                                value="7" <?= ($borg30 == "7" ? 'checked' : ''); ?>>
                                        </td>
                                        <td style="text-align : center;"><input type="radio" id="borg30-8" name="borg30"
                                                                                value="8" <?= ($borg30 == "8" ? 'checked' : ''); ?>>
                                        </td>
                                        <td style="text-align : center;"><input type="radio" id="borg30-9" name="borg30"
                                                                                value="9" <?= ($borg30 == "9" ? 'checked' : ''); ?>>
                                        </td>
                                        <td style="text-align : center;"><input type="radio" id="borg30-10"
                                                                                name="borg30"
                                                                                value="10" <?= ($borg30 == "10" ? 'checked' : ''); ?>>
                                        </td>
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
                        <input type="textarea" name="com_emmi" id="com_emmi" size=125 value="<?php
                        echo $com_emmi; ?>"
                               placeholder="">
                    </div>
                </div>
            </div>

            <div name="cadremotif_emmi" id="cadremotif_emmi">
                <div style="text-align: center" <?php
                if (!empty($id_motif_end_musc_mb_inf)) {
                    echo 'class="cadremotif toggle_choice6"';
                } ?>>
                    <?php
                    generate_select([
                        'name' => 'id_motif_end_musc_mb_inf',
                        'label' => 'Le test d\'endurance musculaire des membres inférieurs n\'a pas été réalisé pour le motif suivant : ',
                        'selected_value' => $id_motif_end_musc_mb_inf,
                        'options' => $options_motif
                    ]);
                    ?>
                </div>
            </div>

            <!-- Bouton pour modifier l'évaluation -->
            <div style="margin-left : 5%; margin-top : 2%">
                <hr style="border-top: 1px solid #fff; margin-top: 10px;"> <!-- Pour un espace verticale -->
                <center>
                    <?php
                    echo " <button type=\"submit\" id=\"modifier\" class=\"boutonvert\" style=\"margin-top:2%\"> Enregistrer la modification </button> ";
                    echo " <button class=\"boutonvert\" style=\"margin-top:2%\"><a style=\"color: white\" href=\"../Patients/Evaluation.php?idPatient=$idPatient\">Revenir à la page evaluation</a></button>";
                    ?>
                </center>
            </div>
        </div>
</div>

</form>
</font>
</div>
<br>
<br>

<script src="../../js/TestAerobie.js"></script>
<script src="../Patients/toggleFormModif.js"></script>
<script src="../Patients/VerifSelectModif.js"></script>
<script src="../../js/calculsEvaluation.js"></script>
<script src="../../js/ModifEvaluation.js"></script>
<!--<script src="../Patients/VerifFormModif.js"></script>-->
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>

</html>