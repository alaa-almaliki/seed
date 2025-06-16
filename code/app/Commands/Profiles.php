<?php

declare(strict_types=1);

namespace Seed\Commands;

use Seed\Profile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Profiles extends Command
{
    public function __construct()
    {
        parent::__construct('profiles');
    }

    protected function configure(): void
    {
        parent::configure();
        $this->addArgument('action', InputArgument::REQUIRED, 'Profile Action[create|copy|delete|list]');
        $this->addOption('name', null, InputOption::VALUE_OPTIONAL);
        $this->addOption('source', null, InputOption::VALUE_OPTIONAL);
        $this->addOption('target', null, InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $action = Profile::getAction((string) $input->getArgument('action'));
        return $action->execute($input, $output);
    }
}