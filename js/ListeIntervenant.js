"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 */

// les différents modes d'interaction avec le modal
const MODE = {
    ADD: 'add',
    EDIT: 'edit',
    READONLY: 'readonly',
    FUSION: 'fusion'
};
Object.freeze(MODE);

$(document).ready(function () {
    // initialisation des élements de la page
    tableauIntervenant.init();
    modalIntervenant.init();
});

/**
 * Affichage du tableau
 */
let tableauIntervenant = (function () {
    const $table = $('#table_id');
    let datatable = null;

    // parametres utilisateur
    // la valeur par défaut est 10
    const nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

    /**
     * Initialisation du tableau
     */
    let init = function () {
        fetch('RecupInfosIntervenant.php', {
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
                actualiserInfos(data);
            })
            .catch((error) => {
                actualiserInfos(null);
            });
    };

    function actualiserInfos(data) {
        // initialisation de la Datatable
        datatable = $table.DataTable({
            "scrollX": true,
            "autoWidth": true,
            responsive: true,
            language: {url: "../../js/DataTables/media/French.json"},
            "pageLength": nombre_elements_tableaux
        });

        if (Array.isArray(data)) {
            for (const intervenant of data) {
                addRow(intervenant, false);
            }
        }
        datatable.draw();
    }

    function createLigne(intervenant) {
        let row = document.createElement('tr');
        row.id = 'row-' + intervenant.id_intervenant;

        let td1 = document.createElement('td');
        td1.className = "text-left clickable";
        td1.setAttribute("id", "td1-" + intervenant.id_intervenant);
        td1.setAttribute("data-toggle", "modal");
        td1.setAttribute("data-target", "#modal");
        td1.setAttribute("data-backdrop", "static");
        td1.setAttribute("data-keyboard", "false");
        td1.textContent = intervenant.nom_intervenant;

        let td2 = document.createElement('td');
        td2.className = "text-left clickable";
        td2.setAttribute("id", "td2-" + intervenant.id_intervenant);
        td2.setAttribute("data-toggle", "modal");
        td2.setAttribute("data-target", "#modal");
        td2.setAttribute("data-backdrop", "static");
        td2.setAttribute("data-keyboard", "false");
        td2.textContent = intervenant.prenom_intervenant;

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.setAttribute("id", "td3-" + intervenant.id_intervenant);
        if (intervenant.tel_fixe_intervenant == null || intervenant.tel_fixe_intervenant === "") {
            td3.textContent = "Aucun";
        } else {
            td3.textContent = intervenant.tel_fixe_intervenant;
        }

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.setAttribute("id", "td4-" + intervenant.id_intervenant);
        if (intervenant.tel_portable_intervenant == null || intervenant.tel_portable_intervenant === "") {
            td4.textContent = "Aucun";
        } else {
            td4.textContent = intervenant.tel_portable_intervenant;
        }

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.setAttribute("id", "td5-" + intervenant.id_intervenant);

        let mailLink = document.createElement('a');
        if (intervenant.mail_intervenant == null || intervenant.mail_intervenant === "") {
            td5.textContent = "Aucun";
        } else {
            mailLink.textContent = intervenant.mail_intervenant;
            mailLink.setAttribute("href", "mailto:" + intervenant.mail_intervenant);
            td5.append(mailLink);
        }

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.setAttribute("id", "td6-" + intervenant.id_intervenant);
        td6.textContent = intervenant.is_user ? "OUI" : "NON";

        let td7 = document.createElement('td');
        td7.className = "text-left";
        td7.setAttribute("id", "td7-" + intervenant.id_intervenant);
        if (intervenant.structures == null || intervenant.structures.length === 0) {
            td7.textContent = "Aucune";
        } else if (intervenant.structures.length === 1) {
            td7.textContent = intervenant.structures[0].nom_structure;
        } else {
            td7.textContent = "Multi-structure";
        }

        let td8 = document.createElement('td');
        td8.className = "text-left";
        td8.setAttribute("id", "td8-" + intervenant.id_intervenant);

        let details = document.createElement('a');
        details.setAttribute("data-toggle", "modal");
        details.setAttribute("data-target", "#modal");
        details.setAttribute("data-backdrop", "static");
        details.setAttribute("data-keyboard", "false");
        details.textContent = "Détail";
        details.className = "clickable";

        function handleClickDetails(event) {
            //event.preventDefault();
            modalIntervenant.setModalMode(MODE.READONLY);
            modalIntervenant.setInfosIntervenant(intervenant.id_intervenant);
        }

        details.onclick = handleClickDetails;
        td1.onclick = handleClickDetails;

        td8.append(details);

        row.append(td1, td2, td3, td4, td5, td6, td7, td8);

        return row;
    }

    /**
     * Remplace les valeurs de la ligne du tableau qui correspond à l'intervenant modifié
     * @param intervenant le nouvel intervenant
     */
    function replaceRowValues(intervenant) {
        const td1 = document.getElementById("td1-" + intervenant.id_intervenant);
        const td2 = document.getElementById("td2-" + intervenant.id_intervenant);
        const td3 = document.getElementById("td3-" + intervenant.id_intervenant);
        const td4 = document.getElementById("td4-" + intervenant.id_intervenant);
        const td5 = document.getElementById("td5-" + intervenant.id_intervenant);

        td1.textContent = intervenant.nom_intervenant;
        td2.textContent = intervenant.prenom_intervenant;
        if (intervenant.tel_fixe_intervenant == null || intervenant.tel_fixe_intervenant === "") {
            td3.textContent = "Aucun";
        } else {
            td3.textContent = intervenant.tel_fixe_intervenant;
        }
        if (intervenant.tel_portable_intervenant == null || intervenant.tel_portable_intervenant === "") {
            td4.textContent = "Aucun";
        } else {
            td4.textContent = intervenant.tel_portable_intervenant;
        }
        if (intervenant.mail_intervenant == null || intervenant.mail_intervenant === "") {
            td5.textContent = "Aucun";
        } else {
            td5.textContent = "";
            let mailLink = document.createElement('a');
            mailLink.textContent = intervenant.mail_intervenant;
            mailLink.setAttribute("href", "mailto:" + intervenant.mail_intervenant);
            td5.append(mailLink);
        }
    }

    function addRow(intervenant, is_draw) {
        datatable.row.add(createLigne(intervenant));

        if (is_draw) {
            datatable.draw();
        }
    }

    function deleteRow(id_intervenant) {
        const row = document.getElementById('row-' + id_intervenant);

        row.remove();
    }

    return {
        init,
        replaceRowValues,
        addRow,
        deleteRow
    };
})();

