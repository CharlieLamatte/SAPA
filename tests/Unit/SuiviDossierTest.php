<?php

namespace Sportsante86\Sapa\tests\Unit;

use Sportsante86\Sapa\Model\SuiviDossier;
use Tests\Support\UnitTester;

class SuiviDossierTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private $suiviDossier;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->suiviDossier = new SuiviDossier($pdo);
        $this->assertNotNull($this->suiviDossier);
    }

    protected function _after()
    {
    }

    public function testCreateOk()
    {
        $id_user = 2;
        $id_patient = 8;

        $dossiers_suivi_count_before = $this->tester->grabNumRecords('dossiers_suivi');

        $status_suivi_dossier = $this->suiviDossier->createSuiviDossier($id_user, $id_patient);
        $this->assertTrue($status_suivi_dossier);

        $dossiers_suivi_count_after = $this->tester->grabNumRecords('dossiers_suivi');
        $this->assertEquals($dossiers_suivi_count_before + 1, $dossiers_suivi_count_after);

        $this->tester->seeInDatabase('dossiers_suivi', array(
            'id_user' => $id_user,
            'id_patient' => $id_patient
        ));
    }

    public function testCreateNotOkMissingUser()
    {
        $id_user = null;
        $id_patient = 8;

        $dossiers_suivi_count_before = $this->tester->grabNumRecords('dossiers_suivi');

        $status_suivi_dossier = $this->suiviDossier->createSuiviDossier($id_user, $id_patient);
        $this->assertFalse($status_suivi_dossier);

        $dossiers_suivi_count_after = $this->tester->grabNumRecords('dossiers_suivi');
        $this->assertEquals($dossiers_suivi_count_before, $dossiers_suivi_count_after);
    }

    public function testCreateNotOkMissingPatient()
    {
        $id_user = 2;
        $id_patient = null;

        $dossiers_suivi_count_before = $this->tester->grabNumRecords('dossiers_suivi');

        $status_suivi_dossier = $this->suiviDossier->createSuiviDossier($id_user, $id_patient);
        $this->assertFalse($status_suivi_dossier);

        $dossiers_suivi_count_after = $this->tester->grabNumRecords('dossiers_suivi');
        $this->assertEquals($dossiers_suivi_count_before, $dossiers_suivi_count_after);
    }

    public function testCheckOkPatientFound()
    {
        $id_user = 2;
        $id_patient = 7;

        $id_patient_found = $this->suiviDossier->checkSuiviDossier($id_user, $id_patient);
        $this->assertTrue($id_patient_found);

        $this->tester->seeInDatabase('dossiers_suivi', array(
            'id_user' => $id_user,
            'id_patient' => $id_patient
        ));
    }

    public function testCheckOkPatientNotFound()
    {
        $id_user = 2;
        $id_patient = -1;

        $id_patient_found = $this->suiviDossier->checkSuiviDossier($id_user, $id_patient);
        $this->assertFalse($id_patient_found);

        $this->tester->dontseeInDatabase('dossiers_suivi', array(
            'id_user' => $id_user,
            'id_patient' => $id_patient
        ));
    }

    public function testCheckNotOkMissingUser()
    {
        $id_user = null;
        $id_patient = 7;

        $id_patient_found = $this->suiviDossier->checkSuiviDossier($id_user, $id_patient);
        $this->assertFalse($id_patient_found);
    }

    public function checkNotOkMissingPatient()
    {
        $id_user = 2;
        $id_patient = null;

        $id_patient_found = $this->suiviDossier->checkSuiviDossier($id_user, $id_patient);
        $this->assertFalse($id_patient_found);
    }

    public function testDeleteNotOkMissingUser()
    {
        $id_user = null;
        $id_patient = 7;

        $dossiers_suivi_count_before = $this->tester->grabNumRecords('dossiers_suivi');

        $status_delete_suivi = $this->suiviDossier->deleteSuiviDossier($id_user, $id_patient);
        $this->assertFalse($status_delete_suivi);

        $dossiers_suivi_count_after = $this->tester->grabNumRecords('dossiers_suivi');
        $this->assertEquals($dossiers_suivi_count_before, $dossiers_suivi_count_after);

        $this->tester->seeInDatabase('dossiers_suivi', array(
            'id_patient' => $id_patient
        ));
    }

    public function testDeleteNotOkMissingPatient()
    {
        $id_user = 2;
        $id_patient = null;

        $dossiers_suivi_count_before = $this->tester->grabNumRecords('dossiers_suivi');

        $status_delete_suivi = $this->suiviDossier->deleteSuiviDossier($id_user, $id_patient);
        $this->assertFalse($status_delete_suivi);

        $dossiers_suivi_count_after = $this->tester->grabNumRecords('dossiers_suivi');
        $this->assertEquals($dossiers_suivi_count_before, $dossiers_suivi_count_after);

        $this->tester->seeInDatabase('dossiers_suivi', array(
            'id_user' => $id_user,
        ));
    }

    public function testDeleteOk()
    {
        $id_user = 2;
        $id_patient = 7;

        $dossiers_suivi_count_before = $this->tester->grabNumRecords('dossiers_suivi');

        $status_delete_suivi = $this->suiviDossier->deleteSuiviDossier($id_user, $id_patient);
        $this->assertTrue($status_delete_suivi);

        $dossiers_suivi_count_after = $this->tester->grabNumRecords('dossiers_suivi');
        $this->assertEquals($dossiers_suivi_count_before - 1, $dossiers_suivi_count_after);

        $this->tester->dontSeeInDatabase('dossiers_suivi', array(
            'id_user' => $id_user,
            'id_patient' => $id_patient
        ));
    }

    public function testDeleteAllNotOkMissingPatient()
    {
        $id_patient = null;

        $dossiers_suivi_count_before = $this->tester->grabNumRecords('dossiers_suivi');

        $status_delete_suivi = $this->suiviDossier->deleteAllSuiviDossier($id_patient);
        $this->assertFalse($status_delete_suivi);

        $dossiers_suivi_count_after = $this->tester->grabNumRecords('dossiers_suivi');
        $this->assertEquals($dossiers_suivi_count_before, $dossiers_suivi_count_after);

        $this->tester->seeInDatabase('dossiers_suivi', array(
            'id_user' => 2,
            'id_patient' => 7,
        ));
        $this->tester->seeInDatabase('dossiers_suivi', array(
            'id_user' => 2,
            'id_patient' => 1,
        ));
        $this->tester->seeInDatabase('dossiers_suivi', array(
            'id_user' => 11,
            'id_patient' => 7
        ));
    }

    public function testDeleteAllOk()
    {
        $id_patient = 7;

        $dossiers_suivi_count_before = $this->tester->grabNumRecords('dossiers_suivi');

        $status_delete_suivi = $this->suiviDossier->deleteAllSuiviDossier($id_patient);
        $this->assertTrue($status_delete_suivi);

        $dossiers_suivi_count_after = $this->tester->grabNumRecords('dossiers_suivi');
        $this->assertEquals($dossiers_suivi_count_before - 2, $dossiers_suivi_count_after);

        $this->tester->dontSeeInDatabase('dossiers_suivi', array(
            'id_user' => 2,
            'id_patient' => $id_patient,
        ));
        $this->tester->dontSeeInDatabase('dossiers_suivi', array(
            'id_user' => 11,
            'id_patient' => $id_patient,
        ));
        $this->tester->seeInDatabase('dossiers_suivi', array(
            'id_user' => 2,
            'id_patient' => 1,
        ));
    }
}