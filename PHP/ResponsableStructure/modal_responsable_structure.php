<form method="POST" class="form-horizontal" id="form">
    <!-- Modal -->
    <div class="modal fade" id="modal-reponsable-structure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="modal-title-reponsable-structure">Modal title</h3>
                </div>
                <div class="modal-body">
                    <div id="tableau-liste_beneficiaires">
                        <table id="table_liste_beneficiaires" class="stripe hover row-border compact"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Antenne</th>
                                <th>Date d'admission</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Médecin prescripteur</th>
                            </tr>
                            </thead>
                            <tbody id="table_liste_beneficiaires-body">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Boutons à gauche -->
                    <button id="close-reponsable-structure" type="button" data-dismiss="modal"
                            class="btn btn-warning pull-left">Abandon
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>