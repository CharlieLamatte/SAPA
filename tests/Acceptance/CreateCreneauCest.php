<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\Page\Acceptance\Creneau;
use Tests\Support\Page\Acceptance\Login;

class CreateCreneauCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function createCreneauAsAdminMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Creneau $creneauPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login($email_connected, 'testAdmin1.1@A');
        $creneauPage->create([
            'nom_creneau' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'type_creneau' => "2",
            'jour' => "2",
            'id_heure_debut' => '6',
            'id_heure_fin' => '10',
            'id_structure' => '1',
            'intervenant_ids' => ['7'],
            'pathologie' => ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj"),
            'type_seance' => ChaineCharactere::str_shuffle_unicode("ouycfhfhfgh"),
            'adresse' => ChaineCharactere::str_shuffle_unicode("dvhdfgh"),
            'code_postal' => '86000',

            'email_connected' => $email_connected
        ]);
    }

    public function createCreneauAsAdminAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Creneau $creneauPage
    ) {
        $email_connected = 'TestAdmin@sportsante86.fr';

        $loginPage->login($email_connected, 'testAdmin1.1@A');
        $creneauPage->create([
            'nom_creneau' => ChaineCharactere::str_shuffle_unicode("sjsdfgpotretjdfnbchh"),
            'type_creneau' => "2",
            'jour' => "2",
            'id_heure_debut' => '6',
            'id_heure_fin' => '10',
            'id_structure' => '1',
            'intervenant_ids' => ['7'],
            'pathologie' => ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj"),
            'type_seance' => ChaineCharactere::str_shuffle_unicode("ouycfhfhfgh"),
            'adresse' => ChaineCharactere::str_shuffle_unicode("dvhdfgh"),
            'code_postal' => '86000',
            //optionnal
            'nb_participant_max' => ChaineCharactere::str_shuffle_unicode("198"),
            'public_vise' => ChaineCharactere::str_shuffle_unicode("dfgdfgdfg"),
            'tarif' => ChaineCharactere::str_shuffle_unicode("543"),
            'paiement' => ChaineCharactere::str_shuffle_unicode("bbvclmkgdf"),
            'description' => ChaineCharactere::str_shuffle_unicode("sdfgdsgdpomb"),
            'complement_adresse' => ChaineCharactere::str_shuffle_unicode("poidfgdfghudf"),

            'email_connected' => $email_connected
        ]);
    }

    public function createCreneauAsResponsableStructureMinData(
        AcceptanceTester $I,
        Login $loginPage,
        Creneau $creneauPage
    ) {
        $email_connected = 'testResponsableStructureNom@sportsante86.fr';

        $loginPage->login($email_connected, 'testResponsableStructureNom1.1@A');
        $creneauPage->create([
            'nom_creneau' => ChaineCharactere::str_shuffle_unicode("ljdlhjvbdhvbdvaowxcv"),
            'type_creneau' => "2",
            'jour' => "2",
            'id_heure_debut' => '6',
            'id_heure_fin' => '10',
            'id_structure' => '1',
            'intervenant_ids' => ['7'],
            'pathologie' => ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj"),
            'type_seance' => ChaineCharactere::str_shuffle_unicode("ouycfhfhfgh"),
            'adresse' => ChaineCharactere::str_shuffle_unicode("dvhdfgh"),
            'code_postal' => '86000',

            'email_connected' => $email_connected
        ]);
    }

    public function createCreneauAsResponsableStructureAllData(
        AcceptanceTester $I,
        Login $loginPage,
        Creneau $creneauPage
    ) {
        $email_connected = 'testResponsableStructureNom@sportsante86.fr';

        $loginPage->login($email_connected, 'testResponsableStructureNom1.1@A');
        $creneauPage->create([
            'nom_creneau' => ChaineCharactere::str_shuffle_unicode("nvcxbnfdssdfkjhqkiur"),
            'type_creneau' => "2",
            'jour' => "2",
            'id_heure_debut' => '6',
            'id_heure_fin' => '10',
            'id_structure' => '1',
            'intervenant_ids' => ['7'],
            'pathologie' => ChaineCharactere::str_shuffle_unicode("sdfsdfsdfskghj"),
            'type_seance' => ChaineCharactere::str_shuffle_unicode("ouycfhfhfgh"),
            'adresse' => ChaineCharactere::str_shuffle_unicode("dvhdfgh"),
            'code_postal' => '86000',
            //optionnal
            'nb_participant_max' => ChaineCharactere::str_shuffle_unicode("198"),
            'public_vise' => ChaineCharactere::str_shuffle_unicode("dfgdfgdfg"),
            'tarif' => ChaineCharactere::str_shuffle_unicode("543"),
            'paiement' => ChaineCharactere::str_shuffle_unicode("bbvclmkgdf"),
            'description' => ChaineCharactere::str_shuffle_unicode("sdfgdsgdpomb"),
            'complement_adresse' => ChaineCharactere::str_shuffle_unicode("poidfgdfghudf"),

            'email_connected' => $email_connected
        ]);
    }
}