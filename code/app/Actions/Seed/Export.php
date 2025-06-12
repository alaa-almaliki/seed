<?php

declare(strict_types=1);

namespace Seed\Actions\Seed;

use Seed\Actions\Action;
use Seed\Profile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Export implements Action
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $mysql =  Profile::load($input->getOption('profile'), 'mysql');
        $mysqlDump =  Profile::load($input->getOption('profile'), 'mysqldump');

        $ignoreTables = '';
        if (!empty($mysqlDump['exclude_tables'] ?? [])) {
            foreach ($mysqlDump['exclude_tables'] as $table) {
                $ignoreTables .= sprintf(' --ignore-table=%s.%s ', $mysql['database'], $table);
            }
        }

        $command = sprintf(
            'mysqldump %s -uroot -proot %s %s > %s',
            implode(' ', $mysqlDump['options']),
            $ignoreTables,
            $mysql['database'],
            $this->createDumpFile($mysql['database'])
        );

        $output->writeln('Creating dump file');
        exec($command);
        return Command::SUCCESS;
    }

    private function createDumpFile(string $database): string
    {
        $file = [
            $database,
            'seed',
            date('YmdHi'),
        ];
        return SEED_ROOT . '/db/' . implode('-', $file) . '.sql';
    }
}