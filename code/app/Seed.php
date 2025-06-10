<?php

declare(strict_types=1);

namespace Seed;

use Seed\Actions\Action;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

readonly class Seed
{
    /**
     * @param Action[] $actions
     */
    public function __construct(
        private array $actions
    ) {
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        foreach ($this->actions as $action) {
            $action->execute($input, $output);
            sleep(1);
        }
    }
}