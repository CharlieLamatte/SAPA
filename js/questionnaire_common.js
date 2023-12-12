"use strict";

// infos sur les chiffres des bouttons radios du questionnaire garnier
const radioInfoGarnier = {
    '48': {
        'avant': 'Très mauvaise',
        'apres': 'Excellente'
    },
    '49': {
        'avant': 'Pas du tout',
        'apres': 'Énormément'
    },
    '50': {
        'avant': 'Pas du tout',
        'apres': 'Très équilibrée'
    },
    '51': {
        'avant': 'Je dors très mal',
        'apres': 'Je dors très bien'
    },
    '52': {
        'avant': 'Très stressé',
        'apres': 'Très détendu'
    },
    '53': {
        'avant': 'Très mauvais',
        'apres': 'Très bon'
    },
    '54': {
        'avant': 'Très isolé',
        'apres': 'Pas du tout isolé'
    },
    '55': {
        'avant': 'Beaucoup',
        'apres': 'Aucune'
    }
};

function createQuestionnaire(data, mainDiv, showStar = true, readonly = false, showSubmitButton = true) {
    const questionnairediv = document.createElement('fieldset');
    questionnairediv.classList.add('section-noir');

    const legend = document.createElement('legend');
    legend.classList.add('section-titre-noir');
    legend.textContent = data.nom_questionnaire;

    questionnairediv.append(legend);
    mainDiv.append(questionnairediv);

    data.questions.forEach(q => {
        questionnairediv.append(createReponseDiv(q, 'main-question', showStar, readonly));
    });

    if (showSubmitButton) {
        const buttonDiv = document.createElement('div');
        buttonDiv.classList.add('centered');
        const submit = document.createElement('button');
        submit.textContent = 'Enregistrer';
        submit.type = 'submit';
        submit.classList.add('btn');
        submit.classList.add('btn-success');

        buttonDiv.append(submit);
        questionnairediv.append(buttonDiv);
    }
}

function createReponseDiv(question, className, showStar, readonly) {
    const panelDiv = document.createElement('div');
    if (className) {
        panelDiv.classList.add(className);
        if (className === 'main-question') {
            panelDiv.classList.add('panel');
            panelDiv.classList.add('panel-default');
        }
    }

    const bodyDiv = document.createElement('div');
    if (className && className === 'main-question') {
        panelDiv.classList.add('panel-body');

        // ajout des id pour les panels qui peuvent être cachés
        if (question.id_question == 69 || question.id_question == 73) {
            panelDiv.id = 'oui-panel';
        } else if (question.id_question == 71 || question.id_question == 75) {
            panelDiv.id = 'non-panel';
        }
    }

    panelDiv.append(bodyDiv);

    const label = document.createElement('label');
    label.textContent = question.enonce;
    label.setAttribute('for', 'question-' + question.id_question);
    if (className && className === 'sous-questions') {
        label.classList.add('sous-questions-enonce');
    } else {
        label.classList.add('main-questions-enonce');
    }

    bodyDiv.append(label);
    if (showStar && className && className === 'main-question') {
        label.append(createRedStarSpan());
    }

    if (question.nom_type_reponse === 'bool') {
        bodyDiv.append(createBoolDiv(question, readonly));
    } else if (question.nom_type_reponse === 'int' && parseInt(question.valeur_max, 10) <= 10) {
        bodyDiv.append(createIntRadioDiv(question, readonly));
    } else if (question.nom_type_reponse === 'int') {
        bodyDiv.append(createInputDiv(question, readonly));
    } else if (question.nom_type_reponse === 'null') {
        question.sous_questions.forEach(q => {
            bodyDiv.append(createReponseDiv(q, 'sous-questions', showStar, readonly));
        })
    } else if (question.nom_type_reponse === 'qcu') {
        bodyDiv.append(createQcuDiv(question, readonly));
    } else if (question.nom_type_reponse === 'qcm' || question.nom_type_reponse === 'qcm_liste') {
        bodyDiv.append(createQcmDiv(question, readonly));
        question.sous_questions?.forEach(q => {
            bodyDiv.append(createReponseDiv(q, 'sous-questions', showStar, readonly));
        })
    }

    return panelDiv;
}

function createBoolDiv(question, readonly) {
    const radioOui = createRadioDiv('reponse-' + question.id_question, 'Oui', '1', 'bool', question.id_question, readonly);
    const radioNon = createRadioDiv('reponse-' + question.id_question, 'Non', '0', 'bool', question.id_question, readonly);

    const div = document.createElement('div');
    div.append(radioOui, radioNon);
    return div;
}

