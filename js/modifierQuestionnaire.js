"use strict";

/**
 * Ce fichier nécessite le fichier questionnaire_common.js pour fonctionner correctement
 */

$(document).ready(function () {
    // initialisation des élements de la page
    modal.init();
});

const modal = (function () {
    const form = document.getElementById('questionnaire');

    function init() {
        setDetails(form.getAttribute('data-id_questionnaire_instance'), form.getAttribute('data-id_questionnaire'));
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

        Promise.all([questionnaireInstance, questionnaire])
            .then(result => {
                createQuestionnaire(result[1], form, true, false, true);
                fillOutQuestionnaire(result[0].reponses);

                form.addEventListener('submit', (event) => {
                    event.preventDefault(); // preventing default behaviour
                    form.reportValidity(); // run native validation manually

                    // runs default behaviour (submitting) in case of validation success
                    if (form.checkValidity()) {
                        fetch('Questionnaire/UpdateQuestionnaireInstance.php', {
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
                                // redirection
                                window.location.href = 'Questionnaires.php?idPatient='+form.getAttribute('data-id_patient');
                            })
                            .catch((error) => {
                                console.error('CreateQuestionnaireInstance Error:', error);
                            });
                    } else {
                        const elem = document.querySelector('input:invalid');
                        elem.scrollIntoView(false);
                    }
                });
            });
    }

    function fillOutQuestionnaire(data) {
        const elems = form.elements;

        for (const obj of data) {
            elems['reponse-'+obj.id_question].value = obj.reponse;
        }
    }

    return {
        init
    };
})();