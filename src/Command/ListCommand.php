<?php

namespace Htn\HistoryBundle\Command;

class ListCommand implements CommandInterface
{
    private CommandDispatcher $dispatcher;

    public function __construct(CommandDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function execute(array $options): void
    {
        $commands = $this->dispatcher->getCommands();

        echo "📋 Commandes disponibles :\n";
        foreach ($commands as $name => $command) {
            echo "  - $name\n";
        }
    }
}
