<?php

namespace Htn\HistoryBundle\Database\Adapter;

use PDO;
use Htn\HistoryBundle\Entity\History;

class SQLiteAdapter implements AdapterInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(History $history): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO histories (table_name, action, user, created_at) 
            VALUES (:table_name, :action, :user, :created_at)
        ");

        $stmt->execute([
            ':table_name' => $history->getTableName(),
            ':action'     => $history->getAction(),
            ':user'       => $history->getUser(),
            ':created_at' => $history->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }
}
