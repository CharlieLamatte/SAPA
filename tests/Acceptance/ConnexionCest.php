<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class ConnexionCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function connexionPasswordOKMailOK(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Connexion');
        $I->seeElement('button', ['type' => 'submit']);
        $I->fillField('identifiant', 'testcoord1@sportsante86.fr');
        $I->fillField('pswd', 'testcoord1.1@A');
        $I->click('form button[type=submit]');
        $I->waitPageLoad();
        $I->seeInCurrentUrl('/Accueil_liste.php');
    }

    public function connexionPasswordOKMailNotOK(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Connexion');
        $I->seeElement('button', ['type' => 'submit']);
        $I->fillField('identifiant', 'testcoord2@sportsante86.fr');
        $I->fillField('pswd', 'testcoord1.1@A');
        $I->click('form button[type=submit]');
        $I->waitPageLoad();
        $I->see('Mot de passe ou email invalide.');
    }

    public function connexionPasswordNotOKMailOK(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Connexion');
        $I->seeElement('button', ['type' => 'submit']);
        $I->fillField('identifiant', 'testcoord1@sportsante86.fr');
        $I->fillField('pswd', 'testcoord1.1@Ac');
        $I->click('form button[type=submit]');
        $I->waitPageLoad();
        $I->see('Mot de passe ou email invalide.');
    }
}