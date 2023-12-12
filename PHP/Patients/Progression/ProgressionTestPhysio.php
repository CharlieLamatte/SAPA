<?php

require '../../Settings/TableauDeBord/functions_tableau.php';

class ProgessionTestPhysio
{
    private $connection;
    private $column;
    private $id_patient;

    private $columns = [
        'poids',
        'taille',
        'IMC',
        'fc_max_mesuree',
        'fc_max_theo',
        'fc_repos',
        'saturation_repos',
        'tour_taille',
        'borg_repos',
    ];

    /**
     * @param $connection
     * @param $column
     * @param $id_patient
     * @throws Exception
     */
    public function __construct($connection, $column, $id_patient)
    {
        if (!in_array($column, $this->columns)) {
            throw new Exception("Nom de colonne invalide.");
        }
        $this->column = $column;
        $this->connection = $connection;
        $this->id_patient = $id_patient;
    }

    public function getProgression()
    {
        $query = "
        SELECT 
               $this->column as value,
               DATE_FORMAT(date_eval, '%d/%m/%Y') as date_eval
        FROM evaluations
        JOIN patients p on evaluations.id_patient = p.id_patient
        JOIN test_physio tp on evaluations.id_evaluation = tp.id_evaluation
        WHERE p.id_patient = :id_patient AND $this->column IS NOT NULL
        ORDER BY date_eval";

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id_patient', $this->id_patient);
        $stmt->execute();

        $result = array(
            'labels' => array(),
            'values' => array()
        );

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            add($result, $row['date_eval'], $row['value']);
        }

        return $result;
    }
}