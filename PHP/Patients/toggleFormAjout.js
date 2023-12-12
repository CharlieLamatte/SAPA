class ToggleForm {
    constructor(yes, no, form, motif) {
        this.yes = document.getElementById(yes)
        this.no = document.getElementById(no)
        this.form = document.getElementById(form)
        this.motif = document.getElementById(motif)


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
let toggleObject0 = new ToggleForm("radio_y0", "radio_n0", "cadreform_testphysio", "cadremotif_testphysio")
let toggleObject1 = new ToggleForm("radio_y1", "radio_n1", "cadreform_aa", "cadremotif_aa")
let toggleObject2 = new ToggleForm("radio_y2", "radio_n2", "cadreform_fmms", "cadremotif_fmms")
let toggleObject3 = new ToggleForm("radio_y3", "radio_n3", "cadreform_eq", "cadremotif_eq")
let toggleObject4 = new ToggleForm("radio_y4", "radio_n4", "cadreform_soupl", "cadremotif_soupl")
let toggleObject5 = new ToggleForm("radio_y5", "radio_n5", "cadreform_msh", "cadremotif_msh")
let toggleObject6 = new ToggleForm("radio_y6", "radio_n6", "cadreform_emmi", "cadremotif_emmi")
let toggleObject7 = new ToggleForm("radio-up-and-go-yes", "radio-up-and-go-no", "cadreform-up-and-go", "cadremotif-up-and-go")