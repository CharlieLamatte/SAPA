<?php
//***
//Ce test permet de vérifier si la page de setting est bien accessible, depuis la page d'accueil du site, en passant pas le bouton réglage et arrivant sur la page de paramètre. 
//Sur cette page, l'on peut voir qu'il y a écrit : Paramètres supplémentaires. Ce test permet donc de vérifier que nous allons bien sur cette page web. 
//***

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class BouttonDeLaPageSettingCest  // /!\ Cest est obligatoire après le nom de la classe
{
	
    //Test qui vérifie que nous pouvons aller sur la page paramètre afin de cliquer sur le bouton Gestion Intervenants
    public function Bouton1Setting(AcceptanceTester $I)
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
		$I->seeElement(Locator::find('input', ['id'=>'boutonAutre','value'=>'Gestion Intervenants'] ));
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Intervenants');
		
		
		// Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Intervenants/ListeIntervenant.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Intervenants');
	}
	
	//Test qui vérifie que nous pouvons aller sur la page paramètre afin de cliquer sur le bouton Gestion Responsable
    public function Bouton2Setting(AcceptanceTester $I)
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
		$I->seeElement(Locator::find('input', ['id'=>'boutonAutre','value'=>'Gestion Responsables'] ));
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Responsables');
		
		
		// Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Responsables/ListeResponsable.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Responsables');
	}
	
	//Test qui vérifie que nous pouvons aller sur la page paramètre afin de cliquer sur le bouton Gestion Structures
    public function Bouton3Setting(AcceptanceTester $I)
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
		
		//Test si le boutton Gestion Structures fonctionne
		$I->seeElement(Locator::find('input', ['id'=>'boutonAutre','value'=>'Gestion Structures'] ));
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Structures');
		
		
		// Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Centres/ListeCentre.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Structures');
	}
	
	//Test qui vérifie que nous pouvons aller sur la page paramètre afin de cliquer sur le bouton Gestion Lieu
    public function Bouton4Setting(AcceptanceTester $I)
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
		$I->seeElement(Locator::find('input', ['id'=>'boutonAutre','value'=>'Gestion Lieu'] ));
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Lieu');
		
		
		// Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Lieux/ListeLieu.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des lieux de pratiques');
	}
	
	//Test qui vérifie que nous pouvons aller sur la page paramètre afin de cliquer sur le bouton Gestion Medecin
    public function Bouton5Setting(AcceptanceTester $I)
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
		$I->seeElement(Locator::find('input', ['id'=>'boutonMedecin','value'=>'Gestion Medecin'] ));
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Medecin');
		
		
		// Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Medecins/ListeMedecin.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Médecins');
	}
	
	//Test qui vérifie que nous pouvons aller sur la page paramètre afin de cliquer sur le bouton Gestion Creneaux
    public function Bouton6Setting(AcceptanceTester $I)
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
		$I->seeElement(Locator::find('input', ['id'=>'boutonCreneaux','value'=>'Gestion Creneaux'] ));
		
		//essais de cliquer sur le bouton
		$I->click('Gestion Creneaux');
		
		
		// Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/Creneaux/ListeCreneau.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Liste des Créneaux ');
	}
	
	//Test qui vérifie que nous pouvons aller sur la page paramètre afin de cliquer sur le bouton Statistiques
    public function Bouton7Setting(AcceptanceTester $I)
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
		$I->seeElement(Locator::find('input', ['id'=>'boutonStats','value'=>'Statistiques'] ));
		
		//essais de cliquer sur le bouton
		$I->click('Statistiques');
		
		
		// Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/Settings/Statistiques.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Données Statistiques');
	}
	
	//Test qui vérifie que nous pouvons aller sur la page paramètre afin de cliquer sur le bouton Mon compte
    public function Bouton8Setting(AcceptanceTester $I)
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
		$I->seeElement(Locator::find('input', ['id'=>'boutonAutre','value'=>'Mon compte'] ));
		
		//essais de cliquer sur le bouton
		$I->click('Mon compte');
		
		
		// Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/ModifCoordinateur.php'); 

        //Je verifie que je trouve bien le texte suivant : Paramètres supplémentaires
        $I->see('Modifier ses informations');
	}
	
	//Test qui vérifie que nous pouvons aller sur la page paramètre afin de cliquer sur la fleche de retour à la page d'accueil
    public function FlecheRetourSetting(AcceptanceTester $I)
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
		
		
		
		//Test si la fleche de retour à l'accueil est présente
		$I->seeElement('/html/body/div[1]/fieldset/center[1]/legend/a');
		
		//clique sur la fleche
		$I->click('/html/body/div[1]/fieldset/center[1]/legend/a');
		
		// Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');

        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
		
	}
	
}