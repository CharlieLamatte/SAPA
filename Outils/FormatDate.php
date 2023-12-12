<?php

namespace Sportsante86\Sapa\Outils;

use DateTime;
use Exception;

/**
 * @param string $date_naissance date au format "AAAA-MM-JJ"
 * @return int|null age ou null en cas d'échec
 */
function age($date_naissance)
{
    try {
        $date = new DateTime($date_naissance);
    } catch (Exception $e) {
        return null;
    }
    $now = new DateTime();
    $interval = $now->diff($date);

    return $interval->y;
}

/**
 * @param string $d date au format "AAAA-MM-JJ"
 * @return string|null date au format "JJ/MM/AAAA" ou null en cas d'échec
 */
function format_date($d)
{
    if (!$d) {
        return null;
    }

    try {
        $date = new DateTime($d);
    } catch (Exception $e) {
        return null;
    }

    return $date->format('d/m/Y');
}

/**
 * @param string $h_deb heure de début au format "hh:mm:ss"
 * @param string $h_fin heure de début au format "hh:mm:ss"
 * @return float|int|null La durée en minutes entre les 2 heures ou null en cas d'échec
 */

function duree_minutes($h_deb, $h_fin)
{
    try {
        $debut = new DateTime($h_deb);
        $fin = new DateTime($h_fin);

        $diff = $debut->diff($fin);

        $minutes = $diff->h * 60;
        $minutes += $diff->i;

        if ($diff->s > 0) {
            $minutes++;
        }

        if ($diff->invert == 1) {
            $minutes = 24 * 60 - $minutes;
        }

        return $minutes;
    } catch (Exception $e) {
        return null;
    }
}

/**
 * @param string $d_deb date au format "AAAA-MM-JJ"
 * @param string $d_fin date au format "AAAA-MM-JJ"
 * @return false|float|null La durée en semaine entre les 2 dates ou null en cas d'échec
 */
function duree_semaines($d_deb, $d_fin)
{
    try {
        $debut = new DateTime($d_deb);
        $fin = new DateTime($d_fin);

        $diff = $debut->diff($fin);

        return ceil($diff->days / 7);
    } catch (Exception $e) {
        return null;
    }
}