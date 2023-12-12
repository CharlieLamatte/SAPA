<?php

namespace Sportsante86\Sapa\tests\Acceptance;

use Faker\Factory;
use Sportsante86\Sapa\Outils\Permissions;
use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\Login;
use Tests\Support\Page\Acceptance\PatientAjout;

class CreatePatientCest
{
    private $faker;

    public function _before(AcceptanceTester $I)
    {
        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(1234);
    }

    public function createPatientAsCoordonnateurPepsMinimumData(
        AcceptanceTester $I,
        Login $loginPage,
        PatientAjout $patientAjoutPage
    ) {
        $email_connected = 'testcoord1@sportsante86.fr';

        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $patientAjoutPage->create([
            'nom_naissance' => $this->faker->lastName(),
            'premier_prenom_naissance' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement(["M", "F"]),
            'date_naissance' => $this->faker->date('Y-m-d', "2022-01-01"),
            'tel_fixe_patient' => $this->faker->numerify('0#########'),
            'adresse_patient' => $this->faker->streetAddress(),
            'code_postal_patient' => "86000",

            'est_pris_en_charge' => $this->faker->boolean(),
            'hauteur_prise_en_charge' => $this->faker->numberBetween(1, 100),

            'sit_part_prevention_chute' => $this->faker->boolean(),
            'sit_part_education_therapeutique' => $this->faker->boolean(),
            'sit_part_grossesse' => $this->faker->boolean(),
            'sit_part_sedentarite' => $this->faker->boolean(),
            'sit_part_autre' => $this->faker->text(200),
            'qpv' => $this->faker->boolean(),
            'zrr' => $this->faker->boolean(),
            'intervalle' => $this->faker->randomElement(["3", "6"]),

            'regime' => $this->faker->numberBetween(1, 21),
            'code_postal_cpam' => "86000",

            'check_autres_infos' => true, // meta-donnée pour informer la classe qui vérifie
            'role' => Permissions::COORDONNATEUR_PEPS, // meta-donnée pour informer la classe qui vérifie
            'email-connected' => $email_connected
        ]);
    }

    public function createPatientAsCoordonnateurPepsAlldata(
        AcceptanceTester $I,
        Login $loginPage,
        PatientAjout $patientAjoutPage
    ) {
        $email_connected = 'testcoord1@sportsante86.fr';

        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $patientAjoutPage->create([
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

            //'code_insee_naissance' => $this->faker->numerify('#####'),
            'nom_utilise' => $this->faker->lastName(),
            'prenom_utilise' => $this->faker->firstName(),
            'liste_prenom_naissance' => $this->faker->firstName() . ' ' . $this->faker->firstName(),

            'nom_contact' => $this->faker->lastName(),
            'prenom_contact' => $this->faker->firstName(),
            'lien' => $this->faker->numberBetween(1, 17),
            'tel_fixe_contact' => $this->faker->numerify('0#########'),
            'tel_portable_contact' => $this->faker->numerify('0#########'),

            'est_pris_en_charge' => $this->faker->boolean(),
            'hauteur_prise_en_charge' => $this->faker->numberBetween(1, 100),

            'sit_part_prevention_chute' => $this->faker->boolean(),
            'sit_part_education_therapeutique' => $this->faker->boolean(),
            'sit_part_grossesse' => $this->faker->boolean(),
            'sit_part_sedentarite' => $this->faker->boolean(),
            'sit_part_autre' => $this->faker->text(200),
            'qpv' => $this->faker->boolean(),
            'zrr' => $this->faker->boolean(),
            'intervalle' => $this->faker->randomElement(["3", "6"]),

            'regime' => $this->faker->numberBetween(1, 21),
            'code_postal_cpam' => "86000",

            'nom_mutuelle' => "MUTUELLE -", // début du nom de la mutuelle

            'check_autres_infos' => true, // meta-donnée pour informer la classe qui vérifie
            'role' => Permissions::COORDONNATEUR_PEPS, // meta-donnée pour informer la classe qui vérifie
            'email-connected' => $email_connected
        ]);
    }

    public function createPatientAsCoordonnateurMSSMinimumData(
        AcceptanceTester $I,
        Login $loginPage,
        PatientAjout $patientAjoutPage
    ) {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');
        $patientAjoutPage->create([
            'nom_naissance' => $this->faker->lastName(),
            'premier_prenom_naissance' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement(["F", "M"]),
            'date_naissance' => $this->faker->date('Y-m-d', "2022-01-01"),
            'tel_fixe_patient' => $this->faker->numerify('0#########'),
            'adresse_patient' => $this->faker->streetAddress(),
            'code_postal_patient' => "86000",

            'est_pris_en_charge' => $this->faker->boolean(),
            'hauteur_prise_en_charge' => $this->faker->numberBetween(1, 100),

            'sit_part_prevention_chute' => $this->faker->boolean(),
            'sit_part_education_therapeutique' => $this->faker->boolean(),
            'sit_part_grossesse' => $this->faker->boolean(),
            'sit_part_sedentarite' => $this->faker->boolean(),
            'sit_part_autre' => $this->faker->text(200),
            'qpv' => $this->faker->boolean(),
            'zrr' => $this->faker->boolean(),
            'intervalle' => $this->faker->randomElement(["3", "6"]),

            'regime' => $this->faker->numberBetween(1, 21),
            'code_postal_cpam' => "86000",

            'check_autres_infos' => true, // meta-donnée pour informer la classe qui vérifie
            'role' => Permissions::COORDONNATEUR_MSS, // meta-donnée pour informer la classe qui vérifie
        ]);
    }

