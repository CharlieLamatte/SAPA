<?php
/**
 * Script à usage unique qui permet de modifier la table activites_physiques:
 */

use Sportsante86\Sapa\Model\ActivitePhysique;

try {
    $root = dirname(__FILE__, 2);
    require $root . '/bootstrap/bootstrap.php';

    $query = '
        SELECT id_activite_physique,
               activite_physique_autonome,
               activite_physique_encadree,
               activite_anterieure,
               disponibilite,
               frein_activite,
               activite_envisagee,
               point_fort_levier,
               a_activite_anterieure,
               a_activite_autonome,
               a_activite_encadree,
               a_activite_envisagee,
               a_activite_frein,
               a_activite_point_fort_levier,
               id_patient,
               id_user,
               date_observation
        FROM activites_physiques';
    $stmt = $bdd->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();

    $erreur_count = 0;
    $ap = new ActivitePhysique($bdd);
    while ($activite = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $activite["a_activite_anterieure"] = empty($activite["activite_anterieure"]) ? "0" : "1";
        $activite["a_activite_autonome"] = empty($activite["activite_physique_autonome"]) ? "0" : "1";
        $activite["a_activite_encadree"] = empty($activite["activite_physique_encadree"]) ? "0" : "1";
        $activite["a_activite_envisagee"] = empty($activite["activite_envisagee"]) ? "0" : "1";
        $activite["a_activite_frein"] = empty($activite["frein_activite"]) ? "0" : "1";
        $activite["a_activite_point_fort_levier"] = empty($activite["point_fort_levier"]) ? "0" : "1";
        $activite["est_dispo_lundi"] = "0";
        $activite["est_dispo_mardi"] = "0";
        $activite["est_dispo_mercredi"] = "0";
        $activite["est_dispo_jeudi"] = "0";
        $activite["est_dispo_vendredi"] = "0";
        $activite["est_dispo_samedi"] = "0";
        $activite["est_dispo_dimanche"] = "0";

        $update_ok = $ap->update($activite);
        if (!$update_ok) {
            $erreur_count++;
        }
    }

    echo '<html lang="fr">';;
    echo "Nombre d'activité = " . ($count) . "<br>";
    if ($erreur_count > 0) {
        echo "Script exécuté avec " . ($erreur_count) . " erreurs<br>";
    } else {
        echo "Script exécuté avec succès<br>";
    }
} catch (Exception $e) {
    echo '<html lang="fr">';;
    echo "Script exécuté avec au moins une erreur:" . $e->getMessage() . ' line' . $e->getLine();
}
?>
</html>
