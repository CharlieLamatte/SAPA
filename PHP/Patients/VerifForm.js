class VerifForm {
    constructor(yes, no, bouton) {
        this.bouton = document.getElementById(bouton)
        this.yes = document.getElementById(yes)
        this.no = document.getElementById(no)

        this.errorDataAA = 0

        this.bouton.addEventListener("click", () => {
            if (this.yes.checked == true) {
                this.verifAllInput()
            } else if (this.no.checked == true) {
                this.verifSelect()
            } else {
                this.errorAlert()
            }
        })
    }
    verifAllInput() {
        this.errorDataAA = 0
        let data = document.querySelectorAll(".data_aa")
        for (let i = 0; i < data.length; i++) {
            console.log(data[i].value)
            if (data[i].value == "") {
                this.errorDataAA++
                    console.log('error Data =')
                console.log(this.errorDataAA)
            }
        }

        if (this.errorDataAA != 0) {
            event.preventDefault()
            alert("ATTENTION : Vous n'avez pas compléter tous les champs *obligatoires pour l'évaluation aptidues aerobies.");
        }
    }
    verifSelect() {
        let motifValue = document.getElementById("motif_apt_aerobie").value
        if (motifValue == 0) {
            event.preventDefault()
            alert("ATTENTION : Vous n'avez pas saisi de motif pour le test d'aptitude aerobie.")
        }
    }
    errorAlert() {
        event.preventDefault()
        alert("ATTENTION : Une erreur est survenue.")
    }
}
let verifForm = new VerifForm("radio_y1", "radio_n1", "valider")