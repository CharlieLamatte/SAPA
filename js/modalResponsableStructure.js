"use strict";

// les différents modes d'interaction avec le modal responsable structure
const MODE = {
    LISTE_PARTICIPANTS_SEANCE: 'LISTE_PARTICIPANTS_SEANCE',
};
Object.freeze(MODE);

const modal = (function () {
    const title = document.getElementById("modal-title-reponsable-structure");

    function setMode(mode) {
        if (mode === MODE.LISTE_PARTICIPANTS_SEANCE) {
            title.textContent = "Détails des bénéficiaires";
        }
    }

    return {
        setMode
    };
})();

/**
 * Tableau des participants d'une séance
 *
 * @type {{init: init, remplir: remplir}}
 */
const tableauParticipant = (function () {
    const $div = $('#tableau-liste_beneficiaires');

    // parametres utilisateur
    // la valeur par défaut est 10
    let nombre_elements_tableaux;

    let dataTableListe;

    function init() {
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

        // format des dates du tableau
        $.fn.dataTable.moment('DD/MM/YYYY');

        // initialisation de la Datatable
        dataTableListe = $('#table_liste_beneficiaires').DataTable({
            paging: true,
            retrieve: true,
            scrollX: false,
            autoWidth: true,
            responsive: true,
            order: [
                [0, "asc"]
            ],

            language: {url: "../../js/DataTables/media/French.json"},
            "pageLength": nombre_elements_tableaux
        });
    }

    /**
     *
     * @param id_seance
     */
    function remplir(id_seance) {
        dataTableListe.clear().draw();

        fetch('../Seances/ReadListeParticipantsSeance.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_seance": id_seance}),
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
                if (Array.isArray(data)) {
                    for (const patient of data) {
                        dataTableListe.row.add(createLigne(patient));
                    }
                }
                dataTableListe.draw();
            })
            .catch((e) => console.error(e));
    }

    function createLigne(patient) {
        let row = document.createElement('tr');

        let td1 = document.createElement('td');
        td1.className = "text-left";
        td1.textContent = patient.nom_patient;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = patient.prenom_patient;

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.textContent = patient.nom_antenne;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.textContent = patient.date_admission;

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.textContent = patient.telephone;

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.textContent = patient.mail_coordonnees;

        let td7 = document.createElement('td');
        td7.className = "text-left";
        td7.textContent = patient.telephone;
        if (patient.prenom_medecin == null || patient.nom_medecin == null) {
            td7.textContent = "Aucun";
        } else {
            td7.textContent = patient.nom_medecin + " " + patient.prenom_medecin;
        }

        row.append(td1, td2, td3, td4, td5, td6, td7);

        return row;
    }

    function setHidden(on) {
        if (on) {
            $div.hide();
        } else {
            $div.show();
        }
    }

    return {
        init,
        remplir,
        setHidden
    };
})();