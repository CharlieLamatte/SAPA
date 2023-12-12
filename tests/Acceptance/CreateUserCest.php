<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\Page\Acceptance\Login;
use Tests\Support\Page\Acceptance\User;

class CreateUserCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function createAdminAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("Jhoueudfefff"),
            'email' => ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("GyiudHG876@@@khgkv"),
            'id_territoire' => '2',
            'role_user_ids' => ['1'],

            'email_connected' => $email_connected
        ]);
    }

    public function createAdminAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("Jhoueudfefff"),
            'email' => ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("GyiudHG876@@@khgkv"),
            'id_territoire' => '2',
            'role_user_ids' => ['1'],
            'tel_fixe' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            'tel_portable' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'email_connected' => $email_connected
        ]);
    }

    public function createCoordonnateurPepsAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("Jhouefrfudfefff"),
            'email' => ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("GyiudHG876@@@khgkv"),
            'id_territoire' => '1',
            'role_user_ids' => ['2'],
            'est_coordonnateur_peps' => true,
            'structure' => "STRUCT TEST 1",

            'email_connected' => $email_connected
        ]);
    }

    public function createCoordonnateurPepsAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("Jhoueudfefff"),
            'email' => ChaineCharactere::str_shuffle_unicode("cohefoeifhooeuf") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("GyiudHG876@@@khgkv"),
            'id_territoire' => '1',
            'role_user_ids' => ['2'],
            'est_coordonnateur_peps' => true,
            'structure' => "STRUCT TEST 1",
            'tel_fixe' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            'tel_portable' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'email_connected' => $email_connected
        ]);
    }

    public function createCoordonnateurNonPepsAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("rfourfnvufrvrf"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("crfcfruorg"),
            'email' => ChaineCharactere::str_shuffle_unicode("defevfrfrhufrkhvOkljfhgjd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("GyiudHG876@@@khgkv"),
            'id_territoire' => '1',
            'role_user_ids' => ['2'],
            'est_coordonnateur_peps' => false,
            'structure' => "STRUCT TEST 1",

            'email_connected' => $email_connected
        ]);
    }

    public function createCoordonnateurNonPepsAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("nvohfevhrfvofr"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("bvcdhvbfvbrfu"),
            'email' => ChaineCharactere::str_shuffle_unicode("rojfvkkkrfjvrfjvrfv") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("GyirfvorfHGG876@@@khgkv"),
            'id_territoire' => '1',
            'role_user_ids' => ['2'],
            'est_coordonnateur_peps' => false,
            'structure' => "STRUCT TEST 1",
            'tel_fixe' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            'tel_portable' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'email_connected' => $email_connected
        ]);
    }

    public function createIntervenantAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("rfourfnvufrvrf"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("crfcfruorg"),
            'email' => ChaineCharactere::str_shuffle_unicode("defevfrfrhufrkhvOkljfhgjd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("GyiudHG876@@@khgkv"),
            'id_territoire' => '1',
            'role_user_ids' => ['3'],
            'structure' => "STRUCT TEST 1",
            'id_statut_intervenant' => "2",

            'email_connected' => $email_connected
        ]);
    }

    public function createIntervenantAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("rfourfnvufrvrf"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("crfcfruorg"),
            'email' => ChaineCharactere::str_shuffle_unicode("defevfrfrhufrkhvOkljfhgjd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("GyiudHG876@@@khgkv"),
            'id_territoire' => '1',
            'role_user_ids' => ['3'],
            'structure' => "STRUCT TEST 1",
            'id_statut_intervenant' => "2",
            'diplomes' => ["2", "3"],
            'numero_carte' => ChaineCharactere::str_shuffle_unicode("987HGFJG"),
            'tel_fixe' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            'tel_portable' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'email_connected' => $email_connected
        ]);
    }

    public function createReferentAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("ohhgvoruotefvzcdapx"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("ioghutoapmwlnkcnbvg"),
            'email' => ChaineCharactere::str_shuffle_unicode("mlkdhgmsjhdfbvyrtvcr") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("BGFtzk987hffdzfHGGF@@!@kjhfvfrd"),
            'id_territoire' => '1',
            'role_user_ids' => ['4'],
            'structure' => "STRUCT TEST 1",

            'email_connected' => $email_connected
        ]);
    }

    public function createReferentAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("ohhgvoruotefvzcdapx"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("ioghutoapmwlnkcnbvg"),
            'email' => ChaineCharactere::str_shuffle_unicode("mlkdhgmsjhdfbvyrtvcr") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("BGFtzkhffdzfHGGF!87@@kjhfv"),
            'id_territoire' => '1',
            'role_user_ids' => ['4'],
            'structure' => "STRUCT TEST 1",
            'tel_fixe' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            'tel_portable' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'email_connected' => $email_connected
        ]);
    }

    public function createEvaluateurAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("ohzfgeeaqwxszedc"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("ppplkhbcigdv"),
            'email' => ChaineCharactere::str_shuffle_unicode("poiuytaqwxcnbvpmljhffd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("VCXNB654j@@!@PMLkjd"),
            'id_territoire' => '1',
            'role_user_ids' => ['5'],
            'structure' => "STRUCT TEST 1",

            'email_connected' => $email_connected
        ]);
    }

    public function createEvaluateurAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("pouuzdiyxuzgvsx"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("oxnowqaxxzojncd"),
            'email' => ChaineCharactere::str_shuffle_unicode("ploihzuzgdiuyrtryzd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("VCXNB654j@@!@PMLkjd"),
            'id_territoire' => '1',
            'role_user_ids' => ['5'],
            'structure' => "STRUCT TEST 1",
            'tel_fixe' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            'tel_portable' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'email_connected' => $email_connected
        ]);
    }

    public function createResponsableStructureAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("mljsdfshjdfskdfqwxcbvhgn"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("ppplkhbcigdv"),
            'email' => ChaineCharactere::str_shuffle_unicode("pmmlkknncbgdvftwxd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("VCXNB654j@@!@PMLkjd"),
            'id_territoire' => '1',
            'role_user_ids' => ['6'],
            'structure' => "STRUCT TEST 1",

            'email_connected' => $email_connected
        ]);
    }

    public function createResponsableStructureAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("mljsdfshjdfskdfqwxcbvhgn"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("ppplkhbcigdv"),
            'email' => ChaineCharactere::str_shuffle_unicode("pmmlkknncbgdvftwxd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("VCXNB654j@@!@PMLkjd"),
            'id_territoire' => '1',
            'role_user_ids' => ['6'],
            'structure' => "STRUCT TEST 1",
            'tel_fixe' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            'tel_portable' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'email_connected' => $email_connected
        ]);
    }

    public function createSuperviseurPepsAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("waqwxzsxcdepokg"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("ppplkhbcigdv"),
            'email' => ChaineCharactere::str_shuffle_unicode("mplkkjhgnvbxwaqwszxcdevfrb") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("VCXNB654j@@!@PMLkjd"),
            'id_territoire' => '1',
            'role_user_ids' => ['7'],
            'structure' => "PARTENAIRE TEST",
            'fonction' => "Superviseur vienne",

            'email_connected' => $email_connected
        ]);
    }

    public function createSuperviseurPepsAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("waqwxzsxcdepokg"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("ppplkhbcigdv"),
            'email' => ChaineCharactere::str_shuffle_unicode("mplkkjhgnvbxwaqwszxcdevfrb") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("VCXNB654j@@!@PMLkjd"),
            'id_territoire' => '1',
            'role_user_ids' => ['7'],
            'structure' => "PARTENAIRE TEST",
            'fonction' => "Superviseur vienne",
            'tel_fixe' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            'tel_portable' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'email_connected' => $email_connected
        ]);
    }

    public function createCoordonnateurPepsAsCoordonnateurPepsMinData(
        AcceptanceTester $I,
        Login $loginPage,
        User $userPage
    ) {
        $email_connected = 'testcoord1@sportsante86.fr';

        $loginPage->login($email_connected, 'testcoord1.1@A');
        $userPage->create([
            'nom' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'prenom' => ChaineCharactere::str_shuffle_unicode("Jhouefrfudfefff"),
            'email' => ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd") . '@gmail.com',
            'mdp' => ChaineCharactere::str_shuffle_unicode("GyiudHG876@@@khgkv"),
            'id_territoire' => '2',
            'role_user_ids' => ['2'],
            'est_coordonnateur_peps' => true,
            'structure' => "STRUCT TEST 1",

            'email_connected' => $email_connected
        ]);
    }
}