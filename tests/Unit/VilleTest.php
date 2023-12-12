<?php

namespace Sportsante86\Sapa\tests\Unit;

use Sportsante86\Sapa\Model\Ville;
use Tests\Support\UnitTester;

class VilleTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Ville $ville;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->ville = new Ville($pdo);
        $this->assertNotNull($this->ville);
    }

    protected function _after()
    {
    }

    public function testReadAllOk()
    {
        $villes = $this->ville->readAll();
        $this->assertIsArray($villes);
        $this->assertNotEmpty($villes);

        foreach ($villes as $ville) {
            $this->assertArrayHasKey("id_ville", $ville);
            $this->assertArrayHasKey("nom_ville", $ville);
            $this->assertArrayHasKey("code_postal", $ville);
        }
    }
}