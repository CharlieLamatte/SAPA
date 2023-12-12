"use strict";

$(document).ready(function () {
    // initialisation des élements de la page
    calendrierType.init();
    modalCreneau.init({
        'urlCreateCreneau': 'CreateCreneau.php',
        'urlUpdateCreneau': 'UpdateCreneau.php',
        'urlReadCreneau': 'RecupOneInfosCreneau.php',
        'urlUpdateParticipants': 'Participants/UpdateParticipants.php',
        'urlReadParticipants': 'Participants/ReadAllParticipantsCreneau.php',
        'urlAutocompletionCodePostal': '../Villes/ReadAllVille.php',
        'urlReadAllIntervenantsStructure': '../Intervenants/ReadAllStructure.php'
    });
});

let calendrierType = (function () {
    let id_structure;

    // filtres
    const filtreActif = document.getElementById("actif");
    const filtreNonActif = document.getElementById("non-actif");
    const filtreTous = document.getElementById("tous");

    const calendarEl = document.getElementById('calendar-type');
    const $listColor = ["#fd0000", "#2dff00", "#0620d3", "#d36c06", "#6206d3", "#d306aa", "#06d395", "#99d306", "#06a3d3"];
    let calendar;

    function init() {
        id_structure = localStorage.getItem('id_structure');

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialDate: '2022-01-04',
            initialView: 'timeGridWeek',
            dayHeaderFormat: {weekday: 'long'},
            locale: 'fr',
            allDaySlot: false,
            headerToolbar: {
                left: '',
                center: '',
                right: ''
            },
            slotMinTime: "07:00:00",
            slotMaxTime: "23:00:00",
            weekNumberCalculation: 'ISO',
            height: 'auto',
            eventStartEditable: false,
            eventResizableFromStart: false,
            eventDurationEditable: false,
            eventClick: function (event) {
                modalCreneau.setModalMode(MODE.READONLY);
                modalCreneau.setInfosCreneau(event.event.extendedProps.id_creneau);
                $('#modal').modal('show');
            },
            eventDidMount: function (event) {
                // filtrage des créneaux
                if (filtreActif.checked && event.event.extendedProps.activation != 1) {
                    event.el.style.display = "none";
                } else if (filtreNonActif.checked && event.event.extendedProps.activation != 0) {
                    event.el.style.display = "none";
                }
            },
            events: function (info, successCallback, failureCallback) {
                fetch('ReadCreneauStructure.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({"id_structure": id_structure}),
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
                        const allEvents = [];
                        data.forEach(c => {
                            const events = createEventsFromCreneau(c);
                            allEvents.push(...events);
                        });
                        successCallback(allEvents);
                    })
                    .catch((error) => {
                        console.error('Error recup infos creneau:', error);
                        failureCallback(error);
                    });
            }
        });
        calendar.render();

        $('input[type=radio][name="filtre-activation"]').change(function () {
            updateCreneaux();
        });
    }

    /**
     * Récupère de nouveau les
     */
    function updateCreneaux() {
        calendar.refetchEvents();
    }

    /**
     *
     * @param creneau
     * @returns {*[]} un array d'events à partir d'un créneau
     */
    function createEventsFromCreneau(creneau) {
        const jours = {
            '1': '2022-01-03',
            '2': '2022-01-04',
            '3': '2022-01-05',
            '4': '2022-01-06',
            '5': '2022-01-07',
            '6': '2022-01-08',
            '7': '2022-01-09',
        };

        const events = [];
        if (creneau.id_jour == 8) {
            for (const id_jour in jours) {
                events.push({
                    id: creneau.id_creneau,
                    id_creneau: creneau.id_creneau,
                    activation: creneau.activation,
                    title: creneau.nom_creneau,
                    start: jours[id_jour] + "T" + creneau.nom_heure_debut,
                    end: jours[id_jour] + "T" + creneau.nom_heure_fin,
                    structure: creneau.nom_structure,
                    backgroundColor: "#0620d3",
                    jour: creneau.jour,
                });
            }
        } else {
            events.push({
                id: creneau.id_creneau,
                id_creneau: creneau.id_creneau,
                activation: creneau.activation,
                title: creneau.nom_creneau,
                start: jours[creneau.id_jour] + "T" + creneau.nom_heure_debut,
                end: jours[creneau.id_jour] + "T" + creneau.nom_heure_fin,
                structure: creneau.nom_structure,
                backgroundColor: "#0620d3",
                jour: creneau.jour,
            });
        }

        return events;
    }

    return {
        init,
        updateCreneaux
    }
})();