<?php

declare(strict_types=1);

namespace Seed\Actions\Seed\Ddl;

use Exception;
use Laminas\Db\Adapter\Adapter;
use Seed\DbAdapter;
use Symfony\Component\Console\Output\OutputInterface;

class Drop
{
    public static function execute(array $config, array $ddl, $output = null): void
    {
        DbAdapter::create($config)->execute(static function (Adapter $adapter) use ($ddl, $output): void {
            try {
                if (!empty($ddl) && !is_array(current($ddl))) {
                    $tables = count($ddl) === 1 ? array_pop($ddl) : implode(',', $ddl);
                    $adapter->query(sprintf('DROP TABLE IF EXISTS %s', $tables), Adapter::QUERY_MODE_EXECUTE);
                }
            } catch (Exception $e) {
                if ($output instanceof OutputInterface) {
                    $output->writeln("<error>Error dropping tables</error>");
                    $output->writeln("<error>". $e->getMessage() ."</error>");
                }
            }
        }, false);
    }
}