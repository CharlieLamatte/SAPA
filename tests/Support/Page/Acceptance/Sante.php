<?php

namespace Sportsante86\Sapa\tests\Support\Page\Acceptance;

use Tests\Support\AcceptanceTester;

class Sante
{
    // include url of current page
    public static $URL = '/PHP/Patients/Sante.php?idPatient=';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    private $toast = ["id" => "toast"];

    private $modifierPathologieButton = ["id" => "modifier-pathologie"];

    private $a_patho_cardioRadio = ["name" => "a-patho-cardio"];
    private $a_patho_respiRadio = ["name" => "a-patho-respi"];
    private $a_patho_metaboRadio = ["name" => "a-patho-metabo"];
    private $a_patho_osteoRadio = ["name" => "a-patho-osteo"];
    private $a_patho_psychoRadio = ["name" => "a-patho-psycho"];
    private $a_patho_neuroRadio = ["name" => "a-patho-neuro"];
    private $a_patho_canceroRadio = ["name" => "a-patho-cancero"];
    private $a_patho_circulRadio = ["name" => "a-patho-circul"];
    private $a_patho_autreRadio = ["name" => "a-patho-autre"];

    private $cardioFied = ["id" => "detail-cardio"];
    private $respiFied = ["id" => "detail-respi"];
    private $metaboFied = ["id" => "detail-metabo"];
    private $osteoFied = ["id" => "detail-osteo"];
    private $neuroFied = ["id" => "detail-neuro"];
    private $psychoFied = ["id" => "detail-psycho"];
    private $canceroFied = ["id" => "detail-cancero"];
    private $circulFied = ["id" => "detail-circul"];
    private $autreFied = ["id" => "detail-autre"];

    protected AcceptanceTester $acceptanceTester;

