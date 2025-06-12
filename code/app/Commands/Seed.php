<?php

declare(strict_types=1);

namespace Seed\Commands;

use Seed\Actions\Seed\Ddl;
use Seed\Actions\Seed\Export;
use Seed\Actions\Seed\Import;
use Seed\Actions\Seed\Sed;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'seed')]
class Seed extends Command
{
    public function __construct()
    {
        parent::__construct('seed');
    }

    protected function configure(): void
    {
        parent::configure();
        $this->addArgument('file', InputArgument::REQUIRED, 'Action');
        $this->addOption('delete-file', mode: InputOption::VALUE_OPTIONAL);
        $this->addOption('profile', mode: InputOption::VALUE_REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $seed = new \Seed\Seed(
            [
                new Sed(),
                new Import(),
                new Ddl(),
                new Export(),
            ]
        );

        $seed->run($input, $output);
        $output->writeln('Done');
        return Command::SUCCESS;
    }
}