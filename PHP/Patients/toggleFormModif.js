class ToggleFormModif {
    constructor(yes, no, form, motif, cadremotif) {
        this.yes = document.getElementById(yes)
        this.no = document.getElementById(no)
        this.form = document.getElementById(form)
        this.motif = document.getElementById(motif)

        this.toggleChoice = document.getElementsByClassName(cadremotif)
        if (this.toggleChoice.length > 0) {
            this.motif.classList.add("toggle_on")
            this.form.classList.add("toggle_off")
            this.no.checked = true
        } else {
            this.motif.classList.add("toggle_off")
            this.form.classList.add("toggle_on")
            this.yes.checked = true
        }


        this.yes.addEventListener('click', () => {
            this.form.classList.add("toggle_on")
            this.motif.classList.add("toggle_off")
                //if(this.form.classList.contains("toggle_off")){
            this.form.classList.remove("toggle_off")
                //}
        })

        this.no.addEventListener('click', () => {
            this.motif.classList.add("toggle_on")
            this.form.classList.add("toggle_off")
                //if(this.motif.classList.contains("toggle_off")){
            this.motif.classList.remove("toggle_off")
                //}
        })
    }
}
let toggleObjectModif0 = new ToggleFormModif("radio_y0", "radio_n0", "cadreform_testphysio", "cadremotif_testphysio", "toggle_choice0")
let toggleObjectModif1 = new ToggleFormModif("radio_y1", "radio_n1", "cadreform_aa", "cadremotif_aa", "toggle_choice1")
let toggleObjectModif2 = new ToggleFormModif("radio_y2", "radio_n2", "cadreform_fmms", "cadremotif_fmms", "toggle_choice2")
let toggleObjectModif3 = new ToggleFormModif("radio_y3", "radio_n3", "cadreform_eq", "cadremotif_eq", "toggle_choice3")
let toggleObjectModif4 = new ToggleFormModif("radio_y4", "radio_n4", "cadreform_soupl", "cadremotif_soupl", "toggle_choice4")
let toggleObjectModif5 = new ToggleFormModif("radio_y5", "radio_n5", "cadreform_msh", "cadremotif_msh", "toggle_choice5")
let toggleObjectModif6 = new ToggleFormModif("radio_y6", "radio_n6", "cadreform_emmi", "cadremotif_emmi", "toggle_choice6")
let toggleObjectModif7 = new ToggleFormModif("radio-up-and-go-yes", "radio-up-and-go-no", "cadreform-up-and-go", "cadremotif-up-and-go", "toggle_choice7")