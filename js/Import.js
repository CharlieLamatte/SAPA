"use strict";

const form = document.getElementById('form');
const login = document.getElementById('login');
const pw = document.getElementById('pw');

$(document).ready(function () {
    // initialisation des élements de la page
    importStructures.init();
    importIntervenants.init();
    importCreneaux.init();
    affichageListeDiplome.init();
});

let importStructures = function () {
    const importStructuresButton = document.getElementById('import-structures');

    let init = function () {
        importStructuresButton.onclick = function () {
            console.log('importStructureButton click');
            const loginstring = login.value + ':' + pw.value;

            form.onsubmit = async function (event) {
                event.preventDefault();

                const headers = new Headers();
                headers.append('Authorization', 'Basic ' + btoa(loginstring));
                headers.append('Content-Type', 'application/ld+json');
                fetch('https://referencement.peps-na.fr/api/structures', {
                    method: 'GET',
                    dataType: "jsonp",
                    headers: headers
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
                        console.log('Success:', data);
                        //const light = [data['hydra:member'][0], data['hydra:member'][2], data['hydra:member'][3], data['hydra:member'][4]];

                        convertData(data['hydra:member']).then(d => {
                            console.log('d:', d);
                            insertStructures(d);
                        });
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            };

        };
    }

    /**
     * Convertion des données au format qui peut être inséré dans la BDD
     */
    function convertData(data) {
        return new Promise((resolve => {
            let promises = [];
            for (const elem of data) {
                //recupère les détails de la structure
                const loginstring = login.value + ':' + pw.value;
                const headers = new Headers();
                headers.append('Authorization', 'Basic ' + btoa(loginstring));

                promises.push(fetch('https://referencement.peps-na.fr/api/structures/' + elem.parent, {
                    method: 'GET',
                    headers: headers
                }).then(response => {
                    if (!response.ok) {
                        throw {
                            statusCode: response.status,
                        };
                    }
                    return response.json()
                }).catch(() => null));
            }

            Promise.all(promises)
                .then(structures => {
                    const new_data = [];
                    for (const structure of structures) {
                        if (structure != null && structure.status === 'approved') {
                            console.log("Fetched: " + structure.name);
                            console.log("Détail structure: " + structure);
                            const converted_structure = {
                                "id_structure": '',
                                "id_api": structure['@id'],
                                "nom_structure": structure.name,
                                "id_statut_structure": '3', // le statut par défaut est 'Structure Sportive'
                                "nom_statut_structure": '',
                                "nom_adresse": structure.streetnum + ' ' + structure.street,
                                "complement_adresse": '',
                                "code_postal": structure.zipcode,
                                "nom_ville": structure.city.trim(),
                                "id_territoire": null, // la recupération du territoire est fait lors de la creation ds la BDD
                                "intervenants": [],
                                "nom_representant": structure.contactlastname,
                                "prenom_representant": structure.contactfirstname,
                                "tel_fixe": structure.contactphone != null ? structure.contactphone.replace(/\s/g, '').replace(/\D/g, '').replace(/^33/i, '0') : '', // on enleve les espaces et la charactères non numériques
                                "tel_portable": '',
                                "email": structure.contactemail,
                                "id_statut_juridique": '14', // la structure est mise par défaut en Association
                                "code_onaps": '',
                                "antennes": []
                            };

                            new_data.push(converted_structure);
                        }
                    }

                    resolve(new_data);
                })
                .catch(function handleError(error) {
                    console.log("Error" + error);
                    resolve(null);
                });
        }));
    }

    async function insertStructures(structures) {
        const structures_not_inserted = [];
        if (Array.isArray(structures) && structures.length > 0) {
            for (const structure of structures) {
                console.log(`Queueing ${structure.nom_structure}`);
                const result = await insertOneStructure(structure);
                console.log(result);
                if (result.includes('Error')) {
                    structures_not_inserted.push(result);
                }
            }
        }

        console.log('Les ' + structures_not_inserted.length + ' erreurs: ');
        structures_not_inserted.forEach(val => console.log(val));
    }

    function insertOneStructure(structure) {
        console.log(structure);
        return fetch('../Structures/CreateStructure.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(structure),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .then(data => 'Success: structure ' + structure.nom_structure)
            .catch((error) => 'Error: structure ' + structure.nom_structure);
    }

    return {
        init
    };
}();

const importIntervenants = function () {
    const importIntervenantsButton = document.getElementById('import-intervenants');

    let init = function () {
        importIntervenantsButton.onclick = function () {
            console.log('importIntervenantsButton click');

            form.onsubmit = async function (event) {
                event.preventDefault();
                const loginstring = login.value + ':' + pw.value;

                const headers = new Headers();
                headers.append('Authorization', 'Basic ' + btoa(loginstring));
                headers.append('Content-Type', 'application/ld+json');
                let structures = await fetch('https://referencement.peps-na.fr/api/structures', {
                    method: 'GET',
                    headers: headers
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

                let structures_id = fetch('ReadStructureId.php')
                    .then(response => {
                        if (!response.ok) {
                            throw {
                                statusCode: response.status,
                            };
                        }
                        return response.json()
                    })
                    .catch(() => null);

                Promise.all([structures, structures_id])
                    .then(result => {
                        console.log('result[0]:', result[0]);
                        console.log('result[1]', result[1]);
                        getCoachesFromStructure(result[0]['hydra:member'], result[1]).then(coaches => {
                            console.log('getCoachesFromStructure done! coachesSet:', coaches);
                            insertIntervenants(coaches);
                        })
                    });
            }
        };
    };

    /**
     * Recupération de tous les intervenants
     */
    function getCoachesFromStructure(structures, structures_id) {
        return new Promise((resolve => {
            let promises = [];
            for (const elem of structures) {
                if (elem != null) {
                    //if (structures_id.includes('/api/structures/' + elem.parent)) {
                    console.log('elem[\'@id\']', '/api/structures/' + elem.parent);
                    //recupère les détails de la structure
                    const loginstring = login.value + ':' + pw.value;
                    const headers = new Headers();
                    headers.append('Authorization', 'Basic ' + btoa(loginstring));

                    promises.push(fetch('https://referencement.peps-na.fr/api/structures/' + elem.parent, {
                        method: 'GET',
                        headers: headers
                    }).then(response => {
                        if (!response.ok) {
                            throw {
                                statusCode: response.status,
                            };
                        }
                        return response.json()
                    }).catch(() => null));
                }
            }

            Promise.all(promises)
                .then(structures => {
                    const intervenantsSet = new Set();
                    for (const structure of structures) {
                        if (structure != null) {
                            console.log("Fetched: " + structure.name);
                            console.log("Détail coach: " + structure);
                            if (Array.isArray(structure.coaches)) {
                                for (const coach of structure.coaches) {
                                    intervenantsSet.add(coach);
                                }
                            }
                        }
                    }

                    resolve(getDetailsIntervenant(Array.from(intervenantsSet)));
                })
                .catch(function handleError(error) {
                    console.log("Error" + error);
                    resolve(null);
                });
        }));
    }

    function getDetailsIntervenant(data) {
        return new Promise((resolve => {
            let promises = [];
            for (const elem of data) {
                //recupère les détails de l'intervenant
                const loginstring = login.value + ':' + pw.value;
                const headers = new Headers();
                headers.append('Authorization', 'Basic ' + btoa(loginstring));

                promises.push(fetch('https://referencement.peps-na.fr/api/coaches/' + elem.id, {
                    method: 'GET',
                    headers: headers
                }).then(response => {
                    if (!response.ok) {
                        throw {
                            statusCode: response.status,
                        };
                    }
                    return response.json()
                }));
            }

            Promise.all(promises)
                .then(coaches => {
                    const new_data = [];
                    for (const coach of coaches) {
                        console.log("Fetched: " + coaches);
                        new_data.push(coach);
                    }

                    resolve(new_data);
                })
                .catch(function handleError(error) {
                    console.log("Error" + error);
                    resolve(null);
                });
        }));
    }

    function convertIntervenant(intervenant) {
        const diplomesSet = new Set();
        const degrees = JSON.parse(intervenant.degree);

        if (Array.isArray(degrees)) {
            for (const d of degrees) {
                for (const nom in d) {
                    diplomesSet.add(nom);
                }
            }
        }
        const diplomesArray = Array.from(diplomesSet);

        return {
            "id_intervenant": null,
            "id_api": intervenant['@id'],
            "id_api_structure": intervenant.structure,
            "nom_intervenant": intervenant.lastname,
            "prenom_intervenant": intervenant.firstname,
            "numero_carte": intervenant.pronumber != null ? intervenant.pronumber.replace(/\s/g, '') : '', // on enlève les espace du numéro de la carte
            "mail_intervenant": '',
            "tel_fixe_intervenant": '',
            "tel_portable_intervenant": '',
            "id_statut_intervenant": isIntervenantSalarie(intervenant) ? '3' : '1', // si l'intervenant n'est pas salarié, il est bénévole
            "id_territoire": '1',
            "id_diplome": diplomesArray.length > 0 ? idDiplomeFromName(diplomesArray[0]) : '1',
            "structures": []
        };
    }

    function isIntervenantSalarie(intervenant) {
        return intervenant.pronumber != null && /\d/.test(intervenant.pronumber) && intervenant.pronumber.length > 0;
    }

    function idDiplomeFromName(name) {
        switch (name) {
            case 'Autre CQP':
                return '1';
            case 'Autre BPJEPS':
                return '2';
            case 'Formation fédérale':
                return '3';
            case 'Licence STAPS APA':
                return '4';
            case 'BPJEPS AF':
                return '5';
            case 'Master STAPS APA':
                return '6';
            case 'Autre licence STAPS':
                return '7';
            case 'BPJEPS APT':
                return '8';
            case 'Formation Spécifique Sport Santé':
                return '9';
            case 'Formation spécifique Sport Santé HORS région NA (SSBE, SSBE niveau 1...)':
                return '10';
            case 'Kinésithérapeute':
                return '11';
            case 'CS AMAP':
                return '12';
            case 'Autre formation d’encadrement sportif':
                return '13';
            case 'Formation Validante à l\'ETP (40h)':
                return '14';
            case 'Formation Spécifique Sport Santé région NA (SSBE, SSBE niveau 1 )':
                return '15';
            default:
                return '1';
        }
    }

    async function insertIntervenants(intervenants) {
        const intervenants_not_inserted = [];
        if (Array.isArray(intervenants) && intervenants.length > 0) {
            for (const intervenant of intervenants) {
                console.log(`Queueing ${intervenant.firstname} ${intervenant.lastname}`);
                const result = await insertOneIntervenant(convertIntervenant(intervenant));
                console.log(result);
                if (result.includes('Echec')) {
                    intervenants_not_inserted.push(result);
                }
            }
        }

        console.log('Les ' + intervenants_not_inserted.length + ' erreurs: ');
        intervenants_not_inserted.forEach(val => console.log(val));
    }

    function insertOneIntervenant(intervenant) {
        console.log(intervenant);
        return fetch('../Intervenants/EnregistrerIntervenant.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(intervenant),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .then(data => 'Success: intervenant ' + intervenant.prenom_intervenant + ' ' + intervenant.nom_intervenant)
            .catch((error) => 'Echec: intervenant ' + intervenant.prenom_intervenant + ' ' + intervenant.nom_intervenant);
    }

    return {
        init
    };
}();

const importCreneaux = function () {
    const importCreneauxButton = document.getElementById('import-creneaux');

    let init = function () {
        importCreneauxButton.onclick = function () {
            console.log('importCreneauxButton click');

            form.onsubmit = async function (event) {
                event.preventDefault();
                const loginstring = login.value + ':' + pw.value;

                const headers = new Headers();
                headers.append('Authorization', 'Basic ' + btoa(loginstring));
                headers.append('Content-Type', 'application/ld+json');
                let structures = await fetch('https://referencement.peps-na.fr/api/structures', {
                    method: 'GET',
                    headers: headers
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

                let structures_id = fetch('ReadStructureId.php')
                    .then(response => {
                        if (!response.ok) {
                            throw {
                                statusCode: response.status,
                            };
                        }
                        return response.json()
                    })
                    .catch(() => null);

                Promise.all([structures, structures_id])
                    .then(result => {
                        console.log('result[0]:', result[0]);
                        console.log('result[1]', result[1]);
                        getActivitiesFromStructure(result[0]['hydra:member'], result[1]).then(activities => {
                            console.log('getActivitiesFromStructure done! activities:', activities);
                            insertCreneau(activities);
                        })
                    });
            }
        };
    };

    async function insertCreneau(activities) {
        const activities_not_inserted = [];
        for (const activity of activities) {
            if (isActivityValid(activity)) {
                const creneaux = convertCreneau(activity);
                console.log('isActivityValid true');
                for (const creneau of creneaux) {
                    // console.log('inserting creneau', creneau);
                    // insertOneCreneau(creneau);

                    const result = await insertOneCreneau(creneau);
                    console.log(result);
                    if (result.includes('Echec')) {
                        activities_not_inserted.push(result);
                    }
                }
            }
        }

        console.log('Les ' + activities_not_inserted.length + ' erreurs: ');
        activities_not_inserted.forEach(val => console.log(val));
    }

    function insertOneCreneau(creneau) {
        return fetch('../Creneaux/CreateCreneau.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(creneau),
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .then(data => 'Success: creneau ' + creneau.nom_creneau)
            .catch((error) => 'Echec: creneau ' + creneau.nom_creneau);
    }

    /**
     * Recupération du détail de tous les créneaux pour qui leur structure est déja dans la BDD
     */
    function getActivitiesFromStructure(structures, structures_id) {
        return new Promise((resolve => {
            let promises = [];
            for (const elem of structures) {
                //if (structures_id.includes('/api/structures/' + elem.parent)) {
                console.log('elem[\'@id\']', '/api/structures/' + elem.parent);
                //recupère les détails de la structure
                const loginstring = login.value + ':' + pw.value;
                const headers = new Headers();
                headers.append('Authorization', 'Basic ' + btoa(loginstring));

                promises.push(fetch('https://referencement.peps-na.fr/api/structures/' + elem.parent, {
                    method: 'GET',
                    headers: headers
                }).then(response => {
                    if (!response.ok) {
                        throw {
                            statusCode: response.status,
                        };
                    }
                    return response.json()
                }).catch(() => null));
                //}
            }

            Promise.all(promises)
                .then(structures => {
                    const creneauxSet = new Set();
                    for (const structure of structures) {
                        if (structure != null) {
                            console.log("Fetched: " + structure);
                            if (Array.isArray(structure.activities)) {
                                for (const activity of structure.activities) {
                                    creneauxSet.add(activity);
                                }
                            }
                        }
                    }

                    resolve(getDetailsActivities(Array.from(creneauxSet)));
                })
                .catch(function handleError(error) {
                    console.log("Error" + error);
                    resolve(null);
                });
        }));
    }

    function getDetailsActivities(data) {
        return new Promise((resolve => {
            let promises = [];
            for (const elem of data) {
                //recupère les détails du creneau
                const loginstring = login.value + ':' + pw.value;
                const headers = new Headers();
                headers.append('Authorization', 'Basic ' + btoa(loginstring));

                promises.push(fetch('https://referencement.peps-na.fr/api/activities/' + elem.id, {
                    method: 'GET',
                    headers: headers
                }).then(response => {
                    if (!response.ok) {
                        throw {
                            statusCode: response.status,
                        };
                    }
                    return response.json()
                }));
            }

            Promise.all(promises)
                .then(creneaux => {
                    const new_data = [];
                    for (const creneau of creneaux) {
                        console.log("Fetched: " + creneaux);
                        new_data.push(creneau);
                    }

                    resolve(new_data);
                })
                .catch(function handleError(error) {
                    console.log("Error" + error);
                    resolve(null);
                });
        }));
    }

    /**
     * Return une liste des créneaux à partir d'une activity
     */
    function convertCreneau(activity) {
        const creneaux = [];

        let description = activity.hours;
        description += activity.details == null ? '.' : '. ' + activity.details

        const commun = {
            "id_creneau": '',
            "id_api": activity['@id'],
            "nom_creneau": activity.name,
            "type_creneau": idTypeCreneau(activity.program),
            "nom_type_creneau": '',
            "jour": '-1', // valeur sentinelle
            //"nom_jour": '',
            "heure_debut": '1',
            "nom_heure_debut": '',
            "heure_fin": '1',
            "nom_heure_fin": '',
            //"nom_structure": '',
            "activites": '1',
            "id_structure": '',
            "id_api_structure": activity.structure,
            "nb_participant": '',
            "public_vise": '',
            "tarif": activity.fee.replace(/\s/g, '').replace(/\D/g, ''), // on enleve les espaces et la charactères non numériques,
            "paiement": '',
            "id_intervenant": '',
            "id_api_intervenant": idIntervenantApi(activity.coaches),
            "nom_prenom_intervenant": '',
            "nom_adresse": activity.address == null ? 'Non renseigné' : activity.address,
            "complement_adresse": '',
            "code_postal": activity.zipcode,
            "nom_ville": activity.city,
            "pathologie": pathologieArrayToString(JSON.parse(activity.pathologies)),
            "description": description,
            //"type_seance": typeSeanceInput.value
        }

        const days = [activity.monday, activity.tuesday, activity.wednesday, activity.thursday,
            activity.friday, activity.saturday, activity.sunday];
        if (activity.groups) {
            const creneauGroupe = JSON.parse(JSON.stringify(commun));
            creneauGroupe.type_seance = 'Collectif';

            const ar = createCreneauForEachDay(creneauGroupe, days);
            for (const c of ar) {
                creneaux.push(c);
            }
        }
        if (activity.single) {
            const creneauIndiv = JSON.parse(JSON.stringify(commun));
            creneauIndiv.type_seance = 'Individuel';

            const ar = createCreneauForEachDay(creneauIndiv, days);
            for (const c of ar) {
                creneaux.push(c);
            }
        }

        return creneaux;
    }

    function createCreneauForEachDay(commun, days) {
        const creneaux = [];
        for (let i = 0; i < 7; i++) {
            if (days[i]) {
                const creneau = JSON.parse(JSON.stringify(commun));
                const idJour = i + 1; // les ids dans la BDD commence à 1
                creneau.jour = idJour.toString();

                creneaux.push(creneau);
            }
        }

        return creneaux;
    }

    /**
     * Return si l'activity peut être convertie en créneau
     */
    function isActivityValid(activity) {
        // const auMoinsUnJour = activity.monday || activity.tuesday || activity.wednesday || activity.thursday ||
        //     activity.friday || activity.saturday || activity.sunday;
        const isApproved = activity.status === 'approved';

        return isApproved;
    }

    function pathologieArrayToString(array) {
        let str = '';
        for (const pathologie of array) {
            str += pathologie + ', ';
        }

        if (str.length > 2) {
            return str.slice(0, -2);
        }
        return str;
    }

    function idTypeCreneau(str) {
        if (str === 'passerelle') {
            return '1';
        } else if (str === 'declic') {
            return '2';
        } else if (str === 'elan') {
            return '3';
        }

        return '4';
    }

    function idIntervenantApi(coaches) {
        if (Array.isArray(coaches) && coaches.length > 0) {
            return coaches[0];
        }

        return '';
    }

    return {
        init
    };
}();

const affichageListeDiplome = function () {
    const afficheDiplomesButton = document.getElementById('affiche-diplomes');

    let init = function () {
        afficheDiplomesButton.onclick = function () {
            console.log('afficheDiplomesButton click');

            form.onsubmit = async function (event) {
                event.preventDefault();
                const loginstring = login.value + ':' + pw.value;

                const headers = new Headers();
                headers.append('Authorization', 'Basic ' + btoa(loginstring));
                headers.append('Content-Type', 'application/ld+json');
                fetch('https://referencement.peps-na.fr/api/coaches', {
                    method: 'GET',
                    headers: headers
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
                        console.log('Success:', data);

                        const diplomes = getDiplomes(data['hydra:member']);
                        console.log('diplomes', diplomes);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        };
    };

    function getDiplomes(intervenants) {
        const diplomesSet = new Set();

        if (Array.isArray(intervenants)) {
            for (const intervenant of intervenants) {
                const degrees = JSON.parse(intervenant.degree);

                if (Array.isArray(degrees)) {
                    for (const d of degrees) {
                        for (const nom in d) {
                            diplomesSet.add(nom);
                        }
                    }
                }
            }
        }

        return diplomesSet;
    }

    return {
        init
    };
}();