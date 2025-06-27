<?php

declare(strict_types=1);

namespace Seed\Actions\Seed;

use Seed\Actions\Action;
use Seed\Exec;
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

        $output->writeln('Creating dump file');
        $command = sprintf(
            '%s %s > %s',
            $ignoreTables,
            $mysql['database'],
            $outputFile = $this->createOutputFile($mysql['database'])
        );

        Exec::create()
            ->setPrefix('mysqldump ' . implode(' ', $mysqlDump['options']) . ' -uroot -proot ')
            ->setCommand($command)
            ->setQuoteCommand(false)
            ->execute();

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
        return SEED_ROOT . '/var/db/' . implode('-', $file) . '.sql';
    }
}