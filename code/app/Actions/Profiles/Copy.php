<?php

declare(strict_types=1);

namespace Seed\Actions\Profiles;

use Seed\Actions\Action;
use Seed\Profile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Copy implements Action
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $source = $input->getOption('source');
        $target = $input->getOption('target');
        if (Profile::copy($source, $target)) {
            $output->writeln("<info>Profile $source copied to $target</info>");
            return Command::SUCCESS;
        }

        $output->writeln("<error>There was an error copying $source to $target</error>");
        return Command::FAILURE;
    }
}