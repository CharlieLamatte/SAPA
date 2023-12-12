<?php

namespace Sportsante86\Sapa\tests\Acceptance;

use Faker\Factory;
use Sportsante86\Sapa\tests\Support\Page\Acceptance\Sante;
use Tests\Support\AcceptanceTester;
use Tests\Support\Page\Acceptance\Login;

class ModifyPathologiesSanteCest
{
    private $faker;

    public function _before(AcceptanceTester $I)
    {
        // use the factory to create a Faker\Generator instance
        $this->faker = Factory::create('fr_FR');
        $this->faker->seed(435);
    }

    public function modifyPatientAsCoordonnateurPepsAllTrue(
        AcceptanceTester $I,
        Login $loginPage,
        Sante $sante
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $sante->modifyPathologies([
            'id_patient' => "1",
            'a_patho_cardio' => "1",
            'a_patho_respiratoire' => "1",
            'a_patho_metabolique' => "1",
            'a_patho_osteo_articulaire' => "1",
            'a_patho_psycho_social' => "1",
            'a_patho_neuro' => "1",
            'a_patho_cancero' => "1",
            'a_patho_circulatoire' => "1",
            'a_patho_autre' => "1",

            'cardio' => $this->faker->text(2000),
            'respiratoire' => $this->faker->text(2000),
            'metabolique' => $this->faker->text(2000),
            'osteo_articulaire' => $this->faker->text(2000),
            'psycho_social' => $this->faker->text(2000),
            'neuro' => $this->faker->text(2000),
            'cancero' => $this->faker->text(2000),
            'circulatoire' => $this->faker->text(2000),
            'autre' => $this->faker->text(2000),
        ]);
    }

    public function modifyPatientAsCoordonnateurPepsAllFalse(
        AcceptanceTester $I,
        Login $loginPage,
        Sante $sante
    ) {
        $loginPage->login('testcoord1@sportsante86.fr', 'testcoord1.1@A');
        $sante->modifyPathologies([
            'id_patient' => "1",
            'a_patho_cardio' => "0",
            'a_patho_respiratoire' => "0",
            'a_patho_metabolique' => "0",
            'a_patho_osteo_articulaire' => "0",
            'a_patho_psycho_social' => "0",
            'a_patho_neuro' => "0",
            'a_patho_cancero' => "0",
            'a_patho_circulatoire' => "0",
            'a_patho_autre' => "0",

            'cardio' => $this->faker->text(2000),
            'respiratoire' => $this->faker->text(2000),
            'metabolique' => $this->faker->text(2000),
            'osteo_articulaire' => $this->faker->text(2000),
            'psycho_social' => $this->faker->text(2000),
            'neuro' => $this->faker->text(2000),
            'cancero' => $this->faker->text(2000),
            'circulatoire' => $this->faker->text(2000),
            'autre' => $this->faker->text(2000),
        ]);
    }
}