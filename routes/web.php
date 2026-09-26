<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::resource('projects', ProjectController::class);

    Route::post(
        'projects/{project}/tasks',
        [TaskController::class, 'store']
    )->name('projects.tasks.store');

    Route::put(
        'tasks/{task}',
        [TaskController::class, 'update']
    )->name('tasks.update');

    Route::delete(
        'tasks/{task}',
        [TaskController::class, 'destroy']
    )->name('tasks.destroy');

    Route::patch(
        'projects/{project}/tasks/reorder',
        [TaskController::class, 'reorder']
    )->name('projects.tasks.reorder');

    //route for the tasks display
    Route::get('tasks', [TaskController::class, 'index'])
    ->name('tasks.index');
});

require __DIR__ . '/settings.php';
