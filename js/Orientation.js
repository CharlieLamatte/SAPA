"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 * modalCreneau.js
 */

// si un champ est modifié sans être enregistré
var is_modified = false;

$(document).ready(function () {
    /**
     * Récupération des données en commun pour éviter de multiples requêtes
     */
    let villeData = fetch("../Villes/ReadAllVille.php", {
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
        .catch(() => null);
    let structureData = fetch('../Structures/ReadAllStructures.php', {
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
        .catch(() => null);

    // initialisation des élements de la page
    confirmExitPage.init();
    orientation.init();

    Promise.all([villeData, structureData])
        .then(result => {
            modalCreneau.init({
                'urlCreateCreneau': '../Creneaux/CreateCreneau.php',
                'urlUpdateCreneau': '../Creneaux/UpdateCreneau.php',
                'urlDeleteCreneau': '../Creneaux/DeleteCreneau.php',
                'urlReadCreneau': '../Creneaux/RecupOneInfosCreneau.php',
                'urlUpdateParticipants': '../Creneaux/Participants/UpdateParticipants.php',
                'urlReadParticipants': '../Creneaux/Participants/ReadAllParticipantsCreneau.php',
                'urlAutocompletionCodePostal': '../Villes/ReadAllVille.php',
                'urlReadAllIntervenantsStructure': '../Intervenants/ReadAllStructure.php',
                "urlReadAllStructures": "../Structures/ReadAllStructures.php"
            }, {
                villeData: result[0],
            });

            //Seuls des créneaux hors peps ("autre", valeur par défaut) peuvent être créés
            document.getElementById("type_creneau").disabled = true;

            modalStructure.init({
                "urlRechercheCPVille": "../Villes/ReadAllVille.php",
                "urlRecupInfosIntervenant": "../Intervenants/RecupInfosIntervenant.php",
                "urlReadOneStructure": "../Structures/ReadOneStructure.php",
                "urlCreateStructure": "../Structures/CreateStructure.php",
                "urlUpdateStructure": "../Structures/UpdateStructure.php",
                "urlDeleteStructure": "../Structures/DeleteStructure.php",
            }, {
                structureData: result[1],
                villeData: result[0],
            });
        });
});

let confirmExitPage = (function () {
    function init() {
        window.onbeforeunload = function (event) {
            if (is_modified) {
                return "Quitter sans enregistrer?";
            } else {
                return null;
            }
        }
    }

    return {
        init
    };
})();

const orientation = (function () {
    const ajoutActiviteButton = document.getElementById('ajout-activite');
    const abody = document.getElementById('abody');
    const form = document.getElementById('form');

    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    function init() {
        // recup des activités du patient
        const activites = fetch('./Orientation/ReadAllActivitesChoisies.php', {
            method: 'POST',
            body: JSON.stringify({'id_patient': form.getAttribute('data-id_patient')})
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
                console.error('Error:', error);
                return null;
            });

        const territoires = fetch('../Territoires/ReadAllTerritoires.php', {
            method: 'POST',
            body: JSON.stringify({'id_type_territoire': TYPE_TERRITOIRE.TYPE_TERRITOIRE_DEPARTEMENT})
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
                console.error('Error:', error);
                return null;
            });

        Promise.all([activites, territoires])
            .then(result => {
                addActivites(result[0], result[1]);

                // ajout d'une activité vide
                ajoutActiviteButton.onclick = function () {
                    abody.append(createActiviteElement({
                        'id_activite_choisie': '',
                        'statut': '',
                        'commentaire': '',
                        'date_demarrage': '',
                        'id_orientation': '',
                        'id_creneau': '',
                        'nom_creneau': '',
                        'nom_jour': '',
                        'heure_debut': '',
                        'heure_fin': '',
                        'nom_structure': '',
                        'id_structure': '',
                        'id_territoire': localStorage.getItem('id_territoire'),
                        'type_parcours': ''
                    }, result[1]));
                    updateNumerosActivites();
                    is_modified = true;
                };

                form.onsubmit = handleSubmitActivites;
                form.onchange = () => {
                    is_modified = true;
                };
            });
    }

    function addActivites(activites, territoires) {
        if (Array.isArray(activites)) {
            for (const activite of activites) {
                abody.append(createActiviteElement(activite, territoires));
            }

            updateNumerosActivites();
        }
    }

    function createActiviteElement(activite, territoires) {
        const fieldset = document.createElement('fieldset');
        fieldset.className = 'section-vert activite-elem';
        fieldset.setAttribute('data-id_activite_choisie', activite.id_activite_choisie);
        const titre = document.createElement('legend');
        titre.className = 'section-titre-vert';
        titre.textContent = 'Activité numéro';

        fieldset.append(titre);

        const span = document.createElement('span');
        span.style.color = 'red';
        span.textContent = '*';

        const span1 = span.cloneNode();
        span1.textContent = '*';

        // row 0
        const row0 = document.createElement('div');
        row0.className = 'row bottom-padding-list';

        const row0_td1 = document.createElement('div');
        row0_td1.className = 'col-md-2';
        const row0_td1_label = document.createElement('label');
        row0_td1_label.textContent = 'Territoire';

        row0_td1.append(row0_td1_label, span1);

        const row0_td2 = document.createElement('div');
        row0_td2.className = 'col-md-10';
        const row0_td2_select = document.createElement('select');
        row0_td2_select.className = 'form-control input-md';

        if (Array.isArray(territoires)) {
            for (const territoire of territoires) {
                const option = document.createElement('option');
                option.value = territoire.id_territoire;
                option.textContent = territoire.nom_territoire;

                if (territoire.id_territoire == activite.id_territoire) {
                    option.selected = true;
                }

                row0_td2_select.append(option);
            }
        }

        row0_td2.append(row0_td2_select);
        row0.append(row0_td1, row0_td2);

        // row 2
        const row2 = document.createElement('div');
        row2.className = 'row bottom-padding-list';

        const row2_td1 = document.createElement('div');
        row2_td1.className = 'col-md-2';
        const row2_td1_label = document.createElement('label');
        row2_td1_label.textContent = 'Nom créneau';

        row2_td1.append(row2_td1_label, span);

        const row2_td2 = document.createElement('div');
        row2_td2.className = 'col-md-10';
        const row2_td2_select = document.createElement('select');
        row2_td2_select.className = 'form-control input-md';
        row2_td2_select.setAttribute('required', '');

        row2_td2.append(row2_td2_select);
        row2.append(row2_td1, row2_td2);

        // row 1
        const row1 = document.createElement('div');
        row1.className = 'row bottom-padding-list';

        const row1_td1 = document.createElement('div');
        row1_td1.className = 'col-md-2';
        const row1_td1_label = document.createElement('label');
        row1_td1_label.textContent = 'Structure';

        row1_td1.append(row1_td1_label, span1);

        const row1_td2 = document.createElement('div');
        row1_td2.className = 'col-md-10';
        const row1_td2_select = document.createElement('select');
        row1_td2_select.className = 'form-control input-md';

        row1_td2.append(row1_td2_select);
        row1.append(row1_td1, row1_td2);

        // row 3
        const row3 = document.createElement('div');
        row3.className = 'row bottom-padding-list';

        const row3_td1 = document.createElement('div');
        row3_td1.className = 'col-md-2';
        const row3_td1_label = document.createElement('label');
        row3_td1_label.textContent = 'Jour';

        row3_td1.append(row3_td1_label);

        const row3_td2 = document.createElement('div');
        row3_td2.className = 'col-md-2';
        const row3_td2_input = document.createElement('input');
        row3_td2_input.className = 'form-control input-md';
        row3_td2_input.type = 'text';
        row3_td2_input.value = activite.nom_jour;
        row3_td2_input.setAttribute('readonly', '');

        row3_td2.append(row3_td2_input);

        const row3_td3 = document.createElement('div');
        row3_td3.className = 'col-md-2';
        const row3_td3_label = document.createElement('label');
        row3_td3_label.textContent = 'Heure de début';

        row3_td3.append(row3_td3_label);

        const row3_td4 = document.createElement('div');
        row3_td4.className = 'col-md-2';
        const row3_td4_input = document.createElement('input');
        row3_td4_input.className = 'form-control input-md';
        row3_td4_input.type = 'text';
        row3_td4_input.value = activite.heure_debut;
        row3_td4_input.setAttribute('readonly', '');

        row3_td4.append(row3_td4_input);

        const row3_td5 = document.createElement('div');
        row3_td5.className = 'col-md-2';
        const row3_td5_label = document.createElement('label');
        row3_td5_label.textContent = 'Heure de fin';

        row3_td5.append(row3_td5_label);

        const row3_td6 = document.createElement('div');
        row3_td6.className = 'col-md-2';
        const row3_td6_input = document.createElement('input');
        row3_td6_input.className = 'form-control input-md';
        row3_td6_input.type = 'text';
        row3_td6_input.value = activite.heure_fin;
        row3_td6_input.setAttribute('readonly', '');

        row3_td6.append(row3_td6_input);
        row3.append(row3_td1, row3_td2, row3_td3, row3_td4, row3_td5, row3_td6);

        // row 4
        const row4 = document.createElement('div');
        row4.className = 'row bottom-padding-list';

        const row4_td1 = document.createElement('div');
        row4_td1.className = 'col-md-2';
        const row4_td1_label = document.createElement('label');
        row4_td1_label.textContent = 'Statut';

        row4_td1.append(row4_td1_label);

        const row4_td2 = document.createElement('div');
        row4_td2.className = 'col-md-2';
        const row4_td2_select = document.createElement('select');
        row4_td2_select.className = 'form-control input-md';

        const option1 = document.createElement('option');
        const option2 = document.createElement('option');
        const option3 = document.createElement('option');
        const option4 = document.createElement('option');

        option1.textContent = 'En cours';
        option2.textContent = 'Testée';
        option3.textContent = 'En attente';
        option4.textContent = 'Terminée';

        option1.value = '1';
        option2.value = '2';
        option3.value = '3';
        option4.value = '4';

        if (activite.statut === 'En cours') {
            option1.selected = true;
        } else if (activite.statut === 'Testée') {
            option2.selected = true;
        } else if (activite.statut === 'En attente') {
            option3.selected = true;
        } else if (activite.statut === 'Terminée') {
            option4.selected = true;
        }

        row4_td2_select.append(option1, option2, option3, option4);
        row4_td2.append(row4_td2_select);

        const row4_td3 = document.createElement('div');
        row4_td3.className = 'col-md-2';
        const row4_td3_label = document.createElement('label');
        row4_td3_label.textContent = 'Date de démarrage';

        row4_td3.append(row4_td3_label);

        const row4_td4 = document.createElement('div');
        row4_td4.className = 'col-md-2';
        const row4_td4_input = document.createElement('input');
        row4_td4_input.className = 'form-control input-md';
        row4_td4_input.type = 'date';
        row4_td4_input.value = activite.date_demarrage;

        row4_td4.append(row4_td4_input);

        const row4_td5 = document.createElement('div');
        row4_td5.className = 'col-md-2';
        const row4_td5_label = document.createElement('label');
        row4_td5_label.textContent = 'Type de créneau';

        row4_td5.append(row4_td5_label);

        const row4_td6 = document.createElement('div');
        row4_td6.className = 'col-md-2';
        const row4_td6_input = document.createElement('input');
        row4_td6_input.className = 'form-control input-md';
        row4_td6_input.type = 'text';
        row4_td6_input.value = activite.type_parcours;//to do
        row4_td6_input.setAttribute('readonly', '');

        row4_td6.append(row4_td6_input);
        row4.append(row4_td1, row4_td2, row4_td3, row4_td4, row4_td5, row4_td6);

        // row 5
        const row5 = document.createElement('div');
        row5.className = 'row bottom-padding-list';

        const row5_td1 = document.createElement('div');
        row5_td1.className = 'col-md-2';
        const row5_td1_label = document.createElement('label');
        row5_td1_label.textContent = 'Commentaires';

        row5_td1.append(row5_td1_label);

        const row5_td2 = document.createElement('div');
        row5_td2.className = 'col-md-10';
        const row5_td2_textarea = document.createElement('textarea');
        row5_td2_textarea.className = 'form-control input-md';
        row5_td2_textarea.value = activite.commentaire;

        row5_td2.append(row5_td2_textarea);
        row5.append(row5_td1, row5_td2);

        // row 6
        const row6 = document.createElement('div');
        row6.className = 'row bottom-padding-list';

        const row6_td1 = document.createElement('div');
        row6_td1.className = 'col-md-12';
        row6_td1.style.textAlign = 'center';
        const row6_td1_button = document.createElement('button');
        row6_td1_button.textContent = 'Supprimer';
        row6_td1_button.className = 'btn btn-danger';

        row6_td1_button.onclick = function (event) {
            event.preventDefault();
            fieldset.remove();
            updateNumerosActivites();
            is_modified = true;
        }

        row6_td1.append(row6_td1_button);
        row6.append(row6_td1);
        fieldset.append(row0, row1, row2, row3, row4, row5, row6);

        row0_td2_select.onchange = handleTerritoireChange;
        row2_td2_select.onchange = handleCreneauChange;
        row1_td2_select.onchange = handleStructureChange;

        function handleTerritoireChange() {
            row1_td2_select.innerHTML = "";

            fetch('../Structures/ReadAllStructures.php', {
                method: 'POST',
                body: JSON.stringify({'id_territoire': row0_td2_select.value})
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
                        for (const structure of data) {
                            const option = document.createElement('option');
                            option.value = structure.id_structure;
                            option.textContent = structure.nom_structure;

                            if (structure.id_structure === activite.id_structure) {
                                option.selected = true;
                            }

                            row1_td2_select.append(option);
                        }
                    } else {
                        addEmptyOption("Aucune structure pour ce territoire", row1_td2_select);
                    }
                    handleStructureChange();
                })
                .catch((error) => {
                    console.error('row1_td2_select.onchange Error:', error);
                    addEmptyOption("Aucune structure pour ce territoire", row1_td2_select);
                });
        }

        function handleStructureChange() {
            row2_td2_select.innerHTML = '';
            row3_td2_input.value = '';
            row3_td4_input.value = '';
            row3_td6_input.value = '';
            row4_td6_input.value = '';

            if (row1_td2_select.value != "") {
                fetch('../Creneaux/ReadCreneauStructure.php', {
                    method: 'POST',
                    body: JSON.stringify({'id_structure': row1_td2_select.value})
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
                            for (const creneau of data) {
                                const option = document.createElement('option');
                                option.value = creneau.id_creneau;
                                option.textContent = creneau.nom_creneau + ' le ' + creneau.jour + ' de ' + creneau.nom_heure_debut + ' à ' + creneau.nom_heure_fin;
                                option.setAttribute('data-nom_creneau', creneau.nom_creneau);
                                option.setAttribute('data-jour', creneau.jour);
                                option.setAttribute('data-heure_debut', creneau.nom_heure_debut);
                                option.setAttribute('data-heure_fin', creneau.nom_heure_fin);
                                option.setAttribute('data-type_parcours', creneau.type_parcours);

                                if (creneau.id_creneau === activite.id_creneau) {
                                    option.selected = true;
                                }

                                row2_td2_select.append(option);
                            }
                        } else {
                            addEmptyOption("Aucun créneau pour cette structure", row2_td2_select);
                        }
                        handleCreneauChange();
                    })
                    .catch((error) => {
                        console.error('row1_td2_select.onchange Error:', error);
                        addEmptyOption("Aucun créneau pour cette structure", row2_td2_select);
                    });
            } else {
                addEmptyOption("Aucun créneau pour cette structure", row2_td2_select);
            }
        }

        /**
         * Ajout une option non sélectionnable dans le selectElem donnée
         *
         * @param txt le texte de l'option
         * @param selectElem l'élément auquel va être ajouté l'option
         */
        function addEmptyOption(txt, selectElem) {
            const option = document.createElement('option');
            option.textContent = txt;
            option.value = '';
            option.selected = true;
            option.setAttribute('disabled', '');
            selectElem.append(option);
        }

        function handleCreneauChange() {
            const selectedOption = row2_td2_select.options[row2_td2_select.selectedIndex];
            if (selectedOption != null) {
                row3_td2_input.value = selectedOption.getAttribute('data-jour');
                row3_td4_input.value = selectedOption.getAttribute('data-heure_debut');
                row3_td6_input.value = selectedOption.getAttribute('data-heure_fin');
                row4_td6_input.value = selectedOption.getAttribute('data-type_parcours');
            }
        }

        handleTerritoireChange();
        row3_td2_input.value = activite.nom_jour;
        row3_td4_input.value = activite.heure_debut;
        row3_td6_input.value = activite.heure_fin;

        return fieldset;
    }

    function updateNumerosActivites() {
        const activite_elems = document.getElementsByClassName('activite-elem');
        for (let i = 0; i < activite_elems.length; i++) {
            activite_elems[i].firstChild.textContent = 'Activité numéro ' + (i + 1);
        }
    }

    function getFormData() {
        const activite_elems = document.getElementsByClassName('activite-elem');

        const activites = [];
        for (const elem of activite_elems) {
            const statutSelect = elem.childNodes[5].childNodes[1].firstChild;
            const commentaireInput = elem.childNodes[6].childNodes[1].firstChild;
            const date_demarrageInput = elem.childNodes[5].childNodes[3].firstChild;
            const creneauSelect = elem.childNodes[3].childNodes[1].firstChild;

            const activite = {
                'id_activite_choisie': elem.getAttribute('data-id_activite_choisie'),
                'statut': statutSelect.options[statutSelect.selectedIndex].text,
                'commentaire': commentaireInput.value,
                'date_demarrage': date_demarrageInput.value,
                'id_orientation': '',
                'id_creneau': creneauSelect.value,
            }

            activites.push(activite);
        }

        return {
            'id_patient': form.getAttribute('data-id_patient'),
            'activites': activites
        };
    }

    function handleSubmitActivites(event) {
        event.preventDefault();

        // Insert dans la BDD
        fetch('./Orientation/UpdateActivitesChoisies.php', {
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
                        message: response.json()
                    };
                }
                return response.json()
            })
            .then(data => {
                is_modified = false;
                toast("Activités mises à jour avec succès");
            })
            .catch((error) => {
                console.error('Error:', error);
                toast("Echec de la mises à jour des activités");
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

    return {
        init
    };
})();