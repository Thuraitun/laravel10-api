<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = QueryBuilder::for(Task::class)
            ->allowedFilters('is_done')
            ->defaultSort('-created_at')
            ->allowedSorts('title', 'is_done', 'created_at')
            ->paginate();
        return new TaskCollection($task);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create($validated);

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();
        $task->update($validated);

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
