/**
 * Ce fichier nécessite le fichier commun.js pour fonctionner correctement
 */

function masquer_div(id) {
    if (document.getElementById(id).style.display == 'none') {
        document.getElementById(id).style.display = 'block';
    } else {
        document.getElementById(id).style.display = 'none';
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
function autocompleteMutuelle(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    let currentFocus;

    function handleMutuelleInput(e) {
        const val = this.value.toUpperCase(); // les noms des mutuelles sont en majuscules
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) {
            return false;
        }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        const a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (let i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].nom.toString().substring(0, val.length).toUpperCase() === val) {
                /*create a DIV element for each matching element:*/
                const b = document.createElement("DIV");
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input " +
                    "style='width:500px;' " +
                    "value='" + sanitize(arr[i].nom + " - " + arr[i].code_postal + " - " + arr[i].nom_ville) + "' >";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function (e) {
                    /*insert the values for the autocomplete text field:*/
                    document.getElementById("choix_mutuelle").value = "";
                    document.getElementById("nom_mutuelle").value = arr[i].nom;
                    document.getElementById("tel_mutuelle").value = arr[i].tel_fixe;
                    document.getElementById("mail_mutuelle").value = arr[i].email;
                    document.getElementById("adresse_mutuelle").value = arr[i].nom_adresse;
                    document.getElementById("complement_mutuelle").value = arr[i].complement_adresse;
                    document.getElementById("cp_mutuelle").value = arr[i].code_postal;
                    document.getElementById("ville_mutuelle").value = arr[i].nom_ville;
                    document.getElementById("id_mutuelle").value = arr[i].id_mutuelle;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    }

    inp.removeEventListener("input", handleMutuelleInput);
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", handleMutuelleInput);
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function (e) {
        let x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
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
        const x = document.getElementsByClassName("autocomplete-items");
        for (let i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

/**
 * @param url l'url de récupération des mutuelles
 * @param mutuelleData les données des villes (pas de requête ne serra faite si non-null)
 */
function trouverMutuelle(url, mutuelleData = null) {
    if (mutuelleData) {
        autocompleteMutuelle(document.getElementById("choix_mutuelle"), mutuelleData);
    } else {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (reponse) {
                autocompleteMutuelle(document.getElementById("choix_mutuelle"), reponse);
            },
            error: function (res, status, err) {
                console.error(status + status + err)
            },
            complete: function () {
            }
        });
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////
function autocompleteMedecinPrescripteur(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    let currentFocus;

    function handleMedecinInput(e) {
        const val = this.value.toUpperCase();
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) {
            return false;
        }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        const a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (let i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].nom_coordonnees.toString().substring(0, val.length).toUpperCase() === val) {
                /*create a DIV element for each matching element:*/
                const b = document.createElement("DIV");
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input " +
                    "style='width:500px;' " +
                    "value='" + sanitize(arr[i].nom_coordonnees + " - " + arr[i].prenom_coordonnees + " - " + arr[i].nom_specialite_medecin + " - " + arr[i].code_postal + " - " + arr[i].nom_ville) + "' >";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function (e) {
                    document.getElementById("choix_prescrip").value = "";
                    document.getElementById("nom_med").value = arr[i].nom_coordonnees;
                    document.getElementById("prenom_med").value = arr[i].prenom_coordonnees;
                    document.getElementById("tel_med").value = arr[i].tel_fixe_coordonnees;
                    document.getElementById("mail_med").value = arr[i].mail_coordonnees;
                    document.getElementById("spe_med").value = arr[i].nom_specialite_medecin;
                    document.getElementById("id_med").value = arr[i].id_medecin;
                    document.getElementById("adresse_med").value = arr[i].nom_adresse;
                    document.getElementById("complement_med").value = arr[i].complement_adresse;
                    document.getElementById("ville_med").value = arr[i].nom_ville;
                    document.getElementById("cp_med").value = arr[i].code_postal;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    }

    inp.removeEventListener("input", handleMedecinInput);
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", handleMedecinInput);
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function (e) {
        let x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
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
        const x = document.getElementsByClassName("autocomplete-items");
        for (let i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

/**
 *
 * @param url l'url de récupération des médecins
 * @param medecinData les données des médecins (pas de requête ne serra faite si non-null)
 */
function trouverMedecinPrescripteur(url, medecinData = null) {
    if (medecinData) {
        autocompleteMedecinPrescripteur(document.getElementById("choix_prescrip"), medecinData);
    } else {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (reponse) {
                autocompleteMedecinPrescripteur(document.getElementById("choix_prescrip"), reponse);
            },
            error: function (res, status, err) {
                console.error(status + status + err)
            },
            complete: function () {
            }
        });
    }
}

///////////////////////////////////
function autocompleteTraitant(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    let currentFocus;

    function handleTraitantInput(e) {
        const val = this.value.toUpperCase();
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) {
            return false;
        }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        const a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (let i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].nom_coordonnees.toString().substring(0, val.length).toUpperCase() === val) {
                /*create a DIV element for each matching element:*/
                const b = document.createElement("DIV");
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input " +
                    "style='width:500px;' " +
                    "value='" + sanitize(arr[i].nom_coordonnees + " - " + arr[i].prenom_coordonnees + " - " + arr[i].nom_specialite_medecin + " - " + arr[i].code_postal + " - " + arr[i].nom_ville) + "' >";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function (e) {
                    /*insert the value for the autocomplete text field:*/
                    document.getElementById("choix_traitant").value = "";
                    document.getElementById("nom_med_traitant").value = arr[i].nom_coordonnees;
                    document.getElementById("prenom_med_traitant").value = arr[i].prenom_coordonnees;
                    document.getElementById("tel_med_traitant").value = arr[i].tel_fixe_coordonnees;
                    document.getElementById("mail_med_traitant").value = arr[i].mail_coordonnees;
                    document.getElementById("spe_med_traitant").value = arr[i].nom_specialite_medecin;
                    document.getElementById("id_med_traitant").value = arr[i].id_medecin;
                    document.getElementById("adresse_med_traitant").value = arr[i].nom_adresse;
                    document.getElementById("complement_med_traitant").value = arr[i].complement_adresse;
                    document.getElementById("ville_med_traitant").value = arr[i].nom_ville;
                    document.getElementById("cp_med_traitant").value = arr[i].code_postal;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    }

    inp.removeEventListener("input", handleTraitantInput);
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", handleTraitantInput);
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function (e) {
        let x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
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
        const x = document.getElementsByClassName("autocomplete-items");
        for (let i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

/**
 *
 * @param url l'url de récupération des médecins
 * @param medecinData les données des médecins (pas de requête ne serra faite si non-null)
 */
function trouverMedecinTraitant(url, medecinData = null) {
    if (medecinData) {
        autocompleteTraitant(document.getElementById("choix_traitant"), medecinData);
    } else {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (reponse) {
                autocompleteTraitant(document.getElementById("choix_traitant"), reponse);
            },
            error: function (res, status, err) {
                console.error(status + status + err)
            },
            complete: function () {
            }
        });
    }
}

///////////////////////////////////
function autocompleteAutre(inp, ii, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    let currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function (e) {
        const val = this.value.toUpperCase();
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) {
            return false;
        }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        const a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (let i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].nom_coordonnees.toString().substring(0, val.length).toUpperCase() === val) {
                /*create a DIV element for each matching element:*/
                const b = document.createElement("DIV");
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input " +
                    "style='width:500px;' " +
                    "value='" + sanitize(arr[i].nom_coordonnees + " - " + arr[i].prenom_coordonnees + " - " + arr[i].nom_specialite_medecin + " - " + arr[i].code_postal + " - " + arr[i].nom_ville) + "' >";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function (e) {
                    /*insert the value for the autocomplete text field:*/
                    document.getElementById("choix_autre[" + ii + "]").value = "";
                    document.getElementById("nom_autre[" + ii + "]").value = arr[i].nom_coordonnees;
                    document.getElementById("prenom_autre[" + ii + "]").value = arr[i].prenom_coordonnees;
                    document.getElementById("tel_autre[" + ii + "]").value = arr[i].tel_fixe_coordonnees;
                    document.getElementById("mail_autre[" + ii + "]").value = arr[i].mail_coordonnees;
                    // TODO ajout ce champ sur la page d'ajout
                    if (document.getElementById("spe_autre[" + ii + "]")) {
                        document.getElementById("spe_autre[" + ii + "]").value = arr[i].nom_specialite_medecin;
                    }
                    document.getElementById("id_autre[" + ii + "]").value = arr[i].id_medecin;
                    document.getElementById("addr_autre[" + ii + "]").value = arr[i].nom_adresse;
                    document.getElementById("complement_autre[" + ii + "]").value = arr[i].complement_adresse;
                    document.getElementById("ville_autre[" + ii + "]").value = arr[i].nom_ville;
                    document.getElementById("cp_autre[" + ii + "]").value = arr[i].code_postal;
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
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
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
        const x = document.getElementsByClassName("autocomplete-items");
        for (let i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

///////////////////////////////////
function trouverAutreProf(i, url) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (reponse) {
            autocompleteAutre(document.getElementById("choix_autre[" + i + "]"), i, reponse);
        },
        error: function (res, status, err) {
            console.error(status + status + err)
        },
        complete: function () {
        }
    });
}