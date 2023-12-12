<?php

namespace Tests\Support\Page\Acceptance;

use Tests\Support\AcceptanceTester;
use Sportsante86\Sapa\Outils\ChaineCharactere;

class Structure
{
    // include url of current page
    public static $URL = '/PHP/Structures/ListeStructure.php';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    private $enregistrerModifierButton = ["id" => "enregistrer-modifier-structure"];
    private $closeButton = ["id" => "close-structure"];
    private $form = ["id" => "form-structure"];

    private $searchField = ["css" => "#table_id_filter > label:nth-child(1) > input:nth-child(1)"];
    private $nameFirstRow = ['css' => 'tr.odd:nth-child(1) > td:nth-child(1)'];

    private $openButton = ["id" => "ajout-modal-structure"];
    private $modal = ["id" => "modalStructure"];
    private $toast = ["id" => "toast"];


    // Coordonnées
    private $codeOnapsField = ["id" => "code-onaps"];
    private $id_territoireSelect = ["id" => "id_territoire-structure"];
    private $id_territoireSelectedOPtion = ["css" => "#id_territoire-structure option:checked"];
    private $nomField = ["id" => "nom-structure"];
    private $statutSelect = ["id" => "statuts_structure"];
    private $statutSelectedOption = ["css" => "#statuts_structure option:checked"];
    private $adresseField = ["id" => "adresse-structure"];
    private $complementAdresseField = ["id" => "complement-adresse-structure"];
    private $codePostalField = ["id" => "code-postal-structure"];
    private $firstCodePostal = ["css" => "#code-postal-structureautocomplete-list > div:nth-child(1) > input:nth-child(1)"];
    private $villeField = ["id" => "ville-structure"];

    // Représentant légal
    private $representantNomField = ["id" => "representant-nom"];
    private $representantPrenomField = ["id" => "representant-prenom"];
    private $telFixeField = ["id" => "tel-fixe"];
    private $telPortableField = ["id" => "tel-portable"];
    private $emailField = ["id" => "email"];

    // Informations complémentaires
    private $statutJuridiqueSelect = ["id" => "statut-juridique"];
    private $statutJuridiqueSelectedOption = ["css" => "#statut-juridique option:checked"];

    // Antennes
    private $addAntenneField = ["id" => "add-antenne"];
    private $addAntenneButton = ["id" => "add-antenne-button"];

    // Intervenants de la structure
    private $addIntervenantField = ["id" => "add-intervenant"];
    private $firstIntervenant = ["css" => "#add-intervenantautocomplete-list > div:nth-child(1) > input:nth-child(1)"];

    // Lien de référencement de la structure
    private $lien_referencementField = ["id" => "lien_referencement"];

