<?php
//Dans ce fichier, nous testons la page des intervenants et notamment le bouton d'ajout d'un intervenant
//Champ Prenom


namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class FormAjoutResponsableNomCest  // /!\ Cest est obligatoire après le nom de la classe
{
public function NewResponsableNormal(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
    
    
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
		$I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','Michel');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}

public function NewResponsable_nomMinuscule(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom minuscule : elie
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','elie');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }
    
public function NewResponsablet_nomMajuscule(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom majuscule : ELIE
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','ELIE');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }
    
public function NewResponsable_PrenomNormal(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom Normal, premiere lettre majuscule : Elie
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','Elie');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrénomAccent(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom majuscule : éééé
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','éééé');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

    public function NewResponsable_PrenomAccentPremiereLettre(AcceptanceTester $I)
    //Ajout d'un nouvel intervenant
    //nom Accent premiere lettre : élie
        
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','éLie');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomUneLettreAccent(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom majuscule : é
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','é');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomChiffres(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom chiffres : 123456
    
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

        //verification de la redirection 
        $I->wait(2);
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','123456');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomCaracteresSpeciaux(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Prenom caractères spéciaux : %-/*
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','%-/*');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomVide(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom vide
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomEspace(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom espace : ' '
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable',' ');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }
public function NewResponsable_EspacePrenom(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//Espace nom : ' Elie'
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable',' Elie');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomEspaceAuMilieu(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom avec un espace au milieu : El ie"
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','El ie');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomCompose(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom composé : Jean-Baptiste
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','Jean-Baptiste');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }

public function NewResponsable_PrenomEspaceFin(AcceptanceTester $I)
//Ajout d'un nouvel intervenant
//nom avec un espace a la fin : 'Elie '
    
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
        $I->seeInCurrentUrl('/PHP/Responsables/AjouterResponsable.php');
        
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Ajouter un Responsable');

        $I-> fillField('nom_responsable','Elie ');
        $I-> fillField('prenom_responsable','Jean');
        $I-> fillField('mail_responsable','jean@gmail.com');
        $I-> fillField('tel_responsable','0606060606');


        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
    }
}