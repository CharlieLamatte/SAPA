// les différents rôles possibles de l'utilisateur
// les rôles sont les mêmes que ceux définis dans Permissions.php
const ROLE = {
    SUPER_ADMIN: 'super_admin',
    COORDONNATEUR_PEPS: 'coordonnateur_peps',
    COORDONNATEUR_MSS: 'coordonnateur_mss',
    COORDONNATEUR_NON_MSS: 'coordonnateur_non_mss',
    INTERVENANT: 'intervenant',
    EVALUATEUR: 'evaluateur',
    REFERENT: 'referent',
    RESPONSABLE_STRUCTURE: 'responsable_structure',
    SUPERVISEUR_PEPS: 'superviseur',
    SECRETAIRE: 'secretaire',
}
Object.freeze(ROLE);

// les différents types de territoire possibles
const TYPE_TERRITOIRE = {
    TYPE_TERRITOIRE_DEPARTEMENT: 1,
    TYPE_TERRITOIRE_REGION: 2
}
Object.freeze(TYPE_TERRITOIRE);

/**
 * Return sanitized string
 *
 * @param val
 * @returns string
 */
function sanitize(val) {
    const string = '' + val;
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#x27;',
        "/": '&#x2F;',
    };
    const reg = /[&<>"'/]/ig;
    return string.replace(reg, (match) => (map[match]));
}

/**
 * @param a
 * @param b
 * @returns {boolean} if the two arrays are equal
 */
function arraysEqual(a, b) {
    if (a === b) return true;
    if (a == null || b == null) return false;
    if (a.length !== b.length) return false;

    // If you don't care about the order of the elements inside
    // the array, you should sort both arrays here.
    // Please note that calling sort on an array will modify that array.
    // you might want to clone your array first.

    for (let i = 0; i < a.length; ++i) {
        if (a[i] !== b[i]) return false;
    }
    return true;
}

/**
 * Returns false if the form is already locked,
 * else lock the form and return true
 *
 * @param form
 * @returns {Promise<boolean>}
 */
function lockForm(form) {
    return new Promise(resolve => {
        if (form.classList.contains('is-submitting')) {
            resolve(false);
        }

        // Add an indicator to show the user it is submitting
        form.classList.add('is-submitting');
        resolve(true);
    });
}

function unlockForm(form) {
    form.classList.remove('is-submitting');
}