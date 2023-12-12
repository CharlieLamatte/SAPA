<?php

namespace Tests\Unit;

use Dotenv\Dotenv;
use Sportsante86\Sapa\Model\Creneau;
use Tests\Support\UnitTester;

class CreneauTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Creneau $creneau;

    private string $root = __DIR__ . '/../..';

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->creneau = new Creneau($pdo);
        $this->assertNotNull($this->creneau);

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

    public function testReadOneOk()
    {
        $id_creneau = '1';

        $c = $this->creneau->readOne($id_creneau);

        $this->assertNotFalse($c);
        $this->assertIsArray($c);

        $this->assertArrayHasKey('id_creneau', $c);
        $this->assertArrayHasKey('nom_creneau', $c);
        $this->assertArrayHasKey('nom_adresse', $c);
        $this->assertArrayHasKey('nom_ville', $c);
        $this->assertArrayHasKey('complement_adresse', $c);
        $this->assertArrayHasKey('code_postal', $c);
        $this->assertArrayHasKey('facilite_paiement', $c);
        $this->assertArrayHasKey('jour', $c);
        $this->assertArrayHasKey('id_jour', $c);
        $this->assertArrayHasKey('nom_heure_debut', $c);
        $this->assertArrayHasKey('heure_debut', $c);
        $this->assertArrayHasKey('nom_heure_fin', $c);
        $this->assertArrayHasKey('heure_fin', $c);
        $this->assertArrayHasKey('nombre_participants', $c);
        $this->assertArrayHasKey('type_parcours', $c);
        $this->assertArrayHasKey('id_type_parcours', $c);
        $this->assertArrayHasKey('nom_structure', $c);
        $this->assertArrayHasKey('id_structure', $c);
        $this->assertArrayHasKey('tarif', $c);
        $this->assertArrayHasKey('public_vise', $c);
        $this->assertArrayHasKey('type_seance', $c);
        $this->assertArrayHasKey('pathologie', $c);
        $this->assertArrayHasKey('nom_coordonnees', $c);
        $this->assertArrayHasKey('prenom_coordonnees', $c);
        $this->assertArrayHasKey('description', $c);
        $this->assertArrayHasKey('0', $c);
        $this->assertArrayHasKey('activation', $c);
        $this->assertArrayHasKey('intervenants', $c);

        $this->assertEquals('1', $c['id_creneau']);
        $this->assertEquals('Creneau 1 86', $c['nom_creneau']);
        $this->assertEquals('1000 Allée Jean Monnet', $c['nom_adresse']);
        $this->assertEquals('POITIERS', $c['nom_ville']);
        $this->assertEquals('Complément', $c['complement_adresse']);
        $this->assertEquals('86000', $c['code_postal']);
        $this->assertEquals('Oui', $c['facilite_paiement']);
        $this->assertEquals('Mardi', $c['jour']);
        $this->assertEquals('2', $c['id_jour']);
        $this->assertEquals('07:00:00', $c['nom_heure_debut']);
        $this->assertEquals('2', $c['heure_debut']);
        $this->assertEquals('09:00:00', $c['nom_heure_fin']);
        $this->assertEquals('10', $c['heure_fin']);
        $this->assertEquals('34', $c['nombre_participants']);
        $this->assertEquals('Declic', $c['type_parcours']);
        $this->assertEquals('2', $c['id_type_parcours']);
        $this->assertEquals('STRUCT TEST 1', $c['nom_structure']);
        $this->assertEquals('1', $c['id_structure']);
        $this->assertEquals('110', $c['tarif']);
        $this->assertEquals('Tous', $c['public_vise']);
        $this->assertEquals('Collective', $c['type_seance']);
        $this->assertEquals('INTERVENANTTESTNOM2', $c['nom_coordonnees']);
        $this->assertEquals('IntervenantTestPrenom2', $c['prenom_coordonnees']);
        $this->assertEquals('Détails', $c['description']);
        $this->assertEquals('1', $c['activation']);
        $this->assertEquals('3', $c[0]['nb_participants_creneau']);
        $this->assertIsArray($c['intervenants']);
        $this->assertEquals("2", $c['intervenants'][0]['id_intervenant']);
    }

    public function testReadOneNotOkId_creneauNull()
    {
        $id_creneau = null;

        $c = $this->creneau->readOne($id_creneau);

        $this->assertFalse($c);
    }

    public function testReadOneNotOkId_creneauInvalid()
    {
        $id_creneau = '-1';

        $c = $this->creneau->readOne($id_creneau);

        $this->assertFalse($c);
    }

    public function testReadAllIntervenantOk()
    {
        $id_intervenant = '2';

        $creneaux = $this->creneau->readAllIntervenant($id_intervenant);
        $this->assertIsArray($creneaux);

        $creneaux_count = $this->tester->grabNumRecords('creneaux_intervenant', ['id_intervenant' => $id_intervenant]);
        $this->assertGreaterThan(0, $creneaux);
        $this->assertCount($creneaux_count, $creneaux);

        $this->assertArrayHasKey('id_creneau', $creneaux[0]);
        $this->assertArrayHasKey('nom_creneau', $creneaux[0]);
        $this->assertArrayHasKey('nom_adresse', $creneaux[0]);
        $this->assertArrayHasKey('nom_ville', $creneaux[0]);
        $this->assertArrayHasKey('complement_adresse', $creneaux[0]);
        $this->assertArrayHasKey('code_postal', $creneaux[0]);
        $this->assertArrayHasKey('facilite_paiement', $creneaux[0]);
        $this->assertArrayHasKey('jour', $creneaux[0]);
        $this->assertArrayHasKey('id_jour', $creneaux[0]);
        $this->assertArrayHasKey('nom_heure_debut', $creneaux[0]);
        $this->assertArrayHasKey('heure_debut', $creneaux[0]);
        $this->assertArrayHasKey('nom_heure_fin', $creneaux[0]);
        $this->assertArrayHasKey('heure_fin', $creneaux[0]);
        $this->assertArrayHasKey('nombre_participants', $creneaux[0]);
        $this->assertArrayHasKey('type_parcours', $creneaux[0]);
        $this->assertArrayHasKey('id_type_parcours', $creneaux[0]);
        $this->assertArrayHasKey('nom_structure', $creneaux[0]);
        $this->assertArrayHasKey('id_structure', $creneaux[0]);
        $this->assertArrayHasKey('tarif', $creneaux[0]);
        $this->assertArrayHasKey('public_vise', $creneaux[0]);
        $this->assertArrayHasKey('type_seance', $creneaux[0]);
        $this->assertArrayHasKey('pathologie', $creneaux[0]);
        $this->assertArrayHasKey('nom_coordonnees', $creneaux[0]);
        $this->assertArrayHasKey('prenom_coordonnees', $creneaux[0]);
        $this->assertArrayHasKey('description', $creneaux[0]);
    }

    public function testReadAllIntervenantOkId_intervenantInvalide()
    {
        $id_intervenant = '-1';

        $creneaux = $this->creneau->readAllIntervenant($id_intervenant);
        $this->assertIsArray($creneaux);
        $this->assertCount(0, $creneaux);
    }

    public function testReadAllIntervenantNotOkId_intervenantNull()
    {
        $id_intervenant = null;

        $creneaux = $this->creneau->readAllIntervenant($id_intervenant);
        $this->assertFalse($creneaux);
    }

    public function testReadAllStructureOk()
    {
        $id_structure = '1';

        $creneaux = $this->creneau->readAllStructure($id_structure);

        $this->assertNotFalse($creneaux);
        $this->assertIsArray($creneaux);

        $creneaux_count = $this->tester->grabNumRecords('creneaux', ['id_structure' => $id_structure]);

        $this->assertGreaterThan(0, $creneaux);
        $this->assertCount($creneaux_count, $creneaux);

        $this->assertArrayHasKey('id_creneau', $creneaux[0]);
        $this->assertArrayHasKey('nom_creneau', $creneaux[0]);
        $this->assertArrayHasKey('nom_adresse', $creneaux[0]);
        $this->assertArrayHasKey('nom_ville', $creneaux[0]);
        $this->assertArrayHasKey('complement_adresse', $creneaux[0]);
        $this->assertArrayHasKey('code_postal', $creneaux[0]);
        $this->assertArrayHasKey('facilite_paiement', $creneaux[0]);
        $this->assertArrayHasKey('jour', $creneaux[0]);
        $this->assertArrayHasKey('id_jour', $creneaux[0]);
        $this->assertArrayHasKey('nom_heure_debut', $creneaux[0]);
        $this->assertArrayHasKey('heure_debut', $creneaux[0]);
        $this->assertArrayHasKey('nom_heure_fin', $creneaux[0]);
        $this->assertArrayHasKey('heure_fin', $creneaux[0]);
        $this->assertArrayHasKey('nombre_participants', $creneaux[0]);
        $this->assertArrayHasKey('type_parcours', $creneaux[0]);
        $this->assertArrayHasKey('id_type_parcours', $creneaux[0]);
        $this->assertArrayHasKey('nom_structure', $creneaux[0]);
        $this->assertArrayHasKey('id_structure', $creneaux[0]);
        $this->assertArrayHasKey('tarif', $creneaux[0]);
        $this->assertArrayHasKey('public_vise', $creneaux[0]);
        $this->assertArrayHasKey('type_seance', $creneaux[0]);
        $this->assertArrayHasKey('pathologie', $creneaux[0]);
        $this->assertArrayHasKey('nom_coordonnees', $creneaux[0]);
        $this->assertArrayHasKey('prenom_coordonnees', $creneaux[0]);
        $this->assertArrayHasKey('description', $creneaux[0]);
        $this->assertArrayHasKey('activation', $creneaux[0]);
    }

    public function testReadAllStructureOkId_intervenantInvalide()
    {
        $id_structure = '-1';

        $creneaux = $this->creneau->readAllStructure($id_structure);
        $this->assertIsArray($creneaux);
        $this->assertCount(0, $creneaux);
    }

    public function testReadAllStructureNotOkId_structureNull()
    {
        $id_structure = null;

        $creneaux = $this->creneau->readAllStructure($id_structure);
        $this->assertFalse($creneaux);
    }

    public function testReadAllOkAsCoordonnateurNonMSS()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2", // non mss
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $c = $this->creneau->readAll($session);
        $this->assertIsArray($c);

        $this->assertCount(7, $c); // 7 créneaux dans le 86

        $this->assertArrayHasKey('id_creneau', $c[0]);
        $this->assertArrayHasKey('nom_creneau', $c[0]);
        $this->assertArrayHasKey('nom_adresse', $c[0]);
        $this->assertArrayHasKey('nom_ville', $c[0]);
        $this->assertArrayHasKey('complement_adresse', $c[0]);
        $this->assertArrayHasKey('code_postal', $c[0]);
        $this->assertArrayHasKey('facilite_paiement', $c[0]);
        $this->assertArrayHasKey('jour', $c[0]);
        $this->assertArrayHasKey('id_jour', $c[0]);
        $this->assertArrayHasKey('nom_heure_debut', $c[0]);
        $this->assertArrayHasKey('heure_debut', $c[0]);
        $this->assertArrayHasKey('nom_heure_fin', $c[0]);
        $this->assertArrayHasKey('heure_fin', $c[0]);
        $this->assertArrayHasKey('nombre_participants', $c[0]);
        $this->assertArrayHasKey('type_parcours', $c[0]);
        $this->assertArrayHasKey('id_type_parcours', $c[0]);
        $this->assertArrayHasKey('nom_structure', $c[0]);
        $this->assertArrayHasKey('id_structure', $c[0]);
        $this->assertArrayHasKey('tarif', $c[0]);
        $this->assertArrayHasKey('public_vise', $c[0]);
        $this->assertArrayHasKey('type_seance', $c[0]);
        $this->assertArrayHasKey('pathologie', $c[0]);
        $this->assertArrayHasKey('nom_coordonnees', $c[0]);
        $this->assertArrayHasKey('prenom_coordonnees', $c[0]);
        $this->assertArrayHasKey('description', $c[0]);
        $this->assertArrayHasKey('activation', $c[0]);
    }

    public function testReadAllOkAsCoordonnateurMSS()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // mss
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $c = $this->creneau->readAll($session);
        $this->assertIsArray($c);

        $this->assertCount(7, $c); // 7 créneaux dans le 86

        $this->assertArrayHasKey('id_creneau', $c[0]);
        $this->assertArrayHasKey('nom_creneau', $c[0]);
        $this->assertArrayHasKey('nom_adresse', $c[0]);
        $this->assertArrayHasKey('nom_ville', $c[0]);
        $this->assertArrayHasKey('complement_adresse', $c[0]);
        $this->assertArrayHasKey('code_postal', $c[0]);
        $this->assertArrayHasKey('facilite_paiement', $c[0]);
        $this->assertArrayHasKey('jour', $c[0]);
        $this->assertArrayHasKey('id_jour', $c[0]);
        $this->assertArrayHasKey('nom_heure_debut', $c[0]);
        $this->assertArrayHasKey('heure_debut', $c[0]);
        $this->assertArrayHasKey('nom_heure_fin', $c[0]);
        $this->assertArrayHasKey('heure_fin', $c[0]);
        $this->assertArrayHasKey('nombre_participants', $c[0]);
        $this->assertArrayHasKey('type_parcours', $c[0]);
        $this->assertArrayHasKey('id_type_parcours', $c[0]);
        $this->assertArrayHasKey('nom_structure', $c[0]);
        $this->assertArrayHasKey('id_structure', $c[0]);
        $this->assertArrayHasKey('tarif', $c[0]);
        $this->assertArrayHasKey('public_vise', $c[0]);
        $this->assertArrayHasKey('type_seance', $c[0]);
        $this->assertArrayHasKey('pathologie', $c[0]);
        $this->assertArrayHasKey('nom_coordonnees', $c[0]);
        $this->assertArrayHasKey('prenom_coordonnees', $c[0]);
        $this->assertArrayHasKey('description', $c[0]);
        $this->assertArrayHasKey('activation', $c[0]);
    }

    public function testReadAllOkAsAdmin()
    {
        $session = [
            'role_user_ids' => ["1"],
            'id_territoire' => "1",
            'id_user' => "1",
            'id_structure' => null,
            'id_statut_structure' => null,
            'est_coordinateur_peps' => "0",
        ];

        $c = $this->creneau->readAll($session);

        $this->assertIsArray($c);

        $total_creneaux_count = $this->tester->grabNumRecords('creneaux');
        $this->assertCount($total_creneaux_count, $c);

        $this->assertArrayHasKey('id_creneau', $c[0]);
        $this->assertArrayHasKey('nom_creneau', $c[0]);
        $this->assertArrayHasKey('nom_adresse', $c[0]);
        $this->assertArrayHasKey('nom_ville', $c[0]);
        $this->assertArrayHasKey('complement_adresse', $c[0]);
        $this->assertArrayHasKey('code_postal', $c[0]);
        $this->assertArrayHasKey('facilite_paiement', $c[0]);
        $this->assertArrayHasKey('jour', $c[0]);
        $this->assertArrayHasKey('id_jour', $c[0]);
        $this->assertArrayHasKey('nom_heure_debut', $c[0]);
        $this->assertArrayHasKey('heure_debut', $c[0]);
        $this->assertArrayHasKey('nom_heure_fin', $c[0]);
        $this->assertArrayHasKey('heure_fin', $c[0]);
        $this->assertArrayHasKey('nombre_participants', $c[0]);
        $this->assertArrayHasKey('type_parcours', $c[0]);
        $this->assertArrayHasKey('id_type_parcours', $c[0]);
        $this->assertArrayHasKey('nom_structure', $c[0]);
        $this->assertArrayHasKey('id_structure', $c[0]);
        $this->assertArrayHasKey('tarif', $c[0]);
        $this->assertArrayHasKey('public_vise', $c[0]);
        $this->assertArrayHasKey('type_seance', $c[0]);
        $this->assertArrayHasKey('pathologie', $c[0]);
        $this->assertArrayHasKey('nom_coordonnees', $c[0]);
        $this->assertArrayHasKey('prenom_coordonnees', $c[0]);
        $this->assertArrayHasKey('description', $c[0]);
        $this->assertArrayHasKey('activation', $c[0]);
    }

    public function testReadAllOkAsCoordoPeps()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $c = $this->creneau->readAll($session);
        $this->assertIsArray($c);

        $creneaux_count = 7;
        $this->assertCount($creneaux_count, $c);

        $this->assertArrayHasKey('id_creneau', $c[0]);
        $this->assertArrayHasKey('nom_creneau', $c[0]);
        $this->assertArrayHasKey('nom_adresse', $c[0]);
        $this->assertArrayHasKey('nom_ville', $c[0]);
        $this->assertArrayHasKey('complement_adresse', $c[0]);
        $this->assertArrayHasKey('code_postal', $c[0]);
        $this->assertArrayHasKey('facilite_paiement', $c[0]);
        $this->assertArrayHasKey('jour', $c[0]);
        $this->assertArrayHasKey('id_jour', $c[0]);
        $this->assertArrayHasKey('nom_heure_debut', $c[0]);
        $this->assertArrayHasKey('heure_debut', $c[0]);
        $this->assertArrayHasKey('nom_heure_fin', $c[0]);
        $this->assertArrayHasKey('heure_fin', $c[0]);
        $this->assertArrayHasKey('nombre_participants', $c[0]);
        $this->assertArrayHasKey('type_parcours', $c[0]);
        $this->assertArrayHasKey('id_type_parcours', $c[0]);
        $this->assertArrayHasKey('nom_structure', $c[0]);
        $this->assertArrayHasKey('id_structure', $c[0]);
        $this->assertArrayHasKey('tarif', $c[0]);
        $this->assertArrayHasKey('public_vise', $c[0]);
        $this->assertArrayHasKey('type_seance', $c[0]);
        $this->assertArrayHasKey('pathologie', $c[0]);
        $this->assertArrayHasKey('nom_coordonnees', $c[0]);
        $this->assertArrayHasKey('prenom_coordonnees', $c[0]);
        $this->assertArrayHasKey('description', $c[0]);
        $this->assertArrayHasKey('activation', $c[0]);
    }

    public function testReadAllOkAsResponsableStructure()
    {
        $session = [
            'role_user_ids' => ["6"],
            'id_territoire' => "1",
            'id_user' => "8",
            'id_structure' => "1",
            'id_statut_structure' => '1', // MSS
            'est_coordinateur_peps' => "0",
        ];

        $c = $this->creneau->readAll($session);

        $this->assertNotFalse($c);
        $this->assertIsArray($c);

        $total_creneaux_count = $this->tester->grabNumRecords('creneaux', ['id_structure' => $session['id_structure']]);
        $this->assertCount($total_creneaux_count, $c);

        $this->assertArrayHasKey('id_creneau', $c[0]);
        $this->assertArrayHasKey('nom_creneau', $c[0]);
        $this->assertArrayHasKey('nom_adresse', $c[0]);
        $this->assertArrayHasKey('nom_ville', $c[0]);
        $this->assertArrayHasKey('complement_adresse', $c[0]);
        $this->assertArrayHasKey('code_postal', $c[0]);
        $this->assertArrayHasKey('facilite_paiement', $c[0]);
        $this->assertArrayHasKey('jour', $c[0]);
        $this->assertArrayHasKey('id_jour', $c[0]);
        $this->assertArrayHasKey('nom_heure_debut', $c[0]);
        $this->assertArrayHasKey('heure_debut', $c[0]);
        $this->assertArrayHasKey('nom_heure_fin', $c[0]);
        $this->assertArrayHasKey('heure_fin', $c[0]);
        $this->assertArrayHasKey('nombre_participants', $c[0]);
        $this->assertArrayHasKey('type_parcours', $c[0]);
        $this->assertArrayHasKey('id_type_parcours', $c[0]);
        $this->assertArrayHasKey('nom_structure', $c[0]);
        $this->assertArrayHasKey('id_structure', $c[0]);
        $this->assertArrayHasKey('tarif', $c[0]);
        $this->assertArrayHasKey('public_vise', $c[0]);
        $this->assertArrayHasKey('type_seance', $c[0]);
        $this->assertArrayHasKey('pathologie', $c[0]);
        $this->assertArrayHasKey('nom_coordonnees', $c[0]);
        $this->assertArrayHasKey('prenom_coordonnees', $c[0]);
        $this->assertArrayHasKey('description', $c[0]);
        $this->assertArrayHasKey('activation', $c[0]);
    }

    public function testReadAllNotOkId_intervenantNull()
    {
        $id_intervenant = null;

        $c = $this->creneau->readAllIntervenant($id_intervenant);
        $this->assertFalse($c);
    }

    public function testReadAllOkId_intervenantInvalide()
    {
        $id_intervenant = '-1';

        $c = $this->creneau->readAllIntervenant($id_intervenant);

        $this->assertNotFalse($c);
        $this->assertIsArray($c);
        $this->assertCount(0, $c);
    }

    public function testReadAllUserOkAsIntervenantLabelise()
    {
        // données initiales
        // id_user=3
        $c = $this->creneau->readAllUser(3, true);
        $this->assertIsArray($c);
        $creneaux_id_user_3_initial_count_expected = 0;
        $this->assertCount($creneaux_id_user_3_initial_count_expected, $c);

        // id_user=4
        $c = $this->creneau->readAllUser(4, true);
        $this->assertIsArray($c);
        $creneaux_id_user_4_initial_count_expected = 1;
        $this->assertCount($creneaux_id_user_4_initial_count_expected, $c);

        // ajout d'un créneau à 2 intervenants utilisateurs
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1"; // declic
        $id_structure = "1";
        $intervenant_ids = ["4", "7"]; // correspond aux id_user 3 et 4
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $id_creneau = $this->creneau->create([
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
        ]);
        $this->assertNotFalse($id_creneau);

        // id_user=3
        $c = $this->creneau->readAllUser(3, true);
        $this->assertIsArray($c);
        $this->assertCount($creneaux_id_user_3_initial_count_expected + 1, $c);

        // id_user=4
        $c = $this->creneau->readAllUser(4, true);
        $this->assertIsArray($c);
        $this->assertCount($creneaux_id_user_4_initial_count_expected + 1, $c);
    }

    public function testReadAllUserOkAsIntervenantNonLabelise()
    {
        // données initiales
        // id_user=3
        $c = $this->creneau->readAllUser(3, false);
        $this->assertIsArray($c);
        $creneaux_id_user_3_initial_count_expected = 1;
        $this->assertCount($creneaux_id_user_3_initial_count_expected, $c);

        // id_user=4
        $c = $this->creneau->readAllUser(4, false);
        $this->assertIsArray($c);
        $creneaux_id_user_4_initial_count_expected = 0;
        $this->assertCount($creneaux_id_user_4_initial_count_expected, $c);

        // ajout d'un créneau à 2 intervenants utilisateurs
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "4"; // autre
        $id_structure = "1";
        $intervenant_ids = ["4", "7"]; // correspond aux id_user 3 et 4
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $id_creneau = $this->creneau->create([
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
        ]);
        $this->assertNotFalse($id_creneau);

        // id_user=3
        $c = $this->creneau->readAllUser(3, false);
        $this->assertIsArray($c);
        $this->assertCount($creneaux_id_user_3_initial_count_expected + 1, $c);

        // id_user=4
        $c = $this->creneau->readAllUser(4, false);
        $this->assertIsArray($c);
        $this->assertCount($creneaux_id_user_4_initial_count_expected + 1, $c);
    }

    public function testReadAllUserOkAsNotIntervenantLabelise()
    {
        $id_user = "1"; // admin

        $c = $this->creneau->readAllUser($id_user, true);
        $this->assertIsArray($c);
        $this->assertCount(0, $c);
    }

    public function testReadAllUserOkAsNotIntervenantNonLabelise()
    {
        $id_user = "1"; // admin

        $c = $this->creneau->readAllUser($id_user, false);
        $this->assertIsArray($c);
        $this->assertCount(0, $c);
    }

    public function testCreateOkMinimumData()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
