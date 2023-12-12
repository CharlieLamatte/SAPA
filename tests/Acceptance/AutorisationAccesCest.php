<?php

namespace Tests\Acceptance;

use Sportsante86\Sapa\Outils\FilesManager;
use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\Login;

class AutorisationAccesCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    //
    // Page Accueil
    //

    public function pageAccueilAdmin(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');
        $I->seeInCurrentUrl('/PHP/Settings/TableauDeBord.php');
        $I->see('Bonjour PrenomAdmin NOMADMIN');
        $I->see('Informations territoires');
        $I->seeElement('a[id=accueil-link]');
        $I->seeElement('a[id=administration-link]');
    }

    public function pageAccueilCoordoPeps(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        $I->see('Bonjour Prenomcoordo1 NOMCOORDO1');
        $I->seeElement('a[id=accueil-link]');
        $I->seeElement('a[id=administration-link]');
    }

    public function pageAccueilCoordoMss(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        $I->see('Bonjour PrénomCoordonnateurMSSAbc NOMCOORDONNATEURMSSABC');
        $I->seeElement('a[id=accueil-link]');
        $I->seeElement('a[id=administration-link]');
    }

    public function pageAccueilReferent(AcceptanceTester $I, Login $loginPage)
    {
//        $loginPage->login('testReferentAbc@gmail.com', 'testReferentAbc@1d');
//        $I->amOnPage('/PHP/Accueil_liste.php');
//        $I->waitPageLoad();
//        $I->see("Vous n'avez pas la permission d'accéder à cette page.");
        // TODO
    }

    public function pageAccueilIntervenant(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testIntervenantAbc@gmail.com', 'testIntervenantAbc@1d');
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        $I->see('Bonjour TestIntervenantAbcPrénom TESTINTERVENANTABCNOM');
        $I->seeElement('a[id=accueil-link]');
        $I->seeElement('a[id=administration-link]');
    }

    public function pageAccueilEvaluateur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        $I->see('Bonjour testEvaluateurPrenom TESTEVALUATEURNOM');
        $I->see('Évaluateur PEPS');
        $I->seeElement('a[id=accueil-link]');
        $I->seeElement('a[id=administration-link]');
    }

    public function pageAccueilResponsableStructure(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testResponsableStructureNom@sportsante86.fr', 'testResponsableStructureNom1.1@A');
        $I->seeInCurrentUrl('/PHP/ResponsableStructure/Accueil.php');
        $I->see('Bonjour testResponsableStructurePrenom TESTRESPONSABLESTRUCTURENOM');
        $I->see('Role : Responsable Structure');
        $I->seeElement('a[id=accueil-link]');
        $I->seeElement('a[id=administration-link]');
    }

    public function pageAccueilSuperviseur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testSuperviseurNom@sportsante86.fr', 'testAdmin1.1@A');
        $I->seeInCurrentUrl('/PHP/Settings/TableauDeBord.php');
        $I->see('Bonjour testsuperviseurnom TESSUPERVISEURNOM');
        $I->see('Role : Superviseur PEPS');
        $I->dontSee('a[id=accueil-link]');
        $I->seeElement('a[id=administration-link]');
    }

    public function pageAccueilSecretaire(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestSecretaireNom@sportsante86.fr', 'TestSecretaireNom.1@A');
        $I->seeInCurrentUrl('/PHP/Accueil_liste.php');
        $I->see('Bonjour TestSecretairePrenom TESTSECRETAIRENOM');
        $I->see('Role : Secrétaire');
        $I->seeElement('a[id=accueil-link]');
        $I->seeElement('a[id=administration-link]');
    }

    public function ongletsPatientAdmin(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');

        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Prescription.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Evaluation.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Questionnaires.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Objectifs.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Suivi.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Synthese.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Progression.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function ongletsPatientCoordoPeps(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');

        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Prescription.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Evaluation.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Questionnaires.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Objectifs.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Suivi.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Synthese.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Progression.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function ongletsPatientCoordoMss(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');

        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Prescription.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Evaluation.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Questionnaires.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Objectifs.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Suivi.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Synthese.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Progression.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function ongletsPatientIntervenant(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testIntervenantAbc@gmail.com', 'testIntervenantAbc@1d');

        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Prescription.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Evaluation.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Questionnaires.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Objectifs.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Suivi.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Synthese.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Progression.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function ongletsPatientEvaluateur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');

        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Prescription.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Evaluation.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Questionnaires.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Objectifs.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Suivi.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Synthese.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Progression.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->seeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->seeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->seeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->seeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function ongletsPatientResponsableStructure(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testResponsableStructureNom@sportsante86.fr', 'testResponsableStructureNom1.1@A');

        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->dontSeeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Prescription.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->dontSeeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->dontSeeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Evaluation.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Questionnaires.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->dontSeeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Objectifs.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->dontSeeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Suivi.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->dontSeeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Synthese.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Progression.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->seeElement('a[id=sante-link]');
        $I->seeElement('a[id=activite-physique-link]');
        $I->dontSeeElement('a[id=evaluation-link]');
        $I->seeElement('a[id=questionnaires-link]');
        $I->seeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->seeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->seeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function ongletsPatientSuperviseur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testSuperviseurNom@sportsante86.fr', 'testAdmin1.1@A');

        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Prescription.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Evaluation.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Questionnaires.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Objectifs.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Suivi.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Synthese.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Progression.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function ongletsPatientSecretaire(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestSecretaireNom@sportsante86.fr', 'TestSecretaireNom.1@A');

        $I->amOnPage('/PHP/Patients/AccueilPatient.php?idPatient=7');
        $I->waitPageLoad();
        $I->seeElement('a[id=accueil-patient-link]');
        $I->dontSeeElement('a[id=prescription-link]');
        $I->dontSeeElement('a[id=sante-link]');
        $I->dontSeeElement('a[id=activite-physique-link]');
        $I->dontSeeElement('a[id=evaluation-link]');
        $I->dontSeeElement('a[id=questionnaires-link]');
        $I->dontSeeElement('a[id=objectifs-link]');
        $I->dontSeeElement('a[id=orientation-link]');
        $I->dontSeeElement('a[id=programme-link]');
        $I->dontSeeElement('a[id=synthese-link]');
        $I->dontSeeElement('a[id=progression-link]');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Prescription.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Sante.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Ap.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Evaluation.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Questionnaires.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Objectifs.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Orientation.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Suivi.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Synthese.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Patients/Progression.php?idPatient=7');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageExportAdmin(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');

        $I->amOnPage('/PHP/Export/ExportStats.php');
        $I->waitPageLoad();
        $I->see('Export des données ONAPS');
        $I->dontSee('Export données médecins prescripteurs');
        $I->see('Export données bénéficiaires');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageExportCoordoPeps(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');

        $I->amOnPage('/PHP/Export/ExportStats.php');
        $I->waitPageLoad();
        $I->see('Export des données ONAPS');
        $I->see('Export données médecins prescripteurs');
        $I->see('Export données bénéficiaires');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageExportCoordoMss(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');

        $I->amOnPage('/PHP/Export/ExportStats.php');
        $I->waitPageLoad();
        $I->see('Export des données ONAPS');
        $I->see('Export données médecins prescripteurs');
        $I->see('Export données bénéficiaires');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageExportCoordoNonMss(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');

        $I->amOnPage('/PHP/Export/ExportStats.php');
        $I->waitPageLoad();
        $I->see('Export des données ONAPS');
        $I->see('Export données médecins prescripteurs');
        $I->see('Export données bénéficiaires');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageExportIntervenant(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testIntervenantAbc@gmail.com', 'testIntervenantAbc@1d');

        $I->amOnPage('/PHP/Export/ExportStats.php');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageExportEvaluateur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');

        $I->amOnPage('/PHP/Export/ExportStats.php');
        $I->waitPageLoad();
        $I->see('Export des données ONAPS');
        $I->see('Export données médecins prescripteurs');
        $I->see('Export données bénéficiaires');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageExportResponsableStructure(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testResponsableStructureNom@sportsante86.fr', 'testResponsableStructureNom1.1@A');

        $I->amOnPage('/PHP/Export/ExportStats.php');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageExportSuperviseur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testSuperviseurNom@sportsante86.fr', 'testAdmin1.1@A');

        $I->amOnPage('/PHP/Export/ExportStats.php');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageExportSecretaire(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestSecretaireNom@sportsante86.fr', 'TestSecretaireNom.1@A');

        $I->amOnPage('/PHP/Export/ExportStats.php');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageSettingsPatientsAdmin(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->dontSeeElement(["id" => "boutonSettingsPatient"]);

        $I->amOnPage('/PHP/Patients/SettingsPatients.php');
        $I->dontSee('Bénéficiaires');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageSettingsPatientsCoordoPeps(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->seeElement(["id" => "boutonSettingsPatient"]);

        $I->amOnPage('/PHP/Patients/SettingsPatients.php');
        $I->waitPageLoad();
        $I->see('Bénéficiaires');
        $I->seeElement(["id" => "fusion-modal-patient"]);
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageSettingsPatientsCoordoMss(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->seeElement(["id" => "boutonSettingsPatient"]);

        $I->amOnPage('/PHP/Patients/SettingsPatients.php');
        $I->waitPageLoad();
        $I->see('Bénéficiaires');
        $I->seeElement(["id" => "fusion-modal-patient"]);
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageSettingsPatientsCoordoNonMss(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->dontSeeElement(["id" => "boutonSettingsPatient"]);

        $I->amOnPage('/PHP/Patients/SettingsPatients.php');
        $I->dontSee('Bénéficiaires');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageSettingsPatientsIntervenant(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testIntervenantAbc@gmail.com', 'testIntervenantAbc@1d');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->dontSeeElement(["id" => "boutonSettingsPatient"]);

        $I->amOnPage('/PHP/Patients/SettingsPatients.php');
        $I->dontSee('Bénéficiaires');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageSettingsPatientsEvaluateur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->dontSeeElement(["id" => "boutonSettingsPatient"]);

        $I->amOnPage('/PHP/Patients/SettingsPatients.php');
        $I->dontSee('Bénéficiaires');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageSettingsPatientsResponsableStructure(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testResponsableStructureNom@sportsante86.fr', 'testResponsableStructureNom1.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->dontSeeElement(["id" => "boutonSettingsPatient"]);

        $I->amOnPage('/PHP/Patients/SettingsPatients.php');
        $I->dontSee('Bénéficiaires');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageSettingsPatientsSuperviseur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testSuperviseurNom@sportsante86.fr', 'testAdmin1.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->dontSeeElement(["id" => "boutonSettingsPatient"]);

        $I->amOnPage('/PHP/Patients/SettingsPatients.php');
        $I->dontSee('Bénéficiaires');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageSettingsPatientsSecretaire(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestSecretaireNom@sportsante86.fr', 'TestSecretaireNom.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->dontSeeElement(["id" => "boutonSettingsPatient"]);

        $I->amOnPage('/PHP/Patients/SettingsPatients.php');
        $I->dontSee('Bénéficiaires');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageCreneauAdmin(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestAdmin@sportsante86.fr', 'testAdmin1.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->seeElement(["id" => "boutonCreneaux"]);
        $I->dontSeeElement(["id" => "mes-creneaux"]);

        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Creneaux/MesCreneaux.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageCreneauCoordoPeps(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->seeElement(["id" => "boutonCreneaux"]);
        $I->dontSeeElement(["id" => "mes-creneaux"]);

        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Creneaux/MesCreneaux.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageCreneauCoordoMss(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testCoordonnateurMSSAbc@gmail.com', 'testCoordonnateurMSSAbc@1d');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->seeElement(["id" => "boutonCreneaux"]);
        $I->dontSeeElement(["id" => "mes-creneaux"]);

        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Creneaux/MesCreneaux.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageCreneauCoordoNonMss(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testSupPatient@gmail.com', 'testCoordonnateurStructureNonMss@1d');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->seeElement(["id" => "boutonCreneaux"]);
        $I->dontSeeElement(["id" => "mes-creneaux"]);

        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Creneaux/MesCreneaux.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageCreneauIntervenant(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testIntervenantAbc@gmail.com', 'testIntervenantAbc@1d');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->dontSeeElement(["id" => "boutonCreneaux"]);
        $I->seeElement(["id" => "mes-creneaux"]);

        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Creneaux/MesCreneaux.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageCreneauEvaluateur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testEvaluateurNom@sportsante86.fr', 'testEvaluateurNom1.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->seeElement(["id" => "boutonCreneaux"]);
        $I->dontSeeElement(["id" => "mes-creneaux"]);

        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Creneaux/MesCreneaux.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageCreneauResponsableStructure(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testResponsableStructureNom@sportsante86.fr', 'testResponsableStructureNom1.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->seeElement(["id" => "boutonCreneaux"]);
        $I->dontSeeElement(["id" => "mes-creneaux"]);

        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->waitPageLoad();
        $I->see('Créneaux');
        $I->dontSee("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Creneaux/MesCreneaux.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageCreneauSuperviseur(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('testSuperviseurNom@sportsante86.fr', 'testAdmin1.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->dontSeeElement(["id" => "boutonCreneaux"]);
        $I->dontSeeElement(["id" => "mes-creneaux"]);

        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Creneaux/MesCreneaux.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function pageCreneauSecretaire(AcceptanceTester $I, Login $loginPage)
    {
        $loginPage->login('TestSecretaireNom@sportsante86.fr', 'TestSecretaireNom.1@A');

        $I->amOnPage('/PHP/Settings/Settings.php');
        $I->waitPageLoad();
        $I->dontSeeElement(["id" => "boutonCreneaux"]);
        $I->dontSeeElement(["id" => "mes-creneaux"]);

        $I->amOnPage('/PHP/Creneaux/ListeCreneau.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");

        $I->amOnPage('/PHP/Creneaux/MesCreneaux.php');
        $I->dontSee('Créneaux');
        $I->see("Vous n'avez pas la permission d'accéder à cette page");
    }

    public function testAllPageProtected(AcceptanceTester $I)
    {
        $directory = FilesManager::rootDirectory() . "/PHP";
        $files = FilesManager::find_all_files($directory);
        $urls = [];
        foreach ($files as $file) {
            $urls[] = str_replace(FilesManager::rootDirectory(), "", $file);
        }

        // TODO ces fichiers ne doivent plus être accessibles (sauf les fichiers js qui doivent déplacés
        // et le fichier de deconnexion
        $excluded = [
            // class
            "/PHP/Patients/Progression/ProgressionTestPhysio.php",
            // functions
            "/PHP/Settings/TableauDeBord/functions_tableau.php",
            // partial pages
            "/PHP/Creneaux/modalCreneau.php",
            "/PHP/FicheResume/parcours.php",
            "/PHP/Medecins/ModalMedecin.php",
            "/PHP/Mutuelles/modalMutuelle.php",
            "/PHP/ResponsableStructure/modal_responsable_structure.php",
            "/PHP/ResponsableStructure/tableau_seances.php",
            "/PHP/Seances/modalDetailsSeance.php",
            "/PHP/Structures/modalStructure.php",
            "/PHP/Users/modalUser.php",
            "/PHP/footer.php",
            "/PHP/header-accueil.php",
            "/PHP/header.php",
            "/PHP/header_index.php",
            "/PHP/header_settings.php",
            "/PHP/modalAjoutSeance.php",
            "/PHP/partials/notification_icon.php",
            "/PHP/partials/notification_icon.php",
            "/PHP/partials/warning_modal.php",
            "/PHP/tableau_beneficiaires.php",
            // js
            "/PHP/Patients/VerifForm.js",
            "/PHP/Patients/VerifFormModif.js",
            "/PHP/Patients/VerifSelectAjout.js",
            "/PHP/Patients/VerifSelectModif.js",
            "/PHP/Patients/toggleFormAjout.js",
            "/PHP/Patients/toggleFormModif.js",
            //page de deconnexion
            "/PHP/deconnexion.php",
            // pages de recuperation compte
            "/PHP/account_recovery/final.php",
            "/PHP/account_recovery/recover_account.php",
            "/PHP/account_recovery/step1.php",
        ];

        foreach ($urls as $url) {
            if (!in_array($url, $excluded)) {
                $I->amOnPage($url);
                $I->see("Vous ne pouvez pas ");
                $I->dontSee("Ignoring session_start()");
            }
        }
    }
}