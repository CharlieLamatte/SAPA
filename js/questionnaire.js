"use strict";

/**
 * Ce fichier nécessite le fichier questionnaire_common.js pour fonctionner correctement
 */

$(document).ready(function () {
    // initialisation des élements de la page
    modal.init();
});

const modal = (function () {
    const open_details = document.getElementsByClassName('open-modal');

    const titre = document.getElementById('modal-title');

    const mainDiv = document.getElementById('main');
    const scoreDiv = document.getElementById('score');
    const form = document.getElementById('details-questionnaire');

    const urlScore = {
        '1': 'Questionnaire/ReadQuestionnaireOpaqScore.php',
        '2': 'Questionnaire/ReadQuestionnaireEpicesScore.php',
        '3': 'Questionnaire/ReadQuestionnaireProshenskaScore.php',
        '4': 'Questionnaire/ReadQuestionnaireGarnierScore.php'
    };

    function init() {
        for (const button of open_details) {
            button.addEventListener('click', function () {
                setDetails(button.getAttribute('data-id_questionnaire_instance'), button.getAttribute('data-id_questionnaire'));
            });
        }
    }

    function setDetails(id_questionnaire_instance, id_questionnaire) {
        const questionnaireInstance = fetch('Questionnaire/ReadQuestionnaireInstance.php', {
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

        const scores = fetch(urlScore[id_questionnaire], {
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
            .catch((error) => {
                console.error('error', error);
                return null;
            });

        Promise.all([questionnaireInstance, questionnaire, scores])
            .then(result => {
                titre.textContent = result[0].nom_questionnaire + ' du ' + result[0].date;

                mainDiv.innerHTML = '';
                createQuestionnaire(result[1], mainDiv, false, true, false);
                fillOutQuestionnaire(result[0].reponses);

                scoreDiv.innerHTML = '';
                if (result[2]) {
                    displayScore(result[2], id_questionnaire);
                }
            });
    }

    function fillOutQuestionnaire(data) {
        const elems = form.elements;

        for (const obj of data) {
            elems['reponse-' + obj.id_question].value = obj.reponse;
        }
    }

    function displayScore(data, id_questionnaire) {
        const questionnairediv = document.createElement('fieldset');
        questionnairediv.classList.add('section-noir');

        const legend = document.createElement('legend');
        legend.classList.add('section-titre-noir');
        legend.textContent = 'Scores';

        questionnairediv.append(legend);
        scoreDiv.append(questionnairediv);

        if (id_questionnaire == '1') {
            questionnairediv.append(createScoreDiv('Activité physique d’intensité modérée et de forte intensité (MVPA en min/semaine)', Number.isFinite(data.niveau_activite_physique_minutes) ? data.niveau_activite_physique_minutes : 'NON-CALCULABLE'));
            questionnairediv.append(createScoreDiv('Activité physique totale en METs.min/semaine (APtot)', Number.isFinite(data.niveau_activite_physique_mets) ? data.niveau_activite_physique_mets : 'NON-CALCULABLE'));
            questionnairediv.append(createScoreDiv('Score niveau sendentarite en min/jour', Number.isFinite(data.niveau_sendentarite) ? data.niveau_sendentarite : 'NON-CALCULABLE'));
            questionnairediv.append(createScoreDiv('Score niveau sendentarite en min/semaine', Number.isFinite(data.niveau_sendentarite_semaine) ? data.niveau_sendentarite_semaine : 'NON-CALCULABLE'));
        } else if (id_questionnaire == '2') {
            let inputId;
            try {
                inputId = ((Number.isFinite(data.epices) && parseInt(data.epices)) <= 30) ? 'green-BG' : 'red-BG';
            } catch (e) {
                inputId = '';
            }

            questionnairediv.append(createScoreDiv('Score EPICES', Number.isFinite(data.epices) ? data.epices : 'NON-CALCULABLE', inputId));
        } else if (id_questionnaire == '3') {
            questionnairediv.append(createScoreDiv('Score PROCHESKA', Number.isFinite(data.proshenska) ? data.proshenska : 'NON-CALCULABLE'));
        } else if (id_questionnaire == '4') {
            questionnairediv.append(createScoreDiv('Score perception santé', Number.isFinite(data.perception_sante) ? data.perception_sante : 'NON-CALCULABLE'));
        }
    }

    function createScoreDiv(text, value, inputId) {
        const row = document.createElement('div');
        row.classList.add('row');
        row.classList.add('padding-5');
        const col = document.createElement('div');
        col.classList.add('col-md-6');

        const label = document.createElement('label');
        label.classList.add('control-label');
        label.textContent = text;

        col.append(label);

        const col2 = document.createElement('div');
        col2.classList.add('col-md-6');

        const input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('readonly', '');
        input.value = value;
        input.classList.add('form-control');
        input.id = inputId;

        col2.append(input);
        row.append(col, col2);
        return row;
    }

    return {
        init
    };
})();