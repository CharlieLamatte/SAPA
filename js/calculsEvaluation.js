"use strict";

/**
 *
 * @param distanceReele la distance réellement parcourue en mètres
 * @param age en années
 * @param taille en cm
 * @param sexe 1 = femme et 2 = homme
 * @param poids en kg
 */
function pourcentageDistanceTheorique(distanceReele, taille, age, sexe, poids) {
    try {
        if (sexe === "F") {
            sexe = 0; // femme
        } else {
            sexe = 1; // homme
        }

        if (!taille || !poids || !distanceReele) {
            return 'Non calculable (il manque le poids et/ou la taille et/ou la distance réelle)';
        }

        taille = parseFloat(taille);
        poids = parseFloat(poids);
        age = parseInt(age);
        distanceReele = parseInt(distanceReele);

        const distanceTheorique = 218 + (5.14 * taille) - (5.32 * age) - (1.80 * poids) + (51.31 * sexe);

        return ((100 * distanceReele) / distanceTheorique).toFixed(2) + ' %';
    } catch (e) {
        return 'Non calculable (il manque le poids et/ou la taille)';
    }
}

const affichageResultatCalculs = (function () {
    const form = document.getElementById("main-form");

    function init() {
        // event handlers pour le calcul de la distance théorique
        const elemsTheo = [form.elements['dp'], form.elements['taille'], form.elements['poids']];
        elemsTheo.forEach(
            input => input.addEventListener('input', (event) => {
                form.elements['distance_theo'].value = pourcentageDistanceTheorique(
                    form.elements['dp'].value,
                    form.elements['taille'].value,
                    form.elements['age_recup'].value,
                    form.elements['sexe_recup'].value,
                    form.elements['poids'].value
                );
            })
        );

        // initilisation valeur initiale du champ distance_theo
        form.elements['distance_theo'].value = pourcentageDistanceTheorique(
            form.elements['dp'].value,
            form.elements['taille'].value,
            form.elements['age_recup'].value,
            form.elements['sexe_recup'].value,
            form.elements['poids'].value
        );

        // event handlers pour le calcul de l'IMC
        const elemsIMC = [form.elements['taille'], form.elements['poids']];
        elemsIMC.forEach(
            input => input.addEventListener('input', (event) => {
                form.elements['IMC'].value = calculIMC(
                    form.elements['poids'].value,
                    form.elements['taille'].value
                );
            })
        );
    }

    return {
        init
    };
})();

/**
 *
 * @param poids en kg
 * @param taille en cm
 * @returns {string}
 */
function calculIMC(poids, taille) {
    try {
        if (!taille || !poids) {
            return 'Non calculable';
        }

        taille = parseFloat(taille) * 0.01; // conversion en m
        poids = parseFloat(poids);

        return (poids / ((taille * taille))).toFixed(2);
    } catch (e) {
        return 'Non calculable';
    }
}