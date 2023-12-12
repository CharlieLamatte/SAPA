<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\Structure;
use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\UnitTester;

class StructureTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Structure $structure;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->structure = new Structure($pdo);
        $this->assertNotNull($this->structure);
    }

    protected function _after()
    {
    }

    public function testCreateOkMinimumData()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfgdfgwpod");
        $id_statut_structure = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfgsdf");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_statut_juridique = "2";

        $structure_count_before = $this->tester->grabNumRecords('structure');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_situe_a_count_before = $this->tester->grabNumRecords('se_situe_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');

        // intervenants
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        // antennes
        $antenne_count_before = $this->tester->grabNumRecords('antenne');

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertNotFalse($id_structure);

        $structure_count_after = $this->tester->grabNumRecords('structure');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_situe_a_count_after = $this->tester->grabNumRecords('se_situe_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');

        //intervenants
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');
        // antennes
        $antenne_count_after = $this->tester->grabNumRecords('antenne');

        $this->assertEquals($structure_count_before + 1, $structure_count_after, 'a');
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after, 'b');
        $this->assertEquals($se_situe_a_count_before + 1, $se_situe_a_count_after, 'c');
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after, 'd');
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after, 'e'); // TODO

        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after, 'f');
        $this->assertEquals($antenne_count_before + 1, $antenne_count_after, 'g');

        $id_adresse = $this->tester->grabFromDatabase(
            'se_situe_a',
            'id_adresse',
            ['id_structure' => $id_structure]
        );

        $this->tester->seeInDatabase('structure', [
            'id_structure' => $id_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_statut_juridique' => $id_statut_juridique,
            'nom_structure' => $nom_structure,
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
        ]);

        $this->tester->seeInDatabase('se_situe_a', [
            'id_adresse' => $id_adresse,
            'id_structure' => $id_structure,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);
    }

    public function testCreateOkApiMinimumData()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfgdfgwpod");
        $id_statut_structure = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfgsdf");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_statut_juridique = "2";

        $id_api = "api-structure-" . ChaineCharactere::str_shuffle_unicode(
                "sdfgsdfgsdf"
            ) . '-' . ChaineCharactere::str_shuffle_unicode("97876567") . '-' . ChaineCharactere::str_shuffle_unicode(
                "seetrtjserjt"
            );

        $structure_count_before = $this->tester->grabNumRecords('structure');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_situe_a_count_before = $this->tester->grabNumRecords('se_situe_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');

        // intervenants
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        // antennes
        $antenne_count_before = $this->tester->grabNumRecords('antenne');

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,

            'id_api' => $id_api,
        ]);
        $this->assertNotFalse($id_structure);

        $structure_count_after = $this->tester->grabNumRecords('structure');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_situe_a_count_after = $this->tester->grabNumRecords('se_situe_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');

        //intervenants
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');
        // antennes
        $antenne_count_after = $this->tester->grabNumRecords('antenne');

        $this->assertEquals($structure_count_before + 1, $structure_count_after, 'a');
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after, 'b');
        $this->assertEquals($se_situe_a_count_before + 1, $se_situe_a_count_after, 'c');
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after, 'd');
        $this->assertEquals($coordonnees_count_before, $coordonnees_count_after, 'e'); // TODO

        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after, 'f');
        $this->assertEquals($antenne_count_before + 1, $antenne_count_after, 'g');

        $id_adresse = $this->tester->grabFromDatabase(
            'se_situe_a',
            'id_adresse',
            ['id_structure' => $id_structure]
        );

        $this->tester->seeInDatabase('structure', [
            'id_structure' => $id_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_statut_juridique' => $id_statut_juridique,
            'nom_structure' => $nom_structure,
            'id_api' => $id_api,
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
        ]);

        $this->tester->seeInDatabase('se_situe_a', [
            'id_adresse' => $id_adresse,
            'id_structure' => $id_structure,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);
    }

    public function testCreateOkAllData()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfgdfgwpod");
        $id_statut_structure = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgdfgsdfg");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_statut_juridique = "2";

        // paramètres optionnels
        $complement_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfg");
        $id_territoire = "1";
        $intervenants = ["1", "2"];
        $antennes = [
            ["nom_antenne" => ChaineCharactere::str_shuffle_unicode("sdfgsdg")],
            ["nom_antenne" => ChaineCharactere::str_shuffle_unicode("sdfsdfsggg")],
        ];
        $lien_ref_structure = ChaineCharactere::str_shuffle_unicode("hjkluiohuoi");
        $code_onaps = ChaineCharactere::str_shuffle_unicode("hjkluiohuoi");

        // representant de la structure
        $nom_representant = ChaineCharactere::str_shuffle_unicode("tynertye");
        $prenom_representant = ChaineCharactere::str_shuffle_unicode("qsdfnyrt");
        $email = ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd") . '@gmail.com';
        $tel_fixe = ChaineCharactere::str_shuffle_unicode('0123456789');
        $tel_portable = ChaineCharactere::str_shuffle_unicode('0123456789');

        //$id_api = $parameters['id_api'] ?? null;

        $structure_count_before = $this->tester->grabNumRecords('structure');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_situe_a_count_before = $this->tester->grabNumRecords('se_situe_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');

        // intervenants
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        // antennes
        $antenne_count_before = $this->tester->grabNumRecords('antenne');

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,

            'complement_adresse' => $complement_adresse,
            'id_territoire' => $id_territoire,
            'intervenants' => $intervenants,
            'antennes' => $antennes,
            'lien_ref_structure' => $lien_ref_structure,
            'code_onaps' => $code_onaps,

            'nom_representant' => $nom_representant,
            'prenom_representant' => $prenom_representant,
            'email' => $email,
            'tel_fixe' => $tel_fixe,
            'tel_portable' => $tel_portable,
        ]);
        $this->assertNotFalse($id_structure);

        $structure_count_after = $this->tester->grabNumRecords('structure');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_situe_a_count_after = $this->tester->grabNumRecords('se_situe_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');

        //intervenants
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');
        // antennes
        $antenne_count_after = $this->tester->grabNumRecords('antenne');

        $this->assertEquals($structure_count_before + 1, $structure_count_after, 'a');
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after, 'b');
        $this->assertEquals($se_situe_a_count_before + 1, $se_situe_a_count_after, 'c');
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after, 'd');
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after, 'e'); // TODO

        $this->assertEquals($intervient_dans_count_before + count($intervenants), $intervient_dans_count_after, 'f');
        $this->assertEquals($antenne_count_before + count($antennes), $antenne_count_after, 'g');

        $id_adresse = $this->tester->grabFromDatabase(
            'se_situe_a',
            'id_adresse',
            ['id_structure' => $id_structure]
        );

        $id_coordonnees = $this->tester->grabFromDatabase(
            'structure',
            'id_coordonnees',
            ['id_structure' => $id_structure]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom_representant,
            'prenom_coordonnees' => $prenom_representant,
            'mail_coordonnees' => $email,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ]);

        $this->tester->seeInDatabase('structure', [
            'id_structure' => $id_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_statut_juridique' => $id_statut_juridique,
            'id_territoire' => $id_territoire,
            'nom_structure' => $nom_structure,
            'lien_ref_structure' => $lien_ref_structure,
            'code_onaps' => $code_onaps,
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->tester->seeInDatabase('se_situe_a', [
            'id_adresse' => $id_adresse,
            'id_structure' => $id_structure,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        foreach ($intervenants as $id_intervenant) {
            $this->tester->seeInDatabase('intervient_dans', [
                'id_intervenant' => $id_intervenant,
                'id_structure' => $id_structure,
            ]);
        }

        foreach ($antennes as $antenne) {
            $this->tester->seeInDatabase('antenne', [
                'nom_antenne' => $antenne['nom_antenne'],
                'id_structure' => $id_structure,
            ]);
        }
    }

    public function testCreateOkApiAllData()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfgdfgwpod");
        $id_statut_structure = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgdfgsdfg");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_statut_juridique = "2";

        // paramètres optionnels
        $complement_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfg");
        $id_territoire = "1";
        $intervenants = ["1", "2"];
        $antennes = [
            ["nom_antenne" => ChaineCharactere::str_shuffle_unicode("sdfgsdg")],
            ["nom_antenne" => ChaineCharactere::str_shuffle_unicode("sdfsdfsggg")],
        ];
        $lien_ref_structure = ChaineCharactere::str_shuffle_unicode("hjkluiohuoi");
        $code_onaps = ChaineCharactere::str_shuffle_unicode("hjkluiohuoi");

        // representant de la structure
        $nom_representant = ChaineCharactere::str_shuffle_unicode("tynertye");
        $prenom_representant = ChaineCharactere::str_shuffle_unicode("qsdfnyrt");
        $email = ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd") . '@gmail.com';
        $tel_fixe = ChaineCharactere::str_shuffle_unicode('0123456789');
        $tel_portable = ChaineCharactere::str_shuffle_unicode('0123456789');

        $id_api = "api-structure-" . ChaineCharactere::str_shuffle_unicode(
                "uoioipuiopsdn"
            ) . '-' . ChaineCharactere::str_shuffle_unicode("1250975658") . '-' . ChaineCharactere::str_shuffle_unicode(
                "gfndhgfhfwstktyf"
            );

        $structure_count_before = $this->tester->grabNumRecords('structure');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_situe_a_count_before = $this->tester->grabNumRecords('se_situe_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $coordonnees_count_before = $this->tester->grabNumRecords('coordonnees');

        // intervenants
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        // antennes
        $antenne_count_before = $this->tester->grabNumRecords('antenne');

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,

            'complement_adresse' => $complement_adresse,
            'id_territoire' => $id_territoire,
            'intervenants' => $intervenants,
            'antennes' => $antennes,
            'lien_ref_structure' => $lien_ref_structure,
            'code_onaps' => $code_onaps,

            'nom_representant' => $nom_representant,
            'prenom_representant' => $prenom_representant,
            'email' => $email,
            'tel_fixe' => $tel_fixe,
            'tel_portable' => $tel_portable,

            'id_api' => $id_api,
        ]);
        $this->assertNotFalse($id_structure);

        $structure_count_after = $this->tester->grabNumRecords('structure');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_situe_a_count_after = $this->tester->grabNumRecords('se_situe_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $coordonnees_count_after = $this->tester->grabNumRecords('coordonnees');

        //intervenants
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');
        // antennes
        $antenne_count_after = $this->tester->grabNumRecords('antenne');

        $this->assertEquals($structure_count_before + 1, $structure_count_after, 'a');
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after, 'b');
        $this->assertEquals($se_situe_a_count_before + 1, $se_situe_a_count_after, 'c');
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after, 'd');
        $this->assertEquals($coordonnees_count_before + 1, $coordonnees_count_after, 'e'); // TODO

        $this->assertEquals($intervient_dans_count_before + count($intervenants), $intervient_dans_count_after, 'f');
        $this->assertEquals($antenne_count_before + count($antennes), $antenne_count_after, 'g');

        $id_adresse = $this->tester->grabFromDatabase(
            'se_situe_a',
            'id_adresse',
            ['id_structure' => $id_structure]
        );

        $id_coordonnees = $this->tester->grabFromDatabase(
            'structure',
            'id_coordonnees',
            ['id_structure' => $id_structure]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom_representant,
            'prenom_coordonnees' => $prenom_representant,
            'mail_coordonnees' => $email,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ]);

        $this->tester->seeInDatabase('structure', [
            'id_structure' => $id_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_statut_juridique' => $id_statut_juridique,
            'id_territoire' => $id_territoire,
            'nom_structure' => $nom_structure,
            'lien_ref_structure' => $lien_ref_structure,
            'code_onaps' => $code_onaps,
            'id_api' => $id_api,
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->tester->seeInDatabase('se_situe_a', [
            'id_adresse' => $id_adresse,
            'id_structure' => $id_structure,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        foreach ($intervenants as $id_intervenant) {
            $this->tester->seeInDatabase('intervient_dans', [
                'id_intervenant' => $id_intervenant,
                'id_structure' => $id_structure,
            ]);
        }

        foreach ($antennes as $antenne) {
            $this->tester->seeInDatabase('antenne', [
                'nom_antenne' => $antenne['nom_antenne'],
                'id_structure' => $id_structure,
            ]);
        }
    }

    public function testCreateNotOkNom_structureNull()
    {
        // paramètres obligatoires
        $nom_structure = null;
        $id_statut_structure = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfgsdf");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_statut_juridique = "2";

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($id_structure);
    }

    public function testCreateNotOkId_statut_structureNull()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfgdfgwpod");
        $id_statut_structure = null;
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfgsdf");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_statut_juridique = "2";

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($id_structure);
    }

    public function testCreateNotOkNom_adresseNull()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfgdfgwpod");
        $id_statut_structure = "2";
        $nom_adresse = null;
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_statut_juridique = "2";

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($id_structure);
    }

    public function testCreateNotOkCode_postalNull()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfgdfgwpod");
        $id_statut_structure = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfgsdf");
        $code_postal = null;
        $nom_ville = "POITIERS";
        $id_statut_juridique = "2";

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($id_structure);
    }

    public function testCreateNotOkNom_villeNull()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfgdfgwpod");
        $id_statut_structure = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfgsdf");
        $code_postal = "86000";
        $nom_ville = null;
        $id_statut_juridique = "2";

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($id_structure);
    }

    public function testCreateNotOkId_statut_juridiqueNull()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfgdfgwpod");
        $id_statut_structure = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfgsdf");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_statut_juridique = null;

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($id_structure);
    }

    public function testCreateNotOkApiStructureAlreadyImported()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfghfdghdfgh");
        $id_statut_structure = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfndfg");
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $id_statut_juridique = "2";

        $id_api = "api-structure-98766568-sdfg";

        $id_structure = $this->structure->create([
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,

            'id_api' => $id_api,
        ]);
        $this->assertFalse($id_structure);
    }

    public function testUpdateOkMinimumData1()
    {
        // paramètres obligatoires
        $id_structure = "1";
        $id_territoire = "2";
        $nom_structure = ChaineCharactere::str_shuffle_unicode("sdlfgbdsbf");
        $id_statut_structure = "3";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfndfg");
        $code_postal = "86100";
        $nom_ville = "CHATELLERAULT";
        $id_statut_juridique = "4";

        // données connues
        $id_ville = '33286';

        // intervenants
        $intervient_dans_count_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure]
        );

        // antennes
        $antenne_count_before = $this->tester->grabNumRecords('antenne', ['id_structure' => $id_structure]);

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertTrue($update_ok, $this->structure->getErrorMessage());

        //intervenants
        $intervient_dans_count_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure]
        );
        // antennes
        $antenne_count_after = $this->tester->grabNumRecords('antenne', ['id_structure' => $id_structure]);

        $this->assertEquals(
            3,
            $intervient_dans_count_after,
            'a'
        ); // il y a 3 intervenants qui ont des créneaux dans la structure
        $this->assertEquals(1, $antenne_count_after, 'b');

        $id_adresse = $this->tester->grabFromDatabase(
            'se_situe_a',
            'id_adresse',
            ['id_structure' => $id_structure]
        );

        $this->tester->seeInDatabase('structure', [
            'id_structure' => $id_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_statut_juridique' => $id_statut_juridique,
            'id_territoire' => $id_territoire,
            'nom_structure' => $nom_structure,
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
        ]);

        $this->tester->seeInDatabase('se_situe_a', [
            'id_adresse' => $id_adresse,
            'id_structure' => $id_structure,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
            'id_ville' => $id_ville,
        ]);
    }

    public function testUpdateOkMinimumData2()
    {
        // paramètres obligatoires
        $id_structure = "3";
        $id_territoire = "2";
        $nom_structure = ChaineCharactere::str_shuffle_unicode("sdlfgbdsbf");
        $id_statut_structure = "3";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfndfg");
        $code_postal = "86100";
        $nom_ville = "CHATELLERAULT";
        $id_statut_juridique = "4";

        // données connues
        $id_ville = '33286';
        $nom_antenne_3 = 'STRUCT TEST 3';
        $id_antenne_3 = '3';

        // intervenants
        $intervient_dans_count_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure]
        );

        // antennes
        $antenne_count_before = $this->tester->grabNumRecords('antenne', ['id_structure' => $id_structure]);

        $this->assertEquals(1, $intervient_dans_count_before, 'a');
        $this->assertEquals(1, $antenne_count_before, 'b');

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertTrue($update_ok, $this->structure->getErrorMessage());

        //intervenants
        $intervient_dans_count_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure]
        );
        // antennes
        $antenne_count_after = $this->tester->grabNumRecords('antenne', ['id_structure' => $id_structure]);

        $this->assertEquals(0, $intervient_dans_count_after, 'c');
        $this->assertEquals(1, $antenne_count_after, 'd');

        $id_adresse = $this->tester->grabFromDatabase(
            'se_situe_a',
            'id_adresse',
            ['id_structure' => $id_structure]
        );

        $this->tester->seeInDatabase('structure', [
            'id_structure' => $id_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_statut_juridique' => $id_statut_juridique,
            'id_territoire' => $id_territoire,
            'nom_structure' => $nom_structure,
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
        ]);

        $this->tester->seeInDatabase('se_situe_a', [
            'id_adresse' => $id_adresse,
            'id_structure' => $id_structure,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
            'id_ville' => $id_ville,
        ]);

        $this->tester->seeInDatabase('antenne', [
            'nom_antenne' => $nom_antenne_3,
            'id_structure' => $id_structure,
            'id_antenne' => $id_antenne_3
        ]);
    }

    public function testUpdateOkAllData()
    {
        // paramètres obligatoires
        $nom_structure = ChaineCharactere::str_shuffle_unicode("dfgdfgwpod");
        $id_statut_structure = "2";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgdfgsdfg");
        $code_postal = "86100";
        $nom_ville = "CHATELLERAULT";
        $id_statut_juridique = "3";
        $id_structure = "1";
        $id_territoire = "2";

        // paramètres optionnels
        $complement_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfg");
        $intervenants = ["1", "2", "5", "7", "4"]; // "1", "2", "5", "7" déjà présent
        $antennes = [
            ["id_antenne" => "1", "nom_antenne" => ChaineCharactere::str_shuffle_unicode("sfdhdshfg")],
            ["id_antenne" => null, "nom_antenne" => ChaineCharactere::str_shuffle_unicode("poiupoi")],
        ]; // "1" déjà présent
        $lien_ref_structure = ChaineCharactere::str_shuffle_unicode("hjkluiohuoi");
        $code_onaps = ChaineCharactere::str_shuffle_unicode("hjkluiohuoi");

        // representant de la structure
        $nom_representant = ChaineCharactere::str_shuffle_unicode("tynertye");
        $prenom_representant = ChaineCharactere::str_shuffle_unicode("qsdfnyrt");
        $email = ChaineCharactere::str_shuffle_unicode("defefdfedfjhkhvOkljfhgjd") . '@gmail.com';
        $tel_fixe = ChaineCharactere::str_shuffle_unicode('0123456789');
        $tel_portable = ChaineCharactere::str_shuffle_unicode('0123456789');

        // données connues
        $id_ville = '33286';

        // intervenants
        $intervient_dans_count_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure]
        );

        // antennes
        $antenne_count_before = $this->tester->grabNumRecords('antenne', ['id_structure' => $id_structure]);

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,

            'complement_adresse' => $complement_adresse,
            'intervenants' => $intervenants,
            'antennes' => $antennes,
            'lien_ref_structure' => $lien_ref_structure,
            'code_onaps' => $code_onaps,

            'nom_representant' => $nom_representant,
            'prenom_representant' => $prenom_representant,
            'email' => $email,
            'tel_fixe' => $tel_fixe,
            'tel_portable' => $tel_portable,
        ]);
        $this->assertTrue($update_ok, $this->structure->getErrorMessage());

        //intervenants
        $intervient_dans_count_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure]
        );
        // antennes
        $antenne_count_after = $this->tester->grabNumRecords('antenne', ['id_structure' => $id_structure]);

        $this->assertEquals(count($intervenants), $intervient_dans_count_after, 'a');
        $this->assertEquals(count($antennes), $antenne_count_after, 'b');

        $id_adresse = $this->tester->grabFromDatabase(
            'se_situe_a',
            'id_adresse',
            ['id_structure' => $id_structure]
        );

        $id_coordonnees = $this->tester->grabFromDatabase(
            'structure',
            'id_coordonnees',
            ['id_structure' => $id_structure]
        );

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom_representant,
            'prenom_coordonnees' => $prenom_representant,
            'mail_coordonnees' => $email,
            'tel_portable_coordonnees' => $tel_portable,
            'tel_fixe_coordonnees' => $tel_fixe,
        ]);

        $this->tester->seeInDatabase('structure', [
            'id_structure' => $id_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_statut_juridique' => $id_statut_juridique,
            'id_territoire' => $id_territoire,
            'nom_structure' => $nom_structure,
            'lien_ref_structure' => $lien_ref_structure,
            'code_onaps' => $code_onaps,
        ]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->tester->seeInDatabase('se_situe_a', [
            'id_adresse' => $id_adresse,
            'id_structure' => $id_structure,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
            'id_ville' => $id_ville,
        ]);

        foreach ($intervenants as $id_intervenant) {
            $this->tester->seeInDatabase('intervient_dans', [
                'id_intervenant' => $id_intervenant,
                'id_structure' => $id_structure,
            ]);
        }

        foreach ($antennes as $antenne) {
            $this->tester->seeInDatabase('antenne', [
                'nom_antenne' => $antenne['nom_antenne'],
                'id_structure' => $id_structure,
            ]);
        }
    }

    public function testUpdateNotOkId_structureNull()
    {
        // paramètres obligatoires
        $id_structure = null;
        $id_territoire = "2";
        $nom_structure = ChaineCharactere::str_shuffle_unicode("sdlfgbdsbf");
        $id_statut_structure = "3";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfndfg");
        $code_postal = "86100";
        $nom_ville = "CHATELLERAULT";
        $id_statut_juridique = "4";

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_territoireNull()
    {
        // paramètres obligatoires
        $id_structure = "1";
        $id_territoire = null;
        $nom_structure = ChaineCharactere::str_shuffle_unicode("sdlfgbdsbf");
        $id_statut_structure = "3";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfndfg");
        $code_postal = "86100";
        $nom_ville = "CHATELLERAULT";
        $id_statut_juridique = "4";

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkNom_structureNull()
    {
        // paramètres obligatoires
        $id_structure = "1";
        $id_territoire = "2";
        $nom_structure = null;
        $id_statut_structure = "3";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfndfg");
        $code_postal = "86100";
        $nom_ville = "CHATELLERAULT";
        $id_statut_juridique = "4";

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_statut_structureNull()
    {
        // paramètres obligatoires
        $id_structure = "1";
        $id_territoire = "2";
        $nom_structure = ChaineCharactere::str_shuffle_unicode("sdlfgbdsbf");
        $id_statut_structure = null;
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfndfg");
        $code_postal = "86100";
        $nom_ville = "CHATELLERAULT";
        $id_statut_juridique = "4";

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkNom_adresseNull()
    {
        // paramètres obligatoires
        $id_structure = "1";
        $id_territoire = "2";
        $nom_structure = ChaineCharactere::str_shuffle_unicode("sdlfgbdsbf");
        $id_statut_structure = "3";
        $nom_adresse = null;
        $code_postal = "86100";
        $nom_ville = "CHATELLERAULT";
        $id_statut_juridique = "4";

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkCode_postalNull()
    {
        // paramètres obligatoires
        $id_structure = "1";
        $id_territoire = "2";
        $nom_structure = ChaineCharactere::str_shuffle_unicode("sdlfgbdsbf");
        $id_statut_structure = "3";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfndfg");
        $code_postal = null;
        $nom_ville = "CHATELLERAULT";
        $id_statut_juridique = "4";

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkNom_villeNull()
    {
        // paramètres obligatoires
        $id_structure = "1";
        $id_territoire = "2";
        $nom_structure = ChaineCharactere::str_shuffle_unicode("sdlfgbdsbf");
        $id_statut_structure = "3";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfndfg");
        $code_postal = "86100";
        $nom_ville = null;
        $id_statut_juridique = "4";

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkId_statut_juridiqueNull()
    {
        // paramètres obligatoires
        $id_structure = "1";
        $id_territoire = "2";
        $nom_structure = ChaineCharactere::str_shuffle_unicode("sdlfgbdsbf");
        $id_statut_structure = "3";
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("sdfgsdfndfg");
        $code_postal = "86100";
        $nom_ville = "CHATELLERAULT";
        $id_statut_juridique = null;

        $update_ok = $this->structure->update([
            'id_structure' => $id_structure,
            'nom_structure' => $nom_structure,
            'id_statut_structure' => $id_statut_structure,
            'id_territoire' => $id_territoire,
            'nom_adresse' => $nom_adresse,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'id_statut_juridique' => $id_statut_juridique,
        ]);
        $this->assertFalse($update_ok);
    }


    public function testSaveLogoOkLogoPresent()
    {
        $id_statut_structure = "1";
        $id_structure = "8";
        $logo_est_present = true;
        $logo_data = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAArCAIAAAC1hEy1AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEBSURBVFhH7Y7RDsQgCAT7/z/d2xTSmioLJPX0gXkxyAJznFtSWhlKK8NGWsfxyOyiBafttF5OYL1W7wRWaokQ0LphmZYlJEzRIveACAGtR8zSsq6SVssULTC8HXQC/9OKO4E/aaWcgBmVRS+0F6ANZ2dB7pKgNeWOxUdaxgNkkZwBWhtIIJIcktYSIgFB6ySmFt8YDLRoI4aZdhfxwGXyBF6lC9Pii7Lda1/UzFlNFvEbwy4faXFy1iL88xvDrjt142sJWl/0Pz1WwB0UYqEObdhYmei4vl9DbpdWB7/tmi3TcgL6fg2/CrjZLK0I+2pZZiu1CKWVobQylFaG0opznj+IhLCT4xhjcgAAAABJRU5ErkJggg==";

        $save_ok = $this->structure->saveLogo([
            'id_statut_structure' => $id_statut_structure,
            'id_structure' => $id_structure,
            'logo_est_present' => $logo_est_present,
            'logo_data' => $logo_data,
        ]);
        $this->assertTrue($save_ok, $this->structure->getErrorMessage());
    }

    public function testSaveLogoOkLogoNonPresent()
    {
        $id_statut_structure = "1";
        $id_structure = "8";
        $logo_est_present = false;
        $logo_data = null;

        $save_ok = $this->structure->saveLogo([
            'id_statut_structure' => $id_statut_structure,
            'id_structure' => $id_structure,
            'logo_est_present' => $logo_est_present,
            'logo_data' => $logo_data,
        ]);
        $this->assertTrue($save_ok);
    }

    public function testSaveLogoNotOkId_statut_structureNull()
    {
        $id_statut_structure = null;
        $id_structure = "8";
        $logo_est_present = false;
        $logo_data = null;

        $save_ok = $this->structure->saveLogo([
            'id_statut_structure' => $id_statut_structure,
            'id_structure' => $id_structure,
            'logo_est_present' => $logo_est_present,
            'logo_data' => $logo_data,
        ]);
        $this->assertFalse($save_ok);
    }

    public function testSaveLogoNotOkId_structureNull()
    {
        $id_statut_structure = "1";
        $id_structure = null;
        $logo_est_present = false;
        $logo_data = null;

        $save_ok = $this->structure->saveLogo([
            'id_statut_structure' => $id_statut_structure,
            'id_structure' => $id_structure,
            'logo_est_present' => $logo_est_present,
            'logo_data' => $logo_data,
        ]);
        $this->assertFalse($save_ok);
    }

    public function testSaveLogoNotOkLogo_est_presentNull()
    {
        $id_statut_structure = "1";
        $id_structure = "8";
        $logo_est_present = null;
        $logo_data = null;

        $save_ok = $this->structure->saveLogo([
            'id_statut_structure' => $id_statut_structure,
            'id_structure' => $id_structure,
            'logo_est_present' => $logo_est_present,
            'logo_data' => $logo_data,
        ]);
        $this->assertFalse($save_ok);
    }

    public function testSaveLogoNotOkLogo_est_presentAndLogo_dataNull()
    {
        $id_statut_structure = "1";
        $id_structure = "8";
        $logo_est_present = true;
        $logo_data = null;

        $save_ok = $this->structure->saveLogo([
            'id_statut_structure' => $id_statut_structure,
            'id_structure' => $id_structure,
            'logo_est_present' => $logo_est_present,
            'logo_data' => $logo_data,
        ]);
        $this->assertFalse($save_ok);
    }

    public function testReadOneOk()
    {
        $id_structure = '1';

        $item = $this->structure->readOne($id_structure);

        $this->assertNotFalse($item);
        $this->assertIsArray($item);

        $this->assertArrayHasKey('id_structure', $item);
        $this->assertArrayHasKey('nom_structure', $item);
        $this->assertArrayHasKey('code_onaps', $item);
        $this->assertArrayHasKey('id_statut_structure', $item);
        $this->assertArrayHasKey('nom_statut_structure', $item);
        $this->assertArrayHasKey('nom_adresse', $item);
        $this->assertArrayHasKey('complement_adresse', $item);
        $this->assertArrayHasKey('code_postal', $item);
        $this->assertArrayHasKey('nom_ville', $item);
        $this->assertArrayHasKey('id_territoire', $item);
        $this->assertArrayHasKey('nom_territoire', $item);
        $this->assertArrayHasKey('id_statut_juridique', $item);
        $this->assertArrayHasKey('nom_representant', $item);
        $this->assertArrayHasKey('prenom_representant', $item);
        $this->assertArrayHasKey('tel_fixe', $item);
        $this->assertArrayHasKey('tel_portable', $item);
        $this->assertArrayHasKey('email', $item);
        $this->assertArrayHasKey('lien_ref_structure', $item);
        $this->assertArrayHasKey('logo_fichier', $item);

        $this->assertArrayHasKey('intervenants', $item);
        $this->assertIsArray($item['intervenants']);
        $this->assertArrayHasKey('creneaux', $item);
        $this->assertIsArray($item['creneaux']);
        $this->assertArrayHasKey('antennes', $item);
        $this->assertIsArray($item['antennes']);
    }

    public function testReadOneNotOkId_structureNull()
    {
        $id_structure = null;

        $item = $this->structure->readOne($id_structure);
        $this->assertFalse($item);
    }

    public function testReadOneNotOkId_structureDoesntExist()
    {
        $id_structure = '-1';

        $item = $this->structure->readOne($id_structure);
        $this->assertFalse($item);
    }

    public function testReadAllOkAdmin()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
        ];

        $structures = $this->structure->readAll($session);

        $this->assertNotFalse($structures);
        $this->assertIsArray($structures);

        $total_count = $this->tester->grabNumRecords('structure');

        $this->assertCount($total_count, $structures);

        foreach ($structures as $structure) {
            $this->assertArrayHasKey('id_structure', $structure);
            $this->assertArrayHasKey('nom_structure', $structure);
            $this->assertArrayHasKey('id_statut_structure', $structure);
            $this->assertArrayHasKey('id_territoire', $structure);
            $this->assertArrayHasKey('lien_ref_structure', $structure);
            $this->assertArrayHasKey('nom_statut_structure', $structure);
            $this->assertArrayHasKey('nom_adresse', $structure);
            $this->assertArrayHasKey('complement_adresse', $structure);
            $this->assertArrayHasKey('code_postal', $structure);
            $this->assertArrayHasKey('nom_ville', $structure);
            $this->assertArrayHasKey('nom_territoire', $structure);
        }
    }

    public function testReadAllOkAdminOptionnalId_territoireUsed()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
        ];
        $id_territoire = '1';

        $structures = $this->structure->readAll($session, $id_territoire);

        $this->assertIsArray($structures);
        $expected_count = $this->tester->grabNumRecords(
            'structure',
            ['id_territoire' => $id_territoire, 'id_statut_structure !=' => '5']
        );
        $this->assertCount($expected_count, $structures);

        foreach ($structures as $structure) {
            $this->assertArrayHasKey('id_structure', $structure);
            $this->assertArrayHasKey('nom_structure', $structure);
            $this->assertArrayHasKey('id_statut_structure', $structure);
            $this->assertArrayHasKey('id_territoire', $structure);
            $this->assertArrayHasKey('lien_ref_structure', $structure);
            $this->assertArrayHasKey('nom_statut_structure', $structure);
            $this->assertArrayHasKey('nom_adresse', $structure);
            $this->assertArrayHasKey('complement_adresse', $structure);
            $this->assertArrayHasKey('code_postal', $structure);
            $this->assertArrayHasKey('nom_ville', $structure);
            $this->assertArrayHasKey('nom_territoire', $structure);
        }
    }

    public function testReadAllOkCoordonnateurPeps()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => '2',
            'id_territoire' => '1',
        ];

        $structures = $this->structure->readAll($session);

        $this->assertIsArray($structures);
        $expected_count = $this->tester->grabNumRecords(
            'structure',
            ['id_territoire' => $session['id_territoire'], 'id_statut_structure !=' => '5']
        );
        $this->assertCount($expected_count, $structures);
    }

    public function testReadAllOkCoordonnateurMss()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '1',
            'id_territoire' => '1',
        ];

        $structures = $this->structure->readAll($session);

        $this->assertIsArray($structures);
        $expected_count = $this->tester->grabNumRecords(
            'structure',
            ['id_territoire' => $session['id_territoire'], 'id_statut_structure !=' => '5']
        );
        $this->assertCount($expected_count, $structures);

        foreach ($structures as $structure) {
            $this->assertArrayHasKey('id_structure', $structure);
            $this->assertArrayHasKey('nom_structure', $structure);
            $this->assertArrayHasKey('id_statut_structure', $structure);
            $this->assertArrayHasKey('id_territoire', $structure);
            $this->assertArrayHasKey('lien_ref_structure', $structure);
            $this->assertArrayHasKey('nom_statut_structure', $structure);
            $this->assertArrayHasKey('nom_adresse', $structure);
            $this->assertArrayHasKey('complement_adresse', $structure);
            $this->assertArrayHasKey('code_postal', $structure);
            $this->assertArrayHasKey('nom_ville', $structure);
            $this->assertArrayHasKey('nom_territoire', $structure);
        }
    }

    public function testReadAllOkCoordonnateurNonMss()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '3',
            'id_territoire' => '1',
        ];

        $structures = $this->structure->readAll($session);

        $this->assertIsArray($structures);
        $expected_count = $this->tester->grabNumRecords(
            'structure',
            ['id_territoire' => $session['id_territoire'], 'id_statut_structure !=' => '5']
        );
        $this->assertCount($expected_count, $structures);

        foreach ($structures as $structure) {
            $this->assertArrayHasKey('id_structure', $structure);
            $this->assertArrayHasKey('nom_structure', $structure);
            $this->assertArrayHasKey('id_statut_structure', $structure);
            $this->assertArrayHasKey('id_territoire', $structure);
            $this->assertArrayHasKey('lien_ref_structure', $structure);
            $this->assertArrayHasKey('nom_statut_structure', $structure);
            $this->assertArrayHasKey('nom_adresse', $structure);
            $this->assertArrayHasKey('complement_adresse', $structure);
            $this->assertArrayHasKey('code_postal', $structure);
            $this->assertArrayHasKey('nom_ville', $structure);
            $this->assertArrayHasKey('nom_territoire', $structure);
        }
    }

    public function testReadAllOkIntervenant()
    {
        $session = [
            'role_user_ids' => ['3'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '3',
            'id_territoire' => '1',
        ];

        $structures = $this->structure->readAll($session);

        $this->assertIsArray($structures);
        $expected_count = $this->tester->grabNumRecords(
            'structure',
            ['id_territoire' => $session['id_territoire'], 'id_statut_structure !=' => '5']
        );
        $this->assertCount($expected_count, $structures);

        foreach ($structures as $structure) {
            $this->assertArrayHasKey('id_structure', $structure);
            $this->assertArrayHasKey('nom_structure', $structure);
            $this->assertArrayHasKey('id_statut_structure', $structure);
            $this->assertArrayHasKey('id_territoire', $structure);
            $this->assertArrayHasKey('lien_ref_structure', $structure);
            $this->assertArrayHasKey('nom_statut_structure', $structure);
            $this->assertArrayHasKey('nom_adresse', $structure);
            $this->assertArrayHasKey('complement_adresse', $structure);
            $this->assertArrayHasKey('code_postal', $structure);
            $this->assertArrayHasKey('nom_ville', $structure);
            $this->assertArrayHasKey('nom_territoire', $structure);
        }
    }

    public function testReadAllOkReferent()
    {
        $session = [
            'role_user_ids' => ['4'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '3',
            'id_territoire' => '1',
        ];

        $structures = $this->structure->readAll($session);

        $this->assertIsArray($structures);
        $expected_count = $this->tester->grabNumRecords(
            'structure',
            ['id_territoire' => $session['id_territoire'], 'id_statut_structure !=' => '5']
        );
        $this->assertCount($expected_count, $structures);

        foreach ($structures as $structure) {
            $this->assertArrayHasKey('id_structure', $structure);
            $this->assertArrayHasKey('nom_structure', $structure);
            $this->assertArrayHasKey('id_statut_structure', $structure);
            $this->assertArrayHasKey('id_territoire', $structure);
            $this->assertArrayHasKey('lien_ref_structure', $structure);
            $this->assertArrayHasKey('nom_statut_structure', $structure);
            $this->assertArrayHasKey('nom_adresse', $structure);
            $this->assertArrayHasKey('complement_adresse', $structure);
            $this->assertArrayHasKey('code_postal', $structure);
            $this->assertArrayHasKey('nom_ville', $structure);
            $this->assertArrayHasKey('nom_territoire', $structure);
        }
    }

    public function testReadAllOkEvaluateur()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '3',
            'id_territoire' => '1',
        ];

        $structures = $this->structure->readAll($session);

        $this->assertIsArray($structures);
        $expected_count = $this->tester->grabNumRecords(
            'structure',
            ['id_territoire' => $session['id_territoire'], 'id_statut_structure !=' => '5']
        );
        $this->assertCount($expected_count, $structures);

        foreach ($structures as $structure) {
            $this->assertArrayHasKey('id_structure', $structure);
            $this->assertArrayHasKey('nom_structure', $structure);
            $this->assertArrayHasKey('id_statut_structure', $structure);
            $this->assertArrayHasKey('id_territoire', $structure);
            $this->assertArrayHasKey('lien_ref_structure', $structure);
            $this->assertArrayHasKey('nom_statut_structure', $structure);
            $this->assertArrayHasKey('nom_adresse', $structure);
            $this->assertArrayHasKey('complement_adresse', $structure);
            $this->assertArrayHasKey('code_postal', $structure);
            $this->assertArrayHasKey('nom_ville', $structure);
            $this->assertArrayHasKey('nom_territoire', $structure);
        }
    }

    public function testReadAllOkResponsableStructure()
    {
        $session = [
            'role_user_ids' => ['6'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => '3',
            'id_territoire' => '1',
        ];

        $structures = $this->structure->readAll($session);

        $this->assertIsArray($structures);
        $expected_count = $this->tester->grabNumRecords(
            'structure',
            ['id_territoire' => $session['id_territoire'], 'id_statut_structure !=' => '5']
        );
        $this->assertCount($expected_count, $structures);

        foreach ($structures as $structure) {
            $this->assertArrayHasKey('id_structure', $structure);
            $this->assertArrayHasKey('nom_structure', $structure);
            $this->assertArrayHasKey('id_statut_structure', $structure);
            $this->assertArrayHasKey('id_territoire', $structure);
            $this->assertArrayHasKey('lien_ref_structure', $structure);
            $this->assertArrayHasKey('nom_statut_structure', $structure);
            $this->assertArrayHasKey('nom_adresse', $structure);
            $this->assertArrayHasKey('complement_adresse', $structure);
            $this->assertArrayHasKey('code_postal', $structure);
            $this->assertArrayHasKey('nom_ville', $structure);
            $this->assertArrayHasKey('nom_territoire', $structure);
        }
    }

    public function testReadAllOkCoordonnateurPepsOptionnalId_territoireUsed()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => '2',
            'id_territoire' => '2',
        ];
        $id_territoire = '1';

        $structures = $this->structure->readAll($session, $id_territoire);

        $this->assertIsArray($structures);
        $expected_count = $this->tester->grabNumRecords(
            'structure',
            ['id_territoire' => $id_territoire, 'id_statut_structure !=' => '5']
        );
        $this->assertCount($expected_count, $structures);

        foreach ($structures as $structure) {
            $this->assertArrayHasKey('id_structure', $structure);
            $this->assertArrayHasKey('nom_structure', $structure);
            $this->assertArrayHasKey('id_statut_structure', $structure);
            $this->assertArrayHasKey('id_territoire', $structure);
            $this->assertArrayHasKey('lien_ref_structure', $structure);
            $this->assertArrayHasKey('nom_statut_structure', $structure);
            $this->assertArrayHasKey('nom_adresse', $structure);
            $this->assertArrayHasKey('complement_adresse', $structure);
            $this->assertArrayHasKey('code_postal', $structure);
            $this->assertArrayHasKey('nom_ville', $structure);
            $this->assertArrayHasKey('nom_territoire', $structure);
        }
    }

    public function testReadAllNotOkEmptySession()
    {
        $session = [];

        $structure = $this->structure->readAll($session);

        $this->assertFalse($structure);
    }

    public function testGetCoordinateurMssOuStructureSportiveOk()
    {
        $id_structure = "1";

        $ids = $this->structure->getCoordinateurMssOuStructureSportive($id_structure);
        $this->assertNotFalse($ids);
        $this->assertIsArray($ids);
        $this->assertCount(1, $ids);
    }

    public function testGetCoordinateurMssOuStructureSportiveOkEmptyResult()
    {
        $id_structure = "3";

        $ids = $this->structure->getCoordinateurMssOuStructureSportive($id_structure);
        $this->assertNotFalse($ids);
        $this->assertIsArray($ids);
        $this->assertCount(0, $ids);
    }

    public function testGetCoordinateurMssOuStructureSportiveNotOk()
    {
        $id_structure = null;

        $ids = $this->structure->getCoordinateurMssOuStructureSportive($id_structure);
        $this->assertFalse($ids);
    }

    public function testGetResponsableStructureOk()
    {
        $id_structure = "1";

        $ids = $this->structure->getResponsableStructure($id_structure);
        $this->assertNotFalse($ids);
        $this->assertIsArray($ids);
        $this->assertCount(2, $ids);
    }

    public function testGetResponsableStructureOkEmptyResult()
    {
        $id_structure = "2";

        $ids = $this->structure->getResponsableStructure($id_structure);
        $this->assertNotFalse($ids);
        $this->assertIsArray($ids);
        $this->assertCount(0, $ids);
    }

    public function testGetResponsableStructureNotOk()
    {
        $id_structure = null;

        $ids = $this->structure->getResponsableStructure($id_structure);
        $this->assertFalse($ids);
    }

    public function testFusionNotOkId_structure_fromNull()
    {
        $id_structure_from = null;
        $id_structure_target = "6";

        $fuse_ok = $this->structure->fuse($id_structure_from, $id_structure_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFusionNotOkId_structure_targetNull()
    {
        $id_structure_from = "6";
        $id_structure_target = null;

        $fuse_ok = $this->structure->fuse($id_structure_from, $id_structure_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFusionNotOkId_structure_fromNullAndId_structure_targetNull()
    {
        $id_structure_from = null;
        $id_structure_target = null;

        $fuse_ok = $this->structure->fuse($id_structure_from, $id_structure_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFusionNotOkId_structure_fromInvalid()
    {
        $id_structure_from = "-1";
        $id_structure_target = "6";

        $fuse_ok = $this->structure->fuse($id_structure_from, $id_structure_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFuseNotOkId_structure_targetInvalid()
    {
        $id_structure_from = "6";
        $id_structure_target = "-1";

        $fuse_ok = $this->structure->fuse($id_structure_from, $id_structure_target);
        $this->assertFalse($fuse_ok);
    }

    public function testFuseOk()
    {
        $id_structure_from = '7';
        $id_structure_target = '6';

        $onaps_from = $this->tester->grabFromDatabase(
            'structure',
            'code_onaps',
            ['id_structure' => $id_structure_from]
        );

        $onaps_target = $this->tester->grabFromDatabase(
            'structure',
            'code_onaps',
            ['id_structure' => $id_structure_target]
        );

        $this->assertEquals(
            $onaps_target,
            null
        );

        // creneau
        $creneau_count_structure_from_before = $this->tester->grabNumRecords(
            'creneaux',
            ['id_structure' => $id_structure_from]
        );
        $creneau_count_structure_target_before = $this->tester->grabNumRecords(
            'creneaux',
            ['id_structure' => $id_structure_target]
        );
        // antenne
        $antenne_count_structure_from_before = $this->tester->grabNumRecords(
            'antenne',
            ['id_structure' => $id_structure_from]
        );
        $antenne_count_structure_target_before = $this->tester->grabNumRecords(
            'antenne',
            ['id_structure' => $id_structure_target]
        );
        // intervenants
        $intervenants_count_structure_from_before = $this->tester->grabNumRecords(
            'intervenants',
            ['id_structure' => $id_structure_from]
        );
        $intervenants_count_structure_target_before = $this->tester->grabNumRecords(
            'intervenants',
            ['id_structure' => $id_structure_target]
        );
        // intervention
        $intervention_count_structure_from_before = $this->tester->grabNumRecords(
            'intervention',
            ['id_structure' => $id_structure_from]
        );
        $intervention_count_structure_target_before = $this->tester->grabNumRecords(
            'intervention',
            ['id_structure' => $id_structure_target]
        );
        // intervient_dans
        $intervient_dans_count_structure_from_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure_from]
        );
        $intervient_dans_count_structure_target_before = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure_target]
        );
        // oriente_vers
        $oriente_vers_count_structure_from_before = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_structure' => $id_structure_from]
        );
        $oriente_vers_count_structure_target_before = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_structure' => $id_structure_target]
        );
        // settings_synthese
        $settings_synthese_count_structure_from_before = $this->tester->grabNumRecords(
            'settings_synthese',
            ['id_structure' => $id_structure_from]
        );
        $settings_synthese_count_structure_target_before = $this->tester->grabNumRecords(
            'settings_synthese',
            ['id_structure' => $id_structure_target]
        );
        // se_situe_a
        $se_situe_a_count_structure_from_before = $this->tester->grabNumRecords(
            'se_situe_a',
            ['id_structure' => $id_structure_from]
        );
        $se_situe_a_count_structure_target_before = $this->tester->grabNumRecords(
            'se_situe_a',
            ['id_structure' => $id_structure_target]
        );
        // users
        $users_count_structure_from_before = $this->tester->grabNumRecords(
            'users',
            ['id_structure' => $id_structure_from]
        );
        $users_count_structure_target_before = $this->tester->grabNumRecords(
            'users',
            ['id_structure' => $id_structure_target]
        );
        // structure
        $structure_count_structure_from_before = $this->tester->grabNumRecords(
            'structure',
            ['id_structure' => $id_structure_from]
        );
        $structure_count_structure_target_before = $this->tester->grabNumRecords(
            'structure',
            ['id_structure' => $id_structure_target]
        );

        $fuse_ok = $this->structure->fuse($id_structure_from, $id_structure_target);
        $this->assertTrue($fuse_ok);

        $onaps_target = $this->tester->grabFromDatabase(
            'structure',
            'code_onaps',
            ['id_structure' => $id_structure_target]
        );

        $this->assertEquals(
            $onaps_target,
            $onaps_from
        );

        // creneau
        $creneau_count_structure_from_after = $this->tester->grabNumRecords(
            'creneaux',
            ['id_structure' => $id_structure_from]
        );
        $creneau_count_structure_target_after = $this->tester->grabNumRecords(
            'creneaux',
            ['id_structure' => $id_structure_target]
        );
        // antenne
        $antenne_count_structure_from_after = $this->tester->grabNumRecords(
            'antenne',
            ['id_structure' => $id_structure_from]
        );
        $antenne_count_structure_target_after = $this->tester->grabNumRecords(
            'antenne',
            ['id_structure' => $id_structure_target]
        );
        // intervenants
        $intervenants_count_structure_from_after = $this->tester->grabNumRecords(
            'intervenants',
            ['id_structure' => $id_structure_from]
        );
        $intervenants_count_structure_target_after = $this->tester->grabNumRecords(
            'intervenants',
            ['id_structure' => $id_structure_target]
        );
        // intervention
        $intervention_count_structure_from_after = $this->tester->grabNumRecords(
            'intervention',
            ['id_structure' => $id_structure_from]
        );
        $intervention_count_structure_target_after = $this->tester->grabNumRecords(
            'intervention',
            ['id_structure' => $id_structure_target]
        );
        // intervient_dans
        $intervient_dans_count_structure_from_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure_from]
        );
        $intervient_dans_count_structure_target_after = $this->tester->grabNumRecords(
            'intervient_dans',
            ['id_structure' => $id_structure_target]
        );
        // oriente_vers
        $oriente_vers_count_structure_from_after = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_structure' => $id_structure_from]
        );
        $oriente_vers_count_structure_target_after = $this->tester->grabNumRecords(
            'oriente_vers',
            ['id_structure' => $id_structure_target]
        );
        // settings_synthese
        $settings_synthese_count_structure_from_after = $this->tester->grabNumRecords(
            'settings_synthese',
            ['id_structure' => $id_structure_from]
        );
        $settings_synthese_count_structure_target_after = $this->tester->grabNumRecords(
            'settings_synthese',
            ['id_structure' => $id_structure_target]
        );
        // se_situe_a
        $se_situe_a_count_structure_from_after = $this->tester->grabNumRecords(
            'se_situe_a',
            ['id_structure' => $id_structure_from]
        );
        $se_situe_a_count_structure_target_after = $this->tester->grabNumRecords(
            'se_situe_a',
            ['id_structure' => $id_structure_target]
        );
        // users
        $users_count_structure_from_after = $this->tester->grabNumRecords(
            'users',
            ['id_structure' => $id_structure_from]
        );
        $users_count_structure_target_after = $this->tester->grabNumRecords(
            'users',
            ['id_structure' => $id_structure_target]
        );
        // structure
        $structure_count_structure_from_after = $this->tester->grabNumRecords(
            'structure',
            ['id_structure' => $id_structure_from]
        );
        $structure_count_structure_target_after = $this->tester->grabNumRecords(
            'structure',
            ['id_structure' => $id_structure_target]
        );

        // creneaux
        $this->assertEquals(
            $creneau_count_structure_from_before + $creneau_count_structure_target_before,
            $creneau_count_structure_target_after
        );
        $this->assertEquals(0, $creneau_count_structure_from_after);
        // antenne
        $this->assertEquals(
            $antenne_count_structure_from_before + $antenne_count_structure_target_before,
            $antenne_count_structure_target_after
        );
        $this->assertEquals(0, $antenne_count_structure_from_after);
        // intervenants
        $this->assertEquals(
            $intervenants_count_structure_from_before + $intervenants_count_structure_target_before,
            $intervenants_count_structure_target_after
        );
        $this->assertEquals(0, $intervenants_count_structure_from_after);
        // intervention
        $this->assertEquals(
            $intervention_count_structure_from_before + $intervention_count_structure_target_before - 1,
            // il y a 1 intervenant en commun
            $intervention_count_structure_target_after,
        );
        $this->assertEquals(0, $intervention_count_structure_from_after);
        // intervient_dans
        $this->assertEquals(
            $intervient_dans_count_structure_from_before + $intervient_dans_count_structure_target_before - 1,
            // il y a 1 intervenant en commun
            $intervient_dans_count_structure_target_after,
        );
        $this->assertEquals(0, $intervient_dans_count_structure_from_after);
        // oriente_vers
        $this->assertEquals(
            $oriente_vers_count_structure_from_before + $oriente_vers_count_structure_target_before,
            $oriente_vers_count_structure_target_after
        );
        $this->assertEquals(0, $oriente_vers_count_structure_from_after);
        // settings_synthese
        $this->assertEquals(
            $settings_synthese_count_structure_from_before + $settings_synthese_count_structure_target_before - 1,
            // les 2 structures ont une settings_synthese
            $settings_synthese_count_structure_target_after
        );
        $this->assertEquals(0, $settings_synthese_count_structure_from_after);
        // se_situe_a
        $this->assertEquals(
            $se_situe_a_count_structure_target_before,
            $se_situe_a_count_structure_target_after
        );
        $this->assertEquals(0, $se_situe_a_count_structure_from_after);
        // users
        $this->assertEquals(
            $users_count_structure_from_before + $users_count_structure_target_before,
            $users_count_structure_target_after
        );
        $this->assertEquals(0, $users_count_structure_from_after);
    }

    public function testDeleteOk()
    {
        $id_structure = "9";

        $id_adresse = $this->tester->grabFromDatabase("se_situe_a", "id_adresse", ["id_structure" => $id_structure]);
        $id_coordonnees = $this->tester->grabFromDatabase(
            "structure",
            "id_coordonnees",
            ["id_structure" => $id_structure]
        );
        $this->assertNotEmpty($id_coordonnees);

        $delete_ok = $this->structure->delete($id_structure);
        $this->assertTrue($delete_ok, $this->structure->getErrorMessage());

        $this->tester->dontSeeInDatabase("intervient_dans", ["id_structure" => $id_structure]);
        $this->tester->dontSeeInDatabase("creneaux", ["id_structure" => $id_structure]);
        $this->tester->dontSeeInDatabase("oriente_vers", ["id_structure" => $id_structure]);
        $this->tester->dontSeeInDatabase("antenne", ["id_structure" => $id_structure]);
        $this->tester->dontSeeInDatabase("se_situe_a", ["id_structure" => $id_structure]);
        $this->tester->dontSeeInDatabase("structure", ["id_structure" => $id_structure]);
        $this->tester->dontSeeInDatabase("users", ["id_structure" => $id_structure]);
        $this->tester->dontSeeInDatabase("settings_synthese", ["id_structure" => $id_structure]);
        $this->tester->dontSeeInDatabase("se_localise_a", ["id_adresse" => $id_adresse]);
        $this->tester->dontSeeInDatabase("coordonnees", ["id_coordonnees" => $id_coordonnees]);
    }

    public function testDeleteNotOkUserInStructure()
    {
        $id_structure = "5";

        $delete_ok = $this->structure->delete($id_structure);
        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkIntervenantInStructure()
    {
        $id_structure = "1";

        $delete_ok = $this->structure->delete($id_structure);
        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkPatientInStructure()
    {
        $id_structure = "2";

        $delete_ok = $this->structure->delete($id_structure);
        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkId_structureNull()
    {
        $id_structure = "1";

        $delete_ok = $this->structure->delete($id_structure);
        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkId_structureInvalid()
    {
        $id_structure = "-1";

        $delete_ok = $this->structure->delete($id_structure);
        $this->assertFalse($delete_ok);
    }
}