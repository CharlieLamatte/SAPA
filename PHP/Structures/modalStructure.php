<?php

use Sportsante86\Sapa\Outils\Permissions;

if (!isset($permissions)) {
    $permissions = new Sportsante86\Sapa\Outils\Permissions($_SESSION);
}
?>

<form method="POST" class="form-horizontal" id="form-structure"
      data-id_structure-utilisateur="<?= $_SESSION['id_structure'] ?>">
    <!-- Modal -->
    <div class="modal fade" id="modalStructure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <fieldset class="can-disable">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title" id="modal-title-structure">Modal title</h3>
                    </div>
                    <div class="modal-body">
                        <div id="section-update-or-create">
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Coordonnées</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="id_territoire-structure">Territoire<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="id_territoire-structure" id="id_territoire-structure"
                                                class="form-control"
                                            <?php
                                            if (!$permissions->hasPermission('can_edit_territoire_structure')) {
                                                echo('disabled');
                                            } ?>
                                        ><?php
                                            $territoire = new \Sportsante86\Sapa\Model\Territoire($bdd);

                                            $territoires = $territoire->readAll(
                                                $_SESSION,
                                                \Sportsante86\Sapa\Model\Territoire::TYPE_TERRITOIRE_DEPARTEMENT
                                            ) ?? [];
                                            foreach ($territoires as $data) {
                                                echo '<option value="' . $data["id_territoire"] . '"';
                                                if (!$permissions->hasRole(Permissions::SUPER_ADMIN)) {
                                                    if ($data['id_territoire'] == $_SESSION['id_territoire']) {
                                                        echo ' selected="selected"';
                                                    }
                                                }
                                                echo '>' . $data["nom_territoire"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="code-onaps">Code ONAPS</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="code-onaps" name="code-onaps" value="" class="form-control input-md"
                                               type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom-structure">Nom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-5">
                                        <input id="nom-structure" name="nom-structure" value=""
                                               class="form-control input-md" required
                                               type="text" maxlength="200">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="statuts_structure">Type structure<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="statuts_structure" id="statuts_structure">
                                            <?php
                                            if ($permissions->hasRole(Permissions::SUPER_ADMIN)) {
                                                $requete = $bdd->query(
                                                    "SELECT * from statuts_structure ORDER BY nom_statut_structure"
                                                );
                                            } else {
                                                $requete = $bdd->query(
                                                    "SELECT * from statuts_structure WHERE id_statut_structure != 5 ORDER BY nom_statut_structure"
                                                );
                                            }
                                            while ($data = $requete->fetch()) {
                                                echo "<option value=" . $data["id_statut_structure"] . ">" . $data["nom_statut_structure"] . "</option>";
                                            }
                                            $requete->closeCursor();
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="adresse-structure">Adresse<span
                                                    style="color:red">*</span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <input id="adresse-structure" name="adresse-structure" value=""
                                               class="form-control input-md"
                                               type="text" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="complement-adresse-structure">Complément
                                            d'adresse</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input id="complement-adresse-structure" name="complement-adresse-structure"
                                               value=""
                                               class="form-control input-md" type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="code-postal-structure" class="control-label">Code postal<span
                                                    style="color:red">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <input autocomplete="off" id="code-postal-structure"
                                               name="code-postal-structure"
                                               class="form-control input-md" type="text" required>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="ville-structure" class="control-label">Ville<span
                                                    style="color:red">*</span></label>
                                    </div>
                                    <div class="col-md-5">
                                        <input autocomplete="off" id="ville-structure" name="ville-structure"
                                               class="form-control input-md"
                                               type="text" required readonly>
                                    </div>
                                </div>
                            </fieldset>

                            <div id="non_partenaire">
                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Représentant légal</legend>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="representant-nom">Nom</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input id="representant-nom" name="representant-nom" value=""
                                                   class="form-control input-md"
                                                   type="text">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="representant-prenom">Prénom</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input id="representant-prenom" name="representant-prenom" value=""
                                                   class="form-control input-md"
                                                   type="text">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label" for="tel-fixe">Téléphone 1</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input id="tel-fixe" name="tel-fixe" value="" class="form-control input-md"
                                                   type="text"
                                                   minlength="10" maxlength="10" placeholder="0XXXXXXXXX">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label" for="tel-portable">Téléphone 2</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input id="tel-portable" name="tel-portable" value=""
                                                   class="form-control input-md"
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
                                </fieldset>

                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Informations complémentaires</legend>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label" for="statut-juridique">Statut juridique<span
                                                        style="color: red">*</span></label>
                                        </div>
                                        <div class="col-md-10">

                                            <select class="form-control" name="statut-juridique" id="statut-juridique"
                                                    required>
                                                <?php
                                                $requete = $bdd->query(
                                                    "SELECT id_statut_juridique, nom_statut_juridique from statut_juridique ORDER BY nom_statut_juridique"
                                                );
                                                while ($data = $requete->fetch()) {
                                                    echo "<option value=" . $data["id_statut_juridique"] . ">" . $data["nom_statut_juridique"] . "</option>";
                                                }
                                                $requete->closeCursor();
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal">
                                    <legend class="group-modal-titre">Antennes</legend>
                                    <div id="liste-antenne"></div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="add-antenne">Ajouter une antenne:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input id="add-antenne" name="add-antenne" class="form-control"
                                                   placeholder="Taper le nom de l'antenne" type="text"
                                                   data-toggle="tooltip"
                                                   data-placement="bottom" title="Tooltip on bottom">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-success" id="add-antenne-button">
                                                Ajout
                                            </button>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal" id="row-intervenant">
                                    <legend class="group-modal-titre">Intervenants de la structure</legend>
                                    <div id="liste-intervenant"></div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="add-intervenant">Ajouter un intervenant:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input id="add-intervenant" name="add-intervenant" class="form-control"
                                                   placeholder="Taper les premières lettres de l'intervenant"
                                                   type="text">
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="group-modal" id="creneaux">
                                    <legend class="group-modal-titre">Créneaux de la structure</legend>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="tableau-creneaux"
                                                       class="table table-bordered table-striped table-hover table-condensed"
                                                       style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Type</th>
                                                        <th>Jour</th>
                                                        <th>Heure début</th>
                                                        <th>Durée</th>
                                                        <th>Intervenant</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="body-creneaux"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="group-modal" id="referencement">
                                    <legend class="group-modal-titre">Lien de référencement de la structure</legend>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label" for="lien_referencement">Lien<span
                                                        style="color:red"></span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input id='lien_referencement' name='lien_referencement'
                                                   class='form-control input-md'
                                                   type='text'>

                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="group-modal" id="section-mss">
                                    <legend class="group-modal-titre">Maison sport santé</legend>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label" for="logo-mss">Logo<span
                                                        style="color:red"></span></label>
                                        </div>
                                        <div class="col-md-4">
                                            <input id='logo-mss' name='logo-mss' class='form-control input-md'
                                                   type='file' accept="image/png, image/jpeg">
                                        </div>
                                        <div class="col-md-6">
                                            <img id="output" src="" alt="logo" class="img-responsive"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-11">
                                            <p class="help-block">
                                                Pour que le logo ne soit pas étiré, utilisez un logo carré.<br>
                                                Formats d'image autorisés: PNG, JPEG, JPG
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <p id="logo-loaded-message"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">
                                            <button id="reset-logo" class="btn">Reset le logo</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div id="section-fusion-structure">
                            <fieldset class="group-modal">
                                <legend class="group-modal-titre">Fusion</legend>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="add-structure-1">Ajouter la structure 1:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input id="add-structure-1" name="add-structure-1" class="form-control"
                                               placeholder="Taper les premières lettres de la structure" type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom-structure-1">Nom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nom-structure-1" name="nom-structure-1" value=""
                                               class="form-control input-md" required
                                               type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="adresse-1">Adresse<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="adresse-1" name="adresse-1" value="" class="form-control input-md"
                                               required
                                               type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="id-structure-1">Id<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="id-structure-1" name="id-structure-1"
                                               class="form-control input-md" type="text" required readonly>
                                    </div>
                                </div>

                                <hr class="solid-pink">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="add-structure-2">Ajouter la structure 2:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input id="add-structure-2" name="add-structure-2" class="form-control"
                                               placeholder="Taper les premières lettres de la structure" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="nom-structure-2">Nom<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="nom-structure-2" name="nom-structure-2" value=""
                                               class="form-control input-md" required
                                               type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label" for="adresse-2">Adresse<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="adresse-2" name="adresse-2" value="" class="form-control input-md"
                                               required
                                               type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label" for="id-structure-2">Id<span
                                                    style="color: red">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="id-structure-2" name="id-structure-2"
                                               class="form-control input-md" type="text" required readonly>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                </fieldset>
                <div class="modal-footer">
                    <!-- Boutons à droite -->
                    <button id="enregistrer-modifier-structure" type="submit" name="valid-entInitial"
                            class="btn btn-success">Modifier
                    </button>

                    <?php
                    if ($permissions->hasPermission('can_delete_strutures')) : ?>
                        <button id="delete-structure" type="submit" name="delete"
                                class="btn btn-danger pull-right">
                            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                            Supprimer
                        </button>
                    <?php
                    endif; ?>

                    <!-- Boutons à gauche -->
                    <button id="close-structure" type="button" data-dismiss="modal" class="btn btn-warning pull-left">
                        Abandon
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>