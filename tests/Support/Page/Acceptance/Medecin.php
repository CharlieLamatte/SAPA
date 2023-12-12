<?php

namespace Tests\Support\Page\Acceptance;

use Tests\Support\AcceptanceTester;
use Sportsante86\Sapa\Outils\ChaineCharactere;

class Medecin
{
    // include url of current page
    public static $URL = '/PHP/Medecins/ListeMedecin.php';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    private $enregistrerModifierButton = ["id" => "enregistrer-modifier"];
    private $closeButton = ["id" => "close"];
    private $form = ["id" => "form-medecin"];

    private $searchField = ["css" => "#table_id_filter > label:nth-child(1) > input:nth-child(1)"];
    private $nameFirstRow = ['css' => 'tr.odd:nth-child(1) > td:nth-child(1)'];

    private $openButton = ["id" => "ajout-modal"];
    private $modal = ["id" => "modal"];
    private $toast = ["id" => "toast"];

    // Coordonnées
    private $id_territoireSelect = ["id" => "id_territoire"];
    private $id_territoireSelectedOption = ["css" => "#id_territoire option:checked"];
    private $nomField = ["id" => "nom"];
    private $prenomField = ["id" => "prenom"];
    private $telPortableField = ["id" => "tel-portable"];
    private $telFixeField = ["id" => "tel-fixe"];
    private $emailField = ["id" => "email"];
    private $adresseField = ["id" => "adresse"];
    private $complementAdresseField = ["id" => "complement-adresse"];
    private $codePostalField = ["id" => "code-postal"];
    private $firstCodePostal = ["css" => "#code-postalautocomplete-list > div:nth-child(1) > input:nth-child(1)"];
    private $villeField = ["id" => "ville"];

    // Données professionnelles
    private $posteField = ["id" => "poste"];
    private $id_specialite_medecinSelect = ["id" => "specialite"];
    private $id_specialite_medecinSelectedOption = ["css" => "#specialite option:checked"];
    private $id_lieu_pratiqueSelect = ["id" => "lieu"];
    private $id_lieu_pratiqueSelectedOption = ["css" => "#lieu option:checked"];

