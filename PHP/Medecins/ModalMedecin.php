<form method="POST" class="form-horizontal" id="form-medecin">
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="modal-title">Modal title</h3>
                </div>
                <div class="modal-body">
                    <div id="medecin-div">
                        <fieldset class="group-modal can-disable">
                            <legend class="group-modal-titre">Coordonnées</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="id_territoire">Territoire<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <select name="id_territoire" id="id_territoire"
                                            class="form-control no-arrows select_modal">
                                        <?php
                                        $territoire = new \Sportsante86\Sapa\Model\Territoire($bdd);

                                        $territoires = $territoire->readAllUnfiltered(
                                            \Sportsante86\Sapa\Model\Territoire::TYPE_TERRITOIRE_DEPARTEMENT
                                        ) ?? [];
                                        foreach ($territoires as $data) {
                                            echo '<option value="' . $data["id_territoire"] . '"';
                                            if ($data['id_territoire'] == $_SESSION['id_territoire']) {
                                                echo ' selected="selected"';
                                            }
                                            echo '>' . $data["nom_territoire"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="nom">Nom <span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input id="nom" name="nom" value="" class="form-control input-md medecin-required"
                                           required
                                           type="text" maxlength="50">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="prenom">Prénom <span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input id="prenom" name="prenom" value=""
                                           class="form-control input-md medecin-required" required
                                           type="text">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="tel-fixe">Téléphone 1<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input id="tel-fixe" name="tel-fixe" value=""
                                           class="form-control input-md medecin-required"
                                           type="text"
                                           minlength="10" maxlength="10" placeholder="0XXXXXXXXX" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="tel-portable">Téléphone 2</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="tel-portable" name="tel-portable" value="" class="form-control input-md"
                                           type="text" minlength="10" maxlength="10" placeholder="0XXXXXXXXX">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="email">Email</label>
                                </div>
                                <div class="col-md-10">
                                    <input id="email" name="email" value="" class="form-control" type="email"
                                           maxlength="100" placeholder="xxxxx@xxxx.xxx"
                                           pattern="[a-zA-Z0-9._\-]+[@][a-zA-Z0-9._\-]+[.][a-zA-Z.]{2,15}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="adresse">Adresse<span
                                                style="color:red">*</span></label>
                                </div>
                                <div class="col-md-10">
                                    <input id="adresse" name="adresse" value=""
                                           class="form-control input-md medecin-required"
                                           type="text" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="complement-adresse">Complément d'adresse</label>
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
                                           class="form-control input-md medecin-required" type="text" required>
                                </div>

                                <div class="col-md-2">
                                    <label for="ville" class="control-label">Ville<span
                                                style="color:red">*</span></label>
                                </div>
                                <div class="col-md-5">
                                    <input autocomplete="off" id="ville" name="ville"
                                           class="form-control input-md medecin-required"
                                           type="text" required readonly>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="group-modal can-disable">
                            <legend class="group-modal-titre">Données professionnelles</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="poste">Poste<span
                                                style="color:red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control medecin-required" id="poste" name="poste" value=""
                                           type="text" maxlength="50" placeholder="Infirmier" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="specialite">Spécialité<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <select name="statut" id="specialite"
                                            class="form-control no-arrows select_modal medecin-required"
                                            required>
                                        <?php
                                        $query = $bdd->prepare(
                                            'SELECT id_specialite_medecin, nom_specialite_medecin FROM specialite_medecin ORDER BY nom_specialite_medecin'
                                        );
                                        $query->execute();
                                        while ($data = $query->fetch()) {
                                            echo '<option value="' . $data['id_specialite_medecin'] . '">' . $data['nom_specialite_medecin'] . '</option>';
                                        }
                                        $query->CloseCursor();
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label medecin-required" for="lieu">Lieu de pratique<span
                                                style="color:red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <select name="lieu" id="lieu"
                                            class="form-control no-arrows select_modal medecin-required" required>
                                        <?php
                                        $query = $bdd->prepare(
                                            'SELECT id_lieu_pratique, nom_lieu_pratique FROM lieu_de_pratique ORDER BY nom_lieu_pratique'
                                        );
                                        $query->execute();
                                        while ($data = $query->fetch()) {
                                            echo '<option value="' . $data['id_lieu_pratique'] . '">' . $data['nom_lieu_pratique'] . '</option>';
                                        }
                                        $query->CloseCursor();
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div id="section-fusion-medecin">
                        <fieldset class="group-modal">
                            <legend class="group-modal-titre">Fusion</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="add-medecin-1">Ajouter le médecin 1:</label>
                                </div>
                                <div class="col-md-9">
                                    <input id="add-medecin-1" name="add-medecin-1" class="form-control"
                                           placeholder="Taper les premières lettres du médecin" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="nom-medecin1">Nom<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input id="nom-medecin1" name="nom-medecin1" value="" class="form-control input-md"
                                           required
                                           type="text">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="prenom-medecin1">Prénom<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input id="prenom-medecin1" name="prenom-medecin1" value=""
                                           class="form-control input-md"
                                           required
                                           type="text">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="id-medecin-1">Id<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input id="id-medecin-1" name="id-medecin-1"
                                           class="form-control input-md" type="text" required readonly>
                                </div>
                            </div>

                            <hr class="solid-pink">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="add-medecin-2">Ajouter le médecin 2:</label>
                                </div>
                                <div class="col-md-9">
                                    <input id="add-medecin-2" name="add-medecin-2" class="form-control"
                                           placeholder="Taper les premières lettres du médecin 2" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="nom-medecin2">Nom<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input id="nom-medecin2" name="nom-medecin2" value="" class="form-control input-md"
                                           required
                                           type="text">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="prenom-medecin2">Prénom<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input id="prenom-medecin2" name="prenom-medecin2" value=""
                                           class="form-control input-md"
                                           required
                                           type="text">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="id-medecin-2">Id<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input id="id-medecin-2" name="id-medecin-2"
                                           class="form-control input-md" type="text" required readonly>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Boutons à droite -->
                    <button id="enregistrer-modifier" type="submit" name="valid-entInitial"
                            class="btn btn-success">Modifier
                    </button>

                    <?php
                    if ($permissions == null) {
                        $permissions = new Permissions($_SESSION);
                    }
                    if ($permissions->hasPermission('can_delete_medecins')) : ?>
                        <button id="delete" type="submit" name="delete"
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