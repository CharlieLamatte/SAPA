<?php

namespace Sportsante86\Sapa\Outils;

/**
 * Source: https://stackoverflow.com/a/20075147
 *
 *  with url like: http://stackoverflow.com/questions/2820723/how-to-get-base-url-with-php
 *
 * echo base_url(); //  will produce something like: http://stackoverflow.com/questions/2820723/
 * echo base_url(TRUE); //  will produce something like: http://stackoverflow.com/
 * echo base_url(TRUE, TRUE); || echo base_url(NULL, TRUE); //  will produce something like:
 * http://stackoverflow.com/questions/ echo base_url(NULL, NULL, TRUE); // will produce something like: array(3) {
 *          ["scheme"]=>
 *          string(4) "http"
 *          ["host"]=>
 *          string(12) "stackoverflow.com"
 *          ["path"]=>
 *          string(35) "/questions/2820723/"
 *      }
 *
 * @param bool $atRoot
 * @param bool $atCore
 * @param bool $parse
 * @return array|int|string
 */
function base_url($atRoot = false, $atCore = false, $parse = false)
{
    if (isset($_SERVER['HTTP_HOST'])) {
        $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
        $hostname = $_SERVER['HTTP_HOST'];
        $dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        $core = preg_split(
            '@/@',
            str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))),
            null,
            PREG_SPLIT_NO_EMPTY
        );
        $core = $core[0];

        $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
        $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
        $base_url = sprintf($tmplt, $http, $hostname, $end);
    } else {
        $base_url = 'http://localhost/';
    }

    if ($parse) {
        $base_url = parse_url($base_url);
        if (isset($base_url['path'])) {
            if ($base_url['path'] == '/') {
                $base_url['path'] = '';
            }
        }
    }

    return $base_url;
}
