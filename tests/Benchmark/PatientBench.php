<?php

namespace Sportsante86\Sapa\tests\Benchmark;

use Sportsante86\Sapa\Model\Patient;

class PatientBench
{
    private Patient $patient;

    public function __construct()
    {
        require './BDD/connexion.php';
        $this->patient = new Patient($bdd);
    }

    public function benchReadOne()
    {
        $this->patient->readOne("1");
    }

    public function benchReadAll()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => '1',
            'id_structure' => null,
            'id_user' => '1', // un user quelconque
        ];
        $est_archive = "0";

        $this->patient->readAll($session, $est_archive);
    }

    public function benchReadAllOriente()
    {
        $id_structure = '1';

        $this->patient->readAllOriente($id_structure);
    }

    public function benchReadAllBasic()
    {
        $id_territoire = "1";

        $this->patient->readAllBasic($id_territoire);
    }

    public function benchGetAllPatientEvaluationLate()
    {
        $today = "2022-06-23";

        $this->patient->getAllPatientEvaluationLate($today);
    }

    public function benchGetAge()
    {
        $id_patient = "1";

        $this->patient->getAge($id_patient);
    }
}