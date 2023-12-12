"use strict";

$(document).ready(function () {
    // initialisation des élements de la page
    tableauArchive.init();
});

let tableauArchive = (function () {
    const $table = $('#table_id');
    let datatable = null;

    // parametres utilisateur
    // la valeur par défaut est 10
    const nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

    let init = function () {
        fetch('ValidationCreneaux/ReadAllCreneauxNonValide.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({'statut_creneau': 'Refuse'}),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .then(data => {
                actualiserInfos(data);
            })
            .catch((error) => {
                console.error('Error:', error);
                actualiserInfos(null);
            });
    };

    function actualiserInfos(data) {
        // initialisation de la Datatable
        datatable = $table.DataTable({
            "scrollX": true,
            "autoWidth": true,
            responsive: true,
            language: {url: "../PHP/DataTables/media/French.json"},
            "pageLength": nombre_elements_tableaux
        });

        if (Array.isArray(data)) {
            for (const creneau of data) {
                addRow(creneau, false);
            }
        }
        datatable.draw();
    }

    function createLigne(creneau) {
        let row = document.createElement('tr');
        row.id = 'row-' + creneau.id_creneau;

        let td1 = document.createElement('td');

        let valider = document.createElement('button');
        valider.className = "clickable btn btn-success";
        valider.textContent = 'Valider';
        valider.id = 'valider-button' + creneau.id_creneau;

        valider.onclick = () => {
            updateCreneau({
                'id_creneau': creneau.id_creneau,
                'statut_creneau': 'Valide'
            }, row);
        };

        td1.append(valider);

        let td3 = document.createElement('td');
        td3.textContent = creneau.nom_creneau;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.textContent = creneau.description_creneau;

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.textContent = creneau.nom_adresse + ' ' + creneau.ville_creneau + ' ' + creneau.codepostal_creneau;

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.textContent = creneau.type_seance;

        let td7 = document.createElement('td');
        td7.className = "text-left";
        td7.textContent = creneau.jour;

        let td8 = document.createElement('td');
        td8.className = "text-left";
        td8.textContent = creneau.heure_debut;

        let td9 = document.createElement('td');
        td9.className = "text-left";
        td9.textContent = creneau.heure_fin;

        let td10 = document.createElement('td');
        td10.className = "text-left";
        td10.textContent = creneau.tarif;

        let td11 = document.createElement('td');
        td11.className = "text-left";
        td11.textContent = 'facilite';

        let td12 = document.createElement('td');
        td12.className = "text-left";
        td12.textContent = creneau.nb_participant;

        let td13 = document.createElement('td');
        td13.className = "text-left";
        td13.textContent = creneau.public_vise;

        let td14 = document.createElement('td');
        td14.className = "text-left";
        td14.textContent = creneau.pathologie_creneau;

        let td15 = document.createElement('td');
        td15.className = "text-left";
        td15.textContent = creneau.type_parcours;

        let td16 = document.createElement('td');
        td16.className = "text-left";
        td16.textContent = creneau.nom_structure;

        let td17 = document.createElement('td');
        td17.className = "text-left";
        td17.textContent = creneau.nom_coordonnees + ' ' + creneau.prenom_coordonnees;

        row.append(td1, td3, td4, td5, td6, td7, td8, td9, td10, td11, td12, td13, td14, td15, td16, td17);

        return row;
    }

    function addRow(creneau, is_draw) {
        datatable.row.add(createLigne(creneau));

        if (is_draw) {
            datatable.draw();
        }
    }

    function updateCreneau(creneau, row) {
        fetch('ValidationCreneaux/UpdateValidationCreneaux.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(creneau),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .then(data => {
                // suppression de la ligne
                datatable.row(row).remove().draw();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    return {
        init,
        addRow
    };
})();