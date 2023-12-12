"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 * moment.min.js
 */

/**
 * Affichage du modal structure
 */
let modalStructure = (function () {
    // le bouton qui ouvre le modal en mode ajout
    const ajoutModalButton = document.getElementById("ajout-modal-structure");
    // le bouton qui ouvre le modal en mode modifier
    const modifierModalButton = document.getElementById("ma-structure");
    // le bouton qui ouvre le modal en mode fusion
    const fusionModalButton = document.getElementById("fusion-modal-structure");

    // l'id_structure de l'utilisateur

    // les element du modal qui peuvent être désactivés (en général tous sauf les bouton abandon, etc ...)
    const canBeDisabledElems = document.getElementsByClassName("can-disable");
    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    const divNonPartenaire = document.getElementById("non_partenaire");

    // boutons du modal
    const confirmclosed = document.getElementById('confirmclosed');
    const refuseclosed = document.getElementById('refuseclosed');
    const enregistrerOuModifier = document.getElementById("enregistrer-modifier-structure");
    const close = document.getElementById("close-structure");

    // boutton de suppression
    const deleteButton = document.getElementById("delete-structure");

    //les 2 sections
    const sectionFusion = document.getElementById("section-fusion-structure");
    const sectionUpdateOrCreate = document.getElementById("section-update-or-create");

    // les 2 modals
    const $warningModal = $("#warning");
    const $mainModal = $("#modalStructure");
    const modalTitle = document.getElementById("modal-title-structure");
    const warningText = document.getElementById('warning-text');

    //formulaire partie fusion
    const addStructure1Input = document.getElementById("add-structure-1");
    const addStructure2Input = document.getElementById("add-structure-2");

    const nom1Input = document.getElementById("nom-structure-1");
    const adresse1Input = document.getElementById("adresse-1");
    const idStructure1Input = document.getElementById("id-structure-1");

    const nom2Input = document.getElementById("nom-structure-2");
    const adresse2Input = document.getElementById("adresse-2");
    const idStructure2Input = document.getElementById("id-structure-2");

    // le formulaire
    const form = document.getElementById("form-structure");

    // Input et Select du form
    // structure
    const id_territoireSelect = document.getElementById("id_territoire-structure");
    const codeOnapsInput = document.getElementById("code-onaps");
    const nomInput = document.getElementById("nom-structure");
    const statuts_structureSelect = document.getElementById("statuts_structure");
    const adresseInput = document.getElementById("adresse-structure");
    const complementAdresseInput = document.getElementById("complement-adresse-structure");
    const codePostalInput = document.getElementById("code-postal-structure");
    const villeInput = document.getElementById("ville-structure");
    // representant
    const representantNomInput = document.getElementById("representant-nom");
    const representantPreomInput = document.getElementById("representant-prenom");
    const telFixeInput = document.getElementById("tel-fixe");
    const telPortableInput = document.getElementById("tel-portable");
    const emailInput = document.getElementById("email");
    const statutJuridiqueSelect = document.getElementById("statut-juridique");
    // MSS
    const logoMssInput = document.getElementById("logo-mss");
    const resetLogoButton = document.getElementById("reset-logo");
    const logoImg = document.getElementById('output');

    // la partie intervenant
    const listeIntervenantDiv = document.getElementById("liste-intervenant");
    const addIntervenantInput = document.getElementById("add-intervenant");

    // la partie créneaux
    const bodyCreneaux = document.getElementById("body-creneaux");
    const creneauxFielset = document.getElementById("creneaux");

    // la partie antenne
    const listeAntenneDiv = document.getElementById("liste-antenne");
    const addAntenneInput = document.getElementById("add-antenne");
    const addAntenneButton = document.getElementById("add-antenne-button");

    // la partie lien de référencement
    const lienRefInput = document.getElementById("lien_referencement");

    // la partie maison sport santé
    const sectionMssFieldset = document.getElementById("section-mss");
    const logoLoadedMessage = document.getElementById("logo-loaded-message");

    // les urls
    let urls;

    /**
     * Initialisation du modal
     */
    let init = function (_urls, data) {
        urls = _urls;

        if (ajoutModalButton) {
            ajoutModalButton.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.ADD);
            };
        }

        if (modifierModalButton) {
            modifierModalButton.onclick = function (event) {
                event.preventDefault();
                modalStructure.setModalMode(MODE.READONLY);
                modalStructure.setInfosStructure(form.getAttribute("data-id_structure-utilisateur"));
            };
        }

        if (fusionModalButton) {
            fusionModalButton.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.FUSION);
            };
        }

        confirmclosed.addEventListener("click", function () {
            $warningModal.modal('hide');
            $mainModal.modal('hide');
        });

        trouverStructure('../Structures/ReadAllStructures.php', data?.structureData);
        trouverCPVille(urls.urlRechercheCPVille, codePostalInput, villeInput, data?.villeData);
        trouverIntervenant(urls.urlRecupInfosIntervenant);

        addAntenneInput.onkeydown = function (event) {
            if (event.code === 'Enter') {
                event.preventDefault(); // empêche de submit le form
                handleAddAntenneClick();
            }
        };

        addAntenneButton.onclick = function (event) {
            event.preventDefault();

            handleAddAntenneClick();
        }

        listeIntervenantDiv.addEventListener('click', event => {
            if (event.target.className.includes('delete-intervenant')) {
                event.target.parentElement.parentElement.remove();
            }
        });

        listeAntenneDiv.addEventListener('click', event => {
            event.preventDefault();
            const nbAntennes = document.getElementsByClassName('delete-antenne');

            // on ne peut pas supprimer une antenne si c'est la dernière qui reste
            if (event.target.className.includes('delete-antenne') && nbAntennes.length > 1) {
                event.target.parentElement.parentElement.remove();
            }
        });

        statuts_structureSelect.onchange = (event) => {
            handleStatusStructureChange();
        }

        logoMssInput.onchange = (event) => {
            let reader = new FileReader();
            reader.onload = async function () {
                if (isFileFormatValid(reader.result)) {
                    getImageDimensions(reader.result)
                        .then(res => {
                            logoImg.src = reader.result;
                            if (res.width === res.height) {
                                displayMessage("Le logo est bien carré.", "valid");
                            } else {
                                displayMessage(
                                    `Le logo n'est pas carré (${res.width}x${res.height}). Il risque de s'afficher de manière étiré.`,
                                    "warning"
                                );
                            }
                        })
                        .catch((error) => {
                            handleResetLogo();
                            displayMessage(error, "invalid");
                        });
                } else {
                    handleResetLogo();
                    displayMessage(
                        "Ce format de d'image n'est pas autorisé",
                        "invalid"
                    );
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        resetLogoButton.onclick = (event) => {
            event.preventDefault();
            handleResetLogo();
        };
    };

    function handleAddAntenneClick() {
        if (addAntenneInput.value !== '') {
            const antenne = {
                'id_antenne': '',
                'nom_antenne': addAntenneInput.value
            };

            handleAddAntenne(antenne);
            addAntenneInput.value = '';
        }
    }

    function handleStatusStructureChange() {
        if (statuts_structureSelect.value === '5') {
            toggleSectionNonPartenaireHidden(true);
        } else {
            toggleSectionNonPartenaireHidden(false);
        }
        if (statuts_structureSelect.value === '1') {
            toggleSectionMssHidden(false);
        } else {
            toggleSectionMssHidden(true);
        }

    }


    /**
     * Returns an object containing the width and height of an image
     * Example:
     *  {"width": 10, "height": 10}
     *
     * @param file
     * @returns {Promise<object|string>}
     */
    function getImageDimensions(file) {
        return new Promise(function (resolve, reject) {
            const i = new Image();
            i.onload = () => {
                resolve({width: i.width, height: i.height})
            };
            i.onerror = () => {
                reject("L'image ne s'est pas chargé correctement.");
            };
            i.src = file;
        });
    }

    function displayMessage(msg, className) {
        if (className) {
            logoLoadedMessage.className = className;
        }
        logoLoadedMessage.textContent = msg;
    }

    /**
     * Returns if the file format is valid (PNG, JPEG or JPG)
     * @param file base64 file
     */
    function isFileFormatValid(file) {
        try {
            const validFormats = ["jpg", "png", "jpeg"];
            let image_parts = file.split(";base64,");
            let image_type_aux = image_parts[0].split("/");
            let image_type = image_type_aux[1];

            return validFormats.includes(image_type);
        } catch (e) {
            return false;
        }
    }

    async function getLogo() {
        return new Promise(resolve => {
            let file = logoMssInput.files[0];
            let reader = new FileReader();
            let logo = {
                "est_present": false,
                "data": ""
            };

            if (file !== null && file !== undefined) {
                reader.readAsDataURL(file);

                reader.onload = function () {
                    logo.data = reader.result;
                    logo.est_present = true;
                    resolve(logo);
                };

                reader.onerror = function () {
                    logo.data = '';
                    logo.est_present = false;

                    resolve(logo);
                };
            } else {
                resolve(logo);
            }
        });
    }

    async function getFormData() {
        const structures = document.querySelectorAll('.intervenant-element');
        const listId = [];
        for (let i = 0; i < structures.length; i++) {
            listId.push(structures[i].getAttribute("data-id-intervenant"));
        }

        const antennes = document.querySelectorAll('.antenne-element-input');
        const listAntenne = [];
        for (let i = 0; i < antennes.length; i++) {
            listAntenne.push(
                {
                    'id_antenne': antennes[i].getAttribute("data-id-antenne"),
                    'nom_antenne': antennes[i].value
                }
            );
        }

        return {
            "id_structure": form.getAttribute("data-id_structure"),
            "nom_structure": nomInput.value,
            "id_statut_structure": statuts_structureSelect.value,
            "nom_statut_structure": statuts_structureSelect.options[statuts_structureSelect.selectedIndex].text,
            "nom_adresse": adresseInput.value,
            "complement_adresse": complementAdresseInput.value,
            "code_postal": codePostalInput.value,
            "nom_ville": villeInput.value,
            "id_territoire": id_territoireSelect.value,
            "intervenants": listId,
            "nom_representant": representantNomInput.value,
            "prenom_representant": representantPreomInput.value,
            "tel_fixe": telFixeInput.value,
            "tel_portable": telPortableInput.value,
            "email": emailInput.value,
            "id_statut_juridique": statutJuridiqueSelect.value,
            "code_onaps": codeOnapsInput.value,
            "antennes": listAntenne,
            "lien_ref_structure": lienRefInput.value,
            "id_api": '',
            "logo": await getLogo()
        };
    }

    function getFusionData() {
        return {
            "id_structure_1": idStructure1Input.value,
            "id_structure_2": idStructure2Input.value,
        };
    }

    /**
     * @param url l'url de récupération des structures
     * @param structureData les données des villes (pas de requête ne serra faite si non-null)
     */
    function trouverStructure(url, structureData = null) {
        if (structureData) {
            autocompleteStructure(addStructure1Input, structureData, 1);
            autocompleteStructure(addStructure2Input, structureData, 2);
        } else {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (reponse) {
                    autocompleteStructure(addStructure1Input, reponse, 1);
                    autocompleteStructure(addStructure2Input, reponse, 2);
                },
                error: function (res, status, err) {
                    console.error(status + status + err)
                },
                complete: function () {
                }
            });
        }
    }

    function autocompleteStructure(inp, arr, num) {
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
                if (arr[i].nom_structure.toUpperCase().substr(0, val.length) === val) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input style='width:500px;' value='" + " id: " + sanitize(arr[i].id_structure) + " - " + sanitize(arr[i].nom_structure) + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = "";
                        handleAddStructure(arr[i], num);
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

        function handleAddStructure(structure, num) {
            if (num === 1) {
                if (idStructure2Input.value != "" && idStructure2Input.value == structure.id_structure) {
                    return;
                }

                nom1Input.value = structure.nom_structure;
                adresse1Input.value = structure.nom_adresse;
                idStructure1Input.value = structure.id_structure;
            } else if (num === 2) {
                if (idStructure1Input.value != "" && idStructure1Input.value == structure.id_structure) {
                    return;
                }

                nom2Input.value = structure.nom_structure;
                adresse2Input.value = structure.nom_adresse;
                idStructure2Input.value = structure.id_structure;
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

    function createIntervenantElement(intervenant) {
        const row = document.createElement('div');
        row.className = 'row intervenant-element';
        row.setAttribute("data-id-intervenant", intervenant.id_intervenant);

        const colVide = document.createElement('div');
        colVide.className = 'col-md-1';

        const colNom = document.createElement('div');
        colNom.className = 'col-md-9';

        const input = document.createElement('input');
        input.value = intervenant.nom_intervenant + ' ' + intervenant.prenom_intervenant;
        input.className = 'form-control input-md intervenant-element-input';
        input.setAttribute("readOnly", "");

        const colDelete = document.createElement('div');
        colDelete.className = 'col-md-2';

        const deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger delete-intervenant';
        deleteButton.setAttribute("data-id-intervenant", intervenant.id_intervenant);
        deleteButton.textContent = 'Supprimer';
        if (intervenant.nb_creneau !== null && intervenant.nb_creneau !== undefined && parseInt(intervenant.nb_creneau) > 0) {
            deleteButton.setAttribute('disabled', '');
            deleteButton.setAttribute('data-title', 'Cet intervenant est chargé d\'au moins un créneau dans la structure');
            deleteButton.classList.add('tooltip-delete');
        }

        colNom.append(input);
        colDelete.append(deleteButton);
        row.append(colVide, colNom, colDelete);

        return row;
    }

    function handleAddIntervenant(intervenant) {
        const intervenants = document.querySelectorAll('.intervenant-element');

        let exist = false;
        for (let i = 0; i < intervenants.length; i++) {
            if (intervenants[i].getAttribute("data-id-intervenant") == intervenant.id_intervenant) {
                exist = true;
                break;
            }
        }

        if (!exist) {
            listeIntervenantDiv.append(createIntervenantElement(intervenant));
        }
    }

    function trouverIntervenant(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (reponse) {
                autocompleteIntervenant(addIntervenantInput, reponse);
            },
            error: function (res, status, err) {
                console.error(status + status + err)
            },
            complete: function () {
            }
        });
    }

    function autocompleteIntervenant(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        let currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function (e) {
            let a, b, i, val = this.value;
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
                const fullName = arr[i].nom_intervenant + ' ' + arr[i].prenom_intervenant;
                if (fullName.toUpperCase().substr(0, val.length) === val) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input style='width:500px;' value='" + arr[i].nom_intervenant + " " + arr[i].prenom_intervenant + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = "";
                        handleAddIntervenant(arr[i]);
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

    function handleAddAntenne(antenne) {
        const antennes = document.querySelectorAll('.antenne-element-input');

        let exist = false;
        for (let i = 0; i < antennes.length; i++) {
            if (antennes[i].value.toLowerCase() === antenne.nom_antenne.toLowerCase()) {
                exist = true;
                break;
            }
        }

        if (!exist) {
            listeAntenneDiv.append(createAntenneElement(antenne));
        }
    }

    function createAntenneElement(antenne) {
        const row = document.createElement('div');
        row.className = 'row antenne-element';
        row.setAttribute("data-id-antenne", antenne.id_antenne);

        const colVide = document.createElement('div');
        colVide.className = 'col-md-1';

        const colNom = document.createElement('div');
        colNom.className = 'col-md-9';

        const input = document.createElement('input');
        input.value = antenne.nom_antenne;
        input.className = 'form-control input-md antenne-element-input';
        input.setAttribute("data-id-antenne", antenne.id_antenne);
        input.setAttribute("pattern", ".{1,}");
        input.setAttribute("required", "");

        const colDelete = document.createElement('div');
        colDelete.className = 'col-md-2';

        const deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger delete-antenne';
        deleteButton.setAttribute("data-id-antenne", antenne.id_antenne);
        deleteButton.textContent = 'Supprimer';
        if (antenne.nb_patient !== null && antenne.nb_patient !== undefined && parseInt(antenne.nb_patient) > 0) {
            deleteButton.setAttribute('disabled', '');
            deleteButton.setAttribute('data-title', 'Au moins un patient est affecté à cette antenne');
            deleteButton.classList.add('tooltip-delete');
        }

        colNom.append(input);
        colDelete.append(deleteButton);
        row.append(colVide, colNom, colDelete);

        return row;
    }

    function handleConfirmCloseClick() {
        $warningModal.modal('show');
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
                .then(async canContinue => {
                    if (canContinue) {
                        const new_data = await getFormData();

                        // Insert dans la BDD
                        fetch(urls.urlCreateStructure, {
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
                                        message: response.json()
                                    };
                                }
                                return response.json()
                            })
                            .then(data => {
                                toast("Structure ajoutée avec succes");
                                // MAJ du tableau si présent
                                if (typeof tableauStructure !== 'undefined') {
                                    tableauStructure.addRow(data, true);
                                }
                                // MAJ du select structure du modal créneau
                                if (typeof orientation !== 'undefined' && typeof modalCreneau !== 'undefined') {
                                    modalCreneau.updateStructureSelect();
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
                .then(async canContinue => {
                    if (canContinue) {
                        const new_data = await getFormData();

                        // Update dans la BDD
                        fetch(urls.urlUpdateStructure, {
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
                                toast("Structure modifiée avec succes");
                                // MAJ du tableau si présent
                                if (typeof tableauStructure !== 'undefined') {
                                    tableauStructure.replaceRowValues(new_data);
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

    function handleFuseClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            $warningModal.modal('show');
            warningText.textContent = 'Fusionner les deux structures?';

            getConfirmation().then(is_delete => {
                $('#modal').modal('hide');

                if (is_delete) {
                    const new_data = getFusionData();

                    // Update dans la BDD
                    fetch('FuseStructure.php', {
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
                            toast("Structures fusionnées avec succès");
                            if (typeof tableauStructure !== 'undefined') {
                                tableauStructure.deleteRow(idStructure1Input.value);
                            }
                        })
                        .catch((error) => {
                            toast("Echec de la fusion. Cause:" + error?.message);
                        });
                }
            });
        }
    }

    function handleDeleteClick(event) {
        $warningModal.modal('show');
        warningText.textContent = 'Supprimer la structure?';

        event.preventDefault();

        getConfirmation().then(async is_delete => {
            $mainModal.modal('hide');

            if (is_delete) {
                const new_data = await getFormData();

                // Update dans la BDD
                fetch(urls.urlDeleteStructure, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({"id_structure": new_data.id_structure}),
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
                        toast("Structure supprimé avec succès.");
                        // MAJ du tableau si présent
                        if (typeof tableauStructure !== 'undefined') {
                            tableauStructure.deleteRow(new_data.id_structure);
                        }
                    })
                    .catch((error) => {
                        toast("Echec de la suppression. Cause:" + error?.message);
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

    /**
     * Return la durée entre 2 moments au format "HH:mm:ss" (par exemple "07:30:00" pour 7h30)
     * @param heure_debut
     * @param heure_fin
     * @returns {*}
     */
    function duree(heure_debut, heure_fin) {
        const date_debut = "01/01/2021 " + heure_debut;
        const date_fin = "01/01/2021 " + heure_fin;
        return moment.utc(moment(date_fin, "DD/MM/YYYY HH:mm:ss").diff(moment(date_debut, "DD/MM/YYYY HH:mm:ss"))).format("HH:mm");
    }

    function createCreneauTr(creneau) {
        let row = document.createElement('tr');

        let td1 = document.createElement('td');
        td1.className = "text-left";
        td1.textContent = creneau.nom_creneau;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = creneau.type_parcours

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.textContent = creneau.jour;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.textContent = moment(creneau.nom_heure_debut, "HH:mm:ss").format("HH:mm");

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.textContent = duree(creneau.nom_heure_debut, creneau.nom_heure_fin);

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.textContent = creneau.nom_coordonnees;

        row.append(td1, td2, td3, td4, td5, td6);

        return row;
    }

    function setInfosStructure(id_structure) {
        fetch(urls.urlReadOneStructure, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_structure": id_structure}),
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
                form.setAttribute("data-id_structure", data.id_structure);
                // pré-rempli les valeurs du formulaire
                id_territoireSelect.value = data.id_territoire;
                nomInput.value = data.nom_structure;
                codeOnapsInput.value = data.code_onaps;
                statuts_structureSelect.value = data.id_statut_structure;
                adresseInput.value = data.nom_adresse;
                complementAdresseInput.value = data.complement_adresse;
                codePostalInput.value = data.code_postal;
                villeInput.value = data.nom_ville;
                representantNomInput.value = data.nom_representant;
                representantPreomInput.value = data.prenom_representant;
                telFixeInput.value = data.tel_fixe;
                telPortableInput.value = data.tel_portable;
                emailInput.value = data.email;
                statutJuridiqueSelect.value = data.id_statut_juridique;
                lienRefInput.value = data.lien_ref_structure;

                // ajout de la liste des intervenants qui font partie de la structure
                if (Array.isArray(data.intervenants)) {
                    for (let i = 0; i < data.intervenants.length; i++) {
                        listeIntervenantDiv.append(createIntervenantElement(data.intervenants[i]));
                    }
                }

                try {
                    // ajout de la liste des créneaux qui font partie de la structure
                    if (Array.isArray(data.creneaux)) {
                        data.creneaux.forEach(creneau => bodyCreneaux.append(createCreneauTr(creneau)));

                        if (data.creneaux.length === 0) {
                            const emptyRow = document.createElement('tr');

                            const td = document.createElement('td');
                            td.setAttribute('colspan', '6');
                            td.textContent = 'Aucun créneau dans cette strucure.'

                            emptyRow.append(td);
                            bodyCreneaux.append(emptyRow);
                        }
                    }
                } catch (e) {
                }

                // ajout de la liste des créneaux qui font partie de la structure
                if (Array.isArray(data.antennes)) {
                    for (let i = 0; i < data.antennes.length; i++) {
                        listeAntenneDiv.append(createAntenneElement(data.antennes[i]));
                    }
                }

                // initialisation des tooltips des boutons delete
                $('.tooltip-delete').tooltip();

                // initilisation de la section MSS
                handleStatusStructureChange();

                // affichage du logo s'il est présent
                if (data.logo_fichier !== null && data.logo_fichier !== '') {
                    const logo_path = "../../Outils/DownloadLogo.php?filename="; // fichier qui permet de télecharger les logos
                    logoImg.src = logo_path + data.logo_fichier;
                }
            })
            .catch((error) => {
                //console.error('Error recup infos intervenant:', error);
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

    function toggleSectionCreneauHidden(on) {
        creneauxFielset.hidden = on;
    }

    function toggleSectionMssHidden(on) {
        sectionMssFieldset.hidden = on;
    }

    function toggleSectionNonPartenaireHidden(on) {
        if (on) {
            statutJuridiqueSelect.required = false;
            divNonPartenaire.style.display = "none";
        } else {
            divNonPartenaire.style.display = "block";
            statutJuridiqueSelect.required = true;
        }
    }

    function toggleSectionCreateOrUpdateHidden(on) {
        if (on) {
            sectionUpdateOrCreate.style.display = 'none';

            nomInput.removeAttribute('required');
            adresseInput.removeAttribute('required');
            codePostalInput.removeAttribute('required');
        } else {
            sectionUpdateOrCreate.style.display = 'block';

            nomInput.setAttribute('required', '');
            adresseInput.setAttribute('required', '');
            codePostalInput.setAttribute('required', '');
        }
    }

    function toggleSectionFusionHidden(on) {
        if (on) {
            sectionFusion.style.display = 'none';

            nom1Input.removeAttribute('required');
            adresse1Input.removeAttribute('required');
            nom2Input.removeAttribute('required');
            adresse2Input.removeAttribute('required');
        } else {
            sectionFusion.style.display = 'block';

            nom1Input.setAttribute('required', '');
            adresse1Input.setAttribute('required', '');
            nom2Input.setAttribute('required', '');
            adresse2Input.setAttribute('required', '');
        }
    }

    function toggleDeleteButtonHidden(on) {
        if (on) {
            deleteButton.style.display = 'none';
        } else {
            deleteButton.style.display = 'block';
        }
    }

    function removeChildren(elem) {
        while (elem.firstChild) {
            elem.firstChild.remove();
        }
    }

    function resetForm() {
        form.reset();

        removeChildren(listeIntervenantDiv);
        removeChildren(listeAntenneDiv);
        removeChildren(bodyCreneaux);

        handleResetLogo();
    }

    function handleResetLogo() {
        logoMssInput.value = null;
        logoImg.src = "";
    }

    /**
     *
     * @param mode {MODE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE.ADD) {
            modalTitle.textContent = "Ajout structure";
            warningText.textContent = 'Quitter sans enregistrer?';
            resetForm();
            handleStatusStructureChange();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleSectionCreateOrUpdateHidden(false);
            toggleSectionCreneauHidden(true);
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
            statuts_structureSelect.addEventListener("change", handleStatusStructureChange);

            enregistrerOuModifier.textContent = "Enregistrer";
        } else if (mode === MODE.EDIT) {
            modalTitle.textContent = "Détails structure";
            warningText.textContent = 'Quitter sans enregistrer?';
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleSectionCreneauHidden(false);
            toggleSectionCreateOrUpdateHidden(false);
            toggleSectionFusionHidden(true);

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
            statuts_structureSelect.addEventListener("change", handleStatusStructureChange);

            enregistrerOuModifier.textContent = "Enregistrer";
        } else if (mode === MODE.FUSION) {
            modalTitle.textContent = "Fusionner deux structures";
            warningText.textContent = 'Quitter sans enregistrer?';
            resetForm();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleSectionCreneauHidden(true);
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
            modalTitle.textContent = "Détails structure";
            warningText.textContent = 'Quitter sans enregistrer?';
            resetForm();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(true);
            toggleSectionCreneauHidden(false);
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
            statuts_structureSelect.addEventListener("change", handleStatusStructureChange);

            enregistrerOuModifier.textContent = "Modifier";
        }
    }

    return {
        init,
        setInfosStructure,
        setModalMode
    };
})();