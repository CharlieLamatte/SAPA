<?php

namespace Tests\Unit;

use PDO;
use Sportsante86\Sapa\Model\Questionnaire;
use Tests\Support\UnitTester;

class QuestionnaireTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private PDO $pdo;
    private Questionnaire $questionnaire;

    protected function _before()
    {
        $this->pdo = $this->getModule('Db')->_getDbh();;
        $this->questionnaire = new Questionnaire($this->pdo);
        $this->assertNotNull($this->questionnaire);
    }

    protected function _after()
    {
    }

    public function testCreateOkQuestionnaireOpaq()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = "1";
        $date = "2022-10-01";
        $reponses = [
            ["nom_type_reponse" => "bool", "id_question" => "1", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "2", "reponse" => "1"],
            ["nom_type_reponse" => "int", "id_question" => "6", "reponse" => "3"],
            ["nom_type_reponse" => "int", "id_question" => "7", "reponse" => "5"],
            ["nom_type_reponse" => "int", "id_question" => "9", "reponse" => "45"],
            ["nom_type_reponse" => "int", "id_question" => "10", "reponse" => "985"],
            ["nom_type_reponse" => "int", "id_question" => "11", "reponse" => "17"],
            ["nom_type_reponse" => "bool", "id_question" => "13", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "14", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "15", "reponse" => "1"],
            ["nom_type_reponse" => "int", "id_question" => "17", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "18", "reponse" => "4"],
            ["nom_type_reponse" => "int", "id_question" => "19", "reponse" => "6"],
            ["nom_type_reponse" => "int", "id_question" => "21", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "22", "reponse" => "16"],
            ["nom_type_reponse" => "int", "id_question" => "23", "reponse" => "150"],
            ["nom_type_reponse" => "bool", "id_question" => "24", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "25", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "26", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "27", "reponse" => "1"],
            ["nom_type_reponse" => "int", "id_question" => "28", "reponse" => "3"],
            ["nom_type_reponse" => "int", "id_question" => "29", "reponse" => "42"],
            ["nom_type_reponse" => "bool", "id_question" => "31", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "32", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "34", "reponse" => "3"],
            ["nom_type_reponse" => "int", "id_question" => "35", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "37", "reponse" => "16"],
            ["nom_type_reponse" => "int", "id_question" => "38", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "40", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "41", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "43", "reponse" => "4"],
            ["nom_type_reponse" => "int", "id_question" => "44", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "46", "reponse" => "30"],
            ["nom_type_reponse" => "int", "id_question" => "47", "reponse" => "0"]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertNotFalse($id_questionnaire_instance);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            $id_reponse_instance = $this->tester->grabFromDatabase(
                "reponse_questionnaire",
                "id_reponse_instance",
                [
                    'id_questionnaire_instance' => $id_questionnaire_instance,
                    'id_question' => $reponse['id_question']
                ]
            );
            $this->assertNotFalse($id_reponse_instance);

            $valeur_bool = null;
            $valeur_string = null;
            $valeur_int = null;

            if ($reponse['nom_type_reponse'] == 'bool') {
                $valeur_bool = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'string') {
                $valeur_string = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'int') {
                $valeur_int = $reponse['reponse'];
            }

            $this->tester->seeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
                'valeur_int' => $valeur_int,
                'valeur_bool' => $valeur_bool,
                'valeur_string' => $valeur_string,
            ]);
        }
    }

    public function testCreateOkQuestionnaireEpices()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = "2";
        $date = "2022-10-01";
        $reponses = [
            ["nom_type_reponse" => "bool", "id_question" => "56", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "57", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "58", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "59", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "60", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "61", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "62", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "63", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "64", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "65", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "66", "reponse" => "1"]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertNotFalse($id_questionnaire_instance);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            $id_reponse_instance = $this->tester->grabFromDatabase(
                "reponse_questionnaire",
                "id_reponse_instance",
                [
                    'id_questionnaire_instance' => $id_questionnaire_instance,
                    'id_question' => $reponse['id_question']
                ]
            );
            $this->assertNotFalse($id_reponse_instance);

            $valeur_bool = null;
            $valeur_string = null;
            $valeur_int = null;

            if ($reponse['nom_type_reponse'] == 'bool') {
                $valeur_bool = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'string') {
                $valeur_string = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'int') {
                $valeur_int = $reponse['reponse'];
            }

            $this->tester->seeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
                'valeur_int' => $valeur_int,
                'valeur_bool' => $valeur_bool,
                'valeur_string' => $valeur_string,
            ]);
        }
    }

    public function testCreateOkQuestionnaireProchaska()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = "3";
        $date = "2022-10-01";
        $reponses = [
            [
                "nom_type_reponse" => "int",
                "id_question" => "67",
                "reponse" => "3"
            ]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertNotFalse($id_questionnaire_instance);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            $id_reponse_instance = $this->tester->grabFromDatabase(
                "reponse_questionnaire",
                "id_reponse_instance",
                [
                    'id_questionnaire_instance' => $id_questionnaire_instance,
                    'id_question' => $reponse['id_question']
                ]
            );
            $this->assertNotFalse($id_reponse_instance);

            $valeur_bool = null;
            $valeur_string = null;
            $valeur_int = null;

            if ($reponse['nom_type_reponse'] == 'bool') {
                $valeur_bool = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'string') {
                $valeur_string = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'int') {
                $valeur_int = $reponse['reponse'];
            }

            $this->tester->seeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
                'valeur_int' => $valeur_int,
                'valeur_bool' => $valeur_bool,
                'valeur_string' => $valeur_string,
            ]);
        }
    }

    public function testCreateOkQuestionnaireGarnier()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = "4";
        $date = "2022-10-01";
        $reponses = [
            ["nom_type_reponse" => "int", "id_question" => "48", "reponse" => "8"],
            ["nom_type_reponse" => "int", "id_question" => "49", "reponse" => "7"],
            ["nom_type_reponse" => "int", "id_question" => "50", "reponse" => "6"],
            ["nom_type_reponse" => "int", "id_question" => "51", "reponse" => "5"],
            ["nom_type_reponse" => "int", "id_question" => "52", "reponse" => "4"],
            ["nom_type_reponse" => "int", "id_question" => "53", "reponse" => "3"],
            ["nom_type_reponse" => "int", "id_question" => "54", "reponse" => "2"],
            ["nom_type_reponse" => "int", "id_question" => "55", "reponse" => "1"]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertNotFalse($id_questionnaire_instance);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            $id_reponse_instance = $this->tester->grabFromDatabase(
                "reponse_questionnaire",
                "id_reponse_instance",
                [
                    'id_questionnaire_instance' => $id_questionnaire_instance,
                    'id_question' => $reponse['id_question']
                ]
            );
            $this->assertNotFalse($id_reponse_instance);

            $valeur_bool = null;
            $valeur_string = null;
            $valeur_int = null;

            if ($reponse['nom_type_reponse'] == 'bool') {
                $valeur_bool = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'string') {
                $valeur_string = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'int') {
                $valeur_int = $reponse['reponse'];
            }

            $this->tester->seeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
                'valeur_int' => $valeur_int,
                'valeur_bool' => $valeur_bool,
                'valeur_string' => $valeur_string,
            ]);
        }
    }

    public function testCreateOkQuestionnaireFinProgramme1AnOui()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = "5";
        $date = "2022-10-01";
        $reponses = [
            ["nom_type_reponse" => "int", "id_question" => "68", "reponse" => "2"],
            ["nom_type_reponse" => "int", "id_question" => "70", "reponse" => "2"],
            ["nom_type_reponse" => "qcm_liste", "id_question" => "69", "reponses" => ["1", "3"]]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertNotFalse($id_questionnaire_instance);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            $id_reponse_instance = $this->tester->grabFromDatabase(
                "reponse_questionnaire",
                "id_reponse_instance",
                [
                    'id_questionnaire_instance' => $id_questionnaire_instance,
                    'id_question' => $reponse['id_question']
                ]
            );
            $this->assertNotFalse($id_reponse_instance);

            $valeur_bool = null;
            $valeur_string = null;
            $valeur_int = null;

            if ($reponse['nom_type_reponse'] == 'bool') {
                $valeur_bool = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'string') {
                $valeur_string = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'int') {
                $valeur_int = $reponse['reponse'];
            }

            $this->tester->seeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
                'valeur_int' => $valeur_int,
                'valeur_bool' => $valeur_bool,
                'valeur_string' => $valeur_string,
            ]);

            if ($reponse['nom_type_reponse'] == 'qcm_liste') {
                $values = $this->tester->grabColumnFromDatabase(
                    "liste_reponse_instance",
                    "valeur_int",
                    ['id_reponse_instance' => $id_reponse_instance]
                );

                $this->assertEqualsCanonicalizing($reponse['reponses'], $values);
            }
        }
    }

    public function testCreateOkQuestionnaireFinProgramme1AnNon()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = "5";
        $date = "2022-10-01";
        $reponses = [
            ["nom_type_reponse" => "int", "id_question" => "68", "reponse" => "3"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "1", "reponse" => "0"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "2", "reponse" => "1"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "3", "reponse" => "1"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "4", "reponse" => "0"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "5", "reponse" => "1"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "6", "reponse" => "0"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "7", "reponse" => "1"]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertNotFalse($id_questionnaire_instance);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            if ($reponse['nom_type_reponse'] == 'qcm') {
                // pour les qcm il y a plusieurs responses pour une question
                $ids = $this->tester->grabColumnFromDatabase(
                    "reponse_questionnaire",
                    "id_reponse_instance",
                    [
                        'id_questionnaire_instance' => $id_questionnaire_instance,
                        'id_question' => $reponse['id_question']
                    ]
                );
                $this->assertNotFalse($ids);

                // on recherche parmi les id_reponse_instance créés pour cette question
                // l'id si la réponse a été créé
                $actual_id_reponse_instance = null;
                foreach ($ids as $id_reponse_instance) {
                    $id = $this->tester->grabFromDatabase(
                        "reponse_instance",
                        "id_reponse_instance",
                        [
                            'valeur_bool' => $reponse['reponse'],
                            'valeur_int' => $reponse['id_qcm']
                        ]
                    );

                    if ($id) {
                        $actual_id_reponse_instance = $id;
                    }
                    break;
                }

                // si c'est null la réponse n'a pas été trouvée
                $this->assertNotNull($actual_id_reponse_instance);
            } else {
                $id_reponse_instance = $this->tester->grabFromDatabase(
                    "reponse_questionnaire",
                    "id_reponse_instance",
                    [
                        'id_questionnaire_instance' => $id_questionnaire_instance,
                        'id_question' => $reponse['id_question']
                    ]
                );
                $this->assertNotFalse($id_reponse_instance);

                $valeur_bool = null;
                $valeur_string = null;
                $valeur_int = null;

                if ($reponse['nom_type_reponse'] == 'bool') {
                    $valeur_bool = $reponse['reponse'];
                } elseif ($reponse['nom_type_reponse'] == 'string') {
                    $valeur_string = $reponse['reponse'];
                } elseif ($reponse['nom_type_reponse'] == 'int') {
                    $valeur_int = $reponse['reponse'];
                }

                $this->tester->seeInDatabase('reponse_instance', [
                    'id_reponse_instance' => $id_reponse_instance,
                    'valeur_int' => $valeur_int,
                    'valeur_bool' => $valeur_bool,
                    'valeur_string' => $valeur_string,
                ]);
            }
        }
    }

    public function testCreateOkQuestionnaireFinProgramme2AnsOui()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = "6";
        $date = "2022-10-01";
        $reponses = [
            ["nom_type_reponse" => "int", "id_question" => "68", "reponse" => "2"],
            ["nom_type_reponse" => "int", "id_question" => "70", "reponse" => "2"],
            ["nom_type_reponse" => "qcm_liste", "id_question" => "69", "reponses" => ["1", "3"]]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertNotFalse($id_questionnaire_instance);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            $id_reponse_instance = $this->tester->grabFromDatabase(
                "reponse_questionnaire",
                "id_reponse_instance",
                [
                    'id_questionnaire_instance' => $id_questionnaire_instance,
                    'id_question' => $reponse['id_question']
                ]
            );
            $this->assertNotFalse($id_reponse_instance);

            $valeur_bool = null;
            $valeur_string = null;
            $valeur_int = null;

            if ($reponse['nom_type_reponse'] == 'bool') {
                $valeur_bool = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'string') {
                $valeur_string = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'int') {
                $valeur_int = $reponse['reponse'];
            }

            $this->tester->seeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
                'valeur_int' => $valeur_int,
                'valeur_bool' => $valeur_bool,
                'valeur_string' => $valeur_string,
            ]);

            if ($reponse['nom_type_reponse'] == 'qcm_liste') {
                $values = $this->tester->grabColumnFromDatabase(
                    "liste_reponse_instance",
                    "valeur_int",
                    ['id_reponse_instance' => $id_reponse_instance]
                );

                $this->assertEqualsCanonicalizing($reponse['reponses'], $values);
            }
        }
    }

    public function testCreateOkQuestionnaireFinProgramme2AnsNon()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = "6";
        $date = "2022-10-01";
        $reponses = [
            ["nom_type_reponse" => "int", "id_question" => "68", "reponse" => "3"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "1", "reponse" => "0"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "2", "reponse" => "1"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "3", "reponse" => "1"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "4", "reponse" => "1"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "5", "reponse" => "1"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "6", "reponse" => "1"],
            ["nom_type_reponse" => "qcm", "id_question" => "71", "id_qcm" => "7", "reponse" => "0"]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertNotFalse($id_questionnaire_instance);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            if ($reponse['nom_type_reponse'] == 'qcm') {
                // pour les qcm il y a plusieurs responses pour une question
                $ids = $this->tester->grabColumnFromDatabase(
                    "reponse_questionnaire",
                    "id_reponse_instance",
                    [
                        'id_questionnaire_instance' => $id_questionnaire_instance,
                        'id_question' => $reponse['id_question']
                    ]
                );
                $this->assertNotFalse($ids);

                // on recherche parmi les id_reponse_instance créés pour cette question
                // l'id si la réponse a été créé
                $actual_id_reponse_instance = null;
                foreach ($ids as $id_reponse_instance) {
                    $id = $this->tester->grabFromDatabase(
                        "reponse_instance",
                        "id_reponse_instance",
                        [
                            'valeur_bool' => $reponse['reponse'],
                            'valeur_int' => $reponse['id_qcm']
                        ]
                    );

                    if ($id) {
                        $actual_id_reponse_instance = $id;
                    }
                    break;
                }

                // si c'est null la réponse n'a pas été trouvée
                $this->assertNotNull($actual_id_reponse_instance);
            } else {
                $id_reponse_instance = $this->tester->grabFromDatabase(
                    "reponse_questionnaire",
                    "id_reponse_instance",
                    [
                        'id_questionnaire_instance' => $id_questionnaire_instance,
                        'id_question' => $reponse['id_question']
                    ]
                );
                $this->assertNotFalse($id_reponse_instance);

                $valeur_bool = null;
                $valeur_string = null;
                $valeur_int = null;

                if ($reponse['nom_type_reponse'] == 'bool') {
                    $valeur_bool = $reponse['reponse'];
                } elseif ($reponse['nom_type_reponse'] == 'string') {
                    $valeur_string = $reponse['reponse'];
                } elseif ($reponse['nom_type_reponse'] == 'int') {
                    $valeur_int = $reponse['reponse'];
                }

                $this->tester->seeInDatabase('reponse_instance', [
                    'id_reponse_instance' => $id_reponse_instance,
                    'valeur_int' => $valeur_int,
                    'valeur_bool' => $valeur_bool,
                    'valeur_string' => $valeur_string,
                ]);
            }
        }
    }

    public function testCreateNotOkId_patientNull()
    {
        $id_patient = null;
        $id_user = "2";
        $id_questionnaire = "3";
        $date = "2022-10-01";
        $reponses = [
            [
                "nom_type_reponse" => "int",
                "id_question" => "67",
                "reponse" => "3"
            ]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertFalse($id_questionnaire_instance);
    }

    public function testCreateNotOkId_userNull()
    {
        $id_patient = "1";
        $id_user = null;
        $id_questionnaire = "3";
        $date = "2022-10-01";
        $reponses = [
            [
                "nom_type_reponse" => "int",
                "id_question" => "67",
                "reponse" => "3"
            ]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertFalse($id_questionnaire_instance);
    }

    public function testCreateNotOkId_questionnaireNull()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = null;
        $date = "2022-10-01";
        $reponses = [
            [
                "nom_type_reponse" => "int",
                "id_question" => "67",
                "reponse" => "3"
            ]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertFalse($id_questionnaire_instance);
    }

    public function testCreateNotOkDateNull()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = "3";
        $date = null;
        $reponses = [
            [
                "nom_type_reponse" => "int",
                "id_question" => "67",
                "reponse" => "3"
            ]
        ];

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertFalse($id_questionnaire_instance);
    }

    public function testCreateNotOkReponsesNull()
    {
        $id_patient = "1";
        $id_user = "2";
        $id_questionnaire = "3";
        $date = "2022-10-01";
        $reponses = null;

        $id_questionnaire_instance = $this->questionnaire->create([
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertFalse($id_questionnaire_instance);
    }

    public function testReadOkOpaq()
    {
        $id_questionnaire = "1";

        $questionnaire = $this->questionnaire->read($id_questionnaire);
        $this->assertIsArray($questionnaire);
        $this->assertArrayHasKey('id_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom_questionnaire', $questionnaire);
        $this->assertArrayHasKey('questions', $questionnaire);
        $this->assertIsArray($questionnaire['questions']);
        $this->assertNotEmpty($questionnaire['questions']);
        $this->assertArrayHasKey('id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('id_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_min', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_max', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('nom_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('enonce', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('que_id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('ordre', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('sous_questions', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcu', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcm', $questionnaire['questions'][0]);
    }

    public function testReadOkEpices()
    {
        $id_questionnaire = "2";

        $questionnaire = $this->questionnaire->read($id_questionnaire);
        $this->assertIsArray($questionnaire);
        $this->assertArrayHasKey('id_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom_questionnaire', $questionnaire);
        $this->assertArrayHasKey('questions', $questionnaire);
        $this->assertIsArray($questionnaire['questions']);
        $this->assertNotEmpty($questionnaire['questions']);
        $this->assertArrayHasKey('id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('id_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_min', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_max', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('nom_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('enonce', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('que_id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('ordre', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('sous_questions', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcu', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcm', $questionnaire['questions'][0]);
    }

    public function testReadOkProchaska()
    {
        $id_questionnaire = "3";

        $questionnaire = $this->questionnaire->read($id_questionnaire);
        $this->assertIsArray($questionnaire);
        $this->assertArrayHasKey('id_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom_questionnaire', $questionnaire);
        $this->assertArrayHasKey('questions', $questionnaire);
        $this->assertIsArray($questionnaire['questions']);
        $this->assertNotEmpty($questionnaire['questions']);
        $this->assertArrayHasKey('id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('id_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_min', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_max', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('nom_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('enonce', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('que_id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('ordre', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('sous_questions', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcu', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcm', $questionnaire['questions'][0]);
    }

    public function testReadOkGarnier()
    {
        $id_questionnaire = "4";

        $questionnaire = $this->questionnaire->read($id_questionnaire);
        $this->assertIsArray($questionnaire);
        $this->assertArrayHasKey('id_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom_questionnaire', $questionnaire);
        $this->assertArrayHasKey('questions', $questionnaire);
        $this->assertIsArray($questionnaire['questions']);
        $this->assertNotEmpty($questionnaire['questions']);
        $this->assertArrayHasKey('id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('id_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_min', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_max', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('nom_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('enonce', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('que_id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('ordre', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('sous_questions', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcu', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcm', $questionnaire['questions'][0]);
    }

    public function testReadOkFinProgramme1An()
    {
        $id_questionnaire = "5";

        $questionnaire = $this->questionnaire->read($id_questionnaire);
        $this->assertIsArray($questionnaire);
        $this->assertArrayHasKey('id_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom_questionnaire', $questionnaire);
        $this->assertArrayHasKey('questions', $questionnaire);
        $this->assertIsArray($questionnaire['questions']);
        $this->assertNotEmpty($questionnaire['questions']);
        $this->assertArrayHasKey('id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('id_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_min', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_max', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('nom_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('enonce', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('que_id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('ordre', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('sous_questions', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcu', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcm', $questionnaire['questions'][0]);
    }

    public function testReadOkFinProgramme2Ans()
    {
        $id_questionnaire = "6";

        $questionnaire = $this->questionnaire->read($id_questionnaire);
        $this->assertIsArray($questionnaire);
        $this->assertArrayHasKey('id_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom_questionnaire', $questionnaire);
        $this->assertArrayHasKey('questions', $questionnaire);
        $this->assertIsArray($questionnaire['questions']);
        $this->assertNotEmpty($questionnaire['questions']);
        $this->assertArrayHasKey('id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('id_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_min', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('valeur_max', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('nom_type_reponse', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('enonce', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('que_id_question', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('ordre', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('sous_questions', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcu', $questionnaire['questions'][0]);
        $this->assertArrayHasKey('qcm', $questionnaire['questions'][0]);
    }

    public function testReadNotOkId_questionnaireNull()
    {
        $id_questionnaire = null;

        $questionnaire = $this->questionnaire->read($id_questionnaire);
        $this->assertFalse($questionnaire);
    }

    public function testReadNotOkId_questionnaireInvalid()
    {
        $id_questionnaire = "-1";

        $questionnaire = $this->questionnaire->read($id_questionnaire);
        $this->assertFalse($questionnaire);
    }

    public function testReadReponsesOkOpaq()
    {
        $id_questionnaire_instance = "7";

        $questionnaire = $this->questionnaire->readReponses($id_questionnaire_instance);
        $this->assertIsArray($questionnaire);
        $this->assertArrayHasKey('id_questionnaire_instance', $questionnaire);
        $this->assertArrayHasKey('id_patient', $questionnaire);
        $this->assertArrayHasKey('date', $questionnaire);
        $this->assertArrayHasKey('id_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom', $questionnaire);
        $this->assertArrayHasKey('prenom', $questionnaire);
        $this->assertArrayHasKey('reponses', $questionnaire);

        $this->assertIsArray($questionnaire['reponses']);
        $this->assertNotEmpty($questionnaire['reponses']);
        $this->assertArrayHasKey('reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_qcm', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_question', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_type_reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('nom_type_reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('ordre', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('liste', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_reponse_instance', $questionnaire['reponses'][0]);
    }

    public function testReadReponsesOkEpices()
    {
        $id_questionnaire_instance = "4";

        $questionnaire = $this->questionnaire->readReponses($id_questionnaire_instance);
        $this->assertIsArray($questionnaire);
        $this->assertArrayHasKey('id_questionnaire_instance', $questionnaire);
        $this->assertArrayHasKey('id_patient', $questionnaire);
        $this->assertArrayHasKey('date', $questionnaire);
        $this->assertArrayHasKey('id_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom', $questionnaire);
        $this->assertArrayHasKey('prenom', $questionnaire);
        $this->assertArrayHasKey('reponses', $questionnaire);

        $this->assertIsArray($questionnaire['reponses']);
        $this->assertNotEmpty($questionnaire['reponses']);
        $this->assertArrayHasKey('reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_qcm', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_question', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_type_reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('nom_type_reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('ordre', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('liste', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_reponse_instance', $questionnaire['reponses'][0]);
    }

    public function testReadReponsesOkProchaska()
    {
        $id_questionnaire_instance = "2";

        $questionnaire = $this->questionnaire->readReponses($id_questionnaire_instance);
        $this->assertIsArray($questionnaire);
        $this->assertArrayHasKey('id_questionnaire_instance', $questionnaire);
        $this->assertArrayHasKey('id_patient', $questionnaire);
        $this->assertArrayHasKey('date', $questionnaire);
        $this->assertArrayHasKey('id_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom', $questionnaire);
        $this->assertArrayHasKey('prenom', $questionnaire);
        $this->assertArrayHasKey('reponses', $questionnaire);

        $this->assertIsArray($questionnaire['reponses']);
        $this->assertNotEmpty($questionnaire['reponses']);
        $this->assertArrayHasKey('reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_qcm', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_question', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_type_reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('nom_type_reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('ordre', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('liste', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_reponse_instance', $questionnaire['reponses'][0]);
    }

    public function testReadReponsesOkGarnier()
    {
        $id_questionnaire_instance = "6";

        $questionnaire = $this->questionnaire->readReponses($id_questionnaire_instance);
        $this->assertIsArray($questionnaire);
        $this->assertArrayHasKey('id_questionnaire_instance', $questionnaire);
        $this->assertArrayHasKey('id_patient', $questionnaire);
        $this->assertArrayHasKey('date', $questionnaire);
        $this->assertArrayHasKey('id_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom_questionnaire', $questionnaire);
        $this->assertArrayHasKey('nom', $questionnaire);
        $this->assertArrayHasKey('prenom', $questionnaire);
        $this->assertArrayHasKey('reponses', $questionnaire);

        $this->assertIsArray($questionnaire['reponses']);
        $this->assertNotEmpty($questionnaire['reponses']);
        $this->assertArrayHasKey('reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_qcm', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_question', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_type_reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('nom_type_reponse', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('ordre', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('liste', $questionnaire['reponses'][0]);
        $this->assertArrayHasKey('id_reponse_instance', $questionnaire['reponses'][0]);
    }

    public function testReadReponsesNotOkId_questionnaire_instanceNull()
    {
        $id_questionnaire_instance = null;

        $questionnaire = $this->questionnaire->readReponses($id_questionnaire_instance);
        $this->assertFalse($questionnaire);
    }

    public function testReadReponsesNotOkId_questionnaire_instanceInvalid()
    {
        $id_questionnaire_instance = "-1";

        $questionnaire = $this->questionnaire->readReponses($id_questionnaire_instance);
        $this->assertFalse($questionnaire);
    }

    public function testDeleteOkOpaq()
    {
        $id_questionnaire_instance = "2";

        $ids = $this->tester->grabColumnFromDatabase(
            'reponse_questionnaire',
            'id_reponse_instance',
            ['id_questionnaire_instance' => $id_questionnaire_instance]
        );

        $questionnaire = $this->questionnaire->delete($id_questionnaire_instance);
        $this->assertTrue($questionnaire);

        $this->tester->dontSeeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
        ]);

        $this->tester->dontSeeInDatabase('reponse_questionnaire', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
        ]);

        foreach ($ids as $id_reponse_instance) {
            $this->tester->dontSeeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
            ]);
        }
    }

    public function testDeleteOkEpices()
    {
        $id_questionnaire_instance = "4";

        $ids = $this->tester->grabColumnFromDatabase(
            'reponse_questionnaire',
            'id_reponse_instance',
            ['id_questionnaire_instance' => $id_questionnaire_instance]
        );

        $questionnaire = $this->questionnaire->delete($id_questionnaire_instance);
        $this->assertTrue($questionnaire);

        $this->tester->dontSeeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
        ]);

        $this->tester->dontSeeInDatabase('reponse_questionnaire', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
        ]);

        foreach ($ids as $id_reponse_instance) {
            $this->tester->dontSeeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
            ]);
        }
    }

    public function testDeleteOkProchaska()
    {
        $id_questionnaire_instance = "2";

        $ids = $this->tester->grabColumnFromDatabase(
            'reponse_questionnaire',
            'id_reponse_instance',
            ['id_questionnaire_instance' => $id_questionnaire_instance]
        );

        $questionnaire = $this->questionnaire->delete($id_questionnaire_instance);
        $this->assertTrue($questionnaire);

        $this->tester->dontSeeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
        ]);

        $this->tester->dontSeeInDatabase('reponse_questionnaire', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
        ]);

        foreach ($ids as $id_reponse_instance) {
            $this->tester->dontSeeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
            ]);
        }
    }

    public function testDeleteOkGarnier()
    {
        $id_questionnaire_instance = "6";

        $ids = $this->tester->grabColumnFromDatabase(
            'reponse_questionnaire',
            'id_reponse_instance',
            ['id_questionnaire_instance' => $id_questionnaire_instance]
        );

        $questionnaire = $this->questionnaire->delete($id_questionnaire_instance);
        $this->assertTrue($questionnaire);

        $this->tester->dontSeeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
        ]);

        $this->tester->dontSeeInDatabase('reponse_questionnaire', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
        ]);

        foreach ($ids as $id_reponse_instance) {
            $this->tester->dontSeeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
            ]);
        }
    }

    public function testDeleteNotOkId_questionnaire_instanceNull()
    {
        $id_questionnaire_instance = null;

        $questionnaire = $this->questionnaire->delete($id_questionnaire_instance);
        $this->assertFalse($questionnaire);
    }

    public function testDeleteNotOkId_questionnaire_instanceInvalid()
    {
        $id_questionnaire_instance = "-1";

        $questionnaire = $this->questionnaire->delete($id_questionnaire_instance);
        $this->assertFalse($questionnaire);
    }

    public function testGetQuestionnairesInstancesPatientOk()
    {
        $id_patient = "1";
        $id_questionnaire = "3";

        $ids = $this->questionnaire->getQuestionnairesInstancesPatient($id_patient, $id_questionnaire);
        $this->assertEqualsCanonicalizing(["2"], $ids);

        $id_patient = "1";
        $id_questionnaire = "1";

        $ids = $this->questionnaire->getQuestionnairesInstancesPatient($id_patient, $id_questionnaire);
        $this->assertEqualsCanonicalizing(["7"], $ids);
    }

    public function testGetQuestionnairesInstancesPatientOkEmptyResult()
    {
        $id_patient = "10";
        $id_questionnaire = "3";

        $ids = $this->questionnaire->getQuestionnairesInstancesPatient($id_patient, $id_questionnaire);
        $this->assertEqualsCanonicalizing([], $ids);
    }

    public function testGetQuestionnairesInstancesPatientNotOkId_patientNull()
    {
        $id_patient = null;
        $id_questionnaire = "1";

        $ids = $this->questionnaire->getQuestionnairesInstancesPatient($id_patient, $id_questionnaire);
        $this->assertFalse($ids);
    }

    public function testGetQuestionnairesInstancesPatientNotOkId_questionnaireNull()
    {
        $id_patient = "1";
        $id_questionnaire = null;

        $ids = $this->questionnaire->getQuestionnairesInstancesPatient($id_patient, $id_questionnaire);
        $this->assertFalse($ids);
    }

    public function testUpdateOkOpaq()
    {
        $id_questionnaire_instance = "7";
        $id_patient = "4";
        $id_user = "3";
        $id_questionnaire = "1";
        $date = "2022-12-02";
        $reponses = [
            ["nom_type_reponse" => "bool", "id_question" => "1", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "2", "reponse" => "1"],
            ["nom_type_reponse" => "int", "id_question" => "6", "reponse" => "3"],
            ["nom_type_reponse" => "int", "id_question" => "7", "reponse" => "5"],
            ["nom_type_reponse" => "int", "id_question" => "9", "reponse" => "45"],
            ["nom_type_reponse" => "int", "id_question" => "10", "reponse" => "985"],
            ["nom_type_reponse" => "int", "id_question" => "11", "reponse" => "17"],
            ["nom_type_reponse" => "bool", "id_question" => "13", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "14", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "15", "reponse" => "1"],
            ["nom_type_reponse" => "int", "id_question" => "17", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "18", "reponse" => "4"],
            ["nom_type_reponse" => "int", "id_question" => "19", "reponse" => "6"],
            ["nom_type_reponse" => "int", "id_question" => "21", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "22", "reponse" => "16"],
            ["nom_type_reponse" => "int", "id_question" => "23", "reponse" => "150"],
            ["nom_type_reponse" => "bool", "id_question" => "24", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "25", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "26", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "27", "reponse" => "1"],
            ["nom_type_reponse" => "int", "id_question" => "28", "reponse" => "3"],
            ["nom_type_reponse" => "int", "id_question" => "29", "reponse" => "42"],
            ["nom_type_reponse" => "bool", "id_question" => "31", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "32", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "34", "reponse" => "3"],
            ["nom_type_reponse" => "int", "id_question" => "35", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "37", "reponse" => "16"],
            ["nom_type_reponse" => "int", "id_question" => "38", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "40", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "41", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "43", "reponse" => "4"],
            ["nom_type_reponse" => "int", "id_question" => "44", "reponse" => "0"],
            ["nom_type_reponse" => "int", "id_question" => "46", "reponse" => "30"],
            ["nom_type_reponse" => "int", "id_question" => "47", "reponse" => "0"]
        ];

        $update_ok = $this->questionnaire->update([
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            $id_reponse_instance = $this->tester->grabFromDatabase(
                "reponse_questionnaire",
                "id_reponse_instance",
                [
                    'id_questionnaire_instance' => $id_questionnaire_instance,
                    'id_question' => $reponse['id_question']
                ]
            );
            $this->assertNotFalse($id_reponse_instance);

            $valeur_bool = null;
            $valeur_string = null;
            $valeur_int = null;

            if ($reponse['nom_type_reponse'] == 'bool') {
                $valeur_bool = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'string') {
                $valeur_string = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'int') {
                $valeur_int = $reponse['reponse'];
            }

            $this->tester->seeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
                'valeur_int' => $valeur_int,
                'valeur_bool' => $valeur_bool,
                'valeur_string' => $valeur_string,
            ]);
        }
    }

    public function testUpdateOkEpices()
    {
        $id_questionnaire_instance = "4";
        $id_patient = "1";
        $id_user = "3";
        $id_questionnaire = "2";
        $date = "2022-10-01";
        $reponses = [
            ["nom_type_reponse" => "bool", "id_question" => "56", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "57", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "58", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "59", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "60", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "61", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "62", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "63", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "64", "reponse" => "1"],
            ["nom_type_reponse" => "bool", "id_question" => "65", "reponse" => "0"],
            ["nom_type_reponse" => "bool", "id_question" => "66", "reponse" => "1"]
        ];

        $update_ok = $this->questionnaire->update([
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            $id_reponse_instance = $this->tester->grabFromDatabase(
                "reponse_questionnaire",
                "id_reponse_instance",
                [
                    'id_questionnaire_instance' => $id_questionnaire_instance,
                    'id_question' => $reponse['id_question']
                ]
            );
            $this->assertNotFalse($id_reponse_instance);

            $valeur_bool = null;
            $valeur_string = null;
            $valeur_int = null;

            if ($reponse['nom_type_reponse'] == 'bool') {
                $valeur_bool = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'string') {
                $valeur_string = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'int') {
                $valeur_int = $reponse['reponse'];
            }

            $this->tester->seeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
                'valeur_int' => $valeur_int,
                'valeur_bool' => $valeur_bool,
                'valeur_string' => $valeur_string,
            ]);
        }
    }

    public function testUpdateOkProchaska()
    {
        $id_questionnaire_instance = "2";
        $id_patient = "4";
        $id_user = "3";
        $id_questionnaire = "3";
        $date = "2022-10-01";
        $reponses = [
            [
                "nom_type_reponse" => "int",
                "id_question" => "67",
                "reponse" => "3"
            ]
        ];

        $update_ok = $this->questionnaire->update([
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            $id_reponse_instance = $this->tester->grabFromDatabase(
                "reponse_questionnaire",
                "id_reponse_instance",
                [
                    'id_questionnaire_instance' => $id_questionnaire_instance,
                    'id_question' => $reponse['id_question']
                ]
            );
            $this->assertNotFalse($id_reponse_instance);

            $valeur_bool = null;
            $valeur_string = null;
            $valeur_int = null;

            if ($reponse['nom_type_reponse'] == 'bool') {
                $valeur_bool = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'string') {
                $valeur_string = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'int') {
                $valeur_int = $reponse['reponse'];
            }

            $this->tester->seeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
                'valeur_int' => $valeur_int,
                'valeur_bool' => $valeur_bool,
                'valeur_string' => $valeur_string,
            ]);
        }
    }

    public function testUpdateOkGarnier()
    {
        $id_questionnaire_instance = "6";
        $id_patient = "4";
        $id_user = "3";
        $id_questionnaire = "4";
        $date = "2022-10-01";
        $reponses = [
            ["nom_type_reponse" => "int", "id_question" => "48", "reponse" => "8"],
            ["nom_type_reponse" => "int", "id_question" => "49", "reponse" => "7"],
            ["nom_type_reponse" => "int", "id_question" => "50", "reponse" => "6"],
            ["nom_type_reponse" => "int", "id_question" => "51", "reponse" => "5"],
            ["nom_type_reponse" => "int", "id_question" => "52", "reponse" => "4"],
            ["nom_type_reponse" => "int", "id_question" => "53", "reponse" => "3"],
            ["nom_type_reponse" => "int", "id_question" => "54", "reponse" => "2"],
            ["nom_type_reponse" => "int", "id_question" => "55", "reponse" => "1"]
        ];

        $update_ok = $this->questionnaire->update([
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'id_patient' => $id_patient,
            'id_questionnaire' => $id_questionnaire,
            'id_user' => $id_user,
            'date' => $date,
            'reponses' => $reponses,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_questionnaire_instance' => $id_questionnaire_instance,
            'date' => $date,
            'id_user' => $id_user,
            'id_questionnaire' => $id_questionnaire,
            'id_patient' => $id_patient,
        ]);

        foreach ($reponses as $reponse) {
            $id_reponse_instance = $this->tester->grabFromDatabase(
                "reponse_questionnaire",
                "id_reponse_instance",
                [
                    'id_questionnaire_instance' => $id_questionnaire_instance,
                    'id_question' => $reponse['id_question']
                ]
            );
            $this->assertNotFalse($id_reponse_instance);

            $valeur_bool = null;
            $valeur_string = null;
            $valeur_int = null;

            if ($reponse['nom_type_reponse'] == 'bool') {
                $valeur_bool = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'string') {
                $valeur_string = $reponse['reponse'];
            } elseif ($reponse['nom_type_reponse'] == 'int') {
                $valeur_int = $reponse['reponse'];
            }

            $this->tester->seeInDatabase('reponse_instance', [
                'id_reponse_instance' => $id_reponse_instance,
                'valeur_int' => $valeur_int,
                'valeur_bool' => $valeur_bool,
                'valeur_string' => $valeur_string,
            ]);
        }
    }

    public function testDeleteAllQuestionnairePatientOk()
    {
        $id_patient = "1";

        $this->tester->seeInDatabase('questionnaire_instance', [
            'id_patient' => $id_patient,
        ]);

        $delete_ok = $this->questionnaire->deleteAllQuestionnairePatient($id_patient);
        $this->assertTrue($delete_ok);

        $this->tester->dontSeeInDatabase('questionnaire_instance', [
            'id_patient' => $id_patient,
        ]);
    }

    public function testDeleteAllQuestionnairePatientNotOkId_patientNull()
    {
        $id_patient = null;

        $delete_ok = $this->questionnaire->deleteAllQuestionnairePatient($id_patient);
        $this->assertFalse($delete_ok);
    }

    public function testGetScoreGarnierOk()
    {
        $id_questionnaire_instance = "6";  // valeur de questionnaire garnier du fichier 2022-05-16_Fichier_type_seul.xlsx

        $scores = $this->questionnaire->getScoreGarnier($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("perception_sante", $scores);
        $this->assertEquals(5.1, $scores["perception_sante"]);
    }

    public function testGetScoreGarnierNotOkId_questionnaire_instanceNull()
    {
        $id_questionnaire_instance = null;

        $scores = $this->questionnaire->getScoreGarnier($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("perception_sante", $scores);
        $this->assertNull($scores["perception_sante"]);
    }

    public function testGetScoreGarnierNotOkId_questionnaire_instanceInvalid()
    {
        $id_questionnaire_instance = "-1";

        $scores = $this->questionnaire->getScoreGarnier($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("perception_sante", $scores);

        $this->assertNull($scores["perception_sante"]);
    }

    public function testGetScoreOpaqOk()
    {
        $id_questionnaire_instance = "7";  // valeur de questionnaire Opaq du fichier 2022-05-16_Fichier_type_seul.xlsx

        $scores = $this->questionnaire->getScoreOpaq($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("niveau_activite_physique_minutes", $scores);
        $this->assertArrayHasKey("niveau_activite_physique_mets", $scores);
        $this->assertArrayHasKey("niveau_sendentarite", $scores);
        $this->assertArrayHasKey("niveau_sendentarite_semaine", $scores);

        $this->assertEquals(210, $scores["niveau_activite_physique_minutes"]);
        $this->assertEquals(756, $scores["niveau_activite_physique_mets"]);
        $this->assertEquals(424.3, $scores["niveau_sendentarite"]);
        $this->assertEqualsWithDelta(424.3 * 7, $scores["niveau_sendentarite_semaine"], 0.1);
    }

    public function testGetScoreOpaqNotOkId_questionnaire_instanceNull()
    {
        $id_questionnaire_instance = null;

        $scores = $this->questionnaire->getScoreOpaq($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("niveau_activite_physique_minutes", $scores);
        $this->assertArrayHasKey("niveau_activite_physique_mets", $scores);
        $this->assertArrayHasKey("niveau_sendentarite", $scores);
        $this->assertArrayHasKey("niveau_sendentarite_semaine", $scores);

        $this->assertNull($scores["niveau_activite_physique_minutes"]);
        $this->assertNull($scores["niveau_activite_physique_mets"]);
        $this->assertNull($scores["niveau_sendentarite"]);
        $this->assertNull($scores["niveau_sendentarite_semaine"]);
    }

    public function testGetScoreOpaqNotOkId_questionnaire_instanceInvalid()
    {
        $id_questionnaire_instance = "-1";

        $scores = $this->questionnaire->getScoreOpaq($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("niveau_activite_physique_minutes", $scores);
        $this->assertArrayHasKey("niveau_activite_physique_mets", $scores);
        $this->assertArrayHasKey("niveau_sendentarite", $scores);
        $this->assertArrayHasKey("niveau_sendentarite_semaine", $scores);

        $this->assertNull($scores["niveau_activite_physique_minutes"]);
        $this->assertNull($scores["niveau_activite_physique_mets"]);
        $this->assertNull($scores["niveau_sendentarite"]);
        $this->assertNull($scores["niveau_sendentarite_semaine"]);
    }

    public function testGetScoreEpicesOk()
    {
        // Pour une personne qui a répondu oui aux questions 1, 2 et 3, et non aux autres questions
        // EPICES = 75,14 +10,06 - 11,83 - 8,28 = 65,09 (exemple du PDF)
        $id_questionnaire_instance = "5";

        $scores = $this->questionnaire->getScoreEpices($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("epices", $scores);
        $this->assertEquals(65.09, $scores["epices"]);
    }

    public function testGetScoreEpicesNotOkId_questionnaire_instanceNull()
    {
        $id_questionnaire_instance = null;

        $scores = $this->questionnaire->getScoreEpices($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("epices", $scores);
        $this->assertNull($scores["epices"]);
    }

    public function testGetScoreEpicesNotOkId_questionnaire_instanceInvalid()
    {
        $id_questionnaire_instance = "-1";

        $scores = $this->questionnaire->getScoreEpices($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("epices", $scores);
        $this->assertNull($scores["epices"]);
    }

    public function testGetScoreProcheskaOk()
    {
        $id_questionnaire_instance = "2";

        $scores = $this->questionnaire->getScoreProcheska($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("proshenska", $scores);
        $this->assertEquals(5, $scores["proshenska"]);
    }

    public function testGetScoreProcheskaNotOkId_questionnaire_instanceNull()
    {
        $id_questionnaire_instance = null;

        $scores = $this->questionnaire->getScoreProcheska($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("proshenska", $scores);
        $this->assertNull($scores["proshenska"]);
    }

    public function testGetScoreProcheskaNotOkId_questionnaire_instanceInvalid()
    {
        $id_questionnaire_instance = "-1";

        $scores = $this->questionnaire->getScoreProcheska($id_questionnaire_instance);
        $this->assertIsArray($scores);
        $this->assertArrayHasKey("proshenska", $scores);
        $this->assertNull($scores["proshenska"]);
    }
}