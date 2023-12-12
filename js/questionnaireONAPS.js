"use strict";

/**
 * Ce fichier nécessite le fichier questionnaire_common.js pour fonctionner correctement
 */

$(document).ready(function () {
    // initialisation des élements de la page
    questionnaire.init();
});

const questionnaire = (function () {
    const mainDiv = document.getElementById('questionnaire');
    mainDiv.noValidate = true;

    function init() {
        fetch('Questionnaire/ReadQuestionnaire.php', {
            method: 'POST',
            body: JSON.stringify({'id_questionnaire': mainDiv.getAttribute('data-id_questionnaire')})
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
                createQuestionnaire(data, mainDiv);
                autoremplissage();
            })
            .catch((error) => {
                console.error('Error:', error);
            });

        mainDiv.addEventListener('submit', (event) => {
            event.preventDefault(); // preventing default behaviour
            mainDiv.reportValidity(); // run native validation manually

            // runs default behaviour (submitting) in case of validation success
            if (mainDiv.checkValidity()) {
                // prevent submitting the form
                if (mainDiv.classList.contains('is-submitting')) {
                    event.preventDefault();
                    return;
                }

                // Add a visual indicator to show the user it is submitting
                mainDiv.classList.add('is-submitting');

                fetch('Questionnaire/CreateQuestionnaireInstance.php', {
                    method: 'POST',
                    body: JSON.stringify(getData(mainDiv))
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
                        // redirection
                        window.location.href = 'Questionnaires.php?idPatient=' + mainDiv.getAttribute('data-id_patient');
                    })
                    .catch((error) => {
                        console.error('CreateQuestionnaireInstance Error:', error);
                    });

            } else {
                const elem = document.querySelector('input:invalid');
                elem.scrollIntoView(false);
            }
        });
    }

    function resetRadio(form, name) {
        form.elements[name].forEach(
            r => r.checked = false
        );
    }

    function toggleRadioDisabled(name, on) {
        if (on) {
            mainDiv.elements[name]?.forEach(
                r => r.setAttribute('disabled', '')
            );
        } else {
            mainDiv.elements[name]?.forEach(
                r => r.removeAttribute('disabled')
            );
        }
    }

    function toggleElementDisabled(name, on) {
        if (on) {
            mainDiv.elements[name]?.setAttribute('disabled', '');
        } else {
            mainDiv.elements[name]?.removeAttribute('disabled');
        }
    }

    function autoremplissage() {
        // question 1
        mainDiv.elements['reponse-1']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-1'].value === '0') {
                        mainDiv.elements['reponse-2'].value = 0;
                        toggleRadioDisabled('reponse-2', true);

                        mainDiv.elements['reponse-6'].value = 0;
                        mainDiv.elements['reponse-7'].value = 0;
                        toggleRadioDisabled('reponse-6', true);
                        toggleRadioDisabled('reponse-7', true);

                        mainDiv.elements['reponse-9'].value = 0;
                        mainDiv.elements['reponse-10'].value = 0;
                        toggleElementDisabled('reponse-9', true);
                        toggleElementDisabled('reponse-10', true);

                        mainDiv.elements['reponse-11'].value = 0;
                        toggleElementDisabled('reponse-11', true);
                    } else if (mainDiv.elements['reponse-1'].value === '1') {
                        resetRadio(mainDiv, 'reponse-2');
                        toggleRadioDisabled('reponse-2', false);

                        resetRadio(mainDiv, 'reponse-6');
                        resetRadio(mainDiv, 'reponse-7');
                        toggleRadioDisabled('reponse-6', false);
                        toggleRadioDisabled('reponse-7', false);

                        mainDiv.elements['reponse-9'].value = '';
                        mainDiv.elements['reponse-10'].value = '';
                        toggleElementDisabled('reponse-9', false);
                        toggleElementDisabled('reponse-10', false);

                        mainDiv.elements['reponse-11'].value = '';
                        toggleElementDisabled('reponse-11', false);
                    }
                }
            }
        );

        // question 2
        mainDiv.elements['reponse-2']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-2'].value === '0') {
                        mainDiv.elements['reponse-6'].value = 0;
                        mainDiv.elements['reponse-7'].value = 0;
                        toggleRadioDisabled('reponse-6', true);
                        toggleRadioDisabled('reponse-7', true);

                        mainDiv.elements['reponse-9'].value = 0;
                        mainDiv.elements['reponse-10'].value = 0;
                        toggleElementDisabled('reponse-9', true);
                        toggleElementDisabled('reponse-10', true);

                        mainDiv.elements['reponse-11'].value = 0;
                        toggleElementDisabled('reponse-11', true);
                    } else if (mainDiv.elements['reponse-2'].value === '1') {
                        resetRadio(mainDiv, 'reponse-6');
                        resetRadio(mainDiv, 'reponse-7');
                        toggleRadioDisabled('reponse-6', false);
                        toggleRadioDisabled('reponse-7', false);

                        mainDiv.elements['reponse-9'].value = '';
                        mainDiv.elements['reponse-10'].value = '';
                        toggleElementDisabled('reponse-9', false);
                        toggleElementDisabled('reponse-10', false);

                        mainDiv.elements['reponse-11'].value = '';
                        toggleElementDisabled('reponse-11', false);
                    }
                }
            }
        );

        // question 3 intensité modéré
        mainDiv.elements['reponse-6']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-6'].value === '0') {
                        mainDiv.elements['reponse-9'].value = 0;
                        toggleElementDisabled('reponse-9', true);
                    } else {
                        mainDiv.elements['reponse-9'].value = '';
                        toggleElementDisabled('reponse-9', false);

                    }
                }
            }
        );

        // question 3 forte intensité
        mainDiv.elements['reponse-7']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-7'].value === '0') {
                        mainDiv.elements['reponse-10'].value = 0;
                        toggleElementDisabled('reponse-10', true);
                    } else {
                        mainDiv.elements['reponse-10'].value = '';
                        toggleElementDisabled('reponse-10', false);
                    }
                }
            }
        );

        // question 6 pied
        mainDiv.elements['reponse-13']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-13'].value === '0') {
                        mainDiv.elements['reponse-17'].value = 0;
                        toggleRadioDisabled('reponse-17', true);

                        mainDiv.elements['reponse-21'].value = 0;
                        toggleElementDisabled('reponse-21', true);
                    } else {
                        resetRadio(mainDiv, 'reponse-17');
                        toggleRadioDisabled('reponse-17', false);

                        mainDiv.elements['reponse-21'].value = '';
                        toggleElementDisabled('reponse-21', false);
                    }
                }
            }
        );

        // question 6 vélo
        mainDiv.elements['reponse-14']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-14'].value === '0') {
                        mainDiv.elements['reponse-18'].value = 0;
                        toggleRadioDisabled('reponse-18', true);

                        mainDiv.elements['reponse-22'].value = 0;
                        toggleElementDisabled('reponse-22', true);
                    } else {
                        resetRadio(mainDiv, 'reponse-18');
                        toggleRadioDisabled('reponse-18', false);

                        mainDiv.elements['reponse-22'].value = '';
                        toggleElementDisabled('reponse-22', false);
                    }
                }
            }
        );

        // question 6 autre
        mainDiv.elements['reponse-15']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-15'].value === '0') {
                        mainDiv.elements['reponse-19'].value = 0;
                        toggleRadioDisabled('reponse-19', true);

                        mainDiv.elements['reponse-23'].value = 0;
                        toggleElementDisabled('reponse-23', true);
                    } else {
                        resetRadio(mainDiv, 'reponse-19');
                        toggleRadioDisabled('reponse-19', false);

                        mainDiv.elements['reponse-23'].value = '';
                        toggleElementDisabled('reponse-23', false);
                    }
                }
            }
        );

        // question 7 pieds
        mainDiv.elements['reponse-17']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-17'].value === '0') {
                        mainDiv.elements['reponse-21'].value = 0;
                        toggleElementDisabled('reponse-21', true);
                    } else {
                        mainDiv.elements['reponse-21'].value = '';
                        toggleElementDisabled('reponse-21', false);
                    }
                }
            }
        );

        // question 7 vélo
        mainDiv.elements['reponse-18']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-18'].value === '0') {
                        mainDiv.elements['reponse-22'].value = 0;
                        toggleElementDisabled('reponse-22', true);
                    } else {
                        mainDiv.elements['reponse-22'].value = '';
                        toggleElementDisabled('reponse-22', false);
                    }
                }
            }
        );

        // question 7 autre
        mainDiv.elements['reponse-19']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-19'].value === '0') {
                        mainDiv.elements['reponse-23'].value = 0;
                        toggleElementDisabled('reponse-23', true);
                    } else {
                        mainDiv.elements['reponse-23'].value = '';
                        toggleElementDisabled('reponse-23', false);
                    }
                }
            }
        );

        // question 9
        mainDiv.elements['reponse-24']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-24'].value === '0') {
                        mainDiv.elements['reponse-25'].value = 0;
                        toggleRadioDisabled('reponse-25', true);

                        mainDiv.elements['reponse-26'].value = 0;
                        toggleElementDisabled('reponse-26', true);
                    } else {
                        resetRadio(mainDiv, 'reponse-25');
                        toggleRadioDisabled('reponse-25', false);

                        mainDiv.elements['reponse-26'].value = '';
                        toggleElementDisabled('reponse-26', false);
                    }
                }
            }
        );

        // question 10
        mainDiv.elements['reponse-25']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-25'].value === '0') {
                        mainDiv.elements['reponse-26'].value = 0;
                        toggleElementDisabled('reponse-26', true);
                    } else {
                        mainDiv.elements['reponse-26'].value = '';
                        toggleElementDisabled('reponse-26', false);
                    }
                }
            }
        );

        // question 12
        mainDiv.elements['reponse-27']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-27'].value === '0') {
                        mainDiv.elements['reponse-28'].value = 0;
                        toggleRadioDisabled('reponse-28', true);

                        mainDiv.elements['reponse-29'].value = 0;
                        toggleElementDisabled('reponse-29', true);
                    } else {
                        resetRadio(mainDiv, 'reponse-28');
                        toggleRadioDisabled('reponse-28', false);

                        mainDiv.elements['reponse-29'].value = '';
                        toggleElementDisabled('reponse-29', false);
                    }
                }
            }
        );

        // question 13
        mainDiv.elements['reponse-28']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-28'].value === '0') {
                        mainDiv.elements['reponse-29'].value = 0;
                        toggleElementDisabled('reponse-29', true);
                    } else {
                        mainDiv.elements['reponse-29'].value = '';
                        toggleElementDisabled('reponse-29', false);
                    }
                }
            }
        );

        // question 15 intensité modéré
        mainDiv.elements['reponse-31']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-31'].value === '0') {
                        mainDiv.elements['reponse-34'].value = 0;
                        toggleRadioDisabled('reponse-34', true);

                        mainDiv.elements['reponse-37'].value = 0;
                        toggleElementDisabled('reponse-37', true);
                    } else {
                        resetRadio(mainDiv, 'reponse-34');
                        toggleRadioDisabled('reponse-34', false);

                        mainDiv.elements['reponse-37'].value = '';
                        toggleElementDisabled('reponse-37', false);
                    }
                }
            }
        );

        // question 15 forte intensité
        mainDiv.elements['reponse-32']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-32'].value === '0') {
                        mainDiv.elements['reponse-35'].value = 0;
                        toggleRadioDisabled('reponse-35', true);

                        mainDiv.elements['reponse-38'].value = 0;
                        toggleElementDisabled('reponse-38', true);
                    } else {
                        resetRadio(mainDiv, 'reponse-35');
                        toggleRadioDisabled('reponse-35', false);

                        mainDiv.elements['reponse-38'].value = '';
                        toggleElementDisabled('reponse-38', false);
                    }
                }
            }
        );

        // question 16 intensité modéré
        mainDiv.elements['reponse-34']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-34'].value === '0') {
                        mainDiv.elements['reponse-37'].value = 0;
                        toggleElementDisabled('reponse-37', true);
                    } else {
                        mainDiv.elements['reponse-37'].value = '';
                        toggleElementDisabled('reponse-37', false);
                    }
                }
            }
        );

        // question 16 forte intensité
        mainDiv.elements['reponse-35']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-35'].value === '0') {
                        mainDiv.elements['reponse-38'].value = 0;
                        toggleElementDisabled('reponse-38', true);
                    } else {
                        mainDiv.elements['reponse-38'].value = '';
                        toggleElementDisabled('reponse-38', false);
                    }
                }
            }
        );

        // question 18 écran
        mainDiv.elements['reponse-40']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-40'].value === '0') {
                        mainDiv.elements['reponse-43'].value = 0;
                        toggleRadioDisabled('reponse-43', true);

                        mainDiv.elements['reponse-46'].value = 0;
                        toggleElementDisabled('reponse-46', true);
                    } else {
                        resetRadio(mainDiv, 'reponse-43');
                        toggleRadioDisabled('reponse-43', false);

                        mainDiv.elements['reponse-46'].value = '';
                        toggleElementDisabled('reponse-46', false);
                    }
                }
            }
        );

        // question 18 autre
        mainDiv.elements['reponse-41']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-41'].value === '0') {
                        mainDiv.elements['reponse-44'].value = 0;
                        toggleRadioDisabled('reponse-44', true);

                        mainDiv.elements['reponse-47'].value = 0;
                        toggleElementDisabled('reponse-47', true);
                    } else {
                        resetRadio(mainDiv, 'reponse-44');
                        toggleRadioDisabled('reponse-44', false);

                        mainDiv.elements['reponse-47'].value = '';
                        toggleElementDisabled('reponse-47', false);
                    }
                }
            }
        );

        // question 19 écran
        mainDiv.elements['reponse-43']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-43'].value === '0') {
                        mainDiv.elements['reponse-46'].value = 0;
                        toggleElementDisabled('reponse-46', true);
                    } else {
                        mainDiv.elements['reponse-46'].value = '';
                        toggleElementDisabled('reponse-46', false);
                    }
                }
            }
        );

        // question 19 autre
        mainDiv.elements['reponse-44']?.forEach(
            r => {
                r.onclick = () => {
                    if (mainDiv.elements['reponse-44'].value === '0') {
                        mainDiv.elements['reponse-47'].value = 0;
                        toggleElementDisabled('reponse-47', true);
                    } else {
                        mainDiv.elements['reponse-47'].value = '';
                        toggleElementDisabled('reponse-47', false);
                    }
                }
            }
        );

    }

    return {
        init
    };
})();