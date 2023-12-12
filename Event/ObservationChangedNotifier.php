<?php

namespace Sportsante86\Sapa\Event;

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Model\Intervenant;
use Sportsante86\Sapa\Model\Notification;
use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Model\Structure;
use Sportsante86\Sapa\Model\Territoire;
use Sportsante86\Sapa\Outils\Permissions;

use function Sportsante86\Sapa\Outils\base_url;

class ObservationChangedNotifier
{
    public const onObservationSanteCreated = 'onObservationSanteCreated';

    /** @var EventManager */
    private $eventManager;

    public function __construct(EventManager $eventManager)
    {
        $eventManager->addEventListener(
            [
                self::onObservationSanteCreated,
            ],
            $this
        );
    }

    /**
     * Envoi d'une notification aux responsables de structure quand une seance
     * est annulée
     *
     * @param BasicEventArgs $eventArgs
     * @return void
     */
    public function onObservationSanteCreated(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_patient'])) {
            return;
        }

        $patient = new Patient($eventArgs->getPdo());
        $item = $patient->readOne($eventArgs->getArgs()['id_patient']);
        if (!$item) {
            return;
        }

        $names = $item['nom_patient'] . ' ' . $item['prenom_patient'];

        $page_sante_url = base_url(true) . 'PHP/Patients/Sante.php?idPatient=' . $eventArgs->getArgs()['id_patient'];
        $link = '<a href="' . $page_sante_url . '" style="font-size: 14px;padding: 0">Voir les observations de santé</a>';
        $text_notification = 'Des observations de santé ont été ajouté pour ' . $names . '. ' . $link;

        $id_user = $eventArgs->getSession()['id_user'];

        $notification = new Notification($eventArgs->getPdo());
        $permission = new Permissions($eventArgs->getSession());

        // envoi de notifications aux responsables de structure
        $structure = new Structure($eventArgs->getPdo());
        $ids = $structure->getResponsableStructure($item['id_structure']) ?? [];
        // on filtre pour ne pas envoyer de notifs à l'utilisateur actuel
        $ids = array_filter($ids, function ($var) use ($id_user) {
            return $id_user != $var;
        });

        $notification->createMultiple([
            'id_envoyeur' => $eventArgs->getSession()['id_user'],
            'destinataires' => $ids,
            'id_type_notification' => Notification::TYPE_NOTIFICATION_AJOUT,
            'text_notification' => $text_notification,
        ]);

        // envoi de notifications aux coordinateurs PEPS du territoire
        $territoire = new Territoire($eventArgs->getPdo());
        $ids = $territoire->getCoordinateurPeps($eventArgs->getSession()['id_territoire']) ?? [];
        // on filtre pour ne pas envoyer de notifs à l'utilisateur actuel
        $ids = array_filter($ids, function ($var) use ($id_user) {
            return $id_user != $var;
        });

        $notification->createMultiple([
            'id_envoyeur' => $eventArgs->getSession()['id_user'],
            'destinataires' => $ids,
            'id_type_notification' => Notification::TYPE_NOTIFICATION_AJOUT,
            'text_notification' => $text_notification,
        ]);

        // envoi de notification aux intervenants qui suivent le patient
        $intervenant = new Intervenant($eventArgs->getPdo());
        $ids = $intervenant->getIntervenantsSuivantsPatient($eventArgs->getArgs()['id_patient']) ?? [];
        // on filtre pour ne pas envoyer de notifs à l'utilisateur actuel
        $ids = array_filter($ids, function ($var) use ($id_user) {
            return $id_user != $var;
        });

        $notification->createMultiple([
            'id_envoyeur' => $eventArgs->getSession()['id_user'],
            'destinataires' => $ids,
            'id_type_notification' => Notification::TYPE_NOTIFICATION_AJOUT,
            'text_notification' => $text_notification,
        ]);
    }
}