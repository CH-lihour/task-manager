<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()->check()) {
        return to_route('dashboard');
    }

    return to_route('login');
});

Route::get('/dashboard', function (Request $request) {
    $tasks = $request->user()->tasks();

    return Inertia::render('Dashboard', [
        'stats' => [
            'total' => $tasks->count(),
            'todo' => (clone $tasks)->where('status', 'todo')->count(),
            'inProgress' => (clone $tasks)->where('status', 'in-progress')->count(),
            'done' => (clone $tasks)->where('status', 'done')->count(),
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

require __DIR__.'/auth.php';
