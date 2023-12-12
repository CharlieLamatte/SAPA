"use strict";

$(document).ready(function () {
    // initialisation des élements de la page
    const estPrisEnChargeCheckbox = document.getElementById('est-pris-en-charge');
    const tr = document.getElementById('prise-en-charge-tr');
    const input = document.getElementById('hauteur-prise-en-charge');

    function handleCheckboxChange() {
        if (estPrisEnChargeCheckbox.checked) {
            tr.hidden = false;
            input.required = true;
        } else {
            tr.hidden = true;
            input.required = false;
        }
    }

    estPrisEnChargeCheckbox.onchange = handleCheckboxChange;
    handleCheckboxChange();
});