<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class InjectionCodeCest  // /!\ Cest est obligatoire après le nom de la classe
{
	//Cette classe permet de tester les les injection de code dans un formulaire donné
	//on trouve le formulaire de la page
	//puis on effectue l'inejction de code dans l'un des champs du formulaire
	//et on vérifie qu'il y ai bien un message d'erreur indiquant que le mot de passe ou mail sont incorrect
	
    public function LoginInjection(AcceptanceTester $I)
    {
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mail et du mot de passe 
		//dans le champ du mot de passe on ne remplit rien
		//dans le champs du mail on mail le mail correct suivi de " ‘ and pswd= ‘pswd’ or 1=1;  -- " qui formera la requete
		
		
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

        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "test@gmail.com\' and pswd= ‘pswd’ or 1=1;  --"
        $I->fillField('identifiant', 'test@gmail.com\' and pswd= ‘pswd’ or 1=1;  --'); 
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'zzqqzdzqdqzdq');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je ne suis pas sur la page PHP/Accueil.php
        $I->dontSeeInCurrentUrl('PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');
		
		// Je teste que je ne trouve pas le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->dontSee('Adresse mail ou mot de passe non renseigné !');
	
		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe incorrect !"
        $I->see('Adresse mail ou mot de passe incorrect !');
		
		
    }

}
