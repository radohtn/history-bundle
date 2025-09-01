<?php

namespace Htn\HistoryBundle\Command;

use RuntimeException;

class CommandDispatcher
{
    private array $commands = [];

    public function register(string $name, CommandInterface $command): void
    {
        $this->commands[$name] = $command;
    }

    public function dispatch(string $name, array $options): void
    {
        if (!isset($this->commands[$name])) {
            throw new RuntimeException("Action inconnue: $name");
        }

        $this->commands[$name]->execute($options);
    }

    public function getCommands(): array
    {
        return $this->commands;
    }
}
