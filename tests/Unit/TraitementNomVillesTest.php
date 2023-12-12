<?php

namespace Sportsante86\Sapa\tests\Unit;

use Tests\Support\UnitTester;

use function Sportsante86\Sapa\Outils\traitement_nom_ville;

class TraitementNomVillesTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testTraitement_nom_villeOK()
    {
        $ville = "paRiS-16";
        $this->assertEquals("PARIS 16", traitement_nom_ville($ville));

        $ville = "POITIERS";
        $this->assertEquals("POITIERS", traitement_nom_ville($ville));
    }

    public function testTraitement_nom_villeOKEmpty()
    {
        $ville = "";
        $this->assertEquals("", traitement_nom_ville($ville));
    }
}