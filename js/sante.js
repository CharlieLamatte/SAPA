"use strict";

/**
 * Ce fichier nécessite:
 * observations.js
 * commun.js
 */

/**
 * si un champ pathologie a été modifié sans être enregistré
 * @type {boolean}
 */
var g_pathologieModified = false;

$(document).ready(function () {
    // initialisation des élements de la page
    confirmExitPage.init();
    observationsDetails.init(
        'Observation/ReadAllObservations.php',
        'Observation/CreateObservation.php',
        TYPE_OBSERVATION.SANTE
    );
    pathologiesDetails.init();
    aldDetails.init();
});

let confirmExitPage = (function () {
    function init() {
        window.onbeforeunload = function (event) {
            if (g_pathologieModified) {
                return "Quitter sans enregistrer les pathologies?";
            } else {
                return null;
            }
        }
    }

    return {
        init
    };
})();

/**
 * Affichage du détails des pathologies sur la page
 */
let pathologiesDetails = (function () {
    // le modal
    const form = document.getElementById('form-details-pathologies');

    // les champs
    const cardio = document.getElementById('detail-cardio');
    const respi = document.getElementById('detail-respi');
    const metabo = document.getElementById('detail-metabo');
    const osteo = document.getElementById('detail-osteo');
    const neuro = document.getElementById('detail-neuro');
    const psycho = document.getElementById('detail-psycho');
    const cancero = document.getElementById('detail-cancero');
    const circul = document.getElementById('detail-circul');
    const autre = document.getElementById('detail-autre');

    const allFields = document.querySelectorAll('.field-patho');

    // boutton qui permet d'enregistrer les modifications
    const modifyButton = document.getElementById('modifier-pathologie');

    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    const nomsPatho = [
        "cardio",
        "respi",
        "metabo",
        "osteo",
        "neuro",
        "psycho",
        "cancero",
        "circul",
        "autre",
    ];

    const init = function () {
        const id_patient = form.getAttribute("data-id_patient");

        let pathologies = fetch('Sante/ReadOnePathologie.php', {
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
            .catch(() => null);

        // on rempli le détail des pathologies quand toutes les données ont été récupérés
        Promise.all([pathologies])
            .then(result => {
                if (result[0] != null) {
                    setDetails(result[0]);
                }
            });

        modifyButton.onclick = (event) => {
            const id_pathologie = form.getAttribute("data-id_pathologie");
            if (id_pathologie != null && id_pathologie !== '') {
                handleUpdate();
            } else {
                handleCreate();
            }
            g_pathologieModified = false;
        };

        nomsPatho.forEach(nom => {
            form.elements['a-patho-' + nom]?.forEach(
                r => {
                    r.onclick = () => {
                        if (r.value === "0") {
                            document.getElementById('detail-' + nom + '-row').style.display = "none";
                        } else {
                            document.getElementById('detail-' + nom + '-row').style.display = "block";
                        }
                    }
                }
            )
        });

        allFields.forEach(
            f => f.addEventListener('input',
                () => g_pathologieModified = true)
        );
    };

    function handleUpdate() {
        const new_data = getFormData();

        // Update dans la BDD
        fetch('Sante/UpdatePathologie.php', {
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
                toast("Pathologies modifiées avec succès");
            })
            .catch((error) => {
                console.error('Error:', error);
                toast("Echec de la modification");
            });
    }

    function handleCreate() {
        const new_data = getFormData();

        // Update dans la BDD
        fetch('Sante/CreatePathologie.php', {
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
                toast("Pathologies modifiées avec succès");
                form.setAttribute("data-id_pathologie", data.id_pathologie);
            })
            .catch((error) => {
                console.error('Error:', error);
                toast("Echec de la modification");
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

    function getFormData() {
        return {
            "id_patient": form.getAttribute("data-id_patient"),
            "id_pathologie": form.getAttribute("data-id_pathologie"),
            "cardio": cardio.value,
            "respiratoire": respi.value,
            "metabolique": metabo.value,
            "osteo_articulaire": osteo.value,
            "neuro": neuro.value,
            "psycho_social": psycho.value,
            "cancero": cancero.value,
            "autre": autre.value,
            "circulatoire": circul.value,

            'a_patho_cardio': form.elements['a-patho-cardio'].value,
            'a_patho_respiratoire': form.elements['a-patho-respi'].value,
            'a_patho_metabolique': form.elements['a-patho-metabo'].value,
            'a_patho_osteo_articulaire': form.elements['a-patho-osteo'].value,
            'a_patho_psycho_social': form.elements['a-patho-psycho'].value,
            'a_patho_neuro': form.elements['a-patho-neuro'].value,
            'a_patho_cancero': form.elements['a-patho-cancero'].value,
            'a_patho_circulatoire': form.elements['a-patho-circul'].value,
            'a_patho_autre': form.elements['a-patho-autre'].value,
        };
    }

    function setDetails(pathologies) {
        form.setAttribute("data-id_pathologie", pathologies.id_pathologie);
        cardio.textContent = pathologies.cardio;
        respi.textContent = pathologies.respiratoire;
        metabo.textContent = pathologies.metabolique;
        osteo.textContent = pathologies.osteo_articulaire;
        neuro.textContent = pathologies.neuro;
        psycho.textContent = pathologies.psycho_social;
        cancero.textContent = pathologies.cancero;
        circul.textContent = pathologies.circulatoire;
        autre.textContent = pathologies.autre;

        form.elements['a-patho-cardio'].value = pathologies.a_patho_cardio;
        form.elements['a-patho-respi'].value = pathologies.a_patho_respiratoire;
        form.elements['a-patho-metabo'].value = pathologies.a_patho_metabolique;
        form.elements['a-patho-osteo'].value = pathologies.a_patho_osteo_articulaire;
        form.elements['a-patho-neuro'].value = pathologies.a_patho_neuro;
        form.elements['a-patho-psycho'].value = pathologies.a_patho_psycho_social;
        form.elements['a-patho-cancero'].value = pathologies.a_patho_cancero;
        form.elements['a-patho-circul'].value = pathologies.a_patho_circulatoire;
        form.elements['a-patho-autre'].value = pathologies.a_patho_autre;

        setDisplay('detail-cardio-row', form.elements['a-patho-cardio'].value === "1");
        setDisplay('detail-respi-row', form.elements['a-patho-respi'].value === "1");
        setDisplay('detail-metabo-row', form.elements['a-patho-metabo'].value === "1");
        setDisplay('detail-osteo-row', form.elements['a-patho-osteo'].value === "1");
        setDisplay('detail-neuro-row', form.elements['a-patho-neuro'].value === "1");
        setDisplay('detail-psycho-row', form.elements['a-patho-psycho'].value === "1");
        setDisplay('detail-cancero-row', form.elements['a-patho-cancero'].value === "1");
        setDisplay('detail-circul-row', form.elements['a-patho-circul'].value === "1");
        setDisplay('detail-autre-row', form.elements['a-patho-autre'].value === "1");
    }

    /**
     *
     * @param id l'id de l'élement que l'on souhaite cacher/afficher
     * @param display si l'élement est affiché
     */
    function setDisplay(id, display) {
        if (display) {
            document.getElementById(id).style.display = "block";
        } else {
            document.getElementById(id).style.display = "none";
        }
    }

    return {
        init,
        setDetails
    };
})();

const aldDetails = (function () {
    const mainDiv = document.getElementById('main');
    const id_patient = mainDiv.getAttribute('data-id_patient');

    // bouton qui ouvre le modal
    const openModalButton = document.getElementById('open-modal-ald');

    const $mainModal = $('#modal');

    // le formulaire
    const form = document.getElementById('form-sante-pathologies');

    // l'affichage des alds
    const aldTextarea = document.getElementById('detail-ald');

    const modalTitle = document.getElementById("modal-title");
    const aldFieldset = document.getElementById("fieldset-ald");
    const conteneurAld = document.getElementById('conteneur-ald');

    const radioDiv = document.getElementById('radio-div');

    const $conteneurAld = $('#conteneur-ald');

    // radio
    const radioOui = document.getElementById('a_une_ald-oui');
    const radioNon = document.getElementById('a_une_ald-non');
    const radioNspp = document.getElementById('a_une_ald-nspp');

    const init = function () {
        // les alds du patient
        const alds_patient = fetch('Sante/ReadAllPatientALD.php', {
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
            .catch(() => null);

        // la liste de tous les ALD
        const liste_ald = fetch('Sante/ReadAllALD.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
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

        // on rempli le détail des observations quand toutes les données ont été récupérées
        Promise.all([alds_patient, liste_ald])
            .then(result => {
                setDetails(result[0]);
                displayAld(result[1]);
            });

        radioDiv.onchange = handleRadioChange;

        openModalButton.onclick = function () {
            modalTitle.textContent = 'Affections de longue durée';
            form.reset();

            // les alds du patient
            const alds_patient = fetch('Sante/ReadAllPatientALD.php', {
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
                .catch(() => null);

            Promise.all([alds_patient])
                .then(result => {
                    setDetailModal(result[0]);
                    handleRadioChange();
                    toggleRequiredHidden(true);

                    aldFieldset.removeAttribute('hidden');

                    form.onsubmit = function (event) {
                        event.preventDefault();

                        handleUpdate();
                        $mainModal.modal('hide');
                    };
                });
        };
    };

    function handleRadioChange() {
        if (getSelectedRadioValue(form, 'a_une_ald') === 'oui') {
            $conteneurAld.show();
        } else if (getSelectedRadioValue(form, 'a_une_ald') === 'non') {
            $conteneurAld.hide();
        } else {
            $conteneurAld.hide();
        }
    }

    function setDetails(alds) {
        aldTextarea.textContent = '';
        if (Array.isArray(alds)) {
            if (alds.length === 0) {
                aldTextarea.textContent += 'Le patient ne souffre d\'aucune ald\n';
            }
            for (const ald of alds) {
                addAld(ald);
            }
        } else {
            aldTextarea.textContent += 'Le patient ne souffre d\'aucune ald\n';
        }
    }

    function addAld(ald) {
        if (ald.id_pathologie_ou_etat === '-1') {
            aldTextarea.textContent += 'Le patient ne se prononce pas\n';
        } else {
            aldTextarea.textContent += '  ' + ald.nom_type_pathologie + ': ' + ald.nom_pathologie_ou_etat + '\n';
        }
    }

    function displayAld(liste_ald) {
        if (Array.isArray(liste_ald)) {
            for (const ald of liste_ald) {
                getOrCreateTypePathologieFieldset(ald).childNodes[1].append(createInputRow(ald, 'checkbox'));
            }
        }
    }

    function getOrCreateTypePathologieFieldset(ald) {
        const fieldsets = document.getElementsByClassName('type-pathologie-fieldset');

        let exists = false;
        let fieldset;
        for (const element of fieldsets) {
            if (element.getAttribute('data-id_type_pathologie') == ald.id_type_pathologie) {
                exists = true;
                fieldset = element;
                break;
            }
        }

        if (exists) {
            return fieldset;
        }

        fieldset = createFieldset(ald.nom_type_pathologie, ald.id_type_pathologie);
        conteneurAld.append(fieldset);

        return fieldset;
    }

    function createInputRow(ald, type) {
        const row = document.createElement('div');

        const colLabel1 = document.createElement('div');
        colLabel1.className = 'col-md-5';

        const colInput1 = document.createElement('div');
        colInput1.className = 'col-md-1';

        const input = document.createElement('input');
        input.type = type;
        input.id = ald.id_pathologie_ou_etat;
        input.className = 'ald-input';

        const label = document.createElement('label');
        label.textContent = ald.nom_pathologie_ou_etat;

        colLabel1.append(label);
        colInput1.append(input);
        row.append(colLabel1, colInput1);

        return row;
    }

    function createFieldset(nom_type_pathologie, id_type_pathologie) {
        const fieldset = document.createElement('div');
        fieldset.classList.add('type-pathologie-fieldset');
        fieldset.classList.add('section-noir-ald');
        fieldset.setAttribute('data-id_type_pathologie', id_type_pathologie);

        const legend = document.createElement('legend');
        legend.classList.add('group-modal-titre-ald');
        legend.textContent = nom_type_pathologie;

        const row = document.createElement('div');
        row.className = 'row';

        fieldset.append(legend, row);

        return fieldset;
    }

    function getFormData() {
        const new_data = {
            'id_patient': id_patient,
            'liste_alds': []
        };
        if (getSelectedRadioValue(form, 'a_une_ald') === 'oui') {
            for (const elem of form.elements) {
                if (elem.className.includes('ald-input') &&
                    elem.type === 'checkbox' &&
                    elem.checked) {
                    new_data.liste_alds.push(elem.id);
                }
            }
        } else if (getSelectedRadioValue(form, 'a_une_ald') === 'nspp') {
            // le patient a l'ald 'Ne se prononce pas' (id='-1') dans la BDD
            new_data.liste_alds.push('-1');
        }

        return new_data;
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

    function handleUpdate() {
        // Update dans la BDD
        fetch('Sante/UpdateALD.php', {
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
                setDetails(data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    function setDetailModal(alds_patient) {
        if (alds_patient == null || alds_patient.length === 0) {
            radioNon.checked = true;
        } else if (alds_patient.length === 1 && alds_patient[0].id_pathologie_ou_etat == '-1') {
            radioNspp.checked = true;
        } else {
            radioOui.checked = true;
            for (const ald of alds_patient) {
                const input = document.getElementById(ald.id_pathologie_ou_etat);
                input.checked = true;
            }
        }
    }

    function toggleRequiredHidden(on) {
        if (on) {
            radioOui.setAttribute('required', '');
        } else {
            radioOui.removeAttribute('required');
        }
    }

    return {
        init
    };
})();