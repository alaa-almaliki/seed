<?php

declare(strict_types=1);

namespace Seed\Actions\Seed\Ddl;

use Exception;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;
use Seed\DbAdapter;
use Symfony\Component\Console\Output\OutputInterface;

class Insert
{
    public static function execute(array $config, array $ddl, $output = null): void
    {
        DbAdapter::create($config)->execute(static function (Adapter $adapter) use ($ddl, $output): void {
            $sql = new Sql($adapter);
            foreach ($ddl as $table => $inserts) {
                foreach ($inserts as $insertFields) {
                    try {
                        $insert = $sql->insert($table)
                            ->columns($insertFields)
                            ->values($insertFields);
                        $sql->prepareStatementForSqlObject($insert)->execute();
                    } catch (Exception $e) {
                        if ($output instanceof OutputInterface) {
                            $output->writeln("<error>Error inserting into $table</error>");
                            $output->writeln("<error>". $e->getMessage() ."</error>");
                        }
                    }
                }
            }
        });
    }
}