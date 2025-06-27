<?php

declare(strict_types=1);

namespace Seed\Actions\Seed;

use Seed\Actions\Action;
use Seed\Exec;
use Seed\Profile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Sed implements Action
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $sqlFile = SEED_ROOT . '/var/db/' . basename($input->getArgument('file'));
        $expressions =  Profile::load($input->getOption('profile'), 'sed');
        if (!empty($expressions)) {
            $prefix = PHP_OS === 'Darwin' ? "sed -i ''" : "sed -i";
            foreach ($expressions as $expression) {
                $output->writeln("Running sed expression: $expression");
                Exec::create()
                    ->setPrefix($prefix)
                    ->setQuoteCommand(false)
                    ->setCommand(sprintf('"%s" %s', $expression, $sqlFile))
                    ->execute();
            }
            return Command::SUCCESS;
        }

        $output->writeln("No sed replacements found");
        return Command::SUCCESS;
    }
}