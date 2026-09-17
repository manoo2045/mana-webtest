<?php 
namespace App\Application\Task;

use App\Domain\Task\Repository\TaskRepositoryInterface;

class ListTask
{
    private $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        return $this->repository->all();
    }
}