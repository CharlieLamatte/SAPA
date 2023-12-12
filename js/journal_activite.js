"use strict";

$(document).ready(function () {
    // initialisation des élements de la page
    tableExportJournalActivite.init();
});

const tableExportJournalActivite = (function () {
    const $table = $('#table-journal');
    const tableBody = document.getElementById('body-journal');

    let datatable = null;
    // parametres utilisateur
    // la valeur par défaut est 10
    let nombre_elements_tableaux;

    function init() {
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

        fetch('ReadJournalActivite.php', {
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
            .then(data => {
                initTable(data);
            })
            .catch((error) => {
                initTable(null);
            });
    }

    function initTable(data) {
        if (Array.isArray(data)) {
            for (const patient of data) {
                tableBody.append(createLigne(patient));
            }
        }

        datatable = $table.DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export excel',
                    exportOptions: {
                        columns: ':visible'
                    },
                    filename: 'journal_activite',
                    title: null
                },
                {
                    extend: 'colvis',
                    text: 'Choix colonnes',
                }
            ],
            "scrollX": true,
            "autoWidth": true,
            responsive: true,
            language: {url: "../../js/DataTables/media/French.json"},
            "pageLength": nombre_elements_tableaux
        });
        datatable.draw();
    }

    function createLigne(activity) {
        let row = document.createElement('tr');

        let td1 = document.createElement('td');
        td1.className = "text-left";
        td1.textContent = activity.id_journal_activite;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = activity.id_user_acteur;

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.textContent = activity.nom_acteur;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.textContent = activity.type_action;

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.textContent = activity.type_cible;

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.textContent = activity.nom_cible;

        let td7 = document.createElement('td');
        td7.className = "text-left";
        td7.textContent = activity.id_cible;

        let td8 = document.createElement('td');
        td8.className = "text-left";
        td8.textContent = activity.date_action;

        row.append(td1, td2, td3, td4, td5, td6, td7, td8);

        return row;
    }

    return {
        init
    };
})();
