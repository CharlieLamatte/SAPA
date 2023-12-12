<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\Page\Acceptance\Login;
use Tests\Support\Page\Acceptance\Medecin;

class ModifyMedecinCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function modifyMedecinAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $medecinPage->modify([
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

    public function modifyMedecinAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $medecinPage->modify([
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

    public function modifyMedecinAsCoordonnateurPepsMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $medecinPage->modify([
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

    public function modifyMedecinAsCoordonnateurPepsAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $medecinPage->modify([
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

    public function modifyMedecinAsCoordonnateurMssMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');
        $medecinPage->modify([
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

    public function modifyMedecinAsCoordonnateurMssAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');
        $medecinPage->modify([
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

    public function modifyMedecinAsCoordonnateurStructureNonMssMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');
        $medecinPage->modify([
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

    public function modifyMedecinAsCoordonnateurStructureNonMssAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');
        $medecinPage->modify([
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

    public function modifyMedecinAsEvaluateurMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');
        $medecinPage->modify([
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

    public function modifyMedecinAsEvaluateurAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Medecin $medecinPage
    ) {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');
        $medecinPage->modify([
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