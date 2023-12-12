<?php

/**
 * Ces tests servent à vérifier que les utilisateurs peuvent modifier leur compte.
 * Test la modification de tous les champs sauf:
 * - la structure
 * - l'email
 * - le mot de passe
 * - le champ "Est coordonnateur territorial PEPS?" pour le coordonnateur
 * - les diplomes pour l'intervenant
 */

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\Page\Acceptance\Login;

class MonCompteCest
{
    private $goToSettingsButton = ["id" => "administration-link"];

    private $monCompteButton = ["id" => "mon-compte"];
    private $modal = ["id" => "modal-user"];
    private $toast = ["id" => "toast"];

    // elements du formulaire "mon compte"

    private $enregistrerModifierButton = ["id" => "enregistrer-modifier-user"];

    // coordonnées
    private $nomField = ["id" => "nom-user"];
    private $prenomField = ["id" => "prenom-user"];
    private $telPortableField = ["id" => "tel-portable-user"];
    private $telFixeField = ["id" => "tel-fixe-user"];

    // settings
    private $nombre_elements_tableauxSelect = ["id" => "nombre_elements_tableaux"];

    // spécifique superviseur
    private $fonctionField = ["id" => "nom-fonction"];

    // spécifique intervenant
    private $statutSelect = ["id" => "statut-user"];
    private $numero_carteField = ["id" => "numero_carte-user"];

    public function _before(AcceptanceTester $I)
    {
    }

