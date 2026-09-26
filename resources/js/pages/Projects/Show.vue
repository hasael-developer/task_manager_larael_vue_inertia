```vue
<script setup lang="ts">
import { Link, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

interface Task {
    id: number
    name: string
    priority: number
}

interface Project {
    id: number
    name: string
    tasks: Task[]
}

const props = defineProps<{
    project: Project
}>()

// Create
const form = useForm({
    name: '',
    priority: 1,
})

const submit = () => {
    form.post(`/projects/${props.project.id}/tasks`, {
        onSuccess: () => {
            form.reset()
        },
    })
}

// Edit
const editingTaskId = ref<number | null>(null)

const editForm = useForm({
    name: '',
    priority: 1,
})

const startEditing = (task: Task) => {
    editingTaskId.value = task.id
    editForm.name = task.name
    editForm.priority = task.priority
}

const cancelEditing = () => {
    editingTaskId.value = null
    editForm.reset()
}

const updateTask = () => {
    if (editingTaskId.value === null) {
        return
    }

    editForm.put(`/tasks/${editingTaskId.value}`, {
        onSuccess: () => {
            cancelEditing()
        },
    })
}

// Delete
const deleteTask = (id: number) => {
    if (confirm('Are you sure you want to delete this task?')) {
        useForm({}).delete(`/tasks/${id}`)
    }
}

// Drag & Drop
const draggedTaskId = ref<number | null>(null)

const startDrag = (taskId: number) => {
    draggedTaskId.value = taskId
}

const dropTask = (targetTaskId: number) => {
    if (
        draggedTaskId.value === null ||
        draggedTaskId.value === targetTaskId
    ) {
        return
    }

    const tasks = [...props.project.tasks]

    const draggedIndex = tasks.findIndex(
        task => task.id === draggedTaskId.value
    )

    const targetIndex = tasks.findIndex(
        task => task.id === targetTaskId
    )

    const [draggedTask] = tasks.splice(draggedIndex, 1)

    tasks.splice(targetIndex, 0, draggedTask)

    router.patch(
        `/projects/${props.project.id}/tasks/reorder`,
        {
            tasks: tasks.map(task => task.id),
        },
        {
            preserveScroll: true,
        },
    )

    draggedTaskId.value = null
}
</script>

<template>
    <div class="p-6">
        <div class="mb-6">
            <Link
                href="/projects"
                class="text-sm text-gray-600 hover:text-black"
            >
                ← Back to Projects
            </Link>

            <h1 class="mt-2 text-2xl font-semibold">
                {{ project.name }}
            </h1>
        </div>

        <!-- Create Task -->
        <div class="mb-8 max-w-md">
            <h2 class="mb-3 text-lg font-medium">
                Add Task
            </h2>

            <form
                class="space-y-4"
                @submit.prevent="submit"
            >
                <div>
                    <label
                        for="name"
                        class="mb-1 block text-sm font-medium"
                    >
                        Name
                    </label>

                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="w-full rounded-lg border px-3 py-2"
                    />

                    <p
                        v-if="form.errors.name"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.name }}
                    </p>
                </div>

                <div>
                    <label
                        for="priority"
                        class="mb-1 block text-sm font-medium"
                    >
                        Priority
                    </label>

                    <input
                        id="priority"
                        v-model.number="form.priority"
                        type="number"
                        min="1"
                        class="w-full rounded-lg border px-3 py-2"
                    />

                    <p
                        v-if="form.errors.priority"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.priority }}
                    </p>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-lg bg-black px-4 py-2 text-white disabled:opacity-50"
                >
                    {{ form.processing ? 'Creating...' : 'Add Task' }}
                </button>
            </form>
        </div>

        <!-- Tasks -->
        <div>
            <h2 class="mb-3 text-lg font-medium">
                Tasks
            </h2>

            <div class="space-y-2">
                <div
                    v-for="task in project.tasks"
                    :key="task.id"
                    draggable="true"
                    class="rounded-lg border p-4"
                    @dragstart="startDrag(task.id)"
                    @dragover.prevent
                    @drop="dropTask(task.id)"
                >
                    <!-- Edit mode -->
                    <template v-if="editingTaskId === task.id">
                        <form
                            class="space-y-4"
                            @submit.prevent="updateTask"
                        >
                            <div>
                                <label
                                    class="mb-1 block text-sm font-medium"
                                >
                                    Name
                                </label>

                                <input
                                    v-model="editForm.name"
                                    type="text"
                                    class="w-full rounded-lg border px-3 py-2"
                                />

                                <p
                                    v-if="editForm.errors.name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ editForm.errors.name }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="mb-1 block text-sm font-medium"
                                >
                                    Priority
                                </label>

                                <input
                                    v-model.number="editForm.priority"
                                    type="number"
                                    min="1"
                                    class="w-full rounded-lg border px-3 py-2"
                                />

                                <p
                                    v-if="editForm.errors.priority"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ editForm.errors.priority }}
                                </p>
                            </div>

                            <div class="flex gap-2">
                                <button
                                    type="submit"
                                    :disabled="editForm.processing"
                                    class="rounded-lg bg-black px-3 py-1 text-sm text-white disabled:opacity-50"
                                >
                                    Save
                                </button>

                                <button
                                    type="button"
                                    class="rounded-lg border px-3 py-1 text-sm"
                                    @click="cancelEditing"
                                >
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </template>

                    <!-- Display mode -->
                    <template v-else>
                        <div class="flex items-center justify-between">
                            <div>
                                <div>
                                    {{ task.name }}
                                </div>

                                <span class="text-sm text-gray-500">
                                    Priority: {{ task.priority }}
                                </span>
                            </div>

                            <div class="flex gap-2">
                                <button
                                    type="button"
                                    class="rounded-lg border px-3 py-1 text-sm"
                                    @click="startEditing(task)"
                                >
                                    Edit
                                </button>

                                <button
                                    type="button"
                                    class="rounded-lg border px-3 py-1 text-sm text-red-600"
                                    @click="deleteTask(task.id)"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>
```
