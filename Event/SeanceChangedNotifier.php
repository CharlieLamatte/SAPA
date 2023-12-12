<?php

namespace Sportsante86\Sapa\Event;

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Model\Notification;
use Sportsante86\Sapa\Model\Seance;
use Sportsante86\Sapa\Model\Structure;
use Sportsante86\Sapa\Outils\Permissions;

final class SeanceChangedNotifier
{
    public const onSeanceCanceled = 'onSeanceCanceled';
    public const onSeanceEmargementLate = 'onSeanceEmargementLate';

    /** @var EventManager */
    private $eventManager;

    public function __construct(EventManager $eventManager)
    {
        $eventManager->addEventListener(
            [
                self::onSeanceCanceled,
                self::onSeanceEmargementLate,
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
    public function onSeanceCanceled(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_seance'])) {
            return;
        }

        // envoi de notification aux responsables structures s'il a été créé par un intervenant
        $permission = new Permissions($eventArgs->getSession());
        if ($permission->hasRole(Permissions::INTERVENANT)) {
            $seance = new Seance($eventArgs->getPdo());
            $item = $seance->readOne($eventArgs->getArgs()['id_seance']);
            if ($item == false) {
                return;
            }

            $text_notification = 'La séance ' . $item['nom_creneau'] . ' prévu le ' . $item['date_seance'] . ' à ' . $item['heure_debut'] . ' à été annulé. Motif:' . $item['motif_annulation'];

            $structure = new Structure($eventArgs->getPdo());
            $ids = $structure->getResponsableStructure($item['id_structure']);

            $notification = new Notification($eventArgs->getPdo());
            $notification->createMultiple([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'destinataires' => $ids,
                'id_type_notification' => Notification::TYPE_NOTIFICATION_ANNULATION,
                'text_notification' => $text_notification,
            ]);
        }
    }

    /**
     * Envoi d'une notification à l'intervenant quand l'émargement d'une séance
     * est en retard
     *
     * @param BasicEventArgs $eventArgs
     * @return void
     */
    public function onSeanceEmargementLate(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_seance'])) {
            return;
        }

        $seance = new Seance($eventArgs->getPdo());
        $item = $seance->readOne($eventArgs->getArgs()['id_seance']);
        if ($item == false) {
            return;
        }

        $text_notification = 'La séance ' . $item['nom_creneau'] . ' du ' . $item['date_seance'] .
            ' à ' . $item['heure_debut'] . ' n\'a pas encore été émargée.';

        $notification = new Notification($eventArgs->getPdo());
        $notification->create([
            'id_envoyeur' => $item['id_user'],
            'id_destinataire' => $item['id_user'],
            'id_type_notification' => Notification::TYPE_NOTIFICATION_RETARD,
            'text_notification' => $text_notification,
        ]);
    }
}