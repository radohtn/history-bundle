<?php

namespace Htn\HistoryBundle\Service;

use Htn\HistoryBundle\Database\Adapter\AdapterInterface;
use Htn\HistoryBundle\Entity\History;

class HistoryLogger
{
    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function log(string $tableName, string $action, ?string $user = null): void
    {
        $history = new History($tableName, $action, $user);
        $this->adapter->save($history);
    }
}
