<?php
//Dans ce fichier, nous testons la page des intervenants et notamment la recherche d'un intervenant par son email.
//Tests de la barre de recherche avec les emails


namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class GestionResponsables_RechercheMailCest  // /!\ Cest est obligatoire après le nom de la classe
{
	
    
    public function GR_Recherche_MailCorrect(AcceptanceTester $I)
	//ce test est correct
	//lorsqu'on effectue la recherche avec un mail correct, la personne correspondant à ce mail apparait dans le tableau
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

        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
     		
		//Test de la barre de recherche
		//vérification de la présence de la barre de recherche
        $I->seeElement( 'input',['type'=>'search'] );
		
		//recherche mail
		$I->fillField('//*[@id="table_id_filter"]/label/input','cd86vb@gmail.com');
		//je verifie que je vois bien la personne associée à l'eamil
        $I->see('Antoine');		
        $I->see('BOURREAU');	
    }	
    	
    public function GR_Recherche_MailAvecUnMot(AcceptanceTester $I)
    
	//ce test est correct
	//lorsqu'on effectue la recherche avec un mot présent dans une adresse mail, toutes les personnes ayant ce mot dans leurs adresses mail sont affichées
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

        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
     		
		//Test de la barre de recherche
		//vérification de la présence de la barre de recherche
        $I->seeElement( 'input',['type'=>'search'] );
		
		//recherche mail
		$I->fillField('//*[@id="table_id_filter"]/label/input','cd86vb');
		//je verifie que je vois bien la personne associée à l'email
        $I->see('Antoine');		
        $I->see('BOURREAU');	
	}
	
	public function GR_Recherche_Mail_AvecUnMotIncongru(AcceptanceTester $I)
	//ce test est correct
	//lorsqu'on effectue la recherche avec un mot présent dans une adresse mail, toutes les personnes ayant ce mot dans leurs adresses mail sont affichées
	
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

        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
     		
		//Test de la barre de recherche
		//vérification de la présence de la barre de recherche
        $I->seeElement( 'input',['type'=>'search'] );
		
		//recherche mail
		$I->fillField('//*[@id="table_id_filter"]/label/input','       C d 86  v     b');
		//je verifie que je vois bien la personne associée à l'email
        $I->see('Antoine');		
        $I->see('BOURREAU');
	}	
}