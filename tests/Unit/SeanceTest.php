<?php

namespace Tests\Unit;

use DateTime;
use Dotenv\Dotenv;
use Faker\Factory;
use PDO;
use Exception;
use Sportsante86\Sapa\Model\Creneau;
use Sportsante86\Sapa\Model\Orientation;
use Sportsante86\Sapa\Model\Seance;
use Tests\Support\UnitTester;

class SeanceTest extends \Codeception\Test\Unit
{
    use \Codeception\AssertThrows;

    protected UnitTester $tester;

    private PDO $pdo;
    private Seance $seance;
    private Orientation $orientation;

    private \Faker\Generator $faker;


    private string $root = __DIR__ . '/../..';

    protected function _before()
    {
        $this->pdo = $this->getModule('Db')->_getDbh();;
        $this->seance = new Seance($this->pdo);
        $this->assertNotNull($this->seance);
        $this->orientation = new Orientation($this->pdo);
        $this->assertNotNull($this->orientation);

        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(1234);

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

    public function testCreateOkMinimumDataDateDemarrageBeforeDateSeance()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date = "2022-07-07";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";
        // id_patient 1 et 4: date_demarrage = "2022-07-06"
        // id_patient 12: null
        $participants_ids = [1, 4, 12];

        $seance_count_before = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');

        $id_seance = $this->seance->create([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date' => $date,
        ]);
        $this->assertNotFalse($id_seance, $this->seance->getErrorMessage());

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + 1, $seance_count_after);
        // tous les participants doivent être ajoutés
        $this->assertEquals($a_participe_a_count_before + count($participants_ids), $a_participe_a_count_after);

        $this->tester->seeInDatabase('seance', [
            'id_creneau' => $id_creneau,
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date_seance' => $date,
            'commentaire_seance' => "",
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'validation_seance' => '0',
            'annulation_seance' => '0',
            'id_motif_annulation' => null,
        ]);

