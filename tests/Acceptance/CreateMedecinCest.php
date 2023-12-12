<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\Page\Acceptance\Login;
use Tests\Support\Page\Acceptance\Medecin;

class CreateMedecinCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function createMedecinAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $medecinPage->create([
            'nom_coordonnees' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'prenom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wxcvxwgdsfsdfg"),
            'poste_medecin' => ChaineCharactere::str_shuffle_unicode("dfgdfghfg"),
            'id_specialite_medecin' => "2",
            'id_lieu_pratique' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("dhfghfgiupio"),
            'code_postal' => '86000',
            'id_territoire' => "2",
            'tel_fixe_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),
        ]);
    }

    public function createMedecinAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $medecinPage->create([
            'nom_coordonnees' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'prenom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wxcvxwgdsfsdfg"),
            'poste_medecin' => ChaineCharactere::str_shuffle_unicode("dfgdfghfg"),
            'id_specialite_medecin' => "2",
            'id_lieu_pratique' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("dhfghfgiupio"),
            'code_postal' => '86000',
            'id_territoire' => "2",
            'tel_fixe_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'complement_adresse' => ChaineCharactere::str_shuffle_unicode("poiuppyuiop"),
            'mail_coordonnees' => ChaineCharactere::str_shuffle_unicode("fghdfghfgh") . '@gmail.com',
            'tel_portable_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),
        ]);
    }

    public function createMedecinAsCoordonnateurPepsMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $medecinPage->create([
            'nom_coordonnees' => ChaineCharactere::str_shuffle_unicode("igdiozgdodzsdz"),
            'prenom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wxcvxwgdsfsdfg"),
            'poste_medecin' => ChaineCharactere::str_shuffle_unicode("dfgdfghfg"),
            'id_specialite_medecin' => "2",
            'id_lieu_pratique' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("dhfghfgiupio"),
            'code_postal' => '86000',
            'id_territoire' => "2",
            'tel_fixe_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),
        ]);
    }

    public function createMedecinAsCoordonnateurPepsAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $medecinPage->create([
            'nom_coordonnees' => ChaineCharactere::str_shuffle_unicode("xphzgjdfzf"),
            'prenom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wxcvxwgdsfsdfg"),
            'poste_medecin' => ChaineCharactere::str_shuffle_unicode("dfgdfghfg"),
            'id_specialite_medecin' => "2",
            'id_lieu_pratique' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("dhfghfgiupio"),
            'code_postal' => '86000',
            'id_territoire' => "2",
            'tel_fixe_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'complement_adresse' => ChaineCharactere::str_shuffle_unicode("poiuppyuiop"),
            'mail_coordonnees' => ChaineCharactere::str_shuffle_unicode("fghdfghfgh") . '@gmail.com',
            'tel_portable_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),
        ]);
    }

    public function createMedecinAsCoordonnateurMssMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');
        $medecinPage->create([
            'nom_coordonnees' => ChaineCharactere::str_shuffle_unicode("xsjkhbwzhuieodzp"),
            'prenom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wxcvxwgdsfsdfg"),
            'poste_medecin' => ChaineCharactere::str_shuffle_unicode("dfgdfghfg"),
            'id_specialite_medecin' => "2",
            'id_lieu_pratique' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("dhfghfgiupio"),
            'code_postal' => '86000',
            'id_territoire' => "2",
            'tel_fixe_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),
        ]);
    }

    public function createMedecinAsCoordonnateurMssAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');
        $medecinPage->create([
            'nom_coordonnees' => ChaineCharactere::str_shuffle_unicode("czjodbczodhbc"),
            'prenom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wxcvxwgdsfsdfg"),
            'poste_medecin' => ChaineCharactere::str_shuffle_unicode("dfgdfghfg"),
            'id_specialite_medecin' => "2",
            'id_lieu_pratique' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("dhfghfgiupio"),
            'code_postal' => '86000',
            'id_territoire' => "2",
            'tel_fixe_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'complement_adresse' => ChaineCharactere::str_shuffle_unicode("poiuppyuiop"),
            'mail_coordonnees' => ChaineCharactere::str_shuffle_unicode("fghdfghfgh") . '@gmail.com',
            'tel_portable_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),
        ]);
    }

    public function createMedecinAsCoordonnateurStructureNonMssMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');
        $medecinPage->create([
            'nom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wasxhbsihxdv"),
            'prenom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wxcvxwgdsfsdfg"),
            'poste_medecin' => ChaineCharactere::str_shuffle_unicode("dfgdfghfg"),
            'id_specialite_medecin' => "2",
            'id_lieu_pratique' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("dhfghfgiupio"),
            'code_postal' => '86000',
            'id_territoire' => "2",
            'tel_fixe_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),
        ]);
    }

    public function createMedecinAsCoordonnateurStructureNonMssAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');
        $medecinPage->create([
            'nom_coordonnees' => ChaineCharactere::str_shuffle_unicode("cdejoedcbheubdceidv"),
            'prenom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wxcvxwgdsfsdfg"),
            'poste_medecin' => ChaineCharactere::str_shuffle_unicode("dfgdfghfg"),
            'id_specialite_medecin' => "2",
            'id_lieu_pratique' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("dhfghfgiupio"),
            'code_postal' => '86000',
            'id_territoire' => "2",
            'tel_fixe_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'complement_adresse' => ChaineCharactere::str_shuffle_unicode("poiuppyuiop"),
            'mail_coordonnees' => ChaineCharactere::str_shuffle_unicode("fghdfghfgh") . '@gmail.com',
            'tel_portable_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),
        ]);
    }

    public function createMedecinAsEvaluateurMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');
        $medecinPage->create([
            'nom_coordonnees' => ChaineCharactere::str_shuffle_unicode("czjdnczhdbvhevw"),
            'prenom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wxcvxwgdsfsdfg"),
            'poste_medecin' => ChaineCharactere::str_shuffle_unicode("dfgdfghfg"),
            'id_specialite_medecin' => "2",
            'id_lieu_pratique' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("dhfghfgiupio"),
            'code_postal' => '86000',
            'id_territoire' => "2",
            'tel_fixe_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),
        ]);
    }

    public function createMedecinAsEvaluateurAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');
        $medecinPage->create([
            'nom_coordonnees' => ChaineCharactere::str_shuffle_unicode("hgrvlzhvbefhvfv"),
            'prenom_coordonnees' => ChaineCharactere::str_shuffle_unicode("wxcvxwgdsfsdfg"),
            'poste_medecin' => ChaineCharactere::str_shuffle_unicode("dfgdfghfg"),
            'id_specialite_medecin' => "2",
            'id_lieu_pratique' => "2",
            'nom_adresse' => ChaineCharactere::str_shuffle_unicode("dhfghfgiupio"),
            'code_postal' => '86000',
            'id_territoire' => "2",
            'tel_fixe_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),

            'complement_adresse' => ChaineCharactere::str_shuffle_unicode("poiuppyuiop"),
            'mail_coordonnees' => ChaineCharactere::str_shuffle_unicode("fghdfghfgh") . '@gmail.com',
            'tel_portable_coordonnees' => ChaineCharactere::str_shuffle_unicode('0123456789'),
        ]);
    }
}