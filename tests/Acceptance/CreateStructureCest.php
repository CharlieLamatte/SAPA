<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\Page\Acceptance\Login;
use Tests\Support\Page\Acceptance\Structure;

class CreateStructureCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function createStructureAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Structure $structurePage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $structurePage->create([
            'nom_structure' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'id_statut_structure' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd"),
            'code_postal' => "64000",
            'id_statut_juridique' => '1',
            'id_territoire' => '2',

            'email_connected' => $email_connected
        ]);
    }

    public function createStructureAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Structure $structurePage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $structurePage->create([
            'nom_structure' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'id_statut_structure' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd"),
            'code_postal' => "64000",
            'id_statut_juridique' => '1',
            'id_territoire' => '2',

            'complement_adresse' => ChaineCharactere::str_shuffle_unicode("jhbhb"),
            'intervenants' => ["TESTSUPINTERVENANT test"],
            'antennes' => [ChaineCharactere::str_shuffle_unicode("zevfv"), ChaineCharactere::str_shuffle_unicode("ykujkuk")],
            'lien_ref_structure' => "https://" . ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd"),
            'code_onaps' => ChaineCharactere::str_shuffle_unicode("jhbhb"),

            'nom_representant' => ChaineCharactere::str_shuffle_unicode("jhbhb"),
            'prenom_representant' => ChaineCharactere::str_shuffle_unicode("jhbhb"),
            'email' => ChaineCharactere::str_shuffle_unicode("vdvdffdv") . '@gmail.com',
            'tel_fixe' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            'tel_portable' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'email_connected' => $email_connected
        ]);
    }

    public function createStructureAsCoordonnateurPepsMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Structure $structurePage
    ) {
        $email_connected = 'testcoord1@sportsante86.fr';

        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $structurePage->create([
            'nom_structure' => ChaineCharactere::str_shuffle_unicode("ivcgzdfdecdzeyfdc"),
            'id_statut_structure' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd"),
            'code_postal' => "86100",
            'id_statut_juridique' => '1',
            'id_territoire' => '1',

            'email_connected' => $email_connected
        ]);
    }

    public function createStructureAsCoordonnateurPepsAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Structure $structurePage
    ) {
        $email_connected = 'testcoord1@sportsante86.fr';

        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $structurePage->create([
            'nom_structure' => ChaineCharactere::str_shuffle_unicode("jhbkzhjvdbkjhdcvk"),
            'id_statut_structure' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd"),
            'code_postal' => "86100",
            'id_statut_juridique' => '1',
            'id_territoire' => '1',

            'complement_adresse' => ChaineCharactere::str_shuffle_unicode("jhbhb"),
            'intervenants' => ["TESTSUPINTERVENANT test"],
            'antennes' => [ChaineCharactere::str_shuffle_unicode("zevfv"), ChaineCharactere::str_shuffle_unicode("ykujkuk")],
            'lien_ref_structure' => "https://" . ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd"),
            'code_onaps' => ChaineCharactere::str_shuffle_unicode("jhbhb"),

            'nom_representant' => ChaineCharactere::str_shuffle_unicode("jhbhb"),
            'prenom_representant' => ChaineCharactere::str_shuffle_unicode("jhbhb"),
            'email' => ChaineCharactere::str_shuffle_unicode("vdvdffdv") . '@gmail.com',
            'tel_fixe' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            'tel_portable' => ChaineCharactere::str_shuffle_unicode('0123456789'),
            
            'email_connected' => $email_connected
        ]);
    }
}