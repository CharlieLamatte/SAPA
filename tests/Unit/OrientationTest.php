<?php

namespace Tests\Unit;

use Faker\Factory;
use Sportsante86\Sapa\Model\Orientation;
use Tests\Support\UnitTester;

class OrientationTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Orientation $orientation;

    private \Faker\Generator $faker;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->orientation = new Orientation($pdo);
        $this->assertNotNull($this->orientation);

        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(1234);
    }

    protected function _after()
    {
    }

    public function testReadAllActivitesChoisiesOk()
    {
        $id_patient = "12";

        $activites = $this->orientation->readAllActivitesChoisies($id_patient);
        $this->assertIsArray($activites);
        $this->assertNotEmpty($activites);

        foreach ($activites as $activite) {
            $this->assertArrayHasKey("id_activite_choisie", $activite);
            $this->assertArrayHasKey("statut", $activite);
            $this->assertArrayHasKey("commentaire", $activite);
            $this->assertArrayHasKey("date_demarrage", $activite);
            $this->assertArrayHasKey("id_orientation", $activite);
            $this->assertArrayHasKey("id_creneau", $activite);
            $this->assertArrayHasKey("id_territoire", $activite);
            $this->assertArrayHasKey("id_structure", $activite);
        }
    }

    public function testReadAllActivitesChoisiesOkid_patientInvalid()
    {
        $id_patient = "-1";

        $activites = $this->orientation->readAllActivitesChoisies($id_patient);
        $this->assertIsArray($activites);
        $this->assertEmpty($activites);
    }

    public function testReadAllActivitesChoisiesNotOkid_patientNull()
    {
        $id_patient = null;

        $activites = $this->orientation->readAllActivitesChoisies($id_patient);
        $this->assertFalse($activites);
    }

    public function testUpdateActivitesChoisiesOkNewOrientation()
    {
        $id_patient = "5";
        $activites = [
            [
                'commentaire' => $this->faker->text(200),
                'date_demarrage' => $this->faker->date('Y-m-d'),
                'id_creneau' => "1", // dans id_structure=1
                'statut' => $this->faker->randomElement(["En cours", "Testée", "En attente", "Terminée"]),
            ],
            [
                'commentaire' => $this->faker->text(200),
                'date_demarrage' => $this->faker->date('Y-m-d'),
                'id_creneau' => "2", // dans id_structure=1
                'statut' => $this->faker->randomElement(["En cours", "Testée", "En attente", "Terminée"]),
            ],
            [
                'commentaire' => $this->faker->text(200),
                'date_demarrage' => $this->faker->date('Y-m-d'),
                'id_creneau' => "6", // dans id_structure=4
                'statut' => $this->faker->randomElement(["En cours", "Testée", "En attente", "Terminée"]),
            ],
        ];

        // données connues
        $structures_ids = [1, 4];

        $update_ok = $this->orientation->updateActivitesChoisies([
            'id_patient' => $id_patient,
            'activites' => $activites,
        ]);
        $this->assertTrue($update_ok, $this->orientation->getErrorMessage());

        $id_orientation = $this->tester->grabFromDatabase(
            "orientation",
            "id_orientation",
            ["id_patient" => $id_patient]
        );

        $this->tester->seeInDatabase("orientation", [
            'id_orientation' => $id_orientation,
            'date_orientation' => date("Y-m-d"),
            'id_patient' => $id_patient,
        ]);

        foreach ($activites as $activite) {
            $this->tester->seeInDatabase("activite_choisie", [
                'commentaire' => $activite['commentaire'],
                'date_demarrage' => $activite['date_demarrage'],
                'id_creneau' => $activite['id_creneau'],
                'statut' => $activite['statut'],
                'id_orientation' => $id_orientation,
            ]);

            $this->tester->seeInDatabase("liste_participants_creneau", [
                'id_creneau' => $activite['id_creneau'],
                'id_patient' => $id_patient,
            ]);
        }

        foreach ($structures_ids as $id_structure) {
            $this->tester->seeInDatabase("oriente_vers", [
                'id_structure' => $id_structure,
                'id_patient' => $id_patient,
            ]);
        }
    }

    public function testUpdateActivitesChoisiesOkModifyOrientation()
    {
        $id_patient = "1";
        $activites = [
            [
                'commentaire' => $this->faker->text(200),
                'date_demarrage' => $this->faker->date('Y-m-d'),
                'id_creneau' => "1", // dans id_structure=1
                'statut' => $this->faker->randomElement(["En cours", "Testée", "En attente", "Terminée"]),
            ],
            [
                'commentaire' => $this->faker->text(200),
                'date_demarrage' => $this->faker->date('Y-m-d'),
                'id_creneau' => "2", // dans id_structure=1
                'statut' => $this->faker->randomElement(["En cours", "Testée", "En attente", "Terminée"]),
            ],
            [
                'commentaire' => $this->faker->text(200),
                'date_demarrage' => $this->faker->date('Y-m-d'),
                'id_creneau' => "6", // dans id_structure=4
                'statut' => $this->faker->randomElement(["En cours", "Testée", "En attente", "Terminée"]),
            ],
        ];

        // données connues
        $structures_ids = [1, 4];

        $update_ok = $this->orientation->updateActivitesChoisies([
            'id_patient' => $id_patient,
            'activites' => $activites,
        ]);
        $this->assertTrue($update_ok, $this->orientation->getErrorMessage());

        $id_orientation = $this->tester->grabFromDatabase(
            "orientation", "id_orientation",
            ["id_patient" => $id_patient]
        );

        $this->tester->seeInDatabase("orientation", [
            'id_orientation' => $id_orientation,
            'date_orientation' => date("Y-m-d"),
            'id_patient' => $id_patient,
        ]);

        foreach ($activites as $activite) {
            $this->tester->seeInDatabase("activite_choisie", [
                'commentaire' => $activite['commentaire'],
                'date_demarrage' => $activite['date_demarrage'],
                'id_creneau' => $activite['id_creneau'],
                'statut' => $activite['statut'],
                'id_orientation' => $id_orientation,
            ]);
        }

        foreach ($structures_ids as $id_structure) {
            $this->tester->seeInDatabase("oriente_vers", [
                'id_structure' => $id_structure,
                'id_patient' => $id_patient,
            ]);
        }

        //on vérifie que le bénéficiaire a bien été supprimé des listes dont il ne fait plus partie
        $id_creneau_absent = [4, 7];
        foreach ($id_creneau_absent as $id_creneau) {
            $this->tester->dontSeeInDatabase("liste_participants_creneau", [
                'id_creneau' => $id_creneau,
                'id_patient' => $id_patient,
            ]);
        }
    }

    public function testUpdateActivitesChoisiesOkEmptyArray()
    {
        $id_patient = "1";
        $activites = [];

        $update_ok = $this->orientation->updateActivitesChoisies([
            'id_patient' => $id_patient,
            'activites' => $activites,
        ]);
        $this->assertTrue($update_ok, $this->orientation->getErrorMessage());

        $id_orientation = $this->tester->grabFromDatabase(
            "orientation", "id_orientation",
            ["id_patient" => $id_patient]
        );

        $this->tester->seeInDatabase("orientation", [
            'id_orientation' => $id_orientation,
            'date_orientation' => date("Y-m-d"),
            'id_patient' => $id_patient,
        ]);

        $this->assertNotEmpty($id_orientation);

        $this->tester->dontSeeInDatabase("activite_choisie", [
            'id_orientation' => $id_orientation,
        ]);

        //on vérifie que le bénéficiaire a bien été supprimé des listes dont il ne fait plus partie
        $id_creneau_absent = [1, 2, 4, 6, 7];
        foreach ($id_creneau_absent as $id_creneau) {
            $this->tester->dontSeeInDatabase("liste_participants_creneau", [
                'id_creneau' => $id_creneau,
                'id_patient' => $id_patient,
            ]);
        }
    }

    public function testUpdateActivitesChoisiesNotOkId_patientNull()
    {
        $id_patient = null;
        $activites = [];

        $update_ok = $this->orientation->updateActivitesChoisies([
            'id_patient' => $id_patient,
            'activites' => $activites,
        ]);
        $this->assertFalse($update_ok, $this->orientation->getErrorMessage());
    }

    public function testUpdateActivitesChoisiesNotOkActivitesNull()
    {
        $id_patient = "1";
        $activites = null;

        $update_ok = $this->orientation->updateActivitesChoisies([
            'id_patient' => $id_patient,
            'activites' => $activites,
        ]);
        $this->assertFalse($update_ok, $this->orientation->getErrorMessage());
    }

    public function testGetMapUrlOkStructureHasUrl()
    {
        $id_patient = "1";

        // données connues
        $id_structure = "1"; // structure du patient

        $lien_ref_structure = $this->tester->grabFromDatabase(
            "structure", "lien_ref_structure",
            ["id_structure" => $id_structure]
        );

        $map_url = $this->orientation->getMapUrl($id_patient);
        $this->assertEquals($lien_ref_structure, $map_url);
    }

    public function testGetMapUrlOkStructureDoesntHaveUrl()
    {
        $id_patient = "4";

        // données connues
        $id_territoire = "1"; // territoire du patient

        $lien_ref_territoire = $this->tester->grabFromDatabase(
            "territoire", "lien_ref_territoire",
            ["id_territoire" => $id_territoire]
        );

        $map_url = $this->orientation->getMapUrl($id_patient);
        $this->assertEquals($lien_ref_territoire, $map_url);
    }

    public function testGetMapUrlOkId_patientNull()
    {
        $id_patient = null;

        $map_url = $this->orientation->getMapUrl($id_patient);
        $this->assertEquals(Orientation::DEFAULT_MAP_URL, $map_url);
    }
}