"use strict";

/**
 * Ce fichier nécessite:
 * observations.js
 */

/**
 * Affiche un message si le s'il n'y a pas de données dans le datasets[0]
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

$(document).ready(function () {
    const id_patient = document.getElementById('main').getAttribute('data-id_patient');

    observationsDetails.init(
        'Observation/ReadAllObservations.php',
        'Observation/CreateObservation.php',
        TYPE_OBSERVATION.PROGRESSION
    );

    //listes pour la gestion du multi-cochage
    let tout = [];
    let physio = [];
    let fmms = [];
    let eq_stat = [];
    let mob_scap_hum = [];
    let emmi = [];
    let liste_graphes = [];

    // Test physiologique
    const graphPoids = new graphPhysio(
        'evolution-poids',
        'poids',
        'Poids (kg)',
        'Évolution du poids',
        id_patient,
        'Progression/ReadProgressionTestPhysio.php',
        'poids-checkbox'
    );

    const graphtour_taille = new graphPhysio(
        'evolution-tour_taille',
        'tour_taille',
        'Tour de taille (cm)',
        'Évolution du tour de taille',
        id_patient,
        'Progression/ReadProgressionTestPhysio.php',
        'tour_taille-checkbox'
    );

    const graphIMC = new graphPhysio(
        'evolution-IMC',
        'IMC',
        'IMC',
        'Évolution de l\'IMC',
        id_patient,
        'Progression/ReadProgressionTestPhysio.php',
        'IMC-checkbox'
    );

    const graphfc_repos = new graphPhysio(
        'evolution-fc_repos',
        'fc_repos',
        'FC de repos (bpm)',
        'Évolution de la FC de repos',
        id_patient,
        'Progression/ReadProgressionTestPhysio.php',
        'fc_repos-checkbox'
    );

    const graphsaturation_repos = new graphPhysio(
        'evolution-saturation_repos',
        'saturation_repos',
        'Saturation de repos (%)',
        'Évolution de la saturation de repos',
        id_patient,
        'Progression/ReadProgressionTestPhysio.php',
        'saturation_repos-checkbox'
    );

    const graphfc_max_mesuree = new graphPhysio(
        'evolution-fc_max_mesuree',
        'fc_max_mesuree',
        'FC max mesurée (bpm)',
        'Évolution de la FC max mesurée',
        id_patient,
        'Progression/ReadProgressionTestPhysio.php',
        'fc_max_mesuree-checkbox'
    );
    tout.push(graphPoids, graphtour_taille, graphIMC, graphfc_repos, graphsaturation_repos, graphfc_max_mesuree);
    physio.push(graphPoids, graphtour_taille, graphIMC, graphfc_repos, graphsaturation_repos, graphfc_max_mesuree);

    //Aptitudes Aérobie
    const graphdistance_parcourue = new graphPhysio(
        'evolution-distance_parcourue',
        'distance_parcourue',
        'Distance parcourue (m)',
        'Évolution de la distance parcourue',
        id_patient,
        'Progression/ReadProgressionTestAerobie.php',
        'distance_parcourue-checkbox'
    );
    tout.push(graphdistance_parcourue);

    // Force musculaire membres supérieurs
    const graphmd = new graphPhysio(
        'evolution-md',
        'md',
        'Force main droite (kg)',
        'Évolution de la force main droite',
        id_patient,
        'Progression/ReadProgressionForceMbSup.php',
        'md-checkbox'
    );

    const graphmg = new graphPhysio(
        'evolution-mg',
        'mg',
        'Force main gauche',
        'Évolution de la force main gauche (kg)',
        id_patient,
        'Progression/ReadProgressionForceMbSup.php',
        'mg-checkbox'
    );
    tout.push(graphmd, graphmg);
    fmms.push(graphmd, graphmg);

    // Equilibre statique
    const graphpied_droit_sol = new graphPhysio(
        'evolution-pied_droit_sol',
        'pied_droit_sol',
        'Equilibre pied droit (s)',
        'Évolution de l\'équilibre pied droit',
        id_patient,
        'Progression/ReadProgressionEquilibre.php',
        'pied_droit_sol-checkbox'
    );

    const graphpied_gauche_sol = new graphPhysio(
        'evolution-pied_gauche_sol',
        'pied_gauche_sol',
        'Equilibre pied gauche (s)',
        'Évolution de l\'équilibre pied gauche',
        id_patient,
        'Progression/ReadProgressionEquilibre.php',
        'pied_gauche_sol-checkbox'
    );
    tout.push(graphpied_droit_sol, graphpied_gauche_sol);
    eq_stat.push(graphpied_droit_sol, graphpied_gauche_sol);

    // Souplesse
    const graphdistance = new graphPhysio(
        'evolution-distance',
        'distance',
        'Distance majeur au sol (cm)',
        'Évolution de la distance majeur au sol',
        id_patient,
        'Progression/ReadProgressionSouplesse.php',
        'distance-checkbox'
    );
    tout.push(graphdistance);

    // Mobilité scapulo-humérale
    const graphmain_gauche_haut = new graphPhysio(
        'evolution-main_gauche_haut',
        'main_gauche_haut',
        'Main gauche en haut (cm)',
        'Évolution de la main gauche en haut',
        id_patient,
        'Progression/ReadProgressionMobilite.php',
        'main_gauche_haut-checkbox'
    );

    const graphmain_droite_haut = new graphPhysio(
        'evolution-main_droite_haut',
        'main_droite_haut',
        'Main droite en haut (cm)',
        'Évolution de la main droite en haut',
        id_patient,
        'Progression/ReadProgressionMobilite.php',
        'main_droite_haut-checkbox'
    );
    tout.push(graphmain_gauche_haut, graphmain_droite_haut);
    mob_scap_hum.push(graphmain_gauche_haut, graphmain_droite_haut);

    // Endurance musculaire membres inférieurs
    const graphnb_lever = new graphPhysio(
        'evolution-nb_lever',
        'nb_lever',
        'Nombre de levers',
        'Évolution du nombre de levers',
        id_patient,
        'Progression/ReadProgressionEnduranceMbInf.php',
        'nb_lever-checkbox'
    );

    const graphfc30 = new graphPhysio(
        'evolution-fc30',
        'fc30',
        'FC à 30 sec (bpm)',
        'Évolution de la FC à 30 sec',
        id_patient,
        'Progression/ReadProgressionEnduranceMbInf.php',
        'fc30-checkbox'
    );

    const graphsat30 = new graphPhysio(
        'evolution-sat30',
        'sat30',
        'Saturation à 30 sec (%)',
        'Évolution de la saturation à 30 sec',
        id_patient,
        'Progression/ReadProgressionEnduranceMbInf.php',
        'sat30-checkbox'
    );

    const graphborg30 = new graphPhysio(
        'evolution-borg30',
        'borg30',
        'Borg à 30 sec',
        'Évolution du borg à 30 sec',
        id_patient,
        'Progression/ReadProgressionEnduranceMbInf.php',
        'borg30-checkbox'
    );
    tout.push(graphnb_lever, graphfc30, graphsat30, graphborg30);
    emmi.push(graphnb_lever, graphfc30, graphsat30, graphborg30);
    liste_graphes.push(tout, physio, fmms, eq_stat, mob_scap_hum, emmi);

    //boucle qui programme le multi-cochage des checkbox "Tout"
    for(let k=1;k<=6;k++) {
        let id_checkbox = "tout-"+k+"-checkbox";
        let checkbox = document.getElementById(id_checkbox);
        checkbox.addEventListener("input", function () {
            for (let graph of liste_graphes[k-1]) {
                graph.checkbox.checked = checkbox.checked;
                graph.checkbox.dispatchEvent(new Event('input'));
            }
            if(k===1){
                let multi_checkboxes = document.getElementsByClassName("multi_checkbox");
                for(let j=0; j < multi_checkboxes.length;j++){
                    multi_checkboxes[j].checked = checkbox.checked;
                }
            }
        });
    }

});

function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}

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

class graphPhysio {
    constructor(canvasId, column, datasetLabel, dataTitle, id_patient, url, checkboxId) {
        this.canvas = document.getElementById(canvasId); // le canvas utilisé pour dessiner le graphe
        this.checkbox = document.getElementById(checkboxId); // la checkbox qui
        this.checkbox.oninput = (event) => {
            if (this.checkbox.checked) {
                this.init(id_patient);
                this.show();
            } else {
                this.hide();
            }
        }
        this.column = column; // le parametre que l'on veut récupérer dans la BDD
        this.datasetLabel = datasetLabel;
        this.dataTitle = dataTitle;
        this.id_patient = id_patient;
        this.url = url; // url qui permet de récupérer les données au format json
        this.is_init = false;
    }

    init() {
        if (!this.is_init) {
            const datasetPoids = fetch(this.url, {
                method: 'POST',
                body: JSON.stringify({id_patient: this.id_patient, column: this.column})
            })
                .then(response => {
                    if (!response.ok) {
                        throw {
                            statusCode: response.status,
                        };
                    }
                    return response.json();
                })
                .catch(() => null);

            Promise.all([datasetPoids])
                .then(result => {
                    if (!result[0]) {
                        throw 'Error fetch dataset';
                    }

                    const dataChart = {
                        labels: result[0].labels,
                        datasets: [
                            {
                                label: this.datasetLabel,
                                data: result[0].values,
                                backgroundColor: 'rgb(255, 205, 86)',
                                borderColor: 'rgb(255, 205, 86)',
                                hoverOffset: 4
                            },
                        ]
                    };

                    const config = {
                        type: 'line',
                        data: dataChart,
                        options: {
                            plugins: {
                                title: {
                                    display: true,
                                    text: this.dataTitle,
                                    position: 'top'
                                },
                                noDataMessage: {
                                    message: 'Pas de données disponibles'
                                },
                                colorBasedOnValue: {}
                            }
                        },
                        plugins: [noDataMessage]
                    };

                    this.myChart = new Chart(
                        this.canvas,
                        config
                    );
                    this.is_init = true;
                })
                .catch(() => {
                    displayMessageInCanvas('Erreur d\'initialisation du graph', canvas);
                    this.is_init = true;
                });
        }
    }

    /**
     * Affiche l'élément parent du canvas
     */
    show() {
        this.canvas.parentElement.style.display = "block";
    }

    /**
     * Cache l'élément parent du canvas
     */
    hide() {
        this.canvas.parentElement.style.display = "none";
    }
}

/**
 *
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