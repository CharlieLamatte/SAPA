"use strict";

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById("form");

    const messageDiv = document.getElementById("message");
    const mdpShow = document.getElementById("mdp-show");
    const confirmMdpShow = document.getElementById("confirm-mdp-show");

    const mdpInput = document.getElementById("mdp");
    const confirmMdpInput = document.getElementById("confirm-mdp");
    const twoPasswords = document.getElementById("2-passwords");

    if (confirmMdpInput && mdpInput && mdpShow && confirmMdpShow) {
        // met le champ en password lisible/illisible
        mdpShow.onclick = () => {
            togglePasswordVisible(mdpInput);
        };
        confirmMdpShow.onclick = () => {
            togglePasswordVisible(confirmMdpInput);
        };

        form.onsubmit = function (e) {
            if (confirmMdpInput.value === mdpInput.value) {
                return true;
            } else {
                e.preventDefault();
                mdpInput.focus();
                twoPasswords.classList.add("invalid");
                twoPasswords.classList.remove("valid");
                messageDiv.style.display = "block";

                return false;
            }
        }
    }

    function togglePasswordVisible(input) {
        if (input.getAttribute('type') === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }
}, false);
