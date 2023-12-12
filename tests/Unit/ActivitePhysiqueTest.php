<?php

namespace Tests\Unit;

use Faker\Factory;
use Sportsante86\Sapa\Model\ActivitePhysique;
use Tests\Support\UnitTester;

class ActivitePhysiqueTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private $activitePhysique;

    private \Faker\Generator $faker;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->activitePhysique = new ActivitePhysique($pdo);
        $this->assertNotNull($this->activitePhysique);

        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(1234);
    }

    protected function _after()
    {
    }

    public function testCreateOkMinimumData()
    {
        $id_user = "2";
        $id_patient = "1";
        $date_observation = date('y-m-d H:i:s');

        $a_activite_anterieure = "0";
        $a_activite_autonome = "0";
        $a_activite_encadree = "0";
        $a_activite_envisagee = "0";
        $a_activite_frein = "0";
        $a_activite_point_fort_levier = "0";

        $est_dispo_lundi = "0";
        $est_dispo_mardi = "0";
        $est_dispo_mercredi = "0";
        $est_dispo_jeudi = "0";
        $est_dispo_vendredi = "0";
        $est_dispo_samedi = "0";
        $est_dispo_dimanche = "0";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $id_activite_physique = $this->activitePhysique->create([
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,
        ]);
        $this->assertNotFalse($id_activite_physique);

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before + 1, $activites_physiques_count_after);

        $this->tester->seeInDatabase('activites_physiques', [
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => "0",
            'a_activite_autonome' => "0",
            'a_activite_encadree' => "0",
            'a_activite_envisagee' => "0",
            'a_activite_frein' => "0",
            'a_activite_point_fort_levier' => "0",

            'activite_physique_autonome' => "",
            'activite_physique_encadree' => "",
            'activite_anterieure' => "",
            'frein_activite' => "",
            'activite_envisagee' => "",
            'point_fort_levier' => "",
            'disponibilite' => "",
            'date_observation' => $date_observation,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,

            'heure_debut_lundi' => null,
            'heure_debut_mardi' => null,
            'heure_debut_mercredi' => null,
            'heure_debut_jeudi' => null,
            'heure_debut_vendredi' => null,
            'heure_debut_samedi' => null,
            'heure_debut_dimanche' => null,

            'heure_fin_lundi' => null,
            'heure_fin_mardi' => null,
            'heure_fin_mercredi' => null,
            'heure_fin_jeudi' => null,
            'heure_fin_vendredi' => null,
            'heure_fin_samedi' => null,
            'heure_fin_dimanche' => null,
        ]);
    }

    public function testCreateOkAllTrue()
    {
        $id_user = "2";
        $id_patient = "1";
        $date_observation = date('y-m-d H:i:s');

        $a_activite_anterieure = "1";
        $a_activite_autonome = "1";
        $a_activite_encadree = "1";
        $a_activite_envisagee = "1";
        $a_activite_frein = "1";
        $a_activite_point_fort_levier = "1";

        $activite_physique_autonome = $this->faker->text("2000");
        $activite_physique_encadree = $this->faker->text("2000");
        $activite_anterieure = $this->faker->text("2000");
        $disponibilite = $this->faker->text("2000");
        $frein_activite = $this->faker->text("2000");
        $activite_envisagee = $this->faker->text("2000");
        $point_fort_levier = $this->faker->text("2000");

        $est_dispo_lundi = "1";
        $est_dispo_mardi = "1";
        $est_dispo_mercredi = "1";
        $est_dispo_jeudi = "1";
        $est_dispo_vendredi = "1";
        $est_dispo_samedi = "1";
        $est_dispo_dimanche = "1";

        $heure_debut_lundi = "1";
        $heure_debut_mardi = "2";
        $heure_debut_mercredi = "3";
        $heure_debut_jeudi = "4";
        $heure_debut_vendredi = "5";
        $heure_debut_samedi = "6";
        $heure_debut_dimanche = "7";

        $heure_fin_lundi = "8";
        $heure_fin_mardi = "9";
        $heure_fin_mercredi = "10";
        $heure_fin_jeudi = "11";
        $heure_fin_vendredi = "12";
        $heure_fin_samedi = "13";
        $heure_fin_dimanche = "14";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $id_activite_physique = $this->activitePhysique->create([
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'activite_physique_autonome' => $activite_physique_autonome,
            'activite_physique_encadree' => $activite_physique_encadree,
            'activite_anterieure' => $activite_anterieure,
            'frein_activite' => $frein_activite,
            'activite_envisagee' => $activite_envisagee,
            'point_fort_levier' => $point_fort_levier,
            'disponibilite' => $disponibilite,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,

            'heure_debut_lundi' => $heure_debut_lundi,
            'heure_debut_mardi' => $heure_debut_mardi,
            'heure_debut_mercredi' => $heure_debut_mercredi,
            'heure_debut_jeudi' => $heure_debut_jeudi,
            'heure_debut_vendredi' => $heure_debut_vendredi,
            'heure_debut_samedi' => $heure_debut_samedi,
            'heure_debut_dimanche' => $heure_debut_dimanche,

            'heure_fin_lundi' => $heure_fin_lundi,
            'heure_fin_mardi' => $heure_fin_mardi,
            'heure_fin_mercredi' => $heure_fin_mercredi,
            'heure_fin_jeudi' => $heure_fin_jeudi,
            'heure_fin_vendredi' => $heure_fin_vendredi,
            'heure_fin_samedi' => $heure_fin_samedi,
            'heure_fin_dimanche' => $heure_fin_dimanche,
        ]);
        $this->assertNotFalse($id_activite_physique);

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before + 1, $activites_physiques_count_after);

        $this->tester->seeInDatabase('activites_physiques', [
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'activite_physique_autonome' => $activite_physique_autonome,
            'activite_physique_encadree' => $activite_physique_encadree,
            'activite_anterieure' => $activite_anterieure,
            'disponibilite' => $disponibilite,
            'frein_activite' => $frein_activite,
            'activite_envisagee' => $activite_envisagee,
            'point_fort_levier' => $point_fort_levier,
            'date_observation' => $date_observation,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,

            'heure_debut_lundi' => $heure_debut_lundi,
            'heure_debut_mardi' => $heure_debut_mardi,
            'heure_debut_mercredi' => $heure_debut_mercredi,
            'heure_debut_jeudi' => $heure_debut_jeudi,
            'heure_debut_vendredi' => $heure_debut_vendredi,
            'heure_debut_samedi' => $heure_debut_samedi,
            'heure_debut_dimanche' => $heure_debut_dimanche,

            'heure_fin_lundi' => $heure_fin_lundi,
            'heure_fin_mardi' => $heure_fin_mardi,
            'heure_fin_mercredi' => $heure_fin_mercredi,
            'heure_fin_jeudi' => $heure_fin_jeudi,
            'heure_fin_vendredi' => $heure_fin_vendredi,
            'heure_fin_samedi' => $heure_fin_samedi,
            'heure_fin_dimanche' => $heure_fin_dimanche,
        ]);
    }

    public function testCreateOkAllFalse()
    {
        $id_user = "2";
        $id_patient = "1";
        $date_observation = date('y-m-d H:i:s');

        $a_activite_anterieure = "0";
        $a_activite_autonome = "0";
        $a_activite_encadree = "0";
        $a_activite_envisagee = "0";
        $a_activite_frein = "0";
        $a_activite_point_fort_levier = "0";

        $activite_physique_autonome = $this->faker->text("2000");
        $activite_physique_encadree = $this->faker->text("2000");
        $activite_anterieure = $this->faker->text("2000");
        $disponibilite = $this->faker->text("2000");
        $frein_activite = $this->faker->text("2000");
        $activite_envisagee = $this->faker->text("2000");
        $point_fort_levier = $this->faker->text("2000");

        $est_dispo_lundi = "0";
        $est_dispo_mardi = "0";
        $est_dispo_mercredi = "0";
        $est_dispo_jeudi = "0";
        $est_dispo_vendredi = "0";
        $est_dispo_samedi = "0";
        $est_dispo_dimanche = "0";

        $heure_debut_lundi = "1";
        $heure_debut_mardi = "2";
        $heure_debut_mercredi = "3";
        $heure_debut_jeudi = "4";
        $heure_debut_vendredi = "5";
        $heure_debut_samedi = "6";
        $heure_debut_dimanche = "7";

        $heure_fin_lundi = "8";
        $heure_fin_mardi = "9";
        $heure_fin_mercredi = "10";
        $heure_fin_jeudi = "11";
        $heure_fin_vendredi = "12";
        $heure_fin_samedi = "13";
        $heure_fin_dimanche = "14";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $id_activite_physique = $this->activitePhysique->create([
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'activite_physique_autonome' => $activite_physique_autonome,
            'activite_physique_encadree' => $activite_physique_encadree,
            'activite_anterieure' => $activite_anterieure,
            'frein_activite' => $frein_activite,
            'activite_envisagee' => $activite_envisagee,
            'point_fort_levier' => $point_fort_levier,
            'disponibilite' => $disponibilite,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,

            'heure_debut_lundi' => $heure_debut_lundi,
            'heure_debut_mardi' => $heure_debut_mardi,
            'heure_debut_mercredi' => $heure_debut_mercredi,
            'heure_debut_jeudi' => $heure_debut_jeudi,
            'heure_debut_vendredi' => $heure_debut_vendredi,
            'heure_debut_samedi' => $heure_debut_samedi,
            'heure_debut_dimanche' => $heure_debut_dimanche,

            'heure_fin_lundi' => $heure_fin_lundi,
            'heure_fin_mardi' => $heure_fin_mardi,
            'heure_fin_mercredi' => $heure_fin_mercredi,
            'heure_fin_jeudi' => $heure_fin_jeudi,
            'heure_fin_vendredi' => $heure_fin_vendredi,
            'heure_fin_samedi' => $heure_fin_samedi,
            'heure_fin_dimanche' => $heure_fin_dimanche,
        ]);
        $this->assertNotFalse($id_activite_physique);

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before + 1, $activites_physiques_count_after);

        $this->tester->seeInDatabase('activites_physiques', [
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'activite_physique_autonome' => "",
            'activite_physique_encadree' => "",
            'activite_anterieure' => "",
            'frein_activite' => "",
            'activite_envisagee' => "",
            'point_fort_levier' => "",
            'disponibilite' => $disponibilite,
            'date_observation' => $date_observation,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,

            'heure_debut_lundi' => null,
            'heure_debut_mardi' => null,
            'heure_debut_mercredi' => null,
            'heure_debut_jeudi' => null,
            'heure_debut_vendredi' => null,
            'heure_debut_samedi' => null,
            'heure_debut_dimanche' => null,

            'heure_fin_lundi' => null,
            'heure_fin_mardi' => null,
            'heure_fin_mercredi' => null,
            'heure_fin_jeudi' => null,
            'heure_fin_vendredi' => null,
            'heure_fin_samedi' => null,
            'heure_fin_dimanche' => null,
        ]);
    }

    public function testCreateNotOkId_userNull()
    {
        $id_user = null;
        $id_patient = "1";

        $a_activite_anterieure = "0";
        $a_activite_autonome = "0";
        $a_activite_encadree = "0";
        $a_activite_envisagee = "0";
        $a_activite_frein = "0";
        $a_activite_point_fort_levier = "0";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $id_activite_physique = $this->activitePhysique->create([
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,
        ]);
        $this->assertFalse($id_activite_physique);

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before, $activites_physiques_count_after);
    }

    public function testCreateNotOkId_patientNull()
    {
        $id_user = "2";
        $id_patient = null;

        $a_activite_anterieure = "0";
        $a_activite_autonome = "0";
        $a_activite_encadree = "0";
        $a_activite_envisagee = "0";
        $a_activite_frein = "0";
        $a_activite_point_fort_levier = "0";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $id_activite_physique = $this->activitePhysique->create([
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,
        ]);
        $this->assertFalse($id_activite_physique);

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before, $activites_physiques_count_after);
    }

    public function testReadOneOk()
    {
        $id_activite_physique = "1";

        $item = $this->activitePhysique->readOne($id_activite_physique);
        $this->assertNotFalse($item);
        $this->assertIsArray($item);

        $this->assertArrayHasKey('id_activite_physique', $item);
        $this->assertArrayHasKey('activite_physique_autonome', $item);
        $this->assertArrayHasKey('activite_physique_encadree', $item);
        $this->assertArrayHasKey('activite_anterieure', $item);
        $this->assertArrayHasKey('disponibilite', $item);
        $this->assertArrayHasKey('frein_activite', $item);
        $this->assertArrayHasKey('activite_envisagee', $item);
        $this->assertArrayHasKey('point_fort_levier', $item);
        $this->assertArrayHasKey('id_patient', $item);
        $this->assertArrayHasKey('id_user', $item);
        $this->assertArrayHasKey('date_observation', $item);
        $this->assertArrayHasKey('a_activite_anterieure', $item);
        $this->assertArrayHasKey('a_activite_autonome', $item);
        $this->assertArrayHasKey('a_activite_encadree', $item);
        $this->assertArrayHasKey('a_activite_envisagee', $item);
        $this->assertArrayHasKey('a_activite_frein', $item);
        $this->assertArrayHasKey('a_activite_point_fort_levier', $item);

        $this->assertArrayHasKey('est_dispo_lundi', $item);
        $this->assertArrayHasKey('est_dispo_mardi', $item);
        $this->assertArrayHasKey('est_dispo_mercredi', $item);
        $this->assertArrayHasKey('est_dispo_jeudi', $item);
        $this->assertArrayHasKey('est_dispo_vendredi', $item);
        $this->assertArrayHasKey('est_dispo_samedi', $item);
        $this->assertArrayHasKey('est_dispo_dimanche', $item);

        $this->assertArrayHasKey('heure_debut_lundi', $item);
        $this->assertArrayHasKey('heure_debut_mardi', $item);
        $this->assertArrayHasKey('heure_debut_mercredi', $item);
        $this->assertArrayHasKey('heure_debut_jeudi', $item);
        $this->assertArrayHasKey('heure_debut_vendredi', $item);
        $this->assertArrayHasKey('heure_debut_samedi', $item);
        $this->assertArrayHasKey('heure_debut_dimanche', $item);

        $this->assertArrayHasKey('heure_fin_lundi', $item);
        $this->assertArrayHasKey('heure_fin_mardi', $item);
        $this->assertArrayHasKey('heure_fin_mercredi', $item);
        $this->assertArrayHasKey('heure_fin_jeudi', $item);
        $this->assertArrayHasKey('heure_fin_vendredi', $item);
        $this->assertArrayHasKey('heure_fin_samedi', $item);
        $this->assertArrayHasKey('heure_fin_dimanche', $item);

        $this->assertEquals('1', $item['id_activite_physique']);
        $this->assertEquals('A 1', $item['activite_physique_autonome']);
        $this->assertEquals('B 1', $item['activite_physique_encadree']);
        $this->assertEquals('C 1', $item['activite_anterieure']);
        $this->assertEquals('D 1', $item['disponibilite']);
        $this->assertEquals('E 1', $item['frein_activite']);
        $this->assertEquals('F 1', $item['activite_envisagee']);
        $this->assertEquals('G 1', $item['point_fort_levier']);
        $this->assertEquals('1', $item['id_patient']);
        $this->assertEquals('2', $item['id_user']);
        $this->assertEquals('2023-06-13 14:35:33', $item['date_observation']);
        $this->assertEquals('1', $item['a_activite_anterieure']);
        $this->assertEquals('1', $item['a_activite_autonome']);
        $this->assertEquals('1', $item['a_activite_encadree']);
        $this->assertEquals('1', $item['a_activite_envisagee']);
        $this->assertEquals('1', $item['a_activite_frein']);
        $this->assertEquals('1', $item['a_activite_point_fort_levier']);
    }

    public function testReadOneNotOkId_activite_physiqueNull()
    {
        $id_activite_physique = null;

        $item = $this->activitePhysique->readOne($id_activite_physique);
        $this->assertFalse($item);
    }

    public function testReadOneNotOkId_activite_physiqueInvalid()
    {
        $id_activite_physique = "-1";

        $item = $this->activitePhysique->readOne($id_activite_physique);
        $this->assertFalse($item);
    }

    public function testReadOnePatientOk()
    {
        $id_patient = "1";

        $item = $this->activitePhysique->readOnePatient($id_patient);
        $this->assertNotFalse($item);
        $this->assertIsArray($item);

        $this->assertArrayHasKey('id_activite_physique', $item);
        $this->assertArrayHasKey('activite_physique_autonome', $item);
        $this->assertArrayHasKey('activite_physique_encadree', $item);
        $this->assertArrayHasKey('activite_anterieure', $item);
        $this->assertArrayHasKey('disponibilite', $item);
        $this->assertArrayHasKey('frein_activite', $item);
        $this->assertArrayHasKey('activite_envisagee', $item);
        $this->assertArrayHasKey('point_fort_levier', $item);
        $this->assertArrayHasKey('id_patient', $item);
        $this->assertArrayHasKey('id_user', $item);
        $this->assertArrayHasKey('date_observation', $item);
        $this->assertArrayHasKey('a_activite_anterieure', $item);
        $this->assertArrayHasKey('a_activite_autonome', $item);
        $this->assertArrayHasKey('a_activite_encadree', $item);
        $this->assertArrayHasKey('a_activite_envisagee', $item);
        $this->assertArrayHasKey('a_activite_frein', $item);
        $this->assertArrayHasKey('a_activite_point_fort_levier', $item);

        $this->assertArrayHasKey('est_dispo_lundi', $item);
        $this->assertArrayHasKey('est_dispo_mardi', $item);
        $this->assertArrayHasKey('est_dispo_mercredi', $item);
        $this->assertArrayHasKey('est_dispo_jeudi', $item);
        $this->assertArrayHasKey('est_dispo_vendredi', $item);
        $this->assertArrayHasKey('est_dispo_samedi', $item);
        $this->assertArrayHasKey('est_dispo_dimanche', $item);

        $this->assertArrayHasKey('heure_debut_lundi', $item);
        $this->assertArrayHasKey('heure_debut_mardi', $item);
        $this->assertArrayHasKey('heure_debut_mercredi', $item);
        $this->assertArrayHasKey('heure_debut_jeudi', $item);
        $this->assertArrayHasKey('heure_debut_vendredi', $item);
        $this->assertArrayHasKey('heure_debut_samedi', $item);
        $this->assertArrayHasKey('heure_debut_dimanche', $item);

        $this->assertArrayHasKey('heure_fin_lundi', $item);
        $this->assertArrayHasKey('heure_fin_mardi', $item);
        $this->assertArrayHasKey('heure_fin_mercredi', $item);
        $this->assertArrayHasKey('heure_fin_jeudi', $item);
        $this->assertArrayHasKey('heure_fin_vendredi', $item);
        $this->assertArrayHasKey('heure_fin_samedi', $item);
        $this->assertArrayHasKey('heure_fin_dimanche', $item);

        $this->assertEquals('1', $item['id_activite_physique']);
        $this->assertEquals('A 1', $item['activite_physique_autonome']);
        $this->assertEquals('B 1', $item['activite_physique_encadree']);
        $this->assertEquals('C 1', $item['activite_anterieure']);
        $this->assertEquals('D 1', $item['disponibilite']);
        $this->assertEquals('E 1', $item['frein_activite']);
        $this->assertEquals('F 1', $item['activite_envisagee']);
        $this->assertEquals('G 1', $item['point_fort_levier']);
        $this->assertEquals('1', $item['id_patient']);
        $this->assertEquals('2', $item['id_user']);
        $this->assertEquals('2023-06-13 14:35:33', $item['date_observation']);
        $this->assertEquals('1', $item['a_activite_anterieure']);
        $this->assertEquals('1', $item['a_activite_autonome']);
        $this->assertEquals('1', $item['a_activite_encadree']);
        $this->assertEquals('1', $item['a_activite_envisagee']);
        $this->assertEquals('1', $item['a_activite_frein']);
        $this->assertEquals('1', $item['a_activite_point_fort_levier']);
    }

    public function testReadOnePatientNotOkId_patientNull()
    {
        $id_patient = null;

        $item = $this->activitePhysique->readOnePatient($id_patient);
        $this->assertFalse($item);
    }

    public function testReadOnePatientNotOkId_patientInvalid()
    {
        $id_patient = "-1";

        $item = $this->activitePhysique->readOnePatient($id_patient);
        $this->assertFalse($item);
    }

    public function testUpdateOkMinimumData()
    {
        $id_activite_physique = "1";
        $id_user = "3";
        $id_patient = "1";
        $date_observation = date('y-m-d H:i:s');

        $a_activite_anterieure = "0";
        $a_activite_autonome = "0";
        $a_activite_encadree = "0";
        $a_activite_envisagee = "0";
        $a_activite_frein = "0";
        $a_activite_point_fort_levier = "0";

        $est_dispo_lundi = "0";
        $est_dispo_mardi = "0";
        $est_dispo_mercredi = "0";
        $est_dispo_jeudi = "0";
        $est_dispo_vendredi = "0";
        $est_dispo_samedi = "0";
        $est_dispo_dimanche = "0";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $update_ok = $this->activitePhysique->update([
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,
        ]);
        $this->assertTrue($update_ok);

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before, $activites_physiques_count_after);

        $this->tester->seeInDatabase('activites_physiques', [
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => "0",
            'a_activite_autonome' => "0",
            'a_activite_encadree' => "0",
            'a_activite_envisagee' => "0",
            'a_activite_frein' => "0",
            'a_activite_point_fort_levier' => "0",

            'activite_physique_autonome' => "",
            'activite_physique_encadree' => "",
            'activite_anterieure' => "",
            'frein_activite' => "",
            'activite_envisagee' => "",
            'point_fort_levier' => "",
            'disponibilite' => "",
            'date_observation' => $date_observation,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,

            'heure_debut_lundi' => null,
            'heure_debut_mardi' => null,
            'heure_debut_mercredi' => null,
            'heure_debut_jeudi' => null,
            'heure_debut_vendredi' => null,
            'heure_debut_samedi' => null,
            'heure_debut_dimanche' => null,

            'heure_fin_lundi' => null,
            'heure_fin_mardi' => null,
            'heure_fin_mercredi' => null,
            'heure_fin_jeudi' => null,
            'heure_fin_vendredi' => null,
            'heure_fin_samedi' => null,
            'heure_fin_dimanche' => null,
        ]);
    }

    public function testUpdateOkAllTrue()
    {
        $id_activite_physique = "1";
        $id_user = "4";
        $id_patient = "1";
        $date_observation = date('y-m-d H:i:s');

        $a_activite_anterieure = "1";
        $a_activite_autonome = "1";
        $a_activite_encadree = "1";
        $a_activite_envisagee = "1";
        $a_activite_frein = "1";
        $a_activite_point_fort_levier = "1";

        $activite_physique_autonome = $this->faker->text("2000");
        $activite_physique_encadree = $this->faker->text("2000");
        $activite_anterieure = $this->faker->text("2000");
        $disponibilite = $this->faker->text("2000");
        $frein_activite = $this->faker->text("2000");
        $activite_envisagee = $this->faker->text("2000");
        $point_fort_levier = $this->faker->text("2000");

        $est_dispo_lundi = "1";
        $est_dispo_mardi = "1";
        $est_dispo_mercredi = "1";
        $est_dispo_jeudi = "1";
        $est_dispo_vendredi = "1";
        $est_dispo_samedi = "1";
        $est_dispo_dimanche = "1";

        $heure_debut_lundi = "1";
        $heure_debut_mardi = "2";
        $heure_debut_mercredi = "3";
        $heure_debut_jeudi = "4";
        $heure_debut_vendredi = "5";
        $heure_debut_samedi = "6";
        $heure_debut_dimanche = "7";

        $heure_fin_lundi = "8";
        $heure_fin_mardi = "9";
        $heure_fin_mercredi = "10";
        $heure_fin_jeudi = "11";
        $heure_fin_vendredi = "12";
        $heure_fin_samedi = "13";
        $heure_fin_dimanche = "14";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $update_ok = $this->activitePhysique->update([
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'activite_physique_autonome' => $activite_physique_autonome,
            'activite_physique_encadree' => $activite_physique_encadree,
            'activite_anterieure' => $activite_anterieure,
            'frein_activite' => $frein_activite,
            'activite_envisagee' => $activite_envisagee,
            'point_fort_levier' => $point_fort_levier,
            'disponibilite' => $disponibilite,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,

            'heure_debut_lundi' => $heure_debut_lundi,
            'heure_debut_mardi' => $heure_debut_mardi,
            'heure_debut_mercredi' => $heure_debut_mercredi,
            'heure_debut_jeudi' => $heure_debut_jeudi,
            'heure_debut_vendredi' => $heure_debut_vendredi,
            'heure_debut_samedi' => $heure_debut_samedi,
            'heure_debut_dimanche' => $heure_debut_dimanche,

            'heure_fin_lundi' => $heure_fin_lundi,
            'heure_fin_mardi' => $heure_fin_mardi,
            'heure_fin_mercredi' => $heure_fin_mercredi,
            'heure_fin_jeudi' => $heure_fin_jeudi,
            'heure_fin_vendredi' => $heure_fin_vendredi,
            'heure_fin_samedi' => $heure_fin_samedi,
            'heure_fin_dimanche' => $heure_fin_dimanche,
        ]);
        $this->assertTrue($update_ok, $this->activitePhysique->getErrorMessage());

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before, $activites_physiques_count_after);

        $this->tester->seeInDatabase('activites_physiques', [
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'activite_physique_autonome' => $activite_physique_autonome,
            'activite_physique_encadree' => $activite_physique_encadree,
            'activite_anterieure' => $activite_anterieure,
            'disponibilite' => "", // reset car les dispos sont renseignées
            'frein_activite' => $frein_activite,
            'activite_envisagee' => $activite_envisagee,
            'point_fort_levier' => $point_fort_levier,
            'date_observation' => $date_observation,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,

            'heure_debut_lundi' => $heure_debut_lundi,
            'heure_debut_mardi' => $heure_debut_mardi,
            'heure_debut_mercredi' => $heure_debut_mercredi,
            'heure_debut_jeudi' => $heure_debut_jeudi,
            'heure_debut_vendredi' => $heure_debut_vendredi,
            'heure_debut_samedi' => $heure_debut_samedi,
            'heure_debut_dimanche' => $heure_debut_dimanche,

            'heure_fin_lundi' => $heure_fin_lundi,
            'heure_fin_mardi' => $heure_fin_mardi,
            'heure_fin_mercredi' => $heure_fin_mercredi,
            'heure_fin_jeudi' => $heure_fin_jeudi,
            'heure_fin_vendredi' => $heure_fin_vendredi,
            'heure_fin_samedi' => $heure_fin_samedi,
            'heure_fin_dimanche' => $heure_fin_dimanche,
        ]);
    }

    public function testUpdateOkAllFalse()
    {
        $id_activite_physique = "1";
        $id_user = "4";
        $id_patient = "1";
        $date_observation = date('y-m-d H:i:s');

        $a_activite_anterieure = "0";
        $a_activite_autonome = "0";
        $a_activite_encadree = "0";
        $a_activite_envisagee = "0";
        $a_activite_frein = "0";
        $a_activite_point_fort_levier = "0";

        $activite_physique_autonome = $this->faker->text("2000");
        $activite_physique_encadree = $this->faker->text("2000");
        $activite_anterieure = $this->faker->text("2000");
        $disponibilite = $this->faker->text("2000");
        $frein_activite = $this->faker->text("2000");
        $activite_envisagee = $this->faker->text("2000");
        $point_fort_levier = $this->faker->text("2000");

        $est_dispo_lundi = "0";
        $est_dispo_mardi = "0";
        $est_dispo_mercredi = "0";
        $est_dispo_jeudi = "0";
        $est_dispo_vendredi = "0";
        $est_dispo_samedi = "0";
        $est_dispo_dimanche = "0";

        $heure_debut_lundi = "1";
        $heure_debut_mardi = "2";
        $heure_debut_mercredi = "3";
        $heure_debut_jeudi = "4";
        $heure_debut_vendredi = "5";
        $heure_debut_samedi = "6";
        $heure_debut_dimanche = "7";

        $heure_fin_lundi = "8";
        $heure_fin_mardi = "9";
        $heure_fin_mercredi = "10";
        $heure_fin_jeudi = "11";
        $heure_fin_vendredi = "12";
        $heure_fin_samedi = "13";
        $heure_fin_dimanche = "14";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $update_ok = $this->activitePhysique->update([
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'activite_physique_autonome' => $activite_physique_autonome,
            'activite_physique_encadree' => $activite_physique_encadree,
            'activite_anterieure' => $activite_anterieure,
            'frein_activite' => $frein_activite,
            'activite_envisagee' => $activite_envisagee,
            'point_fort_levier' => $point_fort_levier,
            'disponibilite' => $disponibilite,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,

            'heure_debut_lundi' => $heure_debut_lundi,
            'heure_debut_mardi' => $heure_debut_mardi,
            'heure_debut_mercredi' => $heure_debut_mercredi,
            'heure_debut_jeudi' => $heure_debut_jeudi,
            'heure_debut_vendredi' => $heure_debut_vendredi,
            'heure_debut_samedi' => $heure_debut_samedi,
            'heure_debut_dimanche' => $heure_debut_dimanche,

            'heure_fin_lundi' => $heure_fin_lundi,
            'heure_fin_mardi' => $heure_fin_mardi,
            'heure_fin_mercredi' => $heure_fin_mercredi,
            'heure_fin_jeudi' => $heure_fin_jeudi,
            'heure_fin_vendredi' => $heure_fin_vendredi,
            'heure_fin_samedi' => $heure_fin_samedi,
            'heure_fin_dimanche' => $heure_fin_dimanche,
        ]);
        $this->assertTrue($update_ok, $this->activitePhysique->getErrorMessage());

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before, $activites_physiques_count_after);

        $this->tester->seeInDatabase('activites_physiques', [
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'activite_physique_autonome' => "",
            'activite_physique_encadree' => "",
            'activite_anterieure' => "",
            'frein_activite' => "",
            'activite_envisagee' => "",
            'point_fort_levier' => "",
            'disponibilite' => $disponibilite,
            'date_observation' => $date_observation,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,

            'heure_debut_lundi' => null,
            'heure_debut_mardi' => null,
            'heure_debut_mercredi' => null,
            'heure_debut_jeudi' => null,
            'heure_debut_vendredi' => null,
            'heure_debut_samedi' => null,
            'heure_debut_dimanche' => null,

            'heure_fin_lundi' => null,
            'heure_fin_mardi' => null,
            'heure_fin_mercredi' => null,
            'heure_fin_jeudi' => null,
            'heure_fin_vendredi' => null,
            'heure_fin_samedi' => null,
            'heure_fin_dimanche' => null,
        ]);
    }

    public function testUpdateNotOkId_activite_physiqueNull()
    {
        $id_activite_physique = null;
        $id_user = "4";
        $id_patient = "1";

        $a_activite_anterieure = "0";
        $a_activite_autonome = "0";
        $a_activite_encadree = "0";
        $a_activite_envisagee = "0";
        $a_activite_frein = "0";
        $a_activite_point_fort_levier = "0";

        $est_dispo_lundi = "0";
        $est_dispo_mardi = "0";
        $est_dispo_mercredi = "0";
        $est_dispo_jeudi = "0";
        $est_dispo_vendredi = "0";
        $est_dispo_samedi = "0";
        $est_dispo_dimanche = "0";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $update_ok = $this->activitePhysique->update([
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,
        ]);
        $this->assertFalse($update_ok);

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before, $activites_physiques_count_after);
    }

    public function testUpdateNotOkId_userNull()
    {
        $id_activite_physique = "1";
        $id_user = null;
        $id_patient = "1";

        $a_activite_anterieure = "0";
        $a_activite_autonome = "0";
        $a_activite_encadree = "0";
        $a_activite_envisagee = "0";
        $a_activite_frein = "0";
        $a_activite_point_fort_levier = "0";

        $est_dispo_lundi = "0";
        $est_dispo_mardi = "0";
        $est_dispo_mercredi = "0";
        $est_dispo_jeudi = "0";
        $est_dispo_vendredi = "0";
        $est_dispo_samedi = "0";
        $est_dispo_dimanche = "0";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $update_ok = $this->activitePhysique->update([
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,
        ]);
        $this->assertFalse($update_ok);

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before, $activites_physiques_count_after);
    }

    public function testUpdateNotOkId_patientNull()
    {
        $id_activite_physique = "1";
        $id_user = "4";
        $id_patient = null;

        $a_activite_anterieure = "0";
        $a_activite_autonome = "0";
        $a_activite_encadree = "0";
        $a_activite_envisagee = "0";
        $a_activite_frein = "0";
        $a_activite_point_fort_levier = "0";

        $est_dispo_lundi = "0";
        $est_dispo_mardi = "0";
        $est_dispo_mercredi = "0";
        $est_dispo_jeudi = "0";
        $est_dispo_vendredi = "0";
        $est_dispo_samedi = "0";
        $est_dispo_dimanche = "0";

        $activites_physiques_count_before = $this->tester->grabNumRecords('activites_physiques');

        $update_ok = $this->activitePhysique->update([
            'id_activite_physique' => $id_activite_physique,
            'id_user' => $id_user,
            'id_patient' => $id_patient,

            'a_activite_anterieure' => $a_activite_anterieure,
            'a_activite_autonome' => $a_activite_autonome,
            'a_activite_encadree' => $a_activite_encadree,
            'a_activite_envisagee' => $a_activite_envisagee,
            'a_activite_frein' => $a_activite_frein,
            'a_activite_point_fort_levier' => $a_activite_point_fort_levier,

            'est_dispo_lundi' => $est_dispo_lundi,
            'est_dispo_mardi' => $est_dispo_mardi,
            'est_dispo_mercredi' => $est_dispo_mercredi,
            'est_dispo_jeudi' => $est_dispo_jeudi,
            'est_dispo_vendredi' => $est_dispo_vendredi,
            'est_dispo_samedi' => $est_dispo_samedi,
            'est_dispo_dimanche' => $est_dispo_dimanche,
        ]);
        $this->assertFalse($update_ok);

        $activites_physiques_count_after = $this->tester->grabNumRecords('activites_physiques');

        $this->assertEquals($activites_physiques_count_before, $activites_physiques_count_after);
    }
}