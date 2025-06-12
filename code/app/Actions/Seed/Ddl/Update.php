<?php

declare(strict_types=1);

namespace Seed\Actions\Seed\Ddl;

use Laminas\Db\Adapter\Adapter;
use Seed\DbAdapter;

class Update
{
    public static function execute(array $config, array $ddl): void
    {
        DbAdapter::create($config)->execute(static function (Adapter $adapter) use ($ddl): void {
            foreach ($ddl as $table => $specs) {
                foreach ($specs as $spec) {
                    $update = sprintf('UPDATE %s set %s = "%s"', $table, $spec['field'], $spec['value']);
                    if ($condition = ($spec['condition'] ?? null)) {
                        $update .= ' ' . $condition;
                    }

                    $adapter->query($update, Adapter::QUERY_MODE_EXECUTE);
                }
            }
        });
    }
}