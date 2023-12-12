"use strict";

document.addEventListener('DOMContentLoaded', function () {
    modalConsentement.init();
}, false);

/**
 * Affichage de la section consentement
 */
let modalConsentement = (function () {
    const formAccord = document.getElementById('form-consentement');
    const plusText = document.getElementById("plus-text-consentement");
    const voirPlusButton = document.getElementById("voir-plus-consentement");
    const mainDiv = document.getElementById('main-navbar');
    const id_patient = mainDiv.getAttribute('data-id_patient');

    const $modalConsentement = $("#modal-consentement");

    let init = function () {
        // si c'est un patient qui vient d'être ajouté
        if (mainDiv.getAttribute('data-is_new') == "1") {
            $modalConsentement.modal('show');
        }

        if (voirPlusButton) {
            voirPlusButton.onclick = (event) => {
                event.preventDefault();

                if (plusText.style.display === "inline") {
                    voirPlusButton.innerHTML = "Voir plus d'informations";
                    plusText.style.display = "none";
                } else {
                    voirPlusButton.innerHTML = "Voir moins d'informations";
                    plusText.style.display = "inline";
                }
            };
        }

        if (formAccord) {
            formAccord.onsubmit = (e) => {
                e.preventDefault();
                $modalConsentement.modal('hide');

                const new_data = {
                    'consentement': getSelectedRadioValue(formAccord, 'accord'),
                    'id_patient': id_patient
                };

                // Update dans la BDD
                fetch('/PHP/Patients/UpdatePatientConsentement.php', {
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
                        toast("Le consentement du patient a été modifié avec succès");
                        changeElementsConsentement(new_data.consentement);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        toast("Echec de la modification");
                        // $canBeHidden2Elems.hide();
                    });
            }
        }
    }

    function changeElementsConsentement(consentement) {
        if (consentement == '1') {
            $(".can-be-hidden-2").show();
            document.getElementById("logo-consentement-ok").style.display = "inline";
            document.getElementById("logo-consentement-not-ok").style.display = "none";
            document.getElementById("logo-consentement-attente").style.display = "none";
        } else if (consentement == '0') {
            $(".can-be-hidden-2").hide();
            document.getElementById("logo-consentement-ok").style.display = "none";
            document.getElementById("logo-consentement-not-ok").style.display = "inline";
            document.getElementById("logo-consentement-attente").style.display = "none";
        } else {
            $(".can-be-hidden-2").hide();
            document.getElementById("logo-consentement-ok").style.display = "none";
            document.getElementById("logo-consentement-not-ok").style.display = "none";
            document.getElementById("logo-consentement-attente").style.display = "inline";
        }
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

    function toast(msg) {
        const toastDiv = document.getElementById("toast");

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