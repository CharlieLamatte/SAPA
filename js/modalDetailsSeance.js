"use strict";
// les différents modes d'interaction avec le modal détails de séance
const MODE_DETAILS = {
    EDIT_ALL: 'EDIT_ALL',
    EDIT_COMMENTAIRE_ONLY: 'EDIT_COMMENTAIRE_ONLY',
    READONLY: 'READONLY'
};
Object.freeze(MODE_DETAILS);

let modalDetailsSeance = (function () {
        // warning modal
        const $warningModal = $("#warning-modal");
        const warningModalText = document.getElementById("warning-modal-text");
        const warningModalConfirmButton = document.getElementById("warning-modal-confirm");
        const warningModalRefuseButton = document.getElementById("warning-modal-refuse");

        const $mainModal = $("#modal");

        const $extraModal = $("#extraModal");
        const extraModal = document.getElementById("extraModal");
        const extraClose = document.getElementById("extraClose");

        //champs de la modale supplémentaire des détails de la séance
        const extraNomCreneau = document.getElementById('extra_nom_creneau');
        const extraTypeCreneau = document.getElementById('extra_type_creneau');
        const extraDate = document.getElementById('extra_date');
        const extraHeureDebut = document.getElementById('extra_heure_debut');
        const extraHeureFin = document.getElementById('extra_heure_fin');
        const extraCommentaire = document.getElementById('extra_commentaire');
        const extraStructure = document.getElementById('extra_nom_structure');
        const extraInterv = document.getElementById('extra_intervenant');
        const extraAdresse = document.getElementById('extra_adresse');
        const extraComplAdresse = document.getElementById('extra_complement-adresse');
        const extraCodePostal = document.getElementById('extra_code-postal');
        const extraVille = document.getElementById('extra_ville');
        const extraBodyParticipant = document.getElementById('extra-body-participants');
        const extraParticipantSelect = document.getElementById('extra-patients-all');
        const extraModifierButton = document.getElementById('extraModifier');
        const boutonAjoutParticipant = document.getElementById("extra-ajout-participant-button");

        const openDetailLink = document.getElementById('detail-extra-link');

        // la div qui sert de toast
        const toastDiv = document.getElementById("toast");

        let urls;

        function init(_urls) {
            urls = _urls;

            extraModifierButton.onclick = function (event) {
                event.preventDefault();
                if (extraCommentaire.disabled === true) {
                    const etat = extraModal.getAttribute('data-etat');
                    if (etat === ETAT_SEANCE.EN_ATTENTE_EMARGEMENT || etat === ETAT_SEANCE.EN_ATTENTE_REALISATION) {
                        setMode(MODE_DETAILS.EDIT_ALL);
                    } else {
                        setMode(MODE_DETAILS.EDIT_COMMENTAIRE_ONLY);
                    }
                } else {
                    handleUpdateSeance();
                }
            };

            boutonAjoutParticipant.onclick = function (event) {
                event.preventDefault();

                if (extraParticipantSelect.options.length > 0) {
                    const participant = {
                        'id_patient': extraParticipantSelect.value,
                        'nom_patient': extraParticipantSelect.options[extraParticipantSelect.selectedIndex].getAttribute('data-nom'),
                        'prenom_patient': extraParticipantSelect.options[extraParticipantSelect.selectedIndex].getAttribute('data-prenom'),
                    };

                    let not_already_added = true;
                    for (const tr of extraBodyParticipant.childNodes) {
                        if (tr.getAttribute('data-id_patient') === null || tr.getAttribute('data-id_patient') === '') {
                            tr.remove();
                        }
                        if (participant.id_patient === tr.getAttribute('data-id_patient')) {
                            not_already_added = false;
                            break;
                        }
                    }

                    if (not_already_added) {
                        extraBodyParticipant.append(createLigneDetails(participant));
                    }
                }
            };

            if (openDetailLink) {
                openDetailLink.onclick = handleOpenClick;
            }
        }

        function handleConfirmCloseExtraClick() {
            getConfirmation('Quitter sans enregistrer?')
                .then(ok => {
                    $warningModal.modal('hide');
                    if (ok) {
                        $extraModal.modal('hide');
                    }
                });
        }

        // click affichage des détail en readOnly
        function handleOpenClick(event) {
            event.preventDefault();

            setMode(MODE_DETAILS.READONLY);
            $extraModal.modal('show');
        }

        function handleUpdateSeance() {
            getConfirmation("Modifier la séance?").then(async is_ok => {
                if (is_ok) {
                    $mainModal.modal('hide');
                    const new_data = getDataDetailsSeance();

                    // Insert dans la BDD
                    fetch(urls.urlUpdateSeance, {
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
                            toast("Séance modifier avec succès");
                            $mainModal.modal('hide');
                            $extraModal.modal('hide');
                            if (typeof calendrier !== 'undefined') {
                                calendrier.init();
                            }
                            if (typeof tableauSeance !== 'undefined') {
                                tableauSeance.replaceRowValues(data);
                            }
                        })
                        .catch((error) => {
                            $mainModal.modal('hide');
                            $extraModal.modal('hide');
                            console.error('Error:', error);
                            toast("Echec de la mise à jour des données de la séance");
                        });
                }
            });
        }

        function getDataDetailsSeance() {
            const participants = [];
            const participantsElems = document.querySelectorAll('.liste-participant-element');
            for (const elem of participantsElems) {
                participants.push(elem.getAttribute('data-id_patient'));
            }

            return {
                'commentaire': extraCommentaire.value,
                'date': extraDate.value,
                'heure_debut': extraHeureDebut.value,
                'heure_fin': extraHeureFin.value,
                'id_seance': extraModal.getAttribute('data-id_seance'),
                'participants': participants,
            };
        }

        function createLigneDetails(participant) {
            let row = document.createElement('tr');
            row.setAttribute('data-id_patient', participant.id_patient);
            row.className = "liste-participant-element";

            let td1 = document.createElement('td');
            td1.textContent = participant.nom_patient;
            let td2 = document.createElement('td');
            td2.textContent = participant.prenom_patient;

            let td3 = document.createElement('td');
            td3.className = "text-left extra-form";

            const inputAbsent = document.createElement('input');
            inputAbsent.type = 'button';
            inputAbsent.value = 'X';
            inputAbsent.className = 'extra-form';

            inputAbsent.onclick = function () {
                extraBodyParticipant.deleteRow(this.parentNode.parentNode.rowIndex - 1);
            }

            td3.append(inputAbsent);

            row.append(td1, td2, td3);
            return row;
        }

        function setParticipants(data) {
            extraBodyParticipant.innerHTML = '';
            if (Array.isArray(data)) {
                for (const participant of data) {
                    extraBodyParticipant.append(createLigneDetails(participant));
                }
            }
        }

        function fetchInfosSeance(id_seance) {
            const seance = fetch(urls.urlRecupOneInfosSeance, {
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
                    return data;
                })
                .catch((error) => {
                    console.error('Error recup infos seance:', error);
                    return null
                });

            const listeParticipants = fetch(urls.urlReadListeParticipantsSeance, {
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
                    return data;
                })
                .catch((error) => {
                    console.error('Error recup infos seance:', error);
                    return null
                });

            Promise.all([seance, listeParticipants])
                .then(result => {
                    if (result[0] && result[1]) {
                        setInfosDetailsSeance(result[0]);
                        setParticipants(result[1]);
                    }
                })
                .catch(e => console.error(e));
        }

        function setInfosDetailsSeance(data) {
            extraModal.setAttribute('data-id_seance', data['id_seance']);
            extraModal.setAttribute('data-etat', data['etat']);

            //informations pour la modale des détails supplémentaires de la séance
            extraNomCreneau.value = data['nom_creneau'];
            extraTypeCreneau.value = data['id_type_parcours'];
            extraDate.value = data['date_seance'];
            extraHeureDebut.value = data['id_heure_debut'];
            extraHeureFin.value = data['id_heure_fin'];
            extraCommentaire.value = data['commentaire_seance'] ?? "";

            extraStructure.value = data['nom_structure'];
            extraInterv.value = data['nom_intervenant'] + " " + data['prenom_intervenant'];
            extraAdresse.value = data['adresse'];
            extraComplAdresse.value = data['complement_adresse'];
            extraCodePostal.value = data['code_postal'];
            extraVille.value = data['nom_ville'];
        }

        function resetForm() {
            removeChildren(extraBodyParticipant);
        }

        function removeChildren(elem) {
            while (elem.firstChild) {
                elem.firstChild.remove();
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

        /**
         *
         * @param on boolean si les champs modifiables (qui ont la classe 'extra-form") sont disabled
         */
        function disableAllChampExtra(on) {
            $('.extra-form').prop('disabled', on);
        }

        function setMode(mode) {
            if (mode === MODE_DETAILS.EDIT_ALL) {
                disableAllChampExtra(false);
                extraModifierButton.innerHTML = 'Enregistrer les modifications';

                extraClose.addEventListener("click", handleConfirmCloseExtraClick);
                extraClose.removeAttribute("data-dismiss");
            } else if (mode === MODE_DETAILS.EDIT_COMMENTAIRE_ONLY) {
                disableAllChampExtra(true);
                extraCommentaire.disabled = false; // seul champ commentaire modifiable
                extraModifierButton.innerHTML = 'Enregistrer les modifications';

                extraClose.addEventListener("click", handleConfirmCloseExtraClick);
                extraClose.removeAttribute("data-dismiss");
            } else if (mode === MODE_DETAILS.READONLY) {
                disableAllChampExtra(true);
                extraModifierButton.textContent = 'Modifier la séance';

                extraClose.removeEventListener("click", handleConfirmCloseExtraClick);
                extraClose.setAttribute("data-dismiss", "modal");
            }
        }

        return {
            init,
            setParticipants,
            setInfosDetailsSeance,
            fetchInfosSeance,
            resetForm,
            handleOpenClick
        };
    }
)();