function createIntRadioDiv(question, readonly) {
    const div = document.createElement('div');

    const min = parseInt(question.valeur_min, 10);
    const max = parseInt(question.valeur_max, 10);

    const id_question = parseInt(question.id_question);

    if (id_question >= 48 && id_question <= 55) {
        const avant = document.createElement('span');
        avant.classList.add('avant-radio');
        avant.textContent = radioInfoGarnier[question.id_question].avant;
        div.append(avant);
    }

    for (let i = min; i <= max; i++) {
        div.append(createRadioDiv('reponse-' + question.id_question, i.toString(), i, 'int', question.id_question, readonly));
    }

    if (id_question >= 48 && id_question <= 55) {
        const apres = document.createElement('span');
        apres.classList.add('apres-radio');
        apres.textContent = radioInfoGarnier[question.id_question].apres;
        div.append(apres);
    }

    return div;
}

function createQcuDiv(question, readonly) {
    const div1 = document.createElement('div');

    if (Array.isArray(question.qcu)) {
        question.qcu.forEach(qcu => {
            const div2 = document.createElement('div');
            div2.classList.add('radio');
            const label = document.createElement('label');

            const input = document.createElement('input');
            input.setAttribute('type', 'radio');
            input.setAttribute('name', 'reponse-' + question.id_question);
            input.setAttribute('value', qcu.valeur);
            input.setAttribute('data-type', 'int');
            input.setAttribute('data-id_question', question.id_question);
            input.setAttribute('required', '');

            if (readonly) {
                input.setAttribute('disabled', '');
            }
            label.append(input, qcu.enonce);

            div2.append(label);
            div1.append(div2);
        });
    }

    return div1;
}

function createQcmDiv(question, readonly) {
    const div1 = document.createElement('div');

    if (Array.isArray(question.qcm)) {
        question.qcm.forEach(qcm => {
            const div2 = document.createElement('div');
            div2.classList.add('radio');
            const label = document.createElement('label');

            const input = document.createElement('input');
            input.setAttribute('type', 'checkbox');
            input.setAttribute('name', 'reponse-' + question.id_question);
            input.setAttribute('value', qcm.valeur);
            input.setAttribute('data-type', 'qcm');
            input.setAttribute('data-id_question', question.id_question);
            //input.setAttribute('required', '');
            if (readonly) {
                input.setAttribute('disabled', '');
            }
            label.append(input, qcm.enonce);

            div2.append(label);
            div1.append(div2);
        });
    } else if (question.id_question == "69" || question.id_question == "73") {
        div1.append(createUndeterminedRep(question, readonly));
    }

    return div1;
}

function createUndeterminedRep(question, readonly) {
    const div1 = document.createElement('div');

    const divListe = document.createElement('div');
    divListe.id = 'div-liste';
    const divRow = document.createElement('div');
    divRow.classList.add("row");
    const divCol1 = document.createElement('div');
    divCol1.classList.add("col-md-3");

    let label = null;
    if (!readonly) {
        label = document.createElement('label');
        label.textContent = "Ajouter structure";

        divCol1.append(label);
    }
    const divCol2 = document.createElement('div');
    divCol2.classList.add("col-md-7");

    let input = null;
    if (!readonly) {
        input = document.createElement('input');
        input.classList.add('form-control');
        input.type = 'text';
        input.placeholder = 'Taper le nom de la structure';

        divCol2.append(input);
    }

    const divCol3 = document.createElement('div');
    divCol3.classList.add("col-md-2");

    // const button = document.createElement('button');
    // button.className = 'btn btn-success';
    // button.textContent = 'Ajouter';
    //
    // divCol3.append(button);

    divRow.append(divCol1, divCol2, divCol3);
    div1.append(divListe, divRow);

    if (!readonly) {
        trouverStructure('../Structures/ReadAllStructures.php', input, divListe, question);
    }

    divListe.addEventListener('click', event => {
        if (event.target.className.includes('delete-structure')) {
            event.target.parentElement.parentElement.remove();
        }
    });

    return div1;
}

function trouverStructure(url, addStructureInput, divListe, question, readonly) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (reponse) {
            autocompleteStructure(addStructureInput, reponse, divListe, question, readonly);
        },
        error: function (res, status, err) {
            console.error(status + status + err)
        },
        complete: function () {
        }
    });
}

