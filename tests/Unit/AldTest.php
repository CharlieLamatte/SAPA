<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\Ald;
use Tests\Support\UnitTester;

class AldTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Ald $ald;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->ald = new Ald($pdo);
        $this->assertNotNull($this->ald);
    }

    protected function _after()
    {
    }

    public function testUpdateOk1()
    {
        $id_patient = "6";
        $liste_alds = ["1", "5", "77"];

        $souffre_de_count_before = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals(0, $souffre_de_count_before);

        $update_ok = $this->ald->update([
            'id_patient' => $id_patient,
            'liste_alds' => $liste_alds
        ]);
        $this->assertTrue($update_ok);

        $souffre_de_count_after = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals(count($liste_alds), $souffre_de_count_after);

        foreach ($liste_alds as $id_pathologie_ou_etat) {
            $this->tester->seeInDatabase('souffre_de', array(
                'id_patient' => $id_patient,
                'id_pathologie_ou_etat' => $id_pathologie_ou_etat,
            ));
        }
    }

    public function testUpdateOk2()
    {
        // update 1
        $id_patient = "6";
        $liste_alds = ["1", "5", "77"];
        $liste_alds_count_update1 = count($liste_alds);

        $souffre_de_count_before = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals(0, $souffre_de_count_before);

        $update_ok = $this->ald->update([
            'id_patient' => $id_patient,
            'liste_alds' => $liste_alds,
        ]);
        $this->assertTrue($update_ok);

        $souffre_de_count_after = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals($liste_alds_count_update1, $souffre_de_count_after);

        foreach ($liste_alds as $id_pathologie_ou_etat) {
            $this->tester->seeInDatabase('souffre_de', array(
                'id_patient' => $id_patient,
                'id_pathologie_ou_etat' => $id_pathologie_ou_etat,
            ));
        }

        // update 2
        $id_patient = "6";
        $liste_alds = ["1", "5"];
        $liste_alds_count_update2 = count($liste_alds);

        $souffre_de_count_before = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals($liste_alds_count_update1, $souffre_de_count_before);

        $update_ok = $this->ald->update([
            'id_patient' => $id_patient,
            'liste_alds' => $liste_alds,
        ]);
        $this->assertTrue($update_ok);

        $souffre_de_count_after = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals($liste_alds_count_update2, $souffre_de_count_after);

        foreach ($liste_alds as $id_pathologie_ou_etat) {
            $this->tester->seeInDatabase('souffre_de', array(
                'id_patient' => $id_patient,
                'id_pathologie_ou_etat' => $id_pathologie_ou_etat,
            ));
        }
    }

    public function testUpdateOkEmptyListe_alds()
    {
        $id_patient = "6";
        $liste_alds = [];

        $souffre_de_count_before = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals(0, $souffre_de_count_before);

        $update_ok = $this->ald->update([
            'id_patient' => $id_patient,
            'liste_alds' => $liste_alds,
        ]);
        $this->assertTrue($update_ok);

        $souffre_de_count_after = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals(count($liste_alds), $souffre_de_count_after);
    }

    public function testUpdateOkListe_aldsContainsNspp()
    {
        $id_patient = "6";
        $liste_alds = ["-1"];
        $liste_alds_count_update1 = count($liste_alds);

        $souffre_de_count_before = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals(0, $souffre_de_count_before);

        $update_ok = $this->ald->update([
            'id_patient' => $id_patient,
            'liste_alds' => $liste_alds,
        ]);
        $this->assertTrue($update_ok);

        $souffre_de_count_after = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals($liste_alds_count_update1, $souffre_de_count_after);

        foreach ($liste_alds as $id_pathologie_ou_etat) {
            $this->tester->seeInDatabase('souffre_de', array(
                'id_patient' => $id_patient,
                'id_pathologie_ou_etat' => $id_pathologie_ou_etat,
            ));
        }
    }

    public function testUpdateNotOkId_patientNull()
    {
        $id_patient = null;
        $liste_alds = ["1", "5", "77"];

        $souffre_de_count_before = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals(0, $souffre_de_count_before);

        $update_ok = $this->ald->update([
            'id_patient' => $id_patient,
            'liste_alds' => $liste_alds,
        ]);
        $this->assertFalse($update_ok);

        $souffre_de_count_after = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals($souffre_de_count_before, $souffre_de_count_after);
    }

    public function testUpdateNotOkListe_aldsNull()
    {
        $id_patient = "6";
        $liste_alds = null;

        $souffre_de_count_before = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals(0, $souffre_de_count_before);

        $update_ok = $this->ald->update([
            'id_patient' => $id_patient,
            'liste_alds' => $liste_alds,
        ]);
        $this->assertFalse($update_ok);

        $souffre_de_count_after = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals($souffre_de_count_before, $souffre_de_count_after);
    }

    public function testReadAllOk()
    {
        $pathologie_ou_etat_count = $this->tester->grabNumRecords('pathologie_ou_etat', ['id_pathologie_ou_etat >' => 0]
        );
        $this->assertGreaterThan(0, $pathologie_ou_etat_count);

        $all_alds = $this->ald->readAll();
        $this->assertIsArray($all_alds);

        $this->assertCount($pathologie_ou_etat_count, $all_alds);
        $this->assertArrayHasKey('id_pathologie_ou_etat', $all_alds[0]);
        $this->assertArrayHasKey('id_type_pathologie', $all_alds[0]);
        $this->assertArrayHasKey('nom_pathologie_ou_etat', $all_alds[0]);
        $this->assertArrayHasKey('nom_type_pathologie', $all_alds[0]);
    }

    public function testReadAllPatientOk()
    {
        $id_patient = "1";

        $souffre_de_count = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertGreaterThan(0, $souffre_de_count);

        $alds = $this->ald->readAllPatient($id_patient);
        $this->assertIsArray($alds);

        $this->assertCount($souffre_de_count, $alds);
        $this->assertArrayHasKey('id_pathologie_ou_etat', $alds[0]);
        $this->assertArrayHasKey('id_type_pathologie', $alds[0]);
        $this->assertArrayHasKey('nom_pathologie_ou_etat', $alds[0]);
        $this->assertArrayHasKey('nom_type_pathologie', $alds[0]);
    }

    public function testReadAllPatientOkId_patientInvalid()
    {
        $id_patient = "-1";

        $souffre_de_count = $this->tester->grabNumRecords('souffre_de', ['id_patient' => $id_patient]);
        $this->assertEquals(0, $souffre_de_count);

        $alds = $this->ald->readAllPatient($id_patient);
        $this->assertIsArray($alds);

        $this->assertCount(0, $alds);
    }

    public function testReadAllPatientNotOkId_patientNull()
    {
        $id_patient = null;

        $alds = $this->ald->readAllPatient($id_patient);
        $this->assertFalse($alds);
    }

    public function testReadAllPatientAsStringOkPatientNeSePrononcePas()
    {
        $id_patient = "5";

        $alds = $this->ald->readAllPatientAsString($id_patient);
        $this->assertStringContainsString("Ne se prononce pas", $alds);
    }

    public function testReadAllPatientAsStringOk1Ald()
    {
        $id_patient = "8";

        $alds = $this->ald->readAllPatientAsString($id_patient);
        $this->assertStringContainsString("Insuffisance Cardiaque", $alds);
    }

    public function testReadAllPatientAsStringOkMoreThan1Ald()
    {
        $id_patient = "1";

        $alds = $this->ald->readAllPatientAsString($id_patient);
        $this->assertStringContainsString(", ", $alds);
    }

    public function testReadAllPatientAsStringOkNoAld()
    {
        $id_patient = "9";

        $alds = $this->ald->readAllPatientAsString($id_patient);
        $this->assertEquals("", $alds);
    }

    public function testReadAllPatientAsStringNotOkId_patientNull()
    {
        $id_patient = null;

        $alds = $this->ald->readAllPatientAsString($id_patient);
        $this->assertFalse($alds);
    }
}