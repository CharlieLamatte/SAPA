<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\Observation;
use Tests\Support\UnitTester;

class ObservationTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Observation $observation;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->observation = new Observation($pdo);
        $this->assertNotNull($this->observation);
    }

    protected function _after()
    {
    }

    public function testCreateOk()
    {
        $id_user = '2';
        $id_patient = '1';
        $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque maximus quam ac volutpat tempus. Nunc metus mauris, efficitur eget blandit. ';
        $id_type_observation = '1';

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $id_observation = $this->observation->create([
            'observation' => $observation,
            'id_patient' => $id_patient,
            'id_user' => $id_user,
            'id_type_observation' => $id_type_observation
        ]);
        $this->assertNotFalse($id_observation);
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before + 1, $observation_count_after);

        $this->tester->seeInDatabase('observation', array(
            'id_observation' => $id_observation,
            'id_patient' => $id_patient,
            'id_user' => $id_user,
            'observation' => $observation,
            'id_type_observation' => $id_type_observation,
        ));
    }

    public function testCreateNotOkInvalidId_user()
    {
        $id_user = '-1';
        $id_patient = '1';
        $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque maximus quam ac volutpat tempus. Nunc metus mauris, efficitur eget blandit.';
        $id_type_observation = '1';

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $id_observation = $this->observation->create([
            'observation' => $observation,
            'id_patient' => $id_patient,
            'id_user' => $id_user,
            'id_type_observation' => $id_type_observation
        ]);
        $this->assertFalse($id_observation);
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before, $observation_count_after);
    }

    public function testCreateNotOkInvalidId_patient()
    {
        $id_user = '2';
        $id_patient = '-1';
        $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque maximus quam ac volutpat tempus. Nunc metus mauris, efficitur eget blandit.';
        $id_type_observation = '1';

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $id_observation = $this->observation->create([
            'observation' => $observation,
            'id_patient' => $id_patient,
            'id_user' => $id_user,
            'id_type_observation' => $id_type_observation
        ]);
        $this->assertFalse($id_observation);
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before, $observation_count_after);
    }

    public function testCreateNotOkInvalidId_type_observation()
    {
        $id_user = '2';
        $id_patient = '1';
        $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque maximus quam ac volutpat tempus. Nunc metus mauris, efficitur eget blandit.';
        $id_type_observation = '-1';

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $id_observation = $this->observation->create([
            'observation' => $observation,
            'id_patient' => $id_patient,
            'id_user' => $id_user,
            'id_type_observation' => $id_type_observation
        ]);
        $this->assertFalse($id_observation);
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before, $observation_count_after);
    }

    public function testCreateNotOkInvalidObservation()
    {
        // TODO
    }

    public function testCreateNotOkMissingId_user()
    {
        $id_patient = '1';
        $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque maximus quam ac volutpat tempus. Nunc metus mauris, efficitur eget blandit.';
        $id_type_observation = '1';

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $id_observation = $this->observation->create([
            'observation' => $observation,
            'id_patient' => $id_patient,
            'id_type_observation' => $id_type_observation
        ]);
        $this->assertFalse($id_observation);
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before, $observation_count_after);
    }

    public function testCreateNotOkMissingId_patient()
    {
        $id_user = '2';
        $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque maximus quam ac volutpat tempus. Nunc metus mauris, efficitur eget blandit.';
        $id_type_observation = '1';

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $id_observation = $this->observation->create([
            'observation' => $observation,
            'id_user' => $id_user,
            'id_type_observation' => $id_type_observation
        ]);
        $this->assertFalse($id_observation);
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before, $observation_count_after);
    }

    public function testCreateNotOkMissingObservation()
    {
        $id_user = '2';
        $id_patient = '1';
        $id_type_observation = '1';

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $id_observation = $this->observation->create([
            'id_patient' => $id_patient,
            'id_user' => $id_user,
            'id_type_observation' => $id_type_observation
        ]);
        $this->assertFalse($id_observation);
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before, $observation_count_after);
    }

    public function testCreateNotOkMissingId_type_observation()
    {
        $id_user = '2';
        $id_patient = '1';
        $observation = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque maximus quam ac volutpat tempus. Nunc metus mauris, efficitur eget blandit.';

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $id_observation = $this->observation->create([
            'observation' => $observation,
            'id_patient' => $id_patient,
            'id_user' => $id_user,
        ]);
        $this->assertFalse($id_observation);
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before, $observation_count_after);
    }

    public function testDeleteOk()
    {
        $id_observation = '1';

        $this->tester->seeInDatabase('observation', array(
            'id_observation' => $id_observation,
        ));

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $result = $this->observation->delete($id_observation);
        $this->assertTrue($result);
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before, $observation_count_after + 1);

        $this->tester->dontSeeInDatabase('observation', array(
            'id_observation' => $id_observation,
        ));
    }

    public function testDeleteNotOkId_observationNull()
    {
        $id_observation = null;

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $result = $this->observation->delete($id_observation);
        $this->assertFalse($result);
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before, $observation_count_after);
    }

    public function testDeleteNotOkId_observationInvalid()
    {
        $id_observation = "-1";

        $observation_count_before = $this->tester->grabNumRecords('observation');
        $result = $this->observation->delete($id_observation);
        $this->assertTrue($result); // request is valid, but nothing is deleted
        $observation_count_after = $this->tester->grabNumRecords('observation');
        $this->assertEquals($observation_count_before, $observation_count_after);
    }

    public function testReadOneOk()
    {
        $id_observation = '1';

        $observation = $this->observation->readOne($id_observation);

        $this->assertNotFalse($observation);
        $this->assertIsArray($observation);

        $this->assertArrayHasKey('id_observation', $observation);
        $this->assertArrayHasKey('observation', $observation);
        $this->assertArrayHasKey('date_observation', $observation);
        $this->assertArrayHasKey('id_patient', $observation);
        $this->assertArrayHasKey('id_user', $observation);
        $this->assertArrayHasKey('id_type_observation', $observation);

        $this->assertEquals('1', $observation['id_observation']);
        $this->assertEquals('Obs 2', $observation['observation']);
        $this->assertEquals('14/02/2022', $observation['date_observation']);
        $this->assertEquals('1', $observation['id_patient']);
        $this->assertEquals('2', $observation['id_user']);
        $this->assertEquals('1', $observation['id_type_observation']);
    }

    public function testReadOneNotOkId_observationNull()
    {
        $id_observation = null;

        $observation = $this->observation->readOne($id_observation);

        $this->assertFalse($observation);
    }

    public function testReadOneNotOkId_observationInvalid()
    {
        $id_observation = '-1';

        $observation = $this->observation->readOne($id_observation);

        $this->assertFalse($observation);
    }

    public function testReadAllOkNoId_type_observation()
    {
        $id_patient = '1';

        $observations = $this->observation->readAll($id_patient);

        $this->assertNotFalse($observations);
        $this->assertIsArray($observations);
        $this->assertCount(3, $observations);

        $first_observation = $observations[0];
        $second_observation = $observations[1];
        $third_observation = $observations[2];

        $this->assertIsArray($first_observation);
        $this->assertIsArray($second_observation);
        $this->assertIsArray($second_observation);

        $this->assertArrayHasKey('id_observation', $first_observation);
        $this->assertArrayHasKey('observation', $first_observation);
        $this->assertArrayHasKey('date_observation', $first_observation);
        $this->assertArrayHasKey('id_patient', $first_observation);
        $this->assertArrayHasKey('id_user', $first_observation);
        $this->assertArrayHasKey('id_type_observation', $first_observation);

        $this->assertEquals('2', $first_observation['id_observation']);
        $this->assertEquals('Obs 1', $first_observation['observation']);
        $this->assertEquals('13/02/2022', $first_observation['date_observation']);
        $this->assertEquals('1', $first_observation['id_patient']);
        $this->assertEquals('2', $first_observation['id_user']);
        $this->assertEquals('1', $first_observation['id_type_observation']);

        $this->assertArrayHasKey('id_observation', $second_observation);
        $this->assertArrayHasKey('observation', $second_observation);
        $this->assertArrayHasKey('date_observation', $second_observation);
        $this->assertArrayHasKey('id_patient', $second_observation);
        $this->assertArrayHasKey('id_user', $second_observation);
        $this->assertArrayHasKey('id_type_observation', $second_observation);

        $this->assertEquals('1', $second_observation['id_observation']);
        $this->assertEquals('Obs 2', $second_observation['observation']);
        $this->assertEquals('14/02/2022', $second_observation['date_observation']);
        $this->assertEquals('1', $second_observation['id_patient']);
        $this->assertEquals('2', $second_observation['id_user']);
        $this->assertEquals('1', $first_observation['id_type_observation']);

        $this->assertArrayHasKey('id_observation', $third_observation);
        $this->assertArrayHasKey('observation', $third_observation);
        $this->assertArrayHasKey('date_observation', $third_observation);
        $this->assertArrayHasKey('id_patient', $third_observation);
        $this->assertArrayHasKey('id_user', $third_observation);
        $this->assertArrayHasKey('id_type_observation', $third_observation);

        $this->assertEquals('3', $third_observation['id_observation']);
        $this->assertEquals('Obs 3', $third_observation['observation']);
        $this->assertEquals('15/02/2022', $third_observation['date_observation']);
        $this->assertEquals('1', $third_observation['id_patient']);
        $this->assertEquals('2', $third_observation['id_user']);
        $this->assertEquals('2', $third_observation['id_type_observation']);
    }

    public function testReadAllOkId_type_observation1()
    {
        $id_patient = '1';
        $id_type_observation = '1';

        $observations = $this->observation->readAll($id_patient, $id_type_observation);

        $this->assertNotFalse($observations);
        $this->assertIsArray($observations);
        $this->assertCount(2, $observations);

        $first_observation = $observations[0];
        $second_observation = $observations[1];

        $this->assertIsArray($first_observation);
        $this->assertIsArray($second_observation);
        $this->assertIsArray($second_observation);

        $this->assertArrayHasKey('id_observation', $first_observation);
        $this->assertArrayHasKey('observation', $first_observation);
        $this->assertArrayHasKey('date_observation', $first_observation);
        $this->assertArrayHasKey('id_patient', $first_observation);
        $this->assertArrayHasKey('id_user', $first_observation);
        $this->assertArrayHasKey('id_type_observation', $first_observation);

        $this->assertEquals('2', $first_observation['id_observation']);
        $this->assertEquals('Obs 1', $first_observation['observation']);
        $this->assertEquals('13/02/2022', $first_observation['date_observation']);
        $this->assertEquals('1', $first_observation['id_patient']);
        $this->assertEquals('2', $first_observation['id_user']);
        $this->assertEquals('1', $first_observation['id_type_observation']);

        $this->assertArrayHasKey('id_observation', $second_observation);
        $this->assertArrayHasKey('observation', $second_observation);
        $this->assertArrayHasKey('date_observation', $second_observation);
        $this->assertArrayHasKey('id_patient', $second_observation);
        $this->assertArrayHasKey('id_user', $second_observation);
        $this->assertArrayHasKey('id_type_observation', $second_observation);

        $this->assertEquals('1', $second_observation['id_observation']);
        $this->assertEquals('Obs 2', $second_observation['observation']);
        $this->assertEquals('14/02/2022', $second_observation['date_observation']);
        $this->assertEquals('1', $second_observation['id_patient']);
        $this->assertEquals('2', $second_observation['id_user']);
        $this->assertEquals('1', $first_observation['id_type_observation']);
    }

    public function testReadAllOkId_type_observation2()
    {
        $id_patient = '1';
        $id_type_observation = '2';

        $observations = $this->observation->readAll($id_patient, $id_type_observation);

        $this->assertNotFalse($observations);
        $this->assertIsArray($observations);
        $this->assertCount(1, $observations);

        $first_observation = $observations[0];

        $this->assertIsArray($first_observation);

        $this->assertArrayHasKey('id_observation', $first_observation);
        $this->assertArrayHasKey('observation', $first_observation);
        $this->assertArrayHasKey('date_observation', $first_observation);
        $this->assertArrayHasKey('id_patient', $first_observation);
        $this->assertArrayHasKey('id_user', $first_observation);
        $this->assertArrayHasKey('id_type_observation', $first_observation);

        $this->assertEquals('3', $first_observation['id_observation']);
        $this->assertEquals('Obs 3', $first_observation['observation']);
        $this->assertEquals('15/02/2022', $first_observation['date_observation']);
        $this->assertEquals('1', $first_observation['id_patient']);
        $this->assertEquals('2', $first_observation['id_user']);
        $this->assertEquals('2', $first_observation['id_type_observation']);
    }

    public function testReadAllNotOkId_patientNull()
    {
        $id_patient = null;

        $observations = $this->observation->readAll($id_patient);

        $this->assertFalse($observations);
    }

    public function testReadAllNotOkId_patientInvalid()
    {
        $id_patient = '-1';

        $observations = $this->observation->readAll($id_patient);

        $this->assertNotFalse($observations);
        $this->assertIsArray($observations);
        $this->assertCount(0, $observations);
    }

    public function testReadAllNotOkId_type_observationInvalid()
    {
        $id_patient = '1';
        $id_type_observation = '-1';

        $observations = $this->observation->readAll($id_patient, $id_type_observation);

        $this->assertNotFalse($observations);
        $this->assertIsArray($observations);
        $this->assertCount(0, $observations);
    }

    public function testReadAllNotOkId_patientNullAndId_type_observationInvalid()
    {
        $id_patient = null;
        $id_type_observation = '-1';

        $observations = $this->observation->readAll($id_patient, $id_type_observation);

        $this->assertFalse($observations);
    }

    public function testReadAllNotOkId_patientNullAndId_type_observationValid()
    {
        $id_patient = null;
        $id_type_observation = '1';

        $observations = $this->observation->readAll($id_patient, $id_type_observation);

        $this->assertFalse($observations);
    }
}