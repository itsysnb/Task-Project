<?php

namespace Tests\Feature\Api\v1\Tasks;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser();
    }

    public function test_user_can_store_task()
    {
        $task = $this->createTask();
        $this->postJson(route('v1.task.store'),[
            'title' => $task->title,
            'description' => $task->description,
            'due_at' => $task->due_at
        ])->assertCreated();

        $this->assertDatabaseHas('tasks', [
            'title' => $task->title,
            'description' => $task->description,
            'due_at' => $task->due_at
        ]);
    }

    public function test_user_can_update_task()
    {
        $task = $this->createTask();
        $this->patchJson(route('v1.task.update', $task->id), ['title' => 'updated task title'])->assertOk();
        $this->assertDatabaseHas('tasks', ['title' => 'updated task title']);
    }

    public function test_user_can_delete_task()
    {
        $task = $this->createTask();
        $this->deleteJson(route('v1.task.delete', $task->id))->assertOk();
        $this->assertDatabaseMissing('tasks', ['title' => $task->title]);
    }
}
