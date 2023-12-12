<?php

namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;
class GestionIntervenant_PrenomCest  // /!\ Cest est obligatoire après le nom de la classe
{
    // ce document contient les tests en rapport avec la recherche par prénom.

    public function Cas5_8_PrenomCorrect(AcceptanceTester $I)
    //Recherche d'un intervenant dans la barre de recherche avec un prénom correct
    //Ce cas est fonctionnel

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Vérification de la présence du bouton Gestion intervenant
        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        //Je clique sur le bouton gestion intervenant
        $I->click('Gestion Intervenants');

        $I->wait(3);

        //Je verifie que je suis bien sur l'URL /PHP/Intervenants/ListeIntervenant.php
        $I->seeInCurrentUrl('/PHP/Intervenants/ListeIntervenant.php');

        //Je vérifie qu'on voit bien le texte "Liste des intervenants"
        $I->see('Liste des Intervenants');

        //Je verifie la présence de la barre de recherche
        $I->seeElement('input', ['type'=>'search']);

        //Je rempli la barre de recherche
        $I->fillField('//*[@id="table_id_filter"]/label/input', 'Vincent');

        //Je vérifie que le résulat de ma recherche s'affiche bien
        $I->see('Vincent');

        //Vérification si le tableau est bien actualisé
        $I->see('Affichage de l\'élément 1 à 1 sur 1 éléments');
    }

    public function Cas5_9_PrenomCorrect_FullMajuscule(AcceptanceTester $I)
    //Recherche d'un intervenant dans la barre de recherche avec un prénom correct en majuscule
    //Ce cas est fonctionnel

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Vérification de la présence du bouton Gestion intervenant
        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        //Je clique sur le bouton gestion intervenant
        $I->click('Gestion Intervenants');

        $I->wait(3);

        //Je verifie que je suis bien sur l'URL /PHP/Intervenants/ListeIntervenant.php
        $I->seeInCurrentUrl('/PHP/Intervenants/ListeIntervenant.php');

        //Je vérifie qu'on voit bien le texte "Liste des intervenants"
        $I->see('Liste des Intervenants');

        //Je verifie la présence de la barre de recherche
        $I->seeElement('input', ['type'=>'search']);

        //Je rempli la barre de recherche
        $I->fillField('//*[@id="table_id_filter"]/label/input', 'VINCENT');

        //Je vérifie que le résulat de ma recherche s'affiche bien
        $I->see('Vincent');

        //Vérification si le tableau est bien actualisé
        $I->see('Affichage de l\'élément 1 à 1 sur 1 éléments');
    }

    public function Cas5_10_PrenomIncorrect_Incoherent(AcceptanceTester $I)
    //Recherche d'un intervenant dans la barre de recherche avec un prénom incohérent : Majuscules, minuscules, espaces ...
    //Ce cas est fonctionnel
    //La recherche trouve bien un résultat plutot coherent vis a vis du prénom mal écrit

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

        //Test du bouton setting
        //vérification de la présence du lien
        $I->seeElement( Locator::href( '/PHP/Settings/Settings.php' ) );

        //on clique sur le lien
        $I->click( Locator::href( '/PHP/Settings/Settings.php' ) );

        // Je verifie que je suis bien sur la page /PHP/Settings/Settings.php
        $I->seeInCurrentUrl('/PHP/Settings/Settings.php'); 

        //Vérification de la présence du bouton Gestion intervenant
        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Intervenants']);

        //Je clique sur le bouton gestion intervenant
        $I->click('Gestion Intervenants');

        $I->wait(3);

        //Je verifie que je suis bien sur l'URL /PHP/Intervenants/ListeIntervenant.php
        $I->seeInCurrentUrl('/PHP/Intervenants/ListeIntervenant.php');

        //Je vérifie qu'on voit bien le texte "Liste des intervenants"
        $I->see('Liste des Intervenants');

        //Je verifie la présence de la barre de recherche
        $I->seeElement('input', ['type'=>'search']);

        //Je rempli la barre de recherche
        $I->fillField('//*[@id="table_id_filter"]/label/input', 'v          in           C     EN         t');

        //Je vérifie que le résulat de ma recherche s'affiche bien
        $I->see('Vincent');

        //Vérification si le tableau est bien actualisé
        $I->see('Affichage de l\'élément 1 à 1 sur 1 éléments');
    }
}