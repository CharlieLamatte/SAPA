<?php

namespace Tests\Support\Page\Acceptance;

use Tests\Support\AcceptanceTester;

class User
{
    // include url of current page
    public static $URL = '/PHP/Users/ListeUser.php';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    private $enregistrerModifierButton = ["id" => "enregistrer-modifier-user"];
    private $closeButton = ["id" => "close-user"];
    private $form = ["id" => "form-user"];

    private $searchField = ["css" => "#table_id_filter > label:nth-child(1) > input:nth-child(1)"];
    private $nameFirtRow = ['xpath' => '/html/body/div[3]/div[3]/div[3]/div/div[3]/div[2]/table/tbody/tr[1]/td[3]'];

    private $openButton = ["id" => "ajout-modal"];
    private $modal = ["id" => "modal-user"];
    private $toast = ["id" => "toast"];

    private $nomField = ["id" => "nom-user"];
    private $prenomField = ["id" => "prenom-user"];
    private $telPortableField = ["id" => "tel-portable-user"];
    private $telFixeField = ["id" => "tel-fixe-user"];
    private $emailField = ["id" => "email-user"];

    private $mdpField = ["id" => "mdp"];
    private $confirmMdpField = ["id" => "confirm-mdp"];

    private $id_territoireSelect = ["id" => "id_territoire-user"];
    private $id_territoireSelectedOPtion = ["css" => "#id_territoire-user option:checked"];

    private $role_userMutiselectButton = ["css" => ".multiselect"];

    private $nomStructureField = ["id" => "nom-structure-user"];
    private $firstStructure = ["css" => "#nom-structure-userautocomplete-list > div:nth-child(1) > input:nth-child(1)"];

    // coordinateur
    private $est_coordinateur_pepsCheckbox = ["id" => "est_coordinateur_peps"];

    // intervenant
    private $statutSelect = ["id" => "statut-user"];
    private $statutSelectedOption = ["css" => "#statut-user option:checked"];
    private $numero_carteField = ["id" => "numero_carte-user"];
    private $diplomeSelect = ["id" => "diplome-user"];
    private $diplomeSelectedOption = ["css" => "#diplome-user option:checked"];
    private $addDiplomeButton = ["id" => "add-diplome-user"];
    private $diplomeDiv = ["id" => "liste-diplome-user"]; // div qui contient les diplôme

    // superviseur peps
    private $fonctionField = ["id" => "nom-fonction"];

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
     *     // obligatoire sauf admin
     *     'structure' => string
     *
     *     // obligatoire si coordinateur
     *     'est_coordonnateur_peps' => bool
     *
     *     // obligatoire si intervenant
     *     'id_statut_intervenant' => string
     *     'numero_carte' => string
     *     'diplomes' => array
     *
     *     // obligatoire si superviseur PEPS
     *     'fonction' => string
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

        $I->wantTo("Remplir les champs");
        // obligatoire
        $I->fillField($this->nomField, $paramaters['nom']);
        $I->fillField($this->prenomField, $paramaters['prenom']);
        $I->fillField($this->emailField, $paramaters['email']);
        $I->fillField($this->mdpField, $paramaters['mdp']);
        $I->fillField($this->confirmMdpField, $paramaters['mdp']);
        $I->selectOption($this->id_territoireSelect, $paramaters['id_territoire']);
        $territoire_text = $I->grabTextFrom($this->id_territoireSelectedOPtion);
        $I->assertNotEmpty($territoire_text);

        $I->wantTo("Choisir les rôles");
        $I->click($this->role_userMutiselectButton);
        $role_user_texts = [];
        foreach ($paramaters['role_user_ids'] as $id_role_user) {
            $I->click(['css' => '.multiselect-container button span input[value="' . $id_role_user . '"]']);
            $role_user_texts[] = $this->roleFromId($id_role_user);
        }
        $I->assertNotEmpty($role_user_texts);
        $I->waitPageLoad();

