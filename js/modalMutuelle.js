"use strict";

// les différents modes d'interaction avec le modal
const MODE_MUTUELLE = {
    ADD_MUTUELLE: 'add_mutuelle',
};
Object.freeze(MODE_MUTUELLE);

/**
 * Affichage du modal mutuelle
 */
let modalMutuelle = (function () {
    // le bouton qui ouvre le modal
    const ajoutMutuelleButton = document.getElementById("ajout-mutuelle");

    // les element du modal qui peuvent être désactivés (en général tous sauf les bouton abandon, etc ...)
    const canBeDisabledElems = document.getElementsByClassName("can-disable");
    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    // boutons du modal
    const enregistrerOuModifier = document.getElementById("enregistrer-modifier-mutuelle");
    const close = document.getElementById("close-mutuelle");

    // les 2 modals
    const $warningModal = $("#warning-modal");
    const $mainModal = $("#modal-mutuelle");
    const confirmclosed = document.getElementById('warning-modal-confirm');
    const refuseclosed = document.getElementById('warning-modal-refuse');
    const modalTitle = document.getElementById("modal-title-mutuelle");

    // le formulaire
    const form = document.getElementById("form-mutuelle");

    // input et select du form mutuelle
    const mutuelleNomInput = document.getElementById("mutuelle-nom");
    const mutuelleEmailInput = document.getElementById("mutuelle-email");
    const mutuelleTelProtableInput = document.getElementById("mutuelle-tel-portable");
    const mutuelleTelFixeInput = document.getElementById("mutuelle-tel-fixe");
    const mutuelleAdresseInput = document.getElementById("mutuelle-adresse");
    const mutuelleComplementAdresseInput = document.getElementById("mutuelle-complement-adresse");
    const mutuelleCodePostalInput = document.getElementById("mutuelle-code-postal");
    const mutuelleVilleInput = document.getElementById("mutuelle-ville");
    const mutuelleRequiredElems = document.getElementsByClassName("mutuelle-required");

    // les url
    let urls;

    let init = function (_urls, data) {
        urls = _urls;

        ajoutMutuelleButton.onclick = function (event) {
            event.preventDefault();
            setModalMode(MODE_MUTUELLE.ADD_MUTUELLE);
        };

        confirmclosed.addEventListener("click", function () {
            $warningModal.modal('hide');
            $mainModal.modal('hide');
        });

        trouverCPVille(urls.urlRechercheCPVille, mutuelleCodePostalInput, mutuelleVilleInput, data?.villeData);
    };


    function getFormDataMutuelle() {
        return {
            "nom": mutuelleNomInput.value,
            "mail": mutuelleEmailInput.value,
            "tel_fixe": mutuelleTelFixeInput.value,
            "tel_portable": mutuelleTelProtableInput.value,
            "nom_adresse": mutuelleAdresseInput.value,
            "complement_adresse": mutuelleComplementAdresseInput.value,
            "code_postal": mutuelleCodePostalInput.value,
            "nom_ville": mutuelleVilleInput.value
        };
    }

    function handleConfirmCloseClick() {
        $warningModal.modal('show');
    }

    function handleCreateMutuelleClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            $mainModal.modal('hide');

            // Insert dans la BDD
            fetch(urls.urlCreateMutuelle, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(getFormDataMutuelle()),
            })
                .then(response => {
                    if (!response.ok) {
                        throw {
                            statusCode: response.status,
                        };
                    }
                    return response.json()
                })
                .then(() => {
                    toast("Mutuelle ajoutée avec succes");
                    trouverMutuelle(urls.urlRechercheMutuelle);
                })
                .catch((error) => {
                    console.error(error);
                    toast("Echec de l'ajout");
                });
        }
    }

    function toast(msg) {
        // rend le toast visible
        toastDiv.className = "show";
        toastDiv.textContent = msg;

        // After 2 seconds, remove the show class from DIV
        setTimeout(function () {
            toastDiv.className = toastDiv.className.replace("show", "");
        }, 2000);
    }

    /**
     *
     * @param mode {MODE_MUTUELLE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE_MUTUELLE.ADD_MUTUELLE) {
            modalTitle.textContent = "Ajout mutuelle";
            form.reset();

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.addEventListener("click", handleCreateMutuelleClick);
            enregistrerOuModifier.textContent = "Enregistrer";
        }
    }

    return {
        init
    };
})();