<?php

declare(strict_types=1);

namespace Seed\Actions\Seed\Ddl;

use Laminas\Db\Adapter\Adapter;
use Seed\DbAdapter;

class Truncate
{
    public static function execute(array $config, array $ddl): void
    {
        DbAdapter::create($config)->execute(static function (Adapter $adapter) use ($ddl): void {
            foreach ($ddl as $table) {
                $adapter->query(sprintf('DELETE FROM %s', $table), Adapter::QUERY_MODE_EXECUTE);
            }
        });
    }
}