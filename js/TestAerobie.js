"use strict";

const testAerobie = (function () {
    const form = document.getElementById('main-form');
    const elems = form.elements;

    // minute à laquelle le patient à abandonné
    let abandonId = null;

    /**
     *
     * @param pageModifEval boolean qui détermine si on est sur la page de modification des évaluations
     */
    function init(pageModifEval) {
        // comportement des boutons radios 'oui' et 'non' du test aérobie
        if (elems['auto1']) {
            elems['auto1'].forEach(
                button => {
                    button.onclick = (event) => {
                        if (elems['auto1']?.value === '1') {
                            elems['dp']?.setAttribute('required', '');

                            hideFieldsFrom(1, false);
                        } else {
                            elems['dp']?.removeAttribute('required');

                            resetAptitudesAerobies();
                            hideFieldsFrom(1, true);
                        }
                    };
                }
            );
        }

        // comportement des input de fréquences cardiaque
        for (let i = 1; i < 10; i++) {
            if (elems['fc' + i]) {
                elems['fc' + i].oninput = (event) => {
                    if (event.target.value === '0') {
                        hideFieldsFrom(i, true);

                        if (abandonId == null) {
                            abandonId = i;
                        } else if (i < abandonId) {
                            abandonId = i;
                        }
                    } else {

                        if (abandonId != null && abandonId === i) {
                            abandonId = null;
                            hideFieldsFrom(i, false);
                        }
                    }
                };
            }
        }

        // initialisation des champs fc si on est sur la page modif eval
        if (pageModifEval) {
            for (let i = 1; i < 10; i++) {
                if (elems['fc' + i] && elems['fc' + i].value === '0') {
                    hideFieldsFrom(i, true);
                    abandonId = i;
                }
            }
        }
    }

    function resetAptitudesAerobies() {
        for (let i = 1; i < 10; i++) {
            elems['fc' + i].value = '';
            elems['sat' + i].value = '';
            elems['borg' + i].forEach(
                r => r.checked = false
            );
        }
    }

    function hideFieldsFrom(index, bool) {
        if (index >= 6) {
            if (bool) {
                elems['fc' + index].removeAttribute('required');
                elems['sat' + index].removeAttribute('required');
                //elems['borg' + index][0].removeAttribute('required');
            } else {
                elems['fc' + index].setAttribute('required', '');
                elems['sat' + index].setAttribute('required', '');
                //elems['borg' + index][0].setAttribute('required', '');
            }
        }

        for (let i = index + 1; i < 10; i++) {
            // seul les mins à patir de 6 sont obligatoire
            if (elems['fc' + i]) {
                elems['fc' + i].parentNode.parentNode.hidden = bool;

                if (i >= 6) {
                    if (bool) {
                        elems['fc' + i].removeAttribute('required');
                        elems['sat' + i].removeAttribute('required');
                        //elems['borg' + i][0].removeAttribute('required');
                    } else {
                        elems['fc' + i].setAttribute('required', '');
                        elems['sat' + i].setAttribute('required', '');
                        //elems['borg' + i][0].setAttribute('required', '');
                    }
                }
            }
        }
    }

    return {
        init
    };
})();