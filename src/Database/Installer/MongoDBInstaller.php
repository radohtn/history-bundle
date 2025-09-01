<?php

namespace Htn\HistoryBundle\Database\Installer;

use MongoDB\Client;

class MongoDBInstaller implements InstallerInterface
{
    private Client $client;
    private string $database;
    private string $collection;

    public function __construct(Client $client, string $database = 'test', string $collection = 'histories')
    {
        $this->client = $client;
        $this->database = $database;
        $this->collection = $collection;
    }

    public function install(): void
    {
        $col = $this->client->selectDatabase($this->database)->selectCollection($this->collection);
        $col->createIndex(['table_name' => 1]);
        $col->createIndex(['created_at' => 1]);
    }
}
