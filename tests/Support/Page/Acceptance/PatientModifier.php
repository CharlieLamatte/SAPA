<?php

namespace Tests\Support\Page\Acceptance;

use Tests\Support\AcceptanceTester;

class PatientModifier
{
    // include url of current page
    public static $URL = '/PHP/Patients/modifbenef.php?idPatient=';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    private $enregistrerButton = ["css" => "input.btn"];
    //private $voirPlusButton = ["id" => "voir-plus"];

    // coordonnées patient
    private $nomPatientField = ["id" => "nom-patient"];
    private $prenomPatientField = ["id" => "prenom-patient"];
    private $sexeSelect = ["id" => "sexe_patient"];
    private $sexeSelectedOption = ["css" => "#sexe_patient option:checked"];
    private $dateNaissanceField = ["id" => "dn"];
    private $telPortablePatientField = ["id" => "tel_p"];
    private $telFixePatientField = ["id" => "tel_f"];
    private $emailPatientField = ["id" => "email-patient"];
    private $adressePatientField = ["id" => "adresse-patient"];
    private $complementAdressePatientField = ["id" => "complement-adresse-patient"];
    private $codePostalPatientField = ["id" => "code-postal-patient"];
    private $firstCodePostalPatient = ["css" => "#code-postal-patientautocomplete-list > div:nth-child(1) > input:nth-child(1)"];
    private $villePatientField = ["id" => "ville-patient"];

    private $code_insee_naissanceField = ["id" => "code_insee_naissance"];
    private $nom_utiliseField = ["id" => "nom_utilise"];
    private $prenom_utiliseField = ["id" => "prenom_utilise"];
    private $liste_prenom_naissanceField = ["id" => "liste_prenom_naissance"];

    // coordonnées contact
    private $nomContactField = ["id" => "nom_urgence"];
    private $prenomContactField = ["id" => "prenom_urgence"];
    private $lienSelect = ["id" => "id_lien"];
    private $lienSelectedOption = ["css" => "#id_lien option:checked"];
    private $telPortableContactField = ["id" => "tel_urgence_p"];
    private $telFixeContactField = ["id" => "tel_urgence_f"];

    private PatientAccueil $patientAccueil;

    protected AcceptanceTester $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        $this->patientAccueil = new PatientAccueil($I);
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    public function modify($paramaters)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::route($paramaters['id_patient']));

        $I->wantTo("Enregistrer les coordonnées du bénéficiaire");
        // obligatoire
        $I->fillField($this->nomPatientField, $paramaters['nom_naissance']);
        $I->fillField($this->prenomPatientField, $paramaters['premier_prenom_naissance']);
        $I->selectOption($this->sexeSelect, $paramaters['sexe']);
        $sexe_text = $I->grabTextFrom($this->sexeSelectedOption);
        $I->assertNotEmpty($sexe_text);
        $I->waitForJS(
            "document.getElementById('dn').value = '" . $paramaters['date_naissance'] . "'; return true;",
            60
        );
        if (!empty($paramaters['tel_fixe_patient'])) {
            $I->fillField($this->telFixePatientField, $paramaters['tel_fixe_patient']);
        }
        if (!empty($paramaters['tel_portable_patient'])) {
            $I->fillField($this->telPortablePatientField, $paramaters['tel_portable_patient']);
        }
        if (!empty($paramaters['email_patient'])) {
            $I->fillField($this->emailPatientField, $paramaters['email_patient']);
        }
        $I->fillField($this->adressePatientField, $paramaters['adresse_patient']);
        if (!empty($paramaters['complement_adresse_patient'])) {
            $I->fillField($this->complementAdressePatientField, $paramaters['complement_adresse_patient']);
        }
        if (!empty($paramaters['code_insee_naissance'])) {
            $I->fillField($this->code_insee_naissanceField, $paramaters['code_insee_naissance']);
        }
        if (!empty($paramaters['nom_utilise'])) {
            $I->fillField($this->nom_utiliseField, $paramaters['nom_utilise']);
        }
        if (!empty($paramaters['prenom_utilise'])) {
            $I->fillField($this->prenom_utiliseField, $paramaters['prenom_utilise']);
        }
        if (!empty($paramaters['liste_prenom_naissance'])) {
            $I->fillField($this->liste_prenom_naissanceField, $paramaters['liste_prenom_naissance']);
        }

        $I->fillField($this->codePostalPatientField, $paramaters['code_postal_patient']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->firstCodePostalPatient, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->firstCodePostalPatient);
        $ville_patient_text = $I->grabValueFrom($this->villePatientField);
        $I->assertNotEmpty($ville_patient_text);

        $I->wantTo("Enregistrer le contact d'urgence");
        if (!empty($paramaters['nom_contact'])) {
            $I->fillField($this->nomContactField, $paramaters['nom_contact']);
        }
        if (!empty($paramaters['prenom_contact'])) {
            $I->fillField($this->prenomContactField, $paramaters['prenom_contact']);
        }
        $lien_text = null;
        if (!empty($paramaters['lien'])) {
            $I->selectOption($this->lienSelect, $paramaters['lien']);
            $lien_text = $I->grabTextFrom($this->lienSelectedOption);
            $I->assertNotEmpty($lien_text);
        }
        if (!empty($paramaters['tel_fixe_contact'])) {
            $I->fillField($this->telFixeContactField, $paramaters['tel_fixe_contact']);
        }
        if (!empty($paramaters['tel_portable_contact'])) {
            $I->fillField($this->telPortableContactField, $paramaters['tel_portable_contact']);
        }

        $I->click($this->enregistrerButton);
        $I->waitPageLoad();
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php?idPatient=');

        $this->patientAccueil->verify(
            array_merge(
                $paramaters,
                [
                    'id_patient' => $paramaters['id_patient'],
                    'ville_patient_text' => $ville_patient_text,
                    'sexe_text' => $sexe_text,
                    'lien_text' => $lien_text,
                ]
            )
        );
    }
}
