<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class SanteTTCest  // /!\ Cest est obligatoire après le nom de la classe
{


public function TTNormale(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 18 : Ok 
        //On met le tour de taille : 100cm + formulaire avec données cohérente 
        //Affichage d’un IMC 

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

        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=133');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->see('27.76');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('tour_de_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('essouflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('frequence_cardiaque', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('saturation', '70');
        
        // Je click sur le bouton pour voir l'IMC
        $I->click('form input[type=button]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste que je trouve bien le texte suivant : "Voici votre IMC"
        $I->see('Voici votre IMC');

        // Je teste qu'il n'y est pas le texte suivant : "Message d erreur"
        $I->dontSee('Message d erreur');

    }

    public function TTTropPetit(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 19 : Erreur 
        //On met le tour de taille : 9cm + formulaire avec données cohérente
        //Affichage message d’erreur

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

        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=133');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->see('27.76');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "9"
        $I->fillField('tour_de_taille', '9');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('essouflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('frequence_cardiaque', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('saturation', '70');
        
        // Je click sur le bouton pour voir l'IMC
        $I->click('form input[type=button]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Voici votre IMC"
        $I->dontSee('Voici votre IMC');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');
        
    }

    public function TTTropGrande(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 20 : Erreur
        //On met le tour de taille : 230cm + formulaire avec données cohérente
        //Affichage message d’erreur

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

        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=133');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');
        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->see('27.76');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "230"
        $I->fillField('tour_de_taille', '230');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('essouflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('frequence_cardiaque', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('saturation', '70');
        
        // Je click sur le bouton pour voir l'IMC
        $I->click('form input[type=button]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Voici votre IMC"
        $I->dontSee('Voici votre IMC');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');
        
    }

    public function TTNegative(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 21 : Erreur
        //On met le tour de taille : -98 + formulaire avec données cohérente
        //Affichage message d’erreur
        
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

        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=133');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->see('27.76');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "-98"
        $I->fillField('tour_de_taille', '-98');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('essouflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('frequence_cardiaque', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('saturation', '70');
        
        // Je click sur le bouton pour voir l'IMC
        $I->click('form input[type=button]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Voici votre IMC"
        $I->dontSee('Voici votre IMC');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');
        
    }

    public function TTUneDecimale(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 22 : Ok
        //On met le tour de taille : 125.5cm + formulaire avec données cohérente
        //Affichage d’un IMC 

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

        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=133');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->see('27.76');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "125.5"
        $I->fillField('tour_de_taille', '125.5');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('essouflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('frequence_cardiaque', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('saturation', '70');
        
        // Je click sur le bouton pour voir l'IMC
        $I->click('form input[type=button]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste que je trouve bien le texte suivant : "Voici votre IMC"
        $I->See('Voici votre IMC');

        // Je teste qu'il n'y est pas le texte suivant : "Message d'erreur"
        $I->dontSee('Message d erreur');
        
    }

    public function TTDeuxDecimal(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 23 : Erreur
        //On met le tour de taille : 45.96cm + formulaire avec données cohérente
        //Affichage message d’erreur

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

        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=133');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->see('27.76');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "-45.96"
        $I->fillField('tour_de_taille', '45.96');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('essouflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('frequence_cardiaque', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('saturation', '70');

        // Je click sur le bouton pour voir l'IMC
        $I->click('form input[type=button]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Voici votre IMC"
        $I->dontSee('Voici votre IMC');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');
        
    }

    public function TTLettre(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 24 : Erreur
        //On met le tour de taille : RPµ + formulaire avec données cohérente
        //Affichage message d’erreur

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

        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=133');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');
        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->see('27.76');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "RPµ"
        $I->fillField('tour_de_taille', 'RPµ');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('essouflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('frequence_cardiaque', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('saturation', '70');

        // Je click sur le bouton pour voir l'IMC
        $I->click('form input[type=button]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Voici votre IMC"
        $I->dontSee('Voici votre IMC');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');
        
    }

    public function TTVide(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 25 : Erreur
        //On ne met rien pour le tour de taille + formulaire avec données cohérente
        //Affichage message d’erreur / message manque une infos

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

        // J'essaie d'aller sur la page index.php
        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=133');

        // Je vérifie que je suis bien sur index.php
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste s'il y a bien un formulaire
        $I->seeElement('form');
        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->see('27.76');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur ""
        $I->fillField('tour_de_taille', '');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('essouflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('frequence_cardiaque', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur ""
        $I->fillField('', '');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('saturation', '70');
        
        // Je click sur le bouton pour voir l'IMC
        $I->click('form input[type=button]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Voici votre IMC"
        $I->dontSee('Voici votre IMC');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');
        
    }



}
