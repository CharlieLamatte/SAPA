"use strict";

/**
 * Affiche un message si le s'il n'y a pas de donné dans le datasets[0]
 * Paramètres: {
 *     message: 'string'
 * }
 */
const noDataMessage = {
    id: 'noDataMessage',
    beforeDraw(chart, args, options) {
        if (!chart.data.datasets || chart.data.datasets[0].data.length === 0) {
            const {ctx, chartArea: {left, top, width, height}} = chart;
            chart.clear();

            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = "16px normal 'Helvetica Nueue'";
            ctx.fillText(options.message, width / 2, height / 2);
            ctx.restore();
        }
    }
};

/**
 * Adds labels and data to the given chart
 * @param chart
 * @param labels
 * @param data
 */
function addData(chart, labels, data) {
    chart.data.labels.push(labels);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}

/**
 * Ajoute des lignes de données dans un tableau (1 colonne label et 1 colonne valeur)
 *
 * @param datatable
 * @param labels array de string
 * @param values array dfe nombres
 */
function addTableData(datatable, labels, values) {
    if (Array.isArray(labels) && Array.isArray(values) && labels.length === values.length) {
        for (let i = 0; i < labels.length; i++) {
            let row = document.createElement('tr');

            let td1 = document.createElement('td');
            td1.className = "text-left";
            td1.textContent = labels[i];

            let td2 = document.createElement('td');
            td2.className = "text-left";
            td2.textContent = values[i];

            row.append(td1, td2);
            datatable.row.add(row);
        }
    }
    datatable.draw();
}

/**
 * Removes labels and all data form the chart
 * @param chart
 */
function removeData(chart) {
    while (chart.data.labels.length > 0) {
        chart.data.labels.pop()
    }

    chart.data.datasets.forEach((dataset) => {
        while (dataset.data.length > 0) {
            dataset.data.pop()
        }
    });
    chart.update();
}

/**
 * Displays the message txt in the given canvas
 * @param txt string le texte à afficher
 * @param canvas HTMLCanvasElement le canvas où sera afficher le texte
 */
function displayMessageInCanvas(txt, canvas) {
    const ctx = canvas.getContext("2d");
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.font = "20px normal 'Helvetica Nueue'";
    ctx.fillText(txt, canvas.width / 2, canvas.height / 2);
}

/**
 * Removes all HTMLOptionElement of an HTMLSelectElement except the first
 * @param select HTMLSelectElement
 */
function emptySelectElemExceptFirst(select) {
    while (select.options.length > 1) {
        select.remove(1);
    }
}

/**
 * Removes all HTMLOptionElement of an HTMLSelectElement
 * @param select HTMLSelectElement
 */
