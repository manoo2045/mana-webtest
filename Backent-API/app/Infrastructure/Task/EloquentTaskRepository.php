<?php
namespace App\Infrastructure\Task;

use App\Domain\Task\Entity\Task;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Infrastructure\Task\EloquentTaskModel;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    public function all(): array
    {
        return EloquentTaskModel::all()
            ->map(fn (EloquentTaskModel $model) => $this->toDomain($model))
            ->toArray();
    }

    public function find(int $id): ?Task
    {
        $model = EloquentTaskModel::find($id);
        return $model ? $this->toDomain($model) : null;
    }

    public function save(Task $task): Task
    {
        $model = $task->getId() ? EloquentTaskModel::findOrFail($task->getId()) : new EloquentTaskModel();

        $model->title = $task->getTitle();
        $model->is_completed = $task->isCompleted();
        $model->save();

        return $this->toDomain($model);
    }

    public function delete(int $id): void
    {
        EloquentTaskModel::destroy($id);
    }

    private function toDomain(EloquentTaskModel $model): Task
    {
        return new Task(
            $model->id,
            $model->title,
            $model->is_completed
        );
    }
}