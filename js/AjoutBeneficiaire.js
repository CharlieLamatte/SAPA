"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 * modalMedecin.js
 * modalMutuelle.js
 */

$(document).ready(function () {
    const roles_user = JSON.parse(localStorage.getItem('roles_user'));
    // initialisation des éléments de la page
    const estPrisEnChargeCheckbox = document.getElementById('est-pris-en-charge');
    const tr = document.getElementById('prise-en-charge-tr');
    const input = document.getElementById('hauteur-prise-en-charge');
    const rechercheButton = document.getElementById('recherche-open');
    if (roles_user.includes(ROLE.COORDONNATEUR_PEPS) ||
        roles_user.includes(ROLE.COORDONNATEUR_MSS)) {
        const suivi = document.getElementById('suivi');
        suivi.onclick = () => {
            if (suivi.checked) {
                suivi.value = true;
            } else {
                suivi.value = false;
            }
        }
    }

    estPrisEnChargeCheckbox.onchange = () => {
        if (estPrisEnChargeCheckbox.checked) {
            tr.hidden = false;
            input.required = true;
        } else {
            tr.hidden = true;
            input.required = false;
        }
    };

    // ouverture popup page professionnels de santé
    rechercheButton.onclick = () => {
        const windowFeatures = "left=100,top=100,width=640,height=640";
        const professionnelsDeSanteUrl = self.origin + '/PHP/Medecins/ListeMedecin.php';
        window.open(professionnelsDeSanteUrl, "OpenProfessionnelsDeSante", windowFeatures);
    };

    // autocompletion du code postal du patient
    const codePostalPatientInput = document.getElementById("code-postal-patient");
    const villePatientInput = document.getElementById("ville-patient");

    // autocompletion du code postal de la CAM
    const codePostalCamInput = document.getElementById("cp_cpam");
    const villCameInput = document.getElementById("ville_cpam");

    /**
     * Récupération des données en commun pour éviter de multiples requêtes
     */

    let villeData = fetch("Villes/ReadAllVille.php", {
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
        .catch(() => null);

    let mutuelleData = fetch('Mutuelles/RechercheMutuelle.php', {
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
        .catch(() => null);

    let medecinData = fetch('Medecins/RecupInfosMedecin.php', {
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
        .catch(() => null);

    Promise.all([villeData, mutuelleData, medecinData])
        .then(result => {
            trouverCPVille("Villes/ReadAllVille.php", codePostalPatientInput, villePatientInput, result[0]);
            trouverCPVille("Villes/ReadAllVille.php", codePostalCamInput, villCameInput, result[0]);

            trouverMutuelle('Mutuelles/RechercheMutuelle.php', result[1]);

            trouverMedecinPrescripteur("Medecins/RecupInfosMedecin.php", result[2]);
            trouverMedecinTraitant("Medecins/RecupInfosMedecin.php", result[2]);

            modalMedecin.init({
                "urlRecupInfosMedecin": "Medecins/RecupInfosMedecin.php",
                "urlRechercheCPVille": "Villes/ReadAllVille.php",
                "urlCreateMedecin": "Medecins/CreateMedecin.php",
                "urlUpdateMedecin": "Medecins/UpdateMedecin.php",
                "urlDeleteMedecin": "Medecins/DeleteMedecin.php",
                "urlFuseMedecin": "Medecins/FuseMedecin.php",
                "urlRecupOneInfosMedecin": "Medecins/RecupOneInfosMedecin.php",
            }, {
                villeData: result[0],
                medecinData: result[2],
            });

            modalMutuelle.init({
                "urlCreateMutuelle": "Mutuelles/CreateMutuelle.php",
                "urlRechercheCPVille": "Villes/ReadAllVille.php",
                "urlRechercheMutuelle": "Mutuelles/RechercheMutuelle.php",
            }, {
                villeData: result[0],
                mutuelleData: result[2],
            });
        });
});

function verif_coordonnees() {
    let new_tel_p = document.getElementById("tel_p").value;
    let new_tel_f = document.getElementById("tel_f").value;
    let new_email = document.getElementById("email-patient").value;
    let tel_p_U = document.getElementById("tel_urgence_p").value;
    let tel_f_U = document.getElementById("tel_urgence_f").value;

    if ((new_tel_p == "") && (new_tel_f == "") && (new_email == "")) {
        alert("PATIENT : Vous devez saisir un numéro de téléphone ou une adresse mail");
        return false;
    } else if ((new_tel_p != "") && (new_tel_f != "") && (new_tel_p == new_tel_f)) {
        alert("PATIENT : Les numéros de téléphone doivent être différents");
        return false;
    } else if ((tel_f_U != "") && (tel_p_U != "") && (tel_f_U == tel_p_U)) {
        alert("CONTACT D'URGENCE : Les deux numéros de téléphone doivent être différents")
        return false;
    } else if ((new_tel_p != "") && (tel_p_U != "") && (new_tel_p == tel_p_U)) {
        alert("Les numéros de téléphone du patient et du contact d'urgence doivent être différents");
        return false;
    } else if ((new_tel_p != "") && (tel_p_U != "") && (new_tel_f == tel_p_U)) {
        alert("Les numéros de téléphone du patient et  portable du contact d'urgence doivent être différents");
        return false;
    } else if ((new_tel_p != "") && (tel_f_U != "") && (new_tel_p == tel_f_U)) {
        alert("Les numéros de téléphone du patient et fixe du contact d'urgence doivent être différents");
        return false;
    }
    return true;
}

let items = 0;
let profSante = 0;

function addItem() {
    items++;
    profSante++;

    let html =
        '<div class="section-noir">' +
        '   <div class="cadre" style="text-align: center">' +
        '       <div class="row">' +
        '           <div class="col-md-12">' +
        '               <label for="choix_autre[' + items + ']">Choisissez un autre professionnel de santé : </label>' +
        '           </div>' +
        '       </div>' +
        '       <div class="row">' +
        '           <div class="col-md-12">' +
        '               <input autocomplete="off" id="choix_autre[' + items + ']" name="choix_autre[' + items + ']" type="text" placeholder="Tapez les premières lettres du professionnel supplémentaire">' +
        '            </div>' +
        '       </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <input type="hidden" id="id_autre[' + items + ']" name="id_autre[' + items + ']">' +
        '            <div class="col-md-6">' +
        '                <label for="nom_autre[' + items + ']" class="control-label">Nom:</label>' +
        '            </div>' +
        '            <div class="col-md-6">' +
        '                <input autocomplete="off" id="nom_autre[' + items + ']" name="nom_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-6">' +
        '                <label for="prenom_autre[' + items + ']" class="control-label">Prénom:</label>' +
        '            </div>' +
        '            <div class="col-md-6">' +
        '                <input autocomplete="off" id="prenom_autre[' + items + ']" name="prenom_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-6">' +
        '                <label for="spe_autre[' + items + ']" class="control-label">Spécialité:</label>' +
        '            </div>' +
        '            <div class="col-md-6">' +
        '                <input autocomplete="off" id="spe_autre[' + items + ']" name="spe_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-6">' +
        '                <label for="tel_autre[' + items + ']" class="control-label">Numéro de téléphone:</label>' +
        '            </div>' +
        '            <div class="col-md-6">' +
        '                <input autocomplete="off" id="tel_autre[' + items + ']" name="tel_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-6">' +
        '                <label for="mail_autre[' + items + ']" class="control-label">Mail:</label>' +
        '            </div>' +
        '            <div class="col-md-6">' +
        '                <input autocomplete="off" id="mail_autre[' + items + ']" name="mail_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-6">' +
        '                <label for="addr_autre[' + items + ']" class="control-label">Adresse:</label>' +
        '            </div>' +
        '            <div class="col-md-6">' +
        '                <input autocomplete="off" id="addr_autre[' + items + ']" name="addr_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-6">' +
        '                <label for="complement_autre[' + items + ']" class="control-label">Complément d\'adresse:</label>' +
        '            </div>' +
        '            <div class="col-md-6">' +
        '                <input autocomplete="off" id="complement_autre[' + items + ']" name="complement_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-6">' +
        '                <label for="cp_autre[' + items + ']" class="control-label">Code postal:</label>' +
        '            </div>' +
        '            <div class="col-md-6">' +
        '                <input autocomplete="off" id="cp_autre[' + items + ']" name="cp_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-6">' +
        '                <label for="ville_autre[' + items + ']" class="control-label">Ville</label>' +
        '            </div>' +
        '            <div class="col-md-6">' +
        '                <input autocomplete="off" id="ville_autre[' + items + ']" name="ville_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <br>' +
        '   <div class="row" style="text-align: center">' +
        '      <div class="col-md-12">' +
        '         <button class="btn btn-danger btn-sm supprimer-autre-prof" data-id="div-autre-prof-' + items + '">Supprimer</button>' +
        '      </div>' +
        '   </div>' +
        '</div>';

    let div = document.createElement('div');
    div.id = "div-autre-prof-" + items;
    div.innerHTML = html;

    document.getElementById('autres-pro-sup').appendChild(div);

    trouverAutreProf(items, "Medecins/RecupInfosMedecin.php");
    initButtonsSupprimer();
}

function initButtonsSupprimer() {
    const suppresionsButtons = document.getElementsByClassName('supprimer-autre-prof');
    for (const button of suppresionsButtons) {
        button.onclick = function (event) {
            event.preventDefault();

            const id = event.target.getAttribute('data-id');
            document.getElementById(id).remove();
        };
    }
}

let etat;

function formulaire_visible(elem) {
    etat = document.getElementById(elem).style.display;
    if (etat == "none") {
        document.getElementById(elem).style.display = "block";
    } else {
        document.getElementById(elem).style.display
    }
}

function formulaire_cache(elem) {
    etat = document.getElementById(elem).style.display;
    if (etat == "block") {
        document.getElementById(elem).style.display = "none";
    } else {
        document.getElementById(elem).style.display
    }
}

// Script permettant d'éviter le pop-up d'avertissement de changement de page lors du clique sur le bouton "Enregistrer"
$(document).on("submit", "form", function (event) {
    window.onbeforeunload = null;
});

