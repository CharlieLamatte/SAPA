<?php

use Sportsante86\Sapa\Outils\Permissions;

?>
<form method="POST" class="form-horizontal" id="form-user" data-id_user-mon-compte="<?= $_SESSION['id_user'] ?>">
    <!-- Modal -->
    <div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="modal-title-user">Modal title</h3>
                </div>
                <div class="modal-body">
                    <fieldset class="group-modal can-disable">
                        <legend class="group-modal-titre">Coordonnées</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="id_territoire-user">Territoire<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <select name="id_territoire-user" id="id_territoire-user" class="form-control"
                                    <?php
                                    if (!$permissions->hasPermission('can_edit_territoire_utilisateur')) {
                                        echo('disabled');
                                    } ?>
                                >
                                    <?php
                                    $territoire = new \Sportsante86\Sapa\Model\Territoire($bdd);

                                    $territoires = $territoire->readAll($_SESSION);
                                    if ($territoires != false) {
                                        foreach ($territoires as $data) {
                                            echo '<option value="' . $data["id_territoire"] . '"';
                                            if (!$permissions->hasRole(Permissions::SUPER_ADMIN)) {
                                                if ($data['id_territoire'] == $_SESSION['id_territoire']) {
                                                    echo ' selected="selected"';
                                                }
                                            }
                                            echo '>' . $data["nom_territoire"] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label" for="role_user_ids">Rôle(s)<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control no-arrows" name="role_user_ids" type="text"
                                        id="role_user_ids" multiple required>
                                    <?php
                                    $req = $bdd->query("SELECT * FROM role_user");
                                    while ($data = $req->fetch()) {
                                        if (!$permissions->hasRole(Permissions::SUPER_ADMIN)) {
                                            if ($data["id_role_user"] != 1) {
                                                echo '<option value="' . $data["id_role_user"] . '"';
                                                echo '>' . $data["role_user"] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="' . $data["id_role_user"] . '"';
                                            echo '>' . $data["role_user"] . '</option>';
                                        }
                                    }
                                    $req->closeCursor();
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="nom-user">Nom <span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="nom-user" name="nom-user" value="" class="form-control input-md" required
                                       type="text" maxlength="50">
                            </div>
                            <div class="col-md-2">
                                <label class="control-label" for="prenom-user">Prénom <span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="prenom-user" name="prenom-user" value="" class="form-control input-md"
                                       required
                                       type="text">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="tel-portable-user">Téléphone 1</label>
                            </div>
                            <div class="col-md-4">
                                <input id="tel-portable-user" name="tel-portable-user" value=""
                                       class="form-control input-md"
                                       type="text" minlength="10" maxlength="10" placeholder="0XXXXXXXXX">
                            </div>
                            <div class="col-md-2">
                                <label class="control-label" for="tel-fixe-user">Téléphone 2</label>
                            </div>
                            <div class="col-md-4">
                                <input id="tel-fixe-user" name="tel-fixe-user" value="" class="form-control input-md"
                                       type="text"
                                       minlength="10" maxlength="10" placeholder="0XXXXXXXXX">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="email-user">Email<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input id="email-user" name="email-user" value="" class="form-control" type="email"
                                       maxlength="100" placeholder="xxxxx@xxxx.xxx"
                                       pattern="[a-zA-Z0-9._\-]+[@][a-zA-Z0-9._\-]+[.][a-zA-Z.]{2,15}" required>
                            </div>
                        </div>
                        <div class="row" id="demande-modif-mdp">
                            <div class="col-md-2">
                                <label class="control-label" for="modif-mdp-checkbox">Modifier le mot de passe?</label>
                            </div>
                            <div class="col-md-1">
                                <input id="modif-mdp-checkbox" name="modif-mdp-checkbox" value="" class="form-control"
                                       type="checkbox">
                            </div>
                        </div>
                        <div id="mdp-row">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="mdp" id="mdp-label">Mot de passe<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="mdp" name="mdp" value="" class="form-control" type="password"
                                               minlength="8"
                                               pattern="(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                               required>
                                        <span class="input-group-addon clickable" id="mdp-show"><span
                                                    class="glyphicon glyphicon-eye-open"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="confirm-mdp-row">
                                <div class="col-md-2">
                                    <label class="control-label" for="confirm-mdp" id="confirm-mdp-label">Confirmer<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input id="confirm-mdp" name="confirm-mdp" value="" class="form-control"
                                               type="password"
                                               minlength="8"
                                               pattern="(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                               required>
                                        <span class="input-group-addon clickable" id="confirm-mdp-show"><span
                                                    class="glyphicon glyphicon-eye-open"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="mdp-row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-10">
                                    <p class="help-block">8 caractères minimum, un chiffre, majuscule, minuscule et
                                        caractère spécial</p>
                                </div>
                            </div>
                            <div class="row" id="message">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-10">
                                    <p id="2-passwords" class="valid">Les 2 mots de passes sont identiques</p>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal can-disable" id="donnees-activation">
                        <legend class="group-modal-titre">Activation du compte</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="is_deactivated">Le compte est désactivé?</label>
                            </div>
                            <div class="col-md-4">
                                <input id="is_deactivated" name="is_deactivated" type="checkbox">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal can-disable" id="donnees-pro">
                        <legend class="group-modal-titre">Données professionnelles</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="statut-user">Statut<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <select name="statut-user" id="statut-user" class="form-control no-arrows">
                                    <?php
                                    $query = $bdd->prepare(
                                        'SELECT id_statut_intervenant, nom_statut_intervenant FROM statuts_intervenant ORDER BY nom_statut_intervenant'
                                    );
                                    $query->execute();
                                    while ($data = $query->fetch()) {
                                        echo '<option value="' . $data['id_statut_intervenant'] . '">' . $data['nom_statut_intervenant'] . '</option>';
                                    }
                                    $query->CloseCursor();
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label" for="numero_carte-user">Numéro de carte</label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" id="numero_carte-user" name="numero_carte-user" value=""
                                       type="text" maxlength="11">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label">Diplômes</label>
                            </div>
                            <div class="col-md-10">
                                <div id="liste-diplome-user"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="diplome">Ajouter un diplôme</label>
                            </div>
                            <div class="col-md-4">
                                <select name="diplome-user" id="diplome-user" class="form-control">
                                    <option value="-1"></option>
                                    <?php
                                    $query = $bdd->prepare(
                                        'SELECT id_diplome, nom_diplome FROM diplome ORDER BY nom_diplome'
                                    );
                                    $query->execute();
                                    while ($data = $query->fetch()) {
                                        echo '<option value="' . $data['id_diplome'] . '">' . $data['nom_diplome'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success" id="add-diplome-user">Add</button>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal can-disable" id="donnees-coordinateur">
                        <legend class="group-modal-titre">Données coordonnateur</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="est_coordinateur_peps">Est coordonnateur territorial
                                    PEPS?</label>
                            </div>
                            <div class="col-md-4">
                                <input id="est_coordinateur_peps" name="est_coordinateur_peps" type="checkbox">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal can-disable" id="donnees-superviseur">
                        <legend class="group-modal-titre">Données superviseur PEPS</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="nom-fonction">Fonction<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="nom-fonction" name="nom-fonction" value="" class="form-control input-md"
                                       required autocomplete="off"
                                       type="text" maxlength="50">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="group-modal can-disable" id="fieldset-structures">
                        <legend class="group-modal-titre">Structure</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="nom-structure-user">Nom<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="nom-structure-user" name="nom-structure-user" value=""
                                       class="form-control input-md"
                                       required autocomplete="off"
                                       type="text" maxlength="50">
                            </div>
                            <div class="col-md-2">
                                <label class="control-label" for="statuts_structure-user">Type structure<span
                                            style="color: red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input id="statuts_structure-user" name="statuts_structure-user" value=""
                                       class="form-control input-md"
                                       type="text" required readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="adresse-user">Adresse<span
                                            style="color:red">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input id="adresse-user" name="adresse-user" value="" class="form-control input-md"
                                       type="text" required readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" for="complement-adresse-user">Complément d'adresse</label>
                            </div>
                            <div class="col-md-10">
                                <input id="complement-adresse-user" name="complement-adresse-user" value=""
                                       class="form-control input-md" type="text" required readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label for="code-postal-user" class="control-label">Code postal<span
                                            style="color:red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input autocomplete="off" id="code-postal-user" name="code-postal-user"
                                       class="form-control input-md" type="text" required readonly>
                            </div>

                            <div class="col-md-2">
                                <label for="ville-user" class="control-label">Ville<span
                                            style="color:red">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input autocomplete="off" id="ville-user" name="ville-user"
                                       class="form-control input-md"
                                       type="text" required readonly>
                            </div>
                        </div>
                        <br>
                    </fieldset>

                    <?php
                    if (PAGE_NAME == 'settings'): ?>
                        <fieldset class="group-modal can-disable" id="fieldset-settings">
                            <legend class="group-modal-titre">Mes choix interface</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="nombre_elements_tableaux">Nombre d'éléments
                                        affichés
                                        par défaut dans les tableaux</label>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control no-arrows" name="nombre_elements_tableaux" type="text"
                                            id="nombre_elements_tableaux"
                                        <?php
                                        $req = $bdd->query(
                                            "SELECT id_setting, nom FROM settings WHERE nom LIKE 'nombre_elements_tableaux'"
                                        );
                                        $data = $req->fetch();
                                        echo 'data-id_setting="' . $data["id_setting"] . '"';
                                        ?>
                                    >
                                        <option value='10'>10</option>
                                        <option value='25'>25</option>
                                        <option value='50'>50</option>
                                        <option value='100'>100</option>
                                    </select>
                                </div>
                                <br>
                        </fieldset>
                    <?php
                    endif; ?>
                </div>
                <div class="modal-footer">
                    <!-- Boutons à droite -->
                    <button id="enregistrer-modifier-user" type="submit" name="valid-entInitial"
                            class="btn btn-success">Modifier
                    </button>

                    <?php
                    if ($permissions->hasPermission('can_delete_utilisateur')) : ?>
                        <button id="delete-user" type="button" name="delete-user"
                                class="btn btn-danger pull-right">
                            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                            Supprimer
                        </button>
                    <?php
                    endif; ?>

                    <!-- Boutons à gauche -->
                    <button id="close-user" type="button" data-dismiss="modal" class="btn btn-warning pull-left">Abandon
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>