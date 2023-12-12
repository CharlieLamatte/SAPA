"use strict";

// les différents modes d'interaction avec le modal
const MODE = {
    ADD: 'add',
    EDIT: 'edit',
    READONLY: 'readonly'
};
Object.freeze(MODE);

$(document).ready(function() {
    // initialisation des élements de la page
    modalObjectifs.init();
});

/**
 * Affichage du modal
 */
let modalObjectifs = (function() {
    // le bouton qui ouvre le modal
    const ajoutModalButton = document.getElementById("ObjEncadre-modal");
    // les element du modal qui peuvent être désactivés (en général tous sauf les bouton abandon, etc ...)
    const canBeDisabledElems = document.getElementsByClassName("can-disable");
    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    // boutons du modal
    const confirmclosedButton = $("#confirmclosed");
    const enregistrerOuModifier = document.getElementById("enregistrer-modifier");
    const close = document.getElementById("close");

    // les 2 modals
    const warningModal = $("#warning");
    const mainModal = $("#modal");
    const modalTitle = document.getElementById("modal-title");

    // le formulaire
    const form = document.getElementById("form-ObjEncadre");

    // input et select du form
    const ObjDate = document.getElementById("ObjDate");
    const ObjNom = document.getElementById("ObjNom");
    const ObjDesc = document.getElementById("ObjDesc");

    /**
     * Initialisation du modal
     */
    let init = function() {
        ajoutModalButton.onclick = function(event) {
            event.preventDefault();
            setModalMode(MODE.ADD);
        };

        confirmclosedButton.on("click", function() {
            warningModal.modal('hide');
            mainModal.modal('hide');
        });
    };

    function getFormData() {
        return {
            "id_objectif": form.getAttribute("data-id_objectif"),
            "ObjDate": ObjDate.value,
            "ObjNom": ObjNom.value,
            "ObjDesc": ObjDesc.value
        };
    }

    function handleConfirmCloseClick() {
        warningModal.modal('show');
    }

    function handleModifierClick(event) {
        event.preventDefault();
        setModalMode(MODE.EDIT);
    }

    function handleCreateClick() {
        form.onsubmit = function(e) {
            e.preventDefault();
            $('#modal').modal('hide');
            // Insert dans la BDD
            fetch('ObjectifsEnregistrer.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(getFormData()),
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
                    toast("Objectif ajouté avec succes");
                })
                .catch((error) => {
                    console.error('Error:', error);
                    toast("Echec de l'ajout");
                });
        }
    }

    function handleUpdateClick(event) {
        form.onsubmit = function(e) {
            e.preventDefault();
            $('#modal').modal('hide');
            const new_data = getFormData();

            // Update dans la BDD
            fetch('update.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(new_data),
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
                    toast("Objectif modifié avec succes");
                    // MAJ du tableau
                    tableauCreneau.replaceRowValues(new_data);
                })
                .catch((error) => {
                    console.error('Error:', error);
                    toast("Echec de la modification");
                });
        }
    }

    function setInfosCreneau(id_creneau) {
        fetch('RecupOneInfosCreneau.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ "id_creneau": id_creneau }),
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
                form.setAttribute("data-id_creneau", data.id_creneau);
                // pré-rempli les valeurs du formulaire
                nomInput.value = data.nom_creneau;
                typeSelect.value = data.type_creneau;
                jourSelect.value = data.jour;
                heureDebSelect.value = data.heure_debut;
                heureFinSelect.value = data.heure_fin;
                nomStructSelect.value = data.nom_structure;
                activitesSelect.value = data.activites;
                //nbParticipantSelect.value = data.nb_participant;
                publicViseInput.value = data.public_vise;
                tarifInput.value = data.tarif;
                paiementInput.value = data.paiement;
                intervenantSelect.value = data.intervenant;
            })
            .catch((error) => {
                console.error('Error recup infos créneau:', error);
            });
    }

    function toast(msg) {
        // rend le toast visible
        toastDiv.className = "show";
        toastDiv.innerHTML = msg;

        // After 2 seconds, remove the show class from DIV
        setTimeout(function() {
            toastDiv.className = toastDiv.className.replace("show", "");
        }, 2000);
    }

    function toggleChampDisabled(on) {
        if (on) {
            for (let i = 0; i < canBeDisabledElems.length; i++) {
                canBeDisabledElems[i].setAttribute("disabled", "");
            }
        } else {
            for (let i = 0; i < canBeDisabledElems.length; i++) {
                canBeDisabledElems[i].removeAttribute("disabled");
            }
        }
    }

    /**
     *
     * @param mode {MODE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE.ADD) {
            modalTitle.innerHTML = "Ajout créneau";
            form.reset();
            //is_userInput.value = "NON";
            toggleChampDisabled(false);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleCreateClick);
            enregistrerOuModifier.innerHTML = "Enregistrer";
        } else if (mode === MODE.EDIT) {
            modalTitle.innerHTML = "Détails créneaux";
            toggleChampDisabled(false);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleUpdateClick);
            enregistrerOuModifier.innerHTML = "Enregistrer";
        } else {
            // mode par défaut : MODE.READONLY
            modalTitle.innerHTML = "Détails créneaux";
            form.reset();
            toggleChampDisabled(true);

            close.setAttribute("data-dismiss", "modal");
            close.removeEventListener('click', handleConfirmCloseClick);

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.addEventListener("click", handleModifierClick);
            enregistrerOuModifier.innerHTML = "Modifier";
        }
    }

    return {
        init: init,
        setInfosCreneau: setInfosCreneau,
        setModalMode: setModalMode
    };
})();