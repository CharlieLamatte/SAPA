<?php
/**
 * Script à usage unique qui permet de modifier les patients:
 *
 */
?>

<html lang="fr">

<?php
try {
    $root = dirname(__FILE__, 2);

    include $root . '/BDD/connexion.php';
    include $root . '/vendor/autoload.php';
    $bdd->beginTransaction();

    $query = '
        SELECT id_user, id_role_user
        FROM users';
    $stmt = $bdd->prepare($query);
    if (!$stmt->execute()) {
        throw new Exception("Error: SELECT FROM users");
    }

    echo "Nombre de users = " . ($stmt->rowCount()) . "<br>";;

    $ok = true;

    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $query_insert = '
            INSERT INTO a_role (id_user, id_role_user)
            VALUES (:id_user, :id_role_user)';
        $stmt_insert = $bdd->prepare($query_insert);

        $stmt_insert->bindValue(":id_user", $user['id_user']);
        $stmt_insert->bindValue(":id_role_user", $user['id_role_user']);

        if (!$stmt_insert->execute()) {
            echo "Error: INSERT a_role id_user=" . $user['id_user'] . " id_role_user=" . $user['id_role_user'] . "<br>";
            $ok = false;
        }
    }

    echo "Script exécuté " . (!$ok ? " avec au moin une erreur:" : " sans erreurs") . "<br>";

    $bdd->commit();
} catch (Exception $e) {
    echo "Script non exécuté cause:" . $e->getMessage();
    $bdd->rollBack();
}
?>
</html>
