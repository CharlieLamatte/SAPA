<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\StatistiquesStructure;
use Tests\Support\UnitTester;

class StatistiquesStructureTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private StatistiquesStructure $stat;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->stat = new StatistiquesStructure($pdo);
        $this->assertNotNull($this->stat);
    }

    protected function _after()
    {
    }

    public function testGetRepartitionAgeOk()
    {
        $id_structure = "1";

        $repartition = $this->stat->getRepartitionAge($id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(6, $repartition["labels"]);
        $this->assertCount(6, $repartition["values"]);
        foreach ($repartition["values"] as $val) {
            $this->assertIsInt($val);
        }
    }

    public function testGetRepartitionAgeOkNoBeneficiairesInStructure()
    {
        $id_structure = "5"; // structure partenaire sans patients

        $repartition = $this->stat->getRepartitionAge($id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(6, $repartition["labels"]);
        $this->assertCount(6, $repartition["values"]);
        foreach ($repartition["values"] as $val) {
            $this->assertEquals(0, $val);
        }
    }

    public function testGetRepartitionAgeOkStructureDoesntExist()
    {
        $id_structure = "-1";

        $repartition = $this->stat->getRepartitionAge($id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(6, $repartition["labels"]);
        $this->assertCount(6, $repartition["values"]);
        foreach ($repartition["values"] as $val) {
            $this->assertEquals(0, $val);
        }
    }

    public function testGetRepartitionAgeOkId_structureNull()
    {
        $id_structure = null;

        $repartition = $this->stat->getRepartitionAge($id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(6, $repartition["labels"]);
        $this->assertCount(6, $repartition["values"]);
        foreach ($repartition["values"] as $val) {
            $this->assertEquals(0, $val);
        }
    }

    public function testGetRepartitionRoleOk()
    {
        $id_structure = "1";

        $repartition = $this->stat->getRepartitionRole($id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(3, $repartition["labels"]);
        $this->assertCount(3, $repartition["values"]);
        foreach ($repartition["values"] as $val) {
            $this->assertIsInt($val);
        }
        $this->assertEquals(5, $repartition["values"][0]); // nombre intervenants
        $this->assertEquals(1, $repartition["values"][1]); // nombre evaluateur
        $this->assertEquals(2, $repartition["values"][2]); // nombre responsable structure
    }

    public function testGetRepartitionRoleOkStructureDoesntExist()
    {
        $id_structure = "-1";

        $repartition = $this->stat->getRepartitionRole($id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(3, $repartition["labels"]);
        $this->assertCount(3, $repartition["values"]);
        foreach ($repartition["values"] as $val) {
            $this->assertEquals(0, $val);
        }
    }

    public function testGetRepartitionRoleOkId_structureNull()
    {
        $id_structure = null;

        $repartition = $this->stat->getRepartitionRole($id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(3, $repartition["labels"]);
        $this->assertCount(3, $repartition["values"]);
        foreach ($repartition["values"] as $val) {
            $this->assertEquals(0, $val);
        }
    }

    public function testGetRepartitionStatusBeneficiaireOk()
    {
        $id_structure = "1";

        $repartition = $this->stat->getRepartitionStatusBeneficiaire($id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(2, $repartition["labels"]);
        $this->assertCount(2, $repartition["values"]);

        $this->assertEquals(7, $repartition["values"][0]); // nombre patients actifs
        $this->assertEquals(1, $repartition["values"][1]); // nombre patients non actifs
    }

    public function testGetRepartitionStatusBeneficiaireOkStructureDoesntExist()
    {
        $id_structure = "-1";

        $repartition = $this->stat->getRepartitionStatusBeneficiaire($id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(2, $repartition["labels"]);
        $this->assertCount(2, $repartition["values"]);
        foreach ($repartition["values"] as $val) {
            $this->assertEquals(0, $val);
        }
    }

    public function testGetRepartitionStatusBeneficiaireOkId_structureNull()
    {
        $id_structure = null;

        $repartition = $this->stat->getRepartitionStatusBeneficiaire($id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(2, $repartition["labels"]);
        $this->assertCount(2, $repartition["values"]);
        foreach ($repartition["values"] as $val) {
            $this->assertEquals(0, $val);
        }
    }

    public function testGetAssiduiteOkParticapantsInCurrentAndPreviousWeek()
    {
        $id_structure = "4";
        $today = "2022-07-04";

        $repartition = $this->stat->getAssiduite($id_structure, $today);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(3, $repartition["labels"]);
        $this->assertCount(3, $repartition["values"]);

        $this->assertEquals(100, $repartition["values"][0], "1/1 arrondi");
        $this->assertEquals(67, $repartition["values"][1], "2/3 arrondi");
        $this->assertEquals(67 - 100, $repartition["values"][2]);

        $this->assertEquals(100, $repartition["percent_present_previous_week"]);
        $this->assertEquals(67, $repartition["percent_present_current_week"]);
        $this->assertEquals(67 - 100, $repartition["variation"]);
    }

    public function testGetAssiduiteOkParticapantsInCurrentWeekOnly()
    {
        $id_structure = "4";
        $today = "2022-06-27";

        $repartition = $this->stat->getAssiduite($id_structure, $today);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(1, $repartition["labels"]);
        $this->assertCount(1, $repartition["values"]);

        $this->assertEquals(100, $repartition["values"][0], "1/1 arrondi, pourcentage semaine actuelle");

        $this->assertNull($repartition["percent_present_previous_week"]);
        $this->assertEquals(100, $repartition["percent_present_current_week"]);
        $this->assertNull($repartition["variation"]);
    }

    public function testGetAssiduiteOkParticapantsInPreviousWeekOnly()
    {
        $id_structure = "4";
        $today = "2022-07-11";

        $repartition = $this->stat->getAssiduite($id_structure, $today);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(1, $repartition["labels"]);
        $this->assertCount(1, $repartition["values"]);

        $this->assertEquals(67, $repartition["values"][0], "2/3 arrondi, pourcentage semaine précédente");

        $this->assertEquals(67, $repartition["percent_present_previous_week"]);
        $this->assertNull($repartition["percent_present_current_week"]);
        $this->assertNull($repartition["variation"]);
    }

    public function testGetAssiduiteOkNoParticapants()
    {
        $id_structure = "4";
        $today = "2022-01-01";

        $repartition = $this->stat->getAssiduite($id_structure, $today);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(0, $repartition["labels"]);
        $this->assertCount(0, $repartition["values"]);

        $this->assertNull($repartition["percent_present_previous_week"]);
        $this->assertNull($repartition["percent_present_current_week"]);
        $this->assertNull($repartition["variation"]);
    }

    public function testGetAssiduiteOkId_structureInvalid()
    {
        $id_structure = "-1";
        $today = "2022-07-04";

        $repartition = $this->stat->getAssiduite($id_structure, $today);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(0, $repartition["labels"]);
        $this->assertCount(0, $repartition["values"]);

        $this->assertNull($repartition["percent_present_previous_week"]);
        $this->assertNull($repartition["percent_present_current_week"]);
        $this->assertNull($repartition["variation"]);
    }

    public function testGetAssiduiteOkId_structureNull()
    {
        $id_structure = null;
        $today = "2022-07-04";

        $repartition = $this->stat->getAssiduite($id_structure, $today);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(0, $repartition["labels"]);
        $this->assertCount(0, $repartition["values"]);

        $this->assertNull($repartition["percent_present_previous_week"]);
        $this->assertNull($repartition["percent_present_current_week"]);
        $this->assertNull($repartition["variation"]);
    }

    public function testGetAssiduiteOkTodayNull()
    {
        $id_structure = "4";
        $today = null;

        $repartition = $this->stat->getAssiduite($id_structure, $today);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(0, $repartition["labels"]);
        $this->assertCount(0, $repartition["values"]);

        $this->assertNull($repartition["percent_present_previous_week"]);
        $this->assertNull($repartition["percent_present_current_week"]);
        $this->assertNull($repartition["variation"]);
    }

    public function testGetAssiduiteCreneauOk()
    {
        $id_creneau = "6";

        $assiduite = $this->stat->getAssiduiteCreneau($id_creneau);

        $this->assertEquals(75, $assiduite);
    }

    public function testGetAssiduiteCreneauOkNoSeance()
    {
        $id_creneau = "1";

        $assiduite = $this->stat->getAssiduiteCreneau($id_creneau);

        $this->assertEquals(false, $assiduite);
    }

    public function testGetAssiduiteCreneauNotOkId_creneauNull()
    {
        $id_creneau = null;

        $assiduite = $this->stat->getAssiduiteCreneau($id_creneau);

        $this->assertEquals(false, $assiduite);
    }

    public function testGetAssiduiteAllCreaneauxOk()
    {
        // test 1
        $id_structure = "4";

        $creneaux = $this->stat->getAssiduiteAllCreaneaux($id_structure);
        $this->assertIsArray($creneaux);
        // 1 créneau dans la structure
        $this->assertCount(1, $creneaux);

        // test 2
        $id_structure = "1";

        $creneaux = $this->stat->getAssiduiteAllCreaneaux($id_structure);
        $this->assertIsArray($creneaux);
        // 6 créneaux dans la structure
        $this->assertCount(6, $creneaux);
    }

    public function testGetAssiduiteAllCreaneauxOkEmptyResult()
    {
        $id_structure = "2";

        $creneaux = $this->stat->getAssiduiteAllCreaneaux($id_structure);
        $this->assertIsArray($creneaux);
        // 0 créneau dans la structure
        $this->assertCount(0, $creneaux);
    }

    public function testGetAssiduiteAllCreaneauxNotOkId_structureNull()
    {
        $id_structure = null;

        $creneaux = $this->stat->getAssiduiteAllCreaneaux($id_structure);
        $this->assertFalse($creneaux);
    }
}