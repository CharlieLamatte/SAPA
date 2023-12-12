<?php
//Le chemin d'accès jusqu'à la page AccueilPatient.php n'est pas fonctionnelle, il faudra donc le modifier pour chaque cas
//Ici, nous avons les tests pour le formulaire Coordonnée de la page AccueilPatient.php
//Celle-ci risque d'être modifier (AccueilPatient.php deviendrait une page de visuel contenant un bouton de modification, qui lui mènerait au formulaire coordonnée).

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;
class PageAccueilPatient_nomUCest  // /!\ Cest est obligatoire après le nom de la classe
{
                            // ce document contient les tests en rapport avec le nom de la personne à contacter en cas d'urgence uniquement.

	public function Cas97_NomU_Correct(AcceptanceTester $I)
    {
        //Test en cas du'urgence, nom correcte
        // Ce test fonctionne correctement

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

        //nom
        $I->fillField('nom_Urgence', 'Boulon');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }

    public function Cas98_NomU_UnSeulCaractere(AcceptanceTester $I)
    {
        //Test en cas du'urgence, nom avec uniquement un seul caractere
        // Ce test fonctionne correctement
        //Il existe des noms avec un seul caractère

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

        //nom
        $I->fillField('nom_Urgence', 'x');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }

 public function Cas99_NomU_PlusDeCinquanteCaracteres(AcceptanceTester $I)
    {
        //Test en cas du'urgence, nom avec plus de 50 caracteres
        //Ce cas n'est pas fonctionnel
        //Le nom est trop long et devrait générer une erreur

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

        //nom
        $I->fillField('nom_Urgence', 'xaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }
    
    public function Cas100_NomU_CaracteresSpeciaux(AcceptanceTester $I)
    {
        //Test en cas du'urgence, nom avec uniquement des caracteres speciaux
        //Ce cas n'est pas fonctionnel
        //Il n'existe pas de nom avec uniquement des caractères spéciaux

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

        //nom
        $I->fillField('nom_Urgence', 'àçè-(‘“”’(-è_ç');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }
 public function Cas101_NomU_Chiffres(AcceptanceTester $I)
    {
        //Test en cas du'urgence, nom avec uniquement des chiffres
        //Ce cas n'est pas fonctionnel
        //Ce test n'est pas censé fonctionner car le nom comporte que des chiffres

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

        //nom
        $I->fillField('nom_Urgence', '123456');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }
    public function Cas101_1_NomU_Espaces(AcceptanceTester $I)
    {
        //Test en cas du'urgence, nom avec uniquement des espaces
        //Ce cas n'est pas fonctionnel
        //Un nom ne peut pas comporter que des espaces

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

        //nom
        $I->fillField('nom_Urgence', '    ');

        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }
}