    protected AcceptanceTester $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    /**
     * required parameters :
     * [
     *     // obligatoire
     *     'nom' => string,
     *     'prenom' => string,
     *     'email' => string,
     *     'mdp' => string,
     *     'id_territoire' => string,
     *     'id_role_user' => string,
     *
     *     // optionnel
     *     'tel_fixe' => string,
     *     'tel_portable' => string,
     * ]
     *
     * @param $paramaters
     * @return void
     */
    public function create($paramaters)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::$URL);

        $I->wantTo("Récupérer données de l'utilisateur connecté");
        $id_territoire_connected = $I->grabFromDatabase(
            'users',
            'id_territoire',
            ['identifiant like' => $paramaters['email_connected']]
        );
        $I->assertNotEmpty($id_territoire_connected);
        $id_user_connected = $I->grabFromDatabase(
            'users',
            'id_user',
            ['identifiant like' => $paramaters['email_connected']]
        );
        $I->assertNotEmpty($id_user_connected);
        $role_user_ids_connected = $I->grabColumnFromDatabase(
            'a_role',
            'id_role_user',
            ['id_user' => $id_user_connected]
        );
        $I->assertNotEmpty($role_user_ids_connected);

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->openButton);
        $I->dontSeeElement($this->modal);
        $I->click($this->openButton);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        // si pas admin
        if (!in_array("1", $role_user_ids_connected)) {
            $I->wantTo("Vérifier que certains élément sont disabled");
            $attribute1 = $I->grabAttributeFrom($this->id_territoireSelect, 'disabled');
            $I->assertNotNull($attribute1);
        }

        $I->wantTo("Remplir les champs");
        // obligatoire
        $I->fillField($this->nomField, $paramaters['nom_structure']);
        $I->fillField($this->adresseField, $paramaters['nom_adresse']);
        $I->fillField($this->codePostalField, $paramaters['code_postal']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->firstCodePostal, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->firstCodePostal);
        $I->selectOption($this->id_territoireSelect, $paramaters['id_territoire']);
        $territoire_text = $I->grabTextFrom($this->id_territoireSelectedOPtion);
        $I->assertNotEmpty($territoire_text);
        $I->selectOption($this->statutSelect, $paramaters['id_statut_structure']);
        $statut_structure_text = $I->grabTextFrom($this->statutSelectedOption);
        $I->assertNotEmpty($statut_structure_text);
        $I->selectOption($this->statutJuridiqueSelect, $paramaters['id_statut_juridique']);
        $role_user_text = $I->grabTextFrom($this->statutJuridiqueSelectedOption);
        $I->assertNotEmpty($role_user_text);
        $I->waitPageLoad();

        // optionnel
        if (isset($paramaters['complement_adresse'])) {
            $I->fillField($this->complementAdresseField, $paramaters['complement_adresse']);
        }
        if (isset($paramaters['lien_ref_structure'])) {
            $I->fillField($this->lien_referencementField, $paramaters['lien_ref_structure']);
        }
        if (isset($paramaters['code_onaps'])) {
            $I->fillField($this->codeOnapsField, $paramaters['code_onaps']);
        }
        if (isset($paramaters['nom_representant'])) {
            $I->fillField($this->representantNomField, $paramaters['nom_representant']);
        }
        if (isset($paramaters['prenom_representant'])) {
            $I->fillField($this->representantPrenomField, $paramaters['prenom_representant']);
        }
        if (isset($paramaters['email'])) {
            $I->fillField($this->emailField, $paramaters['email']);
        }
        if (isset($paramaters['tel_fixe'])) {
            $I->fillField($this->telFixeField, $paramaters['tel_fixe']);
        }
        if (isset($paramaters['tel_portable'])) {
            $I->fillField($this->telPortableField, $paramaters['tel_portable']);
        }
        if (isset($paramaters['antennes'])) {
            foreach ($paramaters['antennes'] as $nom_antenne) {
                $I->fillField($this->addAntenneField, $nom_antenne);
                $I->click($this->addAntenneButton);
                $I->waitPageLoad();
            }
        }
        if (isset($paramaters['intervenants'])) {
            foreach ($paramaters['intervenants'] as $nom_intervenant) {
                $I->wantTo("Choisir les intervenants");
                $I->fillField($this->addIntervenantField, $nom_intervenant);
                $I->waitPageLoad();
                $I->waitForElementClickable($this->firstIntervenant, 30);
                $I->retry(4, 1000);
                $I->retryClick($this->firstIntervenant);
            }
        }

        $I->wantTo("Enregistrer la nouvelle structure");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Structure ajoutée avec succes", $this->toast);

        $I->wantTo("Ouvrir les détails de la nouvelle structure");
        $I->fillField($this->searchField, $paramaters['nom_structure']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->nameFirstRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirstRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $I->assertEquals(mb_strtoupper($paramaters['nom_structure'], 'UTF-8'), $I->grabValueFrom($this->nomField));
        $I->assertEquals($paramaters['id_statut_structure'], $I->grabValueFrom($this->statutSelect));
        $I->assertEquals(
            ChaineCharactere::mb_ucfirst($paramaters['nom_adresse']),
            $I->grabValueFrom($this->adresseField)
        );
        $I->assertEquals($paramaters['code_postal'], $I->grabValueFrom($this->codePostalField));
        $I->assertEquals($paramaters['id_statut_juridique'], $I->grabValueFrom($this->statutJuridiqueSelect));


        if (in_array("1", $role_user_ids_connected)) {
            // si admin
            $I->assertEquals($paramaters['id_territoire'], $I->grabValueFrom($this->id_territoireSelect));
        } else {
            // si pas admin
            $I->assertEquals($id_territoire_connected, $I->grabValueFrom($this->id_territoireSelect));
        }

        if (isset($paramaters['complement_adresse'])) {
            $I->assertEquals($paramaters['complement_adresse'], $I->grabValueFrom($this->complementAdresseField));
        }
        if (isset($paramaters['lien_ref_structure'])) {
            $I->assertEquals($paramaters['lien_ref_structure'], $I->grabValueFrom($this->lien_referencementField));
        }
        if (isset($paramaters['code_onaps'])) {
            $I->assertEquals($paramaters['code_onaps'], $I->grabValueFrom($this->codeOnapsField));
        }
        if (isset($paramaters['nom_representant'])) {
            $I->assertEquals($paramaters['nom_representant'], $I->grabValueFrom($this->representantNomField));
        }
        if (isset($paramaters['prenom_representant'])) {
            $I->assertEquals($paramaters['prenom_representant'], $I->grabValueFrom($this->representantPrenomField));
        }
        if (isset($paramaters['email'])) {
            $I->assertEquals($paramaters['email'], $I->grabValueFrom($this->emailField));
        }
        if (isset($paramaters['tel_fixe'])) {
            $I->assertEquals($paramaters['tel_fixe'], $I->grabValueFrom($this->telFixeField));
        }
        if (isset($paramaters['tel_portable'])) {
            $I->assertEquals($paramaters['tel_portable'], $I->grabValueFrom($this->telPortableField));
        }
        if (isset($paramaters['antennes'])) {
            $ids = $I->grabMultiple(['css' => '.antenne-element-input'], 'value');
            $I->assertEqualsCanonicalizing($ids, $paramaters['antennes']);
        }
        if (isset($paramaters['intervenants'])) {
            $ids = $I->grabMultiple(['css' => '.intervenant-element-input'], 'value');
            $I->assertEqualsCanonicalizing($ids, $paramaters['intervenants']);
        }

        $I->wantTo("Fermer le modal");
        $I->seeElement($this->closeButton);
        $I->retry(4, 1000);
        $I->retryClick($this->closeButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
    }
}