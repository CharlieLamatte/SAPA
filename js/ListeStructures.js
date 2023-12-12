"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 * modalStructure.js
 */

// les différents modes d'interaction avec le modal
const MODE = {
    ADD: 'add',
    EDIT: 'edit',
    READONLY: 'readonly',
    FUSION: 'fusion'
};
Object.freeze(MODE);

$(document).ready(function () {
    let structureData = fetch('../Structures/ReadAllStructures.php', {
        method: 'GET',
    })
        .then(response => {
            if (!response.ok) {
                throw {
                    statusCode: response.status,
                };
            }
            return response.json()
        })
        .catch(() => null);

    Promise.all([structureData])
        .then(result => {
            // initialisation des élements de la page
            tableauStructure.init(result[0]);
            modalStructure.init({
                "urlRechercheCPVille": "../Villes/ReadAllVille.php",
                "urlRecupInfosIntervenant": "../Intervenants/RecupInfosIntervenant.php",
                "urlReadOneStructure": "ReadOneStructure.php",
                "urlCreateStructure": "CreateStructure.php",
                "urlUpdateStructure": "UpdateStructure.php",
                "urlDeleteStructure": "DeleteStructure.php"
            }, {
                structureData: result[0],
            });
        });
});

let tableauStructure = (function () {
    const $table = $('#table_id');
    let datatable = null;

    // parametres utilisateur
    // la valeur par défaut est 10
    const nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

    let init = function (structureData) {
        actualiserInfos(structureData);
    };

    function actualiserInfos(data) {
        // initialisation de la Datatable
        datatable = $table.DataTable({
            "scrollX": true,
            "autoWidth": true,
            responsive: true,
            language: {url: "../../js/DataTables/media/French.json"},
            "pageLength": nombre_elements_tableaux
        });

        if (Array.isArray(data)) {
            for (const structure of data) {
                addRow(structure, false);
            }
        }
        datatable.draw();
    }

    function createLigne(structure) {
        let row = document.createElement('tr');
        row.id = 'row-' + structure.id_structure;

        let td1 = document.createElement('td');
        td1.className = "text-left clickable";
        td1.setAttribute("id", "td1-" + structure.id_structure);
        td1.setAttribute("data-toggle", "modal");
        td1.setAttribute("data-target", "#modalStructure");
        td1.setAttribute("data-backdrop", "static");
        td1.setAttribute("data-keyboard", "false");
        td1.textContent = structure.nom_structure;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.setAttribute("id", "td2-" + structure.id_structure);
        td2.textContent = structure.nom_statut_structure;

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.setAttribute("id", "td3-" + structure.id_structure);
        td3.textContent = structure.nom_adresse + " " + structure.code_postal + " " + structure.nom_ville;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.setAttribute("id", "td4-" + structure.id_structure);
        td4.textContent = structure.nom_territoire;

        let td5 = document.createElement('td');
        td5.className = "text-left";

        let details = document.createElement('a');
        details.setAttribute("data-toggle", "modal");
        details.setAttribute("data-target", "#modalStructure");
        details.setAttribute("data-backdrop", "static");
        details.setAttribute("data-keyboard", "false");
        details.textContent = "Détail";
        details.className = "clickable";

        function handleClickDetails() {
            modalStructure.setModalMode(MODE.READONLY);
            modalStructure.setInfosStructure(structure.id_structure);
        }

        details.onclick = handleClickDetails;
        td1.onclick = handleClickDetails;

        td5.append(details);

        row.append(td1);
        row.append(td2);
        row.append(td3);
        row.append(td4);
        row.append(td5);

        return row;
    }

    function addRow(structure, is_draw) {
        datatable.row.add(createLigne(structure));

        if (is_draw) {
            datatable.draw();
        }
    }

    function deleteRow(id_structure) {
        const row = document.getElementById('row-' + id_structure);

        row.remove();
    }

    /**
     * Remplace les valeurs de la ligne du tableau qui correspond à la structure modifiée
     * @param structure la nouvelle structure
     */
    function replaceRowValues(structure) {
        const td1 = document.getElementById("td1-" + structure.id_structure);
        const td2 = document.getElementById("td2-" + structure.id_structure);
        const td3 = document.getElementById("td3-" + structure.id_structure);

        td1.textContent = structure.nom_structure;
        td2.textContent = structure.nom_statut_structure;
        td3.textContent = structure.nom_adresse + " " + structure.code_postal + " " + structure.nom_ville;
    }

    return {
        init,
        replaceRowValues,
        addRow,
        deleteRow,
    };
})();