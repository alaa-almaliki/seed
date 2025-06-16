<?php

declare(strict_types=1);

namespace Seed;

use Laminas\Db\Adapter\Driver\ConnectionInterface;

class Transaction
{
    private ConnectionInterface $connection;
    private bool $transactional;

    public function __construct(
        ConnectionInterface $connection,
        bool                $transactional
    ) {
        $this->connection = $connection;
        $this->transactional = $transactional;
    }

    public function begin(): void
    {
        if ($this->transactional) {
            $this->connection->beginTransaction();
        }
    }

    public function commit(): void
    {
        if ($this->transactional) {
            $this->connection->commit();
        }
    }

    public function rollback(): void
    {
        if ($this->transactional) {
            $this->connection->rollback();
        }
    }
}