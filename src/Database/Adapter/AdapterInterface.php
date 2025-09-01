<?php

namespace Htn\HistoryBundle\Database;

use Htn\HistoryBundle\Entity\History;

interface AdapterInterface
{
    public function save(History $history): void;
}
