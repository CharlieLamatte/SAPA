"use strict";

// les différents modes d'interaction avec le modal
const MODE = {
    ADD: 'add',
    EDIT: 'edit',
    AVANCEMENT: 'avancement'
};
Object.freeze(MODE);

function removeChildren(elem) {
    while (elem.firstChild) {
        elem.firstChild.remove();
    }
}

$(document).ready(function () {
    // initialisation des élements de la page
    affichageListeObjectif.init();
    affichageModalObjectif.init();
});

/**
 * Affichage des infos des users
 */
let affichageListeObjectif = (function () {
    const body = document.getElementById('main-panel');
    const id_patient = body.getAttribute('data-id_patient');
    const id_user = localStorage.getItem("id_user");
    const id_role_user = localStorage.getItem("id_role_user");

    const objectifsAutonomie = document.getElementById('objectifs-autonomie');
    const objectifsEncadres = document.getElementById('objectifs-encadres');
    const objectifsTermines = document.getElementById('objectifs-termines');

    let init = function () {
        fetch('Objectifs/ReadAllObjectifs.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_patient": id_patient}),
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
                actualiserInfos(data);
            })
            .catch((error) => {
                console.error('Error:', error);
                actualiserInfos(null);
            });
    };

    function createObjectif(objectif) {
        const table = document.createElement('table');
        table.className = 'table-objectif';
        table.id = 'table-' + objectif.id_obj_patient

        const br = document.createElement('br');

        const tr = document.createElement('tr');

        const tdDate = document.createElement('td');
        tdDate.className = 'objectif-td-date';

        const spanDate1 = document.createElement('span');
        spanDate1.textContent = 'Objectif du';
        const spanDate2 = document.createElement('span');
        spanDate2.textContent = objectif.date_objectif_patient_formated;
        spanDate2.id = 'date-' + objectif.id_obj_patient;

        tdDate.append(spanDate1, br, spanDate2);

        const tdAvis = document.createElement('td');
        tdAvis.className = 'objectif-td-avis';
        tdAvis.id = 'avis-' + objectif.id_obj_patient;

        tdAvis.append(createTextLine('Nom de l\'objectif: ', objectif.nom_objectif, 'nom-' + objectif.id_obj_patient));
        tdAvis.append(createTextLine('Description: ', objectif.desc_objectif, 'desc-' + objectif.id_obj_patient));
        if (objectif.pratique === 'Autonome') {
            tdAvis.append(createTextLine('Type d\'activité: ', objectif.type_activite, 'type-' + objectif.id_obj_patient));
            tdAvis.append(createTextLine('Durée: ', objectif.duree, 'duree-' + objectif.id_obj_patient));
            tdAvis.append(createTextLine('Fréquence: ', objectif.frequence, 'frequence-' + objectif.id_obj_patient));
            tdAvis.append(createTextLine('Informations complémentaires: ', objectif.infos_complementaires, 'infos-' + objectif.id_obj_patient));
        }
        tdAvis.append(br.cloneNode());

        if (Array.isArray(objectif.avancements)) {
            for (const avancement of objectif.avancements) {
                const com = (avancement.commentaires == null || avancement.commentaires === '') ? '' : ', ' + avancement.commentaires;
                const ligne = createTextLine(avancement.date_avancement + ': ', avancement.atteinte + com, 'avancement-' + avancement.id_avancement_obj);
                ligne.id = 'ligne-avancement-' + avancement.id_avancement_obj;
                tdAvis.append(ligne);
            }
        }

        const tdBouttons = document.createElement('td');
        tdBouttons.id = 'buttons-' + objectif.id_obj_patient;
        tdBouttons.className = 'objectif-td-boutons';

        if ((objectif.termine == null || objectif.termine != '1') && (id_role_user != 3 || (id_role_user == 3 && objectif.id_user == id_user))) {
            //if(id_role_user != 3 || (id_role_user == 3 && objectif.id_user == id_user){
                const modifier = document.createElement('button');
                modifier.setAttribute("data-toggle", "modal");
                modifier.setAttribute("data-target", "#modal");
                modifier.setAttribute("data-backdrop", "static");
                modifier.setAttribute("data-keyboard", "false");
                modifier.className = 'btn btn-warning btn-sm';
                modifier.textContent = 'Modifier';

                modifier.onclick = () => {
                    affichageModalObjectif.setInfosObjectif(objectif.id_obj_patient);
                    affichageModalObjectif.setModalMode(MODE.EDIT);
                };

                const supprimer = document.createElement('button');
                supprimer.className = 'btn btn-danger btn-sm';
                supprimer.textContent = 'Supprimer';

                supprimer.onclick = () => {
                    affichageModalObjectif.handleDeleteClick(objectif.id_obj_patient);
                };

            const avancement = document.createElement('button');
            avancement.setAttribute("data-toggle", "modal");
            avancement.setAttribute("data-target", "#modal");
            avancement.setAttribute("data-backdrop", "static");
            avancement.setAttribute("data-keyboard", "false");
            avancement.className = 'btn btn-primary btn-sm';
            avancement.textContent = 'Avancement';

            avancement.onclick = () => {
                affichageModalObjectif.setInfosAvancement(objectif.id_obj_patient);
                affichageModalObjectif.setModalMode(MODE.AVANCEMENT);
            };

            tdBouttons.append(modifier, br.cloneNode(), br.cloneNode(), supprimer, br.cloneNode(), br.cloneNode(), avancement);
        //}
        }

        tr.append(tdDate, tdAvis, tdBouttons);
        table.append(tr);


        return table;
    }

    function createTextLine(text1, text2, tagId) {
        const br = document.createElement('br');
        const bold = document.createElement('b');
        bold.textContent = text1;

        const spanText2 = document.createElement('span');
        spanText2.textContent = text2;
        spanText2.id = tagId;

        const mainSpan = document.createElement('span');

        mainSpan.append(bold, spanText2, br);

        return mainSpan;
    }

    function actualiserInfos(objectifs) {
        if (Array.isArray(objectifs)) {
            for (const objectif of objectifs) {
                if (objectif.termine != null && objectif.termine == '1') {
                    objectifsTermines.append(createObjectif(objectif));
                } else {
                    if (objectif.pratique.includes('Autonome')) {
                        objectifsAutonomie.append(createObjectif(objectif));
                    } else {
                        objectifsEncadres.append(createObjectif(objectif));
                    }
                }
            }
        }
    }

    function deleteObjectif(id_obj_patient) {
        const table = document.getElementById('table-' + id_obj_patient);

        table.remove();
    }

    function updateObjectif(objectif) {
        const table = document.getElementById('table-' + objectif.id_obj_patient);
        if ((objectif.pratique.includes('Autonome') && objectifsAutonomie.contains(table)) ||
            (!objectif.pratique.includes('Autonome') && objectifsEncadres.contains(table))) { // si le tableau est dans la bonne liste
            const nomElem = document.getElementById('nom-' + objectif.id_obj_patient);
            const dateElem = document.getElementById('date-' + objectif.id_obj_patient);
            const descElem = document.getElementById('desc-' + objectif.id_obj_patient);
            const typeElem = document.getElementById('type-' + objectif.id_obj_patient);
            const dureeElem = document.getElementById('duree-' + objectif.id_obj_patient);
            const frequenceElem = document.getElementById('frequence-' + objectif.id_obj_patient);
            const infosElem = document.getElementById('infos-' + objectif.id_obj_patient);

            nomElem.textContent = objectif.nom_objectif;
            dateElem.textContent = objectif.date_objectif_patient;
            descElem.textContent = objectif.desc_objectif;

            if (objectif.pratique.includes('Autonome')) {
                typeElem.textContent = objectif.type_activite;
                dureeElem.textContent = objectif.duree;
                frequenceElem.textContent = objectif.frequence;
                infosElem.textContent = objectif.infos_complementaires;
            }
        } else {
            table.remove();

            if (objectif.pratique.includes('Autonome')) {
                objectifsAutonomie.append(createObjectif(objectif));
            } else {
                objectifsEncadres.append(createObjectif(objectif));
            }
        }
    }

    function addObjectif(objectif) {
        if (objectif.pratique.includes('Autonome')) {
            objectifsAutonomie.append(createObjectif(objectif));
        } else {
            objectifsEncadres.append(createObjectif(objectif));
        }
    }

    function addAvancement(avancement) {
        const tdAvis = document.getElementById('avis-' + avancement.id_obj_patient);

        const com = (avancement.commentaires == null || avancement.commentaires === '') ? '' : ', ' + avancement.commentaires;

        const ligne = createTextLine(avancement.date_avancement + ': ', avancement.atteinte + com, 'avancement-' + avancement.id_avancement_obj);
        ligne.id = 'ligne-avancement-' + avancement.id_avancement_obj;
        tdAvis.append(ligne);

        if (avancement.atteinte === 'Atteint') {
            const tdButtons = document.getElementById('buttons-' + avancement.id_obj_patient);
            removeChildren(tdButtons);

            const table = document.getElementById('table-' + avancement.id_obj_patient);
            table.remove();
            objectifsTermines.append(table);
        }
    }

    function deleteAvancement(id_avancement_obj) {
        const ligne = document.getElementById('ligne-avancement-' + id_avancement_obj);

        ligne.remove();
    }

    return {
        init,
        deleteObjectif,
        updateObjectif,
        addObjectif,
        addAvancement,
        deleteAvancement
    };
})();

