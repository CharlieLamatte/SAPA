<?php

namespace Sportsante86\Sapa\tests\Support\Page\Acceptance;

use Tests\Support\AcceptanceTester;

class ActivitePhysique
{
    // include url of current page
    public static $URL = '/PHP/Patients/Ap.php?idPatient=';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    private $toast = ["id" => "toast"];

    private $modifierPathologieButton = ["id" => "modifier-pathologie"];

    private $a_activite_anterieureRadio = ["name" => "a-activite-anterieure"];
    private $a_activite_autonomeRadio = ["name" => "a-activite-autonome"];
    private $a_activite_encadreeRadio = ["name" => "a-activite-encadree"];
    private $a_activite_envisageeRadio = ["name" => "a-activite-envisagee"];
    private $a_activite_freinRadio = ["name" => "a-activite-frein"];
    private $a_activite_point_fort_levierRadio = ["name" => "a-activite-point-fort-levier"];

    private $activite_physique_autonomeFied = ["id" => "activite_physique_autonome_textarea"];
    private $activite_physique_encadreeFied = ["id" => "activite_physique_encadree_textarea"];
    private $activite_anterieureFied = ["id" => "activite_anterieure_textarea"];
    private $frein_activiteFied = ["id" => "frein_activite_textarea"];
    private $activite_envisageeFied = ["id" => "activite_envisagee_textarea"];
    private $point_fort_levierFied = ["id" => "point_fort_levier_textarea"];
    private $disponibiliteFied = ["id" => "disponibilite_textarea"];

    private $jourLundiCheckbox = ["id" => "jour-lundi"];
    private $jourMardiCheckbox = ["id" => "jour-mardi"];
    private $jourMercrediCheckbox = ["id" => "jour-mercredi"];
    private $jourJeudiCheckbox = ["id" => "jour-jeudi"];
    private $jourVendrediCheckbox = ["id" => "jour-vendredi"];
    private $jourSamediCheckbox = ["id" => "jour-samedi"];
    private $jourDimancheCheckbox = ["id" => "jour-dimanche"];

    private $heureDebutLundiSelect = ["id" => "heure-debut-lundi"];
    private $heureDebutMardiSelect = ["id" => "heure-debut-mardi"];
    private $heureDebutMercrediSelect = ["id" => "heure-debut-mercredi"];
    private $heureDebutJeudiSelect = ["id" => "heure-debut-jeudi"];
    private $heureDebutVendrediSelect = ["id" => "heure-debut-vendredi"];
    private $heureDebutSamediSelect = ["id" => "heure-debut-samedi"];
    private $heureDebutDimancheSelect = ["id" => "heure-debut-dimanche"];

    private $heureFinLundiSelect = ["id" => "heure-fin-lundi"];
    private $heureFinMardiSelect = ["id" => "heure-fin-mardi"];
    private $heureFinMercrediSelect = ["id" => "heure-fin-mercredi"];
    private $heureFinJeudiSelect = ["id" => "heure-fin-jeudi"];
    private $heureFinVendrediSelect = ["id" => "heure-fin-vendredi"];
    private $heureFinSamediSelect = ["id" => "heure-fin-samedi"];
    private $heureFinDimancheSelect = ["id" => "heure-fin-dimanche"];

    protected AcceptanceTester $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
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

