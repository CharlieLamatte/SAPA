<?php

namespace Tests\Support\Page\Acceptance;

use Sportsante86\Sapa\Outils\Permissions;
use Tests\Support\AcceptanceTester;

class PatientAjout
{
    // include url of current page
    public static $URL_AJOUT = '/PHP/Ajout_Benef.php';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    private $enregistrerButton = ["css" => "input.btn"];
    //private $voirPlusButton = ["id" => "voir-plus"];

    //
    private $dateAdmissionField = ["id" => "da"];

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

    //private $code_insee_naissanceField = ["id" => "code_insee_naissance"];
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

    // Autres infos
    private $est_pris_en_chargeCheckbox = ["id" => "est-pris-en-charge"];
    private $hauteur_prise_en_chargeCheckbox = ["id" => "hauteur-prise-en-charge"];
    private $sit_part_prevention_chuteCheckbox = ["id" => "sit_part_prevention_chute"];
    private $sit_part_education_therapeutiqueCheckbox = ["id" => "sit_part_education_therapeutique"];
    private $sit_part_grossesseCheckbox = ["id" => "sit_part_grossesse"];
    private $sit_part_sedentariteCheckbox = ["id" => "sit_part_sedentarite"];
    private $sit_part_autreField = ["id" => "sit_part_autre"];
    private $qpvCheckbox = ["id" => "qpv"];
    private $zrrCheckbox = ["id" => "zrr"];
    private $intervalleSelect = ["id" => "intervalle"];
    private $intervalleSelectedOption = ["css" => "#intervalle option:checked"];

    // Régime d'assurance maladie
    private $regimeSelect = ["id" => "TypeRegime"];
    private $regimeSelectedOption = ["css" => "#TypeRegime option:checked"];
    private $codePostalCpamField = ["id" => "cp_cpam"];
    private $firstCodePostalCpam = ["css" => "#cp_cpamautocomplete-list > div:nth-child(1) > input:nth-child(1) "];
    private $villeCpamField = ["id" => "ville_cpam"];

    // mutuelle
    private $choixMutuelleField = ["id" => "choix_mutuelle"];
    private $firstChoixMutuelle = ["css" => "#choix_mutuelleautocomplete-list > div:nth-child(1) > input:nth-child(1)"];
    private $nom_mutuelleField = ["id" => "nom_mutuelle"];
    private $tel_mutuelleField = ["id" => "tel_mutuelle"];
    private $mail_mutuelleField = ["id" => "mail_mutuelle"];
    private $adresse_mutuelleField = ["id" => "adresse_mutuelle"];
    private $complement_mutuelleField = ["id" => "complement_mutuelle"];
    private $cp_mutuelleField = ["id" => "cp_mutuelle"];
    private $ville_mutuelleField = ["id" => "ville_mutuelle"];

    private $modalConsentement = ["id" => "modal-consentement"];

    private $roleCanAccessOngletSante = [
        Permissions::SUPER_ADMIN,
        Permissions::COORDONNATEUR_PEPS,
        Permissions::EVALUATEUR,
        Permissions::COORDONNATEUR_MSS,
    ];

    private PatientAccueil $patientAccueil;

    protected AcceptanceTester $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        $this->patientAccueil = new PatientAccueil($I);
    }

    public function create($paramaters)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::$URL_AJOUT);

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

