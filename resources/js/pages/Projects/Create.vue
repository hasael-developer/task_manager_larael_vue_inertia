```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'


const form = useForm({
    name: '',
})

const submit = () => {
    form.post('/projects')
}
</script>

<template>
    <div class="p-6">
        <h1 class="mb-6 text-2xl font-semibold">
            Create Project
        </h1>

        <form
            @submit.prevent="submit"
            class="max-w-md space-y-4"
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

            <button
                type="submit"
                :disabled="form.processing"
                class="rounded-lg bg-black px-4 py-2 text-white disabled:opacity-50"
            >
                {{ form.processing ? 'Creating...' : 'Create Project' }}
            </button>
        </form>
    </div>
</template>
```