/**
 * Affichage du modal intervenant
 */
let modalIntervenant = (function () {
    // le bouton qui ouvre le modal d'ajout
    const ajoutModalButton = document.getElementById("ajout-modal");
    // le bouton qui ouvre le modal de fusion
    const fusionModalButton = document.getElementById("fusion-modal-intervenant");
    // les element du modal qui peuvent être désactivés (en général tous sauf les bouton abandon, etc ...)
    const canBeDisabledElems = document.getElementsByClassName("can-disable");
    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    // boutons du modal
    //const confirmclosedButton = $("#confirmclosed");
    const confirmclosed = document.getElementById('confirmclosed');
    const refuseclosed = document.getElementById('refuseclosed');
    const enregistrerOuModifier = document.getElementById("enregistrer-modifier");
    const close = document.getElementById("close");

    const createUserButton = document.getElementById("create_user");

    // boutton de suppression
    const deleteButton = document.getElementById("delete");

    // les 2 modals
    const warningModal = $("#warning");
    const mainModal = $("#modal");
    const modalTitle = document.getElementById("modal-title");
    const warningText = document.getElementById('warning-text');

    // le formulaire
    const form = document.getElementById("form-intervenant");

    // la partie structure
    const listeStructureDiv = document.getElementById("liste-structure");
    const addStructureInput = document.getElementById("add-structure");

    // la partie créneaux
    const bodyCreneaux = document.getElementById("body-creneaux");
    const creneauxFielset = document.getElementById("creneaux");

    // les 2 sections
    const sectionUpdateOrCreate = document.getElementById("section-update-or-create");
    const sectionFusion = document.getElementById("section-fusion-intervenant");

    // input et select du form
    const nomInput = document.getElementById("nom");
    const prenomInput = document.getElementById("prenom");
    const emailInput = document.getElementById("email");
    const telProtableInput = document.getElementById("tel-portable");
    const telFixeInput = document.getElementById("tel-fixe");
    const statutSelect = document.getElementById("statut");
    const numero_carteInput = document.getElementById("numero_carte");
    const id_territoireSelect = document.getElementById("id_territoire");
    // les diplômes
    const listeDiplomeDiv = document.getElementById("liste-diplome");
    const addDiplomeButton = document.getElementById("add-diplome");
    const diplomeSelect = document.getElementById("diplome");

    // form partie fusion
    const addIntervenant1Input = document.getElementById("add-intervenant-1");
    const addIntervenant2Input = document.getElementById("add-intervenant-2");

    const nom1Input = document.getElementById("nom-1");
    const prenom1Input = document.getElementById("prenom-1");
    const idIntervenant1Input = document.getElementById("id-intervenant-1");

    const nom2Input = document.getElementById("nom-2");
    const prenom2Input = document.getElementById("prenom-2");
    const idIntervenant2Input = document.getElementById("id-intervenant-2");

    /**
     * Initialisation du modal
     */
    let init = function () {
        ajoutModalButton.onclick = function (event) {
            event.preventDefault();
            setModalMode(MODE.ADD);
        };

        if (fusionModalButton) {
            fusionModalButton.onclick = function (event) {
                event.preventDefault();
                setModalMode(MODE.FUSION);
            };
        }

        confirmclosed.addEventListener("click", function () {
            warningModal.modal('hide');
            mainModal.modal('hide');
        });

        trouverStructure('../Structures/ReadAllStructures.php');
        trouverIntervenant('../Intervenants/RecupInfosIntervenant.php')

        // click sur un bouton de suppression d'une structure
        listeStructureDiv.addEventListener('click', event => {
            if (event.target.className.includes('delete')) {
                event.target.parentElement.parentElement.remove();
            }
        });

        // click sur le bouton d'ajout d'un diplôme
        addDiplomeButton.addEventListener('click', event => {
            event.preventDefault();
            const diplome = {
                'id_diplome': diplomeSelect.value,
                'nom_diplome': diplomeSelect.options[diplomeSelect.selectedIndex].text
            };
            handleAddDiplome(diplome);
        });

        // click sur un bouton de suppression d'un diplôme
        listeDiplomeDiv.addEventListener('click', event => {
            if (event.target.className.includes('delete')) {
                event.target.parentElement.parentElement.remove();
            }
        });

        // création d'un utilisateur à partir d'un intervenant non-utilisateur
        createUserButton.addEventListener('click', event => {
            event.preventDefault();

            warningModal.modal('show');
            warningText.textContent = 'Créer un utilisateur pour cet intervenant?';

            event.preventDefault();

            getConfirmation().then(is_confirmed => {
                if (is_confirmed) {
                    postForm('../Users/ListeUser.php', getFormData());
                }
            });
        });
    };

    function postForm(path, params, method) {
        method = method || 'post';

        const form = document.createElement('form');
        form.setAttribute('method', method);
        form.setAttribute('action', path);

        for (let key in params) {
            if (params.hasOwnProperty(key)) {
                if (Array.isArray(params[key])) {
                    params[key].forEach(value => {
                        const name = key + "[]";
                        const hiddenField = createHiddenField(name, value);
                        form.appendChild(hiddenField);
                    });
                } else {
                    // creation d'un seul champ
                    const hiddenField = createHiddenField(key, params[key]);
                    form.appendChild(hiddenField);
                }
            }
        }
        document.body.appendChild(form);
        form.submit();
    }

    function createHiddenField(name, value) {
        const hiddenField = document.createElement('input');
        hiddenField.setAttribute('type', 'hidden');
        hiddenField.setAttribute('name', name);
        hiddenField.setAttribute('value', value);

        return hiddenField;
    }

    function getFormData() {
        const structures = document.querySelectorAll('.structure-element');
        const structureIds = [];
        for (let i = 0; i < structures.length; i++) {
            structureIds.push(structures[i].getAttribute("data-id-structure"));
        }

        const diplomes = document.querySelectorAll('.diplome-element');
        const diplomeIds = [];
        for (let i = 0; i < diplomes.length; i++) {
            diplomeIds.push(diplomes[i].getAttribute("data-id-diplome"));
        }

        return {
            "id_intervenant": form.getAttribute("data-id_intervenant"),
            "nom_intervenant": nomInput.value,
            "prenom_intervenant": prenomInput.value,
            "numero_carte": numero_carteInput.value,
            "mail_intervenant": emailInput.value,
            "tel_fixe_intervenant": telFixeInput.value,
            "tel_portable_intervenant": telProtableInput.value,
            "id_statut_intervenant": statutSelect.value,
            "id_territoire": id_territoireSelect.value,
            "structures": structureIds,
            "diplomes": diplomeIds,
            "id_intervenant_1": idIntervenant1Input.value,
            "id_intervenant_2": idIntervenant2Input.value
        };
    }

    function trouverStructure(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (reponse) {
                autocompleteStructure(addStructureInput, reponse);
            },
            error: function (res, status, err) {
                console.error(status + status + err)
            },
            complete: function () {
            }
        });
    }

    function autocompleteStructure(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        let currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function (e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (let i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                val = val.toUpperCase();
                if (arr[i].nom_structure.substring(0, val.length).toUpperCase() === val) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input style='width:500px;' value='" + sanitize(arr[i].nom_structure) + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = "";
                        handleAddStructure(arr[i]);
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function (e) {
            let x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode === 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode === 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode === 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (let i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            let x = document.getElementsByClassName("autocomplete-items");
            for (let i = 0; i < x.length; i++) {
                if (elmnt !== x[i] && elmnt !== inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }

        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    function trouverIntervenant(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (reponse) {
                autocompleteIntervenant(addIntervenant1Input, reponse, 1);
                autocompleteIntervenant(addIntervenant2Input, reponse, 2);
            },
            error: function (res, status, err) {
                console.error(status + status + err)
            },
            complete: function () {
            }
        });
    }

    function autocompleteIntervenant(inp, arr, num) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        let currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function (e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (let i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                val = val.toUpperCase();
                if (arr[i].nom_intervenant.substring(0, val.length).toUpperCase() === val) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input style='width:500px;' value='" + " id:" + sanitize(arr[i].id_intervenant) + " " + sanitize(arr[i].nom_intervenant) + " " + sanitize(arr[i].prenom_intervenant) + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = "";
                        handleAddIntervenant(arr[i], num);
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function (e) {
            let x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode === 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode === 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode === 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (let i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            let x = document.getElementsByClassName("autocomplete-items");
            for (let i = 0; i < x.length; i++) {
                if (elmnt !== x[i] && elmnt !== inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }

        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    function handleAddIntervenant(intervenant, num) {
        if (num === 1) {
            if (idIntervenant2Input.value != "" && idIntervenant2Input.value == intervenant.id_intervenant) {
                return;
            }

            nom1Input.value = intervenant.nom_intervenant;
            prenom1Input.value = intervenant.prenom_intervenant;
            idIntervenant1Input.value = intervenant.id_intervenant;
        } else if (num === 2) {
            if (idIntervenant1Input.value != "" && idIntervenant1Input.value == intervenant.id_intervenant) {
                return;
            }

            nom2Input.value = intervenant.nom_intervenant;
            prenom2Input.value = intervenant.prenom_intervenant;
            idIntervenant2Input.value = intervenant.id_intervenant;
        }
    }

    function handleConfirmCloseClick() {
        warningModal.modal('show');
    }

    function handleModifierClick(event) {
        event.preventDefault();
        setModalMode(MODE.EDIT);
    }

    function verif_coordonnees() {
        if ((telProtableInput.value === "") && (telFixeInput.value === "") && (emailInput.value === "")) {
            alert(" Vous devez saisir soit le numéro téléphone portable, soit le numéro de téléphone fixe soit une adresse mail");
            return false;
        } else if ((telProtableInput.value !== "") && (telFixeInput.value !== "") && (telFixeInput.value === telProtableInput.value)) {
            alert("Les deux numéros de téléphone doivent être différents");
            return false;
        }
        return true;
    }

    function createStructureElement(structure) {
        const row = document.createElement('div');
        row.className = 'row structure-element';
        row.setAttribute("data-id-structure", structure.id_structure);

        const colVide = document.createElement('div');
        colVide.className = 'col-md-1';

        const colNom = document.createElement('div');
        colNom.className = 'col-md-9';

        const input = document.createElement('input');
        input.value = structure.nom_structure;
        input.className = 'form-control input-md';
        input.setAttribute("readOnly", "");

        const colDelete = document.createElement('div');
        colDelete.className = 'col-md-2';

        const deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger delete';
        deleteButton.setAttribute("data-id-structure", structure.id_structure);
        deleteButton.textContent = 'Supprimer';
        if (structure.is_intervenant) {
            deleteButton.setAttribute('disabled', '');
            deleteButton.setAttribute('data-title', 'L\'intervenant est chargé d\'au moins un créneau dans cette structure');
            deleteButton.classList.add('tooltip-delete');
        }

        colNom.append(input);
        colDelete.append(deleteButton);
        row.append(colVide, colNom, colDelete);

        return row;
    }

    function handleAddStructure(structure) {
        const structures = document.querySelectorAll('.structure-element');

        let exist = false;
        for (let i = 0; i < structures.length; i++) {
            if (structures[i].getAttribute("data-id-structure") == structure.id_structure) {
                exist = true;
                break;
            }
        }

        if (!exist) {
            listeStructureDiv.append(createStructureElement(structure));
        }
    }

    function createDiplomeElement(diplome) {
        const row = document.createElement('div');
        row.className = 'row diplome-element';
        row.setAttribute("data-id-diplome", diplome.id_diplome);

        const colVide = document.createElement('div');
        colVide.className = 'col-md-1';

        const colNom = document.createElement('div');
        colNom.className = 'col-md-9';

        const input = document.createElement('input');
        input.value = diplome.nom_diplome;
        input.className = 'form-control input-md';
        input.setAttribute("readOnly", "");

        const colDelete = document.createElement('div');
        colDelete.className = 'col-md-2';

        const deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger delete';
        deleteButton.setAttribute("data-id-diplome", diplome.id_diplome);
        deleteButton.textContent = 'Supprimer';

        colNom.append(input);
        colDelete.append(deleteButton);
        row.append(colVide, colNom, colDelete);

        return row;
    }

    function handleAddDiplome(diplome) {
        const diplomes = document.querySelectorAll('.diplome-element');

        // si diplôme vide
        if (parseInt(diplome.id_diplome) <= 0) {
            return;
        }

        // si diplôme est déjà dans la liste
        let exist = false;
        for (let i = 0; i < diplomes.length; i++) {
            if (diplomes[i].getAttribute("data-id-diplome") === diplome.id_diplome) {
                exist = true;
                break;
            }
        }

        if (!exist) {
            listeDiplomeDiv.append(createDiplomeElement(diplome));
        }
    }

    function handleCreateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();
            if (verif_coordonnees()) {
                $('#modal').modal('hide');

                lockForm(form)
                    .then(canContinue => {
                        if (canContinue) {
                            const new_data = getFormData();

                            // Insert dans la BDD
                            fetch('EnregistrerIntervenant.php', {
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
                                    toast("Intervenant ajouté avec succes");
                                    tableauIntervenant.addRow(data, true);
                                })
                                .catch((error) => {
                                    //console.error('Error:', error);
                                    toast("Echec de l'ajout");
                                });
                        }
                    });
            }
        }
    }

    function handleUpdateClick() {
        form.onsubmit = function (e) {
            e.preventDefault();

            if (verif_coordonnees()) {
                $('#modal').modal('hide');

                lockForm(form)
                    .then(canContinue => {
                        if (canContinue) {
                            const new_data = getFormData();

                            // Update dans la BDD
                            fetch('update.php', {
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
                                    toast("Intervenant modifié avec succes");
                                    // MAJ du tableau
                                    tableauIntervenant.replaceRowValues(new_data);
                                })
                                .catch((error) => {
                                    toast("Echec de la modification");
                                });
                        }
                    });
            }
        }
    }

    function handleDeleteClick(event) {
        warningModal.modal('show');
        warningText.textContent = 'Supprimer l\'intervenant?';

        event.preventDefault();

        getConfirmation().then(is_delete => {
            $('#modal').modal('hide');

            if (is_delete) {
                const new_data = getFormData();

                // Update dans la BDD
                fetch('DeleteIntervenant.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({"id_intervenant": new_data.id_intervenant}),
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
                        toast("Intervenant supprimé avec succès.");
                        tableauIntervenant.deleteRow(new_data.id_intervenant);
                    })
                    .catch((error) => {
                        toast("Echec de la suppression. Cause:" + error?.message);
                    });
            }
        });
    }

    function handleFuseClick(event) {
        form.onsubmit = function (e) {
            e.preventDefault();
            warningModal.modal('show');
            warningText.textContent = 'Fusionner les deux intervenants?';

            getConfirmation().then(is_delete => {
                $('#modal').modal('hide');

                if (is_delete) {
                    const new_data = getFormData();

                    // Update dans la BDD
                    fetch('FuseIntervenant.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(new_data),
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
                            toast("Intervenants fusionnés avec succès");
                            // TODO maj du tableau
                        })
                        .catch((error) => {
                            toast("Echec de la fusion. Cause:" + error?.message);
                        });
                }
            });
        }
    }

    async function getConfirmation() {
        return new Promise((resolve => {
            confirmclosed.onclick = () => {
                resolve(true);
            };

            refuseclosed.onclick = () => {
                resolve(false);
            };
        }));
    }

    /**
     * Return la durée entre 2 moments au format "HH:mm:ss" (par exemple "07:30:00" pour 7h30)
     * @param heure_debut
     * @param heure_fin
     * @returns {*}
     */
    function duree(heure_debut, heure_fin) {
        const date_debut = "01/01/2021 " + heure_debut;
        const date_fin = "01/01/2021 " + heure_fin;
        return moment.utc(moment(date_fin, "DD/MM/YYYY HH:mm:ss").diff(moment(date_debut, "DD/MM/YYYY HH:mm:ss"))).format("HH:mm");
    }

    function createCreneauTr(creneau) {
        let row = document.createElement('tr');

        let td1 = document.createElement('td');
        td1.className = "text-left";
        td1.textContent = creneau.nom_creneau;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = creneau.type_parcours

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.textContent = creneau.jour;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.textContent = moment(creneau.nom_heure_debut, "HH:mm:ss").format("HH:mm");

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.textContent = duree(creneau.nom_heure_debut, creneau.nom_heure_fin);

        row.append(td1, td2, td3, td4, td5);

        return row;
    }

    function setInfosIntervenant(id_intervenant) {
        fetch('RecupOneInfosIntervenant.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_intervenant": id_intervenant}),
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
                form.setAttribute("data-id_intervenant", data.id_intervenant);
                // pré-rempli les valeurs du formulaire
                nomInput.value = data.nom_intervenant;
                prenomInput.value = data.prenom_intervenant;
                emailInput.value = data.mail_intervenant;
                telFixeInput.value = data.tel_fixe_intervenant;
                telProtableInput.value = data.tel_portable_intervenant;
                numero_carteInput.value = data.numero_carte;
                id_territoireSelect.value = data.id_territoire;
                statutSelect.value = data.id_statut_intervenant;

                const displayCreateUserButton = data.is_user;
                toggleCreateUserButtonHidden(displayCreateUserButton);

                // ajout de la liste des structures où intervient l'intervenant
                if (Array.isArray(data.structures)) {
                    for (let i = 0; i < data.structures.length; i++) {
                        listeStructureDiv.append(createStructureElement(data.structures[i]));
                    }
                    // initialisation des tooltips des boutons delete
                    $('.tooltip-delete').tooltip();
                }

                // ajout de la liste des créneaux de l'intervenant
                if (Array.isArray(data.creneaux)) {
                    data.creneaux.forEach(creneau => bodyCreneaux.append(createCreneauTr(creneau)));

                    if (data.creneaux.length === 0) {
                        const emptyRow = document.createElement('tr');

                        const td = document.createElement('td');
                        td.setAttribute('colspan', '5');
                        td.textContent = 'Aucun créneau pour cet intervenant.'

                        emptyRow.append(td);
                        bodyCreneaux.append(emptyRow);
                    }
                }

                // ajout de la liste des diplômes de l'intervenant
                if (Array.isArray(data.diplomes)) {
                    for (let i = 0; i < data.diplomes.length; i++) {
                        listeDiplomeDiv.append(createDiplomeElement(data.diplomes[i]));
                    }
                }
            })
            .catch((error) => {
                //console.error('Error recup infos intervenant:', error);
            });
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

    function toggleSectionCreneauHidden(on) {
        creneauxFielset.hidden = on;
    }

    function toggleDeleteButtonHidden(on) {
        if (on) {
            deleteButton.style.display = 'none';
        } else {
            deleteButton.style.display = 'block';
        }
    }

    function toggleCreateUserButtonHidden(on) {
        if (on) {
            createUserButton.style.display = 'none';
        } else {
            createUserButton.style.display = 'block';
        }
    }

    function toggleSectionCreateOrUpdateHidden(on) {
        if (on) {
            sectionUpdateOrCreate.style.display = 'none';

            nomInput.removeAttribute('required');
            prenomInput.removeAttribute('required');
        } else {
            sectionUpdateOrCreate.style.display = 'block';

            nomInput.setAttribute('required', '');
            prenomInput.setAttribute('required', '');
        }
    }

    function toggleSectionFusionHidden(on) {
        if (on) {
            sectionFusion.style.display = 'none';

            nom1Input.removeAttribute('required');
            prenom1Input.removeAttribute('required');
            nom2Input.removeAttribute('required');
            prenom2Input.removeAttribute('required');
        } else {
            sectionFusion.style.display = 'block';

            nom1Input.setAttribute('required', '');
            prenom1Input.setAttribute('required', '');
            nom2Input.setAttribute('required', '');
            prenom2Input.setAttribute('required', '');
        }
    }

    function resetForm() {
        form.reset();

        // reset la liste structure
        const structures = document.querySelectorAll('.structure-element');
        for (let i = 0; i < structures.length; i++) {
            structures[i].remove();
        }

        // reset la liste diplomes
        const diplomes = document.querySelectorAll('.diplome-element');
        for (let i = 0; i < diplomes.length; i++) {
            diplomes[i].remove();
        }

        // reset le tableau créneaux
        bodyCreneaux.innerHTML = '';

        // par défaut le bouton de création d'utilisateur est caché
        toggleCreateUserButtonHidden(true);
    }

    /**
     *
     * @param mode {MODE} Le mode du modal
     */
    function setModalMode(mode) {
        if (mode === MODE.ADD) {
            modalTitle.textContent = "Ajout intervenant";
            warningText.textContent = 'Quitter sans enregistrer?';
            resetForm();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleSectionCreneauHidden(true);
            toggleSectionCreateOrUpdateHidden(false);
            toggleSectionFusionHidden(true);

            // message de confirmation si on quitte le modal
            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleFuseClick);
            if (deleteButton) {
                deleteButton.removeEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(true);
            }

            enregistrerOuModifier.textContent = "Enregistrer";
        } else if (mode === MODE.EDIT) {
            modalTitle.textContent = "Détails intervenant";
            warningText.textContent = 'Quitter sans enregistrer?';
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleSectionCreneauHidden(false);
            toggleSectionCreateOrUpdateHidden(false);
            toggleSectionFusionHidden(true);

            // message de confirmation si on quitte le modal
            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.addEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleFuseClick);
            if (deleteButton) {
                deleteButton.addEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(false);
            }

            enregistrerOuModifier.textContent = "Enregistrer";
        } else if (mode === MODE.FUSION) {
            modalTitle.textContent = "Fusionner deux intervenants";
            warningText.textContent = 'Quitter sans enregistrer?';
            resetForm();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(false);
            toggleSectionCreneauHidden(true);
            toggleSectionCreateOrUpdateHidden(true);
            toggleSectionFusionHidden(false);

            // message de confirmation si on quitte le modal
            close.addEventListener("click", handleConfirmCloseClick);
            close.removeAttribute("data-dismiss");

            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.removeEventListener("click", handleModifierClick);
            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.addEventListener("click", handleFuseClick);
            if (deleteButton) {
                toggleDeleteButtonHidden(true);
            }

            enregistrerOuModifier.textContent = "Fusionner";
        } else {
            // mode par défaut : MODE.READONLY
            modalTitle.textContent = "Détails intervenant";
            warningText.textContent = 'Quitter sans enregistrer?';
            resetForm();
            unlockForm(form); // autorise l'envoie de données par le formulaire
            toggleChampDisabled(true);
            toggleSectionCreneauHidden(false);
            toggleSectionCreateOrUpdateHidden(false);
            toggleSectionFusionHidden(true);

            // pas de message de confirmation si on quitte le modal
            close.setAttribute("data-dismiss", "modal");
            close.removeEventListener('click', handleConfirmCloseClick);

            enregistrerOuModifier.removeEventListener("click", handleUpdateClick);
            enregistrerOuModifier.removeEventListener("click", handleCreateClick);
            enregistrerOuModifier.addEventListener("click", handleModifierClick);
            enregistrerOuModifier.removeEventListener("click", handleFuseClick);
            if (deleteButton) {
                deleteButton.addEventListener("click", handleDeleteClick);
                toggleDeleteButtonHidden(false);
            }

            enregistrerOuModifier.textContent = "Modifier";
        }
    }

    return {
        init,
        setInfosIntervenant,
        setModalMode
    };
})();