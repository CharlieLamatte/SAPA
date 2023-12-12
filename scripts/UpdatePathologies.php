<?php
/**
 * Script à usage unique qui permet de modifier la tables pathologies:
 */

use Sportsante86\Sapa\Model\Pathologie;

try {
    $root = dirname(__FILE__, 2);
    require $root . '/bootstrap/bootstrap.php';

    $query = '
        SELECT id_pathologie,
               cardio,
               respiratoire,
               metabolique,
               osteo_articulaire,
               psycho_social,
               neuro,
               cancero,
               circulatoire,
               autre,
               a_patho_cardio,
               a_patho_respiratoire,
               a_patho_metabolique,
               a_patho_osteo_articulaire,
               a_patho_psycho_social,
               a_patho_neuro,
               a_patho_cancero,
               a_patho_circulatoire,
               a_patho_autre,
               id_patient
        FROM pathologies';
    $stmt = $bdd->prepare($query);
    $stmt->execute();
    $patho_count = $stmt->rowCount();

    $erreur_count = 0;
    $patho = new Pathologie($bdd);
    while ($pathologies = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pathologies["a_patho_cardio"] = empty($pathologies["cardio"]) ? "0" : "1";
        $pathologies["a_patho_respiratoire"] = empty($pathologies["respiratoire"]) ? "0" : "1";
        $pathologies["a_patho_metabolique"] = empty($pathologies["metabolique"]) ? "0" : "1";
        $pathologies["a_patho_osteo_articulaire"] = empty($pathologies["osteo_articulaire"]) ? "0" : "1";
        $pathologies["a_patho_psycho_social"] = empty($pathologies["psycho_social"]) ? "0" : "1";
        $pathologies["a_patho_neuro"] = empty($pathologies["neuro"]) ? "0" : "1";
        $pathologies["a_patho_cancero"] = empty($pathologies["cancero"]) ? "0" : "1";
        $pathologies["a_patho_circulatoire"] = empty($pathologies["circulatoire"]) ? "0" : "1";
        $pathologies["a_patho_autre"] = empty($pathologies["autre"]) ? "0" : "1";

        $update_ok = $patho->update($pathologies);
        if (!$update_ok) {
            $erreur_count++;
        }
    }

    echo '<html lang="fr">';;
    echo "Nombre de pathologies = " . ($patho_count) . "<br>";
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
