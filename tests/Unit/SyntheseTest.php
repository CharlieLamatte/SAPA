<?php

namespace Tests\Unit;

use Dotenv\Dotenv;
use Sportsante86\Sapa\Model\Synthese;
use Tests\Support\UnitTester;

class SyntheseTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Synthese $synthese;

    private string $root = __DIR__ . '/../..';

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->synthese = new Synthese($pdo);
        $this->assertNotNull($this->synthese);

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

    public function testReadOkPatient0Evaluation()
    {
        $id_structure = "2";
        $id_patient = "7";

        $synthese = $this->synthese->read($id_patient, $id_structure);
        $this->assertIsArray($synthese);

        $this->assertArrayHasKey('id_patient', $synthese);
        $this->assertArrayHasKey('nom_patient', $synthese);
        $this->assertArrayHasKey('prenom_patient', $synthese);
        $this->assertArrayHasKey('nom_naissance', $synthese);
        $this->assertArrayHasKey('premier_prenom_naissance', $synthese);
        $this->assertArrayHasKey('nom_utilise', $synthese);
        $this->assertArrayHasKey('prenom_utilise', $synthese);
        $this->assertArrayHasKey('date_naissance', $synthese);
        $this->assertArrayHasKey('sexe_patient', $synthese);
        $this->assertArrayHasKey('nom_naissance', $synthese);
        $this->assertArrayHasKey('premier_prenom_naissance', $synthese);
        $this->assertArrayHasKey('code_insee_naissance', $synthese);
        $this->assertArrayHasKey('oid', $synthese);
        $this->assertArrayHasKey('nature_oid', $synthese);
        $this->assertArrayHasKey('matricule_ins', $synthese);
        $this->assertArrayHasKey('nom_utilise', $synthese);
        $this->assertArrayHasKey('prenom_utilise', $synthese);
        $this->assertArrayHasKey('liste_prenom_naissance', $synthese);
        $this->assertArrayHasKey('id_type_statut_identite', $synthese);

        $this->assertArrayHasKey('nom_suivi', $synthese);
        $this->assertArrayHasKey('prenom_suivi', $synthese);
        $this->assertArrayHasKey('fonction_suivi', $synthese);
        $this->assertArrayHasKey('mail_suivi', $synthese);
        $this->assertArrayHasKey('id_user_suivi', $synthese);

        $this->assertArrayHasKey('nom_coordinateur', $synthese);
        $this->assertArrayHasKey('prenom_coordinateur', $synthese);
        $this->assertArrayHasKey('fonction_coordinateur', $synthese);
        $this->assertArrayHasKey('mail_coordinateur', $synthese);
        $this->assertArrayHasKey('telephone_coordinateur', $synthese);
        $this->assertArrayHasKey('id_user_coordinateur', $synthese);

        $this->assertArrayHasKey('id_evaluation', $synthese);
        $this->assertArrayHasKey('date_eval', $synthese);
        $this->assertArrayHasKey('type_eval', $synthese);
        $this->assertArrayHasKey('nom_evaluateur', $synthese);
        $this->assertArrayHasKey('prenom_evaluateur', $synthese);
        $this->assertArrayHasKey('fonction_evaluateur', $synthese);
        $this->assertArrayHasKey('mail_evaluateur', $synthese);
        $this->assertArrayHasKey('telephone_evaluateur', $synthese);
        $this->assertArrayHasKey('id_user_evaluateur', $synthese);

        $this->assertArrayHasKey('evaluations_precedentes', $synthese);

        $this->assertArrayHasKey('objectifs', $synthese);
        $this->assertIsArray($synthese['objectifs']);
        $this->assertCount(0, $synthese['objectifs']);

        $this->assertArrayHasKey('orientation', $synthese);
        $this->assertNull($synthese['orientation']);

        $this->assertArrayHasKey('activites', $synthese);
        $this->assertIsArray($synthese['activites']);
        $this->assertCount(0, $synthese['activites']);

        $this->assertArrayHasKey('logo_fichier', $synthese);
    }

    public function testReadOkPatient1Evaluation()
    {
        $id_structure = "2";
        $id_patient = "1";

        $synthese = $this->synthese->read($id_patient, $id_structure);
        $this->assertIsArray($synthese);

        $this->assertArrayHasKey('id_patient', $synthese);
        $this->assertArrayHasKey('nom_patient', $synthese);
        $this->assertArrayHasKey('prenom_patient', $synthese);
        $this->assertArrayHasKey('nom_naissance', $synthese);
        $this->assertArrayHasKey('premier_prenom_naissance', $synthese);
        $this->assertArrayHasKey('nom_utilise', $synthese);
        $this->assertArrayHasKey('prenom_utilise', $synthese);
        $this->assertArrayHasKey('date_naissance', $synthese);
        $this->assertArrayHasKey('sexe_patient', $synthese);
        $this->assertArrayHasKey('nom_naissance', $synthese);
        $this->assertArrayHasKey('premier_prenom_naissance', $synthese);
        $this->assertArrayHasKey('code_insee_naissance', $synthese);
        $this->assertArrayHasKey('oid', $synthese);
        $this->assertArrayHasKey('nature_oid', $synthese);
        $this->assertArrayHasKey('matricule_ins', $synthese);
        $this->assertArrayHasKey('nom_utilise', $synthese);
        $this->assertArrayHasKey('prenom_utilise', $synthese);
        $this->assertArrayHasKey('liste_prenom_naissance', $synthese);
        $this->assertArrayHasKey('id_type_statut_identite', $synthese);

        $this->assertArrayHasKey('nom_suivi', $synthese);
        $this->assertArrayHasKey('prenom_suivi', $synthese);
        $this->assertArrayHasKey('fonction_suivi', $synthese);
        $this->assertArrayHasKey('mail_suivi', $synthese);
        $this->assertArrayHasKey('id_user_suivi', $synthese);

        $this->assertArrayHasKey('nom_coordinateur', $synthese);
        $this->assertArrayHasKey('prenom_coordinateur', $synthese);
        $this->assertArrayHasKey('fonction_coordinateur', $synthese);
        $this->assertArrayHasKey('mail_coordinateur', $synthese);
        $this->assertArrayHasKey('telephone_coordinateur', $synthese);
        $this->assertArrayHasKey('id_user_coordinateur', $synthese);

        $this->assertArrayHasKey('id_evaluation', $synthese);
        $this->assertArrayHasKey('date_eval', $synthese);
        $this->assertArrayHasKey('type_eval', $synthese);
        $this->assertArrayHasKey('nom_evaluateur', $synthese);
        $this->assertArrayHasKey('prenom_evaluateur', $synthese);
        $this->assertArrayHasKey('fonction_evaluateur', $synthese);
        $this->assertArrayHasKey('mail_evaluateur', $synthese);
        $this->assertArrayHasKey('telephone_evaluateur', $synthese);
        $this->assertArrayHasKey('id_user_evaluateur', $synthese);

        $this->assertArrayHasKey('evaluations_precedentes', $synthese);

        $this->assertArrayHasKey('objectifs', $synthese);
        $this->assertIsArray($synthese['objectifs']);
        $this->assertCount(1, $synthese['objectifs']);
        $this->assertArrayHasKey('id_obj_patient', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('id_patient', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('date_objectif_patient', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('nom_objectif', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('desc_objectif', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('pratique', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('termine', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('id_user', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('type_activite', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('duree', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('frequence', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('infos_complementaires', $synthese['objectifs'][0]);
        $this->assertArrayHasKey('avancement', $synthese['objectifs'][0]);

        $this->assertArrayHasKey('orientation', $synthese);
        $this->assertIsArray($synthese['orientation']);
        $this->assertArrayHasKey('id_orientation', $synthese['orientation']);
        $this->assertArrayHasKey('date_orientation', $synthese['orientation']);
        $this->assertArrayHasKey('commentaires_general', $synthese['orientation']);
        $this->assertArrayHasKey('type_parcours', $synthese['orientation']);

        $this->assertArrayHasKey('activites', $synthese);
        $this->assertIsArray($synthese['activites']);
        $this->assertCount(2, $synthese['activites']);
        $this->assertArrayHasKey('id_activite_choisie', $synthese['activites'][0]);
        $this->assertArrayHasKey('statut', $synthese['activites'][0]);
        $this->assertArrayHasKey('commentaire', $synthese['activites'][0]);
        $this->assertArrayHasKey('date_demarrage', $synthese['activites'][0]);
        $this->assertArrayHasKey('id_orientation', $synthese['activites'][0]);
        $this->assertArrayHasKey('id_creneau', $synthese['activites'][0]);
        $this->assertArrayHasKey('nom_creneau', $synthese['activites'][0]);
        $this->assertArrayHasKey('jour', $synthese['activites'][0]);
        $this->assertArrayHasKey('heure_debut', $synthese['activites'][0]);
        $this->assertArrayHasKey('heure_fin', $synthese['activites'][0]);
        $this->assertArrayHasKey('nom_structure', $synthese['activites'][0]);
        $this->assertArrayHasKey('id_structure', $synthese['activites'][0]);
        $this->assertArrayHasKey('type_parcours', $synthese['activites'][0]);

        $this->assertArrayHasKey('logo_fichier', $synthese);
    }

    public function testReadOkPatient2Evaluations()
    {
        // TODO
    }

    public function testReadNotOkId_patientNull()
    {
        $id_structure = "2";
        $id_patient = null;

        $synthese = $this->synthese->read($id_patient, $id_structure);
        $this->assertFalse($synthese);
    }

    public function testSaveOk()
    {
        $synthese = "20230615070316_1_SyntheseBeneficiaire.pdf";
        $id_patient = 1;
        $id_user = 2;

        $synthese_count_before = $this->tester->grabNumRecords('synthese');

        $id_synthese = $this->synthese->saveSynthese($synthese, $id_patient, $id_user);

        $this->assertNotFalse($id_synthese);
        $synthese_count_after = $this->tester->grabNumRecords('synthese');
        $this->assertEquals($synthese_count_before + 1, $synthese_count_after);

        $this->tester->seeInDatabase('synthese', [
            'id_synthese' => $id_synthese,
            'synthese' => $synthese,
            'id_patient' => $id_patient,
            'id_user' => $id_user
        ]);
    }

    public function testSaveNotOkMissingSynthese()
    {
        $synthese = null;
        $id_patient = 7;
        $id_user = 2;

        $id_synthese = $this->synthese->saveSynthese($synthese, $id_patient, $id_user);

        $this->assertFalse($id_synthese);
    }

    public function testSaveNotOkMissingIdPatient()
    {
        $synthese = "20230615070316_1_SyntheseBeneficiaire.pdf";
        $id_patient = null;
        $id_user = 2;

        $id_synthese = $this->synthese->saveSynthese($synthese, $id_patient, $id_user);

        $this->assertFalse($id_synthese);
    }

    public function testSaveNotOkMissingIdUser()
    {
        $synthese = "20230615070316_1_SyntheseBeneficiaire.pdf";
        $id_patient = 7;
        $id_user = null;

        $id_synthese = $this->synthese->saveSynthese($synthese, $id_patient, $id_user);

        $this->assertFalse($id_synthese);
    }

    public function testFetchOkListModeTous()
    {
        $filter_id_user = false;
        $id_patient = 1;
        $id_user = 2;
        $syntheses_expected = [
            [
                'id_synthese' => 1,
                'synthese' => '20230615051011_1_SyntheseBeneficiaire.pdf',
                'id_patient' => 1,
                'id_user' => 2,
                'date_synthese' => '2023-06-15 05:10:11'
            ],
            [
                'id_synthese' => 2,
                'synthese' => '20230615061523_1_SyntheseBeneficiaire.pdf',
                'id_patient' => 1,
                'id_user' => 7,
                'date_synthese' => '2023-06-15 06:15:23'
            ]
        ];
        $count = $this->tester->grabNumRecords('synthese');

        $syntheses = $this->synthese->fetchSyntheses($id_patient, $id_user, $filter_id_user);
        $this->assertIsArray($syntheses);
        $this->assertNotEmpty($syntheses);
        $this->assertCount($count, $syntheses);

        $this->assertEquals($syntheses, $syntheses_expected);
    }

    public function testFetchOkListModeTousWrongUser()
    {
        $filter_id_user = false;
        $id_patient = -1;
        $id_user = 2;

        $syntheses = $this->synthese->fetchSyntheses($id_patient, $id_user, $filter_id_user);
        $this->assertIsArray($syntheses);
        $this->assertEmpty($syntheses);
    }

    public function testFetchNotOkListModeTousMissingIdPatient()
    {
        $filter_id_user = false;
        $id_patient = null;
        $id_user = 2;

        $syntheses = $this->synthese->fetchSyntheses($id_patient, $id_user, $filter_id_user);
        $this->assertEmpty($syntheses);
    }

    public function testFetchOkListModeUser()
    {
        $id_user = 2;

        $filter_id_user = true;
        $id_patient = 1;
        $synthese_expected = [
            [
                'id_synthese' => 1,
                'synthese' => '20230615051011_1_SyntheseBeneficiaire.pdf',
                'id_patient' => 1,
                'id_user' => 2,
                'date_synthese' => '2023-06-15 05:10:11'
            ]
        ];
        $count = $this->tester->grabNumRecords('synthese');

        $synthese = $this->synthese->fetchSyntheses($id_patient, $id_user, $filter_id_user);
        $this->assertIsArray($synthese);
        $this->assertNotEmpty($synthese);
        $this->assertCount($count - 1, $synthese);

        $this->assertEquals($synthese, $synthese_expected);
    }

    public function testFetchOkListModeUserWrongPatient()
    {
        $id_user = 2;

        $filter_id_user = true;
        $id_patient = -1;

        $synthese = $this->synthese->fetchSyntheses($id_patient, $id_user, $filter_id_user);
        $this->assertIsArray($synthese);
        $this->assertEmpty($synthese);
    }

    public function testFetchOkListModeUserEmptyWrongUser()
    {
        $id_user = 3;

        $filter_id_user = true;
        $id_patient = 1;

        $synthese = $this->synthese->fetchSyntheses($id_patient, $id_user, $filter_id_user);
        $this->assertIsArray($synthese);
        $this->assertEmpty($synthese);
    }

    public function testFetchNotOkListModeUserMissingIdPatient()
    {
        $id_user = 2;

        $filter_id_user = true;
        $id_patient = null;

        $synthese = $this->synthese->fetchSyntheses($id_patient, $id_user, $filter_id_user);
        $this->assertFalse($synthese);
    }

    public function testDeleteNotOkMissingIdSynthese()
    {
        $id_synthese = null;

        $delete = $this->synthese->deleteSynthese($id_synthese);
        $this->assertFalse($delete);
    }

    public function testDeleteOk()
    {
        $id_synthese = 2;

        $synthese_count_before = $this->tester->grabNumRecords('synthese');

        $delete = $this->synthese->deleteSynthese($id_synthese);
        $this->assertTrue($delete);

        $synthese_count_after = $this->tester->grabNumRecords('synthese');
        $this->assertEquals($synthese_count_before, $synthese_count_after + 1);

        $this->tester->dontSeeInDatabase('synthese', [
            'id_synthese' => $id_synthese
        ]);
    }

    public function testReadOneOk()
    {
        $id_synthese = "1";

        $synthese = $this->synthese->readOne($id_synthese);
        $this->assertIsArray($synthese, $this->synthese->getErrorMessage());
        $this->assertArrayHasKey("id_synthese", $synthese);
        $this->assertArrayHasKey("synthese", $synthese);
        $this->assertArrayHasKey("id_patient", $synthese);
        $this->assertArrayHasKey("id_user", $synthese);
        $this->assertArrayHasKey("date_synthese", $synthese);

        $this->assertEquals($id_synthese, $synthese["id_synthese"]);
    }

    public function testReadOneNotOkId_syntheseNull()
    {
        $id_synthese = null;

        $synthese = $this->synthese->readOne($id_synthese);
        $this->assertFalse($synthese);
    }

    public function testReadOneNotOkId_syntheseInvalid()
    {
        $id_synthese = "-1";

        $synthese = $this->synthese->readOne($id_synthese);
        $this->assertFalse($synthese);
    }
}