        foreach ($participants_ids as $id_patient) {
            $this->tester->seeInDatabase('a_participe_a', [
                'id_seance' => $id_seance,
                'id_patient' => $id_patient,
                'presence' => null,
                'excuse' => null,
            ]);
        }
    }

    public function testCreateOkMinimumDataDateDemarrageEgalDateSeance()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date = "2022-07-06";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";
        // id_patient 1 et 4: date_demarrage = "2022-07-06"
        // id_patient 12: null
        $participants_ids = [1, 4, 12];

        $seance_count_before = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');

        $id_seance = $this->seance->create([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date' => $date,
        ]);
        $this->assertNotFalse($id_seance, $this->seance->getErrorMessage());

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + 1, $seance_count_after);
        // tous les participants doivent être ajoutés
        $this->assertEquals($a_participe_a_count_before + count($participants_ids), $a_participe_a_count_after);

        $this->tester->seeInDatabase('seance', [
            'id_creneau' => $id_creneau,
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date_seance' => $date,
            'commentaire_seance' => "",
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'validation_seance' => '0',
            'annulation_seance' => '0',
            'id_motif_annulation' => null,
        ]);

        foreach ($participants_ids as $id_patient) {
            $this->tester->seeInDatabase('a_participe_a', [
                'id_seance' => $id_seance,
                'id_patient' => $id_patient,
                'presence' => null,
                'excuse' => null,
            ]);
        }
    }

    public function testCreateOkMinimumDataDateDemarrageAfterDateSeance()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date = "2022-07-05";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";
        // id_patient 1 et 4: date_demarrage = "2022-07-06"
        // id_patient 12: null
        $participants_ids = [12];
        $non_participants_ids = [1, 4];

        $seance_count_before = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');

        $id_seance = $this->seance->create([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date' => $date,
        ]);
        $this->assertNotFalse($id_seance, $this->seance->getErrorMessage());

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + 1, $seance_count_after);
        // seulement id_patient 12 doit être ajouté
        $this->assertEquals($a_participe_a_count_before + count($participants_ids), $a_participe_a_count_after);

        $this->tester->seeInDatabase('seance', [
            'id_creneau' => $id_creneau,
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date_seance' => $date,
            'commentaire_seance' => "",
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'validation_seance' => '0',
            'annulation_seance' => '0',
            'id_motif_annulation' => null,
        ]);

        foreach ($participants_ids as $id_patient) {
            $this->tester->seeInDatabase('a_participe_a', [
                'id_seance' => $id_seance,
                'id_patient' => $id_patient,
                'presence' => null,
                'excuse' => null,
            ]);
        }

        foreach ($non_participants_ids as $id_patient) {
            $this->tester->dontSeeInDatabase('a_participe_a', [
                'id_seance' => $id_seance,
                'id_patient' => $id_patient,
            ]);
        }
    }

    public function testCreateOkAllDataDateDemarrageBeforeDateSeance()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date = "2022-07-07";
        $commentaire = "Com";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";
        // id_patient 1 et 4: date_demarrage = "2022-07-06"
        // id_patient 12: null
        $participants_ids = [1, 4, 12];

        $seance_count_before = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');

        $id_seance = $this->seance->create([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date' => $date,
            'commentaire' => $commentaire,
        ]);
        $this->assertNotFalse($id_seance, $this->seance->getErrorMessage());

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + 1, $seance_count_after);
        // tous les participants doivent être ajoutés
        $this->assertEquals($a_participe_a_count_before + count($participants_ids), $a_participe_a_count_after);

        $this->tester->seeInDatabase('seance', [
            'id_creneau' => $id_creneau,
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date_seance' => $date,
            'commentaire_seance' => $commentaire,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'validation_seance' => '0',
            'annulation_seance' => '0',
            'id_motif_annulation' => null,
        ]);

        foreach ($participants_ids as $id_patient) {
            $this->tester->seeInDatabase('a_participe_a', [
                'id_seance' => $id_seance,
                'id_patient' => $id_patient,
                'presence' => null,
                'excuse' => null,
            ]);
        }
    }

    public function testCreateOkAllDataDateDemarrageBeforeDateSeanceActiviteDoublon1()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date = "2022-07-07";
        $commentaire = "Com";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";
        // id_patient 1: date_demarrage = "2022-07-06" et "2022-07-09" // la date minimum doit être prise en compte
        // id_patient 4: date_demarrage = "2022-07-06"
        // id_patient 12: null
        $participants_ids = [1, 4, 12];

        // enregistrement des activités du patient
        $id_patient = "1";
        $activites = [
            [
                'commentaire' => $this->faker->text(200),
                'date_demarrage' => "2022-07-09",
                'id_creneau' => "1",
                'statut' => $this->faker->randomElement(["En cours", "Testée", "En attente", "Terminée"]),
            ],
            [
                'commentaire' => $this->faker->text(200),
                'date_demarrage' => "2022-07-06",
                'id_creneau' => "1",
                'statut' => $this->faker->randomElement(["En cours", "Testée", "En attente", "Terminée"]),
            ],
        ];

        $update_ok = $this->orientation->updateActivitesChoisies([
            'id_patient' => $id_patient,
            'activites' => $activites,
        ]);
        $this->assertTrue($update_ok);

        $seance_count_before = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');

        $id_seance = $this->seance->create([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date' => $date,
            'commentaire' => $commentaire,
        ]);
        $this->assertNotFalse($id_seance, $this->seance->getErrorMessage());

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + 1, $seance_count_after);
        // tous les participants doivent être ajoutés
        $this->assertEquals($a_participe_a_count_before + count($participants_ids), $a_participe_a_count_after);

        $this->tester->seeInDatabase('seance', [
            'id_creneau' => $id_creneau,
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date_seance' => $date,
            'commentaire_seance' => $commentaire,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'validation_seance' => '0',
            'annulation_seance' => '0',
            'id_motif_annulation' => null,
        ]);

        foreach ($participants_ids as $id_patient) {
            $this->tester->seeInDatabase('a_participe_a', [
                'id_seance' => $id_seance,
                'id_patient' => $id_patient,
                'presence' => null,
                'excuse' => null,
            ]);
        }
    }

    public function testCreateOkAllDataDateDemarrageBeforeDateSeanceActiviteDoublon2()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date = "2022-07-07";
        $commentaire = "Com";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";
        // id_patient 1 et 4: date_demarrage = "2022-07-06"
        // id_patient 12: null et null
        $participants_ids = [1, 4, 12];

        // enregistrement des activités du patient
        $id_patient = "12";
        $activites = [
            [
                'commentaire' => $this->faker->text(200),
                'date_demarrage' => null,
                'id_creneau' => "1",
                'statut' => $this->faker->randomElement(["En cours", "Testée", "En attente", "Terminée"]),
            ],
            [
                'commentaire' => $this->faker->text(200),
                'date_demarrage' => null,
                'id_creneau' => "1",
                'statut' => $this->faker->randomElement(["En cours", "Testée", "En attente", "Terminée"]),
            ],
        ];

        $update_ok = $this->orientation->updateActivitesChoisies([
            'id_patient' => $id_patient,
            'activites' => $activites,
        ]);
        $this->assertTrue($update_ok);

        $seance_count_before = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');

        $id_seance = $this->seance->create([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date' => $date,
            'commentaire' => $commentaire,
        ]);
        $this->assertNotFalse($id_seance, $this->seance->getErrorMessage());

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + 1, $seance_count_after);
        // tous les participants doivent être ajoutés
        $this->assertEquals($a_participe_a_count_before + count($participants_ids), $a_participe_a_count_after);

        $this->tester->seeInDatabase('seance', [
            'id_creneau' => $id_creneau,
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date_seance' => $date,
            'commentaire_seance' => $commentaire,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'validation_seance' => '0',
            'annulation_seance' => '0',
            'id_motif_annulation' => null,
        ]);

        foreach ($participants_ids as $id_patient) {
            $this->tester->seeInDatabase('a_participe_a', [
                'id_seance' => $id_seance,
                'id_patient' => $id_patient,
                'presence' => null,
                'excuse' => null,
            ]);
        }
    }

    public function testCreateNotOkMissingId_creneau()
    {
        $id_creneau = null;
        $id_user = "3";
        $date = "2022-04-26";

        $seance_count_before = $this->tester->grabNumRecords('seance');

        $id_seance = $this->seance->create([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date' => $date,
        ]);
        $this->assertFalse($id_seance);

        $seance_count_after = $this->tester->grabNumRecords('seance');

        $this->assertEquals($seance_count_before, $seance_count_after);
    }

    public function testCreateNotOkMissingId_user()
    {
        $id_creneau = "1";
        $id_user = null;
        $date = "2022-04-26";

        $seance_count_before = $this->tester->grabNumRecords('seance');

        $id_seance = $this->seance->create([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date' => $date,
        ]);
        $this->assertFalse($id_seance);

        $seance_count_after = $this->tester->grabNumRecords('seance');

        $this->assertEquals($seance_count_before, $seance_count_after);
    }

    public function testCreateNotOkMissingDate()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date = null;

        $seance_count_before = $this->tester->grabNumRecords('seance');

        $id_seance = $this->seance->create([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date' => $date,
        ]);
        $this->assertFalse($id_seance);

        $seance_count_after = $this->tester->grabNumRecords('seance');

        $this->assertEquals($seance_count_before, $seance_count_after);
    }

    public function testCreateBetweenTwoDatesOk1()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date_start = "2022-04-19";
        $date_end = "2022-04-26";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";
        // id_patient 1 et 4: date_demarrage = "2022-07-06"
        // id_patient 12: null
        $participants_ids = [12];

        $seance_count_expected = 2;
        $participants_creneau_count = count($participants_ids);

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->createBetweenTwoDates([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + $seance_count_expected, $seance_count_after);
        $this->assertEquals(
            $a_participe_a_count_before + $participants_creneau_count * $seance_count_expected,
            $a_participe_a_count_after
        );

        $begin = new DateTime($date_start);

        for ($i = 0; $i < count($ids); $i++) {
            $this->tester->seeInDatabase('seance', [
                'id_creneau' => $id_creneau,
                'id_seance' => $ids[$i],
                'id_user' => $id_user,
                'date_seance' => $begin->format('Y-m-d'),
                'commentaire_seance' => "",
                'heure_debut' => $heure_debut,
                'heure_fin' => $heure_fin,
                'validation_seance' => '0',
                'annulation_seance' => '0',
                'id_motif_annulation' => null,
            ]);

            foreach ($participants_ids as $id_patient) {
                $this->tester->seeInDatabase('a_participe_a', [
                    'id_seance' => $ids[$i],
                    'id_patient' => $id_patient,
                    'presence' => null,
                    'excuse' => null,
                    'commentaire' => null,
                ]);
            }

            $begin = $begin->modify('+7 day');
        }
    }

    public function testCreateBetweenTwoDatesOk2()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date_start = "2022-07-12";
        $date_end = "2022-07-19";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";
        // id_patient 1 et 4: date_demarrage = "2022-07-06"
        // id_patient 12: null
        $participants_ids = [1, 4, 12];

        $seance_count_expected = 2;
        $participants_creneau_count = count($participants_ids);

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->createBetweenTwoDates([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + $seance_count_expected, $seance_count_after);
        $this->assertEquals(
            $a_participe_a_count_before + $participants_creneau_count * $seance_count_expected,
            $a_participe_a_count_after
        );

        $begin = new DateTime($date_start);

        for ($i = 0; $i < count($ids); $i++) {
            $this->tester->seeInDatabase('seance', [
                'id_creneau' => $id_creneau,
                'id_seance' => $ids[$i],
                'id_user' => $id_user,
                'date_seance' => $begin->format('Y-m-d'),
                'commentaire_seance' => "",
                'heure_debut' => $heure_debut,
                'heure_fin' => $heure_fin,
                'validation_seance' => '0',
                'annulation_seance' => '0',
                'id_motif_annulation' => null,
            ]);

            foreach ($participants_ids as $id_patient) {
                $this->tester->seeInDatabase('a_participe_a', [
                    'id_seance' => $ids[$i],
                    'id_patient' => $id_patient,
                    'presence' => null,
                    'excuse' => null,
                    'commentaire' => null,
                ]);
            }

            $begin = $begin->modify('+7 day');
        }
    }

    public function testCreateBetweenTwoDatesOk3()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date_start = "2022-07-05";
        $date_end = "2022-07-12";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";
        // id_patient 1 et 4: date_demarrage = "2022-07-06"
        // id_patient 12: null
        $participants_ids_seance1 = [12];
        $participants_ids_seance2 = [1, 4, 12];

        $seance_count_expected = 2;
        $participants_creneau_count_seance1 = count($participants_ids_seance1);
        $participants_creneau_count_seance2 = count($participants_ids_seance2);

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->createBetweenTwoDates([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + $seance_count_expected, $seance_count_after);
        $this->assertEquals(
            $a_participe_a_count_before + $participants_creneau_count_seance1 + $participants_creneau_count_seance2,
            $a_participe_a_count_after
        );

        $begin = new DateTime($date_start);

        // seance 1
        $this->tester->seeInDatabase('seance', [
            'id_creneau' => $id_creneau,
            'id_seance' => $ids[0],
            'id_user' => $id_user,
            'date_seance' => $begin->format('Y-m-d'),
            'commentaire_seance' => "",
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'validation_seance' => '0',
            'annulation_seance' => '0',
            'id_motif_annulation' => null,
        ]);

        foreach ($participants_ids_seance1 as $id_patient) {
            $this->tester->seeInDatabase('a_participe_a', [
                'id_seance' => $ids[0],
                'id_patient' => $id_patient,
                'presence' => null,
                'excuse' => null,
                'commentaire' => null,
            ]);
        }

        $begin = $begin->modify('+7 day');

        // seance 2
        $this->tester->seeInDatabase('seance', [
            'id_creneau' => $id_creneau,
            'id_seance' => $ids[1],
            'id_user' => $id_user,
            'date_seance' => $begin->format('Y-m-d'),
            'commentaire_seance' => "",
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'validation_seance' => '0',
            'annulation_seance' => '0',
            'id_motif_annulation' => null,
        ]);

        foreach ($participants_ids_seance2 as $id_patient) {
            $this->tester->seeInDatabase('a_participe_a', [
                'id_seance' => $ids[1],
                'id_patient' => $id_patient,
                'presence' => null,
                'excuse' => null,
                'commentaire' => null,
            ]);
        }
    }

    public function testCreateBetweenTwoDatesOkNoSeanceCreated()
    {
        $id_creneau = "1"; // mardi
        $id_user = "3";
        $date_start = "2022-08-17";
        $date_end = "2022-08-19";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";

        $seance_count_expected = 0;
        $participants_creneau_count = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_creneau' => $id_creneau]
        );

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->createBetweenTwoDates([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + $seance_count_expected, $seance_count_after);
        $this->assertEquals(
            $a_participe_a_count_before + $participants_creneau_count * $seance_count_expected,
            $a_participe_a_count_after
        );
    }

    public function testCreateBetweenTwoDatesOkCreneauTousLesJours()
    {
        $id_creneau = "8"; // tous les jours
        $id_user = "3";
        $date_start = "2022-08-18";
        $date_end = "2022-08-21";

        // info creneau 8
        $heure_debut = "6";
        $heure_fin = "18";

        $seance_count_expected = 4;
        $participants_creneau_count = 0;

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->createBetweenTwoDates([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + $seance_count_expected, $seance_count_after, 'a');
        $this->assertEquals(
            $a_participe_a_count_before + $participants_creneau_count * $seance_count_expected,
            $a_participe_a_count_after,
            'b'
        );

        $begin = new DateTime($date_start);

        for ($i = 0; $i < count($ids); $i++) {
            $this->tester->seeInDatabase('seance', [
                'id_creneau' => $id_creneau,
                'id_seance' => $ids[$i],
                'id_user' => $id_user,
                'date_seance' => $begin->format('Y-m-d'),
                'commentaire_seance' => "",
                'heure_debut' => $heure_debut,
                'heure_fin' => $heure_fin,
                'validation_seance' => '0',
                'annulation_seance' => '0',
                'id_motif_annulation' => null,
            ], 'c');

            $begin = $begin->modify('+1 day');
        }
    }

    public function testCreateBetweenTwoDatesOkEndDate1dayAfterStartDate()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date_start = "2022-07-12";
        $date_end = "2022-07-13";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";
        // id_patient 1 et 4: date_demarrage = "2022-07-06"
        // id_patient 12: null
        $participants_ids = [1, 4, 12];

        $seance_count_expected = 1;
        $participants_creneau_count = count($participants_ids);

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->createBetweenTwoDates([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);
        $this->assertCount($seance_count_expected, $ids);

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + $seance_count_expected, $seance_count_after);
        $this->assertEquals(
            $a_participe_a_count_before + $participants_creneau_count * $seance_count_expected,
            $a_participe_a_count_after
        );

        $begin = new DateTime($date_start);

        for ($i = 0; $i < count($ids); $i++) {
            $this->tester->seeInDatabase('seance', [
                'id_creneau' => $id_creneau,
                'id_seance' => $ids[$i],
                'id_user' => $id_user,
                'date_seance' => $begin->format('Y-m-d'),
                'commentaire_seance' => "",
                'heure_debut' => $heure_debut,
                'heure_fin' => $heure_fin,
                'validation_seance' => '0',
                'annulation_seance' => '0',
                'id_motif_annulation' => null,
            ]);

            foreach ($participants_ids as $id_patient) {
                $this->tester->seeInDatabase('a_participe_a', [
                    'id_seance' => $ids[$i],
                    'id_patient' => $id_patient,
                    'presence' => null,
                    'excuse' => null,
                    'commentaire' => null,
                ]);
            }

            $begin = $begin->modify('+7 day');
        }
    }

    public function testCreateBetweenTwoDatesOkEndDateBeforeStartDate()
    {
        $id_creneau = "1";
        $id_user = "3";
        $date_start = "2022-04-19";
        $date_end = "2022-04-18";

        // info creneau 1
        $heure_debut = "2";
        $heure_fin = "10";

        $seance_count_expected = 0;

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->createBetweenTwoDates([
            'id_creneau' => $id_creneau,
            'id_user' => $id_user,
            'date_start' => $date_start,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);
        $this->assertCount($seance_count_expected, $ids);

        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_after = $this->tester->grabNumRecords('seance');

        $this->assertEquals($seance_count_before + $seance_count_expected, $seance_count_after);
        $this->assertEquals(
            $a_participe_a_count_before,
            $a_participe_a_count_after
        );
    }

    public function testDuplicateSeanceOk1()
    {
        $id_seance = "1";
        $date_end = "2022-04-26";

        // info seance 1
        $id_creneau = "6";
        $heure_debut = "9";
        $heure_fin = "17";
        $date = "2022-03-28";
        $id_user = "3";
        $commentaire = "commentaire seance";

        $seance_count_expected = 4;
        // id_patient 1: date_demarrage = "2022-07-06"
        $participants_ids = [];
        $participants_creneau_count = 0;

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->duplicateSeance([
            'id_seance' => $id_seance,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + $seance_count_expected, $seance_count_after);
        $this->assertEquals($a_participe_a_count_before, $a_participe_a_count_after);

        $begin = new DateTime($date);
        $begin = $begin->modify('+7 day');

        for ($i = 0; $i < count($ids); $i++) {
            $this->tester->seeInDatabase('seance', [
                'id_creneau' => $id_creneau,
                'id_seance' => $ids[$i],
                'id_user' => $id_user,
                'date_seance' => $begin->format('Y-m-d'),
                'commentaire_seance' => $commentaire,
                'heure_debut' => $heure_debut,
                'heure_fin' => $heure_fin,
                'validation_seance' => '0',
                'annulation_seance' => '0',
                'id_motif_annulation' => null,
            ]);

            $begin = $begin->modify('+7 day');
        }
    }

    public function testDuplicateSeanceOkCreneauTousLesJours()
    {
        $id_seance = "6";
        $date_end = "2022-08-21";

        // info seance 6
        $id_creneau = "8";
        $heure_debut = "6";
        $heure_fin = "18";
        $date = "2022-08-18";
        $id_user = "3";
        $commentaire = "commentaire seance";

        $seance_count_expected = 3;
        $participants_creneau_count = 0;

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->duplicateSeance([
            'id_seance' => $id_seance,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before + $seance_count_expected, $seance_count_after, 'a');
        $this->assertEquals(
            $a_participe_a_count_before + $participants_creneau_count * $seance_count_expected,
            $a_participe_a_count_after,
            'b'
        );

        $begin = new DateTime($date);
        $begin = $begin->modify('+1 day');

        for ($i = 0; $i < count($ids); $i++) {
            $this->tester->seeInDatabase('seance', [
                'id_creneau' => $id_creneau,
                'id_seance' => $ids[$i],
                'id_user' => $id_user,
                'date_seance' => $begin->format('Y-m-d'),
                'commentaire_seance' => $commentaire,
                'heure_debut' => $heure_debut,
                'heure_fin' => $heure_fin,
                'validation_seance' => '0',
                'annulation_seance' => '0',
                'id_motif_annulation' => null,
            ], 'c');

            $begin = $begin->modify('+1 day');
        }
    }

    public function testDuplicateSeanceOkEndDate1dayAfterSeanceDate()
    {
        $id_seance = "1";
        $date_end = "2022-03-29";

        // info seance 1
        $date = "2022-03-28";
        $id_creneau = "6";

        $seance_count_expected = 0;

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->duplicateSeance([
            'id_seance' => $id_seance,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);
        $this->assertCount($seance_count_expected, $ids);

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before, $seance_count_after);
        $this->assertEquals($a_participe_a_count_before, $a_participe_a_count_after);
    }

    public function testDuplicateSeanceOkEndDateBeforeSeanceDate()
    {
        $id_seance = "1";
        $date_end = "2022-03-27";

        // info seance 1
        $date = "2022-03-28";
        $id_creneau = "6";

        $seance_count_expected = 0;

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');
        $seance_count_before = $this->tester->grabNumRecords('seance');

        $ids = $this->seance->duplicateSeance([
            'id_seance' => $id_seance,
            'date_end' => $date_end,
        ]);
        $this->assertIsArray($ids);
        $this->assertCount($seance_count_expected, $ids);

        $seance_count_after = $this->tester->grabNumRecords('seance');
        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($seance_count_before, $seance_count_after);
        $this->assertEquals($a_participe_a_count_before, $a_participe_a_count_after);
    }

    public function testReadAllOk()
    {
        $id_user = "3";

        $seances = $this->seance->readAll($id_user);
        $this->assertIsArray($seances);

        $seance_count = $this->tester->grabNumRecords('seance', ['id_user' => $id_user, 'annulation_seance' => "0"]);
        $this->assertCount($seance_count, $seances);
        $this->assertTrue(count($seances) > 0);

        $this->assertArrayHasKey('nom_creneau', $seances[0]);
        $this->assertArrayHasKey('nom_structure', $seances[0]);
        $this->assertArrayHasKey('id_type_parcours', $seances[0]);
        $this->assertArrayHasKey('nb_participant', $seances[0]);
        $this->assertArrayHasKey('nom_intervenant', $seances[0]);
        $this->assertArrayHasKey('prenom_intervenant', $seances[0]);
        $this->assertArrayHasKey('id_structure', $seances[0]);
        $this->assertArrayHasKey('nom_structure', $seances[0]);
        $this->assertArrayHasKey('adresse', $seances[0]);
        $this->assertArrayHasKey('complement_adresse', $seances[0]);
        $this->assertArrayHasKey('code_postal', $seances[0]);
        $this->assertArrayHasKey('nom_ville', $seances[0]);
        $this->assertArrayHasKey('type_seance', $seances[0]);
        $this->assertArrayHasKey('type_parcours', $seances[0]);
        $this->assertArrayHasKey('jour', $seances[0]);
        $this->assertArrayHasKey('nom_jour', $seances[0]);
        $this->assertArrayHasKey('id_heure_debut', $seances[0]);
        $this->assertArrayHasKey('id_heure_fin', $seances[0]);
        $this->assertArrayHasKey('id_user', $seances[0]);
        $this->assertArrayHasKey('date_seance', $seances[0]);
        $this->assertArrayHasKey('id_seance', $seances[0]);
        $this->assertArrayHasKey('id_creneau', $seances[0]);
        $this->assertArrayHasKey('heure_debut', $seances[0]);
        $this->assertArrayHasKey('heure_fin', $seances[0]);
        $this->assertArrayHasKey('valider', $seances[0]);
        $this->assertArrayHasKey('commentaire_seance', $seances[0]);
    }

    public function testReadAllOkInvalidId_user()
    {
        $id_user = "-1";

        $seances = $this->seance->readAll($id_user);
        $this->assertIsArray($seances);

        $seance_count = $this->tester->grabNumRecords('seance', ['id_user' => $id_user]);
        $this->assertCount($seance_count, $seances);
        $this->assertTrue(count($seances) == 0);
    }

    public function testReadAllNotOkId_userNull()
    {
        $id_user = null;

        $seances = $this->seance->readAll($id_user);
        $this->assertFalse($seances);
    }

    public function testReadOneOk()
    {
        $id_seance = "1";

        $seance = $this->seance->readOne($id_seance);
        $this->assertIsArray($seance);

        $this->assertArrayHasKey('nom_creneau', $seance);
        $this->assertArrayHasKey('nom_structure', $seance);
        $this->assertArrayHasKey('id_type_parcours', $seance);
        $this->assertArrayHasKey('nb_participant', $seance);
        $this->assertArrayHasKey('nom_intervenant', $seance);
        $this->assertArrayHasKey('prenom_intervenant', $seance);
        $this->assertArrayHasKey('id_structure', $seance);
        $this->assertArrayHasKey('nom_structure', $seance);
        $this->assertArrayHasKey('adresse', $seance);
        $this->assertArrayHasKey('complement_adresse', $seance);
        $this->assertArrayHasKey('code_postal', $seance);
        $this->assertArrayHasKey('nom_ville', $seance);
        $this->assertArrayHasKey('type_seance', $seance);
        $this->assertArrayHasKey('type_parcours', $seance);
        $this->assertArrayHasKey('jour', $seance);
        $this->assertArrayHasKey('nom_jour', $seance);
        $this->assertArrayHasKey('id_heure_debut', $seance);
        $this->assertArrayHasKey('id_heure_fin', $seance);
        $this->assertArrayHasKey('id_user', $seance);
        $this->assertArrayHasKey('date_seance', $seance);
        $this->assertArrayHasKey('id_seance', $seance);
        $this->assertArrayHasKey('id_creneau', $seance);
        $this->assertArrayHasKey('heure_debut', $seance);
        $this->assertArrayHasKey('heure_fin', $seance);
        $this->assertArrayHasKey('valider', $seance);
        $this->assertArrayHasKey('commentaire_seance', $seance);
        $this->assertArrayHasKey('etat', $seance);
        $this->assertArrayHasKey('motif_annulation', $seance);
    }

    public function testReadOneNotOkId_seanceNull()
    {
        $id_seance = null;

        $seance = $this->seance->readOne($id_seance);
        $this->assertFalse($seance);
    }

    public function testReadMultipleOk()
    {
        $ids = ["1"];

        $seances = $this->seance->readMultiple($ids);
        $this->assertIsArray($seances);
        $this->assertCount(1, $seances);


        $this->assertArrayHasKey('nom_creneau', $seances[0]);
        $this->assertArrayHasKey('nom_structure', $seances[0]);
        $this->assertArrayHasKey('id_type_parcours', $seances[0]);
        $this->assertArrayHasKey('nb_participant', $seances[0]);
        $this->assertArrayHasKey('nom_intervenant', $seances[0]);
        $this->assertArrayHasKey('prenom_intervenant', $seances[0]);
        $this->assertArrayHasKey('id_structure', $seances[0]);
        $this->assertArrayHasKey('nom_structure', $seances[0]);
        $this->assertArrayHasKey('adresse', $seances[0]);
        $this->assertArrayHasKey('complement_adresse', $seances[0]);
        $this->assertArrayHasKey('code_postal', $seances[0]);
        $this->assertArrayHasKey('nom_ville', $seances[0]);
        $this->assertArrayHasKey('type_seance', $seances[0]);
        $this->assertArrayHasKey('type_parcours', $seances[0]);
        $this->assertArrayHasKey('jour', $seances[0]);
        $this->assertArrayHasKey('nom_jour', $seances[0]);
        $this->assertArrayHasKey('id_heure_debut', $seances[0]);
        $this->assertArrayHasKey('id_heure_fin', $seances[0]);
        $this->assertArrayHasKey('id_user', $seances[0]);
        $this->assertArrayHasKey('date_seance', $seances[0]);
        $this->assertArrayHasKey('id_seance', $seances[0]);
        $this->assertArrayHasKey('id_creneau', $seances[0]);
        $this->assertArrayHasKey('heure_debut', $seances[0]);
        $this->assertArrayHasKey('heure_fin', $seances[0]);
        $this->assertArrayHasKey('valider', $seances[0]);
        $this->assertArrayHasKey('commentaire_seance', $seances[0]);
        $this->assertArrayHasKey('etat', $seances[0]);
        $this->assertArrayHasKey('motif_annulation', $seances[0]);
    }

    public function testReadMultipleOkInvalidId()
    {
        $ids = ["-1"];

        $seances = $this->seance->readMultiple($ids);
        $this->assertIsArray($seances);
        $this->assertCount(0, $seances);
    }

    public function testReadMultipleNotOkIdsNull()
    {
        $ids = null;

        $seances = $this->seance->readMultiple($ids);
        $this->assertFalse($seances);
    }

    public function testReadMultipleNotOkIdsEmpty()
    {
        $ids = [];

        $seances = $this->seance->readMultiple($ids);
        $this->assertFalse($seances);
    }

    public function testCancelSeanceOK()
    {
        $id_seance = "1";
        $motif_annulation = "1";

        $cancel_ok = $this->seance->cancelSeance([
            'motif_annulation' => $motif_annulation,
            'id_seance' => $id_seance,
        ]);
        $this->assertTrue($cancel_ok);

        $this->tester->seeInDatabase('seance', [
            'id_seance' => $id_seance,
            'annulation_seance' => '1',
            'id_motif_annulation' => '1',
        ]);
    }

    public function testCancelSeanceNotOkMotif_annulationNull()
    {
        $id_seance = "1";
        $motif_annulation = null;

        $cancel_ok = $this->seance->cancelSeance([
            'motif_annulation' => $motif_annulation,
            'id_seance' => $id_seance,
        ]);
        $this->assertFalse($cancel_ok);
    }

    public function testCancelSeanceNotOkId_seanceNull()
    {
        $id_seance = null;
        $motif_annulation = "1";

        $cancel_ok = $this->seance->cancelSeance([
            'motif_annulation' => $motif_annulation,
            'id_seance' => $id_seance,
        ]);
        $this->assertFalse($cancel_ok);
    }

    public function testCancelSeanceNotOkMotif_annulationInvalid()
    {
        $id_seance = "1";
        $motif_annulation = "-1";

        $cancel_ok = $this->seance->cancelSeance([
            'motif_annulation' => $motif_annulation,
            'id_seance' => $id_seance,
        ]);
        $this->assertFalse($cancel_ok);
    }

    public function testValidateSeanceOk()
    {
        $id_seance = "1";

        $validate_ok = $this->seance->validateSeance($id_seance);

        $this->assertTrue($validate_ok);

        $this->tester->seeInDatabase('seance', [
            'id_seance' => $id_seance,
            'validation_seance' => '1',
        ]);
    }

    public function testValidateSeanceNotOkId_seanceNull()
    {
        $id_seance = null;

        $validate_ok = $this->seance->validateSeance($id_seance);
        $this->assertFalse($validate_ok);
    }

    public function testEmargeSeanceOK()
    {
        $id_seance = '1';
        $emargements = [
            [
                'id_patient' => '1',
                'present' => '1',
                'excuse' => null,
                'commentaire' => 'commentaire ok',
            ],
            [
                'id_patient' => '4',
                'present' => '0',
                'excuse' => '1',
                'commentaire' => 'commentaire ok',
            ],
            [
                'id_patient' => '5',
                'present' => '0',
                'excuse' => '0',
                'commentaire' => 'commentaire ok',
            ]
        ];

        $emarge_ok = $this->seance->emargeSeance([
            'id_seance' => $id_seance,
            'emargements' => $emargements,
        ]);
        $this->assertTrue($emarge_ok);

        foreach ($emargements as $emargement) {
            $this->tester->seeInDatabase('a_participe_a', [
                'id_seance' => $id_seance,
                'id_patient' => $emargement['id_patient'],
                'presence' => $emargement['present'],
                'excuse' => $emargement['excuse'],
                'commentaire' => $emargement['commentaire']
            ]);
        }
    }

    public function testEmargeSeanceOKEmptyEmargements()
    {
        $id_seance = '1';
        $emargements = [];

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');

        $emarge_ok = $this->seance->emargeSeance([
            'id_seance' => $id_seance,
            'emargements' => $emargements,
        ]);
        $this->assertTrue($emarge_ok);

        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($a_participe_a_count_before, $a_participe_a_count_after);
    }

    public function testEmargeSeanceNotOKEmargementsNull()
    {
        $id_seance = '1';
        $emargements = null;

        $emarge_ok = $this->seance->emargeSeance([
            'id_seance' => $id_seance,
            'emargements' => $emargements,
        ]);
        $this->assertFalse($emarge_ok);
    }

    public function testEmargeSeanceNotOKId_seanceNull()
    {
        $id_seance = null;
        $emargements = [
            [
                'id_patient' => '1',
                'present' => '1',
                'excuse' => null,
                'commentaire' => 'commentaire ok',
            ]
        ];

        $emarge_ok = $this->seance->emargeSeance([
            'id_seance' => $id_seance,
            'emargements' => $emargements,
        ]);
        $this->assertFalse($emarge_ok);
    }

    public function testReadParticipantsOk()
    {
        $id_seance = '3';

        $participants = $this->seance->readParticipants($id_seance);
        $this->assertIsArray($participants);
        $this->assertCount(2, $participants);

        foreach ($participants as $participant) {
            $this->assertArrayHasKey('id_patient', $participant);
            $this->assertArrayHasKey('presence', $participant);
            $this->assertArrayHasKey('excuse', $participant);
            $this->assertArrayHasKey('commentaire', $participant);
            $this->assertArrayHasKey('id_coordonnees', $participant);
            $this->assertArrayHasKey('nom_patient', $participant);
            $this->assertArrayHasKey('prenom_patient', $participant);
            $this->assertArrayHasKey('mail_coordonnees', $participant);
            $this->assertArrayHasKey('telephone', $participant);
            $this->assertArrayHasKey('date_admission', $participant);
            $this->assertArrayHasKey('valider', $participant);
            $this->assertArrayHasKey('prenom_medecin', $participant);
            $this->assertArrayHasKey('nom_medecin', $participant);
            $this->assertArrayHasKey('nom_antenne', $participant);
        }

        // test tri alphabétique
        $this->assertEquals("DERIVE", $participants[0]["nom_patient"]);
        $this->assertEquals("NOMPATIENT", $participants[1]["nom_patient"]);
    }

    public function testReadParticipantsOkEmptyResult()
    {
        $id_seance = '1';

        $participants = $this->seance->readParticipants($id_seance);
        $this->assertIsArray($participants);
        $this->assertEmpty($participants);
    }

    public function testReadParticipantsNotOkId_seanceNull()
    {
        $id_seance = null;

        $participants = $this->seance->readParticipants($id_seance);
        $this->assertFalse($participants);
    }

    public function testUpdateSeanceOkMinimumData()
    {
        $id_seance = '1';
        $date = '2022-06-20';
        $heure_debut = "07:15:00";
        $id_heure_debut = "3";
        $heure_fin = "08:15:00";
        $id_heure_fin = "7";

        $update_ok = $this->seance->update([
            'id_seance' => $id_seance,
            'date' => $date,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('seance', [
            'id_seance' => $id_seance,
            //'id_user' => $id_user,
            'date_seance' => $date,
            //'commentaire_seance' => "",
            'heure_debut' => $id_heure_debut,
            'heure_fin' => $id_heure_fin,
            //'validation_seance' => $validation,
        ]);
    }

    public function testUpdateSeanceOkAllData()
    {
        $id_seance = '1';
        $id_user = '3';
        $date = '2022-06-27';
        $heure_debut = "07:15:00";
        $id_heure_debut = "3";
        $heure_fin = "08:15:00";
        $id_heure_fin = "7";
        $commentaire = 'Commentaire pertinent dfgdfg';

        $update_ok = $this->seance->update([
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date' => $date,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'commentaire' => $commentaire,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('seance', [
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date_seance' => $date,
            'commentaire_seance' => $commentaire,
            'heure_debut' => $id_heure_debut,
            'heure_fin' => $id_heure_fin,
        ]);
    }

    public function testUpdateSeanceNotOkId_seanceNull()
    {
        $id_seance = null;
        $id_user = '3';
        $date = '2022-05-03';
        $validation = '0';
        $heure_debut = "07:15:00";
        $heure_fin = "08:15:00";
        $commentaire = 'Commentaire pertinent';

        $update_ok = $this->seance->update([
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date' => $date,
            'validation' => $validation,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'commentaire' => $commentaire,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateSeanceNotOkDateNull()
    {
        $id_seance = '1';
        $id_user = '3';
        $date = null;
        $validation = '0';
        $heure_debut = "07:15:00";
        $heure_fin = "08:15:00";
        $commentaire = 'Commentaire pertinent';

        $update_ok = $this->seance->update([
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date' => $date,
            'validation' => $validation,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'commentaire' => $commentaire,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateSeanceNotOkHeure_debutNull()
    {
        $id_seance = '1';
        $id_user = '3';
        $date = '2022-05-03';
        $validation = '0';
        $heure_debut = null;
        $heure_fin = "08:15:00";
        $commentaire = 'Commentaire pertinent';

        $update_ok = $this->seance->update([
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date' => $date,
            'validation' => $validation,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'commentaire' => $commentaire,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateSeanceNotOkHeure_finNull()
    {
        $id_seance = '1';
        $id_user = '3';
        $date = '2022-05-03';
        $validation = '0';
        $heure_debut = "07:15:00";
        $heure_fin = null;
        $commentaire = 'Commentaire pertinent';

        $update_ok = $this->seance->update([
            'id_seance' => $id_seance,
            'id_user' => $id_user,
            'date' => $date,
            'validation' => $validation,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'commentaire' => $commentaire,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateParticipantsSeanceOkReplacePatient()
    {
        $participants = ["4"];
        $id_seance = '4';

        $a_participe_a_before = $this->tester->grabColumnFromDatabase(
            'a_participe_a',
            "id_patient",
            ['id_seance' => $id_seance]
        );
        $this->assertEqualsCanonicalizing(["1"], $a_participe_a_before);

        $add_ok = $this->seance->updateParticipantsSeance([
            'id_seance' => $id_seance,
            'participants' => $participants,
        ]);
        $this->assertTrue($add_ok);

        $a_participe_a_after = $this->tester->grabColumnFromDatabase(
            'a_participe_a',
            "id_patient",
            ['id_seance' => $id_seance]
        );
        $this->assertEqualsCanonicalizing(["4"], $a_participe_a_after);
    }

    public function testUpdateParticipantsSeanceOkEmptyParticipants()
    {
        $participants = [];
        $id_seance = '4';

        $a_participe_a_before = $this->tester->grabColumnFromDatabase(
            'a_participe_a',
            "id_patient",
            ['id_seance' => $id_seance]
        );
        $this->assertEqualsCanonicalizing(["1"], $a_participe_a_before);

        $add_ok = $this->seance->updateParticipantsSeance([
            'id_seance' => $id_seance,
            'participants' => $participants,
        ]);
        $this->assertTrue($add_ok);

        $a_participe_a_after = $this->tester->grabColumnFromDatabase(
            'a_participe_a',
            "id_patient",
            ['id_seance' => $id_seance]
        );
        $this->assertEqualsCanonicalizing([], $a_participe_a_after);
    }

    public function testUpdateParticipantsSeanceOkSameParticipants()
    {
        $participants = ["1"];
        $id_seance = '4';

        $a_participe_a_before = $this->tester->grabColumnFromDatabase(
            'a_participe_a',
            "id_patient",
            ['id_seance' => $id_seance]
        );
        $this->assertEqualsCanonicalizing(["1"], $a_participe_a_before);

        $add_ok = $this->seance->updateParticipantsSeance([
            'id_seance' => $id_seance,
            'participants' => $participants,
        ]);
        $this->assertTrue($add_ok);

        $a_participe_a_after = $this->tester->grabColumnFromDatabase(
            'a_participe_a',
            "id_patient",
            ['id_seance' => $id_seance]
        );
        $this->assertEqualsCanonicalizing(["1"], $a_participe_a_after);
    }

    public function testUpdateParticipantsSeanceOkAddOne()
    {
        $participants = ["1", "4"];
        $id_seance = '4';

        $a_participe_a_before = $this->tester->grabColumnFromDatabase(
            'a_participe_a',
            "id_patient",
            ['id_seance' => $id_seance]
        );
        $this->assertEqualsCanonicalizing(["1"], $a_participe_a_before);

        $add_ok = $this->seance->updateParticipantsSeance([
            'id_seance' => $id_seance,
            'participants' => $participants,
        ]);
        $this->assertTrue($add_ok);

        $a_participe_a_after = $this->tester->grabColumnFromDatabase(
            'a_participe_a',
            "id_patient",
            ['id_seance' => $id_seance]
        );
        $this->assertEqualsCanonicalizing(["1", "4"], $a_participe_a_after);
    }

    public function testUpdateParticipantsSeanceOkAddTwo()
    {
        $participants = ["1", "4", "5"];
        $id_seance = '4';

        $a_participe_a_before = $this->tester->grabColumnFromDatabase(
            'a_participe_a',
            "id_patient",
            ['id_seance' => $id_seance]
        );
        $this->assertEqualsCanonicalizing(["1"], $a_participe_a_before);

        $add_ok = $this->seance->updateParticipantsSeance([
            'id_seance' => $id_seance,
            'participants' => $participants,
        ]);
        $this->assertTrue($add_ok);

        $a_participe_a_after = $this->tester->grabColumnFromDatabase(
            'a_participe_a',
            "id_patient",
            ['id_seance' => $id_seance]
        );
        $this->assertEqualsCanonicalizing(["1", "4", "5"], $a_participe_a_after);
    }

    public function testUpdateParticipantsSeanceNotOkParticipantsNull()
    {
        $participants = null;
        $id_seance = '4';

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');

        $add_ok = $this->seance->updateParticipantsSeance([
            'id_seance' => $id_seance,
            'participants' => $participants,
        ]);

        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertFalse($add_ok);

        $this->assertEquals($a_participe_a_count_before, $a_participe_a_count_after);
    }

    public function testUpdateParticipantsSeanceNotOkId_seanceNull()
    {
        $participants = ["4"];
        $id_seance = null;

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');

        $add_ok = $this->seance->updateParticipantsSeance([
            'id_seance' => $id_seance,
            'participants' => $participants,
        ]);

        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertFalse($add_ok);

        $this->assertEquals($a_participe_a_count_before, $a_participe_a_count_after);
    }

    public function testReadAllStructureOkCurrentWeek()
    {
        $id_structure = '4';
        $today = '2022-07-09';

        $seances = $this->seance->readAllStructure($id_structure, $today);
        $this->assertIsArray($seances);

        $seance_count_expected = 3; // 3 in current week
        $this->assertCount($seance_count_expected, $seances);
        $this->assertNotEmpty($seances);

        $this->assertArrayHasKey('nom_creneau', $seances[0]);
        $this->assertArrayHasKey('nom_structure', $seances[0]);
        $this->assertArrayHasKey('id_type_parcours', $seances[0]);
        $this->assertArrayHasKey('nb_participant', $seances[0]);
        $this->assertArrayHasKey('nom_intervenant', $seances[0]);
        $this->assertArrayHasKey('prenom_intervenant', $seances[0]);
        $this->assertArrayHasKey('id_structure', $seances[0]);
        $this->assertArrayHasKey('nom_structure', $seances[0]);
        $this->assertArrayHasKey('adresse', $seances[0]);
        $this->assertArrayHasKey('complement_adresse', $seances[0]);
        $this->assertArrayHasKey('code_postal', $seances[0]);
        $this->assertArrayHasKey('nom_ville', $seances[0]);
        $this->assertArrayHasKey('type_seance', $seances[0]);
        $this->assertArrayHasKey('type_parcours', $seances[0]);
        $this->assertArrayHasKey('jour', $seances[0]);
        $this->assertArrayHasKey('nom_jour', $seances[0]);
        $this->assertArrayHasKey('id_heure_debut', $seances[0]);
        $this->assertArrayHasKey('id_heure_fin', $seances[0]);
        $this->assertArrayHasKey('id_user', $seances[0]);
        $this->assertArrayHasKey('date_seance', $seances[0]);
        $this->assertArrayHasKey('id_seance', $seances[0]);
        $this->assertArrayHasKey('id_creneau', $seances[0]);
        $this->assertArrayHasKey('heure_debut', $seances[0]);
        $this->assertArrayHasKey('heure_fin', $seances[0]);
        $this->assertArrayHasKey('valider', $seances[0]);
        $this->assertArrayHasKey('commentaire_seance', $seances[0]);
        $this->assertArrayHasKey('nom_antenne', $seances[0]);
        $this->assertArrayHasKey('week_number', $seances[0]);
    }

    public function testReadAllStructureOkPreviousWeek()
    {
        $id_structure = '4';
        $today = '2022-07-11';

        $seances = $this->seance->readAllStructure($id_structure, $today);
        $this->assertIsArray($seances);

        $seance_count_expected = 2; // 2 in previous week
        $this->assertCount($seance_count_expected, $seances);
        $this->assertNotEmpty($seances);

        $this->assertArrayHasKey('nom_creneau', $seances[0]);
        $this->assertArrayHasKey('nom_structure', $seances[0]);
        $this->assertArrayHasKey('id_type_parcours', $seances[0]);
        $this->assertArrayHasKey('nb_participant', $seances[0]);
        $this->assertArrayHasKey('nom_intervenant', $seances[0]);
        $this->assertArrayHasKey('prenom_intervenant', $seances[0]);
        $this->assertArrayHasKey('id_structure', $seances[0]);
        $this->assertArrayHasKey('nom_structure', $seances[0]);
        $this->assertArrayHasKey('adresse', $seances[0]);
        $this->assertArrayHasKey('complement_adresse', $seances[0]);
        $this->assertArrayHasKey('code_postal', $seances[0]);
        $this->assertArrayHasKey('nom_ville', $seances[0]);
        $this->assertArrayHasKey('type_seance', $seances[0]);
        $this->assertArrayHasKey('type_parcours', $seances[0]);
        $this->assertArrayHasKey('jour', $seances[0]);
        $this->assertArrayHasKey('nom_jour', $seances[0]);
        $this->assertArrayHasKey('id_heure_debut', $seances[0]);
        $this->assertArrayHasKey('id_heure_fin', $seances[0]);
        $this->assertArrayHasKey('id_user', $seances[0]);
        $this->assertArrayHasKey('date_seance', $seances[0]);
        $this->assertArrayHasKey('id_seance', $seances[0]);
        $this->assertArrayHasKey('id_creneau', $seances[0]);
        $this->assertArrayHasKey('heure_debut', $seances[0]);
        $this->assertArrayHasKey('heure_fin', $seances[0]);
        $this->assertArrayHasKey('valider', $seances[0]);
        $this->assertArrayHasKey('commentaire_seance', $seances[0]);
        $this->assertArrayHasKey('nom_antenne', $seances[0]);
        $this->assertArrayHasKey('week_number', $seances[0]);
    }

    public function testReadAllStructureOkNextWeek()
    {
        $id_structure = '4';
        $today = '2022-06-27';

        $seances = $this->seance->readAllStructure($id_structure, $today);
        $this->assertIsArray($seances);

        $seance_count_expected = 3; // 3 in next week
        $this->assertCount($seance_count_expected, $seances);
        $this->assertNotEmpty($seances);

        $this->assertArrayHasKey('nom_creneau', $seances[0]);
        $this->assertArrayHasKey('nom_structure', $seances[0]);
        $this->assertArrayHasKey('id_type_parcours', $seances[0]);
        $this->assertArrayHasKey('nb_participant', $seances[0]);
        $this->assertArrayHasKey('nom_intervenant', $seances[0]);
        $this->assertArrayHasKey('prenom_intervenant', $seances[0]);
        $this->assertArrayHasKey('id_structure', $seances[0]);
        $this->assertArrayHasKey('nom_structure', $seances[0]);
        $this->assertArrayHasKey('adresse', $seances[0]);
        $this->assertArrayHasKey('complement_adresse', $seances[0]);
        $this->assertArrayHasKey('code_postal', $seances[0]);
        $this->assertArrayHasKey('nom_ville', $seances[0]);
        $this->assertArrayHasKey('type_seance', $seances[0]);
        $this->assertArrayHasKey('type_parcours', $seances[0]);
        $this->assertArrayHasKey('jour', $seances[0]);
        $this->assertArrayHasKey('nom_jour', $seances[0]);
        $this->assertArrayHasKey('id_heure_debut', $seances[0]);
        $this->assertArrayHasKey('id_heure_fin', $seances[0]);
        $this->assertArrayHasKey('id_user', $seances[0]);
        $this->assertArrayHasKey('date_seance', $seances[0]);
        $this->assertArrayHasKey('id_seance', $seances[0]);
        $this->assertArrayHasKey('id_creneau', $seances[0]);
        $this->assertArrayHasKey('heure_debut', $seances[0]);
        $this->assertArrayHasKey('heure_fin', $seances[0]);
        $this->assertArrayHasKey('valider', $seances[0]);
        $this->assertArrayHasKey('commentaire_seance', $seances[0]);
        $this->assertArrayHasKey('nom_antenne', $seances[0]);
        $this->assertArrayHasKey('week_number', $seances[0]);
    }

    public function testReadAllStructureOkEmpty()
    {
        // test 1
        $id_structure = '4';
        $today = '2022-07-18';

        $seances = $this->seance->readAllStructure($id_structure, $today);
        $this->assertIsArray($seances);
        $this->assertEmpty($seances, "a");

        // test 2
        $id_structure = '4';
        $today = '2022-06-13';

        $seances = $this->seance->readAllStructure($id_structure, $today);
        $this->assertIsArray($seances);
        $this->assertEmpty($seances, "b");
    }

    public function testReadAllStructureOkInvalidId_user()
    {
        $id_structure = '-1';
        $today = '2022-07-09';

        $seances = $this->seance->readAllStructure($id_structure, $today);
        $this->assertIsArray($seances);
        $this->assertEmpty($seances);
    }

    public function testReadAllStructureNotOkId_structureNull()
    {
        $id_structure = null;
        $today = '2022-07-09';

        $seances = $this->seance->readAllStructure($id_structure, $today);
        $this->assertFalse($seances);
    }

    public function testReadAllStructureNotOkTodayNull()
    {
        $id_structure = '4';
        $today = null;

        $seances = $this->seance->readAllStructure($id_structure, $today);
        $this->assertFalse($seances);
    }

    public function testGetAllSeanceEmargementLateOk()
    {
        // test 1
        $min_days = 1;
        $today = "2022-03-29";
        $ids_expected = ["1"];

        $ids = $this->seance->getAllSeanceEmargementLate($min_days, $today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids);

        // test 2
        $min_days = 4;
        $today = "2022-04-01";
        $ids_expected = ["1"];

        $ids = $this->seance->getAllSeanceEmargementLate($min_days, $today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids);

        // test 3
        $min_days = 2;
        $today = "2022-07-06";
        $ids_expected = ["3", "4"];

        $ids = $this->seance->getAllSeanceEmargementLate($min_days, $today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids);
    }

    public function testGetAllSeanceEmargementLateNotOkMin_daysZero()
    {
        $min_days = 0;
        $today = "2022-03-28"; // il y a une séance le "2022-03-28"
        $ids_expected = [];

        $ids = $this->seance->getAllSeanceEmargementLate($min_days, $today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids);
    }

    public function testGetAllSeanceEmargementLateNotOkMin_daysNull()
    {
        $min_days = null;
        $today = "2022-03-29";
        $ids_expected = [];

        $ids = $this->seance->getAllSeanceEmargementLate($min_days, $today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids);
    }

    public function testGetAllSeanceEmargementLateNotOkTodayNull()
    {
        $min_days = 1;
        $today = null;
        $ids_expected = [];

        $ids = $this->seance->getAllSeanceEmargementLate($min_days, $today);
        $this->assertIsArray($ids);
        $this->assertEquals($ids_expected, $ids);
    }

    public function testGetFirstValidDateOk()
    {
        // test creneau lundi
        $id_creneau = "3"; // lundi

        $date = "2022-08-15";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-15", $first_valid_date, 'test creneau lundi 1');

        $date = "2022-08-14";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-15", $first_valid_date, 'test creneau lundi 2');

        $date = "2022-08-09";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-15", $first_valid_date, 'test creneau lundi 3');

        $date = "2022-08-16";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-22", $first_valid_date, 'test creneau lundi 1');

        // test creneau tous
        $id_creneau = "8"; // tous les jours

        $date = "2022-08-15";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-15", $first_valid_date, 'test creneau tous les jours 1');

        $date = "2022-08-14";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-14", $first_valid_date, 'test creneau tous les jours 2');

        $date = "2022-08-09";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-09", $first_valid_date, 'test creneau tous les jours 3');

        $date = "2022-08-16";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-16", $first_valid_date, 'test creneau tous les jours 4');

        // test creneau dimanche
        $id_creneau = "7"; // dimanche

        $date = "2022-08-21";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-21", $first_valid_date, 'test creneau dimanche 1');

        $date = "2022-08-20";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-21", $first_valid_date, 'test creneau dimanche 2');

        $date = "2022-08-22";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-28", $first_valid_date, 'test dimanche lundi 3');

        $date = "2022-08-27";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-28", $first_valid_date, 'test dimanche lundi 1');

        // test creneau vendredi
        $id_creneau = "4"; // vendredi

        $date = "2022-08-19";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-19", $first_valid_date, 'test creneau vendredi 1');

        $date = "2022-08-18";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-19", $first_valid_date, 'test creneau vendredi 2');

        $date = "2022-08-20";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-26", $first_valid_date, 'test dimanche vendredi 3');

        $date = "2022-08-25";
        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertEquals("2022-08-26", $first_valid_date, 'test dimanche vendredi 1');
    }

    public function testGetFirstValidDateNotOkId_creneauNull()
    {
        $id_creneau = null;
        $date = "2022-08-15";

        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertNull($first_valid_date);
    }

    public function testGetFirstValidDateNotOkDateNull()
    {
        $id_creneau = "3"; // lundi
        $date = null;

        $first_valid_date = $this->seance->getFirstValidDate($date, $id_creneau);
        $this->assertNull($first_valid_date);
    }

    public function testUpdateParticipantsSeancesAfterOk()
    {
        // precondition: la fonction $creneau->updateParticipants est correcte

        // update 1
        $id_creneau = "6";
        $participants = [
            [
                'id_patient' => "1",
                'abandon' => "0",
                'propose_inscrit' => "0",
                'reorientation' => "0",
                'status_participant' => "PEPS",
            ],
            [
                'id_patient' => "4",
                'abandon' => "0",
                'propose_inscrit' => "0",
                'reorientation' => "0",
                'status_participant' => "PEPS",
            ],
            [
                'id_patient' => "12",
                'abandon' => "0",
                'propose_inscrit' => "0",
                'reorientation' => "0",
                'status_participant' => "PEPS",
            ],
        ];

        $creneau = new Creneau($this->pdo);
        $this->assertNotNull($creneau);
        $update_participants_creneau_ok = $creneau->updateParticipants($id_creneau, $participants);
        $this->assertTrue($update_participants_creneau_ok);

        // il y a 2 séances le 2022-07-04 (qui ont des patients dans a_participe_a)
        $date = "2022-07-03";

        $update_participants_future_ok = $this->seance->updateParticipantsSeancesAfter($date, $id_creneau);
        $this->assertTrue($update_participants_future_ok);

        $seances_futures = $this->tester->grabColumnFromDatabase(
            'seance',
            'id_seance',
            ['date_seance >' => $date, 'id_creneau' => $id_creneau]
        );
        $this->assertCount(2, $seances_futures);

        foreach ($seances_futures as $id_seance) {
            foreach ($participants as $participant) {
                $this->tester->seeInDatabase('a_participe_a', [
                    'id_patient' => $participant['id_patient'],
                    'id_seance' => $id_seance,
                ]);
            }
        }

        // update 2
        $id_creneau = "6";
        $participants = [
            [
                'id_patient' => "1",
                'abandon' => "0",
                'propose_inscrit' => "0",
                'reorientation' => "0",
                'status_participant' => "PEPS",
            ],
        ];

        $creneau = new Creneau($this->pdo);
        $this->assertNotNull($creneau);
        $update_participants_creneau_ok = $creneau->updateParticipants($id_creneau, $participants);
        $this->assertTrue($update_participants_creneau_ok);

        // il y a 2 séances le 2022-07-04 (qui ont des patients dans a_participe_a)
        $date = "2022-07-03";

        $update_participants_future_ok = $this->seance->updateParticipantsSeancesAfter($date, $id_creneau);
        $this->assertTrue($update_participants_future_ok);

        $seances_futures = $this->tester->grabColumnFromDatabase(
            'seance',
            'id_seance',
            ['date_seance >' => $date, 'id_creneau' => $id_creneau]
        );
        $this->assertCount(2, $seances_futures);

        foreach ($seances_futures as $id_seance) {
            foreach ($participants as $participant) {
                $this->tester->seeInDatabase('a_participe_a', [
                    'id_patient' => $participant['id_patient'],
                    'id_seance' => $id_seance,
                ]);
            }
        }
    }

    public function testUpdateParticipantsSeancesAfterOkRemoveAllParticipants()
    {
        // precondition: la fonction $creneau->updateParticipants est correcte

        $id_creneau = "6";
        $participants = [];

        $creneau = new Creneau($this->pdo);
        $this->assertNotNull($creneau);
        $update_participants_creneau_ok = $creneau->updateParticipants($id_creneau, $participants);
        $this->assertTrue($update_participants_creneau_ok);

        // il y a 3 séances le 2022-07-04 (qui ont des patients dans a_participe_a)
        $date = "2022-07-03";

        $update_participants_future_ok = $this->seance->updateParticipantsSeancesAfter($date, $id_creneau);
        $this->assertTrue($update_participants_future_ok);

        $seances_futures = $this->tester->grabColumnFromDatabase(
            'seance',
            'id_seance',
            ['date_seance >' => $date, 'id_creneau' => $id_creneau]
        );

        foreach ($seances_futures as $id_seance) {
            $a_participe_a_count = $this->tester->grabNumRecords('a_participe_a', ['id_seance' => $id_seance]);
            $this->assertEquals(0, $a_participe_a_count, 'b');
        }
    }

    public function testUpdateParticipantsSeancesAfterOkNothingToUpdate()
    {
        // precondition: la fonction $creneau->updateParticipants est correcte

        $id_creneau = "6";
        $participants = [];

        $creneau = new Creneau($this->pdo);
        $this->assertNotNull($creneau);
        $update_participants_creneau_ok = $creneau->updateParticipants($id_creneau, $participants);
        $this->assertTrue($update_participants_creneau_ok);

        // il y a 2 séances le 2022-07-04 (qui ont des patients dans a_participe_a) et aucune après,
        // donc rien à update
        $date = "2022-07-04";

        $seances_futures = $this->tester->grabColumnFromDatabase(
            'seance',
            'id_seance',
            ['date_seance >' => $date, 'id_creneau' => $id_creneau]
        );
        $this->assertCount(0, $seances_futures);

        $a_participe_a_count_before = $this->tester->grabNumRecords('a_participe_a');

        $update_participants_future_ok = $this->seance->updateParticipantsSeancesAfter($date, $id_creneau);
        $this->assertTrue($update_participants_future_ok);

        $a_participe_a_count_after = $this->tester->grabNumRecords('a_participe_a');

        $this->assertEquals($a_participe_a_count_before, $a_participe_a_count_after); // rien de modifié
    }

    public function testUpdateParticipantsSeancesAfterNotOkId_creneauNull()
    {
        $id_creneau = null;
        // il y a 3 séances le 2022-07-04 (qui ont des patients dans a_participe_a)
        $date = "2022-07-03";

        $update_participants_future_ok = $this->seance->updateParticipantsSeancesAfter($date, $id_creneau);
        $this->assertFalse($update_participants_future_ok);
    }

    public function testUpdateParticipantsSeancesAfterNotOkDateNull()
    {
        $id_creneau = "6";
        // il y a 3 séances le 2022-07-04 (qui ont des patients dans a_participe_a)
        $date = null;

        $update_participants_future_ok = $this->seance->updateParticipantsSeancesAfter($date, $id_creneau);
        $this->assertFalse($update_participants_future_ok);
    }

    function testUpdateSeancesAfterOk()
    {
        // test 1
        $id_creneau = "6";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $nom_adresse = "78 rue carrée";
        $jour = "2";
        $heure_debut = "5";
        $heure_fin = "8";
        $type_creneau = "2";
        $id_structure = "2";
        $intervenant_ids = ["1"];
        $pathologie = "Surpoids";
        $type_seance = "Individuel";
        $activation = "0";

        $creneau = new Creneau($this->pdo);
        $this->assertNotNull($creneau);
        $update_ok = $creneau->update([
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'nom_adresse' => $nom_adresse,
            'jour' => $jour,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'type_creneau' => $type_creneau,
            'id_structure' => $id_structure,
            'intervenant_ids' => $intervenant_ids,
            'pathologie' => $pathologie,
            'type_seance' => $type_seance,
            'activation' => $activation,
        ]);
        $this->assertTrue($update_ok);

        // il y a 2 séances le 2022-07-04
        $date = "2022-07-03";

        $update_ok = $this->seance->updateSeancesAfter($date, $id_creneau);
        $this->assertTrue($update_ok, $this->seance->getErrorMessage());

        $seances_futures = $this->tester->grabColumnFromDatabase(
            'seance',
            'id_seance',
            ['date_seance >' => $date, 'id_creneau' => $id_creneau]
        );
        $this->assertCount(2, $seances_futures);

        foreach ($seances_futures as $id_seance) {
            $this->tester->seeInDatabase('seance', [
                'id_seance' => $id_seance,
                'heure_debut' => $heure_debut,
                'heure_fin' => $heure_fin,
            ]);
        }

        // test 2
        $id_creneau = "6";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $nom_adresse = "78 rue carrée";
        $jour = "2";
        $heure_debut = "2";
        $heure_fin = "3";
        $type_creneau = "2";
        $id_structure = "2";
        $intervenant_ids = ["1"];
        $pathologie = "Surpoids";
        $type_seance = "Individuel";
        $activation = "0";

        $creneau = new Creneau($this->pdo);
        $this->assertNotNull($creneau);
        $update_ok = $creneau->update([
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'nom_adresse' => $nom_adresse,
            'jour' => $jour,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'type_creneau' => $type_creneau,
            'id_structure' => $id_structure,
            'intervenant_ids' => $intervenant_ids,
            'pathologie' => $pathologie,
            'type_seance' => $type_seance,
            'activation' => $activation,
        ]);
        $this->assertTrue($update_ok);

        // il y a 2 séances le 2022-07-04
        $date = "2022-07-03";

        $update_ok = $this->seance->updateSeancesAfter($date, $id_creneau);
        $this->assertTrue($update_ok, $this->seance->getErrorMessage());

        $seances_futures = $this->tester->grabColumnFromDatabase(
            'seance',
            'id_seance',
            ['date_seance >' => $date, 'id_creneau' => $id_creneau]
        );
        $this->assertCount(2, $seances_futures);

        foreach ($seances_futures as $id_seance) {
            $this->tester->seeInDatabase('seance', [
                'id_seance' => $id_seance,
                'heure_debut' => $heure_debut,
                'heure_fin' => $heure_fin,
            ]);
        }
    }

    function testUpdateSeancesAfterOkNothingToUpdate()
    {
        $id_creneau = "6";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $nom_adresse = "78 rue carrée";
        $jour = "2";
        $heure_debut = "1";
        $heure_fin = "1";
        $type_creneau = "2";
        $id_structure = "2";
        $intervenant_ids = ["1"];
        $pathologie = "Surpoids";
        $type_seance = "Individuel";
        $activation = "0";

        $creneau = new Creneau($this->pdo);
        $this->assertNotNull($creneau);
        $update_ok = $creneau->update([
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'nom_adresse' => $nom_adresse,
            'jour' => $jour,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'type_creneau' => $type_creneau,
            'id_structure' => $id_structure,
            'intervenant_ids' => $intervenant_ids,
            'pathologie' => $pathologie,
            'type_seance' => $type_seance,
            'activation' => $activation,
        ]);
        $this->assertTrue($update_ok);

        // il y a 2 séances le 2022-07-04 et aucune après, donc rien à update
        $date = "2022-07-04";

        $update_ok = $this->seance->updateSeancesAfter($date, $id_creneau);
        $this->assertTrue($update_ok, $this->seance->getErrorMessage());

        $seances_futures = $this->tester->grabColumnFromDatabase(
            'seance',
            'id_seance',
            ['date_seance >' => $date, 'id_creneau' => $id_creneau]
        );
        $this->assertCount(0, $seances_futures);

        // il n'y a aucune séance qui ont heure_debut=1 et heure_fin=1 dans la BDD
        $this->tester->dontSeeInDatabase('seance', [
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
        ]);
    }

    public function testUpdateSeancesAfterNotOkId_creneauNull()
    {
        $id_creneau = null;
        // il y a 2 séances le 2022-07-04 (qui ont des patients dans a_participe_a)
        $date = "2022-07-03";

        $update_ok = $this->seance->updateSeancesAfter($date, $id_creneau);
        $this->assertFalse($update_ok);
    }

    public function testUpdateSeancesAfterNotOkDateNull()
    {
        $id_creneau = "6";
        // il y a 3 séances le 2022-07-04 (qui ont des patients dans a_participe_a)
        $date = null;

        $update_ok = $this->seance->updateSeancesAfter($date, $id_creneau);
        $this->assertFalse($update_ok);
    }

    public function testIsJourValidOk()
    {
        $id_creneau = "1"; // mardi
        $date = "2022-12-27"; // mardi

        $is_valid = $this->seance->isDateValid($id_creneau, $date);
        $this->assertTrue($is_valid);

        $id_creneau = "1"; // mardi
        $date = "2022-12-28"; // mercredi

        $is_valid = $this->seance->isDateValid($id_creneau, $date);
        $this->assertFalse($is_valid);
    }

    public function testIsJourValidNotOkId_creneauNull()
    {
        $id_creneau = null;
        $date = "2022-12-27";

        $is_valid = $this->seance->isDateValid($id_creneau, $date);
        $this->assertFalse($is_valid);
    }

    public function testIsJourValidNotOkDateNull()
    {
        $id_creneau = "1";
        $date = null;

        $is_valid = $this->seance->isDateValid($id_creneau, $date);
        $this->assertFalse($is_valid);
    }

    public function testIsJourValidNotOkId_creneauInvalid()
    {
        $id_creneau = "-1";
        $date = "2022-12-27";

        $is_valid = $this->seance->isDateValid($id_creneau, $date);
        $this->assertFalse($is_valid);
    }

    public function testIsJourValidNotOkDateInvalid()
    {
        $id_creneau = "1";
        $date = "2022-12-274";

        $is_valid = $this->seance->isDateValid($id_creneau, $date);
        $this->assertFalse($is_valid);
    }

    public function testDeleteAllSeancesUserOk()
    {
        $id_user = '3';

        $seance_ids = $this->tester->grabColumnFromDatabase(
            'seance',
            'id_seance',
            ['id_user' => $id_user]
        );

        $this->seance->deleteAllSeancesUser($id_user);

        $this->tester->dontSeeInDatabase('seance', [
            'id_user' => $id_user,
        ]);

        foreach ($seance_ids as $id_seance) {
            $this->tester->dontSeeInDatabase('a_participe_a', [
                'id_seance' => $id_seance,
            ]);
        }
    }

    public function testDeleteAllSeancesUserNotOkId_userNull()
    {
        $this->assertThrowsWithMessage(
            Exception::class,
            "Error missing id_user",
            function () {
                $id_user = null;
                $this->seance->deleteAllSeancesUser($id_user);
            }
        );
    }
}