<meta http-equiv="X-UA-Compatible" content="ie=edge">
<?php
$listPEPS = [];
$listAutre = [];

$creneau = new \Sportsante86\Sapa\Model\Creneau($bdd);
$listPEPS = $creneau->readAllUser($_SESSION['id_user'], true);
$listAutre = $creneau->readAllUser($_SESSION['id_user'], false);

if (is_null($permissions)) {
    $permissions = new \Sportsante86\Sapa\Outils\Permissions($_SESSION);
}
?>

<style>
    .less-space {
        width: 15%;
    }

    .more-space {
        width: 85%;
    }
</style>
<!--modal pour l'ajout d'une séance d'activité physique dans le calendrier-->
<form method="POST" class="form-horizontal" id="form">
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
                        <fieldset class="group-modal" id="details">
                            <legend class="group-modal-titre">Détails de la séance</legend>
                            <div class="table-responsive" style="width: 100%;border : 3px #fdfefe solid;">
                                <table id="table_creneau" class="stripe hover row-border compact nowrap"
                                       style="display:block;overflow: auto">
                                    <thead>
                                    <tr>
                                        <th style="white-space:nowrap;padding-right: 50px">Créneau</th>
                                        <th style="white-space:nowrap;padding-right: 25px">Structure</th>
                                        <th style="white-space:nowrap;padding-right: 25px">Intervenant</th>
                                        <th style="white-space:nowrap;padding-right: 25px">Lieu</th>
                                        <th style="white-space:nowrap;padding-right: 25px">Parcours</th>
                                        <th style="white-space:nowrap;padding-right: 25px">Type</th>
                                        <th style="white-space:nowrap;padding-right: 25px">Date</th>
                                        <th style="white-space:nowrap;padding-right: 25px">Début</th>
                                        <th style="white-space:nowrap;padding-right: 25px">Fin</th>
                                        <th style="white-space:nowrap;padding-right: 25px">État de la séance</th>
                                        <th style="white-space:nowrap;padding-right: 25px">Détails</th>
                                    </tr>
                                    </thead>
                                    <tbody id="body-creneaux">
                                    <tr>
                                        <td id="detail-nom-creneau" style="white-space:nowrap;padding-right: 25px"></td>
                                        <td id="detail-struct" style="white-space:nowrap;padding-right: 25px"></td>
                                        <td id="detail-interv" style="white-space:nowrap;padding-right: 25px"></td>
                                        <td id="detail-lieu" style="white-space:nowrap;padding-right: 25px"></td>
                                        <td id="detail-parcours" style="white-space:nowrap;padding-right: 25px"></td>
                                        <td id="detail-type" style="white-space:nowrap;padding-right: 25px"></td>
                                        <td id="detail-date" style="white-space:nowrap;padding-right: 25px"></td>
                                        <td id="detail-debut" style="white-space:nowrap;padding-right: 25px"></td>
                                        <td id="detail-fin" style="white-space:nowrap;padding-right: 25px"></td>
                                        <td id="detail-etat" style="white-space:nowrap;padding-right: 25px"></td>
                                        <td id="detail-extra" style="white-space:nowrap;padding-right: 25px">
                                            <a data-toggle="extraModal"
                                               data-target="#extraModal" data-backdrop="static" data-keyboard="false"
                                               id="detail-extra-link">Détails</a>
                                        </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input id="detail-id-seance" hidden>
                            </div>
                        </fieldset>
                        <fieldset class="group-modal" id="liste-participants">
                            <legend class="group-modal-titre">Émargement des participants</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="tableau-creneaux"
                                               class="table table-bordered table-striped table-hover table-condensed"
                                               style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Bénéficiaire</th>
                                                <th>Présence</th>
                                                <th>Absence</th>
                                                <th>Excusé</th>
                                                <th>Commentaire</th>
                                            </tr>
                                            </thead>
                                            <tbody id="body-emargement"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal" id="ajout">
                            <div>
                                <legend class="group-modal-titre">Labellisation</legend>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="label_peps"></label><input type="radio" id="label_peps"
                                                                               name="labelchoix"
                                                                               value="l_peps" checked>Programme PEPS
                                    </div>
                                    <div class="col-md-4">
                                        <label for="label_non"></label><input type="radio" id="label_non"
                                                                              name="labelchoix"
                                                                              value="l_non">Séance non-labellisée
                                    </div>
                                </div>
                                <legend class="group-modal-titre">Informations créneau</legend>
                                <div class="row ">
                                    <div class="col-md-4 less-space">
                                        <label for="creneauType">Créneau</label>
                                    </div>
                                    <div class="col-md-8 more-space">
                                        <select class="form-control" name="creneauType" id="creneauType"
                                                required="required">
                                            <option value="" disabled selected>Sélectionner un créneau</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-4 less-space">
                                        <label for="intervenant">Intervenant</label>
                                    </div>
                                    <div class="col-md-8 more-space">
                                        <?php
                                        if ($permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::INTERVENANT)) {
                                            $requete = $bdd->prepare(
                                                'SELECT users.id_user, users.id_coordonnees, coordonnees.id_coordonnees, coordonnees.nom_coordonnees, coordonnees.prenom_coordonnees 
                                                                    FROM users 
                                                                        JOIN coordonnees ON users.id_coordonnees = coordonnees.id_coordonnees 
                                                                    WHERE users.id_user =' . $_SESSION['id_user']
                                            );
                                        } else {
                                            $requete = $bdd->prepare(
                                                'SELECT users.id_user, users.id_coordonnees, intervention.id_structure, coordonnees.id_coordonnees, coordonnees.nom_coordonnees, coordonnees.prenom_coordonnees 
                                                                    FROM users 
                                                                        JOIN coordonnees ON users.id_coordonnees = coordonnees.id_coordonnees 
                                                                        join intervention on users.id_user = intervention.id_user 
                                                                    WHERE intervention.id_structure =' . $_SESSION['id_structure']
                                            );
                                        }
                                        $requete->execute();

                                        if (!$permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::INTERVENANT)) {
                                            echo '<select class="form-control" name="intervenantCreneau" id="intervenantCreneau" required="required" >';
                                            echo '<option selected value="">Sélectionner un intervenant</option>';
                                            while ($data = $requete->fetch()) {
                                                echo '<option value=' . $data['id_user'] . '>' . $data['nom_coordonnees'] . " " . $data['prenom_coordonnees'] . '</option>';
                                            }
                                        } else {
                                            echo '<select disabled class="form-control" name="intervenantCreneau" id="intervenantCreneau" required="required" >';
                                            $data = $requete->fetch();
                                            echo '<option selected value=' . $data['id_user'] . '>' . $data['nom_coordonnees'] . " " . $data['prenom_coordonnees'] . '</option>';
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-4 less-space">
                                        <label for="dateActivite">Date</label>
                                    </div>
                                    <div class="col-md-8 more-space">
                                        <input type="date" class="form-control" id="dateActivite"
                                               placeholder="Date de l'activité" required="required"/>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-4 less-space">
                                        <label for="commentaire">Répétition</label>
                                    </div>
                                    <div class="col-md-8 more-space" id="recurs">
                                        <label for="recurs_oui"></label><input type="radio" id="recurs_oui"
                                                                               name="recurs" value="true">Oui
                                        <label for="recurs_oui"></label><input type="radio" id="recurs_non"
                                                                               name="recurs" value="false"
                                                                               checked>Non
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-4 less-space">
                                        <label for="commentaire">Commentaire</label>
                                    </div>
                                    <div class="col-md-8 more-space">
                                        <input type="text" class="form-control" id="commentaire"
                                               placeholder="Commentaire"/>
                                    </div>
                                </div>

                                <div id="recurs_block">
                                    <legend class="group-modal-titre">Répétition</legend>
                                    <div class="row ">
                                        <div class="col-md-4 less-space">
                                            <label for="dateFinRecurs">Date de fin</label>
                                        </div>
                                        <div class="col-md-8 more-space">
                                            <input type="date" class="form-control" id="dateFinRecurs"
                                                   placeholder="Date de fin de la récursivité de la séance"/>
                                        </div>
                                    </div>
                                </div>
                        </fieldset>

                        <fieldset class="group-modal" id="suppression">
                            <legend class="group-modal-titre">Suppression de séance</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="commentaire">Justification</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" name="motifSuppr" id="motifSuppr">
                                        <?php
                                        $requete = $bdd->prepare(
                                            'SELECT id_annulation, motif_annulation 
                                                                    FROM motifannulation '
                                        );
                                        $requete->execute();

                                        while ($data = $requete->fetch()) {
                                            echo '<option value=' . $data['id_annulation'] . '>' . $data['motif_annulation'] . '</option>';
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal" id="dupli">
                            <legend class="group-modal-titre">Duplication de la séance</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="commentaire">Jusqu'a quelle date ? </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" id="dateDupli" placeholder="Date"/>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
                <div class="modal-footer" style="display: flex">
                    <div id="boutonClose" style="padding: 10px">
                        <button id="close" type="button" data-dismiss="modal" class="btn btn-warning pull-left">Abandon
                        </button>
                    </div>
                    <div id="boutonSupprimer" style="padding: 10px">
                        <button id="supprimer" type="button" class="btn btn-danger">Supprimer
                        </button>
                    </div>
                    <div id="boutonRetour" style="padding: 10px">
                        <button id="retour" type="button" class="btn btn-danger">Retour
                        </button>
                    </div>

                    <div id="boutonEnregistrer" style="flex: auto;padding: 10px">
                        <button id="enregistrer" type="submit" class="btn btn-success">Modifier
                        </button>
                    </div>
                    <div id="boutonValider" style="padding: 10px">
                        <button id="valider" type="submit" class="btn btn-success">Valider la séance
                        </button>
                    </div>
                    <div id="boutonDupliquer" style="padding: 10px">
                        <button id="dupliquer" type="button" class="btn btn-success">Dupliquer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    let listPEPS = <?= is_array($listPEPS) ? json_encode($listPEPS) : json_encode([]); ?>;
    let listAutre = <?= is_array($listAutre) ? json_encode($listAutre) : json_encode([]); ?>;
    $(document).ready(function () {
        changerCreneau(listPEPS);
    });

    $("input[name='labelchoix']").on('change', function () {
        if ($("input[name='labelchoix']:checked")[0].value === 'l_peps') {
            changerCreneau(listPEPS);
        } else {
            changerCreneau(listAutre);
        }
    });

    function changerCreneau(list) {
        let $champCreneau = $('#creneauType');
        $champCreneau.empty();
        if (list.length !== 0) {
            list.forEach(function (item) {
                $champCreneau.append($('<option>', {
                    value: item.id_creneau,
                    text: item.nom_creneau + ". Jour(s): " + item.jour + " de " + item.nom_heure_debut + " à " + item.nom_heure_fin + " " + item.nom_structure
                }));
            })
        } else {
            $champCreneau.append($('<option>', {
                value: '',
                text: 'Aucune séance disponible.'
            }));
        }
    }
</script>

