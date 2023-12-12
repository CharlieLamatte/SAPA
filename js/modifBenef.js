"use strict";

/**
 * Ce fichier nécessite le fichier function.js pour fonctionner correctement
 */

$(document).ready(function () {
    const codePostalCamInput = document.getElementById("code-postal-patient");
    const villCameInput = document.getElementById("ville-patient");
    trouverCPVille("../Villes/ReadAllVille.php", codePostalCamInput, villCameInput);
});