<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\Intervenant;
use Sportsante86\Sapa\Outils\Permissions;
use Tests\Support\UnitTester;

class IntervenantTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Intervenant $intervenant;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->intervenant = new Intervenant($pdo);
        $this->assertNotNull($this->intervenant);
    }

    protected function _after()
    {
    }

    public function testReadOneOk1()
    {
        $id_intervenant = '1';

        $intervenant = $this->intervenant->readOne($id_intervenant);

        $this->assertNotFalse($intervenant);
        $this->assertIsArray($intervenant);

        $this->assertArrayHasKey('id_intervenant', $intervenant);
        $this->assertArrayHasKey('numero_carte', $intervenant);
        $this->assertArrayHasKey('nom_intervenant', $intervenant);
        $this->assertArrayHasKey('prenom_intervenant', $intervenant);
        $this->assertArrayHasKey('mail_intervenant', $intervenant);
        $this->assertArrayHasKey('tel_fixe_intervenant', $intervenant);
        $this->assertArrayHasKey('tel_portable_intervenant', $intervenant);
        $this->assertArrayHasKey('id_statut_intervenant', $intervenant);
        $this->assertArrayHasKey('nom_statut_intervenant', $intervenant);
        $this->assertArrayHasKey('id_territoire', $intervenant);
        $this->assertArrayHasKey('nom_territoire', $intervenant);
        $this->assertArrayHasKey('is_user', $intervenant);
        $this->assertArrayHasKey('structures', $intervenant);
        $this->assertArrayHasKey('creneaux', $intervenant);
        $this->assertArrayHasKey('diplomes', $intervenant);

        $this->assertEquals('1', $intervenant['id_intervenant']);
        $this->assertEquals('231', $intervenant['numero_carte']);
        $this->assertEquals('INTERVENANTTESTNOM1', $intervenant['nom_intervenant']);
        $this->assertEquals('IntervenantTestPrenom1', $intervenant['prenom_intervenant']);
        $this->assertEquals(
            'intervenantTestNom1.intervenantTestPrenom1@sportsante86.fr',
            $intervenant['mail_intervenant']
        );
        $this->assertEquals('0145328745', $intervenant['tel_fixe_intervenant']);
        $this->assertEquals('0756438909', $intervenant['tel_portable_intervenant']);
        $this->assertEquals('2', $intervenant['id_statut_intervenant']);
        $this->assertEquals('Libéral', $intervenant['nom_statut_intervenant']);
        $this->assertEquals('1', $intervenant['id_territoire']);
        $this->assertEquals('86 Vienne', $intervenant['nom_territoire']);
        $this->assertEquals(false, $intervenant['is_user']);
        $this->assertIsArray($intervenant['structures']);
        $this->assertEmpty($intervenant['structures']);
        $this->assertIsArray($intervenant['creneaux']);
        $this->assertNotEmpty($intervenant['creneaux']);

        $this->assertIsArray($intervenant['diplomes']);
        $this->assertCount(1, $intervenant['diplomes']);

        $this->assertArrayHasKey('id_diplome', $intervenant['diplomes'][0]);
        $this->assertArrayHasKey('nom_diplome', $intervenant['diplomes'][0]);

        $this->assertEquals('3', $intervenant['diplomes'][0]['id_diplome']);
        $this->assertEquals('Formation fédérale', $intervenant['diplomes'][0]['nom_diplome']);
    }

    public function testReadOneOk2()
    {
        $id_intervenant = '2';

        $intervenant = $this->intervenant->readOne($id_intervenant);

        $this->assertNotFalse($intervenant);
        $this->assertIsArray($intervenant);

        $this->assertArrayHasKey('id_intervenant', $intervenant);
        $this->assertArrayHasKey('numero_carte', $intervenant);
        $this->assertArrayHasKey('nom_intervenant', $intervenant);
        $this->assertArrayHasKey('prenom_intervenant', $intervenant);
        $this->assertArrayHasKey('mail_intervenant', $intervenant);
        $this->assertArrayHasKey('tel_fixe_intervenant', $intervenant);
        $this->assertArrayHasKey('tel_portable_intervenant', $intervenant);
        $this->assertArrayHasKey('id_statut_intervenant', $intervenant);
        $this->assertArrayHasKey('nom_statut_intervenant', $intervenant);
        $this->assertArrayHasKey('id_territoire', $intervenant);
        $this->assertArrayHasKey('nom_territoire', $intervenant);
        $this->assertArrayHasKey('is_user', $intervenant);
        $this->assertArrayHasKey('structures', $intervenant);
        $this->assertArrayHasKey('creneaux', $intervenant);

        $this->assertEquals('2', $intervenant['id_intervenant']);
        $this->assertEquals('56456', $intervenant['numero_carte']);
        $this->assertEquals('INTERVENANTTESTNOM2', $intervenant['nom_intervenant']);
        $this->assertEquals('IntervenantTestPrenom2', $intervenant['prenom_intervenant']);
        $this->assertEquals(
            'intervenantTestNom2.intervenantTestPrenom2@sportsante86.fr',
            $intervenant['mail_intervenant']
        );
        $this->assertEquals('0145328743', $intervenant['tel_fixe_intervenant']);
        $this->assertEquals('0756438908', $intervenant['tel_portable_intervenant']);
        $this->assertEquals('3', $intervenant['id_statut_intervenant']);
        $this->assertEquals('Salarié', $intervenant['nom_statut_intervenant']);
        $this->assertEquals('1', $intervenant['id_territoire']);
        $this->assertEquals('86 Vienne', $intervenant['nom_territoire']);
        $this->assertEquals(false, $intervenant['is_user']);

        $this->assertIsArray($intervenant['structures']);
        $this->assertCount(1, $intervenant['structures']);

        $this->assertArrayHasKey('id_structure', $intervenant['structures'][0]);
        $this->assertArrayHasKey('nom_structure', $intervenant['structures'][0]);
        $this->assertArrayHasKey('is_intervenant', $intervenant['structures'][0]);

        $this->assertEquals('1', $intervenant['structures'][0]['id_structure']);
        $this->assertEquals('STRUCT TEST 1', $intervenant['structures'][0]['nom_structure']);
        $this->assertEquals(true, $intervenant['structures'][0]['is_intervenant']);

        $this->assertIsArray($intervenant['creneaux']);
        $this->assertCount(4, $intervenant['creneaux']);

        $this->assertIsArray($intervenant['diplomes']);
        $this->assertCount(1, $intervenant['diplomes']);

        $this->assertArrayHasKey('id_diplome', $intervenant['diplomes'][0]);
        $this->assertArrayHasKey('nom_diplome', $intervenant['diplomes'][0]);

        $this->assertEquals('6', $intervenant['diplomes'][0]['id_diplome']);
        $this->assertEquals('Master STAPS APA', $intervenant['diplomes'][0]['nom_diplome']);
    }

    public function testReadOneNotOkId_intervenantNull()
    {
        $id_intervenant = null;

        $intervenant = $this->intervenant->readOne($id_intervenant);

        $this->assertFalse($intervenant);
    }

    public function testReadOneNotOkId_intervenantInvalid()
    {
        $id_intervenant = '-1';

        $intervenant = $this->intervenant->readOne($id_intervenant);

        $this->assertFalse($intervenant);
    }

    public function testReadAllOkCoordonateur()
    {
        // coordo peps
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $id_territoire = '1';

        $intervenants = $this->intervenant->readAll(new Permissions($session), $id_territoire);

        $this->assertNotFalse($intervenants);
        $this->assertIsArray($intervenants);

        $intervenants_territoire_count = $this->tester->grabNumRecords(
            'intervenants',
            ['id_territoire' => $id_territoire]
        );

        $this->assertCount($intervenants_territoire_count, $intervenants);

        $first_intervenant = $intervenants[0];

        $this->assertArrayHasKey('id_intervenant', $first_intervenant);
        $this->assertArrayHasKey('numero_carte', $first_intervenant);
        $this->assertArrayHasKey('nom_intervenant', $first_intervenant);
        $this->assertArrayHasKey('prenom_intervenant', $first_intervenant);
        $this->assertArrayHasKey('mail_intervenant', $first_intervenant);
        $this->assertArrayHasKey('tel_fixe_intervenant', $first_intervenant);
        $this->assertArrayHasKey('tel_portable_intervenant', $first_intervenant);
        $this->assertArrayHasKey('id_statut_intervenant', $first_intervenant);
        $this->assertArrayHasKey('nom_statut_intervenant', $first_intervenant);
        $this->assertArrayHasKey('id_territoire', $first_intervenant);
        $this->assertArrayHasKey('nom_territoire', $first_intervenant);
        $this->assertArrayHasKey('is_user', $first_intervenant);
        $this->assertArrayHasKey('structures', $first_intervenant);
    }

    public function testReadAllOkAdmin()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_structure' => null,
            'id_territoire' => '1',
            'id_statut_structure' => null,
        ]; // admin
        $id_territoire = 1;

        $intervenants = $this->intervenant->readAll(new Permissions($session), $id_territoire);

        $this->assertNotFalse($intervenants);
        $this->assertIsArray($intervenants);

        $intervenants_total_count = $this->tester->grabNumRecords('intervenants');
        $this->assertCount(
            $intervenants_total_count,
            $intervenants
        ); // les intervenants de tous les territoires trouvés

        $first_intervenant = $intervenants[0];

        $this->assertArrayHasKey('id_intervenant', $first_intervenant);
        $this->assertArrayHasKey('numero_carte', $first_intervenant);
        $this->assertArrayHasKey('nom_intervenant', $first_intervenant);
        $this->assertArrayHasKey('prenom_intervenant', $first_intervenant);
        $this->assertArrayHasKey('mail_intervenant', $first_intervenant);
        $this->assertArrayHasKey('tel_fixe_intervenant', $first_intervenant);
        $this->assertArrayHasKey('tel_portable_intervenant', $first_intervenant);
        $this->assertArrayHasKey('id_statut_intervenant', $first_intervenant);
        $this->assertArrayHasKey('nom_statut_intervenant', $first_intervenant);
        $this->assertArrayHasKey('id_territoire', $first_intervenant);
        $this->assertArrayHasKey('nom_territoire', $first_intervenant);
        $this->assertArrayHasKey('is_user', $first_intervenant);
        $this->assertArrayHasKey('structures', $first_intervenant);
    }

    public function testReadAllNotOkId_territoireNull()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_structure' => null,
            'id_territoire' => '1',
            'id_statut_structure' => "2",
        ];
        $id_territoire = null;

        $intervenants = $this->intervenant->readAll(new Permissions($session), $id_territoire);

        $this->assertFalse($intervenants);
    }

    public function testReadAllStructureOk()
    {
        $id_structure = '1';

        $intervenants = $this->intervenant->readAllStructure($id_structure);
        $this->assertIsArray($intervenants);

        $intervenants_count = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure]
        );
        $this->assertGreaterThan(1, $intervenants_count);
        $this->assertCount($intervenants_count, $intervenants);

        $this->assertArrayHasKey('id_intervenant', $intervenants[0]);
        $this->assertArrayHasKey('numero_carte', $intervenants[0]);
        $this->assertArrayHasKey('nom_intervenant', $intervenants[0]);
        $this->assertArrayHasKey('prenom_intervenant', $intervenants[0]);
        $this->assertArrayHasKey('mail_intervenant', $intervenants[0]);
        $this->assertArrayHasKey('tel_fixe_intervenant', $intervenants[0]);
        $this->assertArrayHasKey('tel_portable_intervenant', $intervenants[0]);
        $this->assertArrayHasKey('id_statut_intervenant', $intervenants[0]);
        $this->assertArrayHasKey('nom_statut_intervenant', $intervenants[0]);
        $this->assertArrayHasKey('id_territoire', $intervenants[0]);
        $this->assertArrayHasKey('nom_territoire', $intervenants[0]);
        $this->assertArrayHasKey('is_user', $intervenants[0]);
        $this->assertArrayHasKey('structures', $intervenants[0]);
        $this->assertArrayHasKey('nb_creneau', $intervenants[0]);

        $this->assertCount(6, $intervenants);

        $this->assertEquals("6", $intervenants[0]['id_intervenant']);
        $this->assertEquals("0", $intervenants[0]['nb_creneau']);

        $this->assertEquals("2", $intervenants[1]['id_intervenant']);
        $this->assertEquals("4", $intervenants[1]['nb_creneau']);

        $this->assertEquals("5", $intervenants[2]['id_intervenant']);
        $this->assertEquals("1", $intervenants[2]['nb_creneau']);

        $this->assertEquals("7", $intervenants[3]['id_intervenant']);
        $this->assertEquals("1", $intervenants[3]['nb_creneau']);

        $this->assertEquals("12", $intervenants[4]['id_intervenant']);
        $this->assertEquals("0", $intervenants[4]['nb_creneau']);

        $this->assertEquals("9", $intervenants[5]['id_intervenant']);
        $this->assertEquals("0", $intervenants[5]['nb_creneau']);
    }

    public function testReadAllStructureOkInvalidId_structure()
    {
        $id_structure = '-2';

        $intervenants = $this->intervenant->readAllStructure($id_structure);
        $this->assertIsArray($intervenants);
        $this->assertCount(0, $intervenants);
    }

    public function testReadAllStructureOkId_structureNull()
    {
        $id_structure = null;

        $intervenants = $this->intervenant->readAllStructure($id_structure);
        $this->assertFalse($intervenants);
    }

    public function testCreateOkMinimumData()
    {
        $nom = "bobintervenant";
        $prenom = "danieintervenant";
        $id_territoire = "1";
        $id_statut_intervenant = "3";

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
        ]);

        $this->assertNotFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before + 1, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);

        $this->tester->seeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => "bobintervenant",
            'prenom_coordonnees' => "danieintervenant",
            'id_intervenant' => $id_intervenant,
        ]);
    }

    public function testCreateOkAllDataExceptApi()
    {
        $nom = "Small";
        $prenom = "Oren";
        $id_territoire = "1";
        $id_statut_intervenant = "2";

        $email = "Oren.Small@gmail.com";
        $tel_portable = "0989988998";
        $tel_fixe = "0689988998";
        $numero_carte = "K98756";
        $structures = ["1"];
        $diplomes = ["5", "6", "7"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'structures' => $structures,
            'diplomes' => $diplomes,
        ]);

        $this->assertNotFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before + 1, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before + 3, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before + 1, $intervient_dans_count_after);

        $this->tester->seeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => $numero_carte,
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'id_intervenant' => $id_intervenant,
            'mail_coordonnees' => $email,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,

        ]);

        foreach ($diplomes as $id_diplome) {
            $this->tester->seeInDatabase('a_obtenu', [
                'id_diplome' => $id_diplome,
                'id_intervenant' => $id_intervenant,
            ]);
        }

        foreach ($structures as $id_structure) {
            $this->tester->seeInDatabase('intervient_dans', [
                'id_structure' => $id_structure,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testCreateOkApiMinimumData()
    {
        $nom = "ImportapiNom";
        $prenom = "Importapiprénom";
        //$id_territoire = "1";
        $id_statut_intervenant = "2";
        $id_api = "api-intervenant-54387-sdfsdfkuio";
        $id_api_structure = "api-structure-98766568-sdfg";

        $structures = ["1"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,

            'id_api' => $id_api,
            'id_api_structure' => $id_api_structure,
        ]);

        $this->assertNotFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before + 1, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before + 1, $intervient_dans_count_after);

        $this->tester->seeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => '1',
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'id_intervenant' => $id_intervenant,
        ]);

        foreach ($structures as $id_structure) {
            $this->tester->seeInDatabase('intervient_dans', [
                'id_structure' => $id_structure,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testCreateOkApiAllData()
    {
        $nom = "ImportapiNom2";
        $prenom = "Importapiprénom2";
        $id_territoire = "1";
        $id_statut_intervenant = "3";
        $id_api = "api-intervenant-0908765-jhgghgyj";
        $id_api_structure = "api-structure-98766568-sdfg";

        $email = "ImportapiNom2@gmail.com";
        $tel_portable = "0989988498";
        $tel_fixe = "0689488998";
        $numero_carte = "K9875634";
        $structures = ["1"];
        $diplomes = ["5", "6", "7"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,

            'id_api' => $id_api,
            'id_api_structure' => $id_api_structure,
            'id_territoire' => $id_territoire,
            'diplomes' => $diplomes,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'structures' => $structures,
        ]);

        $this->assertNotFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before + 1, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before + 3, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before + 1, $intervient_dans_count_after);

        $this->tester->seeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => '1',
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'id_intervenant' => $id_intervenant,
        ]);

        foreach ($diplomes as $id_diplome) {
            $this->tester->seeInDatabase('a_obtenu', [
                'id_diplome' => $id_diplome,
                'id_intervenant' => $id_intervenant,
            ]);
        }

        foreach ($structures as $id_structure) {
            $this->tester->seeInDatabase('intervient_dans', [
                'id_structure' => $id_structure,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testCreateOkSingleQuotes()
    {
        $nom = "SmallO'Reilly ";
        $prenom = "OrenO'Reilly";
        $id_territoire = "'1";
        $id_statut_intervenant = "'2";

        $email = "'Oren.Small@gmail.com";
        $tel_portable = "'0989988998";
        $tel_fixe = "'0689988998";
        $numero_carte = "K98756";
        $structures = ["'1"];
        $diplomes = ["'5"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'diplomes' => $diplomes,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'structures' => $structures,
        ]);

        $this->assertNotFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before + 1, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before + 1, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before + 1, $intervient_dans_count_after);

        $this->tester->seeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => "2",
            'id_territoire' => "1",
            'numero_carte' => $numero_carte,
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'id_intervenant' => $id_intervenant,
            'mail_coordonnees' => $email,
            'tel_portable_coordonnees' => "0989988998",
            'tel_fixe_coordonnees' => "0689988998",

        ]);

        $this->tester->seeInDatabase('a_obtenu', [
            'id_diplome' => "5",
            'id_intervenant' => $id_intervenant,
        ]);

        $this->tester->seeInDatabase('intervient_dans', [
            'id_structure' => "1",
            'id_intervenant' => $id_intervenant,
        ]);
    }

    public function testCreateNotOkMissingNom()
    {
        $prenom = "danieintervenant";
        $id_territoire = "1";
        $id_statut_intervenant = "3";
        $diplomes = ["6"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'diplomes' => $diplomes,
        ]);

        $this->assertFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkMissingPrenom()
    {
        $nom = "bobintervenant";
        $id_territoire = "1";
        $id_statut_intervenant = "3";
        $diplomes = ["6"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'diplomes' => $diplomes,
        ]);

        $this->assertFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkMissingId_territoire()
    {
        $nom = "bobintervenant";
        $prenom = "danieintervenant";
        $id_statut_intervenant = "3";
        $diplomes = ["6"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'diplomes' => $diplomes,
        ]);

        $this->assertFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkId_statut_intervenant()
    {
        $nom = "bobintervenant";
        $prenom = "danieintervenant";
        $id_territoire = "1";
        $diplomes = ["6"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_territoire' => $id_territoire,
            'diplomes' => $diplomes,
        ]);

        $this->assertFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkInvalidId_diplome()
    {
        $nom = "dfg";
        $prenom = "dfg";
        $id_territoire = "1";
        $id_statut_intervenant = "3";
        $diplomes = ["1", "-1"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'diplomes' => $diplomes,
        ]);

        $this->assertFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkInvalidId_structure()
    {
        $nom = "dfg";
        $prenom = "dfg";
        $id_territoire = "1";
        $id_statut_intervenant = "3";
        $structures = ["1", "-1"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'structures' => $structures,
        ]);

        $this->assertFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkInvalidId_territoire()
    {
        $nom = "bobintervenant";
        $prenom = "danieintervenant";
        $id_territoire = "-1";
        $id_statut_intervenant = "3";
        $diplomes = ["6"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'diplomes' => $diplomes,
        ]);

        $this->assertFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkInvalidId_statut_intervenant()
    {
        $nom = "bobintervenant";
        $prenom = "danieintervenant";
        $id_territoire = "1";
        $id_statut_intervenant = "-1";
        $diplomes = ["6"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'diplomes' => $diplomes,
        ]);

        $this->assertFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkApiIntervenantAlreadyImported()
    {
        $nom = "ImportapiNom3";
        $prenom = "Importapiprénom3";
        $id_territoire = "1";
        $id_statut_intervenant = "3";
        $id_api = "api-intervenant-1111-aaaa"; // intervenant exist
        $id_api_structure = "api-structure-98766568-sdfg";

        $email = "ImportapiNom3@gmail.com";
        $tel_portable = "0989988498";
        $tel_fixe = "0689488998";
        $numero_carte = "K9875634";
        $structures = ["1"];
        $diplomes = ["5", "6", "7"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,

            'id_api' => $id_api,
            'id_api_structure' => $id_api_structure,
            'id_territoire' => $id_territoire,
            'diplomes' => $diplomes,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'structures' => $structures,
        ]);

        $this->assertFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testCreateNotOkApiStructureNotImported()
    {
        $nom = "ImportapiNom4";
        $prenom = "Importapiprénom4";
        $id_territoire = "1";
        $id_statut_intervenant = "3";
        $id_api = "api-intervenant-22222-hfgjhdfgh";
        $id_api_structure = "api-structure-11111-bbbb"; // structure does not exist

        $email = "ImportapiNom3@gmail.com";
        $tel_portable = "0989988498";
        $tel_fixe = "0689488998";
        $numero_carte = "K9875634";
        $structures = ["1"];
        $diplomes = ["5", "6", "7"];

        $intervenant_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_intervenant = $this->intervenant->create([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,

            'id_api' => $id_api,
            'id_api_structure' => $id_api_structure,
            'id_territoire' => $id_territoire,
            'diplomes' => $diplomes,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'structures' => $structures,
        ]);

        $this->assertFalse($id_intervenant);
        $intervenant_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($intervenant_count_before, $intervenant_count_after);
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);
    }

    public function testUpdateOkIntervenantSansCreneaux()
    {
        $id_intervenant = '4';
        $nom = "ABCCD";
        $prenom = "Opppc";
        $id_territoire = "1";
        $id_statut_intervenant = "2";

        $email = "ABCCD.Opppc@gmail.com";
        $tel_portable = "0333333333";
        $tel_fixe = "0444444444";
        $numero_carte = "L98098";
        $structures = ["1"];
        $diplomes = ["5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => $numero_carte,
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'id_intervenant' => $id_intervenant,
            'mail_coordonnees' => $email,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ]);

        foreach ($diplomes as $id_diplome) {
            $this->tester->seeInDatabase('a_obtenu', [
                'id_diplome' => $id_diplome,
                'id_intervenant' => $id_intervenant,
            ]);
        }

        foreach ($structures as $id_structure) {
            $this->tester->seeInDatabase('intervient_dans', [
                'id_structure' => $id_structure,
                'id_intervenant' => $id_intervenant,
            ]);
        }

        // update 2
        // remove all structures and diplomes

        $id_intervenant = '4';
        $nom = "ABCCDFG";
        $prenom = "Opppcfsdf";
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "ABCCD.Opppc@gmail.com";
        $tel_portable = "0555555555";
        $tel_fixe = "0666666666";
        $numero_carte = "L9809854";
        $structures = [];
        $diplomes = [];

        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertTrue($update_ok);

        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after + 3);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after + 1);

        $this->tester->seeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => $numero_carte,
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'id_intervenant' => $id_intervenant,
            'mail_coordonnees' => $email,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ]);

        $this->tester->dontSeeInDatabase('a_obtenu', [
            'id_intervenant' => $id_intervenant,
        ]);

        $this->tester->dontSeeInDatabase('intervient_dans', [
            'id_intervenant' => $id_intervenant,
        ]);

        // update 3
        // add structures and diplomes

        $id_intervenant = '4';
        $nom = "BGGGGG";
        $prenom = "Plkjdfg";
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L980fg4";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertTrue($update_ok);

        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($a_obtenu_count_before + 4, $a_obtenu_count_after);
        $this->assertEquals($intervient_dans_count_before + 3, $intervient_dans_count_after);

        $this->tester->seeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => $numero_carte,
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'id_intervenant' => $id_intervenant,
            'mail_coordonnees' => $email,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ]);

        foreach ($diplomes as $id_diplome) {
            $this->tester->seeInDatabase('a_obtenu', [
                'id_diplome' => $id_diplome,
                'id_intervenant' => $id_intervenant,
            ]);
        }

        foreach ($structures as $id_structure) {
            $this->tester->seeInDatabase('intervient_dans', [
                'id_structure' => $id_structure,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testUpdateOkIntervenantAvecCreneau()
    {
        // intervenant qui intervient dans la structure id_structure = "1"
        // dans le créneau id_creneau = "3"

        $id_intervenant = '5';
        $nom = "ABCCD";
        $prenom = "Opppc";
        $id_territoire = "1";
        $id_statut_intervenant = "2";

        $email = "ABCCD.Opppc@gmail.com";
        $tel_portable = "0333333333";
        $tel_fixe = "0444444444";
        $numero_carte = "L98098";
        $structures = ["1", "2"];
        $diplomes = ["5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => $numero_carte,
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'id_intervenant' => $id_intervenant,
            'mail_coordonnees' => $email,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ]);

        foreach ($diplomes as $id_diplome) {
            $this->tester->seeInDatabase('a_obtenu', [
                'id_diplome' => $id_diplome,
                'id_intervenant' => $id_intervenant,
            ]);
        }

        foreach ($structures as $id_structure) {
            $this->tester->seeInDatabase('intervient_dans', [
                'id_structure' => $id_structure,
                'id_intervenant' => $id_intervenant,
            ]);
        }

        // update 2
        // remove all structures and diplomes

        $id_intervenant = '5';
        $nom = "ABCCDFG";
        $prenom = "Opppcfsdf";
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "ABCCD.Opppc@gmail.com";
        $tel_portable = "0555555555";
        $tel_fixe = "0666666666";
        $numero_carte = "L9809854";
        $structures = [];
        $diplomes = [];

        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertTrue($update_ok);

        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after + 3);
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after + 2);

        $this->tester->seeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'numero_carte' => $numero_carte,
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'nom_coordonnees' => $nom,
            'prenom_coordonnees' => $prenom,
            'id_intervenant' => $id_intervenant,
            'mail_coordonnees' => $email,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ]);
    }

    public function testUpdateNotOkId_intervenantMissing()
    {
        $nom = "x";
        $prenom = "x";
        $id_territoire = "1";
        $id_statut_intervenant = "2";

        $email = "x@gmail.com";
        $tel_portable = "0333333333";
        $tel_fixe = "0444444444";
        $numero_carte = "L98098";
        $structures = ["1"];
        $diplomes = ["5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_intervenantNull()
    {
        $id_intervenant = null;
        $nom = "BGGGGG";
        $prenom = "Plkjdfg";
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_intervenantEmpty()
    {
        $id_intervenant = '';
        $nom = "BGGGGG";
        $prenom = "Plkjdfg";
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkNomMissing()
    {
        $id_intervenant = '4';
        $prenom = "Plkjdfg";
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkNomNull()
    {
        $id_intervenant = '4';
        $nom = null;
        $prenom = "Plkjdfg";
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkNomEmpty()
    {
        $id_intervenant = '4';
        $nom = "";
        $prenom = "Plkjdfg";
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkPrenomMissing()
    {
        $id_intervenant = '4';
        $nom = "BGGGGG";
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }


    public function testUpdateNotOkPrenomEmpty()
    {
        $id_intervenant = '4';
        $nom = "BGGGGG";
        $prenom = "";
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkPrenomNull()
    {
        $id_intervenant = '4';
        $nom = "BGGGGG";
        $prenom = null;
        $id_territoire = "1";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_territoireMissing()
    {
        $id_intervenant = '4';
        $nom = "BGGGGG";
        $prenom = "Plkjdfg";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_territoireEmpty()
    {
        $id_intervenant = '4';
        $nom = "BGGGGG";
        $prenom = "Plkjdfg";
        $id_territoire = "";
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_territoireNull()
    {
        $id_intervenant = '4';
        $nom = "BGGGGG";
        $prenom = "Plkjdfg";
        $id_territoire = null;
        $id_statut_intervenant = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_statut_intervenantMissing()
    {
        $id_intervenant = '4';
        $nom = "BGGGGG";
        $prenom = "Plkjdfg";
        $id_territoire = "1";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_statut_intervenantEmpty()
    {
        $id_intervenant = '4';
        $nom = "BGGGGG";
        $prenom = "Plkjdfg";
        $id_territoire = "1";
        $id_statut_intervenant = "";

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_statut_intervenantNull()
    {
        $id_intervenant = '4';
        $nom = "BGGGGG";
        $prenom = "Plkjdfg";
        $id_territoire = "1";
        $id_statut_intervenant = null;

        $email = "BGGGGG.Plkjdfg@gmail.com";
        $tel_portable = "0333333332";
        $tel_fixe = "0444444443";
        $numero_carte = "L9809854";
        $structures = ["1", "2", "3"];
        $diplomes = ["1", "5", "6", "7"];

        $update_ok = $this->intervenant->update([
            'id_intervenant' => $id_intervenant,
            'nom_intervenant' => $nom,
            'prenom_intervenant' => $prenom,
            'id_statut_intervenant' => $id_statut_intervenant,
            'id_territoire' => $id_territoire,
            'mail_intervenant' => $email,
            'tel_portable_intervenant' => $tel_portable,
            'tel_fixe_intervenant' => $tel_fixe,
            'numero_carte' => $numero_carte,
            'diplomes' => $diplomes,
            'structures' => $structures
        ]);

        $this->assertFalse($update_ok);
    }

    public function testFuseNotOkId_intervenant_fromNull()
    {
        $id_intervenant_from = null;
        $id_intervenant_target = "1";

        $fuse_ok = $this->intervenant->fuse($id_intervenant_from, $id_intervenant_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFuseNotOkId_intervenant_targetNull()
    {
        $id_intervenant_from = "1";
        $id_intervenant_target = null;

        $fuse_ok = $this->intervenant->fuse($id_intervenant_from, $id_intervenant_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFuseNotOkId_intervenant_fromNullAndId_intervenant_targetNull()
    {
        $id_intervenant_from = null;
        $id_intervenant_target = null;

        $fuse_ok = $this->intervenant->fuse($id_intervenant_from, $id_intervenant_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFuseNotOkId_intervenant_fromInvalid()
    {
        $id_intervenant_from = "-1";
        $id_intervenant_target = "1";

        $fuse_ok = $this->intervenant->fuse($id_intervenant_from, $id_intervenant_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFuseNotOkId_intervenant_targetInvalid()
    {
        $id_intervenant_from = "1";
        $id_intervenant_target = "-1";

        $fuse_ok = $this->intervenant->fuse($id_intervenant_from, $id_intervenant_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFuseNotOkId_intervenant_fromInvalidAndId_intervenant_targetInvalid()
    {
        $id_intervenant_from = "-1";
        $id_intervenant_target = "-1";

        $fuse_ok = $this->intervenant->fuse($id_intervenant_from, $id_intervenant_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFuseOkIntervenantFromIsNotUserAndIntervenantTargetIsNotUser()
    {
        $id_intervenant_from = "1";
        $id_intervenant_target = "2";

        // creneaux_intervenant
        $creneaux_intervenant_count_intervenant_from_before = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_from]
        );
        $creneaux_intervenant_count_intervenant_target_before = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_target]
        );
        // a_obtenu
        $a_obtenu_count_intervenant_from_before = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_from]
        );
        $a_obtenu_count_intervenant_target_before = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervient_dans
        $intervient_dans_count_intervenant_from_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_from]
        );
        $intervient_dans_count_intervenant_target_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervenants
        $intervenants_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');

        $fuse_ok = $this->intervenant->fuse($id_intervenant_from, $id_intervenant_target);
        $this->assertTrue($fuse_ok);

        // creneaux_intervenant
        $creneaux_intervenant_count_intervenant_from_after = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_from]
        );
        $creneaux_intervenant_count_intervenant_target_after = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_target]
        );
        // a_obtenu
        $a_obtenu_count_intervenant_from_after = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_from]
        );
        $a_obtenu_count_intervenant_target_after = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervient_dans
        $intervient_dans_count_intervenant_from_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_from]
        );
        $intervient_dans_count_intervenant_target_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervenants
        $intervenants_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        // user
        $users_count_after = $this->tester->grabNumRecords('users');

        // creneaux_intervenant
        $this->assertEquals(
            $creneaux_intervenant_count_intervenant_from_before + $creneaux_intervenant_count_intervenant_target_before,
            $creneaux_intervenant_count_intervenant_target_after
        );
        $this->assertEquals(0, $creneaux_intervenant_count_intervenant_from_after);
        // a_obtenu
        $this->assertEquals(
            $a_obtenu_count_intervenant_from_before + $a_obtenu_count_intervenant_target_before,
            $a_obtenu_count_intervenant_target_after
        ); // pas de diplome en commun
        $this->assertEquals(0, $a_obtenu_count_intervenant_from_after);
        // intervient_dans
        $this->assertEquals(
            $intervient_dans_count_intervenant_from_before + $intervient_dans_count_intervenant_target_before,
            $intervient_dans_count_intervenant_target_after
        ); // pas de structure en commun
        $this->assertEquals(0, $intervient_dans_count_intervenant_from_after);
        // intervention
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after + 1);
        $this->assertEquals($intervenants_count_before, $intervenants_count_after + 1);
    }

    public function testFuseOkIntervenantFromIsUserAndIntervenantTargetIsNotUser()
    {
        $id_intervenant_from = "4";
        $id_intervenant_target = "1";

        $id_user_from = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_user',
            ['id_intervenant' => $id_intervenant_from]
        );

        // creneaux_intervenant
        $creneaux_intervenant_count_intervenant_from_before = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_from]
        );
        $creneaux_intervenant_count_intervenant_target_before = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_target]
        );
        // a_obtenu
        $a_obtenu_count_intervenant_from_before = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_from]
        );
        $a_obtenu_count_intervenant_target_before = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervient_dans
        $intervient_dans_count_intervenant_from_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_from]
        );
        $intervient_dans_count_intervenant_target_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervention
        $intervention_count_intervenant_from_before = $this->tester->grabNumRecords(
            'intervention',
            ['id_user' => $id_user_from]
        );

        // seance
        $seance_count_intervenant_from_before = $this->tester->grabNumRecords(
            'seance',
            ['id_user' => $id_user_from]
        );
        // intervenants
        $intervenants_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        // user
        $users_count_before = $this->tester->grabNumRecords('users');

        $fuse_ok = $this->intervenant->fuse($id_intervenant_from, $id_intervenant_target);
        $this->assertTrue($fuse_ok, $this->intervenant->getErrorMessage());

        // creneaux_intervenant
        $creneaux_intervenant_count_intervenant_from_after = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_from]
        );
        $creneaux_intervenant_count_intervenant_target_after = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_target]
        );
        // a_obtenu
        $a_obtenu_count_intervenant_from_after = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_from]
        );
        $a_obtenu_count_intervenant_target_after = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervient_dans
        $intervient_dans_count_intervenant_from_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_from]
        );
        $intervient_dans_count_intervenant_target_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervention
        $intervention_count_intervenant_from_after = $this->tester->grabNumRecords(
            'intervention',
            ['id_user' => $id_user_from]
        );
        // seance
        $seance_count_intervenant_from_after = $this->tester->grabNumRecords(
            'seance',
            ['id_user' => $id_user_from]
        );
        // intervenants
        $intervenants_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        // user
        $users_count_after = $this->tester->grabNumRecords('users');

        // creneau
        $this->assertEquals(
            $creneaux_intervenant_count_intervenant_from_before + $creneaux_intervenant_count_intervenant_target_before,
            $creneaux_intervenant_count_intervenant_target_after
        );
        $this->assertEquals(0, $creneaux_intervenant_count_intervenant_from_after);
        // a_obtenu
        $this->assertEquals(
            $a_obtenu_count_intervenant_from_before + $a_obtenu_count_intervenant_target_before,
            $a_obtenu_count_intervenant_target_after
        ); // pas de diplomes en commun
        $this->assertEquals(0, $a_obtenu_count_intervenant_from_after);
        // intervient_dans
        $this->assertEquals(
            $intervient_dans_count_intervenant_from_before + $intervient_dans_count_intervenant_target_before,
            $intervient_dans_count_intervenant_target_after
        ); // pas de diplomes en commun
        $this->assertEquals(0, $intervient_dans_count_intervenant_from_after);
        // intervention
        $this->assertEquals(
            $intervention_count_intervenant_from_before,
            $intervention_count_intervenant_from_after
        );
        // seance
        $this->assertEquals(
            $seance_count_intervenant_from_before,
            $seance_count_intervenant_from_after
        );
        // intervenants
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after + 1);
        $this->assertEquals($intervenants_count_before, $intervenants_count_after + 1);
        // user
        $this->assertEquals($users_count_before, $users_count_after);
    }

    public function testFuseOkIntervenantFromIsNotUserAndIntervenantTargetIsUser()
    {
        $id_intervenant_from = "1";
        $id_intervenant_target = "4";

        $id_user_target = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_user',
            ['id_intervenant' => $id_intervenant_target]
        );

        // creneaux_intervenant
        $creneaux_intervenant_count_intervenant_from_before = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_from]
        );
        $creneaux_intervenant_count_intervenant_target_before = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_target]
        );
        // a_obtenu
        $a_obtenu_count_intervenant_from_before = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_from]
        );
        $a_obtenu_count_intervenant_target_before = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervient_dans
        $intervient_dans_count_intervenant_from_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_from]
        );
        $intervient_dans_count_intervenant_target_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervention
        $intervention_count_intervenant_target_before = $this->tester->grabNumRecords(
            'intervention',
            ['id_user' => $id_user_target]
        );
        // seance
        $seance_count_intervenant_target_before = $this->tester->grabNumRecords(
            'seance',
            ['id_user' => $id_user_target]
        );
        // intervenants
        $intervenants_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        // user
        $users_count_before = $this->tester->grabNumRecords('users');

        $fuse_ok = $this->intervenant->fuse($id_intervenant_from, $id_intervenant_target);
        $this->assertTrue($fuse_ok, $this->intervenant->getErrorMessage());

        // creneaux_intervenant
        $creneaux_intervenant_count_intervenant_from_after = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_from]
        );
        $creneaux_intervenant_count_intervenant_target_after = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_target]
        );
        // a_obtenu
        $a_obtenu_count_intervenant_from_after = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_from]
        );
        $a_obtenu_count_intervenant_target_after = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervient_dans
        $intervient_dans_count_intervenant_from_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_from]
        );
        $intervient_dans_count_intervenant_target_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervention
        $intervention_count_intervenant_target_after = $this->tester->grabNumRecords(
            'intervention',
            ['id_user' => $id_user_target]
        );
        // seance
        $seance_count_intervenant_target_after = $this->tester->grabNumRecords(
            'seance',
            ['id_user' => $id_user_target]
        );
        // intervenants
        $intervenants_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        // user
        $users_count_after = $this->tester->grabNumRecords('users');

        // creneau
        $this->assertEquals(0, $creneaux_intervenant_count_intervenant_from_after);
        $this->assertEquals(
            $creneaux_intervenant_count_intervenant_from_before + $creneaux_intervenant_count_intervenant_target_before,
            $creneaux_intervenant_count_intervenant_target_after,
            "creneau_count"
        );
        // a_obtenu
        $this->assertEquals(
            $a_obtenu_count_intervenant_from_before + $a_obtenu_count_intervenant_target_before,
            $a_obtenu_count_intervenant_target_after,
            "a_obtenu_count"
        ); // pas de diplomes en commun
        $this->assertEquals(0, $a_obtenu_count_intervenant_from_after);
        // intervient_dans
        $this->assertEquals(
            $intervient_dans_count_intervenant_from_before + $intervient_dans_count_intervenant_target_before,
            $intervient_dans_count_intervenant_target_after,
            "intervient_dans_count"
        ); // pas de structure en commun
        $this->assertEquals(0, $intervient_dans_count_intervenant_from_after);
        // intervention
        $this->assertEquals(
            $intervention_count_intervenant_target_before,
            $intervention_count_intervenant_target_after,
            "intervention_count"
        );
        $this->assertEquals(
            $seance_count_intervenant_target_before,
            $seance_count_intervenant_target_after,
            "seance_count"
        );
        $this->assertEquals(
            $coordonnees_count_before,
            $coordonnees_count_after + 1,
            "coordonnees_count"
        );
        $this->assertEquals(
            $intervenants_count_before,
            $intervenants_count_after + 1,
            "intervenants_count"
        );
        // user
        $this->assertEquals(
            $users_count_before,
            $users_count_after,
            "users_count"
        );
    }

    public function testFuseOkIntervenantFromIsUserAndIntervenantTargetIsUser()
    {
        $id_intervenant_from = "4";
        $id_intervenant_target = "7";

        $id_user_from = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_user',
            ['id_intervenant' => $id_intervenant_from]
        );
        $id_user_target = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_user',
            ['id_intervenant' => $id_intervenant_target]
        );

        // creneaux_intervenant
        $creneaux_intervenant_count_intervenant_from_before = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_from]
        );
        $creneaux_intervenant_count_intervenant_target_before = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_target]
        );
        // a_obtenu
        $a_obtenu_count_intervenant_from_before = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_from]
        );
        $a_obtenu_count_intervenant_target_before = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervient_dans
        $intervient_dans_count_intervenant_from_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_from]
        );
        $intervient_dans_count_intervenant_target_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervention
        $intervention_count_intervenant_from_before = $this->tester->grabNumRecords(
            'intervention',
            ['id_user' => $id_user_from]
        );
        $intervention_count_intervenant_target_before = $this->tester->grabNumRecords(
            'intervention',
            ['id_user' => $id_user_target]
        );
        // seance
        $seance_count_intervenant_from_before = $this->tester->grabNumRecords(
            'seance',
            ['id_user' => $id_user_from]
        );
        $seance_count_intervenant_target_before = $this->tester->grabNumRecords(
            'seance',
            ['id_user' => $id_user_target]
        );
        // intervenants
        $intervenants_count_before = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        // user
        $users_count_before = $this->tester->grabNumRecords('users');

        $fuse_ok = $this->intervenant->fuse($id_intervenant_from, $id_intervenant_target);
        $this->assertTrue($fuse_ok, $this->intervenant->getErrorMessage());

        // creneaux_intervenant
        $creneaux_intervenant_count_intervenant_from_after = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_from]
        );
        $creneaux_intervenant_count_intervenant_target_after = $this->tester->grabNumRecords(
            'creneaux_intervenant',
            ['id_intervenant' => $id_intervenant_target]
        );
        // a_obtenu
        $a_obtenu_count_intervenant_from_after = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_from]
        );
        $a_obtenu_count_intervenant_target_after = $this->tester->grabNumRecords(
            'a_obtenu',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervient_dans
        $intervient_dans_count_intervenant_from_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_from]
        );
        $intervient_dans_count_intervenant_target_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_intervenant' => $id_intervenant_target]
        );
        // intervention
        $intervention_count_intervenant_from_after = $this->tester->grabNumRecords(
            'intervention',
            ['id_user' => $id_user_from]
        );
        $intervention_count_intervenant_target_after = $this->tester->grabNumRecords(
            'intervention',
            ['id_user' => $id_user_target]
        );
        // seance
        $seance_count_intervenant_from_after = $this->tester->grabNumRecords(
            'seance',
            ['id_user' => $id_user_from]
        );
        $seance_count_intervenant_target_after = $this->tester->grabNumRecords(
            'seance',
            ['id_user' => $id_user_target]
        );
        // intervenants
        $intervenants_count_after = $this->tester->grabNumRecords('intervenants');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        // user
        $users_count_after = $this->tester->grabNumRecords('users');

        // creneau
        $this->assertEquals(
            $creneaux_intervenant_count_intervenant_from_before + $creneaux_intervenant_count_intervenant_target_before,
            $creneaux_intervenant_count_intervenant_target_after,
            "creneau_count"
        );
        $this->assertEquals(0, $creneaux_intervenant_count_intervenant_from_after);
        // a_obtenu
        $this->assertEquals(
            2,
            $a_obtenu_count_intervenant_target_after,
            "a_obtenu_count"
        ); // 1 diplome en commun pour les 2 intervenants
        $this->assertEquals(0, $a_obtenu_count_intervenant_from_after);
        // intervient_dans
        $this->assertEquals(
            $intervient_dans_count_intervenant_from_before + $intervient_dans_count_intervenant_target_before,
            $intervient_dans_count_intervenant_target_after,
            "intervient_dans_count"
        ); // pas de structure en commun
        $this->assertEquals(0, $intervient_dans_count_intervenant_from_after);
        // intervention
        $this->assertEquals(
            3,
            $intervention_count_intervenant_target_after,
            "intervention_count"
        ); // 1 structure en commun pour les 2 intervenants
        $this->assertEquals(0, $intervention_count_intervenant_from_after);
        // seance
        $this->assertEquals(
            $seance_count_intervenant_from_before + $seance_count_intervenant_target_before,
            $seance_count_intervenant_target_after,
            "seance_count"
        );
        $this->assertEquals(0, $seance_count_intervenant_from_after);
        // intervenants
        $this->assertEquals(
            $coordonnees_count_before,
            $coordonnees_count_after + 1,
            "coordonnees_count"
        );
        $this->assertEquals(
            $intervenants_count_before,
            $intervenants_count_after + 1,
            "intervenants_count"
        );
        // user
        $this->assertEquals(
            $users_count_before,
            $users_count_after + 1,
            "creneau_count"
        );
    }

    public function testDeleteNotOkId_intervenantNull()
    {
        $id_intervenant = null;

        $delete_ok = $this->intervenant->delete($id_intervenant);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkId_intervenantInvalide()
    {
        $id_intervenant = '-1';

        $delete_ok = $this->intervenant->delete($id_intervenant);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkIntervenantDansCreneaux()
    {
        $id_intervenant = '2';

        $delete_ok = $this->intervenant->delete($id_intervenant);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkIntervenantUtilisateur()
    {
        $id_intervenant = '4';

        $delete_ok = $this->intervenant->delete($id_intervenant);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteOk()
    {
        $id_intervenant = '6';

        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_before = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');
        $intervenants_count_before = $this->tester->grabNumRecords('intervenants');

        $delete_ok = $this->intervenant->delete($id_intervenant);
        $this->assertTrue($delete_ok, $this->intervenant->getErrorMessage());

        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');
        $a_obtenu_count_after = $this->tester->grabNumRecords('a_obtenu');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');
        $intervenants_count_after = $this->tester->grabNumRecords('intervenants');

        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after + 1);
        $this->assertEquals($a_obtenu_count_before, $a_obtenu_count_after + 2); // l'intervenant a 2 diplômes
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after + 1);
        $this->assertEquals($intervenants_count_before, $intervenants_count_after + 1);

        $this->tester->dontSeeInDatabase('coordonnees', [
            'id_intervenant' => $id_intervenant,
        ]);

        $this->tester->dontSeeInDatabase('a_obtenu', [
            'id_intervenant' => $id_intervenant,
        ]);

        $this->tester->dontSeeInDatabase('intervient_dans', [
            'id_intervenant' => $id_intervenant,
        ]);

        $this->tester->dontSeeInDatabase('intervenants', [
            'id_intervenant' => $id_intervenant,
        ]);

        $this->tester->dontSeeInDatabase('creneaux_intervenant', [
            'id_intervenant' => $id_intervenant,
        ]);
    }

    public function testGetIntervenantsSuivantsPatientOk()
    {
        $id_patient = "1";

        $ids = $this->intervenant->getIntervenantsSuivantsPatient($id_patient);
        $this->assertNotFalse($ids);
        $this->assertIsArray($ids);
        $this->assertCount(2, $ids);
    }

    public function testGetIntervenantsSuivantsPatientOkEmptyResult()
    {
        $id_patient = "5";

        $ids = $this->intervenant->getIntervenantsSuivantsPatient($id_patient);
        $this->assertNotFalse($ids);
        $this->assertIsArray($ids);
        $this->assertCount(0, $ids);
    }

    public function testGetIntervenantsSuivantsPatientNotOk()
    {
        $id_patient = null;

        $ids = $this->intervenant->getIntervenantsSuivantsPatient($id_patient);
        $this->assertFalse($ids);
    }
}