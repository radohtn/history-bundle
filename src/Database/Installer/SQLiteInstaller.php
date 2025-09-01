<?php

namespace Htn\HistoryBundle\Database\Installer;

use PDO;

class SQLiteInstaller implements InstallerInterface
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
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                table_name TEXT NOT NULL,
                action TEXT NOT NULL,
                user TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $this->pdo->exec($sql);
    }
}
