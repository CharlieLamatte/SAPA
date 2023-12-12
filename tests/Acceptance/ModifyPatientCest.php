<?php

namespace Tests\Acceptance;

use Faker\Factory;
use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\Login;
use Tests\Support\Page\Acceptance\PatientModifier;

class ModifyPatientCest
{
    private $faker;

    public function _before(AcceptanceTester $I)
    {
        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(435);
    }

    public function modifyPatientAsCoordonnateurPepsMinimumData(
        AcceptanceTester $I,
        Login $loginPage,
        PatientModifier $patientModifierPage
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $patientModifierPage->modify([
            'id_patient' => "1",
            'nom_naissance' => $this->faker->lastName(),
            'premier_prenom_naissance' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement(["M", "F"]),
            'date_naissance' => $this->faker->date('Y-m-d', "2022-01-01"),
            'tel_fixe_patient' => $this->faker->numerify('0#########'),
            'adresse_patient' => $this->faker->streetAddress(),
            'code_postal_patient' => "86000",

            'check_autres_infos' => false, // meta-donnée pour informer la classe qui vérifie
        ]);
    }

    public function modifyPatientAsCoordonnateurPepsAlldata(
        AcceptanceTester $I,
        Login $loginPage,
        PatientModifier $patientModifierPage
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $patientModifierPage->modify([
            'id_patient' => "1",
            'nom_naissance' => $this->faker->lastName(),
            'premier_prenom_naissance' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement(["M", "F"]),
            'date_naissance' => $this->faker->date('Y-m-d', "2022-01-01"),
            'tel_fixe_patient' => $this->faker->numerify('0#########'),
            'tel_portable_patient' => $this->faker->numerify('0#########'),
            'email_patient' => $this->faker->email(),
            'adresse_patient' => $this->faker->streetAddress(),
            'complement_adresse_patient' => $this->faker->secondaryAddress(),
            'code_postal_patient' => "86000",

            'code_insee_naissance' => $this->faker->numerify('#####'),
            'nom_utilise' => $this->faker->lastName(),
            'prenom_utilise' => $this->faker->firstName(),
            'liste_prenom_naissance' => $this->faker->firstName() . ' ' . $this->faker->firstName(),

            'nom_contact' => $this->faker->lastName(),
            'prenom_contact' => $this->faker->firstName(),
            'lien' => $this->faker->numberBetween(1, 17),
            'tel_fixe_contact' => $this->faker->numerify('0#########'),
            'tel_portable_contact' => $this->faker->numerify('0#########'),

            'check_autres_infos' => false, // meta-donnée pour informer la classe qui vérifie
        ]);
    }

    public function modifyPatientAsCoordonnateurMSSMinimumData(
        AcceptanceTester $I,
        Login $loginPage,
        PatientModifier $patientModifierPage
    ) {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');
        $patientModifierPage->modify([
            'id_patient' => "1",
            'nom_naissance' => $this->faker->lastName(),
            'premier_prenom_naissance' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement(["F", "M"]),
            'date_naissance' => $this->faker->date('Y-m-d', "2022-01-01"),
            'tel_fixe_patient' => $this->faker->numerify('0#########'),
            'adresse_patient' => $this->faker->streetAddress(),
            'code_postal_patient' => "86000",

            'check_autres_infos' => false, // meta-donnée pour informer la classe qui vérifie
        ]);
    }

    public function modifyPatientAsCoordonnateurMSSAlldata(
        AcceptanceTester $I,
        Login $loginPage,
        PatientModifier $patientModifierPage
    ) {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');
        $patientModifierPage->modify([
            'id_patient' => "1",
            'nom_naissance' => $this->faker->lastName(),
            'premier_prenom_naissance' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement(["F", "M"]),
            'date_naissance' => $this->faker->date('Y-m-d', "2022-01-01"),
            'tel_fixe_patient' => $this->faker->numerify('0#########'),
            'tel_portable_patient' => $this->faker->numerify('0#########'),
            'email_patient' => $this->faker->email(),
            'adresse_patient' => $this->faker->streetAddress(),
            'complement_adresse_patient' => $this->faker->secondaryAddress(),
            'code_postal_patient' => "86000",

            'code_insee_naissance' => $this->faker->numerify('#####'),
            'nom_utilise' => $this->faker->lastName(),
            'prenom_utilise' => $this->faker->firstName(),
            'liste_prenom_naissance' => $this->faker->firstName() . ' ' . $this->faker->firstName(),

            'nom_contact' => $this->faker->lastName(),
            'prenom_contact' => $this->faker->firstName(),
            'lien' => $this->faker->numberBetween(1, 17),
            'tel_fixe_contact' => $this->faker->numerify('0#########'),
            'tel_portable_contact' => $this->faker->numerify('0#########'),

            'check_autres_infos' => false, // meta-donnée pour informer la classe qui vérifie
        ]);
    }

    public function modifyPatientAsEvaluateurMinimumData(
        AcceptanceTester $I,
        Login $loginPage,
        PatientModifier $patientModifierPage
    ) {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');
        $patientModifierPage->modify([
            'id_patient' => "1",
            'nom_naissance' => $this->faker->lastName(),
            'premier_prenom_naissance' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement(["F", "M"]),
            'date_naissance' => $this->faker->date('Y-m-d', "2022-01-01"),
            'tel_fixe_patient' => $this->faker->numerify('0#########'),
            'adresse_patient' => $this->faker->streetAddress(),
            'code_postal_patient' => "86000",

            'check_autres_infos' => false, // meta-donnée pour informer la classe qui vérifie
        ]);
    }

    public function modifyPatientAsEvaluateurAlldata(
        AcceptanceTester $I,
        Login $loginPage,
        PatientModifier $patientModifierPage
    ) {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');
        $patientModifierPage->modify([
            'id_patient' => "1",
            'nom_naissance' => $this->faker->lastName(),
            'premier_prenom_naissance' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement(["F", "M"]),
            'date_naissance' => $this->faker->date('Y-m-d', "2022-01-01"),
            'tel_fixe_patient' => $this->faker->numerify('0#########'),
            'tel_portable_patient' => $this->faker->numerify('0#########'),
            'email_patient' => $this->faker->email(),
            'adresse_patient' => $this->faker->streetAddress(),
            'complement_adresse_patient' => $this->faker->secondaryAddress(),
            'code_postal_patient' => "86000",

            'code_insee_naissance' => $this->faker->numerify('#####'),
            'nom_utilise' => $this->faker->lastName(),
            'prenom_utilise' => $this->faker->firstName(),
            'liste_prenom_naissance' => $this->faker->firstName() . ' ' . $this->faker->firstName(),

            'nom_contact' => $this->faker->lastName(),
            'prenom_contact' => $this->faker->firstName(),
            'lien' => $this->faker->numberBetween(1, 17),
            'tel_fixe_contact' => $this->faker->numerify('0#########'),
            'tel_portable_contact' => $this->faker->numerify('0#########'),

            'check_autres_infos' => false, // meta-donnée pour informer la classe qui vérifie
        ]);
    }
}