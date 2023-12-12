<?php

namespace Sportsante86\Sapa\Event;

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Model\Notification;
use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Model\Territoire;
use Sportsante86\Sapa\Outils\Permissions;

use function Sportsante86\Sapa\Outils\base_url;

final class EvaluationChangedNotifier
{
    public const onEvaluationCreated = 'onEvaluationCreated';

    /** @var EventManager */
    private $eventManager;

    public function __construct(EventManager $eventManager)
    {
        $eventManager->addEventListener(
            [
                self::onEvaluationCreated
            ],
            $this
        );
    }

    /**
     * Envoi de notifications aux coordinateurs PEPS du territoire (sauf si l'utilisateur est coordinateur PEPS)
     *
     * @param BasicEventArgs $eventArgs
     * @return void
     */
    public function onEvaluationCreated(BasicEventArgs $eventArgs): void
    {
        if (empty($eventArgs->getArgs()['id_patient']) ||
            empty($eventArgs->getArgs()['id_evaluation'])) {
            return;
        }

        $patient = new Patient($eventArgs->getPdo());
        $item = $patient->readOne($eventArgs->getArgs()['id_patient']);
        if ($item == false) {
            return;
        }
        $names = $item['nom_patient'] . ' ' . $item['prenom_patient'];

        $permission = new Permissions($eventArgs->getSession());
        if (!$permission->hasRole(Permissions::COORDONNATEUR_PEPS)) {
            $territoire = new Territoire($eventArgs->getPdo());
            $ids = $territoire->getCoordinateurPeps($eventArgs->getSession()['id_territoire']);

            $eval_url = base_url(true) . 'PHP/Patients/Evaluation.php?idPatient=' . $eventArgs->getArgs()['id_patient'];

            $link = '<a href="' . $eval_url . '" style="font-size: 14px;padding: 0">Voir les évaluations</a>';

            $notification = new Notification($eventArgs->getPdo());
            $notification->createMultiple([
                'id_envoyeur' => $eventArgs->getSession()['id_user'],
                'destinataires' => $ids,
                'id_type_notification' => Notification::TYPE_NOTIFICATION_EVALUATION,
                'text_notification' => 'L\'évaluation de ' . $names . ' a été réalisé. ' . $link,
            ]);
        }
    }
}