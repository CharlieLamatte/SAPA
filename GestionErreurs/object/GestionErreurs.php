<?php


class GestionErreurs {
    private $bdd;

    // object properties
    public $id_erreur;
    public $date;
    public $id_api;
    public $nom_element;
    public $type_element;
    public $description;
    public $data;

    // constructor with $db as database connection
    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    function create() {
        $query  = 'INSERT INTO erreur_log
                    (date, id_api, nom_element, type_element, description, data)
                    VALUES (:date, :id_api, :nom_element, :type_element, :description, :data)';
        $stmt = $this->bdd->prepare($query);

        $stmt->bindValue(':date', $this->date);
        $stmt->bindValue(':id_api', $this->id_api);
        $stmt->bindValue(':nom_element', $this->nom_element);
        $stmt->bindValue(':type_element', $this->type_element);
        $stmt->bindValue(':description', $this->description);
        $stmt->bindValue(':data', $this->data);

        $a = $stmt->execute();
        return $a;
    }

    function readAll() {
        $query  = 'SELECT id_erreur, date, id_api, nom_element, type_element, description, data
                    FROM erreur_log';
        $stmt = $this->bdd->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}