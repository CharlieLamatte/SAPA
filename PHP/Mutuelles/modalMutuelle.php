<form method="POST" class="form-horizontal" id="form-mutuelle">
    <!-- Modal -->
    <div class="modal fade" id="modal-mutuelle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="modal-title-mutuelle">Modal title</h3>
                </div>
                <div class="modal-body">
                    <div id="mutuelle-div">
                        <fieldset class="group-modal can-disable">
                            <legend class="group-modal-titre">Coordonnées</legend>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="mutuelle-nom">Nom<span
                                                style="color: red">*</span></label>
                                </div>
                                <div class="col-md-10">
                                    <input id="mutuelle-nom" name="mutuelle-nom" value=""
                                           class="form-control input-md mutuelle-required" required
                                           type="text" maxlength="50">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="mutuelle-tel-fixe">Téléphone fixe</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="mutuelle-tel-fixe" name="mutuelle-tel-fixe" value=""
                                           class="form-control input-md" type="text"
                                           minlength="10" maxlength="10" placeholder="0XXXXXXXXX">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="mutuelle-tel-portable">Téléphone
                                        portable</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="mutuelle-tel-portable" name="mutuelle-tel-portable" value=""
                                           class="form-control input-md"
                                           type="text" minlength="10" maxlength="10" placeholder="0XXXXXXXXX">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="mutuelle-email">Email</label>
                                </div>
                                <div class="col-md-10">
                                    <input id="mutuelle-email" name="mutuelle-email" value="" class="form-control"
                                           type="email"
                                           maxlength="100" placeholder="xxxxx@xxxx.xxx"
                                           pattern="[a-zA-Z0-9._\-]+[@][a-zA-Z0-9._\-]+[.][a-zA-Z.]{2,15}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="mutuelle-adresse">Adresse</label>
                                </div>
                                <div class="col-md-10">
                                    <input id="mutuelle-adresse" name="mutuelle-adresse" value=""
                                           class="form-control input-md"
                                           type="text">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label class="control-label" for="mutuelle-complement-adresse">Complément
                                        d'adresse</label>
                                </div>
                                <div class="col-md-10">
                                    <input id="mutuelle-complement-adresse" name="mutuelle-complement-adresse"
                                           value=""
                                           class="form-control input-md" placeholder="Appartement,...(facultatif)"
                                           type="text">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label for="mutuelle-code-postal" class="control-label">Code postal<span
                                                style="color:red">*</span></label>
                                </div>
                                <div class="col-md-3">
                                    <input autocomplete="off" id="mutuelle-code-postal" name="mutuelle-code-postal"
                                           class="form-control input-md mutuelle-required" type="text" required>
                                </div>

                                <div class="col-md-2">
                                    <label for="mutuelle-ville" class="control-label">Ville<span
                                                style="color:red">*</span></label>
                                </div>
                                <div class="col-md-5">
                                    <input autocomplete="off" id="mutuelle-ville" name="mutuelle-ville"
                                           class="form-control input-md mutuelle-required"
                                           type="text" required readonly>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Boutons à droite -->
                    <button id="enregistrer-modifier-mutuelle" type="submit" class="btn btn-success">Modifier
                    </button>

                    <!-- Boutons à gauche -->
                    <button id="close-mutuelle" type="button" data-dismiss="modal" class="btn btn-warning pull-left">
                        Abandon
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>