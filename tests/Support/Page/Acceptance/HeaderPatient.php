<?php

namespace Sportsante86\Sapa\tests\Support\Page\Acceptance;

use Tests\Support\AcceptanceTester;

class HeaderPatient
{
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    private $toast = ["id" => "toast"];

    private $openModalConsentement = ["id" => "logo-consentement"];
    private $modalConsentement = ["id" => "modal-consentement"];
    private $accordOuiRadio = ["id" => "accord-oui"];
    private $accordNonRadio = ["id" => "accord-non"];
    private $accordAttenteRadio = ["id" => "accord-attente"];

    private $logoConsentementOkImg = ["id" => "logo-consentement-ok"];
    private $logoConsentementNotOkImg = ["id" => "logo-consentement-not-ok"];
    private $logoConsentementAttenteImg = ["id" => "logo-consentement-attente"];

    private $modifierConsentementButton = ["id" => "modifier-consentement"];

    protected AcceptanceTester $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    public function modifyConsentement($consentement, $currentBaseUrl)
    {
        $I = $this->acceptanceTester;

        $I->wantTo("Ouvrir le modal");
        $I->seeElement($this->openModalConsentement);
        $I->dontSeeElement($this->modalConsentement);
        $I->click($this->openModalConsentement);
        $I->waitPageLoad();
        $I->seeElement($this->modalConsentement);

        $I->wantTo("Modifier le consentement");
        if ($consentement == "1") {
            $I->click($this->accordOuiRadio);
        } elseif ($consentement == "0") {
            $I->click($this->accordNonRadio);
        } else {
            $I->click($this->accordAttenteRadio);
        }
        $I->click($this->modifierConsentementButton);
        $I->waitPageLoad();
        $I->see("Le consentement du patient a été modifié avec succès", $this->toast);

        $I->wantTo("Verifier les modifications");
        if ($consentement == "1") {
            $I->seeElement($this->logoConsentementOkImg);
            $I->dontSeeElement($this->logoConsentementAttenteImg);
            $I->dontSeeElement($this->logoConsentementNotOkImg);
        } elseif ($consentement == "0") {
            $I->dontSeeElement($this->logoConsentementOkImg);
            $I->dontSeeElement($this->logoConsentementAttenteImg);
            $I->seeElement($this->logoConsentementNotOkImg);
        } else {
            $I->dontSeeElement($this->logoConsentementOkImg);
            $I->seeElement($this->logoConsentementAttenteImg);
            $I->dontSeeElement($this->logoConsentementNotOkImg);
        }

        $I->wantTo("Verifier que les élément de la pages santé sont correctement affichés");
        if ($currentBaseUrl == "/PHP/Patients/Sante.php?idPatient=") {
            if ($consentement == "1") {
                $I->see("Affections de longue durée");
                $I->see("Pathologies");
            } else {
                $I->dontSee("Affections de longue durée");
                $I->dontSee("Pathologies");
            }
        }
    }
}