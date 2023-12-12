"use strict";

$(document).ready(function () {
    if (localStorage.getItem('role_user_ids') == null) {
        storage.init('../Data/ReadSession.php').then(r => {
            if ($('#table_id')) {
                affichageInfoTerritoires.init();
            }
        });
    } else {
        if ($('#table_id')) {
            affichageInfoTerritoires.init();
        }
    }
});

/**
 * Affichage des infos des territoires
 */
let affichageInfoTerritoires = (function () {
    let tbody = document.getElementById('tableau-body');

    // parametres utilisateur
    // la valeur par défaut est 10
    let nombre_elements_tableaux;

    let init = function () {
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

        fetch('../Statistiques/RecupInfosTerritoires.php', {
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
            .then((data) => {
                $.each(data, function (index, value) {
                    tbody.append(createLigneTerritoires(value));
                });

                // initialisation de la Datatable
                $('#tableau-bord').DataTable({
                    "scrollX": true,
                    "autoWidth": true,
                    responsive: true,
                    language: {url: "../../js/DataTables/media/French.json"},
                    "pageLength": nombre_elements_tableaux
                });
            })
            .catch((error) => {
                console.error('Error:', error);
                return null;
            });
    };

    function createLigneTerritoires(territoire) {
        let row = document.createElement('tr');
        if (territoire.is_total) {
            row.setAttribute("style", "background-color:#e5e7e9")
        }

        let td1 = document.createElement('td');
        td1.textContent = territoire.nom_territoire;

        let td2 = document.createElement('td');
        td2.textContent = territoire.nb_coordinateur;

        let td3 = document.createElement('td');
        td3.textContent = territoire.nb_patient;

        let td4 = document.createElement('td');
        td4.textContent = territoire.nb_structure;

        let td5 = document.createElement('td');
        td5.textContent = territoire.nb_intervenant;

        let td6 = document.createElement('td');
        td6.textContent = territoire.nb_creneau;

        row.append(td1, td2, td3, td4, td5, td6);

        return row;
    }

    return {
        init
    };
})();