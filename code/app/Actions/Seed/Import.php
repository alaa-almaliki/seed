<?php

declare(strict_types=1);

namespace Seed\Actions\Seed;

use Seed\Actions\Action;
use Seed\Profile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Import implements Action
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $sqlFile = SEED_ROOT . '/db/' . basename($input->getArgument('file'));
        $mysql =  Profile::load($input->getOption('profile'), 'mysql');
        $deleteFile = $input->getParameterOption('--delete-file');

        $command = 'mysql -uroot -proot';

        $output->writeln('Creating database ' . $mysql['database']);
        $this->createDatabase($command, $mysql);

        $output->writeln('Creating user ' . $mysql['username']);
        $this->createUser($command, $mysql);

        $output->writeln(sprintf('importing database %s from %s', $mysql['database'], $sqlFile));
        $this->importDatabase($command, $mysql, $sqlFile);

        if ($deleteFile !== null) {
            //unlink($sqlFile);
        }

        return Command::SUCCESS;
    }

    private function createUser(string $command, array $mysql): void
    {
        $deleteUserStatement = sprintf(
            '%s -e "DROP USER IF EXISTS \'%s\'@\'%s\';"',
            $command,
            $mysql['username'],
            $mysql['hostname'],
        );

        $createUserStatement = sprintf(
            '%s -e "CREATE USER \'%s\'@\'%s\' IDENTIFIED BY \'%s\';"',
            $command,
            $mysql['username'],
            $mysql['hostname'],
            $mysql['password'],
        );

        $privileges = sprintf(
            '%s -e "GRANT ALL PRIVILEGES ON %s.* TO \'%s\'@\'%s\';"',
            $command,
            $mysql['database'],
            $mysql['username'],
            $mysql['hostname'],
        );
        
        exec($deleteUserStatement);
        exec($createUserStatement);
        exec($privileges);
        exec($command . ' -e "FLUSH PRIVILEGES;"');

        if ($mysql['hostname'] !== 'localhost') {
            $localhostPrivileges = sprintf(
                '%s -e "GRANT USAGE ON %s.* to \'%s\'@localhost" IDENTIFIED BY \'%s\';',
                $command,
                $mysql['database'],
                $mysql['username'],
                $mysql['password'],
            );

            exec($localhostPrivileges);


            $localhostPrivilegesWithOptions = sprintf(
                '%s -e GRANT ALL PRIVILEGES ON %s.* TO \'%s\'@localhost WITH GRANT OPTION;',
                $command,
                $mysql['database'],
                $mysql['username'],
            );
            exec($localhostPrivilegesWithOptions);
            exec($command . ' -e "FLUSH PRIVILEGES;"');
        }
    }

    private function createDatabase(string $command, array $mysql): void
    {
        $dropDatabaseStatement = sprintf('%s -e "DROP DATABASE IF EXISTS %s;"', $command, $mysql['database']);
        $createDatabaseStatement = sprintf(
            '%s -e "CREATE DATABASE %s CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"',
            $command,
            $mysql['database']
        );


        exec($dropDatabaseStatement);
        exec($command . ' -e "FLUSH PRIVILEGES;"');
        exec($createDatabaseStatement);
        exec($command . ' -e "FLUSH PRIVILEGES;"');
    }

    private function importDatabase(string $command, array $mysql, string $sqlFile): void
    {
        exec(sprintf('%s -e "use %s";', $command, $mysql['database']));
        exec(sprintf('%s -e "SET SESSION SQL_MODE=\'NO_AUTO_VALUE_ON_ZERO\';"', $command));
        exec(sprintf('%s -f %s < %s;', $command, $mysql['database'], $sqlFile));
    }
}