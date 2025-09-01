<?php

namespace Htn\HistoryBundle\Command;

use Htn\HistoryBundle\Database\Installer\{MySQLInstaller, PostgreSQLInstaller, SQLiteInstaller, MongoDBInstaller};
use PDO;
use MongoDB\Client;

class InstallCommand implements CommandInterface
{
    public function execute(array $options): void
    {
        if (!empty($options['mongodb'])) {
            $client = new Client($options['mongodb']);
            $installer = new MongoDBInstaller($client);
        } else {
            $pdo = new PDO($options['dsn'], $options['user'] ?? null, $options['password'] ?? null);
            $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

            $installer = match ($driver) {
                'mysql' => new MySQLInstaller($pdo),
                'pgsql' => new PostgreSQLInstaller($pdo),
                'sqlite' => new SQLiteInstaller($pdo),
                default => throw new \RuntimeException("Driver non supporté: $driver"),
            };
        }

        $installer->install();
        echo "✅ Table/Collection 'histories' créée avec succès !\n";
    }
}
