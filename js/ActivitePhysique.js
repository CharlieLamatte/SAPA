"use strict";

/**
 * si un champ pathologie a été modifié sans être enregistré
 * @type {boolean}
 */
var g_activitePhysiqueModified = false;

$(document).ready(function () {
    // initialisation des élements de la page
    // activites.init();
    confirmExitPage.init();
    activitesPhysiques.init();
});

/**
 * Affichage d'un message de confirmation si on quitte la page et g_activitePhysiqueModified=true
 */
const confirmExitPage = (function () {
    function init() {
        window.onbeforeunload = function (event) {
            if (g_activitePhysiqueModified) {
                return "Quitter sans enregistrer les activité physiques?";
            } else {
                return null;
            }
        }
    }

    return {
        init
    };
})();

/**
 * Affichage du détails des pathologies sur la page
 */
const activitesPhysiques = (function () {
    // le modal
    const form = document.getElementById('form-activite-physique');

    // les champs texte
    const activite_anterieureTextarea = document.getElementById("activite_anterieure_textarea");
    const activite_physique_autonomeTextarea = document.getElementById("activite_physique_autonome_textarea");
    const activite_physique_encadreeTextarea = document.getElementById("activite_physique_encadree_textarea");
    const disponibiliteTextarea = document.getElementById("disponibilite_textarea");
    const activite_envisageeTextarea = document.getElementById("activite_envisagee_textarea");
    const frein_activiteTextarea = document.getElementById("frein_activite_textarea");
    const point_fort_levierTextarea = document.getElementById("point_fort_levier_textarea");

    const allFields = document.querySelectorAll('.field-activite-physique');

    // boutton qui permet d'enregistrer les modifications
    const modifyButton = document.getElementById('modifier-pathologie');

    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    const nomsActivitee = [
        "anterieure",
        "autonome",
        "encadree",
        "envisagee",
        "frein",
        "point-fort-levier",
    ];

    const jours = [
        "lundi",
        "mardi",
        "mercredi",
        "jeudi",
        "vendredi",
        "samedi",
        "dimanche",
    ];

    const init = function () {
        fetch('ActivitePhysique/ReadOneActivitePhysiquePatient.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_patient": form.getAttribute("data-id_patient")}),
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
                setDetails(data);
            })
            .catch(error => console.error(error));

        modifyButton.onclick = (event) => {
            const id_activite_physique = form.getAttribute("data-id_activite_physique");
            if (id_activite_physique != null && id_activite_physique !== '') {
                handleUpdate();
            } else {
                handleCreate();
            }
            g_activitePhysiqueModified = false;
        };

        nomsActivitee.forEach(nom => {
            form.elements['a-activite-' + nom]?.forEach(
                r => {
                    r.onclick = () => {
                        if (r.value === "0") {
                            document.getElementById('detail-' + nom + '-row').style.display = "none";
                        } else {
                            document.getElementById('detail-' + nom + '-row').style.display = "block";
                        }
                    }
                }
            )
        });

        jours.forEach(nom => {
            const checkbox = form.elements['jour-' + nom];
            if (checkbox) {
                checkbox.onclick = () => {
                    console.log(checkbox.checked);
                    if (checkbox.checked) {
                        document.getElementById('heures-' + nom + '-row').style.display = "block";
                    } else {
                        document.getElementById('heures-' + nom + '-row').style.display = "none";
                    }
                };
            }
        });

        allFields.forEach(
            field => field.addEventListener('input',
                () => g_activitePhysiqueModified = true)
        );
    };

    function handleUpdate() {
        const new_data = getFormData();

        fetch('ActivitePhysique/UpdateActivitePhysique.php', {
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
                toast("Activités physiques modifiées avec succès");

                const is_dispo_renseigne =
                    new_data.est_dispo_lundi === "1" ||
                    new_data.est_dispo_mardi === "1" ||
                    new_data.est_dispo_mercredi === "1" ||
                    new_data.est_dispo_jeudi === "1" ||
                    new_data.est_dispo_vendredi === "1" ||
                    new_data.est_dispo_samedi === "1" ||
                    new_data.est_dispo_dimanche === "1";

                if (new_data.disponibilite !== "" && is_dispo_renseigne) {
                    // cacher le champ texte des disponibilités si les disponibilités sont renseignées
                    setDisplay('detail-disponibilite-row', false);
                }
            })
            .catch(() => toast("Echec de la modification"));
    }

    function handleCreate() {
        // Update dans la BDD
        fetch('ActivitePhysique/CreateActivitePhysique.php', {
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
                toast("Activités physiques modifiées avec succès");
                setDetails(data);
            })
            .catch(() => toast("Echec de la modification"));
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

    function getFormData() {
        return {
            "id_user": localStorage.getItem('id_user'),
            "id_patient": form.getAttribute("data-id_patient"),
            "id_activite_physique": form.getAttribute("data-id_activite_physique"),
            "activite_physique_autonome": activite_physique_autonomeTextarea.value,
            "activite_physique_encadree": activite_physique_encadreeTextarea.value,
            "activite_anterieure": activite_anterieureTextarea.value,
            "disponibilite": disponibiliteTextarea.value,
            "frein_activite": frein_activiteTextarea.value,
            "activite_envisagee": activite_envisageeTextarea.value,
            "point_fort_levier": point_fort_levierTextarea.value,

            'a_activite_anterieure': form.elements['a-activite-anterieure'].value,
            'a_activite_autonome': form.elements['a-activite-autonome'].value,
            'a_activite_encadree': form.elements['a-activite-encadree'].value,
            'a_activite_envisagee': form.elements['a-activite-envisagee'].value,
            'a_activite_frein': form.elements['a-activite-frein'].value,
            'a_activite_point_fort_levier': form.elements['a-activite-point-fort-levier'].value,

            'est_dispo_lundi': form.elements['jour-lundi'].checked ? "1" : "0",
            'est_dispo_mardi': form.elements['jour-mardi'].checked ? "1" : "0",
            'est_dispo_mercredi': form.elements['jour-mercredi'].checked ? "1" : "0",
            'est_dispo_jeudi': form.elements['jour-jeudi'].checked ? "1" : "0",
            'est_dispo_vendredi': form.elements['jour-vendredi'].checked ? "1" : "0",
            'est_dispo_samedi': form.elements['jour-samedi'].checked ? "1" : "0",
            'est_dispo_dimanche': form.elements['jour-dimanche'].checked ? "1" : "0",

            'heure_debut_lundi': form.elements['heure-debut-lundi'].value,
            'heure_debut_mardi': form.elements['heure-debut-mardi'].value,
            'heure_debut_mercredi': form.elements['heure-debut-mercredi'].value,
            'heure_debut_jeudi': form.elements['heure-debut-jeudi'].value,
            'heure_debut_vendredi': form.elements['heure-debut-vendredi'].value,
            'heure_debut_samedi': form.elements['heure-debut-samedi'].value,
            'heure_debut_dimanche': form.elements['heure-debut-dimanche'].value,

            'heure_fin_lundi': form.elements['heure-fin-lundi'].value,
            'heure_fin_mardi': form.elements['heure-fin-mardi'].value,
            'heure_fin_mercredi': form.elements['heure-fin-mercredi'].value,
            'heure_fin_jeudi': form.elements['heure-fin-jeudi'].value,
            'heure_fin_vendredi': form.elements['heure-fin-vendredi'].value,
            'heure_fin_samedi': form.elements['heure-fin-samedi'].value,
            'heure_fin_dimanche': form.elements['heure-fin-dimanche'].value,
        };
    }

    function setDetails(pathologies) {
        form.setAttribute("data-id_activite_physique", pathologies.id_activite_physique);
        activite_anterieureTextarea.textContent = pathologies.activite_anterieure;
        activite_physique_autonomeTextarea.textContent = pathologies.activite_physique_autonome;
        activite_physique_encadreeTextarea.textContent = pathologies.activite_physique_encadree;
        disponibiliteTextarea.textContent = pathologies.disponibilite;
        activite_envisageeTextarea.textContent = pathologies.activite_envisagee;
        frein_activiteTextarea.textContent = pathologies.frein_activite;
        point_fort_levierTextarea.textContent = pathologies.point_fort_levier;

        form.elements['a-activite-anterieure'].value = pathologies.a_activite_anterieure;
        form.elements['a-activite-autonome'].value = pathologies.a_activite_autonome;
        form.elements['a-activite-encadree'].value = pathologies.a_activite_encadree;
        form.elements['a-activite-envisagee'].value = pathologies.a_activite_envisagee;
        form.elements['a-activite-frein'].value = pathologies.a_activite_frein;
        form.elements['a-activite-point-fort-levier'].value = pathologies.a_activite_point_fort_levier;

        setDisplay('detail-anterieure-row', form.elements['a-activite-anterieure'].value === "1");
        setDisplay('detail-autonome-row', form.elements['a-activite-autonome'].value === "1");
        setDisplay('detail-encadree-row', form.elements['a-activite-encadree'].value === "1");
        setDisplay('detail-envisagee-row', form.elements['a-activite-envisagee'].value === "1");
        setDisplay('detail-frein-row', form.elements['a-activite-frein'].value === "1");
        setDisplay('detail-point-fort-levier-row', form.elements['a-activite-point-fort-levier'].value === "1");

        form.elements['jour-lundi'].checked = pathologies.est_dispo_lundi == 1;
        form.elements['jour-mardi'].checked = pathologies.est_dispo_mardi == 1;
        form.elements['jour-mercredi'].checked = pathologies.est_dispo_mercredi == 1;
        form.elements['jour-jeudi'].checked = pathologies.est_dispo_jeudi == 1;
        form.elements['jour-vendredi'].checked = pathologies.est_dispo_vendredi == 1;
        form.elements['jour-samedi'].checked = pathologies.est_dispo_samedi == 1;
        form.elements['jour-dimanche'].checked = pathologies.est_dispo_dimanche == 1;

        form.elements['heure-debut-lundi'].value = pathologies.heure_debut_lundi ?? "1";
        form.elements['heure-debut-mardi'].value = pathologies.heure_debut_mardi ?? "1";
        form.elements['heure-debut-mercredi'].value = pathologies.heure_debut_mercredi ?? "1";
        form.elements['heure-debut-jeudi'].value = pathologies.heure_debut_jeudi ?? "1";
        form.elements['heure-debut-vendredi'].value = pathologies.heure_debut_vendredi ?? "1";
        form.elements['heure-debut-samedi'].value = pathologies.heure_debut_samedi ?? "1";
        form.elements['heure-debut-dimanche'].value = pathologies.heure_debut_dimanche ?? "1";

        form.elements['heure-fin-lundi'].value = pathologies.heure_fin_lundi ?? "1";
        form.elements['heure-fin-mardi'].value = pathologies.heure_fin_mardi ?? "1";
        form.elements['heure-fin-mercredi'].value = pathologies.heure_fin_mercredi ?? "1";
        form.elements['heure-fin-jeudi'].value = pathologies.heure_fin_jeudi ?? "1";
        form.elements['heure-fin-vendredi'].value = pathologies.heure_fin_vendredi ?? "1";
        form.elements['heure-fin-samedi'].value = pathologies.heure_fin_samedi ?? "1";
        form.elements['heure-fin-dimanche'].value = pathologies.heure_fin_dimanche ?? "1";

        setDisplay('heures-lundi-row', pathologies.est_dispo_lundi == 1);
        setDisplay('heures-mardi-row', pathologies.est_dispo_mardi == 1);
        setDisplay('heures-mercredi-row', pathologies.est_dispo_mercredi == 1);
        setDisplay('heures-jeudi-row', pathologies.est_dispo_jeudi == 1);
        setDisplay('heures-vendredi-row', pathologies.est_dispo_vendredi == 1);
        setDisplay('heures-samedi-row', pathologies.est_dispo_samedi == 1);
        setDisplay('heures-dimanche-row', pathologies.est_dispo_dimanche == 1);

        // affichage du champ texte des disponibilités si présent
        setDisplay('detail-disponibilite-row', pathologies.disponibilite != null && pathologies.disponibilite !== "");
    }

    /**
     *
     * @param id l'id de l'élement que l'on souhaite cacher/afficher
     * @param display si l'élement est affiché
     */
    function setDisplay(id, display) {
        if (display) {
            document.getElementById(id).style.display = "block";
        } else {
            document.getElementById(id).style.display = "none";
        }
    }

    return {
        init
    };
})();