<?php
//Le chemin d'accès jusqu'à la page AccueilPatient.php n'est pas fonctionnelle, il faudra donc le modifier pour chaque cas
//Ici, nous avons les tests pour le formulaire Coordonnée de la page AccueilPatient.php
//Celle-ci risque d'être modifier (AccueilPatient.php deviendrait une page de visuel contenant un bouton de modification, qui lui mènerait au formulaire coordonnée).

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;
class PageAccueilPatient_adresseCest  // /!\ Cest est obligatoire après le nom de la classe
{
            // ce document contient les tests en rapport avec l'adresse du bénéficiaire uniquement.

	public function Cas5_AdresseCorrecte(AcceptanceTester $I)
        //Test avec une adresse correcte
        //Ce cas fonctionne
        //Enregistrement d'une adresse correcte
    
    {        
        // Je vérifie que je suis bien sur la page index
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
        
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');
                
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');
        
        // Je verifie qu'il y a le form
        $I-> seeElement('form');
        
        //adresse
        $I-> fillField('new_adresse','9 rue du Pape');
        
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);
        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }

 public function Cas6_AdresseNonConforme(AcceptanceTester $I)
        //Test avec une adresse "incorrecte"
        //Ce cas ne fonctionne pas
        //Cette adresse n'est pas correcte car il n'y a ni numéro ni nom de rue   
    {
        // Je vérifie que je suis bien sur la page index
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
                
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');
                        
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');
                
        // Je verifie qu'il y a le form
        $I-> seeElement('form');
                
        //adresse
        $I-> fillField('new_adresse','XX');
                
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);
                
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }

public function Cas7_AdresseAvecQueDesChiffres(AcceptanceTester $I)
        //Test avec une adresse incorrecte, avec uniquement des chiffres
        //Ce cas ne fonctionne pas
        //Le test n'est pas censé fonctionner car cette adresse n'est pas correcte, il n'y a trop de numéro et pas de nom de rue mais uniquement des chiffres.
    {
    
        // Je vérifie que je suis bien sur la page index
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
                
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');
                        
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');
                
        // Je verifie qu'il y a le form
        $I-> seeElement('form');
                
        //adresse
        $I-> fillField('new_adresse','123456');
                
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);
                
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }

public function Cas8_AdresseAvecQueDesEspaces(AcceptanceTester $I)
        //Test avec une adresse incorrecte, avec uniquement des espaces
        //Ce cas ne fonctionne pas
        //Le test n'est pas censé fonctionner car il n'y a pas d'adresse, juste des espaces.  
{
        // Je vérifie que je suis bien sur la page index
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
                
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');
                        
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');
                
        // Je verifie qu'il y a le form
        $I-> seeElement('form');
                
        //adresse
        $I-> fillField('new_adresse','              ');
                
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);
                
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }

public function Cas9_AdresseNonRenseignee(AcceptanceTester $I)
    //Test avec une adresse vide
    //Ce cas ne fonctionne pas
    //Le test n'est pas censé fonctionner car le champ n'est pas rempli
    {
        // Je vérifie que je suis bien sur la page index
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
                
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');
                        
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');
                
        // Je verifie qu'il y a le form
        $I-> seeElement('form');
                
        //adresse
        $I-> fillField('new_adresse','');
                
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);
                
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');

    }

    public function Cas10_AdressesAvecQueDesCaractesSpeciaux(AcceptanceTester $I)
        //Test avec une adresse incorrecte, avec des caracteres speciaux
        //Ce cas ne fonctionne pas
        //Le test n'est pas censé fonctionner car l'adresse est composé uniquement de caractères spéciaux. Il n'y a pas de numéro ni de nom de rue. 
    {
        // Je vérifie que je suis bien sur la page index
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
                
        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=133&statutPatient=Actif%20-%20Entretien%20intermédiaire');
                        
        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/AccueilPatient.php');
                
        // Je verifie qu'il y a le form
        $I-> seeElement('form');
                
        //adresse
        $I-> fillField('new_adresse','@ùùùùù&à**');
                
        //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);
                
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }

}
