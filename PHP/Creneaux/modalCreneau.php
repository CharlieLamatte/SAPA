<?php

use Sportsante86\Sapa\Outils\Permissions;

if (is_null($permissions)) {
    $permissions = new Permissions($_SESSION);
}
?>

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
                        <div id="section-creneau">
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Informations du créneau</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom_creneau">Nom du créneau<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nom_creneau" name="nom_creneau" value=""
                                               class="form-control input-md"
                                               required
                                               type="text" maxlength="50">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="type_creneau">Type de créneau</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="type_creneau" id="type_creneau" class="form-control">
                                            <?php
                                            $query = '
                                                SELECT id_type_parcours, type_parcours
                                                FROM type_parcours
                                                ORDER BY type_parcours';
                                            $stmt = $bdd->prepare($query);
                                            $stmt->execute();
                                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="' . $data['id_type_parcours'] . '">' . $data['type_parcours'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-1">
                                        <label class="control-label" for="jour">Jour <span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="jour" id="jour" class="form-control">
                                            <?php
                                            $query = '
                                                SELECT id_jour, nom_jour
                                                FROM jours
                                                order by id_jour';
                                            $stmt = $bdd->prepare($query);
                                            $stmt->execute();
                                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="' . $data['id_jour'] . '">' . $data['nom_jour'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="heure_debut">Heure de début <span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="heure_debut" id="heure_debut" class="form-control">
                                            <?php
                                            $stmt = $bdd->prepare('SELECT id_heure, heure FROM heures');
                                            $stmt->execute();
                                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="' . $data['id_heure'] . '">' . $data['heure'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="heure_fin">Heure de fin <span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="heure_fin" id="heure_fin" class="form-control">
                                            <?php
                                            $stmt = $bdd->prepare('SELECT id_heure, heure  FROM heures');
                                            $stmt->execute();
                                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="' . $data['id_heure'] . '">' . $data['heure'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row" id="activation-row">
                                    <div class="col-md-2">
                                        <label for="creneau-actif">Activation<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" id="creneau-actif" name="activation-creneau" value="1"
                                        >
                                        <label for="creneau-actif">Actif</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" id="creneau-non-actif" name="activation-creneau" value="0">
                                        <label for="creneau-non-actif">Non Actif</label>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Structure</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom_structure">Nom structure<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="nom_structure" id="nom_structure" class="form-control">
                                            <?php
                                            $query = "SELECT id_structure, nom_structure FROM structure WHERE 1=1 ";
                                            if (!$permissions->hasRole(Permissions::SUPER_ADMIN)) {
                                                $query = $query . " AND structure.id_territoire = " . $_SESSION['id_territoire'];
                                            }
                                            if ($permissions->hasRole(Permissions::RESPONSABLE_STRUCTURE)) {
                                                $query = $query . " AND structure.id_structure= " . $_SESSION['id_structure'];
                                            }
                                            $query = $query . " ORDER BY nom_structure";
                                            $stmt = $bdd->prepare($query);
                                            $stmt->execute();
                                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="' . $data['id_structure'] . '">' . $data['nom_structure'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Liste des intervenants</legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="tableau-intervenants"
                                                   class="table table-bordered table-striped table-hover table-condensed"
                                                   style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Prénom</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody id="body-intervenants"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <select name="intervenant" id="intervenant" class="form-control"></select>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="ajout-intervenant-button" type="submit" name="ajout-intervenant-button" class="btn btn-success">Ajouter
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Détails de l'activité</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nb_participant">Nombre max de
                                            participants</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nb_participant" name="nb_participant" value=""
                                               class="form-control input-md"
                                               type="text" maxlength="10">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="nb_participant_creneau">Nombre de
                                            participants</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nb_participant_creneau" name="nb_participant_creneau" value=""
                                               class="form-control input-md"
                                               type="text" maxlength="10">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="public_vise">Public visé</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="public_vise" name="public_vise" value=""
                                               class="form-control input-md"
                                               type="text" maxlength="10">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="tarif">Tarifs</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="tarif" name="tarif" value="" class="form-control input-md"
                                               type="text" maxlength="10">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="paiement">Facilités de paiement</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="paiement" name="paiement" value="" class="form-control input-md"
                                               type="text" maxlength="10">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="pathologie">Pathologies<span
                                                    style="color:red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="pathologie" name="pathologie" value="" class="form-control input-md"
                                               type="text" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="type_seance">Type séance<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="type_seance" name="type_seance" value=""
                                               class="form-control input-md"
                                               type="text" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="description">Description</label>
                                    </div>
                                    <div class="col-md-10">
                                    <textarea id="description" name="description" class="form-control input-md"
                                              type="text"></textarea>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Lieu du Créneau</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="adresse">Adresse<span
                                                    style="color:red">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <input id="adresse" name="adresse" value="" class="form-control input-md"
                                               type="text" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="complement-adresse">Complément
                                            d'adresse</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input id="complement-adresse" name="complement-adresse" value=""
                                               class="form-control input-md" type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="code-postal" class="control-label">Code postal<span
                                                    style="color:red">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <input autocomplete="off" id="code-postal" name="code-postal"
                                               class="form-control input-md" type="text" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="ville" class="control-label">Ville<span
                                                    style="color:red">*</span></label>
                                    </div>
                                    <div class="col-md-5">
                                        <input autocomplete="off" id="ville" name="ville" class="form-control input-md"
                                               type="text" required readonly>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div id="section-liste-participants">
                            <fieldset class="group-modal" id="liste-participants">
                                <legend class="group-modal-titre">Liste des participants</legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="tableau-participants"
                                                   class="table table-bordered table-striped table-hover table-condensed"
                                                   style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Prénom</th>
                                                    <th>Statut</th>
                                                    <th>Propose/inscrit</th>
                                                    <th>Abandon</th>
                                                    <th>Réorientation</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody id="body-participants"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-10">
                                        <select name="patients-all" id="patients-all" class="form-control">
                                            <?php
                                            $_p = new \Sportsante86\Sapa\Model\Patient($bdd);
                                            $patients = $_p->readAllBasic($_SESSION['id_territoire']);

                                            foreach ($patients as $patient) {
                                                echo '<option value="' . $patient['id_patient'] . '" data-nom="' . $patient['nom_patient'] . '" data-prenom="' . $patient['prenom_patient'] . '">' . $patient['nom_patient'] . ' ' . $patient['prenom_patient'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="ajout-participant-button" type="submit"
                                                name="ajout-participant-button"
                                                class="btn btn-success">Ajouter
                                        </button>
                                    </div>
                                </div>
                                <div class="row" style="height: 10px"></div>
                            </fieldset>
                        </div>
                    </div>
                </fieldset>

                <div class="modal-footer">
                    <!-- Boutons à droite -->
                    <button id="enregistrer-modifier" type="submit" name="valid-entInitial"
                            class="btn btn-success">Modifier
                    </button>

                    <?php
                    if ($permissions->hasPermission('can_delete_creneaux')) : ?>
                        <button id="delete-creneau" type="submit" name="delete-creneau"
                                class="btn btn-danger pull-right">
                            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                            Supprimer
                        </button>
                    <?php
                    endif; ?>

                    <!-- Boutons à gauche -->
                    <button id="close" type="button" data-dismiss="modal" class="btn btn-warning pull-left">Abandon
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal With Warning -->
<div id="warning" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <p id="warning-text">Quitter sans enregistrer?</p>
                <button id="confirmclosed" type="button" class="btn btn-danger">Oui</button>
                <button id="refuseclosed" type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>