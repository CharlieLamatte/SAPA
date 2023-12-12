<?php
//Dans ce fichier, nous testons la page des intervenants et notamment le bouton d'ajout d'un intervenant



namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class AjoutIntervenantTelCest  // /!\ Cest est obligatoire après le nom de la classe
{
	
    
    public function Cas1_10chiffresavec_espace(AcceptanceTester $I)
	//ce test est correct
	//lorsqu'on clique sur ce bouton, on est rediriger vers la page AjoutIntervenant.php
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
		$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
		



        // Je verifie qu'il y a le form
        $I-> seeElement('form');

        
        $I-> fillField('nom','Michel');
        $I-> fillField('prenom','Jean');
        $I-> fillField('email','jean@gmail.com');
		$I-> fillField('tel','06 12 34 56 78');
		$I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
	
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');



    }		
	
		
		public function Cas2_correcte(AcceptanceTester $I)
    //ce test est correct
    //lorsqu'on clique sur ce bouton, on est rediriger vers la page AjoutIntervenant.php
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
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        //verification de la redirection vers la page AjoutIntervenant.php
        $I->wait(2);
        $I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        



        // Je verifie qu'il y a le form
        $I-> seeElement('form');

        
        $I-> fillField('nom','Michel');
        $I-> fillField('prenom','Jean');
        $I-> fillField('email','jean@gmail.com');
        $I-> fillField('tel','0612345678');
        $I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
    
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');



    }       

        public function Cas3_avec_tiret(AcceptanceTester $I)
    //ce test est correct
    //lorsqu'on clique sur ce bouton, on est rediriger vers la page AjoutIntervenant.php
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
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        //verification de la redirection vers la page AjoutIntervenant.php
        $I->wait(2);
        $I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        



        // Je verifie qu'il y a le form
        $I-> seeElement('form');

        
        $I-> fillField('nom','Michel');
        $I-> fillField('prenom','Jean');
        $I-> fillField('email','jean@gmail.com');
        $I-> fillField('tel','06-12-34-56-78');
        $I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
    
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');



    }  
	
    public function Cas4_avec_point(AcceptanceTester $I)
    //ce test est correct
    //lorsqu'on clique sur ce bouton, on est rediriger vers la page AjoutIntervenant.php
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
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        //verification de la redirection vers la page AjoutIntervenant.php
        $I->wait(2);
        $I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        



        // Je verifie qu'il y a le form
        $I-> seeElement('form');

        
        $I-> fillField('nom','Michel');
        $I-> fillField('prenom','Jean');
        $I-> fillField('email','jean@gmail.com');
        $I-> fillField('tel','06.12.34.56.78');
        $I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
    
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');



    }  

    public function Cas5_lettreminuscule(AcceptanceTester $I)
    //ce test est correct
    //lorsqu'on clique sur ce bouton, on est rediriger vers la page AjoutIntervenant.php
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
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        //verification de la redirection vers la page AjoutIntervenant.php
        $I->wait(2);
        $I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        



        // Je verifie qu'il y a le form
        $I-> seeElement('form');

        
        $I-> fillField('nom','Michel');
        $I-> fillField('prenom','Jean');
        $I-> fillField('email','jean@gmail.com');
        $I-> fillField('tel','azertyuiop');
        $I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
    
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');



    }  

    public function Cas6_aveccaractèrespé(AcceptanceTester $I)
    //ce test est correct
    //lorsqu'on clique sur ce bouton, on est rediriger vers la page AjoutIntervenant.php
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
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        //verification de la redirection vers la page AjoutIntervenant.php
        $I->wait(2);
        $I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        



        // Je verifie qu'il y a le form
        $I-> seeElement('form');

        
        $I-> fillField('nom','Michel');
        $I-> fillField('prenom','Jean');
        $I-> fillField('email','jean@gmail.com');
        $I-> fillField('tel','éééééééééé');
        $I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
    
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');



    }  

    public function Cas7_lettremajuscule(AcceptanceTester $I)
    //ce test est correct
    //lorsqu'on clique sur ce bouton, on est rediriger vers la page AjoutIntervenant.php
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
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        //verification de la redirection vers la page AjoutIntervenant.php
        $I->wait(2);
        $I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        



        // Je verifie qu'il y a le form
        $I-> seeElement('form');

        
        $I-> fillField('nom','Michel');
        $I-> fillField('prenom','Jean');
        $I-> fillField('email','jean@gmail.com');
        $I-> fillField('tel','AZERTYUIOP');
        $I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
    
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');



    }  

    public function Cas8_1caractere(AcceptanceTester $I)
    //ce test est correct
    //lorsqu'on clique sur ce bouton, on est rediriger vers la page AjoutIntervenant.php
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
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        //verification de la redirection vers la page AjoutIntervenant.php
        $I->wait(2);
        $I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        



        // Je verifie qu'il y a le form
        $I-> seeElement('form');

        
        $I-> fillField('nom','Michel');
        $I-> fillField('prenom','Jean');
        $I-> fillField('email','jean@gmail.com');
        $I-> fillField('tel','1');
        $I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
    
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');



    }  

    public function Cas9_avec11chiffres(AcceptanceTester $I)
    //ce test est correct
    //lorsqu'on clique sur ce bouton, on est rediriger vers la page AjoutIntervenant.php
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
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        //verification de la redirection vers la page AjoutIntervenant.php
        $I->wait(2);
        $I->seeInCurrentUrl('/PHP/Intervenants/AjoutIntervenant.php');
        



        // Je verifie qu'il y a le form
        $I-> seeElement('form');

        
        $I-> fillField('nom','Michel');
        $I-> fillField('prenom','Jean');
        $I-> fillField('email','jean@gmail.com');
        $I-> fillField('tel','12345678912');
        $I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
    
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');



    }  
}