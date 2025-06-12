<?php

declare(strict_types=1);

namespace Seed\Actions\Seed\Ddl;

use Laminas\Db\Adapter\Adapter;
use Seed\DbAdapter;

class Delete
{
    public static function execute(array $config, array $ddl): void
    {
        DbAdapter::create($config)->execute(static function (Adapter $adapter) use ($ddl): void {
            foreach ($ddl as $table => $fields) {
                foreach ($fields as $querySegment) {
                    $delete = "DELETE FROM $table $querySegment";
                    $adapter->query($delete, Adapter::QUERY_MODE_EXECUTE);
                }
            }
        });
    }
}