<?php

declare(strict_types=1);

namespace Seed\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Import extends Command
{
    public function __construct()
    {
        parent::__construct('import');
    }

    protected function configure(): void
    {
        parent::configure();
        $this->addArgument('file', InputArgument::REQUIRED, 'Database File need to run seed against');
        $this->addOption('profile', null, InputOption::VALUE_REQUIRED, 'Profile name to use');
        $this->addOption(
            'delete-file',
            null, InputOption::VALUE_NONE,
            'Option to delete the file after seeding',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return (new \Seed\Actions\Seed\Import())->execute($input, $output);
    }
}