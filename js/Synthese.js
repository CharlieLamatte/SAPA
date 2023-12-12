"use strict";

// les différents modes d'interaction avec le modal
const MODE = {
    ADD: 'add',
    EDIT: 'edit'
};
Object.freeze(MODE);

$(document).ready(function () {
    // initialisation des élements de la page
    synthese.init();
    optionsSynthese.init();
});

// la version de la synthèse
const VERSION = {
    MEDECIN: 'medecin',
    BENEFICIAIRE: 'beneficiaire'
};
Object.freeze(VERSION);

class ChampSynthese {
    constructor(data, version, options) {
        this.data = data;
        this.version = version;

        if (options) {
            this.introductionMedecin = options.introduction_medecin;
            this.introductionBeneficiaire = options.introduction_beneficiaire;
            this.remerciementsMedecin = options.remerciements_medecin;
            this.remerciementBeneficiaire = options.remerciements_beneficiaire;
        }
    }

    titreCivilite() {
        if (!this.data) {
            return "";
        }

        return this.data.sexe_patient === 'F' ? 'Mme' : 'M';
    }

    ne() {
        if (!this.data) {
            return "";
        }

        return this.data.sexe_patient === 'F' ? 'née' : 'né';
    }

    replaceValues(str) {
        const replacements = {
            "\\(date_naissance\\)": new Date(this.data.date_naissance).toLocaleDateString('fr-FR'),
            "\\(titre_civilite\\)": this.titreCivilite(),
            "\\(prenom_beneficiaire\\)": this.data.prenom_patient,
            "\\(nom_beneficiaire\\)": this.data.nom_patient,
            "\\(nee\\)": this.ne(),
        }

        for (const [key, value] of Object.entries(replacements)) {
            str = str.replace(new RegExp(key, "g"), value);
        }

        return str;
    }

    get introduction() {
        if (this.version === VERSION.BENEFICIAIRE) {
            if (this.introductionBeneficiaire) {
                return this.replaceValues(this.introductionBeneficiaire);
            }
            return "Dans le cadre du dispositif PEPS, vous avez bénéficié d'un entretien complémentaire dont vous trouverez ci-dessous les éléments de synthèse.";
        } else if (this.version === VERSION.MEDECIN) {
            if (this.introductionMedecin) {
                return this.replaceValues(this.introductionMedecin);
            }
            const date_naissance = new Date(this.data.date_naissance);
            const date_naissance_str = date_naissance.toLocaleDateString('fr-FR');

            return `Dans le cadre du dispositif PEPS, ${this.titreCivilite()} ${this.data.prenom_patient} ${this.data.nom_patient}, ${this.ne()} le ${date_naissance_str} a bénéficié d'un entretien complémentaire dont vous trouverez ci-dessous les éléments de synthèse.`
        }

        return "";
    }

    get remerciements() {
        if (this.version === VERSION.BENEFICIAIRE) {
            if (this.remerciementBeneficiaire) {
                return this.replaceValues(this.remerciementBeneficiaire);
            }
            return "Nous vous remercions pour votre implication et nous vous invitons à prendre contact avec  l'évaluateur ou le coordonnateur PEPS en cas de besoins, de questions ou de difficultés à maintenir votre activité physique régulière.";
        } else if (this.version === VERSION.MEDECIN) {
            if (this.remerciementsMedecin) {
                return this.replaceValues(this.remerciementsMedecin);
            }
            return "Cher Docteur, nous vous remercions pour votre implication et nous vous tenons informé de la suite du parcours. N'hésitez pas à joindre l'évaluateur ou le coordonnateur PEPS en cas de besoin."
        }

        return "";
    }
}

