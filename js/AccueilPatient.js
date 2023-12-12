"use strict";

const INS_MODAL_MODE = {
    RECHERCHE: "RECHERCHE",
    RESULTAT_OK: "RESULTAT_OK",
    RESULTAT_ERROR: "RESULTAT_ERROR",
};

$(document).ready(function () {
    // initialisation des élements de la page
    gestionPatient.init();
});

const gestionPatient = (function () {
    const deleteButton = document.getElementById("delete");
    const archiveButton = document.getElementById("archive");
    const rechercheInsButton = document.getElementById("recherche-ins");
    const suiviButton = document.getElementById("suivre");
    const partageButton = document.getElementById("partage");

    // modal
    const $warningModal = $("#warning");
    const $loaderModal = $("#loader-modal");

    // boutons du modal
    const confirmclosed = document.getElementById('confirmclosed');
    const refuseclosed = document.getElementById('refuseclosed');
    const warningText = document.getElementById('warning-text');

    //Partage de dossier
    const $modalPartage = $("#modal_partage");
    const modalPartageTitle = document.getElementById("modal-title-partage");

    const listing_coordos_peps = document.getElementById('listing_coordos_peps');
    const selectPartage = document.getElementById("champ_partage");
    const aucun_coordos_peps = document.getElementById('aucun_coordos_peps');

    const valider = document.getElementById("enregistrer-partage");

    //booléen vérifiant si le bénéficiaire est dans le même territoire que l'utilisateur
    //détermine si on affiche un warning puis redirige à l'accueil pour la fin de suivi
    const check_meme_territoire = document.getElementById('main-container').getAttribute('data-meme_territoire');

    // champs du patient
    const nomPatientInput = document.getElementById('nom-patient');
    const prenomPatientInput = document.getElementById('prenom-patient');
    const sexeInput = document.getElementById('sexe');
    const dateNaissanceInput = document.getElementById('dn');

    const matricule_insInput = document.getElementById('matricule_ins');
    const natureOidSelect = document.getElementById('nature-oid');
    const code_insee_naissanceInput = document.getElementById('code_insee_naissance');
    const liste_prenom_naissanceInput = document.getElementById('liste_prenom_naissance');
    const statut_confianceSelect = document.getElementById('statut_confiance');
    const type_piece_identiteSelect = document.getElementById('type_piece_identite');

    const mainContainer = document.getElementById('main-container');
    const insSection = document.getElementById('ins-section');
    const rechercheInsRow = document.getElementById('recherche-ins-row');

    const insCloseButton = document.getElementById("ins-close");

    const rechercheInsTitle = document.getElementById("recherche-ins-title");
    const loadingSection = document.getElementById("loading-section");
    const okResultSection = document.getElementById("ok-result-section");
    const errorResultSection = document.getElementById("error-result-section");

    const okResultTxt = document.getElementById("ok-result-txt");
    const errorResultTxt = document.getElementById("error-result-txt");

    const insModalFooter = document.getElementById("ins-modal-footer");

    // toast div
    const toastDiv = document.getElementById("toast");

    function init() {
        // suppression d'un patient
        if (deleteButton) {
            deleteButton.onclick = (event) => {
                event.preventDefault();
                $warningModal.modal('show');
                warningText.textContent = 'Supprimer le patient?';

                getConfirmation().then(is_delete => {
                    $warningModal.modal('hide');
                    const id_patient = mainContainer.getAttribute("data-id_patient");

                    if (is_delete) {
                        // Update dans la BDD
                        fetch('DeletePatient.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({"id_patient": id_patient}),
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
                                toast("Patient supprimé avec succès.");
                                window.location.href = '../Accueil_liste.php';
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                toast("Echec de la suppression");
                            });
                    }
                });
            }
        }

        // archivage d'un patient
        if (archiveButton) {
            archiveButton.onclick = (event) => {
                event.preventDefault();

                // valeur actuelle
                const archive_value = archiveButton.getAttribute("data-value");
                const current_archive_status = archive_value === "1";

                setPatientArchive(current_archive_status);

                $warningModal.modal('show');

                getConfirmation().then(ok => {
                    $warningModal.modal('hide');

                    if (ok) {
                        const id_patient = mainContainer.getAttribute("data-id_patient");
                        const new_archive_status = archive_value === "0"; // nouvelle valeur
                        const data = {
                            "id_patient": id_patient,
                            "is_archived": new_archive_status
                        };

                        // Update dans la BDD
                        fetch('UpdatePatientArchiveStatus.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(data),
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
                                setPatientArchive(new_archive_status);
                                if (archive_value === "1") {
                                    toast("Patient restauré avec succès.");
                                    if (suiviButton) {
                                        suiviButton.style.display = "inline";
                                    }
                                    if (partageButton) {
                                        partageButton.style.display = "inline";
                                    }
                                } else {
                                    toast("Patient archivé avec succès.");
                                    if (suiviButton) {
                                        suiviButton.innerHTML = "Suivre ce bénéficiaire";
                                        suiviButton.setAttribute("data-value", "0");
                                        suiviButton.style.display = "none"
                                    }
                                    if (partageButton) {
                                        partageButton.style.display = "none";
                                    }
                                }
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                toast("Echec de l'archivage");
                            });
                    }
                });
            }
        }

        // recherche INS
        if (rechercheInsButton) {
            insCloseButton.onclick = (event) => {
                event.preventDefault();
                $loaderModal.modal('hide');
            }

            rechercheInsButton.onclick = (event) => {
                event.preventDefault();
                setInsModalMode(INS_MODAL_MODE.RECHERCHE);

                if (checkTraitsIdentites()) {
                    $warningModal.modal('show');
                    warningText.textContent = 'Faire appel au téléservice pour récupérer l’INS?';

                    getConfirmation().then(ok => {
                        $warningModal.modal('hide');

                        if (ok) {
                            $loaderModal.modal('show');
                            const id_patient = mainContainer.getAttribute("data-id_patient");

                            fetch('../INS/tls_ins.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    "type_appel": "find_ins",
                                    "id_patient": id_patient,
                                }),
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw {
                                            statusCode: response.status,
                                        };
                                    }
                                    return response.json()
                                })
                                .then((data) => {
                                    if (data.success) {
                                        setPatientInputs(data.patient);
                                        setInsModalMode(INS_MODAL_MODE.RESULTAT_OK, data.message);
                                    } else {
                                        setInsModalMode(INS_MODAL_MODE.RESULTAT_ERROR, data.message);
                                    }
                                })
                                .catch((error) => {
                                    console.error('Error:', error);
                                    setInsModalMode(
                                        INS_MODAL_MODE.RESULTAT_ERROR,
                                        "Erreur: Le téléservice INSi n'est actuellement pas disponible");
                                })
                                .finally(() => handleStatut_confianceSelectChange());
                        }
                    });
                } else {
                    alert("Il manque un des traits d'identité obligatoire");
                }
            }
        }

        // changement de la pièce d'identité de vérification
        type_piece_identiteSelect.onchange = (event) => {
            event.preventDefault();

            // si ce n'est pas "Aucun"
            if (type_piece_identiteSelect.value != "1") {
                console.log("value", type_piece_identiteSelect.value);
                const id_patient = mainContainer.getAttribute("data-id_patient");

                // Update du statut de confiance de l'identité
                fetch('VerifyIdentity.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        "id_patient": id_patient,
                        "id_type_piece_identite": type_piece_identiteSelect.value,
                    }),
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
                        statut_confianceSelect.value = data.id_type_statut_identite;
                        type_piece_identiteSelect.setAttribute("disabled", "")
                        toast("Le statut de l’identité est passé à « qualifiée ».");
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        toast("Une erreur s'est produite");
                    })
                    .finally(() => handleStatut_confianceSelectChange());
            }
        }

        handleStatut_confianceSelectChange();
    }

    function checkTraitsIdentites() {
        return dateNaissanceInput.getAttribute("data-raw-value") !== ""
            && sexeInput.getAttribute("data-raw-value") !== ""
            && nomPatientInput.value !== ""
            && prenomPatientInput.value !== "";
    }

    function handleStatut_confianceSelectChange() {
        statut_confianceSelect.style.color = statut_confianceSelect.options[statut_confianceSelect.selectedIndex].style.color;
        statut_confianceSelect.style.backgroundColor = statut_confianceSelect.options[statut_confianceSelect.selectedIndex].style.backgroundColor;
    }

    function setPatientInputs(patient) {
        matricule_insInput.value = patient.matricule_ins;
        natureOidSelect.value = patient.nature_oid;
        code_insee_naissanceInput.value = patient.code_insee_naissance ?? "";
        liste_prenom_naissanceInput.value = patient.liste_prenom_naissance ?? "";
        statut_confianceSelect.value = patient.id_type_statut_identite;
        let sexeText = "Indéterminé";
        if (patient.sexe_patient === "F") {
            sexeText = "Femme";
        } else if (patient.sexe_patient === "M") {
            sexeText = "Homme";
        }
        sexeInput.value = sexeText;
        sexeInput.setAttribute("data-raw-value", patient.sexe_patient);

        nomPatientInput.value = patient.nom_naissance;
        prenomPatientInput.value = patient.premier_prenom_naissance;

        insSection.style.display = "inline";
        rechercheInsRow.remove();
    }

    function setInsModalMode(mode, message = "") {
        if (mode === INS_MODAL_MODE.RECHERCHE) {
            rechercheInsTitle.textContent = "Appel au téléservice INSi en cours";
            loadingSection.hidden = false;
            okResultSection.hidden = true;
            errorResultSection.hidden = true;
            insModalFooter.hidden = true;
        } else if (mode === INS_MODAL_MODE.RESULTAT_OK) {
            rechercheInsTitle.textContent = "Résultat";
            okResultTxt.textContent = message;
            loadingSection.hidden = true;
            okResultSection.hidden = false;
            errorResultSection.hidden = true;
            insModalFooter.hidden = false;
        } else if (mode === INS_MODAL_MODE.RESULTAT_ERROR) {
            rechercheInsTitle.textContent = "Résultat";
            errorResultTxt.textContent = message;
            loadingSection.hidden = true;
            okResultSection.hidden = true;
            errorResultSection.hidden = false;
            insModalFooter.hidden = false;
        }
    }

    if (suiviButton) {
        if (archiveButton.getAttribute("data-value") === "1") {
            suiviButton.style.display = "none";
        }
        const id_patient = suiviButton.getAttribute("data-id_patient");
        suiviButton.onclick = (event) => {
            const suivi_value = suiviButton.getAttribute("data-value");
            if (suivi_value === "0") {
                event.preventDefault();

                // Update dans la BDD
                fetch('SuivreDossier.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({"id_patient": id_patient}),
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
                        suiviButton.innerHTML = "Ne plus suivre ce bénéficiaire";
                        suiviButton.setAttribute("data-value", "1");
                        toast("Suivi du dossier confirmé");
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        toast("Échec du suivi du dossier");
                    });
            } else if (suivi_value === "1") {
                event.preventDefault();

                if (check_meme_territoire === "0") {
                    //cet utilisateur va perdre l'accès au dossier, donc on le prévient de la conséquence de l'opération
                    warningText.textContent = "Vous allez perdre l'accès à ce dossier et être redirigé vers la page d'accueil. " +
                        "Voulez-vous continuer cette opération ?";
                    $warningModal.modal('show');

                    getConfirmation().then(ok => {
                        $warningModal.modal('hide');

                        if (ok) {
                            //fin de suivi et redirection
                            plusSuivreBeneficiaire(id_patient);
                        }
                    });
                } else {
                    //ce bénéficiaire fait partie de sa file active, donc pas besoin de warning (ni de redirection)
                    plusSuivreBeneficiaire(id_patient);
                }
            }
        }
    }

    if (partageButton) {
        if (archiveButton.getAttribute("data-value") === "1") {
            partageButton.style.display = "none";
        }
        partageButton.onclick = function () {
            const id_patient = partageButton.getAttribute("data-id_patient");
            displayModalPartage(id_patient);
            modalPartageTitle.textContent = "Partage de dossier";
            $modalPartage.modal('show');
            if (selectPartage) {
                valider.style.display = "inline";
                valider.onclick = (event) => {
                    event.preventDefault();
                    const id_patient = partageButton.getAttribute("data-id_patient");
                    partageDossier(id_patient);
                    $modalPartage.modal('hide');
                }
            } else {
                //On n'affiche pas le bouton de validation car il n'y a aucun coordonnateur PEPS avec qui partager le dossier
                valider.style.display = "none";
            }


        }
    }

    function plusSuivreBeneficiaire(id_patient) {
        fetch('PlusSuivreDossier.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_patient": id_patient}),
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
                if (check_meme_territoire === "1") {
                    //le bénéficiaire fait partie de la file active = pas de redirection
                    toast("Fin du suivi confirmé");
                    suiviButton.innerHTML = "Suivre ce bénéficiaire";
                    suiviButton.setAttribute("data-value", "0");
                } else {
                    //le bénéficiaire n'est pas dans la file active = redirection à l'accueil
                    window.location.href = '../Accueil_liste.php';
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                toast("Échec de la fin de suivi");
            });
    }

    function displayModalPartage(id_patient) {
        fetch('../Users/ReadAutresCoordoPEPSRegion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_patient": id_patient}),
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
                if (data.length < 1) {
                    listing_coordos_peps.style.display = "none";
                    aucun_coordos_peps.style.display = "block";
                } else {
                    selectPartage.innerHTML = null;
                    listing_coordos_peps.style.display = "block";
                    aucun_coordos_peps.style.display = "none";
                    data.forEach(function (item) {
                        const opt = document.createElement("option");
                        opt.value = item['id_user'];
                        opt.innerHTML = item['nom_coordo_peps'] + " " + item['prenom_coordo_peps'] + " (" + item['territoire_coordo_peps'] + ")";
                        selectPartage.append(opt);
                    });
                }
            })
            .catch((error) => {
                console.log('Error:', error);
                toast("Échec de l'affichage de la modale");
            });
    }

    function partageDossier(id_patient) {
        fetch('PartageDossier.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({"id_patient": id_patient, "id_user": selectPartage.value}),
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
                toast("Partage du dossier réussi");
            })
            .catch((error) => {
                console.error('Error:', error);
                toast("Échec du partage");
            });
    }

    function setPatientArchive(est_archive) {
        if (est_archive) {
            archiveButton.setAttribute("data-value", "1");
            warningText.textContent = 'Restaurer le patient? (Il sera de nouveau visible dans la liste des patients)';
            archiveButton.textContent = "Restaurer le patient";
        } else {
            archiveButton.setAttribute("data-value", "0");
            warningText.textContent = 'Archiver le patient? (Il ne sera plus visible dans la liste des patients)';
            archiveButton.textContent = "Archiver le patient";
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
    }
})();