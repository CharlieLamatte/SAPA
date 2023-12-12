<?php
//Dans ce fichier, nous testons la page des intervenants et notamment la partie haute de la page qui est le bandeauIntervenant
//Tests du bouton parametres, accueil et déconnexion


namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class BandeauPageIntervenantCest  // /!\ Cest est obligatoire après le nom de la classe
{
	
    
    public function Cas1_BoutonParametres(AcceptanceTester $I)
	//ce test est correct
	//lorsqu'on clique sur le bouton parametres de la page des itervenants, on atterit bien sur la page Settings
    {
		// Je test que je suis bien sur la page index.php
        $I->amOnPage('index.php');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');

        $I->seeInCurrentUrl('/PHP/Intervenants/ListeIntervenant.php');
				
		// Je vérifie que je suis bien sur ListeIntervenants.php
        $I->seeInCurrentUrl('/PHP/Intervenants/ListeIntervenant.php');
     		
		//Test du bouton setting sur la page des intervenants
		//vérification de la présence du bouton parametres
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );
		//on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php');
	}		
		
		public function Cas2_BoutonAccueil(AcceptanceTester $I)
		//ce test est correct
		//lorsqu'on clique sur le bouton Accueil de la page des itervenants, on atterit bien sur la page Accueil_liste
		{
			// Je test que je suis bien sur la page index.php
        $I->amOnPage('index.php');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');

        $I->seeInCurrentUrl('/PHP/Intervenants/ListeIntervenant.php');
				
		// Je vérifie que je suis bien sur ListeIntervenants.php
        $I->seeInCurrentUrl('/PHP/Intervenants/ListeIntervenant.php');
     		
	
		//Test du bouton accueil sur la page des intervenants
		//vérification de la présence du bouton accueil
        $I->seeElement( Locator::href( '/PHP/Accueil_liste.php' ) );
		//on clique sur le lien
        $I->click( Locator::href( '/PHP/Accueil_liste.php' ) );
        // Je verifie que je suis bien sur la page /PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
			
		}
		public function Cas3_BoutonDeconnexion(AcceptanceTester $I)
		//ce test est correct
		//lorsqu'on clique sur le bouton Deconnexion de la page des intervenants, on atterit bien sur la page index.php
		{
		// Je test que je suis bien sur la page index.php
        $I->amOnPage('index.php');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');

        $I->seeInCurrentUrl('/PHP/Intervenants/ListeIntervenant.php');
				
		// Je vérifie que je suis bien sur ListeIntervenants.php
        $I->seeInCurrentUrl('/PHP/Intervenants/ListeIntervenant.php');
		
		//Test du bouton deconnexion sur la page des intervenants
		//vérification de la présence du bouton deconnexion
        $I->seeElement( Locator::href( '/PHP/deconnexionBDD' ) );
		//on clique sur le lien
        $I->click( Locator::href( '/PHP/deconnexionBDD' ) );
        // Je verifie que je suis bien sur la page index.php
        $I->seeInCurrentUrl('index.php'); 
		}

	
}