function emptySelectElem(select) {
    while (select.options.length > 0) {
        select.remove(0);
    }
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
 * Affiche le loader si isDisplayed est true sinon le cache
 *
 * @param isDisplayed si le loader est affiché
 */
function setLoaderDisplayed(isDisplayed) {
    const loader = document.getElementById("preloader");
    if (isDisplayed) {
        loader.style.display = "block";
    } else {
        loader.style.display = "none";
    }
}

/**
 * Updates all charts
 */
function handleSelectYearOrStructureOrTerritoireChange() {
    setLoaderDisplayed(true); // affiche le loader

    Promise.all([
        repartitionSexe.handleFilterChange(),
        repartitionAge.handleFilterChange(),
        repartitionALDs.handleFilterChange(),
        repartitionPartALDs.handleFilterChange(),
        priseEnCharge.handleFilterChange(),
        repartitionPersonneActiviteAvant.handleFilterChange(),
        repartitionPersonneActiviteAutonomie.handleFilterChange(),
        repartitionPersonneActiviteEncadree.handleFilterChange(),
        nombrePrescriptionParmedecins.handleFilterChange(),
        nombrePatientParMutuelle.handleFilterChange(),
        repartitionOrientation.handleFilterChange(),
        repartitionObjectif.handleFilterChange(),
        ameliorationTestPhys.handleFilterChange(),
        ameliorationTestAerobie.handleFilterChange(),
        ameliorationTestForceMbSup.handleFilterChange(),
        ameliorationTestEquilibreStatique.handleFilterChange(),
        ameliorationTestSouplesse.handleFilterChange(),
        ameliorationTestMobiliteScapuloHumerale.handleFilterChange(),
        ameliorationTestEnduranceMbInf.handleFilterChange(),
        nombreOrientationsParStructure.handleFilterChange(),
        repartitionQuestionnaireEpices.handleFilterChange(),
        ameliorationParQuestionnaire.handleFilterChange(),
    ]).then(() => setLoaderDisplayed(false)); // cache le loader
}

$(document).ready(function () {
    const selectYear = document.getElementById('year');
    const selectRegion = document.getElementById('id_region');
    const selectTerritoire = document.getElementById('id_territoire');
    const selectStructure = document.getElementById('structure-dossier');
    const selectSpecialite = document.getElementById('specialite');

    // si l'utilisateur peut choisir la region
    let can_select_region = selectRegion.getAttribute('data-can_select_region') === '1';

    // initialisation des des graphs/tableaux qui contiendront les données
    repartitionSexe.init(selectYear, selectTerritoire, selectStructure);
    repartitionAge.init(selectYear, selectTerritoire, selectStructure);
    repartitionALDs.init(selectYear, selectTerritoire, selectStructure);
    repartitionPartALDs.init(selectYear, selectTerritoire, selectStructure);
    priseEnCharge.init(selectYear, selectTerritoire, selectStructure);
    repartitionPersonneActiviteAvant.init(selectYear, selectTerritoire, selectStructure);
    repartitionPersonneActiviteAutonomie.init(selectYear, selectTerritoire, selectStructure);
    repartitionPersonneActiviteEncadree.init(selectYear, selectTerritoire, selectStructure);
    nombrePrescriptionParmedecins.init(selectSpecialite, selectYear, selectTerritoire, selectStructure);
    nombrePatientParMutuelle.init(selectYear, selectTerritoire, selectStructure);
    repartitionOrientation.init(selectYear, selectTerritoire, selectStructure);
    repartitionObjectif.init(selectYear, selectTerritoire, selectStructure);
    ameliorationTestPhys.init(selectYear, selectTerritoire, selectStructure);
    ameliorationTestAerobie.init(selectYear, selectTerritoire, selectStructure);
    ameliorationTestForceMbSup.init(selectYear, selectTerritoire, selectStructure);
    ameliorationTestEquilibreStatique.init(selectYear, selectTerritoire, selectStructure);
    ameliorationTestSouplesse.init(selectYear, selectTerritoire, selectStructure);
    ameliorationTestMobiliteScapuloHumerale.init(selectYear, selectTerritoire, selectStructure);
    ameliorationTestEnduranceMbInf.init(selectYear, selectTerritoire, selectStructure);
    nombreOrientationsParStructure.init(selectYear, selectTerritoire, selectStructure);
    repartitionQuestionnaireEpices.init(selectYear, selectTerritoire, selectStructure);
    ameliorationParQuestionnaire.init(selectYear, selectTerritoire, selectStructure);

    selectTerritoire.onchange = () => {
        select.handleTerritoireChange() // maj des select avant de mettre à jour les graphes
            .then(() => handleSelectYearOrStructureOrTerritoireChange()); // maj des graphes
    }

    selectRegion.onchange = () => {
        select.handleRegionChange()
            .then(() =>
                select.handleTerritoireChange() // maj des select avant de mettre à jour les graphes
                    .then(() => handleSelectYearOrStructureOrTerritoireChange())); // maj des graphes
    }

    // gestion de l'affichage des sections
    let displayed = 'informations-territoires' // l'id de la section actuellement affichée
    const form = document.getElementById('select-section');
    const elemsRadio = form.elements['options'];

    for (const radio of elemsRadio) {
        radio.onchange = () => {
            try {
                // affichages des sections
                const sectionId = getSelectedRadioValue(form, 'options');
                if (displayed) {
                    document.getElementById(displayed).style.display = 'none';
                }
                document.getElementById(sectionId).style.display = 'block';

                // affichage des filtres
                if (sectionId === 'informations-territoires') {
                    document.getElementById("filtres").style.display = 'none';
                } else {
                    document.getElementById("filtres").style.display = 'block';
                }
                displayed = sectionId;
            } catch (e) {
            }
        }
    }

    // initialisation des données
    select.init(selectYear, selectStructure, selectTerritoire, selectRegion, selectSpecialite)
        .then(() => {
            return select.handleRegionChange();
        })
        .then(() => {
            return select.handleTerritoireChange();
        })
        .then(() => {
            handleSelectYearOrStructureOrTerritoireChange();
        })
        .catch(e => console.log(e))
        .finally(() => {
            if (!can_select_region) {
                selectRegion.setAttribute('disabled', '');
            }
        });
});

const select = (function () {
    let selectRegion;
    let selectTerritoire;
    let selectYear;
    let selectStructure;
    let selectSpecialite;

    // si l'utilisateur peut choisir la region
    let can_select_region;
    // si l'utilisateur peut choisir le territoire
    let can_select_territoire;
    // si l'utilisateur peut choisir la structure
    let can_select_structure;

    function init(_selectYear, _selectStructure, _selectTerritoire, _selectRegion, _selectSpecialite) {
        return new Promise((resolve, reject) => {
            selectYear = _selectYear;
            selectRegion = _selectRegion;
            selectTerritoire = _selectTerritoire;
            selectStructure = _selectStructure;
            selectSpecialite = _selectSpecialite;
            can_select_region = selectRegion.getAttribute('data-can_select_region') === '1';
            can_select_territoire = selectTerritoire.getAttribute('data-can_select_territoire') === '1';
            can_select_structure = selectStructure.getAttribute('data-can_select_structure') === '1';

            // création des éléments du select region
            fetch('../Territoires/ReadAllTerritoires.php', {
                method: 'POST',
                body: JSON.stringify({'id_type_territoire': TYPE_TERRITOIRE.TYPE_TERRITOIRE_REGION})
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
                    if (Array.isArray(data)) {
                        data.forEach(region => {
                            const opt1 = document.createElement("option");

                            opt1.value = region.id_region;
                            opt1.text = region.nom_territoire;

                            selectRegion.add(opt1, null);
                        });
                    }

                    // cas si l'utilisateur ne peut pas modifier la region
                    if (!can_select_region) {
                        selectRegion.value = selectRegion.getAttribute('data-id_region');
                    }

                    resolve(true);
                })
                .catch((error) => {
                    console.error(error);
                    reject(false);
                });
        });
    }

    /**
     * Maj des selects selon le territoire
     * @returns {Promise<boolean>} si les selects ont été initialisés
     */
    function handleTerritoireChange() {
        return new Promise((resolve, reject) => {
            let years = fetch('TableauDeBord/ReadYears.php', {
                method: 'POST',
                body: JSON.stringify({id_territoire: selectTerritoire.value})
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
                    console.error(error);
                    return null;
                });

            let structures = fetch('TableauDeBord/ReadStructures.php', {
                method: 'POST',
                body: JSON.stringify({id_territoire: selectTerritoire.value})
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
                    return null;
                });

            let specialites = fetch('TableauDeBord/ReadSpecialites.php', {
                method: 'POST',
                body: JSON.stringify({id_territoire: selectTerritoire.value})
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
                    console.error(error);
                    return null;
                });

            Promise.all([years, structures, specialites])
                .then(result => {
                    emptySelectElemExceptFirst(selectYear);
                    emptySelectElemExceptFirst(selectStructure);
                    emptySelectElemExceptFirst(selectSpecialite);

                    if (result[0]) {
                        if (Array.isArray(result[0])) {
                            result[0].forEach(year => {
                                const option = document.createElement("option");

                                option.value = year;
                                option.text = year;

                                selectYear.add(option, null);
                            });
                        }

                        selectYear.onchange = () => {
                            handleSelectYearOrStructureOrTerritoireChange();
                        }
                    }

                    if (result[1]) {
                        if (Array.isArray(result[1])) {
                            result[1].forEach(struture => {
                                const option = document.createElement("option");

                                option.value = struture.id;
                                option.text = struture.nom;

                                selectStructure.add(option, null);
                            });

                            selectStructure.onchange = () => {
                                handleSelectYearOrStructureOrTerritoireChange();
                            }

                            // cas si l'utilisateur ne peut pas modifier la structure
                            if (!can_select_structure) {
                                selectStructure.value = selectStructure.getAttribute('data-id_structure');
                                selectStructure.setAttribute('disabled', '');
                            }
                        }
                    }

                    if (result[2]) {
                        if (Array.isArray(result[2])) {
                            result[2].forEach(spe => {
                                const option = document.createElement("option");

                                option.value = spe.id;
                                option.text = spe.nom;

                                selectSpecialite.add(option, null);
                            });
                        }

                        selectSpecialite.onchange = () => {
                            nombrePrescriptionParmedecins.handleFilterChange();
                        }
                    }
                    resolve(true);
                }).catch(() => reject(false));
        });
    }

    /**
     * Maj des selects selon la region
     * @returns {Promise<boolean>} si les selects ont été initialisés
     */
    function handleRegionChange() {
        return new Promise((resolve, reject) => {
            let territoires = fetch('../Territoires/ReadAllTerritoires.php', {
                method: 'POST',
                body: JSON.stringify({
                    'id_region': selectRegion.value,
                    'id_type_territoire': TYPE_TERRITOIRE.TYPE_TERRITOIRE_DEPARTEMENT,
                })
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
                    console.error(error);
                    return null;
                });

            Promise.all([territoires,])
                .then(result => {
                    emptySelectElem(selectTerritoire);

                    if (result[0]) {
                        if (Array.isArray(result[0])) {
                            result[0].forEach(territoire => {
                                const option = document.createElement("option");

                                option.value = territoire.id_territoire;
                                option.text = territoire.nom_territoire;

                                selectTerritoire.add(option, null);
                            });
                        }

                        // cas si l'utilisateur ne peut pas modifier le territoire
                        if (!can_select_territoire) {
                            selectTerritoire.setAttribute('disabled', '');
                            selectTerritoire.value = selectTerritoire.getAttribute('data-id_territoire');
                        }
                    }

                    resolve(true);
                }).catch(() => reject(false));
        });
    }

    return {
        init,
        handleTerritoireChange,
        handleRegionChange
    };
})();

const repartitionSexe = (function () {
    const ctx = document.getElementById('repartition-sexe-chart');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Répartion par sexe',
                data: [],
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Répartion par sexe',
                        position: 'top'
                    }
                },
                noDataMessage: {
                    message: 'Pas de données disponibles'
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        removeData(chart);

        return fetch('TableauDeBord/RepartitionSexePatients.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const repartitionAge = (function () {
    const ctx = document.getElementById('repartition-age-chart');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Répartion par âge',
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)',
                    'rgb(255, 156, 132)',
                    'rgb(98, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(54, 4, 235)',
                    'rgb(4, 99, 132)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Répartion par âge',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        removeData(chart);

        return fetch('TableauDeBord/RepartitionAgePatients.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    if (data.values[i] > 0) {
                        addData(chart, data.labels[i], data.values[i]);
                    }
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const repartitionALDs = (function () {
    const ctx = document.getElementById('repartition-ald-chart');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Répartion des bénéficiaires par age',
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)',
                    'rgb(255, 156, 132)',
                    'rgb(98, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(54, 4, 235)',
                    'rgb(4, 99, 132)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Répartion des ald',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        removeData(chart);

        return fetch('TableauDeBord/RepartitionAldPatients.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const repartitionPartALDs = (function () {
    const ctx = document.getElementById('repartition-part-ald-chart');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Part des bénéficiaires en ald',
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)',
                    'rgb(255, 156, 132)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Part des bénéficiaires en ald',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        removeData(chart);

        return fetch('TableauDeBord/RepartionPartAldPatients.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const priseEnCharge = (function () {
    const ctx = document.getElementById('prise-en-charge-mois-chart');
    const $table = $('#prise-en-charge-mois-table');
    let chart;
    let datatable;

    let selectYear;
    let selectTerritoire;
    let selectStructure;
    let nombre_elements_tableaux;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Nombre de nouveaux dossiers',
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Nombre de nouveaux dossiers par mois',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    subtitle: {
                        display: true,
                        text: ''
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        ticks: {
                            stepSize: 1
                        }
                    },
                },
            },
            plugins: [noDataMessage]
        };

        // initilisation du graph
        chart = new Chart(ctx, config);

        // initilisation du tableau
        datatable = $table.DataTable({
            paging: true,
            retrieve: true,
            scrollX: false,
            autoWidth: true,
            responsive: true,
            order: [
                [1, "desc"]
            ],
            language: {url: "../../js/DataTables/media/French.json"},
            pageLength: nombre_elements_tableaux
        });
    }

    function handleFilterChange() {
        removeData(chart);
        datatable.clear().draw();

        return fetch('TableauDeBord/NombreDossierParMois.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }

                // affichage du total dans le tableau
                data.labels.push('Total');
                data.values.push(data.total);

                addTableData(datatable, data.labels, data.values);
                chart.options.plugins.subtitle.text = "Total: " + data.total + " " + (data.total > 1 ? "nouveaux dossiers" : "nouveau dossier");
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const nombrePrescriptionParmedecins = (function () {
    const ctx = document.getElementById('nombre-prescriptions');
    const $table = $('#nombre-prescriptions-table');
    let chart;
    let datatable

    let selectSpecialite;
    let selectYear;
    let selectTerritoire;
    let selectStructure;
    let nombre_elements_tableaux;

    function init(_selectSpecialite, _selectYear, _selectTerritoire, _selectStructure) {
        selectSpecialite = _selectSpecialite;
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Nombre de prescriptions par professionnel de santé',
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Nombre de prescriptions par professionnel de santé',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    subtitle: {
                        display: true,
                        text: ''
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        ticks: {
                            stepSize: 1
                        }
                    },
                },
            },
            plugins: [noDataMessage],
        };

        // initilisation du graph
        chart = new Chart(ctx, config);

        // initilisation du tableau
        datatable = $table.DataTable({
            paging: true,
            retrieve: true,
            scrollX: false,
            autoWidth: true,
            responsive: true,
            order: [
                [1, "desc"]
            ],
            language: {url: "../../js/DataTables/media/French.json"},
            pageLength: nombre_elements_tableaux
        });
    }

    function handleFilterChange() {
        // reset du graph et du tableau
        removeData(chart);
        datatable.clear().draw();

        return fetch('TableauDeBord/NombrePrescriptionsParMedecins.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                id_specialite_medecin: selectSpecialite.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }

                // affichage du total dans le tableau
                data.labels.push('Total');
                data.values.push(data.total);

                addTableData(datatable, data.labels, data.values);
                chart.options.plugins.subtitle.text = "Total: " + data.total + " " + (data.total > 1 ? "prescriptions" : "prescription");
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const nombrePatientParMutuelle = (function () {
    const ctx = document.getElementById('repartition-mutuelles');
    const $table = $('#repartition-mutuelles-table');
    let chart;
    let datatable

    let selectYear;
    let selectTerritoire;
    let selectStructure;
    let nombre_elements_tableaux;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Nombre de bénéficiaires ayant souscrit à la mutuelle',
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Nombre de bénéficiaires ayant souscrit à chaque mutuelle',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    subtitle: {
                        display: true,
                        text: ''
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        ticks: {
                            stepSize: 1
                        }
                    },
                },
            },
            plugins: [noDataMessage]
        };

        // initilisation du graph
        chart = new Chart(ctx, config);

        // initilisation du tableau
        datatable = $table.DataTable({
            paging: true,
            retrieve: true,
            scrollX: false,
            autoWidth: true,
            responsive: true,
            order: [
                [1, "desc"]
            ],
            language: {url: "../../js/DataTables/media/French.json"},
            pageLength: nombre_elements_tableaux
        });
    }

    function handleFilterChange() {
        // reset du graph et du tableau
        removeData(chart);
        datatable.clear().draw();

        return fetch('TableauDeBord/RepartitionMutuelles.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }

                // affichage du total dans le tableau
                data.labels.push('Total');
                data.values.push(data.total);

                addTableData(datatable, data.labels, data.values);
                chart.options.plugins.subtitle.text = "Total: " + data.total + " " + (data.total > 1 ? "bénéficiaires" : "bénéficiaire");
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const repartitionPersonneActiviteAvant = (function () {
    const ctx = document.getElementById('repartition-activite-avant');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)',
                    'rgb(255, 156, 132)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Personnes ayant une activité avant admission',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        removeData(chart);

        return fetch('TableauDeBord/RepartionActiviteAvant.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const repartitionPersonneActiviteAutonomie = (function () {
    const ctx = document.getElementById('repartition-activite-autonomie');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)',
                    'rgb(255, 156, 132)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Personnes ayant une activité en autonomie',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        removeData(chart);

        return fetch('TableauDeBord/RepartionActiviteAutonomie.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const repartitionPersonneActiviteEncadree = (function () {
    const ctx = document.getElementById('repartition-activite-encadree');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)',
                    'rgb(255, 156, 132)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Personnes ayant une activité encadrée',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        removeData(chart);

        return fetch('TableauDeBord/RepartionActiviteEncadree.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const repartitionOrientation = (function () {
    const ctx = document.getElementById('repartition-orientation');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)',
                    'rgb(255, 156, 132)',
                    'rgb(0, 19, 55)',
                    'rgb(200, 162, 200)',
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Répartition des orientation des bénéficiaires',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        removeData(chart);

        return fetch('TableauDeBord/RepartitionOrientation.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const repartitionQuestionnaireEpices = (function () {
    const ctx = document.getElementById('repartition-epices');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)',
                    'rgb(255, 156, 132)',
                    'rgb(0, 19, 55)',
                    'rgb(200, 162, 200)',
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Répartition des scores épices des bénéficiaires',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        removeData(chart);

        return fetch('TableauDeBord/RepatitionScoreEpices.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const ameliorationParQuestionnaire = (function () {
    const ctx = document.getElementById('repartition-amelioration-questionnaire');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Pourcentage d\'évolution',
                data: [],
                backgroundColor: function (context) {
                    const index = context.dataIndex;
                    const value = context.dataset.data[index];
                    return value > 0 ? 'rgb(0, 162, 55)' : 'rgb(255, 99, 132)';
                },
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Moyenne d\'évolution pour chaque questionnaire',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    colorBasedOnValue: {}
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'en %'
                        }
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        removeData(chart);

        return fetch('TableauDeBord/RepartitionAmeliorationQuestionnaire.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const repartitionObjectif = (function () {
    const chart = document.getElementById('repartition-objectif');
    let myChart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Nombre d\'objectifs',
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Répartition des statuts des objectifs des bénéficiaires',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    }
                }
            },
            plugins: [noDataMessage]
        };

        myChart = new Chart(chart, config);
    }

    function handleFilterChange() {
        removeData(myChart);

        return fetch('TableauDeBord/RepartitionObjectif.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                removeData(myChart);

                for (let i = 0; i < data.values.length; i++) {
                    addData(myChart, data.labels[i], data.values[i]);
                }
            });
    }

    return {
        init,
        handleFilterChange
    };
})();

