// les pages où peuvent être situés le modalUser
const PAGE_NAME = {
    SETTINGS: 'settings',
    LISTE_USER: 'liste_user',
};
Object.freeze(PAGE_NAME);

/**
 * Affichage d'un user ans un modal
 */
let modalUser = (function () {
    // le bouton qui ouvre le modal
    const ajoutModalButton = document.getElementById("ajout-modal");
    // le bouton qui ouvre le modal en mode modifier
    const modifierModalButton = document.getElementById("mon-compte");

    // les element du modal qui peuvent être désactivés (en général tous sauf les bouton abandon, etc ...)
    const canBeDisabledElems = document.getElementsByClassName("can-disable");
    // le fieldset qui contient les données pro
    const donneesProFieldset = document.getElementById("donnees-pro");
    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    // boutons du modal
    const confirmclosed = document.getElementById('confirmclosed');
    const refuseclosed = document.getElementById('refuseclosed');
    const $confirmclosedButton = $("#confirmclosed");
    const enregistrerOuModifier = document.getElementById("enregistrer-modifier-user");
    const close = document.getElementById("close-user");

    //bouton de suppression
    const deleteButton = document.getElementById("delete-user");

    // les 2 modals
    const $warningModal = $("#warning");
    const $mainModal = $("#modal-user");
    const modalTitle = document.getElementById("modal-title-user");
    const warningText = document.getElementById('warning-text');

    // le formulaire
    const form = document.getElementById("form-user");

    // la page où est localisé le modal
    const page = document.getElementById("main-div").getAttribute('data-page');

    // input et select du form
    const nomInput = document.getElementById("nom-user");
    const prenomInput = document.getElementById("prenom-user");
    const emailInput = document.getElementById("email-user");
    const telProtableInput = document.getElementById("tel-portable-user");
    const telFixeInput = document.getElementById("tel-fixe-user");
    const statutSelect = document.getElementById("statut-user");
    const estCoordinateurCheckbox = document.getElementById("est_coordinateur_peps");
    const $roleMultiselect = $('#role_user_ids');
    const numero_carteInput = document.getElementById("numero_carte-user");
    const id_territoireSelect = document.getElementById("id_territoire-user");
    const mdpInput = document.getElementById("mdp");
    const confirmMdpInput = document.getElementById("confirm-mdp");
    const modifMdpCheckbox = document.getElementById("modif-mdp-checkbox");
    const twoPasswords = document.getElementById("2-passwords");
    const isDeactivatedCheckbox = document.getElementById("is_deactivated");
    // les diplômes
    const listeDiplomeDiv = document.getElementById("liste-diplome-user");
    const addDiplomeButton = document.getElementById("add-diplome-user");
    const diplomeSelect = document.getElementById("diplome-user");

    // fonction du superviseur PEPS
    const nomFonction = document.getElementById("nom-fonction");

    // structure de l'utilisateur
    const statutStructureInput = document.getElementById("statuts_structure-user");
    const nomStructureInput = document.getElementById("nom-structure-user");
    const adresseInput = document.getElementById("adresse-user");
    const complementAdresseInput = document.getElementById("complement-adresse-user");
    const codePostalInput = document.getElementById("code-postal-user");
    const villeInput = document.getElementById("ville-user");

    //section parametres personnels
    const nombreElementsTableauxSelect = document.getElementById('nombre_elements_tableaux');

    const $demandeModifMdpRow = $("#demande-modif-mdp");
    const $mdpRow = $("#mdp-row");

    const messageDiv = document.getElementById("message");
    const mdpShow = document.getElementById("mdp-show");
    const confirmMdpShow = document.getElementById("confirm-mdp-show");

    const id_structure = localStorage.getItem('id_structure');
    const roles_user = JSON.parse(localStorage.getItem('roles_user'));

    // form utilisé pour stocker les données d'un intervenant existant
    const create_intervenant_form = document.getElementById("create_intervenant");

    // les urls
    let urls;

    let init = function (_urls, data) {
        urls = _urls;

        // init multiselect
        $roleMultiselect.multiselect({
            nonSelectedText: 'Aucun sélectionné',
            nSelectedText: 'sélectionnés',
            allSelectedText: 'Tous sélectionnés',
            buttonWidth: '100%',
            onChange: function (option, checked) {
                const role_user_ids = getFormData().role_user_ids;

                if (role_user_ids.length > 2) {
                    $roleMultiselect.multiselect('deselect', option.val());
                    alert("Il n'est pas possible de choisir plus de 2 rôles pour un utilisateur");
                }

                if (role_user_ids.length === 2) {
                    // les rôles authorisés sont:
                    // intervenant + coordinateur
                    // intervenant + responsable structure
                    // intervenant + évaluateur
                    const allowed_roles_combinations = [
                        ["2", "3"],
                        ["3", "6"],
                        ["3", "5"],
                    ];

                    let is_allowed = false;
                    for (const combination of allowed_roles_combinations) {
                        if (arraysEqual(combination, role_user_ids.sort())) {
                            is_allowed = true;
                            break;
                        }
                    }

                    if (!is_allowed) {
                        $roleMultiselect.multiselect('deselect', option.val());
                        alert("Cette combinaison de rôle n'est pas authorisée");
                    }
                }

                handleRoleUserChange();
            },
        });

        if (ajoutModalButton) {
            ajoutModalButton.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.ADD);
            };
        }

        if (modifierModalButton) {
            modifierModalButton.onclick = function (event) {
                event.preventDefault();
                modalUser.setInfosUser(form.getAttribute("data-id_user-mon-compte"));
                modalUser.setModalMode(MODE.READONLY);
            };
        }

        $confirmclosedButton.on("click", function () {
            $warningModal.modal('hide');
            $mainModal.modal('hide');
        });

        trouverStructure(urls.urlRechercheStructure, data?.structureData);

        modifMdpCheckbox.onchange = function (event) {
            if (modifMdpCheckbox.checked) {
                toggleMdpDisabled(false);
            } else {
                toggleMdpDisabled(true);
            }
        };

        // affichage du message de selon valeur des input
        confirmMdpInput.onkeyup = validationMdpMessage;
        mdpInput.onkeyup = validationMdpMessage;

        // affiche la div message
        confirmMdpInput.onfocus = showMessageDiv;
        mdpInput.onfocus = showMessageDiv;

        // cacher la div message si on est pas focus sur l'input mdpInput ou confirmMdpInput
        confirmMdpInput.onblur = function () {
            if (document.activeElement !== mdpInput) {
                document.getElementById("message").style.display = "none";
            }
        }
        mdpInput.onblur = function () {
            if (document.activeElement !== confirmMdpInput) {
                document.getElementById("message").style.display = "none";
            }
        }

        // met le champ en password lisible/illisible
        mdpShow.onclick = () => {
            togglePasswordVisible(mdpInput);
        };
        confirmMdpShow.onclick = () => {
            togglePasswordVisible(confirmMdpInput);
        };

        // click sur le bouton d'ajout d'un diplôme
        addDiplomeButton.addEventListener('click', event => {
            event.preventDefault();
            const diplome = {
                'id_diplome': diplomeSelect.value,
                'nom_diplome': diplomeSelect.options[diplomeSelect.selectedIndex].text
            };
            handleAddDiplome(diplome);
        });

        // click sur un bouton de suppression d'un diplôme
        listeDiplomeDiv.addEventListener('click', event => {
            if (event.target.className.includes('delete')) {
                event.target.parentElement.parentElement.remove();
            }
        });

        // initialisation
        // if (role_user === ROLE.COORDONNATEUR_NON_MSS) {
        //     toggleStructureReadonly(true);
        // }

        // si on le form existe, c'est qu'on a reçu les données d'un intervenant
        // et qu'on doit ouvrir le modal avec les données préremplies
        if (create_intervenant_form) {
            fetch(urls.urlReadAllDiplomes, {
                method: 'POST',
            }).then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            }).then(allDiplomes => {
                ajoutModalButton.click();

                form.setAttribute("data-id_intervenant", document.getElementsByName('post_id_intervenant')[0].value);
                // pré-rempli les valeurs du formulaire
                nomInput.value = document.getElementsByName('post_nom_intervenant')[0].value;
                prenomInput.value = document.getElementsByName('post_prenom_intervenant')[0].value;
                emailInput.value = document.getElementsByName('post_mail_intervenant')[0].value;
                telFixeInput.value = document.getElementsByName('post_tel_fixe_intervenant')[0].value;
                telProtableInput.value = document.getElementsByName('post_tel_portable_intervenant')[0].value;
                id_territoireSelect.value = document.getElementsByName('post_id_territoire')[0].value;
                statutSelect.value = document.getElementsByName('post_id_statut_intervenant')[0].value;
                numero_carteInput.value = document.getElementsByName('post_numero_carte')[0].value;
                $roleMultiselect.multiselect('select', "3");
                $roleMultiselect.multiselect('disable');

                const diplomeNodes = document.getElementsByName('post_diplomes[]');
                // ajout de la liste des diplômes de l'intervenant
                diplomeNodes.forEach(input => {
                        const diplome = {
                            'id_diplome': input.value,
                            'nom_diplome': findDiplomeName(allDiplomes, input.value)
                        };
                        listeDiplomeDiv.append(createDiplomeElement(diplome));
                    }
                );

                handleRoleUserChange();
            }).catch(() => toast("Erreur de récupération des données de l'intervenant"));
        }
    };

    function findDiplomeName(array, id) {
        for (let diplome of array) {
            if (diplome.id_diplome == id) {
                return diplome.nom_diplome;
            }
        }

        return "";
    }

    function showMessageDiv() {
        messageDiv.style.display = "block";
    }

    function validationMdpMessage() {
        if (confirmMdpInput.value === mdpInput.value) {
            twoPasswords.classList.remove("invalid");
            twoPasswords.classList.add("valid");
        } else {
            twoPasswords.classList.add("invalid");
            twoPasswords.classList.remove("valid");
        }
    }

    function togglePasswordVisible(input) {
        if (input.getAttribute('type') === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }

    /**
     * @param url l'url de récupération des structures
     * @param structureData les données des villes (pas de requête ne serra faite si non-null)
     */
    function trouverStructure(url, structureData = null) {
        if (structureData) {
            autocompleteStructure(nomStructureInput, structureData);
        } else {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (reponse) {
                    autocompleteStructure(nomStructureInput, reponse);
                },
                error: function (res, status, err) {
                    console.error(status + status + err)
                },
                complete: function () {
                }
            });
        }
    }

    function autocompleteStructure(inp, arr) {
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
                if (arr[i].nom_structure.substring(0, val.length).toUpperCase() === val) {
                    /*create a DIV element for each matching element:*/
                    const b = document.createElement("DIV");
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input " +
                        "style='width:500px;' " +
                        "value='" + sanitize(arr[i].nom_structure + " - " + arr[i].nom_statut_structure + " - " + arr[i].code_postal + " - " + arr[i].nom_ville) + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/
                        form.setAttribute("data-id_structure", arr[i].id_structure);
                        nomStructureInput.value = arr[i].nom_structure;
                        adresseInput.value = arr[i].nom_adresse;
                        complementAdresseInput.value = arr[i].complement_adresse;
                        codePostalInput.value = arr[i].code_postal;
                        villeInput.value = arr[i].nom_ville;
                        statutStructureInput.value = arr[i].nom_statut_structure;
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
            const x = document.getElementsByClassName("autocomplete-items");
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

    function getFormData() {
        // recupération des diplomes
        const diplomes = document.querySelectorAll('.diplome-element');
        const diplomeIds = [];
        for (let i = 0; i < diplomes.length; i++) {
            diplomeIds.push(diplomes[i].getAttribute("data-id-diplome"));
        }

        // recupération des rôles
        const selectedNodes = document.querySelectorAll('#role_user_ids option:checked');
        const selectedRoleUserIds = [];
        selectedNodes.forEach(option => selectedRoleUserIds.push(option.value));

        const settings = [];
        if (nombreElementsTableauxSelect) {
            settings.push(
                {
                    "id_setting": nombreElementsTableauxSelect.getAttribute("data-id_setting"),
                    "nom": "nombre_elements_tableaux",
                    "valeur": nombreElementsTableauxSelect.value,
                }
            );
        }

        return {
            "id_user": form.getAttribute("data-id_user"),
            "id_intervenant": form.getAttribute("data-id_intervenant"),
            "nom_user": nomInput.value,
            "prenom_user": prenomInput.value,
            "role_user_ids": selectedRoleUserIds,
            "email_user": emailInput.value,
            "tel_f_user": telFixeInput.value,
            "tel_p_user": telProtableInput.value,
            "id_territoire": id_territoireSelect.value,
            "nom_territoire": id_territoireSelect.options[id_territoireSelect.selectedIndex].text,
            "id_statut_intervenant": statutSelect.value,
            "numero_carte": numero_carteInput.value,
            "est_coordinateur_peps": estCoordinateurCheckbox === null ? false : estCoordinateurCheckbox.checked,
            "mdp": mdpInput.value,
            "is_mdp_modified": modifMdpCheckbox === null ? false : modifMdpCheckbox.checked,
            "is_deactivated": isDeactivatedCheckbox === null ? false : isDeactivatedCheckbox.checked,
            "structure": {
                "id_structure": form.getAttribute("data-id_structure"),
                "nom_structure": nomStructureInput.value,
                "nom_statut_structure": statutStructureInput.value,
                "complement_adresse": complementAdresseInput.value,
                "nom_adresse": adresseInput.value,
                "code_postal": codePostalInput.value,
                "nom_ville": villeInput.value,
            },
            "diplomes": diplomeIds,
            "nom_fonction": nomFonction.value,
            "settings": settings
        };
    }

    function handleConfirmCloseClick() {
        $warningModal.modal('show');
        warningText.textContent = 'Abandonner ?';
    }

    function handleModifierClick(event) {
        event.preventDefault();
        setModalMode(MODE.EDIT);
    }

    function handleCreateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();

            if (confirmMdpInput.value === mdpInput.value) {
                $mainModal.modal('hide');

                lockForm(form)
                    .then(canContinue => {
                        if (canContinue) {
                            const new_data = getFormData();

                            // Insert dans la BDD
                            fetch(urls.urlCreateUser, {
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
                                    toast("Utilisateur ajouté avec succes");
                                    // MAJ du tableau si présent
                                    if (typeof affichageTableauUser !== 'undefined') {
                                        affichageTableauUser.addRow(data, true);
                                    }
                                })
                                .catch((error) => {
                                    toast("Echec de l'ajout");
                                });
                        }
                    });
            } else {
                mdpInput.focus();
                twoPasswords.classList.add("invalid");
                twoPasswords.classList.remove("valid");
                messageDiv.style.display = "block";
            }
        }
    }

    function handleUpdateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();

            if (confirmMdpInput.value === mdpInput.value) {
                $mainModal.modal('hide');

                lockForm(form)
                    .then(canContinue => {
                        if (canContinue) {
                            const new_data = getFormData();

                            // Update dans la BDD
                            fetch(urls.urlUpdateUser, {
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
                                .then((data) => {
                                    toast("Utilisateur modifié avec succes");

                                    // on met à jour les settings de l'utilisateur s'il modifie son compte
                                    if (page === PAGE_NAME.SETTINGS) {
                                        if (Array.isArray(data.settings)) {
                                            for (const setting of data.settings) {
                                                if (setting.nom === 'nombre_elements_tableaux') {
                                                    localStorage.setItem('nombre_elements_tableaux', setting.valeur);
                                                }
                                            }
                                        }
                                    }

                                    // MAJ du tableau si présent
                                    if (typeof affichageTableauUser !== 'undefined') {
                                        affichageTableauUser.replaceRowValues(data);
                                    }
                                })
                                .catch((error) => {
                                    console.error(error);
                                    toast("Echec de la modification");
                                });
                        }
                    });
            } else {
                mdpInput.focus();
                twoPasswords.classList.add("invalid");
                twoPasswords.classList.remove("valid");
                messageDiv.style.display = "block";
            }
        }
    }

    function handleDeleteClick(event) {
        $warningModal.modal('show');
        warningText.textContent = 'Supprimer l\'utilisateur?';

        event.preventDefault();

        getConfirmation().then(is_delete => {
            $('#modal').modal('hide');

            if (is_delete) {
                const new_data = getFormData();

                // Update dans la BDD
                fetch('DeleteUser.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({"id_user": new_data.id_user}),
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
                        toast("Utilisateur supprimé avec succès.");
                        affichageTableauUser.deleteRow(new_data.id_user);
                    })
                    .catch((c) => {
                        toast("Echec de la suppression. Cause: cet utilisateur ne peut pas être supprimé");
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

    function handleAddDiplome(diplome) {
        const diplomes = document.querySelectorAll('.diplome-element');

        // si diplôme vide
        if (parseInt(diplome.id_diplome) <= 0) {
            return;
        }

        // si diplôme est déjà dans la liste
        let exist = false;
        for (let i = 0; i < diplomes.length; i++) {
            if (diplomes[i].getAttribute("data-id-diplome") === diplome.id_diplome) {
                exist = true;
                break;
            }
        }

        if (!exist) {
            listeDiplomeDiv.append(createDiplomeElement(diplome));
        }
    }

    function createDiplomeElement(diplome) {
        const row = document.createElement('div');
        row.className = 'row diplome-element';
        row.setAttribute("data-id-diplome", diplome.id_diplome);

        const colVide = document.createElement('div');
        colVide.className = 'col-md-1';

        const colNom = document.createElement('div');
        colNom.className = 'col-md-9';

        const input = document.createElement('input');
        input.value = diplome.nom_diplome;
        input.className = 'form-control input-md';
        input.setAttribute("readOnly", "");

        const colDelete = document.createElement('div');
        colDelete.className = 'col-md-2';

        const deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger delete';
        deleteButton.setAttribute("data-id-diplome", diplome.id_diplome);
        deleteButton.textContent = 'Supprimer';

        colNom.append(input);
        colDelete.append(deleteButton);
        row.append(colVide, colNom, colDelete);

        return row;
    }

    function setInfosUser(id_user) {
        fetch(urls.urlRecupOneInfosUser, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_user": id_user}),
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
                // mettre la valeur de id_user
                form.setAttribute("data-id_user", data.id_user);
                form.setAttribute("data-id_intervenant", data.id_intervenant);
                // pré-rempli les valeurs du formulaire
                nomInput.value = data.nom_user;
                prenomInput.value = data.prenom_user;
                emailInput.value = data.email_user;
                telFixeInput.value = data.tel_f_user;
                telProtableInput.value = data.tel_p_user;
                id_territoireSelect.value = data.id_territoire;
                data.role_user_ids.forEach(id_role_user => $roleMultiselect.multiselect('select', id_role_user));
                statutSelect.value = data.id_statut_intervenant;
                diplomeSelect.value = data.id_diplome;
                numero_carteInput.value = data.numero_carte;

                estCoordinateurCheckbox.checked = data.est_coordinateur_peps != null && data.est_coordinateur_peps == "1";
                isDeactivatedCheckbox.checked = data.is_deactivated != null && data.is_deactivated == "1";

                form.setAttribute("data-id_structure", data.structure.id_structure == null ? '' : data.structure.id_structure);
                nomStructureInput.value = data.structure.nom_structure;
                statutStructureInput.value = data.structure.nom_statut_structure;
                adresseInput.value = data.structure.nom_adresse;
                complementAdresseInput.value = data.structure.complement_adresse;
                codePostalInput.value = data.structure.code_postal;
                villeInput.value = data.structure.nom_ville;

                nomFonction.value = data.nom_fonction;

                if (page === PAGE_NAME.SETTINGS && Array.isArray(data.settings)) {
                    for (const setting of data.settings) {
                        if (setting.nom === 'nombre_elements_tableaux') {
                            nombreElementsTableauxSelect.value = setting.valeur;
                        }
                    }
                }

                // ajout de la liste des diplômes de l'intervenant
                if (Array.isArray(data.diplomes)) {
                    for (let i = 0; i < data.diplomes.length; i++) {
                        listeDiplomeDiv.append(createDiplomeElement(data.diplomes[i]));
                    }
                }

                handleRoleUserChange();
            })
            .catch((error) => {
                console.error('Error recupr infos user:', error);
            });
    }

    function setStructure(id_structure) {
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
                form.setAttribute("data-id_structure", data.id_structure == null ? '' : data.id_structure);
                nomStructureInput.value = data.nom_structure;
                statutStructureInput.value = data.nom_statut_structure;
                adresseInput.value = data.nom_adresse;
                complementAdresseInput.value = data.complement_adresse;
                codePostalInput.value = data.code_postal;
                villeInput.value = data.nom_ville;
            })
            .catch((error) => {
                console.error('Error recupr infos structure:', error);
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

    function toggleRoleDisabled(on) {
        if (on) {
            $roleMultiselect.multiselect('disable');
        } else {
            $roleMultiselect.multiselect('enable');
        }
    }

    function toggleMdpDisabled(on) {
        if (on) {
            $mdpRow.hide();
            mdpInput.value = '';
            confirmMdpInput.value = '';

            mdpInput.setAttribute("disabled", "");
            confirmMdpInput.setAttribute("disabled", "");

            mdpInput.removeAttribute("required");
            confirmMdpInput.removeAttribute("required");
        } else {
            $mdpRow.show();
            mdpInput.removeAttribute("disabled");
            confirmMdpInput.removeAttribute("disabled");

            mdpInput.setAttribute("required", "");
            confirmMdpInput.setAttribute("required", "");
        }
    }

    function toggleDemandeModifMdpDisabled(on) {
        if (on) {
            $demandeModifMdpRow.hide();
        } else {
            $demandeModifMdpRow.show();
        }
    }

    function toggleDonneesProDisabled(on) {
        if (on) {
            $("#donnees-pro").hide();
            statutSelect.removeAttribute('required');
        } else {
            $("#donnees-pro").show();
            statutSelect.setAttribute('required', '');
        }
    }

    function toggleDonneesCoordinateurDisabled(on) {
        if (on) {
            $("#donnees-coordinateur").hide();
        } else {
            $("#donnees-coordinateur").show();
        }
    }

    function toggleDonneesSuperviseurDisabled(on) {
        if (on) {
            $("#donnees-superviseur").hide();
            nomFonction.removeAttribute('required');
        } else {
            $("#donnees-superviseur").show();
            nomFonction.setAttribute('required', '');
        }
    }

    function toggleSectionStructureDisabled(on) {
        if (on) {
            $("#fieldset-structures").hide();
            nomStructureInput.removeAttribute('required');
        } else {
            $("#fieldset-structures").show();
            nomStructureInput.setAttribute('required', '');
        }
    }

    function toggleSectionActivationDisabled(on) {
        if (on) {
            $("#donnees-activation").hide();
        } else {
            $("#donnees-activation").show();
        }
    }

    function handleRoleUserChange() {
        // update de l'array des roles sélectionnés
        const allOptionNodes = document.querySelectorAll('#role_user_ids option');
        allOptionNodes.forEach(option => {
            switch (parseInt(option.value)) {
                case 1:
                    // admin
                    if (option.selected) {
                        toggleSectionStructureDisabled(true);
                    } else {
                        toggleSectionStructureDisabled(false);
                    }
                    break;
                case 2:
                    // coordinateur
                    if (option.selected) {
                        toggleDonneesCoordinateurDisabled(false);
                    } else {
                        toggleDonneesCoordinateurDisabled(true);
                    }
                    break;
                case 3:
                    // intervenant
                    if (option.selected) {
                        toggleDonneesProDisabled(false);
                    } else {
                        toggleDonneesProDisabled(true);
                    }
                    break;
                case 7:
                    // superviseur PEPS
                    if (option.selected) {
                        toggleDonneesSuperviseurDisabled(false);
                    } else {
                        toggleDonneesSuperviseurDisabled(true);
                    }
                    break;
                default:
                    break;
            }
        });
    }

    /**
     * Désactive la possibilité de changer la structure
     */
    function toggleStructureReadonly(on) {
        if (on) {
            nomStructureInput.setAttribute('readonly', '');
        } else {
            nomStructureInput.removeAttribute('readonly');
        }
    }

    /**
     * Cache les options de l'élement roleSelect qui ont une valeur contenue dans values
     * roleSelectHideOptions([]) pour afficher toutes les options
     */
    function roleSelectHideOptions(values) {
        const cbs = document.querySelectorAll('.multiselect-container button span input');
        cbs.forEach(cb => {
            if (values.includes(cb.value)) {
                cb.parentNode.parentNode.setAttribute('hidden', 'hidden');
            }
        });
    }

    function resetForm() {
        form.reset();

        // réinitialisation des attributs
        form.setAttribute("data-id_intervenant", "");
        form.setAttribute("data-id_user", "");
        form.setAttribute("data-id_structure", "");

        // reset la liste diplomes
        const diplomes = document.querySelectorAll('.diplome-element');
        for (let i = 0; i < diplomes.length; i++) {
            diplomes[i].remove();
        }

        // reset du select role
        $roleMultiselect.multiselect('deselectAll');
    }

    /**
     *
     * @param mode {MODE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE.ADD) {
            // mode ajout
            modalTitle.textContent = "Ajout utilisateur";
            resetForm();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleRoleDisabled(false);
            toggleDemandeModifMdpDisabled(true);
            toggleMdpDisabled(false);
            handleRoleUserChange();
            if (roles_user.includes(ROLE.COORDONNATEUR_NON_MSS)) {
                setStructure(id_structure);
                toggleStructureReadonly(true);
            } else if (roles_user.includes(ROLE.RESPONSABLE_STRUCTURE)) {
                setStructure(id_structure);
                toggleStructureReadonly(true);
                roleSelectHideOptions(['1', '2', '4', '5', '7']);
            }
            toggleSectionActivationDisabled(true);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleCreateClick);
            enregistrerOuModifier.textContent = "Enregistrer";
            $('#enregistrer-modifier-user').show();

            if (deleteButton) {
                deleteButton.removeEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(true);
            }
        } else if (mode === MODE.EDIT) {
            // mode edition
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);

            toggleDemandeModifMdpDisabled(false);
            toggleMdpDisabled(true);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleUpdateClick);
            enregistrerOuModifier.textContent = "Enregistrer";

            if (deleteButton) {
                deleteButton.addEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(false);
            }

            if (page === PAGE_NAME.LISTE_USER) {
                modalTitle.textContent = "Détails utilisateur";
                if (roles_user.includes(ROLE.SUPER_ADMIN)) {
                    // le super admin peut modifier les rôles
                    toggleRoleDisabled(false);
                } else {
                    toggleRoleDisabled(true);
                }
            } else if (page === PAGE_NAME.SETTINGS) {
                modalTitle.textContent = "Mon compte";
                toggleRoleDisabled(true);
            }
        } else {
            // mode par défaut : MODE.READONLY
            resetForm();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(true);
            toggleDemandeModifMdpDisabled(false);
            toggleMdpDisabled(true);

            close.setAttribute("data-dismiss", "modal");
            close.removeEventListener('click', handleConfirmCloseClick);

            if (page === PAGE_NAME.LISTE_USER) {
                modalTitle.textContent = "Détails utilisateur";
                toggleRoleDisabled(true);

                // seul un admin ou un coordonnateur peut modifier un utilisateur
                if (roles_user.includes(ROLE.SUPER_ADMIN) ||
                    roles_user.includes(ROLE.COORDONNATEUR_PEPS) ||
                    roles_user.includes(ROLE.COORDONNATEUR_MSS) ||
                    roles_user.includes(ROLE.COORDONNATEUR_NON_MSS)) {
                    enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
                    enregistrerOuModifier.removeEventListener("click", handleCreateClick);
                    enregistrerOuModifier.addEventListener("click", handleModifierClick);
                    enregistrerOuModifier.textContent = "Modifier";

                    if (deleteButton) {
                        deleteButton.addEventListener("click", handleDeleteClick);
                        toggleDeleteButtonHidden(false);
                    }
                } else {
                    $('#enregistrer-modifier-user').hide();
                }

                // seul un admin ou un coordonnateur peut désactiver un utilisateur
                if (roles_user.includes(ROLE.SUPER_ADMIN)) {
                    toggleSectionActivationDisabled(false);
                } else {
                    toggleSectionActivationDisabled(true);
                }
            } else if (page === PAGE_NAME.SETTINGS) {
                modalTitle.textContent = "Mon compte";
                toggleRoleDisabled(true);

                // un utilisateur peut modifier son propre compte
                enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
                enregistrerOuModifier.removeEventListener("click", handleCreateClick);
                enregistrerOuModifier.addEventListener("click", handleModifierClick);
                enregistrerOuModifier.textContent = "Modifier";

                if (deleteButton) {
                    deleteButton.removeEventListener("click", handleDeleteClick);
                    toggleDeleteButtonHidden(true);
                }

                toggleSectionActivationDisabled(true);
            }
        }
    }

    return {
        init,
        setInfosUser,
        setModalMode
    };
})();