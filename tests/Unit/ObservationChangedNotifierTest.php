<?php

namespace Sportsante86\Sapa\tests\Unit;

use Doctrine\Common\EventManager;
use Dotenv\Dotenv;
use PDO;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\ObservationChangedNotifier;
use Tests\Support\UnitTester;

class ObservationChangedNotifierTest extends \Codeception\Test\Unit
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

    public function testOnObservationSanteCreatedNotOkId_patientNull()
    {
        $session = [
            'id_user' => '2',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $observationChangedNotifier = new ObservationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => null,
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(ObservationChangedNotifier::onObservationSanteCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnObservationSanteCreatedOkCoordinateurPeps()
    {
        $session = [
            'id_user' => '2',
            'role_user_ids' => ['2'],
            'id_statut_structure' => "1", // MSS
            'est_coordinateur_peps' => true,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $observationChangedNotifier = new ObservationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => "1",
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(ObservationChangedNotifier::onObservationSanteCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $expected_count = $notifications_count_before
            + 1 // il y a 2 coordinateurs PEPS dans le territoire id=1 (mais il y en il y en a un qui a l'id_user=2)
            + 2 // il y a 2 intervenants user qui suivent id_patient=1
            + 2; // il y a 2 responsables structure PEPS dans id_structure=1
        $this->assertEquals($expected_count, $notifications_count_after);
    }

    public function testOnObservationSanteCreatedOkResponsableStructure()
    {
        $session = [
            'id_user' => '8',
            'role_user_ids' => ['6'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $observationChangedNotifier = new ObservationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => "1",
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(ObservationChangedNotifier::onObservationSanteCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $expected_count = $notifications_count_before
            + 2 // il y a 2 coordinateurs PEPS dans le territoire id=1
            + 2 // il y a 2 intervenants user qui suivent id_patient=1
            + 1; // il y a 2 responsables structure PEPS dans id_structure=1 (mais il y en il y en a un qui a l'id_user=8)
        $this->assertEquals($expected_count, $notifications_count_after);
    }

    public function testOnObservationSanteCreatedOkIntervenant()
    {
        $session = [
            'id_user' => '3',
            'role_user_ids' => ['3'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $observationChangedNotifier = new ObservationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => "1",
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(ObservationChangedNotifier::onObservationSanteCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $expected_count = $notifications_count_before
            + 2 // il y a 2 coordinateurs PEPS dans le territoire id=1
            + 1 // il y a 2 intervenant user qui suiventt id_patient=1 (mais il y en il y en a un qui a l'id_user=3)
            + 2; // il y a 2 responsables structure PEPS dans id_structure=1
        $this->assertEquals($expected_count, $notifications_count_after);
    }

    public function testOnObservationSanteCreatedOkEvaluateur()
    {
        $session = [
            'id_user' => '7',
            'role_user_ids' => ['5'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $observationChangedNotifier = new ObservationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => "1",
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(ObservationChangedNotifier::onObservationSanteCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $expected_count = $notifications_count_before
            + 2 // il y a 2 coordinateurs PEPS dans le territoire id=1
            + 2 // il y a 2 intervenants user qui suivent id_patient=1
            + 2; // il y a 2 responsables structure PEPS dans id_structure=1
        $this->assertEquals($expected_count, $notifications_count_after);
    }
}