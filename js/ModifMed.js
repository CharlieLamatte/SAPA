"use strict";

/**
 * Pour fonctionner correctement ce fichier nécessite:
 * commun.js
 * autocomplete.js
 * modalMedecin.js
 * modalMutuelle.js
 */

$(document).ready(function () {
    // initialisation de la suppression
    initButtonsSupprimer();

    const codePostalCamInput = document.getElementById("cp_cpam");
    const villCameInput = document.getElementById("ville_cpam");

    // initialisation des champs d'autocomplétion
    let villeData = fetch("../Villes/ReadAllVille.php", {
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

    let mutuelleData = fetch('../Mutuelles/RechercheMutuelle.php', {
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

    let medecinData = fetch('../Medecins/RecupInfosMedecin.php', {
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
            trouverCPVille("../Villes/ReadAllVille.php", codePostalCamInput, villCameInput, result[0]);

            trouverMutuelle('../Mutuelles/RechercheMutuelle.php', result[1]);

            trouverMedecinPrescripteur("../Medecins/RecupInfosMedecin.php", result[2]);
            trouverMedecinTraitant("../Medecins/RecupInfosMedecin.php", result[2]);

            modalMedecin.init({
                "urlRecupInfosMedecin": "../Medecins/RecupInfosMedecin.php",
                "urlRechercheCPVille": "../Villes/ReadAllVille.php",
                "urlCreateMedecin": "../Medecins/CreateMedecin.php",
                "urlUpdateMedecin": "../Medecins/UpdateMedecin.php",
                "urlDeleteMedecin": "../Medecins/DeleteMedecin.php",
                "urlFuseMedecin": "../Medecins/FuseMedecin.php",
                "urlRecupOneInfosMedecin": "../Medecins/RecupOneInfosMedecin.php",
            }, {
                villeData: result[0],
                medecinData: result[2],
            });

            modalMutuelle.init({
                "urlCreateMutuelle": "../Mutuelles/CreateMutuelle.php",
                "urlRechercheCPVille": "../Villes/ReadAllVille.php",
                "urlRechercheMutuelle": "../Mutuelles/RechercheMutuelle.php",
            }, {
                villeData: result[0],
                mutuelleData: result[2],
            });
        });
});

function initButtonsSupprimer() {
    const suppresionsButtons = document.getElementsByClassName('supprimer');
    for (const button of suppresionsButtons) {
        button.onclick = function (event) {
            event.preventDefault();

            if (confirm('Voulez-vous vraiment supprimer ce professionnel de santé ?')) {
                const id = event.target.getAttribute('data-id');
                document.getElementById(id).remove();
            }
        };
    }
}

let items = 0;
let profSante = 0;

function addItem() {
    const divVide = document.getElementById('aucun-autre-pro');
    if (document.getElementById('aucun-autre-pro')) {
        divVide.remove();
    }

    items++;
    profSante++;

    let html = '' +
        '<div class="section-noir">' +
        '   <div class="cadre" style="text-align: center">' +
        '       <div class="row">' +
        '           <div class="col-md-12">' +
        '               <label for="choix_autre[' + items + ']">Choisissez un autre professionnel de santé : </label>' +
        '           </div>' +
        '       </div>' +
        '       <div class="row">' +
        '           <div class="col-md-3"></div>' +
        '           <div class="col-md-6">' +
        '               <input autocomplete="off" id="choix_autre[' + items + ']" name="choix_autre[' + items + ']" type="text" placeholder="Tapez les premières lettres du professionnel supplémentaire">' +
        '            </div>' +
        '           <div class="col-md-3"></div>' +
        '       </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <input type="hidden" id="id_autre[' + items + ']" name="id_autre[' + items + ']">' +
        '            <div class="col-md-2" style="text-align: right">' +
        '                <label for="nom_autre[' + items + ']" class="control-label">Nom</label>' +
        '            </div>' +
        '            <div class="col-md-2">' +
        '                <input autocomplete="off" id="nom_autre[' + items + ']" name="nom_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '            <div class="col-md-2" style="text-align: right">' +
        '                <label for="prenom_autre[' + items + ']" class="control-label">Prénom</label>' +
        '            </div>' +
        '            <div class="col-md-2">' +
        '                <input autocomplete="off" id="prenom_autre[' + items + ']" name="prenom_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '            <div class="col-md-2" style="text-align: right">' +
        '                <label for="spe_autre[' + items + ']" class="control-label">Spécialité</label>' +
        '            </div>' +
        '            <div class="col-md-2">' +
        '                <input autocomplete="off" id="spe_autre[' + items + ']" name="spe_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-2" style="text-align: right">' +
        '                <label for="tel_autre[' + items + ']" class="control-label">Numéro de téléphone</label>' +
        '            </div>' +
        '            <div class="col-md-2">' +
        '                <input autocomplete="off" id="tel_autre[' + items + ']" name="tel_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '            <div class="col-md-2" style="text-align: right">' +
        '                <label for="mail_autre[' + items + ']" class="control-label">Mail</label>' +
        '            </div>' +
        '            <div class="col-md-2">' +
        '                <input autocomplete="off" id="mail_autre[' + items + ']" name="mail_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-2" style="text-align: right">' +
        '                <label for="addr_autre[' + items + ']" class="control-label">Adresse</label>' +
        '            </div>' +
        '            <div class="col-md-2">' +
        '                <input autocomplete="off" id="addr_autre[' + items + ']" name="addr_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '            <div class="col-md-2" style="text-align: right">' +
        '                <label for="complement_autre[' + items + ']" class="control-label">Complément d\'adresse</label>' +
        '            </div>' +
        '            <div class="col-md-2">' +
        '                <input autocomplete="off" id="complement_autre[' + items + ']" name="complement_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <div class="row">' +
        '            <div class="col-md-2" style="text-align: right">' +
        '                <label for="cp_autre[' + items + ']" class="control-label">Code postal</label>' +
        '            </div>' +
        '            <div class="col-md-2">' +
        '                <input autocomplete="off" id="cp_autre[' + items + ']" name="cp_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '            <div class="col-md-2" style="text-align: right">' +
        '                <label for="ville_autre[' + items + ']" class="control-label">Ville</label>' +
        '            </div>' +
        '            <div class="col-md-2">' +
        '                <input autocomplete="off" id="ville_autre[' + items + ']" name="ville_autre[' + items + ']"' +
        '                       class="form-control input-md" type="text" readonly value="">' +
        '            </div>' +
        '   </div>' +
        '   <br>' +
        '   <div class="row" style="text-align: center">' +
        '      <div class="col-md-12">' +
        '         <button class="btn btn-danger btn-sm supprimer" data-id="div_' + items + '">Supprimer</button>' +
        '      </div>' +
        '   </div>' +
        '</div>';

    let div = document.createElement('div');
    div.id = "div_" + items;
    div.innerHTML = html;

    document.getElementById('autres-pro-sup').appendChild(div);

    trouverAutreProf(items, "../Medecins/RecupInfosMedecin.php");
    initButtonsSupprimer();
}