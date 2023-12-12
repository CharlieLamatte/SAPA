<?php

namespace Sportsante86\Sapa\tests\Acceptance;

use Tests\Support\AcceptanceTester;

use Tests\Support\Page\Acceptance\Login;

class MultiRegionCest
{
    private $id_territoireSelect = ["id" => "id_territoire"];

    private $territoirePaysDeLaLoireTypeDepartementOption = ["css" => 'select[id="id_territoire"] > option[value="16"]']; // 49 Maine-et-Loire
    private $territoireNouvelleAquitaineTypeDepartementOption = ["css" => 'select[id="id_territoire"] > option[value="1"]']; // 86 Vienne
    private $territoirePaysDeLaLoireTypeRegionOption = ["css" => 'select[id="id_territoire"] > option[value="19"]']; // Pays de la Loire
    private $territoireNouvelleAquitaineTypeRegionOption = ["css" => 'select[id="id_territoire"] > option[value="13"]']; // Nouvelle-Aquitaine

    private $id_regionSelect = ["id" => "id_region"];

    private $regionNouvelleAquitaineOption = ["css" => 'select[id="id_region"] > option[value="13"]']; // Nouvelle-Aquitaine
    private $regionPaysDeLaLoireOption = ["css" => 'select[id="id_region"] > option[value="11"]']; // Pays de la Loire

    private $openModalButton = ["id" => "ajout-modal"];

    // spécifique page structure
    private $id_territoireStructureSelect = ["id" => "id_territoire-structure"];
    private $openModalStructureButton = ["id" => "ajout-modal-structure"];
    private $territoireStructurePaysDeLaLoireTypeDepartementOption = ["css" => 'select[id="id_territoire-structure"] > option[value="16"]']; // 49 Maine-et-Loire
    private $territoireStructureNouvelleAquitaineTypeDepartementOption = ["css" => 'select[id="id_territoire-structure"] > option[value="1"]']; // 86 Vienne
    private $territoireStructurePaysDeLaLoireTypeRegionOption = ["css" => 'select[id="id_territoire-structure"] > option[value="19"]']; // Pays de la Loire
    private $territoireStructureNouvelleAquitaineTypeRegionOption = ["css" => 'select[id="id_territoire-structure"] > option[value="13"]']; // Nouvelle-Aquitaine


    // specifique page user
    private $id_territoireUserSelect = ["id" => "id_territoire-user"];
    private $territoireUserPaysDeLaLoireTypeDepartementOption = ["css" => 'select[id="id_territoire-user"] > option[value="16"]']; // 49 Maine-et-Loire
    private $territoireUserNouvelleAquitaineTypeDepartementOption = ["css" => 'select[id="id_territoire-user"] > option[value="1"]']; // 86 Vienne
    private $territoireUserPaysDeLaLoireTypeRegionOption = ["css" => 'select[id="id_territoire-user"] > option[value="19"]']; // Pays de la Loire
    private $territoireUserNouvelleAquitaineTypeRegionOption = ["css" => 'select[id="id_territoire-user"] > option[value="13"]']; // Nouvelle-Aquitaine

    private $ajoutActiviteButton = ["id" => "ajout-activite"];

    private $territoireActivitePaysDeLaLoireTypeDepartementOption = ["css" => 'fieldset.section-vert > div:first-of-type > div > select > option[value="16"]']; // 49 Maine-et-Loire
    private $territoireActiviteNouvelleAquitaineTypeDepartementOption = ["css" => 'fieldset.section-vert > div:first-of-type > div > select > option[value="1"]']; // 86 Vienne
    private $territoireActivitePaysDeLaLoireTypeRegionOption = ["css" => 'fieldset.section-vert > div:first-of-type > div > select > option[value="19"]']; // Pays de la Loire
    private $territoireActiviteNouvelleAquitaineTypeRegionOption = ["css" => 'fieldset.section-vert > div:first-of-type > div > select > option[value="13"]']; // Nouvelle-Aquitaine

    public function _before(AcceptanceTester $I)
    {
    }

