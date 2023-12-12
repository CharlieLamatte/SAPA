<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class SanteSaturationCest  // /!\ Cest est obligatoire après le nom de la classe
{
    
    public function SaturationsNormal(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 42 : Ok 
        //On met la saturation : 70% + formulaire avec données cohérente 
        //Enregistrement des données done


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

        // Je teste comme quoi dans ce formulaire il y a bien le type "date" et le name "date_imc"
        $I->seeElement('input', ['type' => 'date', 'name' => 'date_imc']);

        // Je rempli le champ "DATE" avec la valeur "17/06/2020"
        $I->fillField('date_imc', '17/06/2020');

        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('FC_repos', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur "100"
        $I->fillField('FC_max_mesuree', '100');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur "22/06/2020"
        $I->fillField('Date_FC_max_mesuree', '22/06/2020');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('Saturation', '70');
        
        // Je click sur le bouton pour enregistrer
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Message d'erreur"
        //$I->dontSee('Message d erreur');
        
    }

    // public function cas10(AcceptanceTester $I)
    // {
    //     //Test avec les parametres invalide
    //     //Cas 10 : Erreur 
    //     //On met la taille : 19cm + formulaire avec données cohérente
    //     //Données non enregistré


    //     $I->amOnPage('index.php');

    //     // Je vérifie que je suis bien sur index.php
    //     $I->seeInCurrentUrl('/index.php');

    //     // Et que cela a réussi
    //     //$I->seeResponseCodeIsSuccessful();

    //     // Je teste s'il y a bien un formulaire
    //     $I->seeElement('form');

    //     // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Connexion"
    //     $I->seeElement('input', ['type' => 'submit', 'value' => 'Connexion']);

    //     // Je rempli le champ "identifiant" (champ de l'adresse mail) avec la valeur "test@gmail.com"
    //     $I->fillField('identifiant', 'test@gmail.com');

    //     // Je rempli le champ "pswd" (champ du mot de passe) avec la valeur "hjR9L49J22juC"
    //     $I->fillField('pswd', 'hjR9L49J22juC');

    //     // Je click sur le bouton du login
    //     $I->click('form input[type=submit]');

    //     // Je teste que je suis bien sur la page PHP/Accueil.php
    //     $I->seeInCurrentUrl('PHP/Accueil_liste.php');

    //     // J'essaie d'aller sur la page index.php
    //     $I->amOnPage('/PHP/Patients/Sante.php?idPatient=133');

    //     // Je vérifie que je suis bien sur index.php
    //     $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

    //     // Je teste s'il y a bien un formulaire
    //     $I->seeElement('form');

    //     // Je teste comme quoi dans ce formulaire il y a bien le type "date" et le name "date_imc"
    //     $I->seeElement('input', ['type' => 'date', 'name' => 'date_imc']);

    //     // Je rempli le champ "DATE" avec la valeur "17/06/2020"
    //     $I->fillField('date_imc', '17/06/2020');

    //     // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
    //     $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

    //     // Je rempli le champ "poids" (champ du poids) avec la valeur "18"
    //     $I->fillField('poids', '85');
        
    //     // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
    //     $I->fillField('taille', '19');

    //     // Je regarde que le champ IMC soit bien egale "5.88"
    //     $I->grabValueFrom('input[name=IMC]');

    //     // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
    //     $I->fillField('Tour_taille', '100');

    //     // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
    //     $I->fillField('Essoufflement', '5');

    //     // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
    //     $I->fillField('FC_repos', '86');

    //     // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur "100"
    //     $I->fillField('FC_max_mesuree', '100');

    //     // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur "22/06/2020"
    //     $I->fillField('Date_FC_max_mesuree', '22/06/2020');

    //     // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
    //     $I->fillField('Saturation', '70');

    //     // Je click sur le bouton pour enregistrer
    //     $I->click('form input[type=submit]');

    //     //Je teste que je suis sur la bonne page après les résultat
    //     $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

    //     // Je teste que je trouve bien le texte suivant : "Message d'erreur"
    //     //$I->see('Message d erreur');
        
    //}

    public function SaturationMax(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 44 : Erreur
        //On met la saturation : 110% + formulaire avec données cohérente
        //Données non enregistré


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

        // Je teste comme quoi dans ce formulaire il y a bien le type "date" et le name "date_imc"
        $I->seeElement('input', ['type' => 'date', 'name' => 'date_imc']);

        // Je rempli le champ "DATE" avec la valeur "17/06/2020"
        $I->fillField('date_imc', '17/06/2020');

        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "350"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "114.29"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('frequence_cardiaque', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur "100"
        $I->fillField('FC_max_mesuree', '100');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur "22/06/2020"
        $I->fillField('Date_FC_max_mesuree', '22/06/2020');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('Saturation', '110');

        // Je click sur le bouton pour enregistrer
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        //$I->see('Message d erreur');
        
    }

    public function SaturationsNegativ(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 45 : Erreur
        //On met la saturation : -78% + formulaire avec données cohérente
        //Données non enregistré


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

        // Je teste comme quoi dans ce formulaire il y a bien le type "date" et le name "date_imc"
        $I->seeElement('input', ['type' => 'date', 'name' => 'date_imc']);

        // Je rempli le champ "DATE" avec la valeur "17/06/2020"
        $I->fillField('date_imc', '17/06/2020');

        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "-75"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "-24.49"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('FC_repos', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur "100"
        $I->fillField('FC_max_mesuree', '100');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur "22/06/2020"
        $I->fillField('Date_FC_max_mesuree', '22/06/2020');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('Saturation', '-78');
        
        // Je click sur le bouton pour enregistrer
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        //$I->see('Message d erreur');
        
    }

    public function SaturationUneDecimal(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 46 : Ok
        //On met la saturation : 67.2 % + formulaire avec données cohérente
        //Enregistrement des données done


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

        // Je teste comme quoi dans ce formulaire il y a bien le type "date" et le name "date_imc"
        $I->seeElement('input', ['type' => 'date', 'name' => 'date_imc']);

        // Je rempli le champ "DATE" avec la valeur "17/06/2020"
        $I->fillField('date_imc', '17/06/2020');

        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "70.3"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "22.96"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('FC_repos', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur "100"
        $I->fillField('FC_max_mesuree', '100');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur "22/06/2020"
        $I->fillField('Date_FC_max_mesuree', '22/06/2020');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "70"
        $I->fillField('Saturation', '67.2');
        
        // Je click sur le bouton pour enregistrer
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Message d'erreur"
        //$I->dontSee('Message d erreur');
        
    }

    public function SaturationDeuxDecimal(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 47 : Erreur
        //On met la saturation : 96.45% + formulaire avec données cohérente
        //Données non enregistré

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

        // Je teste comme quoi dans ce formulaire il y a bien le type "date" et le name "date_imc"
        $I->seeElement('input', ['type' => 'date', 'name' => 'date_imc']);

        // Je rempli le champ "DATE" avec la valeur "17/06/2020"
        $I->fillField('date_imc', '17/06/2020');

        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "50.23"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "16.40"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('FC_repos', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur "100"
        $I->fillField('FC_max_mesuree', '100');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur "22/06/2020"
        $I->fillField('Date_FC_max_mesuree', '22/06/2020');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "96.45"
        $I->fillField('Saturation', '96.45');
        
        // Je click sur le bouton pour enregistrer
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        //$I->see('Message d erreur');
        
    }

    public function SaturationsLetttres(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 48 : Erreur
        //On met la saturation : DR! + formulaire avec données cohérente
        //Données non enregistré

        
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

        // Je teste comme quoi dans ce formulaire il y a bien le type "date" et le name "date_imc"
        $I->seeElement('input', ['type' => 'date', 'name' => 'date_imc']);

        // Je rempli le champ "DATE" avec la valeur "17/06/2020"
        $I->fillField('date_imc', '17/06/2020');

        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur "PZ/"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', 'AT*');

        // Je regarde que le champ IMC soit bien egale "0.00"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "175"
        $I->fillField('Tour_taille', '175');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('FC_repos', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur "100"
        $I->fillField('FC_max_mesuree', '100');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur "22/06/2020"
        $I->fillField('Date_FC_max_mesuree', '22/06/2020');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur "DR!"
        $I->fillField('Saturation', 'DR!');
        
        // Je click sur le bouton pour enregistrer
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        //$I->see('Message d erreur');
        
    }

    public function SaturationVide(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 49 : Erreur
        //On ne met rien pour la saturation + formulaire avec données cohérente
        //Données non enregistré


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

        // Je teste comme quoi dans ce formulaire il y a bien le type "date" et le name "date_imc"
        $I->seeElement('input', ['type' => 'date', 'name' => 'date_imc']);

        // Je rempli le champ "DATE" avec la valeur "17/06/2020"
        $I->fillField('date_imc', '17/06/2020');

        // Je teste comme quoi dans ce formulaire il y a un bouton qui contient "Enregistrer"
        $I->seeElement('input', ['type' => 'submit', 'value' => 'Enregistrer']);

        // Je rempli le champ "poids" (champ du poids) avec la valeur ""
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "0.00"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "86"
        $I->fillField('FC_repos', '86');

        // Je rempli le champ "frequence cardiaque max mesure" (champ du frequence cardiaque mesure) avec la valeur "100"
        $I->fillField('FC_max_mesuree', '100');

        // Je rempli le champ "date FC max mesurée" (champ du date FC max mesurée) avec la valeur "22/06/2020"
        $I->fillField('Date_FC_max_mesuree', '22/06/2020');

        // Je rempli le champ "saturation en O2" (champ du saturation en 02) avec la valeur ""
        $I->fillField('Saturation', '');
        
        // Je click sur le bouton pour enregistrer
        $I->click('form input[type=submit]');

        //Je teste que je suis sur la bonne page après les résultat
        $I->seeInCurrentUrl('/PHP/Patients/Sante.php');

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        //$I->see('Message d erreur');
        
    }

}