    protected AcceptanceTester $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    /**
     * required parameters :
     * [
     *     // obligatoire
     *     'nom_coordonnees' => string,
     *     'prenom_coordonnees' => string,
     *     'poste_medecin' => string,
     *     'id_specialite_medecin' => string,
     *     'id_lieu_pratique' => string,
     *     'nom_adresse' => string,
     *     'code_postal' => string,
     *     'id_territoire' => string,
     *     'tel_fixe_coordonnees' => string,
     *
     *     // optionnel
     *     'complement_adresse' => string,
     *     'mail_coordonnees' => string,
     *     'tel_portable_coordonnees' => string,
     * ]
     *
     * @param $paramaters
     * @return void
     */
    public function create($paramaters)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::$URL);

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->openButton);
        $I->dontSeeElement($this->modal);
        $I->click($this->openButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Remplir les champs");
        // obligatoire
        $I->fillField($this->nomField, $paramaters['nom_coordonnees']);
        $I->fillField($this->prenomField, $paramaters['prenom_coordonnees']);
        $I->fillField($this->adresseField, $paramaters['nom_adresse']);
        $I->fillField($this->telFixeField, $paramaters['tel_fixe_coordonnees']);
        $I->fillField($this->posteField, $paramaters['poste_medecin']);
        $I->fillField($this->codePostalField, $paramaters['code_postal']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->firstCodePostal, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->firstCodePostal);

        $I->selectOption($this->id_specialite_medecinSelect, $paramaters['id_specialite_medecin']);
        $specialite_text = $I->grabTextFrom($this->id_specialite_medecinSelectedOption);
        $I->assertNotEmpty($specialite_text);

        $I->selectOption($this->id_lieu_pratiqueSelect, $paramaters['id_lieu_pratique']);
        $lieu_pratique_text = $I->grabTextFrom($this->id_lieu_pratiqueSelectedOption);
        $I->assertNotEmpty($lieu_pratique_text);

        $I->selectOption($this->id_territoireSelect, $paramaters['id_territoire']);
        $territoire_text = $I->grabTextFrom($this->id_territoireSelectedOption);
        $I->assertNotEmpty($territoire_text);

        // optionnel
        if (isset($paramaters['complement_adresse'])) {
            $I->fillField($this->complementAdresseField, $paramaters['complement_adresse']);
        }
        if (isset($paramaters['mail_coordonnees'])) {
            $I->fillField($this->emailField, $paramaters['mail_coordonnees']);
        }
        if (isset($paramaters['tel_portable_coordonnees'])) {
            $I->fillField($this->telPortableField, $paramaters['tel_portable_coordonnees']);
        }

        $I->wantTo("Enregistrer le nouveau médecin");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Médecin ajouté avec succes", $this->toast);

        $I->wantTo("Ouvrir les détails du nouveau médecin");
        $I->fillField($this->searchField, $paramaters['nom_coordonnees']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->nameFirstRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirstRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $I->assertEquals(mb_strtoupper($paramaters['nom_coordonnees'], 'UTF-8'), $I->grabValueFrom($this->nomField));
        $I->assertEquals(ChaineCharactere::mb_ucfirst($paramaters['prenom_coordonnees']), $I->grabValueFrom($this->prenomField));
        $I->assertEquals(ChaineCharactere::mb_ucfirst($paramaters['poste_medecin']), $I->grabValueFrom($this->posteField));
        $I->assertEquals($paramaters['id_specialite_medecin'], $I->grabValueFrom($this->id_specialite_medecinSelect));
        $I->assertEquals($paramaters['id_lieu_pratique'], $I->grabValueFrom($this->id_lieu_pratiqueSelect));
        $I->assertEquals(ChaineCharactere::mb_ucfirst($paramaters['nom_adresse']), $I->grabValueFrom($this->adresseField));
        $I->assertEquals($paramaters['code_postal'], $I->grabValueFrom($this->codePostalField));

        // optionnel
        if (isset($paramaters['complement_adresse'])) {
            $I->assertEquals(
                ChaineCharactere::mb_ucfirst($paramaters['complement_adresse']),
                $I->grabValueFrom($this->complementAdresseField)
            );
        }
        if (isset($paramaters['mail_coordonnees'])) {
            $I->assertEquals($paramaters['mail_coordonnees'], $I->grabValueFrom($this->emailField));
        }
        if (isset($paramaters['tel_portable_coordonnees'])) {
            $I->assertEquals($paramaters['tel_portable_coordonnees'], $I->grabValueFrom($this->telPortableField));
        }

        $I->wantTo("Fermer le modal");
        $I->seeElement($this->closeButton);
        $I->retry(4, 1000);
        $I->retryClick($this->closeButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
    }

    /**
     * required parameters :
     * [
     *     // obligatoire
     *     'nom_coordonnees' => string,
     *     'prenom_coordonnees' => string,
     *     'poste_medecin' => string,
     *     'id_specialite_medecin' => string,
     *     'id_lieu_pratique' => string,
     *     'nom_adresse' => string,
     *     'code_postal' => string,
     *     'id_territoire' => string,
     *     'tel_fixe_coordonnees' => string,
     *
     *     // optionnel
     *     'complement_adresse' => string,
     *     'mail_coordonnees' => string,
     *     'tel_portable_coordonnees' => string,
     * ]
     *
     * @param $paramaters
     * @return void
     */
    public function modify($paramaters)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::$URL);

        $I->wantTo("Ouvrir le modal du premier élément du tableau");
        $I->waitPageLoad();
        $I->waitForElementClickable($this->nameFirstRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirstRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Entrer dans le mode édition");
        $I->retry(4, 1000);
        $I->retryClick($this->enregistrerModifierButton);
        $I->waitPageLoad();

        $I->wantTo("Remplir les champs");
        // obligatoire
        $I->fillField($this->nomField, $paramaters['nom_coordonnees']);
        $I->fillField($this->prenomField, $paramaters['prenom_coordonnees']);
        $I->fillField($this->adresseField, $paramaters['nom_adresse']);
        $I->fillField($this->telFixeField, $paramaters['tel_fixe_coordonnees']);
        $I->fillField($this->posteField, $paramaters['poste_medecin']);
        $I->fillField($this->codePostalField, $paramaters['code_postal']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->firstCodePostal, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->firstCodePostal);

        $I->selectOption($this->id_specialite_medecinSelect, $paramaters['id_specialite_medecin']);
        $specialite_text = $I->grabTextFrom($this->id_specialite_medecinSelectedOption);
        $I->assertNotEmpty($specialite_text);

        $I->selectOption($this->id_lieu_pratiqueSelect, $paramaters['id_lieu_pratique']);
        $lieu_pratique_text = $I->grabTextFrom($this->id_lieu_pratiqueSelectedOption);
        $I->assertNotEmpty($lieu_pratique_text);

        $I->selectOption($this->id_territoireSelect, $paramaters['id_territoire']);
        $territoire_text = $I->grabTextFrom($this->id_territoireSelectedOption);
        $I->assertNotEmpty($territoire_text);

        // optionnel
        if (isset($paramaters['complement_adresse'])) {
            $I->fillField($this->complementAdresseField, $paramaters['complement_adresse']);
        }
        if (isset($paramaters['mail_coordonnees'])) {
            $I->fillField($this->emailField, $paramaters['mail_coordonnees']);
        }
        if (isset($paramaters['tel_portable_coordonnees'])) {
            $I->fillField($this->telPortableField, $paramaters['tel_portable_coordonnees']);
        }

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Médecin modifié avec succes", $this->toast);

        $I->wantTo("Ouvrir les détails du médecin");
        $I->fillField($this->searchField, $paramaters['nom_coordonnees']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->nameFirstRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirstRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $I->assertEquals(mb_strtoupper($paramaters['nom_coordonnees'], 'UTF-8'), $I->grabValueFrom($this->nomField));
        $I->assertEquals(ChaineCharactere::mb_ucfirst($paramaters['prenom_coordonnees']), $I->grabValueFrom($this->prenomField));
        $I->assertEquals(ChaineCharactere::mb_ucfirst($paramaters['poste_medecin']), $I->grabValueFrom($this->posteField));
        $I->assertEquals($paramaters['id_specialite_medecin'], $I->grabValueFrom($this->id_specialite_medecinSelect));
        $I->assertEquals($paramaters['id_lieu_pratique'], $I->grabValueFrom($this->id_lieu_pratiqueSelect));
        $I->assertEquals(ChaineCharactere::mb_ucfirst($paramaters['nom_adresse']), $I->grabValueFrom($this->adresseField));
        $I->assertEquals($paramaters['code_postal'], $I->grabValueFrom($this->codePostalField));

        // optionnel
        if (isset($paramaters['complement_adresse'])) {
            $I->assertEquals(
                ChaineCharactere::mb_ucfirst($paramaters['complement_adresse']),
                $I->grabValueFrom($this->complementAdresseField)
            );
        }
        if (isset($paramaters['mail_coordonnees'])) {
            $I->assertEquals($paramaters['mail_coordonnees'], $I->grabValueFrom($this->emailField));
        }
        if (isset($paramaters['tel_portable_coordonnees'])) {
            $I->assertEquals($paramaters['tel_portable_coordonnees'], $I->grabValueFrom($this->telPortableField));
        }

        $I->wantTo("Fermer le modal");
        $I->seeElement($this->closeButton);
        $I->retry(4, 1000);
        $I->retryClick($this->closeButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
    }
}