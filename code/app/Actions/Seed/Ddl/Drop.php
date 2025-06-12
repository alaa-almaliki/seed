<?php

declare(strict_types=1);

namespace Seed\Actions\Seed\Ddl;

use Laminas\Db\Adapter\Adapter;
use Seed\DbAdapter;

class Drop
{
    public static function execute(array $config, array $ddl): void
    {
        DbAdapter::create($config)->execute(static function (Adapter $adapter) use ($ddl): void {
            if (!empty($ddl) && !is_array(current($ddl))) {
                $tables = count($ddl) === 1 ? array_pop($ddl) : implode(',', $ddl);
                $adapter->query(sprintf('DROP TABLE IF EXISTS %s', $tables), Adapter::QUERY_MODE_EXECUTE);
            }
        }, false);
    }
}