<?php

namespace Tests\Feature\Api\v1\Tasks;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{

    public function test_user_can_store_task()
    {
        $task = Task::factory()->create();
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
}
