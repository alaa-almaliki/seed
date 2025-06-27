<?php

declare(strict_types=1);

namespace Seed;

class Exec
{
    private string $prefix = '';
    private string $flag = '-e';
    private bool $quoteCommand = true;
    private string $command = '';
    private bool $debug = false;

    public static function create(): Exec
    {
        return new static();
    }

    public function setPrefix(string $prefix): Exec
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function setFlag(string $flag): Exec
    {
        $this->flag = $flag;
        return $this;
    }

    public function setQuoteCommand(bool $quoteCommand): Exec
    {
        $this->quoteCommand = $quoteCommand;
        return $this;
    }

    public function setCommand(string $command): Exec
    {
        $this->command = $command;
        return $this;
    }

    public function execute(): void
    {
        $command = $this->prefix . " $this->flag \"$this->command\"";
        if ($this->quoteCommand === false) {
            $command = $this->prefix . " $this->flag $this->command";
        }

        if ($this->debug) {
            var_dump($command);
        }

        exec($command);
    }
}