"use strict";

/**
 * Ce fichier nécessite le fichier calculsEvaluation.js pour fonctionner correctement
 */

// les différents modes d'interaction avec le modal
const MODE = {
    EVAL_SUIV: 'eval_suiv',
    INFO_EVAL: 'info_eval'
};
Object.freeze(MODE);

$(document).ready(function () {
    // initialisation des élements de la page
    modal.init();
});


const modal = (function () {
    const open_details = document.getElementsByClassName('open-modal');

    const titre = document.getElementById('modal-title');

    //modals
    const $warning = $("#warning");
    const $modalEval = $("#modal");
    const confirmclosed = document.getElementById('confirmclosed');
    const refuseclosed = document.getElementById('refuseclosed');
    const enregistrer = document.getElementById('enregistrer-modifier');

    // section evaluation suivante
    const section_eval_suiv = document.getElementById('section-eval-suiv');
    const date_eval_suiv = document.getElementById('date_eval_suiv');

    //div section-creneau
    const section_creneau = document.getElementById('section-creneau');

    // champs test physio
    const test_physio_poids = document.getElementById('test_physio_poids');
    const test_physio_taille = document.getElementById('test_physio_taille');
    const test_physio_imc = document.getElementById('test_physio_imc');
    const test_physio_tour_taille = document.getElementById('test_physio_tour_taille');
    const test_physio_saturation_repos = document.getElementById('test_physio_saturation_repos');
    const test_physio_borg_repos = document.getElementById('test_physio_borg_repos');
    const test_physio_fc_repos = document.getElementById('test_physio_fc_repos');
    const test_physio_fc_max_mesuree = document.getElementById('test_physio_fc_max_mesuree');
    const test_physio_fc_max_theorique = document.getElementById('test_physio_fc_max_theorique');
    const test_physio_motif = document.getElementById('test_physio_motif');

    // div test physio
    const test_physio_nonfait = document.getElementById('test_physio_nonfait');
    const test_physio_fait = document.getElementById('test_physio_fait');

    // champs test Aptitudes Aérobie
    const test_aptitude_aerobie_distance = document.getElementById('test_aptitude_aerobie_distance');
    const test_aptitude_aerobie_distance_theorique = document.getElementById('test_aptitude_aerobie_distance_theorique');
    const test_aptitude_aerobie_body = document.getElementById('test_aptitude_aerobie_body');
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

    // div test Endurance musculaire membres inférieurs
    const test_membre_inf_nonfait = document.getElementById('test_membre_inf_nonfait');
    const test_membre_inf_fait = document.getElementById('test_membre_inf_fait');

    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    function init() {
        if (section_eval_suiv.getAttribute('data-new-eval') === "1") {
            //fait suite à une nouvelle évaluation non finale : on affiche de quoi mettre à jour la date de la prochaine évaluation
            $warning.modal("show");

            getConfirmation().then(is_valid => {
                $warning.modal("hide");
                if (is_valid) {
                    setModalMode(MODE.EVAL_SUIV);
                    enregistrer.addEventListener('click', function (event) {
                        event.preventDefault();
                        updateDateEvalSuiv(date_eval_suiv.value);
                        setModalMode(MODE.INFO_EVAL);
                    });
                    $modalEval.modal('show');
                } else {
                    setModalMode(MODE.INFO_EVAL);
                }
            });
        } else {
            //pas de nouvelle évaluation, affichage par défaut de l'onglet
            setModalMode(MODE.INFO_EVAL);
        }
        for (const button of open_details) {
            button.addEventListener('click', function () {
                setDetails(button.getAttribute('data-id_evaluation'));
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

    //fonction pour mettre à jour la date de la prochaine évaluation
    function updateDateEvalSuiv(date) {
        let id_patient = enregistrer.getAttribute('data-id_patient');

        fetch('UpdateDateEvalSuiv.php', {
            method: 'POST',
            body: JSON.stringify({"id_patient": id_patient, "date_eval_suiv": date}),
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
                $modalEval.modal('hide');
                if (date !== "" && date != null) {
                    toast('Date de la prochaine évaluation mise à jour');
                }
            })
            .catch(error => {
                console.log("Error :", error);
                $modalEval.close('hide');
                toast('Erreur de la mise à jour');
            });
    }

    function getDiplayValue(value, unit) {
        if (value && unit) {
            return value + ' ' + unit;
        } else if (value) {
            return value;
        }

        return '';
    }

    function setDetails(id_evaluation) {
        fetch('Evaluation/ReadEvaluation.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_evaluation": id_evaluation}),
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
                titre.textContent = data.type_eval;

                if (data.test_physio.fait) {
                    test_physio_poids.value = getDiplayValue(data.test_physio.poids, 'kg');
                    test_physio_imc.value = data.test_physio.IMC;
                    test_physio_taille.value = getDiplayValue(data.test_physio.taille, 'cm');
                    test_physio_tour_taille.value = getDiplayValue(data.test_physio.tour_taille, 'cm');
                    test_physio_saturation_repos.value = getDiplayValue(data.test_physio.saturation_repos, '%');
                    test_physio_fc_repos.value = getDiplayValue(data.test_physio.fc_repos, 'bpm');
                    test_physio_borg_repos.value = data.test_physio.borg_repos;
                    test_physio_fc_max_mesuree.value = getDiplayValue(data.test_physio.fc_max_mesuree, 'bpm');
                    test_physio_fc_max_theorique.value = getDiplayValue(data.test_physio.fc_max_theo, 'bpm');
                }
                showTest(test_physio_fait, test_physio_nonfait, test_physio_motif, data.test_physio.motif, data.test_physio.fait);

                if (data.test_aptitude_aerobie.fait) {
                    updateBodyAerobie(data.test_aptitude_aerobie);

                    test_aptitude_aerobie_distance.value = data.test_aptitude_aerobie.distance_parcourue;
                    test_aptitude_aerobie_distance_theorique.value = pourcentageDistanceTheorique(
                        data.test_aptitude_aerobie.distance_parcourue,
                        data.test_physio.taille,
                        data.age,
                        data.sexe,
                        data.test_physio.poids
                    );
                    test_aptitude_aerobie_commentaires.value = data.test_aptitude_aerobie.commentaires;
                }
                showTest(test_aptitude_aerobie_fait, test_aptitude_aerobie_nonfait, test_aptitude_aerobie_motif, data.test_aptitude_aerobie.motif, data.test_aptitude_aerobie.fait);

                // si le test aptitude aerobie n'est fait
                if (!data.test_aptitude_aerobie.fait) {
                    test_up_and_go_fieldset.removeAttribute('hidden');

                    if (data.test_up_and_go.fait) {
                        test_up_and_go_duree.value = data.test_up_and_go.duree;
                        test_up_and_go_commentaires.value = data.test_up_and_go.commentaires;
                    }
                    showTest(test_up_and_go_fait, test_up_and_go_nonfait, test_up_and_go_motif, data.test_up_and_go.motif, data.test_up_and_go.fait);
                } else {
                    test_up_and_go_fieldset.setAttribute('hidden', '');
                }

                if (data.test_membre_sup.fait) {
                    test_membre_sup_main_dominante.value = data.test_membre_sup.main_forte;
                    test_membre_sup_main_droite.value = data.test_membre_sup.md;
                    test_membre_sup_main_gauche.value = data.test_membre_sup.mg;
                    test_membre_sup_commentaires.value = data.test_membre_sup.commentaires;
                }
                showTest(test_membre_sup_fait, test_membre_sup_nonfait, test_membre_sup_motif, data.test_membre_sup.motif, data.test_membre_sup.fait);

                if (data.test_equilibre.fait) {
                    test_equilibre_pied_dominant.value = data.test_equilibre.pied_dominant;
                    test_equilibre_pied_gauche.value = data.test_equilibre.pied_gauche_sol;
                    test_equilibre_pied_droit.value = data.test_equilibre.pied_droit_sol;
                    test_equilibre_commentaires.value = data.test_equilibre.commentaires;
                }
                showTest(test_equilibre_fait, test_equilibre_nonfait, test_equilibre_motif, data.test_equilibre.motif, data.test_equilibre.fait);

                if (data.test_souplesse.fait) {
                    test_souplesse_distance.value = data.test_souplesse.distance;
                    test_souplesse_commentaires.value = data.test_souplesse.commentaires;
                }
                showTest(test_souplesse_fait, test_souplesse_nonfait, test_souplesse_motif, data.test_souplesse.motif, data.test_souplesse.fait);

                if (data.test_mobilite.fait) {
                    test_mobilite_main_gauche.value = data.test_mobilite.main_gauche_haut;
                    test_mobilite_main_droite.value = data.test_mobilite.main_droite_haut;
                    test_mobilite_commentaires.value = data.test_mobilite.commentaires;
                }
                showTest(test_mobilite_fait, test_mobilite_nonfait, test_mobilite_motif, data.test_mobilite.motif, data.test_mobilite.fait);

                if (data.test_membre_inf.fait) {
                    test_membre_inf_nombre.value = data.test_membre_inf.nb_lever;
                    test_membre_inf_fc_30.value = data.test_membre_inf.fc30;
                    test_membre_inf_sat_30.value = data.test_membre_inf.sat30;
                    test_membre_inf_borg_30.value = data.test_membre_inf.borg30;
                    test_membre_inf_commentaires.value = data.test_membre_inf.commentaires;
                }
                showTest(test_membre_inf_fait, test_membre_inf_nonfait, test_membre_inf_motif, data.test_membre_inf.motif, data.test_membre_inf.fait);
            })
            .catch((error) => {
                console.error('Error recup eval:', error);
            });
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

    function setModalMode(mode) {
        if (mode === MODE.EVAL_SUIV) {
            //mode pour programmer la prochaine évaluation
            titre.textContent = "Prochaine évaluation";
            section_eval_suiv.style.display = "block";
            section_creneau.style.display = "none";
            enregistrer.style.display = "block";
        } else {
            //détails d'une évaluation
            titre.textContent = "Prochaine évaluation";
            section_eval_suiv.style.display = "none";
            section_creneau.style.display = "block";
            enregistrer.style.display = "none";
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

    return {
        init
    };
})();