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
        $mysql =  Profile::load($profile = $input->getOption('profile'), 'mysql');
        $mysqlDump =  Profile::load($profile, 'mysqldump');

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
            $outputFile = $this->createOutputFile($mysql['database'])
        );

        $output->writeln('Creating dump file');
        exec($command);
        $output->writeln('Dump file created at ' . $outputFile);

        return Command::SUCCESS;
    }

    private function createOutputFile(string $database): string
    {
        $file = [
            $database,
            'seed',
            date('YmdHi'),
        ];
        return SEED_ROOT . '/db/' . implode('-', $file) . '.sql';
    }
}