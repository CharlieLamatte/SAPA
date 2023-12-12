<?php

namespace Sportsante86\Sapa\tests\Unit;

use DateTime;
use Sportsante86\Sapa\Outils\UserManager;
use Tests\Support\UnitTester;

class UserManagerTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private UserManager $manager;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->manager = new UserManager($pdo);
        $this->assertNotNull($this->manager);
    }

    protected function _after()
    {
    }

    public function testGenerate_tokenOkDefault()
    {
        $token1 = $this->manager->generate_token();
        $this->assertIsString($token1);
        $this->assertEquals(24, strlen($token1));

        $token2 = $this->manager->generate_token();
        $this->assertIsString($token2);
        $this->assertEquals(24, strlen($token2));

        $this->assertNotEquals($token1, $token2);
    }

    public function testGenerate_tokenOk()
    {
        $token = $this->manager->generate_token(1);
        $this->assertIsString($token);
        $this->assertEquals(1, strlen($token));

        $token = $this->manager->generate_token(500);
        $this->assertIsString($token);
        $this->assertEquals(500, strlen($token));
    }

    public function testGenerate_tokenNotOkZero()
    {
        $token = $this->manager->generate_token(0);
        $this->assertFalse($token);
    }

    public function testGenerate_tokenNotOkNegative()
    {
        $token = $this->manager->generate_token(-1);
        $this->assertFalse($token);
    }

    public function testIs_less_than_1_hour_agoOk()
    {
        // more than 1 day
        $datetime = "2023-05-24 18:10:00";
        $token = $this->manager->is_less_than_1_hour_ago($datetime);
        $this->assertFalse($token, $token);

        // 1 hour ago
        $now = new DateTime();
        $one_hour_ago = $now->modify('-1 hour');
        $one_hour_ago = $one_hour_ago->format("Y-m-d H:i:s");

        $token = $this->manager->is_less_than_1_hour_ago($one_hour_ago);
        $this->assertFalse($token);

        // 59 minutes ago
        $now = new DateTime();
        $fifty_nine_minutes_ago = $now->modify('-59 minute');
        $fifty_nine_minutes_ago = $fifty_nine_minutes_ago->format("Y-m-d H:i:s");

        $token = $this->manager->is_less_than_1_hour_ago($fifty_nine_minutes_ago);
        $this->assertTrue($token);

        // 10 minutes in the future
        $now = new DateTime();
        $one_hour_in_future = $now->modify('+10 minute');
        $one_hour_in_future = $one_hour_in_future->format("Y-m-d H:i:s");

        $token = $this->manager->is_less_than_1_hour_ago($one_hour_in_future);
        $this->assertFalse($token, $token);
    }

    public function testIs_less_than_1_hour_agoNotOkDateInvalid()
    {
        $now = new DateTime();
        $date = $now->modify('-59 minute');
        $date = $date->format("Y-m-d H:i:s");
        $date = $date . "dsf";

        $token = $this->manager->is_less_than_1_hour_ago($date);
        $this->assertFalse($token, $token);
    }
}