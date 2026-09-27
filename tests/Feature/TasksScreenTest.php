<?php

namespace Tests\Feature;

use App\Models\Task;
use App\NativeComponents\Tasks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Native\Mobile\Testing\Native;
use Tests\TestCase;

class TasksScreenTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_added_and_completed_from_native_screen(): void
    {
        Native::test(Tasks::class)
            ->input('task-input', 'Read chapter one')
            ->tap('add-task')
            ->assertSee('Read chapter one');

        $task = Task::query()->sole();

        Native::test(Tasks::class)
            ->tap('toggle-'.$task->id)
            ->assertSee('1 of 1 tasks done');

        $this->assertTrue($task->fresh()->is_complete);
    }

    public function test_blank_task_is_not_added(): void
    {
        Native::test(Tasks::class)
            ->tap('add-task')
            ->assertSee('Enter a task to add it to your list.');

        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_task_title_limit_is_explained(): void
    {
        Native::test(Tasks::class)
            ->input('task-input', str_repeat('a', 141))
            ->tap('add-task')
            ->assertSee('Keep tasks under 140 characters.');

        $this->assertDatabaseCount('tasks', 0);
    }
}
