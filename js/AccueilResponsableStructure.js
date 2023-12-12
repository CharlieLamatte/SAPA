"use strict";

$(document).ready(function () {
    if (localStorage.getItem('role_user_ids') == null) {
        storage.init('../Data/ReadSession.php').then(r => {
            initPage()
        });
    } else {
        initPage();
    }

    /**
     * Initialisation des éléments de la page
     */
    function initPage() {
        if (document.getElementById('table2_id')) {
            tableauSeance.init();
        }

        if (document.getElementById('tableau-liste_beneficiaires')) {
            tableauParticipant.init();
        }

        if (document.getElementById('extraModal')) {
            modalDetailsSeance.init({
                urlUpdateSeance: '../Seances/UpdateSeance.php',
                urlRecupOneInfosSeance: '../Seances/RecupOneInfosSeance.php',
                urlReadListeParticipantsSeance: '../Seances/ReadListeParticipantsSeance.php',
            });
        }
    }
});

let tableauSeance = (function () {
    // parametres utilisateur
    // la valeur par défaut est 10
    let nombre_elements_tableaux;
    let id_structure;

    const filterWeekSelect = document.getElementById('filter-week');

    const weekDateStartSpan = document.getElementById('week_date_start');
    const weekDateEndSpan = document.getElementById('week_date_end');

    let dataTable;

    let init = async function () {
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;
        id_structure = localStorage.getItem('id_structure');

        // on rempli le tableau quand toutes les données ont été récupérés
        remplirTableau();

        filterWeekSelect.onchange = (event) => {
            dataTable.draw();

            // changement des dates affichées
            const selectedOption = filterWeekSelect.options[filterWeekSelect.selectedIndex];
            weekDateStartSpan.textContent = selectedOption.getAttribute("data-week_date_start");
            weekDateEndSpan.textContent = selectedOption.getAttribute("data-week_date_end");
        };
    }

    function remplirTableau() {
        // format des dates du tableau
        $.fn.dataTable.moment('DD/MM/YYYY');

        // initialisation de la Datatable
        dataTable = $('#table2_id').DataTable({
            paging: true,
            retrieve: true,
            scrollX: false,
            autoWidth: true,
            responsive: true,
            order: [
                [0, "asc"]
            ],
            columnDefs: [
                {targets: [8], visible: false, searchable: false},
                {targets: '_all', visible: true}
            ],

            language: {url: "../../js/DataTables/media/French.json"},
            "pageLength": nombre_elements_tableaux
        });

        // filtrage des séances selon la colonne caché du numéro de semaine
        $.fn.dataTable.ext.search.push(
            function (settings, searchData, index, rowData, counter) {
                // nécessaire car il y a 2 tables sur la même page
                if (settings.nTable.id !== 'table2_id') {
                    return true;
                }

                return rowData[8] === filterWeekSelect.value;
            }
        );

        fetch('../Seances/ReadAllSeanceStructure.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_structure": id_structure}),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            }).then(data => {

            if (Array.isArray(data)) {
                for (const patient of data) {
                    dataTable.row.add(createLigne(patient));
                }

            }
            dataTable.draw();
        }).catch((e) => console.error(e));
    }

    function createLigne(seance) {
        let row = document.createElement('tr');

        const fetchDataOpenModal = (event) => {
            modalDetailsSeance.fetchInfosSeance(seance.id_seance);
            modalDetailsSeance.handleOpenClick(event);
        };

        let td1 = document.createElement('td');
        td1.className = "text-left clickable";
        td1.textContent = seance.nom_antenne;
        td1.onclick = fetchDataOpenModal;

        let td2 = document.createElement('td');
        td2.className = "text-left clickable";
        td2.textContent = seance.tel_fixe_intervenant;
        td2.onclick = fetchDataOpenModal;

        let td3 = document.createElement('td');
        td3.className = "text-left clickable";
        td3.id = "td3-seance-" + seance.id_seance;
        const date = new Date(seance.date_seance);
        td3.textContent = date.toLocaleDateString("fr-FR");
        td3.onclick = fetchDataOpenModal;

        let td4 = document.createElement('td');
        td4.className = "text-left clickable";
        td4.id = "td4-seance-" + seance.id_seance;
        td4.textContent = seance.heure_debut;
        td4.onclick = fetchDataOpenModal;

        let td5 = document.createElement('td');
        td5.className = "text-left";

        let liste = document.createElement('a');
        liste.setAttribute("data-toggle", "modal");
        liste.setAttribute("data-target", "#modal-reponsable-structure");
        liste.textContent = "Liste";
        liste.className = "clickable";

        liste.onclick = (event) => {
            event.preventDefault();
            modal.setMode(MODE.LISTE_PARTICIPANTS_SEANCE);
            tableauParticipant.remplir(seance.id_seance);
        };

        td5.append(liste);

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.textContent = seance.nom_intervenant + " " + seance.prenom_intervenant;

        let td7 = document.createElement('td');
        td7.className = "text-left";
        td7.textContent = seance.nom_statut_structure;

        let td8 = document.createElement('td');
        td8.className = "text-left";
        td8.textContent = seance.adresse + " " + seance.code_postal + " " + seance.nom_ville;

        // colonne cachée
        let td9 = document.createElement('td');
        td9.textContent = seance.week_number;

        row.append(td1, td2, td3, td4, td5, td6, td7, td8, td9);

        return row;
    }

    /**
     * Remplace les valeurs du tableau
     * @param seance les nouvelles valeurs de la seance
     */
    function replaceRowValues(seance) {
        const td3 = document.getElementById("td3-seance-" + seance.id_seance);
        const td4 = document.getElementById("td4-seance-" + seance.id_seance);
        td3.textContent = seance.date_seance;
        td4.textContent = seance.heure_debut;
    }

    return {
        init,
        replaceRowValues
    };
})();