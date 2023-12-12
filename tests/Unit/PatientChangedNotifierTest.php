<?php

namespace Tests\Unit;

use Doctrine\Common\EventManager;
use Dotenv\Dotenv;
use PDO;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\PatientChangedNotifier;
use Tests\Support\UnitTester;

class PatientChangedNotifierTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private PDO $pdo;

    private string $root = __DIR__ . '/../..';

    protected function _before()
    {
        $this->pdo = $this->getModule('Db')->_getDbh();

        $dotenv = Dotenv::createImmutable($this->root);
        $dotenv->load();
        $dotenv->required([
            'ENVIRONNEMENT',
            'VERSION',
            'DATE',
            'KEY',
        ]);
    }

    protected function _after()
    {
    }

    public function testOnEvaluateurChangedOk()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['1'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => false,
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_destinataire' => '3',
            'id_patient' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onEvaluateurChanged, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before + 1, $notifications_count_after);
    }

    public function testOnEvaluateurChangedNotOkArgsId_destinataireNull()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['1'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => false,
        ];

        $args = [
            'id_destinataire' => null,
            'id_patient' => '1'
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs($args);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onEvaluateurChanged, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnEvaluateurChangedNotOkArgsId_patientNull()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['1'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => false,
        ];

        $args = [
            'id_destinataire' => '3',
            'id_patient' => null
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs($args);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onEvaluateurChanged, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnAntenneChangedOk1()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['1'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => false,
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_antenne' => '1',
            'id_patient' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onAntenneChanged, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 responsables structures dans l'antenne 1
        $this->assertEquals($notifications_count_before + 2, $notifications_count_after);
    }

    public function testOnAntenneChangedOk2()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['1'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => false,
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_antenne' => '2',
            'id_patient' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onAntenneChanged, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 0 responsables structures dans l'antenne 1
        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnAntenneChangedNotOkArgsId_antenneNull()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['1'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => false,
        ];

        $args = [
            'id_antenne' => null,
            'id_patient' => '1'
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs($args);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onAntenneChanged, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnAntenneChangedNotOkArgsId_patientNull()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['1'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => false,
        ];

        $args = [
            'id_antenne' => '1',
            'id_patient' => null
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs($args);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onAntenneChanged, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnPatientCreatedNotOkId_patientNull()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => null,
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnPatientCreatedNotOkEst_non_pepsNull()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => "1",
            'est_non_peps' => null
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnPatientCreatedOkCoordinateurPepsStructureMss()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        // il y a 2 responsables structure  dans la struture id=1
        $this->assertEquals($notifications_count_before + 3, $notifications_count_after);
    }

    public function testOnPatientCreatedOkCoordinateurPepsStructureSportive()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        // il y a 2 responsables structure  dans la struture id=1
        $this->assertEquals($notifications_count_before + 3, $notifications_count_after);
    }

    public function testOnPatientCreatedOkCoordinateurPepsStructureCentrePeps()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "4", // centre PEPS
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 responsables structure  dans la struture id=1
        $this->assertEquals($notifications_count_before + 2, $notifications_count_after);
    }

    public function testOnPatientCreatedOkEvaluateur()
    {
        $session = [
            'id_user' => '2',
            'role_user_ids' => ['5'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        // il y a 2 responsables structure  dans la struture id=1
        $this->assertEquals($notifications_count_before + 5, $notifications_count_after);
    }

    public function testOnPatientCreatedOkEvaluateurPatientNonPeps()
    {
        $session = [
            'id_user' => '2',
            'role_user_ids' => ['5'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'checked'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        // il y a 2 responsables structure  dans la struture id=1
        $this->assertEquals($notifications_count_before + 3, $notifications_count_after);
    }

    public function testOnPatientCreatedOkCoordinateurMssStructureMss()
    {
        // coordinateur MSS
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        // il y a 2 responsables structure dans la struture id=1
        $this->assertEquals($notifications_count_before + 4, $notifications_count_after);
    }

    public function testOnPatientCreatedOkCoordinateurMssStructureMssPatientNonPeps()
    {
        // coordinateur MSS
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'checked'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 responsables structure dans la struture id=1
        $this->assertEquals($notifications_count_before + 2, $notifications_count_after);
    }

    public function testOnPatientCreatedOkResponsableStructureStructureMss()
    {
        // responsable structure
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['6'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        $this->assertEquals($notifications_count_before + 3, $notifications_count_after);
    }

    public function testOnPatientCreatedOkResponsableStructureStructureMssPatientNonPeps()
    {
        // responsable structure
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['6'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'checked'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        $this->assertEquals($notifications_count_before + 1, $notifications_count_after);
    }

    public function testOnPatientCreatedOkResponsableStructureStructureSportive()
    {
        // responsable structure
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['6'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        $this->assertEquals($notifications_count_before + 3, $notifications_count_after);
    }

    public function testOnPatientCreatedOkResponsableStructureStructureSportivePatientNonPeps()
    {
        // responsable structure
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['6'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'checked'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        $this->assertEquals($notifications_count_before + 1, $notifications_count_after);
    }

    public function testOnPatientCreatedOkCoordinateurStructureNonMssStructureSportive()
    {
        // coordinateur structure non-mss
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        // il y a 2 responsables structure dans la struture id=1
        $this->assertEquals($notifications_count_before + 4, $notifications_count_after);
    }

    public function testOnPatientCreatedOkCoordinateurStructureNonMssStructureSportivePatientNonPeps()
    {
        // coordinateur structure non-mss
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'checked'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 responsables structure dans la struture id=1
        $this->assertEquals($notifications_count_before + 2, $notifications_count_after);
    }

    public function testOnPatientArchivedNotOkId_patientNull()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => null,
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientArchived, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnPatientArchivedNotOkEst_non_pepsNull()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => "1",
            'est_non_peps' => null
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientArchived, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnPatientArchivedOkCoordinateurPepsStructureMss()
    {
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientArchived, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        $this->assertEquals($notifications_count_before + 1, $notifications_count_after);
    }

    public function testOnPatientArchivedOkEvaluateur()
    {
        $session = [
            'id_user' => '2',
            'role_user_ids' => ['5'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientArchived, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        $this->assertEquals($notifications_count_before + 3, $notifications_count_after);
    }

    public function testOnPatientArchiveddOkEvaluateurPatientNonPeps()
    {
        $session = [
            'id_user' => '2',
            'role_user_ids' => ['5'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'checked'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientArchived, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 1 coordinateur MSS ou structure sportive dans la struture id=1
        $this->assertEquals($notifications_count_before + 1, $notifications_count_after);
    }

    public function testOnPatientArchivedOkCoordinateurMssStructureMss()
    {
        // coordinateur MSS
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'NON'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientArchived, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        $this->assertEquals($notifications_count_before + 2, $notifications_count_after);
    }

    public function testOnPatientArchivedOkCoordinateurMssStructureMssPatientNonPeps()
    {
        // coordinateur MSS
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'est_non_peps' => 'checked'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPatientArchived, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnAffectationCreneauOk()
    {
        // coordinateur structure non-mss
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onAffectationCreneau, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // le patient a été ajouté à 2 créneaux dans la même structure (id=1)
        // les 2 créneaux ont un intervenant différent (1 seul est utilisateur)
        // il y a 2 responsables structure dans la struture id=1
        $this->assertEquals($notifications_count_before + 5, $notifications_count_after);
    }

    public function testOnEvaluationLateNotOkId_patientNull()
    {
        $session = [];
        $id_patient = null;

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => $id_patient,
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onEvaluationLate, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnEvaluationLateOk()
    {
        $session = [];
        $id_patient = '1';

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => $id_patient,
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onEvaluationLate, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before + 1, $notifications_count_after);
    }

    public function testOnPartageDossierOk()
    {
        $session = [
            'id_user' => '2',
            'role_user_ids' => ['2'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => true,
        ];
        $id_patient = "7";
        $id_user = "11";

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => $id_patient,
            'id_destinataire' => $id_user
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPartageDossier, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before + 1, $notifications_count_after);
    }

    public function testOnPartageDossierNotOkId_PatientMissing()
    {
        $session = [
            'id_user' => '2',
            'role_user_ids' => ['2'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => true,
        ];
        $id_patient = null;
        $id_user = "11";

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => $id_patient,
            'id_destinataire' => $id_user
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPartageDossier, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnPartageDossierNotOkId_UserMissing()
    {
        $session = [
            'id_user' => '2',
            'role_user_ids' => ['2'],
            'id_statut_structure' => null,
            'est_coordinateur_peps' => true,
        ];
        $id_patient = "7";
        $id_user = null;

        $eventManager = new EventManager();
        $patientChangedNotifier = new PatientChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => $id_patient,
            'id_destinataire' => $id_user
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(PatientChangedNotifier::onPartageDossier, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }
}