//        $intervention_count_before = $this->tester->grabNumRecords('intervention');
//        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertNotFalse($id_creneau, $this->creneau->getErrorMessage());
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
//        $intervention_count_after = $this->tester->grabNumRecords('intervention');
//        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($creneaux_count_before + 1, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before + 1, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before + 1, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before + 1, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);
//        $this->assertEquals($intervient_dans_count_before + 1, $intervient_dans_count_after);

        $this->tester->seeInDatabase('creneaux', [
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'id_jour' => $jour,
            'id_type_parcours' => $type_creneau,
            'pathologie_creneau' => $pathologie,
            'type_seance' => $type_seance,
            'id_structure' => $id_structure,
            'activation' => "1",
        ]);

        $this->tester->seeInDatabase('commence_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_debut,
        ]);

        $this->tester->seeInDatabase('se_termine_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_fin,
        ]);

        $this->tester->seeInDatabase('se_pratique_a', [
            'id_creneau' => $id_creneau,
        ]);

        $id_adresse = $this->tester->grabFromDatabase(
            'se_pratique_a', 'id_adresse',
            ['id_creneau' => $id_creneau]
        );

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        foreach ($intervenant_ids as $id_intervenant) {
            $this->tester->seeInDatabase('creneaux_intervenant', [
                'id_creneau' => $id_creneau,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testCreateOkAllDataCoordonateur()
    {
        // paramètres obligatoires
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        // paramètres optionnels
        $facilite_paiement = "Oui";
        $nombre_participants = "40";
        $description_creneau = "Allons";
        $prix_creneau = "10";
        $public_vise = "Personnes en mesure de faire du sport";
        $complement_adresse = "11 rue carrée";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
//        $intervention_count_before = $this->tester->grabNumRecords('intervention');
//        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_creneau = $this->creneau->create([
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

            'tarif' => $prix_creneau,
            'paiement' => $facilite_paiement,
            'description' => $description_creneau,
            'nb_participant' => $nombre_participants,
            'public_vise' => $public_vise,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->assertNotFalse($id_creneau, $this->creneau->getErrorMessage());
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
//        $intervention_count_after = $this->tester->grabNumRecords('intervention');
//        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($creneaux_count_before + 1, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before + 1, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before + 1, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before + 1, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);
//        $this->assertEquals($intervient_dans_count_before + 1, $intervient_dans_count_after);

        $this->tester->seeInDatabase('creneaux', [
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'id_jour' => $jour,
            'id_type_parcours' => $type_creneau,
            'pathologie_creneau' => $pathologie,
            'type_seance' => $type_seance,
            'id_structure' => $id_structure,
            'activation' => "1",

            'facilite_paiement' => $facilite_paiement,
            'nombre_participants' => $nombre_participants,
            'description_creneau' => $description_creneau,
            'prix_creneau' => $prix_creneau,
            'public_vise' => $public_vise,
        ]);

        $this->tester->seeInDatabase('commence_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_debut,
        ]);

        $this->tester->seeInDatabase('se_termine_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_fin,
        ]);

        $this->tester->seeInDatabase('se_pratique_a', [
            'id_creneau' => $id_creneau,
        ]);

        $id_adresse = $this->tester->grabFromDatabase(
            'se_pratique_a',
            'id_adresse',
            ['id_creneau' => $id_creneau]
        );

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        foreach ($intervenant_ids as $id_intervenant) {
            $this->tester->seeInDatabase('creneaux_intervenant', [
                'id_creneau' => $id_creneau,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testCreateOkAllDataEvaluateur()
    {
        // paramètres obligatoires
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        // paramètres optionnels
        $facilite_paiement = "Oui";
        $nombre_participants = "40";
        $description_creneau = "Allons-y.";
        $prix_creneau = "10";
        $public_vise = "Personnes en mesure de faire du sport";
        $complement_adresse = "11 rue carrée";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
//        $intervention_count_before = $this->tester->grabNumRecords('intervention');
//        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $id_creneau = $this->creneau->create([
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
            'activation' => "1",

            'tarif' => $prix_creneau,
            'paiement' => $facilite_paiement,
            'description' => $description_creneau,
            'nb_participant' => $nombre_participants,
            'public_vise' => $public_vise,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->assertNotFalse($id_creneau, $this->creneau->getErrorMessage());
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
//        $intervention_count_after = $this->tester->grabNumRecords('intervention');
//        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($creneaux_count_before + 1, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before + 1, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before + 1, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before + 1, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);
//        $this->assertEquals($intervient_dans_count_before + 1, $intervient_dans_count_after);

        $this->tester->seeInDatabase('creneaux', [
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'id_jour' => $jour,
            'id_type_parcours' => $type_creneau,
            'pathologie_creneau' => $pathologie,
            'type_seance' => $type_seance,
            'id_structure' => $id_structure,

            'facilite_paiement' => $facilite_paiement,
            'nombre_participants' => $nombre_participants,
            'description_creneau' => $description_creneau,
            'prix_creneau' => $prix_creneau,
            'public_vise' => $public_vise,
        ]);

        $this->tester->seeInDatabase('commence_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_debut,
        ]);

        $this->tester->seeInDatabase('se_termine_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_fin,
        ]);

        $this->tester->seeInDatabase('se_pratique_a', [
            'id_creneau' => $id_creneau,
        ]);

        $id_adresse = $this->tester->grabFromDatabase(
            'se_pratique_a',
            'id_adresse',
            ['id_creneau' => $id_creneau]
        );

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        foreach ($intervenant_ids as $id_intervenant) {
            $this->tester->seeInDatabase('creneaux_intervenant', [
                'id_creneau' => $id_creneau,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testCreateOkApiMinimumData()
    {
        $nom_creneau = "Pétanque";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $id_api_structure = 'api-structure-98766568-sdfg';
        $id_api_intervenant = 'api-intervenant-1111-aaaa';
        $id_api = 'api-creneau-2222-hdfgh';

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
            'nom_creneau' => $nom_creneau,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'nom_adresse' => $nom_adresse,
            'jour' => $jour,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'type_creneau' => $type_creneau,
            'pathologie' => $pathologie,
            'type_seance' => $type_seance,
            'activation' => "1",

            'id_api_structure' => $id_api_structure,
            'id_api_intervenant' => $id_api_intervenant,
            'id_api' => $id_api,
        ]);

        $this->assertNotFalse($id_creneau, $this->creneau->getErrorMessage());
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before + 1, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before + 1, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before + 1, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before + 1, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);

        $id_intervenant = $this->tester->grabFromDatabase(
            'intervenants',
            'id_intervenant',
            ['id_api' => $id_api_intervenant]
        );
        $intervenant_ids = [$id_intervenant];

        $id_structure = $this->tester->grabFromDatabase(
            'structure',
            'id_structure',
            ['id_api' => $id_api_structure]
        );

        $this->tester->seeInDatabase('creneaux', [
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'id_jour' => $jour,
            'id_type_parcours' => $type_creneau,
            'pathologie_creneau' => $pathologie,
            'type_seance' => $type_seance,
            'id_structure' => $id_structure,
            'id_api' => $id_api,
        ]);

        $this->tester->seeInDatabase('commence_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_debut,
        ]);

        $this->tester->seeInDatabase('se_termine_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_fin,
        ]);

        $this->tester->seeInDatabase('se_pratique_a', [
            'id_creneau' => $id_creneau,
        ]);

        $id_adresse = $this->tester->grabFromDatabase(
            'se_pratique_a',
            'id_adresse',
            ['id_creneau' => $id_creneau]
        );

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        foreach ($intervenant_ids as $id_intervenant) {
            $this->tester->seeInDatabase('creneaux_intervenant', [
                'id_creneau' => $id_creneau,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testCreateOkMissingNom_adresse()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = null;
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
            'activation' => "1",
        ]);

        $this->assertNotFalse($id_creneau, $this->creneau->getErrorMessage());
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before + 1, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before + 1, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before + 1, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before + 1, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before + 1, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before + 1, $se_localise_a_count_after);

        $this->tester->seeInDatabase('creneaux', [
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'id_jour' => $jour,
            'id_type_parcours' => $type_creneau,
            'pathologie_creneau' => $pathologie,
            'type_seance' => $type_seance,
            'id_structure' => $id_structure,
        ]);

        $this->tester->seeInDatabase('commence_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_debut,
        ]);

        $this->tester->seeInDatabase('se_termine_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_fin,
        ]);

        $this->tester->seeInDatabase('se_pratique_a', [
            'id_creneau' => $id_creneau,
        ]);

        $id_adresse = $this->tester->grabFromDatabase('se_pratique_a', 'id_adresse', ['id_creneau' => $id_creneau]
        );

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            // nom d'une adresse par défaut si non renseigné, par exemple lors de l'import par l'API de référencement
            'nom_adresse' => "Non renseigné",
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        foreach ($intervenant_ids as $id_intervenant) {
            $this->tester->seeInDatabase('creneaux_intervenant', [
                'id_creneau' => $id_creneau,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testCreateNotOkApiCreneauAlreadyImported()
    {
        $nom_creneau = "Creneau 1 86";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $type_creneau = "1";
        $pathologie = "Cancer";

        // même jour, heure de début et fin, type de séance
        // que la structure existante
        $jour = "2";
        $heure_debut = "2";
        $heure_fin = "10";
        $type_seance = "Collective";

        $id_api_structure = "api-structure-98766568-sdfg";
        $id_api_intervenant = "api-intervenant-1111-aaaa";
        $id_api = "api-creneau-1111-exist";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
            'nom_creneau' => $nom_creneau,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'nom_adresse' => $nom_adresse,
            'jour' => $jour,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'type_creneau' => $type_creneau,
            'pathologie' => $pathologie,
            'type_seance' => $type_seance,

            'id_api_structure' => $id_api_structure,
            'id_api_intervenant' => $id_api_intervenant,
            'id_api' => $id_api,
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkApiStructureNotImported()
    {
        $nom_creneau = "Pétanque";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $id_api_structure = "api-structure-11111-bbbb"; // structure does not exist
        $id_api_intervenant = "api-intervenant-1111-aaaa";
        $id_api = "api-creneau-2222-hdfgh";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
            'nom_creneau' => $nom_creneau,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'nom_adresse' => $nom_adresse,
            'jour' => $jour,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'type_creneau' => $type_creneau,
            'pathologie' => $pathologie,
            'type_seance' => $type_seance,

            'id_api_structure' => $id_api_structure,
            'id_api_intervenant' => $id_api_intervenant,
            'id_api' => $id_api,
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkApiIntervenantNotImported()
    {
        $nom_creneau = "Pétanque";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $id_api_structure = "api-structure-98766568-sdfg";
        $id_api_intervenant = "api-structure-000-null"; // intervenant does not exist
        $id_api = "api-creneau-2222-hdfgh";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
            'nom_creneau' => $nom_creneau,
            'code_postal' => $code_postal,
            'nom_ville' => $nom_ville,
            'nom_adresse' => $nom_adresse,
            'jour' => $jour,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'type_creneau' => $type_creneau,
            'pathologie' => $pathologie,
            'type_seance' => $type_seance,

            'id_api_structure' => $id_api_structure,
            'id_api_intervenant' => $id_api_intervenant,
            'id_api' => $id_api,
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingNom_creneau()
    {
        $nom_creneau = null;
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingCode_postal()
    {
        $nom_creneau = "Yoga";
        $code_postal = null;
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingNom_ville()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = null;
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingJour()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = null;
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingHeure_debut()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = null;
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingHeure_fin()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = null;
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingType_creneau()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = null;
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingId_structure()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = null;
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingId_intervenant()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = [];
        $pathologie = "Cancer";
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingPathologie()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = null;
        $type_seance = "Collectif";

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testCreateNotOkMissingType_seance()
    {
        $nom_creneau = "Yoga";
        $code_postal = "86000";
        $nom_ville = "POITIERS";
        $nom_adresse = "22 rue carrée";
        $jour = "1";
        $heure_debut = "4";
        $heure_fin = "7";
        $type_creneau = "1";
        $id_structure = "1";
        $intervenant_ids = ["1"];
        $pathologie = "Cancer";
        $type_seance = null;

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');

        $id_creneau = $this->creneau->create([
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
        ]);

        $this->assertFalse($id_creneau);
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after);
        $this->assertEquals($adresse_count_before, $adresse_count_after);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after);
    }

    public function testUpdateOkMinimumData()
    {
        $id_creneau = "3";
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

        $update_ok = $this->creneau->update([
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

        $this->tester->seeInDatabase('creneaux', [
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'id_jour' => $jour,
            'id_type_parcours' => $type_creneau,
            'pathologie_creneau' => $pathologie,
            'type_seance' => $type_seance,
            'id_structure' => $id_structure,
            'activation' => $activation,
        ]);

        $this->tester->seeInDatabase('commence_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_debut,
        ]);

        $this->tester->seeInDatabase('se_termine_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_fin,
        ]);

        $this->tester->seeInDatabase('se_pratique_a', [
            'id_creneau' => $id_creneau,
        ]);

        $id_adresse = $this->tester->grabFromDatabase(
            'se_pratique_a',
            'id_adresse',
            ['id_creneau' => $id_creneau]
        );

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $creneaux_intervenant_count = $this->tester->grabNumRecords('creneaux_intervenant', [
            'id_creneau' => $id_creneau,
        ]);
        $this->assertEquals($creneaux_intervenant_count, count($intervenant_ids));

        foreach ($intervenant_ids as $id_intervenant) {
            $this->tester->seeInDatabase('creneaux_intervenant', [
                'id_creneau' => $id_creneau,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testUpdateOkAllData()
    {
        // paramètres obligatoires
        $id_creneau = "4";
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
        // paramètres optionnels
        $facilite_paiement = "Oui";
        $nombre_participants = "40";
        $description_creneau = "Allons";
        $prix_creneau = "10";
        $public_vise = "Personnes en mesure de faire du sport";
        $complement_adresse = "11 rue carrée";

        $update_ok = $this->creneau->update([
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

            'tarif' => $prix_creneau,
            'paiement' => $facilite_paiement,
            'description' => $description_creneau,
            'nb_participant' => $nombre_participants,
            'public_vise' => $public_vise,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('creneaux', [
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'id_jour' => $jour,
            'id_type_parcours' => $type_creneau,
            'pathologie_creneau' => $pathologie,
            'type_seance' => $type_seance,
            'id_structure' => $id_structure,
            'activation' => $activation,

            'facilite_paiement' => $facilite_paiement,
            'nombre_participants' => $nombre_participants,
            'description_creneau' => $description_creneau,
            'prix_creneau' => $prix_creneau,
            'public_vise' => $public_vise,
        ]);

        $this->tester->seeInDatabase('commence_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_debut,
        ]);

        $this->tester->seeInDatabase('se_termine_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_fin,
        ]);

        $this->tester->seeInDatabase('se_pratique_a', [
            'id_creneau' => $id_creneau,
        ]);

        $id_adresse = $this->tester->grabFromDatabase(
            'se_pratique_a',
            'id_adresse',
            ['id_creneau' => $id_creneau]
        );

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => $nom_adresse,
            'complement_adresse' => $complement_adresse,
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $creneaux_intervenant_count = $this->tester->grabNumRecords('creneaux_intervenant', [
            'id_creneau' => $id_creneau,
        ]);
        $this->assertEquals($creneaux_intervenant_count, count($intervenant_ids));

        foreach ($intervenant_ids as $id_intervenant) {
            $this->tester->seeInDatabase('creneaux_intervenant', [
                'id_creneau' => $id_creneau,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testUpdateOkMissingNom_adresse()
    {
        $id_creneau = "3";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $nom_adresse = null;
        $jour = "2";
        $heure_debut = "5";
        $heure_fin = "8";
        $type_creneau = "2";
        $id_structure = "2";
        $intervenant_ids = ["1"];
        $pathologie = "Surpoids";
        $type_seance = "Individuel";
        $activation = "0";

        $update_ok = $this->creneau->update([
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

        $this->tester->seeInDatabase('creneaux', [
            'id_creneau' => $id_creneau,
            'nom_creneau' => $nom_creneau,
            'id_jour' => $jour,
            'id_type_parcours' => $type_creneau,
            'pathologie_creneau' => $pathologie,
            'type_seance' => $type_seance,
            'id_structure' => $id_structure,
            'activation' => $activation,
        ]);

        $this->tester->seeInDatabase('commence_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_debut,
        ]);

        $this->tester->seeInDatabase('se_termine_a', [
            'id_creneau' => $id_creneau,
            'id_heure' => $heure_fin,
        ]);

        $this->tester->seeInDatabase('se_pratique_a', [
            'id_creneau' => $id_creneau,
        ]);

        $id_adresse = $this->tester->grabFromDatabase(
            'se_pratique_a',
            'id_adresse',
            ['id_creneau' => $id_creneau]
        );

        $this->tester->seeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
            'nom_adresse' => "Non renseigné",
        ]);

        $this->tester->seeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $creneaux_intervenant_count = $this->tester->grabNumRecords('creneaux_intervenant', [
            'id_creneau' => $id_creneau,
        ]);
        $this->assertEquals($creneaux_intervenant_count, count($intervenant_ids));

        foreach ($intervenant_ids as $id_intervenant) {
            $this->tester->seeInDatabase('creneaux_intervenant', [
                'id_creneau' => $id_creneau,
                'id_intervenant' => $id_intervenant,
            ]);
        }
    }

    public function testUpdateNotOkMissingId_creneau()
    {
        $id_creneau = null;
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

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingNom_creneau()
    {
        $id_creneau = "3";
        $nom_creneau = null;
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

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingNom_ville()
    {
        $id_creneau = "3";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = null;
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

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingJour()
    {
        $id_creneau = "3";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $nom_adresse = "78 rue carrée";
        $jour = null;
        $heure_debut = "5";
        $heure_fin = "8";
        $type_creneau = "2";
        $id_structure = "2";
        $intervenant_ids = ["1"];
        $pathologie = "Surpoids";
        $type_seance = "Individuel";
        $activation = "0";

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingHeure_debut()
    {
        $id_creneau = "3";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $nom_adresse = "78 rue carrée";
        $jour = "2";
        $heure_debut = null;
        $heure_fin = "8";
        $type_creneau = "2";
        $id_structure = "2";
        $intervenant_ids = ["1"];
        $pathologie = "Surpoids";
        $type_seance = "Individuel";
        $activation = "0";

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingHeure_fin()
    {
        $id_creneau = "3";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $nom_adresse = "78 rue carrée";
        $jour = "2";
        $heure_debut = "5";
        $heure_fin = null;
        $type_creneau = "2";
        $id_structure = "2";
        $intervenant_ids = ["1"];
        $pathologie = "Surpoids";
        $type_seance = "Individuel";
        $activation = "0";

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingType_creneau()
    {
        $id_creneau = "3";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $nom_adresse = "78 rue carrée";
        $jour = "2";
        $heure_debut = "5";
        $heure_fin = "8";
        $type_creneau = null;
        $id_structure = "2";
        $intervenant_ids = ["1"];
        $pathologie = "Surpoids";
        $type_seance = "Individuel";
        $activation = "0";

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingId_structure()
    {
        $id_creneau = "3";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $nom_adresse = "78 rue carrée";
        $jour = "2";
        $heure_debut = "5";
        $heure_fin = "8";
        $type_creneau = "2";
        $id_structure = null;
        $intervenant_ids = ["1"];
        $pathologie = "Surpoids";
        $type_seance = "Individuel";
        $activation = "0";

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingId_intervenant()
    {
        $id_creneau = "3";
        $nom_creneau = "Tennis";
        $code_postal = "86100";
        $nom_ville = "ANTRAN";
        $nom_adresse = "78 rue carrée";
        $jour = "2";
        $heure_debut = "5";
        $heure_fin = "8";
        $type_creneau = "2";
        $id_structure = "2";
        $intervenant_ids = [];
        $pathologie = "Surpoids";
        $type_seance = "Individuel";
        $activation = "0";

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingPathologie()
    {
        $id_creneau = "3";
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
        $pathologie = null;
        $type_seance = "Individuel";
        $activation = "0";

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingType_seance()
    {
        $id_creneau = "3";
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
        $type_seance = null;
        $activation = "0";

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testUpdateNotOkMissingActivation()
    {
        $id_creneau = "3";
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
        $activation = null;

        $update_ok = $this->creneau->update([
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

        $this->assertFalse($update_ok);
    }

    public function testDeleteOk()
    {
        $id_creneau = '5';

        $id_adresse = $this->tester->grabFromDatabase(
            'se_pratique_a',
            'id_adresse',
            ['id_creneau' => $id_creneau]
        );
        $this->assertNotNull($id_adresse);

        $creneaux_count_before = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_before = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_before = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_before = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_before = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_before = $this->tester->grabNumRecords('se_localise_a');
        $intervient_dans_count_before = $this->tester->grabNumRecords('intervient_dans');

        $delete_ok = $this->creneau->delete($id_creneau);

        $this->assertTrue($delete_ok, $this->creneau->getErrorMessage());
        $creneaux_count_after = $this->tester->grabNumRecords('creneaux');
        $commence_a_count_after = $this->tester->grabNumRecords('commence_a');
        $se_termine_a_count_after = $this->tester->grabNumRecords('se_termine_a');
        $adresse_count_after = $this->tester->grabNumRecords('adresse');
        $se_pratique_a_after = $this->tester->grabNumRecords('se_pratique_a');
        $se_localise_a_count_after = $this->tester->grabNumRecords('se_localise_a');
        $intervient_dans_count_after = $this->tester->grabNumRecords('intervient_dans');

        $this->assertEquals($creneaux_count_before, $creneaux_count_after + 1);
        $this->assertEquals($commence_a_count_before, $commence_a_count_after + 1);
        $this->assertEquals($se_termine_a_count_before, $se_termine_a_count_after + 1);
        $this->assertEquals($adresse_count_before, $adresse_count_after + 1);
        $this->assertEquals($se_pratique_a_before, $se_pratique_a_after + 1);
        $this->assertEquals($se_localise_a_count_before, $se_localise_a_count_after + 1);
        // l'intervenant de ce creneau intervient dans d'autres créneaux de la structure
        $this->assertEquals($intervient_dans_count_before, $intervient_dans_count_after);

        $this->tester->dontSeeInDatabase('creneaux', [
            'id_creneau' => $id_creneau,
        ]);

        $this->tester->dontSeeInDatabase('commence_a', [
            'id_creneau' => $id_creneau,
        ]);

        $this->tester->dontSeeInDatabase('se_termine_a', [
            'id_creneau' => $id_creneau,
        ]);

        $this->tester->dontSeeInDatabase('se_pratique_a', [
            'id_creneau' => $id_creneau,
        ]);

        $this->tester->dontSeeInDatabase('adresse', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->dontSeeInDatabase('se_localise_a', [
            'id_adresse' => $id_adresse,
        ]);

        $this->tester->dontSeeInDatabase('creneaux_intervenant', [
            'id_creneau' => $id_creneau,
        ]);
    }

    public function testDeleteNotOkPatientOrienteVersCreneau()
    {
        $id_creneau = "1";

        $delete_ok = $this->creneau->delete($id_creneau);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkParticipantPresents()
    {
        $id_creneau = "2";

        $delete_ok = $this->creneau->delete($id_creneau);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkSeancePresente()
    {
        $id_creneau = "6";

        $delete_ok = $this->creneau->delete($id_creneau);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkId_creneauNull()
    {
        $id_creneau = null;

        $delete_ok = $this->creneau->delete($id_creneau);

        $this->assertFalse($delete_ok);
    }

    public function testDeleteNotOkId_creneauInvalide()
    {
        $id_creneau = '-1';

        $delete_ok = $this->creneau->delete($id_creneau);

        $this->assertFalse($delete_ok);
    }

    public function testGetUserIdsOkIntervenantUser()
    {
        $id_creneau = '6';

        $id_user = $this->creneau->getUserIds($id_creneau);

        $this->assertEqualsCanonicalizing(["3"], $id_user);
    }

    public function testGetUserIdsOkIntervenantNotUser()
    {
        $id_creneau = '1';

        $id_user = $this->creneau->getUserIds($id_creneau);

        $this->assertEquals([], $id_user);
    }

    public function testUpdateParticipantsOk()
    {
        // update 1
        $id_creneau = "1";
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

        $update_ok = $this->creneau->updateParticipants($id_creneau, $participants);
        $this->assertTrue($update_ok);

        foreach ($participants as $participant) {
            $this->tester->seeInDatabase('liste_participants_creneau', [
                'id_creneau' => $id_creneau,
                'id_patient' => $participant['id_patient'],
                'status_participant' => $participant['status_participant'],
                'propose_inscrit' => $participant['propose_inscrit'],
                'abandon' => $participant['abandon'],
                'reorientation' => $participant['reorientation'],
            ]);
        }

        // update 2
        $participants = [
            [
                'id_patient' => "1",
                'abandon' => "1",
                'propose_inscrit' => "1",
                'reorientation' => "1",
                'status_participant' => "PEPS",
            ],
        ];

        $update_ok = $this->creneau->updateParticipants($id_creneau, $participants);
        $this->assertTrue($update_ok);

        //les bénéficiaires id_patient = 4 et 12 sont plus dans la liste des participants
        //Leur statut d'activité doit donc être "Terminée"
        $id_activites_changees = [4, 5];
        foreach ($id_activites_changees as $id_activite_choisie) {
            $this->tester->seeInDatabase("activite_choisie", [
                'id_activite_choisie' => $id_activite_choisie,
                'statut' => "Terminée",
            ]);
        }

        foreach ($participants as $participant) {
            $this->tester->seeInDatabase('liste_participants_creneau', [
                'id_creneau' => $id_creneau,
                'id_patient' => $participant['id_patient'],
                'status_participant' => $participant['status_participant'],
                'propose_inscrit' => $participant['propose_inscrit'],
                'abandon' => $participant['abandon'],
                'reorientation' => $participant['reorientation'],
            ]);
        }

        // update 3
        $participants = [
            [
                'id_patient' => "4",
                'abandon' => "1",
                'propose_inscrit' => "0",
                'reorientation' => "1",
                'status_participant' => "PEPS",
            ],
        ];

        $update_ok = $this->creneau->updateParticipants($id_creneau, $participants);
        $this->assertTrue($update_ok);

        //l'activité du bénéficiaire id_patient = 1 (id_activite_choisie = 6)
        $this->tester->seeInDatabase("activite_choisie", [
            'id_activite_choisie' => 6,
            'statut' => "Terminée",
        ]);

        foreach ($participants as $participant) {
            $this->tester->seeInDatabase('liste_participants_creneau', [
                'id_creneau' => $id_creneau,
                'id_patient' => $participant['id_patient'],
                'status_participant' => $participant['status_participant'],
                'propose_inscrit' => $participant['propose_inscrit'],
                'abandon' => $participant['abandon'],
                'reorientation' => $participant['reorientation'],
            ]);
        }
    }

    public function testUpdateParticipantsOkEmptyParticipants()
    {
        $id_creneau = "1";
        $participants = [];

        $update_ok = $this->creneau->updateParticipants($id_creneau, $participants);
        $this->assertTrue($update_ok);

        $liste_participants_creneau_count = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_creneau' => $id_creneau]
        );
        $this->assertEquals(0, $liste_participants_creneau_count);

        //les bénéficiaires id_patient = 1, 4 et 12 sont plus dans la liste des participants
        //Leur statut d'activité doit donc être "Terminée"
        $id_activites_changees = [4, 5, 6];
        foreach ($id_activites_changees as $id_activite_choisie) {
            $this->tester->seeInDatabase("activite_choisie", [
                'id_activite_choisie' => $id_activite_choisie,
                'statut' => "Terminée",
            ]);
        }
    }

    public function testUpdateParticipantsNotOkId_creneauNull()
    {
        $id_creneau = null;
        $participants = [];

        $update_ok = $this->creneau->updateParticipants($id_creneau, $participants);
        $this->assertFalse($update_ok);
    }

    public function testUpdateParticipantsNotOkParticipantsNull()
    {
        $id_creneau = "1";
        $participants = null;

        $update_ok = $this->creneau->updateParticipants($id_creneau, $participants);
        $this->assertFalse($update_ok);
    }

    public function testReadAllParticipantsCreneauOk()
    {
        $id_creneau = "1";

        $liste_participants_creneau_count = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_creneau' => $id_creneau]
        );
        $this->assertGreaterThan(0, $liste_participants_creneau_count);

        $participants = $this->creneau->readAllParticipantsCreneau($id_creneau);
        $this->assertIsArray($participants);
        $this->assertCount($liste_participants_creneau_count, $participants);

        foreach ($participants as $participant) {
            $this->assertArrayHasKey('id_patient', $participant);
            $this->assertArrayHasKey('nom_patient', $participant);
            $this->assertArrayHasKey('prenom_patient', $participant);
            $this->assertArrayHasKey('id_liste_participants_creneau', $participant);
            $this->assertArrayHasKey('propose_inscrit', $participant);
            $this->assertArrayHasKey('abandon', $participant);
            $this->assertArrayHasKey('reorientation', $participant);
            $this->assertArrayHasKey('status_participant', $participant);
        }
    }

    public function testReadAllParticipantsCreneauOkEmptyResult()
    {
        $id_creneau = "5";

        $liste_participants_creneau_count = $this->tester->grabNumRecords(
            'liste_participants_creneau',
            ['id_creneau' => $id_creneau]
        );
        $this->assertEquals(0, $liste_participants_creneau_count);

        $participants = $this->creneau->readAllParticipantsCreneau($id_creneau);
        $this->assertIsArray($participants);
        $this->assertCount(0, $participants);
    }

    public function testReadAllParticipantsCreneauNotOkId_creneauNull()
    {
        $id_creneau = null;

        $participants = $this->creneau->readAllParticipantsCreneau($id_creneau);
        $this->assertFalse($participants);
    }

    public function testReadAllPatientOk()
    {
        $id_patient = "4";

        $creneaux = $this->creneau->readAllPatient($id_patient);
        $this->assertIsArray($creneaux);
        $this->assertNotEmpty($creneaux);

        foreach ($creneaux as $creneau) {
            $this->assertArrayHasKey('id_creneau', $creneau);
            $this->assertArrayHasKey('nom_creneau', $creneau);
            $this->assertArrayHasKey('nom_adresse', $creneau);
            $this->assertArrayHasKey('nom_ville', $creneau);
            $this->assertArrayHasKey('complement_adresse', $creneau);
            $this->assertArrayHasKey('code_postal', $creneau);
            $this->assertArrayHasKey('facilite_paiement', $creneau);
            $this->assertArrayHasKey('jour', $creneau);
            $this->assertArrayHasKey('id_jour', $creneau);
            $this->assertArrayHasKey('nom_heure_debut', $creneau);
            $this->assertArrayHasKey('heure_debut', $creneau);
            $this->assertArrayHasKey('nom_heure_fin', $creneau);
            $this->assertArrayHasKey('heure_fin', $creneau);
            $this->assertArrayHasKey('nombre_participants', $creneau);
            $this->assertArrayHasKey('type_parcours', $creneau);
            $this->assertArrayHasKey('id_type_parcours', $creneau);
            $this->assertArrayHasKey('nom_structure', $creneau);
            $this->assertArrayHasKey('id_structure', $creneau);
            $this->assertArrayHasKey('tarif', $creneau);
            $this->assertArrayHasKey('public_vise', $creneau);
            $this->assertArrayHasKey('type_seance', $creneau);
            $this->assertArrayHasKey('pathologie', $creneau);
            $this->assertArrayHasKey('nom_coordonnees', $creneau);
            $this->assertArrayHasKey('prenom_coordonnees', $creneau);
            $this->assertArrayHasKey('description', $creneau);
            $this->assertArrayHasKey('activation', $creneau);
            $this->assertArrayHasKey('nom_territoire', $creneau);
        }
    }

    public function testReadAllPatientOkEmpty()
    {
        $id_patient = "5";

        $creneaux = $this->creneau->readAllPatient($id_patient);
        $this->assertIsArray($creneaux);
        $this->assertEmpty($creneaux);
    }

    public function testReadAllPatientOkId_patientInvalid()
    {
        $id_patient = "-1";

        $creneaux = $this->creneau->readAllPatient($id_patient);
        $this->assertIsArray($creneaux);
        $this->assertEmpty($creneaux);
    }

    public function testReadAllPatientNotOkId_patientNull()
    {
        $id_patient = null;

        $creneaux = $this->creneau->readAllPatient($id_patient);
        $this->assertFalse($creneaux);
    }
}