<?php

declare(strict_types=1);

namespace Seed\Actions\Seed\Ddl;

use Exception;
use Laminas\Db\Adapter\Adapter;
use Seed\DbAdapter;
use Symfony\Component\Console\Output\OutputInterface;

class Delete
{
    public static function execute(array $config, array $ddl, $output = null): void
    {
        DbAdapter::create($config)->execute(static function (Adapter $adapter) use ($ddl, $output): void {
            foreach ($ddl as $table => $fields) {
                foreach ($fields as $querySegment) {
                    try {
                        $delete = "DELETE FROM $table $querySegment";
                        $adapter->query($delete, Adapter::QUERY_MODE_EXECUTE);
                    } catch (Exception $e) {
                        if ($output instanceof OutputInterface) {
                            $output->writeln("<error>Error deleting from $table</error>");
                            $output->writeln("<error>". $e->getMessage() ."</error>");
                        }
                    }
                }
            }
        });
    }
}