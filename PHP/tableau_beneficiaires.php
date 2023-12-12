<!-- menu deroulant , remplissage du tableau pour filtrer la recherche -->
<div style="text-align: center">
    <div style="margin: 10px 0">
        <select name="champ_tri" id="champ_tri" style="padding: 7px 0"
                onchange="document.getElementById('mot_cle').focus()">
            <?php
            if ($permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_PEPS) ||
                $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_MSS) ||
                $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_NON_MSS) ||
                $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::SUPER_ADMIN) ||
                $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::EVALUATEUR) ||
                $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::RESPONSABLE_STRUCTURE) ||
                $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::SECRETAIRE)) {
                echo '<option id="1" value="nom_patient">Filtrer par nom</option>';
                echo '<option id="2" value="prenom_patient">Filtrer par prénom</option>';
                echo '<option id="3" value="ville_patient">Filtrer par antenne</option>';
                echo '<option id="4" value="date_admission">Filtrer par date d\'admission</option>';
                echo '<option id="5" value="medecin_prescripteur">Filtrer par nom du médecin prescripteur</option>';
                echo '<option id="6" value="association_sportive_patient">Filtrer par structure d\'orientation</option>';
                if ($permissions->hasPermission('can_view_colonne_evaluateur')) {
                    echo '<option id="7" value="evaluateur">Filtrer par évaluateur</option>';
                }
            } elseif ($permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::INTERVENANT) &&
                !$permissions->isIntervenantAndOtherRole()) {
                echo '<option id="0" value="nom_patient">Filtrer par nom</option>';
                echo '<option id="1" value="prenom_patient">Filtrer par prénom</option>';
                echo '<option id="2" value="date_admission">Filtrer par date d\'admission</option>';
            }
            ?>
        </select>
        <input type="text" placeholder="Entrez un mot-clé" class="mot_cle" name="mot_cle" id="mot_cle"
               style="padding: 5px" autofocus>
        <!-- <button type="submit" class="hvr-float-shadow" style="padding: 5px" id="trier_beneficiaires">Trier</button> -->
    </div>
    <?php
    if (($permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_PEPS) ||
            $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_MSS)) &&
        $page != "PAGE_PATIENTS_ARCHIVES") {
        echo '<label for="tous" style="margin-right: 2px;vertical-align: top"> Tous </label ><input style = "margin-right: 5px; margin-top: 0" type = "radio" name = "ens_benefs" id = "tous" value = "tous" checked>';
        echo '<label for="suivis" style="margin-right: 2px;vertical-align: top"> Dossiers suivis </label ><input type = "radio" name = "ens_benefs" id = "suivis">';
    }
    ?>
</div>
<div class="body" style="width: 100%;border : 3px #fdfefe solid;">
    <!-- Tableau qui affiche la liste des bénéficiaires avec leur nom prénom et leur statut-->
    <?php
    if ($permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_PEPS) ||
        $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_MSS) ||
        $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::COORDONNATEUR_NON_MSS) ||
        $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::SUPER_ADMIN) ||
        $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::EVALUATEUR) ||
        $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::RESPONSABLE_STRUCTURE) ||
        $permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::SECRETAIRE)) {
        echo '<table id="table_id" class="stripe hover row-border compact" style="width:100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Alerte</th>';
        echo '<th>Nom</th>';
        echo '<th>Prénom</th>';
        echo '<th>Antenne</th>';
        echo '<th>Date d\'admission</th>';
        if ($page == "PAGE_PATIENTS_ARCHIVES") {
            echo '<th>Date d\'archivage</th>';
        }
        echo '<th>Médecin prescripteur</th>';
        echo '<th>Structure d\'orientation</th>';
        if ($permissions->hasPermission('can_view_colonne_evaluateur')) {
            echo '<th>Évaluateur</th>';
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody id="table_id-body">';
        echo '</tbody>';
        echo '</table>';
    } elseif ($permissions->hasRole(Sportsante86\Sapa\Outils\Permissions::INTERVENANT) &&
        !$permissions->isIntervenantAndOtherRole()) {
        echo '<table id="table_patient" class="stripe hover row-border compact" style="width:100%" data-id_structure="' . $id_structure . '">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Nom</th>';
        echo '<th>Prénom</th>';
        echo '<th>Date d\'admission</th>';
        echo '<th>N° téléphone fixe</th>';
        echo '<th>N° téléphone portable</th>';
        echo '<th>E-mail</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody id="table_patient-body">';
        echo '</tbody>';
        echo '</table>';
    }
    ?>
</div>