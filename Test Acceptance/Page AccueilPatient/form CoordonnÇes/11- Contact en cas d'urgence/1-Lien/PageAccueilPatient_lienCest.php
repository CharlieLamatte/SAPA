<?php
//Le chemin d'accès jusqu'à la page AccueilPatient.php n'est pas fonctionnelle, il faudra donc le modifier pour chaque cas
//Ici, nous avons les tests pour le formulaire Coordonnée de la page AccueilPatient.php
//Celle-ci risque d'être modifier (AccueilPatient.php deviendrait une page de visuel contenant un bouton de modification, qui lui mènerait au formulaire coordonnée).

//ceci aa été fait sur une ancienne version (il n'y avait pas encore le "Choisir un lien")
namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;
class PageAccueilPatient_lienCest  // /!\ Cest est obligatoire après le nom de la classe
{
                        // ce document contient les tests en rapport avec les liens de familles de la personne à contacter en cas d'urgence uniquement.

	public function Cas85_LienFils(AcceptanceTester $I)
        //Test de la personne à contacter en cas d'urgence, lien
        //Ce cas fonctionne
        //Le champs séléctionné fait bien partie des propositions du menu déroulant
    
    {
        // Je test que je suis bien sur la page index.php
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
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');

        // J'essaie d'aller sur la page Accueil patient
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');

        // Je vérifie que je suis bien sur accueil patient
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');

        //lien
        $I->selectOption('lien', 'fils');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }

    public function Cas86_LienFille(AcceptanceTester $I)
        //Test de la personne à contacter en cas d'urgence, lien
        //Ce cas fonctionne
        //Le champs séléctionné fait bien partie des propositions du menu déroulant
    {
        // Je test que je suis bien sur la page index.php
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
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');

        // J'essaie d'aller sur la page Accueil patient
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');

        // Je vérifie que je suis bien sur accueil patient
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');

        //lien
        $I->selectOption('lien', 'fille');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }
public function Cas87_LienFrere(AcceptanceTester $I)
        //Test de la personne à contacter en cas d'urgence, lien
        //Ce cas fonctionne
        //Le champs séléctionné fait bien partie des propositions du menu déroulant    
{
        // Je test que je suis bien sur la page index.php
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
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');

        // J'essaie d'aller sur la page Accueil patient
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');

        // Je vérifie que je suis bien sur accueil patient
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');

        //lien
        $I->selectOption('lien', 'frère');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }
    public function Cas88_LienSoeur(AcceptanceTester $I)
        //Test de la personne à contacter en cas d'urgence, lien
        //Ce cas fonctionne
        //Le champs séléctionné fait bien partie des propositions du menu déroulant    
    {
        // Je test que je suis bien sur la page index.php
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
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');

        // J'essaie d'aller sur la page Accueil patient
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');

        // Je vérifie que je suis bien sur accueil patient
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');

        //lien
        $I->selectOption('lien', 'soeur');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }
public function Cas89_LienAmi(AcceptanceTester $I)
        //Test de la personne à contacter en cas d'urgence, lien
        //Ce cas fonctionne
        //Le champs séléctionné fait bien partie des propositions du menu déroulant    
{
        // Je test que je suis bien sur la page index.php
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
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');

        // J'essaie d'aller sur la page Accueil patient
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');

        // Je vérifie que je suis bien sur accueil patient
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');

        //lien
        $I->selectOption('lien', 'ami');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }
public function Cas90_LienVoisin(AcceptanceTester $I)
        //Test de la personne à contacter en cas d'urgence, lien
        //Ce cas fonctionne
        //Le champs séléctionné fait bien partie des propositions du menu déroulant    

{
        // Je test que je suis bien sur la page index.php
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
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');

        // J'essaie d'aller sur la page Accueil patient
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');

        // Je vérifie que je suis bien sur accueil patient
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');

        //lien
        $I->selectOption('lien', 'voisin');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }
public function Cas91_LienAutre(AcceptanceTester $I)
        //Test de la personne à contacter en cas d'urgence, lien
        //Ce cas fonctionne
        //Le champs séléctionné fait bien partie des propositions du menu déroulant
            
{
       // Je test que je suis bien sur la page index.php
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
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');

        // J'essaie d'aller sur la page Accueil patient
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');

        // Je vérifie que je suis bien sur accueil patient
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');

        //lien
        $I->selectOption('lien', 'autre');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
}

}