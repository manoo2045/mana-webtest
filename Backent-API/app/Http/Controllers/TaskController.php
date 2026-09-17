<?php
namespace App\Http\Controllers;

use App\Application\Task\CreateTask;
use App\Application\Task\ListTask;
use App\Application\Task\DeleteTask;
use App\Application\Task\UpdateTask;
use Illuminate\Http\Request;

class TaskController
{
    private $createTaskUseCase;
    private $listTaskUseCase;
    private $deleteTaskUseCase;
    private $updateTaskUseCase;

    public function __construct(CreateTask $createTaskUseCase, ListTask $listTaskUseCase, DeleteTask $deleteTaskUseCase, UpdateTask $updateTaskUseCase)
    {
        $this->createTaskUseCase = $createTaskUseCase;
        $this->listTaskUseCase = $listTaskUseCase;
        $this->deleteTaskUseCase = $deleteTaskUseCase;
        $this->updateTaskUseCase = $updateTaskUseCase;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3'],
        ]);

        $task = $this->createTaskUseCase->execute($validated['title']);
        return response()->json($task, 201);
    }

    public function toggle($id)
    {
        $task = $this->updateTaskUseCase->execute($id);
        return response()->json($task, 201);
    }

    public function index()
    {
        $tasks = $this->listTaskUseCase->execute();

        return response()->json($tasks);
    }

    public function destroy($id)
    {
        $this->deleteTaskUseCase->execute($id);
        return response()->json(null, 204);
    }
}