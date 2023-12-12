"use strict";

// les différents modes d'interaction avec le modal
const MODE = {
    ADD_CRENEAU: 'add_creneau',
    EMAGER: 'emarger',
    SUPPRIMER: 'supprimer',
    DUPLIQUER: 'dupliquer'
};
Object.freeze(MODE);

// les différents états possible d'une séance
const ETAT_SEANCE = {
    VALIDEE: 'Séance validée',
    EN_ATTENTE_REALISATION: 'Séance en attente de réalisation',
    EN_ATTENTE_VALIDATION: 'Séance en attente de validation',
    EN_ATTENTE_EMARGEMENT: 'Séance en attente d\'émargement'
};
Object.freeze(ETAT_SEANCE);

let modalSeance = (function () {
    // le bouton qui ouvre le modal
    const ajoutModalButton = document.getElementById("ajout-modal");
    const supprModalButton = document.getElementById("supprimer");
    const bodyEmargement = document.getElementById('body-emargement');
    const form = document.getElementById('form');

    const listeParticipantsFieldset = document.getElementById('liste-participants');
    const ajoutFieldset = document.getElementById('ajout');
    const detailsFieldset = document.getElementById('details');
    const supprFieldset = document.getElementById('suppression');
    const dupliFieldset = document.getElementById('dupli');

    // champ creneau instance
    const creneauTypeSelect = document.getElementById('creneauType');
    const intervenantCreneauSelect = document.getElementById('intervenantCreneau');
    const dateActiviteInput = document.getElementById('dateActivite');
    const creneauRecursif = $("input[name='recurs']:checked")[0];
    const commentaireInput = document.getElementById('commentaire');
    const dateFinInput = document.getElementById('dateFinRecurs');

    const dateDupli = document.getElementById('dateDupli');

    // warning modal
    const $warningModal = $("#warning-modal");
    const warningModalText = document.getElementById("warning-modal-text");
    const warningModalConfirmButton = document.getElementById("warning-modal-confirm");
    const warningModalRefuseButton = document.getElementById("warning-modal-refuse");

    // seance modal
    const $mainModal = $("#modal");
    const modalTitle = document.getElementById("modal-title");

    // boutons du modal
    const $extraClose = $("#extraClose");
    const enregistrer = document.getElementById("enregistrer");
    const close = document.getElementById("close");
    const valider = document.getElementById("valider");
    const retour = document.getElementById("retour");
    const dupliquer = document.getElementById("dupliquer");

    const boutonEnregistrer = document.getElementById("boutonEnregistrer");
    const boutonClose = document.getElementById("boutonClose");
    const boutonSupprimer = document.getElementById("boutonSupprimer");
    const boutonValider = document.getElementById("boutonValider");
    const boutonRetour = document.getElementById("boutonRetour");
    const boutonDupliquer = document.getElementById("boutonDupliquer");

    const nom_creneau = document.getElementById('detail-nom-creneau');
    const nom_structure = document.getElementById('detail-struct');
    const intervenant = document.getElementById('detail-interv');
    const lieu = document.getElementById('detail-lieu');
    const type = document.getElementById('detail-type');
    const parcours = document.getElementById('detail-parcours');
    const date = document.getElementById('detail-date');
    const h_debut = document.getElementById('detail-debut');
    const h_fin = document.getElementById('detail-fin');
    const etat = document.getElementById('detail-etat');
    const extra = document.getElementById('detail-extra-link');
    const id_seance = document.getElementById('detail-id-seance');
    const motifSuppr = document.getElementById('motifSuppr');

    // div récursion
    const divRecurs = document.getElementById('recurs_block');

    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    // la div qui contient le bouton de suppression de séances (environnement de test)

    const init = function () {
        ajoutModalButton.onclick = function (event) {
            event.preventDefault();
            setModalMode(MODE.ADD_CRENEAU);
        };

        supprModalButton.onclick = function (event) {
            event.preventDefault();
            setModalMode(MODE.SUPPRIMER);
        };

        retour.onclick = function () {
            setModalMode(MODE.EMAGER);
            setInfosSeance(id_seance.value);
        };

        dupliquer.onclick = function (event) {
            event.preventDefault();
            setModalMode(MODE.DUPLIQUER);
        };

        const elemsRadio = form.elements["recurs"];
        for (const radio of elemsRadio) {
            radio.addEventListener('click', handleRecursChange);
        }
    };

    function toast(msg) {
        // rend le toast visible
        toastDiv.className = "show";
        toastDiv.textContent = msg;

        // After 2 seconds, remove the show class from DIV
        setTimeout(function () {
            toastDiv.className = toastDiv.className.replace("show", "");
        }, 2000);
    }

    function handleRecursChange() {
        const val = getSelectedRadioValue(form, 'recurs');
        divRecurs.hidden = val !== "true";
    }

    function handleCreateEmargement() {
        form.onsubmit = (event) => {
            event.preventDefault();

            getConfirmation("Émarger la séance? La séance ne pourra plus être déplacée, supprimée ou modifiée.").then(async is_ok => {
                if (is_ok) {
                    $mainModal.modal('hide');
                    const new_data = getDataEmargement();

                    // Insert dans la BDD
                    fetch('Seances/CreateEmargement.php', {
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
                            calendrier.updateCalendar();
                            toast("Séance émargée avec succès");
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            toast("Echec de l'émargement.");
                        });
                }
            });
        }
    }

    function handleDupliquerSeance() {
        form.onsubmit = (event) => {
            event.preventDefault();

            getConfirmation("Dupliquer la séance?").then(async is_ok => {
                if (is_ok) {
                    $mainModal.modal('hide');
                    const new_data = getDataDupliSeance();

                    // Insert dans la BDD
                    fetch('Seances/DupliquerSeance.php', {
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
                            calendrier.updateCalendar();
                            toast("Séance dupliquée avec succès");
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
    }

    function handleCreateSeance() {
        form.onsubmit = (event) => {
            event.preventDefault();

            getConfirmation("Créer la séance?").then(async create_ok => {
                if (create_ok) {
                    $mainModal.modal('hide');
                    const new_data = getDataSeance();

                    // Insert dans la BDD
                    fetch('Seances/CreateSeance.php', {
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
                            calendrier.updateCalendar();
                            toast("Séance ajoutée avec succès");
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
    }

    function handleSuppressionSeance() {
        form.onsubmit = (event) => {
            event.preventDefault();

            getConfirmation("Supprimer la séance?").then(async create_ok => {
                if (create_ok) {
                    $mainModal.modal('hide');
                    const new_data = getDataSupprSeance();

                    // Insert dans la BDD
                    fetch('Seances/AnnulationSeance.php', {
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
                            calendrier.removeSeance(id_seance.value);
                            toast("Séance supprimée avec succès");
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            toast("Échec de la suppression.");
                        });
                }
            });
        }
    }

    function handleValiderSeance() {
        form.onsubmit = (event) => {
            event.preventDefault();

            getConfirmation("Valider la séance? L’émargement ne pourra plus être modifié.").then(async is_ok => {
                if (is_ok) {
                    $mainModal.modal('hide');

                    // Insert dans la BDD
                    fetch('Seances/ValidateSeance.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({"id_seance": id_seance.value}),
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
                            calendrier.updateCalendar();
                            toast("Séance validée avec succès");
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            toast("Échec de la validation.");
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

    function handleConfirmCloseClick() {
        getConfirmation('Quitter sans enregistrer?')
            .then(ok => {
                $warningModal.modal('hide');
                if (ok) {
                    $mainModal.modal('hide');
                }
            });
    }

    function toggleFieldSetListeParticipantsHidden(on) {
        if (on) {
            bodyEmargement.childNodes.forEach(tr => {
                tr.childNodes[1]?.firstChild.removeAttribute('required');
            });
        } else {
            bodyEmargement.childNodes.forEach(tr => {
                tr.childNodes[1]?.firstChild.setAttribute('required', '');
            });
        }

        listeParticipantsFieldset.hidden = on;
    }

    function toggleFieldSetDetailsHidden(on) {
        detailsFieldset.hidden = on;
    }

    function toggleModalSetSupprHidden(on) {
        if (on) {
            motifSuppr.removeAttribute('required');
        } else {
            motifSuppr.setAttribute('required', '');
        }

        supprFieldset.hidden = on;
    }

    function toggleButtonSetSupprHidden(on) {
        supprModalButton.hidden = on;
    }

    function toggleButtonSetDupliHidden(on) {
        if (on) {
            dateDupli.removeAttribute('required');
        } else {
            dateDupli.setAttribute('required', '');
        }

        dupliFieldset.hidden = on;
    }

    function toggleFieldSetAjoutHidden(on) {
        if (on) {
            creneauTypeSelect.removeAttribute('required');
            intervenantCreneauSelect.removeAttribute('required');
            dateActiviteInput.removeAttribute('required');

        } else {
            creneauTypeSelect.setAttribute('required', '');
            intervenantCreneauSelect.setAttribute('required', '');
            dateActiviteInput.setAttribute('required', '');
        }

        ajoutFieldset.hidden = on;
    }

    function toggleFieldSetSupprHidden(on) {
        if (on) {
            motifSuppr.removeAttribute('required');
        } else {
            motifSuppr.setAttribute('required', '');
        }
    }

    function resetForm() {
        form.reset();

        removeChildren(bodyEmargement);
        modalDetailsSeance.resetForm();
    }

    function removeChildren(elem) {
        while (elem.firstChild) {
            elem.firstChild.remove();
        }
    }

    function getDataEmargement() {
        const listeEmargement = [];
        const emargements = document.querySelectorAll('.emargement-element');
        const id_seance = form.getAttribute("data-id_seance");
        for (const emargementElem of emargements) {
            const id_patient = emargementElem.getAttribute('data-id_patient');
            listeEmargement.push({
                'id_patient': id_patient,
                'present': getSelectedRadioValue(form, 'id_patient-' + id_patient),
                'excuse': form.elements['excuse-id_patient-' + id_patient].checked ? '1' : '0',
                'commentaire': emargementElem.value,
            });
        }

        return {
            'id_seance': id_seance,
            'emargements': listeEmargement,
        };
    }

    function getDataSeance() {
        return {
            'id_creneau': creneauTypeSelect.value,
            'id_user': intervenantCreneauSelect.value,
            'date': dateActiviteInput.value,
            'commentaire': commentaireInput.value,
            'recurs': $("input[name='recurs']:checked")[0].value,
            'date_fin': dateFinInput.value,
        };
    }

    function getDataSupprSeance() {
        return {
            'id_seance': id_seance.value,
            'id_motif_annulation': motifSuppr.value
        };
    }

    function getDataDupliSeance() {
        const parts = date.innerHTML.split('/');
        return {
            'id_seance': id_seance.value,
            'dateFin': dateDupli.value,
            'date': parts[2] + '-' + parts[1] + '-' + parts[0]
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

    function setInfosEmargement(id_creneau, id_seance) {
        resetForm();
        fetch('Seances/ReadListeParticipantsSeance.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_seance": id_seance}),
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
                if (!Array.isArray(data) || data.length === 0) {
                    throw {error: "Pas de patient"};
                }

                form.setAttribute("data-id_seance", id_seance);
                bodyEmargement.innerHTML = '';

                // ajout de la liste des participants
                let allEmarger = true;
                let valid = true;
                if (Array.isArray(data)) {
                    for (const participant of data) {
                        if (participant['presence'] == null) {
                            allEmarger = false;
                        }
                        if (participant['valider'] === 0) {
                            valid = false;
                        }
                        bodyEmargement.append(createLigne(participant));
                    }
                }

                modalDetailsSeance.setParticipants(data);

                if (allEmarger === true) {
                    etat.innerHTML = "Séance émargé en attente de validation";
                    activateListeParticipant(true);
                    activateBoutonValider(true);
                    activateBoutonEmarger(true);
                    activateBoutonSuppr(false);
                }
                if (valid === true) {
                    etat.innerHTML = "Séance validé";
                    activateListeParticipant(false);
                    activateBoutonValider(false);
                    activateBoutonEmarger(false);
                    activateBoutonSuppr(false);
                }
            })
            .catch((error) => {
                console.error('Error recup infos creneau:', error);
                form.setAttribute("data-id_seance", id_seance);

                const emptyRow = document.createElement('tr');

                const td = document.createElement('td');
                td.setAttribute('colspan', '4');
                td.textContent = 'Aucun patient pour ce créneau.';
                activateBoutonEmarger(false);

                bodyEmargement.innerHTML = '';
                emptyRow.append(td);
                bodyEmargement.append(emptyRow);
            });
    }

    function activateListeParticipant(on) {
        if (on) {
            listeParticipantsFieldset.removeAttribute('disabled');
        } else {
            listeParticipantsFieldset.setAttribute('disabled', '');
        }
    }

    function activateBoutonValider(on) {
        if (on) {
            valider.removeAttribute('disabled');
        } else {
            valider.setAttribute('disabled', '');
        }
    }

    function activateBoutonSuppr(on) {
        if (on) {
            supprModalButton.removeAttribute('disabled');
        } else {
            supprModalButton.setAttribute('disabled', '');
        }
    }

    function activateBoutonEmarger(on) {
        if (on) {
            enregistrer.removeAttribute('disabled');
        } else {
            enregistrer.setAttribute('disabled', '');
        }
    }

    function setInfosSeance(seance) {
        fetch('Seances/RecupOneInfosSeance.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_seance": seance}),
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
                // ajout de la liste des participants
                nom_creneau.innerHTML = data['nom_creneau'];
                nom_structure.innerHTML = data['nom_structure'];
                intervenant.innerHTML = data['nom_intervenant'] + " " + data['prenom_intervenant'];
                lieu.innerHTML = data['adresse'];
                type.innerHTML = data['type_seance'];
                parcours.innerHTML = data['type_parcours'];
                id_seance.value = seance;

                let parts = data['date_seance'].split('-');
                date.innerHTML = parts[2] + '/' + parts[1] + '/' + parts[0];
                h_debut.innerHTML = data['heure_debut'].substr(0, 5);
                h_fin.innerHTML = data['heure_fin'].substr(0, 5);
                extra.textContent = "Détails";
                extra.className = "clickable";

                modalDetailsSeance.setInfosDetailsSeance(data);

                let today = new Date();
                let nowDate = today.toISOString().split('T')[0];

                if (data['date_seance'] > nowDate) {
                    etat.innerHTML = "Séance en attente de réalisation";
                    activateListeParticipant(false);

                    activateBoutonEmarger(false);
                    activateBoutonSuppr(true);
                    activateBoutonValider(false);
                } else if (data['valider'] === 0) {
                    etat.innerHTML = "Séance en attente d'émargement";
                    activateListeParticipant(true);
                    activateBoutonValider(false);
                    activateBoutonEmarger(true);
                    activateBoutonSuppr(true);
                } else {
                    etat.innerHTML = "Séance validé";
                    activateListeParticipant(false);
                    activateBoutonValider(false);
                    activateBoutonEmarger(false);
                    activateBoutonSuppr(false);
                }
            })
            .catch((error) => {
                console.error('Error recup infos creneau:', error);
            });
    }

    function createLigne(participant) {
        let row = document.createElement('tr');

        let td1 = document.createElement('td');
        td1.className = "text-left";
        td1.textContent = participant.nom_patient + ' ' + participant.prenom_patient;

        let td2 = document.createElement('td');
        td2.style.textAlign = 'center';

        const inputPresent = document.createElement('input');
        inputPresent.setAttribute('required', '');
        inputPresent.type = 'radio';
        inputPresent.value = '1';
        inputPresent.name = 'id_patient-' + participant.id_patient;
        if (participant.presence === 1) {
            inputPresent.checked = true;
        }

        td2.append(inputPresent);

        let td3 = document.createElement('td');
        td3.style.textAlign = 'center';

        const inputAbsent = document.createElement('input');
        inputAbsent.type = 'radio';
        inputAbsent.value = '0';
        inputAbsent.name = 'id_patient-' + participant.id_patient;
        if (participant.presence === 0) {
            inputAbsent.checked = true;
        }
        td3.append(inputAbsent);

        let excuseCb = document.createElement('input');
        excuseCb.type = 'checkbox';
        excuseCb.name = 'excuse-id_patient-' + participant.id_patient;
        if (participant.excuse === 1) {
            excuseCb.checked = true;
        }

        let td4 = document.createElement('td');
        td4.style.textAlign = 'center';
        td4.append(excuseCb);

        let td5 = document.createElement('td');
        td5.className = "text-left";

        const inputCommentaire = document.createElement('input');
        inputCommentaire.type = 'text';
        inputCommentaire.style.width = '100%';
        inputCommentaire.placeholder = 'Commentaire';
        inputCommentaire.className = 'emargement-element';
        inputCommentaire.setAttribute('data-id_patient', participant.id_patient);

        inputCommentaire.setAttribute('value', participant.commentaire);

        td5.append(inputCommentaire);

        function handleEmargementChange(event) {
            if (inputPresent.checked) {
                excuseCb.checked = false;
                excuseCb.disabled = true;
            } else if (inputAbsent.checked) {
                excuseCb.disabled = false;
            } else {
                excuseCb.disabled = true;
            }
        }

        inputPresent.onchange = handleEmargementChange;
        inputAbsent.onchange = handleEmargementChange;
        handleEmargementChange();

        row.append(td1, td2, td3, td4, td5);

        return row;
    }

    /**
     *
     * @param mode {MODE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE.ADD_CRENEAU) {
            modalTitle.textContent = "Ajout de séance";
            resetForm();

            changerCreneau(listPEPS);
            toggleFieldSetListeParticipantsHidden(true);
            toggleFieldSetAjoutHidden(false);
            toggleFieldSetDetailsHidden(true);
            toggleModalSetSupprHidden(true);
            toggleFieldSetSupprHidden(true);
            toggleButtonSetSupprHidden(true);
            toggleButtonSetDupliHidden(true);
            activateBoutonEmarger(true);
            handleRecursChange();

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrer.addEventListener("click", handleCreateSeance);
            enregistrer.removeEventListener("click", handleCreateEmargement);
            enregistrer.removeEventListener("click", handleSuppressionSeance);
            enregistrer.removeEventListener("click", handleDupliquerSeance);

            enregistrer.removeAttribute("data-dismiss");
            enregistrer.textContent = "Enregistrer";

            boutonClose.hidden = false;
            boutonEnregistrer.hidden = false;
            boutonSupprimer.hidden = true;
            boutonValider.hidden = true;
            boutonRetour.hidden = true;
            boutonDupliquer.hidden = true;

        } else if (mode === MODE.EMAGER) {
            modalTitle.textContent = "Émarger";
            //resetForm();
            toggleFieldSetListeParticipantsHidden(false);
            toggleFieldSetAjoutHidden(true);
            toggleFieldSetDetailsHidden(false);
            toggleFieldSetSupprHidden(false);
            toggleModalSetSupprHidden(true);
            toggleButtonSetSupprHidden(true);
            toggleButtonSetDupliHidden(true);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrer.addEventListener("click", handleCreateEmargement);
            enregistrer.removeEventListener("click", handleCreateSeance);
            enregistrer.removeEventListener("click", handleSuppressionSeance);
            enregistrer.removeEventListener("click", handleDupliquerSeance);

            enregistrer.removeAttribute("data-dismiss");
            enregistrer.textContent = "Émarger";

            valider.addEventListener("click", handleValiderSeance);
            valider.removeAttribute("data-dismiss");

            boutonClose.hidden = false;
            boutonEnregistrer.hidden = false;
            boutonSupprimer.hidden = false;
            boutonValider.hidden = false;
            boutonRetour.hidden = true;
            boutonDupliquer.hidden = false;

        } else if (mode === MODE.SUPPRIMER) {
            modalTitle.textContent = "Suppression";
            //resetForm();
            toggleModalSetSupprHidden(false);
            toggleFieldSetListeParticipantsHidden(true);
            toggleFieldSetAjoutHidden(true);
            toggleFieldSetDetailsHidden(true);
            toggleFieldSetSupprHidden(false);
            toggleButtonSetDupliHidden(true);
            activateBoutonEmarger(true);

            toggleButtonSetSupprHidden(true);

            enregistrer.addEventListener("click", handleSuppressionSeance);
            enregistrer.removeEventListener("click", handleCreateSeance);
            enregistrer.removeEventListener("click", handleCreateEmargement);
            enregistrer.removeEventListener("click", handleDupliquerSeance);

            enregistrer.removeAttribute("data-dismiss");
            enregistrer.textContent = "Valider suppression";

            boutonClose.hidden = false;
            boutonEnregistrer.hidden = false;
            boutonSupprimer.hidden = true;
            boutonValider.hidden = true;
            boutonRetour.hidden = false;
            boutonDupliquer.hidden = true;
        } else if (mode === MODE.DUPLIQUER) {
            modalTitle.textContent = "Duplication de la séance";
            //resetForm();
            toggleModalSetSupprHidden(true);
            toggleFieldSetListeParticipantsHidden(true);
            toggleFieldSetAjoutHidden(true);
            toggleFieldSetDetailsHidden(true);
            toggleFieldSetSupprHidden(true);
            toggleButtonSetDupliHidden(false);
            activateBoutonEmarger(true);

            toggleButtonSetSupprHidden(true);

            enregistrer.addEventListener("click", handleDupliquerSeance);
            enregistrer.removeEventListener("click", handleSuppressionSeance);
            enregistrer.removeEventListener("click", handleCreateSeance);
            enregistrer.removeEventListener("click", handleCreateEmargement);

            enregistrer.removeAttribute("data-dismiss");
            enregistrer.textContent = "Dupliquer la séance";

            boutonClose.hidden = false;
            boutonEnregistrer.hidden = false;
            boutonSupprimer.hidden = true;
            boutonValider.hidden = true;
            boutonRetour.hidden = false;
            boutonDupliquer.hidden = true;
        }
    }

    return {
        init,
        setInfosSeance,
        setInfosEmargement,
        setModalMode
    };
})();

let calendrier = (function () {
    let listStructure = [];
    let id_user;

    const structureRadio = document.getElementById('structure-choice');

    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    let listeBenef = document.getElementById("ConteneurGauche");
    let calSeance = document.getElementById("div_cal");
    let supprButton = document.getElementById('supprButton');

    let dateInit;
    let dayInit;

    let dateAft;
    let dayAft;

    let calendar;
    let calendarEl = document.getElementById('calendar');
    const $listColor = ["#fd0000", "#0620d3", "#d36c06", "#6206d3", "#d306aa", "#06d395", "#99d306", "#06a3d3", "#2dff00"];

    function init() {
        id_user = localStorage.getItem('id_user');

        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay',
                month: 'mois'
            },
            buttonText: {
                today: 'aujourd\'hui',
                month: 'mois',
                week: 'semaine',
                day: 'jour',
                list: 'list'
            },

            locale: 'fr',
            initialView: 'timeGridWeek',
            weekNumberCalculation: 'ISO',
            editable: true,
            slotMinTime: "07:00:00",
            slotMaxTime: "23:00:00",
            allDaySlot: false,
            handleWindowResize: true,
            height: 'auto',
            eventStartEditable: true,
            eventResizableFromStart: true,
            eventDurationEditable: true,

            eventClick: function (info) {
                modalSeance.setModalMode(MODE.EMAGER);
                modalSeance.setInfosSeance(info.event.id);
                modalSeance.setInfosEmargement(info.event.extendedProps.id_creneau, info.event.id);
                $('#modal').modal('show');
            },
            eventDragStart: function (event, info) {
                dateInit = new Date(event.event.startStr.substring(0, 10))
                dayInit = dateInit.getDay();
            },
            eventDrop: function (event, revertFunc) {
                dateAft = new Date(event.event.startStr.substring(0, 10));
                dayAft = dateAft.getDay();

                if (event.event.extendedProps.jour === "8" || dayAft === dayInit) {
                    if (!confirm(event.event.title +
                        " a été déplacé à l'horaire de " + event.event.startStr.substring(11, 19) + " à " +
                        event.event.endStr.substring(11, 19) + "\n" + " Etes-vous sûr de ce changement ?"
                    )) {
                        event.revert();
                    } else {
                        updateSeance(event);
                    }
                } else {
                    event.revert();
                    toast("Ce jour n'est pas disponible pour ce type de créneau");
                }
            },
            eventResize: function (event, revertFunc) {
                if (!confirm(event.event.title +
                    " a été déplacé de " + event.event.startStr.substring(11, 19) + " à " +
                    event.event.endStr.substring(11, 19) + "\n" + " Etes-vous sûr de ce changement ?"
                )) {
                    event.revert();
                } else {
                    updateSeance(event);
                }
            },
            eventDidMount: function (event) {
                // filtrage des séances
                const filterValue = getSelectedRadioValue('structureOption');
                if (filterValue !== "all" && filterValue !== event.event.extendedProps.nom_structure) {
                    event.el.style.display = "none";
                }

                // ajout logo custom si séance réalisé
                if (event.event.extendedProps.statusSeance !== ETAT_SEANCE.EN_ATTENTE_REALISATION) {
                    const span = document.createElement("span");
                    span.setAttribute("aria-hidden", "true");
                    span.classList.add("glyphicon");

                    if (event.event.extendedProps.statusSeance === ETAT_SEANCE.VALIDEE) {
                        span.classList.add("glyphicon-ok");
                    } else if (event.event.extendedProps.statusSeance === ETAT_SEANCE.EN_ATTENTE_EMARGEMENT) {
                        span.classList.add("glyphicon-remove");
                    } else if (event.event.extendedProps.statusSeance === ETAT_SEANCE.EN_ATTENTE_VALIDATION) {
                        span.classList.add("glyphicon-alert");
                    }

                    event.el.querySelector('.fc-event-title').append(" ", span);
                }

                $(event.el).tooltip({
                    title: event.event.extendedProps.statusSeance,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            },
            eventWillUnmount: function (info) {
                $(info.el).tooltip('destroy');
            },
            events: function (info, successCallback, failureCallback) {
                fetch('Seances/ReadAllSeance.php', {
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
                        const allEvents = [];
                        data.forEach(s => {
                            allEvents.push(createEventFromSeance(s));
                        });
                        successCallback(allEvents);
                    })
                    .catch((error) => {
                        console.error('Error recup infos séances:', error);
                        failureCallback(error);
                    });
            }
        });
        calendar.render();

        structureRadio.addEventListener('change', () => {
            calendar.refetchEvents();
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

    function getDataSeance(event) {
        return {
            'id_seance': event.event.id,
            'date': event.event.startStr.substring(0, 10),
            'heure_debut': event.event.startStr.substring(11, 19),
            'heure_fin': event.event.endStr.substring(11, 19),
        };
    }

    /**
     * Affichage le tableau des bénéficiaires
     */
    function displayTableauBeneficiaires() {
        if(supprButton) {
            supprButton.style.display = "none";
        }
        listeBenef.hidden = false;
        calSeance.hidden = true;
    }

    /**
     * Affichage le calendrier
     */
    function displayCalendrier() {
        if(supprButton) {
            supprButton.style.display = "block";
        }
        listeBenef.hidden = true;
        calSeance.hidden = false;

        // nécessaire car sinon le calendrier ne s'affiche pas correctement si c'est le tableau qui est affiché en premier
        if (typeof calendar !== 'undefined') {
            calendar.render();
        }
    }

    function getSelectedRadioValue(name) {
        const elemsRadio = document.getElementsByName(name);

        for (const radio of elemsRadio) {
            if (radio.checked) {
                return radio.value;
            }
        }

        return '';
    }

    /**
     * @param seance object
     */
    function createEventFromSeance(seance) {
        // ajout aux boutons radios
        if (listStructure.indexOf(seance.nom_structure) === -1) {
            listStructure.push(seance.nom_structure);
            const div = document.createElement('div');
            div.classList.add('radio');

            const input = document.createElement('input');
            input.name = 'structureOption';
            input.value = seance.nom_structure;
            input.type = 'radio';

            const label = document.createElement('label');

            const text = document.createTextNode(seance.nom_structure);
            div.append(label);
            label.append(input, text);

            structureRadio.append(div);
        }

        const event_can_be_edited = seance.etat === ETAT_SEANCE.EN_ATTENTE_REALISATION ||
            seance.etat === ETAT_SEANCE.EN_ATTENTE_EMARGEMENT;

        return {
            id: seance.id_seance,
            title: seance.nom_creneau,
            start: seance.date_seance + "T" + seance.heure_debut,
            end: seance.date_seance + "T" + seance.heure_fin,
            nom_structure: seance.nom_structure,
            backgroundColor: $listColor[listStructure.indexOf(seance.nom_structure)],
            commentaire: seance.commentaire_seance,
            valider: seance.valider,
            id_creneau: seance.id_creneau,
            jour: seance.jour,
            statusSeance: seance.etat,
            startEditable: event_can_be_edited,
            durationEditable: event_can_be_edited,
            editable: event_can_be_edited,
        };
    }

    /**
     * Mise à jour de la séance dans la BDD
     * @param event
     */
    function updateSeance(event) {
        fetch('Seances/UpdateSeance.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(getDataSeance(event)),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    /**
     * Récupère de nouveau les séances du calendrier
     */
    function updateCalendar() {
        calendar.refetchEvents();
    }

    /**
     * Suppression d'une séance du calendrier
     *
     * @param id
     */
    function removeSeance(id) {
        calendar.getEventById(id).remove();
    }

    return {
        init,
        removeSeance,
        displayTableauBeneficiaires,
        displayCalendrier,
        updateCalendar
    };
})();