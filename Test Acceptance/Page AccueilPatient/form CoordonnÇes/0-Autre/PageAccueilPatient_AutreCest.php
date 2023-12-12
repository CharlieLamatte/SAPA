<?php

//Le chemin d'accès jusqu'à la page AccueilPatient.php n'est pas fonctionnelle, il faudra donc le modifier pour chaque cas
//Ici, nous avons les tests pour le formulaire Coordonnée de la page AccueilPatient.php
//Celle-ci risque d'être modifier (AccueilPatient.php deviendrait une page de visuel contenant un bouton de modification, qui lui mènerait au formulaire coordonnée).
//Ce document a été fait le 23/06. Le formulaire 


namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;
class PageAccueilPatient_AutreCest  // /!\ Cest est obligatoire après le nom de la classe
{

 public function Cas1_PasDeChangementDesInformations(AcceptanceTester $I)
//Dans formulaire Coordonnée, on test sans rentrer le moindre changement
//Ce cas ne fonctionne pas
// Appuyer sur Enregistrer sans avoir rempli de champs, devrait afficher un message d'erreur du type "Merci de remplir les champs avant d'enregistrer" 
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
		
		// Je test s'il ya bien un bouton Enregistrer les modifs
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);
        $I->click('Enregistrer les modifications');

    }


    public function Cas4_MemeNomsPrenoms(AcceptanceTester $I)
    //Test avec les memes noms et prenoms pour le beneficiaire et la personne à contacter d'urgence
    //ce cas ne fonctionne pas
    // Il faut empêcher l'utisateur de mettre le même nom/prénom pour le bénéficiaire et la personne a apppelé en cas d'urgence et d'enregistrer  
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

        //nom et prenom beneficiaire
        $I-> fillField('nom','Dupont');
        $I-> fillField('Prenom','Michel');


        //nom et prenom de la personne en cas d'urgence
        $I-> fillField('nom_Urgence','Dupont');
        $I-> fillField('Prenom_Urgence','Michel');

         //bouton enregistrer
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer les modifications']);

        $I->click('/html/body/div/div/table/tbody/tr[2]/td[1]/center/div/div/form/fieldset/input[2]');
    }
}