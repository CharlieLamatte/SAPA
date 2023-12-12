<?php

namespace Tests\Unit;

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\SeanceChangedNotifier;
use Tests\Support\UnitTester;

class SeanceChangedNotifierTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private $pdo;

    protected function _before()
    {
        $this->pdo = $this->getModule('Db')->_getDbh();;
    }

    protected function _after()
    {
    }

    public function testOnSeanceCanceledNotOkIntervenantAndId_seanceNull()
    {
        // intervenant
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['3'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $seanceChangedNotifier = new SeanceChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_seance' => null,
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(SeanceChangedNotifier::onSeanceCanceled, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnSeanceCanceledOkIntervenantStructureSansResponsables()
    {
        // intervenant
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['3'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $id_seance = '1';
        // cette seance est dans la structure 4 (0 responsable)

        $eventManager = new EventManager();
        $seanceChangedNotifier = new SeanceChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_seance' => $id_seance,
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(SeanceChangedNotifier::onSeanceCanceled, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnSeanceCanceledOkIntervenantStructureAvecResponsables()
    {
        // intervenant
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['3'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $id_seance = '2';
        // cette seance est dans la structure 1 (2 responsable)

        $eventManager = new EventManager();
        $seanceChangedNotifier = new SeanceChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_seance' => $id_seance,
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(SeanceChangedNotifier::onSeanceCanceled, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // il y a 2 responsables structure dans la struture id=1
        $this->assertEquals($notifications_count_before + 2, $notifications_count_after);
    }

    public function testOnSeanceCanceledOkResponsableStructure()
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
        $seanceChangedNotifier = new SeanceChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_seance' => '1',
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(SeanceChangedNotifier::onSeanceCanceled, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // pas de notification envoyée
        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnSeanceCanceledOkEvaluateur()
    {
        // evaluateur
        $session = [
            'id_user' => '1',
            'role_user_ids' => ['5'],
            'id_statut_structure' => "3", // structure sportive
            'est_coordinateur_peps' => false,
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $eventManager = new EventManager();
        $seanceChangedNotifier = new SeanceChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_seance' => '1',
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(SeanceChangedNotifier::onSeanceCanceled, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        // pas de notification envoyée
        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnSeanceEmargementLateNotOkId_seanceNull()
    {
        $session = [];
        $id_seance = null;

        $eventManager = new EventManager();
        $seanceChangedNotifier = new SeanceChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_seance' => $id_seance,
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(SeanceChangedNotifier::onSeanceEmargementLate, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before, $notifications_count_after);
    }

    public function testOnSeanceEmargementLateOk()
    {
        $session = [];
        $id_seance = '1';

        $eventManager = new EventManager();
        $seanceChangedNotifier = new SeanceChangedNotifier($eventManager);

        $eventArgs = new BasicEventArgs($session, $this->pdo);
        $eventArgs->setArgs([
            'id_seance' => $id_seance,
        ]);
        $notifications_count_before = $this->tester->grabNumRecords('notifications');

        $eventManager->dispatchEvent(SeanceChangedNotifier::onSeanceEmargementLate, $eventArgs);

        $notifications_count_after = $this->tester->grabNumRecords('notifications');

        $this->assertEquals($notifications_count_before + 1, $notifications_count_after);
    }
}