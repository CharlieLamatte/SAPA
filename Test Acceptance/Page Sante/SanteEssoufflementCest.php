<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class SanteEssoufflementCest  // /!\ Cest est obligatoire après le nom de la classe
{


public function EssoufflementValide(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 26 : Ok 
        //On met l'essoufflement : 5 + formulaire avec données cohérente 
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
        $I->seeInCurrentUrl('/PHP/¨Patients/Sante.php');

        // Je teste qu'il n'y est pas le texte suivant : "Message d erreur"
        //$I->dontSee('Message d erreur');

    }

    public function EssoufflementNegatif(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 27 : Erreur 
        //On met l'essoufflement : -4 + formulaire avec données cohérente
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

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "-4"
        $I->fillField('Essoufflement', '-4');

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

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        //$I->see('Message d erreur');
        
    }

    public function EssoufflementSupérieur(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 28 : Erreur
        //On met l'essoufflement : 12 + formulaire avec données cohérente
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

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "12"
        $I->fillField('Essoufflement', '12');

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

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        //$I->see('Message d erreur');
        
    }

    public function EssoufflementUneDecimal(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 29 : Ok
        //On met l'essoufflement : 9.5 + formulaire avec données cohérente
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

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "9.5"
        $I->fillField('Essoufflement', '9.5');

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

    public function EssoufflementDeuxDecimal(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 30 : Erreur
        //On met l'essoufflement: 4.56 + formulaire avec données cohérente
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

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "4.56"
        $I->fillField('Essoufflement', '4.56');

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

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        //$I->see('Message d erreur');
        
    }

    public function EssoufflementAvecLettre(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 31 : Erreur
        //On met l'essoufflement : TU + formulaire avec données cohérente
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

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "TU:"
        $I->fillField('Essoufflement', 'TU:');

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

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        //$I->see('Message d erreur');
        
    }

    public function EssoufflementNonRempli(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 32 : Erreur
        //On ne met rien pour l'essoufflement + formulaire avec données cohérente
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

        // Je rempli le champ "poids" (champ du poids) avec la valeur "85"
        $I->fillField('poids', '85');
        
        // Je rempli le champ "taille" (champ de la taille) avec la valeur "175"
        $I->fillField('taille', '175');

        // Je regarde que le champ IMC soit bien egale "27.76"
        $$I->grabValueFrom('input[name=IMC]');

        // Je rempli le champ "tour de taille" (champ du tour de taille) avec la valeur "100"
        $I->fillField('Tour_taille', '100');

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur ""
        $I->fillField('Essoufflement', '');

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

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        //$I->see('Message d erreur');
        
    }


}
