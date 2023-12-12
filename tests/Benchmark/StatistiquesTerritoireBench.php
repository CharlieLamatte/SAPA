<?php

namespace Sportsante86\Sapa\tests\Benchmark;

use Sportsante86\Sapa\Model\StatistiquesTerritoire;

class StatistiquesTerritoireBench
{
    private StatistiquesTerritoire $statistiquesTerritoire;

    public function __construct()
    {
        require './BDD/connexion.php';
        $this->statistiquesTerritoire = new StatistiquesTerritoire($bdd);
    }

    public function benchGetRepartitionAge()
    {
        $id_territoire = "1";
        $year = 2022;

        $this->statistiquesTerritoire->getRepartitionAge($id_territoire, $year);
    }

    public function benchGetNombreEntitites()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => "1",
        ];

        $this->statistiquesTerritoire->getNombreEntitites($session);
    }

    public function benchGetNombreOrientation()
    {
        $id_territoire = "1";
        $year = 2022;

        $this->statistiquesTerritoire->getNombreOrientation($id_territoire, $year);
    }

    public function benchGetAmeliorationTestAerobie()
    {
        $id_territoire = "1";
        $year = 2022;

        $this->statistiquesTerritoire->getAmeliorationTestAerobie($id_territoire, $year);
    }

    public function benchGetAmeliorationTestPhysio()
    {
        $id_territoire = "1";
        $year = 2022;

        $this->statistiquesTerritoire->getAmeliorationTestPhysio($id_territoire, $year);
    }

    public function benchGetAmeliorationTestForceMbSup()
    {
        $id_territoire = "1";
        $year = 2022;

        $this->statistiquesTerritoire->getAmeliorationTestForceMbSup($id_territoire, $year);
    }

    public function benchGetAmeliorationTestEquilibreStatique()
    {
        $id_territoire = "1";
        $year = 2022;

        $this->statistiquesTerritoire->getAmeliorationTestEquilibreStatique($id_territoire, $year);
    }

    public function benchGetAmeliorationTestSouplesse()
    {
        $id_territoire = "1";
        $year = 2022;

        $this->statistiquesTerritoire->getAmeliorationTestSouplesse($id_territoire, $year);
    }

    public function benchGetEvolutionTestMobiliteScapuloHumerale()
    {
        $id_territoire = "1";
        $year = 2022;

        $this->statistiquesTerritoire->getEvolutionTestMobiliteScapuloHumerale($id_territoire, $year);
    }

    public function benchGetEvolutionTestEnduranceMbInf()
    {
        $id_territoire = "1";
        $year = 2022;

        $this->statistiquesTerritoire->getEvolutionTestEnduranceMbInf($id_territoire, $year);
    }
}