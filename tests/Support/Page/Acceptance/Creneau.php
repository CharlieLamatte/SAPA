<?php

namespace Tests\Support\Page\Acceptance;

use Tests\Support\AcceptanceTester;
use Sportsante86\Sapa\Outils\ChaineCharactere;

class Creneau
{
    // include url of current page
    public static $URL = '/PHP/Creneaux/ListeCreneau.php';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    private $enregistrerModifierButton = ["id" => "enregistrer-modifier"];
    private $closeButton = ["id" => "close"];
    private $form = ["id" => "form-creneau"];

    private $searchField = ["css" => "#table_creneau_filter > label:nth-child(1) > input:nth-child(1)"];
    private $nameFirstRow = ['css' => 'tr.odd:nth-child(1) > td:nth-child(1)'];

    private $openButton = ["id" => "creneau-modal"];
    private $modal = ["id" => "modal"];
    private $toast = ["id" => "toast"];

    // Informations du créneau
    private $nomField = ["id" => "nom_creneau"];
    private $type_creneauSelect = ["id" => "type_creneau"];
    private $type_creneauSelectedOPtion = ["css" => "#type_creneau option:checked"];
    private $jourSelect = ["id" => "jour"];
    private $jourSelectedOPtion = ["css" => "#jour option:checked"];
    private $heure_debutSelect = ["id" => "heure_debut"];
    private $heure_debutSelectedOPtion = ["css" => "#heure_debut option:checked"];
    private $heure_finSelect = ["id" => "heure_fin"];
    private $heure_finSelectedOPtion = ["css" => "#heure_fin option:checked"];

    // Structure
    private $nom_structureSelect = ["id" => "nom_structure"];
    private $nom_structureSelectedOPtion = ["css" => "#nom_structure option:checked"];
    private $intervenantSelect = ["id" => "intervenant"];
    private $intervenantSelectedOPtion = ["css" => "#intervenant option:checked"];
    private $firstIntervenant = ["css" => "#intervenant > option:nth-child(1)"];
    private $ajoutIntervenantButton = ["id" => "ajout-intervenant-button"];

    // Détails de l'activité
    private $nb_participantMaxField = ["id" => "nb_participant"];
    private $nb_participant_creneauField = ["id" => "nb_participant_creneau"];
    private $public_viseField = ["id" => "public_vise"];
    private $tarifField = ["id" => "tarif"];
    private $paiementField = ["id" => "paiement"];
    private $pathologieField = ["id" => "pathologie"];
    private $type_seanceField = ["id" => "type_seance"];
    private $descriptionField = ["id" => "description"];

    // Lieu du Créneau
    private $adresseField = ["id" => "adresse"];
    private $complementAdresseField = ["id" => "complement-adresse"];
    private $codePostalField = ["id" => "code-postal"];
    private $firstCodePostal = ["css" => "#code-postalautocomplete-list > div:nth-child(1) > input:nth-child(1)"];
    private $villeField = ["id" => "ville"];

