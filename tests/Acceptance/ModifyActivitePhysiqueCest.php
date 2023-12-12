<?php

namespace Sportsante86\Sapa\tests\Acceptance;

use Faker\Factory;
use Sportsante86\Sapa\tests\Support\Page\Acceptance\ActivitePhysique;
use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\Login;

class ModifyActivitePhysiqueCest
{
    private $faker;

    private $heuresIds = [
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
        "10",
        "11",
        "12",
        "13",
        "14",
        "15",
        "16",
        "17",
        "18",
        "19",
        "20",
        "21",
        "22",
        "23",
        "24",
        "25",
        "26",
        "27",
        "28",
        "29",
        "30",
        "31",
        "32",
        "33",
        "34",
        "35",
        "36",
        "37",
        "38",
        "39",
        "40",
        "41",
        "42",
        "43",
        "44",
        "45",
        "46",
        "47",
        "48",
        "49",
        "50",
        "51",
        "52",
        "53",
        "54",
        "55",
        "56",
        "57",
        "58",
        "59",
        "60",
        "61",
        "62",
        "63",
        "64",
        "65",
        "66",
        "67",
        "68",
        "69",
    ];

    public function _before(AcceptanceTester $I)
    {
        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(435);
    }

    public function modifyPatientAsCoordonnateurPepsAllTrue(
        AcceptanceTester $I,
        Login $loginPage,
        ActivitePhysique $ap
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $ap->modifyActivites([
            'id_patient' => "8",
            'a_activite_anterieure' => "1",
            'a_activite_autonome' => "1",
            'a_activite_encadree' => "1",
            'a_activite_envisagee' => "1",
            'a_activite_frein' => "1",
            'a_activite_point_fort_levier' => "1",

            'activite_physique_autonome' => $this->faker->text(2000),
            'activite_physique_encadree' => $this->faker->text(2000),
            'activite_anterieure' => $this->faker->text(2000),
            'frein_activite' => $this->faker->text(2000),
            'activite_envisagee' => $this->faker->text(2000),
            'point_fort_levier' => $this->faker->text(2000),
            'disponibilite' => $this->faker->text(2000),

            'est_dispo_lundi' => "1",
            'est_dispo_mardi' => "1",
            'est_dispo_mercredi' => "1",
            'est_dispo_jeudi' => "1",
            'est_dispo_vendredi' => "1",
            'est_dispo_samedi' => "1",
            'est_dispo_dimanche' => "1",

            'heure_debut_lundi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_mardi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_mercredi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_jeudi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_vendredi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_samedi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_dimanche' => $this->faker->randomElement($this->heuresIds),

            'heure_fin_lundi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_mardi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_mercredi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_jeudi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_vendredi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_samedi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_dimanche' => $this->faker->randomElement($this->heuresIds),
        ]);
    }

    public function modifyPatientAsCoordonnateurPepsAllFalse(
        AcceptanceTester $I,
        Login $loginPage,
        ActivitePhysique $ap
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $ap->modifyActivites([
            'id_patient' => "8",
            'a_activite_anterieure' => "0",
            'a_activite_autonome' => "0",
            'a_activite_encadree' => "0",
            'a_activite_envisagee' => "0",
            'a_activite_frein' => "0",
            'a_activite_point_fort_levier' => "0",

            'activite_physique_autonome' => $this->faker->text(2000),
            'activite_physique_encadree' => $this->faker->text(2000),
            'activite_anterieure' => $this->faker->text(2000),
            'frein_activite' => $this->faker->text(2000),
            'activite_envisagee' => $this->faker->text(2000),
            'point_fort_levier' => $this->faker->text(2000),
            'disponibilite' => $this->faker->text(2000),

            'est_dispo_lundi' => "0",
            'est_dispo_mardi' => "0",
            'est_dispo_mercredi' => "0",
            'est_dispo_jeudi' => "0",
            'est_dispo_vendredi' => "0",
            'est_dispo_samedi' => "0",
            'est_dispo_dimanche' => "0",

            'heure_debut_lundi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_mardi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_mercredi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_jeudi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_vendredi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_samedi' => $this->faker->randomElement($this->heuresIds),
            'heure_debut_dimanche' => $this->faker->randomElement($this->heuresIds),

            'heure_fin_lundi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_mardi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_mercredi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_jeudi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_vendredi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_samedi' => $this->faker->randomElement($this->heuresIds),
            'heure_fin_dimanche' => $this->faker->randomElement($this->heuresIds),
        ]);
    }
}