<?php

use PHPUnit\Framework\TestCase;
use Htn\HistoryBundle\Service\HistoryLogger;
use Htn\HistoryBundle\Database\Adapter\MySQLAdapter;
use Htn\HistoryBundle\Entity\History;

class HistoryLoggerTest extends TestCase
{
    public function testLog()
    {
        $pdo = new PDO('sqlite::memory:'); // DB in-memory
        $pdo->exec("CREATE TABLE histories (id INTEGER PRIMARY KEY, table_name TEXT, action TEXT, user TEXT, created_at TEXT)");

        $adapter = new MySQLAdapter($pdo);
        $logger = new HistoryLogger($adapter);

        $logger->log('users', 'create', 'admin');

        $stmt = $pdo->query("SELECT * FROM histories");
        $rows = $stmt->fetchAll();

        $this->assertCount(1, $rows);
        $this->assertEquals('users', $rows[0]['table_name']);
        $this->assertEquals('create', $rows[0]['action']);
        $this->assertEquals('admin', $rows[0]['user']);
    }
}
