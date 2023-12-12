<?php
//Le chemin d'accès jusqu'à la page AccueilPatient.php n'est pas fonctionnelle, il faudra donc le modifier pour chaque cas
//Ici, nous avons les tests pour le formulaire Coordonnée de la page AccueilPatient.php
//Celle-ci risque d'être modifier (AccueilPatient.php deviendrait une page de visuel contenant un bouton de modification, qui lui mènerait au formulaire coordonnée).

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;
class PageAccueilPatient_prenomUCest  // /!\ Cest est obligatoire après le nom de la classe
{
                                // ce document contient les tests en rapport avec le prénom de la personne à contacter en cas d'urgence uniquement.

	public function Cas92_PrenomU_Correct(AcceptanceTester $I)
    {
        //test avec un prénom "correcte"
        //Ce cas fonctionne.

        //Je vérifie que je suis sur la page index
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

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');


        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        //prenom
        $I->fillField('Prenom_Urgence', 'Jacques');
        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }

public function Cas93_PrenomU_UnSeulCaractere(AcceptanceTester $I)
       {
        //test avec un seul caractère
        //Ce cas fonctionne.
        //Il existe des prénoms qui ne comprortent qu'une seule lettre

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

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');


        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        //prenom
        $I->fillField('Prenom_Urgence', 'x');
        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
       

    public function Cas94_PrenomU_TropDeCaracteres(AcceptanceTester $I)
       {//test avec "trop" de caractères
        //Ce cas n'est pas fonctionnel.
        //Le prénom est trop long et devrait générer une erreur

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

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');


        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        //prenom
        $I->fillField('Prenom_Urgence', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }

public function Cas95_PrenomU_CaracteresSpeciaux(AcceptanceTester $I)
           {//test avec que des caractères spéciaux 
            //Ce cas n'est pas fonctionnel
            //Il n'existe pas de prénoms avec uniquement des caractères spéciaux

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

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');


        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        //prenom
        $I->fillField('Prenom_Urgence', 'àçè-‘“”’-()è_ç');
        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }


public function Cas96_PrenomU_Chiffres(AcceptanceTester $I)
           {//test avec que des chiffres
            // Ce cas n'est pas fonctionnel
            //Le prénom ne doit pas comporter de chiffres

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

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');


        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        //prenom
        $I->fillField('Prenom_Urgence', '123456');
        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }

public function Cas96_1_PrenomU_NonRempli(AcceptanceTester $I)
           { //test avec un vide
            // Ce cas n'est pas fonctionnel
            // Le champ n'est pas rempli

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

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');


        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        //prenom
        $I->fillField('Prenom_Urgence', '');
        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
public function Cas96_2_PrenomU_UnEspace(AcceptanceTester $I)
           { // test avec un espace
            // Ce cas n'est pas fonctionnel
            //Il n'y a que des espaces, pas de prénoms.
            
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

        // Je teste s'il y a bien un formulaire
        $I->seeElement('//*[@id="ficheResume"]/form');


        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        //prenom
        $I->fillField('Prenom_Urgence', ' ');
        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }


}
