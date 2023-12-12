"use strict";

const COLOR = {
    RED: 'red',
    GREEN: 'green',
    ORANGE: 'orange',
    GREY: 'grey'
};
Object.freeze(COLOR);

// Cette fonction permet la création du tableau trié
$(document).ready(function () {
    if (localStorage.getItem('role_user_ids') == null) {
        storage.init('Data/ReadSession.php').then(r => {
            initPage()
        });
    } else {
        initPage();
    }

    /**
     * Initialisation des éléments de la page
     */
    function initPage() {
        const roles_user = JSON.parse(localStorage.getItem('roles_user'));
        const table = $('#table_id');
        const radioTous = document.getElementById('tous');
        const radioSuivis = document.getElementById('suivis');

        if (radioTous != null && radioSuivis != null) {
            radioTous.addEventListener('click', function () {
                table.DataTable().destroy();
                tableauPatient.init();
            });
            radioSuivis.addEventListener('click', function () {
                table.DataTable().destroy();
                tableauPatient.init();
            });
        }

        // initialisation de la partie calendrier/séances
        if (document.getElementById('calendar')) {
            // choix de l'affichage par défaut selon l'utilisateur
            if (roles_user.includes(ROLE.INTERVENANT) && roles_user.length === 1) {
                calendrier.displayCalendrier();
            } else {
                calendrier.displayTableauBeneficiaires();
            }

            calendrier.init();
            modalSeance.init();
            modalDetailsSeance.init({
                urlUpdateSeance: '../PHP/Seances/UpdateSeance.php',
                urlRecupOneInfosSeance: '../PHP/Seances/RecupOneInfosSeance.php',
                urlReadListeParticipantsSeance: '../PHP/Seances/ReadListeParticipantsSeance.php',
            });
        }

        //mise en place des valeurs précédentes s'il y en avait
        if (localStorage.getItem('champ_tri') != null) {
            $('#champ_tri option[value="' + localStorage.getItem("champ_tri") + '"]').prop("selected", true);
        }
        if (localStorage.getItem('mot_cle') != null) {
            $('#mot_cle').val(localStorage.getItem("mot_cle"));
        }

        //fonctions pour enregistrer les valeurs à remettre lors du prochain chargement de la page
        $('#champ_tri').on('change', function () {
            localStorage.setItem('champ_tri', this.value);
        });
        $('#mot_cle').on('change', function () {
            localStorage.setItem('mot_cle', this.value);
        });

        // initialisation du tableau patient
        if (document.getElementById('table_id') != null) {
            tableauPatient.init();
        } else if (document.getElementById('table_patient') != null) {
            tableauPatientIntervenant.init();
        }
    }
});

