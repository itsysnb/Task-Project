<?php

namespace App\Http\Controllers\Api\v1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   \App\Http\Requests\TaskRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
