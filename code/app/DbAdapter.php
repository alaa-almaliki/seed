<?php

declare(strict_types=1);

namespace Seed;

use Laminas\Db\Adapter\Adapter;
use Throwable;

class DbAdapter
{
    private ?Adapter $dbAdapter = null;
    private static ?self $instance = null;
    private array $config = [];

    public static function create(array $config = []): self
    {
        if (!static::$instance) {
            static::$instance = new self();
            if (!empty($config)) {
                static::$instance->config($config);
            }
        }

        return static::$instance;
    }

    public function execute(callable $fn, bool $transactional = true): void
    {
        $transaction = new Transaction($this->getDbAdapter()->getDriver()?->getConnection(), $transactional);
        try {
            $transaction->begin();
            $this->start();
            $fn($this->getDbAdapter());
            $this->end();
            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function config(array $config): static
    {
        $this->config = $config;
        return $this;
    }

    private function start(): void
    {
        $this->executeRawQuery("SET SQL_MODE=''");
        $this->executeRawQuery("SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0");
        $this->executeRawQuery("SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO'");
    }

    private function end(): void
    {
        $this->executeRawQuery("SET SQL_MODE=IFNULL(@OLD_SQL_MODE,'')");
        $this->executeRawQuery("SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS=0, 0, 1)");
    }

    private function executeRawQuery(string $rawQuery): void
    {
        $this->getDbAdapter()->query($rawQuery, Adapter::QUERY_MODE_EXECUTE);
    }

    private function getDbAdapter(): Adapter
    {

        if ($this->dbAdapter) {
            return $this->dbAdapter;
        }

        $this->dbAdapter = new Adapter($this->config);

        return $this->dbAdapter;
    }
}