<?php

namespace Tests\Unit;

use Exception;
use Sportsante86\Sapa\Outils\Permissions;
use Tests\Support\UnitTester;

class PermissionsTest extends \Codeception\Test\Unit
{
    use \Codeception\AssertThrows;

    protected UnitTester $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testGetRolesUserOk1Role()
    {
        $p = new Permissions([
            'role_user_ids' => ['2'], // coordo
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $roles_user = $p->getRolesUser();
        $this->assertIsArray($roles_user);
        $this->assertEquals([Permissions::COORDONNATEUR_MSS], $roles_user);

        $p = new Permissions([
            'role_user_ids' => ['2'], // coordo
            'id_statut_structure' => '2', // Centre Evaluateur
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $roles_user = $p->getRolesUser();
        $this->assertIsArray($roles_user);
        $this->assertEquals([Permissions::COORDONNATEUR_NON_MSS], $roles_user);

        $p = new Permissions([
            'role_user_ids' => ['2'], // coordo
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => true,
        ]);

        $this->assertNotNull($p);
        $roles_user = $p->getRolesUser();
        $this->assertIsArray($roles_user);
        $this->assertEquals([Permissions::COORDONNATEUR_PEPS], $roles_user);

        $p = new Permissions([
            'role_user_ids' => ['1'], // super admin
            'id_statut_structure' => null,
            'est_coordinateur_peps' => "0",
        ]);

        $this->assertNotNull($p);
        $roles_user = $p->getRolesUser();
        $this->assertIsArray($roles_user);
        $this->assertEquals([Permissions::SUPER_ADMIN], $roles_user);

        $p = new Permissions([
            'role_user_ids' => ['3'], // intervenant
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $roles_user = $p->getRolesUser();
        $this->assertIsArray($roles_user);
        $this->assertEquals([Permissions::INTERVENANT], $roles_user);

        $p = new Permissions([
            'role_user_ids' => ['4'], // referent
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $roles_user = $p->getRolesUser();
        $this->assertIsArray($roles_user);
        $this->assertEquals([Permissions::REFERENT], $roles_user);

        $p = new Permissions([
            'role_user_ids' => ['5'], // evaluateur
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $roles_user = $p->getRolesUser();
        $this->assertIsArray($roles_user);
        $this->assertEquals([Permissions::EVALUATEUR], $roles_user);

        $p = new Permissions([
            'role_user_ids' => ['6'], // responsable structure
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $roles_user = $p->getRolesUser();
        $this->assertIsArray($roles_user);
        $this->assertEquals([Permissions::RESPONSABLE_STRUCTURE], $roles_user);

        $p = new Permissions([
            'role_user_ids' => ['7'], // superviseur
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $roles_user = $p->getRolesUser();
        $this->assertIsArray($roles_user);
        $this->assertEquals([Permissions::SUPERVISEUR_PEPS], $roles_user);
    }

    public function testGetRolesUserOk2Roles()
    {
        $p = new Permissions([
            'role_user_ids' => ['2', '3'],
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $this->assertEqualsCanonicalizing([Permissions::COORDONNATEUR_MSS, Permissions::INTERVENANT],
            $p->getRolesUser());

        $p = new Permissions([
            'role_user_ids' => ['2', '3'],
            'id_statut_structure' => '2', // Centre Evaluateur
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $this->assertEqualsCanonicalizing([Permissions::COORDONNATEUR_NON_MSS, Permissions::INTERVENANT],
            $p->getRolesUser());

        $p = new Permissions([
            'role_user_ids' => ['2', '3'],
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => true,
        ]);

        $this->assertNotNull($p);
        $this->assertEqualsCanonicalizing([Permissions::COORDONNATEUR_PEPS, Permissions::INTERVENANT],
            $p->getRolesUser());

        $p = new Permissions([
            'role_user_ids' => ['6', "5"],
            'id_statut_structure' => "2",
            'est_coordinateur_peps' => "0",
        ]);

        $this->assertNotNull($p);
        $this->assertEqualsCanonicalizing([Permissions::RESPONSABLE_STRUCTURE, Permissions::EVALUATEUR],
            $p->getRolesUser());

        $p = new Permissions([
            'role_user_ids' => ['3'], // intervenant
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => false,
        ]);
    }

    public function testIsIntervenantAndOtherRoleOk()
    {
        $p = new Permissions([
            'role_user_ids' => ['2', '3'],
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $this->assertTrue($p->isIntervenantAndOtherRole());

        $p = new Permissions([
            'role_user_ids' => ['2', '4'],
            'id_statut_structure' => '2', // Centre Evaluateur
            'est_coordinateur_peps' => false,
        ]);

        $this->assertNotNull($p);
        $this->assertFalse($p->isIntervenantAndOtherRole());

        $p = new Permissions([
            'role_user_ids' => ['3'],
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => true,
        ]);

        $this->assertNotNull($p);
        $this->assertFalse($p->isIntervenantAndOtherRole());

        $p = new Permissions([
            'role_user_ids' => ['2'],
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => true,
        ]);

        $this->assertNotNull($p);
        $this->assertFalse($p->isIntervenantAndOtherRole());
    }

    public function testHasPermissionOk1Role()
    {
        // super admin
        $p = new Permissions([
            'role_user_ids' => ['1'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => "0",
        ]);

        $this->assertNotNull($p);
        $this->assertTrue($p->hasPermission('can_view_page_journal_activite'));
        $this->assertFalse($p->hasPermission('can_view_button_ma_structure'));
    }

    public function testHasPermissionOk2Role()
    {
        // super admin et coordo PEPS
        $p = new Permissions([
            'role_user_ids' => ['1', "2"],
            'id_statut_structure' => '1',
            'est_coordinateur_peps' => "1",
        ]);

        $this->assertNotNull($p);
        // present dans SUPER_ADMIN et pas COORDONNATEUR_PEPS
        $this->assertTrue($p->hasPermission('can_view_page_journal_activite'));
        // present dans COORDONNATEUR_PEPS et pas SUPER_ADMIN
        $this->assertTrue($p->hasPermission('can_view_button_ma_structure'));
        // present uniquement dans COORDONNATEUR_NON_MSS
        $this->assertFalse($p->hasPermission('can_view_button_mes_utilisateurs'));
    }
}