    public function createPatientAsCoordonnateurMSSAlldata(
        AcceptanceTester $I,
        Login $loginPage,
        PatientAjout $patientAjoutPage
    ) {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');
        $patientAjoutPage->create([
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

            //'code_insee_naissance' => $this->faker->numerify('#####'),
            'nom_utilise' => $this->faker->lastName(),
            'prenom_utilise' => $this->faker->firstName(),
            'liste_prenom_naissance' => $this->faker->firstName() . ' ' . $this->faker->firstName(),

            'nom_contact' => $this->faker->lastName(),
            'prenom_contact' => $this->faker->firstName(),
            'lien' => $this->faker->numberBetween(1, 17),
            'tel_fixe_contact' => $this->faker->numerify('0#########'),
            'tel_portable_contact' => $this->faker->numerify('0#########'),

            'est_pris_en_charge' => $this->faker->boolean(),
            'hauteur_prise_en_charge' => $this->faker->numberBetween(1, 100),

            'sit_part_prevention_chute' => $this->faker->boolean(),
            'sit_part_education_therapeutique' => $this->faker->boolean(),
            'sit_part_grossesse' => $this->faker->boolean(),
            'sit_part_sedentarite' => $this->faker->boolean(),
            'sit_part_autre' => $this->faker->text(200),
            'qpv' => $this->faker->boolean(),
            'zrr' => $this->faker->boolean(),
            'intervalle' => $this->faker->randomElement(["3", "6"]),

            'regime' => $this->faker->numberBetween(1, 21),
            'code_postal_cpam' => "86000",

            'nom_mutuelle' => "MUTUELLE -", // début du nom de la mutuelle

            'check_autres_infos' => true, // meta-donnée pour informer la classe qui vérifie
            'role' => Permissions::COORDONNATEUR_MSS, // meta-donnée pour informer la classe qui vérifie
        ]);
    }

    public function createPatientAsEvaluateurMinimumData(
        AcceptanceTester $I,
        Login $loginPage,
        PatientAjout $patientAjoutPage
    ) {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');
        $patientAjoutPage->create([
            'nom_naissance' => $this->faker->lastName(),
            'premier_prenom_naissance' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement(["F", "M"]),
            'date_naissance' => $this->faker->date('Y-m-d', "2022-01-01"),
            'tel_fixe_patient' => $this->faker->numerify('0#########'),
            'adresse_patient' => $this->faker->streetAddress(),
            'code_postal_patient' => "86000",

            'est_pris_en_charge' => $this->faker->boolean(),
            'hauteur_prise_en_charge' => $this->faker->numberBetween(1, 100),

            'sit_part_prevention_chute' => $this->faker->boolean(),
            'sit_part_education_therapeutique' => $this->faker->boolean(),
            'sit_part_grossesse' => $this->faker->boolean(),
            'sit_part_sedentarite' => $this->faker->boolean(),
            'sit_part_autre' => $this->faker->text(200),
            'qpv' => $this->faker->boolean(),
            'zrr' => $this->faker->boolean(),
            'intervalle' => $this->faker->randomElement(["3", "6"]),

            'regime' => $this->faker->numberBetween(1, 21),
            'code_postal_cpam' => "86000",

            'check_autres_infos' => true, // meta-donnée pour informer la classe qui vérifie
            'role' => Permissions::EVALUATEUR, // meta-donnée pour informer la classe qui vérifie
        ]);
    }

