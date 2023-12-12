"use strict";

// affichage des champs d'identité supplémentaires
const voirPlusButton = document.getElementById("voir-plus");
const plusText = document.getElementById("plus-text");

voirPlusButton.onclick = (event) => {
    event.preventDefault();

    if (plusText.style.display === "inline") {
        voirPlusButton.innerHTML = "Voir les autres champs d'identité";
        plusText.style.display = "none";
    } else {
        voirPlusButton.innerHTML = "Cacher les autres champs d'identité";
        plusText.style.display = "inline";
    }
};