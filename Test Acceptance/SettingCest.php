<?php
//***
//Ce test permet de vérifier si la page de setting est bien accessible, depuis la page d'accueil du site, en passant pas le bouton réglage et arrivant sur la page de paramètre. 
//Sur cette page, l'on peut voir qu'il y a écrit : Paramètres supplémentaires. Ce test permet donc de vérifier que nous allons bien sur cette page web. 
//***

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class SettingCest  // /!\ Cest est obligatoire après le nom de la classe
{
	
    //Test qui vérifie que nous pouvons aller sur la page paramètre afin de visualiser les différentes informations nécessaire. Et retourner à la page Accueil_liste.php
    public function SettingCestCorrectAlix(AcceptanceTester $I)
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

        //Je teste le retour à la page d'accueil (Accueil_liste.php)
        //Vérification de la presence du lien 
         $I->seeElement( Locator::href( '/PHP/Accueil_liste.php' ) );

        //on clique sur le lien 
        $I->click( Locator::href( '/PHP/Accueil_liste.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php'); 

	}
}