"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * modalUser.js
 */

// les différents modes d'interaction avec le modal
const MODE = {
    ADD: 'add',
    EDIT: 'edit',
    READONLY: 'readonly'
};
Object.freeze(MODE);

$(document).ready(function () {
    // initialisation des élements de la page
    affichageTableauUser.init();
    modalUser.init({
        "urlReadOneStructure": "../Structures/ReadOneStructure.php",
        "urlRecupInfosUser": "RecupInfosUser.php",
        "urlRecupOneInfosUser": "RecupOneInfosUser.php",
        "urlRechercheStructure": "../Structures/ReadAllStructures.php",
        "urlReadAllDiplomes": "../Diplomes/ReadAllDiplomes.php",
        "urlCreateUser": "CreateUser.php",
        "urlUpdateUser": "UpdateUser.php",
        "urlDeleteUser": "DeleteUser.php"
    });
});

/**
 * Affichage des infos des users
 */
let affichageTableauUser = (function () {
    const $table = $('#table_id');
    const roles_user = JSON.parse(localStorage.getItem('roles_user'));
    let datatable = null;

    // parametres utilisateur
    // la valeur par défaut est 10
    const nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

    let init = function () {
        fetch('RecupInfosUser.php', {
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

    function createLigne(user) {
        let row = document.createElement('tr');
        row.id = 'row-' + user.id_user;

        if (roles_user.includes(ROLE.SUPER_ADMIN)) {
            let td0 = document.createElement('td');
            td0.className = "text-left";
            td0.setAttribute("id", "td0-" + user.id_user);
            td0.textContent = user.nom_territoire;

            row.append(td0);
        }

        let td1 = document.createElement('td');
        td1.className = "text-left";
        td1.setAttribute("id", "td1-" + user.id_user);
        td1.textContent = user.role_user;

        let td2 = document.createElement('td');
        td2.className = "text-left clickable";
        td2.setAttribute("id", "td2-" + user.id_user);
        td2.setAttribute("data-toggle", "modal");
        td2.setAttribute("data-target", "#modal-user");
        td2.setAttribute("data-backdrop", "static");
        td2.setAttribute("data-keyboard", "false");
        td2.textContent = user.nom_user;

        let td3 = document.createElement('td');
        td3.className = "text-left clickable";
        td3.setAttribute("id", "td3-" + user.id_user);
        td3.setAttribute("data-toggle", "modal");
        td3.setAttribute("data-target", "#modal-user");
        td3.setAttribute("data-backdrop", "static");
        td3.setAttribute("data-keyboard", "false");
        td3.textContent = user.prenom_user;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.setAttribute("id", "td4-" + user.id_user);
        if (user.tel_p_user == null || user.tel_p_user === "") {
            td4.textContent = "Aucun";
        } else {
            td4.textContent = user.tel_p_user;
        }

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.setAttribute("id", "td5-" + user.id_user);
        if (user.tel_f_user == null || user.tel_f_user === "") {
            td5.textContent = "Aucun";
        } else {
            td5.textContent = user.tel_f_user;
        }

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.setAttribute("id", "td6-" + user.id_user);
        if (user.email_user == null || user.email_user === "") {
            td6.textContent = "Aucun";
        } else {
            td6.textContent = "";
            let mailLink = document.createElement('a');
            mailLink.textContent = user.email_user;
            mailLink.setAttribute("href", "mailto:" + user.email_user);
            td6.append(mailLink);
        }

        let td7 = document.createElement('td');
        td7.className = "text-left";
        td7.setAttribute("id", "td7-" + user.id_user);
        td7.textContent = user.structure.nom_structure;

        let td8 = document.createElement('td');
        td8.className = "text-left";
        td8.setAttribute("id", "td8-" + user.id_user);
        td8.textContent = user.structure.nom_statut_structure;

        let td9 = document.createElement('td');
        td9.className = "text-left";

        let details = document.createElement('a');
        details.setAttribute("data-toggle", "modal");
        details.setAttribute("data-target", "#modal-user");
        details.setAttribute("data-backdrop", "static");
        details.setAttribute("data-keyboard", "false");
        details.textContent = "Détail";
        details.className = "clickable";

        function handleDetailClick(event) {
            event.preventDefault();
            modalUser.setInfosUser(user.id_user);
            modalUser.setModalMode(MODE.READONLY);
        }

        details.onclick = handleDetailClick;
        td2.onclick = handleDetailClick;
        td3.onclick = handleDetailClick;

        td9.append(details);

        row.append(td1, td2, td3, td4, td5, td6, td7, td8, td9);

        return row;
    }

    function addRow(user, is_draw) {
        datatable.row.add(createLigne(user));

        if (is_draw) {
            datatable.draw();
        }
    }

    function deleteRow(id_user) {
        const row = document.getElementById('row-' + id_user);
        row.remove();
    }

    /**
     * Remplace les valeurs du tableau
     * @param user les nouvelles valeurs du user
     */
    function replaceRowValues(user) {
        const td0 = document.getElementById("td0-" + user.id_user);
        const td1 = document.getElementById("td1-" + user.id_user);
        const td2 = document.getElementById("td2-" + user.id_user);
        const td3 = document.getElementById("td3-" + user.id_user);
        const td4 = document.getElementById("td4-" + user.id_user);
        const td5 = document.getElementById("td5-" + user.id_user);
        const td6 = document.getElementById("td6-" + user.id_user);
        const td7 = document.getElementById("td7-" + user.id_user);
        const td8 = document.getElementById("td8-" + user.id_user);
        if (td0) {
            td0.textContent = user.nom_territoire;
        }
        td1.textContent = user.role_user;
        td2.textContent = user.nom_user;
        td3.textContent = user.prenom_user;
        if (user.tel_p_user == null || user.tel_p_user === "") {
            td4.textContent = "Aucun";
        } else {
            td4.textContent = user.tel_p_user;
        }
        if (user.tel_f_user == null || user.tel_f_user === "") {
            td5.textContent = "Aucun";
        } else {
            td5.textContent = user.tel_f_user;
        }
        if (user.email_user == null || user.email_user === "") {
            td6.textContent = "Aucun";
        } else {
            td6.textContent = "";
            let mailLink = document.createElement('a');
            mailLink.textContent = user.email_user;
            mailLink.setAttribute("href", "mailto:" + user.email_user);
            td6.append(mailLink);
        }
        td7.textContent = user.structure.nom_structure;
        td8.textContent = user.structure.nom_statut_structure;
    }

    return {
        init,
        replaceRowValues,
        addRow,
        deleteRow
    };
})();