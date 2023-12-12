<?php

/**
 * Script à usage unique qui permet de mettre à jour les lignes de la table activites_physiques:
 * - il n'y aura qu'une seule ligne par id_patient
 * - les champs textes sont concaténés pour chaque activité
 *
 */

function insert_or_update($activite, $bdd)
{
    $activite['activite_physique_autonome'] = $activite['activite_physique_autonome'] ?? "";
    $activite['activite_physique_encadree'] = $activite['activite_physique_encadree'] ?? "";
    $activite['activite_anterieure'] = $activite['activite_anterieure'] ?? "";
    $activite['disponibilite'] = $activite['disponibilite'] ?? "";
    $activite['frein_activite'] = $activite['frein_activite'] ?? "";
    $activite['activite_envisagee'] = $activite['activite_envisagee'] ?? "";
    $activite['point_fort_levier'] = $activite['point_fort_levier'] ?? "";

    $query_select = '
        SELECT *
        FROM activites_physiques
        WHERE id_patient = :id_patient';
    $stmt_select = $bdd->prepare($query_select);
    $stmt_select->bindValue(":id_patient", $activite['id_patient']);
    if (!$stmt_select->execute()) {
        throw new Exception("Error: SELECT * FROM activites_physiques");
    }

    $data = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($stmt_select->rowCount() == 0) {
        // insert

        $query = '
                INSERT INTO activites_physiques
                (activite_physique_autonome, activite_physique_encadree, activite_anterieure, disponibilite, frein_activite,
                 activite_envisagee, point_fort_levier, id_patient, id_user, date_observation)
                VALUES (:activite_physique_autonome, :activite_physique_encadree, :activite_anterieure, :disponibilite, :frein_activite,
                        :activite_envisagee, :point_fort_levier, :id_patient, :id_user, :date_observation)';
        $stmt = $bdd->prepare($query);

        $stmt->bindValue(":activite_physique_autonome", $activite['activite_physique_autonome']);
        $stmt->bindValue(":activite_physique_encadree", $activite['activite_physique_encadree']);
        $stmt->bindValue(":activite_anterieure", $activite['activite_anterieure']);
        $stmt->bindValue(":disponibilite", $activite['disponibilite']);
        $stmt->bindValue(":frein_activite", $activite['frein_activite']);
        $stmt->bindValue(":activite_envisagee", $activite['activite_envisagee']);
        $stmt->bindValue(":point_fort_levier", $activite['point_fort_levier']);
        $stmt->bindValue(":id_patient", $activite['id_patient']);
        $stmt->bindValue(":id_user", $activite['id_user']);
        $stmt->bindValue(":date_observation", $activite['date_observation']);

        if (!$stmt->execute()) {
            throw new Exception("Error: INSERT INTO activites_physiques");
        }
    } else {
        // update
        $id_activite_physique = $data['id_activite_physique'] ?? null;
        $date_observation = $data['date_observation'] ?? null;

        $activite['activite_physique_autonome'] = trim(
                $data['activite_physique_autonome']
            ) . "\n" . $activite['activite_physique_autonome'];
        $activite['activite_physique_encadree'] = trim(
                $data['activite_physique_encadree']
            ) . "\n" . $activite['activite_physique_encadree'];
        $activite['activite_anterieure'] = trim($data['activite_anterieure']) . "\n" . $activite['activite_anterieure'];
        $activite['disponibilite'] = trim($data['disponibilite']) . "\n" . $activite['disponibilite'];
        $activite['frein_activite'] = trim($data['frein_activite']) . "\n" . $activite['frein_activite'];
        $activite['activite_envisagee'] = trim($data['activite_envisagee']) . "\n" . $activite['activite_envisagee'];
        $activite['point_fort_levier'] = trim($data['point_fort_levier']) . "\n" . $activite['point_fort_levier'];

        if (is_null($id_activite_physique)) {
            throw new Exception("Error: Invalid previous data");
        } else {
            try {
                // on choisit la date la plus récente
                $date1 = new DateTime($date_observation);
                $date2 = new DateTime($activite['date_observation']);
                $date_observation = ($date1 > $date2) ? $date_observation : $activite['date_observation'];
            } catch (Exception $e) {
                echo $e->getMessage();
                $date_observation = null;
            }

            $query = '
                UPDATE activites_physiques
                SET activite_physique_autonome = :activite_physique_autonome,
                    activite_physique_encadree = :activite_physique_encadree,
                    activite_anterieure        = :activite_anterieure,
                    disponibilite              = :disponibilite,
                    frein_activite             = :frein_activite,
                    activite_envisagee         = :activite_envisagee,
                    point_fort_levier          = :point_fort_levier,
                    id_patient                 = :id_patient,
                    id_user                    = :id_user,
                    date_observation           = :date_observation
                WHERE id_activite_physique = :id_activite_physique';
            $stmt = $bdd->prepare($query);

            $stmt->bindValue(":id_activite_physique", $id_activite_physique);
            $stmt->bindValue(":activite_physique_autonome", $activite['activite_physique_autonome']);
            $stmt->bindValue(":activite_physique_encadree", $activite['activite_physique_encadree']);
            $stmt->bindValue(":activite_anterieure", $activite['activite_anterieure']);
            $stmt->bindValue(":disponibilite", $activite['disponibilite']);
            $stmt->bindValue(":frein_activite", $activite['frein_activite']);
            $stmt->bindValue(":activite_envisagee", $activite['activite_envisagee']);
            $stmt->bindValue(":point_fort_levier", $activite['point_fort_levier']);
            $stmt->bindValue(":id_patient", $activite['id_patient']);
            $stmt->bindValue(":id_user", $activite['id_user']);
            if (is_null($date_observation)) {
                $stmt->bindValue(":date_observation", $date_observation, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":date_observation", $date_observation);
            }

            if (!$stmt->execute()) {
                throw new Exception("Error: UPDATE activites_physiques");
            }
        }
    }
}

try {
    $bdd = new PDO('mysql:host=localhost;dbname=sportsanzbtest2;charset=utf8', 'root', 'root');

    $bdd->beginTransaction();

    $query = '
    SELECT id_activite_physique,
           activite_physique_autonome,
           activite_physique_encadree,
           activite_anterieure,
           disponibilite,
           frein_activite,
           activite_envisagee,
           point_fort_levier,
           id_patient,
           id_user,
           date_observation
    FROM activites_physiques ';
    $stmt = $bdd->prepare($query);
    if (!$stmt->execute()) {
        throw new Exception("Error: SELECT id_activite_physique");
    }

    $activite_physiques = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $query = 'DELETE FROM  activites_physiques';
    $stmt = $bdd->prepare($query);
    if (!$stmt->execute()) {
        throw new Exception("Error: DELETE FROM  activites_physiques");
    }

    foreach ($activite_physiques as $activite) {
        insert_or_update($activite, $bdd);
    }

    $bdd->commit();
} catch (Exception $e) {
    echo "Script non exécuté cause:" . $e->getMessage();
    $bdd->rollBack();
}