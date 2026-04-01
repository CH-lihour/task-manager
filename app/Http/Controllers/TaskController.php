<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        return Inertia::render('Task/Index', [
            'tasks' => auth()->user()->tasks()->latest()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Task/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'status' => 'required|in:todo,in-progress,done',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return Inertia::render('Task/Edit', [
            'task' => $task
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'status' => 'required|in:todo,in-progress,done',
        ]);

        $task->update($validated);

        return to_route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return to_route('tasks.index')->with('success', 'Task deleted successfully.');
    }

}
