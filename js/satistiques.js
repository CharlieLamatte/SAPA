"use strict";

$(document).ready(function () {
    // initialisation des élements de la page
    stastistiques.init();
    tableaux.init();
});

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

const stastistiques = (function () {
    const nombreBeneficiairesSpan = document.getElementById('nombre-beneficiaires');
    const nombreBeneficiairesActifsSpan = document.getElementById('nombre-beneficiaires-actifs');
    const pourcentagePresenceSemaineSpan = document.getElementById('pourcentage-presence-semaine');
    const tauxVariationSpan = document.getElementById('taux-variation');

    function init() {
        fetch('ReadStatistiquesStructure.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({id_structure: localStorage.getItem('id_structure')}),
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
                nombreBeneficiairesSpan.textContent = data.beneficiaire_count;
                nombreBeneficiairesActifsSpan.textContent = data.beneficiaire_actif_count;

                // affichage de l'assiduité
                const percent_present_current_week = data.assiduite["percent_present_current_week"];
                const variation = data.assiduite["variation"];
                pourcentagePresenceSemaineSpan.textContent = percent_present_current_week != null ? percent_present_current_week + '%' : "Pas de données";
                tauxVariationSpan.textContent = variation != null ? variation + '%' : "Pas de données";

                // initialisation des graph
                repartitionAge.init(data.repartition_age);
                repartitionRole.init(data.repartition_role);
                repartitionStatus.init(data.repartition_status_beneficiaire);
                assiduite.init(data.assiduite);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    return {
        init
    }
})();

const tableaux = (function () {
    const nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

    function init() {
        // initilisation du tableau
        const datatable =  $('#table-assiduite-creneaux').DataTable({
            paging: true,
            retrieve: true,
            scrollX: false,
            autoWidth: true,
            responsive: true,
            order: [
                [4, "desc"] // selon assiduité
            ],
            language: {url: "../../js/DataTables/media/French.json"},
            pageLength: nombre_elements_tableaux
        });
    }

    return {
        init
    };
})();

/**
 * Graph qui affiche la repartition par age
 */
const repartitionAge = (function () {
    const ctx = document.getElementById('repartition-age-chart');
    let chart;

    function init(data) {
        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Répartition par âge',
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
                        text: 'Répartition par âge',
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

        for (let i = 0; i < data.values.length; i++) {
            if (data.values[i] > 0) {
                addData(chart, data.labels[i], data.values[i]);
            }
        }
    }

    return {
        init
    };
})();

/**
 * Graph qui affiche la repartition par status (actif ou non)
 */
const repartitionStatus = (function () {
    const ctx = document.getElementById('repartition-status-actif-chart');
    let chart;

    function init(data) {
        const dataChart = {
            labels: [],
            datasets: [{
                label: 'Répartition par status',
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
                        text: 'Répartition par status',
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

        for (let i = 0; i < data.values.length; i++) {
            if (data.values[i] > 0) {
                addData(chart, data.labels[i], data.values[i]);
            }
        }
    }

    return {
        init
    };
})();

/**
 * Graph qui affiche la repartition par role
 */
const repartitionRole = (function () {
    const ctx = document.getElementById('repartition-role-chart');
    let chart;

    function init(data) {
        const dataChart = {
            labels: [],
            datasets: [{
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
                        text: 'Employés de la structure sportive',
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
                                return context.formattedValue + (parseInt(context.formattedValue) > 1 ? ' personnes' : ' personne');
                            }
                        }
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

        chart = new Chart(ctx, config);

        for (let i = 0; i < data.values.length; i++) {
            addData(chart, data.labels[i], data.values[i]);
        }
    }

    return {
        init
    };
})();

/**
 * Graph qui affiche l'assiduité
 */
const assiduite = (function () {
    const ctx = document.getElementById('assiduite-chart');
    let chart;

    function init(data) {
        const dataChart = {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: data.values.map(val => val >= 0 ? 'rgb(0, 162, 55)' : "red"),
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
                        text: 'Présence des bénéficiaires',
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
                                return context.formattedValue + ' %';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            suggestedMin: 0,
                            max: 100,
                            callback: function (value) {
                                return value + '%';
                            },
                        },
                    },
                },
            },
            plugins: [noDataMessage]
        };

        chart = new Chart(ctx, config);

        for (let i = 0; i < data.values.length; i++) {
            addData(chart, data.labels[i], data.values[i]);
        }
    }

    return {
        init
    };
})();