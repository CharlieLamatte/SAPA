<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;

class SanteFCreposCest  // /!\ Cest est obligatoire après le nom de la classe
{


public function FCReposNomal(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 33 : Ok 
        //On met le FC repos : 86bpm + formulaire avec données cohérente 
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

        // Je teste qu'il n'y est pas le texte suivant : "Message d erreur"
        $I->dontSee('Message d erreur');

    }

    public function FCReposTropPetite(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 34 : Erreur 
        //On met le FC repos : 8bpm + formulaire avec données cohérente
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

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "8"
        $I->fillField('FC_repos', '8');

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
        $I->see('Message d erreur');
        
    }

    public function FCReposPetiteValeur(AcceptanceTester $I)
    {
        //Test avec les parametres valide
        //Cas 35 : OK
        //On met le FC repos : 24bpm + formulaire avec données cohérente
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

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "24"
        $I->fillField('FC_repos', '24');

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
        $I->dontSee('Message d erreur');
        
    }

    public function FCReposValeurTropGrande(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 36 : Erreur
        //On met le FC repos : 369bpm + formulaire avec données cohérente
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

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "396"
        $I->fillField('FC_repos', '396');

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
        $I->see('Message d erreur');
        
    }

    public function FCReposUneDecimal(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 37 : Erreur
        //On met le FC repos : 78.5bpm + formulaire avec données cohérente
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

        // Je teste que je trouve bien le texte suivant : "Message d'erreur"
        $I->see('Message d erreur');
        
    }

    public function FCReposDeuxDecimal(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 38 : Erreur
        //On met le FC repos : 96.23bpm + formulaire avec données cohérente
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

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "96.23"
        $I->fillField('FC_repos', '96.23');

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
        $I->see('Message d erreur');
        
    }

    public function FCReposNegatif(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 39 : Erreur
        //On met le FC repos : -56bpm + formulaire avec données cohérente
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

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "-56"
        $I->fillField('FC_repos', '-56');

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
        $I->see('Message d erreur');
        
    }

    public function FCReposLettre(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 40 : Erreur
        //On met le FC repos : MS$ + formulaire avec données cohérente
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

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur "MS$"
        $I->fillField('FC_repos', 'MS$');

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
        $I->see('Message d erreur');
        
    }

    public function FCReposValide(AcceptanceTester $I)
    {
        //Test avec les parametres invalide
        //Cas 41 : Erreur
        //On ne met rien pour le FC repos + formulaire avec données cohérente
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

        // Je rempli le champ "essouflement" (champ du essouflement) avec la valeur "5"
        $I->fillField('Essoufflement', '5');

        // Je rempli le champ "frequence cardiaque au repos" (champ du frequence cardiaque au repos) avec la valeur ""
        $I->fillField('FC_repos', '');

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
        $I->see('Message d erreur');
        
    }



}
