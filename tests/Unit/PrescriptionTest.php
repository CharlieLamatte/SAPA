<?php

namespace Sportsante86\Sapa\tests\Unit;

use Sportsante86\Sapa\Model\Prescription;
use Tests\Support\UnitTester;

class PrescriptionTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Prescription $prescription;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->prescription = new Prescription($pdo);
        $this->assertNotNull($this->prescription);
    }

    protected function _after()
    {
    }

    public function testReadAllPatientOk()
    {
        $id_patient = "1";

        $prescriptions = $this->prescription->readAllPatient($id_patient);
        $this->assertIsArray($prescriptions);
        $this->assertNotEmpty($prescriptions);

        foreach ($prescriptions as $prescription) {
            $this->assertArrayHasKey("id_prescription", $prescription);
            $this->assertArrayHasKey("prescription_ap", $prescription);
            $this->assertArrayHasKey("prescription_medecin", $prescription);
            $this->assertArrayHasKey("prescription_date", $prescription);
            $this->assertArrayHasKey("fc_max", $prescription);
            $this->assertArrayHasKey("remarque", $prescription);
            $this->assertArrayHasKey("act_a_privilegier", $prescription);
            $this->assertArrayHasKey("intensite_recommandee", $prescription);
            $this->assertArrayHasKey("efforts_non", $prescription);
            $this->assertArrayHasKey("articulation_non", $prescription);
            $this->assertArrayHasKey("action_non", $prescription);
            $this->assertArrayHasKey("arret_si", $prescription);
        }
    }

    public function testReadAllPatientOkEmptyResult()
    {
        $id_patient = "5";

        $prescriptions = $this->prescription->readAllPatient($id_patient);
        $this->assertIsArray($prescriptions);
        $this->assertEmpty($prescriptions);
    }
}