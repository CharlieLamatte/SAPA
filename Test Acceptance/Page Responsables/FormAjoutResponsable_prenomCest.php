<?php
//Dans ce fichier, nous testons le formulaire d'ajout d'un responsable
//Champ Prenom


namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class FormAjoutResponsablePrenomCest  // /!\ Cest est obligatoire après le nom de la classe
{
public function NewResponsableNormal(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}

public function NewResponsable_PrenomMinuscule(AcceptanceTester $I)
//Ajout d'un nouvel responsable
//Prenom minuscule : elie
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', 'elie');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');       
    }
    
public function NewResponsable_PrenomMajuscule(AcceptanceTester $I)
//Ajout d'un nouvel responsable
//Prenom majuscule : ELIE
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', 'ELIE');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');   
    }
    
public function NewResponsable_PrenomNormal(AcceptanceTester $I)
//Ajout d'un nouvel responsable
//Prenom Normal, premiere lettre majuscule : Elie
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', 'Elie');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrénomAccent(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Prenom avec accent : éééé
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', 'ééééé');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

    public function NewResponsable_PrenomAccentPremiereLettre(AcceptanceTester $I)
    //Ajout d'un nouvel intervenant
    //Prenom Accent premiere lettre : élie
        
        {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', 'élie');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
        }

public function NewResponsable_PrenomUneLettreMajuscule(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Prenom majuscule : éLie
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', 'éLie');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomChiffres(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Prenom chiffres : 123456
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', '123456');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}
	
public function NewResponsable_PrenomCaracteresSpeciaux(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Prenom caractères spéciaux : %-/*
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', '%//=');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}
	

public function NewResponsable_PrenomVide(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Prenom vide :''
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', '');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}
	
public function NewResponsable_PrenomEspace(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Prenom espace : ' '
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', '  ');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }
public function NewResponsable_EspaceAvantPrenom(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Espace prenom : ' Elie'
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', ' Jean');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomEspaceAuMilieu(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Prenom avec un espace au milieu : "El ie"
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', 'Je an');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomCompose(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Prenom composé : Jean-Baptiste
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', 'Jean-Baptiste');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomEspaceFin(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Prenom avec un espace a la fin : 'Elie '
    
    {
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un responsable
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="ficheResume"]/center/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="ficheResume"]/center/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjouterResponsable.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Ajouter un responsable"
        $I->see('Ajouter un responsable');

        // Je rempli le champ "Nom"
        $I->fillField('nom_responsable', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('prenom_responsable', 'Jean ');

        // Je rempli le champ "email"
        $I->fillField('mail_responsable', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel_responsable', '0606060606');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }
}