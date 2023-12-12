class VerifSelectAjout {
    constructor(bouton) {
        this.bouton = document.getElementById(bouton)

        this.errorSelect = 0

        this.bouton.addEventListener("click", () => {
            this.verifSelect()
        })
    }
    verifSelect() {
        this.errorSelect = 0
        let select = document.querySelectorAll(".select")
        let no = document.querySelectorAll(".no")
        for (let i = 0; i < no.length; i++) {
            if (no[i].checked == true) {
                if (select[i].value == 0) {
                    this.errorSelect++
                }
            }
        }
        if (this.errorSelect != 0) {
            event.preventDefault()
            alert("ATTENTION : Vous n'avez pas choisi de motif pour l'une des évaluations non réalisées.");
        }
    }

}
let verifSelectAjout = new VerifSelectAjout("valider")