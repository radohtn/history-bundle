<?php

namespace Htn\HistoryBundle\Command;

interface CommandInterface
{
    public function execute(array $options): void;
}
