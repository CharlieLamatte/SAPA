<?php

namespace Tests\Unit;

use Dotenv\Dotenv;
use Faker\Factory;
use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Outils\EncryptionManager;
use Sportsante86\Sapa\Outils\Permissions;
use Tests\Support\UnitTester;

class PatientTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Patient $patient;

    private \Faker\Generator $faker;

    private string $root = __DIR__ . '/../..';

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->patient = new Patient($pdo);
        $this->assertNotNull($this->patient);

        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(1234);

        $dotenv = Dotenv::createImmutable($this->root);
        $dotenv->load();
        $dotenv->required([
            'ENVIRONNEMENT',
            'VERSION',
            'DATE',
            'KEY',
        ]);
    }

    protected function _after()
    {
    }

    public function testCreateOkMinimumData()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $patients_count_before = $this->tester->grabNumRecords('patients');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_before = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_before = $this->tester->grabNumRecords('parcours');
        $prescrit_count_before = $this->tester->grabNumRecords('prescrit');
        $traite_count_before = $this->tester->grabNumRecords('traite');
        $suit_count_before = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_before = $this->tester->grabNumRecords('oriente_vers');

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertNotFalse($id_patient, $this->patient->getErrorMessage());
        $patients_count_after = $this->tester->grabNumRecords('patients');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_after = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_after = $this->tester->grabNumRecords('parcours');
        $prescrit_count_after = $this->tester->grabNumRecords('prescrit');
        $traite_count_after = $this->tester->grabNumRecords('traite');
        $suit_count_after = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_after = $this->tester->grabNumRecords('oriente_vers');

        $this->assertEquals($patients_count_before + 1, $patients_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($coordonnees_count_before + 2, $coordonnees_count_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);
        $this->assertEquals($a_contacter_en_cas_urgence_count_before + 1, $a_contacter_en_cas_urgence_count_after);
        $this->assertEquals($parcours_count_before + 1, $parcours_count_after);
        $this->assertEquals($prescrit_count_before, $prescrit_count_after);
        $this->assertEquals($traite_count_before, $traite_count_after);
        $this->assertEquals($suit_count_before, $suit_count_after);
        $this->assertEquals($oriente_vers_count_before, $oriente_vers_count_after);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'date_admission' => $date_admission,
            'sexe' => $sexe_patient,
            'intervalle' => "3", // intervalle par défaut de 3 mois
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,

            'matricule_ins' => null,
            'oid' => null,
            'code_insee_naissance' => null,
            'nom_utilise' => "",
            'prenom_utilise' => "",
            'liste_prenom_naissance' => "",

            'id_type_piece_identite' => "1", // par défault 1 = 'Aucun'
            'id_type_statut_identite' => "1", // par défault 1 = 'Provisoire'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
            'mail_coordonnees' => "",
            'tel_portable_coordonnees' => "",
            'tel_fixe_coordonnees' => "",
        ]);

        $this->tester->seeInDatabase('parcours', [
            'nature_entretien_initial' => $nature_entretien,
            'id_patient' => $id_patient,
        ]);

        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'complement_adresse' => "",
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => '17', // lien par défaut est "Autre"
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => '',
            'prenom_coordonnees' => '',
            'id_coordonnees' => $id_coordonnee,
            'tel_portable_coordonnees' => '',
            'tel_fixe_coordonnees' => '',
        ]);
    }

    public function testCreateOkRoleIntervenant()
    {
        // intervenant
        $session = [
            'role_user_ids' => ['3'],
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $patients_count_before = $this->tester->grabNumRecords('patients');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_before = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_before = $this->tester->grabNumRecords('parcours');
        $prescrit_count_before = $this->tester->grabNumRecords('prescrit');
        $traite_count_before = $this->tester->grabNumRecords('traite');
        $suit_count_before = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_before = $this->tester->grabNumRecords('oriente_vers');

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertNotFalse($id_patient);
        $patients_count_after = $this->tester->grabNumRecords('patients');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_after = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_after = $this->tester->grabNumRecords('parcours');
        $prescrit_count_after = $this->tester->grabNumRecords('prescrit');
        $traite_count_after = $this->tester->grabNumRecords('traite');
        $suit_count_after = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_after = $this->tester->grabNumRecords('oriente_vers');

        $this->assertEquals($patients_count_before + 1, $patients_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($coordonnees_count_before + 2, $coordonnees_count_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);
        $this->assertEquals($a_contacter_en_cas_urgence_count_before + 1, $a_contacter_en_cas_urgence_count_after);
        $this->assertEquals($parcours_count_before + 1, $parcours_count_after);
        $this->assertEquals($prescrit_count_before, $prescrit_count_after);
        $this->assertEquals($traite_count_before, $traite_count_after);
        $this->assertEquals($suit_count_before, $suit_count_after);
        $this->assertEquals($oriente_vers_count_before + 1, $oriente_vers_count_after);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'date_admission' => $date_admission,
            'sexe' => $sexe_patient,
            'intervalle' => "3", // intervalle par défaut de 3 mois
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,

            'matricule_ins' => null,
            'oid' => null,
            'code_insee_naissance' => null,
            'nom_utilise' => "",
            'prenom_utilise' => "",
            'liste_prenom_naissance' => "",

            'id_type_piece_identite' => "1", // par défault 1 = 'Aucun'
            'id_type_statut_identite' => "1", // par défault 1 = 'Provisoire'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
            'mail_coordonnees' => "",
            'tel_portable_coordonnees' => "",
            'tel_fixe_coordonnees' => "",
        ]);

        $this->tester->seeInDatabase('parcours', [
            'nature_entretien_initial' => $nature_entretien,
            'id_patient' => $id_patient,
        ]);

        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'complement_adresse' => "",
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => '17', // lien par défaut est "Autre"
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => '',
            'prenom_coordonnees' => '',
            'id_coordonnees' => $id_coordonnee,
            'tel_portable_coordonnees' => '',
            'tel_fixe_coordonnees' => '',
        ]);
    }

    public function testCreateOkAllData1()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        // obligatoire
        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        // optionnel
        //$code_insee_naissance = "34567";
        $nom_utilise = "sdfgdf";
        $prenom_utilise = "sdfgsdfg";
        $liste_prenom_naissance = "sdfljko";

        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        $est_non_peps = "checked";
        $est_pris_en_charge = "checked";
        $hauteur_prise_en_charge = "90";
        $sit_part_prevention_chute = "YES";
        $sit_part_education_therapeutique = "YES";
        $sit_part_grossesse = "YES";
        $sit_part_sedentarite = "YES";
        $sit_part_autre = "Ydfgdfgg";
        $qpv = "YES";
        $zrr = "YES";
        $date_eval_suiv = "2023-10-10";
        $intervalle = "6";
        $id_medecin = "1";
        $memeMed = "NON";
        $id_med_traitant = "2";
        $id_autre_prof_sante = ["3"];
        $id_mutuelle = "1";

        $newUrgenceNom = "Toure";
        $newUrgencePrenom = "Bob";
        $id_lien = "4";
        $telUp = "0989876564";
        $telUf = "0389876564";

        $patients_count_before = $this->tester->grabNumRecords('patients');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_before = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_before = $this->tester->grabNumRecords('parcours');
        $prescrit_count_before = $this->tester->grabNumRecords('prescrit');
        $traite_count_before = $this->tester->grabNumRecords('traite');
        $suit_count_before = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_before = $this->tester->grabNumRecords('oriente_vers');
        //$reside_count_before = $this->tester->grabNumRecords('reside');

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,

            //'code_insee_naissance' => $code_insee_naissance,
            'nom_utilise' => $nom_utilise,
            'prenom_utilise' => $prenom_utilise,
            'liste_prenom_naissance' => $liste_prenom_naissance,

            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
            'est_pris_en_charge' => $est_pris_en_charge,
            'est_non_peps' => $est_non_peps,
            'hauteur_prise_en_charge' => $hauteur_prise_en_charge,
            'sit_part_prevention_chute' => $sit_part_prevention_chute,
            'sit_part_education_therapeutique' => $sit_part_education_therapeutique,
            'sit_part_grossesse' => $sit_part_grossesse,
            'sit_part_sedentarite' => $sit_part_sedentarite,
            'sit_part_autre' => $sit_part_autre,
            'qpv' => $qpv,
            'zrr' => $zrr,
            'id_mutuelle' => $id_mutuelle,
            'intervalle' => $intervalle,
            'date_eval_suiv' => $date_eval_suiv,

            'id_medecin' => $id_medecin,
            'meme_med' => $memeMed,
            'id_med_traitant' => $id_med_traitant,
            'id_autre' => $id_autre_prof_sante,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertNotFalse($id_patient);
        $patients_count_after = $this->tester->grabNumRecords('patients');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_after = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_after = $this->tester->grabNumRecords('parcours');
        $prescrit_count_after = $this->tester->grabNumRecords('prescrit');
        $traite_count_after = $this->tester->grabNumRecords('traite');
        $suit_count_after = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_after = $this->tester->grabNumRecords('oriente_vers');
        //$reside_count_after = $this->tester->grabNumRecords('reside');

        $this->assertEquals($patients_count_before + 1, $patients_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($coordonnees_count_before + 2, $coordonnees_count_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);
        $this->assertEquals($a_contacter_en_cas_urgence_count_before + 1, $a_contacter_en_cas_urgence_count_after);
        $this->assertEquals($parcours_count_before + 1, $parcours_count_after);
        $this->assertEquals($prescrit_count_before + 1, $prescrit_count_after);
        $this->assertEquals($traite_count_before + 1, $traite_count_after);
        $this->assertEquals($suit_count_before + 1, $suit_count_after);
        $this->assertEquals($oriente_vers_count_before, $oriente_vers_count_after);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'date_admission' => $date_admission,
            'sexe' => $sexe_patient,
            'intervalle' => $intervalle,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
            'est_non_peps' => '1',
            'est_pris_en_charge_financierement' => '1',
            'hauteur_prise_en_charge_financierement' => $hauteur_prise_en_charge,
            'sit_part_prevention_chute' => '1',
            'sit_part_education_therapeutique' => '1',
            'sit_part_grossesse' => '1',
            'sit_part_sedentarite' => '1',
            'est_dans_qpv' => '1',
            'est_dans_zrr' => '1',
            'sit_part_autre' => $sit_part_autre,
            'id_mutuelle' => $id_mutuelle,
            'date_eval_suiv' => $date_eval_suiv,

            'matricule_ins' => null,
            'oid' => null,
            'code_insee_naissance' => null,
            //'liste_prenom_naissance' => $liste_prenom_naissance,

            'id_type_piece_identite' => "1", // par défault 1 = 'Aucun'
            'id_type_statut_identite' => "1", // par défault 1 = 'Provisoire'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
//        $code_insee_naissance_encrypted = $this->tester->grabFromDatabase(
//            'patients',
//            'code_insee_naissance',
//            ['id_patient' => $id_patient]
//        );
        $nom_utilise_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_utilise',
            ['id_patient' => $id_patient]
        );
        $prenom_utilise_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'prenom_utilise',
            ['id_patient' => $id_patient]
        );
        $liste_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'liste_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );
//        $this->assertEqualsIgnoringCase(
//            $code_insee_naissance,
//            EncryptionManager::decrypt($code_insee_naissance_encrypted)
//        );
        $this->assertEqualsIgnoringCase(
            $nom_utilise,
            EncryptionManager::decrypt($nom_utilise_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $prenom_utilise,
            EncryptionManager::decrypt($prenom_utilise_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $liste_prenom_naissance,
            EncryptionManager::decrypt($liste_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $mail_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'mail_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_portable_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_fixe_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $this->assertEqualsIgnoringCase($email_patient, EncryptionManager::decrypt($mail_coordonnees_encrypted));
        $this->assertEqualsIgnoringCase(
            $tel_portable_patient,
            EncryptionManager::decrypt($tel_portable_coordonnees_encrypted)
        );
        $this->assertEqualsIgnoringCase($tel_fixe_patient, EncryptionManager::decrypt($tel_fixe_coordonnees_encrypted));

        $this->tester->seeInDatabase('parcours', [
            'nature_entretien_initial' => $nature_entretien,
            'id_patient' => $id_patient,
        ]);

        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $complement_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'complement_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));
        $this->assertEqualsIgnoringCase(
            $complement_adresse_patient,
            EncryptionManager::decrypt($complement_adresse_encrypted)
        );

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => $id_lien,
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee,
        ]);

        $nom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'nom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $prenom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'prenom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_portable_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_fixe_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );

        $this->assertEqualsIgnoringCase($newUrgenceNom, EncryptionManager::decrypt($nom_coordonnees_urgence_encrypted));
        $this->assertEqualsIgnoringCase(
            $newUrgencePrenom,
            EncryptionManager::decrypt($prenom_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $telUp,
            EncryptionManager::decrypt($tel_portable_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase($telUf, EncryptionManager::decrypt($tel_fixe_coordonnees_urgence_encrypted));

        $this->tester->seeInDatabase('prescrit', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_medecin,
        ]);

        $this->tester->seeInDatabase('traite', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_med_traitant,
        ]);

        foreach ($id_autre_prof_sante as $id_medecin) {
            $this->tester->seeInDatabase('suit', [
                'id_patient' => $id_patient,
                'id_medecin' => $id_medecin,
            ]);
        }
    }

    public function testCreateOkAllDataMaxCharLength()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        // obligatoire
        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = $this->faker->lexify(
            "????????????????????????????????????????????????????????????????????????????????????????????????????"
        ); // max 100
        $premier_prenom_naissance = $this->faker->lexify(
            "????????????????????????????????????????????????????????????????????????????????????????????????????"
        ); // max 100
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = $this->faker->text(200);
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        // optionnel
        //$code_insee_naissance = "34567";
        $nom_utilise = $this->faker->lexify(
            "????????????????????????????????????????????????????????????????????????????????????????????????????"
        ); // max 100
        $prenom_utilise = $this->faker->lexify(
            "????????????????????????????????????????????????????????????????????????????????????????????????????"
        ); // max 100
        $liste_prenom_naissance = $this->faker->lexify(
            "????????????????????????????????????????????????????????????????????????????????????????????????????"
        ); // max 100

        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = $this->faker->lexify(
            "???????????????????????????????????????????????????????????????????????????????????????@?????????.??"
        );  // max 100
        $complement_adresse_patient = $this->faker->text(200);

        $est_non_peps = "checked";
        $est_pris_en_charge = "checked";
        $hauteur_prise_en_charge = "90";
        $sit_part_prevention_chute = "YES";
        $sit_part_education_therapeutique = "YES";
        $sit_part_grossesse = "YES";
        $sit_part_sedentarite = "YES";
        $sit_part_autre = "Ydfgdfgg";
        $qpv = "YES";
        $zrr = "YES";
        $date_eval_suiv = "2023-10-10";
        $intervalle = "6";
        $id_medecin = "1";
        $memeMed = "NON";
        $id_med_traitant = "2";
        $id_autre_prof_sante = ["3"];
        $id_mutuelle = "1";

        $newUrgenceNom = $this->faker->text(100);
        $newUrgencePrenom = $this->faker->text(100);
        $id_lien = "4";
        $telUp = "0989876564";
        $telUf = "0389876564";

        $patients_count_before = $this->tester->grabNumRecords('patients');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_before = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_before = $this->tester->grabNumRecords('parcours');
        $prescrit_count_before = $this->tester->grabNumRecords('prescrit');
        $traite_count_before = $this->tester->grabNumRecords('traite');
        $suit_count_before = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_before = $this->tester->grabNumRecords('oriente_vers');
        //$reside_count_before = $this->tester->grabNumRecords('reside');

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,

            //'code_insee_naissance' => $code_insee_naissance,
            'nom_utilise' => $nom_utilise,
            'prenom_utilise' => $prenom_utilise,
            'liste_prenom_naissance' => $liste_prenom_naissance,

            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
            'est_pris_en_charge' => $est_pris_en_charge,
            'est_non_peps' => $est_non_peps,
            'hauteur_prise_en_charge' => $hauteur_prise_en_charge,
            'sit_part_prevention_chute' => $sit_part_prevention_chute,
            'sit_part_education_therapeutique' => $sit_part_education_therapeutique,
            'sit_part_grossesse' => $sit_part_grossesse,
            'sit_part_sedentarite' => $sit_part_sedentarite,
            'sit_part_autre' => $sit_part_autre,
            'qpv' => $qpv,
            'zrr' => $zrr,
            'id_mutuelle' => $id_mutuelle,
            'intervalle' => $intervalle,
            'date_eval_suiv' => $date_eval_suiv,

            'id_medecin' => $id_medecin,
            'meme_med' => $memeMed,
            'id_med_traitant' => $id_med_traitant,
            'id_autre' => $id_autre_prof_sante,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertNotFalse($id_patient);
        $patients_count_after = $this->tester->grabNumRecords('patients');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_after = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_after = $this->tester->grabNumRecords('parcours');
        $prescrit_count_after = $this->tester->grabNumRecords('prescrit');
        $traite_count_after = $this->tester->grabNumRecords('traite');
        $suit_count_after = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_after = $this->tester->grabNumRecords('oriente_vers');
        //$reside_count_after = $this->tester->grabNumRecords('reside');

        $this->assertEquals($patients_count_before + 1, $patients_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($coordonnees_count_before + 2, $coordonnees_count_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);
        $this->assertEquals($a_contacter_en_cas_urgence_count_before + 1, $a_contacter_en_cas_urgence_count_after);
        $this->assertEquals($parcours_count_before + 1, $parcours_count_after);
        $this->assertEquals($prescrit_count_before + 1, $prescrit_count_after);
        $this->assertEquals($traite_count_before + 1, $traite_count_after);
        $this->assertEquals($suit_count_before + 1, $suit_count_after);
        $this->assertEquals($oriente_vers_count_before, $oriente_vers_count_after);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'date_admission' => $date_admission,
            'sexe' => $sexe_patient,
            'intervalle' => $intervalle,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
            'est_non_peps' => '1',
            'est_pris_en_charge_financierement' => '1',
            'hauteur_prise_en_charge_financierement' => $hauteur_prise_en_charge,
            'sit_part_prevention_chute' => '1',
            'sit_part_education_therapeutique' => '1',
            'sit_part_grossesse' => '1',
            'sit_part_sedentarite' => '1',
            'est_dans_qpv' => '1',
            'est_dans_zrr' => '1',
            'sit_part_autre' => $sit_part_autre,
            'id_mutuelle' => $id_mutuelle,
            'date_eval_suiv' => $date_eval_suiv,

            'matricule_ins' => null,
            'oid' => null,
            'code_insee_naissance' => null,
            //'liste_prenom_naissance' => null,

            'id_type_piece_identite' => "1", // par défault 1 = 'Aucun'
            'id_type_statut_identite' => "1", // par défault 1 = 'Provisoire'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $matricule_ins_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'matricule_ins',
            ['id_patient' => $id_patient]
        );
        $oid_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'oid',
            ['id_patient' => $id_patient]
        );
        $code_insee_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'code_insee_naissance',
            ['id_patient' => $id_patient]
        );
        $nom_utilise_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_utilise',
            ['id_patient' => $id_patient]
        );
        $prenom_utilise_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'prenom_utilise',
            ['id_patient' => $id_patient]
        );
        $liste_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'liste_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );
