/**
 * Ce fichier nécessite le fichier commun.js pour fonctionner correctement
 */

/**
 * Permet l'autocompletion du code postal et de la ville à partir du code postal
 * @param url l'url de récupération des villes en json
 * @param codePostalInput l'élement input du code postal
 * @param villeInput l'élement input de la ville
 * @param villeData les données des villes (pas de requête ne serra faite si non-null)
 */
function trouverCPVille(url, codePostalInput, villeInput, villeData = null) {
    if (villeData) {
        autocomplete_ville(codePostalInput, villeInput, villeData);
    } else {
        $.ajax({
            url: url,
            type: 'GET',
            success: function (reponse) {
                autocomplete_ville(codePostalInput, villeInput, reponse);
            },
            error: function (res, status, err) {
                console.error(status + status + err)
            },
            complete: function () {
            }
        });
    }
}

function autocomplete_ville(input, villeInput, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    let currentFocus;
    /*execute a function when someone writes in the text field:*/
    input.addEventListener("input", function (e) {
        const val = this.value;
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
            if (arr[i].code_postal.toString().substring(0, val.length) === val) {
                /*create a DIV element for each matching element:*/
                const b = document.createElement("DIV");
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input " +
                    "style='width:500px;' " +
                    "value='" + sanitize(arr[i].code_postal + " - " + arr[i].nom_ville) + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function (e) {
                    /*insert the value for the autocomplete text field:*/
                    input.value = arr[i].code_postal;
                    villeInput.value = arr[i].nom_ville;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    input.addEventListener("keydown", function (e) {
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
        const x = document.getElementsByClassName("autocomplete-items");
        for (let i = 0; i < x.length; i++) {
            if (elmnt !== x[i] && elmnt !== input) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}