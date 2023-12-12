<?php
/**
 * Script à usage unique qui permet de mettre à jour les alds des patients:
 *
 */

?>

<html lang="fr">

<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=sportsanzbtest2;charset=utf8', 'root', 'root');
    $bdd->beginTransaction();

    $query = '
        SELECT id_patient, id_ald, detail
        FROM souffre
        ORDER BY id_patient DESC ';
    $stmt = $bdd->prepare($query);
    if (!$stmt->execute()) {
        throw new Exception("Error: SELECT id_patient, id_ald, detail");
    }

    $rc = $stmt->rowCount();
    echo "Nombre d'alds initial = " . ($rc) . "<br>";;

    $ok = true;

    $imported_count = 0;
    $alds = $stmt->fetchAll(PDO::FETCH_ASSOC);
    for ($i = 0; $i < $rc; $i++) {
        switch ($alds[$i]['id_ald']) {
            case '-1': // Ne se prononce pas
                $id_pathologie_ou_etat = '-1';
                break;
            case '2': // Cancer du sein
                $id_pathologie_ou_etat = '22';
                break;
            case '3': // Cancer colo rectale
                $id_pathologie_ou_etat = '23';
                break;
            case '4': // Cancer de la prostate
                $id_pathologie_ou_etat = '26';
                break;
            case '5': // Autres cancers (si autres cancers, précisez)
                $id_pathologie_ou_etat = '30';
                break;
            case '7': // Arthrose de la hanche
                $id_pathologie_ou_etat = '47';
                break;
            case '8': // Autres arthroses (si autres, précisez)
                $id_pathologie_ou_etat = '50';
                break;
            case '9': // Rhumatisme inflammatoire chronique
                $id_pathologie_ou_etat = '50';
                break;
            case '10': // Spondylarthrite ankylosante
                $id_pathologie_ou_etat = '49';
                break;
            case '11': // Polyarthrite rhumatoïde
                $id_pathologie_ou_etat = '48';
                break;
            case '12': // Autres rhumatismes inflammatoires
                $id_pathologie_ou_etat = '50';
                break;
            case '13': // Surpoids ou obésité
                $id_pathologie_ou_etat = '1'; // TODO
                break;
            case '14': // Hypertension artérielle
                $id_pathologie_ou_etat = '8';
                break;
            case '15': // Diabète de type 1
                $id_pathologie_ou_etat = '19'; // TODO
                break;
            case '16': // Diabète de type 2
                $id_pathologie_ou_etat = '17'; // TODO
                break;
            case '17': // Asthme chronique
                $id_pathologie_ou_etat = '53';
                break;
            case '18': // BPCO
                $id_pathologie_ou_etat = '52';
                break;
            case '19': // Sclérose en plaques
                $id_pathologie_ou_etat = '37';
                break;
            case '20': // Maladie de Parkinson
                $id_pathologie_ou_etat = '38';
                break;
            case '21': // Maladie d’Alzheimer
                $id_pathologie_ou_etat = '36';
                break;
            case '22': // Accident vasculaire cérébral (AVC ou AIT)
                $id_pathologie_ou_etat = '35';
                break;
            case '23': // Dépression ou pathologie anxieuse
                $id_pathologie_ou_etat = '41';
                break;
            case '24': // Démence
                $id_pathologie_ou_etat = '36';
                break;
            case '25': // Schizophrénie
                $id_pathologie_ou_etat = '44';
                break;
            case '26': // Troubles déficit de l’attention
                $id_pathologie_ou_etat = '45';
                break;
            case '27': // Déficience intellectuelle
                $id_pathologie_ou_etat = '73';
                break;
            case '28': // Fracture de la hanche
                $id_pathologie_ou_etat = '73';
                break;
            case '29': // Fracture col du fémur
                $id_pathologie_ou_etat = '73';
                break;
            case '30': // Autres fractures (si autres, précisez)
                $id_pathologie_ou_etat = '73';
                break;
            case '31': // Autre(s) général (si autre, précisez)
                $id_pathologie_ou_etat = '73';
                break;
            default:
                echo "Error: INSERT INTO souffre_de id_patient=" . $alds[$i]['id_patient'] . " id_pathologie_ou_etat=" . ($id_pathologie_ou_etat ?? 'null') . " id_ald=" . $alds[$i]['id_ald'] . "<br>";
                $ok = false;
        }

        $query = '
            INSERT INTO souffre_de (id_patient, id_pathologie_ou_etat) VALUES
            (:id_patient, :id_pathologie_ou_etat)';
        $stmt = $bdd->prepare($query);

        $stmt->bindValue(":id_patient", $alds[$i]['id_patient']);
        $stmt->bindValue(":id_pathologie_ou_etat", $id_pathologie_ou_etat);

        if (!$stmt->execute()) {
            echo "Error: INSERT INTO souffre_de id_patient=" . $alds[$i]['id_patient'] . " id_pathologie_ou_etat=" . ($id_pathologie_ou_etat ?? 'null') . " id_ald=" . $alds[$i]['id_ald'] . "<br>";
            $ok = false;
        } else {
            $imported_count++;
        }
    }

    echo "Script exécuté " . (!$ok ? " avec au moin une erreur:" : " sans erreurs") . "<br>";
    echo "Nombre d'alds importées = " . ($imported_count) . "<br>";;

    $bdd->commit();
} catch (Exception $e) {
    echo "Script non exécuté cause:" . $e->getMessage();
    $bdd->rollBack();
}
?>
</html>
