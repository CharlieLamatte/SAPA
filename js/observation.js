"use strict";

/**
 * Ce fichier nécessite:
 * observations.js
 * commun.js
 */

/**
 * Le type d'observation
 */
const TYPE_OBSERVATION = {
    SANTE: 1,
    PROGRESSION: 2,
};
Object.freeze(TYPE_OBSERVATION);

/**
 * Affichage et ajout des observations
 */
const observationsDetails = (function () {
    const mainDiv = document.getElementById('main');

    const id_patient = mainDiv.getAttribute('data-id_patient');
    const id_user = mainDiv.getAttribute('data-id_user');

    // le formulaire
    const form = document.getElementById('form-observation');

    // les champs du formulaire
    const observationsInput = document.getElementById('observation');

    // l'affichage des observations
    const obsTextarea = document.getElementById('obs');

    let urlCreateObservation;
    let typeObservation;

    const init = function (urlReadAllObservations_, urlCreateObservation_, typeObservation_) {
        urlCreateObservation = urlCreateObservation_;
        typeObservation = typeObservation_;

        let observations = fetch(urlReadAllObservations_, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "id_patient": id_patient,
                "id_type_observation": typeObservation,
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

        // on rempli le détail des observations quand toutes les données ont été récupérées
        Promise.all([observations])
            .then(result => {
                setDetails(result[0]);
            });

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            handleCreate(event);
        });
    };

    function getFormData() {
        return {
            'id_user': id_user,
            'id_patient': id_patient,
            'observation': observationsInput.value,
            'id_type_observation': typeObservation
        };
    }

    function handleCreate(event) {
        lockForm(form, event)
            .then(canContinue => {
                if (canContinue) {
                    fetch(urlCreateObservation, {
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
                            addObservation(data);
                            form.reset();
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                }
            })
            .then(() => unlockForm(form));
    }

    function setDetails(observations) {
        if (Array.isArray(observations)) {
            for (const observation of observations) {
                addObservation(observation);
            }
        }
    }

    function addObservation(observation) {
        obsTextarea.textContent = '  ' + observation.nom_coordonnees + ' ' +
            observation.prenom_coordonnees + ' ' +
            observation.date_observation + ': ' + observation.observation + '\n' + obsTextarea.textContent;
        obsTextarea.scrollTop = 0;
    }

    return {
        init
    };
})();