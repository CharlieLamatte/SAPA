<?php
//Dans ce fichier, nous testons la page des intervenants et notamment le bouton d'ajout d'un intervenant
//Champ Nom



namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class FormAjoutIntervenantPrenomCest  // /!\ Cest est obligatoire après le nom de la classe
{
public function NewIntervenantNormal(AcceptanceTester $I)
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', 'Michel');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');
        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}

public function NewIntervenant_NomMinuscule(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom minuscule : elie
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', 'elie');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');
    
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');        
    }
    
public function NewIntervenant_NomMajuscule(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom majuscule : ELIE
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', 'ELIE');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');
    
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');    
    }
    
public function NewIntervenant_NomNormal(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom Normal, premiere lettre majuscule : Elie
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', 'Elie');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');
   
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewIntervenant_NomAccent(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom majuscule : éééé
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', 'éééé');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

    public function NewIntervenant_NomAccentPremiereLettre(AcceptanceTester $I)
    //Ajout d'un nouvel intervenant
    //Nom Accent premiere lettre : élie
        
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
    
            $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);
    
            $I->click('Gestion Intervenants');
            $I->wait(4);
    
            $I->seeInCurrentUrl('ListeIntervenant.php');
            $I->wait(2);
            
                 
            //Test du bouton Ajouter un intervenant
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
    
            //verification de la redirection vers la page AjoutIntervenant.php
            $I->wait(2);
            $I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
            
            // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
            $I->see('Ajouter un intervenant');
    
            // Je rempli le champ "Nom"
            $I->fillField('nom', 'élie');
    
            // Je rempli le champ "prenom"
            $I->fillField('nom', 'Jean');
    
            // Je rempli le champ "email"
            $I->fillField('email', 'jean@gmail.com');
        
            // Je rempli le champ "tel"
            $I->fillField('tel', '0606060606');
    
            //diplome
            $I->selectOption('diplome', 'DEJEPS');
    
            //Statut
            $I->selectOption('statut', 'Salarié');
    
            //Numéro carte
            $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
        }

public function NewIntervenant_NomUneLettreAccent(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom majuscule : é
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', 'é');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewIntervenant_NomChiffres(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom chiffres : 123456
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', '123456');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewIntervenant_NomCaracteresSpeciaux(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom caractères spéciaux : %-/*
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', '%-/*');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewIntervenant_NomVide(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom vide
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', '');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewIntervenant_NomEspace(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom espace : ' '
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', ' ');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }
public function NewIntervenant_EspaceNom(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Espace Nom : ' Elie'
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', ' Elie');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewIntervenant_NomEspaceAuMilieu(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom avec un espace au milieu : El ie"
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', 'El ie');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewIntervenant_NomCompose(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom composé : Jean-Baptiste
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', 'Jean-Baptiste');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewIntervenant_NomEspaceFin(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Nom avec un espace a la fin : 'Elie '
    
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);
		
     		
		//Test du bouton Ajouter un intervenant
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

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un intervenant');

        // Je rempli le champ "Nom"
        $I->fillField('nom', 'Elie ');

        // Je rempli le champ "prenom"
        $I->fillField('nom', 'Jean');

        // Je rempli le champ "email"
        $I->fillField('email', 'jean@gmail.com');
    
        // Je rempli le champ "tel"
        $I->fillField('tel', '0606060606');

        //diplome
        $I->selectOption('diplome', 'DEJEPS');

        //Statut
        $I->selectOption('statut', 'Salarié');

        //Numéro carte
        $I-> fillField('numero_carte','0123456789');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }
}