/**
 * Affichage du modal
 */
let affichageModalObjectif = (function () {
    // le bouton qui ouvre le modal
    const ajoutModalButton = document.getElementById("ajout-modal");
    // les element du modal qui peuvent être désactivés (en général tous sauf les bouton abandon, etc ...)
    const canBeDisabledElems = document.getElementsByClassName("can-disable");
    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    // boutons du modal
    const confirmclosedButton = $("#confirmclosed");
    const enregistrerOuModifier = document.getElementById("enregistrer-modifier");
    const close = document.getElementById("close");

    // les 2 modals
    const warningModal = $('#warning');
    const mainModal = $('#modal');
    const modalTitle = document.getElementById("modal-title");
    const warningText = document.getElementById('warning-text');

    const confirmclosed = document.getElementById('confirmclosed');
    const refuseclosed = document.getElementById('refuseclosed');

    // le formulaire
    const form = document.getElementById("form-user");

    // input et select du form
    const nomInput = document.getElementById("nom");
    const dateDebut = document.getElementById("date-debut");
    const descriptionInput = document.getElementById("description");
    const pratiqueSelect = document.getElementById("pratique");

    const typeActiviteInput = document.getElementById("type-activite");
    const dureeInput = document.getElementById("duree");
    const frequenceInput = document.getElementById("frequence");
    const infosComplementairesInput = document.getElementById("infos-complementaires");

    // Avancement objectif
    const dateAvancementInput = document.getElementById("date-avancement");
    const inlineRadio1 = document.getElementById("inlineRadio1");
    const commentaireInput = document.getElementById("commentaire");

    const bodyAvancement = document.getElementById("body-avancement");
    const avancementAddButton = document.getElementById('avancement-add-button');

    let init = function () {
        ajoutModalButton.onclick = function (event) {
            setModalMode(MODE.ADD);
        };

        confirmclosed.addEventListener("click", handleWarningCloseClick);

        pratiqueSelect.onchange = handlePratiqueChange;

        avancementAddButton.onclick = handleAvancementClick;
    };

    function getFormData() {
        return {
            "id_obj_patient": form.getAttribute("data-id_obj_patient"),
            "id_patient": form.getAttribute("data-id_patient"),
            "nom_objectif": nomInput.value,
            "date_objectif_patient": dateDebut.value,
            "pratique": pratiqueSelect.options[pratiqueSelect.selectedIndex].text,
            "type_activite": typeActiviteInput.value,
            "desc_objectif": descriptionInput.value,
            "duree": dureeInput.value,
            "frequence": frequenceInput.value,
            "infos_complementaires": infosComplementairesInput.value,
            "date_avancement": dateAvancementInput.value,
            "atteinte": getSelectedRadioValue(form, 'etat'),
            "commentaires": commentaireInput.value
        };
    }

    function getSelectedRadioValue(form, name) {
        const elemsRadio = form.elements[name];

        for (const radio of elemsRadio) {
            if (radio.checked) {
                return radio.value;
            }
        }

        return '';
    }

    function handleWarningCloseSuppressionClick() {
        warningModal.modal('hide');
    }

    function handleWarningCloseClick() {
        mainModal.modal('hide');
        warningModal.modal('hide');
    }

    function handleConfirmCloseClick() {
        if (!areAllFieldsEmpty()) {
            warningModal.modal('show');
        } else {
            mainModal.modal('hide');
        }
    }

    function handleModifierClick(event) {
        event.preventDefault();
        setModalMode(MODE.EDIT);
    }

    function handleCreateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            mainModal.modal('hide');

            const new_data = getFormData();

            // Insert dans la BDD
            fetch('Objectifs/CreateObjectif.php', {
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
                    toast("Objectif ajouté avec succes");
                    affichageListeObjectif.addObjectif(data);
                })
                .catch((error) => {
                    console.error('Error:', error);
                    toast("Echec de l'ajout");
                });
        }
    }

    function handleUpdateClick(event) {
        form.onsubmit = function (e) {
            e.preventDefault();
            mainModal.modal('hide');

            const new_data = getFormData();

            // Update dans la BDD
            fetch('Objectifs/UpdateObjectif.php', {
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
                    affichageListeObjectif.updateObjectif(data);
                })
                .catch((error) => {
                    console.error('Error:', error);
                    toast("Echec de la modification");
                });
        }
    }

    function setInfosObjectif(id_obj_patient) {
        fetch('Objectifs/ReadOneObjectif.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_obj_patient": id_obj_patient}),
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
                form.setAttribute("data-id_obj_patient", data.id_obj_patient);
                // pré-rempli les valeurs du formulaire
                nomInput.value = data.nom_objectif;
                dateDebut.value = data.date_objectif_patient;
                descriptionInput.value = data.desc_objectif;

                if (data.pratique === 'Autonome') {
                    pratiqueSelect.value = '2';
                } else {
                    pratiqueSelect.value = '1';
                }
                typeActiviteInput.value = data.type_activite;
                dureeInput.value = data.duree;
                frequenceInput.value = data.frequence;
                infosComplementairesInput.value = data.infos_complementaires;
                handlePratiqueChange();
            })
            .catch((error) => {
                console.error('Error setInfosObjectif:', error);
            });
    }

    function setInfosAvancement(id_obj_patient) {
        form.setAttribute("data-id_obj_patient", id_obj_patient);
        fetch('Objectifs/ReadAllAvancementPatient.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_obj_patient": id_obj_patient}),
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
                form.setAttribute("data-id_obj_patient", id_obj_patient);
                fillTableauAvancement(data);
            })
            .catch((error) => {
                console.error('Error setInfosAvancement:', error);
            });
    }

    function fillTableauAvancement(data) {
        removeChildren(bodyAvancement);
        let isTermine = false;
        if (Array.isArray(data) && data?.length > 0) {
            for (const avancement of data) {
                bodyAvancement.append(createAvancementRow(avancement));
                if (avancement.atteinte === 'Atteint') {
                    isTermine = isTermine || true;
                }
            }
        } else {
            bodyAvancement.append(createEmptyRow());
        }

        toggleChampDisabled(isTermine);
    }

    function createAvancementRow(avancement) {
        const tr = document.createElement('tr');
        tr.id = 'tr-' + avancement.id_avancement_obj;

        const td1 = document.createElement('td');
        td1.textContent = avancement.date_avancement;

        const td2 = document.createElement('td');
        td2.textContent = avancement.atteinte;

        const td3 = document.createElement('td');
        td3.textContent = avancement.commentaires;

        const td4 = document.createElement('td');

        const supprimerButton = document.createElement('button');
        supprimerButton.textContent = 'Supprimer';
        supprimerButton.className = 'btn btn-danger btn-sm';
        td4.append(supprimerButton);

        supprimerButton.onclick = (event) => {
            event.preventDefault();

            handleDeleteAvancementClick(avancement.id_avancement_obj);
        };

        tr.append(td1, td2, td3, td4);

        return tr;
    }

    function createEmptyRow() {
        const tr = document.createElement('tr');
        tr.id = 'empty-tr-avancement';

        const td = document.createElement('td');
        td.textContent = 'Aucun avancement pour cet objectif.';
        td.colSpan = 4;

        tr.append(td);

        return tr;
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

    function handleDeleteAvancementClick(id_avancement_obj) {
        warningModal.modal('show');
        warningText.textContent = 'Supprimer l\'avancement?';

        getConfirmation().then(is_delete => {
            if (is_delete) {
                fetch('Objectifs/DeleteAvancement.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({'id_avancement_obj': id_avancement_obj}),
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
                        toast("Avancement supprimé avec succes");
                        affichageListeObjectif.deleteAvancement(id_avancement_obj);
                        // suppresion du tableau
                        deleteAvancementTableau(id_avancement_obj);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        toast("Echec de la suppression de l'avancement");
                    });
            }
        });
    }

    function deleteAvancementTableau(id_avancement_obj) {
        const tr = document.getElementById('tr-' + id_avancement_obj);
        tr.remove();

        if (bodyAvancement.firstChild == null) {
            bodyAvancement.append(createEmptyRow());
        }
    }

    function handleDeleteClick(id_obj_patient) {
        warningModal.modal('show');
        warningText.textContent = 'Supprimer l\'objectif?';

        getConfirmation().then(is_delete => {
            if (is_delete) {
                fetch('Objectifs/DeleteObjectif.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({'id_obj_patient': id_obj_patient}),
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
                        toast("Objectif supprimé avec succes");
                        affichageListeObjectif.deleteObjectif(id_obj_patient);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        toast("Echec de la suppression de l'objectif");
                    });
            }
        });
    }

    function handleAvancementClick() {
        form.onsubmit = (event) => {
            event.preventDefault();
            const new_data = getFormData();

            // Insert dans la BDD
            fetch('Objectifs/CreateAvancement.php', {
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
                    toast("Avancement ajouté avec succès");
                    affichageListeObjectif.addAvancement(data);

                    const emptyTr = document.getElementById('empty-tr-avancement');
                    if (emptyTr != null) {
                        emptyTr.remove();
                    }

                    bodyAvancement.append(createAvancementRow(data));
                    if (data.atteinte === 'Atteint') {
                        toggleChampDisabled(true);
                    }
                    form.reset();
                })
                .catch((error) => {
                    console.error('Error:', error);
                    toast("Echec de l'ajout");
                });
        };
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

    function areAllFieldsEmpty() {
        let res = nomInput.value === '' && dateDebut.value === '' && descriptionInput.value === '';

        if (pratiqueSelect.value === '2') {
            res = res &&
                typeActiviteInput.value === '' &&
                dureeInput.value === '' &&
                frequenceInput.value === '' &&
                infosComplementairesInput.value === '';
        }

        return res;
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

    function toggleDonneesProDisabled(on) {
        if (on) {
            $("#field-autonomie").hide();
            typeActiviteInput.removeAttribute('required');
            dureeInput.removeAttribute('required');
            frequenceInput.removeAttribute('required');
        } else {
            $("#field-autonomie").show();
            typeActiviteInput.setAttribute('required', '');
            dureeInput.setAttribute('required', '');
            frequenceInput.setAttribute('required', '');
        }
    }

    function toggleMainDisabled(on) {
        if (on) {
            $("#main-field").hide();
            nomInput.removeAttribute('required');
            dateDebut.removeAttribute('required');
            descriptionInput.removeAttribute('required');
        } else {
            $("#main-field").show();
            nomInput.setAttribute('required', '');
            dateDebut.setAttribute('required', '');
            descriptionInput.setAttribute('required', '');
        }
    }

    function toggleAvancementDisabled(on) {
        if (on) {
            $("#avancement").hide();
            $("#avancement-add").hide();
            dateAvancementInput.removeAttribute('required');
            inlineRadio1.removeAttribute('required');
        } else {
            $("#avancement").show();
            $("#avancement-add").show();
            dateAvancementInput.setAttribute('required', '');
            inlineRadio1.setAttribute('required', '');
        }
    }

    function toggleAvancement(on) {
        toggleDonneesProDisabled(on);
        toggleMainDisabled(on);
        toggleAvancementDisabled(!on);
    }

    function handlePratiqueChange() {
        if (pratiqueSelect.value === "2") {
            toggleDonneesProDisabled(false);
        } else {
            toggleDonneesProDisabled(true);
        }
    }

    /**
     *
     * @param mode {MODE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE.ADD) {
            modalTitle.textContent = "Ajout objectif";
            warningText.textContent = 'Quitter sans enregistrer?';
            form.reset();
            toggleChampDisabled(false);
            toggleAvancement(false);
            handlePratiqueChange();

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");
            close.textContent = 'Abandon';

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleCreateClick);
            enregistrerOuModifier.textContent = "Enregistrer";
            $("#enregistrer-modifier").show();

            confirmclosed.addEventListener("click", handleWarningCloseClick);
            confirmclosed.removeEventListener("click", handleWarningCloseSuppressionClick);
        } else if (mode === MODE.EDIT) {
            modalTitle.textContent = "Modifier objectif";
            warningText.textContent = 'Quitter sans enregistrer?';
            toggleChampDisabled(false);
            toggleAvancement(false);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");
            close.textContent = 'Abandon';

            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleUpdateClick);
            enregistrerOuModifier.textContent = "Enregistrer";
            $("#enregistrer-modifier").show();

            confirmclosed.addEventListener("click", handleWarningCloseClick);
            confirmclosed.removeEventListener("click", handleWarningCloseSuppressionClick);
        } else if (mode === MODE.AVANCEMENT) {
            modalTitle.textContent = "Avancement objectif";
            warningText.textContent = 'Quitter sans enregistrer?';
            form.reset();
            toggleChampDisabled(false);
            toggleAvancement(true);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");
            close.textContent = 'Quitter';

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.addEventListener("click", handleAvancementClick);
            $("#enregistrer-modifier").hide();

            confirmclosed.removeEventListener("click", handleWarningCloseClick);
            confirmclosed.addEventListener("click", handleWarningCloseSuppressionClick);
        }
    }

    return {
        init,
        setInfosObjectif,
        setInfosAvancement,
        setModalMode,
        handleDeleteClick
    };
})();