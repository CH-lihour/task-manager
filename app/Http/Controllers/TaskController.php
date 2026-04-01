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
            'tasks' => Task::all()
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

        $request->user()->tasks()->create($validated);

        return redirect()->route('tasks.index');
    }
}
