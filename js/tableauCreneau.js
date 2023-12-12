"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 * modalCreneau.js
 */

/**
 * Affichage du tableau
 */
let tableauCreneau = (function () {
    const $table = $('#table_creneau');
    let datatable = null;

    // parametres utilisateur
    // la valeur par défaut est 10
    const nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

    // les urls
    let urls;

    /**
     * Initialisation du tableau
     */
    let init = function (urlObj) {
        urls = urlObj;

        fetch(urls.urlReadCreneaux, {
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
                actualiserInfos(data);
            })
            .catch((error) => {
                //console.error('Error:', error);
                actualiserInfos(null);
            });
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
            for (const user of data) {
                addRow(user, false);
            }
        }
        datatable.draw();
    }

    function createLigne(creneaux) {
        let row = document.createElement('tr');
        row.id = 'row-' + creneaux.id_creneau;

        let td1 = document.createElement('td');
        td1.className = "text-left clickable";
        td1.setAttribute("id", "td1-" + creneaux.id_creneau);
        td1.setAttribute("data-toggle", "modal");
        td1.setAttribute("data-target", "#modal");
        td1.setAttribute("data-backdrop", "static");
        td1.setAttribute("data-keyboard", "false");
        td1.textContent = creneaux.nom_creneau;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.setAttribute("id", "td2-" + creneaux.id_creneau);
        td2.textContent = creneaux.type_parcours;

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.setAttribute("id", "td3-" + creneaux.id_creneau);
        td3.textContent = creneaux.code_postal + ' ' + creneaux.nom_ville;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.setAttribute("id", "td4-" + creneaux.id_creneau);
        td4.textContent = creneaux.jour;

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.setAttribute("id", "td5-" + creneaux.id_creneau);
        td5.textContent = duree(creneaux.nom_heure_debut, creneaux.nom_heure_fin);

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.setAttribute("id", "td6-" + creneaux.id_creneau);
        td6.textContent = creneaux.nom_structure;

        let td7 = document.createElement('td');
        td7.className = "text-left";
        td7.setAttribute("id", "td7-" + creneaux.id_creneau);
        td7.textContent = creneaux.nom_coordonnees + ' ' + creneaux.prenom_coordonnees;

        let td8 = document.createElement('td');
        td8.className = "text-left";
        td8.setAttribute("id", "td8-" + creneaux.id_creneau);

        let liste = document.createElement('a');
        liste.setAttribute("data-toggle", "modal");
        liste.setAttribute("data-target", "#modal");
        liste.setAttribute("data-backdrop", "static");
        liste.setAttribute("data-keyboard", "false");
        liste.textContent = "Liste";
        liste.className = "clickable";

        liste.onclick = function () {
            modalCreneau.setModalMode(MODE.LISTE_PARTICIPANTS);
            modalCreneau.setInfosListeParticipants(creneaux.id_creneau);
        }

        let td9 = document.createElement('td');
        td9.className = "text-left";
        td9.setAttribute("id", "td9-" + creneaux.id_creneau);

        let details = document.createElement('a');
        details.setAttribute("data-toggle", "modal");
        details.setAttribute("data-target", "#modal");
        details.setAttribute("data-backdrop", "static");
        details.setAttribute("data-keyboard", "false");
        details.textContent = "Détails";
        details.className = "clickable";

        function handleDetailClick() {
            modalCreneau.setModalMode(MODE.READONLY);
            modalCreneau.setInfosCreneau(creneaux.id_creneau);
        }

        details.onclick = handleDetailClick;
        td1.onclick = handleDetailClick;

        td8.append(liste);
        td9.append(details);

        row.append(td1, td2, td3, td4, td5, td6, td7, td8, td9);

        return row;
    }

    function addRow(creneau, is_draw) {
        datatable.row.add(createLigne(creneau, is_draw));

        if (is_draw) {
            datatable.draw();
        }
    }

    function deleteRow(id_intervenant) {
        const row = document.getElementById('row-' + id_intervenant);

        row.remove();
    }

    /**
     * Return la durée entre 2 moments au format "HH:mm:ss" (par exemple "07:30:00" pour 7h30)
     * @param heure_debut
     * @param heure_fin
     * @returns {*}
     */
    function duree(heure_debut, heure_fin) {
        const date_debut = "01/01/2021 " + heure_debut;
        const date_fin = "01/01/2021 " + heure_fin;
        return moment.utc(moment(date_fin, "DD/MM/YYYY HH:mm:ss").diff(moment(date_debut, "DD/MM/YYYY HH:mm:ss"))).format("HH:mm");
    }

    /**
     * Remplace les valeurs de la ligne du tableau qui correspond au creneau modifié
     * @param creneaux le nouveau creneau
     */
    function replaceRowValues(creneaux) {
        const td1 = document.getElementById("td1-" + creneaux.id_creneau);
        const td2 = document.getElementById("td2-" + creneaux.id_creneau);
        const td3 = document.getElementById("td3-" + creneaux.id_creneau);
        const td4 = document.getElementById("td4-" + creneaux.id_creneau);
        const td5 = document.getElementById("td5-" + creneaux.id_creneau);
        const td6 = document.getElementById("td6-" + creneaux.id_creneau);
        const td7 = document.getElementById("td7-" + creneaux.id_creneau);

        td1.textContent = creneaux.nom_creneau;
        td2.textContent = creneaux.type_parcours;
        td3.textContent = creneaux.code_postal + ' ' + creneaux.nom_ville;
        td4.textContent = creneaux.jour;
        td5.textContent = duree(creneaux.nom_heure_debut, creneaux.nom_heure_fin);
        td6.textContent = creneaux.nom_structure;
        td7.textContent = creneaux.nom_coordonnees;

        // redraw la table
        datatable.rows().invalidate().draw();
    }

    return {
        init,
        replaceRowValues,
        addRow,
        deleteRow
    };
})();