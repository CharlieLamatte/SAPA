<?php

//Dans ce fichier, nous testons le formulaire d'ajout d'un intervenant
//le champ testé ici est le champ Mail

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class FormMailAjoutIntervenantCest  // /!\ Cest est obligatoire après le nom de la classe
{

    public function AjoutIntervenant_mailCorrect(AcceptanceTester $I)
	//ce test est correct
	//on test une adresse mail correcte, il ne doit pas avoir de message d'erreur
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
		$I-> fillField('tel','0606060606');
		$I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
	
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}
	
	public function AjoutIntervenant_mailNonConforme1(AcceptanceTester $I)
	//ce test est incorrect
	//on test une adresse mail incorrecte, où il manque la fin de l'adres c-a-d le .fr ou .com
	//un message d'erreur doit s'afficher car le mail est faux, or rien ne s'affiche ce qui n'est pas normal
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
        $I-> fillField('email','aaa@AAA');
		$I-> fillField('tel','0606060606');
		$I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
	
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}
	public function AjoutIntervenant_mailNonConforme2(AcceptanceTester $I)
	//ce test est incorrect
	//on test une adresse mail incorrecte, où il manque le @ et le .fr   
	//on test avec le mot azerty
	//un message d'erreur doit s'afficher car le mail est faux, or rien ne s'affiche ce qui n'est pas normal

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
        $I-> fillField('email','azerty');
		$I-> fillField('tel','0606060606');
		$I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
	
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}
	
	public function AjoutIntervenant_mailVide(AcceptanceTester $I)
	//ce test est incorrect
	//on test avec le champ mail vide, un message d'erreur doit apparaitre
	//un message d'erreur doit s'afficher car le mail n'est pas renseigné, or rien ne s'affiche ce qui n'est pas normal

	
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
        $I-> fillField('email','');
		$I-> fillField('tel','0606060606');
		$I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
	
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}
	
	public function AjoutIntervenant_mailAveccUniquementUnEspace(AcceptanceTester $I)
	//ce test est incorrect
	//on test un mail sans caractere, avec uniquement un espace
	//un message d'erreur doit s'afficher car le mail n'est pas renseigné, or rien ne s'affiche ce qui n'est pas normal

	
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
        $I-> fillField('email','   ');
		$I-> fillField('tel','0606060606');
		$I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
	
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}
	
	public function AjoutIntervenant_mailAvecChiffres(AcceptanceTester $I)
	//ce test est incorrect
	//on test un mail avec uniquement des chiffres
	//un message d'erreur doit s'afficher car le mail n'est pas correcte, or rien ne s'affiche ce qui n'est pas normal

	
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
        $I-> fillField('email','123456');
		$I-> fillField('tel','0606060606');
		$I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
	
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}
	
		public function AjoutIntervenant_mailAvecEspaceAuMilieu(AcceptanceTester $I)
	//ce test est incorrect
	//on test un mail avec un espace au milieu des caracteres
	//un message d'erreur doit s'afficher car le mail n'est pas correcte, or rien ne s'affiche ce qui n'est pas normal

	
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
        $I-> fillField('email','aa aa@gmail.com');
		$I-> fillField('tel','0606060606');
		$I->selectOption('diplome', 'DEJEPS');
        $I->selectOption('statut', 'Salarié');
        $I-> fillField('numero_carte','0123456789');
	
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        $I->click('Enregistrer');
	}
}

	