function autocompleteStructure(inp, arr, divListe, question, readonly) {
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
            if (arr[i].nom_structure.toUpperCase().substr(0, val.length) === val) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input style='width:500px;' value='" + arr[i].nom_structure + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function (e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = "";
                    handleAddStructure(arr[i], divListe, question);
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

function handleAddStructure(structure, divListe, question) {
    const structures = document.querySelectorAll('.structure-element');

    let exist = false;
    for (let i = 0; i < structures.length; i++) {
        if (structures[i].getAttribute("data-id_structure") == structure.id_structure) {
            exist = true;
            break;
        }
    }

    if (!exist) {
        divListe.append(createStructureElement(structure, question));
    }
}

function createStructureElement(structure, question, readonly) {
    const row = document.createElement('div');
    row.className = 'row structure-element';
    row.setAttribute("data-id_structure", structure.id_structure);

    const colVide = document.createElement('div');
    colVide.className = 'col-md-1';

    const colNom = document.createElement('div');
    colNom.className = 'col-md-9';

    const input = document.createElement('input');
    input.className = 'form-control input-md';
    input.value = structure.nom_structure;
    input.type = 'text';
    input.setAttribute('name', 'reponse-' + question.id_question);
    input.setAttribute('data-id_question', question.id_question);
    input.setAttribute('data-value', structure.id_structure);
    input.setAttribute('data-type', 'qcm');
    input.setAttribute("readOnly", "");

    const colDelete = document.createElement('div');
    colDelete.className = 'col-md-2';

    if (!readonly) {
        const deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger delete-structure';
        deleteButton.setAttribute("data-id_structure", structure.id_structure);
        deleteButton.textContent = 'Supprimer';
        colDelete.append(deleteButton);
    }

    colNom.append(input);
    row.append(colVide, colNom, colDelete);

    return row;
}

function createInputDiv(question, readonly) {
    const row = document.createElement('div');
    row.classList.add('row');
    const col = document.createElement('div');
    col.classList.add('col-md-3');

    const col2 = document.createElement('div');
    col2.classList.add('col-md-9');

    const div = document.createElement('div');
    div.classList.add('input-group');

    const input = document.createElement('input');
    input.setAttribute('type', 'number');
    input.setAttribute('min', question.valeur_min);
    input.setAttribute('max', question.valeur_max);
    input.setAttribute('name', 'reponse-' + question.id_question);
    input.setAttribute('data-id_question', question.id_question);
    input.setAttribute('required', '');
    input.classList.add('form-control');
    if (readonly) {
        input.setAttribute('disabled', '');
    }

    const span = document.createElement('span');
    span.classList.add('input-group-addon');
    span.textContent = 'minutes';

    div.append(input, span);
    row.append(col, col2);
    col.append(div);
    return row;
}

function createRadioDiv(name, text, value, dataType, idQuestion, readonly) {
    const label = document.createElement('label');
    label.classList.add('radio-inline');

    const input = document.createElement('input');
    input.classList.add('radio-inline');
    input.setAttribute('type', 'radio');
    input.setAttribute('name', name);
    input.setAttribute('value', value);
    input.setAttribute('data-type', dataType);
    input.setAttribute('data-id_question', idQuestion);
    input.setAttribute('required', '');
    if (readonly) {
        input.setAttribute('disabled', '');
    }
    label.append(input, text);

    return label;
}

function createRedStarSpan() {
    const span = document.createElement('span');
    span.setAttribute('style', 'color: red;');
    span.textContent = ' * ';

    return span;
}

function isHidden(el) {
    return (el.offsetParent === null)
}

function getData(form) {
    const elems = form.elements;

    let reponses = [];
    let liste = null;

    for (let i = 0; i < elems.length; i++) {
        if (elems[i].nodeName === "INPUT" && elems[i].type === "number" && !isHidden(elems[i])) {
            reponses.push({
                'nom_type_reponse': "int",
                'id_question': elems[i].getAttribute('data-id_question'),
                'reponse': elems[i].value
            });
        }

        if (elems[i].nodeName === "INPUT" && elems[i].type === "radio" && elems[i].checked && !isHidden(elems[i])) {
            reponses.push({
                'nom_type_reponse': elems[i].getAttribute('data-type'),
                'id_question': elems[i].getAttribute('data-id_question'),
                'reponse': elems[i].value
            });
        }

        if (elems[i].nodeName === "INPUT" && elems[i].type === "checkbox" && !isHidden(elems[i])) {
            reponses.push({
                'nom_type_reponse': elems[i].getAttribute('data-type'),
                'id_question': elems[i].getAttribute('data-id_question'),
                'id_qcm': elems[i].value,
                'reponse': elems[i].checked ? '1' : '0'
            });
        }

        if (elems[i].nodeName === "INPUT" && elems[i].type === "text" && (elems[i].name != null && elems[i].name !== '') && !isHidden(elems[i])) {
            if (liste != null) {
                liste.reponses.push(elems[i].getAttribute('data-value'));
            } else {
                liste = {
                    'nom_type_reponse': 'qcm_liste',
                    'id_question': elems[i].getAttribute('data-id_question'),
                    'reponses': [elems[i].getAttribute('data-value')],
                }
            }
        }
    }

    if (liste != null) {
        reponses.push(liste);
    }

    return {
        'id_patient': form.getAttribute('data-id_patient'),
        'id_user': form.getAttribute('data-id_user'),
        'id_questionnaire': form.getAttribute('data-id_questionnaire'),
        'id_questionnaire_instance': form.getAttribute('data-id_questionnaire_instance'),
        'reponses': reponses,
    };
}