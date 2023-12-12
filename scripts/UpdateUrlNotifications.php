<?php
/**
 * Script à usage unique qui permet de modifier les urls utilisées dans les notifications
 * Remplace "https://suivibeneficiairesbeta.sportsante86.fr" par "https://sapa-na.fr"
 *
 */

?>

<html lang="fr">

<?php
try {
    $root = dirname(__FILE__, 2);

    include $root . '/BDD/connexion.php';
    $bdd->beginTransaction();

    $query = "
        SELECT id_notification, text_notification
        FROM notifications
        WHERE text_notification LIKE '%https://suivibeneficiairesbeta.sportsante86.fr%'";
    $stmt = $bdd->prepare($query);
    if (!$stmt->execute()) {
        throw new Exception("Error: SELECT FROM notifications");
    }

    echo "Nombre de notifications à update = " . ($stmt->rowCount()) . "<br>";

    $ok = true;

    while ($notification = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $text_notification_url_replaced = str_replace(
            "https://suivibeneficiairesbeta.sportsante86.fr",
            "https://sapa-na.fr",
            $notification['text_notification']
        );

        $query_update = '
            UPDATE notifications
            SET text_notification = :text_notification
            WHERE id_notification = :id_notification';
        $stmt_update = $bdd->prepare($query_update);
        $stmt_update->bindValue(":text_notification", $text_notification_url_replaced);
        $stmt_update->bindValue(":id_notification", $notification['id_notification']);
        if (!$stmt_update->execute()) {
            echo "Error: UPDATE notifications id_notification=" . $notification['id_notification'] . "<br>";
            $ok = false;
        }
    }

    echo "Script exécuté " . (!$ok ? " avec au moins une erreur:" : " sans erreurs") . "<br>";

    $bdd->commit();
} catch (Exception $e) {
    echo "Script non exécuté cause:" . $e->getMessage();
    $bdd->rollBack();
}
?>
</html>