    private HeaderPatient $headerPatient;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
        $this->headerPatient = new HeaderPatient($I);
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param): string
    {
        return static::$URL . $param;
    }

    public function modifyPathologies($paramaters)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::route($paramaters['id_patient']));

        $I->wantTo("Accepter le partage des données de santé");
        $this->headerPatient->modifyConsentement("1", self::$URL);

        $I->wantTo("Modifier les pathologies du patient");
        $I->selectOption($this->a_patho_cardioRadio, $paramaters['a_patho_cardio']);
        $I->waitPageLoad();
        if ($paramaters['a_patho_cardio'] == "1") {
            $I->fillField($this->cardioFied, $paramaters['cardio']);
        }
        $I->selectOption($this->a_patho_respiRadio, $paramaters['a_patho_respiratoire']);
        $I->waitPageLoad();
        if ($paramaters['a_patho_respiratoire'] == "1") {
            $I->fillField($this->respiFied, $paramaters['respiratoire']);
        }
        $I->selectOption($this->a_patho_metaboRadio, $paramaters['a_patho_metabolique']);
        $I->waitPageLoad();
        if ($paramaters['a_patho_metabolique'] == "1") {
            $I->fillField($this->metaboFied, $paramaters['metabolique']);
        }
        $I->selectOption($this->a_patho_osteoRadio, $paramaters['a_patho_osteo_articulaire']);
        $I->waitPageLoad();
        if ($paramaters['a_patho_osteo_articulaire'] == "1") {
            $I->fillField($this->osteoFied, $paramaters['osteo_articulaire']);
        }
        $I->selectOption($this->a_patho_psychoRadio, $paramaters['a_patho_psycho_social']);
        $I->waitPageLoad();
        if ($paramaters['a_patho_psycho_social'] == "1") {
            $I->fillField($this->psychoFied, $paramaters['psycho_social']);
        }
        $I->selectOption($this->a_patho_neuroRadio, $paramaters['a_patho_neuro']);
        $I->waitPageLoad();
        if ($paramaters['a_patho_neuro'] == "1") {
            $I->fillField($this->neuroFied, $paramaters['neuro']);
        }
        $I->selectOption($this->a_patho_canceroRadio, $paramaters['a_patho_cancero']);
        $I->waitPageLoad();
        if ($paramaters['a_patho_cancero'] == "1") {
            $I->fillField($this->canceroFied, $paramaters['cancero']);
        }
        $I->selectOption($this->a_patho_circulRadio, $paramaters['a_patho_circulatoire']);
        $I->waitPageLoad();
        if ($paramaters['a_patho_circulatoire'] == "1") {
            $I->fillField($this->circulFied, $paramaters['circulatoire']);
        }
        $I->selectOption($this->a_patho_autreRadio, $paramaters['a_patho_autre']);
        $I->waitPageLoad();
        if ($paramaters['a_patho_autre'] == "1") {
            $I->fillField($this->autreFied, $paramaters['autre']);
        }

        $I->click($this->modifierPathologieButton);
        $I->waitPageLoad();
        $I->see("Pathologies modifiées avec succès", $this->toast);
        $I->reloadPage();
        $I->waitPageLoad();

        $I->wantTo("Verifier les modifications");

        if ($paramaters['a_patho_cardio'] == "1") {
            $I->seeOptionIsSelected($this->a_patho_cardioRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_patho_cardioRadio, "0");
            $I->assertEqualsIgnoringCase($paramaters['cardio'], $I->grabValueFrom($this->cardioFied));
        } else {
            $I->seeOptionIsSelected($this->a_patho_cardioRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_patho_cardioRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->cardioFied));
        }
        if ($paramaters['a_patho_respiratoire'] == "1") {
            $I->seeOptionIsSelected($this->a_patho_respiRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_patho_respiRadio, "0");
            $I->assertEqualsIgnoringCase($paramaters['respiratoire'], $I->grabValueFrom($this->respiFied));
        } else {
            $I->seeOptionIsSelected($this->a_patho_respiRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_patho_respiRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->respiFied));
        }
        if ($paramaters['a_patho_metabolique'] == "1") {
            $I->seeOptionIsSelected($this->a_patho_metaboRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_patho_metaboRadio, "0");
            $I->assertEqualsIgnoringCase($paramaters['metabolique'], $I->grabValueFrom($this->metaboFied));
        } else {
            $I->seeOptionIsSelected($this->a_patho_metaboRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_patho_metaboRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->metaboFied));
        }
        if ($paramaters['a_patho_osteo_articulaire'] == "1") {
            $I->seeOptionIsSelected($this->a_patho_osteoRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_patho_osteoRadio, "0");
            $I->assertEqualsIgnoringCase($paramaters['osteo_articulaire'], $I->grabValueFrom($this->osteoFied));
        } else {
            $I->seeOptionIsSelected($this->a_patho_osteoRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_patho_osteoRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->osteoFied));
        }
        if ($paramaters['a_patho_psycho_social'] == "1") {
            $I->seeOptionIsSelected($this->a_patho_psychoRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_patho_psychoRadio, "0");
            $I->assertEqualsIgnoringCase($paramaters['psycho_social'], $I->grabValueFrom($this->psychoFied));
        } else {
            $I->seeOptionIsSelected($this->a_patho_psychoRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_patho_psychoRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->psychoFied));
        }
        if ($paramaters['a_patho_neuro'] == "1") {
            $I->seeOptionIsSelected($this->a_patho_neuroRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_patho_neuroRadio, "0");
            $I->assertEqualsIgnoringCase($paramaters['neuro'], $I->grabValueFrom($this->neuroFied));
        } else {
            $I->seeOptionIsSelected($this->a_patho_neuroRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_patho_neuroRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->neuroFied));
        }
        if ($paramaters['a_patho_cancero'] == "1") {
            $I->seeOptionIsSelected($this->a_patho_canceroRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_patho_canceroRadio, "0");
            $I->assertEqualsIgnoringCase($paramaters['cancero'], $I->grabValueFrom($this->canceroFied));
        } else {
            $I->seeOptionIsSelected($this->a_patho_canceroRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_patho_canceroRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->canceroFied));
        }
        if ($paramaters['a_patho_circulatoire'] == "1") {
            $I->seeOptionIsSelected($this->a_patho_circulRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_patho_circulRadio, "0");
            $I->assertEqualsIgnoringCase($paramaters['circulatoire'], $I->grabValueFrom($this->circulFied));
        } else {
            $I->seeOptionIsSelected($this->a_patho_circulRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_patho_circulRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->circulFied));
        }
        if ($paramaters['a_patho_autre'] == "1") {
            $I->seeOptionIsSelected($this->a_patho_autreRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_patho_autreRadio, "0");
            $I->assertEqualsIgnoringCase($paramaters['autre'], $I->grabValueFrom($this->autreFied));
        } else {
            $I->seeOptionIsSelected($this->a_patho_autreRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_patho_autreRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->autreFied));
        }
    }
}