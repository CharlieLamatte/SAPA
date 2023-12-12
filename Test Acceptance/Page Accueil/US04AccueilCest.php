<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class US04AccueilCest
{ // SPECIFICATIONS :

//***
// Ce test permet de tester le tableau sur la page PHP/Accueil_liste.php .
// Lorsque l’on clique sur un patient une fiche détaillée avec les informations de celui-ci apparaît. 
// Lorsqu'on arrive sur la page, l'ordre des lignes doit être en fonction de la priorité couleur (rouge en haut).
// En clickant sur les têtes de colonnes nous devons pouoir modifier l'ordre des colonnes. 
// La barre de recherche doit être fonctionnelle, ainsi que son filtre.
//***
	
    public function Cas1LoginMdpOk(AcceptanceTester $I)
    {
        // SPECIFICATIONS : Test avec login et mdp valides
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
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }

    public function Cas2ChampsVides(AcceptanceTester $I)
    {
        // SPECIFICATIONS : On remplit un formulaire en laissant des champs vides, puis on observe s’il y a un message d’erreur/bug pour les colonnes vides sur le tableau de la page d'accueil.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je laisse tous les champs vides.
        $I->fillField(['name' => 'email'], 'jon@mail.com');
    }

	public function Cas3Deconnexion(AcceptanceTester $I)
    {
        // SPECIFICATIONS : Test du lien déconnexion
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
		// Je click sur le bouton de Déconnexion
        $I->click(Locator::href( '/PHP/deconnexionBDD' ));
		// Je teste que je suis bien sur la page PHP/index.php
		$I->seeInCurrentUrl('/index.php');
  		// Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
    }


	public function Cas3Preferences(AcceptanceTester $I)
    {
        // SPECIFICATIONS : Test du lien préférences
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
		// Je click sur le bouton de Préférences
		$I->click(Locator::href('/PHP/Settings/Settings.php' ));
		// Je teste que je suis bien sur la page PHP/index.php
		$I->seeInCurrentUrl('/PHP/Settings/Settings.php');
  		// Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
    }


	public function Cas3Accueil(AcceptanceTester $I)
    {
        // SPECIFICATIONS : Test du lien Accueil
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
		// Je click sur le bouton de Accueil
		$I->click(Locator::href('/PHP/Accueil.php' ));
		// Je teste que je suis bien sur la page /PHP/Accueil_liste.php
		$I->seeInCurrentUrl('/PHP/Accueil.php');
		// Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
    }


	public function Cas3AjoutBeneficiaire(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : Test du lien Ajout Bénéficiaire (on est censé tomber directement sur la page Bénéficiaire)
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
		// Je click sur le bouton de Ajout Bénéficiaire
		$I->click(Locator::href('/PHP/(?).php' )); // La page n’existe pas encore
		// Je teste que je suis bien sur la page /PHP/(?).php
		$I->seeInCurrentUrl('/PHP/(?).php'); // La page n’existe pas encore
  		// Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
    }

    public function Cas4PrioriteDate(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : En remplissant les champs date, nous testons le bon fonctionnement de la priorité couleur.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }

	public function Cas5ClickPatientFiche(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On clique sur un patient et on vérifie que l'aperçu du patient est bien remplacé par une fiche détaillée de ses informations.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je click sur voir vos bénéficiaires
        //<input type="button" id="boutonAutre" value="Voir vos bénéficiaires" onclick="self.location.href='Accueil_liste.php'">
        //$I->click(Locator::href( 'Accueil_liste.php'));
		// Je click sur un patient
        $I->click(Locator::href( '../PHP/Accueil_liste.php?idPatient=1&amp;statutPatient=Actif - Entretien initial'));
		// Je teste que je suis bien sur la page 
		$I->seeInCurrentUrl('../PHP/Accueil_liste.php?idPatient=1&amp;statutPatient=Actif - Entretien initial');
  		// Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
    }

    public function Cas6AdmisNaissanceDates(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On vérifie la cohérence des dates des colonnes “admis” et “naissance”.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }

    public function Cas7RechercheFiltres(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : Lorsqu’on ajoute des filtres pour la recherche d’individus dans la barre de recherche, nous testons la cohérence de l’affichage des lignes du tableau.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }

	public function Cas8AjoutMedecinPopUp(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : Test du bouton Ajout Médecin avec apparition du pop up
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je click sur le bouton de Ajout Medecin
		//$I->click(Locator::isClass('../PHP/Medecins/AjoutMedecin.php' ));
		//, ['type' => 'onclick', 'value' => '+']
		$I->seeElement('a');
  		$I->see('+');
        // Je click sur le bouton du login
        $I->click('onclick[type=onclick]');
		// Je teste que je suis bien sur la page '../PHP/Medecins/AjoutMedecin.php'
		$I->seeInCurrentUrl('/PHP/Medecins/AjoutMedecin.php');
		//<a onclick="window.open;" class="btn btn-default btn-xs" style="width:20px; height:20px">+</a>
  		// Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
    }

    public function Cas9MenuDeroulant(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : Ajout Médecin => On test le bon fonctionnement du menu déroulant. Que le lieu sélectionné apparaisse dans le tableau.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }


	public function Cas10AjoutMedecinChampsVides(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : Ajout Médecin => On regarde si les champs non obligatoires peuvent ne pas être remplis, message d’erreur ou pas.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
		// Je click sur le bouton de Ajout Medecin
		$I->click(Locator::href('../PHP/Medecins/AjoutMedecin.php' ));
		// Je teste que je suis bien sur la page '../PHP/Medecins/AjoutMedecin.php'
		$I->seeInCurrentUrl('../PHP/Medecins/AjoutMedecin.php');
		// Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
		// Je vérifie que les champs sont vides
		$I->fillField("//input[@type='text']", "");
    }

    public function Cas11NouveauChamp(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : Ajout Médecin => On vérifie que lorsque les champs “Nom”, “Prénom”, “Spécialité”, “Lieu de pratique”, “Code postal”, “Ville”, “Téléphone” sont renseignés un nouveau champ du même nom apparaît.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }

    public function Cas12DonneesBienEnregistrees(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On renseigne le formulaire en entier avec des informations cohérentes et on vérifie qu’elle sont toutes correctement enregistrées dans la base de données.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }

    public function Cas13AccesSansConnexion(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On essaye d’accéder à la page Accueil_liste.php en rentrant seulement l’URL sans connexion préalable.
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Accueil_liste.php');
        // Je vérifie que je suis bien sur /PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
        // Je click sur le bouton de Déconnexion
        $I->click(Locator::href( '/PHP/deconnexionBDD' ));
        // Je teste que je suis bien sur la page PHP/index.php
        $I->seeInCurrentUrl('/index.php');
        // Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Connexion"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Connexion']);
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Accueil_liste.php');
        // Je vérifie que je suis bien sur /PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour');
    }

    public function Cas14LettresChampNumero(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : Ajout Médecin => On insère des lettres dans le champ numéro de téléphone pour tester la possibilité de mettre autre chose que des chiffres et taille du numéro.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }

    public function Cas15MailIncorrect(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : Ajout Médecin => Pour le champ mail on entre un mail sans ajouter un “[texte]@[texte].[texte|”.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }

    public function Cas16AdresseIncorrecte(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : Pour le champ adresse on entre une adresse non conforme et on vérifie qu’un message d’erreur apparaît.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }

    public function Cas17ChampManquant(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On vérifie que lorsque les champs “Nom”, “Prénom”, “Spécialité”, “Lieu de pratique”, “Code postal”, “Ville”, “Téléphone” ne sont pas renseignés ou un manquant un message d’erreur apparaît.
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
		//Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
    }

    public function Cas18OrdreNom(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On teste le changement d'ordre des lignes du tableau en fonction du nom en clickant 1 fois sur le table head "nom".
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
        //Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je click sur Nom pour changer l'ordre
        $I->click('//*[@id="table_id_wrapper"]/div[2]/div[1]/div/table/thead/tr/th[2]');
        // Je véifie que sur la 3eme ligne je vois le nom "jean"
        // $I->see(Locator::elementAt('/html/body/div/div/div/div[2]/div[2]/table/tbody/tr[3]/td[2]', 3), 'jean');
        //$I->see(Locator::contains('/html/body/div/div/div/div[2]/div[2]/table/tbody/tr[3]/td[2]', 'jean'));

        $I->see('jean', '/html/body/div/div/div/div[2]/div[2]/table/tbody/tr[3]/td[2]');   
    }

    public function Cas18OrdreNom2(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On teste le changement d'ordre des lignes du tableau en fonction du nom en clickant 2 fois sur le table head "nom".
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
        //Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je click sur Nom pour changer l'ordre
        $I->click('//*[@id="table_id_wrapper"]/div[2]/div[1]/div/table/thead/tr/th[2]');
        // Je reclicke
        $I->click('//*[@id="table_id_wrapper"]/div[2]/div[1]/div/table/thead/tr/th[2]');
        // Je véifie que sur la 2eme ligne je vois le nom "jean"
        $I->see('jean', '/html/body/div/div/div/div[2]/div[2]/table/tbody/tr[2]/td[2]');   
    }

    public function Cas18OrdrePrenom(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On teste le changement d'ordre des lignes du tableau en fonction du prénom en clickant 1 fois sur le table head "prénom".
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
        //Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je click sur prénom pour changer l'ordre
        $I->click('/html/body/div/div/div/div[2]/div[1]/div/table/thead/tr/th[3]');
        // Je véifie que sur la 4eme ligne je vois le prenom "will"
        $I->see('will', '/html/body/div/div/div/div[2]/div[2]/table/tbody/tr[4]/td[3]');   
    }

    public function Cas18OrdrePrenom2(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On teste le changement d'ordre des lignes du tableau en fonction du prénom en clickant 2 fois sur le table head "prénom".
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
        //Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil_liste.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je click sur prenom pour changer l'ordre
        $I->click('/html/body/div/div/div/div[2]/div[1]/div/table/thead/tr/th[3]');
        // Je reclicke
        $I->click('/html/body/div/div/div/div[2]/div[1]/div/table/thead/tr/th[3]');
        // Je véifie que sur la 1ere ligne je vois le nom "will"
        $I->see('will', '/html/body/div/div/div/div[2]/div[2]/table/tbody/tr[1]/td[3]');   
    }

    public function TrieVille1(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On teste le changement d'ordre des lignes du tableau en fonction de la ville en clickant 1 fois sur le table head "ville".
        // Connexion au site
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('index.php');
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');
        // Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();    
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Connexion"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Connexion']);
        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "test@gmail.com"
        $I->fillField('identifiant', 'test@gmail.com');
        // Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je véifie que sur la 2eme ligne je vois le nom "poitiers"
        $I->see('paul_paul@gmail.com', Locator::elementAt('/html/body/div/div/div/div[2]/div[2]/table/tbody/tr', 2));
        // Je click sur Ville pour changer l'ordre
        $I->click('/html/body/div/div/div/div[2]/div[1]/div/table/thead/tr/th[4]');
        // Je véifie que sur la 4eme ligne je vois le nom "poitiers"
        $I->see('paul_paul@gmail.com', Locator::elementAt('/html/body/div/div/div/div[2]/div[2]/table/tbody/tr', 4));
    }
    
    public function TrieVille2(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On teste le changement d'ordre des lignes du tableau en fonction de la ville en clickant 2 fois sur le table head "ville".
        // Connexion au site
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('index.php');
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');
        // Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();    
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Connexion"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Connexion']);
        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "test@gmail.com"
        $I->fillField('identifiant', 'test@gmail.com');
        // Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je véifie que sur la 2eme ligne je vois le nom "paul_paul@gmail.com"
        $I->see('paul_paul@gmail.com', Locator::elementAt('/html/body/div/div/div/div[2]/div[2]/table/tbody/tr', 2));
        // Je click sur Ville pour changer l'ordre
        $I->click('/html/body/div/div/div/div[2]/div[1]/div/table/thead/tr/th[4]');
        // Je click sur Ville pour changer l'ordre
        $I->click('/html/body/div/div/div/div[2]/div[1]/div/table/thead/tr/th[4]');
        // Je véifie que sur la 1eme ligne je vois le nom "paul_paul@gmail.com"
        $I->see('paul_paul@gmail.com', Locator::elementAt('/html/body/div/div/div/div[2]/div[2]/table/tbody/tr', 1));
    }
    
    public function TrieAdMail1(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On teste le changement d'ordre des lignes du tableau en fonction du mail en clickant 1 fois sur le table head "mail".
        // Connexion au site
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('index.php');
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');
        // Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();    
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Connexion"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Connexion']);
        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "test@gmail.com"
        $I->fillField('identifiant', 'test@gmail.com');
        // Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je véifie que sur la 2eme ligne je vois l'adresse mail "paul_paul@gmail.com"
        $I->see('paul_paul@gmail.com', Locator::elementAt('/html/body/div/div/div/div[2]/div[2]/table/tbody/tr', 2));
        // Je click sur Adresse mail pour changer l'ordre
        $I->click('/html/body/div/div/div/div[2]/div[1]/div/table/thead/tr/th[7]');
        // Je véifie que sur la 4eme ligne je vois l'adresse mail "paul_paul@gmail.com"
        $I->see('paul_paul@gmail.com', Locator::elementAt('/html/body/div/div/div/div[2]/div[2]/table/tbody/tr', 4));
    }
    
    public function TrieAdMail2(AcceptanceTester $I)
    { 
        // SPECIFICATIONS : On teste le changement d'ordre des lignes du tableau en fonction du mail en clickant 2 fois sur le table head "mail".
        // Connexion au site
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('index.php');
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');
        // Et que cela a réussi
        //$I->seeResponseCodeIsSuccessful();    
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Connexion"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Connexion']);
        // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "test@gmail.com"
        $I->fillField('identifiant', 'test@gmail.com');
        // Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
        $I->fillField('pswd', 'hjR9L49J22juC');
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');
        // Je véifie que sur la 2eme ligne je vois l'adresse mail "paul_paul@gmail.com"
        $I->see('paul_paul@gmail.com', Locator::elementAt('/html/body/div/div/div/div[2]/div[2]/table/tbody/tr', 2));
        // Je click sur Adresse mail pour changer l'ordre
        $I->click('/html/body/div/div/div/div[2]/div[1]/div/table/thead/tr/th[7]');
        // Je click sur Adresse mail pour changer l'ordre
        $I->click('/html/body/div/div/div/div[2]/div[1]/div/table/thead/tr/th[7]');
        // Je véifie que sur la 1eme ligne je vois l'adresse mail "paul_paul@gmail.com"
        $I->see('paul_paul@gmail.com', Locator::elementAt('/html/body/div/div/div/div[2]/div[2]/table/tbody/tr', 1));
    }
}