//        $this->assertEqualsIgnoringCase(
//            $code_insee_naissance,
//            EncryptionManager::decrypt($code_insee_naissance_encrypted)
//        );
        $this->assertEqualsIgnoringCase(
            $nom_utilise,
            EncryptionManager::decrypt($nom_utilise_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $prenom_utilise,
            EncryptionManager::decrypt($prenom_utilise_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $liste_prenom_naissance,
            EncryptionManager::decrypt($liste_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $mail_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'mail_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_portable_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_fixe_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $this->assertEqualsIgnoringCase($email_patient, EncryptionManager::decrypt($mail_coordonnees_encrypted));
        $this->assertEqualsIgnoringCase(
            $tel_portable_patient,
            EncryptionManager::decrypt($tel_portable_coordonnees_encrypted)
        );
        $this->assertEqualsIgnoringCase($tel_fixe_patient, EncryptionManager::decrypt($tel_fixe_coordonnees_encrypted));

        $this->tester->seeInDatabase('parcours', [
            'nature_entretien_initial' => $nature_entretien,
            'id_patient' => $id_patient,
        ]);

        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $complement_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'complement_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));
        $this->assertEqualsIgnoringCase(
            $complement_adresse_patient,
            EncryptionManager::decrypt($complement_adresse_encrypted)
        );

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => $id_lien,
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee,
        ]);

        $nom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'nom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $prenom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'prenom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_portable_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_fixe_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );

        $this->assertEqualsIgnoringCase($newUrgenceNom, EncryptionManager::decrypt($nom_coordonnees_urgence_encrypted));
        $this->assertEqualsIgnoringCase(
            $newUrgencePrenom,
            EncryptionManager::decrypt($prenom_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $telUp,
            EncryptionManager::decrypt($tel_portable_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase($telUf, EncryptionManager::decrypt($tel_fixe_coordonnees_urgence_encrypted));

        $this->tester->seeInDatabase('prescrit', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_medecin,
        ]);

        $this->tester->seeInDatabase('traite', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_med_traitant,
        ]);

        foreach ($id_autre_prof_sante as $id_medecin) {
            $this->tester->seeInDatabase('suit', [
                'id_patient' => $id_patient,
                'id_medecin' => $id_medecin,
            ]);
        }
    }

    public function testCreateOkAllDataId_autre_prof_santeContainsInvalidData()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        // obligatoire
        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        // optionnel
        //$code_insee_naissance = "34567";
        $nom_utilise = "sdfgdf";
        $prenom_utilise = "sdfgsdfg";
        $liste_prenom_naissance = "sdfljko";

        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        $est_non_peps = "checked";
        $est_pris_en_charge = "checked";
        $hauteur_prise_en_charge = "90";
        $sit_part_prevention_chute = "YES";
        $sit_part_education_therapeutique = "YES";
        $sit_part_grossesse = "YES";
        $sit_part_sedentarite = "YES";
        $sit_part_autre = "Ydfgdfgg";
        $qpv = "YES";
        $zrr = "YES";
        $date_eval_suiv = "2023-10-10";
        $intervalle = "6";
        $id_medecin = "1";
        $memeMed = "NON";
        $id_med_traitant = "2";
        $id_autre_prof_sante = ["3", "", "sqdf"];
        $id_mutuelle = "1";

        $newUrgenceNom = "Toure";
        $newUrgencePrenom = "Bob";
        $id_lien = "4";
        $telUp = "0989876564";
        $telUf = "0389876564";

        // filtered data
        $id_autre_prof_sante_expected = ["3"];

        $patients_count_before = $this->tester->grabNumRecords('patients');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_before = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_before = $this->tester->grabNumRecords('parcours');
        $prescrit_count_before = $this->tester->grabNumRecords('prescrit');
        $traite_count_before = $this->tester->grabNumRecords('traite');
        $suit_count_before = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_before = $this->tester->grabNumRecords('oriente_vers');
        //$reside_count_before = $this->tester->grabNumRecords('reside');

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,

            //'code_insee_naissance' => $code_insee_naissance,
            'nom_utilise' => $nom_utilise,
            'prenom_utilise' => $prenom_utilise,
            'liste_prenom_naissance' => $liste_prenom_naissance,

            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
            'est_pris_en_charge' => $est_pris_en_charge,
            'est_non_peps' => $est_non_peps,
            'hauteur_prise_en_charge' => $hauteur_prise_en_charge,
            'sit_part_prevention_chute' => $sit_part_prevention_chute,
            'sit_part_education_therapeutique' => $sit_part_education_therapeutique,
            'sit_part_grossesse' => $sit_part_grossesse,
            'sit_part_sedentarite' => $sit_part_sedentarite,
            'sit_part_autre' => $sit_part_autre,
            'qpv' => $qpv,
            'zrr' => $zrr,
            'id_mutuelle' => $id_mutuelle,
            'intervalle' => $intervalle,
            'date_eval_suiv' => $date_eval_suiv,

            'id_medecin' => $id_medecin,
            'meme_med' => $memeMed,
            'id_med_traitant' => $id_med_traitant,
            'id_autre' => $id_autre_prof_sante,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertNotFalse($id_patient, $this->patient->getErrorMessage());
        $patients_count_after = $this->tester->grabNumRecords('patients');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_after = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_after = $this->tester->grabNumRecords('parcours');
        $prescrit_count_after = $this->tester->grabNumRecords('prescrit');
        $traite_count_after = $this->tester->grabNumRecords('traite');
        $suit_count_after = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_after = $this->tester->grabNumRecords('oriente_vers');
        //$reside_count_after = $this->tester->grabNumRecords('reside');

        $this->assertEquals($patients_count_before + 1, $patients_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($coordonnees_count_before + 2, $coordonnees_count_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);
        $this->assertEquals($a_contacter_en_cas_urgence_count_before + 1, $a_contacter_en_cas_urgence_count_after);
        $this->assertEquals($parcours_count_before + 1, $parcours_count_after);
        $this->assertEquals($prescrit_count_before + 1, $prescrit_count_after);
        $this->assertEquals($traite_count_before + 1, $traite_count_after);
        $this->assertEquals($suit_count_before + 1, $suit_count_after);
        $this->assertEquals($oriente_vers_count_before, $oriente_vers_count_after);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'date_admission' => $date_admission,
            'sexe' => $sexe_patient,
            'intervalle' => $intervalle,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
            'est_non_peps' => '1',
            'est_pris_en_charge_financierement' => '1',
            'hauteur_prise_en_charge_financierement' => $hauteur_prise_en_charge,
            'sit_part_prevention_chute' => '1',
            'sit_part_education_therapeutique' => '1',
            'sit_part_grossesse' => '1',
            'sit_part_sedentarite' => '1',
            'est_dans_qpv' => '1',
            'est_dans_zrr' => '1',
            'sit_part_autre' => $sit_part_autre,
            'id_mutuelle' => $id_mutuelle,
            'date_eval_suiv' => $date_eval_suiv,

            'matricule_ins' => null,
            'oid' => null,
            'code_insee_naissance' => null,
            //'liste_prenom_naissance' => null,

            'id_type_piece_identite' => "1", // par défault 1 = 'Aucun'
            'id_type_statut_identite' => "1", // par défault 1 = 'Provisoire'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );

        $matricule_ins_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'matricule_ins',
            ['id_patient' => $id_patient]
        );
        $oid_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'oid',
            ['id_patient' => $id_patient]
        );
        $code_insee_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'code_insee_naissance',
            ['id_patient' => $id_patient]
        );
        $nom_utilise_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_utilise',
            ['id_patient' => $id_patient]
        );
        $prenom_utilise_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'prenom_utilise',
            ['id_patient' => $id_patient]
        );
        $liste_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'liste_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );
