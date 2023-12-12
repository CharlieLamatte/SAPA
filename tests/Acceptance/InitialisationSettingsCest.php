<?php

/**
 * Ces tests servent à vérifier que les settings sont correctement appliqués dans toutes les pages.
 * Actuellement il n'y a un seul setting:
 * - le nombre d'éléments à afficher par défaut dans les tableaux
 *
 */

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\Login;


class InitialisationSettingsCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function settingNumberOfElementsCoordonnateurPeps(AcceptanceTester $I, Login $loginPage)
    {
        $expectedNumberOfElements = $this->getNumberOfElements($I, 'testcoord1@sportsante86.fr');

        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $I->amOnPage('/PHP/Accueil_liste.php');
        $I->waitPageLoad();

        // page d'accueil
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // archive
        $I->click(["id" => "archive"]);
        $I->waitPageLoad();
        $I->see('Bénéficiaires archivés');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page utilisateurs
        $I->amOnPage('/PHP/Users/ListeUser.php');
        $I->waitPageLoad();
        $I->see('Utilisateurs');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Professionnels de santé
        $I->amOnPage('/PHP/Medecins/ListeMedecin.php');
        $I->waitPageLoad();
        $I->see('Professionnels de santé');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Structure
        $I->amOnPage('/PHP/Structures/ListeStructure.php');
        $I->waitPageLoad();
        $I->see('Structures');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Intervenants
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->see('Intervenants');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Créneaux
        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->seeElement(["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // tableau de bord
        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see('Informations territoires');
        $I->seeElement(['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);
    }

    public function settingNumberOfElementsCoordonnateurMss(AcceptanceTester $I, Login $loginPage)
    {
        $expectedNumberOfElements = $this->getNumberOfElements($I, 'testCoordonnateurMSSAbc@gmail.com');

        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');
        $I->amOnPage('/PHP/Accueil_liste.php');
        $I->waitPageLoad();

        // page d'accueil
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // archive
        $I->click(["id" => "archive"]);
        $I->waitPageLoad();
        $I->see('Bénéficiaires archivés');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page utilisateurs
        $I->amOnPage('/PHP/Users/ListeUser.php');
        $I->waitPageLoad();
        $I->see('Utilisateurs');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Professionnels de santé
        $I->amOnPage('/PHP/Medecins/ListeMedecin.php');
        $I->waitPageLoad();
        $I->see('Professionnels de santé');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Structure
        $I->amOnPage('/PHP/Structures/ListeStructure.php');
        $I->waitPageLoad();
        $I->see('Structures');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Intervenants
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->see('Intervenants');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Créneaux
        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->seeElement(["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // tableau de bord
        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see('Informations territoires');
        $I->seeElement(['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);
    }

    public function settingNumberOfElementsCoordonnateurStructureNonMss(
        AcceptanceTester $I,
        Login $loginPage
    ) {
        $expectedNumberOfElements = $this->getNumberOfElements($I, 'testSupPatient@gmail.com');

        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');
        $I->amOnPage('/PHP/Accueil_liste.php');
        $I->waitPageLoad();

        // page d'accueil
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // archive
        $I->click(["id" => "archive"]);
        $I->waitPageLoad();
        $I->see('Bénéficiaires archivés');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page utilisateurs
        $I->amOnPage('/PHP/Users/ListeUser.php');
        $I->waitPageLoad();
        $I->see('Utilisateurs');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Professionnels de santé
        $I->amOnPage('/PHP/Medecins/ListeMedecin.php');
        $I->waitPageLoad();
        $I->see('Professionnels de santé');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Structure
        $I->amOnPage('/PHP/Structures/ListeStructure.php');
        $I->waitPageLoad();
        $I->see('Structures');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Intervenants
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->see('Intervenants');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Créneaux
        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->seeElement(["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // tableau de bord
        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see('Informations territoires');
        $I->seeElement(['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);
    }

    public function settingNumberOfElementsAdmin(AcceptanceTester $I, Login $loginPage)
    {
        $expectedNumberOfElements = $this->getNumberOfElements($I, 'TestAdmin@sportsante86.fr');

        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();

        // tableau de bord
        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see('Informations territoires');
        $I->seeElement(['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page utilisateurs
        $I->amOnPage('/PHP/Users/ListeUser.php');
        $I->waitPageLoad();
        $I->see('Utilisateurs');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Professionnels de santé
        $I->amOnPage('/PHP/Medecins/ListeMedecin.php');
        $I->waitPageLoad();
        $I->see('Professionnels de santé');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Structure
        $I->amOnPage('/PHP/Structures/ListeStructure.php');
        $I->waitPageLoad();
        $I->see('Structures');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Intervenants
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->see('Intervenants');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Créneaux
        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->seeElement(["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);
    }

    public function settingNumberOfElementsResponsableStructure(AcceptanceTester $I, Login $loginPage)
    {
        $expectedNumberOfElements = $this->getNumberOfElements($I, 'testResponsableStructureNom@sportsante86.fr');

        $loginPage->login('testResponsableStructureNom@sportsante86.fr', 'testResponsableStructureNom1.1@A');
        $I->amOnPage('/PHP/ResponsableStructure/Accueil.php');
        $I->waitPageLoad();

        // tableau séance
        $I->seeElement("/html/body/div[3]/div[2]/div[2]/div/div[1]/label/select");
        $actualNumberOfElements = $I->grabValueFrom("/html/body/div[3]/div[2]/div[2]/div/div[1]/label/select");
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // tableau de bord
        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see('Informations territoires');
        $I->seeElement(['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page utilisateurs
        $I->amOnPage('/PHP/Users/ListeUser.php');
        $I->waitPageLoad();
        $I->see('Utilisateurs');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Intervenants
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->see('Intervenants');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Créneaux
        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->seeElement(["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);
    }

    public function settingNumberOfElementsIntervenant(AcceptanceTester $I, Login $loginPage)
    {
        $expectedNumberOfElements = $this->getNumberOfElements($I, 'testIntervenantAbc@gmail.com');

        $loginPage->login('testIntervenantAbc@gmail.com', 'testIntervenantAbc@1d');
        $I->amOnPage('/PHP/Accueil_liste.php');
        $I->waitPageLoad();

        // aller sur le tableau des bénéf
        $I->click(["id" => "liste-beneficiaires"]);
        $I->waitPageLoad();
        $I->seeElement(["css" => "#table_patient_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_patient_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Créneaux
        $I->amOnPage('/PHP/Creneaux/MesCreneaux.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->seeElement(["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);
    }

    public function settingNumberOfElementsEvaluateur(AcceptanceTester $I, Login $loginPage)
    {
        $expectedNumberOfElements = $this->getNumberOfElements($I, 'testEvaluateurNom@sportsante86.fr');

        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');
        $I->amOnPage('/PHP/Accueil_liste.php');
        $I->waitPageLoad();

        // page d'accueil
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page utilisateurs
        $I->amOnPage('/PHP/Users/ListeUser.php');
        $I->waitPageLoad();
        $I->see('Utilisateurs');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Professionnels de santé
        $I->amOnPage('/PHP/Medecins/ListeMedecin.php');
        $I->waitPageLoad();
        $I->see('Professionnels de santé');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Structure
        $I->amOnPage('/PHP/Structures/ListeStructure.php');
        $I->waitPageLoad();
        $I->see('Structures');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Intervenants
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->see('Intervenants');
        $I->seeElement(["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_id_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);

        // page Créneaux
        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->seeElement(["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ["css" => "#table_creneau_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);
    }

    public function settingNumberOfElementsSuperviseurPeps(AcceptanceTester $I, Login $loginPage)
    {
        $expectedNumberOfElements = $this->getNumberOfElements($I, 'testSuperviseurNom@sportsante86.fr');

        $loginPage->login('testSuperviseurNom@sportsante86.fr', 'testAdmin1.1@A');
        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see('Informations territoires');

        // tableau de bord
        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see('Informations territoires');
        $I->seeElement(['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]);
        $actualNumberOfElements = $I->grabValueFrom(
            ['css' => "#tableau-bord_length > label:nth-child(1) > select:nth-child(1)"]
        );
        $I->assertEquals($expectedNumberOfElements, $actualNumberOfElements);
    }

    /**
     * @param AcceptanceTester $I
     * @param $email
     * @return string La valeur du setting 'nombre_elements_tableaux' de l'utilisateur donnée
     */
    private function getNumberOfElements(AcceptanceTester $I, $email)
    {
        $id_user = $I->grabFromDatabase(
            'users',
            'id_user',
            array('identifiant like' => $email)
        );
        $I->assertNotEmpty($id_user);

        $valeur = $I->grabFromDatabase(
            'user_settings',
            'valeur',
            array('id_user' => $id_user)
        );
        if (!$valeur) {
            return "10"; // default number of elements
        }

        return $valeur;
    }
}