```vue
<script setup lang="ts">
import { Link, useForm } from "@inertiajs/vue3";

interface Task {
    id: number;
    name: string;
    priority: number;
}

interface Project {
    id: number;
    name: string;
    tasks: Task[];
}

defineProps<{
    projects: Project[];
}>();

const deleteProject = (id: number) => {
    if (confirm("Are you sure you want to delete this project?")) {
        useForm({}).delete(`/projects/${id}`);
    }
};
</script>

<template>
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Projects</h1>

            <Link
                href="/projects/create"
                class="rounded-lg bg-black px-4 py-2 text-white"
            >
                Create Project
            </Link>
        </div>

        <div class="space-y-4">
            <div
                v-for="project in projects"
                :key="project.id"
                class="rounded-lg border p-4"
            >
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium">
                        {{ project.name }}
                    </h2>

                    <div class="flex gap-2">
                        <Link
                            :href="`/tasks?project=${project.id}`"
                            class="rounded-lg border px-3 py-1 text-sm"
                        >
                            View Tasks
                        </Link>

                        <Link
                            :href="`/projects/${project.id}/edit`"
                            class="rounded border px-3 py-1 text-sm"
                        >
                            Edit
                        </Link>

                        <button
                            type="button"
                            class="rounded border px-3 py-1 text-sm text-red-600"
                            @click="deleteProject(project.id)"
                        >
                            Delete
                        </button>
                    </div>
                </div>

                <ul class="mt-3 space-y-2">
                    <li
                        v-for="task in project.tasks"
                        :key="task.id"
                        class="text-sm"
                    >
                        {{ task.name }}

                        <span class="text-gray-500">
                            — {{ task.priority }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
```
