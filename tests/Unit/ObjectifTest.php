<?php

namespace Sportsante86\Sapa\tests\Unit;

use Faker\Factory;
use Sportsante86\Sapa\Model\Objectif;
use Tests\Support\UnitTester;

class ObjectifTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Objectif $objecif;

    private $faker = null;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->objecif = new Objectif($pdo);
        $this->assertNotNull($this->objecif);

        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(445);
    }

    protected function _after()
    {
    }

    public function testCreateOkMinimumData()
    {
        // obligatoire
        $id_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Encadrée';
        $id_user = "2";

        $id_obj_patient = $this->objecif->create([
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,
        ]);

        $this->assertNotFalse($id_obj_patient, $this->objecif->getErrorMessage());

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,
        ]);
    }

    public function testCreateOkAllData()
    {
        // obligatoire
        $id_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Autonome';
        $id_user = "2";

        // obligatoire si $pratique == 'Autonome'
        $type_activite = 'Autonome';
        $duree = $this->faker->date('h:i') . ':00';
        $frequence = $this->faker->text(200);
        $infos_complementaires = $this->faker->text(1000);

        $id_obj_patient = $this->objecif->create([
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,

            'type_activite' => $type_activite,
            'duree' => $duree,
            'frequence' => $frequence,
            'infos_complementaires' => $infos_complementaires,
        ]);

        $this->assertNotFalse($id_obj_patient, $this->objecif->getErrorMessage());

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,

            'type_activite' => $type_activite,
            'duree' => $duree,
            'frequence' => $frequence,
            'infos_complementaires' => $infos_complementaires,
        ]);
    }

    public function testCreateNotOkId_patientNull()
    {
        // obligatoire
        $id_patient = null;
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Encadrée';
        $id_user = "2";

        $id_obj_patient = $this->objecif->create([
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,
        ]);

        $this->assertFalse($id_obj_patient, $this->objecif->getErrorMessage());
    }

    public function testCreateNotOkNom_objectifNull()
    {
        // obligatoire
        $id_patient = "1";
        $nom_objectif = null;
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Encadrée';
        $id_user = "2";

        $id_obj_patient = $this->objecif->create([
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,
        ]);

        $this->assertFalse($id_obj_patient, $this->objecif->getErrorMessage());
    }

    public function testCreateNotOkDate_objectif_patientNull()
    {
        // obligatoire
        $id_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = null;
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Encadrée';
        $id_user = "2";

        $id_obj_patient = $this->objecif->create([
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,
        ]);

        $this->assertFalse($id_obj_patient, $this->objecif->getErrorMessage());
    }

    public function testCreateNotOkDesc_objectifNull()
    {
        // obligatoire
        $id_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = null;
        $pratique = 'Encadrée';
        $id_user = "2";

        $id_obj_patient = $this->objecif->create([
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,
        ]);

        $this->assertFalse($id_obj_patient, $this->objecif->getErrorMessage());
    }

    public function testCreateNotOkPratiqueNull()
    {
        // obligatoire
        $id_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = null;
        $id_user = "2";

        $id_obj_patient = $this->objecif->create([
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,
        ]);

        $this->assertFalse($id_obj_patient, $this->objecif->getErrorMessage());
    }

    public function testCreateNotOkPratiqueInvalid()
    {
        // obligatoire
        $id_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = "sdffds";
        $id_user = "2";

        $id_obj_patient = $this->objecif->create([
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,
        ]);

        $this->assertFalse($id_obj_patient, $this->objecif->getErrorMessage());
    }

    public function testCreateNotOkId_userNull()
    {
        // obligatoire
        $id_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Encadrée';
        $id_user = null;

        $id_obj_patient = $this->objecif->create([
            'id_patient' => $id_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
            'id_user' => $id_user,
        ]);

        $this->assertFalse($id_obj_patient, $this->objecif->getErrorMessage());
    }

    function testReadOneOk()
    {
        $id_obj_patient = "1";

        $obj_patient = $this->objecif->readOne($id_obj_patient);
        $this->assertIsArray($obj_patient);
        $this->assertArrayHasKey("id_obj_patient", $obj_patient);
        $this->assertArrayHasKey("id_patient", $obj_patient);
        $this->assertArrayHasKey("date_objectif_patient", $obj_patient);
        $this->assertArrayHasKey("date_objectif_patient_formated", $obj_patient);
        $this->assertArrayHasKey("nom_objectif", $obj_patient);
        $this->assertArrayHasKey("desc_objectif", $obj_patient);
        $this->assertArrayHasKey("pratique", $obj_patient);
        $this->assertArrayHasKey("termine", $obj_patient);
        $this->assertArrayHasKey("id_user", $obj_patient);
        $this->assertArrayHasKey("type_activite", $obj_patient);
        $this->assertArrayHasKey("duree", $obj_patient);
        $this->assertArrayHasKey("frequence", $obj_patient);
        $this->assertArrayHasKey("infos_complementaires", $obj_patient);
    }

    function testReadOneNotOkId_obj_patientNull()
    {
        $id_obj_patient = null;

        $obj_patient = $this->objecif->readOne($id_obj_patient);
        $this->assertFalse($obj_patient);
    }

    function testReadOneNotOkId_obj_patientInvalid()
    {
        $id_obj_patient = "-1";

        $obj_patient = $this->objecif->readOne($id_obj_patient);
        $this->assertFalse($obj_patient);
    }

    public function testReadAllOk()
    {
        $id_patient = "1";

        $objectifs = $this->objecif->readAll($id_patient);
        $this->assertIsArray($objectifs);

        foreach ($objectifs as $objectif) {
            $this->assertIsArray($objectif);
            $this->assertArrayHasKey("id_obj_patient", $objectif);
            $this->assertArrayHasKey("id_patient", $objectif);
            $this->assertArrayHasKey("date_objectif_patient", $objectif);
            $this->assertArrayHasKey("date_objectif_patient_formated", $objectif);
            $this->assertArrayHasKey("nom_objectif", $objectif);
            $this->assertArrayHasKey("desc_objectif", $objectif);
            $this->assertArrayHasKey("pratique", $objectif);
            $this->assertArrayHasKey("termine", $objectif);
            $this->assertArrayHasKey("id_user", $objectif);
            $this->assertArrayHasKey("type_activite", $objectif);
            $this->assertArrayHasKey("duree", $objectif);
            $this->assertArrayHasKey("frequence", $objectif);
            $this->assertArrayHasKey("infos_complementaires", $objectif);

            $this->assertArrayHasKey("avancements", $objectif);
            $this->assertIsArray($objectif["avancements"]);
            foreach ($objectif["avancements"] as $avancement) {
                $this->assertArrayHasKey("id_avancement_obj", $avancement);
                $this->assertArrayHasKey("date_avancement", $avancement);
                $this->assertArrayHasKey("commentaires", $avancement);
                $this->assertArrayHasKey("id_obj_patient", $avancement);
            }
        }
    }

    public function testReadAllOkEmpty()
    {
        $id_patient = "5";

        $objectifs = $this->objecif->readAll($id_patient);
        $this->assertIsArray($objectifs);
        $this->assertEmpty($objectifs);
    }

    public function testReadAllOkFilterEncadre()
    {
        $id_patient = "1";
        $filter_pratique = "Encadrée";

        $objectifs = $this->objecif->readAll($id_patient, $filter_pratique);
        $this->assertIsArray($objectifs);
        $this->assertNotEmpty($objectifs);
    }

    public function testReadAllOkFilterAutonome()
    {
        $id_patient = "1";
        $filter_pratique = "Autonome";

        $objectifs = $this->objecif->readAll($id_patient, $filter_pratique);
        $this->assertIsArray($objectifs);
        $this->assertEmpty($objectifs);
    }

    public function testReadAllNotOkFilterInvalid()
    {
        $id_patient = "1";
        $filter_pratique = "sdf";

        $objectifs = $this->objecif->readAll($id_patient, $filter_pratique);
        $this->assertFalse($objectifs);
    }

    public function testReadAllNotOkId_patientInvalid()
    {
        $id_patient = "-1";

        $objectifs = $this->objecif->readAll($id_patient);
        $this->assertIsArray($objectifs);
        $this->assertEmpty($objectifs);
    }

    public function testReadAllNotOkId_patientNull()
    {
        $id_patient = null;

        $objectifs = $this->objecif->readAll($id_patient);
        $this->assertFalse($objectifs);
    }

    public function testDeleteOk()
    {
        $id_obj_patient = "2";

        $this->tester->seeInDatabase("objectif_patient", ['id_obj_patient' => $id_obj_patient]);
        $this->tester->seeInDatabase("avancement_obj", ['id_obj_patient' => $id_obj_patient]);

        $delete_ok = $this->objecif->delete($id_obj_patient);
        $this->assertTrue($delete_ok, $this->objecif->getErrorMessage());

        $this->tester->dontSeeInDatabase("objectif_patient", ['id_obj_patient' => $id_obj_patient]);
        $this->tester->dontSeeInDatabase("avancement_obj", ['id_obj_patient' => $id_obj_patient]);
    }

    public function testDeleteNotOkId_obj_patientNull()
    {
        $id_obj_patient = null;

        $delete_ok = $this->objecif->delete($id_obj_patient);
        $this->assertFalse($delete_ok, $this->objecif->getErrorMessage());
    }

    public function testDeleteAvancementOkPartiellementAtteint()
    {
        $id_avancement_obj = "1";
        $id_obj_patient = $this->tester->grabFromDatabase(
            "avancement_obj",
            "id_obj_patient",
            ['id_avancement_obj' => $id_avancement_obj]
        );

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'termine' => "1"
        ]);
        $this->tester->seeInDatabase("avancement_obj", ['id_avancement_obj' => $id_avancement_obj]);

        $delete_ok = $this->objecif->deleteAvancement($id_avancement_obj);
        $this->assertTrue($delete_ok, $this->objecif->getErrorMessage());

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'termine' => "1"
        ]);
        $this->tester->dontSeeInDatabase("avancement_obj", ['id_avancement_obj' => $id_avancement_obj]);
    }

    public function testDeleteAvancementOkAtteint()
    {
        $id_avancement_obj = "2";
        $id_obj_patient = $this->tester->grabFromDatabase(
            "avancement_obj",
            "id_obj_patient",
            ['id_avancement_obj' => $id_avancement_obj]
        );

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'termine' => "1"
        ]);
        $this->tester->seeInDatabase("avancement_obj", ['id_avancement_obj' => $id_avancement_obj]);

        $delete_ok = $this->objecif->deleteAvancement($id_avancement_obj);
        $this->assertTrue($delete_ok, $this->objecif->getErrorMessage());

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'termine' => "0"
        ]);
        $this->tester->dontSeeInDatabase("avancement_obj", ['id_avancement_obj' => $id_avancement_obj]);
    }

    public function testDeleteAvancementNotOkId_avancement_objNull()
    {
        $id_avancement_obj = null;

        $delete_ok = $this->objecif->deleteAvancement($id_avancement_obj);
        $this->assertFalse($delete_ok, $this->objecif->getErrorMessage());
    }

    public function testDeleteAvancementNotOkId_avancement_objInvalid()
    {
        $id_avancement_obj = '-1';

        $delete_ok = $this->objecif->deleteAvancement($id_avancement_obj);
        $this->assertFalse($delete_ok, $this->objecif->getErrorMessage());
    }

    public function testCreateAvancementOkMinimumData()
    {
        $id_obj_patient = "1";
        $atteinte = 'Non Atteint';
        $date_avancement = $this->faker->date('Y-m-d');

        $id_avancement_obj = $this->objecif->createAvancement([
            'id_obj_patient' => $id_obj_patient,
            'atteinte' => $atteinte,
            'date_avancement' => $date_avancement,
        ]);

        $this->assertNotFalse($id_avancement_obj, $this->objecif->getErrorMessage());

        $this->tester->seeInDatabase("avancement_obj", [
            'id_avancement_obj' => $id_avancement_obj,
            'id_obj_patient' => $id_obj_patient,
            'atteinte' => $atteinte,
            'date_avancement' => $date_avancement,
        ]);

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'termine' => null,
        ]);
    }

    public function testCreateAvancementOkAtteint()
    {
        $id_obj_patient = "1";
        $atteinte = 'Atteint';
        $date_avancement = $this->faker->date('Y-m-d');
        $commentaires = $this->faker->text(1000);

        $id_avancement_obj = $this->objecif->createAvancement([
            'id_obj_patient' => $id_obj_patient,
            'atteinte' => $atteinte,
            'date_avancement' => $date_avancement,
            'commentaires' => $commentaires,
        ]);

        $this->assertNotFalse($id_avancement_obj, $this->objecif->getErrorMessage());

        $this->tester->seeInDatabase("avancement_obj", [
            'id_avancement_obj' => $id_avancement_obj,
            'id_obj_patient' => $id_obj_patient,
            'atteinte' => $atteinte,
            'date_avancement' => $date_avancement,
            'commentaires' => $commentaires,
        ]);

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'termine' => "1",
        ]);
    }

    public function testCreateAvancementOkPartiellementAtteint()
    {
        $id_obj_patient = "1";
        $atteinte = 'Partiellement Atteint';
        $date_avancement = $this->faker->date('Y-m-d');
        $commentaires = $this->faker->text(1000);

        $id_avancement_obj = $this->objecif->createAvancement([
            'id_obj_patient' => $id_obj_patient,
            'atteinte' => $atteinte,
            'date_avancement' => $date_avancement,
            'commentaires' => $commentaires,
        ]);

        $this->assertNotFalse($id_avancement_obj, $this->objecif->getErrorMessage());

        $this->tester->seeInDatabase("avancement_obj", [
            'id_avancement_obj' => $id_avancement_obj,
            'id_obj_patient' => $id_obj_patient,
            'atteinte' => $atteinte,
            'date_avancement' => $date_avancement,
            'commentaires' => $commentaires,
        ]);

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'termine' => null,
        ]);
    }

    public function testCreateAvancementNotOkId_obj_patientNull()
    {
        $id_obj_patient = null;
        $atteinte = 'Non Atteint';
        $date_avancement = $this->faker->date('Y-m-d');

        $id_avancement_obj = $this->objecif->createAvancement([
            'id_obj_patient' => $id_obj_patient,
            'atteinte' => $atteinte,
            'date_avancement' => $date_avancement,
        ]);

        $this->assertFalse($id_avancement_obj, $this->objecif->getErrorMessage());
    }

    public function testCreateAvancementNotOkAtteinteNull()
    {
        $id_obj_patient = "1";
        $atteinte = null;
        $date_avancement = $this->faker->date('Y-m-d');

        $id_avancement_obj = $this->objecif->createAvancement([
            'id_obj_patient' => $id_obj_patient,
            'atteinte' => $atteinte,
            'date_avancement' => $date_avancement,
        ]);

        $this->assertFalse($id_avancement_obj, $this->objecif->getErrorMessage());
    }

    public function testCreateAvancementNotOkDate_avancementNull()
    {
        $id_obj_patient = "1";
        $atteinte = 'Non Atteint';
        $date_avancement = null;

        $id_avancement_obj = $this->objecif->createAvancement([
            'id_obj_patient' => $id_obj_patient,
            'atteinte' => $atteinte,
            'date_avancement' => $date_avancement,
        ]);

        $this->assertFalse($id_avancement_obj, $this->objecif->getErrorMessage());
    }

    public function testReadAllAvancementOk()
    {
        $id_obj_patient = "2";

        $avancements = $this->objecif->readAllAvancement($id_obj_patient);
        $this->assertIsArray($avancements);
        $this->assertNotEmpty($avancements);

        foreach ($avancements as $avancement) {
            $this->assertArrayHasKey("id_avancement_obj", $avancement);
            $this->assertArrayHasKey("date_avancement", $avancement);
            $this->assertArrayHasKey("atteinte", $avancement);
            $this->assertArrayHasKey("commentaires", $avancement);
            $this->assertArrayHasKey("id_obj_patient", $avancement);
        }
    }

    public function testReadAllAvancementOkEmpty()
    {
        $id_obj_patient = "1";

        $avancements = $this->objecif->readAllAvancement($id_obj_patient);
        $this->assertIsArray($avancements);
        $this->assertEmpty($avancements);
    }

    public function testReadAllAvancementOkId_obj_patientInvalid()
    {
        $id_obj_patient = "-1";

        $avancements = $this->objecif->readAllAvancement($id_obj_patient);
        $this->assertIsArray($avancements);
        $this->assertEmpty($avancements);
    }

    public function testReadAllAvancementNotOkId_obj_patientNull()
    {
        $id_obj_patient = "1";

        $avancements = $this->objecif->readAllAvancement($id_obj_patient);
        $this->assertIsArray($avancements);
        $this->assertEmpty($avancements);
    }

    public function testUpdateOkEncadree()
    {
        // obligatoire
        $id_obj_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Encadrée';

        $update_ok = $this->objecif->update([
            'id_obj_patient' => $id_obj_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
        ]);

        $this->assertTrue($update_ok, $this->objecif->getErrorMessage());

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
        ]);
    }

    public function testUpdateOkAutonome()
    {
        // obligatoire
        $id_obj_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Autonome';

        // obligatoire si $pratique == 'Autonome'
        $type_activite = 'Autonome';
        $duree = $this->faker->date('h:i') . ':00';
        $frequence = $this->faker->text(200);
        $infos_complementaires = $this->faker->text(1000);

        $update_ok = $this->objecif->update([
            'id_obj_patient' => $id_obj_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,

            'type_activite' => $type_activite,
            'duree' => $duree,
            'frequence' => $frequence,
            'infos_complementaires' => $infos_complementaires,
        ]);

        $this->assertTrue($update_ok, $this->objecif->getErrorMessage());

        $this->tester->seeInDatabase("objectif_patient", [
            'id_obj_patient' => $id_obj_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,

            'type_activite' => $type_activite,
            'duree' => $duree,
            'frequence' => $frequence,
            'infos_complementaires' => $infos_complementaires,
        ]);
    }

    public function testUpdateNotOkId_obj_patientNull()
    {
        // obligatoire
        $id_obj_patient = null;
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Encadrée';

        $update_ok = $this->objecif->update([
            'id_obj_patient' => $id_obj_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
        ]);
        $this->assertFalse($update_ok, $this->objecif->getErrorMessage());
    }

    public function testUpdateNotOkNom_objectifNull()
    {
        // obligatoire
        $id_obj_patient = "1";
        $nom_objectif = null;
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Encadrée';

        $update_ok = $this->objecif->update([
            'id_obj_patient' => $id_obj_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
        ]);
        $this->assertFalse($update_ok, $this->objecif->getErrorMessage());
    }

    public function testUpdateNotOkDate_objectif_patientNull()
    {
        // obligatoire
        $id_obj_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = null;
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'Encadrée';

        $update_ok = $this->objecif->update([
            'id_obj_patient' => $id_obj_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
        ]);
        $this->assertFalse($update_ok, $this->objecif->getErrorMessage());
    }

    public function testUpdateNotOkDesc_objectifNull()
    {
        // obligatoire
        $id_obj_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = null;
        $pratique = 'Encadrée';

        $update_ok = $this->objecif->update([
            'id_obj_patient' => $id_obj_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
        ]);
        $this->assertFalse($update_ok, $this->objecif->getErrorMessage());
    }

    public function testUpdateNotOkPratiqueNull()
    {
        // obligatoire
        $id_obj_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = null;

        $update_ok = $this->objecif->update([
            'id_obj_patient' => $id_obj_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
        ]);
        $this->assertFalse($update_ok, $this->objecif->getErrorMessage());
    }

    public function testUpdateNotOkPratiqueInvalid()
    {
        // obligatoire
        $id_obj_patient = "1";
        $nom_objectif = $this->faker->text(200);
        $date_objectif_patient = $this->faker->date('Y-m-d');
        $desc_objectif = $this->faker->text(1000);
        $pratique = 'sdfgsdgf';

        $update_ok = $this->objecif->update([
            'id_obj_patient' => $id_obj_patient,
            'nom_objectif' => $nom_objectif,
            'date_objectif_patient' => $date_objectif_patient,
            'desc_objectif' => $desc_objectif,
            'pratique' => $pratique,
        ]);
        $this->assertFalse($update_ok, $this->objecif->getErrorMessage());
    }

    function testReadOneAvancementOk()
    {
        $id_avancement_obj = "1";

        $avancement_obj = $this->objecif->readOneAvancement($id_avancement_obj);
        $this->assertIsArray($avancement_obj);
        $this->assertArrayHasKey("id_avancement_obj", $avancement_obj);
        $this->assertArrayHasKey("date_avancement", $avancement_obj);
        $this->assertArrayHasKey("atteinte", $avancement_obj);
        $this->assertArrayHasKey("commentaires", $avancement_obj);
        $this->assertArrayHasKey("id_obj_patient", $avancement_obj);
    }

    function testReadOneAvancementNotOkId_obj_patientNull()
    {
        $id_avancement_obj = null;

        $avancement_obj = $this->objecif->readOneAvancement($id_avancement_obj);
        $this->assertFalse($avancement_obj);
    }

    function testReadOneAvancementNotOkId_obj_patientInvalid()
    {
        $id_avancement_obj = "-1";

        $avancement_obj = $this->objecif->readOneAvancement($id_avancement_obj);
        $this->assertFalse($avancement_obj);
    }
}