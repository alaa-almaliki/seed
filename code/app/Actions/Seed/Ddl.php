<?php

declare(strict_types=1);

namespace Seed\Actions\Seed;

use Seed\Actions\Action;
use Seed\Actions\Seed\Ddl\Delete;
use Seed\Actions\Seed\Ddl\Drop;
use Seed\Actions\Seed\Ddl\Insert;
use Seed\Actions\Seed\Ddl\Truncate;
use Seed\Actions\Seed\Ddl\Update;
use Seed\Profile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Ddl implements Action
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $config =  Profile::load($input->getOption('profile'), 'mysql');
        $ddl =  Profile::load($input->getOption('profile'), 'ddl');

        $output->writeln('Executing DDL...');

        $output->writeln('Executing insert statements');
        Insert::execute($config, $ddl['insert']);

        $output->writeln('Executing update statements');
        Update::execute($config, $ddl['update']);

        $output->writeln('Executing delete statements');
        Delete::execute($config, $ddl['delete']);

        $output->writeln('Executing truncate statements');
        Truncate::execute($config, $ddl['truncate']);

        $output->writeln('Executing drop statements');
        Drop::execute($config, $ddl['drop']);

        return Command::SUCCESS;
    }
}