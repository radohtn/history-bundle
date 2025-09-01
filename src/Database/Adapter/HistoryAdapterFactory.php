<?php

namespace Htn\HistoryBundle\Database\Adapter;

use MongoDB\Client;
use PDO;
use RuntimeException;

class HistoryAdapterFactory
{
    public static function create(array $options): AdapterInterface
    {
        if (!empty($options['mongodb'])) {
            $client = new Client($options['mongodb']);
            return new MongoDBAdapter($client);
        }

        if (empty($options['dsn'])) {
            throw new RuntimeException("DSN requis pour MySQL/PostgreSQL/SQLite");
        }

        $pdo = new PDO(
            $options['dsn'],
            $options['user'] ?? null,
            $options['password'] ?? null
        );

        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

        return match ($driver) {
            'mysql'   => new MySQLAdapter($pdo),
            'pgsql'   => new PostgreSQLAdapter($pdo),
            'sqlite'  => new SQLiteAdapter($pdo),
            default   => throw new RuntimeException("Driver non supporté: $driver"),
        };
    }
}
