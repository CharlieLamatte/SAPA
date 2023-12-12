<!-- modal pour l'affichage des détails d'une séance -->
<div id="extraModal" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div id="section-extra">
                    <fieldset class="group-modal">
                        <legend class="group-modal-titre">Informations de la séance</legend>
                        <input id="etat_seance" name="etat_seance" value="" type="text" hidden="">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="extra_nom_creneau">Nom du créneau<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input disabled id="extra_nom_creneau" name="extra_nom_creneau" value=""
                                       class="form-control input-md"
                                       required
                                       type="text" maxlength="50">
                            </div>
                            <div class="col-md-2">
                                <label class="control-label" for="extra_type_creneau">Type de créneau</label>
                            </div>
                            <div class="col-md-3">
                                <select disabled name="extra_type_creneau" id="extra_type_creneau"
                                        class="form-control">
                                    <?php
                                    $query = $bdd->prepare(
                                        'SELECT id_type_parcours, type_parcours FROM type_parcours order by type_parcours'
                                    );
                                    $query->execute();
                                    while ($data = $query->fetch()) {
                                        echo '<option value="' . $data['id_type_parcours'] . '">' . $data['type_parcours'] . '</option>';
                                    }
                                    $query->CloseCursor();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <label class="control-label" for="extra_date">Date<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-3">
                                <input type="date" disabled name="extra_date" id="extra_date"
                                       class="form-control extra-form" value="">
                            </div>
                            <div class="col-md-2" style="margin: inherit;">
                                <label class="control-label" for="extra_heure_debut">Heure de début <span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-2">
                                <select disabled name="extra_heure_debut" id="extra_heure_debut"
                                        class="form-control extra-form" style="padding: 5px; min-width: 88px;">
                                    <?php
                                    $query = $bdd->prepare('SELECT id_heure, heure FROM heures');
                                    $query->execute();
                                    while ($data = $query->fetch()) {
                                        echo '<option value="' . $data['id_heure'] . '">' . $data['heure'] . '</option>';
                                    }
                                    $query->CloseCursor();
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label" for="extra_heure_fin">Heure de fin <span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-2">
                                <select disabled name="extra_heure_fin" id="extra_heure_fin"
                                        class="form-control extra-form" style="padding: 5px; min-width: 88px;">
                                    <?php
                                    $query = $bdd->prepare('SELECT id_heure, heure  FROM heures');
                                    $query->execute();
                                    while ($data = $query->fetch()) {
                                        echo '<option value="' . $data['id_heure'] . '">' . $data['heure'] . '</option>';
                                    }
                                    $query->CloseCursor();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                <label class="control-label" for="extra_commentaire">Commentaire</label>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <textarea type="text" id="extra_commentaire" name="extra_commentaire"
                                          class="form-control input-md extra-form"
                                          maxlength="200"></textarea>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="group-modal">
                        <legend class="group-modal-titre">Structure</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="extra_nom_structure">Nom structure</label>
                            </div>
                            <div class="col-md-10">
                                <input disabled name="extra_nom_structure" id="extra_nom_structure"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="extra_intervenant">Intervenant</label>
                            </div>
                            <div class="col-md-10">
                                <input disabled name="extra_intervenant" id="extra_intervenant"
                                       class="form-control">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal">
                        <legend class="group-modal-titre">Coordonnées</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="extra_adresse">Adresse<span
                                            style="color:red">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input disabled id="extra_adresse" name="extra_adresse" value=""
                                       class="form-control input-md"
                                       type="text" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="extra_complement-adresse">Complément
                                    d'adresse</label>
                            </div>
                            <div class="col-md-10">
                                <input disabled id="extra_complement-adresse" name="extra_complement-adresse" value=""
                                       class="form-control input-md" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="extra_code-postal" class="control-label">Code postal<span
                                            style="color:red">*</span></label>
                            </div>
                            <div class="col-md-3">
                                <input disabled autocomplete="off" id="extra_code-postal" name="extra_code-postal"
                                       class="form-control input-md" type="text" required>
                            </div>

                            <div class="col-md-2">
                                <label for="extra_ville" class="control-label">Ville<span
                                            style="color:red">*</span></label>
                            </div>
                            <div class="col-md-5">
                                <input disabled autocomplete="off" id="extra_ville" name="extra_ville"
                                       class="form-control input-md"
                                       type="text" required readonly>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div id="section-liste-participants">
                    <fieldset class="group-modal" id="extra-liste-participants">
                        <legend class="group-modal-titre">Liste des participants</legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="extra-tableau-participants"
                                           class="table table-bordered table-striped table-hover table-condensed"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody id="extra-body-participants"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <select disabled name="extra-patients-all" id="extra-patients-all"
                                        class="form-control extra-form">
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
                                <button disabled id="extra-ajout-participant-button" type="button"
                                        name="extra-ajout-participant-button"
                                        class="btn btn-success extra-form">Ajouter
                                </button>
                            </div>
                        </div>
                        <div class="row" style="height: 10px">
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button id="extraClose" type="button" data-dismiss="extraModal" class="btn btn-warning pull-left">
                        Abandon
                    </button>

                    <div id="boutonEnregistrer" style="flex: auto">
                        <button id="extraEnregistrer" type="submit" class="btn btn-success" value="Enregistrer" style="display: none">
                            Enregistrer
                        </button>

                        <button id="extraModifier" type="button" class="b1 btn btn-success" value="Modifier">Modifier la
                            séance
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>