<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class DeconnexionCest  // /!\ Cest est obligatoire après le nom de la classe
{
	//cette classe test permet de tester le bouton de déconnexion
	
	
    public function DeconnexionCorrect(AcceptanceTester $I)
    {
		//on effectue une déconnexion fonctionnelle après s'être connecté.
		//On commence par la connexion d'un utilisateur et l'arrivé sur la page d'accueil 
		//puis on clique sur le bouton de déconnexion et  on vérifie que l'on est bien sur la page du login
		
		
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('index.php');
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');
        // Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Connexion"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Connexion']);

        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "test@gmail.com"
        $I->fillField('identifiant', 'test@gmail.com');
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
		
		
		//Test de la déconnexion
		//vérification de la présence du lien
		$I->seeElement( Locator::href( '/PHP/deconnexionBDD' ) );
		//on clique sur le lien
		$I->click( Locator::href( '/PHP/deconnexionBDD' ) );
		
		//je vérifie que je suis bien sur a page du login
		// Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');
        // Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
		// Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Connexion"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Connexion']);
		
    }
	
	public function DeconnexionSansConnexion(AcceptanceTester $I)
    {
		//On commence par vérifier que l'on est bien sur la page du login
		//puis on essais de touver le botton de déconnexion et de cliquer sur le bouton de déconnexion
		//on est pas supposé le trouvé puisque ce bouton ne se trouve que dans les pages où est supposé être connecté
		
		
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('index.php');
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');
        // Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Connexion"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Connexion']);

        
		//Test de la déconnexion
		//vérification de la présence du lien de déconnexion
		$I->dontSee( Locator::href('/PHP/deconnexionBDD'));
		
		
    }
	
	
	
}