        // si pas admin
        if (!in_array("1", $paramaters['role_user_ids'])) {
            $I->wantTo("Choisir la structure");
            $I->fillField($this->nomStructureField, $paramaters['structure']);
            $I->waitPageLoad();
            $I->waitForElementClickable($this->firstStructure, 30);
            $I->retry(4, 1000);
            $I->retryClick($this->firstStructure);
        }
        // optionnel
        if (isset($paramaters['tel_fixe'])) {
            $I->fillField($this->telFixeField, $paramaters['tel_fixe']);
        }
        if (isset($paramaters['tel_portable'])) {
            $I->fillField($this->telPortableField, $paramaters['tel_portable']);
        }
        // si coordonnateur
        if (in_array("2", $paramaters['role_user_ids']) && $paramaters['est_coordonnateur_peps']) {
            $I->wantTo("Ajouter les paramètres du coordonnateur");
            $I->checkOption($this->est_coordinateur_pepsCheckbox);
        }
        // si intervenant
        if (in_array("3", $paramaters['role_user_ids'])) {
            $I->wantTo("Ajouter les paramètres de l'intervenant");
            $I->selectOption($this->statutSelect, $paramaters['id_statut_intervenant']);
            $statut_text = $I->grabTextFrom($this->statutSelectedOption);
            $I->assertNotEmpty($statut_text);

            if (isset($paramaters['diplomes'])) {
                foreach ($paramaters['diplomes'] as $id_diplome) {
                    $I->selectOption($this->diplomeSelect, $id_diplome);
                    $I->click($this->addDiplomeButton);
                    $I->waitPageLoad();
                }
            }

            if (isset($paramaters['numero_carte'])) {
                $I->fillField($this->numero_carteField, $paramaters['numero_carte']);
            }
        }
        // si superviseur Peps
        if (in_array("7", $paramaters['role_user_ids'])) {
            $I->wantTo("Ajouter les paramètres du superviseur Peps");
            $I->fillField($this->fonctionField, $paramaters['fonction']);
        }

        $I->wantTo("Enregistrer le nouvel utilisateur");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Utilisateur ajouté avec succes", $this->toast);

        $I->wantTo("Ouvrir les détails du nouvel utilisateur");
        $I->fillField($this->searchField, $paramaters['nom']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->nameFirtRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirtRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $I->assertEquals(mb_strtoupper($paramaters['nom'], 'UTF-8'), $I->grabValueFrom($this->nomField));
        $I->assertEquals($paramaters['prenom'], $I->grabValueFrom($this->prenomField));
        $I->assertEquals($paramaters['email'], $I->grabValueFrom($this->emailField));
        foreach ($role_user_texts as $role) {
            $I->see($role, ['css' => '.multiselect-selected-text']);
        }

        // si pas admin
        if (!in_array('1', $paramaters['role_user_ids'])) {
            $I->assertEquals($paramaters['structure'], $I->grabValueFrom($this->nomStructureField));
        }
        // optionnel
        if (isset($paramaters['tel_portable'])) {
            $I->assertEquals($paramaters['tel_portable'], $I->grabValueFrom($this->telPortableField));
        } else {
            $I->assertEquals('', $I->grabValueFrom($this->telPortableField));
        }
        if (isset($paramaters['tel_fixe'])) {
            $I->assertEquals($paramaters['tel_fixe'], $I->grabValueFrom($this->telFixeField));
        } else {
            $I->assertEquals('', $I->grabValueFrom($this->telFixeField));
        }
        // si coordonnateur
        if (in_array('2', $paramaters['role_user_ids'])) {
            $I->wantTo("Vérifier les paramètres du coordonnateur");
            if ($paramaters['est_coordonnateur_peps']) {
                $I->seeCheckboxIsChecked($this->est_coordinateur_pepsCheckbox);
            } else {
                $I->dontSeeCheckboxIsChecked($this->est_coordinateur_pepsCheckbox);
            }
        }
        // si intervenant
        if (in_array('3', $paramaters['role_user_ids'])) {
            $I->wantTo("Vérifier les paramètres de l'intervenant");
            $I->assertEquals($paramaters['id_statut_intervenant'], $I->grabValueFrom($this->statutSelect));

            if (isset($paramaters['diplomes'])) {
                $ids = $I->grabMultiple(['css' => '.diplome-element'], 'data-id-diplome');
                $I->assertEqualsCanonicalizing($ids, $paramaters['diplomes']);
            }

            if (isset($paramaters['numero_carte'])) {
                $I->assertEquals($paramaters['numero_carte'], $I->grabValueFrom($this->numero_carteField));
            }
        }
        // si superviseur Peps
        if (in_array('7', $paramaters['role_user_ids'])) {
            $I->wantTo("Vérifier les paramètres du superviseur Peps");
            $I->assertEquals($paramaters['fonction'], $I->grabValueFrom($this->fonctionField));
        }
        // si user connecté est admin
        if (in_array('1', $role_user_ids_connected)) {
            $I->assertEquals($paramaters['id_territoire'], $I->grabValueFrom($this->id_territoireSelect));
        } else {
            $I->assertEquals($id_territoire_connected, $I->grabValueFrom($this->id_territoireSelect));
        }

        $I->wantTo("Fermer le modal");
        $I->seeElement($this->closeButton);
        $I->retry(4, 1000);
        $I->retryClick($this->closeButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
    }

    private function roleFromId($id): ?string
    {
        switch (intval($id)) {
            case 1:
                return "super admin";
            case 2:
                return "Coordinateur";
            case 3:
                return "Intervenant sportif";
            case 4:
                return "Référent";
            case 5:
                return "Évaluateur PEPS";
            case 6:
                return "Responsable Structure";
            case 7:
                return "Superviseur PEPS";
            default:
                return null;
        }
    }
}
