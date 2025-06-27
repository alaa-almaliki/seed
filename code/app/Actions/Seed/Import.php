<?php

declare(strict_types=1);

namespace Seed\Actions\Seed;

use Seed\Actions\Action;
use Seed\Exec;
use Seed\Profile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Import implements Action
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $sqlFile = SEED_ROOT . '/var/db/' . basename($input->getArgument('file'));
        $mysql =  Profile::load($input->getOption('profile'), 'mysql');
        $deleteFile = $input->getOption('delete-file');

        $exec = Exec::create()->setPrefix('mysql -uroot -proot');

        $output->writeln('Creating database ' . $mysql['database']);
        $this->createDatabase($exec, $mysql);

        $output->writeln('Creating user ' . $mysql['username']);
        $this->createUser($exec, $mysql);

        $output->writeln(sprintf('importing database %s from %s', $mysql['database'], $sqlFile));
        $this->importDatabase($exec, $mysql, $sqlFile);

        if ($deleteFile) {
            unlink($sqlFile);
        }

        return Command::SUCCESS;
    }

    private function createUser(Exec $rawSqlCommand, array $mysql): void
    {
        $deleteUserStatement = sprintf(
            'DROP USER IF EXISTS \'%s\'@\'%s\';',
            $mysql['username'],
            $mysql['hostname'],
        );

        $createUserStatement = sprintf(
            'CREATE USER \'%s\'@\'%s\' IDENTIFIED BY \'%s\';',
            $mysql['username'],
            $mysql['hostname'],
            $mysql['password'],
        );

        $privileges = sprintf(
            'GRANT ALL PRIVILEGES ON %s.* TO \'%s\'@\'%s\';',
            $mysql['database'],
            $mysql['username'],
            $mysql['hostname'],
        );

        $rawSqlCommand->setCommand($deleteUserStatement)->execute();
        $rawSqlCommand->setCommand($createUserStatement)->execute();
        $rawSqlCommand->setCommand($privileges)->execute();
        $rawSqlCommand->setCommand('FLUSH PRIVILEGES;')->execute();

        if ($mysql['hostname'] !== 'localhost') {
            $localhostPrivileges = sprintf(
                'GRANT USAGE ON %s.* to \'%s\'@localhost IDENTIFIED BY \'%s\';',
                $mysql['database'],
                $mysql['username'],
                $mysql['password'],
            );

            $rawSqlCommand->setCommand($localhostPrivileges)->execute();


            $localhostPrivilegesWithOptions = sprintf(
                'GRANT ALL PRIVILEGES ON %s.* TO \'%s\'@localhost WITH GRANT OPTION;',
                $mysql['database'],
                $mysql['username'],
            );

            $rawSqlCommand->setCommand($localhostPrivilegesWithOptions)->execute();
            $rawSqlCommand->setCommand('FLUSH PRIVILEGES;')->execute();
        }
    }

    private function createDatabase(Exec $exec, array $mysql): void
    {
        $dropDatabaseStatement = sprintf('DROP DATABASE IF EXISTS %s;', $mysql['database']);
        $createDatabaseStatement = sprintf(
            'CREATE DATABASE %s CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;',
            $mysql['database']
        );

        $exec->setCommand($dropDatabaseStatement)->execute();
        $exec->setCommand('FLUSH PRIVILEGES;')->execute();
        $exec->setCommand($createDatabaseStatement)->execute();
        $exec->setCommand('FLUSH PRIVILEGES;')->execute();
    }

    private function importDatabase(Exec $exec, array $mysql, string $sqlFile): void
    {
        $exec->setCommand('SET SESSION SQL_MODE=\'NO_AUTO_VALUE_ON_ZERO\';')->execute();
        $exec->setFlag('-f')
            ->setQuoteCommand(false)
            ->setCommand($mysql['database'] . ' < ' . $sqlFile)
            ->execute();
    }
}