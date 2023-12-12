<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\Page\Acceptance\Login;

class ModifyUserCest
{
    private $goToSettingsButton = ["id" => "administration-link"];
    private $goToUserPageButton = ["id" => "boutonAutre"];

    private $searchField = ["css" => "#table_id_filter > label:nth-child(1) > input:nth-child(1)"];
    private $modal = ["id" => "modal-user"];
    private $toast = ["id" => "toast"];

    private $nameFirtRow = ['xpath' => '/html/body/div[3]/div[3]/div[3]/div/div[3]/div[2]/table/tbody/tr[1]/td[3]'];

    // elements du formulaire

    private $enregistrerModifierButton = ["id" => "enregistrer-modifier-user"];
    private $closeButton = ["id" => "close-user"];
    private $form = ["id" => "form-user"];

    // coordonnées
    private $nomField = ["id" => "nom-user"];
    private $prenomField = ["id" => "prenom-user"];
    private $telPortableField = ["id" => "tel-portable-user"];
    private $telFixeField = ["id" => "tel-fixe-user"];
    private $id_territoireSelect = ["id" => "id_territoire-user"];
    private $id_territoireSelectedOPtion = ["css" => "#id_territoire-user option:checked"];

    public function _before(AcceptanceTester $I)
    {
    }

    public function modifyUserCoordonnateurAsAdmin(AcceptanceTester $I, Login $loginPage) {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToSettingsButton);
        $I->waitPageLoad();
        $I->see("Administration");

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToUserPageButton);
        $I->waitPageLoad();
        $I->see("Utilisateurs");

        $I->wantTo("Ouvrir les détails d'un coordonnateur");
        $I->fillField($this->searchField, 'coordinateur');
        $I->waitPageLoad();
        $I->waitForElementClickable($this->nameFirtRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirtRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);
        $I->dontSee("Données superviseur PEPS");
        $I->see("Données coordonnateur");
        $I->dontSee("Données professionnelles");
        $I->dontSee("Mes choix interface");

        $id_user = $I->grabAttributeFrom($this->form, 'data-id_user');
        $I->assertNotEmpty($id_user);

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

        $id_territoire = $I->grabValueFrom($this->id_territoireSelect);
        $I->assertNotEmpty($id_territoire);
        $id_territoire = $this->get_different_id_territoire($id_territoire);
        $I->assertNotEmpty($id_territoire);

        $I->wantTo("Entrer dans le mode édition");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        $I->fillField($this->nomField, $nom);
        $I->fillField($this->prenomField, $prenom);
        $I->fillField($this->telFixeField, $tel_fixe);
        $I->fillField($this->telPortableField, $tel_portable);
        $I->selectOption($this->id_territoireSelect, $id_territoire);
        $territoire_text = $I->grabTextFrom($this->id_territoireSelectedOPtion);
        $I->assertNotEmpty($territoire_text);

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur modifié avec succes", $this->toast);

        $I->wantTo("Ré-ouvrir le modal");
        $I->dontSeeElement($this->modal);
        $I->seeElement($this->nameFirtRow);
        $I->waitForElementClickable($this->nameFirtRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirtRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $nom_modified = $I->grabValueFrom($this->nomField);
        $prenom_modified = $I->grabValueFrom($this->prenomField);
        $tel_portable_modified = $I->grabValueFrom($this->telPortableField);
        $tel_fixe_modified = $I->grabValueFrom($this->telFixeField);
        $id_territoire_modified = $I->grabValueFrom($this->id_territoireSelect);

        $I->assertEquals($nom, $nom_modified);
        $I->assertEquals($prenom, $prenom_modified);
        $I->assertEquals($tel_portable, $tel_portable_modified);
        $I->assertEquals($tel_fixe, $tel_fixe_modified);
        $I->assertEquals($id_territoire, $id_territoire_modified);

        $I->wantTo("Fermer le modal");
        $I->seeElement($this->closeButton);
        $I->retry(4, 1000);
        $I->retryClick($this->closeButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont mis à jour le tableau");
        $I->assertEquals($nom, $I->grabTextFrom(['id' => 'td2-'.$id_user]));
        $I->assertEquals($prenom, $I->grabTextFrom(['id' => 'td3-'.$id_user]));
        $I->assertEquals($tel_portable, $I->grabTextFrom(['id' => 'td4-'.$id_user]));
        $I->assertEquals($tel_fixe, $I->grabTextFrom(['id' => 'td5-'.$id_user]));
        $I->assertEquals($territoire_text, $I->grabTextFrom(['id' => 'td0-'.$id_user]));
    }

    public function modifyUserCoordonnateurAsCoordonnateur(AcceptanceTester $I, Login $loginPage) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToSettingsButton);
        $I->waitPageLoad();
        $I->see("Administration");

        $I->wantTo("Aller sur la page administration");
        $I->click($this->goToUserPageButton);
        $I->waitPageLoad();
        $I->see("Utilisateurs");

        $I->wantTo("Ouvrir les détails d'un coordonnateur");
        $I->fillField($this->searchField, 'coordinateur');
        $I->waitPageLoad();
        $I->waitForElementClickable($this->nameFirtRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirtRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);
        $I->dontSee("Données superviseur PEPS");
        $I->see("Données coordonnateur");
        $I->dontSee("Données professionnelles");
        $I->dontSee("Mes choix interface");

        $id_user = $I->grabAttributeFrom($this->form, 'data-id_user');
        $I->assertNotEmpty($id_user);

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

        $id_territoire = $I->grabValueFrom($this->id_territoireSelect);
        $I->assertNotEmpty($id_territoire);
        $id_territoire = $this->get_different_id_territoire($id_territoire);
        $I->assertNotEmpty($id_territoire);

        $I->wantTo("Entrer dans le mode édition");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        $I->fillField($this->nomField, $nom);
        $I->fillField($this->prenomField, $prenom);
        $I->fillField($this->telFixeField, $tel_fixe);
        $I->fillField($this->telPortableField, $tel_portable);

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur modifié avec succes", $this->toast);

        $I->wantTo("Ré-ouvrir le modal");
        $I->dontSeeElement($this->modal);
        $I->seeElement($this->nameFirtRow);
        $I->waitForElementClickable($this->nameFirtRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirtRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $nom_modified = $I->grabValueFrom($this->nomField);
        $prenom_modified = $I->grabValueFrom($this->prenomField);
        $tel_portable_modified = $I->grabValueFrom($this->telPortableField);
        $tel_fixe_modified = $I->grabValueFrom($this->telFixeField);

        $I->assertEquals($nom, $nom_modified);
        $I->assertEquals($prenom, $prenom_modified);
        $I->assertEquals($tel_portable, $tel_portable_modified);
        $I->assertEquals($tel_fixe, $tel_fixe_modified);

        $I->wantTo("Fermer le modal");
        $I->seeElement($this->closeButton);
        $I->retry(4, 1000);
        $I->retryClick($this->closeButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont mis à jour le tableau");
        $I->assertEquals($nom, $I->grabTextFrom(['id' => 'td2-'.$id_user]));
        $I->assertEquals($prenom, $I->grabTextFrom(['id' => 'td3-'.$id_user]));
        $I->assertEquals($tel_portable, $I->grabTextFrom(['id' => 'td4-'.$id_user]));
        $I->assertEquals($tel_fixe, $I->grabTextFrom(['id' => 'td5-'.$id_user]));
    }

    /**
     * @param $id
     * @return string|null Un id_territoire valide et différent de $id ou null
     */
    private function get_different_id_territoire($id)
    {
        switch ($id) {
            case "1":
                return "2";
            case "2":
                return "3";
            case "3":
                return "4";
            case "4":
                return "5";
            case "5":
                return "6";
            case "6":
                return "7";
            case "7":
                return "8";
            case "8":
                return "9";
            case "9":
                return "10";
            case "10":
                return "11";
            case "11":
                return "12";
            case "12":
                return "13";
            case "13":
                return "1";
            default:
                return null;
        }
    }
}