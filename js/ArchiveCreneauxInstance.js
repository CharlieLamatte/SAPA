"use strict";

$(document).ready(function () {
    // initialisation des élements de la page
    tableauArchive.init();
});

let tableauArchive = (function () {
    const $table = $('#table_id');
    let datatable = null;

    // parametres utilisateur
    const nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux');

    let init = function () {
        fetch('ArchiveCreneauxInstance/ReadAllArchiveCreneauxInstance.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_structure": $table.attr('data-id_structure')}),
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
            "pageLength": nombre_elements_tableaux == null || nombre_elements_tableaux === 'undefined' || nombre_elements_tableaux === 'null' ? 10 : nombre_elements_tableaux
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

        let td1 = document.createElement('td');
        td1.className = "text-left clickable";
        td1.textContent = creneau.nom_creneau;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = creneau.date;

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.textContent = creneau.heure_debut;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.textContent = creneau.heure_fin;

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.textContent = creneau.nom_lieu_pratique;

        let td6 = document.createElement('td');
        td6.className = "text-left";

        let details = document.createElement('a');
        details.setAttribute("data-toggle", "modal");
        details.setAttribute("data-target", "#modal");
        details.textContent = "Détail";
        details.className = "clickable";

        details.onclick = () => {
            modalListeParticipants.setInfosCreneau(creneau.id_creneau_instance);
        };

        td6.append(details);

        row.append(td1, td2, td3, td4, td5, td6);

        return row;
    }

    function addRow(creneau, is_draw) {
        datatable.row.add(createLigne(creneau));

        if (is_draw) {
            datatable.draw();
        }
    }

    return {
        init,
        addRow
    };
})();

let modalListeParticipants = (function () {
    const bodyEmargement = document.getElementById('body-emargement');

    function setInfosCreneau(id_creneau_instance) {
        fetch('ArchiveCreneauxInstance/ReadEmargement.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_creneau_instance": id_creneau_instance}),
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
                //form.setAttribute("data-id_structure", data.id_structure);

                bodyEmargement.innerHTML = '';
                // ajout de la liste des emargements
                if (Array.isArray(data)) {
                    for (const emargement of data) {
                        bodyEmargement.append(createLigne(emargement));
                    }
                }
            })
            .catch((error) => {
                console.error('Error recup infos creneau:', error);

                const emptyRow = document.createElement('tr');

                const td = document.createElement('td');
                td.setAttribute('colspan', '4');
                td.textContent = 'Aucun patient pour ce créneau.'

                bodyEmargement.innerHTML = '';
                emptyRow.append(td);
                bodyEmargement.append(emptyRow);
            });
    }

    function createLigne(emargement) {
        let row = document.createElement('tr');

        let td1 = document.createElement('td');
        td1.className = "text-left clickable";
        td1.textContent = emargement.nom_coordonnees + ' ' + emargement.prenom_coordonnees;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = emargement.presence === '1' ? 'Présent' : 'Absent';

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.textContent = emargement.commentaire;

        row.append(td1, td2, td3);

        return row;
    }

    return {
        setInfosCreneau
    };
})();