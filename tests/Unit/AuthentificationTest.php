<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Outils\Authentification;
use Exception;
use Tests\Support\UnitTester;

require 'vendor/autoload.php';

class AuthentificationTest extends \Codeception\Test\Unit
{
    use \Codeception\AssertThrows;

    protected UnitTester $tester;

    private Authentification $auth;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->auth = new Authentification($pdo);
        $this->assertNotNull($this->auth);
    }

    protected function _after()
    {
    }

    public function testUserExists()
    {
        $this->assertTrue($this->auth->user_exists("testcoord1@sportsante86.fr"));

        $this->assertFalse($this->auth->user_exists("testcoord1@sportsante86.frsdfsdf"));
        $this->assertFalse($this->auth->user_exists(""));
        $this->assertFalse($this->auth->user_exists(null));
    }

    public function testIsPasswordValid()
    {
        $this->assertTrue($this->auth->is_password_valid("testcoord1@sportsante86.fr", "testcoord1.1@A"));

        $this->assertFalse($this->auth->is_password_valid("test", "testcoord1.1@A"));
        $this->assertFalse($this->auth->is_password_valid("testcoord1@sportsante86.fr", ""));
        $this->assertFalse($this->auth->is_password_valid("", "testcoord1.1@A"));
        $this->assertFalse($this->auth->is_password_valid(null, "testcoord1.1@A"));
        $this->assertFalse($this->auth->is_password_valid("testcoord1@sportsante86.fr", null));
        $this->assertFalse($this->auth->is_password_valid(null, null));
    }

    public function testIs_user_deactivated()
    {
        // user exists
        $this->assertFalse($this->auth->is_user_deactivated("testcoord1@sportsante86.fr"));
        $this->assertFalse($this->auth->is_user_deactivated("TestAdmin@sportsante86.fr"));
        $this->assertTrue($this->auth->is_user_deactivated("deactivateduser@sportsante86.fr"));

        // user doesn't exist
        $this->assertTrue($this->auth->is_user_deactivated("test"));
        $this->assertTrue($this->auth->is_user_deactivated(""));
        $this->assertTrue($this->auth->is_user_deactivated(null));
    }

    public function testGetRolesUser()
    {
        $this->assertEquals(["1"], $this->auth->get_roles_user("TestAdmin@sportsante86.fr"));
        $this->assertEquals(["2"], $this->auth->get_roles_user("testcoord1@sportsante86.fr"));
        $this->assertEquals(["3"], $this->auth->get_roles_user("testIntervenantAbc@gmail.com"));
        $this->assertEquals(["4"], $this->auth->get_roles_user("testReferentNom@sportsante86.fr"));
        $this->assertEquals(["5"], $this->auth->get_roles_user("testEvaluateurNom@sportsante86.fr"));
        $this->assertEquals(["6"], $this->auth->get_roles_user("testResponsableStructureNom@sportsante86.fr"));
        $this->assertEquals(["7"], $this->auth->get_roles_user("testSuperviseurNom@sportsante86.fr"));

        $this->assertEquals([], $this->auth->get_roles_user("testcoord1@sportsante86.frdfd"));
        $this->assertEquals([], $this->auth->get_roles_user(""));
        $this->assertEquals([], $this->auth->get_roles_user(null));
    }

    public function testUpdateCompteurOk()
    {
        $id_user = "2";

        $compteur_before = $this->tester->grabFromDatabase(
            'users',
            'compteur',
            ['id_user' => $id_user]
        );

        $update_ok = $this->auth->update_compteur($id_user);
        $this->assertTrue($update_ok);

        $compteur_after = $this->tester->grabFromDatabase(
            'users',
            'compteur',
            ['id_user' => $id_user]
        );

        $this->assertEquals($compteur_before + 1, $compteur_after);
    }

    public function testloginOkAdmin()
    {
        $login_ok = $this->auth->login("TestAdmin@sportsante86.fr", "testAdmin1.1@A");
        $this->assertTrue($login_ok);
    }

    public function testloginOkCoordonnateur()
    {
        $login_ok = $this->auth->login("testcoord1@sportsante86.fr", "testcoord1.1@A");
        $this->assertTrue($login_ok);
    }

    public function testloginOkIntervenant()
    {
        $login_ok = $this->auth->login(
            "testIntervenantSansCreneauxNom@sportsante86.fr",
            "testIntervenantSansCreneauxNom1.1@A"
        );
        $this->assertTrue($login_ok);
    }

    public function testloginOkReferent()
    {
        $login_ok = $this->auth->login("testReferentNom@sportsante86.fr", "testReferentNom1.1@A");
        $this->assertTrue($login_ok);
    }

    public function testloginOkEvaluateur()
    {
        $login_ok = $this->auth->login("testEvaluateurNom@sportsante86.fr", "testEvaluateurNom1.1@A");
        $this->assertTrue($login_ok);
    }

    public function testloginOkResponsableStructure()
    {
        $login_ok = $this->auth->login(
            "testResponsableStructureNom@sportsante86.fr",
            "testResponsableStructureNom1.1@A"
        );
        $this->assertTrue($login_ok);
    }

    public function testloginOkSuperviseur()
    {
        $login_ok = $this->auth->login(
            "testSuperviseurNom@sportsante86.fr",
            "testAdmin1.1@A"
        );
        $this->assertTrue($login_ok);
    }

    public function testloginNotOkInvalidEmail()
    {
        $this->assertThrowsWithMessage(
            Exception::class,
            "Mot de passe ou email invalide.",
            function () {
                $this->auth->login("TestAdmin@sportsante86.frd", "testAdmin1.1@A");
            }
        );
    }

    public function testloginNotOkInvalidPassword()
    {
        $this->assertThrowsWithMessage(
            Exception::class,
            "Mot de passe ou email invalide.",
            function () {
                $this->auth->login("TestAdmin@sportsante86.fr", "testAdmin1.1@a");
            }
        );
    }
}