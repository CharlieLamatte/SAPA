"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 */

// les différents modes d'interaction avec le modal
const MODE = {
    ADD: 'add',
    EDIT: 'edit',
    READONLY: 'readonly',
    LISTE_PARTICIPANTS: 'liste_participants'
};
Object.freeze(MODE);

/**
 * Affichage du modal creneaux
 */
let modalCreneau = (function () {
    // le bouton qui ouvre le modal
    const ajoutModalButton = document.getElementById("creneau-modal");
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

    // boutton de suppression
    const deleteButton = document.getElementById("delete-creneau");

    // les 2 modals
    const warningModal = $("#warning");
    const mainModal = $("#modal");
    const modalTitle = document.getElementById("modal-title");
    const warningText = document.getElementById('warning-text');

    // le formulaire
    const form = document.getElementById("form-creneau");

    // input et select du form section creneau
    const nomInput = document.getElementById("nom_creneau");
    const type_parcoursSelect = document.getElementById("type_creneau");
    const jourSelect = document.getElementById("jour");
    const heureDebSelect = document.getElementById("heure_debut");
    const heureFinSelect = document.getElementById("heure_fin");
    const structureSelect = document.getElementById("nom_structure");
    const nbParticipantInput = document.getElementById("nb_participant");
    const publicViseInput = document.getElementById("public_vise");
    const tarifInput = document.getElementById("tarif");
    const paiementInput = document.getElementById("paiement");
    const intervenantSelect = document.getElementById("intervenant");
    const adresseInput = document.getElementById("adresse");
    const complementAdresseInput = document.getElementById("complement-adresse");
    const codePostalInput = document.getElementById("code-postal");
    const villeInput = document.getElementById("ville");
    const pathologieInput = document.getElementById("pathologie");
    const descriptionTextarea = document.getElementById("description");
    const typeSeanceInput = document.getElementById("type_seance");
    const creneauActifInput = document.getElementById("creneau-actif");

    // les sectiond du modal
    const sectionCreneauDiv = document.getElementById("section-creneau");
    const sectionListeParticipantsDiv = document.getElementById("section-liste-participants");
    const activationDiv = document.getElementById("activation-row");

    // section intervenant
    const bodyIntervenants = document.getElementById("body-intervenants");
    const ajoutIntervenantButton = document.getElementById("ajout-intervenant-button");


    // input et select du form section liste participants
    const bodyParticipants = document.getElementById("body-participants");
    const ajoutParticipantButton = document.getElementById("ajout-participant-button");
    const patientsAllSelect = document.getElementById("patients-all");

    // les urls
    let urls;

    let roles_user;

    /**
     * Initialisation du modal
     */
    let init = function (urlObj, data) {
        urls = urlObj;

        roles_user = JSON.parse(localStorage.getItem('roles_user'));

        if (ajoutModalButton) {
            ajoutModalButton.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.ADD);
            };
        }

        confirmclosed.onclick = function (event) {
            event.preventDefault();
            warningModal.modal('hide');
            mainModal.modal('hide');
        };

        trouverCPVille(urls.urlAutocompletionCodePostal, codePostalInput, villeInput, data?.villeData);

        ajoutParticipantButton.onclick = function (event) {
            event.preventDefault();

            const patient = {
                'id_patient': patientsAllSelect.value,
                'id_creneau': form.getAttribute("data-id_creneau"),
                'nom_patient': patientsAllSelect.options[patientsAllSelect.selectedIndex].getAttribute('data-nom'),
                'prenom_patient': patientsAllSelect.options[patientsAllSelect.selectedIndex].getAttribute('data-prenom'),
                'status_participant': 'PEPS',
                'propose_inscrit': '0',
                'abandon': '0',
                'reorientation': '0'
            };
            addPatient(patient);
        }

        ajoutIntervenantButton.onclick = function (event) {
            event.preventDefault();

            const intervenant = {
                'id_intervenant': intervenantSelect.value,
                'nom_intervenant': intervenantSelect.options[intervenantSelect.selectedIndex].getAttribute('data-nom_intervenant'),
                'prenom_intervenant': intervenantSelect.options[intervenantSelect.selectedIndex].getAttribute('data-prenom_intervenant'),
            }

            if (intervenant.id_intervenant !== "") {
                addIntervenant(intervenant);
            }
        }

        structureSelect.addEventListener("change", handleStructureChange)
    };

    function updateStructureSelect() {
        structureSelect.removeEventListener("change", handleStructureChange)
        structureSelect.innerHTML = "";

        fetch(urls.urlReadAllStructures, {
            method: 'GET',
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
                if (Array.isArray(data) && data.length > 0) {
                    for (const intervenant of data) {
                        const option = document.createElement('option');
                        option.value = intervenant.id_structure;
                        option.textContent = intervenant.nom_structure;

                        structureSelect.append(option);
                    }
                }

                structureSelect.addEventListener("change", handleStructureChange)
                handleStructureChange();
            })
            .catch((error) => {
                console.error('structureSelect.onchange Error:', error);
            });
    }

    /**
     * Returns the value of a radio-group
     * @param form the form containing the radio-group
     * @param name the name of the radio-group
     * @returns {string|*}
     */
    function getSelectedRadioValue(form, name) {
        const elemsRadio = form.elements[name];

        for (const radio of elemsRadio) {
            if (radio.checked) {
                return radio.value;
            }
        }

        return '';
    }

    /**
     * Sets the value of a radio-group
     * @param form the form containing the radio-group
     * @param name the name of the radio-group
     * @param value
     * @returns void
     */
    function setSelectedRadioValue(form, name, value) {
        form.elements[name].value = value;
    }

    function getFormData() {
        const intervenantIds = [];
        for (const tr of bodyIntervenants.childNodes) {
            const id_intervenant = tr.getAttribute('data-id_intervenant');
            if (id_intervenant != null && id_intervenant !== '') {
                intervenantIds.push(id_intervenant);
            }
        }

        return {
            "id_creneau": form.getAttribute("data-id_creneau"),
            "nom_creneau": nomInput.value,
            "type_creneau": type_parcoursSelect.value,
            "nom_type_creneau": type_parcoursSelect.options[type_parcoursSelect.selectedIndex].text,
            "jour": jourSelect.value,
            "nom_jour": jourSelect.options[jourSelect.selectedIndex].text,
            "heure_debut": heureDebSelect.value,
            "nom_heure_debut": heureDebSelect.options[heureDebSelect.selectedIndex].text,
            "heure_fin": heureFinSelect.value,
            "nom_heure_fin": heureFinSelect.options[heureFinSelect.selectedIndex].text,
            "nom_structure": structureSelect.options[structureSelect.selectedIndex].text,
            "id_structure": structureSelect.value,
            "nb_participant": nbParticipantInput.value,
            "public_vise": publicViseInput.value,
            "tarif": tarifInput.value,
            "paiement": paiementInput.value,
            "nom_prenom_intervenant": intervenantSelect.options[intervenantSelect.selectedIndex].text,
            "nom_adresse": adresseInput.value,
            "complement_adresse": complementAdresseInput.value,
            "code_postal": codePostalInput.value,
            "nom_ville": villeInput.value,
            "pathologie": pathologieInput.value,
            "description": descriptionTextarea.value,
            "type_seance": typeSeanceInput.value,
            "activation": getSelectedRadioValue(form, 'activation-creneau'),
            "intervenant_ids": intervenantIds
        };
    }

    function getPatientFormData() {
        const listePatient = [];
        for (const tr of bodyParticipants.childNodes) {
            const id_patient = tr.getAttribute('data-id_patient');
            if (id_patient != null && id_patient !== '') {
                const statutSelect = tr.childNodes[2].firstChild;

                listePatient.push({
                    'id_patient': id_patient,
                    'status_participant': statutSelect.options[statutSelect.selectedIndex].text,
                    'propose_inscrit': tr.childNodes[3].firstChild.getAttribute('data-value'),
                    'abandon': tr.childNodes[4].firstChild.getAttribute('data-value'),
                    'reorientation': tr.childNodes[5].firstChild.getAttribute('data-value')
                });
            }
        }

        return {
            'id_creneau': form.getAttribute("data-id_creneau"),
            'participants': listePatient
        };
    }

    function handleStructureChange(id_intervenant_selected = null) {
        intervenantSelect.innerHTML = '';

        return new Promise(resolve => {
            fetch(urls.urlReadAllIntervenantsStructure, {
                method: 'POST',
                body: JSON.stringify({'id_structure': structureSelect.value})
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
                    if (Array.isArray(data) && data.length > 0) {
                        for (const intervenant of data) {
                            const option = document.createElement('option');
                            option.value = intervenant.id_intervenant;
                            option.textContent = intervenant.nom_intervenant + ' ' + intervenant.prenom_intervenant;
                            option.setAttribute("data-nom_intervenant", intervenant.nom_intervenant);
                            option.setAttribute("data-prenom_intervenant", intervenant.prenom_intervenant);
                            if (id_intervenant_selected && intervenant.id_intervenant === id_intervenant_selected) {
                                option.selected = true;
                            }

                            intervenantSelect.append(option);
                        }

                        bodyIntervenants.innerHTML = "";
                    } else {
                        addEmptyIntervenant();
                    }
                })
                .catch((error) => {
                    console.error('structureSelect.onchange Error:', error);
                    addEmptyIntervenant();
                })
                .finally(() => resolve(true));
        });

        /**
         * Ajout une option non sélectionnable dans la liste déroulante des intervenants
         */
        function addEmptyIntervenant() {
            const option = document.createElement('option');
            option.textContent = 'Aucun intervenant pour cette structure';
            option.value = '';
            option.selected = true;
            option.setAttribute('disabled', '');
            intervenantSelect.append(option);
        }
    }

    function handleConfirmCloseClick() {
        warningModal.modal('show');
    }

    function handleModifierClick(event) {
        event.preventDefault();
        setModalMode(MODE.EDIT);
    }

    /**
     * Vérifie qu'il y a au moins un intervenant dans les données
     * @param new_data
     * @returns {boolean}
     */
    function verifyIntervenants(new_data) {
        if (new_data.intervenant_ids.length > 0) {
            return true;
        }

        alert('Il faut obligatoirement ajouter au moins un intervenant pour le créneau');
        return false;
    }

    function handleCreateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            const new_data = getFormData();

            if (verifyIntervenants(new_data)) {
                $('#modal').modal('hide');

                lockForm(form)
                    .then(canContinue => {
                        if (canContinue) {
                            // Insert dans la BDD
                            fetch(urls.urlCreateCreneau, {
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
                                    toast("Créneau ajouté avec succes");
                                    if (document.getElementById('table_creneau')) {
                                        tableauCreneau.addRow(data, true);
                                    }
                                })
                                .catch((error) => {
                                    toast("Echec de l'ajout");
                                });
                        }
                    });
            }
        }
    }

    function handleUpdateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            const new_data = getFormData();

            if (verifyIntervenants(new_data)) {
                $('#modal').modal('hide');

                lockForm(form)
                    .then(canContinue => {
                        if (canContinue) {
                            // Update dans la BDD
                            fetch(urls.urlUpdateCreneau, {
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
                                    toast("Créneau modifié avec succès.");
                                    if (document.getElementById('table_creneau')) {
                                        tableauCreneau.replaceRowValues(data);
                                    }
                                    if (typeof calendrierType !== 'undefined') {
                                        calendrierType.updateCreneaux();
                                    }
                                })
                                .catch((error) => {
                                    console.error(error);
                                    toast("Echec de la modification");
                                });
                        }
                    });
            }
        }
    }

    function handleDeleteClick(event) {
        warningModal.modal('show');
        warningText.textContent = 'Supprimer le créneau?';

        event.preventDefault();

        getConfirmation().then(is_delete => {
            $('#modal').modal('hide');
            warningModal.modal('hide');

            if (is_delete) {
                const new_data = getFormData();

                // Update dans la BDD
                fetch(urls.urlDeleteCreneau, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({"id_creneau": new_data.id_creneau}),
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
                        toast("Créneau supprimé avec succès.");
                        tableauCreneau.deleteRow(new_data.id_creneau);
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

    function handleEnregistrerParticipantsClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            $('#modal').modal('hide');
            const new_data = getPatientFormData();

            // Update dans la BDD
            fetch(urls.urlUpdateParticipants, {
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
                    toast("Liste des patients modifiée avec succès.");
                })
                .catch((error) => {
                    toast("Echec de la modification");
                });
        }
    }

    function handleProposeClick(event) {
        event.preventDefault();

        const button = event.target;
        if (button.textContent === 'Propose') {
            button.textContent = 'Inscrit';
            button.setAttribute('data-value', '1');
        } else {
            button.textContent = 'Propose';
            button.setAttribute('data-value', '0');
        }
    }

    function handleAbandonClick(event) {
        event.preventDefault();

        const button = event.target;
        if (button.textContent === 'Oui') {
            button.textContent = 'Non';
            button.setAttribute('data-value', '0');
            button.className = 'btn btn-default';
        } else {
            button.textContent = 'Oui';
            button.setAttribute('data-value', '1');
            button.className = 'btn btn-danger';
        }
    }

    function handleReorientationClick(event) {
        event.preventDefault();

        const button = event.target;
        if (button.textContent === 'Oui') {
            button.textContent = 'Non';
            button.setAttribute('data-value', '0');
            button.className = 'btn btn-default';
        } else {
            button.textContent = 'Oui';
            button.setAttribute('data-value', '1');
            button.className = 'btn btn-danger';
        }
    }

    function setInfosCreneau(id_creneau) {
        fetch(urls.urlReadCreneau, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_creneau": id_creneau}),
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
                type_parcoursSelect.value = data.id_type_parcours;
                jourSelect.value = data.id_jour;
                heureDebSelect.value = data.heure_debut;
                heureFinSelect.value = data.heure_fin;
                structureSelect.value = data.id_structure;
                nbParticipantInput.value = data.nombre_participants;
                publicViseInput.value = data.public_vise;
                tarifInput.value = data.tarif;
                paiementInput.value = data.facilite_paiement;
                //intervenantSelect.value = data.id_intervenant;
                adresseInput.value = data.nom_adresse;
                complementAdresseInput.value = data.complement_adresse;
                codePostalInput.value = data.code_postal;
                villeInput.value = data.nom_ville;
                typeSeanceInput.value = data.type_seance;
                pathologieInput.value = data.pathologie;
                descriptionTextarea.value = data.description;
                setSelectedRadioValue(form, "activation-creneau", data.activation);

                handleStructureChange(data.id_intervenant)
                    .then(() => {
                        // ajout de la liste des intervenants du créneau
                        // doit être après handleStructureChange()
                        if (Array.isArray(data.intervenants)) {
                            data.intervenants.forEach(intervenant => addIntervenant(intervenant));
                        }
                    });
            })
            .catch((error) => {
                console.error('Error recup infos créneau:', error);
            });
    }

    function setInfosListeParticipants(id_creneau) {
        fetch(urls.urlReadParticipants, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_creneau": id_creneau}),
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
                form.setAttribute("data-id_creneau", id_creneau);

                // ajout de la liste des patients du créneau
                if (Array.isArray(data)) {
                    if (data.length === 0) { // si aucun patient
                        createEmptyLignePatient();
                    } else {
                        data.forEach(patient => addPatient(patient));
                    }
                }
            })
            .catch((error) => {
                console.error(error);
            });
    }

    function addPatient(patient) {
        let not_already_added = true;
        for (const tr of bodyParticipants.childNodes) {
            if (tr.getAttribute('data-id_patient') === null || tr.getAttribute('data-id_patient') === '') {
                tr.remove();
            }
            if (patient.id_patient === tr.getAttribute('data-id_patient')) {
                not_already_added = false;
                break;
            }
        }

        if (not_already_added) {
            bodyParticipants.append(createLignePatient(patient));
        }
    }

    function createEmptyLignePatient() {
        const emptyRow = document.createElement('tr');

        const td = document.createElement('td');
        td.setAttribute('colspan', '6');
        td.textContent = 'Aucun patient pour ce créneau.'

        emptyRow.append(td);
        bodyParticipants.append(emptyRow);
    }

    function createLignePatient(patient) {
        let row = document.createElement('tr');
        row.setAttribute('data-id_patient', patient.id_patient);

        let td1 = document.createElement('td');
        td1.className = "text-left clickable";
        td1.textContent = patient.nom_patient;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = patient.prenom_patient;

        let td3 = document.createElement('td');
        td3.className = "text-left";

        let statutSelect = document.createElement('select');
        statutSelect.className = 'form-control';
        let optionPeps = document.createElement('option');
        optionPeps.value = '0';
        optionPeps.textContent = 'PEPS';
        let optionExterne = document.createElement('option');
        optionExterne.value = '1';
        optionExterne.textContent = 'EXTERNE';
        statutSelect.append(optionPeps, optionExterne);

        if (patient.status_participant === 'EXTERNE') {
            optionExterne.selected = true;
        } else {
            optionPeps.selected = true;
        }
        td3.append(statutSelect);

        let td4 = document.createElement('td');
        td4.className = "text-left";

        const proposeButton = document.createElement('button');
        proposeButton.className = 'btn btn-default';
        proposeButton.onclick = handleProposeClick;
        if (patient.propose_inscrit == null || patient.propose_inscrit == '0') {
            proposeButton.textContent = 'Propose';
            proposeButton.setAttribute('data-value', '0');
        } else {
            proposeButton.textContent = 'Inscrit';
            proposeButton.setAttribute('data-value', '1');
        }
        td4.append(proposeButton);

        let td5 = document.createElement('td');
        td5.className = "text-left";

        const abandonButton = document.createElement('button');
        abandonButton.onclick = handleAbandonClick;
        if (patient.abandon == null || patient.abandon == '0') {
            abandonButton.textContent = 'Non';
            abandonButton.className = 'btn btn-default';
            abandonButton.setAttribute('data-value', '0');
        } else {
            abandonButton.textContent = 'Oui';
            abandonButton.className = 'btn btn-danger';
            abandonButton.setAttribute('data-value', '1');
        }
        td5.append(abandonButton);

        let td6 = document.createElement('td');
        td6.className = "text-left";

        const reorientationButton = document.createElement('button');
        reorientationButton.onclick = handleReorientationClick;
        if (patient.reorientation == null || patient.reorientation == '0') {
            reorientationButton.textContent = 'Non';
            reorientationButton.className = 'btn btn-default';
            reorientationButton.setAttribute('data-value', '0');
        } else {
            reorientationButton.textContent = 'Oui';
            reorientationButton.className = 'btn btn-danger';
            reorientationButton.setAttribute('data-value', '1');
        }
        td6.append(reorientationButton);

        let td7 = document.createElement('td');
        td7.className = "text-left";

        const deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger';
        deleteButton.textContent = 'Supprimer';
        td7.append(deleteButton);

        deleteButton.onclick = (event) => {
            event.preventDefault();
            row.remove();
            if (bodyParticipants.childNodes.length === 0) {
                createEmptyLignePatient();
            }
        };

        row.append(td1, td2, td3, td4, td5, td6, td7);

        return row;
    }

    function addIntervenant(intervenant) {
        let not_already_added = true;
        for (const tr of bodyIntervenants.childNodes) {
            if (tr.getAttribute('data-id_intervenant') === null || tr.getAttribute('data-id_intervenant') === '') {
                tr.remove();
            }
            if (intervenant.id_intervenant == tr.getAttribute('data-id_intervenant')) {
                not_already_added = false;
                break;
            }
        }

        if (not_already_added) {
            bodyIntervenants.append(createLigneIntervenant(intervenant));
        }
    }

    function createLigneIntervenant(intervenant) {
        let row = document.createElement('tr');
        row.setAttribute('data-id_intervenant', intervenant.id_intervenant);

        let td1 = document.createElement('td');
        td1.className = "text-left clickable";
        td1.textContent = intervenant.nom_intervenant;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = intervenant.prenom_intervenant;

        let td3 = document.createElement('td');
        td3.className = "text-left";

        const deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger';
        deleteButton.textContent = 'Supprimer';
        td3.append(deleteButton);

        deleteButton.onclick = (event) => {
            event.preventDefault();
            row.remove();
            if (bodyParticipants.childNodes.length === 0) {
                createEmptyLignePatient();
            }
        };

        row.append(td1, td2, td3);

        return row;
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
        if (on) {
            nomInput.removeAttribute('required');
            jourSelect.removeAttribute('required');
            heureDebSelect.removeAttribute('required');
            heureFinSelect.removeAttribute('required');
            structureSelect.removeAttribute('required');
            intervenantSelect.removeAttribute('required');
            pathologieInput.removeAttribute('required');
            typeSeanceInput.removeAttribute('required');
            adresseInput.removeAttribute('required');
            codePostalInput.removeAttribute('required');
            villeInput.removeAttribute('required');
        } else {
            nomInput.setAttribute('required', '');
            jourSelect.setAttribute('required', '');
            heureDebSelect.setAttribute('required', '');
            heureFinSelect.setAttribute('required', '');
            structureSelect.setAttribute('required', '');
            intervenantSelect.setAttribute('required', '');
            pathologieInput.setAttribute('required', '');
            typeSeanceInput.setAttribute('required', '');
            adresseInput.setAttribute('required', '');
            codePostalInput.setAttribute('required', '');
            villeInput.setAttribute('required', '');
        }

        sectionCreneauDiv.hidden = on;
    }

    function toggleActivationHidden(on) {
        if (on) {
            creneauActifInput.removeAttribute('required');
        } else {
            creneauActifInput.setAttribute('required', '');
        }

        activationDiv.hidden = on;
    }

    function toggleSectionListeParticipantsHidden(on) {
        sectionListeParticipantsDiv.hidden = on;
    }

    function toggleDeleteButtonHidden(on) {
        if (on) {
            deleteButton.style.display = 'none';
        } else {
            deleteButton.style.display = 'block';
        }
    }

    function toggleRestictionsResponsableStructure(on) {
        if (on) {
            // type de créneaux non modifiable
            type_parcoursSelect.setAttribute('disabled', '');

            // structure non modifiable
            structureSelect.setAttribute('disabled', '');
        } else {
            type_parcoursSelect.removeAttribute('disabled');
            structureSelect.removeAttribute('disabled');
        }
    }

    /**
     *
     * @param mode {MODE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE.ADD) {
            modalTitle.textContent = "Ajout créneau";
            warningText.textContent = 'Quitter sans enregistrer?';
            form.reset();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            //is_userInput.value = "NON";
            toggleChampDisabled(false);
            toggleSectionCreneauHidden(false);
            toggleSectionListeParticipantsHidden(true);
            toggleActivationHidden(true);
            handleStructureChange();

            if (roles_user.includes(ROLE.RESPONSABLE_STRUCTURE)) {
                type_parcoursSelect.value = "4"; // creneau non labellisé
                toggleRestictionsResponsableStructure(true);
            }
            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener('click', handleEnregistrerParticipantsClick);
            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleCreateClick);
            if (deleteButton) {
                deleteButton.removeEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(true);
            }

            enregistrerOuModifier.textContent = "Enregistrer";
        } else if (mode === MODE.EDIT) {
            modalTitle.textContent = "Détails créneau";
            warningText.textContent = 'Quitter sans enregistrer?';
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleSectionCreneauHidden(false);
            toggleSectionListeParticipantsHidden(true);
            toggleActivationHidden(false);
            if (roles_user.includes(ROLE.RESPONSABLE_STRUCTURE)) {
                toggleRestictionsResponsableStructure(true);
            }

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener('click', handleEnregistrerParticipantsClick);
            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleUpdateClick);
            if (deleteButton) {
                deleteButton.addEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(false);
            }

            enregistrerOuModifier.textContent = "Enregistrer";
        } else if (mode === MODE.READONLY) {
            modalTitle.textContent = "Détails créneau";
            warningText.textContent = 'Quitter sans enregistrer?';
            form.reset();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(true);
            toggleSectionCreneauHidden(false);
            toggleActivationHidden(false);
            toggleSectionListeParticipantsHidden(true);
            if (roles_user.includes(ROLE.RESPONSABLE_STRUCTURE)) {
                toggleRestictionsResponsableStructure(false);
            }

            close.setAttribute("data-dismiss", "modal");
            close.removeEventListener('click', handleConfirmCloseClick);

            enregistrerOuModifier.removeEventListener('click', handleEnregistrerParticipantsClick);
            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.addEventListener("click", handleModifierClick);
            if (deleteButton) {
                deleteButton.addEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(false);
            }

            enregistrerOuModifier.textContent = "Modifier";
        } else if (mode === MODE.LISTE_PARTICIPANTS) {
            modalTitle.textContent = "Liste participants";
            warningText.textContent = 'Quitter sans enregistrer?';
            form.reset();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            bodyParticipants.innerHTML = '';
            toggleChampDisabled(false);
            toggleSectionCreneauHidden(true);
            toggleActivationHidden(true);
            toggleSectionListeParticipantsHidden(false);
            if (roles_user.includes(ROLE.RESPONSABLE_STRUCTURE)) {
                toggleRestictionsResponsableStructure(false);
            }

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.addEventListener('click', handleEnregistrerParticipantsClick);
            if (deleteButton) {
                deleteButton.removeEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(true);
            }

            enregistrerOuModifier.textContent = "Enregistrer";
        }
    }

    return {
        init,
        setInfosCreneau,
        setInfosListeParticipants,
        setModalMode,
        updateStructureSelect
    };
})();