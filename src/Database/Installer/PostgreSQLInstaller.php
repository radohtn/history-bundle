<?php

namespace Htn\HistoryBundle\Database\Installer;

use PDO;

class PostgreSQLInstaller implements InstallerInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function install(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS histories (
                id SERIAL PRIMARY KEY,
                table_name VARCHAR(255) NOT NULL,
                action VARCHAR(50) NOT NULL,
                user VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $this->pdo->exec($sql);
    }
}
