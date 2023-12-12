"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 */

// les différents modes d'interaction avec le modal
const MODE = {
    ADD: 'add',
    EDIT: 'edit',
    READONLY: 'readonly',
};
Object.freeze(MODE);

$(document).ready(function () {
    // initialisation des élements de la page
    tableNotificationsMaj.init();
    modalNotification.init();
});

const tableNotificationsMaj = (function () {
    const $table = $('#table-notifications');
    const tableBody = document.getElementById('body-notifications');

    let datatable = null;
    // parametres utilisateur
    // la valeur par défaut est 10
    let nombre_elements_tableaux;

    function init() {
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

        fetch('ReadAllNotificationMaj.php', {
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
            .then(data => {
                initTable(data);
            })
            .catch((error) => {
                console.log(error);
                initTable(null);
            });
    }

    function initTable(data) {
        if (Array.isArray(data)) {
            for (const notification of data) {
                tableBody.append(createLigne(notification));
            }
        }

        datatable = $table.DataTable({
            "scrollX": true,
            "autoWidth": true,
            responsive: true,
            language: {url: "../../js/DataTables/media/French.json"},
            "pageLength": nombre_elements_tableaux,
            order: [
                [0, "desc"]
            ],
        });
        datatable.draw();
    }

    function createLigne(notification) {
        let row = document.createElement('tr');
        row.id = 'row-' + notification.id_notification;

        let td1 = document.createElement('td');
        td1.className = "text-left";
        td1.textContent = notification.date_default_format;
        td1.setAttribute("id", "td1-" + notification.id_notification);

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = notification.text_notification;
        td2.setAttribute("id", "td2-" + notification.id_notification);

        let td3 = document.createElement('td');
        td3.className = "text-left";

        let details = document.createElement('a');
        details.setAttribute("data-toggle", "modal");
        details.setAttribute("data-target", "#modal");
        details.setAttribute("data-backdrop", "static");
        details.setAttribute("data-keyboard", "false");
        details.textContent = "Détail";
        details.className = "clickable";

        function handleDetailClick() {
            modalNotification.setModalMode(MODE.READONLY);
            modalNotification.setInfosNotification(notification.id_notification);
        }

        details.onclick = handleDetailClick;

        td3.append(details);
        row.append(td1, td2, td3);

        return row;
    }

    function addRow(notification) {
        datatable.row.add(createLigne(notification));
        datatable.draw();
    }

    function deleteRow(id_notification) {
        const row = document.getElementById('row-' + id_notification);
        row.remove();
        //datatable.draw();
    }

    function replaceRowValues(notification) {
        const td2 = document.getElementById("td2-" + notification.id_notification);
        td2.textContent = notification.text_notification;

        // redraw la table
        datatable.rows().invalidate().draw();
    }

    return {
        init,
        addRow,
        deleteRow,
        replaceRowValues
    };
})();

const modalNotification = (function () {
    const ajoutModalButton = document.getElementById("ajout-modal");

    // les element du modal qui peuvent être désactivés (en général tous sauf les bouton abandon, etc ...)
    const canBeDisabledElems = document.getElementsByClassName("can-disable");

    // le formulaire
    const form = document.getElementById("form-notification");

    const texteNotificationTextArea = document.getElementById("texte-notification");
    const panelBodyPreview = document.getElementById("body-preview");

    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    // boutons du modal
    //const confirmclosedButton = $("#confirmclosed");
    const warningModalConfirmButton = document.getElementById('warning-modal-confirm');
    const warningModalRefuseButton = document.getElementById('warning-modal-refuse');

    const enregistrerOuModifier = document.getElementById("enregistrer-modifier");
    const close = document.getElementById("close");

    // les 2 modals
    const $warningModal = $("#warning-modal");
    const $mainModal = $("#modal");
    const modalTitle = document.getElementById("modal-title");
    const warningModalText = document.getElementById('warning-modal-text');

    // boutton de suppression
    const deleteButton = document.getElementById("delete");

    function init() {
        ajoutModalButton.onclick = () => {
            modalNotification.setModalMode(MODE.ADD);
        };

        texteNotificationTextArea.onchange = handleTextChange;

        warningModalConfirmButton.addEventListener("click", function () {
            $warningModal.modal('hide');
            $mainModal.modal('hide');
        });
    }

    function handleTextChange() {
        panelBodyPreview.innerHTML = texteNotificationTextArea.value;
    }

    function handleConfirmCloseClick() {
        getConfirmation('Quitter sans enregistrer?');
    }

    function handleModifierClick(event) {
        event.preventDefault();
        setModalMode(MODE.EDIT);
    }

    function handleCreateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            $mainModal.modal('hide');

            lockForm(form)
                .then(canContinue => {
                    if (canContinue) {
                        // Insert dans la BDD
                        fetch("CreateNotificationMaj.php", {
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
                                toast("Notification ajoutée avec succès");
                                tableNotificationsMaj.addRow(data);
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                toast("Echec de l'ajout");
                            });
                    }
                });
        }
    }

    function handleUpdateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            $mainModal.modal('hide');

            lockForm(form)
                .then(canContinue => {
                    if (canContinue) {
                        const new_data = getFormData();

                        // Update dans la BDD
                        fetch("UpdateNotificationMaj.php", {
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
                            .then(() => {
                                toast("Notification modifiée avec succès");
                                tableNotificationsMaj.replaceRowValues(new_data);
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                toast("Echec de la modification");
                            });
                    }
                });
        }
    }

    function handleDeleteClick(event) {
        event.preventDefault();

        getConfirmation('Supprimer la notification?').then(is_delete => {
            $mainModal.modal('hide');

            if (is_delete) {
                const new_data = getFormData();

                // Update dans la BDD
                fetch("DeleteNotificationMaj.php", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({"id_notification": new_data.id_notification}),
                })
                    .then(async response => {
                        if (!response.ok) {
                            let json = '';
                            try {
                                json = await response.json();
                            } catch (e) {
                            }

                            throw {
                                statusCode: response.status,
                                message: json?.message
                            };
                        }
                        return response.json()
                    })
                    .then(() => {
                        toast("Notification supprimée avec succès.");
                        console.log(new_data.id_notification);
                        tableNotificationsMaj.deleteRow(new_data.id_notification);
                    })
                    .catch((error) => {
                        if (error?.message) {
                            alert(error?.message);
                        } else {
                            alert("Échec de l'ajout. Cause: erreur inconnue");
                        }
                    });
            }
        });
    }

    function setInfosNotification(id_notification) {
        fetch("ReadOneNotification.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_notification": id_notification}),
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
                form.setAttribute("data-id_notification", data.id_notification);
                texteNotificationTextArea.value = data.text_notification;
                handleTextChange();
            })
            .catch((error) => {
                console.error(error);
            });
    }

    function getFormData() {
        return {
            "id_notification": form.getAttribute("data-id_notification"),
            "text_notification": texteNotificationTextArea.value,
        }
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

    async function getConfirmation(txt) {
        warningModalText.textContent = txt;
        $warningModal.modal('show');

        return new Promise((resolve => {
            warningModalConfirmButton.onclick = () => {
                $warningModal.modal('hide');
                resolve(true);
            };

            warningModalRefuseButton.onclick = () => {
                $warningModal.modal('hide');
                resolve(false);
            };
        }));
    }

    function toggleDeleteButtonHidden(on) {
        if (on) {
            deleteButton.style.display = 'none';
        } else {
            deleteButton.style.display = 'block';
        }
    }

    function toggleChampDisabled(on) {
        if (on) {
            for (let i = 0; i < canBeDisabledElems.length; i++) {
                canBeDisabledElems[i].setAttribute("disabled", "");
            }
        } else {
            for (let i = 0; i < canBeDisabledElems.length; i++) {
                canBeDisabledElems[i].removeAttribute("disabled");
            }
        }
    }

    /**
     *
     * @param mode {MODE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE.ADD) {
            modalTitle.textContent = "Ajout";
            form.reset();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleCreateClick);

            deleteButton.removeEventListener("click", handleDeleteClick);
            toggleDeleteButtonHidden(true);

            enregistrerOuModifier.textContent = "Enregistrer";
        } else if (mode === MODE.EDIT) {
            modalTitle.textContent = "Modifier";
            toggleChampDisabled(false);
            unlockForm(form); // autorise l'envoie de données par le formulaire

            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleUpdateClick);
            deleteButton.addEventListener("click", handleDeleteClick);
            toggleDeleteButtonHidden(false);

            enregistrerOuModifier.textContent = "Enregistrer";
        } else {
            // mode par défaut : MODE.READONLY
            modalTitle.textContent = "Détails";
            form.reset();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(true);

            close.setAttribute("data-dismiss", "modal");
            close.removeEventListener('click', handleConfirmCloseClick);

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.addEventListener("click", handleModifierClick);
            deleteButton.addEventListener("click", handleDeleteClick);
            toggleDeleteButtonHidden(true);

            enregistrerOuModifier.textContent = "Modifier";
        }
    }

    return {
        init,
        setModalMode,
        setInfosNotification
    };
})();
