<?php

namespace Tests\Unit;

use PDO;
use Sportsante86\Sapa\Model\Medecin;
use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\UnitTester;

class MedecinTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Medecin $medecin;

    private PDO $pdo;

    protected function _before()
    {
        $this->pdo = $this->getModule('Db')->_getDbh();
        $this->medecin = new Medecin($this->pdo);
        $this->assertNotNull($this->medecin);
    }

    protected function _after()
    {
    }

    public function testFuseOk()
    {
        $id_medecin_from = "1";
        $id_medecin_target = "2";

        // données à update
        $suit_count_medecin_from_before = $this->tester->grabNumRecords(
            'suit',
            ['id_medecin' => $id_medecin_from]
        );
        $suit_count_medecin_target_before = $this->tester->grabNumRecords(
            'suit',
            ['id_medecin' => $id_medecin_target]
        );
        $prescrit_count_medecin_from_before = $this->tester->grabNumRecords(
            'prescrit',
            ['id_medecin' => $id_medecin_from]
        );
        $prescrit_count_medecin_target_before = $this->tester->grabNumRecords(
            'prescrit',
            ['id_medecin' => $id_medecin_target]
        );
        $traite_count_medecin_from_before = $this->tester->grabNumRecords(
            'traite',
            ['id_medecin' => $id_medecin_from]
        );
        $traite_count_medecin_target_before = $this->tester->grabNumRecords(
            'traite',
            ['id_medecin' => $id_medecin_target]
        );

        // données à supprimer
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $pratique_a_count_before = $this->tester->grabNumRecords('coordonnees');
        $siege_count_before = $this->tester->grabNumRecords('coordonnees');
        $medecins_count_before = $this->tester->grabNumRecords('coordonnees');

        $fuse_ok = $this->medecin->fuse($id_medecin_from, $id_medecin_target);
        $this->assertTrue($fuse_ok);

        // données à update
        $suit_count_medecin_from_after = $this->tester->grabNumRecords(
            'suit',
            ['id_medecin' => $id_medecin_from]
        );
        $suit_count_medecin_target_after = $this->tester->grabNumRecords(
            'suit',
            ['id_medecin' => $id_medecin_target]
        );
        $prescrit_count_medecin_from_after = $this->tester->grabNumRecords(
            'prescrit',
            ['id_medecin' => $id_medecin_from]
        );
        $prescrit_count_medecin_target_after = $this->tester->grabNumRecords(
            'prescrit',
            ['id_medecin' => $id_medecin_target]
        );
        $traite_count_medecin_from_after = $this->tester->grabNumRecords(
            'traite',
            ['id_medecin' => $id_medecin_from]
        );
        $traite_count_medecin_target_after = $this->tester->grabNumRecords(
            'traite',
            ['id_medecin' => $id_medecin_target]
        );

        // données à supprimer
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $pratique_a_count_after = $this->tester->grabNumRecords('coordonnees');
        $siege_count_after = $this->tester->grabNumRecords('coordonnees');
        $medecins_count_after = $this->tester->grabNumRecords('coordonnees');

        // données à update
        // suit
        $this->assertEquals(
            $suit_count_medecin_from_before + $suit_count_medecin_target_before,
            $suit_count_medecin_target_after
        );
        $this->assertEquals(0, $suit_count_medecin_from_after);
        // prescrit
        $this->assertEquals(
            $prescrit_count_medecin_from_before + $prescrit_count_medecin_target_before,
            $prescrit_count_medecin_target_after
        );
        $this->assertEquals(0, $prescrit_count_medecin_from_after);
        // traite
        $this->assertEquals(
            $traite_count_medecin_from_before + $traite_count_medecin_target_before,
            $traite_count_medecin_target_after
        );
        $this->assertEquals(0, $traite_count_medecin_from_after);

        // données à supprimer
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after + 1);
        $this->assertEquals($pratique_a_count_before, $pratique_a_count_after + 1);
        $this->assertEquals($siege_count_before, $siege_count_after + 1);
        $this->assertEquals($medecins_count_before, $medecins_count_after + 1);
    }

    public function testFuseNotOkId_medecin_fromNull()
    {
        $id_medecin_from = null;
        $id_medecin_target = "1";

        $fuse_ok = $this->medecin->fuse($id_medecin_from, $id_medecin_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFuseNotOkId_medecin_targetNull()
    {
        $id_medecin_from = "1";
        $id_medecin_target = null;

        $fuse_ok = $this->medecin->fuse($id_medecin_from, $id_medecin_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFuseNotOkId_medecin_targetNullAndId_medecin_fromNull()
    {
        $id_medecin_from = null;
        $id_medecin_target = null;

        $fuse_ok = $this->medecin->fuse($id_medecin_from, $id_medecin_target);
        $this->assertFalse($fuse_ok);
    }

    public function testReadAllMedecinsPrescripteurForExportOkAdmin()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
            'id_structure' => null,
            'id_user' => '1', // un user quelconque
        ];

        $medecins = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertIsArray($medecins);

        // 1 seul patient avec med prescripteur dans id_territoire=1
        $this->assertCount(1, $medecins);

        foreach ($medecins as $medecin) {
            $this->assertArrayHasKey('nb_prescription', $medecin);
            $this->assertArrayHasKey('nom', $medecin);
            $this->assertArrayHasKey('prenom', $medecin);
            $this->assertArrayHasKey('tel_fixe', $medecin);
            $this->assertArrayHasKey('tel_portable', $medecin);
            $this->assertArrayHasKey('email', $medecin);
            $this->assertArrayHasKey('poste_medecin', $medecin);
            $this->assertArrayHasKey('nom_specialite_medecin', $medecin);
            $this->assertArrayHasKey('nom_adresse', $medecin);
            $this->assertArrayHasKey('complement_adresse', $medecin);
            $this->assertArrayHasKey('code_postal', $medecin);
            $this->assertArrayHasKey('nom_ville', $medecin);
        }
    }

    public function testReadAllMedecinsPrescripteurForExportOKCoordoPeps()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $medecins = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertIsArray($medecins);

        // 1 seul patient avec med prescripteur dans id_territoire=1
        $this->assertCount(1, $medecins);

        foreach ($medecins as $medecin) {
            $this->assertArrayHasKey('nb_prescription', $medecin);
            $this->assertArrayHasKey('nom', $medecin);
            $this->assertArrayHasKey('prenom', $medecin);
            $this->assertArrayHasKey('tel_fixe', $medecin);
            $this->assertArrayHasKey('tel_portable', $medecin);
            $this->assertArrayHasKey('email', $medecin);
            $this->assertArrayHasKey('poste_medecin', $medecin);
            $this->assertArrayHasKey('nom_specialite_medecin', $medecin);
            $this->assertArrayHasKey('nom_adresse', $medecin);
            $this->assertArrayHasKey('complement_adresse', $medecin);
            $this->assertArrayHasKey('code_postal', $medecin);
            $this->assertArrayHasKey('nom_ville', $medecin);
        }
    }

    public function testReadAllMedecinsPrescripteurForExportOKCoordoMss()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => '1',
            'id_structure' => '2',
            'id_user' => '26',
        ];

        $medecins = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertIsArray($medecins);
        // 1 seul patient avec med prescripteur dans id_structure=2
        $this->assertCount(1, $medecins);

        foreach ($medecins as $medecin) {
            $this->assertArrayHasKey('nb_prescription', $medecin);
            $this->assertArrayHasKey('nom', $medecin);
            $this->assertArrayHasKey('prenom', $medecin);
            $this->assertArrayHasKey('tel_fixe', $medecin);
            $this->assertArrayHasKey('tel_portable', $medecin);
            $this->assertArrayHasKey('email', $medecin);
            $this->assertArrayHasKey('poste_medecin', $medecin);
            $this->assertArrayHasKey('nom_specialite_medecin', $medecin);
            $this->assertArrayHasKey('nom_adresse', $medecin);
            $this->assertArrayHasKey('complement_adresse', $medecin);
            $this->assertArrayHasKey('code_postal', $medecin);
            $this->assertArrayHasKey('nom_ville', $medecin);
        }
    }

    public function testReadAllMedecinsPrescripteurForExportOKCoordoNonMss()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2", // non MSS
            'id_territoire' => '1',
            'id_structure' => '2',
            'id_user' => '16',
        ];

        $medecins = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertIsArray($medecins);
        // 1 seul patient avec med prescripteur dans id_structure=2
        $this->assertCount(1, $medecins);

        foreach ($medecins as $medecin) {
            $this->assertArrayHasKey('nb_prescription', $medecin);
            $this->assertArrayHasKey('nom', $medecin);
            $this->assertArrayHasKey('prenom', $medecin);
            $this->assertArrayHasKey('tel_fixe', $medecin);
            $this->assertArrayHasKey('tel_portable', $medecin);
            $this->assertArrayHasKey('email', $medecin);
            $this->assertArrayHasKey('poste_medecin', $medecin);
            $this->assertArrayHasKey('nom_specialite_medecin', $medecin);
            $this->assertArrayHasKey('nom_adresse', $medecin);
            $this->assertArrayHasKey('complement_adresse', $medecin);
            $this->assertArrayHasKey('code_postal', $medecin);
            $this->assertArrayHasKey('nom_ville', $medecin);
        }
    }

    public function testReadAllMedecinsPrescripteurForExportOKEvaluateur()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '7', // un évaluateur
        ];

        $medecins = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertIsArray($medecins);
        // 0 patient avec med prescripteur (l'éval à 1 patient)
        $this->assertCount(0, $medecins);

        //===========================
        // ajout d'un med prescripteur au patient
        // obligatoire
        $id_patient = "7"; // le patient de l'évaluateur
        $regime_assurance_maladie = "1";
        $code_postal_assurance_maladie = "86100";
        $ville_assurance_maladie = "CHATELLERAULT";

        // optionnel
        $id_med_traitant = "2";
        $id_med_prescripteur = "1";
        $autre_prof_sante = ["3"];
        $id_mutuelle = "1";

        $patient = new Patient($this->pdo);
        $update_ok = $patient->updateSuiviMedical([
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

        //===========================
        $medecins = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertIsArray($medecins);
        // 1 patient avec med prescripteur (l'éval à 1 patient)
        $this->assertCount(1, $medecins);

        foreach ($medecins as $medecin) {
            $this->assertArrayHasKey('nb_prescription', $medecin);
            $this->assertArrayHasKey('nom', $medecin);
            $this->assertArrayHasKey('prenom', $medecin);
            $this->assertArrayHasKey('tel_fixe', $medecin);
            $this->assertArrayHasKey('tel_portable', $medecin);
            $this->assertArrayHasKey('email', $medecin);
            $this->assertArrayHasKey('poste_medecin', $medecin);
            $this->assertArrayHasKey('nom_specialite_medecin', $medecin);
            $this->assertArrayHasKey('nom_adresse', $medecin);
            $this->assertArrayHasKey('complement_adresse', $medecin);
            $this->assertArrayHasKey('code_postal', $medecin);
            $this->assertArrayHasKey('nom_ville', $medecin);
        }
    }

    public function testReadAllMedecinsPrescripteurForExportOKCoordoMssEmptyResult()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '26',
        ];

        $medecins = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertIsArray($medecins);
        // 0 patient avec med prescripteur dans id_structure=1
        $this->assertCount(0, $medecins);

        foreach ($medecins as $medecin) {
            $this->assertArrayHasKey('nb_prescription', $medecin);
            $this->assertArrayHasKey('nom', $medecin);
            $this->assertArrayHasKey('prenom', $medecin);
            $this->assertArrayHasKey('tel_fixe', $medecin);
            $this->assertArrayHasKey('tel_portable', $medecin);
            $this->assertArrayHasKey('email', $medecin);
            $this->assertArrayHasKey('poste_medecin', $medecin);
            $this->assertArrayHasKey('nom_specialite_medecin', $medecin);
            $this->assertArrayHasKey('nom_adresse', $medecin);
            $this->assertArrayHasKey('complement_adresse', $medecin);
            $this->assertArrayHasKey('code_postal', $medecin);
            $this->assertArrayHasKey('nom_ville', $medecin);
        }
    }

    public function testReadAllMedecinsPrescripteurForExportNotOKAutreRoles()
    {
        // intervenant
        $session = [
            'role_user_ids' => ['3'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1",
            'id_territoire' => '1',
            'id_structure' => "1",
            'id_user' => '1', // un user quelconque
        ];

        $result = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertFalse($result);

        // responsable
        $session = [
            'role_user_ids' => ['6'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $result = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertFalse($result);

        // référent
        $session = [
            'role_user_ids' => ['4'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $result = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertFalse($result);

        // secrétaire
        $session = [
            'role_user_ids' => ['8'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $result = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertFalse($result);

        // superviseur
        $session = [
            'role_user_ids' => ['7'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $result = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertFalse($result);
    }

    public function testReadAllMedecinsPrescripteurForExportNotOkEmptySession()
    {
        $session = [];
        $medecins = $this->medecin->readAllMedecinsPrescripteurForExport($session);
        $this->assertFalse($medecins);
    }

    public function testReadAllMedecinsOk()
    {
        $medecins = $this->medecin->readAll();

        $expected_count = $this->tester->grabNumRecords('medecins');

        $this->assertCount($expected_count, $medecins);

        $first_medecin = $medecins[0];
        $this->assertIsArray($first_medecin);

        $this->assertArrayHasKey('nom_coordonnees', $first_medecin);
        $this->assertArrayHasKey('prenom_coordonnees', $first_medecin);
        $this->assertArrayHasKey('id_terr', $first_medecin);
        $this->assertArrayHasKey('tel_fixe_coordonnees', $first_medecin);
        $this->assertArrayHasKey('tel_portable_coordonnees', $first_medecin);
        $this->assertArrayHasKey('mail_coordonnees', $first_medecin);
        $this->assertArrayHasKey('id_medecin', $first_medecin);
        $this->assertArrayHasKey('poste_medecin', $first_medecin);
        $this->assertArrayHasKey('id_lieu_pratique', $first_medecin);
        $this->assertArrayHasKey('id_specialite_medecin', $first_medecin);
        $this->assertArrayHasKey('nom_specialite_medecin', $first_medecin);
        $this->assertArrayHasKey('nom_lieu_pratique', $first_medecin);
        $this->assertArrayHasKey('complement_adresse', $first_medecin);
        $this->assertArrayHasKey('nom_adresse', $first_medecin);
        $this->assertArrayHasKey('code_postal', $first_medecin);
        $this->assertArrayHasKey('nom_ville', $first_medecin);
    }

    function testReadOneOk()
    {
        $id_medecin = "1";
        $medecin = $this->medecin->readOne($id_medecin);
        $this->assertIsArray($medecin);

        $this->assertArrayHasKey('nom_coordonnees', $medecin);
        $this->assertArrayHasKey('prenom_coordonnees', $medecin);
        $this->assertArrayHasKey('id_territoire', $medecin);
        $this->assertArrayHasKey('tel_fixe_coordonnees', $medecin);
        $this->assertArrayHasKey('tel_portable_coordonnees', $medecin);
        $this->assertArrayHasKey('mail_coordonnees', $medecin);
        $this->assertArrayHasKey('id_medecin', $medecin);
        $this->assertArrayHasKey('poste_medecin', $medecin);
        $this->assertArrayHasKey('id_lieu_pratique', $medecin);
        $this->assertArrayHasKey('id_specialite_medecin', $medecin);
        $this->assertArrayHasKey('nom_specialite_medecin', $medecin);
        $this->assertArrayHasKey('nom_lieu_pratique', $medecin);
        $this->assertArrayHasKey('complement_adresse', $medecin);
        $this->assertArrayHasKey('nom_adresse', $medecin);
        $this->assertArrayHasKey('code_postal', $medecin);
        $this->assertArrayHasKey('nom_ville', $medecin);
    }

    function testReadOneNotOkId_medecinNull()
    {
        $id_medecin = null;
        $medecin = $this->medecin->readOne($id_medecin);
        $this->assertFalse($medecin);
    }

    function testReadOneNotOkId_medecinInvalid()
    {
        $id_medecin = "-1";
        $medecin = $this->medecin->readOne($id_medecin);
        $this->assertFalse($medecin);
    }

    function testReadMedecinPrescripteurPatientOk()
    {
        $id_patient = "4";
        $medecin = $this->medecin->readMedecinPrescripteurPatient($id_patient);
        $this->assertIsArray($medecin);

        $this->assertArrayHasKey('nom_coordonnees', $medecin);
        $this->assertArrayHasKey('prenom_coordonnees', $medecin);
        $this->assertArrayHasKey('id_territoire', $medecin);
        $this->assertArrayHasKey('tel_fixe_coordonnees', $medecin);
        $this->assertArrayHasKey('tel_portable_coordonnees', $medecin);
        $this->assertArrayHasKey('mail_coordonnees', $medecin);
        $this->assertArrayHasKey('id_medecin', $medecin);
        $this->assertArrayHasKey('poste_medecin', $medecin);
        $this->assertArrayHasKey('id_lieu_pratique', $medecin);
        $this->assertArrayHasKey('id_specialite_medecin', $medecin);
        $this->assertArrayHasKey('nom_specialite_medecin', $medecin);
        $this->assertArrayHasKey('nom_lieu_pratique', $medecin);
        $this->assertArrayHasKey('complement_adresse', $medecin);
        $this->assertArrayHasKey('nom_adresse', $medecin);
        $this->assertArrayHasKey('code_postal', $medecin);
        $this->assertArrayHasKey('nom_ville', $medecin);
    }

    function testReadMedecinPrescripteurPatientNotOkNoMedecinPrescripteur()
    {
        $id_patient = "1";
        $medecin = $this->medecin->readMedecinPrescripteurPatient($id_patient);
        $this->assertFalse($medecin);
    }

    function testReadMedecinPrescripteurPatientNotOkId_patientNull()
    {
        $id_patient = null;
        $medecin = $this->medecin->readMedecinPrescripteurPatient($id_patient);
        $this->assertFalse($medecin);
    }

    function testReadMedecinTraitantPatientOk()
    {
        $id_patient = "4";
        $medecin = $this->medecin->readMedecinTraitantPatient($id_patient);
        $this->assertIsArray($medecin);

        $this->assertArrayHasKey('nom_coordonnees', $medecin);
        $this->assertArrayHasKey('prenom_coordonnees', $medecin);
        $this->assertArrayHasKey('id_territoire', $medecin);
        $this->assertArrayHasKey('tel_fixe_coordonnees', $medecin);
        $this->assertArrayHasKey('tel_portable_coordonnees', $medecin);
        $this->assertArrayHasKey('mail_coordonnees', $medecin);
        $this->assertArrayHasKey('id_medecin', $medecin);
        $this->assertArrayHasKey('poste_medecin', $medecin);
        $this->assertArrayHasKey('id_lieu_pratique', $medecin);
        $this->assertArrayHasKey('id_specialite_medecin', $medecin);
        $this->assertArrayHasKey('nom_specialite_medecin', $medecin);
        $this->assertArrayHasKey('nom_lieu_pratique', $medecin);
        $this->assertArrayHasKey('complement_adresse', $medecin);
        $this->assertArrayHasKey('nom_adresse', $medecin);
        $this->assertArrayHasKey('code_postal', $medecin);
        $this->assertArrayHasKey('nom_ville', $medecin);
    }

    function testReadMedecinTraitantPatientNotOkNoMedecinTraitant()
    {
        $id_patient = "1";
        $medecin = $this->medecin->readMedecinTraitantPatient($id_patient);
        $this->assertFalse($medecin);
    }

    function testReadMedecinTraitantPatientNotOkId_patientNull()
    {
        $id_patient = null;
        $medecin = $this->medecin->readMedecinTraitantPatient($id_patient);
        $this->assertFalse($medecin);
    }

    function testReadAutresProfessionnelsSantePatientOk()
    {
        $id_patient = "1";
        $medecins = $this->medecin->readAutresProfessionnelsSantePatient($id_patient);
        $this->assertIsArray($medecins);
        $this->assertGreaterThan(0, count($medecins));
        $suit_count = $this->tester->grabNumRecords('suit', ['id_patient' => $id_patient]);
        $this->assertCount($suit_count, $medecins);

        foreach ($medecins as $medecin) {
            $this->assertArrayHasKey('nom_coordonnees', $medecin);
            $this->assertArrayHasKey('prenom_coordonnees', $medecin);
            $this->assertArrayHasKey('id_territoire', $medecin);
            $this->assertArrayHasKey('tel_fixe_coordonnees', $medecin);
            $this->assertArrayHasKey('tel_portable_coordonnees', $medecin);
            $this->assertArrayHasKey('mail_coordonnees', $medecin);
            $this->assertArrayHasKey('id_medecin', $medecin);
            $this->assertArrayHasKey('poste_medecin', $medecin);
            $this->assertArrayHasKey('id_lieu_pratique', $medecin);
            $this->assertArrayHasKey('id_specialite_medecin', $medecin);
            $this->assertArrayHasKey('nom_specialite_medecin', $medecin);
            $this->assertArrayHasKey('nom_lieu_pratique', $medecin);
            $this->assertArrayHasKey('complement_adresse', $medecin);
            $this->assertArrayHasKey('nom_adresse', $medecin);
            $this->assertArrayHasKey('code_postal', $medecin);
            $this->assertArrayHasKey('nom_ville', $medecin);
        }
    }

    function testReadAutresProfessionnelsSantePatientOkNoAutresprofessionnelsSante()
    {
        $id_patient = "2";
        $medecins = $this->medecin->readAutresProfessionnelsSantePatient($id_patient);
        $this->assertIsArray($medecins);
        $this->assertEmpty($medecins);
    }

    function testReadAutresProfessionnelsSantePatientNotOkId_patientNull()
    {
        $id_patient = null;
        $medecin = $this->medecin->readAutresProfessionnelsSantePatient($id_patient);
        $this->assertFalse($medecin);
    }

    function testCreateOkMinimumData()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("dfgjhdfjgfdj");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("wxvcbxbhsdfhg");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("moiliuoliol");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_territoire = "1";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $medecins_count_before = $this->tester->grabNumRecords('medecins');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertNotFalse($id_medecin);

        $medecins_count_after = $this->tester->grabNumRecords('medecins');

        $this->assertEquals($medecins_count_before + 1, $medecins_count_after);

        $this->tester->seeInDatabase('medecins', [
            'id_medecin' => $id_medecin,
            'poste_medecin' => $poste_medecin,
            'id_territoire' => $id_territoire,
            'id_specialite_medecin' => $id_specialite_medecin,
        ]);

        $id_coordonnees = $this->tester->grabFromDatabase('medecins', 'id_coordonnees', ['id_medecin' => $id_medecin]);

        $this->tester->seeInDatabase('coordonnees', [
            'id_medecin' => $id_medecin,
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom_coordonnees,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);

        $this->tester->seeInDatabase('pratique_a', [
            'id_medecin' => $id_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
        ]);

        $this->tester->seeInDatabase('siege', [
            'id_medecin' => $id_medecin
        ]);

        $id_adresse = $this->tester->grabFromDatabase('siege', 'id_adresse', ['id_medecin' => $id_medecin]);

        $this->tester->seeInDatabase('siege', [
            'id_adresse' => $id_adresse,
            'id_medecin' => $id_medecin
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);
    }

    function testCreateOkAllData()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_territoire = "1";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $complement_adresse = ChaineCharactere::str_shuffle_unicode("poiuppyuiop");
        $mail_coordonnees = ChaineCharactere::str_shuffle_unicode("mplkkjhgnvbxwaqwszxcdevfrb") . '@gmail.com';
        $tel_portable_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $medecins_count_before = $this->tester->grabNumRecords('medecins');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,

            'complement_adresse' => $complement_adresse,
            'mail_coordonnees' => $mail_coordonnees,
            'tel_portable_coordonnees' => $tel_portable_coordonnees,
        ]);
        $this->assertNotFalse($id_medecin);

        $medecins_count_after = $this->tester->grabNumRecords('medecins');

        $this->assertEquals($medecins_count_before + 1, $medecins_count_after);

        $this->tester->seeInDatabase('medecins', [
            'id_medecin' => $id_medecin,
            'poste_medecin' => $poste_medecin,
            'id_territoire' => $id_territoire,
            'id_specialite_medecin' => $id_specialite_medecin,
        ]);

        $id_coordonnees = $this->tester->grabFromDatabase('medecins', 'id_coordonnees', ['id_medecin' => $id_medecin]);

        $this->tester->seeInDatabase('coordonnees', [
            'id_medecin' => $id_medecin,
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom_coordonnees,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
            'tel_portable_coordonnees' => $tel_portable_coordonnees,
            'mail_coordonnees' => $mail_coordonnees,
        ]);

        $this->tester->seeInDatabase('pratique_a', [
            'id_medecin' => $id_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
        ]);

        $this->tester->seeInDatabase('siege', [
            'id_medecin' => $id_medecin
        ]);

        $id_adresse = $this->tester->grabFromDatabase('siege', 'id_adresse', ['id_medecin' => $id_medecin]);

        $this->tester->seeInDatabase('siege', [
            'id_adresse' => $id_adresse,
            'id_medecin' => $id_medecin
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);
    }

    function testCreateNotOkNom_coordonneesNull()
    {
        $nom_coordonnees = null;
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("dfgjhdfjgfdj");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("wxvcbxbhsdfhg");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("moiliuoliol");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_territoire = "1";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($id_medecin);
    }

    function testCreateNotOkPrenom_coordonneesNull()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $prenom_coordonnees = null;
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("wxvcbxbhsdfhg");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("moiliuoliol");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_territoire = "1";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($id_medecin);
    }

    function testCreateNotOkPoste_medecinNull()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("dfgjhdfjgfdj");
        $poste_medecin = null;
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("moiliuoliol");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_territoire = "1";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($id_medecin);
    }

    function testCreateNotOkId_specialite_medecinNull()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("dfgjhdfjgfdj");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("wxvcbxbhsdfhg");
        $id_specialite_medecin = null;
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("moiliuoliol");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_territoire = "1";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($id_medecin);
    }

    function testCreateNotOkId_lieu_pratiqueNull()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("dfgjhdfjgfdj");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("wxvcbxbhsdfhg");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = null;
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("moiliuoliol");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_territoire = "1";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($id_medecin);
    }

    function testCreateNotOkNom_adresseNull()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("dfgjhdfjgfdj");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("wxvcbxbhsdfhg");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = null;
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_territoire = "1";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($id_medecin);
    }

    function testCreateNotOkCode_postalNull()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("dfgjhdfjgfdj");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("wxvcbxbhsdfhg");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("moiliuoliol");
        $code_postal = null;
        $nom_ville = "POITIERS";
        $id_territoire = "1";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($id_medecin);
    }

    function testCreateNotOkNom_villeNull()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("dfgjhdfjgfdj");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("wxvcbxbhsdfhg");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("moiliuoliol");
        $code_postal = "86000";
        $nom_ville = null;
        $id_territoire = "1";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($id_medecin);
    }

    function testCreateNotOkId_territoireNull()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("dfgjhdfjgfdj");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("wxvcbxbhsdfhg");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("moiliuoliol");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_territoire = null;
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($id_medecin);
    }

    function testCreateNotOkTel_fixe_coordonneesNull()
    {
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("dfgjhdfjgfdj");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("wxvcbxbhsdfhg");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("moiliuoliol");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_territoire = "1";
        $tel_fixe_coordonnees = null;

        $id_medecin = $this->medecin->create([
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($id_medecin);
    }

    function testUpdateOkMinimumData()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('medecins', [
            'id_medecin' => $id_medecin,
            'poste_medecin' => $poste_medecin,
            'id_territoire' => $id_territoire,
            'id_specialite_medecin' => $id_specialite_medecin,
        ]);

        $id_coordonnees = $this->tester->grabFromDatabase('medecins', 'id_coordonnees', ['id_medecin' => $id_medecin]);

        $this->tester->seeInDatabase('coordonnees', [
            'id_medecin' => $id_medecin,
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom_coordonnees,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);

        $this->tester->seeInDatabase('pratique_a', [
            'id_medecin' => $id_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
        ]);

        $this->tester->seeInDatabase('siege', [
            'id_medecin' => $id_medecin
        ]);

        $id_adresse = $this->tester->grabFromDatabase('siege', 'id_adresse', ['id_medecin' => $id_medecin]);

        $this->tester->seeInDatabase('siege', [
            'id_adresse' => $id_adresse,
            'id_medecin' => $id_medecin
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);
    }

    function testUpdateOkAllData()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $complement_adresse = ChaineCharactere::str_shuffle_unicode("poiuppyuiop");
        $mail_coordonnees = ChaineCharactere::str_shuffle_unicode("mplkkjhgnvbxwaqwszxcdevfrb") . '@gmail.com';
        $tel_portable_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,

            'complement_adresse' => $complement_adresse,
            'mail_coordonnees' => $mail_coordonnees,
            'tel_portable_coordonnees' => $tel_portable_coordonnees,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('medecins', [
            'id_medecin' => $id_medecin,
            'poste_medecin' => $poste_medecin,
            'id_territoire' => $id_territoire,
            'id_specialite_medecin' => $id_specialite_medecin,
        ]);

        $id_coordonnees = $this->tester->grabFromDatabase('medecins', 'id_coordonnees', ['id_medecin' => $id_medecin]);

        $this->tester->seeInDatabase('coordonnees', [
            'id_medecin' => $id_medecin,
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom_coordonnees,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
            'tel_portable_coordonnees' => $tel_portable_coordonnees,
            'mail_coordonnees' => $mail_coordonnees,
        ]);

        $this->tester->seeInDatabase('pratique_a', [
            'id_medecin' => $id_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
        ]);

        $this->tester->seeInDatabase('siege', [
            'id_medecin' => $id_medecin
        ]);

        $id_adresse = $this->tester->grabFromDatabase('siege', 'id_adresse', ['id_medecin' => $id_medecin]);

        $this->tester->seeInDatabase('siege', [
            'id_adresse' => $id_adresse,
            'id_medecin' => $id_medecin
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);
    }

    function testUpdateNotOkId_medecinNull()
    {
        $id_medecin = null;
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testUpdateNotOkNom_coordonneesNull()
    {
        $id_medecin = "1";
        $nom_coordonnees = null;
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testUpdateNotOkPrenom_coordonneesNull()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = null;
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testUpdateNotOkPoste_medecinNull()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = null;
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testUpdateNotOkId_specialite_medecinNull()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = null;
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testUpdateNotOkId_lieu_pratiqueNull()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = null;
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testUpdateNotOkNom_adresseNull()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = null;
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testUpdateNotOkCode_postalNull()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = null;
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testUpdateNotOkNom_villeNull()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = null;
        $id_territoire = "2";
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testUpdateNotOkId_territoireNull()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = null;
        $tel_fixe_coordonnees = ChaineCharactere::str_shuffle_unicode('0123456789');

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testUpdateNotOkTel_fixe_coordonneesNull()
    {
        $id_medecin = "1";
        $nom_coordonnees = ChaineCharactere::str_shuffle_unicode("dgdfgopimiomp");
        $prenom_coordonnees = ChaineCharactere::str_shuffle_unicode("ncvcgdfsdfg");
        $poste_medecin = ChaineCharactere::str_shuffle_unicode("mompjkhgfh");
        $id_specialite_medecin = "2";
        $id_lieu_pratique = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj");
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $id_territoire = "2";
        $tel_fixe_coordonnees = null;

        $update_ok = $this->medecin->update([
            'id_medecin' => $id_medecin,
            'nom_coordonnees' => $nom_coordonnees,
            'prenom_coordonnees' => $prenom_coordonnees,
            'poste_medecin' => $poste_medecin,
            'id_specialite_medecin' => $id_specialite_medecin,
            'id_lieu_pratique' => $id_lieu_pratique,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_territoire' => $id_territoire,
            'tel_fixe_coordonnees' => $tel_fixe_coordonnees,
        ]);
        $this->assertFalse($update_ok);
    }

    function testDeleteOk()
    {
        $id_medecin = "4"; // médecin rattaché a aucun patient

        $id_adresse = $this->tester->grabFromDatabase('siege', 'id_adresse', ['id_medecin' => $id_medecin]);
        $id_coordonnees = $this->tester->grabFromDatabase('medecins', 'id_coordonnees', ['id_medecin' => $id_medecin]);

        $delete_ok = $this->medecin->delete($id_medecin);
        $this->assertTrue($delete_ok);

        $this->tester->dontSeeInDatabase('medecins', [
            'id_medecin' => $id_medecin,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_medecin' => $id_medecin,
        ]);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnees,
        ]);

        $this->tester->dontSeeInDatabase('pratique_a', [
            'id_medecin' => $id_medecin,
        ]);

        $this->tester->dontSeeInDatabase('siege', [
            'id_medecin' => $id_medecin
        ]);

        $this->tester->dontSeeInDatabase('siege', [
            'id_medecin' => $id_medecin
        ]);

        $this->tester->dontSeeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->dontSeeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);
    }

    function testDeleteNotOkMedecinPrescrit()
    {
        $id_medecin = "1";

        $delete_ok = $this->medecin->delete($id_medecin);
        $this->assertFalse($delete_ok);
    }

    function testDeleteNotOkMedecinTraite()
    {
        $id_medecin = "2";

        $delete_ok = $this->medecin->delete($id_medecin);
        $this->assertFalse($delete_ok);
    }

    function testDeleteNotOkMedecinSuit()
    {
        $id_medecin = "3";

        $delete_ok = $this->medecin->delete($id_medecin);
        $this->assertFalse($delete_ok);
    }
}