<?php
//***
//Ce test permet de vérifier si la page de setting est bien accessible, depuis la page d'accueil du site, en passant pas le bouton réglage et arrivant sur la page de paramètre. 
//Sur cette page, l'on peut voir qu'il y a écrit : Paramètres supplémentaires. Ce test permet donc de vérifier que nous allons bien sur cette page web. 
//***

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class AjoutMedecinCest  // /!\ Cest est obligatoire après le nom de la classe
{
	//Test qui vérifie que nous pouvons jouter un medecin avec les données suivante :
	//NOM : -
	//PRÉNOM : Patrick
	//SPÉCIALITÉ : -
	//NUMÉRO : 5                         ADRESSE : Rue du Pitre
	//CODE POSTAL : -      VILLE : Saint Pierre 
	//TÉLÉPHONE : 0501020304
	//MAIL : secretairiaPJ@laposte.fr
    public function cas1(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Medecin fonctionne
		$I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
		
		//Pour eviter les problèmes entre chrome et firefox on doit attendre le chargment des java scripts ce qui inclut les onclick
		$I->wait(10);
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Medecin');
		
		
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
		
		
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
	    $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
	   
	    //on clique sur l'element
	    $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
		
		//on verifie que la page d'ajout c'est bien ouverte
		$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
		
		//Pour eviter les problèmes de chargement de chrome et ou de firefox on doit attendre le chargment des java scripts et de la page
		$I->wait(10);
		
		//verification de l'ouverture de la bonne page
		$I->see('Informations Medecin');
		
		
		//verification de la présence du formulaire
		$I->seeElement('/html/body/div[1]/div/div/fieldset/div/center/div/div/form');
		
		
		//remplissage du formulaire et ajout du Medecin avec les parametre suivant
		//NOM : -
		//PRÉNOM : Patrick
		//SPÉCIALITÉ : -
		//NUMÉRO : 5                         ADRESSE : Rue du Pitre
		//CODE POSTAL : -      VILLE : Saint Pierre 
		//TÉLÉPHONE : 0501020304
		
		// Je rempli le champ "firstname" avec la valeur "Patrick"
        $I->fillField('firstname', 'Patrick');
		
		// Je rempli le champ "lastname" avec la valeur ""
        $I->fillField('lastname', '');
		
		//remplir la région
		$I->selectOption('region', array('value' => '0'));
		
		//remplir le champ de la spécialité
		//champs non présent
		
		
		// Je rempli le champ "Lieux de pratique" avec la valeur "quelque part"
        $I->fillField('LieuMedecin', '');

        // Je rempli le champ "Numéro Adeli" avec la valeur "5"
        $I->fillField('numAdeli', '5');

        // Je rempli le champ "Adresse" avec la valeur "Rue du Pitre"
        $I->fillField('adresseMedecin', 'Rue du Pitre');

        // Je rempli le champ "Code postal" avec la valeur ""
        $I->fillField('city', '');


        // Je rempli le champ "Ville" avec la valeur "Saint Pierre"
        $I->fillField('state', 'Saint Pierre');        

        // Je rempli le champ "Téléphone" avec la valeur "0501020304"
        $I->fillField('phone', '0501020304');

        // Je rempli le champ "Email" avec la valeur "secretairiaPJ@laposte.fr"
        $I->fillField('email', 'secretairiaPJ@laposte.fr');
		
		
		//on valide le formulaire
		$I->click('form input[type=submit]');
		
		// Je verifie que le message d'erreur("Veuillez compléter ce champ") indiquant que le champ du nom est vide 
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->dontSeeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
		
        //Je verifie que je ne trouve pas le texte suivant : Liste des Médecins
        $I->dontSee('Liste des Médecins');
		
        
		//retour a la page de la liste des docteurs
		$I->switchToWindow();
		
		
		
	}
	
    //Test qui vérifie que nous pouvons jouter un medecin avec toutes les données valides.
    public function cas2(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Medecin fonctionne
		$I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
		
		//Pour eviter les problèmes entre chrome et firefox on doit attendre le chargment des java scripts ce qui inclut les onclick
		$I->wait(10);
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Medecin');
		
		
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
		
		
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
	    $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
	   
	    //on clique sur l'element
	    $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
		
		//on verifie que la page d'ajout c'est bien ouverte
		$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
		
		//Pour eviter les problèmes de chargement de chrome et ou de firefox on doit attendre le chargment des java scripts et de la page
		$I->wait(10);
		
		//verification de l'ouverture de la bonne page
		$I->see('Informations Medecin');
		
		
		//verification de la présence du formulaire
		$I->seeElement('/html/body/div[1]/div/div/fieldset/div/center/div/div/form');
		
		
		//remplissage du formulaire et ajout du Medecin avec les parametre suivant
		//NOM : JEAN 
		//PRÉNOM : Patrick
		//SPÉCIALITÉ : Généraliste 
		//NUMÉRO : 5                         ADRESSE : Rue du Pitre
		//CODE POSTAL : 86001        VILLE : Saint Pierre 
		//TÉLÉPHONE : 0501020304
		//MAIL : secretairiaPJ@laposte.fr
		
		// Je rempli le champ "firstname" avec la valeur "Patrick"
        $I->fillField('firstname', 'Patrick');
		
		// Je rempli le champ "lastname" avec la valeur "JEAN"
        $I->fillField('lastname', 'JEAN');
		
		//remplir la région
		$I->selectOption('region', array('value' => '0'));
		
		//remplir le champ de la spécialité
		//champs non présent
		
		
		// Je rempli le champ "Lieux de pratique" avec la valeur "quelque part"
        $I->fillField('LieuMedecin', 'quelque part');

        // Je rempli le champ "Numéro Adeli" avec la valeur "919304097"
        $I->fillField('numAdeli', '919304097');

        // Je rempli le champ "Adresse" avec la valeur "Rue du Pitre"
        $I->fillField('adresseMedecin', 'Rue du Pitre');

        // Je rempli le champ "Code postal" avec la valeur "86001"
        $I->fillField('city', '86001');


        // Je rempli le champ "Ville" avec la valeur "Saint Pierre"
        $I->fillField('state', 'Saint Pierre');        

        // Je rempli le champ "Téléphone" avec la valeur "0501020304"
        $I->fillField('phone', '0501020304');

        // Je rempli le champ "Email" avec la valeur "secretairiaPJ@laposte.fr"
        $I->fillField('email', 'secretairiaPJ@laposte.fr');
		
		
		//on valide le formulaire
		$I->click('form input[type=submit]');
		
		//retour a la page de la liste des docteurs
		$I->switchToWindow();
		
		// Je verifie que je ne suis pas revenut sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
		
		//Je verifie que je trouve bien le texte suivant : Liste des Médecins
        $I->see('Liste des Médecins');
		
		
		
		
		
		
	}
	
	//Test qui vérifie que la flèche retour du formulaire d'ajout d'un médecin nous ramène bien sur la page Liste des medecins.
    public function AjoutMedecinFlecheRetour(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Intervenants fonctionne
		$I->seeElement(Locator::find('input', ['type' => 'button', 'id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
        
        $I->wait(5);
		//essais de cliquer sur le bouton
        $I->click(Locator::find('input', ['type' => 'button', 'id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
		
		
		// Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
	    $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
	   
	    //on clique sur l'element
	    $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
		
		// Je verifie que je suis bien sur la page /PHP/Medecins/AjoutMedecin.php
        //$I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
        
        //Accès au formulaire d'ajout d'un médecin
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $handles=$webdriver->getWindowHandles();
            $last_window = end($handles);
            $webdriver->switchTo()->window($last_window);
       });

        // Je teste que je trouve bien le texte suivant : "Informations Medecin"
        $I->see('Informations Medecin');

        //Test du bouton retour
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/html/body/div[1]/div/div/fieldset/center/legend/a' ) );
		
        //on clique sur le lien et le popup doit se fermer
        $I->click( Locator::href( '/html/body/div[1]/div/div/fieldset/center/legend/a' ) );
		
		//retour a la page de la liste des docteurs
		$I->switchToWindow();
		
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 

		
	}
	
	//Test qui vérifie que nous pouvons jouter un medecin avec les données suivante :
	//NOM : JEA1
	//PRÉNOM : Patrick
	//SPÉCIALITÉ : Généraliste 
	//NUMÉRO : 5                         ADRESSE : Rue du Pitre
	//CODE POSTAL : 86001        VILLE : Saint Pierre 
	//TÉLÉPHONE : 0501020304
	//MAIL : secretairiaPJ@laposte.fr
    public function cas3(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Medecin fonctionne
		$I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
		
		//Pour eviter les problèmes entre chrome et firefox on doit attendre le chargment des java scripts ce qui inclut les onclick
		$I->wait(10);
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Medecin');
		
		
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
		
		
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
	    $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
	   
	    //on clique sur l'element
	    $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
		
		//on verifie que la page d'ajout c'est bien ouverte
		$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
		
		//Pour eviter les problèmes de chargement de chrome et ou de firefox on doit attendre le chargment des java scripts et de la page
		$I->wait(10);
		
		//verification de l'ouverture de la bonne page
		$I->see('Informations Medecin');
		
		
		//verification de la présence du formulaire
		$I->seeElement('/html/body/div[1]/div/div/fieldset/div/center/div/div/form');
		
		
		//remplissage du formulaire et ajout du Medecin avec les parametre suivant
		//NOM : JEA1
		//PRÉNOM : Patrick
		//SPÉCIALITÉ : Généraliste 
		//NUMÉRO : 5                         ADRESSE : Rue du Pitre
		//CODE POSTAL : 86001        VILLE : Saint Pierre 
		//TÉLÉPHONE : 0501020304
		//MAIL : secretairiaPJ@laposte.fr
		
		// Je rempli le champ "firstname" avec la valeur "Patrick"
        $I->fillField('firstname', 'Patrick');
		
		// Je rempli le champ "lastname" avec la valeur "JEA1"
        $I->fillField('lastname', 'JEA1');
		
		//remplir la région
		$I->selectOption('region', array('value' => '0'));
		
		//remplir le champ de la spécialité
		//champs non présent
		
		
		// Je rempli le champ "Lieux de pratique" avec la valeur "quelque part"
        $I->fillField('LieuMedecin', 'quelque part');

        // Je rempli le champ "Numéro Adeli" avec la valeur "5"
        $I->fillField('numAdeli', '5');

        // Je rempli le champ "Adresse" avec la valeur "Rue du Pitre"
        $I->fillField('adresseMedecin', 'Rue du Pitre');

        // Je rempli le champ "Code postal" avec la valeur ""
        $I->fillField('city', '86001');


        // Je rempli le champ "Ville" avec la valeur "Saint Pierre"
        $I->fillField('state', 'Saint Pierre');        

        // Je rempli le champ "Téléphone" avec la valeur "0501020304"
        $I->fillField('phone', '0501020304');

        // Je rempli le champ "Email" avec la valeur "secretairiaPJ@laposte.fr"
        $I->fillField('email', 'secretairiaPJ@laposte.fr');
		
		
		//on valide le formulaire
		$I->click('form input[type=submit]');
		
		// Je verifie que je ne suis pas allez sur la page /PHP/Medecins/ListeMedecin.php
        $I->dontSeeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
		
        //Je verifie que je ne trouve pas le texte suivant : Liste des Médecins
        $I->dontSee('Liste des Médecins');
		
        
		//retour a la page de la liste des docteurs
		$I->switchToWindow();
		
		
		
	}
	
	
	//Test qui vérifie que nous pouvons jouter un medecin avec les données suivante :
	//NOM : JEAN
	//PRÉNOM : Patric3
	//SPÉCIALITÉ : Généraliste 
	//NUMÉRO : 5                         ADRESSE : Rue du Pitre
	//CODE POSTAL : 86001        VILLE : Saint Pierre 
	//TÉLÉPHONE : 0501020304
	//MAIL : secretairiaPJ@laposte.fr

    public function cas4(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Medecin fonctionne
		$I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
		
		//Pour eviter les problèmes entre chrome et firefox on doit attendre le chargment des java scripts ce qui inclut les onclick
		$I->wait(10);
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Medecin');
		
		
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
		
		
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
	    $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
	   
	    //on clique sur l'element
	    $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
		
		//on verifie que la page d'ajout c'est bien ouverte
		$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
		
		//Pour eviter les problèmes de chargement de chrome et ou de firefox on doit attendre le chargment des java scripts et de la page
		$I->wait(10);
		
		//verification de l'ouverture de la bonne page
		$I->see('Informations Medecin');
		
		
		//verification de la présence du formulaire
		$I->seeElement('/html/body/div[1]/div/div/fieldset/div/center/div/div/form');
		
		
		//remplissage du formulaire et ajout du Medecin avec les parametre suivant
		//NOM : JEAN
		//PRÉNOM : Patric3
		//SPÉCIALITÉ : Généraliste 
		//NUMÉRO : 5                         ADRESSE : Rue du Pitre
		//CODE POSTAL : 86001        VILLE : Saint Pierre 
		//TÉLÉPHONE : 0501020304
		//MAIL : secretairiaPJ@laposte.fr
		
		// Je rempli le champ "firstname" avec la valeur "Patric3"
        $I->fillField('firstname', 'Patric3');
		
		// Je rempli le champ "lastname" avec la valeur "JEAN"
        $I->fillField('lastname', 'JEAN');
		
		//remplir la région
		$I->selectOption('region', array('value' => '0'));
		
		//remplir le champ de la spécialité
		//champs non présent
		
		
		// Je rempli le champ "Lieux de pratique" avec la valeur "quelque part"
        $I->fillField('LieuMedecin', 'quelque part');

        // Je rempli le champ "Numéro Adeli" avec la valeur "5"
        $I->fillField('numAdeli', '5');

        // Je rempli le champ "Adresse" avec la valeur "Rue du Pitre"
        $I->fillField('adresseMedecin', 'Rue du Pitre');

        // Je rempli le champ "Code postal" avec la valeur ""
        $I->fillField('city', '86001');


        // Je rempli le champ "Ville" avec la valeur "Saint Pierre"
        $I->fillField('state', 'Saint Pierre');        

        // Je rempli le champ "Téléphone" avec la valeur "0501020304"
        $I->fillField('phone', '0501020304');

        // Je rempli le champ "Email" avec la valeur "secretairiaPJ@laposte.fr"
        $I->fillField('email', 'secretairiaPJ@laposte.fr');
		
		
		//on valide le formulaire
		$I->click('form input[type=submit]');
		
		// Je verifie que je ne suis pas allez sur la page /PHP/Medecins/ListeMedecin.php
        $I->dontSeeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
		
        //Je verifie que je ne trouve pas le texte suivant : Liste des Médecins
        $I->dontSee('Liste des Médecins');
		
        
		//retour a la page de la liste des docteurs
		$I->switchToWindow();
	}
	
	//Test qui vérifie que nous pouvons jouter un medecin avec les données suivante :
	//NOM : JEAN
	/* PRÉNOM : Patrick
	SPÉCIALITÉ : -
	NUMÉRO : 5                         ADRESSE : Rue du Pitre
	CODE POSTAL : 86001        VILLE : Saint Pierre 
	TÉLÉPHONE : 0501020304
	MAIL : secretairiaPJ@laposte.fr */

    public function cas5(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Medecin fonctionne
		$I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
		
		//Pour eviter les problèmes entre chrome et firefox on doit attendre le chargment des java scripts ce qui inclut les onclick
		$I->wait(10);
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Medecin');
		
		
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
		
		
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
	    $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
	   
	    //on clique sur l'element
	    $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
		
		//on verifie que la page d'ajout c'est bien ouverte
		$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
		// Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
		
		//Pour eviter les problèmes de chargement de chrome et ou de firefox on doit attendre le chargment des java scripts et de la page
		$I->wait(10);
		
		//verification de l'ouverture de la bonne page
		$I->see('Informations Medecin');
		
		
		//verification de la présence du formulaire
		$I->seeElement('/html/body/div[1]/div/div/fieldset/div/center/div/div/form');
		
		
		//remplissage du formulaire et ajout du Medecin avec les parametre suivant
		//NOM : JEAN
		/*PRÉNOM : Patrick
		SPÉCIALITÉ : -
		NUMÉRO : 5                         ADRESSE : Rue du Pitre
		CODE POSTAL : 86001        VILLE : Saint Pierre 
		TÉLÉPHONE : 0501020304
		MAIL : secretairiaPJ@laposte.fr */
		
		// Je rempli le champ "firstname" avec la valeur "Patrick"
        $I->fillField('firstname', 'Patrick');
		
		// Je rempli le champ "lastname" avec la valeur "JEAN"
        $I->fillField('lastname', 'JEAN');
		
		//remplir la région
		$I->selectOption('region', array('value' => '0'));
		
		//remplir le champ de la spécialité
		//champs non présent
		
		
		// Je rempli le champ "Lieux de pratique" avec la valeur "quelque part"
        $I->fillField('LieuMedecin', 'quelque part');

        // Je rempli le champ "Numéro Adeli" avec la valeur "5"
        $I->fillField('numAdeli', '5');

        // Je rempli le champ "Adresse" avec la valeur "Rue du Pitre"
        $I->fillField('adresseMedecin', 'Rue du Pitre');

        // Je rempli le champ "Code postal" avec la valeur ""
        $I->fillField('city', '86001');


        // Je rempli le champ "Ville" avec la valeur "Saint Pierre"
        $I->fillField('state', 'Saint Pierre');        

        // Je rempli le champ "Téléphone" avec la valeur "0501020304"
        $I->fillField('phone', '0501020304');

        // Je rempli le champ "Email" avec la valeur "secretairiaPJ@laposte.fr"
        $I->fillField('email', 'secretairiaPJ@laposte.fr');
		
		
		//on valide le formulaire
		$I->click('form input[type=submit]');
		
		// Je verifie que je ne suis pas allez sur la page /PHP/Medecins/ListeMedecin.php
        $I->dontSeeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
		
        //Je verifie que je ne trouve pas le texte suivant : Liste des Médecins
        $I->dontSee('Liste des Médecins');
		
        
		//retour a la page de la liste des docteurs
		$I->switchToWindow();
	}
	
	public function AjoutMedecinCas6(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Medecin fonctionne
        $I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
        
        //Pour eviter les problèmes entre chrome et firefox on doit attendre le chargment des java scripts ce qui inclut les onclick
        $I->wait(10);
        
        //essais de cliquer sur le bouton
        $I->click('Gestion Medecin');
        
        
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
        
        
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
        $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
       
        //on clique sur l'element
        $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
        
        //on verifie que la page d'ajout c'est bien ouverte
        //$I->switchToWindow('PEPS');
        
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
        
        //Pour eviter les problèmes de chargement de chrome et ou de firefox on doit attendre le chargment des java scripts et de la page
        $I->wait(10);
        
        //verification de l'ouverture de la bonne page
        $I->see('Informations Medecin');
        
        
        //verification de la présence du formulaire
        $I->seeElement('/html/body/div[1]/div/div/fieldset/div/center/div/div/form');
        
        
        //remplissage du formulaire et ajout du Medecin avec les parametre suivant
        //NOM : JEAN 
        //PRÉNOM : Patrick
        //SPÉCIALITÉ : Généraliste 
        //NUMÉRO : L                         ADRESSE : Rue du Pitre
        //CODE POSTAL : 86001        VILLE : Saint Pierre 
        //TÉLÉPHONE : 0501020304
        //MAIL : secretairiaPJ@laposte.fr
        
        // Je rempli le champ "firstname" avec la valeur "Patrick"
        $I->fillField('firstname', 'Patrick');
        
        // Je rempli le champ "lastname" avec la valeur "JEAN"
        $I->fillField('lastname', 'JEAN');
        
        //remplir la région
        $I->selectOption('region', array('value' => '0'));
        
        //remplir le champ de la spécialité
        //champs non présent
        
        
        // Je rempli le champ "Lieux de pratique" avec la valeur "quelque part"
        $I->fillField('LieuMedecin', 'quelque part');

        // Je rempli le champ "Numéro Adeli" avec la valeur "919304097"
        $I->fillField('numAdeli', '919304097');

        //Je rempli le numéro de l'adresse 
        //$I->fillField('numeroAdresse', 'L');

        // Je rempli le champ "Adresse" avec la valeur "Rue du Pitre"
        $I->fillField('adresseMedecin', 'Rue du Pitre');

        // Je rempli le champ "Code postal" avec la valeur "86001"
        $I->fillField('city', '86001');


        // Je rempli le champ "Ville" avec la valeur "Saint Pierre"
        $I->fillField('state', 'Saint Pierre');        

        // Je rempli le champ "Téléphone" avec la valeur "0501020304"
        $I->fillField('phone', '0501020304');

        // Je rempli le champ "Email" avec la valeur "secretairiaPJ@laposte.fr"
        $I->fillField('email', 'secretairiaPJ@laposte.fr');
        
        
        //on valide le formulaire
        $I->click('form input[type=submit]');
        
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
        
        
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');
        
        //retour a la page de la liste des docteurs
        $I->switchToWindow();
    }



public function AjoutMedecinCas7(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Medecin fonctionne
        $I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
        
        //Pour eviter les problèmes entre chrome et firefox on doit attendre le chargment des java scripts ce qui inclut les onclick
        $I->wait(10);
        
        //essais de cliquer sur le bouton
        $I->click('Gestion Medecin');
        
        
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
        
        
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
        $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
       
        //on clique sur l'element
        $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
        
        //on verifie que la page d'ajout c'est bien ouverte
        //$I->switchToWindow('PEPS');
        
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
        
        //Pour eviter les problèmes de chargement de chrome et ou de firefox on doit attendre le chargment des java scripts et de la page
        $I->wait(10);
        
        //verification de l'ouverture de la bonne page
        $I->see('Informations Medecin');
        
        
        //verification de la présence du formulaire
        $I->seeElement('/html/body/div[1]/div/div/fieldset/div/center/div/div/form');
        
        
        //remplissage du formulaire et ajout du Medecin avec les parametre suivant
        //NOM : JEAN 
        //PRÉNOM : Patrick
        //SPÉCIALITÉ : Généraliste 
        //NUMÉRO : 5                         ADRESSE : Rue du P7
        //CODE POSTAL : 86001        VILLE : Saint Pierre 
        //TÉLÉPHONE : 0501020304
        //MAIL : secretairiaPJ@laposte.fr
        
        // Je rempli le champ "firstname" avec la valeur "Patrick"
        $I->fillField('firstname', 'Patrick');
        
        // Je rempli le champ "lastname" avec la valeur "JEAN"
        $I->fillField('lastname', 'JEAN');
        
        //remplir la région
        $I->selectOption('region', array('value' => '0'));
        
        //remplir le champ de la spécialité
        //champs non présent
        
        
        // Je rempli le champ "Lieux de pratique" avec la valeur "quelque part"
        $I->fillField('LieuMedecin', 'quelque part');

        // Je rempli le champ "Numéro Adeli" avec la valeur "919304097"
        $I->fillField('numAdeli', '919304097');

        //Je rempli le numéro de l'adresse 
        //$I->fillField('numeroAdresse', '5');

        // Je rempli le champ "Adresse" avec la valeur "Rue du P7"
        $I->fillField('adresseMedecin', 'Rue du P7');

        // Je rempli le champ "Code postal" avec la valeur "86001"
        $I->fillField('city', '86001');

        // Je rempli le champ "Ville" avec la valeur "Saint Pierre"
        $I->fillField('state', 'Saint Pierre');        

        // Je rempli le champ "Téléphone" avec la valeur "0501020304"
        $I->fillField('phone', '0501020304');

        // Je rempli le champ "Email" avec la valeur "secretairiaPJ@laposte.fr"
        $I->fillField('email', 'secretairiaPJ@laposte.fr');
        
        //on valide le formulaire
        $I->click('form input[type=submit]');
        
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->dontSeeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
        
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->dontSee('Liste des Médecins');
        
        //retour a la page de la liste des docteurs
        $I->switchToWindow();
        
    }



public function AjoutMedecinCas8(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Medecin fonctionne
        $I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
        
        //Pour eviter les problèmes entre chrome et firefox on doit attendre le chargment des java scripts ce qui inclut les onclick
        $I->wait(10);
        
        //essais de cliquer sur le bouton
        $I->click('Gestion Medecin');
        
        
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
        
        
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
        $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
       
        //on clique sur l'element
        $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
        
        //on verifie que la page d'ajout c'est bien ouverte
        //$I->switchToWindow('PEPS');
        
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
        
        //Pour eviter les problèmes de chargement de chrome et ou de firefox on doit attendre le chargment des java scripts et de la page
        $I->wait(10);
        
        //verification de l'ouverture de la bonne page
        $I->see('Informations Medecin');
        
        
        //verification de la présence du formulaire
        $I->seeElement('/html/body/div[1]/div/div/fieldset/div/center/div/div/form');
        
        
        //remplissage du formulaire et ajout du Medecin avec les parametre suivant
        //NOM : JEAN 
        //PRÉNOM : Patrick
        //SPÉCIALITÉ : Généraliste 
        //NUMÉRO : 5                         ADRESSE : Rue du Pitre
        //CODE POSTAL : 8600         VILLE : Saint Pierre 
        //TÉLÉPHONE : 0501020304
        //MAIL : secretairiaPJ@laposte.fr
        
        // Je rempli le champ "firstname" avec la valeur "Patrick"
        $I->fillField('firstname', 'Patrick');
        
        // Je rempli le champ "lastname" avec la valeur "JEAN"
        $I->fillField('lastname', 'JEAN');
        
        //remplir la région
        $I->selectOption('region', array('value' => '0'));
        
        //remplir le champ de la spécialité
        //champs non présent
        
        
        // Je rempli le champ "Lieux de pratique" avec la valeur "quelque part"
        $I->fillField('LieuMedecin', 'quelque part');

        // Je rempli le champ "Numéro Adeli" avec la valeur "919304097"
        $I->fillField('numAdeli', '919304097');

        //Je rempli le numéro de l'adresse 
        //$I->fillField('numeroAdresse', '5');

        // Je rempli le champ "Adresse" avec la valeur "Rue du Pitre"
        $I->fillField('adresseMedecin', 'Rue du Pitre');

        // Je rempli le champ "Code postal" avec la valeur "8600 "
        $I->fillField('city', '8600 ');

        // Je rempli le champ "Ville" avec la valeur "Saint Pierre"
        $I->fillField('state', 'Saint Pierre');        

        // Je rempli le champ "Téléphone" avec la valeur "0501020304"
        $I->fillField('phone', '0501020304');

        // Je rempli le champ "Email" avec la valeur "secretairiaPJ@laposte.fr"
        $I->fillField('email', 'secretairiaPJ@laposte.fr');
        
        //on valide le formulaire
        $I->click('form input[type=submit]');
        
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->dontSeeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
        
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->dontSee('Liste des Médecins');
        
        //retour a la page de la liste des docteurs
        $I->switchToWindow();
        
    }





public function AjoutMedecinCas9(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Medecin fonctionne
        $I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
        
        //Pour eviter les problèmes entre chrome et firefox on doit attendre le chargment des java scripts ce qui inclut les onclick
        $I->wait(10);
        
        //essais de cliquer sur le bouton
        $I->click('Gestion Medecin');
        
        
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
        
        
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
        $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
       
        //on clique sur l'element
        $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
        
        //on verifie que la page d'ajout c'est bien ouverte
        //$I->switchToWindow('PEPS');
        
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
        
        //Pour eviter les problèmes de chargement de chrome et ou de firefox on doit attendre le chargment des java scripts et de la page
        $I->wait(10);
        
        //verification de l'ouverture de la bonne page
        $I->see('Informations Medecin');
        
        
        //verification de la présence du formulaire
        $I->seeElement('/html/body/div[1]/div/div/fieldset/div/center/div/div/form');
        
        
        //remplissage du formulaire et ajout du Medecin avec les parametre suivant
        //NOM : JEAN 
        //PRÉNOM : Patrick
        //SPÉCIALITÉ : Généraliste 
        //NUMÉRO : 5                         ADRESSE : Rue du Pitre
        //CODE POSTAL : 86001         VILLE : Saint Pierre 
        //TÉLÉPHONE : 050102035
        //MAIL : secretairiaPJ@laposte.fr
        
        // Je rempli le champ "firstname" avec la valeur "Patrick"
        $I->fillField('firstname', 'Patrick');
        
        // Je rempli le champ "lastname" avec la valeur "JEAN"
        $I->fillField('lastname', 'JEAN');
        
        //remplir la région
        $I->selectOption('region', array('value' => '0'));
        
        //remplir le champ de la spécialité
        //champs non présent
        
        
        // Je rempli le champ "Lieux de pratique" avec la valeur "quelque part"
        $I->fillField('LieuMedecin', 'quelque part');

        // Je rempli le champ "Numéro Adeli" avec la valeur "919304097"
        $I->fillField('numAdeli', '919304097');

        //Je rempli le numéro de l'adresse 
        //$I->fillField('numeroAdresse', '5');

        // Je rempli le champ "Adresse" avec la valeur "Rue du Pitre"
        $I->fillField('adresseMedecin', 'Rue du Pitre');

        // Je rempli le champ "Code postal" avec la valeur "8600 "
        $I->fillField('city', '8600 ');

        // Je rempli le champ "Ville" avec la valeur "Saint Pierre"
        $I->fillField('state', 'Saint Pierre');        

        // Je rempli le champ "Téléphone" avec la valeur "0501020304"
        $I->fillField('phone', '050102035');

        // Je rempli le champ "Email" avec la valeur "secretairiaPJ@laposte.fr"
        $I->fillField('email', 'secretairiaPJ@laposte.fr');
        
        //on valide le formulaire
        $I->click('form input[type=submit]');
        
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->dontSeeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
        
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->dontSee('Liste des Médecins');
        
        //retour a la page de la liste des docteurs
        $I->switchToWindow();
        
    }




public function AjoutMedecinCas10(AcceptanceTester $I)
    {

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Paramètres supplémentaires');

        //Test si le boutton Gestion Medecin fonctionne
        $I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
        
        //Pour eviter les problèmes entre chrome et firefox on doit attendre le chargment des java scripts ce qui inclut les onclick
        $I->wait(10);
        
        //essais de cliquer sur le bouton
        $I->click('Gestion Medecin');
        
        
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
        
        
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');

        //on cherche a voir le lien Ajouter un médecin
        $I->seeElement('//a[contains(text(),\'Ajouter un médecin\')]' );
       
        //on clique sur l'element
        $I->click('//a[contains(text(),\'Ajouter un médecin\')]' );
        
        //on verifie que la page d'ajout c'est bien ouverte
        //$I->switchToWindow('PEPS');
        
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php'); 
        
        //Pour eviter les problèmes de chargement de chrome et ou de firefox on doit attendre le chargment des java scripts et de la page
        $I->wait(10);
        
        //verification de l'ouverture de la bonne page
        $I->see('Informations Medecin');
        
        
        //verification de la présence du formulaire
        $I->seeElement('/html/body/div[1]/div/div/fieldset/div/center/div/div/form');
        
        
        //remplissage du formulaire et ajout du Medecin avec les parametre suivant
        //NOM : JEAN 
        //PRÉNOM : Patrick
        //SPÉCIALITÉ : Généraliste 
        //NUMÉRO : 5                         ADRESSE : Rue du Pitre
        //CODE POSTAL : 86001         VILLE : Saint Pierre 
        //TÉLÉPHONE : 0501020304
        //MAIL : secretairiaPJ@laposte.uk
        
        // Je rempli le champ "firstname" avec la valeur "Patrick"
        $I->fillField('firstname', 'Patrick');
        
        // Je rempli le champ "lastname" avec la valeur "JEAN"
        $I->fillField('lastname', 'JEAN');
        
        //remplir la région
        $I->selectOption('region', array('value' => '0'));
        
        //remplir le champ de la spécialité
        //champs non présent
        
        
        // Je rempli le champ "Lieux de pratique" avec la valeur "quelque part"
        $I->fillField('LieuMedecin', 'quelque part');

        // Je rempli le champ "Numéro Adeli" avec la valeur "919304097"
        $I->fillField('numAdeli', '919304097');

        //Je rempli le numéro de l'adresse 
        //$I->fillField('numeroAdresse', '5');

        // Je rempli le champ "Adresse" avec la valeur "Rue du Pitre"
        $I->fillField('adresseMedecin', 'Rue du Pitre');

        // Je rempli le champ "Code postal" avec la valeur "8600 "
        $I->fillField('city', '8600 ');

        // Je rempli le champ "Ville" avec la valeur "Saint Pierre"
        $I->fillField('state', 'Saint Pierre');        

        // Je rempli le champ "Téléphone" avec la valeur "0501020304"
        $I->fillField('phone', '0501020304');

        // Je rempli le champ "Email" avec la valeur "secretairiaPJ@laposte.fr"
        $I->fillField('email', 'secretairiaPJ@laposte.uk');
        
        //on valide le formulaire
        $I->click('form input[type=submit]');
        
        // Je verifie que je suis bien sur la page /PHP/Medecins/ListeMedecin.php
        $I->dontSeeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 
        
        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->dontSee('Liste des Médecins');
        
        //retour a la page de la liste des docteurs
        $I->switchToWindow();
        
    }

}