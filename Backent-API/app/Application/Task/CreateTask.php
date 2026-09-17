<?php
namespace App\Application\Task;

use App\Domain\Task\Entity\Task;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Domain\Task\ValueObject\TaskTitle;

final class CreateTask
{
    private $repository;

    public function __construct(TaskRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(string $title): Task
    {
        $task = Task::create($title);
        return $this->repository->save($task);
    }
}