<?php

namespace Tests\Support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Exception\ModuleException;
use PDO;

class Unit extends \Codeception\Module
{
    /**
     * @param $parameters
     * @return mixed
     * @throws ModuleException
     */
    public function grabNumUsers($parameters) {
        $pdo = $this->getModule('Db')->_getDbh();

        $query = "
            SELECT DISTINCT COUNT(users.id_user)
            FROM users
            JOIN a_role ar on users.id_user = ar.id_user 
            WHERE 1=1 ";

        if (!empty($parameters['id_territoire'])) {
            $query .= " AND users.id_territoire = :id_territoire ";
        }
        if (!empty($parameters['id_structure'])) {
            $query .= " AND users.id_structure = :id_structure ";
        }
        if (!empty($parameters['not_id_role_user_1'])) {
            $query .= " AND ar.id_role_user <> :not_id_role_user_1 ";
        }
        if (!empty($parameters['not_id_role_user_2'])) {
            $query .= " AND ar.id_role_user <> :not_id_role_user_2 ";
        }

        $stmt = $pdo->prepare($query);

        if (!empty($parameters['id_territoire'])) {
            $stmt->bindValue(':id_territoire', $parameters['id_territoire']);
        }
        if (!empty($parameters['id_structure'])) {
            $stmt->bindValue(':id_structure', $parameters['id_structure']);
        }
        if (!empty($parameters['not_id_role_user_1'])) {
            $stmt->bindValue(':not_id_role_user_1', $parameters['not_id_role_user_1']);
        }
        if (!empty($parameters['not_id_role_user_2'])) {
            $stmt->bindValue(':not_id_role_user_2', $parameters['not_id_role_user_2']);
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN, 0);
    }
}
