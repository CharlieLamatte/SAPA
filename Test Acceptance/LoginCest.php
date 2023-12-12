<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class LoginCest  // /!\ Cest est obligatoire après le nom de la classe
{
	//Cette classe permet de tester les différents paramettre du login
	//en cas d'erreur 2 cas sont possibles,
	//si il manque un champs on dira que l'un des champs est non renseigné
	//sinon on dira que les parametres sont incorrect.
	
    public function LoginParametreCorrect(AcceptanceTester $I)
    {
		//Test avec les parametres valide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mail et du mot de passe avec les valeurs d'un utilisateur existant et on vérifie que l'on arrive bien sur la page d'accueil
		
		
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
		
		
    }
	
	public function FauxMDP(AcceptanceTester $I)
    {
		//Test avec les parametres invalide avec un faux mot de passe
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mail et du mot de passe avec les valeurs d'un utilisateur existant mais un mot de passe faux 
		//et on vérifie que l'on a un message d'erreur indiquant "Adresse mail ou mot de passe incorrect !"
		
		
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
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "123456789azer"
        $I->fillField('pswd', '123456789azer');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je ne suis bien sur la page PHP/Accueil.php
        $I->dontSeeInCurrentUrl('PHP/Accueil_liste.php');
	
		// Je vérifie que je ne suis plu sur index.php
        $I->dontSeeInCurrentUrl('/index.php');
	
		// Je suis bien sur Connexion_ErrorEmail.php
		$I->SeeInCurrentUrl('/PHP/Connexion_ErrorEmail.php');	

        // Je teste que je ne trouve pas le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');

		// Je teste que je ne trouve pas le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->dontSee('Adresse mail ou mot de passe non renseigné !');
	
		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe incorrect !"
        $I->see('Adresse mail ou mot de passe incorrect !');
		
		
    }
	
	public function IdSansMail(AcceptanceTester $I)
    {
		//Test avec les parametres invalide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mail et du mot de passe avec les valeurs d'un utilisateur existant mais un identifiant n'étant pas un mail
		//et on vérifie que l'on a un message d'erreur indiquant "Adresse mail ou mot de passe incorrect !"
		
		
		
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

        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "essai"
        $I->fillField('identifiant', 'essai');
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je ne suis pas sur la page PHP/Accueil.php
        $I->dontSeeInCurrentUrl('PHP/Accueil_liste.php');

		// Je vérifie que je ne suis plu sur index.php
        $I->dontSeeInCurrentUrl('/index.php');
	
		// Je suis bien sur Connexion_ErrorEmail.php
		$I->SeeInCurrentUrl('/PHP/Connexion_ErrorEmail.php');

        // Je teste que je ne trouve pas le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');

		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->dontSee('Adresse mail ou mot de passe non renseigné !');
	
		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe incorrect !"
        $I->see('Adresse mail ou mot de passe incorrect !');	
		
    }

	public function FauxId(AcceptanceTester $I)
	{
		//Test avec les parametres invalide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mail et du mot de passe avec les valeurs d'un utilisateur existant mais avec mail qui n'est pas enregistré 
		//et on vérifie que l'on a un message d'erreur indiquant "Adresse mail ou mot de passe incorrect !"
		
		
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

        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "essai@gmail.com"
        $I->fillField('identifiant', 'essai@gmail.com');
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je ne suis pas sur la page PHP/Accueil.php
        $I->dontSeeInCurrentUrl('PHP/Accueil_liste.php');

		// Je vérifie que je ne suis plu sur index.php
        $I->dontSeeInCurrentUrl('/index.php');
	
		// Je suis bien sur Connexion_ErrorEmail.php
		$I->SeeInCurrentUrl('/PHP/Connexion_ErrorEmail.php');

        // Je teste que je ne trouve pas le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');

		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->dontSee('Adresse mail ou mot de passe non renseigné !');
	
		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe incorrect !"
        $I->see('Adresse mail ou mot de passe incorrect !');	
		
    }
	
	public function MDP_MAIL_troplong(AcceptanceTester $I)
	{
		//Test avec les parametres invalide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on tente de remplir les champs du mail et du mot de passe avec les valeurs très longue (nombre de caratère > 30)
		//on s'attend à un blocage de la saisie et l'affichage de l'erreur 'identifiant trop long'
		
		
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

        // Je rempli le champ "identifiant" 
        $I->fillField('identifiant', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
	
		// Il faut que ça me bloque avant ! et affichage d'un message d'alerte
		$I->see('identifiant trop long');
		
    }
	public function MDP_MAIL_tropcourt(AcceptanceTester $I)
    {
		//Test avec les parametres invalide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mail et du mot de passe avec les valeurs d'un utilisateur existant mais avec valeur tronqué et donc qui ne sont pas enregistrés 
		//et on vérifie que l'on a un message d'erreur indiquant "Adresse mail ou mot de passe incorrect !"
		
		
		
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

        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "essa"
        $I->fillField('identifiant', 'essa');
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR"
        $I->fillField('pswd', 'hjR');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je ne suis pas sur la page PHP/Accueil.php
        $I->dontSeeInCurrentUrl('PHP/Accueil_liste.php');

		// Je vérifie que je ne suis plu sur index.php
        $I->dontSeeInCurrentUrl('/index.php');
	
		// Je suis bien sur Connexion_ErrorEmail.php
		$I->SeeInCurrentUrl('/PHP/Connexion_ErrorEmail.php');

        // Je teste que je ne trouve pas le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');

		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->dontSee('Adresse mail ou mot de passe non renseigné !');
	
	// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe incorrect !"
        $I->see('Adresse mail ou mot de passe incorrect !');
		
		
    }
	
	public function RienRempli(AcceptanceTester $I)
    {
		//Test avec les parametres invalide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on ne remplit aucun des champs du mail et du mot de passe et on essais de se connecter
		//et que l'on a un message d'erreur indiquant "Adresse mail ou mot de passe non renseigné !"
		
		
		
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
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je ne suis pas sur la page PHP/Accueil.php
        $I->dontSeeInCurrentUrl('PHP/Accueil_liste.php');

		// Je vérifie que je ne suis plu sur index.php
        $I->dontSeeInCurrentUrl('/index.php');
	
		// Je suis bien sur Connexion_ErrorEmail.php
		$I->SeeInCurrentUrl('/PHP/Connexion_ErrorEmail.php');

        // Je teste que je ne trouve pas le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');
	
		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->see('Adresse mail ou mot de passe non renseigné !');
		
		
		
    }
	
	public function DoubleFail(AcceptanceTester $I)
    {
		//Test avec les parametres invalide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mail et du mot de passe avec les valeurs incorrect 
		//et on vérifie que l'on a un message d'erreur indiquant "Adresse mail ou mot de passe incorrect !"
		//on effectue cette manoeuvre 2 fois pour vérifier que l'on est bien sur la page de login avec l'erreur
		
		
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
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "123456789azer"
        $I->fillField('pswd', '123456789azer');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je ne suis bien sur la page PHP/Accueil.php
        $I->dontSeeInCurrentUrl('PHP/Accueil_liste.php');
	
		// Je vérifie que je ne suis plu sur index.php
        $I->dontSeeInCurrentUrl('/index.php');
	
		// Je suis bien sur Connexion_ErrorEmail.php
		$I->SeeInCurrentUrl('/PHP/Connexion_ErrorEmail.php');	

        // Je teste que je ne trouve pas le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');

		// Je teste que je ne trouve pas le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->dontSee('Adresse mail ou mot de passe non renseigné !');
	
		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe incorrect !"
        $I->see('Adresse mail ou mot de passe incorrect !');
		
		// Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Connexion"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Connexion']);

        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "test@gmail.com"
        $I->fillField('identifiant', 'test@gmail.com');
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "123456789azer"
        $I->fillField('pswd', '123456789azer');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

	
		// Je vérifie que je ne suis plu sur index.php
        $I->dontSeeInCurrentUrl('/index.php');
	
		// Je suis bien sur Connexion_ErrorEmail.php
		$I->SeeInCurrentUrl('/PHP/Connexion_ErrorEmail.php');	

        // Je teste que je ne trouve pas le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');

		// Je teste que je ne trouve pas le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->dontSee('Adresse mail ou mot de passe non renseigné !');
	
		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe incorrect !"
        $I->see('Adresse mail ou mot de passe incorrect !');
		
    }
	public function testPaloma1MailInexistant(AcceptanceTester $I)
    {
		//Test avec les parametres invalide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mot de passe avec les valeurs d'un utilisateur existant 
		//et on vérifie que l'on a un message d'erreur indiquant "Adresse mail ou mot de passe non renseigné !"
		
		
		
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

        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "paloma@gmail.com"
        $I->fillField('identifiant', 'paloma@gmail.com');
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->dontSeeInCurrentUrl('PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');
		
		// Je teste que je trouve le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->see('Adresse mail ou mot de passe non renseigné !');
    }
	
	public function testPaloma2MailRemplacerParChiffre(AcceptanceTester $I)
    {
		//Test avec les parametres invalide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mail et du mot de passe avec les valeurs d'un utilisateur existant pour le mot de passe mais on remplace sont mail par des chiffres
		//et on vérifie que l'on a un message d'erreur indiquant "Adresse mail ou mot de passe incorrect !"
		
		
		
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

        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "12345"
		$I->fillField('identifiant', '12345');
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->dontSeeInCurrentUrl('PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');
		
		// Je teste que je ne trouve pas le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->dontSee('Adresse mail ou mot de passe non renseigné !');
	
		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe incorrect !"
        $I->see('Adresse mail ou mot de passe incorrect !');
    }
	
	
	
	
	
	public function testGabrielCaracteresSpeciaux(AcceptanceTester $I)
    {
		//Test avec les parametres invalide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mail et du mot de passe avec les valeurs d'un utilisateur existant mais on utilise des caracteres spéciaux à la place du mot de passe
		//et on vérifie que l'on a un message d'erreur indiquant "Adresse mail ou mot de passe incorrect !"
		
		
		
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

        // Je rempli le champ "identifiant" (champ de l'adresse mail)
        $I->fillField('identifiant', 't');
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec des caracteres speciaux
        $I->fillField('pswd', 'a?/§*^:145+é');
		
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->dontSeeInCurrentUrl('PHP/Accueil_liste.php');
        // Je teste que je ne trouve pas le texte suivant : "Bonjour TEST Prénom"
        $I->dontSee('Bonjour TEST Prénom');

        // Je suis bien sur Connexion_ErrorEmail.php
		$I->SeeInCurrentUrl('/PHP/Connexion_ErrorEmail.php');

        // Je teste que je ne trouve pas le texte suivant : "Adresse mail ou mot de passe non renseigné !"
        $I->dontSee('Adresse mail ou mot de passe non renseigné !');
	
		// Je teste que je trouve bien le texte suivant : "Adresse mail ou mot de passe incorrect !"
        $I->see('Adresse mail ou mot de passe incorrect !');

    }
	
	public function testSarahMailsansArobase(AcceptanceTester $I)
    {
		
		//Test avec les parametres invalide
		//on commence par vérifier qu'on est bien sur la page d'index qui contient le formulaire du login,
		//puis on remplit les champs du mail et du mot de passe avec les valeurs d'un utilisateur existant mais on enlève le @ du mail
		//et on vérifie que l'on a un message d'erreur indiquant "Adresse mail ou mot de passe incorrect !"
		
		
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

        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "testgmail.com" sans le @
        $I->fillField('identifiant', 'testgmail.com');
		
		// Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
		
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
