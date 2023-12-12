<?php
//Dans ce fichier, nous testons la page des responsables et notamment les boutons pour se déplacer sur les differentes pages regroupant les responsables
//les boutons sont les suivants : Précédent, Suivant ainsi que tous les boutons individuels correspondant à chaque page



namespace App\Tests\acceptance;

use App\Tests\AcceptanceTester;
use \Codeception\Util\Locator;

class BoutonSuivantPecedentPageResponsableCest  // /!\ Cest est obligatoire après le nom de la classe
{
	
    
    public function Cas8_boutonAjoutResponsable(AcceptanceTester $I)
	//ce test est correct
	//lorsqu'on clique sur ce bouton, on est rediriger vers la page suivante par rapport à celle où l'on était de base
    {
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Suivant
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="table_id_next"]');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="table_id_next"]');
		
		//verification de la redirection vers la page d'apres
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/ListeResponsable.php');
				
	}

public function Cas9_boutonPrecedentResponsable(AcceptanceTester $I)
	//ce test est correct
	//lorsqu'on clique sur ce bouton, on est rediriger vers la page précédente par rapport à celle où l'on était de base
    {
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton Suivant
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="table_id_previous"]');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="table_id_previous"]');
		
		//verification de la redirection vers la page d'avant
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/ListeResponsable.php');
				
	}	
	public function Cas10_boutonNumPageResponsable(AcceptanceTester $I)
	//ce test est correct
	//lorsqu'on clique sur un de ces boutons, on est rediriger vers la page souhaitée
    {
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

        $I->seeElement('input', ['type'=>'button','value'=>'Gestion Responsables']);

        $I->click('Gestion Responsables');
        $I->wait(4);

        $I->seeInCurrentUrl('ListeResponsable.php');
        $I->wait(2);
		
     		
		//Test du bouton numero de page, 3
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="table_id_paginate"]/span/a[3]');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="table_id_paginate"]/span/a[3]');
		
		//verification de la redirection vers la page d'avant
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/ListeResponsable.php');
		
		//Test du bouton numero de page, 1
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="table_id_paginate"]/span/a[1]');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="table_id_paginate"]/span/a[1]');
		
		//verification de la redirection vers la page d'avant
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/ListeResponsable.php');
		
		//Test du bouton numero de page, 2
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="table_id_paginate"]/span/a[2]');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="table_id_paginate"]/span/a[2]');
		
		//verification de la redirection vers la page d'avant
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/ListeResponsable.php');
		
		//Test du bouton numero de page, 4
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="table_id_paginate"]/span/a[4]');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="table_id_paginate"]/span/a[4]');
		
		//verification de la redirection vers la page d'avant
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/ListeResponsable.php');
		
		//Test du bouton numero de page, 5
		//vérification de la présence du bouton
        $I->seeElement('//*[@id="table_id_paginate"]/span/a[5]');
		
		//verification si le bouton est cliquable
		$I->click('//*[@id="table_id_paginate"]/span/a[5]');
		
		//verification de la redirection vers la page d'avant
		$I->wait(2);
		$I->seeInCurrentUrl('/PHP/Responsables/ListeResponsable.php');
		
				
	}	
		
		

	
}