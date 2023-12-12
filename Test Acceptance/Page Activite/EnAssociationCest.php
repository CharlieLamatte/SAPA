<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class EnAssociationCest  // /!\ Cest est obligatoire après le nom de la classe
{
//***
// Ce test permet de tester le champ en association sur PHP/Patients/Ap.php .
// On peut enregistrer le formulaire en ignorant ce champ.
// Ce champ doit pouvoir contenir des chiffres.
// Ce champ doit pouvoir contenir des caractères spéciaux. 
// Ce champ doit afficher un message d’erreur si l’on insère un seul caractère.
// Ce champ doit pouvoir contenir des minuscules et des majuscules.
// Ce champ doit pouvoir contenir au maximum 2000 caractères
// Après avoir rempli ce champ, si l’on clique sur le bouton radio “Non”, le contenu préalable ne doit pas être enregistré.
//***


	public function EnvoiFormulaireAvecChampIgnore(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire avec le champ "En association" ignore
		//On remplit les champs en ignorant le champ “En association”,
		//on valide le formulaire et on vérifie l’enregistrement dans la base de donnée.
		//Aucun message d’erreur ne doit apparaître.
		
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
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur ""
        $I->fillField('a_asso', '');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
	public function EnvoiFormulaireAvecCharctereSpeciaux(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire en remplissant le champ "En association" avec des charactere speciaux
		//On insère dans le champ “En association” différents caractères spéciaux “é”#%*$+,./:?!”.
		//Ensuite on regarde si les caractères spéciaux sont bien affichés dans les informations personnelles.
		
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
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur "“é”#%*$+,./:?!"
        $I->fillField('a_asso', '“é”#%*$+,./:?!');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
		public function EnvoiFormulaireAvecChiffre(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire en remplissant le champ "En association" avec des chiffre
		//On insère dans le champ “En association” différents chiffres “0123456789”. 
		//Ensuite on regarde si les chiffres sont bien affichés dans les informations personnelles.
		
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
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur "123456789"
        $I->fillField('a_asso', '123456789');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
	public function EnvoiFormulaireAvecAMin(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire avec le charactere "a" dans le champ "En association"
		//On insère dans le champs “En association” 1 caractère  “a” pour voir si un caractère minuscule est accepté.
		
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
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur "a"
        $I->fillField('a_asso', 'a');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
	public function EnvoiFormulaireAvecAMaj(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire avec le charactere "A" dans le champ "En association"
		//On insère dans le champs “En association” 1 caractère  “A” pour voir si un caractère majuscule est accepté.
		
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
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur "A"
        $I->fillField('a_asso', 'A');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
	public function EnvoiFormulaireAvecAMajMin(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire avec le charactere "AaBbCcDd" dans le champ "En association"
		//On insère dans le champs “En association”   “AaBbCcDd” pour voir si un string de maj et min est accepté.
		
		// Connexion au site
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('index.php');
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/index.php');
        // Et que cela a réussi
        ////$I->seeResponseCodeIsSuccessful();	
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
		
		// Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
		// Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur "AaBbCcDd"
        $I->fillField('a_asso', 'AaBbCcDd');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
	public function EnvoiFormulaireAvec2000Car(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire avec 2000 charactere "a" dans le champ "En association"
		//On insère dans le champs “En association” 2000 caractères (des “a”) pour voir si la limite est acceptée.
		
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
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
        $I->fillField('a_asso', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
	public function EnvoiFormulaireAvec2001Car(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire avec 2001 charactere "a" dans le champ "En association"
		//On insère dans le champs “En association” 2001 caractères (des “a” pour voir si la limite est acceptée.
		//Affichage d’un message d’erreur.

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
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
        $I->fillField('a_asso', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
	public function EnvoiFormulaireAvec2100Car(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire avec 2100 charactere "a" dans le champ "En association"
		//On insère dans le champs “En association” 2100 caractères (des “a” pour voir si la limite est acceptée.
		//Affichage d’un message d’erreur.

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
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[1]', 'oui');
		// Je rempli le champ "En association" avec la valeur "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
        $I->fillField('a_asso', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
	public function EssaiNonRadio(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire en choisissant l'option "non" pour la radio "En association"
		//On coche “non” pour la radio "En association", on vérifie l’enregistrement.
		
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
		
		/// Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
		// Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
		// Je rempli le champ "Activite physique anterieur" avec la valeur "Valeur normal."
        $I->fillField('a_ant', 'Valeur normal.');
		// Je coche la valeur "Oui" pour la radio "Autonome" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[1]/fieldset/input[1]', 'oui');
		// Je rempli le champ "Autonome" avec la valeur "Valeur normal."
        $I->fillField('a_auto', 'Valeur normal.');
		// Je coche la valeur "Non" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[2]', 'non');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }
	
	public function EssaiOuiNonRadio(AcceptanceTester $I)
    {
		//Test d'envoi du formulaire en choisissant l'option "oui" pour la radio "En association" en remplissant le champ puis en cochant "non"
		//On coche “oui” pour la radio "En association", on remplit le champ qui apparaît et on coche non. 
		//On vérifie que le texte n’a pas été enregistré.
		
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
		
		/// Accession a la page de test
        // J'essaie d'aller sur la page /PHP/Patients/Ap.php?idPatient=1
        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=502');
        // Je vérifie que je suis bien sur /PHP/Patients/Ap.php?idPatient=1
        $I->seeInCurrentUrl('/PHP/Patients/Ap.php?idPatient=502');
        // Je teste s'il y a bien un formulaire
        //$I->seeElement('form');
		// Je teste que je trouve bien le texte suivant : "Activité physique antérieure"
        $I->see('Activité physique antérieure');
		
		// Test
		// J'attend que la page se charge
		$I->wait(2);
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
		// Je coche la valeur "Non" pour la radio "En association" pour le champ "Activite physique actuelle"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[5]/td[2]/fieldset/input[2]', 'non');
		// Je rempli le champ "Disponibilite" avec la valeur "Valeur normal."
        $I->fillField('dispo', 'Valeur normal.');
		// Je coche la radio "Oui" pour le champ "Activite physique envisagee"
		$I->selectOption('/html/body/div/div/div[1]/table/tbody/tr[8]/td/fieldset/input[1]', 'oui');
		// Je rempli le champ "Activite physique envisagee" avec la valeur "Valeur normal."
        $I->fillField('a_envisagee', 'Valeur normal.');
		// Je rempli le champ "Freins à l'activité physique" avec la valeur "Valeur normal."
        $I->fillField('frein', 'Valeur normal.');
		// Je rempli le champ "Points forts / Ressources / Leviers" avec la valeur "Valeur normal."
        $I->fillField('point_fort', 'Valeur normal.');
        // Je click sur le bouton valider
        $I->click('Enregistrer');
        // Je verifie que les donnees on correctement ete enregistre dans la base de donnne
        
		//Test a complter
		//Le bouton enregestriment ne fonctionne pas en local, 
		//on ne peut donc pas vérifier l'apparition de message d'erreur ou l'enregitrement de donnée
		
    }

}