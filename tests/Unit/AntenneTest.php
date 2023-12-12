<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\Antenne;
use Tests\Support\UnitTester;

class AntenneTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Antenne $antenne;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->antenne = new Antenne($pdo);
        $this->assertNotNull($this->antenne);
    }

    protected function _after()
    {
    }

    public function testReadOneOk()
    {
        $id_antenne = '1';

        $item = $this->antenne->readOne($id_antenne);

        $this->assertNotFalse($item);
        $this->assertIsArray($item);

        $this->assertArrayHasKey('id_antenne', $item);
        $this->assertArrayHasKey('id_structure', $item);
        $this->assertArrayHasKey('nom_antenne', $item);
        $this->assertArrayHasKey('nom_structure', $item);

        $this->assertEquals('1', $item['id_antenne']);
        $this->assertEquals('1', $item['id_structure']);
        $this->assertEquals('STRUCT TEST 1', $item['nom_antenne']);
        $this->assertEquals('STRUCT TEST 1', $item['nom_structure']);
    }

    public function testReadOneNotOkId_structureNull()
    {
        $id_antenne = null;

        $item = $this->antenne->readOne($id_antenne);

        $this->assertFalse($item);
    }

    public function testReadOneNotOkId_structureDoesntExist()
    {
        $id_antenne = '-1';

        $item = $this->antenne->readOne($id_antenne);

        $this->assertFalse($item);
    }

    public function testGetResponsableAntenneOk()
    {
        $id_antenne = "1";

        $ids = $this->antenne->getResponsableAntenne($id_antenne);
        $this->assertNotFalse($ids);
        $this->assertIsArray($ids);
        $this->assertCount(2, $ids);
    }

    public function testGetResponsableAntenneOkEmptyResult()
    {
        $id_antenne = "2";

        $ids = $this->antenne->getResponsableAntenne($id_antenne);
        $this->assertNotFalse($ids);
        $this->assertIsArray($ids);
        $this->assertCount(0, $ids);
    }

    public function testGetResponsableAntenneNotOk()
    {
        $id_antenne = null;

        $ids = $this->antenne->getResponsableAntenne($id_antenne);
        $this->assertFalse($ids);
    }

    public function testReadAllOkSuperAdmin()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
            'id_structure' => '1',
        ];
        $antennes = $this->antenne->readAll($session);
        $this->assertIsArray($antennes);

        $antennes_count = $this->tester->grabNumRecords('antenne');
        $this->assertGreaterThan(0, $antennes_count);
        $this->assertCount($antennes_count, $antennes);

        foreach ($antennes as $antenne) {
            $this->assertArrayHasKey('id_antenne', $antenne);
            $this->assertArrayHasKey('id_structure', $antenne);
            $this->assertArrayHasKey('nom_antenne', $antenne);
            $this->assertArrayHasKey('nom_structure', $antenne);
        }
    }

    public function testReadAllOkCoordinateurPeps()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
        ];
        $antennes = $this->antenne->readAll($session);
        $this->assertIsArray($antennes);

        $expected_antennes_count = "6"; // 6 antennes dans le territoire=1
        $this->assertCount($expected_antennes_count, $antennes);

        foreach ($antennes as $antenne) {
            $this->assertArrayHasKey('id_antenne', $antenne);
            $this->assertArrayHasKey('id_structure', $antenne);
            $this->assertArrayHasKey('nom_antenne', $antenne);
            $this->assertArrayHasKey('nom_structure', $antenne);
        }
    }

    public function testReadAllOkCoordinateurMss()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => '1',
            'id_structure' => '1',
        ];
        $antennes = $this->antenne->readAll($session);
        $this->assertIsArray($antennes);

        $antennes_count = $this->tester->grabNumRecords('antenne', ['id_structure' => $session['id_structure']]);
        $this->assertGreaterThan(0, $antennes_count);
        $this->assertCount($antennes_count, $antennes);

        foreach ($antennes as $antenne) {
            $this->assertArrayHasKey('id_antenne', $antenne);
            $this->assertArrayHasKey('id_structure', $antenne);
            $this->assertArrayHasKey('nom_antenne', $antenne);
            $this->assertArrayHasKey('nom_structure', $antenne);
        }
    }

    public function testReadAllNotOkRole_user_idsNull()
    {
        $session = [
            'role_user_ids' => null,
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => '1',
            'id_structure' => '1',
        ];
        $antennes = $this->antenne->readAll($session);
        $this->assertFalse($antennes);
    }

    public function testReadAllNotOkEst_coordinateur_pepsNull()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => null,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => '1',
            'id_structure' => '1',
        ];
        $antennes = $this->antenne->readAll($session);
        $this->assertFalse($antennes);
    }

    public function testReadAllNotOkId_territoireNull()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => null,
            'id_structure' => '1',
        ];
        $antennes = $this->antenne->readAll($session);
        $this->assertFalse($antennes);
    }

    public function testReadAllNotOkId_statut_structureNullAndNotAdmin()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
            'id_structure' => '1',
        ];
        $antennes = $this->antenne->readAll($session);
        $this->assertFalse($antennes);
    }

    public function testReadAllOkId_statut_structureNullAndAdmin()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
            'id_structure' => '1',
        ];
        $antennes = $this->antenne->readAll($session);
        $this->assertIsArray($antennes);
    }

    public function testReadAllNotOkId_structureNullAndNotAdmin()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => '1',
            'id_structure' => null,
        ];
        $antennes = $this->antenne->readAll($session);
        $this->assertFalse($antennes);
    }

    public function testReadAllOkId_structureNullAndAdmin()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => '1',
            'id_structure' => null,
        ];
        $antennes = $this->antenne->readAll($session);
        $this->assertIsArray($antennes);
    }

    public function testReadAllStructureOk()
    {
        $id_structure = "1";

        $antennes = $this->antenne->readAllStructure($id_structure);
        $this->assertIsArray($antennes);

        $antennes_count = $this->tester->grabNumRecords('antenne', ['id_structure' => $id_structure]);
        $this->assertGreaterThan(0, $antennes_count);
        $this->assertCount($antennes_count, $antennes);

        $this->assertArrayHasKey('id_antenne', $antennes[0]);
        $this->assertArrayHasKey('id_structure', $antennes[0]);
        $this->assertArrayHasKey('nom_antenne', $antennes[0]);
        $this->assertArrayHasKey('nom_structure', $antennes[0]);
        $this->assertArrayHasKey('nb_patient', $antennes[0]);

        foreach ($antennes as $antenne) {
            $patient_count = $this->tester->grabNumRecords('patients', ['id_antenne' => $antenne['id_antenne']]);
            $this->assertEquals($antenne['nb_patient'], $patient_count);
        }
    }

    public function testReadAllStructureOkInvalidId_structure()
    {
        $id_structure = "-1";

        $antennes = $this->antenne->readAllStructure($id_structure);
        $this->assertIsArray($antennes);
        $this->assertCount(0, $antennes);
    }

    public function testReadAllStructureNotOkId_structureNull()
    {
        $id_structure = null;

        $antennes = $this->antenne->readAllStructure($id_structure);
        $this->assertFalse($antennes);
    }
}