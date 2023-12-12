<?php

namespace Tests\Unit;

use Exception;
use Sportsante86\Sapa\Model\Evaluation;
use Tests\Support\UnitTester;

class EvaluationTest extends \Codeception\Test\Unit
{
    use \Codeception\AssertThrows;

    protected UnitTester $tester;

    private Evaluation $evaluation;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();
        $this->evaluation = new Evaluation($pdo);
        $this->assertNotNull($this->evaluation);
    }

    protected function _after()
    {
    }

    public function testDeleteAllEvaluationPatientOk()
    {
        $id_patient = '1';

        $evaluation_ids = $this->tester->grabColumnFromDatabase(
            'evaluations',
            'id_evaluation',
            ['id_patient' => $id_patient]
        );

        $this->evaluation->deleteAllEvaluationPatient($id_patient);

        $this->tester->dontSeeInDatabase('evaluations', [
            'id_patient' => $id_patient,
        ]);

        foreach ($evaluation_ids as $id_evaluation) {
            $this->tester->dontSeeInDatabase('eval_apt_aerobie', [
                'id_evaluation' => $id_evaluation,
            ]);
            $this->tester->dontSeeInDatabase('eval_endurance_musc_mb_inf', [
                'id_evaluation' => $id_evaluation,
            ]);
            $this->tester->dontSeeInDatabase('eval_eq_stat', [
                'id_evaluation' => $id_evaluation,
            ]);
            $this->tester->dontSeeInDatabase('eval_force_musc_mb_sup', [
                'id_evaluation' => $id_evaluation,
            ]);
            $this->tester->dontSeeInDatabase('eval_mobilite_scapulo_humerale', [
                'id_evaluation' => $id_evaluation,
            ]);
            $this->tester->dontSeeInDatabase('eval_soupl', [
                'id_evaluation' => $id_evaluation,
            ]);
            $this->tester->dontSeeInDatabase('eval_up_and_go', [
                'id_evaluation' => $id_evaluation,
            ]);
            $this->tester->dontSeeInDatabase('test_physio', [
                'id_evaluation' => $id_evaluation,
            ]);
        }
    }

    public function testDeleteAllEvaluationPatientNotOkId_patientNull()
    {
        $this->assertThrowsWithMessage(
            Exception::class,
            "Error missing id_patient",
            function () {
                $id_patient = null;
                $this->evaluation->deleteAllEvaluationPatient($id_patient);
            }
        );
    }

    public function testCreateOkAllEvaluationExceptUpAndGo()
    {
        $id_user = "1";
        $id_patient = "1";
        $id_type_eval = "1";
        $date_eval = "2022-07-28";

        // test physio
        $auto0 = "1"; // égal à "1" si le test a été réalisé
        $poids = "90.1";
        $taille = "91.2";
        $IMC = "22.3";
        $tour_taille = "93.4";
        $fcrepos = "94";
        $satrepos = "95.1";
        $borgrepos = "96.1";
        $fcmax = "190";
        $motif_test_physio = "";

        // test Aptitude aerobie
        $auto1 = "1"; // égal à "1" si le test a été réalisé
        $dp = "300";
        $fc1 = "101";
        $fc2 = "102";
        $fc3 = "103";
        $fc4 = "104";
        $fc5 = "105";
        $fc6 = "106";
        $fc7 = "107";
        $fc8 = "108";
        $fc9 = "109";
        $sat1 = "71.1";
        $sat2 = "72.1";
        $sat3 = "73.1";
        $sat4 = "74.1";
        $sat5 = "75.1";
        $sat6 = "76.1";
        $sat7 = "77.1";
        $sat8 = "78.1";
        $sat9 = "79.1";
        $borg1 = "0.1";
        $borg2 = "0.5";
        $borg3 = "1.1";
        $borg4 = "2.1";
        $borg5 = "3.1";
        $borg6 = "4.1";
        $borg7 = "5.1";
        $borg8 = "6.1";
        $borg9 = "7.1";
        $com_aa = "Com aa";
        $motif_apt_aerobie = "";

        // test up and go (non réalisé)
        $auto_up_and_go = "2"; // égal à "1" si le test a été réalisé
        $com_up_and_go = "";
        $duree_up_and_go = "";
        $motif_up_and_go = "";

        // test Force musculaire membres supérieurs
        $auto2 = "1"; // égal à "1" si le test a été réalisé
        $com_fmms = "Com fms";
        $main_forte = "droitier";
        $mg = "100.1";
        $md = "101.2";
        $motif_fmms = "";

        // test Equilibre statique
        $auto3 = "1"; // égal à "1" si le test a été réalisé
        $com_eq = "Com eq";
        $pied_dominant = "gauche";
        $pg = "102";
        $pd = "103";
        $motif_eq_stat = "";

        // test Souplesse
        $auto4 = "1"; // égal à "1" si le test a été réalisé
        $com_soupl = "Com soupl";
        $distance = "20";
        $motif_soupl = "";

        // test Mobilité Scapulo-Humérale
        $auto5 = "1"; // égal à "1" si le test a été réalisé
        $com_msh = "Com msh";
        $mgh = "10";
        $mdh = "11";
        $motif_mobilite_scapulo_humerale = "";

        // test Endurance musculaire membres inférieurs
        $auto6 = "1"; // égal à "1" si le test a été réalisé
        $com_emmi = "Com emi";
        $nb_lever = "30";
        $fc30 = "130";
        $sat30 = "99.1";
        $borg30 = "0.5";
        $motif_end_musc_mb_inf = "";

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

        $id_test_physio = $this->tester->grabFromDatabase(
            'test_physio',
            'id_test_physio',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_apt_aerobie = $this->tester->grabFromDatabase(
            'eval_apt_aerobie',
            'id_eval_apt_aerobie',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_up_and_go = $this->tester->grabFromDatabase(
            'eval_up_and_go',
            'id_eval_up_and_go',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_force_musc_mb_sup = $this->tester->grabFromDatabase(
            'eval_force_musc_mb_sup',
            'id_eval_force_musc_mb_sup',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_eq_stat = $this->tester->grabFromDatabase(
            'eval_eq_stat',
            'id_eval_eq_stat',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_soupl = $this->tester->grabFromDatabase(
            'eval_soupl',
            'id_eval_soupl',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_mobilite_scapulo_humerale = $this->tester->grabFromDatabase(
            'eval_mobilite_scapulo_humerale',
            'id_eval_mobilite_scapulo_humerale',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_end_musc_mb_inf = $this->tester->grabFromDatabase(
            'eval_endurance_musc_mb_inf',
            'id_eval_end_musc_mb_inf',
            ['id_evaluation' => $id_evaluation]
        );

        $this->tester->seeInDatabase('evaluations', [
            'id_patient' => $id_patient,
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,
            'id_user' => $id_user,
            'id_test_physio' => $id_test_physio,
            'id_evaluation_apt_aerobie' => $id_eval_apt_aerobie,
            'id_evaluation_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'id_evaluation_eq_stat' => $id_eval_eq_stat,
            'id_evaluation_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'id_evaluation_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'id_evaluation_soupl' => $id_eval_soupl,
            'id_eval_up_and_go' => null,
        ]);

        $this->tester->seeInDatabase('eval_apt_aerobie', [
            'id_evaluation' => $id_evaluation,
            'id_eval_apt_aerobie' => $id_eval_apt_aerobie,
            'distance_parcourue' => $dp,
            'com_apt_aerobie' => $com_aa,
            'fc1' => $fc1,
            'fc2' => $fc2,
            'fc3' => $fc3,
            'fc4' => $fc4,
            'fc5' => $fc5,
            'fc6' => $fc6,
            'fc7' => $fc7,
            'fc8' => $fc8,
            'fc9' => $fc9,
            'sat1 like' => $sat1,
            'sat2 like' => $sat2,
            'sat3 like' => $sat3,
            'sat4 like' => $sat4,
            'sat5 like' => $sat5,
            'sat6 like' => $sat6,
            'sat7 like' => $sat7,
            'sat8 like' => $sat8,
            'sat9 like' => $sat9,
            'borg1 like' => $borg1,
            'borg2 like' => $borg2,
            'borg3 like' => $borg3,
            'borg4 like' => $borg4,
            'borg5 like' => $borg5,
            'borg6 like' => $borg6,
            'borg7 like' => $borg7,
            'borg8 like' => $borg8,
            'borg9 like' => $borg9,
            'motif_apt_aerobie' => null,
        ]);
        $this->tester->seeInDatabase('eval_endurance_musc_mb_inf', [
            'id_evaluation' => $id_evaluation,
            'id_eval_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'nb_lever' => $nb_lever,
            'fc30' => $fc30,
            'sat30 like' => $sat30,
            'borg30 like' => $borg30,
            'com_end_musc_mb_inf' => $com_emmi,
            'motif_end_musc_mb_inf' => null,
        ]);
        $this->tester->seeInDatabase('eval_eq_stat', [
            'id_evaluation' => $id_evaluation,
            'id_eval_eq_stat' => $id_eval_eq_stat,
            'pied_gauche_sol' => $pg,
            'pied_droit_sol' => $pd,
            'pied_dominant' => $pied_dominant,
            'com_eq_stat' => $com_eq,
            'motif_eq_stat' => null,
        ]);
        $this->tester->seeInDatabase('eval_force_musc_mb_sup', [
            'id_evaluation' => $id_evaluation,
            'id_eval_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'com_fmms' => $com_fmms,
            'main_forte' => $main_forte,
            'mg like' => $mg,
            'md like' => $md,
            'motif_fmms' => null,
        ]);
        $this->tester->seeInDatabase('eval_mobilite_scapulo_humerale', [
            'id_evaluation' => $id_evaluation,
            'id_eval_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'main_gauche_haut' => $mgh,
            'main_droite_haut' => $mdh,
            'com_mobilite_scapulo_humerale' => $com_msh,
            'motif_mobilite_scapulo_humerale' => null,
        ]);
        $this->tester->seeInDatabase('eval_soupl', [
            'id_evaluation' => $id_evaluation,
            'id_eval_soupl' => $id_eval_soupl,
            'distance' => $distance,
            'com_soupl' => $com_soupl,
            'motif_soupl' => null,
        ]);
        $this->tester->seeInDatabase('test_physio', [
            'id_evaluation' => $id_evaluation,
            'id_test_physio' => $id_test_physio,
            'poids like' => $poids,
            'taille like' => $taille,
            'IMC like' => $IMC,
            'tour_taille like' => $tour_taille,
            'fc_repos' => $fcrepos,
            'saturation_repos like' => $satrepos,
            'borg_repos like' => $borgrepos,
            'fc_max_mesuree' => $fcmax,
            'motif_test_physio' => null,
            //'fc_max_theo' => $fc_max_theo,
        ]);
        $this->tester->dontSeeInDatabase('eval_up_and_go', [
            'id_evaluation' => $id_evaluation,
        ]);
    }

    public function testCreateOkOnlyUpAndGo()
    {
        $id_user = "1";
        $id_patient = "1";
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
        $auto_up_and_go = "1"; // égal à "1" si le test a été réalisé
        $com_up_and_go = "Com up";
        $duree_up_and_go = "20";
        $motif_up_and_go = "";

        // test Force musculaire membres supérieurs
        $auto2 = "2"; // égal à "1" si le test a été réalisé
        $com_fmms = "";
        $main_forte = "";
        $mg = "";
        $md = "";
        $motif_fmms = "3";

        // test Equilibre statique
        $auto3 = "2"; // égal à "1" si le test a été réalisé
        $com_eq = "";
        $pied_dominant = "";
        $pg = "";
        $pd = "";
        $motif_eq_stat = "4";

        // test Souplesse
        $auto4 = "2"; // égal à "1" si le test a été réalisé
        $com_soupl = "";
        $distance = "";
        $motif_soupl = "1";

        // test Mobilité Scapulo-Humérale
        $auto5 = "2"; // égal à "1" si le test a été réalisé
        $com_msh = "";
        $mgh = "";
        $mdh = "";
        $motif_mobilite_scapulo_humerale = "2";

        // test Endurance musculaire membres inférieurs
        $auto6 = "2"; // égal à "1" si le test a été réalisé
        $com_emmi = "";
        $nb_lever = "";
        $fc30 = "";
        $sat30 = "";
        $borg30 = "";
        $motif_end_musc_mb_inf = "3";

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

        $id_test_physio = $this->tester->grabFromDatabase(
            'test_physio',
            'id_test_physio',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_apt_aerobie = $this->tester->grabFromDatabase(
            'eval_apt_aerobie',
            'id_eval_apt_aerobie',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_up_and_go = $this->tester->grabFromDatabase(
            'eval_up_and_go',
            'id_eval_up_and_go',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_force_musc_mb_sup = $this->tester->grabFromDatabase(
            'eval_force_musc_mb_sup',
            'id_eval_force_musc_mb_sup',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_eq_stat = $this->tester->grabFromDatabase(
            'eval_eq_stat',
            'id_eval_eq_stat',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_soupl = $this->tester->grabFromDatabase(
            'eval_soupl',
            'id_eval_soupl',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_mobilite_scapulo_humerale = $this->tester->grabFromDatabase(
            'eval_mobilite_scapulo_humerale',
            'id_eval_mobilite_scapulo_humerale',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_end_musc_mb_inf = $this->tester->grabFromDatabase(
            'eval_endurance_musc_mb_inf',
            'id_eval_end_musc_mb_inf',
            ['id_evaluation' => $id_evaluation]
        );

        $this->tester->seeInDatabase('evaluations', [
            'id_patient' => $id_patient,
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,
            'id_user' => $id_user,
            'id_test_physio' => $id_test_physio,
            'id_evaluation_apt_aerobie' => $id_eval_apt_aerobie,
            'id_evaluation_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'id_evaluation_eq_stat' => $id_eval_eq_stat,
            'id_evaluation_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'id_evaluation_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'id_evaluation_soupl' => $id_eval_soupl,
            'id_eval_up_and_go' => $id_eval_up_and_go,
        ]);

        $this->tester->seeInDatabase('eval_apt_aerobie', [
            'id_evaluation' => $id_evaluation,
            'id_eval_apt_aerobie' => $id_eval_apt_aerobie,
            'distance_parcourue' => null,
            'com_apt_aerobie' => null,
            'fc1' => null,
            'fc2' => null,
            'fc3' => null,
            'fc4' => null,
            'fc5' => null,
            'fc6' => null,
            'fc7' => null,
            'fc8' => null,
            'fc9' => null,
            'sat1' => null,
            'sat2' => null,
            'sat3' => null,
            'sat4' => null,
            'sat5' => null,
            'sat6' => null,
            'sat7' => null,
            'sat8' => null,
            'sat9' => null,
            'borg1' => null,
            'borg2' => null,
            'borg3' => null,
            'borg4' => null,
            'borg5' => null,
            'borg6' => null,
            'borg7' => null,
            'borg8' => null,
            'borg9' => null,
            'motif_apt_aerobie' => $motif_apt_aerobie,
        ]);
        $this->tester->seeInDatabase('eval_endurance_musc_mb_inf', [
            'id_evaluation' => $id_evaluation,
            'id_eval_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'nb_lever' => null,
            'fc30' => null,
            'sat30' => null,
            'borg30' => null,
            'com_end_musc_mb_inf' => null,
            'motif_end_musc_mb_inf' => $motif_end_musc_mb_inf,
        ]);
        $this->tester->seeInDatabase('eval_eq_stat', [
            'id_evaluation' => $id_evaluation,
            'id_eval_eq_stat' => $id_eval_eq_stat,
            'pied_gauche_sol' => null,
            'pied_droit_sol' => null,
            'pied_dominant' => null,
            'com_eq_stat' => null,
            'motif_eq_stat' => $motif_eq_stat,
        ]);
        $this->tester->seeInDatabase('eval_force_musc_mb_sup', [
            'id_evaluation' => $id_evaluation,
            'id_eval_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'com_fmms' => null,
            'main_forte' => null,
            'mg' => null,
            'md' => null,
            'motif_fmms' => $motif_fmms,
        ]);
        $this->tester->seeInDatabase('eval_mobilite_scapulo_humerale', [
            'id_evaluation' => $id_evaluation,
            'id_eval_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'main_gauche_haut' => null,
            'main_droite_haut' => null,
            'com_mobilite_scapulo_humerale' => null,
            'motif_mobilite_scapulo_humerale' => $motif_mobilite_scapulo_humerale,
        ]);
        $this->tester->seeInDatabase('eval_soupl', [
            'id_evaluation' => $id_evaluation,
            'id_eval_soupl' => $id_eval_soupl,
            'distance' => null,
            'com_soupl' => null,
            'motif_soupl' => $motif_soupl,
        ]);
        $this->tester->seeInDatabase('test_physio', [
            'id_evaluation' => $id_evaluation,
            'id_test_physio' => $id_test_physio,
            'poids' => null,
            'taille' => null,
            'IMC' => null,
            'tour_taille' => null,
            'fc_repos' => null,
            'saturation_repos' => null,
            'borg_repos' => null,
            'fc_max_mesuree' => null,
            'motif_test_physio' => $motif_test_physio,
            //'fc_max_theo' => $fc_max_theo,
        ]);
        $this->tester->seeInDatabase('eval_up_and_go', [
            'id_evaluation' => $id_evaluation,
            'id_eval_up_and_go' => $id_eval_up_and_go,
            'duree' => $duree_up_and_go,
            'commentaire' => $com_up_and_go,
            'id_motif' => null,
        ]);
    }

    public function testCreateOkNoEvaluationDone()
    {
        $id_user = "1";
        $id_patient = "1";
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

        $id_test_physio = $this->tester->grabFromDatabase(
            'test_physio',
            'id_test_physio',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_apt_aerobie = $this->tester->grabFromDatabase(
            'eval_apt_aerobie',
            'id_eval_apt_aerobie',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_up_and_go = $this->tester->grabFromDatabase(
            'eval_up_and_go',
            'id_eval_up_and_go',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_force_musc_mb_sup = $this->tester->grabFromDatabase(
            'eval_force_musc_mb_sup',
            'id_eval_force_musc_mb_sup',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_eq_stat = $this->tester->grabFromDatabase(
            'eval_eq_stat',
            'id_eval_eq_stat',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_soupl = $this->tester->grabFromDatabase(
            'eval_soupl',
            'id_eval_soupl',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_mobilite_scapulo_humerale = $this->tester->grabFromDatabase(
            'eval_mobilite_scapulo_humerale',
            'id_eval_mobilite_scapulo_humerale',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_end_musc_mb_inf = $this->tester->grabFromDatabase(
            'eval_endurance_musc_mb_inf',
            'id_eval_end_musc_mb_inf',
            ['id_evaluation' => $id_evaluation]
        );

        $this->tester->seeInDatabase('evaluations', [
            'id_patient' => $id_patient,
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,
            'id_user' => $id_user,
            'id_test_physio' => $id_test_physio,
            'id_evaluation_apt_aerobie' => $id_eval_apt_aerobie,
            'id_evaluation_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'id_evaluation_eq_stat' => $id_eval_eq_stat,
            'id_evaluation_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'id_evaluation_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'id_evaluation_soupl' => $id_eval_soupl,
            'id_eval_up_and_go' => $id_eval_up_and_go,
        ]);

        $this->tester->seeInDatabase('eval_apt_aerobie', [
            'id_evaluation' => $id_evaluation,
            'id_eval_apt_aerobie' => $id_eval_apt_aerobie,
            'distance_parcourue' => null,
            'com_apt_aerobie' => null,
            'fc1' => null,
            'fc2' => null,
            'fc3' => null,
            'fc4' => null,
            'fc5' => null,
            'fc6' => null,
            'fc7' => null,
            'fc8' => null,
            'fc9' => null,
            'sat1' => null,
            'sat2' => null,
            'sat3' => null,
            'sat4' => null,
            'sat5' => null,
            'sat6' => null,
            'sat7' => null,
            'sat8' => null,
            'sat9' => null,
            'borg1' => null,
            'borg2' => null,
            'borg3' => null,
            'borg4' => null,
            'borg5' => null,
            'borg6' => null,
            'borg7' => null,
            'borg8' => null,
            'borg9' => null,
            'motif_apt_aerobie' => $motif_apt_aerobie,
        ]);
        $this->tester->seeInDatabase('eval_endurance_musc_mb_inf', [
            'id_evaluation' => $id_evaluation,
            'id_eval_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'nb_lever' => null,
            'fc30' => null,
            'sat30' => null,
            'borg30' => null,
            'com_end_musc_mb_inf' => null,
            'motif_end_musc_mb_inf' => $motif_end_musc_mb_inf,
        ]);
        $this->tester->seeInDatabase('eval_eq_stat', [
            'id_evaluation' => $id_evaluation,
            'id_eval_eq_stat' => $id_eval_eq_stat,
            'pied_gauche_sol' => null,
            'pied_droit_sol' => null,
            'pied_dominant' => null,
            'com_eq_stat' => null,
            'motif_eq_stat' => $motif_eq_stat,
        ]);
        $this->tester->seeInDatabase('eval_force_musc_mb_sup', [
            'id_evaluation' => $id_evaluation,
            'id_eval_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'com_fmms' => null,
            'main_forte' => null,
            'mg' => null,
            'md' => null,
            'motif_fmms' => $motif_fmms,
        ]);
        $this->tester->seeInDatabase('eval_mobilite_scapulo_humerale', [
            'id_evaluation' => $id_evaluation,
            'id_eval_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'main_gauche_haut' => null,
            'main_droite_haut' => null,
            'com_mobilite_scapulo_humerale' => null,
            'motif_mobilite_scapulo_humerale' => $motif_mobilite_scapulo_humerale,
        ]);
        $this->tester->seeInDatabase('eval_soupl', [
            'id_evaluation' => $id_evaluation,
            'id_eval_soupl' => $id_eval_soupl,
            'distance' => null,
            'com_soupl' => null,
            'motif_soupl' => $motif_soupl,
        ]);
        $this->tester->seeInDatabase('test_physio', [
            'id_evaluation' => $id_evaluation,
            'id_test_physio' => $id_test_physio,
            'poids' => null,
            'taille' => null,
            'IMC' => null,
            'tour_taille' => null,
            'fc_repos' => null,
            'saturation_repos' => null,
            'borg_repos' => null,
            'fc_max_mesuree' => null,
            'motif_test_physio' => $motif_test_physio,
            //'fc_max_theo' => $fc_max_theo,
        ]);
        $this->tester->seeInDatabase('eval_up_and_go', [
            'id_evaluation' => $id_evaluation,
            'id_eval_up_and_go' => $id_eval_up_and_go,
            'duree' => null,
            'commentaire' => null,
            'id_motif' => $motif_up_and_go,
        ]);
    }

    public function testCreateNotOkId_userNull()
    {
        $id_user = null;
        $id_patient = "1";
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
        $this->assertFalse($id_evaluation, $this->evaluation->getErrorMessage());
    }

    public function testCreateNotOkId_patientNull()
    {
        $id_user = "1";
        $id_patient = null;
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
        $this->assertFalse($id_evaluation, $this->evaluation->getErrorMessage());
    }

    public function testCreateNotOkId_type_evalNull()
    {
        $id_user = "1";
        $id_patient = "1";
        $id_type_eval = null;
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
        $this->assertFalse($id_evaluation, $this->evaluation->getErrorMessage());
    }

    public function testCreateNotOkDate_evalNull()
    {
        $id_user = "1";
        $id_patient = "1";
        $id_type_eval = "1";
        $date_eval = null;

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
        $this->assertFalse($id_evaluation, $this->evaluation->getErrorMessage());
    }

    function testUpdateOkAllEvaluationDoneExceptUpAndGoToNoEvaluationDone()
    {
        // known data
        $id_patient = "1";
        $id_type_eval = "6";
        $id_user = "2";

        $id_evaluation = "1";
        $date_eval = "2022-07-26";

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

        $update_ok = $this->evaluation->update([
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,

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
        $this->assertTrue($update_ok, $this->evaluation->getErrorMessage());

        $id_test_physio = $this->tester->grabFromDatabase(
            'test_physio',
            'id_test_physio',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_apt_aerobie = $this->tester->grabFromDatabase(
            'eval_apt_aerobie',
            'id_eval_apt_aerobie',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_up_and_go = $this->tester->grabFromDatabase(
            'eval_up_and_go',
            'id_eval_up_and_go',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_force_musc_mb_sup = $this->tester->grabFromDatabase(
            'eval_force_musc_mb_sup',
            'id_eval_force_musc_mb_sup',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_eq_stat = $this->tester->grabFromDatabase(
            'eval_eq_stat',
            'id_eval_eq_stat',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_soupl = $this->tester->grabFromDatabase(
            'eval_soupl',
            'id_eval_soupl',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_mobilite_scapulo_humerale = $this->tester->grabFromDatabase(
            'eval_mobilite_scapulo_humerale',
            'id_eval_mobilite_scapulo_humerale',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_end_musc_mb_inf = $this->tester->grabFromDatabase(
            'eval_endurance_musc_mb_inf',
            'id_eval_end_musc_mb_inf',
            ['id_evaluation' => $id_evaluation]
        );

        $this->tester->seeInDatabase('evaluations', [
            'id_patient' => $id_patient,
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,
            'id_user' => $id_user,
            'id_test_physio' => $id_test_physio,
            'id_evaluation_apt_aerobie' => $id_eval_apt_aerobie,
            'id_evaluation_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'id_evaluation_eq_stat' => $id_eval_eq_stat,
            'id_evaluation_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'id_evaluation_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'id_evaluation_soupl' => $id_eval_soupl,
            'id_eval_up_and_go' => $id_eval_up_and_go,
        ]);

        $this->tester->seeInDatabase('eval_apt_aerobie', [
            'id_evaluation' => $id_evaluation,
            'id_eval_apt_aerobie' => $id_eval_apt_aerobie,
            'distance_parcourue' => null,
            'com_apt_aerobie' => null,
            'fc1' => null,
            'fc2' => null,
            'fc3' => null,
            'fc4' => null,
            'fc5' => null,
            'fc6' => null,
            'fc7' => null,
            'fc8' => null,
            'fc9' => null,
            'sat1' => null,
            'sat2' => null,
            'sat3' => null,
            'sat4' => null,
            'sat5' => null,
            'sat6' => null,
            'sat7' => null,
            'sat8' => null,
            'sat9' => null,
            'borg1' => null,
            'borg2' => null,
            'borg3' => null,
            'borg4' => null,
            'borg5' => null,
            'borg6' => null,
            'borg7' => null,
            'borg8' => null,
            'borg9' => null,
            'motif_apt_aerobie' => $motif_apt_aerobie,
        ]);
        $this->tester->seeInDatabase('eval_endurance_musc_mb_inf', [
            'id_evaluation' => $id_evaluation,
            'id_eval_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'nb_lever' => null,
            'fc30' => null,
            'sat30' => null,
            'borg30' => null,
            'com_end_musc_mb_inf' => null,
            'motif_end_musc_mb_inf' => $motif_end_musc_mb_inf,
        ]);
        $this->tester->seeInDatabase('eval_eq_stat', [
            'id_evaluation' => $id_evaluation,
            'id_eval_eq_stat' => $id_eval_eq_stat,
            'pied_gauche_sol' => null,
            'pied_droit_sol' => null,
            'pied_dominant' => null,
            'com_eq_stat' => null,
            'motif_eq_stat' => $motif_eq_stat,
        ]);
        $this->tester->seeInDatabase('eval_force_musc_mb_sup', [
            'id_evaluation' => $id_evaluation,
            'id_eval_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'com_fmms' => null,
            'main_forte' => null,
            'mg' => null,
            'md' => null,
            'motif_fmms' => $motif_fmms,
        ]);
        $this->tester->seeInDatabase('eval_mobilite_scapulo_humerale', [
            'id_evaluation' => $id_evaluation,
            'id_eval_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'main_gauche_haut' => null,
            'main_droite_haut' => null,
            'com_mobilite_scapulo_humerale' => null,
            'motif_mobilite_scapulo_humerale' => $motif_mobilite_scapulo_humerale,
        ]);
        $this->tester->seeInDatabase('eval_soupl', [
            'id_evaluation' => $id_evaluation,
            'id_eval_soupl' => $id_eval_soupl,
            'distance' => null,
            'com_soupl' => null,
            'motif_soupl' => $motif_soupl,
        ]);
        $this->tester->seeInDatabase('test_physio', [
            'id_evaluation' => $id_evaluation,
            'id_test_physio' => $id_test_physio,
            'poids' => null,
            'taille' => null,
            'IMC' => null,
            'tour_taille' => null,
            'fc_repos' => null,
            'saturation_repos' => null,
            'borg_repos' => null,
            'fc_max_mesuree' => null,
            'motif_test_physio' => $motif_test_physio,
            //'fc_max_theo' => $fc_max_theo,
        ]);
        $this->tester->seeInDatabase('eval_up_and_go', [
            'id_evaluation' => $id_evaluation,
            'id_eval_up_and_go' => $id_eval_up_and_go,
            'duree' => null,
            'commentaire' => null,
            'id_motif' => $motif_up_and_go,
        ]);
    }

    function testUpdateOkAllEvaluationDoneExceptUpAndGoToNoEvaluationDoneExceptAptitudeAerobie()
    {
        // known data
        $id_patient = "1";
        $id_type_eval = "8";
        $id_user = "2";

        $id_evaluation = "1";
        $date_eval = "2022-07-26";

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
        $auto1 = "1"; // égal à "1" si le test a été réalisé
        $dp = "121";
        $fc1 = "121";
        $fc2 = "121";
        $fc3 = "121";
        $fc4 = "121";
        $fc5 = "121";
        $fc6 = "121";
        $fc7 = "121";
        $fc8 = "121";
        $fc9 = "121";
        $sat1 = "97.1";
        $sat2 = "97.2";
        $sat3 = "97.3";
        $sat4 = "97.4";
        $sat5 = "97.5";
        $sat6 = "97.6";
        $sat7 = "97.7";
        $sat8 = "97.8";
        $sat9 = "97.9";
        $borg1 = "1.1";
        $borg2 = "1.2";
        $borg3 = "1.3";
        $borg4 = "1.4";
        $borg5 = "1.5";
        $borg6 = "1.6";
        $borg7 = "1.7";
        $borg8 = "1.8";
        $borg9 = "1.9";
        $com_aa = "ff";
        $motif_apt_aerobie = "";

        // test up and go
        $auto_up_and_go = "2"; // égal à "1" si le test a été réalisé
        $com_up_and_go = "";
        $duree_up_and_go = "";
        $motif_up_and_go = "";

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

        $update_ok = $this->evaluation->update([
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,

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
        $this->assertTrue($update_ok, $this->evaluation->getErrorMessage());

        $id_test_physio = $this->tester->grabFromDatabase(
            'test_physio',
            'id_test_physio',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_apt_aerobie = $this->tester->grabFromDatabase(
            'eval_apt_aerobie',
            'id_eval_apt_aerobie',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_up_and_go = $this->tester->grabFromDatabase(
            'eval_up_and_go',
            'id_eval_up_and_go',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_force_musc_mb_sup = $this->tester->grabFromDatabase(
            'eval_force_musc_mb_sup',
            'id_eval_force_musc_mb_sup',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_eq_stat = $this->tester->grabFromDatabase(
            'eval_eq_stat',
            'id_eval_eq_stat',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_soupl = $this->tester->grabFromDatabase(
            'eval_soupl',
            'id_eval_soupl',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_mobilite_scapulo_humerale = $this->tester->grabFromDatabase(
            'eval_mobilite_scapulo_humerale',
            'id_eval_mobilite_scapulo_humerale',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_end_musc_mb_inf = $this->tester->grabFromDatabase(
            'eval_endurance_musc_mb_inf',
            'id_eval_end_musc_mb_inf',
            ['id_evaluation' => $id_evaluation]
        );

        $this->tester->seeInDatabase('evaluations', [
            'id_patient' => $id_patient,
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,
            'id_user' => $id_user,
            'id_test_physio' => $id_test_physio,
            'id_evaluation_apt_aerobie' => $id_eval_apt_aerobie,
            'id_evaluation_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'id_evaluation_eq_stat' => $id_eval_eq_stat,
            'id_evaluation_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'id_evaluation_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'id_evaluation_soupl' => $id_eval_soupl,
            'id_eval_up_and_go' => null,
        ]);

        $this->tester->seeInDatabase('eval_apt_aerobie', [
            'id_evaluation' => $id_evaluation,
            'id_eval_apt_aerobie' => $id_eval_apt_aerobie,
            'distance_parcourue' => $dp,
            'com_apt_aerobie' => $com_aa,
            'fc1' => $fc1,
            'fc2' => $fc2,
            'fc3' => $fc3,
            'fc4' => $fc4,
            'fc5' => $fc5,
            'fc6' => $fc6,
            'fc7' => $fc7,
            'fc8' => $fc8,
            'fc9' => $fc9,
            'sat1 like' => $sat1,
            'sat2 like' => $sat2,
            'sat3 like' => $sat3,
            'sat4 like' => $sat4,
            'sat5 like' => $sat5,
            'sat6 like' => $sat6,
            'sat7 like' => $sat7,
            'sat8 like' => $sat8,
            'sat9 like' => $sat9,
            'borg1 like' => $borg1,
            'borg2 like' => $borg2,
            'borg3 like' => $borg3,
            'borg4 like' => $borg4,
            'borg5 like' => $borg5,
            'borg6 like' => $borg6,
            'borg7 like' => $borg7,
            'borg8 like' => $borg8,
            'borg9 like' => $borg9,
            'motif_apt_aerobie' => null,
        ]);
        $this->tester->seeInDatabase('eval_endurance_musc_mb_inf', [
            'id_evaluation' => $id_evaluation,
            'id_eval_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'nb_lever' => null,
            'fc30' => null,
            'sat30' => null,
            'borg30' => null,
            'com_end_musc_mb_inf' => null,
            'motif_end_musc_mb_inf' => $motif_end_musc_mb_inf,
        ]);
        $this->tester->seeInDatabase('eval_eq_stat', [
            'id_evaluation' => $id_evaluation,
            'id_eval_eq_stat' => $id_eval_eq_stat,
            'pied_gauche_sol' => null,
            'pied_droit_sol' => null,
            'pied_dominant' => null,
            'com_eq_stat' => null,
            'motif_eq_stat' => $motif_eq_stat,
        ]);
        $this->tester->seeInDatabase('eval_force_musc_mb_sup', [
            'id_evaluation' => $id_evaluation,
            'id_eval_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'com_fmms' => null,
            'main_forte' => null,
            'mg' => null,
            'md' => null,
            'motif_fmms' => $motif_fmms,
        ]);
        $this->tester->seeInDatabase('eval_mobilite_scapulo_humerale', [
            'id_evaluation' => $id_evaluation,
            'id_eval_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'main_gauche_haut' => null,
            'main_droite_haut' => null,
            'com_mobilite_scapulo_humerale' => null,
            'motif_mobilite_scapulo_humerale' => $motif_mobilite_scapulo_humerale,
        ]);
        $this->tester->seeInDatabase('eval_soupl', [
            'id_evaluation' => $id_evaluation,
            'id_eval_soupl' => $id_eval_soupl,
            'distance' => null,
            'com_soupl' => null,
            'motif_soupl' => $motif_soupl,
        ]);
        $this->tester->seeInDatabase('test_physio', [
            'id_evaluation' => $id_evaluation,
            'id_test_physio' => $id_test_physio,
            'poids' => null,
            'taille' => null,
            'IMC' => null,
            'tour_taille' => null,
            'fc_repos' => null,
            'saturation_repos' => null,
            'borg_repos' => null,
            'fc_max_mesuree' => null,
            'motif_test_physio' => $motif_test_physio,
            //'fc_max_theo' => $fc_max_theo,
        ]);
        $this->tester->dontSeeInDatabase('eval_up_and_go', [
            'id_evaluation' => $id_evaluation,
        ]);
    }

    function testUpdateOkNoEvaluationDoneToAllEvaluationDoneExceptUpAndGo()
    {
        // known data
        $id_user = "22";
        $id_patient = "4";
        $id_type_eval = "9";

        $id_evaluation = "3";
        $date_eval = "2022-07-28";

        // test physio
        $auto0 = "1"; // égal à "1" si le test a été réalisé
        $poids = "90.1";
        $taille = "91.2";
        $IMC = "22.3";
        $tour_taille = "93.4";
        $fcrepos = "94";
        $satrepos = "95.1";
        $borgrepos = "96.1";
        $fcmax = "190";
        $motif_test_physio = "";

        // test Aptitude aerobie
        $auto1 = "1"; // égal à "1" si le test a été réalisé
        $dp = "300";
        $fc1 = "101";
        $fc2 = "102";
        $fc3 = "103";
        $fc4 = "104";
        $fc5 = "105";
        $fc6 = "106";
        $fc7 = "107";
        $fc8 = "108";
        $fc9 = "109";
        $sat1 = "71.1";
        $sat2 = "72.1";
        $sat3 = "73.1";
        $sat4 = "74.1";
        $sat5 = "75.1";
        $sat6 = "76.1";
        $sat7 = "77.1";
        $sat8 = "78.1";
        $sat9 = "79.1";
        $borg1 = "0.1";
        $borg2 = "0.5";
        $borg3 = "1.1";
        $borg4 = "2.1";
        $borg5 = "3.1";
        $borg6 = "4.1";
        $borg7 = "5.1";
        $borg8 = "6.1";
        $borg9 = "7.1";
        $com_aa = "Com aa";
        $motif_apt_aerobie = "";

        // test up and go (non réalisé)
        $auto_up_and_go = "2"; // égal à "1" si le test a été réalisé
        $com_up_and_go = "";
        $duree_up_and_go = "";
        $motif_up_and_go = "";

        // test Force musculaire membres supérieurs
        $auto2 = "1"; // égal à "1" si le test a été réalisé
        $com_fmms = "Com fms";
        $main_forte = "droitier";
        $mg = "100.1";
        $md = "101.2";
        $motif_fmms = "";

        // test Equilibre statique
        $auto3 = "1"; // égal à "1" si le test a été réalisé
        $com_eq = "Com eq";
        $pied_dominant = "gauche";
        $pg = "102";
        $pd = "103";
        $motif_eq_stat = "";

        // test Souplesse
        $auto4 = "1"; // égal à "1" si le test a été réalisé
        $com_soupl = "Com soupl";
        $distance = "20";
        $motif_soupl = "";

        // test Mobilité Scapulo-Humérale
        $auto5 = "1"; // égal à "1" si le test a été réalisé
        $com_msh = "Com msh";
        $mgh = "10";
        $mdh = "11";
        $motif_mobilite_scapulo_humerale = "";

        // test Endurance musculaire membres inférieurs
        $auto6 = "1"; // égal à "1" si le test a été réalisé
        $com_emmi = "Com emi";
        $nb_lever = "30";
        $fc30 = "130";
        $sat30 = "99.1";
        $borg30 = "0.5";
        $motif_end_musc_mb_inf = "";

        $update_ok = $this->evaluation->update([
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,

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
        $this->assertTrue($update_ok, $this->evaluation->getErrorMessage());

        $id_test_physio = $this->tester->grabFromDatabase(
            'test_physio',
            'id_test_physio',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_apt_aerobie = $this->tester->grabFromDatabase(
            'eval_apt_aerobie',
            'id_eval_apt_aerobie',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_up_and_go = $this->tester->grabFromDatabase(
            'eval_up_and_go',
            'id_eval_up_and_go',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_force_musc_mb_sup = $this->tester->grabFromDatabase(
            'eval_force_musc_mb_sup',
            'id_eval_force_musc_mb_sup',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_eq_stat = $this->tester->grabFromDatabase(
            'eval_eq_stat',
            'id_eval_eq_stat',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_soupl = $this->tester->grabFromDatabase(
            'eval_soupl',
            'id_eval_soupl',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_mobilite_scapulo_humerale = $this->tester->grabFromDatabase(
            'eval_mobilite_scapulo_humerale',
            'id_eval_mobilite_scapulo_humerale',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_end_musc_mb_inf = $this->tester->grabFromDatabase(
            'eval_endurance_musc_mb_inf',
            'id_eval_end_musc_mb_inf',
            ['id_evaluation' => $id_evaluation]
        );

        $this->tester->seeInDatabase('evaluations', [
            'id_patient' => $id_patient,
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,
            'id_user' => $id_user,
            'id_test_physio' => $id_test_physio,
            'id_evaluation_apt_aerobie' => $id_eval_apt_aerobie,
            'id_evaluation_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'id_evaluation_eq_stat' => $id_eval_eq_stat,
            'id_evaluation_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'id_evaluation_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'id_evaluation_soupl' => $id_eval_soupl,
            'id_eval_up_and_go' => null,
        ]);

        $this->tester->seeInDatabase('eval_apt_aerobie', [
            'id_evaluation' => $id_evaluation,
            'id_eval_apt_aerobie' => $id_eval_apt_aerobie,
            'distance_parcourue' => $dp,
            'com_apt_aerobie' => $com_aa,
            'fc1' => $fc1,
            'fc2' => $fc2,
            'fc3' => $fc3,
            'fc4' => $fc4,
            'fc5' => $fc5,
            'fc6' => $fc6,
            'fc7' => $fc7,
            'fc8' => $fc8,
            'fc9' => $fc9,
            'sat1 like' => $sat1,
            'sat2 like' => $sat2,
            'sat3 like' => $sat3,
            'sat4 like' => $sat4,
            'sat5 like' => $sat5,
            'sat6 like' => $sat6,
            'sat7 like' => $sat7,
            'sat8 like' => $sat8,
            'sat9 like' => $sat9,
            'borg1 like' => $borg1,
            'borg2 like' => $borg2,
            'borg3 like' => $borg3,
            'borg4 like' => $borg4,
            'borg5 like' => $borg5,
            'borg6 like' => $borg6,
            'borg7 like' => $borg7,
            'borg8 like' => $borg8,
            'borg9 like' => $borg9,
            'motif_apt_aerobie' => null,
        ]);
        $this->tester->seeInDatabase('eval_endurance_musc_mb_inf', [
            'id_evaluation' => $id_evaluation,
            'id_eval_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'nb_lever' => $nb_lever,
            'fc30' => $fc30,
            'sat30 like' => $sat30,
            'borg30 like' => $borg30,
            'com_end_musc_mb_inf' => $com_emmi,
            'motif_end_musc_mb_inf' => null,
        ]);
        $this->tester->seeInDatabase('eval_eq_stat', [
            'id_evaluation' => $id_evaluation,
            'id_eval_eq_stat' => $id_eval_eq_stat,
            'pied_gauche_sol' => $pg,
            'pied_droit_sol' => $pd,
            'pied_dominant' => $pied_dominant,
            'com_eq_stat' => $com_eq,
            'motif_eq_stat' => null,
        ]);
        $this->tester->seeInDatabase('eval_force_musc_mb_sup', [
            'id_evaluation' => $id_evaluation,
            'id_eval_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'com_fmms' => $com_fmms,
            'main_forte' => $main_forte,
            'mg like' => $mg,
            'md like' => $md,
            'motif_fmms' => null,
        ]);
        $this->tester->seeInDatabase('eval_mobilite_scapulo_humerale', [
            'id_evaluation' => $id_evaluation,
            'id_eval_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'main_gauche_haut' => $mgh,
            'main_droite_haut' => $mdh,
            'com_mobilite_scapulo_humerale' => $com_msh,
            'motif_mobilite_scapulo_humerale' => null,
        ]);
        $this->tester->seeInDatabase('eval_soupl', [
            'id_evaluation' => $id_evaluation,
            'id_eval_soupl' => $id_eval_soupl,
            'distance' => $distance,
            'com_soupl' => $com_soupl,
            'motif_soupl' => null,
        ]);
        $this->tester->seeInDatabase('test_physio', [
            'id_evaluation' => $id_evaluation,
            'id_test_physio' => $id_test_physio,
            'poids like' => $poids,
            'taille like' => $taille,
            'IMC like' => $IMC,
            'tour_taille like' => $tour_taille,
            'fc_repos' => $fcrepos,
            'saturation_repos like' => $satrepos,
            'borg_repos like' => $borgrepos,
            'fc_max_mesuree' => $fcmax,
            'motif_test_physio' => null,
            //'fc_max_theo' => $fc_max_theo,
        ]);
        $this->tester->dontSeeInDatabase('eval_up_and_go', [
            'id_evaluation' => $id_evaluation,
        ]);
    }

    function testUpdateOkNoEvaluationDoneToAllEvaluationDoneExceptAptitudeAerobie()
    {
        // known data
        $id_user = "22";
        $id_patient = "4";
        $id_type_eval = "7";

        $id_evaluation = "3";
        $date_eval = "2022-07-28";

        // test physio
        $auto0 = "1"; // égal à "1" si le test a été réalisé
        $poids = "90.1";
        $taille = "91.2";
        $IMC = "22.3";
        $tour_taille = "93.4";
        $fcrepos = "94";
        $satrepos = "95.1";
        $borgrepos = "96.1";
        $fcmax = "190";
        $motif_test_physio = "";

        // test Aptitude aerobie
        $auto1 = "2"; // égal à "1" si le test a été réalisé
        $dp = "300";
        $fc1 = "101";
        $fc2 = "102";
        $fc3 = "103";
        $fc4 = "104";
        $fc5 = "105";
        $fc6 = "106";
        $fc7 = "107";
        $fc8 = "108";
        $fc9 = "109";
        $sat1 = "71.1";
        $sat2 = "72.1";
        $sat3 = "73.1";
        $sat4 = "74.1";
        $sat5 = "75.1";
        $sat6 = "76.1";
        $sat7 = "77.1";
        $sat8 = "78.1";
        $sat9 = "79.1";
        $borg1 = "0.1";
        $borg2 = "0.5";
        $borg3 = "1.1";
        $borg4 = "2.1";
        $borg5 = "3.1";
        $borg6 = "4.1";
        $borg7 = "5.1";
        $borg8 = "6.1";
        $borg9 = "7.1";
        $com_aa = "Com aa";
        $motif_apt_aerobie = "3";

        // test up and go (non réalisé)
        $auto_up_and_go = "1"; // égal à "1" si le test a été réalisé
        $com_up_and_go = "Com up";
        $duree_up_and_go = "30";
        $motif_up_and_go = "";

        // test Force musculaire membres supérieurs
        $auto2 = "1"; // égal à "1" si le test a été réalisé
        $com_fmms = "Com fms";
        $main_forte = "droitier";
        $mg = "100.1";
        $md = "101.2";
        $motif_fmms = "";

        // test Equilibre statique
        $auto3 = "1"; // égal à "1" si le test a été réalisé
        $com_eq = "Com eq";
        $pied_dominant = "gauche";
        $pg = "102";
        $pd = "103";
        $motif_eq_stat = "";

        // test Souplesse
        $auto4 = "1"; // égal à "1" si le test a été réalisé
        $com_soupl = "Com soupl";
        $distance = "20";
        $motif_soupl = "";

        // test Mobilité Scapulo-Humérale
        $auto5 = "1"; // égal à "1" si le test a été réalisé
        $com_msh = "Com msh";
        $mgh = "10";
        $mdh = "11";
        $motif_mobilite_scapulo_humerale = "";

        // test Endurance musculaire membres inférieurs
        $auto6 = "1"; // égal à "1" si le test a été réalisé
        $com_emmi = "Com emi";
        $nb_lever = "30";
        $fc30 = "130";
        $sat30 = "99.1";
        $borg30 = "0.5";
        $motif_end_musc_mb_inf = "";

        $update_ok = $this->evaluation->update([
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,

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
        $this->assertTrue($update_ok, $this->evaluation->getErrorMessage());

        $id_test_physio = $this->tester->grabFromDatabase(
            'test_physio',
            'id_test_physio',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_apt_aerobie = $this->tester->grabFromDatabase(
            'eval_apt_aerobie',
            'id_eval_apt_aerobie',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_up_and_go = $this->tester->grabFromDatabase(
            'eval_up_and_go',
            'id_eval_up_and_go',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_force_musc_mb_sup = $this->tester->grabFromDatabase(
            'eval_force_musc_mb_sup',
            'id_eval_force_musc_mb_sup',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_eq_stat = $this->tester->grabFromDatabase(
            'eval_eq_stat',
            'id_eval_eq_stat',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_soupl = $this->tester->grabFromDatabase(
            'eval_soupl',
            'id_eval_soupl',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_mobilite_scapulo_humerale = $this->tester->grabFromDatabase(
            'eval_mobilite_scapulo_humerale',
            'id_eval_mobilite_scapulo_humerale',
            ['id_evaluation' => $id_evaluation]
        );
        $id_eval_end_musc_mb_inf = $this->tester->grabFromDatabase(
            'eval_endurance_musc_mb_inf',
            'id_eval_end_musc_mb_inf',
            ['id_evaluation' => $id_evaluation]
        );

        $this->tester->seeInDatabase('evaluations', [
            'id_patient' => $id_patient,
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,
            'id_user' => $id_user,
            'id_test_physio' => $id_test_physio,
            'id_evaluation_apt_aerobie' => $id_eval_apt_aerobie,
            'id_evaluation_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'id_evaluation_eq_stat' => $id_eval_eq_stat,
            'id_evaluation_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'id_evaluation_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'id_evaluation_soupl' => $id_eval_soupl,
            'id_eval_up_and_go' => $id_eval_up_and_go,
        ]);

        $this->tester->seeInDatabase('eval_apt_aerobie', [
            'id_evaluation' => $id_evaluation,
            'id_eval_apt_aerobie' => $id_eval_apt_aerobie,
            'distance_parcourue' => null,
            'com_apt_aerobie' => null,
            'fc1' => null,
            'fc2' => null,
            'fc3' => null,
            'fc4' => null,
            'fc5' => null,
            'fc6' => null,
            'fc7' => null,
            'fc8' => null,
            'fc9' => null,
            'sat1' => null,
            'sat2' => null,
            'sat3' => null,
            'sat4' => null,
            'sat5' => null,
            'sat6' => null,
            'sat7' => null,
            'sat8' => null,
            'sat9' => null,
            'borg1' => null,
            'borg2' => null,
            'borg3' => null,
            'borg4' => null,
            'borg5' => null,
            'borg6' => null,
            'borg7' => null,
            'borg8' => null,
            'borg9' => null,
            'motif_apt_aerobie' => $motif_apt_aerobie,
        ]);
        $this->tester->seeInDatabase('eval_endurance_musc_mb_inf', [
            'id_evaluation' => $id_evaluation,
            'id_eval_end_musc_mb_inf' => $id_eval_end_musc_mb_inf,
            'nb_lever' => $nb_lever,
            'fc30' => $fc30,
            'sat30 like' => $sat30,
            'borg30 like' => $borg30,
            'com_end_musc_mb_inf' => $com_emmi,
            'motif_end_musc_mb_inf' => null,
        ]);
        $this->tester->seeInDatabase('eval_eq_stat', [
            'id_evaluation' => $id_evaluation,
            'id_eval_eq_stat' => $id_eval_eq_stat,
            'pied_gauche_sol' => $pg,
            'pied_droit_sol' => $pd,
            'pied_dominant' => $pied_dominant,
            'com_eq_stat' => $com_eq,
            'motif_eq_stat' => null,
        ]);
        $this->tester->seeInDatabase('eval_force_musc_mb_sup', [
            'id_evaluation' => $id_evaluation,
            'id_eval_force_musc_mb_sup' => $id_eval_force_musc_mb_sup,
            'com_fmms' => $com_fmms,
            'main_forte' => $main_forte,
            'mg like' => $mg,
            'md like' => $md,
            'motif_fmms' => null,
        ]);
        $this->tester->seeInDatabase('eval_mobilite_scapulo_humerale', [
            'id_evaluation' => $id_evaluation,
            'id_eval_mobilite_scapulo_humerale' => $id_eval_mobilite_scapulo_humerale,
            'main_gauche_haut' => $mgh,
            'main_droite_haut' => $mdh,
            'com_mobilite_scapulo_humerale' => $com_msh,
            'motif_mobilite_scapulo_humerale' => null,
        ]);
        $this->tester->seeInDatabase('eval_soupl', [
            'id_evaluation' => $id_evaluation,
            'id_eval_soupl' => $id_eval_soupl,
            'distance' => $distance,
            'com_soupl' => $com_soupl,
            'motif_soupl' => null,
        ]);
        $this->tester->seeInDatabase('test_physio', [
            'id_evaluation' => $id_evaluation,
            'id_test_physio' => $id_test_physio,
            'poids like' => $poids,
            'taille like' => $taille,
            'IMC like' => $IMC,
            'tour_taille like' => $tour_taille,
            'fc_repos' => $fcrepos,
            'saturation_repos like' => $satrepos,
            'borg_repos like' => $borgrepos,
            'fc_max_mesuree' => $fcmax,
            'motif_test_physio' => null,
            //'fc_max_theo' => $fc_max_theo,
        ]);
        $this->tester->seeInDatabase('eval_up_and_go', [
            'id_evaluation' => $id_evaluation,
            'id_eval_up_and_go' => $id_eval_up_and_go,
            'duree' => $duree_up_and_go,
            'commentaire' => $com_up_and_go,
            'id_motif' => null,
        ]);
    }

    function testUpdateOkIncompleteIdsInEvaluation()
    {
    }

    function testUpdateNotOkId_evaluationNull()
    {
        // known data
        $id_patient = "1";
        $id_type_eval = "1";
        $id_user = "2";

        $id_evaluation = null;
        $date_eval = "2022-07-26";

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

        $update_ok = $this->evaluation->update([
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,

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
        $this->assertFalse($update_ok, $this->evaluation->getErrorMessage());
    }

    function testUpdateNotOkDate_evalNull()
    {
        // known data
        $id_patient = "1";
        $id_type_eval = "1";
        $id_user = "2";

        $id_evaluation = "1";
        $date_eval = null;

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

        $update_ok = $this->evaluation->update([
            'id_evaluation' => $id_evaluation,
            'date_eval' => $date_eval,
            'id_type_eval' => $id_type_eval,

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
        $this->assertFalse($update_ok, $this->evaluation->getErrorMessage());
    }
}