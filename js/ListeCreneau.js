"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 * modalCreneau.js
 * tableauCreneau.js
 */

$(document).ready(function () {
    // initialisation des élements de la page
    tableauCreneau.init({
        "urlReadCreneaux": "RecupInfosCreneau.php"
    });
    modalCreneau.init({
        'urlCreateCreneau': 'CreateCreneau.php',
        'urlUpdateCreneau': 'UpdateCreneau.php',
        'urlDeleteCreneau': 'DeleteCreneau.php',
        'urlReadCreneau': 'RecupOneInfosCreneau.php',
        'urlUpdateParticipants': './Participants/UpdateParticipants.php',
        'urlReadParticipants': 'Participants/ReadAllParticipantsCreneau.php',
        'urlAutocompletionCodePostal': '../Villes/ReadAllVille.php',
        'urlReadAllIntervenantsStructure': '../Intervenants/ReadAllStructure.php'
    });
});