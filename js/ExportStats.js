"use strict";

$(document).ready(function () {
    // initialisation des élements de la page
    exportData.init();
    exportDataPatient.init();
    exportDataMedecin.init();
});

let exportData = function () {
    const exportPatientDataForm = document.getElementById('export-patient-data-sante');

    // la div qui sert de toast
    const toastDiv = document.getElementById("toast");

    const mainDiv = document.getElementById("main-div");
    const selectYearPatientData = document.getElementById('year-patient-data-sante');

    let init = function () {
        exportPatientDataForm.onsubmit = async function (event) {
            event.preventDefault();

            try {
                let patientData = await getPatientData();
                exportToCsv('export.csv', patientData);
            } catch (err) {
                toast(err);
            }
        };

        let years = fetch('../Settings/TableauDeBord/ReadYears.php', {
            method: 'POST',
            body: JSON.stringify({id_territoire: mainDiv.getAttribute('data-id_territoire')})
        })
            .then(response => {
                if (!response.ok) {
                    throw {
                        statusCode: response.status,
                    };
                }
                return response.json()
            })
            .catch((error) => {
                return null;
            });

        Promise.all([years])
            .then(result => {
                emptySelectElem(selectYearPatientData);

                if (result[0]) {
                    if (Array.isArray(result[0])) {
                        result[0].forEach(year => {
                            const option = document.createElement("option");

                            option.value = year;
                            option.text = year;

                            selectYearPatientData.add(option, null);
                        });
                    }
                }
            }).catch(() => console.error('error'));
    }

    function exportToCsv(filename, rows) {
        const processRow = function (row) {
            let finalVal = '';
            for (let j = 0; j < row.length; j++) {
                let innerValue = row[j] === null ? '' : row[j].toString();
                if (row[j] instanceof Date) {
                    innerValue = row[j].toLocaleString();
                }

                var result = innerValue.replace(/"/g, '""');
                if (result.search(/("|;|\n)/g) >= 0) {
                    result = '"' + result + '"';
                }
                if (j > 0) {
                    finalVal += ';';
                }
                finalVal += result;
            }
            return finalVal + '\n';
        };

        let csvFile = 'sep=;\n';
        for (let i = 0; i < rows.length; i++) {
            csvFile += processRow(rows[i]);
        }

        const blob = new Blob([csvFile], {type: 'text/csv;charset=utf-8;'});
        if (navigator.msSaveBlob) {
            navigator.msSaveBlob(blob, filename);
        } else {
            const link = document.createElement("a");
            if (link.download !== undefined) {
                const url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", filename);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    }

    async function getPatientData() {
        let response = await fetch('ReadOnapsData.php', {
            method: 'POST',
            body: JSON.stringify({'year': exportPatientDataForm.elements.year.value})
        });
        return await response.json();
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
}();

const exportDataPatient = (function () {
    const $table = $('#table-patient');
    const tableBody = document.getElementById('body-patient');

    let datatable = null;

    function init() {
        fetch('ReadPatientData.php', {
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
            .then(data => {
                initTable(data);
            })
            .catch((error) => {
                initTable(null);
            });
    }

    function initTable(data) {
        if (Array.isArray(data)) {
            for (const patient of data) {
                tableBody.append(createLigne(patient));
            }
        }

        datatable = $table.DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export excel',
                    exportOptions: {
                        columns: ':visible'
                    },
                    filename: 'donnees_patients',
                    title: null
                },
                {
                    extend: 'colvis',
                    text: 'Choix colonnes',
                }
            ],
            "scrollX": true,
            "autoWidth": true,
            responsive: true,
            language: {url: "../../js/DataTables/media/French.json"},
        });
        datatable.draw();
    }

    function createLigne(patient) {
        let row = document.createElement('tr');

        let td1 = document.createElement('td');
        td1.className = "text-left";
        td1.textContent = patient.nom;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = patient.prenom;

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.textContent = patient.tel_fixe;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.textContent = patient.tel_portable;

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.textContent = patient.email;

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.textContent = patient.nom_ville;

        let td7 = document.createElement('td');
        td7.className = "text-left";
        td7.textContent = patient.nom_adresse;

        let td8 = document.createElement('td');
        td8.className = "text-left";
        if (patient.nom_prescripteur && patient.prenom_prescripteur) {
            td8.textContent = patient.nom_prescripteur + ' ' + patient.prenom_prescripteur;
        } else {
            td8.textContent = '';
        }

        let td9 = document.createElement('td');
        td9.className = "text-left";
        if (patient.nom_traitant && patient.prenom_traitant) {
            td9.textContent = patient.nom_traitant + ' ' + patient.prenom_traitant;
        } else {
            td9.textContent = '';
        }

        let td10 = document.createElement('td');
        td10.className = "text-left";
        td10.textContent = patient.type_parcours;

        let td11 = document.createElement('td');
        td11.className = "text-left";
        td11.textContent = patient.nom_antenne;

        let td12 = document.createElement('td');
        td12.className = "text-left";
        td12.textContent = patient.alds;

        let td13 = document.createElement('td');
        td13.className = "text-left";
        td13.textContent = patient.date_admission;

        row.append(td1, td2, td3, td4, td5, td6, td7, td8, td9, td10, td11, td12, td13);

        return row;
    }

    return {
        init
    };
})();

const exportDataMedecin = (function () {
    const $table = $('#table-medecins');
    const tableBody = document.getElementById('body-medecins');

    let datatable = null;

    function init() {
        fetch('ReadMedecinPrescripteurData.php', {
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
            .then(data => {
                initTable(data);
            })
            .catch((error) => {
                initTable(null);
            });
    }

    function initTable(data) {
        if (Array.isArray(data)) {
            for (const patient of data) {
                tableBody.append(createLigne(patient));
            }
        }

        datatable = $table.DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export excel',
                    exportOptions: {
                        columns: ':visible'
                    },
                    filename: 'donnees_medecins',
                    title: null
                },
                {
                    extend: 'colvis',
                    text: 'Choix colonnes',
                }
            ],
            "scrollX": true,
            "autoWidth": true,
            responsive: true,
            language: {url: "../../js/DataTables/media/French.json"},
        });
        datatable.draw();
    }

    function createLigne(patient) {
        let row = document.createElement('tr');

        let td1 = document.createElement('td');
        td1.className = "text-left";
        td1.textContent = patient.nb_prescription;

        let td2 = document.createElement('td');
        td2.className = "text-left";
        td2.textContent = patient.nom;

        let td3 = document.createElement('td');
        td3.className = "text-left";
        td3.textContent = patient.prenom;

        let td4 = document.createElement('td');
        td4.className = "text-left";
        td4.textContent = patient.tel_fixe;

        let td5 = document.createElement('td');
        td5.className = "text-left";
        td5.textContent = patient.tel_portable;

        let td6 = document.createElement('td');
        td6.className = "text-left";
        td6.textContent = patient.email;

        let td7 = document.createElement('td');
        td7.className = "text-left";
        td7.textContent = patient.poste_medecin;

        let td8 = document.createElement('td');
        td8.className = "text-left";
        td8.textContent = patient.nom_specialite_medecin;

        let td9 = document.createElement('td');
        td9.className = "text-left";
        td9.textContent = patient.nom_adresse;

        let td10 = document.createElement('td');
        td10.className = "text-left";
        td10.textContent = patient.complement_adresse;

        let td11 = document.createElement('td');
        td11.className = "text-left";
        td11.textContent = patient.code_postal;

        let td12 = document.createElement('td');
        td12.className = "text-left";
        td12.textContent = patient.nom_ville;

        row.append(td1, td2, td3, td4, td5, td6, td7, td8, td9, td10, td11, td12);

        return row;
    }

    return {
        init
    };
})();

/**
 * Removes all HTMLOptionElement of an HTMLSelectElement except the first
 * @param select HTMLSelectElement
 */
function emptySelectElem(select) {
    while (select.options.length > 1) {
        select.remove(1);
    }
}