const ameliorationTestPhys = (function () {
    const ctx = document.getElementById('amelioration-phys');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [[]],
            datasets: [[]]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Moyennes d\'évolution des paramètres du test physiologique',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    colorBasedOnValue: {}
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: ''
                        }
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        // reset du graph
        removeData(chart);

        return fetch('TableauDeBord/AmeliorationTestPhysio.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value,
            })
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
                chart.data.labels = data.stats_all.labels;
                chart.data.datasets = [{
                    label: 'Tous',
                    data: data.stats_all.values,
                    backgroundColor: 'rgb(201, 203, 207)',
                    hoverOffset: 4
                }, {
                    label: 'Femmes',
                    data: data.stats_femmes.values,
                    backgroundColor: 'rgb(255, 99, 132)',
                    hoverOffset: 4
                }, {
                    label: 'Hommes',
                    data: data.stats_hommes.values,
                    backgroundColor: 'rgb(54, 162, 235)',
                    hoverOffset: 4
                }];
                chart.update();
            })
            .catch(error => console.error('error:', error));
    }

    return {
        init,
        handleFilterChange
    };
})();


const ameliorationTestAerobie = (function () {
    const ctx = document.getElementById('amelioration-distance-parcourue');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [[]],
            datasets: [[]]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Moyenne d\'évolution du test aérobie',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    colorBasedOnValue: {}
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'en m'
                        }
                    }
                }
            },
            plugins: [noDataMessage]
        };

        // initilisation du graph
        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        // reset du graph
        removeData(chart);

        return fetch('TableauDeBord/AmeliorationTestAerobie.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value,
            })
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
                chart.data.labels = data.stats_all.labels;
                chart.data.datasets = [{
                    label: 'Tous',
                    data: data.stats_all.values,
                    backgroundColor: 'rgb(201, 203, 207)',
                    hoverOffset: 4
                }, {
                    label: 'Femmes',
                    data: data.stats_femmes.values,
                    backgroundColor: 'rgb(255, 99, 132)',
                    hoverOffset: 4
                }, {
                    label: 'Hommes',
                    data: data.stats_hommes.values,
                    backgroundColor: 'rgb(54, 162, 235)',
                    hoverOffset: 4
                }];
                chart.update();
            })
            .catch(error => console.error('error:', error));
    }

    return {
        init,
        handleFilterChange
    };
})();

