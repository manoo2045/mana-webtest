<?php

namespace App\Domain\Task\Repository;

use App\Domain\Task\Entity\Task;

interface TaskRepositoryInterface
{
    public function all(): array;
    public function find(int $id): ?Task;
    public function save(Task $task): Task;
    public function delete(int $id): void;
}