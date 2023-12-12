"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 * modalMedecin.js
 */

$(document).ready(function () {
    let medecinData = fetch('RecupInfosMedecin.php', {
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

    Promise.all([medecinData])
        .then(result => {
            // initialisation des élements de la page
            tableauMedecin.init(result[0]);
            modalMedecin.init({
                "urlRecupInfosMedecin": "RecupInfosMedecin.php",
                "urlRechercheCPVille": "../Villes/ReadAllVille.php",
                "urlCreateMedecin": "CreateMedecin.php",
                "urlUpdateMedecin": "UpdateMedecin.php",
                "urlDeleteMedecin": "DeleteMedecin.php",
                "urlFuseMedecin": "FuseMedecin.php",
                "urlRecupOneInfosMedecin": "RecupOneInfosMedecin.php",
            }, {
                medecinData: result[0],
            });
        });
});

/**
 * Affichage des infos des medecins
 */
let tableauMedecin = (function () {
    const $table = $('#table_id');
    let datatable = null;

    // parametres utilisateur
    // la valeur par défaut est 10
    const nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

    let init = function (medecinData) {
        actualiserInfos(medecinData)
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
            for (const medecin of data) {
                addRow(medecin, false);
            }
        }
        datatable.draw();
    }

    function createLigne(medecin) {
        let row = document.createElement('tr');
        row.id = 'row-' + medecin.id_medecin;

        let td1 = document.createElement('td');
        td1.className = "text-left clickable";
        td1.setAttribute("id", "td1-" + medecin.id_medecin);
        td1.setAttribute("data-toggle", "modal");
        td1.setAttribute("data-target", "#modal");
        td1.setAttribute("data-backdrop", "static");
        td1.setAttribute("data-keyboard", "false");
        td1.textContent = medecin.nom_coordonnees;

        let td2 = document.createElement('td');
        td2.className = "text-left clickable";
        td2.setAttribute("id", "td2-" + medecin.id_medecin);
        td2.setAttribute("data-toggle", "modal");
        td2.setAttribute("data-target", "#modal");
        td2.setAttribute("data-backdrop", "static");
        td2.setAttribute("data-keyboard", "false");
        td2.textContent = medecin.prenom_coordonnees;

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.setAttribute("id", "td3-" + medecin.id_medecin);
        td3.textContent = medecin.poste_medecin;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.setAttribute("id", "td4-" + medecin.id_medecin);
        td4.textContent = medecin.nom_specialite_medecin;

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.setAttribute("id", "td5-" + medecin.id_medecin);
        td5.textContent = medecin.nom_lieu_pratique;

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.setAttribute("id", "td6-" + medecin.id_medecin);
        td6.textContent = medecin.nom_adresse + " " + medecin.code_postal + " " + medecin.nom_ville;

        let td7 = document.createElement('td');
        td7.className = "text-left";
        td7.setAttribute("id", "td7-" + medecin.id_medecin);
        if (medecin.tel_fixe_coordonnees == null || medecin.tel_fixe_coordonnees === "") {
            td7.textContent = "Aucun";
        } else {
            td7.textContent = medecin.tel_fixe_coordonnees;
        }

        let td8 = document.createElement('td');
        td8.className = "text-left";
        td8.setAttribute("id", "td8-" + medecin.id_medecin);

        if (medecin.mail_coordonnees == null || medecin.mail_coordonnees === "") {
            td8.textContent = "Aucun";
        } else {
            let mailLink = document.createElement('a');
            mailLink.textContent = medecin.mail_coordonnees;
            mailLink.setAttribute("href", "mailto:" + medecin.mail_coordonnees);
            td8.append(mailLink);
        }

        let td9 = document.createElement('td');
        td9.className = "text-left";

        let details = document.createElement('a');
        details.setAttribute("data-toggle", "modal");
        details.setAttribute("data-target", "#modal");
        details.setAttribute("data-backdrop", "static");
        details.setAttribute("data-keyboard", "false");
        details.textContent = "Détail";
        details.className = "clickable";

        function handleDetailClick() {
            modalMedecin.setModalMode(MODE.READONLY);
            modalMedecin.setInfosMededin(medecin.id_medecin);
        }

        details.onclick = handleDetailClick;
        td1.onclick = handleDetailClick;
        td2.onclick = handleDetailClick;

        td9.append(details);

        row.append(td1, td2, td3, td4, td5, td6, td7, td8, td9);

        return row;
    }

    function addRow(medecin, is_draw) {
        datatable.row.add(createLigne(medecin));

        if (is_draw) {
            datatable.draw();
        }
    }

    function deleteRow(id_medecin) {
        const row = document.getElementById('row-' + id_medecin);

        row.remove();
    }

    /**
     * Remplace les valeurs du tableau
     * @param medecin les nouvelles valeurs du médecins
     */
    function replaceRowValues(medecin) {
        const td1 = document.getElementById("td1-" + medecin.id_medecin);
        const td2 = document.getElementById("td2-" + medecin.id_medecin);
        const td3 = document.getElementById("td3-" + medecin.id_medecin);
        const td4 = document.getElementById("td4-" + medecin.id_medecin);
        const td5 = document.getElementById("td5-" + medecin.id_medecin);
        const td6 = document.getElementById("td6-" + medecin.id_medecin);
        const td7 = document.getElementById("td7-" + medecin.id_medecin);
        const td8 = document.getElementById("td8-" + medecin.id_medecin);

        td1.textContent = medecin.nom_coordonnees;
        td2.textContent = medecin.prenom_coordonnees;
        td3.textContent = medecin.poste_medecin;
        td4.textContent = medecin.nom_specialite_medecin;
        td5.textContent = medecin.nom_lieu_pratique;
        td6.textContent = medecin.nom_adresse + " " + medecin.code_postal + " " + medecin.nom_ville;
        if (medecin.tel_fixe_coordonnees == null || medecin.tel_fixe_coordonnees === "") {
            td7.textContent = "Aucun";
        } else {
            td7.textContent = medecin.tel_fixe_coordonnees;
        }
        if (medecin.mail_coordonnees == null || medecin.mail_coordonnees === "") {
            td8.textContent = "Aucun";
        } else {
            td8.textContent = "";
            let mailLink = document.createElement('a');
            mailLink.textContent = medecin.mail_coordonnees;
            mailLink.setAttribute("href", "mailto:" + medecin.mail_coordonnees);
            td8.append(mailLink);
        }

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