let tableauPatient = (function () {
    const tbody = $('#table_id-body');
    const mot_cle = $('#mot_cle');
    const radioTous = document.getElementById("tous");
    const radioSuivis = document.getElementById("suivis");

    // parametres utilisateur
    // la valeur par défaut est 10
    let nombre_elements_tableaux;
    /**
     * le type du tableau actuel qui est un de:
     *  - "tableau-beneficiaires-archives"
     *  - "tableau-beneficiaires-non-archives"
     */
    const tableau_type = document.getElementById('main-div').getAttribute('data-archive');

    let roles_user;

    let dataTable;

    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    let init = async function () {
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;
        roles_user = JSON.parse(localStorage.getItem('roles_user'));

        let antennes = fetch('Antennes/ReadAllAntenne.php')
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .catch(() => null);

        let patients;

        if (tableau_type === "tableau-beneficiaires-archives" ||
            radioTous == null ||
            radioTous.checked) {
            patients = await fetch('Patients/ReadAll.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({"est_archive": tableau_type === "tableau-beneficiaires-archives"}),
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
        } else if (radioSuivis.checked) {
            patients = await fetch('Patients/ReadAllSuivi.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
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
        }

        let evaluateurs = fetch('Evaluateurs/ReadAllEvaluateur.php')
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .catch(() => null);

        // on remplit le tableau quand toutes les données ont été récupérés
        Promise.all([patients, antennes, evaluateurs])
            .then(result => remplirTableau(result[0], result[1], result[2]));
    }

    function remplirTableau(dataPatient, dataAntenne, dataEvaluateur) {
        tbody.empty();

        if (Array.isArray(dataPatient)) {
            $.each(dataPatient, function (index, value) {
                tbody.append(createLigne(index, value, dataEvaluateur, dataAntenne));
            });
        }

        // format des dates du tableau
        $.fn.dataTable.moment('DD/MM/YYYY');

        // initialisation de la Datatable
        dataTable = $('#table_id').DataTable({
            stateSave: true,
            paging: true,
            retrieve: true,
            scrollX: false,
            autoWidth: true,
            responsive: true,
            order: [
                [4, "desc"]
            ],

            language: {url: "../js/DataTables/media/French.json"},
            "pageLength": nombre_elements_tableaux,
            "fnDrawCallback": function () {
                $('.dataTables_filter input').attr("id", "sSearch");
                $('#sSearch').on('change', function () {
                    dataTable.state.save();
                });
                dataTable.state.loaded();
            }
        });


        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex, original, counter) {
                const id = $('#champ_tri option:selected').attr("id");
                const regex = /data-filter-name="(.*?)"/gm;
                let match = regex.exec(original[id]);

                let valueToFilter;
                if (match) {
                    valueToFilter = match[1].toUpperCase();
                } else {
                    valueToFilter = original[id].toUpperCase();
                }

                let filterValue = mot_cle.val().toUpperCase();

                return valueToFilter.indexOf(filterValue) != -1;
            }
        );

        mot_cle.on('keyup click', function () {
            dataTable.draw();
        });
    }

    /**
     * Création du logo alerte (évaluation) + ajout d'un logo s'il n'y a pas de prescription
     *
     * @param patient
     * @returns {HTMLTableCellElement}
     */
    function createTdAlerte(patient) {
        let color;
        if (patient.id_type_eval == null
            || patient.id_type_eval == 14
            || patient.a_termine_programme
            || patient.est_archive) {
            // si le patient a déja fait l'éval finale
            // ou qu'il n'a pas encore fait d'évaluation
            // ou s'il a terminé le programme
            color = COLOR.GREY;
        } else {
            let days;
            //s'il n'y a pas de date programmée pour la prochaine évaluation, on utilise l'intervalle
            if (patient.date_eval_suiv == null) {
                if (patient.intervalle === 6) {
                    days = 180;
                } else {
                    // valeur par défaut de 3 mois
                    days = 90;
                }
            }

            const date_eval = moment(patient.date_eval, 'YYYY-MM-DD');
            let date_rdv_suivant;
            if (patient.date_eval_suiv == null) {
                date_rdv_suivant = moment(date_eval.add(days, 'days'), 'YYYY-MM-DD');
            } else {
                date_rdv_suivant = moment(patient.date_eval_suiv, 'YYYY-MM-DD');
            }
            const today = moment();
            const diff = date_rdv_suivant.diff(today, 'days');

            if (diff < 0) {
                color = COLOR.RED;
            } else if (diff < 15) {
                color = COLOR.ORANGE;
            } else {
                color = COLOR.GREEN;
            }
        }

        let td1 = document.createElement('td');
        td1.className = "text-center";

        const div = document.createElement('div');
        div.setAttribute('style', 'display:none');

        const imgContainer = document.createElement('div');
        imgContainer.style.position = 'relative';
        imgContainer.style.top = '0';
        imgContainer.style.left = '0';
        imgContainer.className = "aInfobulle";

        const img = document.createElement('img');
        img.setAttribute('style', 'height:25px;width:auto');

        const span = document.createElement('span');

        let is_text_before = true; // si il y a un texte important

        if (color === COLOR.RED) {
            td1.setAttribute('bgcolor', '#F2A0A0');
            div.textContent = '1';
            img.src = '../images/AlerteRed.png';
            img.alt = 'Alerte Rouge';
            span.textContent = 'Date d\'évaluation dépassée';
        } else if (color === COLOR.ORANGE) {
            td1.setAttribute('bgcolor', '#F2CAA0');
            div.textContent = '2';
            img.src = '../images/AlerteOrange.png';
            img.alt = 'Alerte Orange';
            span.textContent = 'Date d\'évaluation dans moins de 15 jours';
        } else if (color === COLOR.GREEN) {
            td1.setAttribute('bgcolor', '#A5F2A0');
            div.textContent = '3';
            img.src = '../images/AlerteGreen.png';
            img.alt = 'Alerte Verte';
            span.textContent = 'Rien à signaler';
            is_text_before = false;
        } else {
            td1.setAttribute('bgcolor', '#D3D3D3');
            div.textContent = '4';
            img.src = '../images/AlerteGrey.png';
            img.alt = 'Alerte Grise';
            span.textContent = 'Pas d\'évaluation prévue';
        }

        imgContainer.append(span, img)
        td1.append(div, imgContainer);

        // affichage d'un logo si le patient n'a pas de prescription
        if (!patient.a_prescription) {
            const imgPrescription = document.createElement('img');
            imgPrescription.style.position = 'absolute';
            imgPrescription.style.top = '0';
            imgPrescription.style.left = '-3';
            imgPrescription.style.width = '20px';
            imgPrescription.src = '../images/prescription_icon.png';
            imgPrescription.alt = 'prescrition à faire';
            imgContainer.append(imgPrescription);

            if (is_text_before) {
                span.textContent += " et la prescription n'est pas enregistrée";
            } else {
                span.textContent = "La prescription n'est pas enregistrée";
            }
        }

        return td1;
    }

    function createLigne(index, patient, dataEvaluateur, dataAntenne) {
        let td1 = createTdAlerte(patient);

        let italique = document.createElement('i');

        let td2 = document.createElement('td');
        td2.className = "text-left clickable";
        if (patient.nom_patient == null || patient.nom_patient === "") {
            italique.textContent = 'INCONNU';
            td2.append(italique);
        } else {
            td2.textContent = patient.nom_patient;
        }

        let td3 = document.createElement('td');
        td3.className = "text-left clickable";
        if (patient.prenom_patient == null || patient.prenom_patient === "") {
            const li = italique.cloneNode();
            li.textContent = 'INCONNU';
            td3.append(li);
        } else {
            td3.textContent = patient.prenom_patient;
        }

        let td4 = document.createElement('td');
        td4.className = "text-left";

        if (tableau_type === "tableau-beneficiaires-archives") {
            if (patient.nom_antenne == null || patient.nom_antenne === "") {
                const li = italique.cloneNode();
                li.textContent = 'INCONNU';
                td4.append(li);
            } else {
                td4.textContent = patient.nom_antenne;
            }
        } else {
            if (roles_user.includes(ROLE.COORDONNATEUR_PEPS) ||
                roles_user.includes(ROLE.COORDONNATEUR_MSS) ||
                roles_user.includes(ROLE.COORDONNATEUR_NON_MSS) ||
                roles_user.includes(ROLE.EVALUATEUR)) {
                let dropdownDiv = document.createElement('div')
                dropdownDiv.className = 'dropdown';
                dropdownDiv.setAttribute('data-filter-name', patient.nom_antenne);

                let group = document.createElement('div')
                group.className = 'btn-group overflow-table-button';

                let button = document.createElement('button');
                button.className = "btn btn-default btn-sm dropdown-toggle";
                button.setAttribute('type', 'button');
                button.setAttribute('aria-haspopup', 'true');
                button.setAttribute('aria-expanded', 'false');
                button.setAttribute('data-toggle', 'dropdown');
                button.id = 'dropdown-antenne-' + patient.id_patient;

                button.textContent = patient.nom_antenne;

                const carret = document.createElement('span');
                carret.className = 'caret';
                button.append(carret);

                dropdownDiv.append(group);
                group.append(button, createAntenneDropdown(patient, dataAntenne));
                td4.append(dropdownDiv);
            } else {
                if (patient.nom_antenne == null || patient.nom_antenne === "") {
                    const li = italique.cloneNode();
                    li.textContent = 'INCONNU';
                    td4.append(li);
                } else {
                    td4.textContent = patient.nom_antenne;
                }
            }
        }

        let td5 = document.createElement('td');
        td5.className = "text-left";
        if (patient.date_admission == null) {
            const li = italique.cloneNode();
            li.textContent = 'INCONNU';
            td5.append(li);
        } else {
            td5.textContent = patient.date_admission;
        }

        let td5_archive = document.createElement('td');
        td5_archive.className = "text-left";
        if (patient.date_archivage == null) {
            const li = italique.cloneNode();
            li.textContent = 'INCONNUE';
            td5_archive.append(li);
        } else {
            td5_archive.textContent = patient.date_archivage;
        }

        let td8 = document.createElement('td');
        td8.className = "text-left";
        if (patient.prenom_medecin == null || patient.prenom_medecin === "" ||
            patient.nom_medecin == null || patient.nom_medecin === "") {
            const li = italique.cloneNode();
            li.textContent = 'INCONNU';
            td8.append(li);
        } else {
            td8.textContent = patient.prenom_medecin + " " + patient.nom_medecin;
        }

        let td9 = document.createElement('td');
        td9.className = "text-left";
        if (patient.nom_structure == null || patient.nom_structure === "") {
            const li = italique.cloneNode();
            li.textContent = 'INCONNUE';
            td9.append(li);
        } else {
            td9.textContent = patient.nom_structure;
        }
        td9.id = 'td9-' + patient.id_patient;

        let tr = document.createElement('tr');
        tr.setAttribute('data-column', index);
        tr.setAttribute('data-href', '../PHP/Patients/AccueilPatient.php?idPatient=' + patient.id_patient);
        tr.append(td1, td2, td3, td4, td5);
        if (tableau_type === "tableau-beneficiaires-archives") {
            tr.append(td5_archive);
        }
        tr.append(td8, td9);

        if (tableau_type === "tableau-beneficiaires-archives") {
            let td10 = document.createElement('td');
            td10.className = "text-left";
            td10.textContent = patient.nom_suivi + ' ' + patient.prenom_suivi;

            tr.append(td10);
        } else {
            if (roles_user.includes(ROLE.COORDONNATEUR_PEPS) ||
                roles_user.includes(ROLE.COORDONNATEUR_MSS) ||
                roles_user.includes(ROLE.COORDONNATEUR_NON_MSS) ||
                roles_user.includes(ROLE.EVALUATEUR) ||
                roles_user.includes(ROLE.SECRETAIRE)) {
                let td10 = document.createElement('td');
                td10.className = "text-left";

                let dropdownDiv = document.createElement('div')
                dropdownDiv.className = 'dropdown';
                dropdownDiv.setAttribute('data-filter-name', patient.nom_suivi + ' ' + patient.prenom_suivi + ' (' + patient.role_user_suivi + ') ');

                let group = document.createElement('div')
                group.className = 'btn-group overflow-table-button';

                let button = document.createElement('button');
                button.className = "btn btn-default btn-sm dropdown-toggle";
                if (roles_user.includes(ROLE.COORDONNATEUR_PEPS) ||
                    roles_user.includes(ROLE.COORDONNATEUR_MSS) ||
                    roles_user.includes(ROLE.SECRETAIRE)) {
                    button.setAttribute('type', 'button');
                    button.setAttribute('aria-haspopup', 'true');
                    button.setAttribute('aria-expanded', 'false');
                    button.setAttribute('data-toggle', 'dropdown');
                    button.id = 'dropdown-' + patient.id_patient;
                }
                button.textContent = patient.nom_suivi + ' ' + patient.prenom_suivi;

                const carret = document.createElement('span');
                carret.className = 'caret';
                button.append(carret);

                dropdownDiv.append(group);
                group.append(button, createEvaluateurDropdown(patient, dataEvaluateur));
                td10.append(dropdownDiv);

                tr.append(td10);
            }
        }

        const handleClickNom = function (event) {
            event.preventDefault();
            window.location.href = '../PHP/Patients/AccueilPatient.php?idPatient=' + patient.id_patient;
        }

        td2.onclick = handleClickNom;
        td3.onclick = handleClickNom;

        return tr;
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

    function createEvaluateurDropdown(patient, dataEvaluateur) {
        const ul = document.createElement('ul');
        ul.classList.add('dropdown-menu');
        ul.classList.add('dropdown-menu-right');
        ul.classList.add('scroll-list-15em');
        ul.setAttribute('aria-labelledby', 'dropdown-' + patient.id_patient);

        if (dataEvaluateur !== null && dataEvaluateur.length > 0) {
            const separator = document.createElement('li');
            separator.className = 'divider';
            separator.setAttribute('role', 'separator');

            const choix = document.createElement('li');
            choix.className = 'dropdown-header';
            choix.textContent = 'Changer l\'évaluateur';

            ul.append(choix, separator);
            for (const evaluateur of dataEvaluateur) {
                const evalItem = document.createElement('li');
                evalItem.innerHTML = '<a href="#">' + evaluateur.nom_evaluateur + ' ' + evaluateur.prenom_evaluateur + ' (' + evaluateur.structure_evaluateur + ') ' + '</a>';

                evalItem.onclick = function (event) {
                    event.preventDefault();

                    // Update dans la BDD
                    fetch('Patients/UpdatePatientEvaluateur.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            'id_patient': patient.id_patient,
                            'id_user': evaluateur.id_user,
                        }),
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw {
                                    statusCode: response.status,
                                };
                            }
                            return response.json();
                        })
                        .then(data => {
                            toast("L'évaluateur de " + patient.nom_patient + ' ' + patient.prenom_patient + ' a été modifié');
                            // maj du nom de la cellule du tableau
                            const button = document.getElementById('dropdown-' + patient.id_patient);
                            button.textContent = evaluateur.nom_evaluateur + ' ' + evaluateur.prenom_evaluateur;

                            button.parentNode.parentNode.setAttribute('data-filter-name', evaluateur.nom_evaluateur + ' ' + evaluateur.prenom_evaluateur);

                            const carret = document.createElement('span');
                            carret.className = 'caret';
                            button.append(carret);

                            dataTable.rows().invalidate();
                            //dataTable2.rows().invalidate();
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            toast("Echec de la modification");
                        });
                };

                ul.append(evalItem);
            }
        } else {
            const empty = document.createElement('li');
            empty.className = 'dropdown-header';
            empty.textContent = "Pas d'évaluateurs dans le territoire";

            ul.append(empty);
        }

        return ul;
    }

    function createAntenneDropdown(patient, dataAntenne) {
        const ul = document.createElement('ul');
        ul.classList.add('dropdown-menu');
        ul.classList.add('scroll-list-15em');
        ul.setAttribute('aria-labelledby', 'dropdown-' + patient.id_patient);

        if (dataAntenne !== null && dataAntenne.length > 0) {
            const separator = document.createElement('li');
            separator.className = 'divider';
            separator.setAttribute('role', 'separator');

            const choix = document.createElement('li');
            choix.className = 'dropdown-header';
            choix.textContent = 'Changer l\'antenne';

            ul.append(choix, separator);
            for (const antenne of dataAntenne) {
                const evalItem = document.createElement('li');
                evalItem.innerHTML = '<a href="#">' + antenne.nom_antenne + '</a>';

                evalItem.onclick = function (event) {
                    event.preventDefault();

                    // Update dans la BDD
                    fetch('Patients/UpdatePatientAntenne.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            'id_patient': patient.id_patient,
                            'id_antenne': antenne.id_antenne
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
                            toast("L'antenne de " + patient.nom_patient + ' ' + patient.prenom_patient + ' a été modifié');
                            // maj du nom de la cellule du tableau
                            const button = document.getElementById('dropdown-antenne-' + patient.id_patient);
                            button.textContent = antenne.nom_antenne;

                            button.parentNode.parentNode.setAttribute('data-filter-name', antenne.nom_antenne);

                            // maj de la structure
                            const td9 = document.getElementById('td9-' + patient.id_patient);
                            td9.textContent = data.nom_structure;

                            const carret = document.createElement('span');
                            carret.className = 'caret';
                            button.append(carret);

                            dataTable.rows().invalidate();
                            dataTable.rows().invalidate();
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            toast("Echec de la modification");
                        });
                };

                ul.append(evalItem);
            }
        } else {
            const empty = document.createElement('li');
            empty.className = 'dropdown-header';
            empty.textContent = "Pas d'antenne disponible dans le territoire";

            ul.append(empty);
        }

        return ul;
    }

    return {
        init
    };
})();

