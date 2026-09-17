<?php
namespace App\Application\Task;

use App\Domain\Task\Entity\Task;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Domain\Task\ValueObject\TaskTitle;

final class UpdateTask
{
    private $repository;

    public function __construct(TaskRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function execute(?int $id): Task
    {
        $task = $this->repository->find($id);
        $task->updateStatus();
        return $this->repository->save($task);
    }
}