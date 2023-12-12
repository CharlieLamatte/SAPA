<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\JournalAcces;
use Tests\Support\UnitTester;

class JournalAccesTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private JournalAcces $journal;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->journal = new JournalAcces($pdo);
        $this->assertNotNull($this->journal);
    }

    protected function _after()
    {
    }

    public function testCreateOkMinimumData()
    {
        $nom_acteur = "BOB dupond";
        $type_action = "read";
        $type_cible = "patient";
        $nom_cible = "LUCY maude";

        $journal_activite_count_before = $this->tester->grabNumRecords('journal_activite');

        $id_journal_activite = $this->journal->create([
            'nom_acteur' => $nom_acteur,
            'type_action' => $type_action,
            'type_cible' => $type_cible,
            'nom_cible' => $nom_cible,
        ]);
        $this->assertNotFalse($id_journal_activite);

        $journal_activite_count_after = $this->tester->grabNumRecords('journal_activite');
        $this->assertEquals($journal_activite_count_before + 1, $journal_activite_count_after);
    }

    public function testCreateOkMinimumDataType_actionUpperCase()
    {
        $nom_acteur = "BOB dupond";
        $type_action = "READ";
        $type_cible = "patient";
        $nom_cible = "LUCY maude";

        $journal_activite_count_before = $this->tester->grabNumRecords('journal_activite');

        $id_journal_activite = $this->journal->create([
            'nom_acteur' => $nom_acteur,
            'type_action' => $type_action,
            'type_cible' => $type_cible,
            'nom_cible' => $nom_cible,
        ]);
        $this->assertNotFalse($id_journal_activite);

        $journal_activite_count_after = $this->tester->grabNumRecords('journal_activite');
        $this->assertEquals($journal_activite_count_before + 1, $journal_activite_count_after);
    }

    public function testCreateOkMinimumDataType_cibleUpperCase()
    {
        $nom_acteur = "BOB dupond";
        $type_action = "read";
        $type_cible = "PATIENT";
        $nom_cible = "LUCY maude";

        $journal_activite_count_before = $this->tester->grabNumRecords('journal_activite');

        $id_journal_activite = $this->journal->create([
            'nom_acteur' => $nom_acteur,
            'type_action' => $type_action,
            'type_cible' => $type_cible,
            'nom_cible' => $nom_cible,
        ]);
        $this->assertNotFalse($id_journal_activite);

        $journal_activite_count_after = $this->tester->grabNumRecords('journal_activite');
        $this->assertEquals($journal_activite_count_before + 1, $journal_activite_count_after);
    }

    public function testCreateOkMinimumAllData()
    {
        $nom_acteur = "BOB dupond";
        $type_action = "read";
        $type_cible = "patient";
        $nom_cible = "LUCY maude";

        $id_user_acteur = "2";
        $id_cible = "4";

        $journal_activite_count_before = $this->tester->grabNumRecords('journal_activite');

        $id_journal_activite = $this->journal->create([
            'nom_acteur' => $nom_acteur,
            'type_action' => $type_action,
            'type_cible' => $type_cible,
            'nom_cible' => $nom_cible,

            'id_user_acteur' => $id_user_acteur,
            'id_cible' => $id_cible,
        ]);
        $this->assertNotFalse($id_journal_activite);

        $journal_activite_count_after = $this->tester->grabNumRecords('journal_activite');
        $this->assertEquals($journal_activite_count_before + 1, $journal_activite_count_after);
    }

    public function testCreateNotOkType_actionWrong()
    {
        $nom_acteur = "BOB dupond";
        $type_action = "reads";
        $type_cible = "patient";
        $nom_cible = "LUCY maude";

        $journal_activite_count_before = $this->tester->grabNumRecords('journal_activite');

        $id_journal_activite = $this->journal->create([
            'nom_acteur' => $nom_acteur,
            'type_action' => $type_action,
            'type_cible' => $type_cible,
            'nom_cible' => $nom_cible,
        ]);
        $this->assertFalse($id_journal_activite);

        $journal_activite_count_after = $this->tester->grabNumRecords('journal_activite');
        $this->assertEquals($journal_activite_count_before, $journal_activite_count_after);
    }

    public function testCreateNotOkType_cibleWrong()
    {
        $nom_acteur = "BOB dupond";
        $type_action = "read";
        $type_cible = "patients";
        $nom_cible = "LUCY maude";

        $journal_activite_count_before = $this->tester->grabNumRecords('journal_activite');

        $id_journal_activite = $this->journal->create([
            'nom_acteur' => $nom_acteur,
            'type_action' => $type_action,
            'type_cible' => $type_cible,
            'nom_cible' => $nom_cible,
        ]);
        $this->assertFalse($id_journal_activite);

        $journal_activite_count_after = $this->tester->grabNumRecords('journal_activite');
        $this->assertEquals($journal_activite_count_before, $journal_activite_count_after);
    }

    public function testCreateNotOkNom_acteurNull()
    {
        $nom_acteur = null;
        $type_action = "read";
        $type_cible = "patient";
        $nom_cible = "LUCY maude";

        $journal_activite_count_before = $this->tester->grabNumRecords('journal_activite');

        $id_journal_activite = $this->journal->create([
            'nom_acteur' => $nom_acteur,
            'type_action' => $type_action,
            'type_cible' => $type_cible,
            'nom_cible' => $nom_cible,
        ]);
        $this->assertFalse($id_journal_activite);

        $journal_activite_count_after = $this->tester->grabNumRecords('journal_activite');
        $this->assertEquals($journal_activite_count_before, $journal_activite_count_after);
    }

    public function testCreateNotOkType_actionNull()
    {
        $nom_acteur = "BOB dupond";
        $type_action = null;
        $type_cible = "patient";
        $nom_cible = "LUCY maude";

        $journal_activite_count_before = $this->tester->grabNumRecords('journal_activite');

        $id_journal_activite = $this->journal->create([
            'nom_acteur' => $nom_acteur,
            'type_action' => $type_action,
            'type_cible' => $type_cible,
            'nom_cible' => $nom_cible,
        ]);
        $this->assertFalse($id_journal_activite);

        $journal_activite_count_after = $this->tester->grabNumRecords('journal_activite');
        $this->assertEquals($journal_activite_count_before, $journal_activite_count_after);
    }

    public function testCreateNotOkType_cibleNull()
    {
        $nom_acteur = "BOB dupond";
        $type_action = "read";
        $type_cible = null;
        $nom_cible = "LUCY maude";

        $journal_activite_count_before = $this->tester->grabNumRecords('journal_activite');

        $id_journal_activite = $this->journal->create([
            'nom_acteur' => $nom_acteur,
            'type_action' => $type_action,
            'type_cible' => $type_cible,
            'nom_cible' => $nom_cible,
        ]);
        $this->assertFalse($id_journal_activite);

        $journal_activite_count_after = $this->tester->grabNumRecords('journal_activite');
        $this->assertEquals($journal_activite_count_before, $journal_activite_count_after);
    }

    public function testCreateNotOkNom_cibleNull()
    {
        $nom_acteur = "BOB dupond";
        $type_action = "read";
        $type_cible = "patient";
        $nom_cible = null;

        $journal_activite_count_before = $this->tester->grabNumRecords('journal_activite');

        $id_journal_activite = $this->journal->create([
            'nom_acteur' => $nom_acteur,
            'type_action' => $type_action,
            'type_cible' => $type_cible,
            'nom_cible' => $nom_cible,
        ]);
        $this->assertFalse($id_journal_activite);

        $journal_activite_count_after = $this->tester->grabNumRecords('journal_activite');
        $this->assertEquals($journal_activite_count_before, $journal_activite_count_after);
    }

    public function testReadAllOk()
    {
        $activities = $this->journal->readAll();
        $this->assertIsArray($activities);
        $this->assertGreaterThan(0, count($activities));

        $journal_activite_count = $this->tester->grabNumRecords('journal_activite');
        $this->assertCount($journal_activite_count, $activities);

        foreach ($activities as $activity) {
            $this->assertArrayHasKey('id_journal_activite', $activity);
            $this->assertArrayHasKey('id_user_acteur', $activity);
            $this->assertArrayHasKey('nom_acteur', $activity);
            $this->assertArrayHasKey('type_action', $activity);
            $this->assertArrayHasKey('type_cible', $activity);
            $this->assertArrayHasKey('nom_cible', $activity);
            $this->assertArrayHasKey('id_cible', $activity);
            $this->assertArrayHasKey('date_action', $activity);
        }
    }
}