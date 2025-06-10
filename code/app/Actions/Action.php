<?php

declare(strict_types=1);

namespace Seed\Actions;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface Action
{
    public function execute(InputInterface $input, OutputInterface $output): int;
}