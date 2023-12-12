<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class  PointFortsCest  // /!\ Cest est obligatoire après le nom de la classe
{
//***
// Ce test permet de tester le formulaire des Points forts sur PHP/Patients/Ap.php .
// On peut enregistrer le formulaire en ignorant ce champ.
// Ce champ doit pouvoir contenir des chiffres.
// Ce champ doit pouvoir contenir des caractères spéciaux. 
// Ce champ doit afficher un message d’erreur si l’on insère un seul caractère.
// Ce champ doit pouvoir contenir des minuscules et des majuscules.
// Ce champ doit pouvoir contenir au maximum 2000 caractères.
//***


	public function EnvoiFormulaireAvecChampIgnore(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire avec le champ "Points forts / Ressources / Leviers" ignore
		
		// Connexion au site
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('index.php');
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');
        /// Je teste s'il y a bien un formulaire
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
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');		
		
		// Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
		// Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Points forts');
		
		// Test
		// J'attend que la page se charge
		$I->wait(1);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur "Valeur normal."
        $I->fillField('a_asso', 'Valeur normal.');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Points forts"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Points forts" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur ""
        $I->fillField('point_fort', '');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
	public function EnvoiFormulaireAvecCharctereSpeciaux(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire en remplissant le champ "Points forts / Ressources / Leviers" avec des charactere speciaux
		
		// Connexion au site
        // J'essaie d'aller sur la page index.php
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
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');		
		
		// Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
		// Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Points forts');
		
		// Test
		// J'attend que la page se charge
		$I->wait(1);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur "Valeur normal."
        $I->fillField('a_asso', 'Valeur normal.');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Points forts"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Points forts" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "aA?;,.:/!êéè&àç()123456789-+/*=""
        $I->fillField('point_fort', 'aA?;,.:/!êéè&àç()123456789-+/*="');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }

    public function EnvoiFormulaireAvecChiffres(AcceptanceTester $I)
    {
        //Test d'envoi du formulaire en remplissant le champ "Points forts" avec des charactere speciaux
        
        // Connexion au site
        // J'essaie d'aller sur la page index.php
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
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');     
        // Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Points forts');
        // Test
        // J'attend que la page se charge
        $I->wait(1);
        // Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
        // Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
        // Je rempli le champ "En association" avec la valeur "Valeur normal."
        $I->fillField('a_asso', 'Valeur normal.');
        // Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
        // Je coche la radio "Oui" pour le champ "Points forts"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
        // Je rempli le champ "Points forts" avec les chiffres "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
        // Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
        // Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "0123456789"
        $I->fillField('point_fort', '0123456789');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
        
    }

    public function EnvoiFormulaireAvecAMin(AcceptanceTester $I)
    {
        //Test d'envoi du formulaire en remplissant le champ "Points forts" avec des charactere speciaux
        
        // Connexion au site
        // J'essaie d'aller sur la page index.php
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
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');     
        // Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Points forts');
        // Test
        // J'attend que la page se charge
        $I->wait(1);
        // Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
        // Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
        // Je rempli le champ "En association" avec la valeur "Valeur normal."
        $I->fillField('a_asso', 'Valeur normal.');
        // Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
        // Je coche la radio "Oui" pour le champ "Points forts"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
        // Je rempli le champ "activité physique envisagée" avec "Valeur normale."
        $I->fillField('a_envisagee', 'Valeur normale.');
        // Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normale.');
        // Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "a."
        $I->fillField('point_fort', 'a');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
        
    }

    public function EnvoiFormulaireAvecAMaj(AcceptanceTester $I)
    {
        //Test d'envoi du formulaire en remplissant le champ "Points forts" avec des charactere speciaux
        
        // Connexion au site
        // J'essaie d'aller sur la page index.php
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
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');     
        // Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Points forts');
        // Test
        // J'attend que la page se charge
        $I->wait(1);
        // Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
        // Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
        // Je rempli le champ "En association" avec la valeur "Valeur normal."
        $I->fillField('a_asso', 'Valeur normal.');
        // Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
        // Je coche la radio "Oui" pour le champ "Points forts"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
        // Je rempli le champ "Points forts" avec "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
        // Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
        // Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "A"
        $I->fillField('point_fort', 'A');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
        
    }

    public function EnvoiFormulaireAvecAbcd(AcceptanceTester $I)
    {
        //Test d'envoi du formulaire en remplissant le champ "Points forts" avec des charactere speciaux
        
        // Connexion au site
        // J'essaie d'aller sur la page index.php
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
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');     
        // Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Points forts');
        // Test
        // J'attend que la page se charge
        $I->wait(1);
        // Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
        // Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
        // Je rempli le champ "En association" avec la valeur "Valeur normal."
        $I->fillField('a_asso', 'Valeur normal.');
        // Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
        // Je coche la radio "Oui" pour le champ "Points forts"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
        // Je rempli le champ "Points forts" avec "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
        // Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
        // Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "AaBbCcDd"
        $I->fillField('point_fort', 'AaBbCcDd');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
        
    }

    public function EnvoiFormulaireAvec2000A(AcceptanceTester $I)
    {
        //Test d'envoi du formulaire en remplissant le champ "Points forts" avec des charactere speciaux
        
        // Connexion au site
        // J'essaie d'aller sur la page index.php
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
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');     
        // Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Points forts');
        // Test
        // J'attend que la page se charge
        $I->wait(1);
        // Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
        // Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
        // Je rempli le champ "En association" avec la valeur "Valeur normal."
        $I->fillField('a_asso', 'Valeur normal.');
        // Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
        // Je coche la radio "Oui" pour le champ "Points forts"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
        // Je rempli le champ "acivité physique envisagée" avec "valeur normale")
        $I->fillField('a_envisagee', 'Valeur normale.');
        // Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
        // Je rempli le champ "Points forts / Ressources / Leviers" avec 2000 a
        $I->fillField('point_fort', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        //Test a complter
        
    }
    
    public function EnvoiFormulaireAvec2001A(AcceptanceTester $I)
    {
        //Test d'envoi du formulaire en remplissant le champ "Points forts" avec des charactere speciaux
        
        // Connexion au site
        // J'essaie d'aller sur la page index.php
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
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');     
        // Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Points forts');
        // Test
        // J'attend que la page se charge
        $I->wait(1);
        // Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
        // Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
        // Je rempli le champ "En association" avec la valeur "Valeur normal."
        $I->fillField('a_asso', 'Valeur normal.');
        // Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
        // Je coche la radio "Oui" pour le champ "activité physique envisagée"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
        // Je rempli le champ "activité physique envisagée" avec 2001 "a" (valeur limite dépassée de 1)
        $I->fillField('a_envisagee', 'Valeur normal.');
        // Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
        // Je rempli le champ "Points forts / Ressources / Leviers" avec 2001 "a" (valeur limite dépassée de 1)
        $I->fillField('point_fort', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
        
    }

    public function EnvoiFormulaireAvec2100A(AcceptanceTester $I)
    {
        //Test d'envoi du formulaire en remplissant le champ "Points forts" avec des charactere speciaux
        
        // Connexion au site
        // J'essaie d'aller sur la page index.php
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
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        // Je teste que je trouve bien le texte suivant : "Bonjour TEST Prénom"
        $I->see('Bonjour TEST Prénom');     
        // Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
        // Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Points forts');
        // Test
        // J'attend que la page se charge
        $I->wait(1);
        // Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
        // Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
        // Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
        // Je rempli le champ "En association" avec la valeur "Valeur normal."
        $I->fillField('a_asso', 'Valeur normal.');
        // Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
        // Je coche la radio "Oui" pour le champ "activité physique envisagée"
        $I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
        // Je rempli le champ "activité physique envisagée" avec valeur normale.
        $I->fillField('a_envisagee', 'Valeur normal.');
        // Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
        // Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
        
    }

}