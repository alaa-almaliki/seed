<?php

declare(strict_types=1);

namespace Seed\Actions\Seed\Ddl;

use Exception;
use Laminas\Db\Adapter\Adapter;
use Seed\DbAdapter;
use Symfony\Component\Console\Output\OutputInterface;

class Update
{
    public static function execute(array $config, array $ddl, $output = null): void
    {
        DbAdapter::create($config)->execute(static function (Adapter $adapter) use ($ddl, $output): void {
            foreach ($ddl as $table => $specs) {
                foreach ($specs as $spec) {
                    $update = sprintf('UPDATE %s set %s = "%s"', $table, $spec['field'], $spec['value']);
                    if ($condition = ($spec['condition'] ?? null)) {
                        $update .= ' ' . $condition;
                    }

                    try {
                        $adapter->query($update, Adapter::QUERY_MODE_EXECUTE);
                    } catch (Exception $e) {
                        if ($output instanceof OutputInterface) {
                            $output->writeln("<error>Error updating $table</error>");
                            $output->writeln("<error>". $e->getMessage() ."</error>");
                        }
                    }
                }
            }
        });
    }
}