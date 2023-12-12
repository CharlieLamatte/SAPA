<?php

namespace Sportsante86\Sapa\tests\Unit;

use Sportsante86\Sapa\Outils\SapaLogger;

class SapaLoggerTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testGet()
    {
        $logger = SapaLogger::get();
        $this->assertNotNull($logger);
        $this->assertEquals('Monolog\Logger', get_class($logger));
    }
}