    public function createPatientAsEvaluateurAlldata(
        AcceptanceTester $I,
        Login $loginPage,
        PatientAjout $patientAjoutPage
    ) {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');
        $patientAjoutPage->create([
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

            //'code_insee_naissance' => $this->faker->numerify('#####'),
            'nom_utilise' => $this->faker->lastName(),
            'prenom_utilise' => $this->faker->firstName(),
            'liste_prenom_naissance' => $this->faker->firstName() . ' ' . $this->faker->firstName(),

            'nom_contact' => $this->faker->lastName(),
            'prenom_contact' => $this->faker->firstName(),
            'lien' => $this->faker->numberBetween(1, 17),
            'tel_fixe_contact' => $this->faker->numerify('0#########'),
            'tel_portable_contact' => $this->faker->numerify('0#########'),

            'est_pris_en_charge' => $this->faker->boolean(),
            'hauteur_prise_en_charge' => $this->faker->numberBetween(1, 100),

            'sit_part_prevention_chute' => $this->faker->boolean(),
            'sit_part_education_therapeutique' => $this->faker->boolean(),
            'sit_part_grossesse' => $this->faker->boolean(),
            'sit_part_sedentarite' => $this->faker->boolean(),
            'sit_part_autre' => $this->faker->text(200),
            'qpv' => $this->faker->boolean(),
            'zrr' => $this->faker->boolean(),
            'intervalle' => $this->faker->randomElement(["3", "6"]),

            'regime' => $this->faker->numberBetween(1, 21),
            'code_postal_cpam' => "86000",

            'nom_mutuelle' => "MUTUELLE -", // début du nom de la mutuelle

            'check_autres_infos' => true, // meta-donnée pour informer la classe qui vérifie
            'role' => Permissions::EVALUATEUR, // meta-donnée pour informer la classe qui vérifie
        ]);
    }

    public function createPatientAsSecretaireMinimumData(
        AcceptanceTester $I,
        Login $loginPage,
        PatientAjout $patientAjoutPage
    ) {
        $email_connected = 'TestSecretaireNom@sportsante86.fr';

        $loginPage->login($email_connected, 'TestSecretaireNom.1@A');
        $patientAjoutPage->create([
            'nom_naissance' => $this->faker->lastName(),
            'premier_prenom_naissance' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement(["M", "F"]),
            'date_naissance' => $this->faker->date('Y-m-d', "2022-01-01"),
            'tel_fixe_patient' => $this->faker->numerify('0#########'),
            'adresse_patient' => $this->faker->streetAddress(),
            'code_postal_patient' => "86000",

            'est_pris_en_charge' => $this->faker->boolean(),
            'hauteur_prise_en_charge' => $this->faker->numberBetween(1, 100),

            'sit_part_prevention_chute' => $this->faker->boolean(),
            'sit_part_education_therapeutique' => $this->faker->boolean(),
            'sit_part_grossesse' => $this->faker->boolean(),
            'sit_part_sedentarite' => $this->faker->boolean(),
            'sit_part_autre' => $this->faker->text(200),
            'qpv' => $this->faker->boolean(),
            'zrr' => $this->faker->boolean(),
            'intervalle' => $this->faker->randomElement(["3", "6"]),

            'regime' => $this->faker->numberBetween(1, 21),
            'code_postal_cpam' => "86000",

            'check_autres_infos' => true, // meta-donnée pour informer la classe qui vérifie
            'role' => Permissions::SECRETAIRE, // meta-donnée pour informer la classe qui vérifie
            'email-connected' => $email_connected
        ]);
    }

    public function createPatientAsSecretaireAlldata(
        AcceptanceTester $I,
        Login $loginPage,
        PatientAjout $patientAjoutPage
    ) {
        $email_connected = 'TestSecretaireNom@sportsante86.fr';

        $loginPage->login($email_connected, 'TestSecretaireNom.1@A');
        $patientAjoutPage->create([
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

            //'code_insee_naissance' => $this->faker->numerify('#####'),
            'nom_utilise' => $this->faker->lastName(),
            'prenom_utilise' => $this->faker->firstName(),
            'liste_prenom_naissance' => $this->faker->firstName() . ' ' . $this->faker->firstName(),

            'nom_contact' => $this->faker->lastName(),
            'prenom_contact' => $this->faker->firstName(),
            'lien' => $this->faker->numberBetween(1, 17),
            'tel_fixe_contact' => $this->faker->numerify('0#########'),
            'tel_portable_contact' => $this->faker->numerify('0#########'),

            'est_pris_en_charge' => $this->faker->boolean(),
            'hauteur_prise_en_charge' => $this->faker->numberBetween(1, 100),

            'sit_part_prevention_chute' => $this->faker->boolean(),
            'sit_part_education_therapeutique' => $this->faker->boolean(),
            'sit_part_grossesse' => $this->faker->boolean(),
            'sit_part_sedentarite' => $this->faker->boolean(),
            'sit_part_autre' => $this->faker->text(200),
            'qpv' => $this->faker->boolean(),
            'zrr' => $this->faker->boolean(),
            'intervalle' => $this->faker->randomElement(["3", "6"]),

            'regime' => $this->faker->numberBetween(1, 21),
            'code_postal_cpam' => "86000",

            'nom_mutuelle' => "MUTUELLE -", // début du nom de la mutuelle

            'check_autres_infos' => true, // meta-donnée pour informer la classe qui vérifie
            'role' => Permissions::SECRETAIRE, // meta-donnée pour informer la classe qui vérifie
            'email-connected' => $email_connected
        ]);
    }
}