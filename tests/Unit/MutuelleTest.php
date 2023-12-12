<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\Mutuelle;
use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\UnitTester;

class MutuelleTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Mutuelle $mutuelle;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->mutuelle = new Mutuelle($pdo);
        $this->assertNotNull($this->mutuelle);
    }

    protected function _after()
    {
    }

    public function testCreateOkAllData()
    {
        // paramètres obligatoires
        $nom = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $code_postal = "98600";
        $nom_ville = "UVEA";

        // paramètres optionnels
        $email = ChaineCharactere::str_shuffle_unicode("dfgdfgdfg") . '@gmail.com';
        $tel_fixe = ChaineCharactere::str_shuffle_unicode("0123456789");
        $tel_portable = ChaineCharactere::str_shuffle_unicode("0123456789");
        $nom_adresse = ChaineCharactere::str_shuffle_unicode("uyturtyfghd");
        $complement_adresse = ChaineCharactere::str_shuffle_unicode("wxcvgdfg");

        $mutuelles_count_before = $this->tester->grabNumRecords('mutuelles');

        $id_mutuelle = $this->mutuelle->create([
            'nom' => $nom,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,

            'nom_adresse' => $nom_adresse,
            'tel_fixe' => $tel_fixe,
            'complement_adresse' => $complement_adresse,
            'email' => $email,
            'tel_portable' => $tel_portable,
        ]);
        $this->assertNotFalse($id_mutuelle);

        $mutuelles_count_after = $this->tester->grabNumRecords('mutuelles');

        $this->assertEquals($mutuelles_count_before + 1, $mutuelles_count_after);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_coordonnees',
            ['id_mutuelle' => $id_mutuelle]
        );

        $this->tester->seeInDatabase('mutuelles', [
            'id_mutuelle' => $id_mutuelle,
            'id_coordonnees' => $id_coordonnees,
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
            'tel_fixe_coordonnees' => $tel_fixe,
            'tel_portable_coordonnees' => $tel_portable,
            'mail_coordonnees' => $email,
        ]);

        $id_adresse = $this->tester->grabFromDatabase('se_trouve', 'id_adresse', ['id_mutuelle' => $id_mutuelle]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->tester->seeInDatabase('se_trouve', [
            'id_adresse' => $id_adresse,
            'id_mutuelle' => $id_mutuelle
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);
    }

    public function testCreateOkMinimumData()
    {
        // paramètres obligatoires
        $nom = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $code_postal = "97413";
        $nom_ville = "CILAOS";

        $mutuelles_count_before = $this->tester->grabNumRecords('mutuelles');

        $id_mutuelle = $this->mutuelle->create([
            'nom' => $nom,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
        ]);
        $this->assertNotFalse($id_mutuelle);

        $mutuelles_count_after = $this->tester->grabNumRecords('mutuelles');

        $this->assertEquals($mutuelles_count_before + 1, $mutuelles_count_after);

        $id_coordonnees = $this->tester->grabFromDatabase(
            'coordonnees',
            'id_coordonnees',
            ['id_mutuelle' => $id_mutuelle]
        );

        $this->tester->seeInDatabase('mutuelles', [
            'id_mutuelle' => $id_mutuelle,
            'id_coordonnees' => $id_coordonnees,
        ]);

        $this->tester->seeInDatabase('coordonnees', [
            'id_coordonnees' => $id_coordonnees,
            'nom_coordonnees' => $nom,
        ]);

        $id_adresse = $this->tester->grabFromDatabase('se_trouve', 'id_adresse', ['id_mutuelle' => $id_mutuelle]);

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->seeInDatabase('se_trouve', [
            'id_adresse' => $id_adresse,
            'id_mutuelle' => $id_mutuelle
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);
    }

    public function testCreateNotOkMutuelleAlreadyExists()
    {
        // paramètres obligatoires
        $nom = "MUTUELLE - POITIERS";
        $code_postal = "86000";
        $nom_ville = "POITIERS";

        $id_mutuelle = $this->mutuelle->create([
            'nom' => $nom,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
        ]);
        $this->assertFalse($id_mutuelle);
    }

    public function testCreateNotOkNomNull()
    {
        // paramètres obligatoires
        $nom = null;
        $code_postal = "97413";
        $nom_ville = "CILAOS";

        $id_mutuelle = $this->mutuelle->create([
            'nom' => $nom,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
        ]);
        $this->assertFalse($id_mutuelle);
    }

    public function testCreateNotOkCode_postalNull()
    {
        // paramètres obligatoires
        $nom = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $code_postal = null;
        $nom_ville = "CILAOS";

        $id_mutuelle = $this->mutuelle->create([
            'nom' => $nom,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
        ]);
        $this->assertFalse($id_mutuelle);
    }

    public function testCreateNotOkNom_villeNull()
    {
        // paramètres obligatoires
        $nom = ChaineCharactere::str_shuffle_unicode("nfgddhfghkdfh");
        $code_postal = "97413";
        $nom_ville = null;

        $id_mutuelle = $this->mutuelle->create([
            'nom' => $nom,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
        ]);
        $this->assertFalse($id_mutuelle);
    }

    public function testReadOneOk()
    {
        $id_mutuelle = "1";

        $m = $this->mutuelle->readOne($id_mutuelle);
        $this->assertIsArray($m);

        $this->assertArrayHasKey("id_mutuelle", $m);
        $this->assertArrayHasKey("nom", $m);
        $this->assertArrayHasKey("nom_ville", $m);
        $this->assertArrayHasKey("code_postal", $m);
        $this->assertArrayHasKey("tel_fixe", $m);
        $this->assertArrayHasKey("tel_portable", $m);
        $this->assertArrayHasKey("email", $m);
        $this->assertArrayHasKey("nom_adresse", $m);
        $this->assertArrayHasKey("complement_adresse", $m);
    }

    public function testReadOneNotOkId_mutuelleNull()
    {
        $id_mutuelle = null;

        $m = $this->mutuelle->readOne($id_mutuelle);
        $this->assertFalse($m);
    }

    public function testReadOneNotOkId_mutuellIvalid()
    {
        $id_mutuelle = "-1";

        $m = $this->mutuelle->readOne($id_mutuelle);
        $this->assertFalse($m);
    }

    public function testReadAllOk()
    {
        $mutuelles = $this->mutuelle->readAll();
        $this->assertIsArray($mutuelles);
        $this->assertNotEmpty($mutuelles);

        $this->assertArrayHasKey("id_mutuelle", $mutuelles[0]);
        $this->assertArrayHasKey("nom", $mutuelles[0]);
        $this->assertArrayHasKey("nom_ville", $mutuelles[0]);
        $this->assertArrayHasKey("code_postal", $mutuelles[0]);
        $this->assertArrayHasKey("tel_fixe", $mutuelles[0]);
        $this->assertArrayHasKey("tel_portable", $mutuelles[0]);
        $this->assertArrayHasKey("email", $mutuelles[0]);
        $this->assertArrayHasKey("nom_adresse", $mutuelles[0]);
        $this->assertArrayHasKey("complement_adresse", $mutuelles[0]);
    }
}