let tableauPatientIntervenant = (function () {
    const tbody = $('#table_patient-body');
    const mot_cle = $('#mot_cle');

    // parametres utilisateur
    // la valeur par défaut est 10
    let nombre_elements_tableaux;

    /** le type du tableau actuel qui est un de:
     *  - "tableau-beneficiaires-archives"
     *  - "tableau-beneficiaires-non-archives"
     */
    const tableau_type = document.getElementById('main-div').getAttribute('data-archive');

    let dataTable;

    let init = async function () {
        nombre_elements_tableaux = localStorage.getItem('nombre_elements_tableaux') ? parseInt(localStorage.getItem('nombre_elements_tableaux')) : 10;

        let patients = await fetch('Patients/ReadAll.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
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

        // on rempli le tableau quand toutes les données ont été récupérés
        Promise.all([patients])
            .then(result => remplirTableau(result[0]));
    }

    function remplirTableau(dataPatient) {
        tbody.empty();

        if (Array.isArray(dataPatient)) {
            $.each(dataPatient, function (index, value) {
                tbody.append(createLigne(index, value));
            });
        }

        // format des dates du tableau
        $.fn.dataTable.moment('DD/MM/YYYY');

        // initialisation de la Datatable
        dataTable = $('#table_patient').DataTable({
            paging: true,
            retrieve: true,
            scrollX: false,
            autoWidth: true,
            responsive: true,
            order: [
                [2, "desc"]
            ],

            language: {url: "../js/DataTables/media/French.json"},
            "pageLength": nombre_elements_tableaux
        });

        mot_cle.on('keyup click', function () {
            let id = $('#champ_tri option:selected').attr("id");

            dataTable.column(id).search(
                mot_cle.val()
            ).draw();
        });
    }

    function createLigne(index, patient) {
        let italique = document.createElement('i');

        let td1 = document.createElement('td');
        td1.className = "text-left clickable";
        if (patient.nom_patient == null || patient.nom_patient === "") {
            italique.textContent = 'INCONNU';
            td1.append(italique);
        } else {
            td1.textContent = patient.nom_patient;
        }

        let td2 = document.createElement('td');
        td2.className = "text-left clickable";
        if (patient.prenom_patient == null || patient.prenom_patient === "") {
            const li = italique.cloneNode();
            li.textContent = 'INCONNU';
            td2.append(li);
        } else {
            td2.textContent = patient.prenom_patient;
        }

        let td3 = document.createElement('td');
        td3.className = "text-left";
        if (patient.date_admission == null) {
            const li = italique.cloneNode();
            li.textContent = 'INCONNU';
            td3.append(li);
        } else {
            td3.textContent = patient.date_admission;
        }

        let td4 = document.createElement('td');
        td4.className = "text-left";
        if (patient.tel_fixe_patient == null || patient.tel_fixe_patient === "") {
            const li = italique.cloneNode();
            li.textContent = 'INCONNU';
            td4.append(li);
        } else {
            td4.textContent = patient.tel_fixe_patient;
        }

        let td5 = document.createElement('td');
        td5.className = "text-left";
        if (patient.tel_portable_patient == null || patient.tel_portable_patient === "") {
            const li = italique.cloneNode();
            li.textContent = 'INCONNU';
            td5.append(li);
        } else {
            td5.textContent = patient.tel_portable_patient;
        }

        let td6 = document.createElement('td');
        td6.className = "text-left";
        if (patient.mail_patient == null || patient.mail_patient === "") {
            const li = italique.cloneNode();
            li.textContent = 'INCONNU';
            td6.append(li);
        } else {
            let mailLink = document.createElement('a');
            mailLink.textContent = patient.mail_patient;
            mailLink.setAttribute("href", "mailto:" + patient.mail_patient);
            td6.append(mailLink);
        }

        let tr = document.createElement('tr');
        tr.setAttribute('data-column', index);
        tr.setAttribute('data-href', '../PHP/Patients/AccueilPatient.php?idPatient=' + patient.id_patient);
        tr.append(td1, td2, td3, td4, td5, td6);


        const handleClickNom = function (event) {
            event.preventDefault();
            window.location.href = '../PHP/Patients/AccueilPatient.php?idPatient=' + patient.id_patient;
        }

        td1.onclick = handleClickNom;
        td2.onclick = handleClickNom;

        return tr;
    }

    return {
        init
    };
})();

