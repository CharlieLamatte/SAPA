<?php

namespace Tests\Unit;

use Faker\Factory;
use Sportsante86\Sapa\Model\User;
use Tests\Support\UnitTester;

class UserTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private User $user;
    private $faker;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->user = new User($pdo);
        $this->assertNotNull($this->user);

        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed();
    }

    protected function _after()
    {
    }

    public function testCreateOkAdmin()
    {
        $nom = "Adminnom";
        $prenom = "Adminprénom";
        $email = $this->faker->email();
        $id_structure = "1";
        $role_user_ids = ["1"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertNotFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($users_count_before + 1, $users_count_after);
        $this->assertEquals($intervention_count_before + 1, $intervention_count_after);
        $this->assertEquals($a_role_count_before + 1, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testCreateOkAdminMissingId_structure()
    {
        $nom = "Adminnostructurenom";
        $prenom = "Adminnostructureprénom";
        $email = $this->faker->email();
        $id_structure = null;
        $role_user_ids = ["1"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertNotFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($users_count_before + 1, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before + 1, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->dontSeeInDatabase('intervention', array(
            'id_user' => $id_user,
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testCreateOkCoordonnateur()
    {
        $nom = "Coordonnateurnom";
        $prenom = "Coordonnateurprénom";
        $email = $this->faker->email();
        $id_structure = "1";
        $role_user_ids = ["2"];
        $id_territoire = "1";
        $mdp = "BVGVGFdfsd@5467456";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        $est_coordinateur_peps = true;

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,

            'est_coordinateur_peps' => $est_coordinateur_peps,
        ]);
        $this->assertNotFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($users_count_before + 1, $users_count_after);
        $this->assertEquals($intervention_count_before + 1, $intervention_count_after);
        $this->assertEquals($a_role_count_before + 1, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "1",
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testCreateOkIntervenant()
    {
        $nom = "Intervenantnom";
        $prenom = "Intervenantprénom";
        $email = $this->faker->email();
        $id_structure = "1";
        $role_user_ids = ["3"];
        $id_territoire = "1";
        $mdp = "jfdgfGFH@098";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        $diplomes = ["5", "6", "7"];
        $id_statut_intervenant = "2";
        $numero_carte = "K98756";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,

            'id_statut_intervenant' => $id_statut_intervenant,
            'diplomes' => $diplomes,
            'numero_carte' => $numero_carte,
        ]);
        $this->assertNotFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($users_count_before + 1, $users_count_after);
        $this->assertEquals($intervention_count_before + 1, $intervention_count_after);
        $this->assertEquals($a_role_count_before + 1, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before + 1, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before + 3, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before + 1, $intervient_dans_count_after);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $id_intervenant = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_intervenant',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'id_intervenant' => $id_intervenant,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        $this->tester->seeInDatabase('intervenants', array(
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => $numero_carte,
        ));

        foreach ($diplomes as $id_diplome) {
            $this->tester->seeInDatabase('a_obtenu', array(
                'id_diplome' => $id_diplome,
                'id_intervenant' => $id_intervenant,
            ));
        }

        $this->tester->seeInDatabase('intervient_dans', array(
            'id_structure' => $id_structure,
            'id_intervenant' => $id_intervenant,
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testCreateOkReferent()
    {
        $nom = "Referentnom";
        $prenom = "Referentprénom";
        $email = $this->faker->email();
        $id_structure = "1";
        $role_user_ids = ["4"];
        $id_territoire = "1";
        $mdp = "GyHfdsdfgg@7577";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertNotFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($users_count_before + 1, $users_count_after);
        $this->assertEquals($intervention_count_before + 1, $intervention_count_after);
        $this->assertEquals($a_role_count_before + 1, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testCreateOkEvaluateur()
    {
        $nom = "Evaluateurnom";
        $prenom = "Evaluateurprénom";
        $email = $this->faker->email();
        $id_structure = "1";
        $role_user_ids = ["5"];
        $id_territoire = "1";
        $mdp = "GyHfdsdfgg@7577";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertNotFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($users_count_before + 1, $users_count_after);
        $this->assertEquals($intervention_count_before + 1, $intervention_count_after);
        $this->assertEquals($a_role_count_before + 1, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testCreateOkSuperviseur()
    {
        $nom = "Superviseurnom";
        $prenom = "Superviseurprénom";
        $email = $this->faker->email();
        $id_structure = "1";
        $role_user_ids = ["7"];
        $id_territoire = "1";
        $fonction = "Conseiller sportif";
        $mdp = "GyHfdsdfgg@7577";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'nom_fonction' => $fonction,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertNotFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($users_count_before + 1, $users_count_after);
        $this->assertEquals($a_role_count_before + 1, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => $fonction,
            'est_coordinateur_peps' => "0", // default value
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testCreateOKIntervenantExistant()
    {
        $nom = "INTERVENANTTESTNOM1"; // même nom
        $prenom = "IntervenantTestPrenom1"; // même prénom
        $email = "intervenantTestNom1.intervenantTestPrenom1@sportsante86.fr"; // même email
        $id_structure = "1";
        $role_user_ids = ["3"];
        $id_territoire = "1";
        $mdp = "jfdgfGFH@098";
        $tel_portable = "0756438909";
        $tel_fixe = "0145328745";

        $id_intervenant = "1";
        $diplomes = ["3"]; // même diplômes que l'intervenant existant
        $id_statut_intervenant = "2"; // même statut
        $numero_carte = "231"; // même numéro de carte

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,

            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'diplomes' => $diplomes,
            'numero_carte' => $numero_carte,
        ]);
        $this->assertNotFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after, "coordonnees"); // re-use
        $this->assertEquals($users_count_before + 1, $users_count_after, "users");
        $this->assertEquals($intervention_count_before + 1, $intervention_count_after, "intervention");
        $this->assertEquals($a_role_count_before + 1, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after, "ntervenant"); // re-use
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after, "a_obtenu"); // re-use
        $this->assertEquals($intervient_dans_count_before + 1, $intervient_dans_count_after, "intervient_dans");

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'id_intervenant' => $id_intervenant,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        $this->tester->seeInDatabase('intervenants', array(
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => $numero_carte,
        ));

        foreach ($diplomes as $id_diplome) {
            $this->tester->seeInDatabase('a_obtenu', array(
                'id_diplome' => $id_diplome,
                'id_intervenant' => $id_intervenant,
            ));
        }

        $this->tester->seeInDatabase('intervient_dans', array(
            'id_structure' => $id_structure,
            'id_intervenant' => $id_intervenant,
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testCreateNotOKIntervenantAlreadyUser()
    {
        $nom = "dfgfghj";
        $prenom = "hgjmklm";
        $email = "IntervenantAlreadyUser@gmail.com";
        $id_structure = "1";
        $role_user_ids = ["3"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        $id_intervenant = "4"; // intervenant utilisateur (id_user = "3")
        $numero_carte = "K987jhh";
        $diplomes = ["5", "6", "7"];
        $id_statut_intervenant = "2";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,

            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'diplomes' => $diplomes,
            'numero_carte' => $numero_carte,
        ]);
        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOKId_intervenantInvalid()
    {
        $nom = "dfgfghj";
        $prenom = "hgjmklm";
        $email = "IntervenantAlreadyUser@gmail.com";
        $id_structure = "1";
        $role_user_ids = ["3"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        $id_intervenant = "-1"; // invalide
        $numero_carte = "K987jhh";
        $diplomes = ["5", "6", "7"];
        $id_statut_intervenant = "2";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,

            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'diplomes' => $diplomes,
            'numero_carte' => $numero_carte,
        ]);
        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkMissingNom()
    {
        $nom = null;
        $prenom = "Adminprénom";
        $email = "AdminMissingNom@gmail.com";
        $id_structure = "1";
        $role_user_ids = ["1"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkMissingPrenom()
    {
        $nom = "dfghdfgh";
        $prenom = null;
        $email = "AdminnomMissingPrenom@gmail.com";
        $id_structure = "1";
        $role_user_ids = ["1"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkMissingEmail()
    {
        $nom = "dfghdfgh";
        $prenom = "Adminprénom";
        $email = null;
        $id_structure = "1";
        $role_user_ids = ["1"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkMissingMotDePasse()
    {
        $nom = "dfghdfgh";
        $prenom = "Adminprénom";
        $email = "AdminMissingMotDePasse@gmail.com";
        $id_structure = "1";
        $role_user_ids = ["1"];
        $id_territoire = "1";
        $mdp = null;
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkCoordonnateurMissingId_structure()
    {
        $nom = "dfghdfgh";
        $prenom = "sdgffg";
        $email = "CoordonnateurMissingId_structure@gmail.com";
        $id_structure = null;
        $role_user_ids = ["2"];
        $id_territoire = "1";
        $mdp = "sfgh9087gf@hF";
        $est_coordinateur_peps = true;
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,

            'est_coordinateur_peps' => $est_coordinateur_peps,
        ]);
        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkMissingId_territoire()
    {
        $nom = "dfghdfgh";
        $prenom = "fghjghjf";
        $email = "MissingId_territoire@gmail.com";
        $id_structure = "1";
        $role_user_ids = ["1"];
        $id_territoire = null;
        $mdp = "dsfghfgd987ghg@";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkMissingRole_user_ids()
    {
        $nom = "dfghdfgh";
        $prenom = "Adminprénom";
        $email = "AdminnomMissingId_role_user@gmail.com";
        $id_structure = "1";
        $role_user_ids = [];
        $id_territoire = "1";
        $mdp = "sdfgdsfgHG78";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,
        ]);
        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkIntervenantMissingId_statut()
    {
        $nom = "dfghdfgh";
        $prenom = "Adminprénom";
        $email = "IntervenantMissingId_statut@gmail.com";
        $id_structure = "1";
        $role_user_ids = ["3"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        $numero_carte = "K98756";
        $diplomes = ["5", "6", "7"];
        $id_statut_intervenant = null;

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,

            'id_statut_intervenant' => $id_statut_intervenant,
            'diplomes' => $diplomes,
            'numero_carte' => $numero_carte,
        ]);

        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkIntervenantInvalidCard()
    {
        $nom = "hgf";
        $prenom = "dfgdffg";
        $email = "IntervenantInvalidCard@gmail.com";
        $id_structure = "1";
        $role_user_ids = ["3"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        $numero_carte = "K98756dfgdgr"; // carte de plus de 11 chars
        $diplomes = ["5", "6", "7"];
        $id_statut_intervenant = "2";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,

            'id_statut_intervenant' => $id_statut_intervenant,
            'diplomes' => $diplomes,
            'numero_carte' => $numero_carte,
        ]);
        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkCoordonnateurMissingEst_coordonateur_peps()
    {
        $nom = "dfghdljlfgh";
        $prenom = "dfgdf";
        $email = "CoordonnateurMissingEst_coordonateur_peps@gmail.com";
        $id_structure = "1";
        $role_user_ids = ["2"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";

        $est_coordinateur_peps = null;

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
            'tel_f_user' => $tel_fixe,
            'tel_p_user' => $tel_portable,

            'est_coordinateur_peps' => $est_coordinateur_peps,
        ]);

        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkEmailAlreadyUsed()
    {
        $nom = "fghfg";
        $prenom = "khjkj";
        $email = "TestAdmin@sportsante86.fr"; // email existant dans la BDD
        $id_structure = "1";
        $role_user_ids = ["1"];
        $id_territoire = "1";
        $mdp = "GyHfds@8765";

        // all
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $users_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $a_role_count_before = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_user = $this->user->create([
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'id_structure' => $id_structure,
            'role_user_ids' => $role_user_ids,
            'mdp' => $mdp,
        ]);

        $this->assertFalse($id_user);

        // all
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $users_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $a_role_count_after = $this->tester->grabNumRecords('a_role');
        // intervenant
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        // all
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($users_count_before, $users_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($a_role_count_before, $a_role_count_after);
        // intervenant
        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testDeleteNotOkId_userNull()
    {
        $id_user = null;

        $delete_ok = $this->user->delete($id_user);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkId_userInvalide()
    {
        $id_user = '-1';

        $delete_ok = $this->user->delete($id_user);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteSuper_coordinateurOk()
    {
        $id_user = '10';

        $delete_ok = $this->user->delete($id_user);
        $this->assertTrue($delete_ok);

        $this->tester->dontSeeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('users', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('intervention', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('user_settings', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('a_role', array(
            'id_user' => $id_user,
        ));
    }

    public function testDeleteCoordinateurOk()
    {
        $id_user = '11';

        $delete_ok = $this->user->delete($id_user);
        $this->assertTrue($delete_ok);

        $this->tester->dontSeeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('users', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('intervention', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('user_settings', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('a_role', array(
            'id_user' => $id_user,
        ));
    }

    public function testDeleteIntervenantNotOkCreneaux()
    {
        $id_user = '3';

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $id_intervenant = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_intervenant',
            array('id_user' => $id_user)
        );

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $intervenants_count_before = $this->tester->grabNumRecords('intervenants');
        $user_count_before = $this->tester->grabNumRecords('users');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $delete_ok = $this->user->delete($id_user);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $intervenants_count_after = $this->tester->grabNumRecords('intervenants');
        $user_count_after = $this->tester->grabNumRecords('users');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($intervenants_count_before, $intervenants_count_after);
        $this->assertEquals($user_count_before, $user_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);


        $this->tester->seeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('intervenants', array(
            'id_coordonnees' => $id_coordonnees,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('a_obtenu', array(
            'id_intervenant' => $id_intervenant,
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('intervient_dans', array(
            'id_intervenant' => $id_intervenant,
        ));
    }

    public function testDeleteIntervenantNotOkSeance()
    {
        $id_user = '15';

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $id_intervenant = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_intervenant',
            array('id_user' => $id_user)
        );

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $intervenants_count_before = $this->tester->grabNumRecords('intervenants');
        $user_count_before = $this->tester->grabNumRecords('users');
        $intervention_count_before = $this->tester->grabNumRecords('intervention');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $delete_ok = $this->user->delete($id_user);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $intervenants_count_after = $this->tester->grabNumRecords('intervenants');
        $user_count_after = $this->tester->grabNumRecords('users');
        $intervention_count_after = $this->tester->grabNumRecords('intervention');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($intervenants_count_before, $intervenants_count_after);
        $this->assertEquals($user_count_before, $user_count_after);
        $this->assertEquals($intervention_count_before, $intervention_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);

        $this->tester->seeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('intervenants', array(
            'id_coordonnees' => $id_coordonnees,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('intervient_dans', array(
            'id_intervenant' => $id_intervenant,
        ));
    }

    public function testDeleteIntervenantOK()
    {
        $id_user = '21';

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $id_intervenant = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_intervenant',
            array('id_user' => $id_user)
        );

        $delete_ok = $this->user->delete($id_user);
        $this->assertTrue($delete_ok, $this->user->getErrorMessage());

        $this->tester->dontSeeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('intervenants', array(
            'id_coordonnees' => $id_coordonnees,
        ));

        $this->tester->dontSeeInDatabase('users', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('a_obtenu', array(
            'id_intervenant' => $id_intervenant,
        ));

        $this->tester->dontSeeInDatabase('intervention', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('user_settings', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('a_role', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('creneaux_intervenant', array(
            'id_intervenant' => $id_intervenant,
        ));
    }

    public function testDeleteReferentOk()
    {
        $id_user = '13';

        $delete_ok = $this->user->delete($id_user);
        $this->assertTrue($delete_ok);

        $this->tester->dontSeeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('users', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('intervention', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('user_settings', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('a_role', array(
            'id_user' => $id_user,
        ));
    }

    public function testDeleteEvaluateurOk()
    {
        $id_user = '14';

        $delete_ok = $this->user->delete($id_user);
        $this->assertTrue($delete_ok);

        $this->tester->dontSeeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('users', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('intervention', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('user_settings', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('a_role', array(
            'id_user' => $id_user,
        ));
    }

    public function testDeleteUserNotOkObservations()
    {
        $id_user = '2';

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $user_count_before = $this->tester->grabNumRecords('users');

        $delete_ok = $this->user->delete($id_user);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $user_count_after = $this->tester->grabNumRecords('users');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($user_count_before, $user_count_after);

        $this->tester->seeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
        ));
    }

    public function testDeleteUserNotOkPatient()
    {
        $id_user = '16';

        $patient_count = $this->tester->grabNumRecords('patients', ['id_user' => $id_user]);

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $user_count_before = $this->tester->grabNumRecords('users');

        $delete_ok = $this->user->delete($id_user);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $user_count_after = $this->tester->grabNumRecords('users');

        $this->assertGreaterThan(0, $patient_count);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($user_count_before, $user_count_after);

        $this->tester->seeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
        ));
    }

    public function testDeleteUserNotOkEval()
    {
        $id_user = '22';

        $eval_count = $this->tester->grabNumRecords('evaluations', ['id_user' => $id_user]);
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $user_count_before = $this->tester->grabNumRecords('users');

        $delete_ok = $this->user->delete($id_user);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $user_count_after = $this->tester->grabNumRecords('users');

        $this->assertGreaterThan(0, $eval_count);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($user_count_before, $user_count_after);


        $this->tester->seeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
        ));
    }

    public function testDeleteUserNotOkQuestionnaire()
    {
        $id_user = '18';

        $questionnaire_count = $this->tester->grabNumRecords('questionnaire_instance', ['id_user' => $id_user]);

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $user_count_before = $this->tester->grabNumRecords('users');

        $delete_ok = $this->user->delete($id_user);
        $this->assertFalse($delete_ok);

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $user_count_after = $this->tester->grabNumRecords('users');

        $this->assertGreaterThan(0, $questionnaire_count);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($user_count_before, $user_count_after);

        $this->tester->seeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
        ));
    }

    public function testDeleteSuperviseurOk()
    {
        $id_user = '19';

        $delete_ok = $this->user->delete($id_user);
        $this->assertTrue($delete_ok);

        $this->tester->dontSeeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('users', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('intervention', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('user_settings', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('a_role', array(
            'id_user' => $id_user,
        ));
    }

    public function testDeleteResponsableStructureOk()
    {
        $id_user = '20';

        $delete_ok = $this->user->delete($id_user);
        $this->assertTrue($delete_ok);

        $this->tester->dontSeeInDatabase('coordonnees', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('users', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('intervention', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('user_settings', array(
            'id_user' => $id_user,
        ));

        $this->tester->dontSeeInDatabase('a_role', array(
            'id_user' => $id_user,
        ));
    }

    public function testUpdateOkAdminMinimumData()
    {
        // obligatoire
        $id_user = "1";
        $role_user_ids = ["1"];
        $id_territoire = "3";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "TestAdmin@sportsante86.fr";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
        ]);
        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'id_coordonnees' => $id_coordonnees,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkAdminMinimumDataIs_deactivatedTrue()
    {
        // obligatoire
        $id_user = "1";
        $role_user_ids = ["1"];
        $id_territoire = "3";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "TestAdmin@sportsante86.fr";
        $is_deactivated = true;

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'is_deactivated' => $is_deactivated,
        ]);
        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'id_coordonnees' => $id_coordonnees,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => "1",
        ));

        $is_deactivated_updated_at = $this->tester->grabFromDatabase(
            'users',
            'is_deactivated_updated_at',
            array('id_user' => $id_user)
        );

        $this->assertNotNull($is_deactivated_updated_at);

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkAdminMinimumDataIs_deactivatedFalse()
    {
        // obligatoire
        $id_user = "1";
        $role_user_ids = ["1"];
        $id_territoire = "3";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "TestAdmin@sportsante86.fr";
        $is_deactivated = false;

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'is_deactivated' => $is_deactivated,
        ]);
        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'id_coordonnees' => $id_coordonnees,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => "0",
        ));

        $is_deactivated_updated_at = $this->tester->grabFromDatabase(
            'users',
            'is_deactivated_updated_at',
            array('id_user' => $id_user)
        );

        $this->assertNotNull($is_deactivated_updated_at);

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkAdminAllData()
    {
        // obligatoire
        $id_user = "1";
        $role_user_ids = ["1"];
        $id_territoire = "4";
        $nom = "Begoyui";
        $prenom = "Vefdyui";
        $email = "TestAdmin@sportsante86.fr";

        // optionnel
        $id_structure = "1";
        $is_mdp_modified = true;
        $mdp = "GyHfds@8765dfgs";
        $tel_f_user = "0787654554";
        $tel_p_user = "0123454343";
        $settings = [
            [
                'id_setting' => '1',
                'valeur' => '50',
            ]
        ];

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,
            'is_mdp_modified' => $is_mdp_modified,
            'mdp' => $mdp,
            'tel_f_user' => $tel_f_user,
            'tel_p_user' => $tel_p_user,
            'settings' => $settings,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_p_user,
            'tel_fixe_coordonnees' => $tel_f_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        foreach ($settings as $setting) {
            $this->tester->seeInDatabase('user_settings', array(
                'id_user' => $id_user,
                'id_setting' => $setting['id_setting'],
                'valeur' => $setting['valeur'],
            ));
        }

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkCoordinateurMinimumData()
    {
        // obligatoire
        $id_user = "2";
        $role_user_ids = ["2"];
        $id_territoire = "5";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "testcoord1@sportsante86.fr";
        $id_structure = "1";
        $est_coordinateur_peps = true;

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
            'id_structure' => $id_structure,

            'est_coordinateur_peps' => $est_coordinateur_peps,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "1",
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkCoordinateurAllData()
    {
        // obligatoire
        $id_user = "2";
        $role_user_ids = ["2"];
        $id_territoire = "5";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "testcoord1@sportsante86.fr";
        $id_structure = "1";

        // optionnel
        $is_mdp_modified = true;
        $mdp = "GyHfds@8765dfg";
        $tel_f_user = "0787654554";
        $tel_p_user = "0123454343";
        $settings = [
            [
                'id_setting' => '1',
                'valeur' => '50',
            ]
        ];
        $est_coordinateur_peps = true;

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,
            'is_mdp_modified' => $is_mdp_modified,
            'mdp' => $mdp,
            'tel_f_user' => $tel_f_user,
            'tel_p_user' => $tel_p_user,
            'settings' => $settings,

            'est_coordinateur_peps' => $est_coordinateur_peps,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_p_user,
            'tel_fixe_coordonnees' => $tel_f_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "1",
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        foreach ($settings as $setting) {
            $this->tester->seeInDatabase('user_settings', array(
                'id_user' => $id_user,
                'id_setting' => $setting['id_setting'],
                'valeur' => $setting['valeur'],
            ));
        }

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkIntervenantMinimumData()
    {
        // obligatoire
        $id_user = "3";
        $role_user_ids = ["3"];
        $id_territoire = "2";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "testIntervenantAbc@gmail.com";
        $id_structure = "1";

        $id_statut_intervenant = "2";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,
            'id_statut_intervenant' => $id_statut_intervenant,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $id_intervenant = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_intervenant',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'id_intervenant' => $id_intervenant,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        $this->tester->seeInDatabase('intervenants', array(
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => "",
        ));

        $this->tester->dontSeeInDatabase('a_obtenu', array(
            'id_intervenant' => $id_intervenant,
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkIntervenantAllData()
    {
        // obligatoire
        $id_user = "3";
        $role_user_ids = ["3"];
        $id_territoire = "2";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "testIntervenantAbc@gmail.com";
        $id_structure = "1";

        // optionnel
        $is_mdp_modified = true;
        $mdp = "GyHfds@8765dfg";
        $tel_f_user = "0787654554";
        $tel_p_user = "0123454343";
        $settings = [
            [
                'id_setting' => '1',
                'valeur' => '50',
            ]
        ];
        // si intervenant
        $id_statut_intervenant = "1";
        $numero_carte = "sdfg56";
        $diplomes = ["4"];

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,
            'is_mdp_modified' => $is_mdp_modified,
            'mdp' => $mdp,
            'tel_f_user' => $tel_f_user,
            'tel_p_user' => $tel_p_user,
            'settings' => $settings,

            'id_statut_intervenant' => $id_statut_intervenant,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $id_intervenant = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_intervenant',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'id_intervenant' => $id_intervenant,
            'tel_portable_coordonnees' => $tel_p_user,
            'tel_fixe_coordonnees' => $tel_f_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervention', array(
            'id_user' => $id_user,
            'id_structure' => $id_structure,
        ));

        $this->tester->seeInDatabase('intervenants', array(
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => $numero_carte,
        ));

        foreach ($diplomes as $id_diplome) {
            $this->tester->seeInDatabase('a_obtenu', array(
                'id_diplome' => $id_diplome,
                'id_intervenant' => $id_intervenant,
            ));
        }

        foreach ($settings as $setting) {
            $this->tester->seeInDatabase('user_settings', array(
                'id_user' => $id_user,
                'id_setting' => $setting['id_setting'],
                'valeur' => $setting['valeur'],
            ));
        }

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateSuperviseurNomOk()
    {
        // obligatoire
        $id_user = "9";
        $role_user_ids = ["7"];
        $id_territoire = "6";
        $fonction = "Conseiller sport";
        $nom = "testsuperviseurnom";
        $prenom = "prenom";
        $email = "testSuperviseurNom@sportsante86.fr";
        $id_structure = "1";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
            'id_structure' => $id_structure,
            'nom_fonction' => $fonction,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => $fonction,
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateSuperviseurFonctionOk()
    {
        // obligatoire
        $id_user = "9";
        $role_user_ids = ["7"];
        $id_territoire = "6";
        $fonction = "Conseiller sportif";
        $nom = "testsuperviseurnom";
        $prenom = "nom";
        $email = "testSuperviseurNom@sportsante86.fr";
        $id_structure = "1";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
            'id_structure' => $id_structure,
            'nom_fonction' => $fonction,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => $fonction,
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkAdminToCoordonateur()
    {
        // obligatoire
        $id_user = "1";
        $role_user_ids = ["2"];
        $id_territoire = "6";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "TestAdmin@sportsante86.fr";
        $id_structure = "1";

        // optionnel
        $is_mdp_modified = true;
        $mdp = "GyHfds@8765dfg";
        $tel_f_user = "0787654554";
        $tel_p_user = "0123454343";
        $settings = [
            [
                'id_setting' => '1',
                'valeur' => '50',
            ]
        ];
        $est_coordinateur_peps = true;

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,
            'is_mdp_modified' => $is_mdp_modified,
            'mdp' => $mdp,
            'tel_f_user' => $tel_f_user,
            'tel_p_user' => $tel_p_user,
            'settings' => $settings,

            'est_coordinateur_peps' => $est_coordinateur_peps
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_p_user,
            'tel_fixe_coordonnees' => $tel_f_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "1",
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($settings as $setting) {
            $this->tester->seeInDatabase('user_settings', array(
                'id_user' => $id_user,
                'id_setting' => $setting['id_setting'],
                'valeur' => $setting['valeur'],
            ));
        }

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateSuperviseurToCoordinateurOk()
    {
        // obligatoire
        $id_user = "9";
        $role_user_ids = ["2"];
        $id_territoire = "7";
        $nom = "testsuperviseurnom";
        $prenom = "nom";
        $email = "testSuperviseurNom@sportsante86.fr";
        $id_structure = "1";

        $est_coordinateur_peps = true;

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,

            'est_coordinateur_peps' => $est_coordinateur_peps,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "1",
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkCoordonateurToIntervenant()
    {
        // obligatoire
        $id_user = "2";
        $role_user_ids = ["3"];
        $id_territoire = "2";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "testcoord1@sportsante86.fr";
        $id_structure = "1";

        // optionnel
        $is_mdp_modified = true;
        $mdp = "GyHfds@8765dfg";
        $tel_f_user = "0787654554";
        $tel_p_user = "0123454343";
        $settings = [
            [
                'id_setting' => '1',
                'valeur' => '50',
            ]
        ];

        $diplomes = ["5", "6", "7"];
        $id_statut_intervenant = "2";
        $numero_carte = "K98756";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,
            'is_mdp_modified' => $is_mdp_modified,
            'mdp' => $mdp,
            'tel_f_user' => $tel_f_user,
            'tel_p_user' => $tel_p_user,
            'settings' => $settings,

            'id_statut_intervenant' => $id_statut_intervenant,
            'diplomes' => $diplomes,
            'numero_carte' => $numero_carte,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $id_intervenant = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_intervenant',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'id_intervenant' => $id_intervenant,
            'tel_portable_coordonnees' => $tel_p_user,
            'tel_fixe_coordonnees' => $tel_f_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        $this->tester->seeInDatabase('intervenants', array(
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => $numero_carte,
        ));

        foreach ($diplomes as $id_diplome) {
            $this->tester->seeInDatabase('a_obtenu', array(
                'id_diplome' => $id_diplome,
                'id_intervenant' => $id_intervenant,
            ));
        }

        foreach ($settings as $setting) {
            $this->tester->seeInDatabase('user_settings', array(
                'id_user' => $id_user,
                'id_setting' => $setting['id_setting'],
                'valeur' => $setting['valeur'],
            ));
        }

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateCoordinateurToSuperviseurOk()
    {
        // obligatoire
        $id_user = "11";
        $role_user_ids = ["7"];
        $id_territoire = "4";
        $nom = "testSupCoord";
        $prenom = "test";
        $email = "testsupcoord@sportsante86.fr";
        $id_structure = "1";

        $fonction = "Conseiller Sportif";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
            'id_structure' => $id_structure,
            'nom_fonction' => $fonction,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => $fonction,
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkIntervenantToReferent()
    {
        // obligatoire
        $id_user = "5";
        $role_user_ids = ["4"];
        $id_territoire = "2";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "testIntervenantSansCreneauxNom@sportsante86.fr";
        $id_structure = "1";

        // optionnel
        $is_mdp_modified = true;
        $mdp = "GyHfds@8765dfg";
        $tel_f_user = "0787654554";
        $tel_p_user = "0123454343";
        $settings = [
            [
                'id_setting' => '1',
                'valeur' => '50',
            ]
        ];

        // données connues
        $id_intervenant = "10";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,
            'is_mdp_modified' => $is_mdp_modified,
            'mdp' => $mdp,
            'tel_f_user' => $tel_f_user,
            'tel_p_user' => $tel_p_user,
            'settings' => $settings,
        ]);

        $this->assertTrue($update_ok, $this->user->getErrorMessage());

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_p_user,
            'tel_fixe_coordonnees' => $tel_f_user,
        ));

        $this->tester->dontSeeInDatabase('coordonnees', array(
            'id_user' => $id_user,
            'id_intervenant' => $id_intervenant,
        ));

        $this->tester->dontSeeInDatabase('intervenants', array(
            'id_intervenant' => $id_intervenant,
        ));

        $this->tester->dontSeeInDatabase('a_obtenu', array(
            'id_intervenant' => $id_intervenant,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($settings as $setting) {
            $this->tester->seeInDatabase('user_settings', array(
                'id_user' => $id_user,
                'id_setting' => $setting['id_setting'],
                'valeur' => $setting['valeur'],
            ));
        }

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkReferentToEvaluateur()
    {
        // obligatoire
        $id_user = "6";
        $role_user_ids = ["5"];
        $id_territoire = "3";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "testReferentNom@sportsante86.fr";
        $id_structure = "1";

        // optionnel
        $is_mdp_modified = true;
        $mdp = "GyHfds@8765dfg";
        $tel_f_user = "0787654554";
        $tel_p_user = "0123454343";
        $settings = [
            [
                'id_setting' => '1',
                'valeur' => '50',
            ]
        ];

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,
            'is_mdp_modified' => $is_mdp_modified,
            'mdp' => $mdp,
            'tel_f_user' => $tel_f_user,
            'tel_p_user' => $tel_p_user,
            'settings' => $settings,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_p_user,
            'tel_fixe_coordonnees' => $tel_f_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($settings as $setting) {
            $this->tester->seeInDatabase('user_settings', array(
                'id_user' => $id_user,
                'id_setting' => $setting['id_setting'],
                'valeur' => $setting['valeur'],
            ));
        }

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkEvaluateurToResponsableStructure()
    {
        // obligatoire
        $id_user = "7";
        $role_user_ids = ["6"];
        $id_territoire = "4";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "testEvaluateurNom@sportsante86.fr";
        $id_structure = "1";

        // optionnel
        $is_mdp_modified = true;
        $mdp = "GyHfds@8765dfg";
        $tel_f_user = "0787654554";
        $tel_p_user = "0123454343";
        $settings = [
            [
                'id_setting' => '1',
                'valeur' => '50',
            ]
        ];

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,
            'is_mdp_modified' => $is_mdp_modified,
            'mdp' => $mdp,
            'tel_f_user' => $tel_f_user,
            'tel_p_user' => $tel_p_user,
            'settings' => $settings,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_p_user,
            'tel_fixe_coordonnees' => $tel_f_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($settings as $setting) {
            $this->tester->seeInDatabase('user_settings', array(
                'id_user' => $id_user,
                'id_setting' => $setting['id_setting'],
                'valeur' => $setting['valeur'],
            ));
        }

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateOkResponsableStructureToAdmin()
    {
        // obligatoire
        $id_user = "8";
        $role_user_ids = ["1"];
        $id_territoire = "4";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "testResponsableStructureNom@sportsante86.fr";
        $id_structure = "1";

        // optionnel
        $is_mdp_modified = true;
        $mdp = "GyHfds@8765dfg";
        $tel_f_user = "0787654554";
        $tel_p_user = "0123454343";
        $settings = [
            [
                'id_setting' => '1',
                'valeur' => '50',
            ]
        ];

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,

            'id_structure' => $id_structure,
            'is_mdp_modified' => $is_mdp_modified,
            'mdp' => $mdp,
            'tel_f_user' => $tel_f_user,
            'tel_p_user' => $tel_p_user,
            'settings' => $settings,
        ]);

        $this->assertTrue($update_ok);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'users',
            'id_coordonnees',
            array('id_user' => $id_user)
        );

        $this->tester->seeInDatabase('coordonnees', array(
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'mail_coordonnees' => $email,
            'id_user' => $id_user,
            'tel_portable_coordonnees' => $tel_p_user,
            'tel_fixe_coordonnees' => $tel_f_user,
        ));

        $this->tester->seeInDatabase('users', array(
            'id_user' => $id_user,
            'identifiant' => $email,
            'pswd' => password_verify($mdp, PASSWORD_DEFAULT),
            'id_coordonnees' => $id_coordonnees,
            'id_structure' => $id_structure,
            'id_territoire' => $id_territoire,
            'fonction' => null, // valeur par défaut
            'est_coordinateur_peps' => "0", // valeur par défaut
            'is_deactivated' => null,  // valeur par défaut
        ));

        foreach ($settings as $setting) {
            $this->tester->seeInDatabase('user_settings', array(
                'id_user' => $id_user,
                'id_setting' => $setting['id_setting'],
                'valeur' => $setting['valeur'],
            ));
        }

        foreach ($role_user_ids as $id_role_user) {
            $this->tester->seeInDatabase('a_role', array(
                'id_user' => $id_user,
                'id_role_user' => $id_role_user,
            ));
        }
    }

    public function testUpdateNotOkId_userNull()
    {
        // obligatoire
        $id_user = null;
        $role_user_ids = ["1"];
        $id_territoire = "3";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "zergzegrtgerg@sportsante86.fr";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_userInvalid()
    {
        // obligatoire
        $id_user = "-1";
        $role_user_ids = ["1"];
        $id_territoire = "3";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "zergzegrtgerg@sportsante86.fr";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_territoireNull()
    {
        // obligatoire
        $id_user = "1";
        $role_user_ids = ["1"];
        $id_territoire = null;
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "zergzegrtgerg@sportsante86.fr";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkRole_user_idsEmpty()
    {
        // obligatoire
        $id_user = "1";
        $role_user_ids = [];
        $id_territoire = "1";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = "zergzegrtgerg@sportsante86.fr";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkNomNull()
    {
        // obligatoire
        $id_user = "1";
        $role_user_ids = ["1"];
        $id_territoire = "1";
        $nom = null;
        $prenom = "Vefd";
        $email = "zergzegrtgerg@sportsante86.fr";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkPrenomNull()
    {
        // obligatoire
        $id_user = "1";
        $role_user_ids = ["1"];
        $id_territoire = "1";
        $nom = "Bego";
        $prenom = null;
        $email = "zergzegrtgerg@sportsante86.fr";

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkEmailNull()
    {
        // obligatoire
        $id_user = "1";
        $role_user_ids = ["1"];
        $id_territoire = "1";
        $nom = "Bego";
        $prenom = "Vefd";
        $email = null;

        $update_ok = $this->user->update([
            'id_user' => $id_user,
            'nom_user' => $nom,
            'prenom_user' => $prenom,
            'email_user' => $email,
            'id_territoire' => $id_territoire,
            'role_user_ids' => $role_user_ids,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testReadAllOkAdmin()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_structure' => null,
            'id_territoire' => "1",
        ];

        $users = $this->user->readAll($session);
        $this->assertIsArray($users);

        $total_count = $this->tester->grabNumRecords('users');
        $this->assertCount($total_count, $users);

        $this->assertArrayHasKey('id_user', $users[1]);
        $this->assertArrayHasKey('prenom_user', $users[1]);
        $this->assertArrayHasKey('nom_user', $users[1]);
        $this->assertArrayHasKey('tel_f_user', $users[1]);
        $this->assertArrayHasKey('tel_p_user', $users[1]);
        $this->assertArrayHasKey('email_user', $users[1]);
        $this->assertArrayHasKey('role_user', $users[1]);
        $this->assertArrayHasKey('id_territoire', $users[1]);
        $this->assertArrayHasKey('nom_territoire', $users[1]);
        $this->assertArrayHasKey('id_intervenant', $users[1]);
        $this->assertArrayHasKey('numero_carte', $users[1]);
        $this->assertArrayHasKey('id_statut_intervenant', $users[1]);
        $this->assertArrayHasKey('diplomes', $users[1]);
    }

    public function testReadAllOkCoordonnateurPeps()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => '2',
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $users = $this->user->readAll($session);
        $this->assertIsArray($users);

        // 3 admins + 4 dans autre territoire
        //$expected_count = 25 - 3 - 4;
        $expected_count = $this->tester->grabNumUsers([
            'id_territoire' => $session['id_territoire'],
            'not_id_role_user_1' => "1"
        ]);
        $this->assertCount($expected_count, $users);
    }

    public function testReadAllOkCoordonnateurNonMss()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '3',
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $users = $this->user->readAll($session);
        $this->assertIsArray($users);

        $expected_count = $this->tester->grabNumUsers([
            'id_structure' => $session['id_structure'],
            'not_id_role_user_1' => "1"
        ]);
        $this->assertCount($expected_count, $users);
    }

    public function testReadAllOkCoordonnateurMss()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '1', // MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $users = $this->user->readAll($session);
        $this->assertIsArray($users);

        $expected_count = $this->tester->grabNumUsers([
            'id_structure' => $session['id_structure'],
            'not_id_role_user_1' => "1"
        ]);
        $this->assertCount($expected_count, $users);
    }

    public function testReadAllOkIntervenant()
    {
        $session = [
            'role_user_ids' => ['3'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '3',
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $users = $this->user->readAll($session);
        $this->assertIsArray($users);
        $this->assertEmpty($users);
    }

    public function testReadAllOkReferent()
    {
        $session = [
            'role_user_ids' => ['4'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '3',
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $users = $this->user->readAll($session);
        $this->assertIsArray($users);
        $this->assertEmpty($users);
    }

    public function testReadAllOkEvaluateur()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '3',
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $users = $this->user->readAll($session);
        $this->assertIsArray($users);

        $expected_count = $this->tester->grabNumUsers([
            'id_structure' => $session['id_structure'],
            'not_id_role_user_1' => "1"
        ]);
        $this->assertCount($expected_count, $users);
    }

    public function testReadAllOkResponsableStructure()
    {
        $session = [
            'role_user_ids' => ['6'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '2',
            'id_structure' => '1', // STRUCT TEST 1
            'id_territoire' => "1",
        ];

        $users = $this->user->readAll($session);
        $this->assertIsArray($users);

        // 5 intervenants + 2 Responsable Structure dans STRUCT TEST 1
        $expected_count = 7;
        $this->assertCount($expected_count, $users);
    }

    public function testReadAllNotOkEmptySession()
    {
        $session = [];

        $users = $this->user->readAll($session);
        $this->assertFalse($users);
    }

    public function testReadAllEvaluateurOkAdmin()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_structure' => null,
            'id_territoire' => "1",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);

        // 2 evaluateur + 5 coordo
        $expected_count = 2 + 5;
        $this->assertCount($expected_count, $evaluateur);

        $this->assertArrayHasKey('id_user', $evaluateur[0]);
        $this->assertArrayHasKey('nom_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('prenom_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('structure_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('role_user', $evaluateur[0]);
    }

    public function testReadAllEvaluateurOkCoordonateurPepsId_territoire1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "1",
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);

        // 2 evaluateurs (dans id_territoire=1) + 5 coordos (dans id_territoire=1)
        $expected_count = 2 + 5;
        $this->assertCount($expected_count, $evaluateur);

        $this->assertArrayHasKey('id_user', $evaluateur[0]);
        $this->assertArrayHasKey('nom_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('prenom_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('structure_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('role_user', $evaluateur[0]);
    }

    public function testReadAllEvaluateurOkCoordonateurPepsId_territoire2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "1",
            'id_structure' => "1",
            'id_territoire' => "2",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);

        // 0 evaluateur (dans id_territoire=2) + 0 coordo (dans id_territoire=2)
        $expected_count = 0;
        $this->assertCount($expected_count, $evaluateur);
    }

    public function testReadAllEvaluateurOkCoordonateurMSSId_territoire1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);

        // 1 evaluateurs (dans id_territoire=1 et id_structure=1) + 5 coordos (dans id_territoire=1)
        $expected_count = 1 + 5;
        $this->assertCount($expected_count, $evaluateur);

        $this->assertArrayHasKey('id_user', $evaluateur[0]);
        $this->assertArrayHasKey('nom_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('prenom_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('structure_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('role_user', $evaluateur[0]);
    }

    public function testReadAllEvaluateurOkCoordonateurMSSId_territoire2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_structure' => "1",
            'id_territoire' => "2",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);

        // 0 evaluateur (dans id_territoire=2 et id_structure=1) + 0 coordo (dans id_territoire=2)
        $expected_count = 0;
        $this->assertCount($expected_count, $evaluateur);
    }

    public function testReadAllEvaluateurOkCoordonateurNonMSSId_territoire1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);

        // 1 evaluateurs (dans id_territoire=1 et id_structure=1) + 5 coordos (dans id_territoire=1)
        $expected_count = 1 + 5;
        $this->assertCount($expected_count, $evaluateur);

        $this->assertArrayHasKey('id_user', $evaluateur[0]);
        $this->assertArrayHasKey('nom_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('prenom_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('structure_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('role_user', $evaluateur[0]);
    }

    public function testReadAllEvaluateurOkCoordonateurNonMSSId_territoire2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "2",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);

        // 0 evaluateur (dans id_territoire=2 et id_structure=1) + 0 coordo (dans id_territoire=2)
        $expected_count = 0;
        $this->assertCount($expected_count, $evaluateur);
    }

    public function testReadAllEvaluateurOkSecretaireId_territoire1()
    {
        $session = [
            'role_user_ids' => ['8'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);

        // 1 evaluateurs (dans id_territoire=1 et id_structure=1) + 5 coordos (dans id_territoire=1)
        $expected_count = 1 + 5;
        $this->assertCount($expected_count, $evaluateur);

        $this->assertArrayHasKey('id_user', $evaluateur[0]);
        $this->assertArrayHasKey('nom_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('prenom_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('structure_evaluateur', $evaluateur[0]);
        $this->assertArrayHasKey('role_user', $evaluateur[0]);
    }

    public function testReadAllEvaluateurOkSecretaireId_territoire2()
    {
        $session = [
            'role_user_ids' => ['8'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "2",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);

        // 0 evaluateur (dans id_territoire=2 et id_structure=1) + 0 coordo (dans id_territoire=2)
        $expected_count = 0;
        $this->assertCount($expected_count, $evaluateur);
    }

    public function testReadAllEvaluateurOkIntervenant()
    {
        $session = [
            'role_user_ids' => ['3'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);
        $this->assertEmpty($evaluateur);
    }

    public function testReadAllEvaluateurNotOkReferent()
    {
        $session = [
            'role_user_ids' => ['4'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);
        $this->assertEmpty($evaluateur);
    }

    public function testReadAllEvaluateurNotOkEvaluateur()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);
        $this->assertEmpty($evaluateur);
    }

    public function testReadAllEvaluateurNotOkResponsableStructure()
    {
        $session = [
            'role_user_ids' => ['6'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);
        $this->assertEmpty($evaluateur);
    }

    public function testReadAllEvaluateurNotOkSuperviseurPeps()
    {
        $session = [
            'role_user_ids' => ['7'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $evaluateur = $this->user->readAllEvaluateur($session);
        $this->assertIsArray($evaluateur);
        $this->assertEmpty($evaluateur);
    }

    public function testReadAllCoordosPEPSOk()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "2",
            'id_territoire' => "1"
        ];

        $coordos_peps = $this->user->readAllCoordosPEPS($session);
        $this->assertIsArray($coordos_peps);

        //deux coordos peps (id_patient 2 et 11)
        $expected_count = 2;
        $this->assertCount($expected_count, $coordos_peps);
    }

    public function testReadAllCoordosPEPSNotOkId_TerritoireMissing()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "2",
            'id_territoire' => null
        ];

        $coordos_peps = $this->user->readAllCoordosPEPS($session);
        $this->assertFalse($coordos_peps);
    }

    public function testReadOneOkAdminWithoutStructure()
    {
        $id_user = "10";

        $user = $this->user->readOne($id_user);
        $this->assertIsArray($user);

        $this->assertArrayHasKey('id_user', $user);
        $this->assertArrayHasKey('id_territoire', $user);
        $this->assertArrayHasKey('nom_user', $user);
        $this->assertArrayHasKey('prenom_user', $user);
        $this->assertArrayHasKey('tel_f_user', $user);
        $this->assertArrayHasKey('tel_p_user', $user);
        $this->assertArrayHasKey('email_user', $user);
        $this->assertArrayHasKey('role_user', $user);
        $this->assertArrayHasKey('role_user_ids', $user);
        $this->assertEqualsCanonicalizing(['1'], $user['role_user_ids']);
        $this->assertArrayHasKey('nom_territoire', $user);
        $this->assertArrayHasKey('est_coordinateur_peps', $user);
        $this->assertArrayHasKey('nom_fonction', $user);
        $this->assertArrayHasKey('id_intervenant', $user);
        $this->assertArrayHasKey('numero_carte', $user);
        $this->assertArrayHasKey('id_statut_intervenant', $user);
        $this->assertArrayHasKey('diplomes', $user);
        $this->assertArrayHasKey('is_deactivated', $user);

        $this->assertArrayHasKey('settings', $user);
        $this->assertIsArray($user['settings']);
        if (!empty($user['settings'])) {
            $this->assertArrayHasKey('id_user_setting', $user['settings'][0]);
            $this->assertArrayHasKey('id_setting', $user['settings'][0]);
            $this->assertArrayHasKey('nom', $user['settings'][0]);
            $this->assertArrayHasKey('valeur', $user['settings'][0]);
        }

        $this->assertArrayHasKey('structure', $user);
        $this->assertArrayHasKey('id_structure', $user['structure']);
        $this->assertArrayHasKey('nom_structure', $user['structure']);
        $this->assertArrayHasKey('nom_statut_structure', $user['structure']);
        $this->assertArrayHasKey('complement_adresse', $user['structure']);
        $this->assertArrayHasKey('nom_adresse', $user['structure']);
        $this->assertArrayHasKey('code_postal', $user['structure']);
        $this->assertArrayHasKey('nom_ville', $user['structure']);
    }

    public function testReadOneOkAdminWithStructure()
    {
        $id_user = "1";

        $user = $this->user->readOne($id_user);
        $this->assertIsArray($user);

        $this->assertArrayHasKey('id_user', $user);
        $this->assertArrayHasKey('id_territoire', $user);
        $this->assertArrayHasKey('nom_user', $user);
        $this->assertArrayHasKey('prenom_user', $user);
        $this->assertArrayHasKey('tel_f_user', $user);
        $this->assertArrayHasKey('tel_p_user', $user);
        $this->assertArrayHasKey('email_user', $user);
        $this->assertArrayHasKey('role_user', $user);
        $this->assertArrayHasKey('role_user_ids', $user);
        $this->assertEqualsCanonicalizing(['1'], $user['role_user_ids']);
        $this->assertArrayHasKey('nom_territoire', $user);
        $this->assertArrayHasKey('est_coordinateur_peps', $user);
        $this->assertArrayHasKey('nom_fonction', $user);
        $this->assertArrayHasKey('id_intervenant', $user);
        $this->assertArrayHasKey('numero_carte', $user);
        $this->assertArrayHasKey('id_statut_intervenant', $user);
        $this->assertArrayHasKey('diplomes', $user);
        $this->assertArrayHasKey('is_deactivated', $user);

        $this->assertArrayHasKey('settings', $user);
        $this->assertIsArray($user['settings']);
        if (!empty($user['settings'])) {
            $this->assertArrayHasKey('id_user_setting', $user['settings'][0]);
            $this->assertArrayHasKey('id_setting', $user['settings'][0]);
            $this->assertArrayHasKey('nom', $user['settings'][0]);
            $this->assertArrayHasKey('valeur', $user['settings'][0]);
        }

        $this->assertArrayHasKey('structure', $user);
        $this->assertArrayHasKey('id_structure', $user['structure']);
        $this->assertArrayHasKey('nom_structure', $user['structure']);
        $this->assertArrayHasKey('nom_statut_structure', $user['structure']);
        $this->assertArrayHasKey('complement_adresse', $user['structure']);
        $this->assertArrayHasKey('nom_adresse', $user['structure']);
        $this->assertArrayHasKey('code_postal', $user['structure']);
        $this->assertArrayHasKey('nom_ville', $user['structure']);
    }

    public function testReadOneOkCoordonnateur()
    {
        $id_user = "2";

        $user = $this->user->readOne($id_user);
        $this->assertIsArray($user);

        $this->assertArrayHasKey('id_user', $user);
        $this->assertArrayHasKey('id_territoire', $user);
        $this->assertArrayHasKey('nom_user', $user);
        $this->assertArrayHasKey('prenom_user', $user);
        $this->assertArrayHasKey('tel_f_user', $user);
        $this->assertArrayHasKey('tel_p_user', $user);
        $this->assertArrayHasKey('email_user', $user);
        $this->assertArrayHasKey('role_user', $user);
        $this->assertArrayHasKey('role_user_ids', $user);
        $this->assertEqualsCanonicalizing(['2'], $user['role_user_ids']);
        $this->assertArrayHasKey('nom_territoire', $user);
        $this->assertArrayHasKey('est_coordinateur_peps', $user);
        $this->assertArrayHasKey('nom_fonction', $user);
        $this->assertArrayHasKey('id_intervenant', $user);
        $this->assertArrayHasKey('numero_carte', $user);
        $this->assertArrayHasKey('id_statut_intervenant', $user);
        $this->assertArrayHasKey('diplomes', $user);
        $this->assertArrayHasKey('is_deactivated', $user);

        $this->assertArrayHasKey('settings', $user);
        $this->assertIsArray($user['settings']);
        if (!empty($user['settings'])) {
            $this->assertArrayHasKey('id_user_setting', $user['settings'][0]);
            $this->assertArrayHasKey('id_setting', $user['settings'][0]);
            $this->assertArrayHasKey('nom', $user['settings'][0]);
            $this->assertArrayHasKey('valeur', $user['settings'][0]);
        }

        $this->assertArrayHasKey('structure', $user);
        $this->assertArrayHasKey('id_structure', $user['structure']);
        $this->assertArrayHasKey('nom_structure', $user['structure']);
        $this->assertArrayHasKey('nom_statut_structure', $user['structure']);
        $this->assertArrayHasKey('complement_adresse', $user['structure']);
        $this->assertArrayHasKey('nom_adresse', $user['structure']);
        $this->assertArrayHasKey('code_postal', $user['structure']);
        $this->assertArrayHasKey('nom_ville', $user['structure']);
    }

    public function testReadOneOkIntervenant()
    {
        $id_user = "3";

        $user = $this->user->readOne($id_user);
        $this->assertIsArray($user);

        $this->assertArrayHasKey('id_user', $user);
        $this->assertArrayHasKey('id_territoire', $user);
        $this->assertArrayHasKey('nom_user', $user);
        $this->assertArrayHasKey('prenom_user', $user);
        $this->assertArrayHasKey('tel_f_user', $user);
        $this->assertArrayHasKey('tel_p_user', $user);
        $this->assertArrayHasKey('email_user', $user);
        $this->assertArrayHasKey('role_user', $user);
        $this->assertArrayHasKey('role_user_ids', $user);
        $this->assertEqualsCanonicalizing(['3'], $user['role_user_ids']);
        $this->assertArrayHasKey('nom_territoire', $user);
        $this->assertArrayHasKey('est_coordinateur_peps', $user);
        $this->assertArrayHasKey('nom_fonction', $user);
        $this->assertArrayHasKey('id_intervenant', $user);
        $this->assertArrayHasKey('numero_carte', $user);
        $this->assertArrayHasKey('id_statut_intervenant', $user);
        $this->assertArrayHasKey('diplomes', $user);
        $this->assertArrayHasKey('is_deactivated', $user);

        $this->assertArrayHasKey('settings', $user);
        $this->assertIsArray($user['settings']);
        if (!empty($user['settings'])) {
            $this->assertArrayHasKey('id_user_setting', $user['settings'][0]);
            $this->assertArrayHasKey('id_setting', $user['settings'][0]);
            $this->assertArrayHasKey('nom', $user['settings'][0]);
            $this->assertArrayHasKey('valeur', $user['settings'][0]);
        }

        $this->assertArrayHasKey('structure', $user);
        $this->assertArrayHasKey('id_structure', $user['structure']);
        $this->assertArrayHasKey('nom_structure', $user['structure']);
        $this->assertArrayHasKey('nom_statut_structure', $user['structure']);
        $this->assertArrayHasKey('complement_adresse', $user['structure']);
        $this->assertArrayHasKey('nom_adresse', $user['structure']);
        $this->assertArrayHasKey('code_postal', $user['structure']);
        $this->assertArrayHasKey('nom_ville', $user['structure']);
    }

    public function testReadOneOkReferent()
    {
        $id_user = "6";

        $user = $this->user->readOne($id_user);
        $this->assertIsArray($user);

        $this->assertArrayHasKey('id_user', $user);
        $this->assertArrayHasKey('id_territoire', $user);
        $this->assertArrayHasKey('nom_user', $user);
        $this->assertArrayHasKey('prenom_user', $user);
        $this->assertArrayHasKey('tel_f_user', $user);
        $this->assertArrayHasKey('tel_p_user', $user);
        $this->assertArrayHasKey('email_user', $user);
        $this->assertArrayHasKey('role_user', $user);
        $this->assertArrayHasKey('role_user_ids', $user);
        $this->assertEqualsCanonicalizing(['4'], $user['role_user_ids']);
        $this->assertArrayHasKey('nom_territoire', $user);
        $this->assertArrayHasKey('est_coordinateur_peps', $user);
        $this->assertArrayHasKey('nom_fonction', $user);
        $this->assertArrayHasKey('id_intervenant', $user);
        $this->assertArrayHasKey('numero_carte', $user);
        $this->assertArrayHasKey('id_statut_intervenant', $user);
        $this->assertArrayHasKey('diplomes', $user);
        $this->assertArrayHasKey('is_deactivated', $user);

        $this->assertArrayHasKey('settings', $user);
        $this->assertIsArray($user['settings']);
        if (!empty($user['settings'])) {
            $this->assertArrayHasKey('id_user_setting', $user['settings'][0]);
            $this->assertArrayHasKey('id_setting', $user['settings'][0]);
            $this->assertArrayHasKey('nom', $user['settings'][0]);
            $this->assertArrayHasKey('valeur', $user['settings'][0]);
        }

        $this->assertArrayHasKey('structure', $user);
        $this->assertArrayHasKey('id_structure', $user['structure']);
        $this->assertArrayHasKey('nom_structure', $user['structure']);
        $this->assertArrayHasKey('nom_statut_structure', $user['structure']);
        $this->assertArrayHasKey('complement_adresse', $user['structure']);
        $this->assertArrayHasKey('nom_adresse', $user['structure']);
        $this->assertArrayHasKey('code_postal', $user['structure']);
        $this->assertArrayHasKey('nom_ville', $user['structure']);
    }

    public function testReadOneOkEvaluateur()
    {
        $id_user = "7";

        $user = $this->user->readOne($id_user);
        $this->assertIsArray($user);

        $this->assertArrayHasKey('id_user', $user);
        $this->assertArrayHasKey('id_territoire', $user);
        $this->assertArrayHasKey('nom_user', $user);
        $this->assertArrayHasKey('prenom_user', $user);
        $this->assertArrayHasKey('tel_f_user', $user);
        $this->assertArrayHasKey('tel_p_user', $user);
        $this->assertArrayHasKey('email_user', $user);
        $this->assertArrayHasKey('role_user', $user);
        $this->assertArrayHasKey('role_user_ids', $user);
        $this->assertEqualsCanonicalizing(['5'], $user['role_user_ids']);
        $this->assertArrayHasKey('nom_territoire', $user);
        $this->assertArrayHasKey('est_coordinateur_peps', $user);
        $this->assertArrayHasKey('nom_fonction', $user);
        $this->assertArrayHasKey('id_intervenant', $user);
        $this->assertArrayHasKey('numero_carte', $user);
        $this->assertArrayHasKey('id_statut_intervenant', $user);
        $this->assertArrayHasKey('diplomes', $user);
        $this->assertArrayHasKey('is_deactivated', $user);

        $this->assertArrayHasKey('settings', $user);
        $this->assertIsArray($user['settings']);
        if (!empty($user['settings'])) {
            $this->assertArrayHasKey('id_user_setting', $user['settings'][0]);
            $this->assertArrayHasKey('id_setting', $user['settings'][0]);
            $this->assertArrayHasKey('nom', $user['settings'][0]);
            $this->assertArrayHasKey('valeur', $user['settings'][0]);
        }

        $this->assertArrayHasKey('structure', $user);
        $this->assertArrayHasKey('id_structure', $user['structure']);
        $this->assertArrayHasKey('nom_structure', $user['structure']);
        $this->assertArrayHasKey('nom_statut_structure', $user['structure']);
        $this->assertArrayHasKey('complement_adresse', $user['structure']);
        $this->assertArrayHasKey('nom_adresse', $user['structure']);
        $this->assertArrayHasKey('code_postal', $user['structure']);
        $this->assertArrayHasKey('nom_ville', $user['structure']);
    }

    public function testReadOneOkResponsableStructure()
    {
        $id_user = "8";

        $user = $this->user->readOne($id_user);
        $this->assertIsArray($user);

        $this->assertArrayHasKey('id_user', $user);
        $this->assertArrayHasKey('id_territoire', $user);
        $this->assertArrayHasKey('nom_user', $user);
        $this->assertArrayHasKey('prenom_user', $user);
        $this->assertArrayHasKey('tel_f_user', $user);
        $this->assertArrayHasKey('tel_p_user', $user);
        $this->assertArrayHasKey('email_user', $user);
        $this->assertArrayHasKey('role_user', $user);
        $this->assertArrayHasKey('role_user_ids', $user);
        $this->assertEqualsCanonicalizing(['6'], $user['role_user_ids']);
        $this->assertArrayHasKey('nom_territoire', $user);
        $this->assertArrayHasKey('est_coordinateur_peps', $user);
        $this->assertArrayHasKey('nom_fonction', $user);
        $this->assertArrayHasKey('id_intervenant', $user);
        $this->assertArrayHasKey('numero_carte', $user);
        $this->assertArrayHasKey('id_statut_intervenant', $user);
        $this->assertArrayHasKey('diplomes', $user);
        $this->assertArrayHasKey('is_deactivated', $user);

        $this->assertArrayHasKey('settings', $user);
        $this->assertIsArray($user['settings']);
        if (!empty($user['settings'])) {
            $this->assertArrayHasKey('id_user_setting', $user['settings'][0]);
            $this->assertArrayHasKey('id_setting', $user['settings'][0]);
            $this->assertArrayHasKey('nom', $user['settings'][0]);
            $this->assertArrayHasKey('valeur', $user['settings'][0]);
        }

        $this->assertArrayHasKey('structure', $user);
        $this->assertArrayHasKey('id_structure', $user['structure']);
        $this->assertArrayHasKey('nom_structure', $user['structure']);
        $this->assertArrayHasKey('nom_statut_structure', $user['structure']);
        $this->assertArrayHasKey('complement_adresse', $user['structure']);
        $this->assertArrayHasKey('nom_adresse', $user['structure']);
        $this->assertArrayHasKey('code_postal', $user['structure']);
        $this->assertArrayHasKey('nom_ville', $user['structure']);
    }

    public function testReadOneOkSuperviseur()
    {
        $id_user = "9";

        $user = $this->user->readOne($id_user);
        $this->assertIsArray($user);

        $this->assertArrayHasKey('id_user', $user);
        $this->assertArrayHasKey('id_territoire', $user);
        $this->assertArrayHasKey('nom_user', $user);
        $this->assertArrayHasKey('prenom_user', $user);
        $this->assertArrayHasKey('tel_f_user', $user);
        $this->assertArrayHasKey('tel_p_user', $user);
        $this->assertArrayHasKey('email_user', $user);
        $this->assertArrayHasKey('role_user', $user);
        $this->assertArrayHasKey('role_user_ids', $user);
        $this->assertEqualsCanonicalizing(['7'], $user['role_user_ids']);
        $this->assertArrayHasKey('nom_territoire', $user);
        $this->assertArrayHasKey('est_coordinateur_peps', $user);
        $this->assertArrayHasKey('nom_fonction', $user);
        $this->assertArrayHasKey('id_intervenant', $user);
        $this->assertArrayHasKey('numero_carte', $user);
        $this->assertArrayHasKey('id_statut_intervenant', $user);
        $this->assertArrayHasKey('diplomes', $user);
        $this->assertArrayHasKey('is_deactivated', $user);

        $this->assertArrayHasKey('settings', $user);
        $this->assertIsArray($user['settings']);
        if (!empty($user['settings'])) {
            $this->assertArrayHasKey('id_user_setting', $user['settings'][0]);
            $this->assertArrayHasKey('id_setting', $user['settings'][0]);
            $this->assertArrayHasKey('nom', $user['settings'][0]);
            $this->assertArrayHasKey('valeur', $user['settings'][0]);
        }

        $this->assertArrayHasKey('structure', $user);
        $this->assertArrayHasKey('id_structure', $user['structure']);
        $this->assertArrayHasKey('nom_structure', $user['structure']);
        $this->assertArrayHasKey('nom_statut_structure', $user['structure']);
        $this->assertArrayHasKey('complement_adresse', $user['structure']);
        $this->assertArrayHasKey('nom_adresse', $user['structure']);
        $this->assertArrayHasKey('code_postal', $user['structure']);
        $this->assertArrayHasKey('nom_ville', $user['structure']);
    }

    public function testReadOneNotOkId_userNull()
    {
        $id_user = null;

        $user = $this->user->readOne($id_user);
        $this->assertFalse($user);
    }

    public function testReadOneNotOkId_userInvalid()
    {
        $id_user = "-1";

        $user = $this->user->readOne($id_user);
        $this->assertFalse($user);
    }

    public function testGetRolesNotOkId_userNull()
    {
        $id_user = null;

        $user = $this->user->getRoles($id_user);
        $this->assertFalse($user);
    }

    public function testGetRolesNotOkId_userInvalid()
    {
        $id_user = "-1";

        $user = $this->user->getRoles($id_user);
        $this->assertFalse($user);
    }

    public function testGetRolesOkAdmin()
    {
        $id_user = "1";

        $user = $this->user->getRoles($id_user);
        $this->assertIsString($user);
        $this->assertNotEmpty($user);
    }

    public function testGetRolesOkMultiRoles()
    {
        // TODO
//        $id_user = "1";
//
//        $user = $this->user->getRoles($id_user);
//        $this->assertIsString($user);
//        $this->assertNotEmpty($user);
    }
}
