<?php

namespace Sportsante86\Sapa\tests\Benchmark;

use Sportsante86\Sapa\Model\Territoire;

class TerritoireBench
{
    private Territoire $territoire;

    public function __construct()
    {
        require './BDD/connexion.php';
        $this->territoire = new Territoire($bdd);
    }

    public function benchReadOne()
    {
        $this->territoire->readOne("1");
    }

    public function benchReadAll()
    {
        $session = [
            'role_user_ids' => ['1'],
            'est_coordinateur_peps' => false,
            'id_statut_structure' => null,
            'id_territoire' => "1",
        ];

        $this->territoire->readAll($session);
    }

    public function benchReadAllUnfiltered()
    {
        $this->territoire->readAllUnfiltered();
    }
}