<?php

namespace Sportsante86\Sapa\Outils;

use Exception;
use Monolog\Processor\ProcessorInterface;

/**
 * Injects $_ENV['VERSION'] in all records
 */
class SapaVersionProcessor implements ProcessorInterface
{
    public function __invoke(array $record): array
    {
        try {
            $record['extra']['version'] = $_ENV['VERSION'];

            return $record;
        } catch (Exception $exception) {
            return $record;
        }
    }
}