class VerifFormModif {
    constructor(yes, no, bouton) {
        this.bouton = document.getElementById(bouton)
        this.yes = document.getElementById(yes)
        this.no = document.getElementById(no)

        this.errorDataAA = 0

        this.bouton.addEventListener("click", () => {
            /*             console.log(this.yes.checked)
                        console.log(this.no.checked) */
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
            /*         console.log('Oui aa')
                    event.preventDefault() */
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
        /*         console.log('Non aa')
                event.preventDefault() */
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
let verifForm = new VerifFormModif("radio_y1", "radio_n1", "modifier")