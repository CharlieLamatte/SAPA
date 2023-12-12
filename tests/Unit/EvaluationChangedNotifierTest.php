<?php

namespace Tests\Unit;

use Doctrine\Common\EventManager;
use Dotenv\Dotenv;
use PDO;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\EvaluationChangedNotifier;
use Tests\Support\UnitTester;

class EvaluationChangedNotifierTest extends \Codeception\Test\Unit
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

    public function testOnEvaluationCreatedNotOkId_patientNull()
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
        $evaluationChangedNotifier = new EvaluationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => null,
            'id_evaluation' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(EvaluationChangedNotifier::onEvaluationCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnEvaluationCreatedNotOkId_evaluationNull()
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
        $evaluationChangedNotifier = new EvaluationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'id_evaluation' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(EvaluationChangedNotifier::onEvaluationCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnEvaluationCreatedOkCoordinateurPepsStructureMss()
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
        $evaluationChangedNotifier = new EvaluationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'id_evaluation' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(EvaluationChangedNotifier::onEvaluationCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        // mais pas de notifs doivent être créées
        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnEvaluationCreatedOkCoordinateurPepsStructureSportive()
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
        $evaluationChangedNotifier = new EvaluationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'id_evaluation' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(EvaluationChangedNotifier::onEvaluationCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        // mais pas de notifs doivent être créées
        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnEvaluationCreatedOkCoordinateurPepsStructureCentrePeps()
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
        $evaluationChangedNotifier = new EvaluationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'id_evaluation' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(EvaluationChangedNotifier::onEvaluationCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        // mais pas de notifs doivent être créées
        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnEvaluationCreatedOkCoordinateurMssStructureMss()
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
        $evaluationChangedNotifier = new EvaluationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'id_evaluation' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(EvaluationChangedNotifier::onEvaluationCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        $this->assertEquals($notifications_count_before + 2, $notifications_count_after);
    }

    public function testOnEvaluationCreatedOkResponsableStructureStructureMss()
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
        $evaluationChangedNotifier = new EvaluationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'id_evaluation' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(EvaluationChangedNotifier::onEvaluationCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        $this->assertEquals($notifications_count_before + 2, $notifications_count_after);
    }

    public function testOnEvaluationCreatedOkResponsableStructureStructureSportive()
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
        $evaluationChangedNotifier = new EvaluationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'id_evaluation' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(EvaluationChangedNotifier::onEvaluationCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        $this->assertEquals($notifications_count_before + 2, $notifications_count_after);
    }

    public function testOnEvaluationCreatedOkCoordinateurStructureNonMssStructureSportive()
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
        $evaluationChangedNotifier = new EvaluationChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_patient' => '1',
            'id_evaluation' => '1'
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(EvaluationChangedNotifier::onEvaluationCreated, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 coordinateurs PEPS dans le territoire id=1
        $this->assertEquals($notifications_count_before + 2, $notifications_count_after);
    }
}