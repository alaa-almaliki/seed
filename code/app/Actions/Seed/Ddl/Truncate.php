<?php

declare(strict_types=1);

namespace Seed\Actions\Seed\Ddl;

use Exception;
use Laminas\Db\Adapter\Adapter;
use Seed\DbAdapter;
use Symfony\Component\Console\Output\OutputInterface;

class Truncate
{
    public static function execute(array $config, array $ddl, $output = null): void
    {
        DbAdapter::create($config)->execute(static function (Adapter $adapter) use ($ddl, $output): void {
            foreach ($ddl as $table) {
                try {
                    $adapter->query(sprintf('DELETE FROM %s', $table), Adapter::QUERY_MODE_EXECUTE);
                } catch (Exception $e) {
                    if ($output instanceof OutputInterface) {
                        $output->writeln("<error>Error truncating $table</error>");
                        $output->writeln("<error>". $e->getMessage() ."</error>");
                    }
                }
            }
        });
    }
}