const ameliorationTestForceMbSup = (function () {
    const ctx = document.getElementById('amelioration-force-mb-sup');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [[]],
            datasets: [[]]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Moyenne d\'évolution du test de force des membres supérieurs',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    colorBasedOnValue: {}
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'en kg'
                        }
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        // reset du graph
        removeData(chart);

        return fetch('TableauDeBord/AmeliorationTestForceMbSup.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value,
            })
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
                chart.data.labels = data.stats_all.labels;
                chart.data.datasets = [{
                    label: 'Tous',
                    data: data.stats_all.values,
                    backgroundColor: 'rgb(201, 203, 207)',
                    hoverOffset: 4
                }, {
                    label: 'Femmes',
                    data: data.stats_femmes.values,
                    backgroundColor: 'rgb(255, 99, 132)',
                    hoverOffset: 4
                }, {
                    label: 'Hommes',
                    data: data.stats_hommes.values,
                    backgroundColor: 'rgb(54, 162, 235)',
                    hoverOffset: 4
                }];
                chart.update();
            })
            .catch(error => console.error('error:', error));
    }

    return {
        init,
        handleFilterChange
    };
})();

const ameliorationTestEquilibreStatique = (function () {
    const ctx = document.getElementById('amelioration-equilibre-statique');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [[]],
            datasets: [[]]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Moyenne d\'évolution du test d\'équilibre statique',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    colorBasedOnValue: {}
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'en secondes'
                        }
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        // reset du graph
        removeData(chart);

        return fetch('TableauDeBord/AmeliorationTestEquilibreStatique.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value,
            })
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
                chart.data.labels = data.stats_all.labels;
                chart.data.datasets = [{
                    label: 'Tous',
                    data: data.stats_all.values,
                    backgroundColor: 'rgb(201, 203, 207)',
                    hoverOffset: 4
                }, {
                    label: 'Femmes',
                    data: data.stats_femmes.values,
                    backgroundColor: 'rgb(255, 99, 132)',
                    hoverOffset: 4
                }, {
                    label: 'Hommes',
                    data: data.stats_hommes.values,
                    backgroundColor: 'rgb(54, 162, 235)',
                    hoverOffset: 4
                }];
                chart.update();
            })
            .catch(error => console.error('error:', error));
    }

    return {
        init,
        handleFilterChange
    };
})();

