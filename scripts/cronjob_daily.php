<?php

/**
 * Script qui doit être exécuté une fois par jour.
 *
 * Ce script permet de déclencher des events quand :
 *  - l'émargement d'une séance est en retard
 *  - la réalisation d'une évaluation d'un patient est en retard
 */

use Doctrine\Common\EventManager;
use Sportsante86\Sapa\Event\BasicEventArgs;
use Sportsante86\Sapa\Event\PatientChangedNotifier;
use Sportsante86\Sapa\Event\SeanceChangedNotifier;
use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Model\Seance;

$root = dirname(__FILE__, 2);

include $root . '/BDD/connexion.php';
require $root . '/vendor/autoload.php';

const MIN_DAYS_SEANCE = 1;
$date = new DateTime();
$today = $date->format(DATE_ATOM);

$eventManager = new EventManager();
$eventArgs = new BasicEventArgs([], $bdd);

// émission des events onSeanceEmargementLate
$seanceChangedNotifier = new SeanceChangedNotifier($eventManager);

$seance = new Seance($bdd);
$ids = $seance->getAllSeanceEmargementLate(MIN_DAYS_SEANCE, $today);
foreach ($ids as $id_seance) {
    $eventArgs->setArgs([
        'id_seance' => $id_seance,
    ]);

    $eventManager->dispatchEvent(SeanceChangedNotifier::onSeanceEmargementLate, $eventArgs);
}

// émission des events onEvaluationLate
$patientChangedNotifier = new PatientChangedNotifier($eventManager);

$patient = new Patient($bdd);
$ids = $patient->getAllPatientEvaluationLate($today);
foreach ($ids as $id_patient) {
    $eventArgs->setArgs([
        'id_patient' => $id_patient,
    ]);

    $eventManager->dispatchEvent(PatientChangedNotifier::onEvaluationLate, $eventArgs);
}

echo "Script executed";