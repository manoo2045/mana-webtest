<?php

namespace App\Domain\Task\Entity;

class Task
{
    public ?int $id;
    public string $title;
    public bool $is_completed;
    public \DateTimeImmutable $createdAt;

    public function __construct(?int $id, string $title, bool $is_completed)
    {
        $this->id = $id;
        $this->title = $title;
        $this->is_completed = $is_completed;
    }

    public static function create(string $title): self
    {
        return new self(null, $title, false);
    }

    public function updateStatus(): void
    {
        $this->is_completed = !$this->is_completed;
    }   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isCompleted(): bool
    {
        return $this->is_completed;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}