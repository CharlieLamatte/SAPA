<?php
//Dans ce fichier, nous testons la page des responsables et notamment le bouton modifier qui permet la modification d'information d'un intervenant

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class GestionResponsables_ModificationCest  // /!\ Cest est obligatoire après le nom de la classe
{
    public function GR_modificationResponsables(AcceptanceTester $I)
	//ce test est correct
	//lorsqu'on clique sur ce bouton, on est rediriger vers la page ModifIntervenant.php
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
		
		//Test du bouton modifier
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="table_id"]/tbody/tr[1]/td[5]/a');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="table_id"]/tbody/tr[1]/td[5]/a');
		
		//on verifie que la page d'ajout c'est bien ouverte et on se place sur cette page
		$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
        $handles=$webdriver->getWindowHandles();
        $last_window = end($handles);
        $webdriver->switchTo()->window($last_window);
        });

		//verification de la redirection vers la page AjoutIntervenant.php
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/ModifResponsable.php');			
	}			
}