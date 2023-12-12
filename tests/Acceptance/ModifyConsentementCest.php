<?php

namespace Sportsante86\Sapa\tests\Acceptance;

use Faker\Factory;
use Sportsante86\Sapa\tests\Support\Page\Acceptance\HeaderPatient;
use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\Login;

class ModifyConsentementCest
{
    private $faker;

    public function _before(AcceptanceTester $I)
    {
        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(435);
    }

    public function modifyConsentementAsAdmin(
        AcceptanceTester $I,
        Login $loginPage,
        HeaderPatient $headerPatient
    ) {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');

        $id_patient = "1";

        // AccueilPatient
        $baseUrl = "/PHP/Patients/AccueilPatient.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // modifbenef
        $baseUrl = "/PHP/Patients/modifbenef.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifAutresInfos
        $baseUrl = "/PHP/Patients/ModifAutresInfos.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // modifmed
        $baseUrl = "/PHP/Patients/modifmed.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Prescription
        $baseUrl = "/PHP/Patients/Prescription.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // PrescriptionModif
        $baseUrl = "/PHP/Patients/PrescriptionModif.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&idPrescription=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Sante
        $baseUrl = "/PHP/Patients/Sante.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Activité Physique
        $baseUrl = "/PHP/Patients/Ap.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Evaluation
        $baseUrl = "/PHP/Patients/Evaluation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // AjoutEvaluation
        $baseUrl = "/PHP/Patients/AjoutEvaluation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifEval
        $baseUrl = "/PHP/Patients/ModifEval.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&id_eval=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Questionnaires
        $baseUrl = "/PHP/Patients/Questionnaires.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifierQuestionnaire
        $baseUrl = "/PHP/Patients/ModifierQuestionnaire.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&id_questionnaire_instance=7&id_questionnaire=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Objectifs
        $baseUrl = "/PHP/Patients/Objectifs.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Orientation
        $baseUrl = "/PHP/Patients/Orientation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Suivi
        $baseUrl = "/PHP/Patients/Suivi.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Synthese
        $baseUrl = "/PHP/Patients/Synthese.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Progression
        $baseUrl = "/PHP/Patients/Progression.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);
    }

    public function modifyConsentementAsCoordonnateurPeps(
        AcceptanceTester $I,
        Login $loginPage,
        HeaderPatient $headerPatient
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');

        $id_patient = "7";

        // AccueilPatient
        $baseUrl = "/PHP/Patients/AccueilPatient.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // modifbenef
        $baseUrl = "/PHP/Patients/modifbenef.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifAutresInfos
        $baseUrl = "/PHP/Patients/ModifAutresInfos.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // modifmed
        $baseUrl = "/PHP/Patients/modifmed.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Prescription
        $baseUrl = "/PHP/Patients/Prescription.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // PrescriptionModif
        $baseUrl = "/PHP/Patients/PrescriptionModif.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&idPrescription=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Sante
        $baseUrl = "/PHP/Patients/Sante.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Activité Physique
        $baseUrl = "/PHP/Patients/Ap.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Evaluation
        $baseUrl = "/PHP/Patients/Evaluation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // AjoutEvaluation
        $baseUrl = "/PHP/Patients/AjoutEvaluation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifEval
        $baseUrl = "/PHP/Patients/ModifEval.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&id_eval=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Questionnaires
        $baseUrl = "/PHP/Patients/Questionnaires.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifierQuestionnaire
        $baseUrl = "/PHP/Patients/ModifierQuestionnaire.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&id_questionnaire_instance=7&id_questionnaire=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Objectifs
        $baseUrl = "/PHP/Patients/Objectifs.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Orientation
        $baseUrl = "/PHP/Patients/Orientation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Suivi
        $baseUrl = "/PHP/Patients/Suivi.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Synthese
        $baseUrl = "/PHP/Patients/Synthese.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Progression
        $baseUrl = "/PHP/Patients/Progression.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);
    }