    public function navigationAsSuperAdmin(
        AcceptanceTester $I,
        Login $loginPage
    ) {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see("du département");
        $I->see(
            "sur 20 éléments"
        ); // 12 départements dans la vienne + 5 départements dans le Pays de la Loire + 2 totals region + 1 total global

        $I->wantTo("Voir le selects de territoire/region");
        $I->click("label.btn:nth-child(2)");
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->id_regionSelect);

        $I->wantTo("Vérifier les options du select region");
        $I->seeElement($this->regionNouvelleAquitaineOption);
        $I->seeElement($this->regionPaysDeLaLoireOption);

        $I->wantTo("Vérifier que le select de region n'est pas disabled");
        $attribute1 = $I->grabAttributeFrom($this->id_regionSelect, 'disabled');
        $I->assertNull($attribute1);

        $I->wantTo("Vérifier les options du select territoire");
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);
        // elem pas encore visible
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeDepartementOption);

        $I->wantTo("Changer de region");
        $I->selectOption($this->id_regionSelect, '11');
        $I->waitPageLoad();
        $I->seeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeDepartementOption);

        $I->wantTo("Vérifier que le select de territoire n'est pas disabled");
        $attribute1 = $I->grabAttributeFrom($this->id_territoireSelect, 'disabled');
        $I->assertNull($attribute1);

        $I->wantTo("Vérifier le header patient");
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=1');
        $I->waitPageLoad();
        $I->see("du département");

        $I->wantTo("Vérifier les options du select territoire du modal utilisateur");
        $I->amOnPage('/PHP/Users/ListeUser.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireUserSelect);
        $I->seeElement($this->territoireUserNouvelleAquitaineTypeDepartementOption);
        $I->seeElement($this->territoireUserPaysDeLaLoireTypeDepartementOption);
        $I->seeElement($this->territoireUserNouvelleAquitaineTypeRegionOption);
        $I->seeElement($this->territoireUserPaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal medecin");
        $I->amOnPage('/PHP/Medecins/ListeMedecin.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->seeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal structure");
        $I->amOnPage('/PHP/Structures/ListeStructure.php');
        $I->waitPageLoad();
        $I->click($this->openModalStructureButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireStructureSelect);
        $I->seeElement($this->territoireStructureNouvelleAquitaineTypeDepartementOption);
        $I->seeElement($this->territoireStructurePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireStructureNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireStructurePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal intervenant");
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->seeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire des activités");
        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=1');
        $I->waitPageLoad();
        $I->click($this->ajoutActiviteButton);
        $I->waitPageLoad();
        $I->seeElement($this->territoireActiviteNouvelleAquitaineTypeDepartementOption);
        $I->seeElement($this->territoireActivitePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireActiviteNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireActivitePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Quit the page and accept popup");
        $I->amOnPage('/');
        $I->acceptPopup();
    }

    public function navigationAsCoordonnateurPeps(
        AcceptanceTester $I,
        Login $loginPage
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');

        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see("du département");
        $I->see("sur 13 éléments"); // 12 département dans la vienne + total

        $I->wantTo("Voir le select de territoire");
        $I->click("label.btn:nth-child(2)");
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->id_regionSelect);

        $I->wantTo("Vérifier les options du select region");
        $I->seeElement($this->regionNouvelleAquitaineOption);
        $I->dontSeeElement($this->regionPaysDeLaLoireOption);

        $I->wantTo("Vérifier que le select de region est disabled");
        $attribute1 = $I->grabAttributeFrom($this->id_regionSelect, 'disabled');
        $I->assertNotNull($attribute1);

        $I->wantTo("Vérifier les options du select territoire");
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier que le select de territoire est disabled");
        $attribute1 = $I->grabAttributeFrom($this->id_territoireSelect, 'disabled');
        $I->assertNotNull($attribute1);

        $I->wantTo("Vérifier le header patient");
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=1');
        $I->waitPageLoad();
        $I->see("du département");

        $I->wantTo("Vérifier les options du select territoire du modal utilisateur");
        $I->amOnPage('/PHP/Users/ListeUser.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireUserSelect);
        $I->seeElement($this->territoireUserNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireUserPaysDeLaLoireTypeDepartementOption);
        $I->seeElement($this->territoireUserNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireUserPaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal medecin");
        $I->amOnPage('/PHP/Medecins/ListeMedecin.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->seeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal structure");
        $I->amOnPage('/PHP/Structures/ListeStructure.php');
        $I->waitPageLoad();
        $I->click($this->openModalStructureButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireStructureSelect);
        $I->seeElement($this->territoireStructureNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireStructurePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireStructureNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireStructurePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal intervenant");
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire des activités");
        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=1');
        $I->waitPageLoad();
        $I->click($this->ajoutActiviteButton);
        $I->waitPageLoad();
        $I->seeElement($this->territoireActiviteNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireActivitePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireActiviteNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireActivitePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Quit the page and accept popup");
        $I->amOnPage('/');
        $I->acceptPopup();
    }

    public function navigationAsCoordonnateurMss(
        AcceptanceTester $I,
        Login $loginPage
    ) {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');

        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see("du département");
        $I->see("sur 13 éléments"); // 12 département dans la vienne + total

        $I->wantTo("Voir le select de territoire");
        $I->click("label.btn:nth-child(2)");
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->id_regionSelect);

        $I->wantTo("Vérifier les options du select region");
        $I->seeElement($this->regionNouvelleAquitaineOption);
        $I->dontSeeElement($this->regionPaysDeLaLoireOption);

        $I->wantTo("Vérifier que le select de region est disabled");
        $attribute1 = $I->grabAttributeFrom($this->id_regionSelect, 'disabled');
        $I->assertNotNull($attribute1);

        $I->wantTo("Vérifier les options du select territoire");
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier que le select de territoire est disabled");
        $attribute1 = $I->grabAttributeFrom($this->id_territoireSelect, 'disabled');
        $I->assertNotNull($attribute1);

        $I->wantTo("Vérifier le header patient");
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=1');
        $I->waitPageLoad();
        $I->see("du département");

        $I->wantTo("Vérifier les options du select territoire du modal utilisateur");
        $I->amOnPage('/PHP/Users/ListeUser.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireUserSelect);
        $I->seeElement($this->territoireUserNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireUserPaysDeLaLoireTypeDepartementOption);
        $I->seeElement($this->territoireUserNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireUserPaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal medecin");
        $I->amOnPage('/PHP/Medecins/ListeMedecin.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->seeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal structure");
        $I->amOnPage('/PHP/Structures/ListeStructure.php');
        $I->waitPageLoad();
        $I->click($this->openModalStructureButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireStructureSelect);
        $I->seeElement($this->territoireStructureNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireStructurePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireStructureNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireStructurePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal intervenant");
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire des activités");
        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=1');
        $I->waitPageLoad();
        $I->click($this->ajoutActiviteButton);
        $I->waitPageLoad();
        $I->seeElement($this->territoireActiviteNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireActivitePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireActiviteNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireActivitePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Quit the page and accept popup");
        $I->amOnPage('/');
        $I->acceptPopup();
    }

    public function navigationAsCoordonnateurStructureNonMssMinData(
        AcceptanceTester $I,
        Login $loginPage
    ) {
        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');

        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see("du département");
        $I->see("sur 13 éléments"); // 12 département dans la vienne + total

        $I->wantTo("Voir le select de territoire");
        $I->click("label.btn:nth-child(2)");
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->id_regionSelect);

        $I->wantTo("Vérifier les options du select region");
        $I->seeElement($this->regionNouvelleAquitaineOption);
        $I->dontSeeElement($this->regionPaysDeLaLoireOption);

        $I->wantTo("Vérifier que le select de region est disabled");
        $attribute1 = $I->grabAttributeFrom($this->id_regionSelect, 'disabled');
        $I->assertNotNull($attribute1);

        $I->wantTo("Vérifier les options du select territoire");
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier que le select de territoire est disabled");
        $attribute1 = $I->grabAttributeFrom($this->id_territoireSelect, 'disabled');
        $I->assertNotNull($attribute1);

        $I->wantTo("Vérifier le header patient");
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=1');
        $I->waitPageLoad();
        $I->see("du département");

        $I->wantTo("Vérifier les options du select territoire du modal utilisateur");
        $I->amOnPage('/PHP/Users/ListeUser.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireUserSelect);
        $I->seeElement($this->territoireUserNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireUserPaysDeLaLoireTypeDepartementOption);
        $I->seeElement($this->territoireUserNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireUserPaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal medecin");
        $I->amOnPage('/PHP/Medecins/ListeMedecin.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->seeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal structure");
        $I->amOnPage('/PHP/Structures/ListeStructure.php');
        $I->waitPageLoad();
        $I->click($this->openModalStructureButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireStructureSelect);
        $I->seeElement($this->territoireStructureNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireStructurePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireStructureNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireStructurePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal intervenant");
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);
    }

    public function navigationAsEvaluateur(
        AcceptanceTester $I,
        Login $loginPage
    ) {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');

        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->see("Vous n'avez pas la permission d'accéder à cette page.");

        $I->wantTo("Vérifier le header patient");
        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=1');
        $I->waitPageLoad();
        $I->see("du département");

        $I->wantTo("Vérifier les options du select territoire du modal medecin");
        $I->amOnPage('/PHP/Medecins/ListeMedecin.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->seeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal structure");
        $I->amOnPage('/PHP/Structures/ListeStructure.php');
        $I->waitPageLoad();
        $I->click($this->openModalStructureButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireStructureSelect);
        $I->seeElement($this->territoireStructureNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireStructurePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireStructureNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireStructurePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire du modal intervenant");
        $I->amOnPage('/PHP/Intervenants/ListeIntervenant.php');
        $I->waitPageLoad();
        $I->click($this->openModalButton);
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier les options du select territoire des activités");
        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=1');
        $I->waitPageLoad();
        $I->click($this->ajoutActiviteButton);
        $I->waitPageLoad();
        $I->seeElement($this->territoireActiviteNouvelleAquitaineTypeDepartementOption);
        $I->dontSeeElement($this->territoireActivitePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireActiviteNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoireActivitePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Quit the page and accept popup");
        $I->amOnPage('/');
        $I->acceptPopup();
    }

    public function navigationAsSuperviseur(
        AcceptanceTester $I,
        Login $loginPage
    ) {
        $loginPage->login('testSuperviseurNom@sportsante86.fr', 'testAdmin1.1@A');

        $I->amOnPage('/PHP/Settings/TableauDeBord.php');
        $I->waitPageLoad();
        $I->see("de la région");
        $I->see("sur 6 éléments"); // 5 départements dans le Pays de la Loire + total

        $I->wantTo("Voir le select de territoire");
        $I->click("label.btn:nth-child(2)");
        $I->waitPageLoad();
        $I->seeElement($this->id_territoireSelect);
        $I->seeElement($this->id_regionSelect);

        $I->wantTo("Vérifier les options du select region");
        $I->dontSeeElement($this->regionNouvelleAquitaineOption);
        $I->seeElement($this->regionPaysDeLaLoireOption);

        $I->wantTo("Vérifier que le select de region est disabled");
        $attribute1 = $I->grabAttributeFrom($this->id_regionSelect, 'disabled');
        $I->assertNotNull($attribute1);

        $I->wantTo("Vérifier les options du select territoire");
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeDepartementOption);
        $I->seeElement($this->territoirePaysDeLaLoireTypeDepartementOption);
        $I->dontSeeElement($this->territoireNouvelleAquitaineTypeRegionOption);
        $I->dontSeeElement($this->territoirePaysDeLaLoireTypeRegionOption);

        $I->wantTo("Vérifier que le select de territoire n'est pas disabled");
        $attribute1 = $I->grabAttributeFrom($this->id_territoireSelect, 'disabled');
        $I->assertNull($attribute1);
    }
}