<?php

//Le chemin d'accès jusqu'à la page ListeIntervenant.php est fonctionnel.
//Celle-ci risque d'être modifier
//Ce document a été fait le 23/06. Le formulaire 


namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;
class IntervenantCest  // /!\ Cest est obligatoire après le nom de la classe
{
            // ce document tourne autour des tests de en rapport avec le prénom dans la barre de recherche.


 public function Cas5_0_AffichageNombreResultat(AcceptanceTester $I)
//On vérifie que Affichage de l'élément 1 à 10 sur 70 éléments”
//Ce cas fonctionne

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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 70 éléments');

    }
 public function Cas5_1_RechercheJULIEN(AcceptanceTester $I)
//On vérifie que Affichage en écrivant comme "JULIEN"
//Ce cas fonctionne
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 70 éléments');

        $I->seeElement('input',['type'=>'search']);
        $I->fillField('//*[@id="table_id_filter"]/label/input','JULIEN');

        $I->see('Vincent');
    }

     public function Cas5_2_Recherche_JULIEN(AcceptanceTester $I)
//On vérifie que Affichage en écrivant comme " JULIEN"
//Ce cas fonctionne
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 70 éléments');

        $I->seeElement('input',['type'=>'search']);
        $I->fillField('//*[@id="table_id_filter"]/label/input',' JULIEN');

        $I->see('Vincent');
    }
     public function Cas5_3_Recherchejulien(AcceptanceTester $I)
//On vérifie que Affichage en écrivant comme "julien"
//Ce cas fonctionne
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 70 éléments');

        $I->seeElement('input',['type'=>'search']);
        $I->fillField('//*[@id="table_id_filter"]/label/input','julien');

        $I->see('Vincent');
    }

     public function Cas5_4_RechercheJU_LIEN(AcceptanceTester $I)
//On vérifie que Affichage en écrivant comme "JU LIEN"
//Ce cas fonctionne
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 70 éléments');

        $I->seeElement('input',['type'=>'search']);
        $I->fillField('//*[@id="table_id_filter"]/label/input','JU LIEN');

        $I->see('Vincent');
    }

     public function Cas5_5_Recherche_special (AcceptanceTester $I)
//On vérifie que Affichage en écrivant comme "%"
//Ce cas fonctionne
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 70 éléments');

        $I->seeElement('input',['type'=>'search']);
        $I->fillField('//*[@id="table_id_filter"]/label/input','%');

        $I->dontSee('Vincent');
    }

     public function Cas5_6_RechercheAz(AcceptanceTester $I)
//On vérifie que Affichage en écrivant comme "Az"
//Ce cas fonctionne
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 70 éléments');

        $I->seeElement('input',['type'=>'search']);
        $I->fillField('//*[@id="table_id_filter"]/label/input','Az');

        $I->see('Marine');
        $I->see('zeaeeazezzea');
    }

     public function Cas5_7_RechercherJ_u_L_I_____________en(AcceptanceTester $I)
//On vérifie que Affichage en écrivant comme "J u L I             en"
//Ce cas fonctionne
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
        $I->wait(2);
        // Je click sur le bouton du login
        $I->click('form input[type=submit]');
        $I->wait(2);

        // Je teste que je suis bien sur la page PHP/Accueil.php
        $I->seeInCurrentUrl('PHP/Accueil_liste.php');
        $I->wait(2);

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );
        $I->wait(2);

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 
        $I->wait(2);

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        $I->click('Gestion Intervenants');
        $I->wait(4);
        
        $I->seeInCurrentUrl('ListeIntervenant.php');
        $I->wait(2);

        $I->See('Affichage de l');
        $I->See('élément 1 à 10 sur 70 éléments');

        $I->seeElement('input',['type'=>'search']);
        $I->fillField('//*[@id="table_id_filter"]/label/input','J u L I             en');

        $I->see('Vincent');
    }
}