const ameliorationTestSouplesse = (function () {
    const ctx = document.getElementById('amelioration-souplesse');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [[]],
            datasets: [[]]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Moyenne d\'évolution du test souplesse',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    colorBasedOnValue: {}
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'en cm'
                        }
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        // reset du graph
        removeData(chart);

        return fetch('TableauDeBord/AmeliorationTestSouplesse.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value,
            })
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
                chart.data.labels = data.stats_all.labels;
                chart.data.datasets = [{
                    label: 'Tous',
                    data: data.stats_all.values,
                    backgroundColor: 'rgb(201, 203, 207)',
                    hoverOffset: 4
                }, {
                    label: 'Femmes',
                    data: data.stats_femmes.values,
                    backgroundColor: 'rgb(255, 99, 132)',
                    hoverOffset: 4
                }, {
                    label: 'Hommes',
                    data: data.stats_hommes.values,
                    backgroundColor: 'rgb(54, 162, 235)',
                    hoverOffset: 4
                }];
                chart.update();
            })
            .catch(error => console.error('error:', error));
    }

    return {
        init,
        handleFilterChange
    };
})();

const ameliorationTestMobiliteScapuloHumerale = (function () {
    const ctx = document.getElementById('evolution-mobilite-scapulo-humerale');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [[]],
            datasets: [[]]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Moyenne d\'évolution du test mobilité scapulo-humérale',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    colorBasedOnValue: {}
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'en cm'
                        }
                    }
                }
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        // reset du graph
        removeData(chart);

        return fetch('TableauDeBord/EvolutionTestMobiliteScapuloHumerale.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value,
            })
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
                chart.data.labels = data.stats_all.labels;
                chart.data.datasets = [{
                    label: 'Tous',
                    data: data.stats_all.values,
                    backgroundColor: 'rgb(201, 203, 207)',
                    hoverOffset: 4
                }, {
                    label: 'Femmes',
                    data: data.stats_femmes.values,
                    backgroundColor: 'rgb(255, 99, 132)',
                    hoverOffset: 4
                }, {
                    label: 'Hommes',
                    data: data.stats_hommes.values,
                    backgroundColor: 'rgb(54, 162, 235)',
                    hoverOffset: 4
                }];
                chart.update();
            })
            .catch(error => console.error('error:', error));
    }

    return {
        init,
        handleFilterChange
    };
})();


