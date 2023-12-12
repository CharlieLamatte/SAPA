<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\Territoire;
use Tests\Support\UnitTester;

class TerritoireTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Territoire $territoire;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->territoire = new Territoire($pdo);
        $this->assertNotNull($this->territoire);
    }

    protected function _after()
    {
    }

    public function testReadOneOk()
    {
        $id_territoire = '1';

        $item = $this->territoire->readOne($id_territoire);

        $this->assertNotFalse($item);
        $this->assertIsArray($item);

        $this->assertArrayHasKey('id_territoire', $item);
        $this->assertArrayHasKey('nom_territoire', $item);
        $this->assertArrayHasKey('lien_ref_territoire', $item);

        $this->assertEquals('1', $item['id_territoire']);
        $this->assertEquals('86 Vienne', $item['nom_territoire']);
        $this->assertEquals(
            'https://referencement.peps-na.fr/?distance=80&latitude=46.5750247&longitude=0.3890599&address=Cabinet+Kiné+Sport+Santé+86+%28K2S%29%2C+Rue+Denis+Papin%2C+Poitiers%2C+France',
            $item['lien_ref_territoire']
        );
    }

    public function testReadOneNotOkId_territoireNull()
    {
        $id_territoire = null;

        $item = $this->territoire->readOne($id_territoire);

        $this->assertFalse($item);
    }

    public function testReadOneNotOkId_territoireDoesntExist()
    {
        $id_territoire = '-1';

        $item = $this->territoire->readOne($id_territoire);

        $this->assertFalse($item);
    }

    public function testReadAllOkAdminNoTypeTerritoire()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => "1",
        ];

        $territoires = $this->territoire->readAll($session);
        $this->assertIsArray($territoires);

        $total_count = $this->tester->grabNumRecords('territoire');

        $this->assertCount($total_count, $territoires);

        foreach ($territoires as $territoire) {
            $this->assertArrayHasKey('id_territoire', $territoire);
            $this->assertArrayHasKey('nom_territoire', $territoire);
            $this->assertArrayHasKey('lien_ref_territoire', $territoire);
        }
    }

    public function testReadAllOkAdminTypeTerritoireDepartement()
    {
        $id_type_territoire = Territoire::TYPE_TERRITOIRE_DEPARTEMENT;
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => "1",
        ];

        $territoires = $this->territoire->readAll($session, $id_type_territoire);
        $this->assertIsArray($territoires);

        $total_count = $this->tester->grabNumRecords('territoire', ['id_type_territoire' => $id_type_territoire]);

        $this->assertCount($total_count, $territoires);

        foreach ($territoires as $territoire) {
            $this->assertArrayHasKey('id_territoire', $territoire);
            $this->assertArrayHasKey('nom_territoire', $territoire);
            $this->assertArrayHasKey('lien_ref_territoire', $territoire);
        }
    }

    public function testReadAllOkAdminTypeTerritoireRegion()
    {
        $id_type_territoire = Territoire::TYPE_TERRITOIRE_REGION;
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => "1",
        ];

        $territoires = $this->territoire->readAll($session, $id_type_territoire);
        $this->assertIsArray($territoires);

        $total_count = $this->tester->grabNumRecords('territoire', ['id_type_territoire' => $id_type_territoire]);

        $this->assertCount($total_count, $territoires);

        foreach ($territoires as $territoire) {
            $this->assertArrayHasKey('id_territoire', $territoire);
            $this->assertArrayHasKey('nom_territoire', $territoire);
            $this->assertArrayHasKey('lien_ref_territoire', $territoire);
        }
    }

    public function testReadAllOkCoordonnateurPepsNoTypeTerritoire()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => '2',
            'id_territoire' => "1",
        ];

        $territoire = $this->territoire->readAll($session);
        $this->assertIsArray($territoire);
        $this->assertCount(13, $territoire);
    }

    public function testReadAllOkCoordonnateurPepsTypeTerritoireDepartement()
    {
        $id_type_territoire = Territoire::TYPE_TERRITOIRE_DEPARTEMENT;
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => '2',
            'id_territoire' => "1",
        ];

        $territoire = $this->territoire->readAll($session, $id_type_territoire);
        $this->assertIsArray($territoire);
        $this->assertCount(12, $territoire);
    }

    public function testReadAllOkCoordonnateurPepsTypeTerritoireRegion()
    {
        $id_type_territoire = Territoire::TYPE_TERRITOIRE_REGION;
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => '2',
            'id_territoire' => "1",
        ];

        $territoire = $this->territoire->readAll($session, $id_type_territoire);
        $this->assertIsArray($territoire);
        $this->assertCount(1, $territoire);
    }

    public function testReadAllNotOkEmptySession()
    {
        $session = [];

        $territoire = $this->territoire->readAll($session);

        $this->assertFalse($territoire);
    }

    public function testReadAllNotOkAdminTypeTerritoireInvalid()
    {
        $id_type_territoire = "-1";
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => "1",
        ];

        $territoires = $this->territoire->readAll($session, $id_type_territoire);
        $this->assertFalse($territoires);
    }

    public function testReadAllUnfilteredOkNoTypeTerritoire()
    {
        $territoires = $this->territoire->readAllUnfiltered();
        $this->assertIsArray($territoires);

        $total_count = $this->tester->grabNumRecords('territoire');

        $this->assertCount($total_count, $territoires);

        foreach ($territoires as $territoire) {
            $this->assertArrayHasKey('id_territoire', $territoire);
            $this->assertArrayHasKey('nom_territoire', $territoire);
            $this->assertArrayHasKey('lien_ref_territoire', $territoire);
        }
    }

    public function testReadAllUnfilteredOkTypeTerritoireDepartement()
    {
        $id_type_territoire = Territoire::TYPE_TERRITOIRE_DEPARTEMENT;

        $territoires = $this->territoire->readAllUnfiltered($id_type_territoire);
        $this->assertIsArray($territoires);

        $total_count = $this->tester->grabNumRecords('territoire', ['id_type_territoire' => $id_type_territoire]);

        $this->assertCount($total_count, $territoires);

        foreach ($territoires as $territoire) {
            $this->assertArrayHasKey('id_territoire', $territoire);
            $this->assertArrayHasKey('nom_territoire', $territoire);
            $this->assertArrayHasKey('lien_ref_territoire', $territoire);
        }
    }

    public function testReadAllUnfilteredOkTypeTerritoireRegion()
    {
        $id_type_territoire = Territoire::TYPE_TERRITOIRE_REGION;

        $territoires = $this->territoire->readAllUnfiltered($id_type_territoire);
        $this->assertIsArray($territoires);

        $total_count = $this->tester->grabNumRecords('territoire', ['id_type_territoire' => $id_type_territoire]);

        $this->assertCount($total_count, $territoires);

        foreach ($territoires as $territoire) {
            $this->assertArrayHasKey('id_territoire', $territoire);
            $this->assertArrayHasKey('nom_territoire', $territoire);
            $this->assertArrayHasKey('lien_ref_territoire', $territoire);
        }
    }

    public function testReadAllUnfilteredNotOkTypeTerritoirInvalid()
    {
        $id_type_territoire = "-1";

        $territoires = $this->territoire->readAllUnfiltered($id_type_territoire);
        $this->assertFalse($territoires);
    }

    public function testGetCoordinateurPepsOk()
    {
        $id_territoire = "1";

        $ids = $this->territoire->getCoordinateurPeps($id_territoire);
        $this->assertNotFalse($ids);
        $this->assertIsArray($ids);
        $this->assertCount(2, $ids);
    }

    public function testGetCoordinateurPepsOkEmptyResult()
    {
        $id_territoire = "5";

        $ids = $this->territoire->getCoordinateurPeps($id_territoire);
        $this->assertNotFalse($ids);
        $this->assertIsArray($ids);
        $this->assertCount(0, $ids);
    }

    public function testGetCoordinateurPepsNotId_territoireNull()
    {
        $id_territoire = null;

        $ids = $this->territoire->getCoordinateurPeps($id_territoire);
        $this->assertFalse($ids);
    }
}