<?php
//Dans ce fichier, nous testons la page des intervenants et notamment la recherche d'un intervenant par un numero de telephone
//Tests de la barre de recherche avec un numero de telephone

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class RechercheTelephoneResponsableCest  // /!\ Cest est obligatoire après le nom de la classe
{
	
    
    public function Cas5_16_Recherche_TelephoneCorrect(AcceptanceTester $I)
	//ce test est correct
	//lorsqu'on effectue une recherche avec un numero de telephone correct, la personne associé à ce numero est affichée dans le tableau
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);
        $I->wait(2);

        $I->click('Gestion Responsables');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 42 éléments');
     		
		//Test de la barre de recherche
		//vérification de la présence de la barre de recherche
        $I->seeElement( 'input',['type'=>'search'] );
		
		//recherche telephone
		$I->fillField('//*[@id="table_id_filter"]/label/input','0660448877');
		//je verifie que je vois bien la personne associée au numero
		$I->see('Johan');
	}	
	public function Cas5_2_Recherche_TelephoneAvecespaces(AcceptanceTester $I)
	//numéro de tel avec des espaces du type : 06 60 44 88 77
    //ce test est correct
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);
        $I->wait(2);

        $I->click('Gestion Responsables');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 42 éléments');
            
        //Test de la barre de recherche
        //vérification de la présence de la barre de recherche
        $I->seeElement( 'input',['type'=>'search'] );
        
        //recherche telephone
        $I->fillField('//*[@id="table_id_filter"]/label/input','06 60 44 88 77');
        //je verifie que je vois bien la personne associée au numero
        $I->see('Johan');
    }
		
		
	   public function Cas5_17_Recherche_TelephoneAvecModifier(AcceptanceTester $I)
    //ce test est incorrect
    //lorsqu'on effectue une recherche avec le mot Modifier, tous les responsables apparaissent dans le tablau, ce qui n'est pas normal
    //il ne devrait pas etre possible d'effectuer une recherche avec ce mot là, il ne devrait pas etre pris en compte comme étant un élément de recherche possible
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);
        $I->wait(2);

        $I->click('Gestion Responsables');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 42 éléments');
            
        //Test de la barre de recherche
        //vérification de la présence de la barre de recherche
        $I->seeElement( 'input',['type'=>'search'] );
        
        //recherche telephone
        $I->fillField('//*[@id="table_id_filter"]/label/input','Modifier');
        //je verifie que je vois bien la personne associée au numero
        $I->see('élément 1 à 10 sur 42 éléments');
    }
}