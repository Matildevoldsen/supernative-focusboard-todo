<?php

namespace App\NativeComponents;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Native\Mobile\Edge\Element;
use Native\Mobile\Edge\NativeComponent;

class Tasks extends NativeComponent
{
    public string $draft = '';

    public int $inputVersion = 0;

    public string $error = '';

    public function add(): void
    {
        $title = trim($this->draft);

        if ($title === '') {
            $this->error = 'Enter a task to add it to your list.';

            return;
        }

        if (mb_strlen($title) > 140) {
            $this->error = 'Keep tasks under 140 characters.';

            return;
        }

        Task::query()->create(['title' => $title]);
        $this->draft = '';
        $this->error = '';
        $this->inputVersion++;
    }

    public function toggle(int $id): void
    {
        $task = Task::query()->findOrFail($id);
        $task->update(['is_complete' => ! $task->is_complete]);
    }

    public function remove(int $id): void
    {
        Task::query()->findOrFail($id)->delete();
    }

    public function render(): Element
    {
        /** @var Collection<int, Task> $tasks */
        $tasks = Task::query()->latest()->get();

        return $this->view('tasks', [
            'tasks' => $tasks,
            'completeCount' => $tasks->where('is_complete', true)->count(),
            'totalCount' => $tasks->count(),
        ]);
    }
}
