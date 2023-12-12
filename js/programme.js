"use strict";

// les différents modes d'interaction avec le modal
const MODE = {
    ADD: 'add',
    READ: 'read'
};
Object.freeze(MODE);

$(document).ready(function () {
    // initialisation des élements de la page
    listeFinOrientation.init();
    finProgramme.init();
});

let listeFinOrientation = (function () {
    // le formulaire
    const form = document.getElementById("form-user");

    const open_details = document.getElementsByClassName('open-modal');

    // les div qui servent de conteneur pour les listes
    const unAnDiv = document.getElementById("div-1-an");
    const deuxAnsDiv = document.getElementById("div-2-ans");
    const sortieDiv = document.getElementById("div-sortie");

    let init = function () {
        const questionnaire1an = fetch('Questionnaire/ReadAllQuestionnairesPatient.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                'id_patient': form.getAttribute("data-id_patient"),
                'id_questionnaire': '5'
            }),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .catch(() => null);

        const questionnaire2ans = fetch('Questionnaire/ReadAllQuestionnairesPatient.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                'id_patient': form.getAttribute("data-id_patient"),
                'id_questionnaire': '6'
            }),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .catch(() => null);

        const questionnaireMotifSortie = fetch('Questionnaire/ReadAllQuestionnairesPatient.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                'id_patient': form.getAttribute("data-id_patient"),
                'id_questionnaire': '7'
            }),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .catch(() => null);

        Promise.all([questionnaire1an, questionnaire2ans, questionnaireMotifSortie])
            .then(result => {
                actualiserInfos(result[0], unAnDiv);
                actualiserInfos(result[1], deuxAnsDiv);
                actualiserInfos(result[2], sortieDiv);
            });
    };

    function actualiserInfos(finOrientations, div) {
        if (Array.isArray(finOrientations)) {
            for (const finOrientation of finOrientations) {
                div.append(createCommentaireElement(finOrientation));
            }
        }
    }

    function deleteFinOrientation(id_fin_orientation) {
        const table = document.getElementById('table-' + id_fin_orientation);

        table.remove();
    }

    function createCommentaireElement(finOrientation) {
        const table = document.createElement('table');
        table.className = 'table-objectif';
        table.id = 'table-' + finOrientation.id_questionnaire_instance;

        const br = document.createElement('br');

        const tr = document.createElement('tr');

        const tdDate = document.createElement('td');
        tdDate.className = 'objectif-td-date';

        const spanDate1 = document.createElement('span');
        spanDate1.textContent = 'Enregistré le';
        const spanDate2 = document.createElement('span');
        spanDate2.id = 'date-' + finOrientation.id_questionnaire_instance;
        spanDate2.textContent = finOrientation.date;

        tdDate.append(spanDate1, br, spanDate2);

        const tdAvis = document.createElement('td');
        tdAvis.className = 'objectif-td-avis';

        const bold = document.createElement('b');
        bold.textContent = 'Evaluateur: ';

        const spanText2 = document.createElement('span');
        spanText2.id = 'commentaire-' + finOrientation.id_questionnaire_instance;
        spanText2.textContent = finOrientation.nom + ' ' + finOrientation.prenom;

        const mainSpan = document.createElement('span');
        mainSpan.append(bold, spanText2, br.cloneNode());
        tdAvis.append(mainSpan);

        const tdBouttons = document.createElement('td');
        tdBouttons.className = 'objectif-td-boutons';

        const modifier = document.createElement('button');
        modifier.setAttribute("data-toggle", "modal");
        modifier.setAttribute("data-target", "#modal");
        modifier.setAttribute("data-backdrop", "static");
        modifier.setAttribute("data-keyboard", "false");

        modifier.setAttribute("data-id_questionnaire_instance", finOrientation.id_questionnaire_instance);
        modifier.setAttribute("data-id_questionnaire", finOrientation.id_questionnaire);
        modifier.setAttribute("data-keyboard", "false");

        modifier.className = 'btn btn-warning btn-sm open-modal';
        modifier.textContent = 'Détails';

        modifier.onclick = () => {
            finProgramme.setModalMode(MODE.READ);
            finProgramme.setDetails(finOrientation.id_questionnaire, finOrientation.id_questionnaire_instance, true);
        };

        const supprimer = document.createElement('button');
        supprimer.className = 'btn btn-danger btn-sm';
        supprimer.textContent = 'Supprimer';
        tdBouttons.append(modifier, br.cloneNode(), br.cloneNode(), supprimer);

        supprimer.onclick = () => {
            finProgramme.handleDeleteClick(finOrientation.id_questionnaire_instance);
        };

        tr.append(tdDate, tdAvis, tdBouttons);
        table.append(tr);

        return table;
    }

    function addElement(finOrientation) {
        if (finOrientation.id_questionnaire == 5) {
            unAnDiv.append(createCommentaireElement(finOrientation));
        } else if (finOrientation.id_questionnaire == 6) {
            deuxAnsDiv.append(createCommentaireElement(finOrientation));
        } else if (finOrientation.id_questionnaire == 7) {
            sortieDiv.append(createCommentaireElement(finOrientation));
        }
    }

    return {
        init,
        addElement,
        deleteFinOrientation
    };
})();