    protected AcceptanceTester $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    /**
     * required parameters :
     * [
     *     // obligatoire
     *     'email_connected' => string,
     *     'nom_creneau' => string,
     *     'jour' => string,
     *     'id_heure_debut' => string,
     *     'id_heure_fin' => string,
     *     'pathologie' => string,
     *     'type_seance' => string,
     *     'adresse' => string,
     *     'code_postal' => string,
     *
     *     // obligatoire sauf si utilisateur est responsable structure
     *     'id_structure' => string,
     *     'intervenant_ids' => array,
     *     'type_creneau' => string,
     *
     *     // optionnel
     *     'nb_participant_max' => string,
     *     'public_vise' => string,
     *     'tarif' => string,
     *     'paiement' => string,
     *     'description' => string,
     *     'complement_adresse' => string,
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
        $id_structure_connected = $I->grabFromDatabase(
            'users',
            'id_structure',
            ['identifiant like' => $paramaters['email_connected']]
        );
        $I->assertNotEmpty($id_structure_connected);
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

        // si responsable structure
        if (in_array("6", $role_user_ids_connected)) {
            $I->wantTo("Vérifier que certains élément sont disabled");
            $attribute1 = $I->grabAttributeFrom($this->type_creneauSelect, 'disabled');
            $I->assertNotNull($attribute1);
            $attribute2 = $I->grabAttributeFrom($this->nom_structureSelect, 'disabled');
            $I->assertNotNull($attribute2);
        }

        $I->wantTo("Remplir les champs");
        // obligatoire
        $I->fillField($this->nomField, $paramaters['nom_creneau']);
        $I->fillField($this->pathologieField, $paramaters['pathologie']);
        $I->fillField($this->type_seanceField, $paramaters['type_seance']);
        $I->fillField($this->adresseField, $paramaters['adresse']);
        $I->fillField($this->codePostalField, $paramaters['code_postal']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->firstCodePostal, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->firstCodePostal);

        $I->selectOption($this->heure_debutSelect, $paramaters['id_heure_debut']);
        $heure_debut_text = $I->grabTextFrom($this->heure_debutSelectedOPtion);
        $I->assertNotEmpty($heure_debut_text);

        $I->selectOption($this->heure_finSelect, $paramaters['id_heure_fin']);
        $heure_fin_text = $I->grabTextFrom($this->heure_finSelectedOPtion);
        $I->assertNotEmpty($heure_fin_text);

        $I->selectOption($this->jourSelect, $paramaters['jour']);
        $jour_text = $I->grabTextFrom($this->jourSelectedOPtion);
        $I->assertNotEmpty($jour_text);

        // si pas responsable structure
        if (!in_array("6", $role_user_ids_connected)) {
            $I->selectOption($this->type_creneauSelect, $paramaters['type_creneau']);
            $type_creneau_text = $I->grabTextFrom($this->type_creneauSelectedOPtion);
            $I->assertNotEmpty($type_creneau_text);

            $I->selectOption($this->nom_structureSelect, $paramaters['id_structure']);
            $nom_structure_text = $I->grabTextFrom($this->nom_structureSelectedOPtion);
            $I->assertNotEmpty($nom_structure_text);
        }

        // si responsable structure
        if (in_array("6", $role_user_ids_connected)) {
            // on choisi le premier intervenant du select
            $id_intervenant_responsable = $I->grabValueFrom($this->firstIntervenant);
            $I->assertNotEmpty($id_intervenant_responsable);
            $I->click($this->ajoutIntervenantButton);
        } else {
            foreach ($paramaters['intervenant_ids'] as $id_intervenant) {
                $I->selectOption($this->intervenantSelect, $id_intervenant);
                $I->click($this->ajoutIntervenantButton);
                $I->wait(1);
            }
        }

        // optionnel
        if (isset($paramaters['nb_participant_max'])) {
            $I->fillField($this->nb_participantMaxField, $paramaters['nb_participant_max']);
        }
        if (isset($paramaters['public_vise'])) {
            $I->fillField($this->public_viseField, $paramaters['public_vise']);
        }
        if (isset($paramaters['tarif'])) {
            $I->fillField($this->tarifField, $paramaters['tarif']);
        }
        if (isset($paramaters['paiement'])) {
            $I->fillField($this->paiementField, $paramaters['paiement']);
        }
        if (isset($paramaters['description'])) {
            $I->fillField($this->descriptionField, $paramaters['description']);
        }
        if (isset($paramaters['complement_adresse'])) {
            $I->fillField($this->complementAdresseField, $paramaters['complement_adresse']);
        }

        $I->wantTo("Enregistrer le nouveau créneau");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Créneau ajouté avec succes", $this->toast);

        $I->wantTo("Ouvrir les détails du nouveau créneau");
        $I->fillField($this->searchField, $paramaters['nom_creneau']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->nameFirstRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirstRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");
        $I->assertEquals(ChaineCharactere::mb_ucfirst($paramaters['nom_creneau']), $I->grabValueFrom($this->nomField));

        if (in_array("6", $role_user_ids_connected)) {
            // le responsable structure ne peut que créer des créneaux non labellisés
            $I->assertEquals('4', $I->grabValueFrom($this->type_creneauSelect));
            $I->assertEquals($id_structure_connected, $I->grabValueFrom($this->nom_structureSelect));
            $ids = $I->grabMultiple(['css' => '#body-intervenants > tr'], 'data-id_intervenant');
            $I->assertEqualsCanonicalizing($ids, [$id_intervenant_responsable]);
        } else {
            $ids = $I->grabMultiple(['css' => '#body-intervenants > tr'], 'data-id_intervenant');
            $I->assertEqualsCanonicalizing($ids, $paramaters['intervenant_ids']);
            $I->assertEquals($paramaters['type_creneau'], $I->grabValueFrom($this->type_creneauSelect));
            $I->assertEquals($paramaters['id_structure'], $I->grabValueFrom($this->nom_structureSelect));
        }
        $I->assertEquals($paramaters['jour'], $I->grabValueFrom($this->jourSelect));
        $I->assertEquals($paramaters['id_heure_debut'], $I->grabValueFrom($this->heure_debutSelect));
        $I->assertEquals($paramaters['id_heure_fin'], $I->grabValueFrom($this->heure_finSelect));

        $I->assertEquals($paramaters['pathologie'], $I->grabValueFrom($this->pathologieField));
        $I->assertEquals($paramaters['type_seance'], $I->grabValueFrom($this->type_seanceField));
        $I->assertEquals(ChaineCharactere::mb_ucfirst($paramaters['adresse']), $I->grabValueFrom($this->adresseField));
        $I->assertEquals($paramaters['code_postal'], $I->grabValueFrom($this->codePostalField));

        // optionnel
        if (isset($paramaters['nb_participant_max'])) {
            $I->assertEquals($paramaters['nb_participant_max'], $I->grabValueFrom($this->nb_participantMaxField));
        }
        if (isset($paramaters['public_vise'])) {
            $I->assertEquals($paramaters['public_vise'], $I->grabValueFrom($this->public_viseField));
        }
        if (isset($paramaters['tarif'])) {
            $I->assertEquals($paramaters['tarif'], $I->grabValueFrom($this->tarifField));
        }
        if (isset($paramaters['paiement'])) {
            $I->assertEquals($paramaters['paiement'], $I->grabValueFrom($this->paiementField));
        }
        if (isset($paramaters['description'])) {
            $I->assertEquals($paramaters['description'], $I->grabValueFrom($this->descriptionField));
        }
        if (isset($paramaters['complement_adresse'])) {
            $I->assertEquals(
                ChaineCharactere::mb_ucfirst($paramaters['complement_adresse']),
                $I->grabValueFrom($this->complementAdresseField)
            );
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
     *     'email_connected' => string,
     *     'nom_creneau' => string,
     *     'jour' => string,
     *     'id_heure_debut' => string,
     *     'id_heure_fin' => string,
     *     'pathologie' => string,
     *     'type_seance' => string,
     *     'adresse' => string,
     *     'code_postal' => string,
     *
     *     // obligatoire sauf si utilisateur est responsable structure
     *     'id_structure' => string,
     *     'intervenant_ids' => array,
     *     'type_creneau' => string,
     *
     *     // optionnel
     *     'nb_participant_max' => string,
     *     'public_vise' => string,
     *     'tarif' => string,
     *     'paiement' => string,
     *     'description' => string,
     *     'complement_adresse' => string,
     * ]
     *
     * @param $paramaters
     * @return void
     */
    public function modify($paramaters)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::$URL);

        $I->wantTo("Récupérer données de l'utilisateur connecté");
        $id_structure_connected = $I->grabFromDatabase(
            'users',
            'id_structure',
            ['identifiant like' => $paramaters['email_connected']]
        );
        $I->assertNotEmpty($id_structure_connected);
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

        // si responsable structure
        if (in_array("6", $role_user_ids_connected)) {
            $I->wantTo("Vérifier que certains élément sont disabled");
            $attribute1 = $I->grabAttributeFrom($this->type_creneauSelect, 'disabled');
            $I->assertNotNull($attribute1);
            $attribute2 = $I->grabAttributeFrom($this->nom_structureSelect, 'disabled');
            $I->assertNotNull($attribute2);
        }

        // si responsable structure
        if (in_array("6", $role_user_ids_connected)) {
            $I->wantTo("Vérifier que certains élément sont disabled");
            $attribute1 = $I->grabAttributeFrom($this->type_creneauSelect, 'disabled');
            $I->assertNotNull($attribute1);
            $attribute2 = $I->grabAttributeFrom($this->nom_structureSelect, 'disabled');
            $I->assertNotNull($attribute2);
        }

        $I->wantTo("Remplir les champs");
        // obligatoire
        if (isset($paramaters['nom_creneau'])) {
            $I->fillField($this->nomField, $paramaters['nom_creneau']);
        }

        if (isset($paramaters['pathologie'])) {
            $I->fillField($this->pathologieField, $paramaters['pathologie']);
        }

        if (isset($paramaters['type_seance'])) {
            $I->fillField($this->type_seanceField, $paramaters['type_seance']);
        }

        if (isset($paramaters['adresse'])) {
            $I->fillField($this->adresseField, $paramaters['adresse']);
        }

        if (isset($paramaters['code_postal'])) {
            $I->fillField($this->codePostalField, $paramaters['code_postal']);
            $I->waitPageLoad();
            $I->waitForElementClickable($this->firstCodePostal, 30);
            $I->retry(4, 1000);
            $I->retryClick($this->firstCodePostal);
        }

        if (isset($paramaters['id_heure_debut'])) {
            $I->selectOption($this->heure_debutSelect, $paramaters['id_heure_debut']);
            $heure_debut_text = $I->grabTextFrom($this->heure_debutSelectedOPtion);
            $I->assertNotEmpty($heure_debut_text);
        }

        if (isset($paramaters['id_heure_fin'])) {
            $I->selectOption($this->heure_finSelect, $paramaters['id_heure_fin']);
            $heure_fin_text = $I->grabTextFrom($this->heure_finSelectedOPtion);
            $I->assertNotEmpty($heure_fin_text);
        }

        if (isset($paramaters['jour'])) {
            $I->selectOption($this->jourSelect, $paramaters['jour']);
            $jour_text = $I->grabTextFrom($this->jourSelectedOPtion);
            $I->assertNotEmpty($jour_text);
        }

        // si pas responsable structure
        if (!in_array("6", $role_user_ids_connected)) {
            if (isset($paramaters['type_creneau'])) {
                $I->selectOption($this->type_creneauSelect, $paramaters['type_creneau']);
                $type_creneau_text = $I->grabTextFrom($this->type_creneauSelectedOPtion);
                $I->assertNotEmpty($type_creneau_text);
            }

            if (isset($paramaters['id_structure'])) {
                $I->selectOption($this->nom_structureSelect, $paramaters['id_structure']);
                $nom_structure_text = $I->grabTextFrom($this->nom_structureSelectedOPtion);
                $I->assertNotEmpty($nom_structure_text);
            }
        }

        // si responsable structure
        if (in_array("6", $role_user_ids_connected)) {
            // suppression des intervenants précedents
            $I->clickAllElements(['css' =>'#body-intervenants > tr > td> button']);

            // on choisi le premier intervenant du select
            $id_intervenant_responsable = $I->grabValueFrom($this->firstIntervenant);
            $I->assertNotEmpty($id_intervenant_responsable);
            $I->click($this->ajoutIntervenantButton);

            $type_creneau_initial_value = $I->grabValueFrom($this->type_creneauSelect);
        } else {
            if (isset($paramaters['intervenant_ids'])) {
                // suppression des intervenants précedents
                $I->clickAllElements(['css' =>'#body-intervenants > tr > td> button']);

                foreach ($paramaters['intervenant_ids'] as $id_intervenant) {
                    $I->selectOption($this->intervenantSelect, $id_intervenant);
                    $I->click($this->ajoutIntervenantButton);
                    $I->wait(1);
                }
            }
        }
        if (isset($paramaters['nb_participant_max'])) {
            $I->fillField($this->nb_participantMaxField, $paramaters['nb_participant_max']);
        }
        if (isset($paramaters['public_vise'])) {
            $I->fillField($this->public_viseField, $paramaters['public_vise']);
        }
        if (isset($paramaters['tarif'])) {
            $I->fillField($this->tarifField, $paramaters['tarif']);
        }
        if (isset($paramaters['paiement'])) {
            $I->fillField($this->paiementField, $paramaters['paiement']);
        }
        if (isset($paramaters['description'])) {
            $I->fillField($this->descriptionField, $paramaters['description']);
        }
        if (isset($paramaters['complement_adresse'])) {
            $I->fillField($this->complementAdresseField, $paramaters['complement_adresse']);
        }

        $I->wantTo("Enregistrer les modifications");
        $I->click($this->enregistrerModifierButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
        $I->see("Créneau modifié avec succès.", $this->toast);

        $I->wantTo("Ouvrir les détails du créneau");
        $I->fillField($this->searchField, $paramaters['nom_creneau']);
        $I->waitPageLoad();
        $I->waitForElementClickable($this->nameFirstRow, 30);
        $I->retry(4, 1000);
        $I->retryClick($this->nameFirstRow);
        $I->waitPageLoad();
        $I->seeElement($this->modal);

        $I->wantTo("Vérifier que les modifications ont été enregistrées");

        if (in_array("6", $role_user_ids_connected)) {
            // le responsable structure
            $I->assertEquals($type_creneau_initial_value, $I->grabValueFrom($this->type_creneauSelect));
            $ids = $I->grabMultiple(['css' => '#body-intervenants > tr'], 'data-id_intervenant');
            $I->assertEqualsCanonicalizing($ids, [$id_intervenant_responsable]);
            $I->assertEquals($id_structure_connected, $I->grabValueFrom($this->nom_structureSelect));
        } else {
            if (isset($paramaters['type_creneau'])) {
                $I->assertEquals($paramaters['type_creneau'], $I->grabValueFrom($this->type_creneauSelect));
            }
            if (isset($paramaters['id_intervenant'])) {
                $ids = $I->grabMultiple(['css' => '#body-intervenants > tr'], 'data-id_intervenant');
                $I->assertEqualsCanonicalizing($ids, $paramaters['intervenant_ids']);
                $I->assertEquals($paramaters['type_creneau'], $I->grabValueFrom($this->type_creneauSelect));
                $I->assertEquals($paramaters['id_structure'], $I->grabValueFrom($this->nom_structureSelect));
            }
            if (isset($paramaters['id_structure'])) {
                $I->assertEquals($paramaters['id_structure'], $I->grabValueFrom($this->nom_structureSelect));
            }
        }

        if (isset($paramaters['nom_creneau'])) {
            $I->assertEquals(ChaineCharactere::mb_ucfirst($paramaters['nom_creneau']), $I->grabValueFrom($this->nomField));
        }
        if (isset($paramaters['jour'])) {
            $I->assertEquals($paramaters['jour'], $I->grabValueFrom($this->jourSelect));
        }
        if (isset($paramaters['id_heure_debut'])) {
            $I->assertEquals($paramaters['id_heure_debut'], $I->grabValueFrom($this->heure_debutSelect));
        }
        if (isset($paramaters['id_heure_fin'])) {
            $I->assertEquals($paramaters['id_heure_fin'], $I->grabValueFrom($this->heure_finSelect));
        }
        if (isset($paramaters['pathologie'])) {
            $I->assertEquals($paramaters['pathologie'], $I->grabValueFrom($this->pathologieField));
        }
        if (isset($paramaters['type_seance'])) {
            $I->assertEquals($paramaters['type_seance'], $I->grabValueFrom($this->type_seanceField));
        }
        if (isset($paramaters['adresse'])) {
            $I->assertEquals(ChaineCharactere::mb_ucfirst($paramaters['adresse']), $I->grabValueFrom($this->adresseField));
        }
        if (isset($paramaters['code_postal'])) {
            $I->assertEquals($paramaters['code_postal'], $I->grabValueFrom($this->codePostalField));
        }

        // optionnel
        if (isset($paramaters['nb_participant_max'])) {
            $I->assertEquals($paramaters['nb_participant_max'], $I->grabValueFrom($this->nb_participantMaxField));
        }
        if (isset($paramaters['public_vise'])) {
            $I->assertEquals($paramaters['public_vise'], $I->grabValueFrom($this->public_viseField));
        }
        if (isset($paramaters['tarif'])) {
            $I->assertEquals($paramaters['tarif'], $I->grabValueFrom($this->tarifField));
        }
        if (isset($paramaters['paiement'])) {
            $I->assertEquals($paramaters['paiement'], $I->grabValueFrom($this->paiementField));
        }
        if (isset($paramaters['description'])) {
            $I->assertEquals($paramaters['description'], $I->grabValueFrom($this->descriptionField));
        }
        if (isset($paramaters['complement_adresse'])) {
            $I->assertEquals(
                ChaineCharactere::mb_ucfirst($paramaters['complement_adresse']),
                $I->grabValueFrom($this->complementAdresseField)
            );
        }

        $I->wantTo("Fermer le modal");
        $I->seeElement($this->closeButton);
        $I->retry(4, 1000);
        $I->retryClick($this->closeButton);
        $I->waitPageLoad();
        $I->dontSeeElement($this->modal);
    }
}