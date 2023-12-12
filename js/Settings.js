"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * modalStructure.js
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
            modalUser.init({
                "urlReadOneStructure": "../Structures/ReadOneStructure.php",
                "urlRecupInfosUser": "../Users/RecupInfosUser.php",
                "urlRecupOneInfosUser": "../Users/RecupOneInfosUser.php",
                "urlRechercheStructure": "../Structures/ReadAllStructures.php",
                "urlReadAllDiplomes": "../Diplomes/ReadAllDiplomes.php",
                "urlCreateUser": "../Users/CreateUser.php",
                "urlUpdateUser": "../Users/UpdateUser.php",
                "urlDeleteUser": "../Users/DeleteUser.php"
            }, {
                structureData: result[0],
            });
            modalStructure.init({
                "urlRechercheCPVille": "../Villes/ReadAllVille.php",
                "urlRecupInfosIntervenant": "../Intervenants/RecupInfosIntervenant.php",
                "urlReadOneStructure": "../Structures/ReadOneStructure.php",
                "urlCreateStructure": "../Structures/CreateStructure.php",
                "urlUpdateStructure": "../Structures/UpdateStructure.php",
                "urlDeleteStructure": "../Structures/DeleteStructure.php"
            }, {
                structureData: result[0],
            });
        });
});