    public function monCompteSuperviseurPeps(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testSuperviseurNom@sportsante86.fr', 'testAdmin1.1@A');

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToSettingsButton);
        $I->waitPageLoad();
        $I->see("Administration");

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->monCompteButton);
        $I->dontSeeElement($this->modal);
        $I->click($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);
        $I->see("Données superviseur PEPS");
        $I->dontSee("Données coordonnateur");
        $I->dontSee("Données professionnelles");
        $I->see("Mes choix interface");

        // coordonnées
        $nom = $I->grabValueFrom($this->nomField);
        $I->assertNotEmpty($nom);
        $nom = ChaineCharactere::str_shuffle_unicode($nom);

        $prenom = $I->grabValueFrom($this->prenomField);
        $I->assertNotEmpty($prenom);
        $prenom = ChaineCharactere::str_shuffle_unicode($prenom);

        $tel_portable = $I->grabValueFrom($this->telPortableField);
        if (empty($tel_portable)) {
            $tel_portable = "1492765676";
        } else {
            $tel_portable = ChaineCharactere::str_shuffle_unicode($tel_portable);
        }

        $tel_fixe = $I->grabValueFrom($this->telFixeField);
        if (empty($tel_fixe)) {
            $tel_fixe = "1492765633";
        } else {
            $tel_fixe = ChaineCharactere::str_shuffle_unicode($tel_fixe);
        }

        // spécifique superviseur
        $fonction = $I->grabValueFrom($this->fonctionField);
        $I->assertNotEmpty($fonction);
        $fonction = ChaineCharactere::str_shuffle_unicode($fonction);

        // settings
        $nombre_elements_tableaux = $I->grabValueFrom($this->nombre_elements_tableauxSelect);
        $I->assertNotEmpty($nombre_elements_tableaux);
        $nombre_elements_tableaux = $this->get_different_nombre_elements_tableaux($nombre_elements_tableaux);
        $I->assertNotEmpty($nombre_elements_tableaux);

        $I->wantTo("Entrer dans le mode édition");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        $I->fillField($this->nomField, $nom);
        $I->fillField($this->prenomField, $prenom);
        $I->fillField($this->telFixeField, $tel_fixe);
        $I->fillField($this->telPortableField, $tel_portable);
        $I->fillField($this->fonctionField, $fonction);
        $I->selectOption($this->nombre_elements_tableauxSelect, $nombre_elements_tableaux);

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur modifié avec succes", $this->toast);

        $I->wantTo("Ré-ouvrir le modal");
        $I->dontSeeElement($this->modal);
        $I->seeElement($this->monCompteButton);
        $I->waitForElementClickable($this->monCompteButton, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $nom_modified = $I->grabValueFrom($this->nomField);
        $prenom_modified = $I->grabValueFrom($this->prenomField);
        $tel_portable_modified = $I->grabValueFrom($this->telPortableField);
        $tel_fixe_modified = $I->grabValueFrom($this->telFixeField);
        $fonction_modified = $I->grabValueFrom($this->fonctionField);
        $nombre_elements_tableaux_modified = $I->grabValueFrom($this->nombre_elements_tableauxSelect);

        $I->assertEquals($nom, $nom_modified);
        $I->assertEquals($prenom, $prenom_modified);
        $I->assertEquals($tel_portable, $tel_portable_modified);
        $I->assertEquals($tel_fixe, $tel_fixe_modified);
        $I->assertEquals($fonction, $fonction_modified);
        $I->assertEquals($nombre_elements_tableaux, $nombre_elements_tableaux_modified);
    }

    public function monCompteCoordonnateurPeps(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToSettingsButton);
        $I->waitPageLoad();
        $I->see("Administration");

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->monCompteButton);
        $I->dontSeeElement($this->modal);
        $I->click($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);
        $I->dontSee("Données superviseur PEPS");
        $I->see("Données coordonnateur");
        $I->dontSee("Données professionnelles");
        $I->see("Mes choix interface");

        // coordonnées
        $nom = $I->grabValueFrom($this->nomField);
        $I->assertNotEmpty($nom);
        $nom = ChaineCharactere::str_shuffle_unicode($nom);

        $prenom = $I->grabValueFrom($this->prenomField);
        $I->assertNotEmpty($prenom);
        $prenom = ChaineCharactere::str_shuffle_unicode($prenom);

        $tel_portable = $I->grabValueFrom($this->telPortableField);
        if (empty($tel_portable)) {
            $tel_portable = "1492765676";
        } else {
            $tel_portable = ChaineCharactere::str_shuffle_unicode($tel_portable);
        }

        $tel_fixe = $I->grabValueFrom($this->telFixeField);
        if (empty($tel_fixe)) {
            $tel_fixe = "1492765633";
        } else {
            $tel_fixe = ChaineCharactere::str_shuffle_unicode($tel_fixe);
        }

        // settings
        $nombre_elements_tableaux = $I->grabValueFrom($this->nombre_elements_tableauxSelect);
        $I->assertNotEmpty($nombre_elements_tableaux);
        $nombre_elements_tableaux = $this->get_different_nombre_elements_tableaux($nombre_elements_tableaux);
        $I->assertNotEmpty($nombre_elements_tableaux);

        $I->wantTo("Entrer dans le mode édition");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        $I->fillField($this->nomField, $nom);
        $I->fillField($this->prenomField, $prenom);
        $I->fillField($this->telFixeField, $tel_fixe);
        $I->fillField($this->telPortableField, $tel_portable);
        $I->selectOption($this->nombre_elements_tableauxSelect, $nombre_elements_tableaux);

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur modifié avec succes", $this->toast);

        $I->wantTo("Ré-ouvrir le modal");
        $I->dontSeeElement($this->modal);
        $I->seeElement($this->monCompteButton);
        $I->waitForElementClickable($this->monCompteButton, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $nom_modified = $I->grabValueFrom($this->nomField);
        $prenom_modified = $I->grabValueFrom($this->prenomField);
        $tel_portable_modified = $I->grabValueFrom($this->telPortableField);
        $tel_fixe_modified = $I->grabValueFrom($this->telFixeField);
        $nombre_elements_tableaux_modified = $I->grabValueFrom($this->nombre_elements_tableauxSelect);

        $I->assertEquals($nom, $nom_modified);
        $I->assertEquals($prenom, $prenom_modified);
        $I->assertEquals($tel_portable, $tel_portable_modified);
        $I->assertEquals($tel_fixe, $tel_fixe_modified);
        $I->assertEquals($nombre_elements_tableaux, $nombre_elements_tableaux_modified);
    }

    public function monCompteCoordonnateurMss(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToSettingsButton);
        $I->waitPageLoad();
        $I->see("Administration");

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->monCompteButton);
        $I->dontSeeElement($this->modal);
        $I->click($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);
        $I->dontSee("Données superviseur PEPS");
        $I->see("Données coordonnateur");
        $I->dontSee("Données professionnelles");
        $I->see("Mes choix interface");

        // coordonnées
        $nom = $I->grabValueFrom($this->nomField);
        $I->assertNotEmpty($nom);
        $nom = ChaineCharactere::str_shuffle_unicode($nom);

        $prenom = $I->grabValueFrom($this->prenomField);
        $I->assertNotEmpty($prenom);
        $prenom = ChaineCharactere::str_shuffle_unicode($prenom);

        $tel_portable = $I->grabValueFrom($this->telPortableField);
        if (empty($tel_portable)) {
            $tel_portable = "1492765676";
        } else {
            $tel_portable = ChaineCharactere::str_shuffle_unicode($tel_portable);
        }

        $tel_fixe = $I->grabValueFrom($this->telFixeField);
        if (empty($tel_fixe)) {
            $tel_fixe = "1492765633";
        } else {
            $tel_fixe = ChaineCharactere::str_shuffle_unicode($tel_fixe);
        }

        // settings
        $nombre_elements_tableaux = $I->grabValueFrom($this->nombre_elements_tableauxSelect);
        $I->assertNotEmpty($nombre_elements_tableaux);
        $nombre_elements_tableaux = $this->get_different_nombre_elements_tableaux($nombre_elements_tableaux);
        $I->assertNotEmpty($nombre_elements_tableaux);

        $I->wantTo("Entrer dans le mode édition");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        $I->fillField($this->nomField, $nom);
        $I->fillField($this->prenomField, $prenom);
        $I->fillField($this->telFixeField, $tel_fixe);
        $I->fillField($this->telPortableField, $tel_portable);
        $I->selectOption($this->nombre_elements_tableauxSelect, $nombre_elements_tableaux);

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur modifié avec succes", $this->toast);

        $I->wantTo("Ré-ouvrir le modal");
        $I->dontSeeElement($this->modal);
        $I->seeElement($this->monCompteButton);
        $I->waitForElementClickable($this->monCompteButton, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $nom_modified = $I->grabValueFrom($this->nomField);
        $prenom_modified = $I->grabValueFrom($this->prenomField);
        $tel_portable_modified = $I->grabValueFrom($this->telPortableField);
        $tel_fixe_modified = $I->grabValueFrom($this->telFixeField);
        $nombre_elements_tableaux_modified = $I->grabValueFrom($this->nombre_elements_tableauxSelect);

        $I->assertEquals($nom, $nom_modified);
        $I->assertEquals($prenom, $prenom_modified);
        $I->assertEquals($tel_portable, $tel_portable_modified);
        $I->assertEquals($tel_fixe, $tel_fixe_modified);
        $I->assertEquals($nombre_elements_tableaux, $nombre_elements_tableaux_modified);
    }

    public function monCompteCoordonnateurStructureNonMss(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToSettingsButton);
        $I->waitPageLoad();
        $I->see("Administration");

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->monCompteButton);
        $I->dontSeeElement($this->modal);
        $I->click($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);
        $I->dontSee("Données superviseur PEPS");
        $I->see("Données coordonnateur");
        $I->dontSee("Données professionnelles");
        $I->see("Mes choix interface");

        // coordonnées
        $nom = $I->grabValueFrom($this->nomField);
        $I->assertNotEmpty($nom);
        $nom = ChaineCharactere::str_shuffle_unicode($nom);

        $prenom = $I->grabValueFrom($this->prenomField);
        $I->assertNotEmpty($prenom);
        $prenom = ChaineCharactere::str_shuffle_unicode($prenom);

        $tel_portable = $I->grabValueFrom($this->telPortableField);
        if (empty($tel_portable)) {
            $tel_portable = "1492765676";
        } else {
            $tel_portable = ChaineCharactere::str_shuffle_unicode($tel_portable);
        }

        $tel_fixe = $I->grabValueFrom($this->telFixeField);
        if (empty($tel_fixe)) {
            $tel_fixe = "1492765633";
        } else {
            $tel_fixe = ChaineCharactere::str_shuffle_unicode($tel_fixe);
        }

        // settings
        $nombre_elements_tableaux = $I->grabValueFrom($this->nombre_elements_tableauxSelect);
        $I->assertNotEmpty($nombre_elements_tableaux);
        $nombre_elements_tableaux = $this->get_different_nombre_elements_tableaux($nombre_elements_tableaux);
        $I->assertNotEmpty($nombre_elements_tableaux);

        $I->wantTo("Entrer dans le mode édition");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        $I->fillField($this->nomField, $nom);
        $I->fillField($this->prenomField, $prenom);
        $I->fillField($this->telFixeField, $tel_fixe);
        $I->fillField($this->telPortableField, $tel_portable);
        $I->selectOption($this->nombre_elements_tableauxSelect, $nombre_elements_tableaux);

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur modifié avec succes", $this->toast);

        $I->wantTo("Ré-ouvrir le modal");
        $I->dontSeeElement($this->modal);
        $I->seeElement($this->monCompteButton);
        $I->waitForElementClickable($this->monCompteButton, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $nom_modified = $I->grabValueFrom($this->nomField);
        $prenom_modified = $I->grabValueFrom($this->prenomField);
        $tel_portable_modified = $I->grabValueFrom($this->telPortableField);
        $tel_fixe_modified = $I->grabValueFrom($this->telFixeField);
        $nombre_elements_tableaux_modified = $I->grabValueFrom($this->nombre_elements_tableauxSelect);

        $I->assertEquals($nom, $nom_modified);
        $I->assertEquals($prenom, $prenom_modified);
        $I->assertEquals($tel_portable, $tel_portable_modified);
        $I->assertEquals($tel_fixe, $tel_fixe_modified);
        $I->assertEquals($nombre_elements_tableaux, $nombre_elements_tableaux_modified);
    }

    public function monCompteAdmin(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToSettingsButton);
        $I->waitPageLoad();
        $I->see("Administration");

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->monCompteButton);
        $I->dontSeeElement($this->modal);
        $I->click($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);
        $I->dontSee("Données superviseur PEPS");
        $I->dontSee("Données coordonnateur");
        $I->dontSee("Données professionnelles");
        $I->see("Mes choix interface");

        // coordonnées
        $nom = $I->grabValueFrom($this->nomField);
        $I->assertNotEmpty($nom);
        $nom = ChaineCharactere::str_shuffle_unicode($nom);

        $prenom = $I->grabValueFrom($this->prenomField);
        $I->assertNotEmpty($prenom);
        $prenom = ChaineCharactere::str_shuffle_unicode($prenom);

        $tel_portable = $I->grabValueFrom($this->telPortableField);
        if (empty($tel_portable)) {
            $tel_portable = "1492765676";
        } else {
            $tel_portable = ChaineCharactere::str_shuffle_unicode($tel_portable);
        }

        $tel_fixe = $I->grabValueFrom($this->telFixeField);
        if (empty($tel_fixe)) {
            $tel_fixe = "1492765633";
        } else {
            $tel_fixe = ChaineCharactere::str_shuffle_unicode($tel_fixe);
        }

        // settings
        $nombre_elements_tableaux = $I->grabValueFrom($this->nombre_elements_tableauxSelect);
        $I->assertNotEmpty($nombre_elements_tableaux);
        $nombre_elements_tableaux = $this->get_different_nombre_elements_tableaux($nombre_elements_tableaux);
        $I->assertNotEmpty($nombre_elements_tableaux);

        $I->wantTo("Entrer dans le mode édition");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        $I->fillField($this->nomField, $nom);
        $I->fillField($this->prenomField, $prenom);
        $I->fillField($this->telFixeField, $tel_fixe);
        $I->fillField($this->telPortableField, $tel_portable);
        $I->selectOption($this->nombre_elements_tableauxSelect, $nombre_elements_tableaux);

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur modifié avec succes", $this->toast);

        $I->wantTo("Ré-ouvrir le modal");
        $I->dontSeeElement($this->modal);
        $I->seeElement($this->monCompteButton);
        $I->waitForElementClickable($this->monCompteButton, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $nom_modified = $I->grabValueFrom($this->nomField);
        $prenom_modified = $I->grabValueFrom($this->prenomField);
        $tel_portable_modified = $I->grabValueFrom($this->telPortableField);
        $tel_fixe_modified = $I->grabValueFrom($this->telFixeField);
        $nombre_elements_tableaux_modified = $I->grabValueFrom($this->nombre_elements_tableauxSelect);

        $I->assertEquals($nom, $nom_modified);
        $I->assertEquals($prenom, $prenom_modified);
        $I->assertEquals($tel_portable, $tel_portable_modified);
        $I->assertEquals($tel_fixe, $tel_fixe_modified);
        $I->assertEquals($nombre_elements_tableaux, $nombre_elements_tableaux_modified);
    }

    public function monCompteResponsableStructure(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testResponsableStructureNom@sportsante86.fr', 'testResponsableStructureNom1.1@A');

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToSettingsButton);
        $I->waitPageLoad();
        $I->see("Administration");

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->monCompteButton);
        $I->dontSeeElement($this->modal);
        $I->click($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);
        $I->dontSee("Données superviseur PEPS");
        $I->dontSee("Données coordonnateur");
        $I->dontSee("Données professionnelles");
        $I->see("Mes choix interface");

        // coordonnées
        $nom = $I->grabValueFrom($this->nomField);
        $I->assertNotEmpty($nom);
        $nom = ChaineCharactere::str_shuffle_unicode($nom);

        $prenom = $I->grabValueFrom($this->prenomField);
        $I->assertNotEmpty($prenom);
        $prenom = ChaineCharactere::str_shuffle_unicode($prenom);

        $tel_portable = $I->grabValueFrom($this->telPortableField);
        if (empty($tel_portable)) {
            $tel_portable = "1492765676";
        } else {
            $tel_portable = ChaineCharactere::str_shuffle_unicode($tel_portable);
        }

        $tel_fixe = $I->grabValueFrom($this->telFixeField);
        if (empty($tel_fixe)) {
            $tel_fixe = "1492765633";
        } else {
            $tel_fixe = ChaineCharactere::str_shuffle_unicode($tel_fixe);
        }

        // settings
        $nombre_elements_tableaux = $I->grabValueFrom($this->nombre_elements_tableauxSelect);
        $I->assertNotEmpty($nombre_elements_tableaux);
        $nombre_elements_tableaux = $this->get_different_nombre_elements_tableaux($nombre_elements_tableaux);
        $I->assertNotEmpty($nombre_elements_tableaux);

        $I->wantTo("Entrer dans le mode édition");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        $I->fillField($this->nomField, $nom);
        $I->fillField($this->prenomField, $prenom);
        $I->fillField($this->telFixeField, $tel_fixe);
        $I->fillField($this->telPortableField, $tel_portable);
        $I->selectOption($this->nombre_elements_tableauxSelect, $nombre_elements_tableaux);

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur modifié avec succes", $this->toast);

        $I->wantTo("Ré-ouvrir le modal");
        $I->dontSeeElement($this->modal);
        $I->seeElement($this->monCompteButton);
        $I->waitForElementClickable($this->monCompteButton, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $nom_modified = $I->grabValueFrom($this->nomField);
        $prenom_modified = $I->grabValueFrom($this->prenomField);
        $tel_portable_modified = $I->grabValueFrom($this->telPortableField);
        $tel_fixe_modified = $I->grabValueFrom($this->telFixeField);
        $nombre_elements_tableaux_modified = $I->grabValueFrom($this->nombre_elements_tableauxSelect);

        $I->assertEquals($nom, $nom_modified);
        $I->assertEquals($prenom, $prenom_modified);
        $I->assertEquals($tel_portable, $tel_portable_modified);
        $I->assertEquals($tel_fixe, $tel_fixe_modified);
        $I->assertEquals($nombre_elements_tableaux, $nombre_elements_tableaux_modified);
    }

    public function monCompteIntervenant(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testIntervenantAbc@gmail.com', 'testIntervenantAbc@1d');

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToSettingsButton);
        $I->waitPageLoad();
        $I->see("Administration");

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->monCompteButton);
        $I->dontSeeElement($this->modal);
        $I->click($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);
        $I->dontSee("Données superviseur PEPS");
        $I->dontSee("Données coordonnateur");
        $I->see("Données professionnelles");
        $I->see("Mes choix interface");

        // coordonnées
        $nom = $I->grabValueFrom($this->nomField);
        $I->assertNotEmpty($nom);
        $nom = ChaineCharactere::str_shuffle_unicode($nom);

        $prenom = $I->grabValueFrom($this->prenomField);
        $I->assertNotEmpty($prenom);
        $prenom = ChaineCharactere::str_shuffle_unicode($prenom);

        $tel_portable = $I->grabValueFrom($this->telPortableField);
        if (empty($tel_portable)) {
            $tel_portable = "1492765676";
        } else {
            $tel_portable = ChaineCharactere::str_shuffle_unicode($tel_portable);
        }

        $tel_fixe = $I->grabValueFrom($this->telFixeField);
        if (empty($tel_fixe)) {
            $tel_fixe = "1492765633";
        } else {
            $tel_fixe = ChaineCharactere::str_shuffle_unicode($tel_fixe);
        }

        // settings
        $nombre_elements_tableaux = $I->grabValueFrom($this->nombre_elements_tableauxSelect);
        $I->assertNotEmpty($nombre_elements_tableaux);
        $nombre_elements_tableaux = $this->get_different_nombre_elements_tableaux($nombre_elements_tableaux);
        $I->assertNotEmpty($nombre_elements_tableaux);

        // spécifique intervenant
        $statut = $I->grabValueFrom($this->statutSelect);
        $I->assertNotEmpty($statut);
        $statut = $this->get_different_statut_intervenant($statut);
        $I->assertNotEmpty($statut);

        $numero_carte = $I->grabValueFrom($this->numero_carteField);
        if (empty($numero_carte)) {
            $numero_carte = "ADF643";
        } else {
            $numero_carte = ChaineCharactere::str_shuffle_unicode($numero_carte);
        }

        $I->wantTo("Entrer dans le mode édition");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        $I->fillField($this->nomField, $nom);
        $I->fillField($this->prenomField, $prenom);
        $I->fillField($this->telFixeField, $tel_fixe);
        $I->fillField($this->telPortableField, $tel_portable);
        $I->selectOption($this->nombre_elements_tableauxSelect, $nombre_elements_tableaux);
        $I->selectOption($this->statutSelect, $statut);
        $I->fillField($this->numero_carteField, $numero_carte);

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur modifié avec succes", $this->toast);

        $I->wantTo("Ré-ouvrir le modal");
        $I->dontSeeElement($this->modal);
        $I->seeElement($this->monCompteButton);
        $I->waitForElementClickable($this->monCompteButton, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $nom_modified = $I->grabValueFrom($this->nomField);
        $prenom_modified = $I->grabValueFrom($this->prenomField);
        $tel_portable_modified = $I->grabValueFrom($this->telPortableField);
        $tel_fixe_modified = $I->grabValueFrom($this->telFixeField);
        $nombre_elements_tableaux_modified = $I->grabValueFrom($this->nombre_elements_tableauxSelect);
        $statut_modified = $I->grabValueFrom($this->statutSelect);
        $numero_carte_modified = $I->grabValueFrom($this->numero_carteField);

        $I->assertEquals($nom, $nom_modified);
        $I->assertEquals($prenom, $prenom_modified);
        $I->assertEquals($tel_portable, $tel_portable_modified);
        $I->assertEquals($tel_fixe, $tel_fixe_modified);
        $I->assertEquals($nombre_elements_tableaux, $nombre_elements_tableaux_modified);
        $I->assertEquals($statut, $statut_modified);
        $I->assertEquals($numero_carte, $numero_carte_modified);
    }

    public function monCompteEvaluateur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToSettingsButton);
        $I->waitPageLoad();
        $I->see("Administration");

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->monCompteButton);
        $I->dontSeeElement($this->modal);
        $I->click($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);
        $I->dontSee("Données superviseur PEPS");
        $I->dontSee("Données coordonnateur");
        $I->dontSee("Données professionnelles");
        $I->see("Mes choix interface");

        // coordonnées
        $nom = $I->grabValueFrom($this->nomField);
        $I->assertNotEmpty($nom);
        $nom = ChaineCharactere::str_shuffle_unicode($nom);

        $prenom = $I->grabValueFrom($this->prenomField);
        $I->assertNotEmpty($prenom);
        $prenom = ChaineCharactere::str_shuffle_unicode($prenom);

        $tel_portable = $I->grabValueFrom($this->telPortableField);
        if (empty($tel_portable)) {
            $tel_portable = "1492765676";
        } else {
            $tel_portable = ChaineCharactere::str_shuffle_unicode($tel_portable);
        }

        $tel_fixe = $I->grabValueFrom($this->telFixeField);
        if (empty($tel_fixe)) {
            $tel_fixe = "1492765633";
        } else {
            $tel_fixe = ChaineCharactere::str_shuffle_unicode($tel_fixe);
        }

        // settings
        $nombre_elements_tableaux = $I->grabValueFrom($this->nombre_elements_tableauxSelect);
        $I->assertNotEmpty($nombre_elements_tableaux);
        $nombre_elements_tableaux = $this->get_different_nombre_elements_tableaux($nombre_elements_tableaux);
        $I->assertNotEmpty($nombre_elements_tableaux);

        $I->wantTo("Entrer dans le mode édition");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        $I->fillField($this->nomField, $nom);
        $I->fillField($this->prenomField, $prenom);
        $I->fillField($this->telFixeField, $tel_fixe);
        $I->fillField($this->telPortableField, $tel_portable);
        $I->selectOption($this->nombre_elements_tableauxSelect, $nombre_elements_tableaux);

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur modifié avec succes", $this->toast);

        $I->wantTo("Ré-ouvrir le modal");
        $I->dontSeeElement($this->modal);
        $I->seeElement($this->monCompteButton);
        $I->waitForElementClickable($this->monCompteButton, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->monCompteButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $nom_modified = $I->grabValueFrom($this->nomField);
        $prenom_modified = $I->grabValueFrom($this->prenomField);
        $tel_portable_modified = $I->grabValueFrom($this->telPortableField);
        $tel_fixe_modified = $I->grabValueFrom($this->telFixeField);
        $nombre_elements_tableaux_modified = $I->grabValueFrom($this->nombre_elements_tableauxSelect);

        $I->assertEquals($nom, $nom_modified);
        $I->assertEquals($prenom, $prenom_modified);
        $I->assertEquals($tel_portable, $tel_portable_modified);
        $I->assertEquals($tel_fixe, $tel_fixe_modified);
        $I->assertEquals($nombre_elements_tableaux, $nombre_elements_tableaux_modified);
    }

    /**
     * @param $nb
     * @return string|null Une valeur de nombre_elements_tableaux valide et différente de $nb ou null
     */
    private function get_different_nombre_elements_tableaux($nb)
    {
        switch ($nb) {
            case "10":
                return "25";
            case "25":
                return "50";
            case "50":
                return "100";
            case "100":
                return "10";
            default:
                return null;
        }
    }

    /**
     * @param $id
     * @return string|null Un id de statut d'intervenant valide et différent de $id ou null
     */
    private function get_different_statut_intervenant($id)
    {
        switch ($id) {
            case "1":
                return "2";
            case "2":
                return "3";
            case "3":
                return "1";
            default:
                return null;
        }
    }
}