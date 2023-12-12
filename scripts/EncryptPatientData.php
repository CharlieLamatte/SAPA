<?php
/**
 * Script qui permet de crypter les données patients de la BDD
 * (remplace les données non cryptées par une version cryptée)
 */

use Sportsante86\Sapa\Outils\EncryptionManager;

try {
    $root = dirname(__FILE__, 2);
    require $root . '/bootstrap/bootstrap.php';

    $bdd->beginTransaction();

    $query = '
            SELECT p.id_patient,
                   premier_prenom_naissance,
                   nom_naissance,
                   matricule_ins,
                   oid,
                   code_insee_naissance,
                   nom_utilise,
                   prenom_utilise,
                   liste_prenom_naissance,
                   sexe as sexe_patient,
                   date_naissance,
                   p.id_adresse,
                   nom_adresse,
                   complement_adresse,
                   mail_coordonnees         as email_patient,
                   tel_fixe_coordonnees     as tel_fixe_patient,
                   tel_portable_coordonnees as tel_portable_patient
            FROM patients p
                     JOIN coordonnees c ON p.id_patient = c.id_patient
                     JOIN adresse a ON a.id_adresse = p.id_adresse';
    $stmt = $bdd->prepare($query);
    $stmt->execute();
    $patient_count = $stmt->rowCount();

    while ($patient = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // crypter les coordonnees du patient
        $tel_portable_patient = empty($patient['tel_portable_patient']) ? "" : EncryptionManager::encrypt(
            $patient['tel_portable_patient']
        );
        $tel_fixe_patient = empty($patient['tel_fixe_patient']) ? "" : EncryptionManager::encrypt(
            $patient['tel_fixe_patient']
        );
        $email_patient = empty($patient['email_patient']) ? "" : EncryptionManager::encrypt($patient['email_patient']);

        $query_coord_patient = "
            UPDATE coordonnees
            SET 
                tel_portable_coordonnees = :tel_portable_coordonnees,
                tel_fixe_coordonnees = :tel_fixe_coordonnees,
                mail_coordonnees = :mail_coordonnees
            WHERE coordonnees.id_patient = :id_patient";
        $stmt_coord_patient = $bdd->prepare($query_coord_patient);
        $stmt_coord_patient->bindValue(":tel_portable_coordonnees", $tel_portable_patient);
        $stmt_coord_patient->bindValue(":tel_fixe_coordonnees", $tel_fixe_patient);
        $stmt_coord_patient->bindValue(":mail_coordonnees", $email_patient);
        $stmt_coord_patient->bindValue(":id_patient", $patient['id_patient']);
        if (!$stmt_coord_patient->execute()) {
            throw new Exception('Error UPDATE coordonnees du patient id_patient=' . $patient['id_patient']);
        }

        // crypter l'adresse du patient
        $nom_adresse = empty($patient['nom_adresse']) ? "" : EncryptionManager::encrypt($patient['nom_adresse']);
        $complement_adresse = empty($patient['complement_adresse']) ? "" : EncryptionManager::encrypt(
            $patient['complement_adresse']
        );

        $query_adresse_patient = "
            UPDATE adresse
            SET 
                nom_adresse = :nom_adresse,
                complement_adresse = :complement_adresse 
            WHERE id_adresse = :id_adresse";
        $stmt_adresse_patient = $bdd->prepare($query_adresse_patient);
        $stmt_adresse_patient->bindValue(":nom_adresse", $nom_adresse);
        $stmt_adresse_patient->bindValue(":complement_adresse", $complement_adresse);
        $stmt_adresse_patient->bindValue(":id_adresse", $patient['id_adresse']);
        if (!$stmt_adresse_patient->execute()) {
            throw new Exception('Error UPDATE adresse du patient id_patient=' . $patient['id_patient']);
        }

        // crypter les données du patient
        $premier_prenom_naissance = empty($patient['premier_prenom_naissance']) ? "" : EncryptionManager::encrypt(
            $patient['premier_prenom_naissance']
        );
        $nom_naissance = empty($patient['nom_naissance']) ? "" : EncryptionManager::encrypt($patient['nom_naissance']);
        $matricule_ins = empty($patient['matricule_ins']) ? "" : EncryptionManager::encrypt($patient['matricule_ins']);
        $oid = empty($patient['oid']) ? "" : EncryptionManager::encrypt($patient['oid']);
        $code_insee_naissance = empty($patient['code_insee_naissance']) ? "" : EncryptionManager::encrypt(
            $patient['code_insee_naissance']
        );
        $nom_utilise = empty($patient['nom_utilise']) ? "" : EncryptionManager::encrypt($patient['nom_utilise']);
        $prenom_utilise = empty($patient['prenom_utilise']) ? "" : EncryptionManager::encrypt(
            $patient['prenom_utilise']
        );
        $liste_prenom_naissance = empty($patient['liste_prenom_naissance']) ? "" : EncryptionManager::encrypt(
            $patient['liste_prenom_naissance']
        );

        $query_patient = "
            UPDATE patients 
            SET premier_prenom_naissance = :premier_prenom_naissance,
                nom_naissance = :nom_naissance,
                matricule_ins = :matricule_ins,
                oid = :oid,
                code_insee_naissance = :code_insee_naissance,
                nom_utilise = :nom_utilise,
                prenom_utilise = :prenom_utilise,
                liste_prenom_naissance = :liste_prenom_naissance
            WHERE id_patient = :id_patient";
        $stmt_patient = $bdd->prepare($query_patient);
        $stmt_patient->bindValue(":premier_prenom_naissance", $premier_prenom_naissance);
        $stmt_patient->bindValue(":nom_naissance", $nom_naissance);
        $stmt_patient->bindValue(":matricule_ins", $matricule_ins);
        $stmt_patient->bindValue(":oid", $oid);
        $stmt_patient->bindValue(":code_insee_naissance", $code_insee_naissance);
        $stmt_patient->bindValue(":nom_utilise", $nom_utilise);
        $stmt_patient->bindValue(":prenom_utilise", $prenom_utilise);
        $stmt_patient->bindValue(":liste_prenom_naissance", $liste_prenom_naissance);
        $stmt_patient->bindValue(":id_patient", $patient['id_patient']);
        if (!$stmt_patient->execute()) {
            throw new Exception('Error UPDATE patients du patient id_patient=' . $patient['id_patient']);
        }

        // cryter les coordonnées du contact
        $query_select_urgence = '
            SELECT a_contacter_en_cas_urgence.id_coordonnee,
                   nom_coordonnees          as nom_contact_urgence,
                   prenom_coordonnees       as prenom_contact_urgence,
                   tel_fixe_coordonnees     as tel_fixe_contact_urgence,
                   tel_portable_coordonnees as tel_portable_contact_urgence,
                   l.id_lien,
                   l.type_lien
            FROM coordonnees
                     JOIN a_contacter_en_cas_urgence ON coordonnees.id_coordonnees = a_contacter_en_cas_urgence.id_coordonnee
                     JOIN liens l on a_contacter_en_cas_urgence.id_lien = l.id_lien
            WHERE a_contacter_en_cas_urgence.id_patient = :id_patient';
        $stmt_select_urgence = $bdd->prepare($query_select_urgence);
        $stmt_select_urgence->bindValue(':id_patient', $patient['id_patient']);
        $stmt_select_urgence->execute();
        $contact_urgence = $stmt_select_urgence->fetch(PDO::FETCH_ASSOC);
        if ($contact_urgence) {
            $nom_contact_urgence = empty($patient['nom_contact_urgence']) ? "" : EncryptionManager::encrypt(
                $patient['nom_contact_urgence']
            );
            $prenom_contact_urgence = empty($patient['prenom_contact_urgence']) ? "" : EncryptionManager::encrypt(
                $patient['prenom_contact_urgence']
            );
            $tel_fixe_contact_urgence = empty($patient['tel_fixe_contact_urgence']) ? "" : EncryptionManager::encrypt(
                $patient['tel_fixe_contact_urgence']
            );
            $tel_portable_contact_urgence = empty($patient['tel_portable_contact_urgence']) ? "" : EncryptionManager::encrypt(
                $patient['tel_portable_contact_urgence']
            );

            $query_update_urgence = "
                UPDATE coordonnees
                SET 
                    nom_coordonnees = :nom_coordonnees,
                    prenom_coordonnees = :prenom_coordonnees,
                    tel_fixe_coordonnees = :tel_fixe_coordonnees,
                    tel_portable_coordonnees = :tel_portable_coordonnees
                WHERE id_coordonnees = :id_coordonnees";
            $stmt_update_urgence = $bdd->prepare($query_update_urgence);
            $stmt_update_urgence->bindValue(":nom_coordonnees", $nom_contact_urgence);
            $stmt_update_urgence->bindValue(":prenom_coordonnees", $prenom_contact_urgence);
            $stmt_update_urgence->bindValue(":tel_fixe_coordonnees", $tel_fixe_contact_urgence);
            $stmt_update_urgence->bindValue(":tel_portable_coordonnees", $tel_portable_contact_urgence);
            $stmt_update_urgence->bindValue(":id_coordonnees", $contact_urgence['id_coordonnee']);
            if (!$stmt_update_urgence->execute()) {
                throw new Exception(
                    'Error UPDATE coordonnees urgence id_coordonnee=' . $contact_urgence['id_coordonnee']
                );
            }
        }
    }

    $bdd->commit();

    echo '<html lang="fr">';;
    echo "Nombre de patients = " . ($patient_count) . "<br>";;
    echo "Script exécuté avec succès<br>";
} catch (Exception $e) {
    $bdd->rollBack();

    echo '<html lang="fr">';;
    echo "Script non exécuté cause:" . $e->getMessage() . ' line' . $e->getLine();
}
?>
</html>
