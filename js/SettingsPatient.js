"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 */

// les différents modes d'interaction avec le modal
const MODE = {
    FUSION: 'fusion',
    SUPPRESSION: 'suppression'
};
Object.freeze(MODE);

$(document).ready(function () {
    // initialisation des élements de la page
    modalPatient.init();
});

/**
 * Affichage du modal patient
 */
let modalPatient = (function () {
    // le bouton qui ouvre le modal de fusion
    const fusionModalButton = document.getElementById("fusion-modal-patient");
    //le bouton qui ouvre le modal de suppression
    const supprModalButton = document.getElementById("suppr-modal-patient");
    // les element du modal qui peuvent être désactivés (en général tous sauf les bouton abandon, etc ...)
    const canBeDisabledElems = document.getElementsByClassName("can-disable");
    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    // boutons du modal
    //const confirmclosedButton = $("#confirmclosed");
    const confirmclosed = document.getElementById('confirmclosed');
    const refuseclosed = document.getElementById('refuseclosed');
    const enregistrerOuModifier = document.getElementById("enregistrer-modifier");
    const close = document.getElementById("close");

    // les 2 modals
    const warningModal = $("#warning");
    const mainModal = $("#modal");
    const modalTitle = document.getElementById("modal-title");
    const warningText = document.getElementById('warning-text');

    // le formulaire
    const form = document.getElementById("form-patient");

    // les 2 sections
    const sectionFusion = document.getElementById("section-fusion-patient");
    const sectionSuppr = document.getElementById("section-suppr-patient");

    // form partie fusion
    const addPatient1Input = document.getElementById("add-patient-1");
    const addPatient2Input = document.getElementById("add-patient-2");
    const addPatientInput = document.getElementById("add-patient");

    const nom1Input = document.getElementById("nom-1");
    const prenom1Input = document.getElementById("prenom-1");
    const idPatient1Input = document.getElementById("id-patient-1");

    const nom2Input = document.getElementById("nom-2");
    const prenom2Input = document.getElementById("prenom-2");
    const idPatient2Input = document.getElementById("id-patient-2");

    const nomInput = document.getElementById("nom");
    const prenomInput = document.getElementById("prenom");
    const idPatientInput = document.getElementById("id-patient");

    /**
     * Initialisation du modal
     */
    let init = function () {
        if (fusionModalButton) {
            fusionModalButton.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.FUSION);
            };
        }
        if (supprModalButton) {
            supprModalButton.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.SUPPRESSION);
            }
        }

        confirmclosed.addEventListener("click", function () {
            warningModal.modal('hide');
            mainModal.modal('hide');
        });

        trouverPatient('ReadAllPatientsBasic.php')
    };

    function getFormData() {
        return {
            "id_patient_1": idPatient1Input.value,
            "id_patient_2": idPatient2Input.value,
            "id_patient": idPatientInput.value
        };
    }

    function trouverPatient(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (reponse) {
                autocompletePatient(addPatient1Input, reponse, 1);
                autocompletePatient(addPatient2Input, reponse, 2);
                autocompletePatient(addPatientInput, reponse, 3);
            },
            error: function (res, status, err) {
                console.error(status + status + err)
            },
            complete: function () {
            }
        });
    }

    function autocompletePatient(inp, arr, num) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        let currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function (e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (let i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                val = val.toUpperCase();
                if (arr[i].nom_naissance.toUpperCase().substr(0, val.length) === val) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input style='width:500px;' value='" + " id:" + sanitize(arr[i].id_patient) + " " + sanitize(arr[i].nom_naissance) + " " + sanitize(arr[i].premier_prenom_naissance) + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = "";
                        handleAddPatient(arr[i], num);
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function (e) {
            let x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode === 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode === 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode === 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (let i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            let x = document.getElementsByClassName("autocomplete-items");
            for (let i = 0; i < x.length; i++) {
                if (elmnt !== x[i] && elmnt !== inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }

        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    function handleAddPatient(patient, num) {
        if (num === 1) {
            if (idPatient2Input.value != "" && idPatient2Input.value == patient.id_patient) {
                return;
            }

            nom1Input.value = patient.nom_naissance;
            prenom1Input.value = patient.premier_prenom_naissance;
            idPatient1Input.value = patient.id_patient;
        } else if (num === 2) {
            if (idPatient1Input.value != "" && idPatient1Input.value == patient.id_patient) {
                return;
            }

            nom2Input.value = patient.nom_naissance;
            prenom2Input.value = patient.premier_prenom_naissance;
            idPatient2Input.value = patient.id_patient;
        } else if (num === 3) {
            if (idPatientInput.value != "" && idPatientInput.value == patient.id_patient) {
                return;
            }

            nomInput.value = patient.nom_naissance;
            prenomInput.value = patient.premier_prenom_naissance;
            idPatientInput.value = patient.id_patient;
        }
    }

    function handleConfirmCloseClick() {
        warningModal.modal('show');
    }

    function handleFuseClick(event) {
        form.onsubmit = function (e) {
            e.preventDefault();
            warningModal.modal('show');
            warningText.textContent = 'Fusionner les deux bénéficiaires?';

            getConfirmation().then(is_delete => {
                $('#modal').modal('hide');

                if (is_delete) {
                    const new_data = getFormData();

                    // Update dans la BDD
                    fetch('FusePatients.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(new_data),
                    })
                        .then(async response => {
                            if (!response.ok) {
                                let json = '';
                                try {
                                    json = await response.json();
                                } catch (e) {
                                }

                                throw {
                                    statusCode: response.status,
                                    message: json?.message
                                };
                            }
                            return response.json()
                        })
                        .then(() => {
                            toast("Bénéficiaires fusionnés avec succès");
                            // TODO maj du tableau
                        })
                        .catch((error) => {
                            toast("Echec de la fusion. Cause:" + error?.message);
                        });
                }
            });
        }
    }

    function handleDeleteClick(event) {
        warningModal.modal('show');
        warningText.textContent = 'Supprimer le bénéficiaire ?';

        event.preventDefault();

        getConfirmation().then(is_delete => {
            $('#modal').modal('hide');

            if (is_delete) {
                const new_data = getFormData();

                // Update dans la BDD
                fetch('DeletePatient.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({"id_patient": new_data.id_patient}),
                })
                    .then(async response => {
                        if (!response.ok) {
                            let json = '';
                            try {
                                json = await response.json();
                            } catch (e) {
                            }
                            throw {
                                statusCode: response.status,
                                message: json?.message
                            };
                        }
                        return response.json()
                    })
                    .then(() => {
                        toast("Bénéficiaire supprimé avec succès.");
                    })
                    .catch((error) => {
                        toast("Echec de la suppression. Cause: " + error?.message);
                    });
            }
        });
    }

    async function getConfirmation() {
        return new Promise((resolve => {
            confirmclosed.onclick = () => {
                resolve(true);
            };

            refuseclosed.onclick = () => {
                resolve(false);
            };
        }));
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

    function toggleSectionFusionHidden(on) {
        if (on) {
            sectionFusion.style.display = 'none';

            nom1Input.removeAttribute('required');
            prenom1Input.removeAttribute('required');
            nom2Input.removeAttribute('required');
            prenom2Input.removeAttribute('required');
        } else {
            sectionFusion.style.display = 'block';

            nom1Input.setAttribute('required', '');
            prenom1Input.setAttribute('required', '');
            nom2Input.setAttribute('required', '');
            prenom2Input.setAttribute('required', '');
        }
    }

    function toggleSectionSuppressionHidden(on) {
        if (on) {
            sectionSuppr.style.display = 'none';

            nomInput.removeAttribute('required');
            prenomInput.removeAttribute('required');
        } else {
            sectionSuppr.style.display = 'block';

            nomInput.setAttribute('required', '');
            prenomInput.setAttribute('required', '');
        }
    }

    function resetForm() {
        form.reset();
    }

    /**
     *
     * @param mode {MODE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE.FUSION) {
            modalTitle.textContent = "Fusionner deux bénéficiaires";
            warningText.textContent = 'Quitter sans enregistrer ?';
            resetForm();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleSectionFusionHidden(false);
            toggleSectionSuppressionHidden(true);

            // message de confirmation si on quitte le modal
            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.addEventListener("click", handleFuseClick);
            enregistrerOuModifier.removeEventListener("click", handleDeleteClick);

            enregistrerOuModifier.textContent = "Fusionner";
        }
        if (mode === MODE.SUPPRESSION) {
            modalTitle.textContent = "Supprimer un bénéficiaire";
            warningText.textContent = 'Quitter sans enregistrer ?';
            resetForm();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleSectionFusionHidden(true);
            toggleSectionSuppressionHidden(false);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.addEventListener("click", handleDeleteClick);
            enregistrerOuModifier.removeEventListener("click", handleFuseClick);

            enregistrerOuModifier.textContent = "Supprimer";
        }
    }

    return {
        init,
        setModalMode
    };
})();