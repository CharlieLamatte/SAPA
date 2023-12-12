<?php

//*** 
// @Auteur: Chloé SICARD
// @DateDeCréation: 08/06/2021
// @DateDeDernièreMAJ : 14/06/2021 par Chloé SICARD
//***
// SPECIFICATIONS :
// Ce document sert à valider la page d'accueil des utilisateurs. Il s'appuie sur le document : Plan de Test & Debug.xlsx
// Il comprend la validation :
//      ***TESTS ÉCRITS OU EN COURS D'ÉCRITURE***
//      - le tri du tableau grâce aux filtres : FiltreRôle, FiltreNom, FiltrePrenom, FiltreTelPort, FiltreTelFixe, FiltreEmail, FiltreNomStruct, FiltreTypeStruct
//      - la barre de recherche : FiltreRecherche
//      - le bouton <- Retour : BoutonRetour
//      - l'affichage restreint à un certains nombre de lignes : AffichageRestreint
//      - les boutons d'accès aux pages : NumeroPage


//      ***TESTS À FAIRE***
//      - l'ouverture de la boîte mail grâce à l'adresse mail : RedirectionEmail
//      - les boutons d'accès aux pop-up : AjoutUtilisateur, ModifUtilisateur
//      - les boutons d'accès aux pages : PrecedentPremierePage, SuivantDernierePage,
//***

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class AccueilUtilisateursCest
{

/*
      //Filtre la colonne Rôle dans l'ordre alphabétique croissant puis décroissant
    public function FiltreRôle(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je suis sur la page d'accueil des utilisateurs, triée par défaut dans l'ordre alphabétique croissant des rôles des utilisateurs
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        //Je vérifie que les données de la première ligne sont bien présentes
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]');
        //Je clique sur "Rôle" pour trier par ordre alphabétique décroissant des rôles des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[1]');                
        $I->wait(5);
        $I->see('Évaluateur PEPS', '//*[@id="td1-15"]');
        $I->see('DUPOND','//*[@id="td2-15"]');
        $I->see('Bob', '//*[@id="td3-15"]');
        $I->see('Aucun','//*[@id="td4-15"]');
        $I->see('Aucun','//*[@id="td5-15"]');
        $I->see('Dupond.Bob@gmail.com','//*[@id="td6-15"]');
        $I->see('COMITé DéPARTEMENTAL DE TENNIS','//*[@id="td7-15"]');
        $I->see('Structure Sportive','//*[@id="td8-15"]');
    }*/


    //Filtre la colonne Nom dans l'ordre alphabétique croissant puis décroissant
    public function FiltreNom(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je suis sur la page d'accueil des utilisateurs, triée par défaut dans l'ordre alphabétique croissant les rôles des utilisateurs
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        $I->seeElement('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]'); //Tri sur cette colonne
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]');
        //Je clique sur "Nom" pour trier par ordre alphabétique croissant les noms des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[2]');        
        $I->wait(5);
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]'); //Tri sur cette colonne
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]');
        //Je clique sur "Nom" pour trier par ordre alphabétique décroissant les noms des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[2]');        
        $I->wait(5);
        $I->see('Coordinateur', '//*[@id="td1-16"]');
        $I->see('ÉVALUATEUR', '//*[@id="td2-16"]'); //Tri sur cette colonne
        $I->see('PEPS', '//*[@id="td3-16"]');
        $I->see('Aucun','//*[@id="td4-16"]');
        $I->see('Aucun','//*[@id="td5-16"]');
        $I->see('evaluateur@peps.fr','//*[@id="td6-16"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-16"]');
        $I->see('Centre PEPS','//*[@id="td8-16"]');        
    }

    /*
     //Filtre la colonne Prénom dans l'ordre alphabétique croissant puis décroissant
    public function FiltrePrenom(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je suis sur la page d'accueil des utilisateurs, triée par défaut dans l'ordre alphabétique croissant les rôles des utilisateurs
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]'); //Tri sur cette colonne
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]');
        //Je clique sur "Nom" pour trier par ordre alphabétique croissant les prénoms des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[3]');        
        $I->wait(5);
        $I->see('Évaluateur PEPS', '//*[@id="td1-15"]');
        $I->see('DUPOND','//*[@id="td2-15"]');
        $I->see('Bob', '//*[@id="td3-15"]'); //Tri sur cette colonne
        $I->see('Aucun','//*[@id="td4-15"]');
        $I->see('Aucun','//*[@id="td5-15"]');
        $I->see('Dupond.Bob@gmail.com','//*[@id="td6-15"]');
        $I->see('COMITé DéPARTEMENTAL DE TENNIS','//*[@id="td7-15"]');
        $I->see('Structure Sportive','//*[@id="td8-15"]');
        //Je clique sur "Prénom" pour trier par ordre alphabétique décroissant les prénoms des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[3]');        
        $I->wait(5);
        $I->see('Coordinateur', '//*[@id="td1-24"]');
        $I->see('TestV','//*[@id="td2-24"]');
        $I->see('Validation', '//*[@id="td3-24"]'); //Tri sur cette colonne     
        $I->see('Aucun','//*[@id="td4-24"]');
        $I->see('Aucun','//*[@id="td5-24"]');
        $I->see('test@gmail.com','//*[@id="td6-24"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-24"]');
        $I->see('Centre PEPS','//*[@id="td8-24"]');
    } 


    //Filtre la colonne Téléphone Portable dans l'ordre croissant puis décroissant
    public function FiltreTelPort(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je suis sur la page d'accueil des utilisateurs, triée par défaut dans l'ordre alphabétique croissant les rôles des utilisateurs
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]'); //Tri sur cette colonne
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]');
        //Je clique sur "Téléphone Portable" pour trier par ordre alphabétique croissant les numéro de téléphone portable des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[4]');        
        $I->wait(5);
        $I->see('Coordinateur', '//*[@id="td1-6"]');
        $I->see('GIRARD','//*[@id="td2-6"]');
        $I->see('Patrick', '//*[@id="td3-6"]');
        $I->see('0655555555', '//*[@id="td4-6"]'); //Tri sur cette colonne
        $I->see('Aucun','//*[@id="td5-6"]');
        $I->see('PG@gmail.com','//*[@id="td6-6"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-6"]');
        $I->see('Centre PEPS','//*[@id="td8-6"]');
        //Je clique sur "Téléphone portable" pour trier par ordre alphabétique décroissant les numéros de téléphone portable des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[4]');        
        $I->wait(5);
        $I->see('Coordinateur', '//*[@id="td1-11"]');
        $I->see('TESTCOORD1NOM','//*[@id="td2-11"]');
        $I->see('Testcoord1prenom', '//*[@id="td3-11"]');    
        $I->see('Aucun','//*[@id="td4-11"]'); //Tri sur cette colonne 
        $I->see('Aucun','//*[@id="td5-11"]');
        $I->see('testcoord1@sportsante86.fr','//*[@id="td6-11"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-11"]');
        $I->see('Centre PEPS','//*[@id="td8-11"]');        
    }


    //Filtre la colonne Téléphone Fixe dans l'ordre croissant puis décroissant
    public function FiltreTelFixe(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je suis sur la page d'accueil des utilisateurs, triée par défaut dans l'ordre alphabétique croissant les rôles des utilisateurs
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]'); //Tri sur cette colonne
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]');
        //Je clique sur "Téléphone Fixe" pour trier par ordre alphabétique croissant les numéro de téléphone fixe des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[5]');        
        $I->wait(5);
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]'); //Tri sur cette colonne
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]');         //Je clique sur "Téléphone Fixe" pour trier par ordre alphabétique décroissant les numéros de téléphone fixe des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[5]');        
        $I->wait(5);
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]'); //Tri sur cette colonne
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]');       
    }


    //Filtre la colonne Email dans l'ordre alphabétique croissant puis décroissant
    public function FiltreEmail(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je suis sur la page d'accueil des utilisateurs, triée par défaut dans l'ordre alphabétique croissant les rôles des utilisateurs
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]'); //Tri sur cette colonne
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]');
        //Je clique sur "Email" pour trier par ordre alphabétique croissant les email des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[6]');        
        $I->wait(5);
        $I->see('Évaluateur PEPS', '//*[@id="td1-15"]');
        $I->see('DUPOND','//*[@id="td2-15"]');
        $I->see('Bob', '//*[@id="td3-15"]');
        $I->see('Aucun','//*[@id="td4-15"]');
        $I->see('Aucun','//*[@id="td5-15"]');
        $I->see('Dupond.Bob@gmail.com','//*[@id="td6-15"]'); //Tri sur cette colonne
        $I->see('COMITé DéPARTEMENTAL DE TENNIS','//*[@id="td7-15"]');
        $I->see('Structure Sportive','//*[@id="td8-15"]');        
        //Je clique sur "Email" pour trier par ordre alphabétique décroissant les email des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[6]');        
        $I->wait(5);
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]'); //Tri sur cette colonne
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]');
    }


    //Filtre la colonne Nom de la structure dans l'ordre alphabétique croissant puis décroissant
    public function FiltreNomStruct(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je suis sur la page d'accueil des utilisateurs, triée par défaut dans l'ordre alphabétique croissant les rôles des utilisateurs
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]'); //Tri sur cette colonne
        $I->see('Centre PEPS','//*[@id="td8-1"]');
        //Je clique sur "Nom de la structure" pour trier par ordre alphabétique croissant les noms de structure de rattachement des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[7]');        
        $I->wait(5);
        $I->see('Intervenant sportif', '//*[@id="td1-10"]');
        $I->see('PEPS','//*[@id="td2-10"]');
        $I->see('MOBILE', '//*[@id="td3-10"]');
        $I->see('Aucun','//*[@id="td4-10"]');
        $I->see('Aucun','//*[@id="td5-10"]');
        $I->see('pepsM2@gmail.com','//*[@id="td6-10"]');
        $I->see('COMITé DéPARTEMENTAL DE TENNIS', '//*[@id="td7-10"]'); //Tri sur cette colonne
        $I->see('Structure Sportive','//*[@id="td8-10"]');
        //Je clique sur "Nom de la structure" pour trier par ordre alphabétique décroissant les noms de structures de rattachement des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[7]');        
        $I->wait(5);
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]'); //Tri sur cette colonne
        $I->see('Centre PEPS','//*[@id="td8-1"]');       
    }


    //Filtre la colonne Type de structure dans l'ordre alphabétique croissant puis décroissant
    public function FiltreTypeStruct(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je suis sur la page d'accueil des utilisateurs, triée par défaut dans l'ordre alphabétique croissant les rôles des utilisateurs
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]'); //Tri sur cette colonne
        //Je clique sur "Type de structure" pour trier par ordre alphabétique croissant le type de structure de rattachement des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[8]');        
        $I->wait(5);
        $I->see('Coordinateur', '//*[@id="td1-1"]');
        $I->see('CHASSIN','//*[@id="td2-1"]');
        $I->see('THOMAS', '//*[@id="td3-1"]');
        $I->see('0999999991','//*[@id="td4-1"]');
        $I->see('Aucun','//*[@id="td5-1"]');
        $I->see('thomas.chassin@sportsante86.fr','//*[@id="td6-1"]');
        $I->see('SPORT SANTE 86','//*[@id="td7-1"]');
        $I->see('Centre PEPS','//*[@id="td8-1"]'); //Tri sur cette colonne
        //Je clique sur "Type de structure" pour trier par ordre alphabétique décroissant le type de structure de rattachement des utilisateurs.
        $I->click('//*[@id="table_id_wrapper"]/div[3]/div[1]/div/table/thead/tr/th[8]');        
        $I->wait(5);
        $I->see('Intervenant sportif', '//*[@id="td1-10"]');
        $I->see('PEPS','//*[@id="td2-10"]');
        $I->see('MOBILE', '//*[@id="td3-10"]');
        $I->see('Aucun','//*[@id="td4-10"]');
        $I->see('Aucun','//*[@id="td5-10"]');
        $I->see('pepsM2@gmail.com','//*[@id="td6-10"]');
        $I->see('COMITé DéPARTEMENTAL DE TENNIS', '//*[@id="td7-10"]'); 
        $I->see('Structure Sportive','//*[@id="td8-10"]'); //Tri sur cette colonne
    }


    //Lorsque l'on clique sur le bouton <-Retour, l'utilisateur est redirigé vers la page d'accueil de l'administration
    public function BoutonRetour(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je vois le bouton <-Retour et je clique dessus pour retourner sur la page Administration
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        $I->seeElement('/html/body/div[2]/div[2]');
        $I->click('/html/body/div[2]/div[2]/a');
        $I->wait(3);
        //Je suis sur la page Administration
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->see('Administration');
    }


    //Grâce au menu déroulant, il y a possibilité d'afficher 10, 25, 50 ou 100 éléments
    public function AffichageRestreint(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je suis sur la page Utilisateurs, je regarde que la barre déroulante pour l'affichage restreint est présente
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        //Je teste l'affichage restreint à 10 éléments
        $I->selectOption('//*[@name="table_id_length"]/label/select','10');
        $I->wait(5);
        $I->seeElement('//*[@name="table_id_length"]/label/select/option[1]');
        //Je teste l'affichage restreint à 25 éléments
        $I->selectOption('//*[@name="table_id_length"]/label/select','25');
        $I->wait(5);
        $I->seeElement('//*[@name="table_id_length"]/label/select/option[2]');
        //Je teste l'affichage restreint à 50 éléments
        $I->selectOption('//*[@name="table_id_length"]/label/select','50');
        $I->wait(5);
        $I->seeElement('//*[@name="table_id_length"]/label/select/option[3]');
        //Je teste l'affichage restreint à 100 éléments
        $I->selectOption('//*[@name="table_id_length"]/label/select','100');
        $I->wait(5);
        $I->seeElement('//*[@name="table_id_length"]/label/select/option[4]');
    }


    //Lorsqu'il y a trop d'éléments, plusieurs pages sont nécessaires pour contenir
    //les utilisateurs et les informations qui leurs sont relatives.
    //En cliquant sur un numéro de page, on passe d'une page à celle désirée.
    public function NumeroPage(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
        //Je suis sur la page Utilisateurs, je regarde que la barre déroulante pour l'affichage restreint est présente
        $I->amOnPage('/../PHP/Users/ListeUser.php');
        //L''affichage est restreint à 10 éléments
        $I->selectOption('//*[@name="table_id_length"]/label/select','10');
        $I->wait(5);
        $I->seeElement('//*[@name="table_id_length"]/label/select/option[1]');
        //Je suis sur la page 1 : je vérifie le bouton "1", "2", "Précédent", "Suivant"
        Locator::elementAt('//*[@id="table_id_paginate"]/span/a[1]', -2);
        //Locator::elementAt('//*[@id="table_id_paginate"]/span/a[2]', )
        //$I->seeElement('//*[@id="table_id_paginate"]/span/a[1]', '#table_id_paginate > span > a.paginate_button.current');
        //$I->seeElement('//*[@id="table_id_paginate"]/span/a[2]', '#table_id_paginate > span > a:nth-child(2)');
        //$I->seeElement('//*[@id="table_id_previous"]', '#table_id_previous');
        //$I->seeElement('//*[@id="table_id_next"]','#table_id_next');
        //Je veux aller à la page 2 en cliquant sur le bouton 2
        $I->click('//*[@id="table_id_paginate"]/span/a[2]');
        $I->wait(5);
        //$I->seeElement('//*[@id="table_id_paginate"]/span/a[2]', '#table_id_paginate > span > a.paginate_button.current');
        //$I->seeElement('//*[@id="table_id_paginate"]/span/a[1]', '#table_id_paginate > span > a:nth-child(1)');

        //Je suis sur la page 2 affichant les éléments 11 à 20

    }


    //Filtre le tableau grâce à la barre de recherche
    public function FiltreRecherche(AcceptanceTester $I)
    {
        //Je me connecte
        $I->amOnPage('index.php');
        $I->fillField('identifiant', 'thomas.chassin@sportsante86.fr');
        $I->fillField('pswd', '5f43b1e9040ea');
        $I->click('Connexion');
        $I->wait(5);
        $I->dontseeInCurrentUrl('/index.php');
        //Je clique sur le bouton Settings pour accéder à l'administration
        $I->seeElement('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->click('//*[@id="bs-example-navbar-collapse-1"]/ul/li[1]/a');
        $I->wait(5);
        //Je suis sur la page Administration et je veux accéder à l'onglet Utilisateurs
        $I->amOnPage('/../PHP/Settings/Settings.php');
        $I->seeElement('//*[@id="boutonAutre"]');
        $I->click('Utilisateurs');
        $I->wait(5);
    }*/
}