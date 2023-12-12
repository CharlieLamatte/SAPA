"use strict";

let storage = (function () {
    let init = async function (url) {
        return new Promise(((resolve, reject) => {
            fetch(url, {
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
                    setStorage(data);
                    resolve('localstorage set successfully');
                })
                .catch((error) => {
                    console.error('Error:', error);
                    localStorage.clear();
                    reject('Error setting localstorage');
                });
        }));
    };

    // source: https://developer.mozilla.org/en-US/docs/Web/API/Web_Storage_API/Using_the_Web_Storage_API
    function storageAvailable(type) {
        let storage;
        try {
            storage = window[type];
            let x = '__storage_test__';
            storage.setItem(x, x);
            storage.removeItem(x);
            return true;
        } catch (e) {
            return e instanceof DOMException && (
                    // everything except Firefox
                    e.code === 22 ||
                    // Firefox
                    e.code === 1014 ||
                    // test name field too, because code might not be present
                    // everything except Firefox
                    e.name === 'QuotaExceededError' ||
                    // Firefox
                    e.name === 'NS_ERROR_DOM_QUOTA_REACHED') &&
                // acknowledge QuotaExceededError only if there's something already stored
                (storage && storage.length !== 0);
        }
    }

    function setStorage(data) {
        if (storageAvailable('localStorage')) {
            localStorage.clear();
            localStorage.setItem('nombre_elements_tableaux', data.nombre_elements_tableaux);
            localStorage.setItem('nom_connecte', data.nom_connecte);
            localStorage.setItem('prenom_connecte', data.prenom_connecte);
            localStorage.setItem('email_connecte', data.email_connecte);
            localStorage.setItem('role_user_ids', JSON.stringify(data.role_user_ids));
            localStorage.setItem('id_user', data.id_user);
            localStorage.setItem('id_structure', data.id_structure);
            localStorage.setItem('roles_user', JSON.stringify(data.roles_user));
            localStorage.setItem('id_territoire', data.id_territoire);
        } else {
            // Too bad, no localStorage for us
        }
    }

    return {
        init
    };
})();