const finProgramme = (function () {
    const mainDiv = document.getElementById('main');

    const form = document.getElementById('form-user');

    const orientationButton = document.getElementById('orientation-button');
    const finButton = document.getElementById('fin-button');
    const sortieButton = document.getElementById('sortie-button');

    // les 2 modals
    const $mainModal = $('#modal');
    const $warningModal = $('#warning');
    const warningText = document.getElementById('warning-text');
    const modalTitle = document.getElementById("modal-title");

    // boutons du modal
    //const confirmclosedButton = $("#confirmclosed");
    const enregistrerOuModifier = document.getElementById("enregistrer-modifier");
    const close = document.getElementById("close");

    const confirmclosed = document.getElementById('confirmclosed');
    const refuseclosed = document.getElementById('refuseclosed');

    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    function init() {
        orientationButton.onclick = (event) => {
            const id_questionnaire = '5';

            form.setAttribute('data-id_questionnaire', id_questionnaire);
            setDetails(id_questionnaire, null, false);
            setModalMode(MODE.ADD);
        };

        finButton.onclick = (event) => {
            const id_questionnaire = '6';

            form.setAttribute('data-id_questionnaire', id_questionnaire);
            setDetails(id_questionnaire, null, false);
            setModalMode(MODE.ADD);
        };

        sortieButton.onclick = (event) => {
            const id_questionnaire = '7';

            form.setAttribute('data-id_questionnaire', id_questionnaire);
            setDetails(id_questionnaire, null, false);
            setModalMode(MODE.ADD);
        };

        confirmclosed.addEventListener("click", function () {
            $warningModal.modal('hide');
            $mainModal.modal('hide');
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

    function togglePanelVisible(panel, panelOui, panelNon) {
        if (panel === 'oui') {
            panelOui.hidden = false;
            panelNon.hidden = true;
            form.elements['reponse-70']?.forEach(
                radio => radio.setAttribute('required', '')
            );
            form.elements['reponse-74']?.forEach(
                radio => radio.setAttribute('required', '')
            );
        } else if (panel === 'non') {
            panelOui.hidden = true;
            panelNon.hidden = false;
            form.elements['reponse-70']?.forEach(
                radio => radio.removeAttribute('required')
            );
            form.elements['reponse-74']?.forEach(
                radio => radio.removeAttribute('required')
            );
        } else {
            panelOui.hidden = true;
            panelNon.hidden = true;
            form.elements['reponse-70']?.forEach(
                radio => radio.removeAttribute('required')
            );
            form.elements['reponse-74']?.forEach(
                radio => radio.removeAttribute('required')
            );
        }
    }

    function fillOutQuestionnaire(data, readonly) {
        const elems = form.elements;

        for (const obj of data) {
            if (obj.nom_type_reponse === 'qcm_liste') {
                const divListe = document.getElementById('div-liste');

                if (Array.isArray(obj.liste)) {
                    obj.liste.forEach(
                        structure => divListe.append(createStructureElement(structure, obj, readonly))
                    );
                }
            } else if (obj.nom_type_reponse === 'qcm') {
                elems['reponse-' + obj.id_question]?.forEach(e => {
                    if (e.value == obj.id_qcm) {
                        e.checked = obj.reponse == 1;
                    }
                });
            } else {
                elems['reponse-' + obj.id_question].value = obj.reponse;
            }
        }

        // initialisation des panels
        let rep = '';
        if (elems['reponse-68']) {
            rep = 'reponse-68';
        } else if (elems['reponse-72']) {
            rep = 'reponse-72';
        }

        const panelOui = document.getElementById('oui-panel');
        const panelNon = document.getElementById('non-panel');

        if (rep !== '' && panelOui && panelNon) {
            if (elems[rep].value === '1' || elems[rep].value === '2') {
                togglePanelVisible('oui', panelOui, panelNon);
            } else if (elems[rep].value === '3') {
                togglePanelVisible('non', panelOui, panelNon);
            }
        }
    }

    function setDetails(id_questionnaire, id_questionnaire_instance, readonly) {
        const questionnaire = fetch('Questionnaire/ReadQuestionnaire.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_questionnaire": id_questionnaire}),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .catch(() => null);

        let questionnaireInstance = null;
        if (id_questionnaire_instance) {
            questionnaireInstance = fetch('Questionnaire/ReadQuestionnaireInstance.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({"id_questionnaire_instance": id_questionnaire_instance}),
            })
                .then(response => {
                    if (!response.ok) {
                        throw {
                            statusCode: response.status,
                        };
                    }
                    return response.json()
                })
                .catch(() => null);
        }

        Promise.all([questionnaire, questionnaireInstance])
            .then(result => {
                mainDiv.innerHTML = '';
                modalTitle.textContent = result[0]?.nom_questionnaire;
                createQuestionnaire(result[0], mainDiv, false, readonly, false);

                const panelOui = document.getElementById('oui-panel');
                const panelNon = document.getElementById('non-panel');

                if (panelOui && panelNon) {
                    togglePanelVisible('none', panelOui, panelNon);
                }

                form.elements['reponse-68']?.forEach(radio => {
                    radio.onclick = (event) => {
                        if (event.target.value === '1' || event.target.value === '2') {
                            togglePanelVisible('oui', panelOui, panelNon);
                        } else if (event.target.value === '3') {
                            togglePanelVisible('non', panelOui, panelNon);
                        }
                    };
                });

                form.elements['reponse-72']?.forEach(radio => {
                    radio.onclick = (event) => {
                        if (event.target.value === '1' || event.target.value === '2') {
                            togglePanelVisible('oui', panelOui, panelNon);
                        } else if (event.target.value === '3') {
                            togglePanelVisible('non', panelOui, panelNon);
                        }
                    };
                });

                if (result[1]) {
                    fillOutQuestionnaire(result[1].reponses, readonly);
                }
            });
    }

    function handleConfirmCloseClick() {
        $warningModal.modal('show');
    }

    function handleCreateClick() {
        form.onsubmit = (event) => {
            event.preventDefault();

            $mainModal.modal('hide');
            fetch('Questionnaire/CreateQuestionnaireInstance.php', {
                method: 'POST',
                body: JSON.stringify(getData(form))
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
                    listeFinOrientation.addElement(data);

                    // valeur actuelle
                    const archive_value = form.getAttribute("data-est_archive");

                    // on propose d'archiver le patient s'il ne l'est pas encore
                    if (archive_value === "0") {
                        $warningModal.modal('show');
                        warningText.textContent = 'Archiver le patient? (Il ne sera plus visible dans la liste des patients)';

                        getConfirmation()
                            .then(ok => {
                                $warningModal.modal('hide');

                                if (ok) {
                                    const data = {
                                        "id_patient": form.getAttribute("data-id_patient"),
                                        "is_archived": true
                                    };

                                    // Update dans la BDD
                                    fetch('UpdatePatientArchiveStatus.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify(data),
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
                                            form.setAttribute("data-est_archive", "1")
                                            toast("Patient archivé avec succès.");
                                        })
                                        .catch((error) => {
                                            console.error('Error:', error);
                                            toast("Echec de l'archivage");
                                        });
                                }
                            });
                    }
                })
                .catch((error) => {
                    console.error('CreateQuestionnaireInstance Error:', error);
                });
        };
    }

    function handleDeleteClick(id_questionnaire_instance) {
        $warningModal.modal('show');
        warningText.textContent = 'Supprimer le commentaire?';

        getConfirmation().then(is_delete => {
            if (is_delete) {
                fetch('Questionnaire/DeleteQuestionnaireInstance.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({'id_questionnaire_instance': id_questionnaire_instance}),
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
                        toast("Supprimé avec succès");
                        listeFinOrientation.deleteFinOrientation(id_questionnaire_instance);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        toast("Echec de la suppression");
                    });
            }
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

    /**
     *
     * @param mode {MODE} Le mode du modal
     * @param title le titre du modal
     */
    function setModalMode(mode, title) {
        if (mode === MODE.ADD) {
            if (typeof title !== 'undefined') {
                modalTitle.textContent = title;
            }
            warningText.textContent = 'Quitter sans enregistrer?';
            form.reset();

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.addEventListener("click", handleCreateClick);
            enregistrerOuModifier.textContent = "Enregistrer";
            enregistrerOuModifier.style.visibility = 'visible';
        } else {
            if (typeof title !== 'undefined') {
                modalTitle.textContent = title;
            }
            warningText.textContent = 'Quitter sans enregistrer?';

            close.removeEventListener("click", handleConfirmCloseClick);
            close.setAttribute("data-dismiss", 'modal');

            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.style.visibility = 'hidden';
        }
    }

    return {
        init,
        setDetails,
        setModalMode,
        handleDeleteClick
    };
})();