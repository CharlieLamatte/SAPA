<?php

namespace Sportsante86\Sapa\Event;

use Doctrine\Common\EventArgs;
use PDO;

class BasicEventArgs extends EventArgs
{
    private array $args;
    private array $session;
    private PDO $pdo;

    public function __construct($session, $pdo)
    {
        $this->session = $session;
        $this->pdo = $pdo;
        $this->args = [];
    }

    /**
     * @param $args
     * @return void
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return array
     */
    public function getSession(): array
    {
        return $this->session;
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}