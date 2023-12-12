<?php

namespace Tests\Unit;

use Dotenv\Dotenv;
use Sportsante86\Sapa\Model\Evaluation;
use Sportsante86\Sapa\Model\Export;
use Tests\Support\UnitTester;

class ExportTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private Export $export;
    private Evaluation $evaluation;

    private string $root = __DIR__ . '/../..';

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->evaluation = new Evaluation($pdo);
        $this->export = new Export($pdo);
        $this->assertNotNull($this->export);
        $this->assertNotNull($this->evaluation);

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

    public function testReadOnapsDataNotOKMissingRole_user_ids()
    {
        $session = [
            'role_user_ids' => [],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsData($session);

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testReadOnapsDataNotOKMissingId_structure()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => null,
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsData($session);

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testReadOnapsDataNotOKMissingId_territoire()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => null,
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsData($session);

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testReadOnapsDataNotOKMissingId_statut_structure()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => null,
        ];
        $result = $this->export->readOnapsData($session);

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testReadOnapsDataWithoutYearOKCoordonnateurPeps1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsData($session);

        $this->assertIsArray($result);

        $expected_count = 4;// il y a le header et 3 évaluations pour les patients du territoire 1
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);
        }
    }

    public function testReadOnapsDataWithoutYearOKCoordonnateurPeps2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '2',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsData($session);

        $this->assertIsArray($result);

        $expected_count = 1;// il y a le header et 0 évaluations pour les patients du territoire 2
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);
        }
    }

    public function testReadOnapsDataWithoutYearOKCoordonnateurMss1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_structure' => '1',
            'id_territoire' => '2',
            'id_statut_structure' => '1',
        ];
        $result = $this->export->readOnapsData($session);

        $this->assertIsArray($result);

        $expected_count = 5;// il y a le header et 4 évaluations pour les patients de la structure 1
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);
        }
    }

    public function testReadOnapsDataWithoutYearOKCoordonnateurMss2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_structure' => '4',
            'id_territoire' => '2',
            'id_statut_structure' => '1',
        ];
        $result = $this->export->readOnapsData($session);

        $this->assertIsArray($result);

        $expected_count = 1;// il y a le header et 0 évaluation pour les patients de la structure 4
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);
        }
    }

    public function testReadOnapsDataWithoutYearOKCoordonnateurNonMssMss1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2", // non MSS
            'id_territoire' => '1',
            'id_structure' => '2',
            'id_user' => '16',
        ];
        $result = $this->export->readOnapsData($session);

        $this->assertIsArray($result);

        $expected_count = 2;// il y a le header et 1 évaluation pour les patients de la structure 2
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);
        }
    }

    public function testReadOnapsDataWithoutYearOKCoordonnateurNonMss2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2", // non MSS
            'id_territoire' => '1',
            'id_structure' => '4',
            'id_user' => '16',
        ];
        $result = $this->export->readOnapsData($session);

        $this->assertIsArray($result);

        $expected_count = 1;// il y a le header et 0 évaluation pour les patients de la structure 4
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);
        }
    }

    public function testReadOnapsDataWithoutYearOKEvaluateur1()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '7', // un évaluateur
        ];
        $result = $this->export->readOnapsData($session);
        $this->assertIsArray($result);
        $expected_count = 2; // il y a le header et 1 patient (l'évaluateur n'a qu'un patient et le patient a 1 évaluation)
        $this->assertCount($expected_count, $result);

        //==============================
        // création évaluation initiale
        $id_user = $session['id_user'];
        $id_patient = "7";
        $id_type_eval = "1";
        $date_eval = "2022-07-28";

        // test physio
        $auto0 = "2"; // égal à "1" si le test a été réalisé
        $poids = "";
        $taille = "";
        $IMC = "";
        $tour_taille = "";
        $fcrepos = "";
        $satrepos = "";
        $borgrepos = "";
        $fcmax = "";
        $motif_test_physio = "1";

        // test Aptitude aerobie
        $auto1 = "2"; // égal à "1" si le test a été réalisé
        $dp = "";
        $fc1 = "";
        $fc2 = "";
        $fc3 = "";
        $fc4 = "";
        $fc5 = "";
        $fc6 = "";
        $fc7 = "";
        $fc8 = "";
        $fc9 = "";
        $sat1 = "";
        $sat2 = "";
        $sat3 = "";
        $sat4 = "";
        $sat5 = "";
        $sat6 = "";
        $sat7 = "";
        $sat8 = "";
        $sat9 = "";
        $borg1 = "";
        $borg2 = "";
        $borg3 = "";
        $borg4 = "";
        $borg5 = "";
        $borg6 = "";
        $borg7 = "";
        $borg8 = "";
        $borg9 = "";
        $com_aa = "";
        $motif_apt_aerobie = "2";

        // test up and go (non réalisé)
        $auto_up_and_go = "2"; // égal à "1" si le test a été réalisé
        $com_up_and_go = "";
        $duree_up_and_go = "";
        $motif_up_and_go = "3";

        // test Force musculaire membres supérieurs
        $auto2 = "2"; // égal à "1" si le test a été réalisé
        $com_fmms = "";
        $main_forte = "";
        $mg = "";
        $md = "";
        $motif_fmms = "4";

        // test Equilibre statique
        $auto3 = "2"; // égal à "1" si le test a été réalisé
        $com_eq = "";
        $pied_dominant = "";
        $pg = "";
        $pd = "";
        $motif_eq_stat = "1";

        // test Souplesse
        $auto4 = "2"; // égal à "1" si le test a été réalisé
        $com_soupl = "";
        $distance = "";
        $motif_soupl = "2";

        // test Mobilité Scapulo-Humérale
        $auto5 = "2"; // égal à "1" si le test a été réalisé
        $com_msh = "";
        $mgh = "";
        $mdh = "";
        $motif_mobilite_scapulo_humerale = "3";

        // test Endurance musculaire membres inférieurs
        $auto6 = "2"; // égal à "1" si le test a été réalisé
        $com_emmi = "";
        $nb_lever = "";
        $fc30 = "";
        $sat30 = "";
        $borg30 = "";
        $motif_end_musc_mb_inf = "4";

        $id_evaluation = $this->evaluation->create([
            'id_user' => $id_user,
            'id_patient' => $id_patient,
            'id_type_eval' => $id_type_eval,
            'date_eval' => $date_eval,

            // test physio
            'auto0' => $auto0,
            'poids' => $poids,
            'taille' => $taille,
            'IMC' => $IMC,
            'tour_taille' => $tour_taille,
            'fcrepos' => $fcrepos,
            'satrepos' => $satrepos,
            'borgrepos' => $borgrepos,
            'fcmax' => $fcmax,
            'motif_test_physio' => $motif_test_physio,

            // test Aptitude aerobie
            'auto1' => $auto1,
            'dp' => $dp,
            'fc1' => $fc1,
            'fc2' => $fc2,
            'fc3' => $fc3,
            'fc4' => $fc4,
            'fc5' => $fc5,
            'fc6' => $fc6,
            'fc7' => $fc7,
            'fc8' => $fc8,
            'fc9' => $fc9,
            'sat1' => $sat1,
            'sat2' => $sat2,
            'sat3' => $sat3,
            'sat4' => $sat4,
            'sat5' => $sat5,
            'sat6' => $sat6,
            'sat7' => $sat7,
            'sat8' => $sat8,
            'sat9' => $sat9,
            'borg1' => $borg1,
            'borg2' => $borg2,
            'borg3' => $borg3,
            'borg4' => $borg4,
            'borg5' => $borg5,
            'borg6' => $borg6,
            'borg7' => $borg7,
            'borg8' => $borg8,
            'borg9' => $borg9,
            'com_aa' => $com_aa,
            'motif_apt_aerobie' => $motif_apt_aerobie,

            // test up and go
            'auto-up-and-go' => $auto_up_and_go,
            'com-up-and-go' => $com_up_and_go,
            'duree-up-and-go' => $duree_up_and_go,
            'motif-up-and-go' => $motif_up_and_go,

            // test Force musculaire membres supérieurs
            'auto2' => $auto2,
            'com_fmms' => $com_fmms,
            'main_forte' => $main_forte,
            'mg' => $mg,
            'md' => $md,
            'motif_fmms' => $motif_fmms,

            // test Equilibre statique
            'auto3' => $auto3,
            'com_eq' => $com_eq,
            'pied-dominant' => $pied_dominant,
            'pg' => $pg,
            'pd' => $pd,
            'motif_eq_stat' => $motif_eq_stat,

            // test Souplesse
            'auto4' => $auto4,
            'com_soupl' => $com_soupl,
            //'membre' => "Majeur au sol",
            'distance' => $distance,
            'motif_soupl' => $motif_soupl,

            // test Mobilité Scapulo-Humérale
            'auto5' => $auto5,
            'com_msh' => $com_msh,
            'mgh' => $mgh,
            'mdh' => $mdh,
            'motif_mobilite_scapulo_humerale' => $motif_mobilite_scapulo_humerale,

            // test Endurance musculaire membres inférieurs
            'auto6' => $auto6,
            'com_emmi' => $com_emmi,
            'nb_lever' => $nb_lever,
            'fc30' => $fc30,
            'sat30' => $sat30,
            'borg30' => $borg30,
            'motif_end_musc_mb_inf' => $motif_end_musc_mb_inf
        ]);
        $this->assertNotFalse($id_evaluation, $this->evaluation->getErrorMessage());

        //==============================
        $result = $this->export->readOnapsData($session);
        $this->assertIsArray($result);
        $expected_count = 3; // il y a le header et les 2 évals d'1 patient (l'évaluateur n'a qu'un patient)
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);
        }
    }

    public function testReadOnapsDataWithYearOK1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsData($session, 2022);

        $expected_count = 4;// il y a le header et 3 évaluations pour les patients arrivés en 2022 du territoire 1
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);
        }
    }

    public function testReadOnapsDataWithYearOK2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsData($session, 2000);

        $expected_count = 1;// il y a le header et 0 évaluations pour les patients arrivés en 2000 du territoire 1
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);
        }
    }

    public function testReadOnapsDataForThalamusNotOKMissingRole_user_ids()
    {
        $session = [
            'role_user_ids' => [],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsDataForThalamus($session);

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testReadOnapsDataForThalamusNotOKMissingId_structure()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => null,
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsDataForThalamus($session);

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testReadOnapsDataForThalamusNotOKMissingId_territoire()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => null,
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsDataForThalamus($session);

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testReadOnapsDataForThalamusNotOKMissingId_statut_structure()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => null,
        ];
        $result = $this->export->readOnapsDataForThalamus($session);

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testReadOnapsDataForThalamusWithoutYearOKCoordonnateurPeps1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsDataForThalamus($session);

        $this->assertIsArray($result);

        $expected_count = 3;// il y a 3 évaluations pour les patients du territoire 1
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);

            $this->assertArrayHasKey("id_beneficiaire", $row);
            $this->assertArrayHasKey("date", $row);
            $this->assertArrayHasKey("rep_mesure", $row);
            $this->assertArrayHasKey("age", $row);
            $this->assertArrayHasKey("sexe", $row);
            $this->assertArrayHasKey("prescription", $row);
            $this->assertArrayHasKey("raison", $row);
            $this->assertArrayHasKey("raison_detail", $row);
            $this->assertArrayHasKey("ald1", $row);
            $this->assertArrayHasKey("ald1_detail", $row);
            $this->assertArrayHasKey("ald2", $row);
            $this->assertArrayHasKey("ald2_detail", $row);
            $this->assertArrayHasKey("ald3", $row);
            $this->assertArrayHasKey("ald3_detail", $row);
            $this->assertArrayHasKey("ald4", $row);
            $this->assertArrayHasKey("ald4_detail", $row);
            $this->assertArrayHasKey("poids", $row);
            $this->assertArrayHasKey("taille", $row);
            $this->assertArrayHasKey("perimetre", $row);
            $this->assertArrayHasKey("qpv", $row);
            $this->assertArrayHasKey("zrr", $row);
            $this->assertArrayHasKey("heures", $row);
            $this->assertArrayHasKey("mode", $row);
            $this->assertArrayHasKey("tm6", $row);
            $this->assertArrayHasKey("tm6_spo2_pre", $row);
            $this->assertArrayHasKey("tm6_spo2_post0min", $row);
            $this->assertArrayHasKey("tm6_spo2_post1min", $row);
            $this->assertArrayHasKey("tm6_spo2_post2min", $row);
            $this->assertArrayHasKey("tm6_fc_pre", $row);
            $this->assertArrayHasKey("tm6_fc_post0min", $row);
            $this->assertArrayHasKey("tm6_fc_post1min", $row);
            $this->assertArrayHasKey("tm6_fc_post2min", $row);
            $this->assertArrayHasKey("tm6_rpe", $row);
            $this->assertArrayHasKey("assis_debout", $row);
            $this->assertArrayHasKey("tupandgo", $row);
            $this->assertArrayHasKey("handgrip_md", $row);
            $this->assertArrayHasKey("handgrip_mnd", $row);
            $this->assertArrayHasKey("equilibre_pd", $row);
            $this->assertArrayHasKey("equilibre_pnd", $row);
            $this->assertArrayHasKey("flexion_tronc", $row);
            $this->assertArrayHasKey("q0", $row);
            $this->assertArrayHasKey("q1_fort", $row);
            $this->assertArrayHasKey("q1_modere", $row);
            $this->assertArrayHasKey("q2_fort", $row);
            $this->assertArrayHasKey("q2_modere", $row);
            $this->assertArrayHasKey("q3_fort", $row);
            $this->assertArrayHasKey("q3_modere", $row);
            $this->assertArrayHasKey("q4", $row);
            $this->assertArrayHasKey("q5_pied", $row);
            $this->assertArrayHasKey("q5_velo", $row);
            $this->assertArrayHasKey("q5_autre", $row);
            $this->assertArrayHasKey("q6_pied", $row);
            $this->assertArrayHasKey("q6_velo", $row);
            $this->assertArrayHasKey("q6_autre", $row);
            $this->assertArrayHasKey("q7_pied", $row);
            $this->assertArrayHasKey("q7_velo", $row);
            $this->assertArrayHasKey("q7_autre", $row);
            $this->assertArrayHasKey("q8", $row);
            $this->assertArrayHasKey("q9", $row);
            $this->assertArrayHasKey("q10", $row);
            $this->assertArrayHasKey("q11", $row);
            $this->assertArrayHasKey("q12", $row);
            $this->assertArrayHasKey("q13", $row);
            $this->assertArrayHasKey("q14_fort", $row);
            $this->assertArrayHasKey("q14_modere", $row);
            $this->assertArrayHasKey("q15_fort", $row);
            $this->assertArrayHasKey("q15_modere", $row);
            $this->assertArrayHasKey("q16_fort", $row);
            $this->assertArrayHasKey("q16_modere", $row);
            $this->assertArrayHasKey("q17_ecran", $row);
            $this->assertArrayHasKey("q17_autre", $row);
            $this->assertArrayHasKey("q18_ecran", $row);
            $this->assertArrayHasKey("q18_autre", $row);
            $this->assertArrayHasKey("q19_ecran", $row);
            $this->assertArrayHasKey("q19_autre", $row);
            $this->assertArrayHasKey("garnier_q1", $row);
            $this->assertArrayHasKey("garnier_q2", $row);
            $this->assertArrayHasKey("garnier_q3", $row);
            $this->assertArrayHasKey("garnier_q4", $row);
            $this->assertArrayHasKey("garnier_q5", $row);
            $this->assertArrayHasKey("garnier_q6", $row);
            $this->assertArrayHasKey("garnier_q7", $row);
            $this->assertArrayHasKey("garnier_q8", $row);
            $this->assertArrayHasKey("nap_min_score", $row);
            $this->assertArrayHasKey("nap_mets_score", $row);
            $this->assertArrayHasKey("sed_score", $row);
            $this->assertArrayHasKey("ps_score", $row);
        }
    }

    public function testReadOnapsDataForThalamusWithoutYearOKCoordonnateurPeps2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '2',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsDataForThalamus($session);

        $this->assertIsArray($result);

        $expected_count = 0;// il y a 0 évaluations pour les patients du territoire 2
        $this->assertCount($expected_count, $result);
    }

    public function testReadOnapsDataForThalamusWithoutYearOKCoordonnateurMss1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_structure' => '1',
            'id_territoire' => '2',
            'id_statut_structure' => '1',
        ];
        $result = $this->export->readOnapsDataForThalamus($session);

        $this->assertIsArray($result);

        $expected_count = 4;// il y a 4 évaluations pour les patients de la structure 1
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);

            $this->assertArrayHasKey("id_beneficiaire", $row);
            $this->assertArrayHasKey("date", $row);
            $this->assertArrayHasKey("rep_mesure", $row);
            $this->assertArrayHasKey("age", $row);
            $this->assertArrayHasKey("sexe", $row);
            $this->assertArrayHasKey("prescription", $row);
            $this->assertArrayHasKey("raison", $row);
            $this->assertArrayHasKey("raison_detail", $row);
            $this->assertArrayHasKey("ald1", $row);
            $this->assertArrayHasKey("ald1_detail", $row);
            $this->assertArrayHasKey("ald2", $row);
            $this->assertArrayHasKey("ald2_detail", $row);
            $this->assertArrayHasKey("ald3", $row);
            $this->assertArrayHasKey("ald3_detail", $row);
            $this->assertArrayHasKey("ald4", $row);
            $this->assertArrayHasKey("ald4_detail", $row);
            $this->assertArrayHasKey("poids", $row);
            $this->assertArrayHasKey("taille", $row);
            $this->assertArrayHasKey("perimetre", $row);
            $this->assertArrayHasKey("qpv", $row);
            $this->assertArrayHasKey("zrr", $row);
            $this->assertArrayHasKey("heures", $row);
            $this->assertArrayHasKey("mode", $row);
            $this->assertArrayHasKey("tm6", $row);
            $this->assertArrayHasKey("tm6_spo2_pre", $row);
            $this->assertArrayHasKey("tm6_spo2_post0min", $row);
            $this->assertArrayHasKey("tm6_spo2_post1min", $row);
            $this->assertArrayHasKey("tm6_spo2_post2min", $row);
            $this->assertArrayHasKey("tm6_fc_pre", $row);
            $this->assertArrayHasKey("tm6_fc_post0min", $row);
            $this->assertArrayHasKey("tm6_fc_post1min", $row);
            $this->assertArrayHasKey("tm6_fc_post2min", $row);
            $this->assertArrayHasKey("tm6_rpe", $row);
            $this->assertArrayHasKey("assis_debout", $row);
            $this->assertArrayHasKey("tupandgo", $row);
            $this->assertArrayHasKey("handgrip_md", $row);
            $this->assertArrayHasKey("handgrip_mnd", $row);
            $this->assertArrayHasKey("equilibre_pd", $row);
            $this->assertArrayHasKey("equilibre_pnd", $row);
            $this->assertArrayHasKey("flexion_tronc", $row);
            $this->assertArrayHasKey("q0", $row);
            $this->assertArrayHasKey("q1_fort", $row);
            $this->assertArrayHasKey("q1_modere", $row);
            $this->assertArrayHasKey("q2_fort", $row);
            $this->assertArrayHasKey("q2_modere", $row);
            $this->assertArrayHasKey("q3_fort", $row);
            $this->assertArrayHasKey("q3_modere", $row);
            $this->assertArrayHasKey("q4", $row);
            $this->assertArrayHasKey("q5_pied", $row);
            $this->assertArrayHasKey("q5_velo", $row);
            $this->assertArrayHasKey("q5_autre", $row);
            $this->assertArrayHasKey("q6_pied", $row);
            $this->assertArrayHasKey("q6_velo", $row);
            $this->assertArrayHasKey("q6_autre", $row);
            $this->assertArrayHasKey("q7_pied", $row);
            $this->assertArrayHasKey("q7_velo", $row);
            $this->assertArrayHasKey("q7_autre", $row);
            $this->assertArrayHasKey("q8", $row);
            $this->assertArrayHasKey("q9", $row);
            $this->assertArrayHasKey("q10", $row);
            $this->assertArrayHasKey("q11", $row);
            $this->assertArrayHasKey("q12", $row);
            $this->assertArrayHasKey("q13", $row);
            $this->assertArrayHasKey("q14_fort", $row);
            $this->assertArrayHasKey("q14_modere", $row);
            $this->assertArrayHasKey("q15_fort", $row);
            $this->assertArrayHasKey("q15_modere", $row);
            $this->assertArrayHasKey("q16_fort", $row);
            $this->assertArrayHasKey("q16_modere", $row);
            $this->assertArrayHasKey("q17_ecran", $row);
            $this->assertArrayHasKey("q17_autre", $row);
            $this->assertArrayHasKey("q18_ecran", $row);
            $this->assertArrayHasKey("q18_autre", $row);
            $this->assertArrayHasKey("q19_ecran", $row);
            $this->assertArrayHasKey("q19_autre", $row);
            $this->assertArrayHasKey("garnier_q1", $row);
            $this->assertArrayHasKey("garnier_q2", $row);
            $this->assertArrayHasKey("garnier_q3", $row);
            $this->assertArrayHasKey("garnier_q4", $row);
            $this->assertArrayHasKey("garnier_q5", $row);
            $this->assertArrayHasKey("garnier_q6", $row);
            $this->assertArrayHasKey("garnier_q7", $row);
            $this->assertArrayHasKey("garnier_q8", $row);
            $this->assertArrayHasKey("nap_min_score", $row);
            $this->assertArrayHasKey("nap_mets_score", $row);
            $this->assertArrayHasKey("sed_score", $row);
            $this->assertArrayHasKey("ps_score", $row);
        }
    }

    public function testReadOnapsDataForThalamusWithoutYearOKCoordonnateurMss2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_structure' => '4',
            'id_territoire' => '2',
            'id_statut_structure' => '1',
        ];
        $result = $this->export->readOnapsDataForThalamus($session);

        $this->assertIsArray($result);

        $expected_count = 0;// il y a 0 évaluation pour les patients de la structure 4
        $this->assertCount($expected_count, $result);
    }

    public function testReadOnapsDataForThalamusWithoutYearOKCoordonnateurNonMssMss1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2", // non MSS
            'id_territoire' => '1',
            'id_structure' => '2',
            'id_user' => '16',
        ];
        $result = $this->export->readOnapsDataForThalamus($session);

        $this->assertIsArray($result);

        $expected_count = 1;// il y a 1 évaluation pour les patients de la structure 2
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);

            $this->assertArrayHasKey("id_beneficiaire", $row);
            $this->assertArrayHasKey("date", $row);
            $this->assertArrayHasKey("rep_mesure", $row);
            $this->assertArrayHasKey("age", $row);
            $this->assertArrayHasKey("sexe", $row);
            $this->assertArrayHasKey("prescription", $row);
            $this->assertArrayHasKey("raison", $row);
            $this->assertArrayHasKey("raison_detail", $row);
            $this->assertArrayHasKey("ald1", $row);
            $this->assertArrayHasKey("ald1_detail", $row);
            $this->assertArrayHasKey("ald2", $row);
            $this->assertArrayHasKey("ald2_detail", $row);
            $this->assertArrayHasKey("ald3", $row);
            $this->assertArrayHasKey("ald3_detail", $row);
            $this->assertArrayHasKey("ald4", $row);
            $this->assertArrayHasKey("ald4_detail", $row);
            $this->assertArrayHasKey("poids", $row);
            $this->assertArrayHasKey("taille", $row);
            $this->assertArrayHasKey("perimetre", $row);
            $this->assertArrayHasKey("qpv", $row);
            $this->assertArrayHasKey("zrr", $row);
            $this->assertArrayHasKey("heures", $row);
            $this->assertArrayHasKey("mode", $row);
            $this->assertArrayHasKey("tm6", $row);
            $this->assertArrayHasKey("tm6_spo2_pre", $row);
            $this->assertArrayHasKey("tm6_spo2_post0min", $row);
            $this->assertArrayHasKey("tm6_spo2_post1min", $row);
            $this->assertArrayHasKey("tm6_spo2_post2min", $row);
            $this->assertArrayHasKey("tm6_fc_pre", $row);
            $this->assertArrayHasKey("tm6_fc_post0min", $row);
            $this->assertArrayHasKey("tm6_fc_post1min", $row);
            $this->assertArrayHasKey("tm6_fc_post2min", $row);
            $this->assertArrayHasKey("tm6_rpe", $row);
            $this->assertArrayHasKey("assis_debout", $row);
            $this->assertArrayHasKey("tupandgo", $row);
            $this->assertArrayHasKey("handgrip_md", $row);
            $this->assertArrayHasKey("handgrip_mnd", $row);
            $this->assertArrayHasKey("equilibre_pd", $row);
            $this->assertArrayHasKey("equilibre_pnd", $row);
            $this->assertArrayHasKey("flexion_tronc", $row);
            $this->assertArrayHasKey("q0", $row);
            $this->assertArrayHasKey("q1_fort", $row);
            $this->assertArrayHasKey("q1_modere", $row);
            $this->assertArrayHasKey("q2_fort", $row);
            $this->assertArrayHasKey("q2_modere", $row);
            $this->assertArrayHasKey("q3_fort", $row);
            $this->assertArrayHasKey("q3_modere", $row);
            $this->assertArrayHasKey("q4", $row);
            $this->assertArrayHasKey("q5_pied", $row);
            $this->assertArrayHasKey("q5_velo", $row);
            $this->assertArrayHasKey("q5_autre", $row);
            $this->assertArrayHasKey("q6_pied", $row);
            $this->assertArrayHasKey("q6_velo", $row);
            $this->assertArrayHasKey("q6_autre", $row);
            $this->assertArrayHasKey("q7_pied", $row);
            $this->assertArrayHasKey("q7_velo", $row);
            $this->assertArrayHasKey("q7_autre", $row);
            $this->assertArrayHasKey("q8", $row);
            $this->assertArrayHasKey("q9", $row);
            $this->assertArrayHasKey("q10", $row);
            $this->assertArrayHasKey("q11", $row);
            $this->assertArrayHasKey("q12", $row);
            $this->assertArrayHasKey("q13", $row);
            $this->assertArrayHasKey("q14_fort", $row);
            $this->assertArrayHasKey("q14_modere", $row);
            $this->assertArrayHasKey("q15_fort", $row);
            $this->assertArrayHasKey("q15_modere", $row);
            $this->assertArrayHasKey("q16_fort", $row);
            $this->assertArrayHasKey("q16_modere", $row);
            $this->assertArrayHasKey("q17_ecran", $row);
            $this->assertArrayHasKey("q17_autre", $row);
            $this->assertArrayHasKey("q18_ecran", $row);
            $this->assertArrayHasKey("q18_autre", $row);
            $this->assertArrayHasKey("q19_ecran", $row);
            $this->assertArrayHasKey("q19_autre", $row);
            $this->assertArrayHasKey("garnier_q1", $row);
            $this->assertArrayHasKey("garnier_q2", $row);
            $this->assertArrayHasKey("garnier_q3", $row);
            $this->assertArrayHasKey("garnier_q4", $row);
            $this->assertArrayHasKey("garnier_q5", $row);
            $this->assertArrayHasKey("garnier_q6", $row);
            $this->assertArrayHasKey("garnier_q7", $row);
            $this->assertArrayHasKey("garnier_q8", $row);
            $this->assertArrayHasKey("nap_min_score", $row);
            $this->assertArrayHasKey("nap_mets_score", $row);
            $this->assertArrayHasKey("sed_score", $row);
            $this->assertArrayHasKey("ps_score", $row);
        }
    }

    public function testReadOnapsDataForThalamusWithoutYearOKCoordonnateurNonMss2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2", // non MSS
            'id_territoire' => '1',
            'id_structure' => '4',
            'id_user' => '16',
        ];
        $result = $this->export->readOnapsDataForThalamus($session);

        $this->assertIsArray($result);

        $expected_count = 0;// il y a 0 évaluation pour les patients de la structure 4
        $this->assertCount($expected_count, $result);
    }

    public function testReadOnapsDataForThalamusWithoutYearOKEvaluateur1()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '7', // un évaluateur
        ];
        $result = $this->export->readOnapsDataForThalamus($session);
        $this->assertIsArray($result);
        $expected_count = 1; // il y a 1 patient (l'évaluateur n'a qu'un patient et le patient a 1 évaluation)
        $this->assertCount($expected_count, $result);

        //==============================
        // création évaluation initiale
        $id_user = $session['id_user'];
        $id_patient = "7";
        $id_type_eval = "1";
        $date_eval = "2022-07-28";

        // test physio
        $auto0 = "2"; // égal à "1" si le test a été réalisé
        $poids = "";
        $taille = "";
        $IMC = "";
        $tour_taille = "";
        $fcrepos = "";
        $satrepos = "";
        $borgrepos = "";
        $fcmax = "";
        $motif_test_physio = "1";

        // test Aptitude aerobie
        $auto1 = "2"; // égal à "1" si le test a été réalisé
        $dp = "";
        $fc1 = "";
        $fc2 = "";
        $fc3 = "";
        $fc4 = "";
        $fc5 = "";
        $fc6 = "";
        $fc7 = "";
        $fc8 = "";
        $fc9 = "";
        $sat1 = "";
        $sat2 = "";
        $sat3 = "";
        $sat4 = "";
        $sat5 = "";
        $sat6 = "";
        $sat7 = "";
        $sat8 = "";
        $sat9 = "";
        $borg1 = "";
        $borg2 = "";
        $borg3 = "";
        $borg4 = "";
        $borg5 = "";
        $borg6 = "";
        $borg7 = "";
        $borg8 = "";
        $borg9 = "";
        $com_aa = "";
        $motif_apt_aerobie = "2";

        // test up and go (non réalisé)
        $auto_up_and_go = "2"; // égal à "1" si le test a été réalisé
        $com_up_and_go = "";
        $duree_up_and_go = "";
        $motif_up_and_go = "3";

        // test Force musculaire membres supérieurs
        $auto2 = "2"; // égal à "1" si le test a été réalisé
        $com_fmms = "";
        $main_forte = "";
        $mg = "";
        $md = "";
        $motif_fmms = "4";

        // test Equilibre statique
        $auto3 = "2"; // égal à "1" si le test a été réalisé
        $com_eq = "";
        $pied_dominant = "";
        $pg = "";
        $pd = "";
        $motif_eq_stat = "1";

        // test Souplesse
        $auto4 = "2"; // égal à "1" si le test a été réalisé
        $com_soupl = "";
        $distance = "";
        $motif_soupl = "2";

        // test Mobilité Scapulo-Humérale
        $auto5 = "2"; // égal à "1" si le test a été réalisé
        $com_msh = "";
        $mgh = "";
        $mdh = "";
        $motif_mobilite_scapulo_humerale = "3";

        // test Endurance musculaire membres inférieurs
        $auto6 = "2"; // égal à "1" si le test a été réalisé
        $com_emmi = "";
        $nb_lever = "";
        $fc30 = "";
        $sat30 = "";
        $borg30 = "";
        $motif_end_musc_mb_inf = "4";

        $id_evaluation = $this->evaluation->create([
            'id_user' => $id_user,
            'id_patient' => $id_patient,
            'id_type_eval' => $id_type_eval,
            'date_eval' => $date_eval,

            // test physio
            'auto0' => $auto0,
            'poids' => $poids,
            'taille' => $taille,
            'IMC' => $IMC,
            'tour_taille' => $tour_taille,
            'fcrepos' => $fcrepos,
            'satrepos' => $satrepos,
            'borgrepos' => $borgrepos,
            'fcmax' => $fcmax,
            'motif_test_physio' => $motif_test_physio,

            // test Aptitude aerobie
            'auto1' => $auto1,
            'dp' => $dp,
            'fc1' => $fc1,
            'fc2' => $fc2,
            'fc3' => $fc3,
            'fc4' => $fc4,
            'fc5' => $fc5,
            'fc6' => $fc6,
            'fc7' => $fc7,
            'fc8' => $fc8,
            'fc9' => $fc9,
            'sat1' => $sat1,
            'sat2' => $sat2,
            'sat3' => $sat3,
            'sat4' => $sat4,
            'sat5' => $sat5,
            'sat6' => $sat6,
            'sat7' => $sat7,
            'sat8' => $sat8,
            'sat9' => $sat9,
            'borg1' => $borg1,
            'borg2' => $borg2,
            'borg3' => $borg3,
            'borg4' => $borg4,
            'borg5' => $borg5,
            'borg6' => $borg6,
            'borg7' => $borg7,
            'borg8' => $borg8,
            'borg9' => $borg9,
            'com_aa' => $com_aa,
            'motif_apt_aerobie' => $motif_apt_aerobie,

            // test up and go
            'auto-up-and-go' => $auto_up_and_go,
            'com-up-and-go' => $com_up_and_go,
            'duree-up-and-go' => $duree_up_and_go,
            'motif-up-and-go' => $motif_up_and_go,

            // test Force musculaire membres supérieurs
            'auto2' => $auto2,
            'com_fmms' => $com_fmms,
            'main_forte' => $main_forte,
            'mg' => $mg,
            'md' => $md,
            'motif_fmms' => $motif_fmms,

            // test Equilibre statique
            'auto3' => $auto3,
            'com_eq' => $com_eq,
            'pied-dominant' => $pied_dominant,
            'pg' => $pg,
            'pd' => $pd,
            'motif_eq_stat' => $motif_eq_stat,

            // test Souplesse
            'auto4' => $auto4,
            'com_soupl' => $com_soupl,
            //'membre' => "Majeur au sol",
            'distance' => $distance,
            'motif_soupl' => $motif_soupl,

            // test Mobilité Scapulo-Humérale
            'auto5' => $auto5,
            'com_msh' => $com_msh,
            'mgh' => $mgh,
            'mdh' => $mdh,
            'motif_mobilite_scapulo_humerale' => $motif_mobilite_scapulo_humerale,

            // test Endurance musculaire membres inférieurs
            'auto6' => $auto6,
            'com_emmi' => $com_emmi,
            'nb_lever' => $nb_lever,
            'fc30' => $fc30,
            'sat30' => $sat30,
            'borg30' => $borg30,
            'motif_end_musc_mb_inf' => $motif_end_musc_mb_inf
        ]);
        $this->assertNotFalse($id_evaluation, $this->evaluation->getErrorMessage());

        //==============================
        $result = $this->export->readOnapsDataForThalamus($session);
        $this->assertIsArray($result);
        $expected_count = 2; // il y a les 2 évals d'1 patient (l'évaluateur n'a qu'un patient)
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);

            $this->assertArrayHasKey("id_beneficiaire", $row);
            $this->assertArrayHasKey("date", $row);
            $this->assertArrayHasKey("rep_mesure", $row);
            $this->assertArrayHasKey("age", $row);
            $this->assertArrayHasKey("sexe", $row);
            $this->assertArrayHasKey("prescription", $row);
            $this->assertArrayHasKey("raison", $row);
            $this->assertArrayHasKey("raison_detail", $row);
            $this->assertArrayHasKey("ald1", $row);
            $this->assertArrayHasKey("ald1_detail", $row);
            $this->assertArrayHasKey("ald2", $row);
            $this->assertArrayHasKey("ald2_detail", $row);
            $this->assertArrayHasKey("ald3", $row);
            $this->assertArrayHasKey("ald3_detail", $row);
            $this->assertArrayHasKey("ald4", $row);
            $this->assertArrayHasKey("ald4_detail", $row);
            $this->assertArrayHasKey("poids", $row);
            $this->assertArrayHasKey("taille", $row);
            $this->assertArrayHasKey("perimetre", $row);
            $this->assertArrayHasKey("qpv", $row);
            $this->assertArrayHasKey("zrr", $row);
            $this->assertArrayHasKey("heures", $row);
            $this->assertArrayHasKey("mode", $row);
            $this->assertArrayHasKey("tm6", $row);
            $this->assertArrayHasKey("tm6_spo2_pre", $row);
            $this->assertArrayHasKey("tm6_spo2_post0min", $row);
            $this->assertArrayHasKey("tm6_spo2_post1min", $row);
            $this->assertArrayHasKey("tm6_spo2_post2min", $row);
            $this->assertArrayHasKey("tm6_fc_pre", $row);
            $this->assertArrayHasKey("tm6_fc_post0min", $row);
            $this->assertArrayHasKey("tm6_fc_post1min", $row);
            $this->assertArrayHasKey("tm6_fc_post2min", $row);
            $this->assertArrayHasKey("tm6_rpe", $row);
            $this->assertArrayHasKey("assis_debout", $row);
            $this->assertArrayHasKey("tupandgo", $row);
            $this->assertArrayHasKey("handgrip_md", $row);
            $this->assertArrayHasKey("handgrip_mnd", $row);
            $this->assertArrayHasKey("equilibre_pd", $row);
            $this->assertArrayHasKey("equilibre_pnd", $row);
            $this->assertArrayHasKey("flexion_tronc", $row);
            $this->assertArrayHasKey("q0", $row);
            $this->assertArrayHasKey("q1_fort", $row);
            $this->assertArrayHasKey("q1_modere", $row);
            $this->assertArrayHasKey("q2_fort", $row);
            $this->assertArrayHasKey("q2_modere", $row);
            $this->assertArrayHasKey("q3_fort", $row);
            $this->assertArrayHasKey("q3_modere", $row);
            $this->assertArrayHasKey("q4", $row);
            $this->assertArrayHasKey("q5_pied", $row);
            $this->assertArrayHasKey("q5_velo", $row);
            $this->assertArrayHasKey("q5_autre", $row);
            $this->assertArrayHasKey("q6_pied", $row);
            $this->assertArrayHasKey("q6_velo", $row);
            $this->assertArrayHasKey("q6_autre", $row);
            $this->assertArrayHasKey("q7_pied", $row);
            $this->assertArrayHasKey("q7_velo", $row);
            $this->assertArrayHasKey("q7_autre", $row);
            $this->assertArrayHasKey("q8", $row);
            $this->assertArrayHasKey("q9", $row);
            $this->assertArrayHasKey("q10", $row);
            $this->assertArrayHasKey("q11", $row);
            $this->assertArrayHasKey("q12", $row);
            $this->assertArrayHasKey("q13", $row);
            $this->assertArrayHasKey("q14_fort", $row);
            $this->assertArrayHasKey("q14_modere", $row);
            $this->assertArrayHasKey("q15_fort", $row);
            $this->assertArrayHasKey("q15_modere", $row);
            $this->assertArrayHasKey("q16_fort", $row);
            $this->assertArrayHasKey("q16_modere", $row);
            $this->assertArrayHasKey("q17_ecran", $row);
            $this->assertArrayHasKey("q17_autre", $row);
            $this->assertArrayHasKey("q18_ecran", $row);
            $this->assertArrayHasKey("q18_autre", $row);
            $this->assertArrayHasKey("q19_ecran", $row);
            $this->assertArrayHasKey("q19_autre", $row);
            $this->assertArrayHasKey("garnier_q1", $row);
            $this->assertArrayHasKey("garnier_q2", $row);
            $this->assertArrayHasKey("garnier_q3", $row);
            $this->assertArrayHasKey("garnier_q4", $row);
            $this->assertArrayHasKey("garnier_q5", $row);
            $this->assertArrayHasKey("garnier_q6", $row);
            $this->assertArrayHasKey("garnier_q7", $row);
            $this->assertArrayHasKey("garnier_q8", $row);
            $this->assertArrayHasKey("nap_min_score", $row);
            $this->assertArrayHasKey("nap_mets_score", $row);
            $this->assertArrayHasKey("sed_score", $row);
            $this->assertArrayHasKey("ps_score", $row);
        }
    }

    public function testReadOnapsDataForThalamusWithYearOK1()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsDataForThalamus($session, 2022);

        $expected_count = 3;// il y a 3 évaluations pour les patients arrivés en 2022 du territoire 1
        $this->assertCount($expected_count, $result);

        foreach ($result as $row) {
            $this->assertCount(87, $row);

            $this->assertArrayHasKey("id_beneficiaire", $row);
            $this->assertArrayHasKey("date", $row);
            $this->assertArrayHasKey("rep_mesure", $row);
            $this->assertArrayHasKey("age", $row);
            $this->assertArrayHasKey("sexe", $row);
            $this->assertArrayHasKey("prescription", $row);
            $this->assertArrayHasKey("raison", $row);
            $this->assertArrayHasKey("raison_detail", $row);
            $this->assertArrayHasKey("ald1", $row);
            $this->assertArrayHasKey("ald1_detail", $row);
            $this->assertArrayHasKey("ald2", $row);
            $this->assertArrayHasKey("ald2_detail", $row);
            $this->assertArrayHasKey("ald3", $row);
            $this->assertArrayHasKey("ald3_detail", $row);
            $this->assertArrayHasKey("ald4", $row);
            $this->assertArrayHasKey("ald4_detail", $row);
            $this->assertArrayHasKey("poids", $row);
            $this->assertArrayHasKey("taille", $row);
            $this->assertArrayHasKey("perimetre", $row);
            $this->assertArrayHasKey("qpv", $row);
            $this->assertArrayHasKey("zrr", $row);
            $this->assertArrayHasKey("heures", $row);
            $this->assertArrayHasKey("mode", $row);
            $this->assertArrayHasKey("tm6", $row);
            $this->assertArrayHasKey("tm6_spo2_pre", $row);
            $this->assertArrayHasKey("tm6_spo2_post0min", $row);
            $this->assertArrayHasKey("tm6_spo2_post1min", $row);
            $this->assertArrayHasKey("tm6_spo2_post2min", $row);
            $this->assertArrayHasKey("tm6_fc_pre", $row);
            $this->assertArrayHasKey("tm6_fc_post0min", $row);
            $this->assertArrayHasKey("tm6_fc_post1min", $row);
            $this->assertArrayHasKey("tm6_fc_post2min", $row);
            $this->assertArrayHasKey("tm6_rpe", $row);
            $this->assertArrayHasKey("assis_debout", $row);
            $this->assertArrayHasKey("tupandgo", $row);
            $this->assertArrayHasKey("handgrip_md", $row);
            $this->assertArrayHasKey("handgrip_mnd", $row);
            $this->assertArrayHasKey("equilibre_pd", $row);
            $this->assertArrayHasKey("equilibre_pnd", $row);
            $this->assertArrayHasKey("flexion_tronc", $row);
            $this->assertArrayHasKey("q0", $row);
            $this->assertArrayHasKey("q1_fort", $row);
            $this->assertArrayHasKey("q1_modere", $row);
            $this->assertArrayHasKey("q2_fort", $row);
            $this->assertArrayHasKey("q2_modere", $row);
            $this->assertArrayHasKey("q3_fort", $row);
            $this->assertArrayHasKey("q3_modere", $row);
            $this->assertArrayHasKey("q4", $row);
            $this->assertArrayHasKey("q5_pied", $row);
            $this->assertArrayHasKey("q5_velo", $row);
            $this->assertArrayHasKey("q5_autre", $row);
            $this->assertArrayHasKey("q6_pied", $row);
            $this->assertArrayHasKey("q6_velo", $row);
            $this->assertArrayHasKey("q6_autre", $row);
            $this->assertArrayHasKey("q7_pied", $row);
            $this->assertArrayHasKey("q7_velo", $row);
            $this->assertArrayHasKey("q7_autre", $row);
            $this->assertArrayHasKey("q8", $row);
            $this->assertArrayHasKey("q9", $row);
            $this->assertArrayHasKey("q10", $row);
            $this->assertArrayHasKey("q11", $row);
            $this->assertArrayHasKey("q12", $row);
            $this->assertArrayHasKey("q13", $row);
            $this->assertArrayHasKey("q14_fort", $row);
            $this->assertArrayHasKey("q14_modere", $row);
            $this->assertArrayHasKey("q15_fort", $row);
            $this->assertArrayHasKey("q15_modere", $row);
            $this->assertArrayHasKey("q16_fort", $row);
            $this->assertArrayHasKey("q16_modere", $row);
            $this->assertArrayHasKey("q17_ecran", $row);
            $this->assertArrayHasKey("q17_autre", $row);
            $this->assertArrayHasKey("q18_ecran", $row);
            $this->assertArrayHasKey("q18_autre", $row);
            $this->assertArrayHasKey("q19_ecran", $row);
            $this->assertArrayHasKey("q19_autre", $row);
            $this->assertArrayHasKey("garnier_q1", $row);
            $this->assertArrayHasKey("garnier_q2", $row);
            $this->assertArrayHasKey("garnier_q3", $row);
            $this->assertArrayHasKey("garnier_q4", $row);
            $this->assertArrayHasKey("garnier_q5", $row);
            $this->assertArrayHasKey("garnier_q6", $row);
            $this->assertArrayHasKey("garnier_q7", $row);
            $this->assertArrayHasKey("garnier_q8", $row);
            $this->assertArrayHasKey("nap_min_score", $row);
            $this->assertArrayHasKey("nap_mets_score", $row);
            $this->assertArrayHasKey("sed_score", $row);
            $this->assertArrayHasKey("ps_score", $row);
        }
    }

    public function testReadOnapsDataForThalamusWithYearOK2()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_structure' => '1',
            'id_territoire' => '1',
            'id_statut_structure' => '2',
        ];
        $result = $this->export->readOnapsDataForThalamus($session, 2000);

        $expected_count = 0;// il y a 0 évaluations pour les patients arrivés en 2000 du territoire 1
        $this->assertCount($expected_count, $result);
    }

    public function testReadPatientDataOKAdmin()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
            'id_structure' => null,
            'id_user' => '1', // un user quelconque
        ];

        $result = $this->export->readPatientData($session);
        $this->assertIsArray($result);

        $expected_count = $this->tester->grabNumRecords('patients');
        $this->assertCount($expected_count, $result);

        foreach ($result as $patient) {
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('date_naissance', $patient);
            $this->assertArrayHasKey('date_admission', $patient);
            $this->assertArrayHasKey('nom', $patient);
            $this->assertArrayHasKey('prenom', $patient);
            $this->assertArrayHasKey('tel_fixe', $patient);
            $this->assertArrayHasKey('tel_portable', $patient);
            $this->assertArrayHasKey('email', $patient);
            $this->assertArrayHasKey('nom_ville', $patient);
            $this->assertArrayHasKey('code_postal', $patient);
            $this->assertArrayHasKey('nom_adresse', $patient);
            $this->assertArrayHasKey('nom_prescripteur', $patient);
            $this->assertArrayHasKey('prenom_prescripteur', $patient);
            $this->assertArrayHasKey('nom_traitant', $patient);
            $this->assertArrayHasKey('prenom_traitant', $patient);
            $this->assertArrayHasKey('type_parcours', $patient);
            $this->assertArrayHasKey('nom_antenne', $patient);
            $this->assertArrayHasKey('alds', $patient);
        }
    }

    public function testReadPatientDataOKCoordoPeps()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $result = $this->export->readPatientData($session);
        $this->assertIsArray($result);

        $expected_count = $this->tester->grabNumRecords('patients', ['id_territoire' => $session['id_territoire']]);
        $this->assertCount($expected_count, $result);

        foreach ($result as $patient) {
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('date_naissance', $patient);
            $this->assertArrayHasKey('date_admission', $patient);
            $this->assertArrayHasKey('nom', $patient);
            $this->assertArrayHasKey('prenom', $patient);
            $this->assertArrayHasKey('tel_fixe', $patient);
            $this->assertArrayHasKey('tel_portable', $patient);
            $this->assertArrayHasKey('email', $patient);
            $this->assertArrayHasKey('nom_ville', $patient);
            $this->assertArrayHasKey('code_postal', $patient);
            $this->assertArrayHasKey('nom_adresse', $patient);
            $this->assertArrayHasKey('nom_prescripteur', $patient);
            $this->assertArrayHasKey('prenom_prescripteur', $patient);
            $this->assertArrayHasKey('nom_traitant', $patient);
            $this->assertArrayHasKey('prenom_traitant', $patient);
            $this->assertArrayHasKey('type_parcours', $patient);
            $this->assertArrayHasKey('nom_antenne', $patient);
            $this->assertArrayHasKey('alds', $patient);
        }
    }

    public function testReadPatientDataOKCoordoMss()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1", // MSS
            'id_territoire' => '1',
            'id_structure' => '8',
            'id_user' => '26',
        ];

        $result = $this->export->readPatientData($session);
        $this->assertIsArray($result);

        // 1 patient dans la structure
        // 1 patient dans une structure différente mais user est l'évaluateur
        $this->assertCount(2, $result);

        foreach ($result as $patient) {
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('date_naissance', $patient);
            $this->assertArrayHasKey('date_admission', $patient);
            $this->assertArrayHasKey('nom', $patient);
            $this->assertArrayHasKey('prenom', $patient);
            $this->assertArrayHasKey('tel_fixe', $patient);
            $this->assertArrayHasKey('tel_portable', $patient);
            $this->assertArrayHasKey('email', $patient);
            $this->assertArrayHasKey('nom_ville', $patient);
            $this->assertArrayHasKey('code_postal', $patient);
            $this->assertArrayHasKey('nom_adresse', $patient);
            $this->assertArrayHasKey('nom_prescripteur', $patient);
            $this->assertArrayHasKey('prenom_prescripteur', $patient);
            $this->assertArrayHasKey('nom_traitant', $patient);
            $this->assertArrayHasKey('prenom_traitant', $patient);
            $this->assertArrayHasKey('type_parcours', $patient);
            $this->assertArrayHasKey('nom_antenne', $patient);
            $this->assertArrayHasKey('alds', $patient);
        }
    }

    public function testReadPatientDataOKCoordoNonMss()
    {
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2", // non MSS
            'id_territoire' => '1',
            'id_structure' => '2',
            'id_user' => '16',
        ];

        $result = $this->export->readPatientData($session);
        $this->assertIsArray($result);

        // 1 patient dans la structure
        // 1 patient dans une structure différente mais user est l'évaluateur
        $this->assertCount(2, $result);

        foreach ($result as $patient) {
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('date_naissance', $patient);
            $this->assertArrayHasKey('date_admission', $patient);
            $this->assertArrayHasKey('nom', $patient);
            $this->assertArrayHasKey('prenom', $patient);
            $this->assertArrayHasKey('tel_fixe', $patient);
            $this->assertArrayHasKey('tel_portable', $patient);
            $this->assertArrayHasKey('email', $patient);
            $this->assertArrayHasKey('nom_ville', $patient);
            $this->assertArrayHasKey('code_postal', $patient);
            $this->assertArrayHasKey('nom_adresse', $patient);
            $this->assertArrayHasKey('nom_prescripteur', $patient);
            $this->assertArrayHasKey('prenom_prescripteur', $patient);
            $this->assertArrayHasKey('nom_traitant', $patient);
            $this->assertArrayHasKey('prenom_traitant', $patient);
            $this->assertArrayHasKey('type_parcours', $patient);
            $this->assertArrayHasKey('nom_antenne', $patient);
            $this->assertArrayHasKey('alds', $patient);
        }
    }

    public function testReadPatientDataOKEvaluateur()
    {
        $session = [
            'role_user_ids' => ['5'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "2",
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '7', // un évaluateur
        ];

        $result = $this->export->readPatientData($session);
        $this->assertIsArray($result);

        // 1 patient dont user est l'évaluateur
        $this->assertCount(1, $result);

        foreach ($result as $patient) {
            $this->assertArrayHasKey('id_patient', $patient);
            $this->assertArrayHasKey('date_naissance', $patient);
            $this->assertArrayHasKey('date_admission', $patient);
            $this->assertArrayHasKey('nom', $patient);
            $this->assertArrayHasKey('prenom', $patient);
            $this->assertArrayHasKey('tel_fixe', $patient);
            $this->assertArrayHasKey('tel_portable', $patient);
            $this->assertArrayHasKey('email', $patient);
            $this->assertArrayHasKey('nom_ville', $patient);
            $this->assertArrayHasKey('code_postal', $patient);
            $this->assertArrayHasKey('nom_adresse', $patient);
            $this->assertArrayHasKey('nom_prescripteur', $patient);
            $this->assertArrayHasKey('prenom_prescripteur', $patient);
            $this->assertArrayHasKey('nom_traitant', $patient);
            $this->assertArrayHasKey('prenom_traitant', $patient);
            $this->assertArrayHasKey('type_parcours', $patient);
            $this->assertArrayHasKey('nom_antenne', $patient);
            $this->assertArrayHasKey('alds', $patient);
        }
    }

    public function testReadPatientDataNotOKAutreRoles()
    {
        // intervenant
        $session = [
            'role_user_ids' => ['3'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "1",
            'id_territoire' => '1',
            'id_structure' => "1",
            'id_user' => '1', // un user quelconque
        ];

        $result = $this->export->readPatientData($session);
        $this->assertFalse($result);

        // responsable
        $session = [
            'role_user_ids' => ['6'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $result = $this->export->readPatientData($session);
        $this->assertFalse($result);

        // référent
        $session = [
            'role_user_ids' => ['4'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $result = $this->export->readPatientData($session);
        $this->assertFalse($result);

        // secrétaire
        $session = [
            'role_user_ids' => ['8'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_territoire' => '1',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];

        $result = $this->export->readPatientData($session);
        $this->assertFalse($result);

        // superviseur
        $session = [
            'role_user_ids' => ['7'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => "3", // non MSS
            'id_structure' => "1",
            'id_territoire' => "1",
        ];

        $result = $this->export->readPatientData($session);
        $this->assertFalse($result);
    }

    public function testReadPatientDataOKEmptyResult()
    {
        // coordo PEPS dans id_territoire=5 qui ne contient pas de patient
        $session = [
            'role_user_ids' => ['2'],
            'est_coordinateur_peps' => true,
            'id_statut_structure' => "2",
            'id_territoire' => '5',
            'id_structure' => '1',
            'id_user' => '1', // un user quelconque
        ];
        $result = $this->export->readPatientData($session);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testReadPatientDataOKId_territoireNull()
    {
        $session = [];
        $result = $this->export->readPatientData($session);

        $this->assertFalse($result);
    }
}