//        $this->assertEqualsIgnoringCase(
//            $code_insee_naissance,
//            EncryptionManager::decrypt($code_insee_naissance_encrypted)
//        );
        $this->assertEqualsIgnoringCase(
            $nom_utilise,
            EncryptionManager::decrypt($nom_utilise_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $prenom_utilise,
            EncryptionManager::decrypt($prenom_utilise_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $liste_prenom_naissance,
            EncryptionManager::decrypt($liste_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $mail_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'mail_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_portable_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_fixe_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $this->assertEqualsIgnoringCase($email_patient, EncryptionManager::decrypt($mail_coordonnees_encrypted));
        $this->assertEqualsIgnoringCase(
            $tel_portable_patient,
            EncryptionManager::decrypt($tel_portable_coordonnees_encrypted)
        );
        $this->assertEqualsIgnoringCase($tel_fixe_patient, EncryptionManager::decrypt($tel_fixe_coordonnees_encrypted));

        $this->tester->seeInDatabase('parcours', [
            'nature_entretien_initial' => $nature_entretien,
            'id_patient' => $id_patient,
        ]);

        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $complement_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'complement_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));
        $this->assertEqualsIgnoringCase(
            $complement_adresse_patient,
            EncryptionManager::decrypt($complement_adresse_encrypted)
        );

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => $id_lien,
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee,
        ]);


        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $complement_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'complement_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));
        $this->assertEqualsIgnoringCase(
            $complement_adresse_patient,
            EncryptionManager::decrypt($complement_adresse_encrypted)
        );


        $nom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'nom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $prenom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'prenom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_portable_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_fixe_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );

        $this->assertEqualsIgnoringCase($newUrgenceNom, EncryptionManager::decrypt($nom_coordonnees_urgence_encrypted));
        $this->assertEqualsIgnoringCase(
            $newUrgencePrenom,
            EncryptionManager::decrypt($prenom_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $telUp,
            EncryptionManager::decrypt($tel_portable_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase($telUf, EncryptionManager::decrypt($tel_fixe_coordonnees_urgence_encrypted));

        $this->tester->seeInDatabase('prescrit', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_medecin,
        ]);

        $this->tester->seeInDatabase('traite', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_med_traitant,
        ]);

        foreach ($id_autre_prof_sante_expected as $id_medecin) {
            $this->tester->seeInDatabase('suit', [
                'id_patient' => $id_patient,
                'id_medecin' => $id_medecin,
            ]);
        }
    }

    public function testCreateOkAllDataAutresInfosNull()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        // obligatoire
        $date_admission = "2029-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        // optionnel
        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        $est_non_peps = null;
        $est_pris_en_charge = null;
        $hauteur_prise_en_charge = null;
        $sit_part_prevention_chute = null;
        $sit_part_education_therapeutique = null;
        $sit_part_grossesse = null;
        $sit_part_sedentarite = null;
        $sit_part_autre = null;
        $qpv = null;
        $zrr = null;
        $date_eval_suiv = null;
        $intervalle = "6";
        $id_medecin = "1";
        $memeMed = "NON";
        $id_med_traitant = "2";
        $id_autre_prof_sante = ["3"];
        $id_mutuelle = "1";

        $newUrgenceNom = "Toure";
        $newUrgencePrenom = "Bob";
        $id_lien = "4";
        $telUp = "0989876564";
        $telUf = "0389876564";

        $patients_count_before = $this->tester->grabNumRecords('patients');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_before = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_before = $this->tester->grabNumRecords('parcours');
        $prescrit_count_before = $this->tester->grabNumRecords('prescrit');
        $traite_count_before = $this->tester->grabNumRecords('traite');
        $suit_count_before = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_before = $this->tester->grabNumRecords('oriente_vers');

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
            'est_non_peps' => $est_non_peps,
            'est_pris_en_charge' => $est_pris_en_charge,
            'hauteur_prise_en_charge' => $hauteur_prise_en_charge,
            'sit_part_prevention_chute' => $sit_part_prevention_chute,
            'sit_part_education_therapeutique' => $sit_part_education_therapeutique,
            'sit_part_grossesse' => $sit_part_grossesse,
            'sit_part_sedentarite' => $sit_part_sedentarite,
            'sit_part_autre' => $sit_part_autre,
            'qpv' => $qpv,
            'zrr' => $zrr,
            'id_mutuelle' => $id_mutuelle,
            'intervalle' => $intervalle,
            'date_eval_suiv' => $date_eval_suiv,

            'id_medecin' => $id_medecin,
            'meme_med' => $memeMed,
            'id_med_traitant' => $id_med_traitant,
            'id_autre' => $id_autre_prof_sante,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertNotFalse($id_patient);
        $patients_count_after = $this->tester->grabNumRecords('patients');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $a_contacter_en_cas_urgence_count_after = $this->tester->grabNumRecords('a_contacter_en_cas_urgence');
        $parcours_count_after = $this->tester->grabNumRecords('parcours');
        $prescrit_count_after = $this->tester->grabNumRecords('prescrit');
        $traite_count_after = $this->tester->grabNumRecords('traite');
        $suit_count_after = $this->tester->grabNumRecords('suit');
        $oriente_vers_count_after = $this->tester->grabNumRecords('oriente_vers');

        $this->assertEquals($patients_count_before + 1, $patients_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($coordonnees_count_before + 2, $coordonnees_count_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);
        $this->assertEquals($a_contacter_en_cas_urgence_count_before + 1, $a_contacter_en_cas_urgence_count_after);
        $this->assertEquals($parcours_count_before + 1, $parcours_count_after);
        $this->assertEquals($prescrit_count_before + 1, $prescrit_count_after);
        $this->assertEquals($traite_count_before + 1, $traite_count_after);
        $this->assertEquals($suit_count_before + 1, $suit_count_after);
        $this->assertEquals($oriente_vers_count_before, $oriente_vers_count_after);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'date_admission' => $date_admission,
            'sexe' => $sexe_patient,
            'intervalle' => $intervalle,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
            'est_pris_en_charge_financierement' => '0',
            'est_non_peps' => '0',
            'hauteur_prise_en_charge_financierement' => null,
            'sit_part_prevention_chute' => '0',
            'sit_part_education_therapeutique' => '0',
            'sit_part_grossesse' => '0',
            'sit_part_sedentarite' => '0',
            'est_dans_qpv' => '0',
            'est_dans_zrr' => '0',
            'sit_part_autre' => '',
            'id_mutuelle' => $id_mutuelle,
            'date_eval_suiv' => $date_eval_suiv,

            'matricule_ins' => null,
            'oid' => null,
            'code_insee_naissance' => null,
            'nom_utilise' => "",
            'prenom_utilise' => "",
            //'liste_prenom_naissance' => null,

            'id_type_piece_identite' => "1", // par défault 1 = 'Aucun'
            'id_type_statut_identite' => "1", // par défault 1 = 'Provisoire'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $mail_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'mail_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_portable_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_fixe_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $this->assertEqualsIgnoringCase($email_patient, EncryptionManager::decrypt($mail_coordonnees_encrypted));
        $this->assertEqualsIgnoringCase(
            $tel_portable_patient,
            EncryptionManager::decrypt($tel_portable_coordonnees_encrypted)
        );
        $this->assertEqualsIgnoringCase($tel_fixe_patient, EncryptionManager::decrypt($tel_fixe_coordonnees_encrypted));

        $this->tester->seeInDatabase('parcours', [
            'nature_entretien_initial' => $nature_entretien,
            'id_patient' => $id_patient,
        ]);

        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $complement_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'complement_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));
        $this->assertEqualsIgnoringCase(
            $complement_adresse_patient,
            EncryptionManager::decrypt($complement_adresse_encrypted)
        );

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => $id_lien,
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee,
        ]);

        $nom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'nom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $prenom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'prenom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_portable_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_fixe_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );

        $this->assertEqualsIgnoringCase($newUrgenceNom, EncryptionManager::decrypt($nom_coordonnees_urgence_encrypted));
        $this->assertEqualsIgnoringCase(
            $newUrgencePrenom,
            EncryptionManager::decrypt($prenom_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $telUp,
            EncryptionManager::decrypt($tel_portable_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase($telUf, EncryptionManager::decrypt($tel_fixe_coordonnees_urgence_encrypted));

        $this->tester->seeInDatabase('prescrit', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_medecin,
        ]);

        $this->tester->seeInDatabase('traite', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_med_traitant,
        ]);

        $this->tester->seeInDatabase('suit', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_autre_prof_sante[0],
        ]);
    }

    public function testCreateNotOkMissingDateAdmission()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = null;
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingNatureEntretien()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = null;
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingNom()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingPrenom()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingId_territoire()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingId_user()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingId_structure()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingSexe()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = ""; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingDateDeNaissance()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingAdressePatient()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingCodePostalPatient()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingVillePatient()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingRegimeAssuranceMaladie()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingVilleAssuranceMaladie()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "86000";
        $ville_assurance_maladie = "";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testCreateNotOkMissingCodePostalAssuranceMaladie()
    {
        // coordo PEPS
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];

        $date_admission = "2022-03-03";
        $nature_entretien = "present";
        $nom_naissance = "Small";
        $premier_prenom_naissance = "Josian";
        $sexe_patient = "H"; // homme
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $regime_assurance_maladie = "15";
        $code_postal_assurance_maladie = "";
        $ville_assurance_maladie = "POITIERS";

        $id_structure = "1";
        $id_user = "2";
        $id_territoire = "1";

        $id_patient = $this->patient->create(new Permissions($session), [
            'date_admission' => $date_admission,
            'nature_entretien' => $nature_entretien,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'regime_assurance_maladie' => $regime_assurance_maladie,
            'ville_assurance_maladie' => $ville_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'id_structure' => $id_structure,
            'id_user' => $id_user,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertFalse($id_patient);
    }

    public function testsetArchiveStatusOk()
    {
        // update 1 => archiving patient
        $id_patient = "1";
        $is_archived = true;

        $update_status_ok = $this->patient->setArchiveStatus($id_patient, $is_archived);

        $this->assertTrue($update_status_ok);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'est_archive' => "1",
        ]);

        // update 2 => restoring patient
        $id_patient = "1";
        $is_archived = false;

        $update_status_ok = $this->patient->setArchiveStatus($id_patient, $is_archived);

        $this->assertTrue($update_status_ok);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'est_archive' => "0",
        ]);
    }

    public function testsetArchiveStatusNotOkId_patientNull()
    {
        $id_patient = null;
        $is_archived = true;

        $update_status_ok = $this->patient->setArchiveStatus($id_patient, $is_archived);

        $this->assertFalse($update_status_ok);
    }

    public function testsetArchiveStatusNotOkIs_archivedNull()
    {
        $id_patient = "1";
        $is_archived = null;

        $update_status_ok = $this->patient->setArchiveStatus($id_patient, $is_archived);

        $this->assertFalse($update_status_ok);
    }

    public function testsetArchiveStatusNotOkId_patientNullAndIs_archivedNull()
    {
        $id_patient = null;
        $is_archived = null;

        $update_status_ok = $this->patient->setArchiveStatus($id_patient, $is_archived);

        $this->assertFalse($update_status_ok);
    }

    public function testsetArchiveStatusNotOkId_patientInvalid()
    {
        $id_patient = "-1";
        $is_archived = true;

        $update_status_ok = $this->patient->setArchiveStatus($id_patient, $is_archived);

        $this->assertFalse($update_status_ok);
    }

    public function testUpdateSuiviMedicalNotOkId_patientNull()
    {
        // obligatoire
        $id_patient = null;
        $regime_assurance_maladie = "1";
        $code_postal_assurance_maladie = "86100";
        $ville_assurance_maladie = "CHATELLERAULT";

        $update_ok = $this->patient->updateSuiviMedical([
            'id_patient' => $id_patient,
            'id_caisse_assurance_maladie' => $regime_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'ville_cpam' => $ville_assurance_maladie,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateSuiviMedicalNotOkRegime_assurance_maladieNull()
    {
        // obligatoire
        $id_patient = "1";
        $regime_assurance_maladie = null;
        $code_postal_assurance_maladie = "86100";
        $ville_assurance_maladie = "CHATELLERAULT";

        $update_ok = $this->patient->updateSuiviMedical([
            'id_patient' => $id_patient,
            'id_caisse_assurance_maladie' => $regime_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'ville_cpam' => $ville_assurance_maladie,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateSuiviMedicalNotOkCode_postal_assurance_maladieNull()
    {
        // obligatoire
        $id_patient = "1";
        $regime_assurance_maladie = "1";
        $code_postal_assurance_maladie = null;
        $ville_assurance_maladie = "CHATELLERAULT";

        $update_ok = $this->patient->updateSuiviMedical([
            'id_patient' => $id_patient,
            'id_caisse_assurance_maladie' => $regime_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'ville_cpam' => $ville_assurance_maladie,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateSuiviMedicalNotOkVille_assurance_maladieNull()
    {
        // obligatoire
        $id_patient = "1";
        $regime_assurance_maladie = "1";
        $code_postal_assurance_maladie = "86100";
        $ville_assurance_maladie = null;

        $update_ok = $this->patient->updateSuiviMedical([
            'id_patient' => $id_patient,
            'id_caisse_assurance_maladie' => $regime_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'ville_cpam' => $ville_assurance_maladie,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateSuiviMedicalOkMinimumData()
    {
        // obligatoire
        $id_patient = "1";
        $regime_assurance_maladie = "1";
        $code_postal_assurance_maladie = "86100";
        $ville_assurance_maladie = "CHATELLERAULT";

        $update_ok = $this->patient->updateSuiviMedical([
            'id_patient' => $id_patient,
            'id_caisse_assurance_maladie' => $regime_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'ville_cpam' => $ville_assurance_maladie,
        ]);

        $this->assertTrue($update_ok);

        $id_ville = $this->tester->grabFromDatabase(
            'villes',
            'id_ville',
            ['nom_ville' => $ville_assurance_maladie, 'code_postal' => $code_postal_assurance_maladie]
        );

        $id_reside = $this->tester->grabFromDatabase(
            'reside',
            'id_reside',
            ['id_caisse_assurance_maladie' => $regime_assurance_maladie, 'id_ville' => $id_ville]
        );

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'id_reside' => $id_reside,
        ]);

        $this->tester->dontSeeInDatabase('prescrit', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->dontSeeInDatabase('traite', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->dontSeeInDatabase('suit', [
            'id_patient' => $id_patient,
        ]);
    }

    public function testUpdateSuiviMedicalOkAllData()
    {
        // obligatoire
        $id_patient = "1";
        $regime_assurance_maladie = "1";
        $code_postal_assurance_maladie = "86100";
        $ville_assurance_maladie = "CHATELLERAULT";

        // optionnel
        $id_med_traitant = "2";
        $id_med_prescripteur = "1";
        $autre_prof_sante = ["3"];
        $id_mutuelle = "1";

        $update_ok = $this->patient->updateSuiviMedical([
            'id_patient' => $id_patient,
            'id_med' => $id_med_prescripteur,
            'id_med_traitant' => $id_med_traitant,
            'id_autre' => $autre_prof_sante,
            'id_mutuelle' => $id_mutuelle,
            'id_caisse_assurance_maladie' => $regime_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'ville_cpam' => $ville_assurance_maladie,
        ]);

        $this->assertTrue($update_ok);

        $id_ville = $this->tester->grabFromDatabase(
            'villes',
            'id_ville',
            ['nom_ville' => $ville_assurance_maladie, 'code_postal' => $code_postal_assurance_maladie]
        );

        $id_reside = $this->tester->grabFromDatabase(
            'reside',
            'id_reside',
            ['id_caisse_assurance_maladie' => $regime_assurance_maladie, 'id_ville' => $id_ville]
        );

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'id_reside' => $id_reside,
        ]);

        $this->tester->seeInDatabase('prescrit', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_med_prescripteur,
        ]);

        $this->tester->seeInDatabase('traite', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_med_traitant,
        ]);

        foreach ($autre_prof_sante as $id_autre_prof_sante) {
            $this->tester->seeInDatabase('suit', [
                'id_patient' => $id_patient,
                'id_medecin' => $id_autre_prof_sante,
            ]);
        }
    }

    public function testUpdateSuiviMedicalOkAllDataId_autre_prof_santeContainsInvalidData()
    {
        // obligatoire
        $id_patient = "1";
        $regime_assurance_maladie = "1";
        $code_postal_assurance_maladie = "86100";
        $ville_assurance_maladie = "CHATELLERAULT";

        // optionnel
        $id_med_traitant = "2";
        $id_med_prescripteur = "1";
        $autre_prof_sante = ["3", "", "zsd"];
        $id_mutuelle = "1";

        // filtered data
        $autre_prof_sante_expected = ["3"];

        $update_ok = $this->patient->updateSuiviMedical([
            'id_patient' => $id_patient,
            'id_med' => $id_med_prescripteur,
            'id_med_traitant' => $id_med_traitant,
            'id_autre' => $autre_prof_sante,
            'id_mutuelle' => $id_mutuelle,
            'id_caisse_assurance_maladie' => $regime_assurance_maladie,
            'code_postal_assurance_maladie' => $code_postal_assurance_maladie,
            'ville_cpam' => $ville_assurance_maladie,
        ]);

        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $id_ville = $this->tester->grabFromDatabase(
            'villes',
            'id_ville',
            ['nom_ville' => $ville_assurance_maladie, 'code_postal' => $code_postal_assurance_maladie]
        );

        $id_reside = $this->tester->grabFromDatabase(
            'reside',
            'id_reside',
            ['id_caisse_assurance_maladie' => $regime_assurance_maladie, 'id_ville' => $id_ville]
        );

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'id_reside' => $id_reside,
        ]);

        $this->tester->seeInDatabase('prescrit', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_med_prescripteur,
        ]);

        $this->tester->seeInDatabase('traite', [
            'id_patient' => $id_patient,
            'id_medecin' => $id_med_traitant,
        ]);

        $suit_count = $this->tester->grabNumRecords('suit', ['id_patient' => $id_patient]);
        $this->assertEquals(count($autre_prof_sante_expected), $suit_count);

        foreach ($autre_prof_sante_expected as $id_autre_prof_sante) {
            $this->tester->seeInDatabase('suit', [
                'id_patient' => $id_patient,
                'id_medecin' => $id_autre_prof_sante,
            ]);
        }
    }

    public function testUpdateCoordonneesOkMinimumData1()
    {
        // obligatoire
        $id_patient = "1";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'sexe_patient' => $sexe_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'sexe' => $sexe_patient,

            'matricule_ins' => "",
            'oid' => "",
            'code_insee_naissance' => "",
            'nom_utilise' => "",
            'prenom_utilise' => "",
            'liste_prenom_naissance' => "",
            'id_type_statut_identite' => "1", // 'Provisoire'
            'id_type_piece_identite' => "1", // 'Aucun'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );

        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
            'mail_coordonnees' => "",
            'tel_portable_coordonnees' => "",
            'tel_fixe_coordonnees' => "",
        ]);

        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'complement_adresse' => "",
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => "17", // valeur par défaut
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => "",
            'prenom_coordonnees' => "",
            'id_coordonnees' => $id_coordonnee,
            'tel_portable_coordonnees' => "",
            'tel_fixe_coordonnees' => "",
        ]);
    }

    public function testUpdateCoordonneesOkMinimumData2()
    {
        // obligatoire
        $id_patient = "1";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        // optionnel
        //$code_insee_naissance = "";
        $nom_utilise = "";
        $prenom_utilise = "";
        $liste_prenom_naissance = "";

        $tel_fixe_patient = "";
        $tel_portable_patient = "";
        $email_patient = "";
        $complement_adresse_patient = "";

        // contact urgence
        $newUrgenceNom = "";
        $newUrgencePrenom = "";
        $id_lien = "";
        $telUp = "";
        $telUf = "";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            //'code_insee_naissance' => $code_insee_naissance,
            'nom_utilise' => $nom_utilise,
            'prenom_utilise' => $prenom_utilise,
            'liste_prenom_naissance' => $liste_prenom_naissance,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'sexe' => $sexe_patient,

            //'code_insee_naissance' => "",
            'nom_utilise' => "",
            'prenom_utilise' => "",
            'liste_prenom_naissance' => "",
            'id_type_statut_identite' => "1", // 'Provisoire'
            'id_type_piece_identite' => "1", // 'Aucun'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );

        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
            'mail_coordonnees' => "",
            'tel_portable_coordonnees' => "",
            'tel_fixe_coordonnees' => "",
        ]);

        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'complement_adresse' => "",
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => "17", // valeur par défaut
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => "",
            'prenom_coordonnees' => "",
            'id_coordonnees' => $id_coordonnee,
            'tel_portable_coordonnees' => "",
            'tel_fixe_coordonnees' => "",
        ]);
    }

    public function testUpdateCoordonneesOkMinimumDataNoVilleBefore()
    {
        // obligatoire
        $id_patient = "7";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86100";
        $ville_patient = "CHATELLERAULT";

        // vérifier que le patient n'a pas de ville
        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);
        $this->assertNotEmpty($id_adresse);
        $this->tester->dontSeeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'sexe_patient' => $sexe_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'sexe' => $sexe_patient,
            'id_type_statut_identite' => "1", // 'Provisoire'
            'id_type_piece_identite' => "1", // 'Aucun'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
            'mail_coordonnees' => "",
            'tel_portable_coordonnees' => "",
            'tel_fixe_coordonnees' => "",
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'complement_adresse' => "",
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => "17", // valeur par défaut
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => "",
            'prenom_coordonnees' => "",
            'id_coordonnees' => $id_coordonnee,
            'tel_portable_coordonnees' => "",
            'tel_fixe_coordonnees' => "",
        ]);
    }

    public function testUpdateCoordonneesOkAllData()
    {
        // obligatoire
        $id_patient = "1";
        $nom_naissance = "Hdfyfg";
        $premier_prenom_naissance = "cvbnvbn";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        // optionnel
        $code_insee_naissance = "34567";
        $nom_utilise = "sdfgdf";
        $prenom_utilise = "sdfgsdfg";
        $liste_prenom_naissance = "sdfljko";

        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        // contact urgence
        $newUrgenceNom = "Tourev";
        $newUrgencePrenom = "Bobv";
        $id_lien = "3";
        $telUp = "0989846564";
        $telUf = "0389836564";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            'code_insee_naissance' => $code_insee_naissance,
            'nom_utilise' => $nom_utilise,
            'prenom_utilise' => $prenom_utilise,
            'liste_prenom_naissance' => $liste_prenom_naissance,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'sexe' => $sexe_patient,
            'id_type_statut_identite' => "1", // 'Provisoire'
            'id_type_piece_identite' => "1", // 'Aucun'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $code_insee_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'code_insee_naissance',
            ['id_patient' => $id_patient]
        );
        $nom_utilise_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_utilise',
            ['id_patient' => $id_patient]
        );
        $prenom_utilise_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'prenom_utilise',
            ['id_patient' => $id_patient]
        );
        $liste_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'liste_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $code_insee_naissance,
            EncryptionManager::decrypt($code_insee_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $nom_utilise,
            EncryptionManager::decrypt($nom_utilise_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $prenom_utilise,
            EncryptionManager::decrypt($prenom_utilise_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $liste_prenom_naissance,
            EncryptionManager::decrypt($liste_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $mail_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'mail_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_portable_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_fixe_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $this->assertEqualsIgnoringCase($email_patient, EncryptionManager::decrypt($mail_coordonnees_encrypted));
        $this->assertEqualsIgnoringCase(
            $tel_portable_patient,
            EncryptionManager::decrypt($tel_portable_coordonnees_encrypted)
        );
        $this->assertEqualsIgnoringCase($tel_fixe_patient, EncryptionManager::decrypt($tel_fixe_coordonnees_encrypted));

        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $complement_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'complement_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));
        $this->assertEqualsIgnoringCase(
            $complement_adresse_patient,
            EncryptionManager::decrypt($complement_adresse_encrypted)
        );

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => $id_lien,
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee,
        ]);

        $nom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'nom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $prenom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'prenom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_portable_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_fixe_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );

        $this->assertEqualsIgnoringCase($newUrgenceNom, EncryptionManager::decrypt($nom_coordonnees_urgence_encrypted));
        $this->assertEqualsIgnoringCase(
            $newUrgencePrenom,
            EncryptionManager::decrypt($prenom_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $telUp,
            EncryptionManager::decrypt($tel_portable_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase($telUf, EncryptionManager::decrypt($tel_fixe_coordonnees_urgence_encrypted));
    }

    public function testUpdateCoordonneesOkAllDataPatientQualife()
    {
        //
        $id_patient = "4";
        $id_type_piece_identite = "2";

        $update_ok = $this->patient->verifyIdentity($id_patient, $id_type_piece_identite);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'id_type_piece_identite' => $id_type_piece_identite,
            'id_type_statut_identite' => "4",  // "Qualifiée"
        ]);


        // obligatoire
        $nom_naissance = "Hdfyfg";
        $premier_prenom_naissance = "cvbnvbn";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        // optionnel
        $code_insee_naissance = "34567";
        $nom_utilise = "sdfgdf";
        $prenom_utilise = "sdfgsdfg";
        $liste_prenom_naissance = "sdfljko";

        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        // contact urgence
        $newUrgenceNom = "Tourev";
        $newUrgencePrenom = "Bobv";
        $id_lien = "3";
        $telUp = "0989846564";
        $telUf = "0389836564";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            'code_insee_naissance' => $code_insee_naissance,
            'nom_utilise' => $nom_utilise,
            'prenom_utilise' => $prenom_utilise,
            'liste_prenom_naissance' => $liste_prenom_naissance,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'sexe' => $sexe_patient,
            'id_type_statut_identite' => "1", // 'Provisoire'
            'id_type_piece_identite' => "1", // 'Aucun'
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $code_insee_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'code_insee_naissance',
            ['id_patient' => $id_patient]
        );
        $nom_utilise_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_utilise',
            ['id_patient' => $id_patient]
        );
        $prenom_utilise_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'prenom_utilise',
            ['id_patient' => $id_patient]
        );
        $liste_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'liste_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $code_insee_naissance,
            EncryptionManager::decrypt($code_insee_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $nom_utilise,
            EncryptionManager::decrypt($nom_utilise_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $prenom_utilise,
            EncryptionManager::decrypt($prenom_utilise_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $liste_prenom_naissance,
            EncryptionManager::decrypt($liste_prenom_naissance_encrypted)
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $mail_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'mail_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_portable_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $tel_fixe_coordonnees_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_patient' => $id_patient,]
        );
        $this->assertEqualsIgnoringCase($email_patient, EncryptionManager::decrypt($mail_coordonnees_encrypted));
        $this->assertEqualsIgnoringCase(
            $tel_portable_patient,
            EncryptionManager::decrypt($tel_portable_coordonnees_encrypted)
        );
        $this->assertEqualsIgnoringCase($tel_fixe_patient, EncryptionManager::decrypt($tel_fixe_coordonnees_encrypted));

        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
        ]);

        $nom_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'nom_adresse',
            ['id_adresse' => $id_adresse]
        );
        $complement_adresse_encrypted = $this->tester->grabFromDatabase(
            'adresse',
            'complement_adresse',
            ['id_adresse' => $id_adresse]
        );
        $this->assertEqualsIgnoringCase($adresse_patient, EncryptionManager::decrypt($nom_adresse_encrypted));
        $this->assertEqualsIgnoringCase(
            $complement_adresse_patient,
            EncryptionManager::decrypt($complement_adresse_encrypted)
        );

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
            'id_lien' => $id_lien,
        ]);

        $id_coordonnee = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee,
        ]);

        $nom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'nom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $prenom_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'prenom_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_portable_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_portable_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );
        $tel_fixe_coordonnees_urgence_encrypted = $this->tester->grabFromDatabase(
            'coordonnees',
            'tel_fixe_coordonnees',
            ['id_coordonnees' => $id_coordonnee,]
        );

        $this->assertEqualsIgnoringCase($newUrgenceNom, EncryptionManager::decrypt($nom_coordonnees_urgence_encrypted));
        $this->assertEqualsIgnoringCase(
            $newUrgencePrenom,
            EncryptionManager::decrypt($prenom_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $telUp,
            EncryptionManager::decrypt($tel_portable_coordonnees_urgence_encrypted)
        );
        $this->assertEqualsIgnoringCase($telUf, EncryptionManager::decrypt($tel_fixe_coordonnees_urgence_encrypted));
    }

    public function testUpdateCoordonneesNotOkId_patient()
    {
        // obligatoire
        $id_patient = "";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        // optionnel
        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        // contact urgence
        $newUrgenceNom = "Tourev";
        $newUrgencePrenom = "Bobv";
        $id_lien = "3";
        $telUp = "0989846564";
        $telUf = "0389836564";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateCoordonneesNotOkNom_patient()
    {
        // obligatoire
        $id_patient = "1";
        $nom_naissance = "";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        // optionnel
        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        // contact urgence
        $newUrgenceNom = "Tourev";
        $newUrgencePrenom = "Bobv";
        $id_lien = "3";
        $telUp = "0989846564";
        $telUf = "0389836564";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateCoordonneesNotOkPrenom_patient()
    {
        // obligatoire
        $id_patient = "1";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        // optionnel
        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        // contact urgence
        $newUrgenceNom = "Tourev";
        $newUrgencePrenom = "Bobv";
        $id_lien = "3";
        $telUp = "0989846564";
        $telUf = "0389836564";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateCoordonneesNotOkSexe_patient()
    {
        // obligatoire
        $id_patient = "1";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        // optionnel
        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        // contact urgence
        $newUrgenceNom = "Tourev";
        $newUrgencePrenom = "Bobv";
        $id_lien = "3";
        $telUp = "0989846564";
        $telUf = "0389836564";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateCoordonneesNotOkDate_naissance()
    {
        // obligatoire
        $id_patient = "1";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        // optionnel
        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        // contact urgence
        $newUrgenceNom = "Tourev";
        $newUrgencePrenom = "Bobv";
        $id_lien = "3";
        $telUp = "0989846564";
        $telUf = "0389836564";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateCoordonneesNotOkAdresse_patient()
    {
        // obligatoire
        $id_patient = "1";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "";
        $code_postal_patient = "86000";
        $ville_patient = "POITIERS";

        // optionnel
        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        // contact urgence
        $newUrgenceNom = "Tourev";
        $newUrgencePrenom = "Bobv";
        $id_lien = "3";
        $telUp = "0989846564";
        $telUf = "0389836564";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateCoordonneesNotOkCode_postal_patient()
    {
        // obligatoire
        $id_patient = "1";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "";
        $ville_patient = "POITIERS";

        // optionnel
        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        // contact urgence
        $newUrgenceNom = "Tourev";
        $newUrgencePrenom = "Bobv";
        $id_lien = "3";
        $telUp = "0989846564";
        $telUf = "0389836564";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateCoordonneesNotOkVille_patient()
    {
        // obligatoire
        $id_patient = "1";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $adresse_patient = "11 rue carrée";
        $code_postal_patient = "86000";
        $ville_patient = "";

        // optionnel
        $tel_fixe_patient = "0989876565";
        $tel_portable_patient = "0689876565";
        $email_patient = "dfgdfgdf@gmail.com";
        $complement_adresse_patient = "Bâtiment A";

        // contact urgence
        $newUrgenceNom = "Tourev";
        $newUrgencePrenom = "Bobv";
        $id_lien = "3";
        $telUp = "0989846564";
        $telUf = "0389836564";

        $update_ok = $this->patient->updateCoordonnees([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'adresse_patient' => $adresse_patient,
            'complement_adresse_patient' => $complement_adresse_patient,
            'code_postal_patient' => $code_postal_patient,
            'ville_patient' => $ville_patient,
            'tel_fixe_patient' => $tel_fixe_patient,
            'tel_portable_patient' => $tel_portable_patient,
            'email_patient' => $email_patient,

            'nom_urgence' => $newUrgenceNom,
            'prenom_urgence' => $newUrgencePrenom,
            'id_lien' => $id_lien,
            'tel_portable_urgence' => $telUp,
            'tel_fixe_urgence' => $telUf,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateInsDataOkMinimumData()
    {
        // obligatoire
        $id_patient = "7";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $matricule_ins = "1810163220751";
        $oid = "1.2.250.1.213.1.4.8";

        // optionnel
        $liste_prenom_naissance = null;
        $code_insee_naissance = null;
        $historique = null;
        $cle = null;

        $update_ok = $this->patient->updateInsData([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'liste_prenom_naissance' => $liste_prenom_naissance,
            'code_insee_naissance' => $code_insee_naissance,
            'matricule_ins' => $matricule_ins,
            'oid' => $oid,
            'cle' => $cle,
            'historique' => $historique,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'sexe' => $sexe_patient,

            'id_type_statut_identite' => "2", // 'Récupérée'
            'code_insee_naissance' => "",
            'liste_prenom_naissance' => "",
            'cle' => $cle,
        ]);

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $matricule_ins_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'matricule_ins',
            ['id_patient' => $id_patient]
        );
        $oid_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'oid',
            ['id_patient' => $id_patient]
        );

        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $matricule_ins,
            EncryptionManager::decrypt($matricule_ins_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $oid,
            EncryptionManager::decrypt($oid_encrypted)
        );
    }

    public function testUpdateInsDataOkAllDataExceptHistoriqueMin()
    {
        // obligatoire
        $id_patient = "7";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $matricule_ins = "2090763220834";
        $oid = "1.2.250.1.213.1.4.8";

        // optionnel
        $liste_prenom_naissance = "art rue carree";
        $code_insee_naissance = "86000";
        $cle = "45";
        $historique = [
            [
                'matricule' => [
                    'numIdentifiant' => '2690763220834',
                    'cle' => '23',
                    'typeMatricule' => null,
                ],
                'oid' => '1.2.250.1.213.1.4.8',
                'dateDeb' => null,
                'dateFin' => null,
            ],
            [
                'matricule' => [
                    'numIdentifiant' => null,
                    'cle' => null,
                    'typeMatricule' => null,
                ],
                'oid' => '1.2.250.1.213.1.4.9',
                'dateDeb' => null,
                'dateFin' => null,
            ]
        ];

        $update_ok = $this->patient->updateInsData([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'liste_prenom_naissance' => $liste_prenom_naissance,
            'code_insee_naissance' => $code_insee_naissance,
            'matricule_ins' => $matricule_ins,
            'oid' => $oid,
            'cle' => $cle,
            'historique' => $historique,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'sexe' => $sexe_patient,
            'cle' => $cle,

            'id_type_statut_identite' => "2", // 'Récupérée'
        ]);

        foreach ($historique as $historique_elem) {
            $this->tester->seeInDatabase('historique_ins_patient', [
                'id_patient' => $id_patient,
                'num_identifiant' => $historique_elem['matricule']["numIdentifiant"],
                'cle' => $historique_elem['matricule']["cle"],
                'type_matricule' => $historique_elem['matricule']["typeMatricule"],
                'oid' => $historique_elem["oid"],
                'date_deb' => $historique_elem["dateDeb"],
                'date_fin' => $historique_elem["dateFin"],
            ]);
        }

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $liste_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'liste_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $code_insee_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'code_insee_naissance',
            ['id_patient' => $id_patient]
        );
        $matricule_ins_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'matricule_ins',
            ['id_patient' => $id_patient]
        );
        $oid_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'oid',
            ['id_patient' => $id_patient]
        );

        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $liste_prenom_naissance,
            EncryptionManager::decrypt($liste_prenom_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $code_insee_naissance,
            EncryptionManager::decrypt($code_insee_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $matricule_ins,
            EncryptionManager::decrypt($matricule_ins_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $oid,
            EncryptionManager::decrypt($oid_encrypted)
        );
    }

    public function testUpdateInsDataOkAllData()
    {
        // obligatoire
        $id_patient = "7";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $matricule_ins = "2090763220834";
        $oid = "1.2.250.1.213.1.4.8";

        // optionnel
        $liste_prenom_naissance = "art rue carree";
        $code_insee_naissance = "86000";
        $cle = "45";
        $historique = [
            [
                'matricule' => [
                    'numIdentifiant' => '2690763220834',
                    'cle' => '23',
                    'typeMatricule' => 'NIR',
                ],
                'oid' => '1.2.250.1.213.1.4.8',
                'dateDeb' => '2000-01-04',
                'dateFin' => '2004-01-04',
            ],
            [
                'matricule' => [
                    'numIdentifiant' => '2690763220835',
                    'cle' => '13',
                    'typeMatricule' => 'NIA',
                ],
                'oid' => '1.2.250.1.213.1.4.9',
                'dateDeb' => '1980-02-02',
                'dateFin' => '2000-01-04',
            ]
        ];

        $update_ok = $this->patient->updateInsData([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'liste_prenom_naissance' => $liste_prenom_naissance,
            'code_insee_naissance' => $code_insee_naissance,
            'matricule_ins' => $matricule_ins,
            'oid' => $oid,
            'historique' => $historique,
            'cle' => $cle,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_naissance' => $date_naissance,
            'sexe' => $sexe_patient,
            'cle' => $cle,

            'id_type_statut_identite' => "2", // 'Récupérée'
        ]);

        foreach ($historique as $historique_elem) {
            $this->tester->seeInDatabase('historique_ins_patient', [
                'id_patient' => $id_patient,
                'num_identifiant' => $historique_elem['matricule']["numIdentifiant"],
                'cle' => $historique_elem['matricule']["cle"],
                'type_matricule' => $historique_elem['matricule']["typeMatricule"],
                'oid' => $historique_elem["oid"],
                'date_deb' => $historique_elem["dateDeb"],
                'date_fin' => $historique_elem["dateFin"],
            ]);
        }

        $nom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'nom_naissance',
            ['id_patient' => $id_patient]
        );
        $premier_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'premier_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $liste_prenom_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'liste_prenom_naissance',
            ['id_patient' => $id_patient]
        );
        $code_insee_naissance_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'code_insee_naissance',
            ['id_patient' => $id_patient]
        );
        $matricule_ins_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'matricule_ins',
            ['id_patient' => $id_patient]
        );
        $oid_encrypted = $this->tester->grabFromDatabase(
            'patients',
            'oid',
            ['id_patient' => $id_patient]
        );

        $this->assertEqualsIgnoringCase($nom_naissance, EncryptionManager::decrypt($nom_naissance_encrypted));
        $this->assertEqualsIgnoringCase(
            $premier_prenom_naissance,
            EncryptionManager::decrypt($premier_prenom_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $liste_prenom_naissance,
            EncryptionManager::decrypt($liste_prenom_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $code_insee_naissance,
            EncryptionManager::decrypt($code_insee_naissance_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $matricule_ins,
            EncryptionManager::decrypt($matricule_ins_encrypted)
        );
        $this->assertEqualsIgnoringCase(
            $oid,
            EncryptionManager::decrypt($oid_encrypted)
        );
    }

    public function testUpdateInsDataNotOkId_patientNull()
    {
        // obligatoire
        $id_patient = null;
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $matricule_ins = "1810163220751";
        $oid = "1.2.250.1.213.1.4.8";

        // optionnel
        $liste_prenom_naissance = null;
        $code_insee_naissance = null;
        $historique = null;
        $cle = null;

        $update_ok = $this->patient->updateInsData([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'liste_prenom_naissance' => $liste_prenom_naissance,
            'code_insee_naissance' => $code_insee_naissance,
            'matricule_ins' => $matricule_ins,
            'oid' => $oid,
            'cle' => $cle,
            'historique' => $historique,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Il manque au moins un paramètre obligatoire", $this->patient->getErrorMessage());
    }

    public function testUpdateInsDataNotOkNom_naissanceNull()
    {
        // obligatoire
        $id_patient = "7";
        $nom_naissance = null;
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $matricule_ins = "1810163220751";
        $oid = "1.2.250.1.213.1.4.8";

        // optionnel
        $liste_prenom_naissance = null;
        $code_insee_naissance = null;
        $historique = null;
        $cle = null;

        $update_ok = $this->patient->updateInsData([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'liste_prenom_naissance' => $liste_prenom_naissance,
            'code_insee_naissance' => $code_insee_naissance,
            'matricule_ins' => $matricule_ins,
            'oid' => $oid,
            'cle' => $cle,
            'historique' => $historique,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Il manque au moins un paramètre obligatoire", $this->patient->getErrorMessage());
    }

    public function testUpdateInsDataNotOkPremier_prenom_naissanceNull()
    {
        // obligatoire
        $id_patient = "7";
        $nom_naissance = "Jodfghfdqe";
        $premier_prenom_naissance = null;
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $matricule_ins = "1810163220751";
        $oid = "1.2.250.1.213.1.4.8";

        // optionnel
        $liste_prenom_naissance = null;
        $code_insee_naissance = null;
        $historique = null;
        $cle = null;

        $update_ok = $this->patient->updateInsData([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'liste_prenom_naissance' => $liste_prenom_naissance,
            'code_insee_naissance' => $code_insee_naissance,
            'matricule_ins' => $matricule_ins,
            'oid' => $oid,
            'cle' => $cle,
            'historique' => $historique,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Il manque au moins un paramètre obligatoire", $this->patient->getErrorMessage());
    }

    public function testUpdateInsDataNotOkSexe_patientNull()
    {
        // obligatoire
        $id_patient = "7";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = null;
        $date_naissance = "1962-03-03";
        $matricule_ins = "1810163220751";
        $oid = "1.2.250.1.213.1.4.8";

        // optionnel
        $liste_prenom_naissance = null;
        $code_insee_naissance = null;
        $historique = null;
        $cle = null;

        $update_ok = $this->patient->updateInsData([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'liste_prenom_naissance' => $liste_prenom_naissance,
            'code_insee_naissance' => $code_insee_naissance,
            'matricule_ins' => $matricule_ins,
            'oid' => $oid,
            'cle' => $cle,
            'historique' => $historique,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Il manque au moins un paramètre obligatoire", $this->patient->getErrorMessage());
    }

    public function testUpdateInsDataNotOkDate_naissanceNull()
    {
        // obligatoire
        $id_patient = "7";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = null;
        $matricule_ins = "1810163220751";
        $oid = "1.2.250.1.213.1.4.8";

        // optionnel
        $liste_prenom_naissance = null;
        $code_insee_naissance = null;
        $historique = null;
        $cle = null;

        $update_ok = $this->patient->updateInsData([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'liste_prenom_naissance' => $liste_prenom_naissance,
            'code_insee_naissance' => $code_insee_naissance,
            'matricule_ins' => $matricule_ins,
            'oid' => $oid,
            'cle' => $cle,
            'historique' => $historique,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Il manque au moins un paramètre obligatoire", $this->patient->getErrorMessage());
    }

    public function testUpdateInsDataNotOkMatricule_insNull()
    {
        // obligatoire
        $id_patient = "7";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $matricule_ins = null;
        $oid = "1.2.250.1.213.1.4.8";

        // optionnel
        $liste_prenom_naissance = null;
        $code_insee_naissance = null;
        $historique = null;
        $cle = null;

        $update_ok = $this->patient->updateInsData([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'liste_prenom_naissance' => $liste_prenom_naissance,
            'code_insee_naissance' => $code_insee_naissance,
            'matricule_ins' => $matricule_ins,
            'oid' => $oid,
            'cle' => $cle,
            'historique' => $historique,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Il manque au moins un paramètre obligatoire", $this->patient->getErrorMessage());
    }

    public function testUpdateInsDataNotOkOidNull()
    {
        // obligatoire
        $id_patient = "7";
        $nom_naissance = "Ssdfgdsfgd";
        $premier_prenom_naissance = "Jodfghfdqe";
        $sexe_patient = "F";
        $date_naissance = "1962-03-03";
        $matricule_ins = "1810163220751";
        $oid = null;

        // optionnel
        $liste_prenom_naissance = null;
        $code_insee_naissance = null;
        $historique = null;
        $cle = null;

        $update_ok = $this->patient->updateInsData([
            'id_patient' => $id_patient,
            'nom_naissance' => $nom_naissance,
            'premier_prenom_naissance' => $premier_prenom_naissance,
            'sexe_patient' => $sexe_patient,
            'date_naissance' => $date_naissance,
            'liste_prenom_naissance' => $liste_prenom_naissance,
            'code_insee_naissance' => $code_insee_naissance,
            'matricule_ins' => $matricule_ins,
            'oid' => $oid,
            'cle' => $cle,
            'historique' => $historique,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Il manque au moins un paramètre obligatoire", $this->patient->getErrorMessage());
    }

    public function testUpdateAutresInformationsOkMinimumData()
    {
        // obligatoire
        $id_patient = "1";

        $update_ok = $this->patient->updateAutresInformations([
            'id_patient' => $id_patient,
        ]);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'est_non_peps' => '0',
            'est_pris_en_charge_financierement' => '0',
            'hauteur_prise_en_charge_financierement' => null,
            'sit_part_prevention_chute' => '0',
            'sit_part_education_therapeutique' => '0',
            'sit_part_grossesse' => '0',
            'sit_part_sedentarite' => '0',
            'est_dans_qpv' => '0',
            'est_dans_zrr' => '0',
            'sit_part_autre' => "",
        ]);
    }

    public function testUpdateAutresInformationsOkAllData()
    {
        // obligatoire
        $id_patient = "1";

        $est_non_peps = "checked";
        $est_pris_en_charge = "checked";
        $hauteur_prise_en_charge = "90";
        $sit_part_prevention_chute = "checked";
        $sit_part_education_therapeutique = "checked";
        $sit_part_grossesse = "checked";
        $sit_part_sedentarite = "checked";
        $sit_part_autre = "Ydfgdfgg";
        $qpv = "checked";
        $zrr = "checked";

        $update_ok = $this->patient->updateAutresInformations([
            'id_patient' => $id_patient,
            'est_non_peps' => $est_non_peps,
            'est_pris_en_charge' => $est_pris_en_charge,
            'hauteur_prise_en_charge' => $hauteur_prise_en_charge,
            'sit_part_prevention_chute' => $sit_part_prevention_chute,
            'sit_part_education_therapeutique' => $sit_part_education_therapeutique,
            'sit_part_grossesse' => $sit_part_grossesse,
            'sit_part_sedentarite' => $sit_part_sedentarite,
            'sit_part_autre' => $sit_part_autre,
            'qpv' => $qpv,
            'zrr' => $zrr,
        ]);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'est_non_peps' => '1',
            'est_pris_en_charge_financierement' => '1',
            'hauteur_prise_en_charge_financierement' => $hauteur_prise_en_charge,
            'sit_part_prevention_chute' => '1',
            'sit_part_education_therapeutique' => '1',
            'sit_part_grossesse' => '1',
            'sit_part_sedentarite' => '1',
            'est_dans_qpv' => '1',
            'est_dans_zrr' => '1',
            'sit_part_autre' => $sit_part_autre,
        ]);
    }

    public function testUpdateAutresInformationsNotOkId_patientNull()
    {
        // obligatoire
        $id_patient = null;

        $est_pris_en_charge = "checked";
        $hauteur_prise_en_charge = "90";
        $sit_part_prevention_chute = "checked";
        $sit_part_education_therapeutique = "checked";
        $sit_part_grossesse = "checked";
        $sit_part_sedentarite = "checked";
        $sit_part_autre = "Ydfgdfgg";
        $qpv = "checked";
        $zrr = "checked";

        $update_ok = $this->patient->updateAutresInformations([
            'id_patient' => $id_patient,
            'est_pris_en_charge' => $est_pris_en_charge,
            'hauteur_prise_en_charge' => $hauteur_prise_en_charge,
            'sit_part_prevention_chute' => $sit_part_prevention_chute,
            'sit_part_education_therapeutique' => $sit_part_education_therapeutique,
            'sit_part_grossesse' => $sit_part_grossesse,
            'sit_part_sedentarite' => $sit_part_sedentarite,
            'sit_part_autre' => $sit_part_autre,
            'qpv' => $qpv,
            'zrr' => $zrr,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateEvaluateurOk()
    {
        // obligatoire
        $id_patient = "1";
        $id_user = "7";

        $update_ok = $this->patient->updateEvaluateur([
            'id_patient' => $id_patient,
            'id_user' => $id_user,
        ]);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'id_user' => $id_user,
        ]);
    }

    public function testUpdateEvaluateurNotOkId_patientNull()
    {
        // obligatoire
        $id_patient = null;
        $id_user = "3";

        $update_ok = $this->patient->updateEvaluateur([
            'id_patient' => $id_patient,
            'id_user' => $id_user,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateEvaluateurNotOkId_userNull()
    {
        // obligatoire
        $id_patient = "1";
        $id_user = null;

        $update_ok = $this->patient->updateEvaluateur([
            'id_patient' => $id_patient,
            'id_user' => $id_user,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateAntennerOk()
    {
        // obligatoire
        $id_patient = "1";
        $id_antenne = "4";

        $update_ok = $this->patient->updateAntenne([
            'id_patient' => $id_patient,
            'id_antenne' => $id_antenne,
        ]);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'id_antenne' => $id_antenne,
        ]);
    }

    public function testUpdateAntenneNotOkId_patientNull()
    {
        // obligatoire
        $id_patient = null;
        $id_antenne = "3";

        $update_ok = $this->patient->updateAntenne([
            'id_patient' => $id_patient,
            'id_antenne' => $id_antenne,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateAntenneNotOkId_userNull()
    {
        // obligatoire
        $id_patient = "1";
        $id_antenne = null;

        $update_ok = $this->patient->updateAntenne([
            'id_patient' => $id_patient,
            'id_antenne' => $id_antenne,
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateParcoursOkAllData()
    {
        $id_patient = "1";
        $date_debut_programme = "2020-10-22";
        $intervalle = "6";
        $date_admission = "2023-10-22";
        $date_eval_suiv = "2023-12-28";

        $update_ok = $this->patient->updateParcours([
            'id_patient' => $id_patient,
            'date_debut_programme' => $date_debut_programme,
            'intervalle' => $intervalle,
            'date_admission' => $date_admission,
            'date_eval_suiv' => $date_eval_suiv,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('parcours', [
            'date_debut_programme' => $date_debut_programme,
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'date_admission' => $date_admission,
            'intervalle' => $intervalle,
            'id_patient' => $id_patient,
            'date_eval_suiv' => $date_eval_suiv,
        ]);
    }

    public function testUpdateParcoursOkDate_debut_programmeNull()
    {
        $id_patient = "1";
        $date_debut_programme = null;
        $intervalle = "6";
        $date_admission = "2023-10-22";
        $date_eval_suiv = "2023-12-28";

        $update_ok = $this->patient->updateParcours([
            'id_patient' => $id_patient,
            'date_debut_programme' => $date_debut_programme,
            'intervalle' => $intervalle,
            'date_admission' => $date_admission,
            'date_eval_suiv' => $date_eval_suiv,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'date_admission' => $date_admission,
            'intervalle' => $intervalle,
            'id_patient' => $id_patient,
            'date_eval_suiv' => $date_eval_suiv,
        ]);
    }


    public function testUpdateParcoursOkDate_admissionNull()
    {
        $id_patient = "1";
        $date_debut_programme = "2020-10-22";
        $intervalle = "6";
        $date_admission = null;
        $date_eval_suiv = "2023-12-28";

        $update_ok = $this->patient->updateParcours([
            'id_patient' => $id_patient,
            'date_debut_programme' => $date_debut_programme,
            'intervalle' => $intervalle,
            'date_admission' => $date_admission,
            'date_eval_suiv' => $date_eval_suiv,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('parcours', [
            'date_debut_programme' => $date_debut_programme,
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'intervalle' => $intervalle,
            'id_patient' => $id_patient,
            'date_eval_suiv' => $date_eval_suiv,
        ]);
    }

    public function testUpdateParcoursOkIntervalleNull()
    {
        $id_patient = "1";
        $date_debut_programme = "2020-10-22";
        $intervalle = null;
        $date_admission = "2023-10-22";
        $date_eval_suiv = "2023-12-28";

        $update_ok = $this->patient->updateParcours([
            'id_patient' => $id_patient,
            'date_debut_programme' => $date_debut_programme,
            'intervalle' => $intervalle,
            'date_admission' => $date_admission,
            'date_eval_suiv' => $date_eval_suiv,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('parcours', [
            'date_debut_programme' => $date_debut_programme,
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'date_admission' => $date_admission,
            'id_patient' => $id_patient,
            'date_eval_suiv' => $date_eval_suiv,
        ]);
    }

    public function testUpdateParcoursOkDateEvalSuivNull()
    {
        $id_patient = "1";
        $date_debut_programme = "2020-10-22";
        $intervalle = "6";
        $date_admission = "2023-10-22";
        $date_eval_suiv = null;

        $update_ok = $this->patient->updateParcours([
            'id_patient' => $id_patient,
            'date_debut_programme' => $date_debut_programme,
            'intervalle' => $intervalle,
            'date_admission' => $date_admission,
            'date_eval_suiv' => $date_eval_suiv,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('parcours', [
            'date_debut_programme' => $date_debut_programme,
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'date_admission' => $date_admission,
            'id_patient' => $id_patient,
            'intervalle' => $intervalle,
        ]);
    }

    public function testUpdateParcoursOkMinimumData()
    {
        $id_patient = "1";

        $update_ok = $this->patient->updateParcours([
            'id_patient' => $id_patient,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('parcours', [
            'date_debut_programme' => '2022-07-06',
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'date_admission' => '2022-02-14',
            'intervalle' => '3',
            'id_patient' => $id_patient,
            'date_eval_suiv' => null,
        ]);
    }

    public function testUpdateParcoursNotOkId_patientNull()
    {
        $id_patient = null;
        $date_debut_programme = "2020-10-22";
        $intervalle = "6";

        $update_ok = $this->patient->updateParcours([
            'id_patient' => $id_patient,
            'date_debut_programme' => $date_debut_programme,
            'intervalle' => $intervalle,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
    }

    public function testUpdateConsentementOk0()
    {
        $id_patient = "1";
        $consentement = "0";

        $update_ok = $this->patient->updateConsentement([
            'id_patient' => $id_patient,
            'consentement' => $consentement,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'consentement' => $consentement,
            'id_patient' => $id_patient,
        ]);
    }

    public function testUpdateConsentementOk1()
    {
        $id_patient = "1";
        $consentement = "0";

        $update_ok = $this->patient->updateConsentement([
            'id_patient' => $id_patient,
            'consentement' => $consentement,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'consentement' => $consentement,
            'id_patient' => $id_patient,
        ]);
    }

    public function testUpdateConsentementOkAttente()
    {
        $id_patient = "1";
        $consentement = "attente";

        $update_ok = $this->patient->updateConsentement([
            'id_patient' => $id_patient,
            'consentement' => $consentement,
        ]);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'consentement' => null,
            'id_patient' => $id_patient,
        ]);
    }

    public function testUpdateConsentementNotOkId_patientNull()
    {
        $id_patient = null;
        $consentement = "1";

        $update_ok = $this->patient->updateConsentement([
            'id_patient' => $id_patient,
            'consentement' => $consentement,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
    }

    public function testUpdateConsentementNotOkConsentementNull()
    {
        $id_patient = "1";
        $consentement = null;

        $update_ok = $this->patient->updateConsentement([
            'id_patient' => $id_patient,
            'consentement' => $consentement,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
    }

    public function testUpdateConsentementNotOkConsentementInvalide()
    {
        $id_patient = "1";
        $consentement = "2";

        $update_ok = $this->patient->updateConsentement([
            'id_patient' => $id_patient,
            'consentement' => $consentement,
        ]);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
    }

    public function testReadOneOk()
    {
        $id_patient = '1';

        $item = $this->patient->readOne($id_patient);

        $this->assertNotFalse($item);
        $this->assertIsArray($item);

        $this->assertArrayHasKey('id_patient', $item);
        $this->assertArrayHasKey('prenom_patient', $item);
        $this->assertArrayHasKey('nom_patient', $item);
        $this->assertArrayHasKey('premier_prenom_naissance', $item);
        $this->assertArrayHasKey('nom_naissance', $item);
        $this->assertArrayHasKey('matricule_ins', $item);
        $this->assertArrayHasKey('cle', $item);
        $this->assertArrayHasKey('oid', $item);
        $this->assertArrayHasKey('nature_oid', $item);
        $this->assertArrayHasKey('code_insee_naissance', $item);
        $this->assertArrayHasKey('nom_utilise', $item);
        $this->assertArrayHasKey('prenom_utilise', $item);
        $this->assertArrayHasKey('liste_prenom_naissance', $item);
        $this->assertArrayHasKey('sexe_patient', $item);
        $this->assertArrayHasKey('date_naissance', $item);
        $this->assertArrayHasKey('nom_adresse', $item);
        $this->assertArrayHasKey('complement_adresse', $item);
        $this->assertArrayHasKey('code_postal', $item);
        $this->assertArrayHasKey('nom_ville', $item);
        $this->assertArrayHasKey('email_patient', $item);
        $this->assertArrayHasKey('tel_fixe_patient', $item);
        $this->assertArrayHasKey('tel_portable_patient', $item);
        $this->assertArrayHasKey('est_pris_en_charge_financierement', $item);
        $this->assertArrayHasKey('hauteur_prise_en_charge_financierement', $item);
        $this->assertArrayHasKey('sit_part_autre', $item);
        $this->assertArrayHasKey('sit_part_education_therapeutique', $item);
        $this->assertArrayHasKey('sit_part_grossesse', $item);
        $this->assertArrayHasKey('sit_part_prevention_chute', $item);
        $this->assertArrayHasKey('sit_part_sedentarite', $item);
        $this->assertArrayHasKey('est_dans_zrr', $item);
        $this->assertArrayHasKey('est_dans_qpv', $item);
        $this->assertArrayHasKey('est_archive', $item);
        $this->assertArrayHasKey('id_user', $item);
        $this->assertArrayHasKey('id_mutuelle', $item);
        $this->assertArrayHasKey('id_antenne', $item);
        $this->assertArrayHasKey('id_structure', $item);
        $this->assertArrayHasKey('consentement', $item);

        $this->assertArrayHasKey('nom_contact_urgence', $item);
        $this->assertArrayHasKey('prenom_contact_urgence', $item);
        $this->assertArrayHasKey('tel_fixe_contact_urgence', $item);
        $this->assertArrayHasKey('tel_portable_contact_urgence', $item);
        $this->assertArrayHasKey('id_lien', $item);
        $this->assertArrayHasKey('type_lien', $item);

        $this->assertArrayHasKey('nom_regime', $item);
        $this->assertArrayHasKey('nom_ville_cam', $item);
        $this->assertArrayHasKey('code_postal_cam', $item);
        $this->assertArrayHasKey('id_caisse_assurance_maladie', $item);

        $this->assertArrayHasKey('id_type_statut_identite', $item);
        $this->assertArrayHasKey('id_type_piece_identite', $item);
        $this->assertArrayHasKey('id_territoire', $item);
    }

    public function testReadOneOkNoVille()
    {
        $id_patient = '7';

        // vérifier que le patient n'a pas de ville
        $id_adresse = $this->tester->grabFromDatabase('patients', 'id_adresse', ['id_patient' => $id_patient]);
        $this->assertNotEmpty($id_adresse);
        $this->tester->dontSeeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $item = $this->patient->readOne($id_patient);

        $this->assertNotFalse($item);
        $this->assertIsArray($item);

        $this->assertArrayHasKey('id_patient', $item);
        $this->assertArrayHasKey('prenom_patient', $item);
        $this->assertArrayHasKey('nom_patient', $item);
        $this->assertArrayHasKey('premier_prenom_naissance', $item);
        $this->assertArrayHasKey('nom_naissance', $item);
        $this->assertArrayHasKey('matricule_ins', $item);
        $this->assertArrayHasKey('cle', $item);
        $this->assertArrayHasKey('oid', $item);
        $this->assertArrayHasKey('nature_oid', $item);
        $this->assertArrayHasKey('code_insee_naissance', $item);
        $this->assertArrayHasKey('nom_utilise', $item);
        $this->assertArrayHasKey('prenom_utilise', $item);
        $this->assertArrayHasKey('liste_prenom_naissance', $item);
        $this->assertArrayHasKey('sexe_patient', $item);
        $this->assertArrayHasKey('date_naissance', $item);
        $this->assertArrayHasKey('nom_adresse', $item);
        $this->assertArrayHasKey('complement_adresse', $item);
        $this->assertArrayHasKey('code_postal', $item);
        $this->assertArrayHasKey('nom_ville', $item);
        $this->assertArrayHasKey('email_patient', $item);
        $this->assertArrayHasKey('tel_fixe_patient', $item);
        $this->assertArrayHasKey('tel_portable_patient', $item);
        $this->assertArrayHasKey('est_pris_en_charge_financierement', $item);
        $this->assertArrayHasKey('hauteur_prise_en_charge_financierement', $item);
        $this->assertArrayHasKey('sit_part_autre', $item);
        $this->assertArrayHasKey('sit_part_education_therapeutique', $item);
        $this->assertArrayHasKey('sit_part_grossesse', $item);
        $this->assertArrayHasKey('sit_part_prevention_chute', $item);
        $this->assertArrayHasKey('sit_part_sedentarite', $item);
        $this->assertArrayHasKey('est_dans_zrr', $item);
        $this->assertArrayHasKey('est_dans_qpv', $item);
        $this->assertArrayHasKey('est_archive', $item);
        $this->assertArrayHasKey('id_user', $item);
        $this->assertArrayHasKey('id_mutuelle', $item);
        $this->assertArrayHasKey('id_antenne', $item);
        $this->assertArrayHasKey('id_structure', $item);
        $this->assertArrayHasKey('consentement', $item);

        $this->assertArrayHasKey('nom_contact_urgence', $item);
        $this->assertArrayHasKey('prenom_contact_urgence', $item);
        $this->assertArrayHasKey('tel_fixe_contact_urgence', $item);
        $this->assertArrayHasKey('tel_portable_contact_urgence', $item);
        $this->assertArrayHasKey('id_lien', $item);
        $this->assertArrayHasKey('type_lien', $item);

        $this->assertArrayHasKey('nom_regime', $item);
        $this->assertArrayHasKey('nom_ville_cam', $item);
        $this->assertArrayHasKey('code_postal_cam', $item);
        $this->assertArrayHasKey('id_caisse_assurance_maladie', $item);

        $this->assertArrayHasKey('id_type_statut_identite', $item);
        $this->assertArrayHasKey('id_type_piece_identite', $item);
        $this->assertArrayHasKey('id_territoire', $item);
    }

    public function testReadOneNotOkInvalidId_patient()
    {
        $id_patient = '-1';

        $item = $this->patient->readOne($id_patient);

        $this->assertFalse($item);
    }

    public function testReadOneNotOkId_patientNull()
    {
        $id_patient = null;

        $item = $this->patient->readOne($id_patient);

        $this->assertFalse($item);
    }

    public function testFuseOk1()
    {
        $id_patient_from = "1";
        $id_patient_target = "4";

        $id_coordonnees_patient_from = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $id_parcours_patient_from = $this->tester->grabFromDatabase(
            'parcours',
            'id_parcours',
            ['id_patient' => $id_patient_from]
        );
        $id_adresse_patient_from = $this->tester->grabFromDatabase(
            'patients',
            'id_adresse',
            ['id_patient' => $id_patient_from]
        );
        $id_coordonnee_contact_urgence_from = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient_from]
        );
        $id_coordonnee_contact_urgence_target = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient_target]
        );

        // prescription
        $prescription_count_patient_from_before = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_from]
        );
        $prescription_count_patient_target_before = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_target]
        );
        // objectif_patient
        $objectif_patient_count_patient_from_before = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_from]
        );
        $objectif_patient_count_patient_target_before = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_target]
        );
        // observation
        $observation_count_patient_from_before = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_from]
        );
        $observation_count_patient_target_before = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_target]
        );
        // questionnaire_instance
        $questionnaire_instance_count_patient_from_before = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_from]
        );
        $questionnaire_instance_count_patient_target_before = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_target]
        );
        // a_participe_a
        $a_participe_a_count_patient_from_before = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_from]
        );
        $a_participe_a_count_patient_target_before = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_target]
        );
        // a_contacter_en_cas_urgence
        $a_contacter_en_cas_urgence_count_patient_from_before = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_from]
        );
        $a_contacter_en_cas_urgence_count_patient_target_before = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_target]
        );
        // evaluations
        $evaluations_count_patient_from_before = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_from]
        );
        $evaluations_count_patient_target_before = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_target]
        );
        // activites_physiques
        $activites_physiques_count_patient_from_before = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_from]
        );
        $activites_physiques_count_patient_target_before = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_target]
        );
        // orientation
        $orientation_count_patient_from_before = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_from]
        );
        $orientation_count_patient_target_before = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_target]
        );
        // liste_participants_creneau
        $liste_participants_creneau_count_patient_from_before = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_from]
        );
        $liste_participants_creneau_count_patient_target_before = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_target]
        );
        // suit
        $suit_count_patient_from_before = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_from]
        );
        $suit_count_patient_target_before = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_target]
        );
        // traite
        $traite_count_patient_from_before = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_from]
        );
        $traite_count_patient_target_before = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_target]
        );
        // prescrit
        $prescrit_count_patient_from_before = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_from]
        );
        $prescrit_count_patient_target_before = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_target]
        );
        // parcours
        $parcours_count_patient_from_before = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_from]
        );
        $parcours_count_patient_target_before = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du patient
        $coordonnees_count_patient_from_before = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $coordonnees_count_patient_target_before = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du contact d'urgence
        $coordonnees_contact_count_patient_from_before = 0;
        if ($id_coordonnee_contact_urgence_from) {
            $coordonnees_contact_count_patient_from_before = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_from]
            );
        }
        $coordonnees_contact_count_patient_target_before = 0;
        if ($id_coordonnee_contact_urgence_target) {
            $coordonnees_contact_count_patient_target_before = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_target]
            );
        }
        // oriente_vers
        $oriente_vers_count_patient_from_before = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_from]
        );
        $oriente_vers_count_patient_target_before = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_target]
        );
        // souffre_de
        $souffre_de_count_patient_from_before = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_from]
        );
        $souffre_de_count_patient_target_before = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_target]
        );

        $fuse_ok = $this->patient->fuse($id_patient_from, $id_patient_target);
        $this->assertTrue($fuse_ok);

        // prescription
        $prescription_count_patient_from_after = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_from]
        );
        $prescription_count_patient_target_after = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_target]
        );
        // objectif_patient
        $objectif_patient_count_patient_from_after = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_from]
        );
        $objectif_patient_count_patient_target_after = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_target]
        );
        // observation
        $observation_count_patient_from_after = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_from]
        );
        $observation_count_patient_target_after = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_target]
        );
        // questionnaire_instance
        $questionnaire_instance_count_patient_from_after = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_from]
        );
        $questionnaire_instance_count_patient_target_after = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_target]
        );
        // a_participe_a
        $a_participe_a_count_patient_from_after = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_from]
        );
        $a_participe_a_count_patient_target_after = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_target]
        );
        // a_contacter_en_cas_urgence
        $a_contacter_en_cas_urgence_count_patient_from_after = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_from]
        );
        $a_contacter_en_cas_urgence_count_patient_target_after = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_target]
        );
        // evaluations
        $evaluations_count_patient_from_after = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_from]
        );
        $evaluations_count_patient_target_after = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_target]
        );
        // activites_physiques
        $activites_physiques_count_patient_from_after = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_from]
        );
        $activites_physiques_count_patient_target_after = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_target]
        );
        // orientation
        $orientation_count_patient_from_after = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_from]
        );
        $orientation_count_patient_target_after = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_target]
        );
        // liste_participants_creneau
        $liste_participants_creneau_count_patient_from_after = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_from]
        );
        $liste_participants_creneau_count_patient_target_after = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_target]
        );
        // suit
        $suit_count_patient_from_after = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_from]
        );
        $suit_count_patient_target_after = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_target]
        );
        // traite
        $traite_count_patient_from_after = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_from]
        );
        $traite_count_patient_target_after = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_target]
        );
        // prescrit
        $prescrit_count_patient_from_after = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_from]
        );
        $prescrit_count_patient_target_after = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_target]
        );
        // parcours
        $parcours_count_patient_from_after = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_from]
        );
        $parcours_count_patient_target_after = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du patient
        $coordonnees_count_patient_from_after = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $coordonnees_count_patient_target_after = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du contact d'urgence
        $coordonnees_contact_count_patient_from_after = 0;
        if ($id_coordonnee_contact_urgence_from) {
            $coordonnees_contact_count_patient_from_after = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_from]
            );
        }
        $coordonnees_contact_count_patient_target_after = 0;
        if ($id_coordonnee_contact_urgence_target) {
            $coordonnees_contact_count_patient_target_after = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_target]
            );
        }
        // oriente_vers
        $oriente_vers_count_patient_from_after = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_from]
        );
        $oriente_vers_count_patient_target_after = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_target]
        );
        // souffre_de
        $souffre_de_count_patient_from_after = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_from]
        );
        $souffre_de_count_patient_target_after = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_target]
        );

        // prescription
        $this->assertEquals(
            $prescription_count_patient_from_before + $prescription_count_patient_target_before,
            $prescription_count_patient_target_after
        );
        $this->assertEquals(0, $prescription_count_patient_from_after);
        // objectif_patient
        $this->assertEquals(
            $objectif_patient_count_patient_from_before + $objectif_patient_count_patient_target_before,
            $objectif_patient_count_patient_target_after
        );
        $this->assertEquals(0, $objectif_patient_count_patient_from_after);
        // observation
        $this->assertEquals(
            $observation_count_patient_from_before + $observation_count_patient_target_before,
            $observation_count_patient_target_after
        );
        $this->assertEquals(0, $observation_count_patient_from_after);
        // questionnaire_instance
        $this->assertEquals(
            $questionnaire_instance_count_patient_from_before + $questionnaire_instance_count_patient_target_before,
            $questionnaire_instance_count_patient_target_after
        );
        $this->assertEquals(0, $questionnaire_instance_count_patient_from_after);

        // a_participe_a
        // 3 pour id_patient_from et 1 pour id_patient_target (dont 1 en commun)
        $this->assertEquals(3, $a_participe_a_count_patient_target_after, 'a_participe_a target after');
        $this->assertEquals(0, $a_participe_a_count_patient_from_after, 'a_participe_a from after');

        // evaluations
        // chaque patient à une évaluation
        $this->assertEquals(1, $evaluations_count_patient_target_after, 'evaluations target after');
        $this->assertEquals(0, $evaluations_count_patient_from_after, 'evaluations from after');

        // activites_physiques
        // chaque patient à une activites_physiques
        $this->assertEquals(1, $activites_physiques_count_patient_target_after, 'activites_physiques target after');
        $this->assertEquals(0, $activites_physiques_count_patient_from_after, 'activites_physiques from after');

        // orientation
        // chaque patient à une orientation
        $this->assertEquals(1, $orientation_count_patient_target_after, 'orientation target after');
        $this->assertEquals(0, $orientation_count_patient_from_after, 'orientation from after');

        // liste_participants_creneau
        // 5 pour id_patient_from et 1 pour id_patient_target (dont 1 en commun)
        $this->assertEquals(
            5,
            $liste_participants_creneau_count_patient_target_after,
            'liste_participants_creneau target after'
        );
        $this->assertEquals(
            0,
            $liste_participants_creneau_count_patient_from_after,
            'liste_participants_creneau from after'
        );

        // suit
        // 1 pour id_patient_from et 0 pour id_patient_target
        $this->assertEquals(1, $suit_count_patient_target_after, 'suit target after');
        $this->assertEquals(0, $suit_count_patient_from_after, 'suit from after');

        // traite
        // 0 pour id_patient_from et 1 pour id_patient_target
        $this->assertEquals(1, $traite_count_patient_target_after, 'traite target after');
        $this->assertEquals(0, $traite_count_patient_from_after, 'traite from after');

        // prescrit
        // 0 pour id_patient_from et 1 pour id_patient_target
        $this->assertEquals(1, $prescrit_count_patient_target_after, 'prescrit target after');
        $this->assertEquals(0, $prescrit_count_patient_from_after, 'prescrit from after');

        // a_contacter_en_cas_urgence
        // 1 pour id_patient_from et 1 pour id_patient_target
        $this->assertEquals(
            1,
            $a_contacter_en_cas_urgence_count_patient_target_after,
            'a_contacter_en_cas_urgence target after'
        );
        $this->assertEquals(
            0,
            $a_contacter_en_cas_urgence_count_patient_from_after,
            'a_contacter_en_cas_urgence from after'
        );

        // oriente_vers
        // 1 pour id_patient_from et 1 pour id_patient_target (même structure)
        $this->assertEquals(1, $oriente_vers_count_patient_target_after, 'oriente_vers target after');
        $this->assertEquals(0, $oriente_vers_count_patient_from_after, 'oriente_vers from after');

        // souffre_de
        // 3 pour id_patient_from et 3 pour id_patient_target (2 des ALD sont en commun)
        $this->assertEquals(4, $souffre_de_count_patient_target_after, 'souffre_de target after');
        $this->assertEquals(0, $souffre_de_count_patient_from_after, 'souffre_de from after');

        $this->tester->dontSeeInDatabase('adresse', [
            'id_adresse' => $id_adresse_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnees_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee_contact_urgence_from,
        ]);

        $this->tester->dontSeeInDatabase('parcours', [
            'id_parcours' => $id_parcours_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('evaluations', [
            'id_patient' => $id_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('patients', [
            'id_patient' => $id_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('souffre_de', [
            'id_patient' => $id_patient_from,
        ]);
    }

    public function testFuseOk2()
    {
        $id_patient_from = "4";
        $id_patient_target = "1";

        $id_coordonnees_patient_from = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $id_parcours_patient_from = $this->tester->grabFromDatabase(
            'parcours',
            'id_parcours',
            ['id_patient' => $id_patient_from]
        );
        $id_adresse_patient_from = $this->tester->grabFromDatabase(
            'patients',
            'id_adresse',
            ['id_patient' => $id_patient_from]
        );
        $id_coordonnee_contact_urgence_from = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient_from]
        );
        $id_coordonnee_contact_urgence_target = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient_target]
        );

        // prescription
        $prescription_count_patient_from_before = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_from]
        );
        $prescription_count_patient_target_before = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_target]
        );
        // objectif_patient
        $objectif_patient_count_patient_from_before = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_from]
        );
        $objectif_patient_count_patient_target_before = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_target]
        );
        // observation
        $observation_count_patient_from_before = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_from]
        );
        $observation_count_patient_target_before = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_target]
        );
        // questionnaire_instance
        $questionnaire_instance_count_patient_from_before = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_from]
        );
        $questionnaire_instance_count_patient_target_before = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_target]
        );
        // a_participe_a
        $a_participe_a_count_patient_from_before = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_from]
        );
        $a_participe_a_count_patient_target_before = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_target]
        );
        // a_contacter_en_cas_urgence
        $a_contacter_en_cas_urgence_count_patient_from_before = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_from]
        );
        $a_contacter_en_cas_urgence_count_patient_target_before = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_target]
        );
        // evaluations
        $evaluations_count_patient_from_before = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_from]
        );
        $evaluations_count_patient_target_before = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_target]
        );
        // activites_physiques
        $activites_physiques_count_patient_from_before = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_from]
        );
        $activites_physiques_count_patient_target_before = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_target]
        );
        // orientation
        $orientation_count_patient_from_before = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_from]
        );
        $orientation_count_patient_target_before = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_target]
        );
        // liste_participants_creneau
        $liste_participants_creneau_count_patient_from_before = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_from]
        );
        $liste_participants_creneau_count_patient_target_before = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_target]
        );
        // suit
        $suit_count_patient_from_before = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_from]
        );
        $suit_count_patient_target_before = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_target]
        );
        // traite
        $traite_count_patient_from_before = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_from]
        );
        $traite_count_patient_target_before = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_target]
        );
        // prescrit
        $prescrit_count_patient_from_before = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_from]
        );
        $prescrit_count_patient_target_before = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_target]
        );

        // parcours
        $parcours_count_patient_from_before = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_from]
        );
        $parcours_count_patient_target_before = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du patient
        $coordonnees_count_patient_from_before = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $coordonnees_count_patient_target_before = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du contact d'urgence
        $coordonnees_contact_count_patient_from_before = 0;
        if ($id_coordonnee_contact_urgence_from) {
            $coordonnees_contact_count_patient_from_before = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_from]
            );
        }
        $coordonnees_contact_count_patient_target_before = 0;
        if ($id_coordonnee_contact_urgence_target) {
            $coordonnees_contact_count_patient_target_before = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_target]
            );
        }
        // oriente_vers
        $oriente_vers_count_patient_from_before = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_from]
        );
        $oriente_vers_count_patient_target_before = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_target]
        );
        // souffre_de
        $souffre_de_count_patient_from_before = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_from]
        );
        $souffre_de_count_patient_target_before = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_target]
        );

        $fuse_ok = $this->patient->fuse($id_patient_from, $id_patient_target);
        $this->assertTrue($fuse_ok);

        // prescription
        $prescription_count_patient_from_after = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_from]
        );
        $prescription_count_patient_target_after = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_target]
        );
        // objectif_patient
        $objectif_patient_count_patient_from_after = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_from]
        );
        $objectif_patient_count_patient_target_after = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_target]
        );
        // observation
        $observation_count_patient_from_after = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_from]
        );
        $observation_count_patient_target_after = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_target]
        );
        // questionnaire_instance
        $questionnaire_instance_count_patient_from_after = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_from]
        );
        $questionnaire_instance_count_patient_target_after = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_target]
        );
        // a_participe_a
        $a_participe_a_count_patient_from_after = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_from]
        );
        $a_participe_a_count_patient_target_after = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_target]
        );
        // a_contacter_en_cas_urgence
        $a_contacter_en_cas_urgence_count_patient_from_after = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_from]
        );
        $a_contacter_en_cas_urgence_count_patient_target_after = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_target]
        );
        // evaluations
        $evaluations_count_patient_from_after = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_from]
        );
        $evaluations_count_patient_target_after = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_target]
        );
        // activites_physiques
        $activites_physiques_count_patient_from_after = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_from]
        );
        $activites_physiques_count_patient_target_after = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_target]
        );
        // orientation
        $orientation_count_patient_from_after = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_from]
        );
        $orientation_count_patient_target_after = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_target]
        );
        // liste_participants_creneau
        $liste_participants_creneau_count_patient_from_after = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_from]
        );
        $liste_participants_creneau_count_patient_target_after = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_target]
        );
        // suit
        $suit_count_patient_from_after = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_from]
        );
        $suit_count_patient_target_after = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_target]
        );
        // traite
        $traite_count_patient_from_after = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_from]
        );
        $traite_count_patient_target_after = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_target]
        );
        // prescrit
        $prescrit_count_patient_from_after = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_from]
        );
        $prescrit_count_patient_target_after = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_target]
        );
        // parcours
        $parcours_count_patient_from_after = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_from]
        );
        $parcours_count_patient_target_after = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du patient
        $coordonnees_count_patient_from_after = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $coordonnees_count_patient_target_after = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du contact d'urgence
        $coordonnees_contact_count_patient_from_after = 0;
        if ($id_coordonnee_contact_urgence_from) {
            $coordonnees_contact_count_patient_from_after = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_from]
            );
        }
        $coordonnees_contact_count_patient_target_after = 0;
        if ($id_coordonnee_contact_urgence_target) {
            $coordonnees_contact_count_patient_target_after = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_target]
            );
        }
        // oriente_vers
        $oriente_vers_count_patient_from_after = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_from]
        );
        $oriente_vers_count_patient_target_after = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_target]
        );
        // souffre_de
        $souffre_de_count_patient_from_after = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_from]
        );
        $souffre_de_count_patient_target_after = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_target]
        );

        // prescription
        $this->assertEquals(
            $prescription_count_patient_from_before + $prescription_count_patient_target_before,
            $prescription_count_patient_target_after
        );
        $this->assertEquals(0, $prescription_count_patient_from_after);
        // objectif_patient
        $this->assertEquals(
            $objectif_patient_count_patient_from_before + $objectif_patient_count_patient_target_before,
            $objectif_patient_count_patient_target_after
        );
        $this->assertEquals(0, $objectif_patient_count_patient_from_after);
        // observation
        $this->assertEquals(
            $observation_count_patient_from_before + $observation_count_patient_target_before,
            $observation_count_patient_target_after
        );
        $this->assertEquals(0, $observation_count_patient_from_after);
        // questionnaire_instance
        $this->assertEquals(
            $questionnaire_instance_count_patient_from_before + $questionnaire_instance_count_patient_target_before,
            $questionnaire_instance_count_patient_target_after
        );
        $this->assertEquals(0, $questionnaire_instance_count_patient_from_after);

        // a_participe_a
        // 3 pour id_patient_from et 1 pour id_patient_target (dont 1 en commun)
        $this->assertEquals(3, $a_participe_a_count_patient_target_after, 'a_participe_a target after');
        $this->assertEquals(0, $a_participe_a_count_patient_from_after, 'a_participe_a from after');

        // evaluations
        // chaque patient à une évaluation
        $this->assertEquals(1, $evaluations_count_patient_target_after, 'evaluations target after');
        $this->assertEquals(0, $evaluations_count_patient_from_after, 'evaluations from after');

        // activites_physiques
        // chaque patient à une activites_physiques
        $this->assertEquals(1, $activites_physiques_count_patient_target_after, 'activites_physiques target after');
        $this->assertEquals(0, $activites_physiques_count_patient_from_after, 'activites_physiques from after');

        // orientation
        // chaque patient à une orientation
        $this->assertEquals(1, $orientation_count_patient_target_after, 'orientation target after');
        $this->assertEquals(0, $orientation_count_patient_from_after, 'orientation from after');

        // liste_participants_creneau
        // 5 pour id_patient_from et 1 pour id_patient_target (dont 1 en commun)
        $this->assertEquals(
            5,
            $liste_participants_creneau_count_patient_target_after,
            'liste_participants_creneau target after'
        );
        $this->assertEquals(
            0,
            $liste_participants_creneau_count_patient_from_after,
            'liste_participants_creneau from after'
        );

        // suit
        // 0 pour id_patient_from et 1 pour id_patient_target
        $this->assertEquals(1, $suit_count_patient_target_after, 'suit target after');
        $this->assertEquals(0, $suit_count_patient_from_after, 'suit from after');

        // traite
        // 1 pour id_patient_from et 0 pour id_patient_target
        $this->assertEquals(1, $traite_count_patient_target_after, 'traite target after');
        $this->assertEquals(0, $traite_count_patient_from_after, 'traite from after');

        // prescrit
        // 1 pour id_patient_from et 0 pour id_patient_target
        $this->assertEquals(1, $prescrit_count_patient_target_after, 'prescrit target after');
        $this->assertEquals(0, $prescrit_count_patient_from_after, 'prescrit from after');

        // a_contacter_en_cas_urgence
        // 1 pour id_patient_from et 1 pour id_patient_target
        $this->assertEquals(
            1,
            $a_contacter_en_cas_urgence_count_patient_target_after,
            'a_contacter_en_cas_urgence target after'
        );
        $this->assertEquals(
            0,
            $a_contacter_en_cas_urgence_count_patient_from_after,
            'a_contacter_en_cas_urgence from after'
        );

        // oriente_vers
        // 1 pour id_patient_from et 1 pour id_patient_target (même structure)
        $this->assertEquals(1, $oriente_vers_count_patient_target_after, 'oriente_vers target after');
        $this->assertEquals(0, $oriente_vers_count_patient_from_after, 'oriente_vers from after');

        // souffre_de
        // 3 pour id_patient_from et 3 pour id_patient_target (2 des ALD sont en commun)
        $this->assertEquals(4, $souffre_de_count_patient_target_after, 'souffre_de target after');
        $this->assertEquals(0, $souffre_de_count_patient_from_after, 'souffre_de from after');

        $this->tester->dontSeeInDatabase('adresse', [
            'id_adresse' => $id_adresse_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnees_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee_contact_urgence_from,
        ]);

        $this->tester->dontSeeInDatabase('parcours', [
            'id_parcours' => $id_parcours_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('evaluations', [
            'id_patient' => $id_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('patients', [
            'id_patient' => $id_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('souffre_de', [
            'id_patient' => $id_patient_from,
        ]);
    }

    public function testFuseOk3()
    {
        $id_patient_from = "1";
        $id_patient_target = "5";

        $id_coordonnees_patient_from = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $id_parcours_patient_from = $this->tester->grabFromDatabase(
            'parcours',
            'id_parcours',
            ['id_patient' => $id_patient_from]
        );
        $id_adresse_patient_from = $this->tester->grabFromDatabase(
            'patients',
            'id_adresse',
            ['id_patient' => $id_patient_from]
        );
        $id_coordonnee_contact_urgence_from = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient_from]
        );
        $id_coordonnee_contact_urgence_target = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient_target]
        );

        // prescription
        $prescription_count_patient_from_before = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_from]
        );
        $prescription_count_patient_target_before = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_target]
        );
        // objectif_patient
        $objectif_patient_count_patient_from_before = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_from]
        );
        $objectif_patient_count_patient_target_before = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_target]
        );
        // observation
        $observation_count_patient_from_before = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_from]
        );
        $observation_count_patient_target_before = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_target]
        );
        // questionnaire_instance
        $questionnaire_instance_count_patient_from_before = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_from]
        );
        $questionnaire_instance_count_patient_target_before = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_target]
        );
        // a_participe_a
        $a_participe_a_count_patient_from_before = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_from]
        );
        $a_participe_a_count_patient_target_before = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_target]
        );
        // a_contacter_en_cas_urgence
        $a_contacter_en_cas_urgence_count_patient_from_before = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_from]
        );
        $a_contacter_en_cas_urgence_count_patient_target_before = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_target]
        );
        // evaluations
        $evaluations_count_patient_from_before = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_from]
        );
        $evaluations_count_patient_target_before = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_target]
        );
        // activites_physiques
        $activites_physiques_count_patient_from_before = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_from]
        );
        $activites_physiques_count_patient_target_before = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_target]
        );
        // orientation
        $orientation_count_patient_from_before = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_from]
        );
        $orientation_count_patient_target_before = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_target]
        );
        // liste_participants_creneau
        $liste_participants_creneau_count_patient_from_before = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_from]
        );
        $liste_participants_creneau_count_patient_target_before = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_target]
        );
        // suit
        $suit_count_patient_from_before = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_from]
        );
        $suit_count_patient_target_before = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_target]
        );
        // traite
        $traite_count_patient_from_before = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_from]
        );
        $traite_count_patient_target_before = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_target]
        );
        // prescrit
        $prescrit_count_patient_from_before = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_from]
        );
        $prescrit_count_patient_target_before = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_target]
        );
        // parcours
        $parcours_count_patient_from_before = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_from]
        );
        $parcours_count_patient_target_before = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du patient
        $coordonnees_count_patient_from_before = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $coordonnees_count_patient_target_before = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du contact d'urgence
        $coordonnees_contact_count_patient_from_before = 0;
        if ($id_coordonnee_contact_urgence_from) {
            $coordonnees_contact_count_patient_from_before = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_from]
            );
        }
        $coordonnees_contact_count_patient_target_before = 0;
        if ($id_coordonnee_contact_urgence_target) {
            $coordonnees_contact_count_patient_target_before = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_target]
            );
        }
        // oriente_vers
        $oriente_vers_count_patient_from_before = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_from]
        );
        $oriente_vers_count_patient_target_before = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_target]
        );
        // souffre_de
        $souffre_de_count_patient_from_before = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_from]
        );
        $souffre_de_count_patient_target_before = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_target]
        );

        $fuse_ok = $this->patient->fuse($id_patient_from, $id_patient_target);
        $this->assertTrue($fuse_ok);

        // prescription
        $prescription_count_patient_from_after = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_from]
        );
        $prescription_count_patient_target_after = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_target]
        );
        // objectif_patient
        $objectif_patient_count_patient_from_after = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_from]
        );
        $objectif_patient_count_patient_target_after = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_target]
        );
        // observation
        $observation_count_patient_from_after = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_from]
        );
        $observation_count_patient_target_after = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_target]
        );
        // questionnaire_instance
        $questionnaire_instance_count_patient_from_after = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_from]
        );
        $questionnaire_instance_count_patient_target_after = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_target]
        );
        // a_participe_a
        $a_participe_a_count_patient_from_after = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_from]
        );
        $a_participe_a_count_patient_target_after = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_target]
        );
        // a_contacter_en_cas_urgence
        $a_contacter_en_cas_urgence_count_patient_from_after = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_from]
        );
        $a_contacter_en_cas_urgence_count_patient_target_after = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_target]
        );
        // evaluations
        $evaluations_count_patient_from_after = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_from]
        );
        $evaluations_count_patient_target_after = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_target]
        );
        // activites_physiques
        $activites_physiques_count_patient_from_after = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_from]
        );
        $activites_physiques_count_patient_target_after = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_target]
        );
        // orientation
        $orientation_count_patient_from_after = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_from]
        );
        $orientation_count_patient_target_after = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_target]
        );
        // liste_participants_creneau
        $liste_participants_creneau_count_patient_from_after = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_from]
        );
        $liste_participants_creneau_count_patient_target_after = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_target]
        );
        // suit
        $suit_count_patient_from_after = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_from]
        );
        $suit_count_patient_target_after = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_target]
        );
        // traite
        $traite_count_patient_from_after = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_from]
        );
        $traite_count_patient_target_after = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_target]
        );
        // prescrit
        $prescrit_count_patient_from_after = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_from]
        );
        $prescrit_count_patient_target_after = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_target]
        );
        // parcours
        $parcours_count_patient_from_after = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_from]
        );
        $parcours_count_patient_target_after = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du patient
        $coordonnees_count_patient_from_after = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $coordonnees_count_patient_target_after = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du contact d'urgence
        $coordonnees_contact_count_patient_from_after = 0;
        if ($id_coordonnee_contact_urgence_from) {
            $coordonnees_contact_count_patient_from_after = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_from]
            );
        }
        $coordonnees_contact_count_patient_target_after = 0;
        if ($id_coordonnee_contact_urgence_target) {
            $coordonnees_contact_count_patient_target_after = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_target]
            );
        }
        // oriente_vers
        $oriente_vers_count_patient_from_after = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_from]
        );
        $oriente_vers_count_patient_target_after = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_target]
        );
        // souffre_de
        $souffre_de_count_patient_from_after = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_from]
        );
        $souffre_de_count_patient_target_after = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_target]
        );

        // prescription
        $this->assertEquals(
            $prescription_count_patient_from_before + $prescription_count_patient_target_before,
            $prescription_count_patient_target_after
        );
        $this->assertEquals(0, $prescription_count_patient_from_after);
        // objectif_patient
        $this->assertEquals(
            $objectif_patient_count_patient_from_before + $objectif_patient_count_patient_target_before,
            $objectif_patient_count_patient_target_after
        );
        $this->assertEquals(0, $objectif_patient_count_patient_from_after);
        // observation
        $this->assertEquals(
            $observation_count_patient_from_before + $observation_count_patient_target_before,
            $observation_count_patient_target_after
        );
        $this->assertEquals(0, $observation_count_patient_from_after);
        // questionnaire_instance
        $this->assertEquals(
            $questionnaire_instance_count_patient_from_before + $questionnaire_instance_count_patient_target_before,
            $questionnaire_instance_count_patient_target_after
        );
        $this->assertEquals(0, $questionnaire_instance_count_patient_from_after);

        // a_participe_a
        // 3 pour id_patient_from et 0
        $this->assertEquals(3, $a_participe_a_count_patient_target_after, 'a_participe_a target after');
        $this->assertEquals(0, $a_participe_a_count_patient_from_after, 'a_participe_a from after');

        // evaluations
        // 1 pour id_patient_from
        $this->assertEquals(1, $evaluations_count_patient_target_after, 'evaluations target after');
        $this->assertEquals(0, $evaluations_count_patient_from_after, 'evaluations from after');

        // activites_physiques
        // 1 pour id_patient_from
        $this->assertEquals(1, $activites_physiques_count_patient_target_after, 'activites_physiques target after');
        $this->assertEquals(0, $activites_physiques_count_patient_from_after, 'activites_physiques from after');

        // orientation
        // 1 pour id_patient_from
        $this->assertEquals(1, $orientation_count_patient_target_after, 'orientation target after');
        $this->assertEquals(0, $orientation_count_patient_from_after, 'orientation from after');

        // liste_participants_creneau
        // 5 pour id_patient_from
        $this->assertEquals(
            5,
            $liste_participants_creneau_count_patient_target_after,
            'liste_participants_creneau target after'
        );
        $this->assertEquals(
            0,
            $liste_participants_creneau_count_patient_from_after,
            'liste_participants_creneau from after'
        );

        // suit
        // 1 pour id_patient_from
        $this->assertEquals(1, $suit_count_patient_target_after, 'suit target after');
        $this->assertEquals(0, $suit_count_patient_from_after, 'suit from after');

        // traite
        $this->assertEquals(0, $traite_count_patient_target_after, 'traite target after');
        $this->assertEquals(0, $traite_count_patient_from_after, 'traite from after');

        // prescrit
        $this->assertEquals(0, $prescrit_count_patient_target_after, 'prescrit target after');
        $this->assertEquals(0, $prescrit_count_patient_from_after, 'prescrit from after');

        // a_contacter_en_cas_urgence
        // 1 pour id_patient_from et 1 pour id_patient_target
        $this->assertEquals(
            1,
            $a_contacter_en_cas_urgence_count_patient_target_after,
            'a_contacter_en_cas_urgence target after'
        );
        $this->assertEquals(
            0,
            $a_contacter_en_cas_urgence_count_patient_from_after,
            'a_contacter_en_cas_urgence from after'
        );

        // oriente_vers
        // 1 pour id_patient_from et 1 pour id_patient_target
        $this->assertEquals(2, $oriente_vers_count_patient_target_after, 'oriente_vers target after');
        $this->assertEquals(0, $oriente_vers_count_patient_from_after, 'oriente_vers from after');

        // souffre_de
        // 3 pour id_patient_from et 1 pour id_patient_target (-1 qui doit être supprimé)
        $this->assertEquals(3, $souffre_de_count_patient_target_after, 'souffre_de target after');
        $this->assertEquals(0, $souffre_de_count_patient_from_after, 'souffre_de from after');

        $this->tester->dontSeeInDatabase('adresse', [
            'id_adresse' => $id_adresse_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnees_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee_contact_urgence_from,
        ]);

        $this->tester->dontSeeInDatabase('parcours', [
            'id_parcours' => $id_parcours_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('evaluations', [
            'id_patient' => $id_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('patients', [
            'id_patient' => $id_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('souffre_de', [
            'id_patient' => $id_patient_from,
        ]);
    }

    public function testFuseOk4()
    {
        $id_patient_from = "5";
        $id_patient_target = "1";

        $id_coordonnees_patient_from = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $id_parcours_patient_from = $this->tester->grabFromDatabase(
            'parcours',
            'id_parcours',
            ['id_patient' => $id_patient_from]
        );
        $id_adresse_patient_from = $this->tester->grabFromDatabase(
            'patients',
            'id_adresse',
            ['id_patient' => $id_patient_from]
        );
        $id_coordonnee_contact_urgence_from = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient_from]
        );
        $id_coordonnee_contact_urgence_target = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient_target]
        );

        // prescription
        $prescription_count_patient_from_before = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_from]
        );
        $prescription_count_patient_target_before = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_target]
        );
        // objectif_patient
        $objectif_patient_count_patient_from_before = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_from]
        );
        $objectif_patient_count_patient_target_before = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_target]
        );
        // observation
        $observation_count_patient_from_before = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_from]
        );
        $observation_count_patient_target_before = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_target]
        );
        // questionnaire_instance
        $questionnaire_instance_count_patient_from_before = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_from]
        );
        $questionnaire_instance_count_patient_target_before = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_target]
        );
        // a_participe_a
        $a_participe_a_count_patient_from_before = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_from]
        );
        $a_participe_a_count_patient_target_before = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_target]
        );
        // a_contacter_en_cas_urgence
        $a_contacter_en_cas_urgence_count_patient_from_before = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_from]
        );
        $a_contacter_en_cas_urgence_count_patient_target_before = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_target]
        );
        // evaluations
        $evaluations_count_patient_from_before = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_from]
        );
        $evaluations_count_patient_target_before = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_target]
        );
        // activites_physiques
        $activites_physiques_count_patient_from_before = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_from]
        );
        $activites_physiques_count_patient_target_before = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_target]
        );
        // orientation
        $orientation_count_patient_from_before = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_from]
        );
        $orientation_count_patient_target_before = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_target]
        );
        // liste_participants_creneau
        $liste_participants_creneau_count_patient_from_before = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_from]
        );
        $liste_participants_creneau_count_patient_target_before = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_target]
        );
        // suit
        $suit_count_patient_from_before = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_from]
        );
        $suit_count_patient_target_before = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_target]
        );
        // traite
        $traite_count_patient_from_before = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_from]
        );
        $traite_count_patient_target_before = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_target]
        );
        // prescrit
        $prescrit_count_patient_from_before = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_from]
        );
        $prescrit_count_patient_target_before = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_target]
        );
        // parcours
        $parcours_count_patient_from_before = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_from]
        );
        $parcours_count_patient_target_before = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du patient
        $coordonnees_count_patient_from_before = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $coordonnees_count_patient_target_before = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du contact d'urgence
        $coordonnees_contact_count_patient_from_before = 0;
        if ($id_coordonnee_contact_urgence_from) {
            $coordonnees_contact_count_patient_from_before = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_from]
            );
        }
        $coordonnees_contact_count_patient_target_before = 0;
        if ($id_coordonnee_contact_urgence_target) {
            $coordonnees_contact_count_patient_target_before = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_target]
            );
        }
        // oriente_vers
        $oriente_vers_count_patient_from_before = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_from]
        );
        $oriente_vers_count_patient_target_before = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_target]
        );
        // souffre_de
        $souffre_de_count_patient_from_before = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_from]
        );
        $souffre_de_count_patient_target_before = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_target]
        );

        $fuse_ok = $this->patient->fuse($id_patient_from, $id_patient_target);
        $this->assertTrue($fuse_ok);

        // prescription
        $prescription_count_patient_from_after = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_from]
        );
        $prescription_count_patient_target_after = $this->tester->grabNumRecords(
            'prescription',
            ['id_patient' => $id_patient_target]
        );
        // objectif_patient
        $objectif_patient_count_patient_from_after = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_from]
        );
        $objectif_patient_count_patient_target_after = $this->tester->grabNumRecords(
            'objectif_patient',
            ['id_patient' => $id_patient_target]
        );
        // observation
        $observation_count_patient_from_after = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_from]
        );
        $observation_count_patient_target_after = $this->tester->grabNumRecords(
            'observation',
            ['id_patient' => $id_patient_target]
        );
        // questionnaire_instance
        $questionnaire_instance_count_patient_from_after = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_from]
        );
        $questionnaire_instance_count_patient_target_after = $this->tester->grabNumRecords(
            'questionnaire_instance',
            ['id_patient' => $id_patient_target]
        );
        // a_participe_a
        $a_participe_a_count_patient_from_after = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_from]
        );
        $a_participe_a_count_patient_target_after = $this->tester->grabNumRecords(
            'a_participe_a',
            ['id_patient' => $id_patient_target]
        );
        // a_contacter_en_cas_urgence
        $a_contacter_en_cas_urgence_count_patient_from_after = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_from]
        );
        $a_contacter_en_cas_urgence_count_patient_target_after = $this->tester->grabNumRecords(
            'a_contacter_en_cas_urgence',
            ['id_patient' => $id_patient_target]
        );
        // evaluations
        $evaluations_count_patient_from_after = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_from]
        );
        $evaluations_count_patient_target_after = $this->tester->grabNumRecords(
            'evaluations',
            ['id_patient' => $id_patient_target]
        );
        // activites_physiques
        $activites_physiques_count_patient_from_after = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_from]
        );
        $activites_physiques_count_patient_target_after = $this->tester->grabNumRecords(
            'activites_physiques',
            ['id_patient' => $id_patient_target]
        );
        // orientation
        $orientation_count_patient_from_after = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_from]
        );
        $orientation_count_patient_target_after = $this->tester->grabNumRecords(
            'orientation',
            ['id_patient' => $id_patient_target]
        );
        // liste_participants_creneau
        $liste_participants_creneau_count_patient_from_after = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_from]
        );
        $liste_participants_creneau_count_patient_target_after = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_patient' => $id_patient_target]
        );
        // suit
        $suit_count_patient_from_after = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_from]
        );
        $suit_count_patient_target_after = $this->tester->grabNumRecords(
            'suit',
            ['id_patient' => $id_patient_target]
        );
        // traite
        $traite_count_patient_from_after = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_from]
        );
        $traite_count_patient_target_after = $this->tester->grabNumRecords(
            'traite',
            ['id_patient' => $id_patient_target]
        );
        // prescrit
        $prescrit_count_patient_from_after = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_from]
        );
        $prescrit_count_patient_target_after = $this->tester->grabNumRecords(
            'prescrit',
            ['id_patient' => $id_patient_target]
        );
        // parcours
        $parcours_count_patient_from_after = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_from]
        );
        $parcours_count_patient_target_after = $this->tester->grabNumRecords(
            'parcours',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du patient
        $coordonnees_count_patient_from_after = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_from]
        );
        $coordonnees_count_patient_target_after = $this->tester->grabNumRecords(
            'coordonnees',
            ['id_patient' => $id_patient_target]
        );
        // coordonnees du contact d'urgence
        $coordonnees_contact_count_patient_from_after = 0;
        if ($id_coordonnee_contact_urgence_from) {
            $coordonnees_contact_count_patient_from_after = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_from]
            );
        }
        $coordonnees_contact_count_patient_target_after = 0;
        if ($id_coordonnee_contact_urgence_target) {
            $coordonnees_contact_count_patient_target_after = $this->tester->grabNumRecords(
                'coordonnees',
                ['id_coordonnees' => $id_coordonnee_contact_urgence_target]
            );
        }
        // oriente_vers
        $oriente_vers_count_patient_from_after = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_from]
        );
        $oriente_vers_count_patient_target_after = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_patient' => $id_patient_target]
        );
        // souffre_de
        $souffre_de_count_patient_from_after = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_from]
        );
        $souffre_de_count_patient_target_after = $this->tester->grabNumRecords(
            'souffre_de',
            ['id_patient' => $id_patient_target]
        );

        // prescription
        $this->assertEquals(
            $prescription_count_patient_from_before + $prescription_count_patient_target_before,
            $prescription_count_patient_target_after
        );
        $this->assertEquals(0, $prescription_count_patient_from_after);
        // objectif_patient
        $this->assertEquals(
            $objectif_patient_count_patient_from_before + $objectif_patient_count_patient_target_before,
            $objectif_patient_count_patient_target_after
        );
        $this->assertEquals(0, $objectif_patient_count_patient_from_after);
        // observation
        $this->assertEquals(
            $observation_count_patient_from_before + $observation_count_patient_target_before,
            $observation_count_patient_target_after
        );
        $this->assertEquals(0, $observation_count_patient_from_after);
        // questionnaire_instance
        $this->assertEquals(
            $questionnaire_instance_count_patient_from_before + $questionnaire_instance_count_patient_target_before,
            $questionnaire_instance_count_patient_target_after
        );
        $this->assertEquals(0, $questionnaire_instance_count_patient_from_after);

        // a_participe_a
        // 3 pour id_patient_target et 0
        $this->assertEquals(3, $a_participe_a_count_patient_target_after, 'a_participe_a target after');
        $this->assertEquals(0, $a_participe_a_count_patient_from_after, 'a_participe_a from after');

        // evaluations
        // 1 pour id_patient_target
        $this->assertEquals(1, $evaluations_count_patient_target_after, 'evaluations target after');
        $this->assertEquals(0, $evaluations_count_patient_from_after, 'evaluations from after');

        // activites_physiques
        // 1 pour id_patient_target
        $this->assertEquals(1, $activites_physiques_count_patient_target_after, 'activites_physiques target after');
        $this->assertEquals(0, $activites_physiques_count_patient_from_after, 'activites_physiques from after');

        // orientation
        // 1 pour id_patient_target
        $this->assertEquals(1, $orientation_count_patient_target_after, 'orientation target after');
        $this->assertEquals(0, $orientation_count_patient_from_after, 'orientation from after');

        // liste_participants_creneau
        // 5 pour id_patient_target
        $this->assertEquals(
            5,
            $liste_participants_creneau_count_patient_target_after,
            'liste_participants_creneau target after'
        );
        $this->assertEquals(
            0,
            $liste_participants_creneau_count_patient_from_after,
            'liste_participants_creneau from after'
        );

        // suit
        // 1 pour id_patient_target
        $this->assertEquals(1, $suit_count_patient_target_after, 'suit target after');
        $this->assertEquals(0, $suit_count_patient_from_after, 'suit from after');

        // traite
        $this->assertEquals(0, $traite_count_patient_target_after, 'traite target after');
        $this->assertEquals(0, $traite_count_patient_from_after, 'traite from after');

        // prescrit
        $this->assertEquals(0, $prescrit_count_patient_target_after, 'prescrit target after');
        $this->assertEquals(0, $prescrit_count_patient_from_after, 'prescrit from after');

        // a_contacter_en_cas_urgence
        // 1 pour id_patient_from et 1 pour id_patient_target
        $this->assertEquals(
            1,
            $a_contacter_en_cas_urgence_count_patient_target_after,
            'a_contacter_en_cas_urgence target after'
        );
        $this->assertEquals(
            0,
            $a_contacter_en_cas_urgence_count_patient_from_after,
            'a_contacter_en_cas_urgence from after'
        );

        // oriente_vers
        // 1 pour id_patient_from et 1 pour id_patient_target (même structure)
        $this->assertEquals(2, $oriente_vers_count_patient_target_after, 'oriente_vers target after');
        $this->assertEquals(0, $oriente_vers_count_patient_from_after, 'oriente_vers from after');

        // souffre_de
        // 1 pour id_patient_from (-1 qui doit être supprimé) et 3 pour id_patient_target
        $this->assertEquals(3, $souffre_de_count_patient_target_after, 'souffre_de target after');
        $this->assertEquals(0, $souffre_de_count_patient_from_after, 'souffre_de from after');

        $this->tester->dontSeeInDatabase('adresse', [
            'id_adresse' => $id_adresse_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnees_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee_contact_urgence_from,
        ]);

        $this->tester->dontSeeInDatabase('parcours', [
            'id_parcours' => $id_parcours_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('evaluations', [
            'id_patient' => $id_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('patients', [
            'id_patient' => $id_patient_from,
        ]);

        $this->tester->dontSeeInDatabase('souffre_de', [
            'id_patient' => $id_patient_from,
        ]);
    }

    public function testGetAllPatientEvaluationLateOk()
    {
        // test 1
        $today = "2022-06-23";
        $ids_expected = ["1"];

        $ids = $this->patient->getAllPatientEvaluationLate($today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids, "test 1 failed");

        // test 2
        $today = "2022-06-24";
        $ids_expected = [];

        $ids = $this->patient->getAllPatientEvaluationLate($today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids, "test 2 failed");

        // test 3
        // l'évaluation du patient id=6 qui a eu lieu il y a 90 jours (le 2022-06-03) est une évaluation finale et
        // ne doit pas être prise en compte
        // le patient id=4 a aussi eu une évaluation le 2022-06-03, mais elle n'est pas finale
        $today = "2022-09-01";
        $ids_expected = ["4"];

        $ids = $this->patient->getAllPatientEvaluationLate($today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids, "test 3 failed");

        //test 4
        // L'évaluation du patient id=7 a une valeur pour le champ date_eval_suiv (le 2022-06-04) donc
        // son intervalle n'est pas pris en compte par rapport à sa dernière évaluation
        $today = "2022-06-04";
        $ids_expected = ["7"];

        $ids = $this->patient->getAllPatientEvaluationLate($today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids, "test 4 failed");
    }


    public function testGetAllPatientEvaluationLateNotOkTodayNull()
    {
        $today = null;
        $ids_expected = [];

        $ids = $this->patient->getAllPatientEvaluationLate($today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids);
    }

    public function testDeleteNotOkId_patientNull()
    {
        $id_patient = null;

        $delete_ok = $this->patient->delete($id_patient);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkId_patientInvalide()
    {
        $id_patient = '-1';

        $delete_ok = $this->patient->delete($id_patient);

        $this->assertFalse($delete_ok);
    }

    public function testDeletePatientOk()
    {
        $id_patient = '5';

        $id_adresse = $this->tester->grabFromDatabase(
            'patients',
            'id_adresse',
            ['id_patient' => $id_patient]
        );

        $id_coordonnee_urgence = $this->tester->grabFromDatabase(
            'a_contacter_en_cas_urgence',
            'id_coordonnee',
            ['id_patient' => $id_patient]
        );

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $patients_count_before = $this->tester->grabNumRecords('patients');

        $delete_ok = $this->patient->delete($id_patient);
        $this->assertTrue($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $patients_count_after = $this->tester->grabNumRecords('patients');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after + 2);
        $this->assertEquals($patients_count_before, $patients_count_after + 1);


        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->dontSeeInDatabase('patients', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->dontSeeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->dontSeeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->dontSeeInDatabase('parcours', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->dontSeeInDatabase('a_contacter_en_cas_urgence', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnee_urgence,
        ]);

        $this->tester->dontSeeInDatabase('prescrit', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->dontSeeInDatabase('traite', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->dontSeeInDatabase('suit', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->dontSeeInDatabase('oriente_vers', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->dontSeeInDatabase('souffre_de', [
            'id_patient' => $id_patient,
        ]);
    }

    public function testDeletePatientNotOkPrescription()
    {
        $id_patient = '7';

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $patients_count_before = $this->tester->grabNumRecords('patients');

        $delete_ok = $this->patient->delete($id_patient);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $patients_count_after = $this->tester->grabNumRecords('patients');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($patients_count_before, $patients_count_after);


        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
        ]);
    }

    public function testDeletePatientNotOkEvaluations()
    {
        $id_patient = '6';

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $patients_count_before = $this->tester->grabNumRecords('patients');

        $delete_ok = $this->patient->delete($id_patient);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $patients_count_after = $this->tester->grabNumRecords('patients');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($patients_count_before, $patients_count_after);

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
        ]);
    }

    public function testDeletePatientNotOkActivitePhysique()
    {
        $id_patient = '9';

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $patients_count_before = $this->tester->grabNumRecords('patients');

        $delete_ok = $this->patient->delete($id_patient);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $patients_count_after = $this->tester->grabNumRecords('patients');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($patients_count_before, $patients_count_after);

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
        ]);
    }

    public function testDeletePatientNotOkQuestionnaire()
    {
        $id_patient = '10';

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $patients_count_before = $this->tester->grabNumRecords('patients');

        $delete_ok = $this->patient->delete($id_patient);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $patients_count_after = $this->tester->grabNumRecords('patients');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($patients_count_before, $patients_count_after);

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
        ]);
    }

    public function testDeletePatientNotOkObjectif()
    {
        $id_patient = '11';

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $patients_count_before = $this->tester->grabNumRecords('patients');

        $delete_ok = $this->patient->delete($id_patient);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $patients_count_after = $this->tester->grabNumRecords('patients');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($patients_count_before, $patients_count_after);

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
        ]);
    }

    public function testDeletePatientNotOkOrientation()
    {
        $id_patient = '12';

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $patients_count_before = $this->tester->grabNumRecords('patients');

        $delete_ok = $this->patient->delete($id_patient);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $patients_count_after = $this->tester->grabNumRecords('patients');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($patients_count_before, $patients_count_after);

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
        ]);
    }

    public function testDeletePatientNotOkALD()
    {
        $id_patient = '8';

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $patients_count_before = $this->tester->grabNumRecords('patients');

        $delete_ok = $this->patient->delete($id_patient);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $patients_count_after = $this->tester->grabNumRecords('patients');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($patients_count_before, $patients_count_after);

        $this->tester->seeInDatabase('coordonnees', [
            'id_patient' => $id_patient,
        ]);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
        ]);
    }

    public function testGetAgeOk()
    {
        $id_patient = "1";

        $age = $this->patient->getAge($id_patient);
        $this->assertIsInt($age);
        $this->assertGreaterThanOrEqual(52, $age); // age 22 en 2022
    }

    public function testGetAgeNotOkId_patientNull()
    {
        $id_patient = null;

        $age = $this->patient->getAge($id_patient);
        $this->assertNull($age);
    }

    public function testGetAgeNotOkId_patientInvalid()
    {
        $id_patient = "-1";

        $age = $this->patient->getAge($id_patient);
        $this->assertNull($age);
    }

    public function testUpdateDateEvalSuivOkDateNotNull()
    {
        $id_patient = "7";
        $date_eval_suiv_before = $this->tester->grabFromDatabase(
            'patients',
            'date_eval_suiv',
            ['id_patient' => $id_patient]
        );

        $update = $this->patient->updateDateEvalSuiv($id_patient, '2023-10-10');
        $this->assertTrue($update);
        $this->tester->dontSeeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_eval_suiv' => $date_eval_suiv_before
        ]);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_eval_suiv' => '2023-10-10'
        ]);
    }

    public function testUpdateDateEvalSuivOkDateNull()
    {
        $id_patient = "7";
        $date_eval_suiv_before = $this->tester->grabFromDatabase(
            'patients',
            'date_eval_suiv',
            ['id_patient' => $id_patient]
        );
        $update = $this->patient->updateDateEvalSuiv($id_patient, null);
        $this->assertTrue($update);

        $this->tester->dontSeeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_eval_suiv' => $date_eval_suiv_before
        ]);

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'date_eval_suiv' => null
        ]);
    }

    public function testUpdateDateEvalSuivNotOk()
    {
        $id_patient = null;
        $update = $this->patient->updateDateEvalSuiv($id_patient, '2023-10-10');
        $this->assertFalse($update);
    }

    public function testReadAllOkSuperAdminEst_archive0()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
            'id_structure' => null,
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "0";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $patients_count = $this->tester->grabNumRecords(
            'patients',
            ['est_archive' => $est_archive]
        );
        $this->assertGreaterThan(0, $patients_count);
        $this->assertCount($patients_count, $patients);

        foreach ($patients as $patient) {
            $this->assertArrayHasKey('nom_patient', $patient);
            $this->assertArrayHasKey('prenom_patient', $patient);
            $this->assertArrayHasKey('nom_naissance', $patient);
            $this->assertArrayHasKey('premier_prenom_naissance', $patient);
            $this->assertArrayHasKey('matricule_ins', $patient);
            $this->assertArrayHasKey('cle', $patient);
            $this->assertArrayHasKey('oid', $patient);
            $this->assertArrayHasKey('code_insee_naissance', $patient);
            $this->assertArrayHasKey('nom_utilise', $patient);
            $this->assertArrayHasKey('prenom_utilise', $patient);
            $this->assertArrayHasKey('liste_prenom_naissance', $patient);
            $this->assertArrayHasKey('tel_fixe_patient', $patient);
            $this->assertArrayHasKey('tel_portable_patient', $patient);
            $this->assertArrayHasKey('mail_patient', $patient);
            $this->assertArrayHasKey('nom_medecin', $patient);
            $this->assertArrayHasKey('prenom_medecin', $patient);
            $this->assertArrayHasKey('nom_suivi', $patient);
            $this->assertArrayHasKey('prenom_suivi', $patient);
            $this->assertArrayHasKey('role_user_suivi', $patient);
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('date_admission', $patient);
            $this->assertArrayHasKey('nom_antenne', $patient);
            $this->assertArrayHasKey('nom_structure', $patient);
            $this->assertArrayHasKey('intervalle', $patient);
            $this->assertArrayHasKey('date_archivage', $patient);
            $this->assertArrayHasKey('est_non_peps', $patient);

            $this->assertArrayHasKey('id_type_eval', $patient);
            $this->assertArrayHasKey('date_eval', $patient);
            $this->assertArrayHasKey('a_prescription', $patient);

            $this->assertArrayHasKey('a_termine_programme', $patient);
            $this->assertIsBool($patient['a_termine_programme']);
            $this->assertArrayHasKey('est_archive', $patient);
            $this->assertIsBool($patient['est_archive']);
            $this->assertArrayHasKey('date_eval_suiv', $patient);
        }
    }

    public function testReadAllOkSuperAdminEst_archive1()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
            'id_structure' => null,
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $patients_count = $this->tester->grabNumRecords(
            'patients',
            ['est_archive' => $est_archive]
        );
        $this->assertGreaterThan(0, $patients_count);
        $this->assertCount($patients_count, $patients);

        foreach ($patients as $patient) {
            $this->assertArrayHasKey('nom_patient', $patient);
            $this->assertArrayHasKey('prenom_patient', $patient);
            $this->assertArrayHasKey('nom_naissance', $patient);
            $this->assertArrayHasKey('premier_prenom_naissance', $patient);
            $this->assertArrayHasKey('matricule_ins', $patient);
            $this->assertArrayHasKey('cle', $patient);
            $this->assertArrayHasKey('oid', $patient);
            $this->assertArrayHasKey('code_insee_naissance', $patient);
            $this->assertArrayHasKey('nom_utilise', $patient);
            $this->assertArrayHasKey('prenom_utilise', $patient);
            $this->assertArrayHasKey('liste_prenom_naissance', $patient);
            $this->assertArrayHasKey('tel_fixe_patient', $patient);
            $this->assertArrayHasKey('tel_portable_patient', $patient);
            $this->assertArrayHasKey('mail_patient', $patient);
            $this->assertArrayHasKey('nom_medecin', $patient);
            $this->assertArrayHasKey('prenom_medecin', $patient);
            $this->assertArrayHasKey('nom_suivi', $patient);
            $this->assertArrayHasKey('prenom_suivi', $patient);
            $this->assertArrayHasKey('role_user_suivi', $patient);
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('date_admission', $patient);
            $this->assertArrayHasKey('nom_antenne', $patient);
            $this->assertArrayHasKey('nom_structure', $patient);
            $this->assertArrayHasKey('intervalle', $patient);
            $this->assertArrayHasKey('date_archivage', $patient);
            $this->assertArrayHasKey('est_non_peps', $patient);

            $this->assertArrayHasKey('id_type_eval', $patient);
            $this->assertArrayHasKey('date_eval', $patient);
            $this->assertArrayHasKey('a_prescription', $patient);

            $this->assertArrayHasKey('a_termine_programme', $patient);
            $this->assertIsBool($patient['a_termine_programme']);
            $this->assertArrayHasKey('est_archive', $patient);
            $this->assertIsBool($patient['est_archive']);
            $this->assertArrayHasKey('date_eval_suiv', $patient);
        }
    }

    public function testReadAllOkCoordonateurPepsEst_archive0()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "0";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $patients_count = $this->tester->grabNumRecords(
            'patients',
            // les coordo PEPS ne doivent pas voir les patients non-PEPS
            ['id_territoire' => $session['id_territoire'], 'est_archive' => $est_archive, 'est_non_peps' => '0']
        );
        $this->assertGreaterThan(0, $patients_count);
        $this->assertCount($patients_count, $patients);
    }

    public function testReadAllOkCoordonateurPepsEst_archive1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $patients_count = $this->tester->grabNumRecords(
            'patients',
            ['id_territoire' => $session['id_territoire'], 'est_archive' => $est_archive]
        );
        $this->assertGreaterThan(0, $patients_count);
        $this->assertCount($patients_count, $patients);
    }

    public function testReadAllOkCoordonateurMssEst_archive0()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => '1',
            'id_structure' => '8',
            'id_user' => '26',
        ];
        $est_archive = "0";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        // 1 patient dans la structure
        // 1 patient dans une structure différente mais user est l'évaluateur
        $this->assertCount(2, $patients);
    }

    public function testReadAllOkCoordonateurMssEst_archive1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => '1',
            'id_structure' => '8',
            'id_user' => '26',
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $this->assertCount(0, $patients);
    }

    public function testReadAllOkCoordonateurNonMssEst_archive0()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2", // non MSS
            'id_territoire' => '1',
            'id_structure' => '2',
            'id_user' => '16',
        ];
        $est_archive = "0";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        // 1 patient dans la structure
        // 1 patient dans une structure différente mais user est l'évaluateur
        $this->assertCount(2, $patients);
    }

    public function testReadAllOkCoordonateurNonMssEst_archive1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2", // non MSS
            'id_territoire' => '1',
            'id_structure' => '2',
            'id_user' => '16',
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);
        // pas de patients archivés
        $this->assertCount(0, $patients);
    }

    public function testReadAllOkResponsableStructureEst_archive0()
    {
        $session = [
            'role_user_ids' => ['6'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "0";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $antennes_ids = $this->tester->grabColumnFromDatabase(
            'antenne',
            'id_antenne',
            ['id_structure' => $session['id_structure']]
        );
        $patients_count = 0;
        foreach ($antennes_ids as $id_antenne) {
            $patients_count += $this->tester->grabNumRecords(
                'patients',
                ['id_antenne' => $id_antenne, 'est_archive' => $est_archive]
            );
        }
        $this->assertCount($patients_count, $patients);
    }

    public function testReadAllOkResponsableStructureEst_archive1()
    {
        $session = [
            'role_user_ids' => ['6'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $antennes_ids = $this->tester->grabColumnFromDatabase(
            'antenne',
            'id_antenne',
            ['id_structure' => $session['id_structure']]
        );
        $patients_count = 0;
        foreach ($antennes_ids as $id_antenne) {
            $patients_count += $this->tester->grabNumRecords(
                'patients',
                ['id_antenne' => $id_antenne, 'est_archive' => $est_archive]
            );
        }
        $this->assertCount($patients_count, $patients);
    }

    public function testReadAllOkReferentEst_archive0()
    {
        $session = [
            'role_user_ids' => ['4'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "0";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $antennes_ids = $this->tester->grabColumnFromDatabase(
            'antenne',
            'id_antenne',
            ['id_structure' => $session['id_structure']]
        );
        $patients_count = 0;
        foreach ($antennes_ids as $id_antenne) {
            $patients_count += $this->tester->grabNumRecords(
                'patients',
                ['id_antenne' => $id_antenne, 'est_archive' => $est_archive]
            );
        }
        $this->assertCount($patients_count, $patients);
    }

    public function testReadAllOkReferentEst_archive1()
    {
        $session = [
            'role_user_ids' => ['4'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $antennes_ids = $this->tester->grabColumnFromDatabase(
            'antenne',
            'id_antenne',
            ['id_structure' => $session['id_structure']]
        );
        $patients_count = 0;
        foreach ($antennes_ids as $id_antenne) {
            $patients_count += $this->tester->grabNumRecords(
                'patients',
                ['id_antenne' => $id_antenne, 'est_archive' => $est_archive]
            );
        }
        $this->assertCount($patients_count, $patients);
    }

    public function testReadAllOkEvaluateurEst_archive0()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '7', // un évaluateur
        ];
        $est_archive = "0";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $patients_count = $this->tester->grabNumRecords(
            'patients',
            ['id_user' => $session['id_user'], 'est_archive' => $est_archive]
        );
        $this->assertCount($patients_count, $patients);
    }

    public function testReadAllOkEvaluateurEst_archive1()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '7', // un évaluateur
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $patients_count = $this->tester->grabNumRecords(
            'patients',
            ['id_user' => $session['id_user'], 'est_archive' => $est_archive]
        );
        $this->assertCount($patients_count, $patients);
    }

    public function testReadAllNotOkId_role_userNull()
    {
        $session = [
            'role_user_ids' => null,
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertFalse($patients);
    }

    public function testReadAllNotOkEst_coordinateur_pepsNull()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => null,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertFalse($patients);
    }

    public function testReadAllOkSecretaireEst_archive0()
    {
        $session = [
            'role_user_ids' => ['8'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "0";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $antennes_ids = $this->tester->grabColumnFromDatabase(
            'antenne',
            'id_antenne',
            ['id_structure' => $session['id_structure']]
        );
        $patients_count = 0;
        foreach ($antennes_ids as $id_antenne) {
            $patients_count += $this->tester->grabNumRecords(
                'patients',
                ['id_antenne' => $id_antenne, 'est_archive' => $est_archive]
            );
        }
        $this->assertCount($patients_count, $patients);
    }

    public function testReadAllOkSecretaireEst_archive1()
    {
        $session = [
            'role_user_ids' => ['8'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertIsArray($patients);

        $antennes_ids = $this->tester->grabColumnFromDatabase(
            'antenne',
            'id_antenne',
            ['id_structure' => $session['id_structure']]
        );
        $patients_count = 0;
        foreach ($antennes_ids as $id_antenne) {
            $patients_count += $this->tester->grabNumRecords(
                'patients',
                ['id_antenne' => $id_antenne, 'est_archive' => $est_archive]
            );
        }
        $this->assertCount($patients_count, $patients);
    }

    public function testReadAllNotOkId_territoireNull()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2",
            'id_territoire' => null,
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertFalse($patients);
    }

    public function testReadAllNotOkId_structureNullAndNotSuperAdmin()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => null,
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertFalse($patients);
    }

    public function testReadAllNotOkId_statut_structureNullAndNotSuperAdmin()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "1";

        $patients = $this->patient->readAll($session, $est_archive);
        $this->assertFalse($patients);
    }

    public function testReadAllSuiviOkCoordoPEPS()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => '2',
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '2',
        ];

        $patients = $this->patient->readAllSuivi($session);
        $this->assertNotFalse($patients);
        $this->assertIsArray($patients);

        $patients_count = $this->tester->grabNumRecords(
            'dossiers_suivi',
            ['id_user' => $session['id_user']]
        );
        $this->assertGreaterThan(0, $patients_count);
        $this->assertCount($patients_count, $patients);

        foreach ($patients as $patient) {
            $this->assertArrayHasKey('nom_patient', $patient);
            $this->assertArrayHasKey('prenom_patient', $patient);
            $this->assertArrayHasKey('nom_naissance', $patient);
            $this->assertArrayHasKey('premier_prenom_naissance', $patient);
            $this->assertArrayHasKey('matricule_ins', $patient);
            $this->assertArrayHasKey('oid', $patient);
            $this->assertArrayHasKey('code_insee_naissance', $patient);
            $this->assertArrayHasKey('nom_utilise', $patient);
            $this->assertArrayHasKey('prenom_utilise', $patient);
            $this->assertArrayHasKey('liste_prenom_naissance', $patient);
            $this->assertArrayHasKey('tel_fixe_patient', $patient);
            $this->assertArrayHasKey('tel_portable_patient', $patient);
            $this->assertArrayHasKey('mail_patient', $patient);
            $this->assertArrayHasKey('nom_medecin', $patient);
            $this->assertArrayHasKey('prenom_medecin', $patient);
            $this->assertArrayHasKey('nom_suivi', $patient);
            $this->assertArrayHasKey('prenom_suivi', $patient);
            $this->assertArrayHasKey('role_user_suivi', $patient);
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('date_admission', $patient);
            $this->assertArrayHasKey('nom_antenne', $patient);
            $this->assertArrayHasKey('nom_structure', $patient);
            $this->assertArrayHasKey('intervalle', $patient);
            $this->assertArrayHasKey('date_archivage', $patient);
            $this->assertArrayHasKey('est_non_peps', $patient);

            $this->assertArrayHasKey('id_type_eval', $patient);
            $this->assertArrayHasKey('date_eval', $patient);
            $this->assertArrayHasKey('a_prescription', $patient);

            $this->assertArrayHasKey('a_termine_programme', $patient);
            $this->assertIsBool($patient['a_termine_programme']);
            $this->assertArrayHasKey('est_archive', $patient);
            $this->assertIsBool($patient['est_archive']);
            $this->assertArrayHasKey('date_eval_suiv', $patient);
        }
    }

    public function testReadAllSuiviOkCoordoMSS()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '1',
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '2',
        ];

        $patients = $this->patient->readAllSuivi($session);
        $this->assertNotFalse($patients);
        $this->assertIsArray($patients);

        $patients_count = $this->tester->grabNumRecords(
            'dossiers_suivi',
            ['id_user' => $session['id_user']]
        );
        $this->assertGreaterThan(0, $patients_count);
        $this->assertCount($patients_count, $patients);

        foreach ($patients as $patient) {
            $this->assertArrayHasKey('nom_patient', $patient);
            $this->assertArrayHasKey('prenom_patient', $patient);
            $this->assertArrayHasKey('nom_naissance', $patient);
            $this->assertArrayHasKey('premier_prenom_naissance', $patient);
            $this->assertArrayHasKey('matricule_ins', $patient);
            $this->assertArrayHasKey('oid', $patient);
            $this->assertArrayHasKey('code_insee_naissance', $patient);
            $this->assertArrayHasKey('nom_utilise', $patient);
            $this->assertArrayHasKey('prenom_utilise', $patient);
            $this->assertArrayHasKey('liste_prenom_naissance', $patient);
            $this->assertArrayHasKey('tel_fixe_patient', $patient);
            $this->assertArrayHasKey('tel_portable_patient', $patient);
            $this->assertArrayHasKey('mail_patient', $patient);
            $this->assertArrayHasKey('nom_medecin', $patient);
            $this->assertArrayHasKey('prenom_medecin', $patient);
            $this->assertArrayHasKey('nom_suivi', $patient);
            $this->assertArrayHasKey('prenom_suivi', $patient);
            $this->assertArrayHasKey('role_user_suivi', $patient);
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('date_admission', $patient);
            $this->assertArrayHasKey('nom_antenne', $patient);
            $this->assertArrayHasKey('nom_structure', $patient);
            $this->assertArrayHasKey('intervalle', $patient);
            $this->assertArrayHasKey('date_archivage', $patient);
            $this->assertArrayHasKey('est_non_peps', $patient);

            $this->assertArrayHasKey('id_type_eval', $patient);
            $this->assertArrayHasKey('date_eval', $patient);
            $this->assertArrayHasKey('a_prescription', $patient);

            $this->assertArrayHasKey('a_termine_programme', $patient);
            $this->assertIsBool($patient['a_termine_programme']);
            $this->assertArrayHasKey('est_archive', $patient);
            $this->assertIsBool($patient['est_archive']);
            $this->assertArrayHasKey('date_eval_suiv', $patient);
        }
    }

    public function testReadAllSuiviNotOkWrongRole()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '2',
        ];

        $patients = $this->patient->readAllSuivi($session);
        $this->assertFalse($patients);
    }

    public function testReadAllSuiviNotOkMissingRole()
    {
        $session = [
            'role_user_ids' => [],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '2',
        ];

        $patients = $this->patient->readAllSuivi($session);
        $this->assertFalse($patients);
    }

    public function testReadAllSuiviNotOkMissingEstCoordoPEPS()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => null,
            'id_statut_structure' => "1",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '2',
        ];

        $patients = $this->patient->readAllSuivi($session);
        $this->assertFalse($patients);
    }

    public function testReadAllSuiviNotOkMissingStatutStructure()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '2',
        ];

        $patients = $this->patient->readAllSuivi($session);
        $this->assertFalse($patients);
    }

    public function testReadAllSuiviNotOkMissingIdUser()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => null,
        ];

        $patients = $this->patient->readAllSuivi($session);
        $this->assertFalse($patients);
    }

    public function testReadAllOrienteOk()
    {
        $id_structure = '1';

        $patients = $this->patient->readAllOriente($id_structure);
        $this->assertIsArray($patients);

        $patients_count = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_structure' => $id_structure]
        );
        $this->assertCount($patients_count, $patients);

        $this->assertArrayHasKey('nom_patient', $patients[0]);
        $this->assertArrayHasKey('prenom_patient', $patients[0]);
        $this->assertArrayHasKey('tel_fixe_patient', $patients[0]);
        $this->assertArrayHasKey('tel_portable_patient', $patients[0]);
        $this->assertArrayHasKey('mail_patient', $patients[0]);
        $this->assertArrayHasKey('id_patient', $patients[0]);
    }

    public function testReadAllOrienteNotOkId_structureNull()
    {
        $id_structure = null;

        $patients = $this->patient->readAllOriente($id_structure);
        $this->assertFalse($patients);
    }

    public function testReadAllBasicOk()
    {
        $patients_count = $this->tester->grabNumRecords("patients");

        $patients = $this->patient->readAllBasic();
        $this->assertIsArray($patients);
        $this->assertNotEmpty($patients);
        $this->assertCount($patients_count, $patients);

        foreach ($patients as $patient) {
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('nom_naissance', $patient);
            $this->assertArrayHasKey('premier_prenom_naissance', $patient);
            $this->assertArrayHasKey('nom_utilise', $patient);
            $this->assertArrayHasKey('prenom_utilise', $patient);
            $this->assertArrayHasKey('nom_patient', $patient);
            $this->assertArrayHasKey('prenom_patient', $patient);
            $this->assertArrayHasKey('sexe_patient', $patient);
            $this->assertArrayHasKey('date_naissance', $patient);
            $this->assertArrayHasKey('nom_adresse', $patient);
            $this->assertArrayHasKey('complement_adresse', $patient);
            $this->assertArrayHasKey('code_postal', $patient);
            $this->assertArrayHasKey('nom_ville', $patient);
            $this->assertArrayHasKey('email_patient', $patient);
            $this->assertArrayHasKey('tel_fixe_patient', $patient);
            $this->assertArrayHasKey('tel_portable_patient', $patient);
            $this->assertArrayHasKey('est_pris_en_charge_financierement', $patient);
            $this->assertArrayHasKey('hauteur_prise_en_charge_financierement', $patient);
            $this->assertArrayHasKey('sit_part_autre', $patient);
            $this->assertArrayHasKey('sit_part_education_therapeutique', $patient);
            $this->assertArrayHasKey('sit_part_grossesse', $patient);
            $this->assertArrayHasKey('sit_part_prevention_chute', $patient);
            $this->assertArrayHasKey('sit_part_sedentarite', $patient);
            $this->assertArrayHasKey('est_dans_zrr', $patient);
            $this->assertArrayHasKey('est_dans_qpv', $patient);
            $this->assertArrayHasKey('est_archive', $patient);
        }

        //test tri ordre alphabétique
        $this->assertEquals("ABOU", $patients[0]["nom_patient"]);

        $this->assertEquals("BOB", $patients[1]["nom_patient"]);

        $this->assertEquals("DERIVE", $patients[2]["nom_patient"]);

        $this->assertEquals("NOMPATIENT", $patients[3]["nom_patient"]);

        $this->assertEquals("TESTSUPPPATIENT", $patients[4]["nom_patient"]);
        $this->assertEquals("ACTIVITEPHYSIQUE", $patients[4]["prenom_patient"]);

        $this->assertEquals("TESTSUPPPATIENT", $patients[5]["nom_patient"]);
        $this->assertEquals("EVALUATION", $patients[5]["prenom_patient"]);

        $this->assertEquals("TESTSUPPPATIENT", $patients[6]["nom_patient"]);
        $this->assertEquals("OBJECTIF", $patients[6]["prenom_patient"]);

        $this->assertEquals("TESTSUPPPATIENT", $patients[7]["nom_patient"]);
        $this->assertEquals("ORIENTATION", $patients[7]["prenom_patient"]);

        $this->assertEquals("TESTSUPPPATIENT", $patients[8]["nom_patient"]);
        $this->assertEquals("PRESCRIPTION", $patients[8]["prenom_patient"]);

        $this->assertEquals("TESTSUPPPATIENT", $patients[9]["nom_patient"]);
        $this->assertEquals("QUESTIONNAIRE", $patients[9]["prenom_patient"]);
    }

    public function testReadAllBasicOkFilter_territoire1()
    {
        $id_territoire = "1";

        $patients_count = $this->tester->grabNumRecords("patients", ['id_territoire' => $id_territoire]);

        $patients = $this->patient->readAllBasic($id_territoire);
        $this->assertIsArray($patients);
        $this->assertCount($patients_count, $patients);

        foreach ($patients as $patient) {
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('nom_naissance', $patient);
            $this->assertArrayHasKey('premier_prenom_naissance', $patient);
            $this->assertArrayHasKey('nom_utilise', $patient);
            $this->assertArrayHasKey('prenom_utilise', $patient);
            $this->assertArrayHasKey('nom_patient', $patient);
            $this->assertArrayHasKey('prenom_patient', $patient);
            $this->assertArrayHasKey('sexe_patient', $patient);
            $this->assertArrayHasKey('date_naissance', $patient);
            $this->assertArrayHasKey('nom_adresse', $patient);
            $this->assertArrayHasKey('complement_adresse', $patient);
            $this->assertArrayHasKey('code_postal', $patient);
            $this->assertArrayHasKey('nom_ville', $patient);
            $this->assertArrayHasKey('email_patient', $patient);
            $this->assertArrayHasKey('tel_fixe_patient', $patient);
            $this->assertArrayHasKey('tel_portable_patient', $patient);
            $this->assertArrayHasKey('est_pris_en_charge_financierement', $patient);
            $this->assertArrayHasKey('hauteur_prise_en_charge_financierement', $patient);
            $this->assertArrayHasKey('sit_part_autre', $patient);
            $this->assertArrayHasKey('sit_part_education_therapeutique', $patient);
            $this->assertArrayHasKey('sit_part_grossesse', $patient);
            $this->assertArrayHasKey('sit_part_prevention_chute', $patient);
            $this->assertArrayHasKey('sit_part_sedentarite', $patient);
            $this->assertArrayHasKey('est_dans_zrr', $patient);
            $this->assertArrayHasKey('est_dans_qpv', $patient);
            $this->assertArrayHasKey('est_archive', $patient);
        }
    }

    public function testReadAllBasicOkFilter_territoire2()
    {
        $id_territoire = "2";

        $patients_count = $this->tester->grabNumRecords("patients", ['id_territoire' => $id_territoire]);

        $patients = $this->patient->readAllBasic($id_territoire);
        $this->assertIsArray($patients);
        $this->assertCount($patients_count, $patients);

        foreach ($patients as $patient) {
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('nom_naissance', $patient);
            $this->assertArrayHasKey('premier_prenom_naissance', $patient);
            $this->assertArrayHasKey('nom_utilise', $patient);
            $this->assertArrayHasKey('prenom_utilise', $patient);
            $this->assertArrayHasKey('nom_patient', $patient);
            $this->assertArrayHasKey('prenom_patient', $patient);
            $this->assertArrayHasKey('sexe_patient', $patient);
            $this->assertArrayHasKey('date_naissance', $patient);
            $this->assertArrayHasKey('nom_adresse', $patient);
            $this->assertArrayHasKey('complement_adresse', $patient);
            $this->assertArrayHasKey('code_postal', $patient);
            $this->assertArrayHasKey('nom_ville', $patient);
            $this->assertArrayHasKey('email_patient', $patient);
            $this->assertArrayHasKey('tel_fixe_patient', $patient);
            $this->assertArrayHasKey('tel_portable_patient', $patient);
            $this->assertArrayHasKey('est_pris_en_charge_financierement', $patient);
            $this->assertArrayHasKey('hauteur_prise_en_charge_financierement', $patient);
            $this->assertArrayHasKey('sit_part_autre', $patient);
            $this->assertArrayHasKey('sit_part_education_therapeutique', $patient);
            $this->assertArrayHasKey('sit_part_grossesse', $patient);
            $this->assertArrayHasKey('sit_part_prevention_chute', $patient);
            $this->assertArrayHasKey('sit_part_sedentarite', $patient);
            $this->assertArrayHasKey('est_dans_zrr', $patient);
            $this->assertArrayHasKey('est_dans_qpv', $patient);
            $this->assertArrayHasKey('est_archive', $patient);
        }
    }

    public function testVerifyIdentityOk()
    {
        $id_patient = "4";
        $id_type_piece_identite = "2";

        $update_ok = $this->patient->verifyIdentity($id_patient, $id_type_piece_identite);
        $this->assertTrue($update_ok, $this->patient->getErrorMessage());

        $this->tester->seeInDatabase('patients', [
            'id_patient' => $id_patient,
            'id_type_piece_identite' => $id_type_piece_identite,
            'id_type_statut_identite' => "4",  // "Qualifiée"
        ]);
    }

    public function testVerifyIdentityNotOkId_patientNull()
    {
        $id_patient = null;
        $id_type_piece_identite = "2";

        $update_ok = $this->patient->verifyIdentity($id_patient, $id_type_piece_identite);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Il manque au moins un paramètre obligatoire", $this->patient->getErrorMessage());
    }

    public function testVerifyIdentityNotOkId_type_piece_identiteNull()
    {
        $id_patient = "4";
        $id_type_piece_identite = null;

        $update_ok = $this->patient->verifyIdentity($id_patient, $id_type_piece_identite);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Il manque au moins un paramètre obligatoire", $this->patient->getErrorMessage());
    }

    public function testVerifyIdentityNotOkId_patientDoesntExist()
    {
        $id_patient = "-1";
        $id_type_piece_identite = "2";

        $update_ok = $this->patient->verifyIdentity($id_patient, $id_type_piece_identite);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Ce patient n'existe pas", $this->patient->getErrorMessage());
    }

    public function testVerifyIdentityNotOkId_type_piece_identiteInvalid()
    {
        $id_patient = "4";
        $id_type_piece_identite = "1";

        $update_ok = $this->patient->verifyIdentity($id_patient, $id_type_piece_identite);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals("Le type de pièce d'identité est invalide", $this->patient->getErrorMessage());
    }

    public function testVerifyIdentityNotOkPatientId_type_statut_identiteInvalid()
    {
        $id_patient = "1";
        $id_type_piece_identite = "2";

        $update_ok = $this->patient->verifyIdentity($id_patient, $id_type_piece_identite);
        $this->assertFalse($update_ok, $this->patient->getErrorMessage());
        $this->assertEquals('Ce patient n\'a pas le statut d\'identité "Récupérée"', $this->patient->getErrorMessage());
    }
}