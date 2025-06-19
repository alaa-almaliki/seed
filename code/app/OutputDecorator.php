<?php

declare(strict_types=1);

namespace Seed;

use Symfony\Component\Console\Output\ConsoleOutput;

class OutputDecorator extends ConsoleOutput
{
    public function writeln($messages, int $options = self::OUTPUT_NORMAL)
    {
        if (is_string($messages) && strpos($messages, '<error>') === 0) {
            parent::writeln($messages, $options);
        } else {
            $timestamp = date('Y-m-d H:i:s');
            parent::writeln("<info>[$timestamp]</info> $messages");
        }
    }
}