<?php 
namespace App\Application\Task;

use App\Domain\Task\Repository\TaskRepositoryInterface;

final class DeleteTask
{
    public function __construct(private TaskRepositoryInterface $repository) {}

    public function execute(int $id): void
    {
        $this->repository->delete($id);
    }
}