<?php

namespace Sportsante86\Sapa\Event;

use Doctrine\Common\EventManager;
use PDO;
use Sportsante86\Sapa\Model\Antenne;
use Sportsante86\Sapa\Model\Creneau;
use Sportsante86\Sapa\Model\Notification;
use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Model\Structure;
use Sportsante86\Sapa\Model\Territoire;
use Sportsante86\Sapa\Outils\Permissions;

use function Sportsante86\Sapa\Outils\base_url;

final class PatientChangedNotifier
{
    public const onEvaluateurChanged = 'onEvaluateurChanged';
    public const onPatientCreated = 'onPatientCreated';
    public const onPatientArchived = 'onPatientArchived';
    public const onAffectationCreneau = 'onAffectationCreneau';
    public const onAntenneChanged = 'onAntenneChanged';
    public const onEvaluationLate = 'onEvaluationLate';
    public const onPartageDossier = 'onPartageDossier';

    /** @var EventManager */
    private $eventManager;

    public function __construct(EventManager $eventManager)
    {
        $eventManager->addEventListener(
            [
                self::onEvaluateurChanged,
                self::onPatientCreated,
                self::onAffectationCreneau,
                self::onAntenneChanged,
                self::onEvaluationLate,
                self::onPatientArchived,
                self::onPartageDossier
            ],
            $this
        );
    }

    /**
     * Envoie d'une notification à l'évaluateur choisi quand on modifie l'évaluateur d'un patient
     *
     * @param BasicEventArgs $eventArgs
     * @return void
     */
    public function onEvaluateurChanged(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_destinataire']) ||
            empty($eventArgs->getArgs()['id_patient'])) {
            return;
        }

