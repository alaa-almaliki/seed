<?php

declare(strict_types=1);

namespace Seed\Actions\Profiles;

use Seed\Actions\Action;
use Seed\Profile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Create implements Action
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        if (Profile::create($name = $input->getOption('name'))) {
            $output->writeln("<info>Profile $name created successfully</info>");
            return Command::SUCCESS;
        }

        $output->writeln("<error>Unable to create profile</error>");
        return Command::FAILURE;
    }
}