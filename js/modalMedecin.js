"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 */

// les différents modes d'interaction avec le modal
const MODE = {
    ADD_MEDECIN: 'add_medecin',
    ADD_AUTRE_PROFESSIONNEL: 'add_autre_professionnel',
    EDIT: 'edit',
    READONLY: 'readonly',
    FUSION: 'fusion'
};
Object.freeze(MODE);

/**
 * Affichage détails d'un médecin
 */
let modalMedecin = (function () {
    // le bouton qui ouvre le modal
    const ajoutModalButton = document.getElementById("ajout-modal");
    const ajoutMedecinsButtons = document.getElementsByClassName("ajout-medecins");
    const ajoutAutreProfessionnelButtons = document.getElementsByClassName("ajout-autre-professionnel");

    // les element du modal qui peuvent être désactivés (en général tous sauf les bouton abandon, etc ...)
    const canBeDisabledElems = document.getElementsByClassName("can-disable");
    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");
    //bouton d'ouverture du modal de fusion
    const fusionModalButton = document.getElementById("fusion-modal-professionnel");

    // boutons du modal
    //const confirmclosedButton = $("#confirmclosed");
    const warningModalConfirmButton = document.getElementById('warning-modal-confirm');
    const warningModalRefuseButton = document.getElementById('warning-modal-refuse');

    const enregistrerOuModifier = document.getElementById("enregistrer-modifier");
    const close = document.getElementById("close");

    // les 2 modals
    const $warningModal = $("#warning-modal");
    const $mainModal = $("#modal");
    const modalTitle = document.getElementById("modal-title");
    const warningModalText = document.getElementById('warning-modal-text');

    // boutton de suppression
    const deleteButton = document.getElementById("delete");

    //les 2 sections
    const createOrUpdateSection = document.getElementById("medecin-div");
    const sectionFusion = document.getElementById("section-fusion-medecin");

    // le formulaire
    const form = document.getElementById("form-medecin");

    //formulaire partie fusion
    const addMedecin1Input = document.getElementById("add-medecin-1");
    const addMedecin2Input = document.getElementById("add-medecin-2");

    const nom1Input = document.getElementById("nom-medecin1");
    const prenom1Input = document.getElementById("prenom-medecin1");
    const idMedecin1Input = document.getElementById("id-medecin-1");

    const nom2Input = document.getElementById("nom-medecin2");
    const prenom2Input = document.getElementById("prenom-medecin2");
    const idMedecin2Input = document.getElementById("id-medecin-2");

    // input et select du form
    const nomInput = document.getElementById("nom");
    const prenomInput = document.getElementById("prenom");
    const emailInput = document.getElementById("email");
    const telProtableInput = document.getElementById("tel-portable");
    const telFixeInput = document.getElementById("tel-fixe");
    const specialiteSelect = document.getElementById("specialite");
    const lieuSelect = document.getElementById("lieu");
    const posteInput = document.getElementById("poste");
    const id_territoireSelect = document.getElementById("id_territoire");
    const adresseInput = document.getElementById("adresse");
    const complementAdresseInput = document.getElementById("complement-adresse");
    const codePostalInput = document.getElementById("code-postal");
    const villeInput = document.getElementById("ville");

    // les urls
    let urls;

    let init = function (_urls, data) {
        urls = _urls;

        if (ajoutModalButton) {
            ajoutModalButton.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.ADD_MEDECIN);
            };
        }

        for (const button of ajoutMedecinsButtons) {
            button.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.ADD_MEDECIN);
            };
        }

        for (const button of ajoutAutreProfessionnelButtons) {
            button.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.ADD_AUTRE_PROFESSIONNEL);
            };
        }

        warningModalConfirmButton.addEventListener("click", function () {
            $warningModal.modal('hide');
            $mainModal.modal('hide');
        });

        if (fusionModalButton) {
            fusionModalButton.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.FUSION);
            };
        }

        trouverMedecin(urls.urlRecupInfosMedecin, data?.medecinData);
        trouverCPVille(urls.urlRechercheCPVille, codePostalInput, villeInput, data?.villeData);
    };

    function getFormData() {
        return {
            "id_medecin": form.getAttribute("data-id_medecin"),
            "nom_coordonnees": nomInput.value,
            "prenom_coordonnees": prenomInput.value,
            "mail_coordonnees": emailInput.value,
            "tel_fixe_coordonnees": telFixeInput.value,
            "tel_portable_coordonnees": telProtableInput.value,
            "id_territoire": id_territoireSelect.value,
            "poste_medecin": posteInput.value,
            "id_specialite_medecin": specialiteSelect.value,
            "nom_specialite_medecin": specialiteSelect.options[specialiteSelect.selectedIndex].text,
            "id_lieu_pratique": lieuSelect.value,
            "nom_lieu_pratique": lieuSelect.options[lieuSelect.selectedIndex].text,
            "nom_adresse": adresseInput.value,
            "complement_adresse": complementAdresseInput.value,
            "code_postal": codePostalInput.value,
            "nom_ville": villeInput.value
        };
    }

    function getFusionData() {
        return {
            "id_medecin_1": idMedecin1Input.value,
            "id_medecin_2": idMedecin2Input.value,
        };
    }

    /**
     *
     * @param url l'url de récupération des médecins
     * @param medecinData les données des médecins (pas de requête ne serra faite si non-null)
     */
    function trouverMedecin(url, medecinData = null) {
        if (medecinData) {
            autocompleteMedecin(addMedecin1Input, medecinData, 1);
            autocompleteMedecin(addMedecin2Input, medecinData, 2);
        } else {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (reponse) {
                    autocompleteMedecin(addMedecin1Input, reponse, 1);
                    autocompleteMedecin(addMedecin2Input, reponse, 2);
                },
                error: function (res, status, err) {
                    console.error(status + status + err)
                },
                complete: function () {
                }
            });
        }
    }

    function autocompleteMedecin(inp, arr, num) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        let currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function (e) {
            const val = this.value.toUpperCase();
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            const a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (let i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].nom_coordonnees.toUpperCase().substring(0, val.length) === val) {
                    /*create a DIV element for each matching element:*/
                    const b = document.createElement("DIV");
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input style='width:500px;' value='" + " id: " + sanitize(arr[i].id_medecin) + " - " + sanitize(arr[i].nom_coordonnees) + " " + sanitize(arr[i].prenom_coordonnees) + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = "";
                        handleAddMedecin(arr[i], num);
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

        function handleAddMedecin(medecin, num) {
            if (num === 1) {
                if (idMedecin2Input.value != "" && idMedecin2Input.value == medecin.id_medecin) {
                    return;
                }

                nom1Input.value = medecin.nom_coordonnees;
                prenom1Input.value = medecin.prenom_coordonnees;
                idMedecin1Input.value = medecin.id_medecin;
            } else if (num === 2) {
                if (idMedecin1Input.value != "" && idMedecin1Input.value == medecin.id_medecin) {
                    return;
                }

                nom2Input.value = medecin.nom_coordonnees;
                prenom2Input.value = medecin.prenom_coordonnees;
                idMedecin2Input.value = medecin.id_medecin;
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

    function handleConfirmCloseClick() {
        getConfirmation('Quitter sans enregistrer?');
    }

    function handleModifierClick(event) {
        event.preventDefault();
        setModalMode(MODE.EDIT);
    }

    function handleCreateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            $mainModal.modal('hide');

            lockForm(form)
                .then(canContinue => {
                    if (canContinue) {
                        // Insert dans la BDD
                        fetch(urls.urlCreateMedecin, {
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
                                toast("Médecin ajouté avec succes");
                                if (typeof tableauMedecin !== 'undefined') {
                                    tableauMedecin.addRow(data, true);
                                }
                                // si on est sur la page d'ajout d'un patient
                                if (document.getElementById("choix_prescrip") &&
                                    document.getElementById("choix_traitant")) {
                                    trouverMedecinPrescripteur(urls.urlRecupInfosMedecin);
                                    trouverMedecinTraitant(urls.urlRecupInfosMedecin);
                                }
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                toast("Echec de l'ajout");
                            });
                    }
                });
        }
    }

    function handleUpdateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            $mainModal.modal('hide');

            lockForm(form)
                .then(canContinue => {
                    if (canContinue) {
                        const new_data = getFormData();

                        // Update dans la BDD
                        fetch(urls.urlUpdateMedecin, {
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
                            .then(() => {
                                toast("Médecin modifié avec succes");
                                if (typeof tableauMedecin !== 'undefined') {
                                    tableauMedecin.replaceRowValues(new_data);
                                }
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                toast("Echec de la modification");
                            });

                    }
                });
        }
    }

    function handleDeleteClick(event) {
        event.preventDefault();

        getConfirmation('Supprimer le médecin?').then(is_delete => {
            $mainModal.modal('hide');

            if (is_delete) {
                const new_data = getFormData();

                // Update dans la BDD
                fetch(urls.urlDeleteMedecin, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({"id_medecin": new_data.id_medecin}),
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
                        toast("Médecin supprimé avec succès.");
                        if (typeof tableauMedecin !== 'undefined') {
                            tableauMedecin.deleteRow(new_data.id_medecin);
                        }
                    })
                    .catch((error) => {
                        if (error?.message) {
                            alert(error?.message);
                        } else {
                            alert("Échec de l'ajout. Cause: erreur inconnue");
                        }
                    });
            }
        });
    }

    function handleFuseClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            getConfirmation('Fusionner les deux médecins?').then(is_delete => {
                $mainModal.modal('hide');

                if (is_delete) {
                    const new_data = getFusionData();

                    // Update dans la BDD
                    fetch(urls.urlFuseMedecin, {
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
                            toast("Médecins fusionnés avec succès");
                            if (typeof tableauMedecin !== 'undefined') {
                                tableauMedecin.deleteRow(idMedecin1Input.value);
                            }
                        })
                        .catch((error) => {
                            toast("Echec de la fusion. Cause:" + error?.message);
                        });
                }
            });
        }
    }

    async function getConfirmation(txt) {
        warningModalText.textContent = txt;
        $warningModal.modal('show');

        return new Promise((resolve => {
            warningModalConfirmButton.onclick = () => {
                $warningModal.modal('hide');
                resolve(true);
            };

            warningModalRefuseButton.onclick = () => {
                $warningModal.modal('hide');
                resolve(false);
            };
        }));
    }

    function setInfosMededin(id_medecin) {
        fetch(urls.urlRecupOneInfosMedecin, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_medecin": id_medecin}),
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
                // mettre la valeur de id_medecin
                form.setAttribute("data-id_medecin", data.id_medecin);
                // pré-rempli les valeurs du formulaire
                nomInput.value = data.nom_coordonnees;
                prenomInput.value = data.prenom_coordonnees;
                emailInput.value = data.mail_coordonnees;
                telFixeInput.value = data.tel_fixe_coordonnees;
                telProtableInput.value = data.tel_portable_coordonnees;
                id_territoireSelect.value = data.id_territoire;
                specialiteSelect.value = data.id_specialite_medecin;
                lieuSelect.value = data.id_lieu_pratique;
                posteInput.value = data.poste_medecin;
                adresseInput.value = data.nom_adresse;
                complementAdresseInput.value = data.complement_adresse;
                codePostalInput.value = data.code_postal;
                villeInput.value = data.nom_ville;
            })
            .catch((error) => {
                //console.error('Error recupr infos medecin:', error);
            });
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

    function toggleDeleteButtonHidden(on) {
        if (on) {
            deleteButton.style.display = 'none';
        } else {
            deleteButton.style.display = 'block';
        }
    }

    function toggleSectionCreateOrUpdateHidden(on) {
        if (on) {
            createOrUpdateSection.style.display = 'none';

            nomInput.removeAttribute('required');
            prenomInput.removeAttribute('required');
            telFixeInput.removeAttribute('required');
            adresseInput.removeAttribute('required');
            codePostalInput.removeAttribute('required');
            villeInput.removeAttribute('required');
            posteInput.removeAttribute('required');
            specialiteSelect.removeAttribute('required');
            lieuSelect.removeAttribute('required');
        } else {
            createOrUpdateSection.style.display = 'block';

            nomInput.setAttribute('required', '');
            prenomInput.setAttribute('required', '');
            telFixeInput.setAttribute('required', '');
            adresseInput.setAttribute('required', '');
            codePostalInput.setAttribute('required', '');
            villeInput.setAttribute('required', '');
            posteInput.setAttribute('required', '');
            specialiteSelect.setAttribute('required', '');
            lieuSelect.setAttribute('required', '');
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

    /**
     *
     * @param mode {MODE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE.ADD_MEDECIN) {
            modalTitle.textContent = "Ajout professionnel de santé";
            form.reset();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            posteInput.value = "Médecin";
            toggleChampDisabled(false);
            toggleSectionCreateOrUpdateHidden(false);
            toggleSectionFusionHidden(true);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleFuseClick);
            if (deleteButton) {
                deleteButton.removeEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(true);
            }

            enregistrerOuModifier.textContent = "Enregistrer";
        } else if (mode === MODE.ADD_AUTRE_PROFESSIONNEL) {
            modalTitle.textContent = "Ajout autre professionnel de santé";
            form.reset();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            posteInput.value = "";
            toggleChampDisabled(false);
            toggleSectionCreateOrUpdateHidden(false);
            toggleSectionFusionHidden(true);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleFuseClick);
            if (deleteButton) {
                deleteButton.removeEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(true);
            }

            enregistrerOuModifier.textContent = "Enregistrer";
        } else if (mode === MODE.EDIT) {
            modalTitle.textContent = "Détails médecin";
            toggleChampDisabled(false);
            toggleSectionCreateOrUpdateHidden(false);
            toggleSectionFusionHidden(true);
            unlockForm(form); // autorise l'envoie de données par le formulaire

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleFuseClick);
            if (deleteButton) {
                deleteButton.addEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(false);
            }

            enregistrerOuModifier.textContent = "Enregistrer";
        } else if (mode === MODE.FUSION) {
            modalTitle.textContent = "Fusionner deux médecins";
            form.reset();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleSectionCreateOrUpdateHidden(true);
            toggleSectionFusionHidden(false);

            // message de confirmation si on quitte le modal
            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.addEventListener("click", handleFuseClick);
            if (deleteButton) {
                toggleDeleteButtonHidden(true);
            }

            enregistrerOuModifier.textContent = "Fusionner";
        } else {
            // mode par défaut : MODE.READONLY
            modalTitle.textContent = "Détails médecin";
            form.reset();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(true);
            toggleSectionCreateOrUpdateHidden(false);
            toggleSectionFusionHidden(true);

            close.setAttribute("data-dismiss", "modal");
            close.removeEventListener('click', handleConfirmCloseClick);

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.addEventListener("click", handleModifierClick);
            enregistrerOuModifier.removeEventListener("click", handleFuseClick);
            if (deleteButton) {
                deleteButton.addEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(false);
            }

            enregistrerOuModifier.textContent = "Modifier";
        }
    }

    return {
        init,
        setInfosMededin,
        setModalMode
    };
})();