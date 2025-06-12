<?php

declare(strict_types=1);

namespace Seed\Actions\Seed\Ddl;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;
use Seed\DbAdapter;

class Insert
{
    public static function execute(array $config, array $ddl): void
    {
        DbAdapter::create($config)->execute(static function (Adapter $adapter) use ($ddl): void {
            $sql = new Sql($adapter);
            foreach ($ddl as $table => $inserts) {
                foreach ($inserts as $insertFields) {
                    $insert = $sql->insert($table)
                        ->columns($insertFields)
                        ->values($insertFields);
                    $sql->prepareStatementForSqlObject($insert)->execute();
                }
            }
        });
    }
}