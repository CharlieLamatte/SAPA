<?php
//Le chemin d'accès jusqu'à la page AccueilPatient.php n'est pas fonctionnelle, il faudra donc le modifier pour chaque cas
//Ici, nous avons les tests pour le formulaire Coordonnée de la page AccueilPatient.php
//Celle-ci risque d'être modifier (AccueilPatient.php deviendrait une page de visuel contenant un bouton de modification, qui lui mènerait au formulaire coordonnée).

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;
class PageAccueilPatient_numUCest  // /!\ Cest est obligatoire après le nom de la classe
{
                                    // ce document contient les tests en rapport avec le prénom de la personne à contacter en cas d'urgence uniquement.

	public function Cas102_NumU_Correct(AcceptanceTester $I)
    {//test avec un numéro "correcte"
        //Ce cas fonctionne.

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

        //telephone en cas d'urgence
        $I->fillField('num_Urgence', '0556988545');        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
        

    
public function Cas103_NumU_PlusTrentretrois(AcceptanceTester $I)
{//test avec un +33
    //Ce cas n'est pas fonctionnel
    //Le numéro de téléphone doit commencer par un "0"

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

        //telephone en cas d'urgence
        $I->fillField('num_Urgence', '+33556988545');        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
       
public function Cas104_NumU_TropLong(AcceptanceTester $I)
    {// test avec un numéro trop long
        //Ce cas n'est pas fonctionnel
        //Il y a trop de chiffres dans le numéro de téléphone

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

        //telephone en cas d'urgence
        $I->fillField('num_Urgence', '0632489715348543867');        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
       
        public function Cas105_NumU_TropCourt(AcceptanceTester $I)
     {//test avec un numéro trop court
        //Ce cas n'est pas fonctionnel
        //Le numéro est trop court, il faut 10 chiffres


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

        //telephone en cas d'urgence
        $I->fillField('num_Urgence', '06367');        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
        
public function Cas106_NumU_UniquementCaracteresSpeciaux(AcceptanceTester $I)
     {//test avec que des caractères spéciaux
        //Ce cas ne fonctionne pas
        //Le numéro de téléphone doit etre composé uniquement de chiffres

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

        //telephone en cas d'urgence
        $I->fillField('num_Urgence', '(-èçç_è-(');        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
       

  public function Cas107_NumU_Lettres(AcceptanceTester $I)
        {//test avec que des lettres
            //Ce cas ne fonctionne pas
            //Le numéro de téléphone doit comporter uniquement des chiffres

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

        //telephone en cas d'urgence
        $I->fillField('num_Urgence', 'aaaaaaaaaa');        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
       
public function Cas108_NumU_EspaceToutLesDeuxChiffres(AcceptanceTester $I)
            {//test avec un numéro avec des espaces tous les 2 chiffres
                //Ce cas n'est pas fonctionnel
                //Les chiffres des numéros de téléphones doivent être a la suite sans espaces

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

        //telephone en cas d'urgence
        $I->fillField('num_Urgence', '06 56 48 96 12');        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
        
public function Cas109_NumU_PointToutLesDeuxChiffres(AcceptanceTester $I)
                           {//test avec un numéro avec des points tous les 2 chiffres
                            //Ce cas n'est pas fonctionnel
                            //Le numéro de téléphone ne doit pas comporter de caractères spéciaux, juste des chiffres

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

        //telephone en cas d'urgence
        $I->fillField('num_Urgence', '06.56.48.96.12');        
        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
        

    }