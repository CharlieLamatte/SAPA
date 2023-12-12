<?php
/**
 * Script à usage unique qui permet de modifier users:
 *
 */

?>

<html lang="fr">

<?php
try {
    $root = dirname(__FILE__, 2);

    include $root . '/BDD/connexion.php';
    $bdd->beginTransaction();

    // update coordinateur
    $query = '
        SELECT compteur, est_coordinateur_peps, id_coordonnees
        FROM coordinateur ';
    $stmt = $bdd->prepare($query);
    if (!$stmt->execute()) {
        throw new Exception("Error: SELECT FROM coordinateur");
    }

    $rc = $stmt->rowCount();
    echo "Nombre de coordinateurs = " . ($rc) . "<br>";;

    $ok = true;

    $coordinateur_updated_count = 0;
    $coordinateur = $stmt->fetchAll(PDO::FETCH_ASSOC);
    for ($i = 0; $i < $rc; $i++) {
        $query = '
            UPDATE users
            SET est_coordinateur_peps = :est_coordinateur_peps,
                compteur = :compteur
            WHERE id_coordonnees = :id_coordonnees';
        $stmt = $bdd->prepare($query);

        $stmt->bindValue(":est_coordinateur_peps", $coordinateur[$i]['est_coordinateur_peps']);
        $stmt->bindValue(":compteur", $coordinateur[$i]['compteur']);
        $stmt->bindValue(":id_coordonnees", $coordinateur[$i]['id_coordonnees']);

        if (!$stmt->execute()) {
            echo "Error: UPDATE users id_coordonnees=" . $coordinateur[$i]['id_coordonnees'] . "<br>";
            $ok = false;
        } else {
            $coordinateur_updated_count++;
        }
    }

    echo "Script exécuté " . (!$ok ? " avec au moin une erreur:" : " sans erreurs") . "<br>";
    echo "Nombre de coordinateurs MAJ = " . ($coordinateur_updated_count) . "<br>";;

    // update superviseur_peps
    $query = '
        SELECT fonction, id_coordonnees
        FROM superviseur_peps ';
    $stmt = $bdd->prepare($query);
    if (!$stmt->execute()) {
        throw new Exception("Error: SELECT FROM superviseur_peps");
    }

    $rc = $stmt->rowCount();
    echo "Nombre de superviseurs peps = " . ($rc) . "<br>";;

    $ok = true;

    $superviseur_peps_updated_count = 0;
    $superviseur_peps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    for ($i = 0; $i < $rc; $i++) {
        $query = '
            UPDATE users
            SET fonction = :fonction
            WHERE id_coordonnees = :id_coordonnees';
        $stmt = $bdd->prepare($query);

        $stmt->bindValue(":fonction", $superviseur_peps[$i]['fonction']);
        $stmt->bindValue(":id_coordonnees", $superviseur_peps[$i]['id_coordonnees']);

        if (!$stmt->execute()) {
            echo "Error: UPDATE users id_coordonnees=" . $superviseur_peps[$i]['id_coordonnees'] . "<br>";
            $ok = false;
        } else {
            $superviseur_peps_updated_count++;
        }
    }

    echo "Script exécuté " . (!$ok ? " avec au moin une erreur:" : " sans erreurs") . "<br>";
    echo "Nombre de superviseurs peps MAJ = " . ($superviseur_peps_updated_count) . "<br>";;

    $bdd->commit();
} catch (Exception $e) {
    echo "Script non exécuté cause:" . $e->getMessage();
    $bdd->rollBack();
}
?>
</html>
