<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;


class TaskController extends Controller
{
    public function index(Request $request): Response
    {
        $projects = Project::orderBy('name')->get();

        $project = $request->filled('project')
            ? Project::findOrFail($request->integer('project'))
            : $projects->first();

        if ($project) {
            $project->load([
                'tasks' => fn($query) => $query->orderBy('priority'),
            ]);
        }

        return Inertia::render('Tasks/Index', [
            'projects' => $projects,
            'project' => $project,
        ]);
    }

    public function store(
        StoreTaskRequest $request,
        Project $project
    ): RedirectResponse {
        $project->tasks()->create($request->validated());

        return redirect()->route('projects.show', $project);
    }

    public function update(
        UpdateTaskRequest $request,
        Task $task
    ): RedirectResponse {
        $task->update($request->validated());

        return redirect()->route('projects.show', $task->project);
    }

    public function destroy(Task $task): RedirectResponse
    {
        $project = $task->project;

        $task->delete();

        return redirect()->route('projects.show', $project);
    }

    public function reorder(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'tasks' => ['required', 'array'],
            'tasks.*' => ['integer', 'exists:tasks,id'],
        ]);

        DB::transaction(function () use ($validated, $project) {
            foreach ($validated['tasks'] as $index => $taskId) {
                $project->tasks()
                    ->whereKey($taskId)
                    ->update([
                        'priority' => $index + 1,
                    ]);
            }
        });

        return redirect()->route('projects.show', $project);
    }
}
