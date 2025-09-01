<?php

namespace Htn\HistoryBundle\Database\Adapter;

use MongoDB\Client;
use Htn\HistoryBundle\Entity\History;

class MongoDBAdapter implements AdapterInterface
{
    private \MongoDB\Collection $collection;

    public function __construct(Client $client, string $database = 'test', string $collection = 'histories')
    {
        $this->collection = $client->selectDatabase($database)->selectCollection($collection);
    }

    public function save(History $history): void
    {
        $createdAt = (new \DateTime())->format(\DateTime::ATOM);
    
        $this->collection->insertOne([
            'table_name' => $history->getTableName(),
            'action' => $history->getAction(),
            'user' => $history->getUser(),
            'created_at' => $createdAt,
        ]);
    }
}
