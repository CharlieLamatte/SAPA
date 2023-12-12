<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\StatistiquesTerritoire;
use Sportsante86\Sapa\Model\Territoire;
use Tests\Support\UnitTester;

class StatistiquesTerritoireTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private StatistiquesTerritoire $stat;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->stat = new StatistiquesTerritoire($pdo);
        $this->assertNotNull($this->stat);
    }

    protected function _after()
    {
    }

    public function testGetRepartitionAgeOk()
    {
        $id_territoire = "1";

        $repartition = $this->stat->getRepartitionAge($id_territoire);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(6, $repartition["labels"]);
        $this->assertCount(6, $repartition["values"]);
        $patient_count = 0;
        foreach ($repartition["values"] as $val) {
            $this->assertIsInt($val);
            $patient_count += $val;
        }
        $exepected_patient_count = $this->tester->grabNumRecords('patients', ['id_territoire' => $id_territoire]);
        $this->assertEquals($exepected_patient_count, $patient_count);
    }

    public function testGetRepartitionAgeOkYearNoPatients()
    {
        $id_territoire = "1";
        $year = '1999'; // aucun patient admis en 1999

        $repartition = $this->stat->getRepartitionAge($id_territoire, $year);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(6, $repartition["labels"]);
        $this->assertCount(6, $repartition["values"]);
        $patient_count = 0;
        foreach ($repartition["values"] as $val) {
            $this->assertIsInt($val);
            $patient_count += $val;
        }
        $this->assertEquals(0, $patient_count);
    }

    public function testGetRepartitionAgeOkId_structureNoPatients()
    {
        $id_territoire = "1";
        $year = null;
        $id_structure = '6'; // aucun patient dans la structure 6

        $repartition = $this->stat->getRepartitionAge($id_territoire, $year, $id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertCount(6, $repartition["labels"]);
        $this->assertCount(6, $repartition["values"]);
        $patient_count = 0;
        foreach ($repartition["values"] as $val) {
            $this->assertIsInt($val);
            $patient_count += $val;
        }
        $this->assertEquals(0, $patient_count);
    }

    public function testGetNombreEntititesOkAdmin()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => "1",
        ];

        $nombre_entite = $this->stat->getNombreEntitites($session);
        $this->assertIsArray($nombre_entite);

        $total_count = $this->tester->grabNumRecords(
            'territoire',
            ['id_type_territoire' => Territoire::TYPE_TERRITOIRE_DEPARTEMENT]
        );

        $this->assertGreaterThan(0, $total_count);
        $this->assertCount(
            $total_count
            + 3, // 2 total region + 1 total global
            $nombre_entite
        );

        foreach ($nombre_entite as $a) {
            $this->assertArrayHasKey("id_territoire", $a);
            $this->assertArrayHasKey("nom_territoire", $a);
            $this->assertArrayHasKey("nb_patient", $a);
            $this->assertArrayHasKey("nb_creneau", $a);
            $this->assertArrayHasKey("nb_intervenant", $a);
            $this->assertArrayHasKey("nb_medecin", $a);
            $this->assertArrayHasKey("nb_coordinateur", $a);
            $this->assertArrayHasKey("is_total", $a);
            $this->assertArrayHasKey("nom_region", $a);
            $this->assertArrayHasKey("id_region", $a);
        }
    }

    public function testGetNombreEntititesOkCoordonnateurPepsNouvelleAquitaine()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => '2',
            'id_territoire' => "1",
        ];

        $nombre_entite = $this->stat->getNombreEntitites($session);
        $this->assertIsArray($nombre_entite);
        $this->assertCount(
            12
            + 1, // 1 total region
            $nombre_entite
        );

        foreach ($nombre_entite as $a) {
            $this->assertArrayHasKey("id_territoire", $a);
            $this->assertArrayHasKey("nom_territoire", $a);
            $this->assertArrayHasKey("nb_patient", $a);
            $this->assertArrayHasKey("nb_creneau", $a);
            $this->assertArrayHasKey("nb_intervenant", $a);
            $this->assertArrayHasKey("nb_medecin", $a);
            $this->assertArrayHasKey("nb_coordinateur", $a);
            $this->assertArrayHasKey("is_total", $a);
            $this->assertArrayHasKey("nom_region", $a);
            $this->assertArrayHasKey("id_region", $a);
        }
    }

    public function testGetNombreEntititesOkCoordonnateurPepsPaysDeLaLoire()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => '2',
            'id_territoire' => "14", //territoire du pays de la loire
        ];

        $nombre_entite = $this->stat->getNombreEntitites($session);
        $this->assertIsArray($nombre_entite);
        $this->assertCount(
            5
            + 1, // 1 total region
            $nombre_entite
        );

        foreach ($nombre_entite as $a) {
            $this->assertArrayHasKey("id_territoire", $a);
            $this->assertArrayHasKey("nom_territoire", $a);
            $this->assertArrayHasKey("nb_patient", $a);
            $this->assertArrayHasKey("nb_creneau", $a);
            $this->assertArrayHasKey("nb_intervenant", $a);
            $this->assertArrayHasKey("nb_medecin", $a);
            $this->assertArrayHasKey("nb_coordinateur", $a);
            $this->assertArrayHasKey("is_total", $a);
            $this->assertArrayHasKey("nom_region", $a);
            $this->assertArrayHasKey("id_region", $a);
        }
    }

    public function testGetNombreEntititesNotOkSessionEmpty()
    {
        $session = [];

        $nombre_entite = $this->stat->getNombreEntitites($session);
        $this->assertFalse($nombre_entite);
    }

    public function testGetNombreOrientationOkMinimumData()
    {
        $id_territoire = "1";

        $repartition = $this->stat->getNombreOrientation($id_territoire);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertArrayHasKey("total", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertIsInt($repartition["total"]);
        $this->assertGreaterThan(0, count($repartition["labels"]));
        $this->assertGreaterThan(0, count($repartition["values"]));
        $this->assertGreaterThan(0, $repartition["total"]);
    }

    public function testGetNombreOrientationOkAllData()
    {
        $id_territoire = "1";
        $year = '2022'; // il y a patients orientés admis en 2022
        $id_structure = '1'; // il y a patients orientés admis en 2022 par la structure 1

        $repartition = $this->stat->getNombreOrientation($id_territoire, $year, $id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertArrayHasKey("total", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertIsInt($repartition["total"]);
        $this->assertGreaterThan(0, count($repartition["labels"]));
        $this->assertGreaterThan(0, count($repartition["values"]));
        $this->assertGreaterThan(0, $repartition["total"]);
    }

    public function testGetNombreOrientationOkYearNoOrientation()
    {
        $id_territoire = "1";
        $year = '1999'; // aucun patient admis en 1999

        $repartition = $this->stat->getNombreOrientation($id_territoire, $year);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertArrayHasKey("total", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertIsInt($repartition["total"]);
        $this->assertCount(0, $repartition["labels"]);
        $this->assertCount(0, $repartition["values"]);
        $this->assertEquals(0, $repartition["total"]);
    }

    public function testGetNombreOrientationOkId_structureNoPatients()
    {
        $id_territoire = "1";
        $year = null;
        $id_structure = '6'; // aucun patient dans la structure 6

        $repartition = $this->stat->getNombreOrientation($id_territoire, $year, $id_structure);

        $this->assertIsArray($repartition);
        $this->assertArrayHasKey("labels", $repartition);
        $this->assertArrayHasKey("values", $repartition);
        $this->assertArrayHasKey("total", $repartition);
        $this->assertIsArray($repartition["labels"]);
        $this->assertIsArray($repartition["values"]);
        $this->assertIsInt($repartition["total"]);
        $this->assertCount(0, $repartition["labels"]);
        $this->assertCount(0, $repartition["values"]);
        $this->assertEquals(0, $repartition["total"]);
    }

    public function testGetNombreOrientationNotOkId_territoireNull()
    {
        $id_territoire = null;

        $repartition = $this->stat->getNombreOrientation($id_territoire);
        $this->assertFalse($repartition);
    }

    public function testGetAmeliorationTestAerobieOkMinimumData()
    {
        $id_territoire = "1";

        $result = $this->stat->getAmeliorationTestAerobie($id_territoire);

        $this->assertIsArray($result);
        $this->assertArrayHasKey("labels", $result);
        $this->assertArrayHasKey("values", $result);
        $this->assertIsArray($result["labels"]);
        $this->assertIsArray($result["values"]);
        $this->assertGreaterThan(0, count($result["labels"]));
        $this->assertGreaterThan(0, count($result["values"]));
    }

    public function testGetAmeliorationTestAerobieNotOkId_territoireNull()
    {
        $id_territoire = null;

        $result = $this->stat->getAmeliorationTestAerobie($id_territoire);
        $this->assertFalse($result);
    }

    public function testGetAmeliorationTestPhysioOkMinimumData()
    {
        $id_territoire = "1";

        $result = $this->stat->getAmeliorationTestPhysio($id_territoire);

        $this->assertIsArray($result);
        $this->assertArrayHasKey("labels", $result);
        $this->assertArrayHasKey("values", $result);
        $this->assertIsArray($result["labels"]);
        $this->assertIsArray($result["values"]);
        $this->assertGreaterThan(0, count($result["labels"]));
        $this->assertGreaterThan(0, count($result["values"]));
    }

    public function testGetAmeliorationTestPhysioNotOkId_territoireNull()
    {
        $id_territoire = null;

        $result = $this->stat->getAmeliorationTestPhysio($id_territoire);
        $this->assertFalse($result);
    }

    public function testGetAmeliorationTestForceMbSupOkMinimumData()
    {
        $id_territoire = "1";

        $result = $this->stat->getAmeliorationTestForceMbSup($id_territoire);

        $this->assertIsArray($result);
        $this->assertArrayHasKey("labels", $result);
        $this->assertArrayHasKey("values", $result);
        $this->assertIsArray($result["labels"]);
        $this->assertIsArray($result["values"]);
        $this->assertGreaterThan(0, count($result["labels"]));
        $this->assertGreaterThan(0, count($result["values"]));
    }

    public function testGetAmeliorationTestForceMbSupNotOkId_territoireNull()
    {
        $id_territoire = null;

        $result = $this->stat->getAmeliorationTestForceMbSup($id_territoire);
        $this->assertFalse($result);
    }

    public function testGetAmeliorationTestEquilibreStatiqueOkMinimumData()
    {
        $id_territoire = "1";

        $result = $this->stat->getAmeliorationTestEquilibreStatique($id_territoire);

        $this->assertIsArray($result);
        $this->assertArrayHasKey("labels", $result);
        $this->assertArrayHasKey("values", $result);
        $this->assertIsArray($result["labels"]);
        $this->assertIsArray($result["values"]);
        $this->assertGreaterThan(0, count($result["labels"]));
        $this->assertGreaterThan(0, count($result["values"]));
    }

    public function testGetAmeliorationTestEquilibreStatiqueNotOkId_territoireNull()
    {
        $id_territoire = null;

        $result = $this->stat->getAmeliorationTestEquilibreStatique($id_territoire);
        $this->assertFalse($result);
    }

    public function testGetAmeliorationTestSouplesseOkMinimumData()
    {
        $id_territoire = "1";

        $result = $this->stat->getAmeliorationTestSouplesse($id_territoire);

        $this->assertIsArray($result);
        $this->assertArrayHasKey("labels", $result);
        $this->assertArrayHasKey("values", $result);
        $this->assertIsArray($result["labels"]);
        $this->assertIsArray($result["values"]);
        $this->assertGreaterThan(0, count($result["labels"]));
        $this->assertGreaterThan(0, count($result["values"]));
    }

    public function testGetAmeliorationTestSouplesseNotOkId_territoireNull()
    {
        $id_territoire = null;

        $result = $this->stat->getAmeliorationTestSouplesse($id_territoire);
        $this->assertFalse($result);
    }

    public function testGetEvolutionTestMobiliteScapuloHumeraleOkMinimumData()
    {
        $id_territoire = "1";

        $result = $this->stat->getEvolutionTestMobiliteScapuloHumerale($id_territoire);

        $this->assertIsArray($result);
        $this->assertArrayHasKey("labels", $result);
        $this->assertArrayHasKey("values", $result);
        $this->assertIsArray($result["labels"]);
        $this->assertIsArray($result["values"]);
        $this->assertGreaterThan(0, count($result["labels"]));
        $this->assertGreaterThan(0, count($result["values"]));
    }

    public function testGetEvolutionTestMobiliteScapuloHumeraleNotOkId_territoireNull()
    {
        $id_territoire = null;

        $result = $this->stat->getEvolutionTestMobiliteScapuloHumerale($id_territoire);
        $this->assertFalse($result);
    }

    public function testGetEvolutionTestEnduranceMbInfOkMinimumData()
    {
        $id_territoire = "1";

        $result = $this->stat->getEvolutionTestEnduranceMbInf($id_territoire);

        $this->assertIsArray($result);
        $this->assertArrayHasKey("labels", $result);
        $this->assertArrayHasKey("values", $result);
        $this->assertIsArray($result["labels"]);
        $this->assertIsArray($result["values"]);
        $this->assertGreaterThan(0, count($result["labels"]));
        $this->assertGreaterThan(0, count($result["values"]));
    }

    public function testGetEvolutionTestEnduranceMbInfNotOkId_territoireNull()
    {
        $id_territoire = null;

        $result = $this->stat->getEvolutionTestEnduranceMbInf($id_territoire);
        $this->assertFalse($result);
    }
}