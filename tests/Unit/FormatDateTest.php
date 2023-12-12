<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;

use function Sportsante86\Sapa\Outils\{duree_minutes, duree_semaines, format_date};

class FormatDateTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testAgeOk()
    {
        //TODO
    }

    public function testFormat_dateOk()
    {
        $this->assertEquals('18/07/2000', format_date('2000-07-18'));
    }

    public function testFormat_dateNotOk()
    {
        $this->assertEquals(null, format_date(''));
        $this->assertEquals(null, format_date(null));
    }

    public function testDuree_minutesOk()
    {
        $this->assertEquals(1, duree_minutes('06:00:00', '06:01:00'));
        $this->assertEquals(1, duree_minutes('06:00:00', '06:00:01'));
        $this->assertEquals(0, duree_minutes('06:00:00', '06:00:00'));
        $this->assertEquals(60, duree_minutes('05:00:00', '06:00:00'));
    }

    public function testDuree_semainesOk()
    {
        $this->assertEquals(0, duree_semaines('2022-07-18', '2022-07-18'));
        $this->assertEquals(1, duree_semaines('2022-07-18', '2022-07-19'));
        $this->assertEquals(2, duree_semaines('2022-07-18', '2022-07-26'));
        $this->assertEquals(2, duree_semaines('2022-07-18', '2022-07-31'));
        $this->assertEquals(6, duree_semaines('2022-07-18', '2022-08-29'));
        $this->assertEquals(7, duree_semaines('2022-07-18', '2022-08-30'));
    }
}