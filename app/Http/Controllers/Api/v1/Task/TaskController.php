<?php

namespace App\Http\Controllers\Api\v1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Jobs\ProcessTask;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json(['tasks' => TaskResource::collection($tasks)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TaskRequest $request)
    {
        $task = Task::create($request->validated());
        ProcessTask::dispatch($task)->delay(now()->addMinutes(2));
        return response()->json(['task' => TaskResource::make($task)], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   \App\Http\Requests\TaskRequest $request
     * @param  \App\Models\Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return response()->json(['data' => 'your task updated success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['data' => 'your task deleted success.']);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'name' =>[
                Rule::in([
                    'today',
                    'tomorrow',
                    'completed',
                    'uncompleted'
                ]),
            ],
        ]);
        $method = $request->get('name');
        return $this->$method();
    }

    public function toggleCompleted(Task $task)
    {
        $task->update([
            'is_completed' => !$task->is_completed,
        ]);
        return $task;
    }

    public function today()
    {
        return Task::whereDate('due_at', Carbon::today())->get();
    }

    public function tomorrow()
    {
        return Task::whereDate('due_at', Carbon::tomorrow())->get();
    }

    public function completed()
    {
        return Task::with('children')->where('is_completed', true)->get();
    }

    public function uncompleted()
    {
        return Task::with('children')->where('is_completed', false)->get();
    }
}