const ameliorationTestEnduranceMbInf = (function () {
    const ctx = document.getElementById('evolution-endurance-mb-inf');
    let chart;

    let selectYear;
    let selectTerritoire;
    let selectStructure;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;

        const dataChart = {
            labels: [[]],
            datasets: [[]]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Moyenne d\'évolution du test endurance musculaire membres inférieurs',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    colorBasedOnValue: {}
                },
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);
    }

    function handleFilterChange() {
        // reset du graph
        removeData(chart);

        return fetch('TableauDeBord/EvolutionTestEnduranceMbInf.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value,
            })
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
                chart.data.labels = data.stats_all.labels;
                chart.data.datasets = [{
                    label: 'Tous',
                    data: data.stats_all.values,
                    backgroundColor: 'rgb(201, 203, 207)',
                    hoverOffset: 4
                }, {
                    label: 'Femmes',
                    data: data.stats_femmes.values,
                    backgroundColor: 'rgb(255, 99, 132)',
                    hoverOffset: 4
                }, {
                    label: 'Hommes',
                    data: data.stats_hommes.values,
                    backgroundColor: 'rgb(54, 162, 235)',
                    hoverOffset: 4
                }];
                chart.update();
            })
            .catch(error => console.error('error:', error));
    }

    return {
        init,
        handleFilterChange
    };
})();

