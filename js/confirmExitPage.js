window.onbeforeunload = () => {
    return 'Êtes-vous sûr de vouloir quitter la page sans enregistrer les modifications apportées ?';
};

// pas d'affichage de message de confirmation si on submit
document.onsubmit =  () => {
    window.onbeforeunload = null;
}