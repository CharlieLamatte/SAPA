<?php

use function Sportsante86\Sapa\Outils\format_date;

?>

<center>
    <!-- Permet d'afficher le bandeau parcours et entrer la date début programme si elle n'est pas rentrée-->
    <!--    <script type="text/javascript" src="/js/commun.js"></script>-->
    <!--    <script type="text/javascript" src="/js/functions.js"></script>-->
    <div class="panel-body">
        <div id="ficheResume" class="tab-pane fade active in">
            <?php
            //Formulaire de méthode POST amenant à la page Traitement Parcours
            echo "<form class=\"form-horizontal\" method=\"POST\" action=\"../FicheResume/TraitementParcours.php?idPatient=" . $idPatient . "\">"; ?>

            <input name="idFormulaire" type="hidden" value="form-resume">
            <fieldset style="background-color: #bfbfbf;">
                <legend style="color:red; background-color: #bfbfbf">
                    <center> Parcours</center>
                </legend>
                <br>


                <?php
                //Récupérer l'id du patient
                $idPatient = $_GET['idPatient'];

                // TODO éviter les répétitions

                // REQUETE DATE_PRESCRIPTION
                $query = $bdd->prepare("SELECT prescription_date FROM prescription WHERE id_patient = :id_patient");
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_prescription = empty($data['prescription_date']) ? null : format_date($data['prescription_date']);
                $query->CloseCursor();

                // REQUETE DATE_INITIAL
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=1"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_entretien_initial = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ////////////////////////ENTRETIENS INTERMEDIAIRES
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                //REQUETE DATE INTERMEDIAIRE 2
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=2"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int2 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                // //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval='2'");
                $query->execute();
                $data = $query->fetch();
                $entretien_de2 = $data['type_eval'];
                $query->CloseCursor();

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 3
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=3"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int3 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval='3'");
                $query->execute();
                $data = $query->fetch();
                $entretien_de3 = $data['type_eval'];
                $query->CloseCursor();

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 4
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=4"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int4 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval='4'");
                $query->execute();
                $data = $query->fetch();
                $entretien_de4 = $data['type_eval'];
                $query->CloseCursor();
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 5
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=5"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int5 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval='5'");
                $query->execute();
                $data = $query->fetch();
                $entretien_de5 = $data['type_eval'];
                $query->CloseCursor();
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 6
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=6"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int6 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval='6'");
                $query->execute();
                $data = $query->fetch();
                $entretien_de6 = $data['type_eval'];
                $query->CloseCursor();
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 7
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=7"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int7 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval='7'");
                $query->execute();
                $data = $query->fetch();
                $entretien_de7 = $data['type_eval'];
                $query->CloseCursor();
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 8
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=8"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int8 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval='8'");
                $query->execute();
                $data = $query->fetch();
                $entretien_de8 = $data['type_eval'];
                $query->CloseCursor();
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 9
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=9"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int9 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval='9'");
                $query->execute();
                $data = $query->fetch();
                $entretien_de9 = $data['type_eval'];
                $query->CloseCursor();

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 10
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=10"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int10 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval='10'");
                $query->execute();
                $data = $query->fetch();
                $entretien_de10 = $data['type_eval'];
                $query->CloseCursor();

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 11
                $query = $bdd->prepare(
                    "
                    SELECT date_eval
                    FROM evaluations
                    WHERE id_patient = :id_patient AND id_type_eval=11"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int11 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval=11");
                $query->execute();
                $data = $query->fetch();
                $entretien_de11 = $data['type_eval'];
                $query->CloseCursor();

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 12
                $query = $bdd->prepare(
                    "
                    SELECT date_eval
                    FROM evaluations
                    WHERE id_patient = :id_patient AND id_type_eval=12"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int12 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval=12");
                $query->execute();
                $data = $query->fetch();
                $entretien_de12 = $data['type_eval'];
                $query->CloseCursor();

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE DATE INTERMEDIAIRE 13
                $query = $bdd->prepare(
                    "
                    SELECT date_eval
                    FROM evaluations 
                    WHERE id_patient = :id_patient AND id_type_eval=13"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_int13 = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval=13");
                $query->execute();
                $data = $query->fetch();
                $entretien_de13 = $data['type_eval'];
                $query->CloseCursor();

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //REQUETE date entretien final
                $query = $bdd->prepare(
                    "SELECT date_eval FROM evaluations WHERE id_patient = :id_patient AND id_type_eval=14"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_final = empty($data['date_eval']) ? null : format_date($data['date_eval']);
                $query->CloseCursor();

                //REQUETE ENTRETIEN DE X MOIS
                $query = $bdd->prepare("SELECT type_eval FROM type_eval WHERE id_type_eval=14");
                $query->execute();
                $data = $query->fetch();
                $entretien_final = $data['type_eval'];
                $query->CloseCursor();

                //REQUETE DATE DEB PROGRAMME
                $query = $bdd->prepare("SELECT date_debut_programme FROM parcours  WHERE id_patient = :id_patient");
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $date_deb = $data['date_debut_programme'];
                $query->CloseCursor();

                //REQUETE DIFFERENCE JOURS
                $query = $bdd->prepare(
                    "SELECT DATEDIFF(NOW(),(SELECT date_debut_programme FROM parcours WHERE id_patient = :id_patient)) AS Nb_j FROM parcours"
                );
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $diff = $data['Nb_j'];
                $query->CloseCursor();

                //REQUETE NATURE ENTRETIEN
                $query = $bdd->prepare("SELECT nature_entretien_initial FROM parcours WHERE id_patient = :id_patient");
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $nature_entretien = $data['nature_entretien_initial'];
                $query->CloseCursor();

                //REQUETE TYPE PARCOURS
                $query = $bdd->prepare("SELECT id_type_parcours FROM orientation WHERE id_patient = :id_patient");
                $query->bindValue(":id_patient", $idPatient);
                $query->execute();
                $data = $query->fetch();
                $id_type_parcours = $data['id_type_parcours'] ?? null;;
                $query->CloseCursor();

                $query = $bdd->prepare(
                    "SELECT type_parcours FROM type_parcours WHERE id_type_parcours = :id_type_parcours"
                );
                $query->bindValue(":id_type_parcours", $id_type_parcours);
                $query->execute();
                $data = $query->fetch();
                $type_parcours = $data['type_parcours'] ?? null;
                $query->CloseCursor();
                ?>

                <!-- Ensemble de fields qui va afficher les données receuillis et permettre à l'utilisateur de pouvoir les modifier -->

                <!---------------------- FORMULAIRE PRINCIPAL ------------------------------>
                <div>
                    <table>
                        <!-- Ligne 1 -->
                        <tr>
                            <td>
                                <center>
                                    <legend style="color: black; font-size: 15px;">Prescription</legend>
                                    <?php
                                    if (empty($date_prescription)) {
                                        echo 'Pas de prescription saisie';
                                    } else {
                                        echo $date_prescription;
                                    } ?>
                                </center>
                            </td>
                            <td>&emsp;</td>
                            <td>
                                <center>
                                    <legend style="color: black ; font-size: 15px;">Entretien Initial</legend>
                                    <?php
                                    if (empty($date_entretien_initial)) {
                                        echo 'Pas d\'entretien initial';
                                    } else {
                                        echo $date_entretien_initial;
                                    } ?>
                                </center>
                            </td>
                            <td>&emsp;</td>
                            <td>
                                <center>
                                    <legend style="color: black; font-size:15px;">Nature de l'entretien</legend>
                                    <?php
                                    if ($nature_entretien == "present") {
                                        echo "Présentiel";
                                    } elseif ($nature_entretien == "tel") {
                                        echo "Téléphonique";
                                    }
                                    ?>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <!-- Ligne 2 -->
                            <td>
                                <center>
                                    <legend style="color: black; font-size:15px;">Type de parcours</legend>
                                    <?php
                                    if (empty($type_parcours)) {
                                        echo 'Non renseigné';
                                    } else {
                                        echo $type_parcours;
                                    } ?>
                                </center>
                            </td>
                            <td>&emsp;</td>
                            <td>
                                <center>
                                    <legend style="color: black; font-size:15px;">Début du programme</legend>
                                    <input id='dateDebPrevue' value='<?= is_null($date_deb) ? "" : $date_deb; ?>'
                                           name='dateDebPrevue' class='form-control input-md' type='date'
                                           style='width:150px'>
                                </center>
                            </td>
                            <td>&emsp;</td>
                            <td>
                                <center>
                                    <?php
                                    $query = 'SELECT date_admission FROM patients WHERE id_patient = :id_patient';
                                    $stmt = $bdd->prepare($query);
                                    $stmt->bindValue(':id_patient', $idPatient);
                                    $stmt->execute();
                                    $data = $stmt->fetch();
                                    $date_admission = $data['date_admission'];
                                    ?>

                                    <legend style="color: black; font-size: 15px;">Date d'admission</legend>
                                    <!--<label class="control-label" for="da">Date d'admission:</label>-->
                                    <input id='da' name='da' type='date' style="width:150px"
                                           value='<?= $date_admission; ?>' max='<?= date("Y-m-d"); ?>'
                                           class='form-control input-md' required>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 7px">
                                <center>
                                    <legend style="color: black; font-size: 15px;">A commencé depuis</legend>
                                    <?php
                                    if (!empty($date_deb)) {
                                        if ($diff == 0) {
                                            echo 'Aujourd\'hui';
                                        } else {
                                            echo $diff;
                                            echo ' jours';
                                        }
                                    }
                                    ?>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <center>
                                    ENTRETIENS INTERMEDIAIRES
                                </center>
                            </td>
                        </tr>
                        <?php
                        if (!empty($date_int2)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de2;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int2;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int3)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de3;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int3;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int4)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de4;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int4;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int5)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de5;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int5;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int6)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de6;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int6;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int7)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de7;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int7;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int8)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de8;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int8;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int9)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de9;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int9;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int10)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de10;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int10;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int11)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de11;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int11;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int12)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de12;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int12;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        if (!empty($date_int13)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_de13;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_int13;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        ?>
                        <tr>
                            <td colspan="6">
                                <center>
                                    ENTRETIEN FINAL
                                </center>
                            </td>
                        </tr>
                        <?php
                        if (!empty($date_final)) {
                            echo '<tr>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo $entretien_final;
                            echo '</center>';
                            echo '</td>';

                            echo '<td colspan="3">';
                            echo '<center>';
                            echo ' Réalisé le : ';
                            echo $date_final;
                            echo '</center>';
                            echo '</td>';

                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
                <br>
                <?php
                $query = 'SELECT intervalle FROM patients WHERE id_patient = :id_patient';
                $stmt = $bdd->prepare($query);
                $stmt->bindValue(':id_patient', $idPatient);
                $stmt->execute();
                $data = $stmt->fetch();
                $intervalle = $data['intervalle'];
                ?>
                <label class="control-label" for="intervalle">Intervalle entre les évaluations:</label>
                <select id="intervalle" name="intervalle">
                    <option value="3" <?php
                    if ($intervalle == 3) {
                        echo "selected";
                    } ?>>3 mois
                    </option>
                    <option value="6" <?php
                    if ($intervalle == 6) {
                        echo "selected";
                    } ?>>6 mois
                    </option>
                </select>
                &emsp;

                <?php
                //REQUÊTE DATE DE LA PROCHAINE ÉVALUATION
                $query = 'SELECT date_eval_suiv FROM patients WHERE id_patient = :id_patient';
                $stmt = $bdd->prepare($query);
                $stmt->bindValue(':id_patient', $idPatient);
                $stmt->execute();
                $data = $stmt->fetch();
                $date_eval_suiv = $data['date_eval_suiv'];
                ?>
                <label class="control-label" for="dateEvalSuiv">Prochaine évaluation:</label>
                <input id='dateEvalSuiv' name='dateEvalSuiv' type='date' style="display: inline-block"
                       value='<?= $date_eval_suiv; ?>' min='<?= date("Y-m-d"); ?>'>
                <br><br>
                <?php
                if (!isset($permissions)) {
                    $permissions = new Permissions($_SESSION);
                }

                if ($permissions->hasPermission('can_modify_parcours')): ?>
                    <input type="submit" value="Enregistrer les modifications" class="btn btn-success btn-xs">
                    <br>
                <?php
                endif; ?>
            </fieldset>
            </form>
        </div>
    </div>
</center>