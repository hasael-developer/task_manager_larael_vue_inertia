<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { dashboard } from '@/routes'

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
})
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">
        <div>
            <h1 class="text-2xl font-semibold">
                Dashboard
            </h1>

            <p class="mt-1 text-sm text-muted-foreground">
                Welcome to your workspace.
            </p>
        </div>

        <Link
            href="/projects"
            class="group relative overflow-hidden rounded-xl border border-sidebar-border/70 p-8 transition hover:bg-muted/50 dark:border-sidebar-border"
        >
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-semibold">
                        Task Manager
                    </h2>

                    <p class="mt-2 max-w-lg text-sm text-muted-foreground">
                        Create, organize and manage your tasks and projects.
                    </p>

                    <div
                        class="mt-6 inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground"
                    >
                        Open Task Manager
                        <span class="ml-2 transition-transform group-hover:translate-x-1">
                            →
                        </span>
                    </div>
                </div>
            </div>
        </Link>
    </div>
</template>