    public function modifyConsentementAsCoordonnateurStructureNonMss(
        AcceptanceTester $I,
        Login $loginPage,
        HeaderPatient $headerPatient
    ) {
        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');

        $id_patient = "12";

        // AccueilPatient
        $baseUrl = "/PHP/Patients/AccueilPatient.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // modifbenef
        $baseUrl = "/PHP/Patients/modifbenef.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifAutresInfos
        $baseUrl = "/PHP/Patients/ModifAutresInfos.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // modifmed
        $baseUrl = "/PHP/Patients/modifmed.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Prescription
        $baseUrl = "/PHP/Patients/Prescription.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // PrescriptionModif
        $baseUrl = "/PHP/Patients/PrescriptionModif.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&idPrescription=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Sante
        $baseUrl = "/PHP/Patients/Sante.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Activité Physique
        $baseUrl = "/PHP/Patients/Ap.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Evaluation
        $baseUrl = "/PHP/Patients/Evaluation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // AjoutEvaluation
        $baseUrl = "/PHP/Patients/AjoutEvaluation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifEval
        $baseUrl = "/PHP/Patients/ModifEval.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&id_eval=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Questionnaires
        $baseUrl = "/PHP/Patients/Questionnaires.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifierQuestionnaire
        $baseUrl = "/PHP/Patients/ModifierQuestionnaire.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&id_questionnaire_instance=7&id_questionnaire=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Objectifs
        $baseUrl = "/PHP/Patients/Objectifs.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Suivi
        $baseUrl = "/PHP/Patients/Suivi.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Progression
        $baseUrl = "/PHP/Patients/Progression.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);
    }

    public function modifyConsentementAsCoordonnateurMss(
        AcceptanceTester $I,
        Login $loginPage,
        HeaderPatient $headerPatient
    ) {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');

        $id_patient = "8";

        // AccueilPatient
        $baseUrl = "/PHP/Patients/AccueilPatient.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // modifbenef
        $baseUrl = "/PHP/Patients/modifbenef.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifAutresInfos
        $baseUrl = "/PHP/Patients/ModifAutresInfos.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // modifmed
        $baseUrl = "/PHP/Patients/modifmed.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Prescription
        $baseUrl = "/PHP/Patients/Prescription.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // PrescriptionModif
        $baseUrl = "/PHP/Patients/PrescriptionModif.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&idPrescription=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Sante
        $baseUrl = "/PHP/Patients/Sante.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Activité Physique
        $baseUrl = "/PHP/Patients/Ap.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Evaluation
        $baseUrl = "/PHP/Patients/Evaluation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // AjoutEvaluation
        $baseUrl = "/PHP/Patients/AjoutEvaluation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifEval
        $baseUrl = "/PHP/Patients/ModifEval.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&id_eval=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Questionnaires
        $baseUrl = "/PHP/Patients/Questionnaires.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifierQuestionnaire
        $baseUrl = "/PHP/Patients/ModifierQuestionnaire.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&id_questionnaire_instance=7&id_questionnaire=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Objectifs
        $baseUrl = "/PHP/Patients/Objectifs.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Orientation
        $baseUrl = "/PHP/Patients/Orientation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Suivi
        $baseUrl = "/PHP/Patients/Suivi.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Synthese
        $baseUrl = "/PHP/Patients/Synthese.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Progression
        $baseUrl = "/PHP/Patients/Progression.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);
    }

    public function modifyConsentementAsEvaluateur(
        AcceptanceTester $I,
        Login $loginPage,
        HeaderPatient $headerPatient
    ) {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');

        $id_patient = "8";

        // AccueilPatient
        $baseUrl = "/PHP/Patients/AccueilPatient.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // modifbenef
        $baseUrl = "/PHP/Patients/modifbenef.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifAutresInfos
        $baseUrl = "/PHP/Patients/ModifAutresInfos.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // modifmed
        $baseUrl = "/PHP/Patients/modifmed.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Prescription
        $baseUrl = "/PHP/Patients/Prescription.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // PrescriptionModif
        $baseUrl = "/PHP/Patients/PrescriptionModif.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&idPrescription=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Sante
        $baseUrl = "/PHP/Patients/Sante.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Activité Physique
        $baseUrl = "/PHP/Patients/Ap.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Evaluation
        $baseUrl = "/PHP/Patients/Evaluation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // AjoutEvaluation
        $baseUrl = "/PHP/Patients/AjoutEvaluation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifEval
        $baseUrl = "/PHP/Patients/ModifEval.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&id_eval=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Questionnaires
        $baseUrl = "/PHP/Patients/Questionnaires.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // ModifierQuestionnaire
        $baseUrl = "/PHP/Patients/ModifierQuestionnaire.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient . "&id_questionnaire_instance=7&id_questionnaire=1");
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Objectifs
        $baseUrl = "/PHP/Patients/Objectifs.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Orientation
        $baseUrl = "/PHP/Patients/Orientation.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Suivi
        $baseUrl = "/PHP/Patients/Suivi.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Synthese
        $baseUrl = "/PHP/Patients/Synthese.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);

        // Progression
        $baseUrl = "/PHP/Patients/Progression.php?idPatient=";
        $I->amOnPage($baseUrl . $id_patient);
        $headerPatient->modifyConsentement("0", $baseUrl);
        $headerPatient->modifyConsentement("1", $baseUrl);
        $headerPatient->modifyConsentement("attente", $baseUrl);
    }
}