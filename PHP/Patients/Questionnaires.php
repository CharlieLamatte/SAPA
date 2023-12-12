<?php

use Sportsante86\Sapa\Outils\Permissions;
use Sportsante86\Sapa\Model\Questionnaire;

use function Sportsante86\Sapa\Outils\format_date;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_questionnaire')) {
    erreur_permission();
}

//Récupérer id du bénéficiaire
$idPatient = $_GET['idPatient'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Questionnaires</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/synthese.css">
    <link rel="stylesheet" href="../../css/evaluation.css">
    <link href="../../css/objectifs.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/sante.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">

    <script type="text/javascript" src='../../js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>
<?php
require '../header.php';

function createSpan($text, $val)
{
    ?>
    <span><b><?php
            echo $text; ?></b><span><?php
            echo !is_numeric($val) ? 'NON-CALCULABLE' : $val ?></span><br></span><br>
    <?php
}

function createQuestionnaireTable($id_questionnaire, $idPatient, $bdd)
{
    $query = "SELECT 
                id_questionnaire_instance,
                date,
                nom_questionnaire,
                questionnaire_instance.id_questionnaire
                FROM questionnaire_instance
                JOIN questionnaire q on questionnaire_instance.id_questionnaire = q.id_questionnaire
                WHERE questionnaire_instance.id_patient = :id_patient AND q.id_questionnaire = :id_questionnaire
                ORDER BY date";
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(':id_patient', $idPatient);
    $stmt->bindValue(':id_questionnaire', $id_questionnaire);
    $stmt->execute();
    $questionnaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($questionnaires as $data) {
        $id_questionnaire_instance = $data['id_questionnaire_instance'];
        $date = $data['date'];
        $id_questionnaire = $data['id_questionnaire'];
        ?>

        <table class="table-objectif" id="table-<?php
        echo $id_questionnaire_instance; ?>">
            <tr>
                <td class="objectif-td-date"><span>Questionnaire réalisé le</span><br><span
                            id="date-<?php
                            echo $id_questionnaire_instance; ?>"><?php
                        echo format_date($date); ?></span>
                </td>
                <td class="objectif-td-avis"
                    id="avis-<?php
                    echo $id_questionnaire_instance; ?>" style="height: 287px">

                    <?php
                    $questionnaire = new Questionnaire($bdd);
                    if ($id_questionnaire == '1') {
                        $scores = $questionnaire->getScoreOpaq($id_questionnaire_instance);
                    } elseif ($id_questionnaire == '2') {
                        $scores = $questionnaire->getScoreEpices($id_questionnaire_instance);
                    } elseif ($id_questionnaire == '3') {
                        $scores = $questionnaire->getScoreProcheska($id_questionnaire_instance);
                    } elseif ($id_questionnaire == '4') {
                        $scores = $questionnaire->getScoreGarnier($id_questionnaire_instance);
                    }

                    if (is_array($scores) && !empty($scores)) {
                        if ($id_questionnaire == '1') {
                            createSpan(
                                'Niveau activite physique (minutes) : ',
                                $scores['niveau_activite_physique_minutes']
                            );
                            createSpan('Niveau activite physique (mets) : ', $scores['niveau_activite_physique_mets']);
                            createSpan('Niveau sédentarité (min/jour) : ', $scores['niveau_sendentarite']);
                            createSpan('Niveau sédentarité (min/semaine) : ', $scores['niveau_sendentarite_semaine']);
                        } elseif ($id_questionnaire == '2') {
                            createSpan('Score : ', $scores['epices']);
                        } elseif ($id_questionnaire == '3') {
                            createSpan('Score : ', $scores['proshenska']);
                        } elseif ($id_questionnaire == '4') {
                            createSpan('Perception santé : ', $scores['perception_sante']);
                        }
                    }
                    ?>
                </td>
                <td id="buttons-189" class="objectif-td-boutons">
                    <button class="btn btn-primary btn-sm open-modal" data-toggle="modal" data-target="#modal"
                            data-id_questionnaire_instance="<?php
                            echo $id_questionnaire_instance; ?>"
                            data-id_questionnaire="<?php
                            echo $id_questionnaire; ?>">
                        Détails
                    </button>
                    <br><br>
                    <?php
                    echo "<button class=\"btn btn-primary btn-sm\"><a style=\"color: white\" href=\"../Patients/ModifierQuestionnaire.php?idPatient=$idPatient&id_questionnaire_instance=$id_questionnaire_instance&id_questionnaire=$id_questionnaire\">Modifier</a></button>";
                    ?>
                </td>
            </tr>
        </table>

        <?php
    }
} ?>

<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <br>
    <?php
    if ($_ENV['ENVIRONNEMENT'] === 'TEST'): ?>
        <div style="text-align: center">
            <button id="delete-questionnaires" class="btn btn-danger btn-sm">Supprimer toutes les questionnaires
            </button>
            <script>
                const deleteButton = document.getElementById("delete-questionnaires");
                deleteButton.onclick = () => {
                    fetch('./Questionnaire/DeleteQuestionnairesPatient.php', {
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
        <br>
    <?php
    endif; ?>

    <form method="POST" class="form-horizontal" id="details-questionnaire">
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
                            <div class="row" style="margin-left: 0; margin-right: 0">
                                <div class="col-md-12" id="score"></div>
                            </div>
                            <div class="row" style="margin-left: 0; margin-right: 0">
                                <div class="col-md-12" id="main"></div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="modal-footer">
                        <!-- Boutons à gauche -->
                        <button id="close" type="button" data-dismiss="modal" class="btn btn-warning pull-left">Quitter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div>
        <div class="row">
            <div class="col-md-3">
                <fieldset class="section-noir">
                    <legend class="section-titre-noir">
                        OPAQ
                    </legend>
                    <div style="text-align: center">
                        <button class="btn btn-success btn-sm" style="margin-top:1%"
                                onclick="self.location.href='AjoutQuestionnaire.php?idPatient=<?php
                                echo $idPatient; ?>&id_questionnaire=1'">
                            Ajouter un questionnaire
                        </button>
                    </div>
                    <br>
                    <?php
                    createQuestionnaireTable('1', $idPatient, $bdd);
                    ?>
                </fieldset>
            </div>
            <div class="col-md-3">
                <fieldset class="section-noir">
                    <legend class="section-titre-noir">
                        Garnier
                    </legend>
                    <div style="text-align: center">
                        <button class="btn btn-success btn-sm" style="margin-top:1%"
                                onclick="self.location.href='AjoutQuestionnaire.php?idPatient=<?php
                                echo $idPatient; ?>&id_questionnaire=4'">
                            Ajouter un questionnaire
                        </button>
                    </div>
                    <br>
                    <?php
                    createQuestionnaireTable('4', $idPatient, $bdd);
                    ?>
                </fieldset>
            </div>
            <div class="col-md-3">
                <fieldset class="section-noir">
                    <legend class="section-titre-noir">
                        EPICES
                    </legend>
                    <div style="text-align: center">
                        <button class="btn btn-success btn-sm" style="margin-top:1%"
                                onclick="self.location.href='AjoutQuestionnaire.php?idPatient=<?php
                                echo $idPatient; ?>&id_questionnaire=2'">
                            Ajouter un questionnaire
                        </button>
                    </div>
                    <br>
                    <?php
                    createQuestionnaireTable('2', $idPatient, $bdd);
                    ?>
                </fieldset>
            </div>
            <div class="col-md-3">
                <fieldset class="section-noir">
                    <legend class="section-titre-noir">
                        PROCHASKA et DICLEMENTE
                    </legend>
                    <div style="text-align: center">
                        <button class="btn btn-success btn-sm" style="margin-top:1%"
                                onclick="self.location.href='AjoutQuestionnaire.php?idPatient=<?php
                                echo $idPatient; ?>&id_questionnaire=3'">
                            Ajouter un questionnaire
                        </button>
                    </div>
                    <br>
                    <?php
                    createQuestionnaireTable('3', $idPatient, $bdd);
                    ?>
                </fieldset>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../../js/fixHeader.js"></script>

    <script type="text/javascript" src="../../js/questionnaire_common.js"></script>
    <script type="text/javascript" src="../../js/questionnaire.js"></script>
</body>
</html>