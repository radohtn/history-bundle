<?php

namespace Htn\HistoryBundle\Entity;

class History
{
    private string $tableName;
    private string $action;
    private ?string $user;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $tableName, 
        string $action, 
        ?string $user = null
    ) {
        $this->tableName = $tableName;
        $this->action = $action;
        $this->user = $user;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