const nombreOrientationsParStructure = (function () {
    const ctx = document.getElementById('nombre-orientations');
    const $table = $('#nombre-orientations-table');
    let chart;
    let datatable

    let selectYear;
    let selectTerritoire;
    let selectStructure;
    let nombre_elements_tableaux;

    function init(_selectYear, _selectTerritoire, _selectStructure) {
        selectYear = _selectYear;
        selectTerritoire = _selectTerritoire;
        selectStructure = _selectStructure;
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Nombre de patients orientés vers les structures',
                data: [],
                backgroundColor: [
                    'rgb(0, 162, 55)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'bar',
            data: dataChart,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Nombre de bénéficiaires orientés vers les structures',
                        position: 'top'
                    },
                    noDataMessage: {
                        message: 'Pas de données disponibles'
                    },
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.formattedValue + ((parseInt(context.formattedValue) > 1 ? ' bénéficiaires orientés' : ' bénéficiaire orienté') + ' vers cette structure');
                            }
                        }
                    },
                    subtitle: {
                        display: true,
                        text: ''
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        ticks: {
                            stepSize: 1
                        }
                    },
                },
            },
            plugins: [noDataMessage]
        };

        // initilisation du graph
        chart = new Chart(ctx, config);

        // initilisation du tableau
        datatable = $table.DataTable({
            paging: true,
            retrieve: true,
            scrollX: false,
            autoWidth: true,
            responsive: true,
            order: [
                [1, "desc"]
            ],
            language: {url: "../../js/DataTables/media/French.json"},
            pageLength: nombre_elements_tableaux
        });
    }

    function handleFilterChange() {
        removeData(chart);
        datatable.clear().draw();

        return fetch('TableauDeBord/NombreOrientationsParStructure.php', {
            method: 'POST',
            body: JSON.stringify({
                id_territoire: selectTerritoire.value,
                year: selectYear.value,
                id_structure: selectStructure.value
            })
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
                for (let i = 0; i < data.values.length; i++) {
                    addData(chart, data.labels[i], data.values[i]);
                }

                // affichage du total dans le tableau
                data.labels.push('Total');
                data.values.push(data.total);

                addTableData(datatable, data.labels, data.values);
                chart.options.plugins.subtitle.text = "Total: " + data.total + " " + (data.total > 1 ? "bénéficiaires" : "bénéficiaire");
            });
    }

    return {
        init,
        handleFilterChange
    };
})();