let synthese = (function () {
    // le formulaire
    const form = document.getElementById("form");

    const titreSpan = document.getElementById("titre");

    const ajoutPersonnesSupplemantairesButton = document.getElementById("ajout-personnes-supplemantaires");
    const personnesSupplemantairesBody = document.getElementById("personnes-supplemantaires-body");

    // les champs
    const versionSyntheseSlect = document.getElementById("version-synthese");
    const dateSynthese = document.getElementById("date-synthese");
    const nomPatientSpan = document.getElementById("nom-patient");
    const dateBilan = document.getElementById("date-bilan");
    const typeBilanInput = document.getElementById("type-bilan");
    const nomEvaluateurInput = document.getElementById("nom-evaluateur");
    const prenomEvaluateurInput = document.getElementById("prenom-evaluateur");
    const fonctionEvaluateurInput = document.getElementById("fonction-evaluateur");
    const mailEvaluateurInput = document.getElementById("mail-evaluateur");
    const telephoneEvaluateurInput = document.getElementById("telephone-evaluateur");
    const nomCoordonnateurInput = document.getElementById("nom-coordonnateur");
    const prenomCoordonnateurInput = document.getElementById("prenom-coordonnateur");
    const fonctionCoordonnateurInput = document.getElementById("fonction-coordonnateur");
    const mailCoordonnateurInput = document.getElementById("mail-coordonnateur");
    const telephoneCoordonnateurInput = document.getElementById("telephone-coordonnateur");

    const commentairesObjectifsInput = document.getElementById("commentaires-objectifs");
    const preconisationsInput = document.getElementById("preconisations");
    const pointVigilancesInput = document.getElementById("point-vigilances");
    const evaluationsPrecedentesSelect = document.getElementById("evaluations-precedentes");
    const nomBilanPrecedentInput = document.getElementById("nom_bilan_precedent");
    const introductionTextarea = document.getElementById('introduction');
    const conclusionTextarea = document.getElementById('conclusion');
    const remerciementsTextarea = document.getElementById('remerciements');
    const affichagePageCheckbox = document.getElementById("affichage-page");
    const affichagePaacoGlobuleCheckbox = document.getElementById("affichage-paaco-globule");
    const affichageCoordonneesEvaluateurCheckbox = document.getElementById("affichage-coordonnees-evaluateur");
    const affichageCoordonneesCoordonnateurCheckbox = document.getElementById("affichage-coordonnees-coordonnateur");
    const affichageSautPageConclusionCheckbox = document.getElementById("affichage-saut-page-conclusion");
    const affichageDetailsPatientInfosSupplementairesCheckbox = document.getElementById("affichage-details-patient-infos-supplementaires");

    // champs test physio
    const test_physio_poids = document.getElementById('test_physio_poids');
    const test_physio_taille = document.getElementById('test_physio_taille');
    const test_physio_imc = document.getElementById('test_physio_imc');
    const test_physio_tour_taille = document.getElementById('test_physio_tour_taille');
    const test_physio_borg_repos = document.getElementById('test_physio_borg_repos');
    const test_physio_motif = document.getElementById('test_physio_motif');
    const test_physio_saturation_repos = document.getElementById('test_physio_saturation_repos');
    const test_physio_fc_repos = document.getElementById('test_physio_fc_repos');
    const test_physio_fc_max_mesuree = document.getElementById('test_physio_fc_max_mesuree');
    const test_physio_fc_max_theorique = document.getElementById('test_physio_fc_max_theorique');
    // checkboxes pour champs test physio
    const test_physio_saturation_repos_checkbox = document.getElementById('test_physio_saturation_repos_checkbox');
    const test_physio_fc_repos_checkbox = document.getElementById('test_physio_fc_repos_checkbox');
    const test_physio_fc_max_mesuree_checkbox = document.getElementById('test_physio_fc_max_mesuree_checkbox');
    const test_physio_fc_max_theorique_checkbox = document.getElementById('test_physio_fc_max_theorique_checkbox');

    // div test physio
    const test_physio_nonfait = document.getElementById('test_physio_nonfait');
    const test_physio_fait = document.getElementById('test_physio_fait');

    // champs test Aptitudes Aérobie
    const test_aptitude_aerobie_distance = document.getElementById('test_aptitude_aerobie_distance');
    const test_aptitude_aerobie_distance_theorique = document.getElementById('test_aptitude_aerobie_distance_theorique');
    const test_aptitude_aerobie_commentaires = document.getElementById('test_aptitude_aerobie_commentaires');
    const test_aptitude_aerobie_motif = document.getElementById('test_aptitude_aerobie_motif');

    // div test Aptitudes Aérobie
    const test_aptitude_aerobie_nonfait = document.getElementById('test_aptitude_aerobie_nonfait');
    const test_aptitude_aerobie_fait = document.getElementById('test_aptitude_aerobie_fait');

    // champs test up and go
    const test_up_and_go_duree = document.getElementById('test_up_and_go_duree');
    const test_up_and_go_commentaires = document.getElementById('test_up_and_go_commentaires');
    const test_up_and_go_motif = document.getElementById('test_up_and_go_motif');

    // div test up and go
    const test_up_and_go_nonfait = document.getElementById('test_up_and_go_nonfait');
    const test_up_and_go_fait = document.getElementById('test_up_and_go_fait');

    // fieldset test up and go
    const test_up_and_go_fieldset = document.getElementById('test_up_and_go_fieldset');

    // champs test Force musculaire membres supérieurs
    const test_membre_sup_main_dominante = document.getElementById('test_membre_sup_main_dominante');
    const test_membre_sup_main_droite = document.getElementById('test_membre_sup_main_droite');
    const test_membre_sup_main_gauche = document.getElementById('test_membre_sup_main_gauche');
    const test_membre_sup_commentaires = document.getElementById('test_membre_sup_commentaires');
    const test_membre_sup_motif = document.getElementById('test_membre_sup_motif');

    // div test Force musculaire membres supérieurs
    const test_membre_sup_nonfait = document.getElementById('test_membre_sup_nonfait');
    const test_membre_sup_fait = document.getElementById('test_membre_sup_fait');

    // champs test Equilibre statique
    const test_equilibre_pied_dominant = document.getElementById('test_equilibre_pied_dominant');
    const test_equilibre_pied_gauche = document.getElementById('test_equilibre_pied_gauche');
    const test_equilibre_pied_droit = document.getElementById('test_equilibre_pied_droit');
    const test_equilibre_commentaires = document.getElementById('test_equilibre_commentaires');
    const test_equilibre_motif = document.getElementById('test_equilibre_motif');

    // div test Equilibre statique
    const test_equilibre_nonfait = document.getElementById('test_equilibre_nonfait');
    const test_equilibre_fait = document.getElementById('test_equilibre_fait');

    // champs test Souplesse
    const test_souplesse_distance = document.getElementById('test_souplesse_distance');
    const test_souplesse_commentaires = document.getElementById('test_souplesse_commentaires');
    const test_souplesse_motif = document.getElementById('test_souplesse_motif');

    // div test Souplesse
    const test_souplesse_nonfait = document.getElementById('test_souplesse_nonfait');
    const test_souplesse_fait = document.getElementById('test_souplesse_fait');

    // champs test Mobilité scapulo-humérale
    const test_mobilite_main_gauche = document.getElementById('test_mobilite_main_gauche');
    const test_mobilite_main_droite = document.getElementById('test_mobilite_main_droite');
    const test_mobilite_commentaires = document.getElementById('test_mobilite_commentaires');
    const test_mobilite_motif = document.getElementById('test_mobilite_motif');

    // div test Mobilité scapulo-humérale
    const test_mobilite_nonfait = document.getElementById('test_mobilite_nonfait');
    const test_mobilite_fait = document.getElementById('test_mobilite_fait');

    // champs test Endurance musculaire membres inférieurs
    const test_membre_inf_nombre = document.getElementById('test_membre_inf_nombre');
    const test_membre_inf_fc_30 = document.getElementById('test_membre_inf_fc_30');
    const test_membre_inf_sat_30 = document.getElementById('test_membre_inf_sat_30');
    const test_membre_inf_borg_30 = document.getElementById('test_membre_inf_borg_30');
    const test_membre_inf_commentaires = document.getElementById('test_membre_inf_commentaires');
    const test_membre_inf_motif = document.getElementById('test_membre_inf_motif');
    // checkboxes pour test Endurance musculaire membres inférieurs
    const test_membre_inf_fc_30_checkbox = document.getElementById('test_membre_inf_fc_30_checkbox');
    const test_membre_inf_sat_30_checkbox = document.getElementById('test_membre_inf_sat_30_checkbox');

    // div test Endurance musculaire membres inférieurs
    const test_membre_inf_nonfait = document.getElementById('test_membre_inf_nonfait');
    const test_membre_inf_fait = document.getElementById('test_membre_inf_fait');

    // les ojectifs et activités
    const listObjectifsDiv = document.getElementById("list-objectifs");
    const objectifsTextTextarea = document.getElementById("objectifs-text");
    const objectifsTextDiv = document.getElementById("objectifs-text-div");
    const listActivitesDiv = document.getElementById("list-activites");
    const activitesTextTextarea = document.getElementById("activites-text");
    const activitesTextDiv = document.getElementById("activites-text-div");

    const previewButton = document.getElementById("preview");
    const saveButton = document.getElementById("save");

    //liste des synthèses
    const listeSynth = document.getElementById("liste_synthese");
    const buttonsListeSynth = document.getElementsByName("filtre_user");//filtres de la liste des synthèses

    //toast
    const toastDiv = document.getElementById("toast");

    //warning pour la suppression de synthèses
    const confirmclosedSupp = document.getElementById('confirmclosed');
    const refuseclosedSupp = document.getElementById('refuseclosed');
    const $warningModalSupp = $("#warning");
    const warningTextSupp = document.getElementById('warning-text');

    // synthese data
    let data = null;
    let lastestEval = null;
    let previousEval = null;

    let init = function () {
        fetch('Synthese/ReadSynthese.php', {
            method: 'POST',
            body: JSON.stringify({'id_patient': form.getAttribute("data-id_patient")})
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .then(result => {
                remplirFormulaire(result);
                data = result;

                evaluationsPrecedentesSelect.onchange = handlePreviousEvalChange;

                //init
                handleVersionChange();

                //chaque bouton de filtre de la liste de synthèse appelle handleListeSynthese quand on clique dessus
                for (var b = buttonsListeSynth.length; b--;) {
                    buttonsListeSynth[b].addEventListener("click", function () {
                        handleListeSynthese()
                    });
                }
                handleListeSynthese();//premier affichage de la liste des synthèses

                if (data.id_evaluation) {
                    fetch('Evaluation/ReadEvaluation.php', {
                        method: 'POST',
                        body: JSON.stringify({'id_evaluation': data.id_evaluation})
                    }).then(response => {
                        if (!response.ok) {
                            throw {
                                statusCode: response.status,
                            };
                        }
                        return response.json()
                    })
                        .then(result => {
                            lastestEval = result;
                            setEvaluationValues(lastestEval, null);
                        })
                        .catch((error) => console.error(error));

                } else {
                    lastestEval = {
                        'test_aptitude_aerobie': {'motif': 'Aucun'},
                        'test_equilibre': {'motif': 'Aucun'},
                        'test_mobilite': {'motif': 'Aucun'},
                        'test_souplesse': {'motif': 'Aucun'},
                        'test_membre_sup': {'motif': 'Aucun'},
                        'test_membre_inf': {'motif': 'Aucun'},
                        'test_physio': {'motif': 'Aucun'},
                        'test_up_and_go': {'motif': 'Aucun'},
                    }
                    setEvaluationValues(lastestEval, null);
                }
            })
            .catch((error) => console.error(error));

        form.onsubmit = handleSubmit;
        previewButton.onclick = handlePreviewPdfClick;
        versionSyntheseSlect.onchange = handleVersionChange;
        saveButton.onclick = handleSaveClick;

        test_physio_saturation_repos_checkbox.onchange = handleToggleEvolutionClick;
        test_physio_fc_repos_checkbox.onchange = handleToggleEvolutionClick;
        test_physio_fc_max_mesuree_checkbox.onchange = handleToggleEvolutionClick;
        test_physio_fc_max_theorique_checkbox.onchange = handleToggleEvolutionClick;

        ajoutPersonnesSupplemantairesButton.onclick = (event) => {
            event.preventDefault();

            personnesSupplemantairesBody.append(createPersonneElement());
            updateNumerosPersonnes();
        }
    };

    function handleSubmit(event) {
        event.preventDefault();

        const data = getFormData();

        fetch('Synthese/CreateSynthese.php', {
            method: 'POST',
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.blob();
            })
            .then(blob => {
                const link = document.createElement("a");
                const url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", 'Synthese.pdf');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
            .catch((error) => console.error(error));
    }

    function handlePreviewPdfClick(event) {
        event.preventDefault();

        const data = getFormData();

        fetch('Synthese/CreateSynthese.php', {
            method: 'POST',
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                        statusText: response.statusText
                    };
                }
                return response.arrayBuffer();
            })
            .then(arrayBuffer => previewPdf.loadPdfdocument(arrayBuffer))
            .catch(error => previewPdf.displayMessageInCanvas('Error downloading pdf:' + error.statusText));
    }

    function handleSaveClick(event) {
        event.preventDefault();

        const data = getFormData();
        data.save = 1//indique qu'on sauvegarde la synthèse dans CreateSynthese.php

        fetch('Synthese/CreateSynthese.php', {
            method: 'POST',
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                        statusText: response.statusText
                    };
                }
                return response;
            })
            .then(() => {
                //on affiche la liste des synthèses à jour
                handleListeSynthese();
                toast("La synthèse a été enregistrée")
            })
            .catch(error => {
                toast("La synthèse n'a pas pu être enregistrée : " + error.statusText);
            });
    }

    function handleListeSynthese() {
        fetch('Synthese/RecupSyntheses.php', {
            method: 'POST',
            body: JSON.stringify({
                'id_patient': form.getAttribute("data-id_patient"),
                'filter_id_user': document.querySelector('input[name="filtre_user"]:checked').value
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                        statusText: response.statusText
                    };
                }
                return response.json()
            })
            .then(data => {
                if (data.length > 0) {
                    listeSynth.innerHTML = null; //on supprime le tableau préexistant
                    const tableSynthese = document.createElement("table");
                    data.forEach(function (synth) {
                        //le lien de téléchargement de la synthèse
                        const rowSynth = document.createElement("tr");
                        const dateSynth = new Date(synth['date_synthese']);
                        const lienLigne = document.createElement("td");
                        lienLigne.style = "padding-right: 5px"
                        const lien = document.createElement("a");
                        lien.id = synth['id_synthese'];
                        lien.innerHTML = "Synthèse du " + dateSynth.toLocaleDateString("fr-FR");
                        lien.href = "../../Outils/DownloadSynthese.php?filename=" + synth['synthese'].toString();
                        lienLigne.appendChild(lien);
                        rowSynth.appendChild(lienLigne);
                        //le bouton de suppression de la synthèse
                        const boutonLigne = document.createElement("td");
                        const suppSynth = document.createElement("button");
                        suppSynth.id = "supp_" + synth['id_synthese'];
                        suppSynth.onclick = function () {
                            handleConfirmSuppSynth(synth['id_synthese']);
                        };
                        suppSynth.innerText = "Supprimer";
                        suppSynth.style = "margin-bottom : 2px"
                        suppSynth.className = "btn btn-danger btn-sm";
                        boutonLigne.appendChild(suppSynth);
                        rowSynth.appendChild(boutonLigne);
                        tableSynthese.appendChild(rowSynth);
                    })
                    listeSynth.appendChild(tableSynthese);
                } else {
                    listeSynth.innerHTML = null; //on supprime le tableau préexistant
                    const erreur = document.createElement("div");
                    erreur.innerHTML = "Aucune synthèse n'a été récupérée";
                    listeSynth.appendChild(erreur);
                }
            })
            .catch(error => {
                listeSynth.innerHTML = null; //on supprime le tableau préexistant
                console.log(error.status);
                const erreur = document.createElement("div");
                erreur.innerHTML = "Aucune synthèse n'a été récupérée";
                listeSynth.appendChild(erreur);
            });

    }

    function handleConfirmSuppSynth(id_synthese) {
        $warningModalSupp.modal('show');
        warningTextSupp.textContent = 'Supprimer la synthèse ?';

        confirmclosedSupp.onclick = () => {
            $warningModalSupp.modal('hide');
            handleSuppSynth(id_synthese);
        };
        refuseclosedSupp.onclick = () => {
            optionsSynthese.init(); //évite que le warning des options de synthèse utilise la mauvaise fonction
        }

    }

    function handleSuppSynth(id_synthese) {
        fetch('Synthese/DeleteSynthese.php', {
            method: 'POST',
            body: JSON.stringify({'id_synthese': id_synthese})
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                        statusText: response.statusText
                    };
                }
                return response
            })
            .then(() => {
                handleListeSynthese(); //on met à jour la liste des synthèses
                toast("La synthèse a été supprimée");
                optionsSynthese.init();
            })
            .catch(error => {
                console.log(error.statusText);
                toast("La synthèse n'a pas pu être supprimée");
                optionsSynthese.init();
            })
    }

    function handlePreviousEvalChange(event) {
        const id_evaluation = event.target.value;
        if (id_evaluation && id_evaluation !== '-1') {
            fetch('Evaluation/ReadEvaluation.php', {
                method: 'POST',
                body: JSON.stringify({'id_evaluation': id_evaluation})
            }).then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
                .then(result => {
                    previousEval = result;
                    setEvaluationValues(lastestEval, previousEval);
                })
                .catch((error) => console.error(error));
        } else {
            previousEval = null;
            setEvaluationValues(lastestEval, previousEval);
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

    function handleVersionChange() {
        const id_settings_synthese = document.getElementById("form-options-synthese").getAttribute("data-id_settings_synthese");
        if (id_settings_synthese !== "") {
            const options = fetch('Synthese/SettingsSynthese/ReadOneSettingsSynthese.php', {
                method: 'POST',
                body: JSON.stringify({'id_settings_synthese': id_settings_synthese})
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

            Promise.all([options])
                .then(result => {
                    let champs;
                    if (versionSyntheseSlect.value === "beneficiaire") {
                        champs = new ChampSynthese(data, VERSION.BENEFICIAIRE, result[0]);
                    } else if (versionSyntheseSlect.value === "medecin") {
                        champs = new ChampSynthese(data, VERSION.MEDECIN, result[0]);
                    }

                    introductionTextarea.value = champs.introduction;
                    remerciementsTextarea.value = champs.remerciements;
                });
        }
    }

    function handleToggleEvolutionClick() {
        setEvaluationValues(lastestEval, previousEval);
    }

    function setEvaluationValues(newEvaluationData, previousEvaluationData) {
        if (newEvaluationData.test_physio.fait) {
            test_physio_poids.value = getDiplayValue(getEvolutionValue(previousEvaluationData?.test_physio.poids, newEvaluationData.test_physio.poids), 'kg');
            test_physio_imc.value = getEvolutionValue(previousEvaluationData?.test_physio.IMC, newEvaluationData.test_physio.IMC);
            test_physio_taille.value = getDiplayValue(getEvolutionValue(previousEvaluationData?.test_physio.taille, newEvaluationData.test_physio.taille), 'cm');
            test_physio_tour_taille.value = getDiplayValue(getEvolutionValue(previousEvaluationData?.test_physio.tour_taille, newEvaluationData.test_physio.tour_taille), 'cm');
            test_physio_borg_repos.value = getEvolutionValue(previousEvaluationData?.test_physio.borg_repos, newEvaluationData.test_physio.borg_repos);
            test_physio_saturation_repos.value = getDiplayValue(getEvolutionValue(previousEvaluationData?.test_physio.saturation_repos, newEvaluationData.test_physio.saturation_repos, test_physio_saturation_repos_checkbox.checked), '%');
            test_physio_fc_repos.value = getDiplayValue(getEvolutionValue(previousEvaluationData?.test_physio.fc_repos, newEvaluationData.test_physio.fc_repos, test_physio_fc_repos_checkbox.checked), 'bpm');
            test_physio_fc_max_mesuree.value = getDiplayValue(getEvolutionValue(previousEvaluationData?.test_physio.fc_max_mesuree, newEvaluationData.test_physio.fc_max_mesuree, test_physio_fc_max_mesuree_checkbox.checked), 'bpm');
            test_physio_fc_max_theorique.value = getDiplayValue(getEvolutionValue(previousEvaluationData?.test_physio.fc_max_theo, newEvaluationData.test_physio.fc_max_theo, test_physio_fc_max_theorique_checkbox.checked), 'bpm');
        }
        showTest(test_physio_fait, test_physio_nonfait, test_physio_motif, newEvaluationData.test_physio.motif, newEvaluationData.test_physio.fait);

        if (newEvaluationData.test_aptitude_aerobie.fait) {
            updateBodyAerobie(newEvaluationData.test_aptitude_aerobie);

            test_aptitude_aerobie_distance.value = getEvolutionValue(previousEvaluationData?.test_aptitude_aerobie.distance_parcourue, newEvaluationData.test_aptitude_aerobie.distance_parcourue);

            const newDistTheo = pourcentageDistanceTheorique(
                newEvaluationData.test_aptitude_aerobie.distance_parcourue,
                newEvaluationData.test_physio.taille,
                newEvaluationData.age,
                newEvaluationData.sexe,
                newEvaluationData.test_physio.poids
            );
            const oldDistTheo = pourcentageDistanceTheorique(
                previousEvaluationData?.test_aptitude_aerobie.distance_parcourue,
                previousEvaluationData?.test_physio.taille,
                previousEvaluationData?.age,
                previousEvaluationData?.sexe,
                previousEvaluationData?.test_physio.poids
            );
            test_aptitude_aerobie_distance_theorique.value = getEvolutionValue(oldDistTheo, newDistTheo);
            test_aptitude_aerobie_commentaires.value = newEvaluationData.test_aptitude_aerobie.commentaires;
        }
        showTest(test_aptitude_aerobie_fait, test_aptitude_aerobie_nonfait, test_aptitude_aerobie_motif, newEvaluationData.test_aptitude_aerobie.motif, newEvaluationData.test_aptitude_aerobie.fait);

        // si le test aptitude aerobie n'est fait
        if (!newEvaluationData.test_aptitude_aerobie.fait) {
            test_up_and_go_fieldset.removeAttribute('hidden');

            if (newEvaluationData.test_up_and_go.fait) {
                test_up_and_go_duree.value = getEvolutionValue(previousEvaluationData?.test_up_and_go.duree, newEvaluationData.test_up_and_go.duree);
                test_up_and_go_commentaires.value = newEvaluationData.test_up_and_go.commentaires;
            }
            showTest(test_up_and_go_fait, test_up_and_go_nonfait, test_up_and_go_motif, newEvaluationData.test_up_and_go.motif, newEvaluationData.test_up_and_go.fait);
        } else {
            test_up_and_go_fieldset.setAttribute('hidden', '');
        }

        if (newEvaluationData.test_membre_sup.fait) {
            test_membre_sup_main_dominante.value = newEvaluationData.test_membre_sup.main_forte;
            test_membre_sup_main_droite.value = getEvolutionValue(previousEvaluationData?.test_membre_sup.md, newEvaluationData.test_membre_sup.md);
            test_membre_sup_main_gauche.value = getEvolutionValue(previousEvaluationData?.test_membre_sup.mg, newEvaluationData.test_membre_sup.mg);
            test_membre_sup_commentaires.value = newEvaluationData.test_membre_sup.commentaires;
        }
        showTest(test_membre_sup_fait, test_membre_sup_nonfait, test_membre_sup_motif, newEvaluationData.test_membre_sup.motif, newEvaluationData.test_membre_sup.fait);

        if (newEvaluationData.test_equilibre.fait) {
            test_equilibre_pied_dominant.value = newEvaluationData.test_equilibre.pied_dominant;
            test_equilibre_pied_gauche.value = getEvolutionValue(previousEvaluationData?.test_equilibre.pied_gauche_sol, newEvaluationData.test_equilibre.pied_gauche_sol);
            test_equilibre_pied_droit.value = getEvolutionValue(previousEvaluationData?.test_equilibre.pied_droit_sol, newEvaluationData.test_equilibre.pied_droit_sol);
            test_equilibre_commentaires.value = newEvaluationData.test_equilibre.commentaires;
        }
        showTest(test_equilibre_fait, test_equilibre_nonfait, test_equilibre_motif, newEvaluationData.test_equilibre.motif, newEvaluationData.test_equilibre.fait);

        if (newEvaluationData.test_souplesse.fait) {
            test_souplesse_distance.value = getEvolutionValue(previousEvaluationData?.test_souplesse.distance, newEvaluationData.test_souplesse.distance);
            test_souplesse_commentaires.value = newEvaluationData.test_souplesse.commentaires;
        }
        showTest(test_souplesse_fait, test_souplesse_nonfait, test_souplesse_motif, newEvaluationData.test_souplesse.motif, newEvaluationData.test_souplesse.fait);

        if (newEvaluationData.test_mobilite.fait) {
            test_mobilite_main_gauche.value = getEvolutionValue(previousEvaluationData?.test_mobilite.main_gauche_haut, newEvaluationData.test_mobilite.main_gauche_haut);
            test_mobilite_main_droite.value = getEvolutionValue(previousEvaluationData?.test_mobilite.main_droite_haut, newEvaluationData.test_mobilite.main_droite_haut);
            test_mobilite_commentaires.value = newEvaluationData.test_mobilite.commentaires;
        }
        showTest(test_mobilite_fait, test_mobilite_nonfait, test_mobilite_motif, newEvaluationData.test_mobilite.motif, newEvaluationData.test_mobilite.fait);

        if (newEvaluationData.test_membre_inf.fait) {
            test_membre_inf_nombre.value = getEvolutionValue(previousEvaluationData?.test_membre_inf.nb_lever, newEvaluationData.test_membre_inf.nb_lever);
            test_membre_inf_fc_30.value = getEvolutionValue(previousEvaluationData?.test_membre_inf.fc30, newEvaluationData.test_membre_inf.fc30, test_membre_inf_fc_30_checkbox.checked);
            test_membre_inf_sat_30.value = getEvolutionValue(previousEvaluationData?.test_membre_inf.sat30, newEvaluationData.test_membre_inf.sat30, test_membre_inf_sat_30_checkbox.checked);
            test_membre_inf_borg_30.value = getEvolutionValue(previousEvaluationData?.test_membre_inf.borg30, newEvaluationData.test_membre_inf.borg30);
            test_membre_inf_commentaires.value = newEvaluationData.test_membre_inf.commentaires;
        }
        showTest(test_membre_inf_fait, test_membre_inf_nonfait, test_membre_inf_motif, newEvaluationData.test_membre_inf.motif, newEvaluationData.test_membre_inf.fait);
    }

    /**
     *
     *
     * @param previousEval value for a previous evaluation
     * @param lastestVal value for the most recent evaluation
     * @param isCalculated if the evolution is calculated
     * @returns {string|*}
     */
    function getEvolutionValue(previousEval, lastestVal, isCalculated = true) {
        if (!isCalculated || !previousEval || previousEval === '' || !lastestVal || lastestVal === '') {
            return lastestVal;
        }
        try {
            const previousEvalFloat = parseFloat(previousEval);
            const latestValFloat = parseFloat(lastestVal);

            if (isNaN(previousEvalFloat) || isNaN(latestValFloat)) {
                return lastestVal;
            }

            const evolution = latestValFloat - previousEvalFloat;

            return lastestVal + ' (' + (evolution >= 0 ? '+' : '') + evolution.toFixed(2) + ')';
        } catch (e) {
            return lastestVal;
        }
    }

    function createOption(value, text) {
        const option = document.createElement('option');
        option.textContent = text;
        option.value = value;

        return option;
    }

    /**
     * Affiche les résultats du test s'il a été réalisé
     * sinon affiche le motif de la non réalisation
     *
     * @param fait_elem
     * @param nonfait_elem
     * @param motif_elem
     * @param motif
     * @param is_fait
     */
    function showTest(fait_elem, nonfait_elem, motif_elem, motif, is_fait) {
        if (is_fait) {
            nonfait_elem.setAttribute('hidden', '');
            fait_elem.removeAttribute('hidden');
        } else {
            fait_elem.setAttribute('hidden', '');
            nonfait_elem.removeAttribute('hidden');

            motif_elem.value = motif;
        }
    }

    function updateBodyAerobie(test_aptitude_aerobie) {
        for (let i = 1; i < 10; i++) {
            const fcTD = document.getElementById('test_aptitude_aerobie_fc' + i);
            const satTD = document.getElementById('test_aptitude_aerobie_sat' + i);
            const borgTD = document.getElementById('test_aptitude_aerobie_borg' + i);

            fcTD.textContent = getDiplayValue(test_aptitude_aerobie['fc' + i], ' bpm');
            satTD.textContent = getDiplayValue(test_aptitude_aerobie['sat' + i], ' %');
            borgTD.textContent = test_aptitude_aerobie['borg' + i];
        }
    }

    function getDiplayValue(value, unit) {
        if (value && unit) {
            return value + ' ' + unit;
        } else if (value) {
            return value;
        }

        return '';
    }

    function remplirFormulaire(data) {
        if (data == null) {
            console.error('les données n\'ont pas été récupérés');
            return;
        }

        titreSpan.textContent = data.sexe_patient === 'F' ? 'Mme ' : 'M ';

        nomPatientSpan.textContent = data.nom_patient + " " + data.prenom_patient;
        dateBilan.value = data.date_eval;
        typeBilanInput.value = data.type_eval;
        nomEvaluateurInput.value = data.nom_evaluateur;
        fonctionEvaluateurInput.value = data.fonction_evaluateur;
        prenomEvaluateurInput.value = data.prenom_evaluateur;
        mailEvaluateurInput.value = data.mail_evaluateur;
        telephoneEvaluateurInput.value = data.telephone_evaluateur;

        nomCoordonnateurInput.value = data.nom_coordinateur;
        prenomCoordonnateurInput.value = data.prenom_coordinateur;
        fonctionCoordonnateurInput.value = data.fonction_coordinateur;
        mailCoordonnateurInput.value = data.mail_coordinateur;
        telephoneCoordonnateurInput.value = data.telephone_coordinateur;

        // évaluations précedentes
        if (Array.isArray(data.evaluations_precedentes) && data.evaluations_precedentes.length > 0) {
            data.evaluations_precedentes.forEach(
                (evaluation) => {
                    evaluationsPrecedentesSelect.append(createOption(evaluation.id, evaluation.nom));
                }
            );

            const noEvalOption = createOption('-1', 'Aucun (Pas de calcul de l\'évolution)');
            noEvalOption.selected = true;
            evaluationsPrecedentesSelect.append(noEvalOption);
        } else {
            evaluationsPrecedentesSelect.append(createOption('-1', 'Aucune évaluation précédente disponible'));
        }

        let objectifPresent = false;
        if (Array.isArray(data.objectifs)) {
            for (let i = 0; i < data.objectifs.length; i++) {
                listObjectifsDiv.append(createObjectif(data.objectifs[i], i + 1));
                objectifPresent = true;
            }
        }
        if (!objectifPresent) {
            objectifsTextDiv.style.display = "block";
        }

        let activitePresent = false;
        if (Array.isArray(data.activites)) {
            for (let i = 0; i < data.activites.length; i++) {
                listActivitesDiv.append(createActivite(data.activites[i]));
                activitePresent = true;
                if (i !== data.activites.length - 1) {
                    //pour séparer les activités
                    const hr = document.createElement('hr');
                    hr.style.borderWidth = "3px";
                    listActivitesDiv.append(hr);
                }
            }
        }
        if (!activitePresent) {
            activitesTextDiv.style.display = "block";
        }
    }

    function createObjectif(objectif, id) {
        const row1 = document.createElement('div');
        row1.className = 'row';

        const col1_1 = document.createElement('div');
        col1_1.className = 'col-md-3 intitule';
        col1_1.textContent = 'Objectif ' + id;
        const col1_2 = document.createElement('div');
        col1_2.className = 'col-md-2 intitule';
        col1_2.textContent = 'Date';
        const col1_3 = document.createElement('div');
        col1_3.className = 'col-md-2 intitule';
        col1_3.textContent = 'Date dernier avancement';
        const col1_4 = document.createElement('div');
        col1_4.className = 'col-md-2 intitule';
        col1_4.textContent = 'Avancement';
        const col1_5 = document.createElement('div');
        col1_5.className = 'col-md-3 intitule';
        col1_5.textContent = 'Commentaires';

        row1.append(col1_1, col1_2, col1_3, col1_4, col1_5);

        const row2 = document.createElement('div');
        row2.className = 'row objectifs-element';

        const col2_1 = document.createElement('div');
        col2_1.className = 'col-md-3';

        const nomObjectif = document.createElement('input');
        nomObjectif.type = 'text';
        nomObjectif.value = objectif.nom_objectif;
        nomObjectif.className = 'form-control';

        col2_1.append(nomObjectif);

        const col2_2 = document.createElement('div');
        col2_2.className = 'col-md-2';
        const date = document.createElement('input');
        date.type = 'date';
        date.className = 'form-control';
        date.value = objectif.date_objectif_patient;

        col2_2.append(date);

        const col2_3 = document.createElement('div');
        col2_3.className = 'col-md-2';

        const dateDerniere = document.createElement('input');
        dateDerniere.className = 'form-control';
        if (objectif.avancement == null) {
            dateDerniere.type = 'text';
            dateDerniere.value = 'Aucune';
        } else {
            dateDerniere.type = 'date';
            dateDerniere.value = objectif.avancement.date_avancement;
        }

        col2_3.append(dateDerniere);

        const col2_4 = document.createElement('div');
        col2_4.className = 'col-md-2';
        const avancement = document.createElement('input');
        avancement.type = 'text';
        avancement.value = objectif.avancement == null ? 'Aucun' : objectif.avancement.atteinte;
        avancement.className = 'form-control';

        col2_4.append(avancement);

        const col2_5 = document.createElement('div');
        col2_5.className = 'col-md-3';
        const commentaires = document.createElement('input');
        commentaires.type = 'text';
        commentaires.value = objectif.avancement == null ? '' : objectif.avancement.commentaires;
        commentaires.className = 'form-control';

        col2_5.append(commentaires);

        row2.append(col2_1, col2_2, col2_3, col2_4, col2_5);

        const div = document.createElement('div');
        div.className = 'bottom-padding-list';
        div.append(row1, row2);

        return div;
    }

    function createActivite(activite) {
        const row1 = document.createElement('div');
        row1.className = 'row';

        // const col1_1 = document.createElement('div');
        // col1_1.className = 'col-md-1 intitule';
        // col1_1.textContent = 'Date';
        const col1_2 = document.createElement('div');
        col1_2.className = 'col-md-2 intitule';
        col1_2.textContent = 'Orientation';
        const col1_3 = document.createElement('div');
        col1_3.className = 'col-md-4 intitule';
        col1_3.textContent = 'Activité choisie';
        const col1_4 = document.createElement('div');
        col1_4.className = 'col-md-6 intitule';
        col1_4.textContent = 'Structure';

        row1.append(col1_2, col1_3, col1_4);

        const row2 = document.createElement('div');
        row2.className = 'row activites-element-1';

        const col2_2 = document.createElement('div');
        col2_2.className = 'col-md-2';
        const orientation = document.createElement('input');
        orientation.type = 'text';
        orientation.value = activite.type_parcours;
        orientation.className = 'form-control';

        col2_2.append(orientation);

        const col2_3 = document.createElement('div');
        col2_3.className = 'col-md-4';
        const nomActivite = document.createElement('input');
        nomActivite.type = 'text';
        nomActivite.value = activite.nom_creneau;
        nomActivite.className = 'form-control';

        col2_3.append(nomActivite);

        const col2_4 = document.createElement('div');
        col2_4.className = 'col-md-6';
        const nomStructure = document.createElement('input');
        nomStructure.type = 'text';
        nomStructure.value = activite.nom_structure;
        nomStructure.className = 'form-control';

        col2_4.append(nomStructure);
        const linebreak = document.createElement('br');

        row2.append(col2_2, col2_3, col2_4, linebreak);

        const row3 = document.createElement('div');
        row3.className = 'row';
        row3.style.marginTop = '5px';

        const col3_1 = document.createElement('div');
        col3_1.className = 'col-md-5 intitule';
        col3_1.textContent = 'Horaires';
        const col3_2 = document.createElement('div');
        col3_2.className = 'col-md-3 intitule';
        col3_2.textContent = 'Date démarrage';
        const col3_3 = document.createElement('div');
        col3_3.className = 'col-md-3 intitule';
        col3_3.textContent = 'Statut';

        row3.append(col3_1, col3_2, col3_3);

        const row4 = document.createElement('div');
        row4.className = 'row activites-element-2';

        const col4_1 = document.createElement('div');
        col4_1.className = 'col-md-5';
        const horaire = document.createElement('input');
        horaire.type = 'text';
        horaire.value = activite.jour + ', ' + activite.heure_debut + ' à ' + activite.heure_fin;
        horaire.className = 'form-control';

        col4_1.append(horaire);

        const col4_2 = document.createElement('div');
        col4_2.className = 'col-md-3';
        const dateDemarrage = document.createElement('input');
        dateDemarrage.type = 'date';
        dateDemarrage.value = activite.date_demarrage;
        dateDemarrage.className = 'form-control';

        col4_2.append(dateDemarrage);

        const col4_3 = document.createElement('div');
        col4_3.className = 'col-md-3';
        const statut = document.createElement('input');
        statut.type = 'text';
        statut.value = activite.statut;
        statut.className = 'form-control';

        col4_3.append(statut);

        row4.append(col4_1, col4_2, col4_3);

        const row5 = document.createElement('div');
        row5.className = 'row';
        row5.style.marginTop = '5px';

        const col5_1 = document.createElement('div');
        col5_1.className = 'col-md-4 intitule';
        col5_1.textContent = 'Commentaires';

        row5.append(col5_1);

        const row6 = document.createElement('div');
        row6.className = 'row activites-element-3';

        const col6_1 = document.createElement('div');
        col6_1.className = 'col-md-12';
        const commentaires = document.createElement('textarea');
        commentaires.value = activite.commentaire;
        commentaires.className = 'form-control';

        col6_1.append(commentaires);

        row6.append(col6_1);

        const div = document.createElement('div');
        div.className = 'bottom-padding-list act-div';
        div.append(row1, row2, row3, row4, row5, row6);

        return div;
    }

    function createPersonneElement() {
        const fieldset = document.createElement('fieldset');
        fieldset.className = 'section-bleu personnes-element';
        fieldset.style.marginTop = '5px';
        fieldset.style.marginLeft = '5px';
        fieldset.style.marginRight = '5px';
        const titre = document.createElement('legend');
        titre.className = 'section-titre-bleu';
        titre.textContent = 'Personne numéro ';

        fieldset.append(titre);

        // row 0
        const row0 = document.createElement('div');
        row0.className = 'row bottom-padding-list';

        const row0_td1 = document.createElement('div');
        row0_td1.className = 'col-md-4';
        const row0_td1_label = document.createElement('label');
        row0_td1_label.textContent = 'Nom';

        row0_td1.append(row0_td1_label);

        const row0_td2 = document.createElement('div');
        row0_td2.className = 'col-md-4';
        const row0_td2_input = document.createElement('input');
        row0_td2_input.className = 'form-control input-md';
        row0_td2_input.type = 'text';

        row0_td2.append(row0_td2_input);
        row0.append(row0_td1, row0_td2);

        // row 1
        const row1 = document.createElement('div');
        row1.className = 'row bottom-padding-list';

        const row1_td1 = document.createElement('div');
        row1_td1.className = 'col-md-4';
        const row1_td1_label = document.createElement('label');
        row1_td1_label.textContent = 'Prénom';

        row1_td1.append(row1_td1_label);

        const row1_td2 = document.createElement('div');
        row1_td2.className = 'col-md-4';
        const row1_td2_input = document.createElement('input');
        row1_td2_input.className = 'form-control input-md';
        row1_td2_input.type = 'text';

        row1_td2.append(row1_td2_input);
        row1.append(row1_td1, row1_td2);

        // row 2
        const row2 = document.createElement('div');
        row2.className = 'row bottom-padding-list';

        const row2_td1 = document.createElement('div');
        row2_td1.className = 'col-md-4';
        const row2_td1_label = document.createElement('label');
        row2_td1_label.textContent = 'Fonction';

        row2_td1.append(row2_td1_label);

        const row2_td2 = document.createElement('div');
        row2_td2.className = 'col-md-4';
        const row2_td2_input = document.createElement('input');
        row2_td2_input.className = 'form-control input-md';
        row2_td2_input.type = 'text';

        row2_td2.append(row2_td2_input);
        row2.append(row2_td1, row2_td2);

        // row 3
        const row3 = document.createElement('div');
        row3.className = 'row bottom-padding-list';

        const row3_td1 = document.createElement('div');
        row3_td1.className = 'col-md-4';
        const row3_td1_label = document.createElement('label');
        row3_td1_label.textContent = 'Mail';

        row3_td1.append(row3_td1_label);

        const row3_td2 = document.createElement('div');
        row3_td2.className = 'col-md-4';
        const row3_td2_input = document.createElement('input');
        row3_td2_input.className = 'form-control input-md';
        row3_td2_input.type = 'text';

        row3_td2.append(row3_td2_input);
        row3.append(row3_td1, row3_td2);

        // row 4
        const row4 = document.createElement('div');
        row4.className = 'row bottom-padding-list';

        const row4_td1 = document.createElement('div');
        row4_td1.className = 'col-md-4';
        const row4_td1_label = document.createElement('label');
        row4_td1_label.textContent = 'Téléphone';

        row4_td1.append(row4_td1_label);

        const row4_td2 = document.createElement('div');
        row4_td2.className = 'col-md-4';
        const row4_td2_input = document.createElement('input');
        row4_td2_input.className = 'form-control input-md';
        row4_td2_input.type = 'text';

        row4_td2.append(row4_td2_input);
        row4.append(row4_td1, row4_td2);

        // row 5
        const row5 = document.createElement('div');
        row5.className = 'row bottom-padding-list';

        const row5_td1 = document.createElement('div');
        row5_td1.className = 'col-md-12';
        row5_td1.style.textAlign = 'center';
        const row5_td1_button = document.createElement('button');
        row5_td1_button.textContent = 'Supprimer';
        row5_td1_button.className = 'btn btn-danger';

        row5_td1_button.onclick = function (event) {
            event.preventDefault();
            fieldset.remove();
            updateNumerosPersonnes();
        }

        row5_td1.append(row5_td1_button);
        row5.append(row5_td1);
        fieldset.append(row0, row1, row2, row3, row4, row5);

        return fieldset;
    }

    function updateNumerosPersonnes() {
        const activite_elems = document.getElementsByClassName('personnes-element');
        for (let i = 0; i < activite_elems.length; i++) {
            activite_elems[i].firstChild.textContent = 'Personne numéro ' + (i + 1);
        }
    }

    function getFormData() {
        const patient = form.getAttribute("data-id_patient");
        const activites = [];
        //on récupère chaque division d'activité
        const div_activites = document.querySelectorAll('.act-div');
        for (const div_act of div_activites) {
            //les différents champs de valeurs de l'activité
            const elem_row2 = div_act.querySelector('.activites-element-1');
            const elem_row4 = div_act.querySelector('.activites-element-2');
            const elem_row6 = div_act.querySelector('.activites-element-3');
            activites.push({
                'orientation': elem_row2.childNodes[0].firstChild.value,
                'activite': elem_row2.childNodes[1].firstChild.value,
                'structure': elem_row2.childNodes[2].firstChild.value,
                'creneaux': elem_row4.childNodes[0].firstChild.value,
                'date_demarrage': elem_row4.childNodes[1].firstChild.value,
                'statut': elem_row4.childNodes[2].firstChild.value,
                'commentaire': elem_row6.childNodes[0].firstChild.value,
            });
        }

        const objectifs = [];
        const elemsObjectifs = document.querySelectorAll('.objectifs-element');
        for (const elem of elemsObjectifs) {
            objectifs.push({
                'nom_objectif': elem.childNodes[0].firstChild.value,
                'date': elem.childNodes[1].firstChild.value,
                'date_dernier_avancement': elem.childNodes[2].firstChild.value,
                'avancement': elem.childNodes[3].firstChild.value,
                'commentaire': elem.childNodes[4].firstChild.value,
            });
        }

        const personnes = [];
        const elemsPersonnes = document.querySelectorAll('.personnes-element');
        for (const elem of elemsPersonnes) {
            console.log("elemsPersonnes", elemsPersonnes);
            console.log("nom", elem.childNodes[1].childNodes[1].firstChild.value);
            console.log("prenom", elem.childNodes[2].childNodes[1].firstChild.value);
            console.log("fonction", elem.childNodes[3].childNodes[1].firstChild.value);
            console.log("mail", elem.childNodes[4].childNodes[1].firstChild.value);
            console.log("telephone", elem.childNodes[5].childNodes[1].firstChild.value);
            personnes.push({
                'nom': elem.childNodes[1].childNodes[1].firstChild.value,
                'prenom': elem.childNodes[2].childNodes[1].firstChild.value,
                'fonction': elem.childNodes[3].childNodes[1].firstChild.value,
                'mail': elem.childNodes[4].childNodes[1].firstChild.value,
                'telephone': elem.childNodes[5].childNodes[1].firstChild.value,
            });
        }

        console.log("personnes", personnes);

        lastestEval.test_aptitude_aerobie.pourcentage_distance_theorique = pourcentageDistanceTheorique(
            lastestEval.test_aptitude_aerobie.distance_parcourue,
            lastestEval.test_physio.taille,
            lastestEval.age,
            lastestEval.sexe,
            lastestEval.test_physio.poids
        );

        const test_aptitude_aerobie = JSON.parse(JSON.stringify(lastestEval.test_aptitude_aerobie));
        const test_equilibre = JSON.parse(JSON.stringify(lastestEval.test_equilibre));
        const test_mobilite = JSON.parse(JSON.stringify(lastestEval.test_mobilite));
        const test_souplesse = JSON.parse(JSON.stringify(lastestEval.test_souplesse));
        const test_force = JSON.parse(JSON.stringify(lastestEval.test_membre_sup));
        const test_assis_debout = JSON.parse(JSON.stringify(lastestEval.test_membre_inf));
        const donnee_anthropometrique = JSON.parse(JSON.stringify(lastestEval.test_physio));
        const test_up_and_go = JSON.parse(JSON.stringify(lastestEval.test_up_and_go));

        if (previousEval != null) {
            test_aptitude_aerobie.distance_parcourue = getEvolutionValue(previousEval.test_aptitude_aerobie.distance_parcourue, lastestEval.test_aptitude_aerobie.distance_parcourue);

            test_up_and_go.duree = getEvolutionValue(previousEval.test_up_and_go.duree, lastestEval.test_up_and_go.duree);

            test_force.mg = getEvolutionValue(previousEval.test_membre_sup.mg, lastestEval.test_membre_sup.mg);
            test_force.md = getEvolutionValue(previousEval.test_membre_sup.md, lastestEval.test_membre_sup.md);

            test_equilibre.pied_gauche_sol = getEvolutionValue(previousEval.test_equilibre.pied_gauche_sol, lastestEval.test_equilibre.pied_gauche_sol);
            test_equilibre.pied_droit_sol = getEvolutionValue(previousEval.test_equilibre.pied_droit_sol, lastestEval.test_equilibre.pied_droit_sol);

            test_souplesse.distance = getEvolutionValue(previousEval.test_souplesse.distance, lastestEval.test_souplesse.distance);

            test_mobilite.main_gauche_haut = getEvolutionValue(previousEval.test_mobilite.main_gauche_haut, lastestEval.test_mobilite.main_gauche_haut);
            test_mobilite.main_droite_haut = getEvolutionValue(previousEval.test_mobilite.main_droite_haut, lastestEval.test_mobilite.main_droite_haut);

            test_assis_debout.nb_lever = getEvolutionValue(previousEval.test_membre_inf.nb_lever, lastestEval.test_membre_inf.nb_lever);
            test_assis_debout.borg30 = getEvolutionValue(previousEval.test_membre_inf.borg30, lastestEval.test_membre_inf.borg30);
            test_assis_debout.fc30 = getEvolutionValue(previousEval.test_membre_inf.fc30, lastestEval.test_membre_inf.fc30, test_membre_inf_fc_30_checkbox.checked);
            test_assis_debout.sat30 = getEvolutionValue(previousEval.test_membre_inf.sat30, lastestEval.test_membre_inf.sat30, test_membre_inf_sat_30_checkbox.checked);

            donnee_anthropometrique.IMC = getEvolutionValue(previousEval.test_physio.IMC, lastestEval.test_physio.IMC);
            donnee_anthropometrique.borg_repos = getEvolutionValue(previousEval.test_physio.borg_repos, lastestEval.test_physio.borg_repos);
            donnee_anthropometrique.poids = getEvolutionValue(previousEval.test_physio.poids, lastestEval.test_physio.poids);
            donnee_anthropometrique.taille = getEvolutionValue(previousEval.test_physio.taille, lastestEval.test_physio.taille);
            donnee_anthropometrique.tour_taille = getEvolutionValue(previousEval.test_physio.tour_taille, lastestEval.test_physio.tour_taille);
            donnee_anthropometrique.saturation_repos = getEvolutionValue(previousEval.test_physio.saturation_repos, lastestEval.test_physio.saturation_repos, test_physio_saturation_repos_checkbox.checked);
            donnee_anthropometrique.fc_repos = getEvolutionValue(previousEval.test_physio.fc_repos, lastestEval.test_physio.fc_repos, test_physio_fc_repos_checkbox.checked);
            donnee_anthropometrique.fc_max_mesuree = getEvolutionValue(previousEval.test_physio.fc_max_mesuree, lastestEval.test_physio.fc_max_mesuree, test_physio_fc_max_mesuree_checkbox.checked);
            donnee_anthropometrique.fc_max_theo = getEvolutionValue(previousEval.test_physio.fc_max_theo, lastestEval.test_physio.fc_max_theo, test_physio_fc_max_theorique_checkbox.checked);
        }

        return {
            'version_synthese': versionSyntheseSlect.value,
            'nom_patient': data.nom_patient,
            'prenom_patient': data.prenom_patient,
            'sexe_patient': data.sexe_patient,
            'date_naissance': data.date_naissance,
            'nom_naissance': data.nom_naissance,
            'premier_prenom_naissance': data.premier_prenom_naissance,
            'code_insee_naissance': data.code_insee_naissance,
            'oid': data.oid,
            'nature_oid': data.nature_oid,
            'matricule_ins': data.matricule_ins,
            'nom_utilise': data.nom_utilise,
            'prenom_utilise': data.prenom_utilise,
            'liste_prenom_naissance': data.liste_prenom_naissance,
            'id_type_statut_identite': data.id_type_statut_identite,
            'date_synthese': dateSynthese.value,
            'date_bilan': dateBilan.value,
            'type_bilan': typeBilanInput.value,
            'activites': activites,
            'activites_text': activitesTextTextarea.value,
            'objectifs': objectifs,
            'objectif_text': objectifsTextTextarea.value,
            'commentaires_objectifs': commentairesObjectifsInput.value,
            'preconisations': preconisationsInput.value,
            'point_vigilances': pointVigilancesInput.value,
            'logo_fichier': data.logo_fichier,

            'nom_coordinateur': nomCoordonnateurInput.value,
            'fonction_coordinateur': fonctionCoordonnateurInput.value,
            'mail_coordinateur': mailCoordonnateurInput.value,
            'prenom_coordinateur': prenomCoordonnateurInput.value,
            'telephone_coordinateur': telephoneCoordonnateurInput.value,

            'nom_evaluateur': nomEvaluateurInput.value,
            'fonction_evaluateur': fonctionEvaluateurInput.value,
            'mail_evaluateur': mailEvaluateurInput.value,
            'prenom_evaluateur': prenomEvaluateurInput.value,
            'telephone_evaluateur': telephoneEvaluateurInput.value,

            'introduction': introductionTextarea.value,
            'conclusion': conclusionTextarea.value,
            'remerciements': remerciementsTextarea.value,
            'affichage_page': affichagePageCheckbox.checked,
            'affichage_paaco_globule': affichagePaacoGlobuleCheckbox.checked,
            'affichage_coordonnees_evaluateur': affichageCoordonneesEvaluateurCheckbox.checked,
            'affichage_coordonnees_coordonnateur': affichageCoordonneesCoordonnateurCheckbox.checked,
            'affichage_saut_page_conclusion': affichageSautPageConclusionCheckbox.checked,
            'affichage_details_patient_infos_supplementaires': affichageDetailsPatientInfosSupplementairesCheckbox.checked,

            'test_6_min': test_aptitude_aerobie,
            'test_equilibre': test_equilibre,
            'test_mobilite': test_mobilite,
            'test_souplesse': test_souplesse,
            'test_force': test_force,
            'test_assis_debout': test_assis_debout,
            'donnee_anthropometrique': donnee_anthropometrique,
            'test_up_and_go': test_up_and_go,
            'date_bilan_precedent': previousEval ? previousEval.date_eval : '',
            'nom_bilan_precedent': nomBilanPrecedentInput.value,

            'autres_personnes': personnes,

            'save': 0,//valeur par défaut, indique si on sauvegarde la synthèse ou non
            'id_patient': patient
        };
    }

    return {
        init,
        handleVersionChange
    };
})();

const optionsSynthese = (function () {
    const form = document.getElementById("form-options-synthese");
    const openModalButton = document.getElementById("open-modal-options-synthese");
    const enregistrerButton = document.getElementById("enregistrer");

    const introductionMedecin = document.getElementById("introduction-medecin");
    const introductionBeneficiaire = document.getElementById("introduction-beneficiaire");
    const remerciementsMedecin = document.getElementById("remerciements-medecin");
    const remerciementBeneficiaire = document.getElementById("remerciements-beneficiaire");

    const voirPlusButton = document.getElementById("voir-plus");
    const plusText = document.getElementById("plus-text");

    // boutons du modal
    const confirmclosed = document.getElementById('confirmclosed');
    const close = document.getElementById("close");

    const $warningModal = $("#warning");
    const $mainModal = $("#modal-options-synthese");
    const warningText = document.getElementById('warning-text');

    function init() {
        form.onsubmit = handleSubmit;
        openModalButton.onclick = setOptions;
        enregistrerButton.onclick = handleSubmit;
        close.onclick = handleConfirmCloseClick;

        confirmclosed.onclick = () => {
            $warningModal.modal('hide');
            $mainModal.modal('hide');
        };

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

    function handleConfirmCloseClick() {
        $warningModal.modal('show');
        warningText.textContent = 'Abandonner ?';
    }

    function getData() {
        return {
            "id_settings_synthese": form.getAttribute("data-id_settings_synthese"),
            "id_structure": form.getAttribute("data-id_structure"),
            "introduction_medecin": introductionMedecin.value,
            "introduction_beneficiaire": introductionBeneficiaire.value,
            "remerciements_medecin": remerciementsMedecin.value,
            "remerciements_beneficiaire": remerciementBeneficiaire.value,
        };
    }

    function handleSubmit(event) {
        event.preventDefault();
        $mainModal.modal('hide');

        if (form.getAttribute("data-id_settings_synthese") === '') {
            fetch('Synthese/SettingsSynthese/CreateSettingsSynthese.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(getData()),
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
                    form.setAttribute("data-id_settings_synthese", data.id_settings_synthese);
                    synthese.handleVersionChange();
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        } else {
            fetch('Synthese/SettingsSynthese/UpdateSettingsSynthese.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(getData()),
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
                    synthese.handleVersionChange();
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    }

    function setOptions() {
        const id_settings_synthese = form.getAttribute("data-id_settings_synthese");
        if (id_settings_synthese !== "") {
            fetch('Synthese/SettingsSynthese/ReadOneSettingsSynthese.php', {
                method: 'POST',
                body: JSON.stringify({'id_settings_synthese': id_settings_synthese})
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
                    introductionMedecin.textContent = data.introduction_medecin;
                    introductionBeneficiaire.textContent = data.introduction_beneficiaire;
                    remerciementsMedecin.textContent = data.remerciements_medecin;
                    remerciementBeneficiaire.textContent = data.remerciements_beneficiaire;
                })
                .catch((error) => console.error(error));
        }
    }

    return {
        init
    };
})();

const previewPdf = (function () {
    // Loaded via <script> tag, create shortcut to access PDF.js exports.
    const pdfjsLib = window['pdfjs-dist/build/pdf'];

    // The workerSrc property shall be specified.
    pdfjsLib.GlobalWorkerOptions.workerSrc = '../../js/pdfjs-dist/pdf.worker.js';

    // pdf buttons controls
    const nextButton = document.getElementById('next');
    const prevButton = document.getElementById('prev');
    const zoomPlusButton = document.getElementById('zoom-plus');
    const minusPlusButton = document.getElementById('zoom-minus');
    const borderCheckbox = document.getElementById('border-checkbox');

    // adding event listeners on buttons
    nextButton.addEventListener('click', onNextPage);
    prevButton.addEventListener('click', onPrevPage);
    zoomPlusButton.addEventListener('click', onZoomPlus);
    minusPlusButton.addEventListener('click', onZoomMinus);
    borderCheckbox.addEventListener('change', onToggleBorder);

    // canvas used to draw the pdf
    const canvas = document.getElementById('the-canvas');
    const ctx = canvas.getContext('2d');

    // pdf infos
    const pageNumInput = document.getElementById('page_num');
    const zoomValueInput = document.getElementById('zoom_value');

    const scale_min = 0.5;
    const scale_max = 3;
    const scale_step = 0.1;

    let pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 1;

    //init
    onToggleBorder();

    /**
     * Get page info from document, resize canvas accordingly, and render page.
     * @param num Page number.
     */
    function renderPage(num) {
        pageRendering = true;
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function (page) {
            const viewport = page.getViewport({scale: scale});
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Render PDF page into canvas context
            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            const renderTask = page.render(renderContext);

            // Wait for rendering to finish
            renderTask.promise.then(function () {
                pageRendering = false;
                if (pageNumPending !== null) {
                    // New page rendering is pending
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });

        // Update page counters
        setCurrentPageNum(num);
        setZoomValue(scale);
        handleButtonsStates();
    }

    /**
     * If another page rendering in progress, waits until the rendering is
     * finised. Otherwise, executes rendering immediately.
     */
    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    /**
     * Displays the message txt in the canvas ctx
     * (clear the canvas first)
     * @param txt string the message to display
     */
    function displayMessageInCanvas(txt) {
        ctx.clearRect(0, 0, canvas.width, canvas.height); // clear the canvas
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.font = "20px normal 'Helvetica Nueue'";
        ctx.fillText(txt, canvas.width / 2, canvas.height / 2);
    }

    /**
     * Displays previous page.
     */
    function onPrevPage() {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    }

    /**
     * Displays next page.
     */
    function onNextPage() {
        if (pdfDoc) {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
    }

    /**
     * Increments the zoom of the page
     */
    function onZoomPlus() {
        if (scale + scale_step >= scale_max) {
            return;
        }
        scale += scale_step;
        scale = parseFloat(scale.toFixed(1));
        queueRenderPage(pageNum);
        setZoomValue(scale);
    }

    /**
     * Decrements the zoom of the page
     */
    function onZoomMinus() {
        if (scale - scale_step <= scale_min) {
            return;
        }
        scale -= scale_step;
        scale = parseFloat(scale.toFixed(1));
        queueRenderPage(pageNum);
        setZoomValue(scale);
    }

    /**
     * Displays the border if the checkbox is checked
     */
    function onToggleBorder() {
        if (borderCheckbox.checked) {
            canvas.classList.remove("border-hidden");
            canvas.classList.add("border-displayed");
        } else {
            canvas.classList.remove("border-displayed");
            canvas.classList.add("border-hidden");
        }
    }

    /**
     * Disables buttons if they should be disabled.
     */
    function handleButtonsStates() {
        // zoom plus button
        if (scale + scale_step >= scale_max) {
            zoomPlusButton.setAttribute("disabled", "disabled");
        } else {
            zoomPlusButton.removeAttribute("disabled");
        }

        // zoom minus button
        if (scale - scale_step <= scale_min) {
            minusPlusButton.setAttribute("disabled", "disabled");
        } else {
            minusPlusButton.removeAttribute("disabled");
        }

        // prev button
        if (pageNum <= 1) {
            prevButton.setAttribute("disabled", "disabled");
        } else {
            prevButton.removeAttribute("disabled");
        }

        // next button
        if (pageNum >= pdfDoc.numPages) {
            nextButton.setAttribute("disabled", "disabled");
        } else {
            nextButton.removeAttribute("disabled");
        }
    }

    /**
     * Sets the pdf document.
     * Renders the first page of the pdf
     *
     * @param pdfDoc_ the pdf document.
     */
    function setPdfDoc(pdfDoc_) {
        pdfDoc = pdfDoc_;
        pageNum = 1;
        renderPage(pageNum);
    }

    /**
     * Sets current page number
     * @param num Current page number.
     */
    function setCurrentPageNum(num) {
        if (pdfDoc) {
            pageNumInput.value = num + '/' + pdfDoc.numPages;
        } else {
            pageNumInput.value = pageNumInput.placeholder;
        }
    }

    /**
     * Sets current page number
     * @param scale Current page number.
     */
    function setZoomValue(scale) {
        zoomValueInput.value = (scale * 100).toFixed(0).toString() + " %";
    }

    /**
     * Asynchronously loads PDF from an arrayBuffer
     * @param arrayBuffer the pdf data
     */
    function loadPdfdocument(arrayBuffer) {
        pdfjsLib.getDocument({data: arrayBuffer})
            .promise
            .then(pdfDoc_ => setPdfDoc(pdfDoc_))
            .catch(error => displayMessageInCanvas('Error displaying pdf:' + error));
    }

    return {
        loadPdfdocument,
        displayMessageInCanvas
    };
})();