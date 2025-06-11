<?php

declare(strict_types=1);

namespace Seed\Actions\Profiles;

use Seed\Actions\Action;
use Seed\Profile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Scan implements Action
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($profiles = Profile::list()) {
            foreach ($profiles as $idx => $profile) {
                ++$idx;
                $output->writeln("<info>$idx. $profile</info>");
            }
            return Command::SUCCESS;
        }

        $output->writeln("<error>There was error listing profiles</error>");
        return Command::FAILURE;

    }
}