        if ($eventArgs->getSession()['id_user'] != $eventArgs->getArgs()['id_destinataire']) {
            $patient = new Patient($eventArgs->getPdo());
            $item = $patient->readOne($eventArgs->getArgs()['id_patient']);
            if ($item == false) {
                return;
            }
            $names = $item['nom_patient'] . ' ' . $item['prenom_patient'];

            $notification = new Notification($eventArgs->getPdo());
            $notification->create([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'id_destinataire' => $eventArgs->getArgs()['id_destinataire'],
                'id_type_notification' => Notification::TYPE_NOTIFICATION_CHANGEMENT_EVALUATEUR,
                'text_notification' => 'Vous avez été mis évaluateur du patient ' . $names,
            ]);
        }
    }

    /**
     * Envoie d'une notification aux responsables structures quand on modifie l'antenne d'un patient
     *
     * @param BasicEventArgs $eventArgs
     * @return void
     */
    public function onAntenneChanged(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_antenne']) ||
            empty($eventArgs->getArgs()['id_patient'])) {
            return;
        }

        $patient = new Patient($eventArgs->getPdo());
        $item = $patient->readOne($eventArgs->getArgs()['id_patient']);
        if ($item == false) {
            return;
        }
        $names = $item['nom_patient'] . ' ' . $item['prenom_patient'];

        $antenne = new Antenne($eventArgs->getPdo());
        $item_antenne = $antenne->readOne($eventArgs->getArgs()['id_antenne']);
        $nom_antenne = $item_antenne['nom_antenne'] ?? '';

        // envoi de notification aux responsables structures
        $ids = $antenne->getResponsableAntenne($eventArgs->getArgs()['id_antenne']);
        $notification = new Notification($eventArgs->getPdo());

        $notification->createMultiple([
            'id_envoyeur' => $eventArgs->getSession()['id_user'],
            'destinataires' => $ids,
            'id_type_notification' => Notification::TYPE_NOTIFICATION_CHANGEMENT_ANTENNE,
            'text_notification' => 'Le bénéficiaire ' . $names .
                ' a été affecté à l\'antenne ' . $nom_antenne,
        ]);
    }

    /**
     * Envoi d'une notification aux utilisateurs concernés par la création d'un bénéficiaire
     *
     * @param BasicEventArgs $eventArgs
     * @return void
     */
    public function onPatientCreated(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_patient']) ||
            empty($eventArgs->getArgs()['est_non_peps'])) {
            return;
        }

        $est_non_peps = $eventArgs->getArgs()['est_non_peps'] == 'checked';

        $patient = new Patient($eventArgs->getPdo());
        $item = $patient->readOne($eventArgs->getArgs()['id_patient']);
        if ($item == false) {
            return;
        }
        $names = $item['nom_patient'] . ' ' . $item['prenom_patient'];

        $patient_url = base_url(true) .
            'PHP/Patients/AccueilPatient.php?idPatient=' .
            $eventArgs->getArgs()['id_patient'];
        $link = '<a href="' . $patient_url . '" style="font-size: 14px;padding: 0">Voir le bénéficiaire</a>';

        $notification = new Notification($eventArgs->getPdo());

        // envoi de notification aux coordinateurs PEPS du territoire
        // (pas d'envoie si patient non-PEPS
        $permission = new Permissions($eventArgs->getSession());
        if (!$permission->hasRole(Permissions::COORDONNATEUR_PEPS) &&
            !$est_non_peps) {
            $territoire = new Territoire($eventArgs->getPdo());
            $ids = $territoire->getCoordinateurPeps($eventArgs->getSession()['id_territoire']);

            $notification->createMultiple([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'destinataires' => $ids,
                'id_type_notification' => Notification::TYPE_NOTIFICATION_AJOUT,
                'text_notification' => 'Le patient ' . $names . ' a été ajouté.' . $link,
            ]);
        }

        // envoi de notification aux coordinateurs MSS de la structure si le patient est dans une structure MSS
        // (sauf si c'est lui qui l'a créé)
        if (!$permission->hasRole(Permissions::COORDONNATEUR_MSS) &&
            $eventArgs->getSession()['id_statut_structure'] == '1') {
            $structure = new Structure($eventArgs->getPdo());
            $ids = $structure->getCoordinateurMssOuStructureSportive($eventArgs->getSession()['id_structure']);

            $notification->createMultiple([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'destinataires' => $ids,
                'id_type_notification' => Notification::TYPE_NOTIFICATION_AJOUT,
                'text_notification' => 'Le patient ' . $names . ' a été ajouté.' . $link,
            ]);
        }

        // envoi de notification aux responsables structures
        // (sauf si c'est lui qui l'a créé)
        if (!$permission->hasRole(Permissions::RESPONSABLE_STRUCTURE)) {
            $structure = new Structure($eventArgs->getPdo());
            $ids = $structure->getResponsableStructure($eventArgs->getSession()['id_structure']);

            $notification->createMultiple([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'destinataires' => $ids,
                'id_type_notification' => Notification::TYPE_NOTIFICATION_AJOUT,
                'text_notification' => 'Le patient ' . $names . ' a été ajouté.' . $link,
            ]);
        }

        // envoi de notification aux coordinateurs structure sportive de la structure si le patient est dans une structure sportive
        // (sauf si c'est lui qui l'a créé)
        if (!$permission->hasRole(Permissions::COORDONNATEUR_NON_MSS) &&
            $eventArgs->getSession()['id_statut_structure'] == '3') {
            $structure = new Structure($eventArgs->getPdo());
            $ids = $structure->getCoordinateurMssOuStructureSportive($eventArgs->getSession()['id_structure']);

            $notification->createMultiple([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'destinataires' => $ids,
                'id_type_notification' => Notification::TYPE_NOTIFICATION_AJOUT,
                'text_notification' => 'Le patient ' . $names . ' a été ajouté.' . $link,
            ]);
        }
    }

    /**
     * Envoi d'une notification au coordo PEPS et/ou coordo MSS lors de l'archivage d'un patient
     *
     * @param BasicEventArgs $eventArgs
     * @return void
     */
    public function onPatientArchived(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_patient']) ||
            empty($eventArgs->getArgs()['est_non_peps'])) {
            return;
        }

        $est_non_peps = $eventArgs->getArgs()['est_non_peps'] == 'checked';

        $patient = new Patient($eventArgs->getPdo());
        $item = $patient->readOne($eventArgs->getArgs()['id_patient']);
        if ($item == false) {
            return;
        }
        $names = $item['nom_patient'] . ' ' . $item['prenom_patient'];

        $patient_url = base_url(true) .
            'PHP/Patients/AccueilPatient.php?idPatient=' .
            $eventArgs->getArgs()['id_patient'];
        $link = '<a href="' . $patient_url . '" style="font-size: 14px;padding: 0">Voir le bénéficiaire</a>';

        $notification = new Notification($eventArgs->getPdo());

        // envoi de notification aux coordinateurs PEPS du territoire
        // (pas d'envoie si patient non-PEPS
        $permission = new Permissions($eventArgs->getSession());
        if (!$permission->hasRole(Permissions::COORDONNATEUR_PEPS) &&
            !$est_non_peps) {
            $territoire = new Territoire($eventArgs->getPdo());
            $ids = $territoire->getCoordinateurPeps($eventArgs->getSession()['id_territoire']);

            $notification->createMultiple([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'destinataires' => $ids,
                'id_type_notification' => Notification::TYPE_NOTIFICATION_ARCHIVAGE,
                'text_notification' => 'Le patient ' . $names . ' a été archivé.' . $link,
            ]);
        }

        // envoi de notification aux coordinateurs MSS de la structure si le patient est dans une structure MSS
        // (sauf si c'est lui qui l'a créé)
        if (!$permission->hasRole(Permissions::COORDONNATEUR_MSS) &&
            $eventArgs->getSession()['id_statut_structure'] == '1') {
            $structure = new Structure($eventArgs->getPdo());
            $ids = $structure->getCoordinateurMssOuStructureSportive($eventArgs->getSession()['id_structure']);

            $notification->createMultiple([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'destinataires' => $ids,
                'id_type_notification' => Notification::TYPE_NOTIFICATION_ARCHIVAGE,
                'text_notification' => 'Le patient ' . $names . ' a été archivé.' . $link,
            ]);
        }
    }

    /**
     * Envoi d'une notification aux utilisateurs concernés par l'affectation d'un bénéficiaire sur une activité
     *
     * @param BasicEventArgs $eventArgs
     * @return void
     */
    public function onAffectationCreneau(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_patient'])) {
            return;
        }

        $patient = new Patient($eventArgs->getPdo());
        $item = $patient->readOne($eventArgs->getArgs()['id_patient']);
        if ($item == false) {
            return;
        }
        $names = $item['nom_patient'] . ' ' . $item['prenom_patient'];

        // recuperation des créneaux affectés
        $query = "
            SELECT DISTINCT activite_choisie.id_creneau, id_structure
            FROM activite_choisie
            JOIN orientation o on activite_choisie.id_orientation = o.id_orientation
            JOIN creneaux c on activite_choisie.id_creneau = c.id_creneau
            WHERE id_patient = :id_patient";
        $stmt = $eventArgs->getPdo()->prepare($query);
        $stmt->bindValue(':id_patient', $eventArgs->getArgs()['id_patient']);
        if (!$stmt->execute()) {
            return;
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows == false) {
            $rows = [];
        }

        $notification = new Notification($eventArgs->getPdo());
        $creneau = new Creneau($eventArgs->getPdo());
        $structure = new Structure($eventArgs->getPdo());
        foreach ($rows as $row) {
            $creneau_item = $creneau->readOne($row['id_creneau']);

            // envoi de notification aux responsables structures
            $notification->createMultiple([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'destinataires' => $structure->getResponsableStructure($row['id_structure']),
                'id_type_notification' => Notification::TYPE_NOTIFICATION_AFFECTATION_CRENEAU,
                'text_notification' => 'Le bénéficiaire ' . $names .
                    ' a été affecté au créneau ' . $creneau_item['nom_creneau'],
            ]);

            // envoi de notif aux intervenants des creneaux
            $notification->createMultiple([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'destinataires' => $creneau->getUserIds($row['id_creneau']),
                'id_type_notification' => Notification::TYPE_NOTIFICATION_AFFECTATION_CRENEAU,
                'text_notification' => 'Le bénéficiaire ' . $names .
                    ' a été affecté au créneau ' . $creneau_item['nom_creneau'],
            ]);
        }
    }

    /**
     * Envoi d'une notification à l'évaluateur quand un patient à une évaluation en retard
     *
     * @param BasicEventArgs $eventArgs
     * @return void
     */
    public function onEvaluationLate(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_patient'])) {
            return;
        }

        $patient = new Patient($eventArgs->getPdo());
        $item = $patient->readOne($eventArgs->getArgs()['id_patient']);
        if ($item == false) {
            return;
        }
        $names = $item['nom_patient'] . ' ' . $item['prenom_patient'];

        $text_notification = 'L\'évaluation du bénéficiaire ' . $names . ' n\'a pas encore été réalisée.';

        $notification = new Notification($eventArgs->getPdo());
        $notification->create([
            'id_envoyeur' => $item['id_user'],
            'id_destinataire' => $item['id_user'],
            'id_type_notification' => Notification::TYPE_NOTIFICATION_RETARD,
            'text_notification' => $text_notification,
        ]);
    }

    /**
     * Envoi de notifications au coordonnateur PEPS qui reçoit le dossier partagé
     *
     * @param BasicEventArgs $eventArgs
     * @return void
     */
    public function onPartageDossier(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_patient']) ||
            empty($eventArgs->getArgs()['id_destinataire'])) {
            return;
        }

        $patient = new Patient($eventArgs->getPdo());
        $item = $patient->readOne($eventArgs->getArgs()['id_patient']);
        if ($item == false) {
            return;
        }
        $names = $item['nom_patient'] . ' ' . $item['prenom_patient'];

        $patient_url = base_url(true) .
            'PHP/Patients/AccueilPatient.php?idPatient=' .
            $eventArgs->getArgs()['id_patient'];
        $link = '<a href="' . $patient_url . '" style="font-size: 14px;padding: 0">Voir le bénéficiaire</a>';

        $notification = new Notification($eventArgs->getPdo());

        $notification->create([
            'id_envoyeur' => $eventArgs->getSession()['id_user'],
            'id_destinataire' => $eventArgs->getArgs()['id_destinataire'],
            'id_type_notification' => Notification::TYPE_NOTIFICATION_PARTAGE,
            'text_notification' => 'Le dossier de ' . $names . ' vous a été partagé. ' . $link,
        ]);
    }
}