//        if (!empty($paramaters['code_insee_naissance'])) {
//            $I->fillField($this->code_insee_naissanceField, $paramaters['code_insee_naissance']);
//        }
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

        $I->wantTo("Enregistrer les Autres infos");
        $I->selectOption($this->intervalleSelect, $paramaters['intervalle']);
        if ($paramaters['est_pris_en_charge'] && !empty($paramaters['hauteur_prise_en_charge'])) {
            $I->checkOption($this->est_pris_en_chargeCheckbox);
            $I->fillField($this->hauteur_prise_en_chargeCheckbox, $paramaters['hauteur_prise_en_charge']);
        }
        if ($paramaters['sit_part_prevention_chute']) {
            $I->checkOption($this->sit_part_prevention_chuteCheckbox);
        }
        if ($paramaters['sit_part_education_therapeutique']) {
            $I->checkOption($this->sit_part_education_therapeutiqueCheckbox);
        }
        if ($paramaters['sit_part_grossesse']) {
            $I->checkOption($this->sit_part_grossesseCheckbox);
        }
        if ($paramaters['sit_part_sedentarite']) {
            $I->checkOption($this->sit_part_sedentariteCheckbox);
        }
        if (!empty($paramaters['sit_part_autre'])) {
            $I->fillField($this->sit_part_autreField, $paramaters['sit_part_autre']);
        }
        if ($paramaters['qpv']) {
            $I->checkOption($this->qpvCheckbox);
        }
        if ($paramaters['zrr']) {
            $I->checkOption($this->zrrCheckbox);
        }

        if (!empty($paramaters['nom_mutuelle'])) {
            $I->wantTo("Enregistrer CPAM");
            $I->fillField($this->choixMutuelleField, $paramaters['nom_mutuelle']);
            $I->waitPageLoad();
            $I->waitForElementClickable($this->firstChoixMutuelle, 30);
            $I->retry(4, 1000);
            $I->retryClick($this->firstChoixMutuelle);
            $nom_mutuelle_complete_text = $I->grabValueFrom($this->nom_mutuelleField);
            $tel_mutuelle_text = $I->grabValueFrom($this->tel_mutuelleField);
            $mail_mutuelle_text = $I->grabValueFrom($this->mail_mutuelleField);
            $adresse_mutuelle_text = $I->grabValueFrom($this->adresse_mutuelleField);
            $complement_mutuelle_text = $I->grabValueFrom($this->complement_mutuelleField);
            $cp_mutuelle_text = $I->grabValueFrom($this->cp_mutuelleField);
            $ville_mutuelle_text = $I->grabValueFrom($this->ville_mutuelleField);
        }

        $I->wantTo("Enregistrer CPAM");
        $I->selectOption($this->regimeSelect, $paramaters['regime']);
        $regime_text = $I->grabTextFrom($this->regimeSelectedOption);
        $I->fillField($this->codePostalCpamField, $paramaters['code_postal_cpam']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->firstCodePostalCpam, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->firstCodePostalCpam);
        $ville_cpam_text = $I->grabValueFrom($this->villeCpamField);
        $I->assertNotEmpty($ville_cpam_text);

        $I->click($this->enregistrerButton);
        $I->waitPageLoad();
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php?idPatient=');
        $a = explode('/PHP/Patients/AccueilPatient.php?idPatient=', $I->grabFromCurrentUrl());
        $id_patient = $a[1];

        if (in_array($paramaters['role'], $this->roleCanAccessOngletSante)) {
            $I->seeElement($this->modalConsentement);
        } else {
            $I->dontSeeElement($this->modalConsentement);
        }

        $this->patientAccueil->verify(
            array_merge(
                $paramaters,
                [
                    'id_patient' => $id_patient,
                    'ville_cpam_text' => $ville_cpam_text,
                    'ville_patient_text' => $ville_patient_text,
                    'regime_text' => $regime_text,
                    'sexe_text' => $sexe_text,
                    'lien_text' => $lien_text,

                    'nom_mutuelle_complete_text' => $nom_mutuelle_complete_text ?? null,
                    'tel_mutuelle_text' => $tel_mutuelle_text ?? null,
                    'mail_mutuelle_text' => $mail_mutuelle_text ?? null,
                    'adresse_mutuelle_text' => $adresse_mutuelle_text ?? null,
                    'complement_mutuelle_text' => $complement_mutuelle_text ?? null,
                    'cp_mutuelle_text' => $cp_mutuelle_text ?? null,
                    'ville_mutuelle_text' => $ville_mutuelle_text ?? null,
                ]
            )
        );
    }
}
