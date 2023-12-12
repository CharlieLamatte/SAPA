<?php

namespace Sportsante86\Sapa\tests\Unit;

use Faker\Factory;
use Sportsante86\Sapa\Model\Pathologie;
use Tests\Support\UnitTester;

class PathologieTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Pathologie $pathologie;

    private \Faker\Generator $faker;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->pathologie = new Pathologie($pdo);
        $this->assertNotNull($this->pathologie);

        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(1234);
    }

    protected function _after()
    {
    }

    public function testReadOneOk()
    {
        $id_patient = "1";

        $patho = $this->pathologie->readOne($id_patient);

        $this->assertIsArray($patho);
        $this->assertArrayHasKey("id_pathologie", $patho);
        $this->assertArrayHasKey("cardio", $patho);
        $this->assertArrayHasKey("respiratoire", $patho);
        $this->assertArrayHasKey("metabolique", $patho);
        $this->assertArrayHasKey("osteo_articulaire", $patho);
        $this->assertArrayHasKey("psycho_social", $patho);
        $this->assertArrayHasKey("neuro", $patho);
        $this->assertArrayHasKey("cancero", $patho);
        $this->assertArrayHasKey("circulatoire", $patho);
        $this->assertArrayHasKey("autre", $patho);
        $this->assertArrayHasKey("a_patho_cardio", $patho);
        $this->assertArrayHasKey("a_patho_respiratoire", $patho);
        $this->assertArrayHasKey("a_patho_metabolique", $patho);
        $this->assertArrayHasKey("a_patho_osteo_articulaire", $patho);
        $this->assertArrayHasKey("a_patho_psycho_social", $patho);
        $this->assertArrayHasKey("a_patho_neuro", $patho);
        $this->assertArrayHasKey("a_patho_cancero", $patho);
        $this->assertArrayHasKey("a_patho_circulatoire", $patho);
        $this->assertArrayHasKey("a_patho_autre", $patho);
    }

    public function testReadOneOkInvalid()
    {
        $id_patient = "-1";

        $patho = $this->pathologie->readOne($id_patient);
        $this->assertFalse($patho);
    }

    public function testReadOneNotOkId_patientNull()
    {
        $id_patient = null;

        $patho = $this->pathologie->readOne($id_patient);

        $this->assertFalse($patho);
        $this->assertEquals("Il manque au moins un paramètre obligatoire", $this->pathologie->getErrorMessage());
    }

    public function testCreateOkAllTrue()
    {
        $id_patient = "5";
        $a_patho_cardio = "1";
        $a_patho_respiratoire = "1";
        $a_patho_metabolique = "1";
        $a_patho_osteo_articulaire = "1";
        $a_patho_psycho_social = "1";
        $a_patho_neuro = "1";
        $a_patho_cancero = "1";
        $a_patho_circulatoire = "1";
        $a_patho_autre = "1";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertNotEmpty($id_pathologie, $this->pathologie->getErrorMessage());

        $this->tester->seeInDatabase('pathologies', [
            'id_patient' => $id_patient,
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => "1",
            'a_patho_respiratoire' => "1",
            'a_patho_metabolique' => "1",
            'a_patho_osteo_articulaire' => "1",
            'a_patho_psycho_social' => "1",
            'a_patho_neuro' => "1",
            'a_patho_cancero' => "1",
            'a_patho_circulatoire' => "1",
            'a_patho_autre' => "1",

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);
    }

    public function testCreateOkAllFalse()
    {
        $id_patient = "5";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertNotEmpty($id_pathologie, $this->pathologie->getErrorMessage());

        $this->tester->seeInDatabase('pathologies', [
            'id_patient' => $id_patient,
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => "0",
            'a_patho_respiratoire' => "0",
            'a_patho_metabolique' => "0",
            'a_patho_osteo_articulaire' => "0",
            'a_patho_psycho_social' => "0",
            'a_patho_neuro' => "0",
            'a_patho_cancero' => "0",
            'a_patho_circulatoire' => "0",
            'a_patho_autre' => "0",

            'cardio' => "",
            'respiratoire' => "",
            'metabolique' => "",
            'osteo_articulaire' => "",
            'psycho_social' => "",
            'neuro' => "",
            'cancero' => "",
            'circulatoire' => "",
            'autre' => "",
        ]);
    }

    public function testCreateNotOkId_patientNull()
    {
        $id_patient = null;
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertEmpty($id_pathologie, $this->pathologie->getErrorMessage());
    }

    public function testCreateNotOkA_patho_cardioNull()
    {
        $id_patient = "5";
        $a_patho_cardio = null;
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertEmpty($id_pathologie, $this->pathologie->getErrorMessage());
    }

    public function testCreateNotOkA_patho_respiratoireNull()
    {
        $id_patient = "5";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = null;
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertEmpty($id_pathologie, $this->pathologie->getErrorMessage());
    }

    public function testCreateNotOkA_patho_metaboliqueNull()
    {
        $id_patient = "5";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = null;
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertEmpty($id_pathologie, $this->pathologie->getErrorMessage());
    }

    public function testCreateNotOkA_patho_osteo_articulaireNull()
    {
        $id_patient = "5";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = null;
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertEmpty($id_pathologie, $this->pathologie->getErrorMessage());
    }

    public function testCreateNotOkA_patho_psycho_socialNull()
    {
        $id_patient = "5";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = null;
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertEmpty($id_pathologie, $this->pathologie->getErrorMessage());
    }

    public function testCreateNotOkA_patho_neuroNull()
    {
        $id_patient = "5";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = null;
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertEmpty($id_pathologie, $this->pathologie->getErrorMessage());
    }

    public function testCreateNotOkA_patho_canceroNull()
    {
        $id_patient = "5";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = null;
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertEmpty($id_pathologie, $this->pathologie->getErrorMessage());
    }

    public function testCreateNotOkA_patho_circulatoireNull()
    {
        $id_patient = "5";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = null;
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertEmpty($id_pathologie, $this->pathologie->getErrorMessage());
    }

    public function testCreateNotOkA_patho_autreNull()
    {
        $id_patient = "5";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = null;
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $id_pathologie = $this->pathologie->create([
            'id_patient' => $id_patient,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertEmpty($id_pathologie, $this->pathologie->getErrorMessage());
    }

    public function testUpdateOkAllTrue()
    {
        $id_pathologie = "1";
        $a_patho_cardio = "1";
        $a_patho_respiratoire = "1";
        $a_patho_metabolique = "1";
        $a_patho_osteo_articulaire = "1";
        $a_patho_psycho_social = "1";
        $a_patho_neuro = "1";
        $a_patho_cancero = "1";
        $a_patho_circulatoire = "1";
        $a_patho_autre = "1";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertTrue($update_ok, $this->pathologie->getErrorMessage());

        $this->tester->seeInDatabase('pathologies', [
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => "1",
            'a_patho_respiratoire' => "1",
            'a_patho_metabolique' => "1",
            'a_patho_osteo_articulaire' => "1",
            'a_patho_psycho_social' => "1",
            'a_patho_neuro' => "1",
            'a_patho_cancero' => "1",
            'a_patho_circulatoire' => "1",
            'a_patho_autre' => "1",

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);
    }

    public function testUpdateOkAllFalse()
    {
        $id_pathologie = "1";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertTrue($update_ok, $this->pathologie->getErrorMessage());

        $this->tester->seeInDatabase('pathologies', [
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => "0",
            'a_patho_respiratoire' => "0",
            'a_patho_metabolique' => "0",
            'a_patho_osteo_articulaire' => "0",
            'a_patho_psycho_social' => "0",
            'a_patho_neuro' => "0",
            'a_patho_cancero' => "0",
            'a_patho_circulatoire' => "0",
            'a_patho_autre' => "0",

            'cardio' => "",
            'respiratoire' => "",
            'metabolique' => "",
            'osteo_articulaire' => "",
            'psycho_social' => "",
            'neuro' => "",
            'cancero' => "",
            'circulatoire' => "",
            'autre' => "",
        ]);
    }

    public function testUpdateNotOkId_pathologieNull()
    {
        $id_pathologie = null;
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertFalse($update_ok, $this->pathologie->getErrorMessage());
    }

    public function testUpdateNotOkA_patho_cardioNull()
    {
        $id_pathologie = "1";
        $a_patho_cardio = null;
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertFalse($update_ok, $this->pathologie->getErrorMessage());
    }

    public function testUpdateNotOkA_patho_respiratoireNull()
    {
        $id_pathologie = "1";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = null;
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertFalse($update_ok, $this->pathologie->getErrorMessage());
    }

    public function testUpdateNotOkA_patho_metaboliqueNull()
    {
        $id_pathologie = "1";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = null;
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertFalse($update_ok, $this->pathologie->getErrorMessage());
    }

    public function testUpdateNotOkA_patho_osteo_articulaireNull()
    {
        $id_pathologie = "1";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = null;
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertFalse($update_ok, $this->pathologie->getErrorMessage());
    }

    public function testUpdateNotOkA_patho_psycho_socialNull()
    {
        $id_pathologie = "1";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = null;
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertFalse($update_ok, $this->pathologie->getErrorMessage());
    }

    public function testUpdateNotOkA_patho_neuroNull()
    {
        $id_pathologie = "1";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = null;
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertFalse($update_ok, $this->pathologie->getErrorMessage());
    }

    public function testUpdateNotOkA_patho_canceroNull()
    {
        $id_pathologie = "1";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = null;
        $a_patho_circulatoire = "0";
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertFalse($update_ok, $this->pathologie->getErrorMessage());
    }

    public function testUpdateNotOkA_patho_circulatoireNull()
    {
        $id_pathologie = "1";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = null;
        $a_patho_autre = "0";
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertFalse($update_ok, $this->pathologie->getErrorMessage());
    }

    public function testUpdateNotOkA_patho_autreNull()
    {
        $id_pathologie = "1";
        $a_patho_cardio = "0";
        $a_patho_respiratoire = "0";
        $a_patho_metabolique = "0";
        $a_patho_osteo_articulaire = "0";
        $a_patho_psycho_social = "0";
        $a_patho_neuro = "0";
        $a_patho_cancero = "0";
        $a_patho_circulatoire = "0";
        $a_patho_autre = null;
        $cardio = $this->faker->text("2000");
        $respiratoire = $this->faker->text("2000");
        $metabolique = $this->faker->text("2000");
        $osteo_articulaire = $this->faker->text("2000");
        $psycho_social = $this->faker->text("2000");
        $neuro = $this->faker->text("2000");
        $cancero = $this->faker->text("2000");
        $circulatoire = $this->faker->text("2000");
        $autre = $this->faker->text("2000");

        $update_ok = $this->pathologie->update([
            'id_pathologie' => $id_pathologie,
            'a_patho_cardio' => $a_patho_cardio,
            'a_patho_respiratoire' => $a_patho_respiratoire,
            'a_patho_metabolique' => $a_patho_metabolique,
            'a_patho_osteo_articulaire' => $a_patho_osteo_articulaire,
            'a_patho_psycho_social' => $a_patho_psycho_social,
            'a_patho_neuro' => $a_patho_neuro,
            'a_patho_cancero' => $a_patho_cancero,
            'a_patho_circulatoire' => $a_patho_circulatoire,
            'a_patho_autre' => $a_patho_autre,

            'cardio' => $cardio,
            'respiratoire' => $respiratoire,
            'metabolique' => $metabolique,
            'osteo_articulaire' => $osteo_articulaire,
            'psycho_social' => $psycho_social,
            'neuro' => $neuro,
            'cancero' => $cancero,
            'circulatoire' => $circulatoire,
            'autre' => $autre,
        ]);

        $this->assertFalse($update_ok, $this->pathologie->getErrorMessage());
    }
}