    public function modifyActivites($paramaters)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::route($paramaters['id_patient']));

        $I->wantTo("Modifier les pathologies du patient");
        $I->selectOption($this->a_activite_anterieureRadio, $paramaters['a_activite_anterieure']);
        $I->waitPageLoad();
        if ($paramaters['a_activite_anterieure'] == "1") {
            $I->fillField($this->activite_anterieureFied, $paramaters['activite_anterieure']);
        }
        $I->selectOption($this->a_activite_autonomeRadio, $paramaters['a_activite_autonome']);
        $I->waitPageLoad();
        if ($paramaters['a_activite_autonome'] == "1") {
            $I->fillField($this->activite_physique_autonomeFied, $paramaters['activite_physique_autonome']);
        }
        $I->selectOption($this->a_activite_encadreeRadio, $paramaters['a_activite_encadree']);
        $I->waitPageLoad();
        if ($paramaters['a_activite_encadree'] == "1") {
            $I->fillField($this->activite_physique_encadreeFied, $paramaters['activite_physique_encadree']);
        }
        $I->selectOption($this->a_activite_envisageeRadio, $paramaters['a_activite_envisagee']);
        $I->waitPageLoad();
        if ($paramaters['a_activite_envisagee'] == "1") {
            $I->fillField($this->activite_envisageeFied, $paramaters['activite_envisagee']);
        }
        $I->selectOption($this->a_activite_freinRadio, $paramaters['a_activite_frein']);
        $I->waitPageLoad();
        if ($paramaters['a_activite_frein'] == "1") {
            $I->fillField($this->frein_activiteFied, $paramaters['frein_activite']);
        }
        $I->selectOption($this->a_activite_point_fort_levierRadio, $paramaters['a_activite_point_fort_levier']);
        $I->waitPageLoad();
        if ($paramaters['a_activite_point_fort_levier'] == "1") {
            $I->fillField($this->point_fort_levierFied, $paramaters['point_fort_levier']);
        }

        if ($paramaters['est_dispo_lundi'] == "1") {
            $I->checkOption($this->jourLundiCheckbox);
            $I->waitPageLoad();
            $I->selectOption($this->heureDebutLundiSelect, $paramaters['heure_debut_lundi']);
            $I->selectOption($this->heureFinLundiSelect, $paramaters['heure_fin_lundi']);
        } else {
            $I->uncheckOption($this->jourLundiCheckbox);
        }
        if ($paramaters['est_dispo_mardi'] == "1") {
            $I->checkOption($this->jourMardiCheckbox);
            $I->waitPageLoad();
            $I->selectOption($this->heureDebutMardiSelect, $paramaters['heure_debut_mardi']);
            $I->selectOption($this->heureFinMardiSelect, $paramaters['heure_fin_mardi']);
        } else {
            $I->uncheckOption($this->jourMardiCheckbox);
        }
        if ($paramaters['est_dispo_mercredi'] == "1") {
            $I->checkOption($this->jourMercrediCheckbox);
            $I->waitPageLoad();
            $I->selectOption($this->heureDebutMercrediSelect, $paramaters['heure_debut_mercredi']);
            $I->selectOption($this->heureFinMercrediSelect, $paramaters['heure_fin_mercredi']);
        } else {
            $I->uncheckOption($this->jourMercrediCheckbox);
        }
        if ($paramaters['est_dispo_jeudi'] == "1") {
            $I->checkOption($this->jourJeudiCheckbox);
            $I->waitPageLoad();
            $I->selectOption($this->heureDebutJeudiSelect, $paramaters['heure_debut_jeudi']);
            $I->selectOption($this->heureFinJeudiSelect, $paramaters['heure_fin_jeudi']);
        } else {
            $I->uncheckOption($this->jourJeudiCheckbox);
        }
        if ($paramaters['est_dispo_vendredi'] == "1") {
            $I->checkOption($this->jourVendrediCheckbox);
            $I->waitPageLoad();
            $I->selectOption($this->heureDebutVendrediSelect, $paramaters['heure_debut_vendredi']);
            $I->selectOption($this->heureFinVendrediSelect, $paramaters['heure_fin_vendredi']);
        } else {
            $I->uncheckOption($this->jourVendrediCheckbox);
        }
        if ($paramaters['est_dispo_samedi'] == "1") {
            $I->checkOption($this->jourSamediCheckbox);
            $I->waitPageLoad();
            $I->selectOption($this->heureDebutSamediSelect, $paramaters['heure_debut_samedi']);
            $I->selectOption($this->heureFinSamediSelect, $paramaters['heure_fin_samedi']);
        } else {
            $I->uncheckOption($this->jourSamediCheckbox);
        }
        if ($paramaters['est_dispo_dimanche'] == "1") {
            $I->checkOption($this->jourDimancheCheckbox);
            $I->waitPageLoad();
            $I->selectOption($this->heureDebutDimancheSelect, $paramaters['heure_debut_dimanche']);
            $I->selectOption($this->heureFinDimancheSelect, $paramaters['heure_fin_dimanche']);
        } else {
            $I->uncheckOption($this->jourDimancheCheckbox);
        }

        $I->click($this->modifierPathologieButton);
        $I->waitPageLoad();
        $I->see("Activités physiques modifiées avec succès", $this->toast);
        $I->reloadPage();
        $I->waitPageLoad();

        $I->wantTo("Verifier les modifications");

        if ($paramaters['a_activite_anterieure'] == "1") {
            $I->seeOptionIsSelected($this->a_activite_anterieureRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_activite_anterieureRadio, "0");
            $I->assertEqualsIgnoringCase(
                $paramaters['activite_anterieure'],
                $I->grabValueFrom($this->activite_anterieureFied)
            );
        } else {
            $I->seeOptionIsSelected($this->a_activite_anterieureRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_activite_anterieureRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->activite_anterieureFied));
        }
        if ($paramaters['a_activite_autonome'] == "1") {
            $I->seeOptionIsSelected($this->a_activite_autonomeRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_activite_autonomeRadio, "0");
            $I->assertEqualsIgnoringCase(
                $paramaters['activite_physique_autonome'],
                $I->grabValueFrom($this->activite_physique_autonomeFied)
            );
        } else {
            $I->seeOptionIsSelected($this->a_activite_autonomeRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_activite_autonomeRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->activite_physique_autonomeFied));
        }
        if ($paramaters['a_activite_encadree'] == "1") {
            $I->seeOptionIsSelected($this->a_activite_encadreeRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_activite_encadreeRadio, "0");
            $I->assertEqualsIgnoringCase(
                $paramaters['activite_physique_encadree'],
                $I->grabValueFrom($this->activite_physique_encadreeFied)
            );
        } else {
            $I->seeOptionIsSelected($this->a_activite_encadreeRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_activite_encadreeRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->activite_physique_encadreeFied));
        }
        if ($paramaters['a_activite_envisagee'] == "1") {
            $I->seeOptionIsSelected($this->a_activite_envisageeRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_activite_envisageeRadio, "0");
            $I->assertEqualsIgnoringCase(
                $paramaters['activite_envisagee'],
                $I->grabValueFrom($this->activite_envisageeFied)
            );
        } else {
            $I->seeOptionIsSelected($this->a_activite_envisageeRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_activite_envisageeRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->activite_envisageeFied));
        }
        if ($paramaters['a_activite_frein'] == "1") {
            $I->seeOptionIsSelected($this->a_activite_freinRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_activite_freinRadio, "0");
            $I->assertEqualsIgnoringCase($paramaters['frein_activite'], $I->grabValueFrom($this->frein_activiteFied));
        } else {
            $I->seeOptionIsSelected($this->a_activite_freinRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_activite_freinRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->frein_activiteFied));
        }
        if ($paramaters['a_activite_point_fort_levier'] == "1") {
            $I->seeOptionIsSelected($this->a_activite_point_fort_levierRadio, "1");
            $I->dontSeeOptionIsSelected($this->a_activite_point_fort_levierRadio, "0");
            $I->assertEqualsIgnoringCase(
                $paramaters['point_fort_levier'],
                $I->grabValueFrom($this->point_fort_levierFied)
            );
        } else {
            $I->seeOptionIsSelected($this->a_activite_point_fort_levierRadio, "0");
            $I->dontSeeOptionIsSelected($this->a_activite_point_fort_levierRadio, "1");
            $I->assertEqualsIgnoringCase("", $I->grabValueFrom($this->point_fort_levierFied));
        }

        if ($paramaters['est_dispo_lundi'] == "1") {
            $I->seeCheckboxIsChecked($this->jourLundiCheckbox);
            $I->assertEquals($paramaters['heure_debut_lundi'], $I->grabValueFrom($this->heureDebutLundiSelect));
            $I->assertEquals($paramaters['heure_fin_lundi'], $I->grabValueFrom($this->heureFinLundiSelect));
        } else {
            $I->dontSeeCheckboxIsChecked($this->jourLundiCheckbox);
            $I->dontSeeElement($this->heureDebutLundiSelect);
            $I->dontSeeElement($this->heureFinLundiSelect);
        }
        if ($paramaters['est_dispo_mardi'] == "1") {
            $I->seeCheckboxIsChecked($this->jourMardiCheckbox);
            $I->assertEquals($paramaters['heure_debut_mardi'], $I->grabValueFrom($this->heureDebutMardiSelect));
            $I->assertEquals($paramaters['heure_fin_mardi'], $I->grabValueFrom($this->heureFinMardiSelect));
        } else {
            $I->dontSeeCheckboxIsChecked($this->jourMardiCheckbox);
            $I->dontSeeElement($this->heureDebutMardiSelect);
            $I->dontSeeElement($this->heureFinMardiSelect);
        }
        if ($paramaters['est_dispo_mercredi'] == "1") {
            $I->seeCheckboxIsChecked($this->jourMercrediCheckbox);
            $I->assertEquals($paramaters['heure_debut_mercredi'], $I->grabValueFrom($this->heureDebutMercrediSelect));
            $I->assertEquals($paramaters['heure_fin_mercredi'], $I->grabValueFrom($this->heureFinMercrediSelect));
        } else {
            $I->dontSeeCheckboxIsChecked($this->jourMercrediCheckbox);
            $I->dontSeeElement($this->heureDebutMercrediSelect);
            $I->dontSeeElement($this->heureFinMercrediSelect);
        }
        if ($paramaters['est_dispo_jeudi'] == "1") {
            $I->seeCheckboxIsChecked($this->jourJeudiCheckbox);
            $I->assertEquals($paramaters['heure_debut_jeudi'], $I->grabValueFrom($this->heureDebutJeudiSelect));
            $I->assertEquals($paramaters['heure_fin_jeudi'], $I->grabValueFrom($this->heureFinJeudiSelect));
        } else {
            $I->dontSeeCheckboxIsChecked($this->jourJeudiCheckbox);
            $I->dontSeeElement($this->heureDebutJeudiSelect);
            $I->dontSeeElement($this->heureFinJeudiSelect);
        }
        if ($paramaters['est_dispo_vendredi'] == "1") {
            $I->seeCheckboxIsChecked($this->jourVendrediCheckbox);
            $I->assertEquals($paramaters['heure_debut_vendredi'], $I->grabValueFrom($this->heureDebutVendrediSelect));
            $I->assertEquals($paramaters['heure_fin_vendredi'], $I->grabValueFrom($this->heureFinVendrediSelect));
        } else {
            $I->dontSeeCheckboxIsChecked($this->jourVendrediCheckbox);
            $I->dontSeeElement($this->heureDebutVendrediSelect);
            $I->dontSeeElement($this->heureFinVendrediSelect);
        }
        if ($paramaters['est_dispo_samedi'] == "1") {
            $I->seeCheckboxIsChecked($this->jourSamediCheckbox);
            $I->assertEquals($paramaters['heure_debut_samedi'], $I->grabValueFrom($this->heureDebutSamediSelect));
            $I->assertEquals($paramaters['heure_fin_samedi'], $I->grabValueFrom($this->heureFinSamediSelect));
        } else {
            $I->dontSeeCheckboxIsChecked($this->jourSamediCheckbox);
            $I->dontSeeElement($this->heureDebutSamediSelect);
            $I->dontSeeElement($this->heureFinSamediSelect);
        }
        if ($paramaters['est_dispo_dimanche'] == "1") {
            $I->seeCheckboxIsChecked($this->jourDimancheCheckbox);
            $I->assertEquals($paramaters['heure_debut_dimanche'], $I->grabValueFrom($this->heureDebutDimancheSelect));
            $I->assertEquals($paramaters['heure_fin_dimanche'], $I->grabValueFrom($this->heureFinDimancheSelect));
        } else {
            $I->dontSeeCheckboxIsChecked($this->jourDimancheCheckbox);
            $I->dontSeeElement($this->heureDebutDimancheSelect);
            $I->dontSeeElement($this->heureFinDimancheSelect);
        }
    }
}