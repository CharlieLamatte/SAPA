<?php
/**
 * Script à usage unique qui permet de modifier les patients:
 *
 */

use Sportsante86\Sapa\Outils\ChaineCharactere;

?>

<html lang="fr">

<?php
try {
    $root = dirname(__FILE__, 2);

    include $root . '/BDD/connexion.php';
    include $root . '/vendor/autoload.php';
    $bdd->beginTransaction();

    $query = '
        SELECT nom_coordonnees, prenom_coordonnees, sexe_patient, p.id_patient
        FROM patients p
        JOIN coordonnees c on c.id_coordonnees = p.id_coordonnee';
    $stmt = $bdd->prepare($query);
    if (!$stmt->execute()) {
        throw new Exception("Error: SELECT FROM patients");
    }

    echo "Nombre de patients = " . ($stmt->rowCount()) . "<br>";;

    $ok = true;

    while ($patient = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nom = ChaineCharactere::format_compatible_ins($patient['nom_coordonnees']);
        $prenom = ChaineCharactere::format_compatible_ins($patient['prenom_coordonnees']);

        $sexe = $patient['sexe_patient'] == 1 ? "F" : "M";

        echo $nom . ' ' . $prenom . ' ' . $sexe . "<br>";
        $query_update = '
            UPDATE patients
            SET premier_prenom_naissance = :premier_prenom_naissance,
                nom_naissance = :nom_naissance,
                sexe = :sexe
            WHERE id_patient = :id_patient';
        $stmt_update = $bdd->prepare($query_update);

        $stmt_update->bindValue(":premier_prenom_naissance", $prenom);
        $stmt_update->bindValue(":nom_naissance", $nom);
        $stmt_update->bindValue(":sexe", $sexe);
        $stmt_update->bindValue(":id_patient", $patient['id_patient']);

        if (!$stmt_update->execute()) {
            echo "Error: UPDATE patients id_patient=" . $patient['id_patient'] . "<br>";
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
