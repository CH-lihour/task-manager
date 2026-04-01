<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Button from '@/Components/Button.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    tasks: Array
});
</script>

<template>
    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tasks
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Task List</h3>
                            <Button variant="primary" size="md" :href="route('tasks.create')">
                                Create Task
                            </Button>
                        </div>

                        <div v-if="tasks.length === 0" class="text-center py-10">
                            <p class="text-gray-500 text-lg">No tasks found. Create one to get started!</p>
                        </div>
                        <div v-else class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            URL
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Created
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="task in tasks" :key="task.id" class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ task.title }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span 
                                                class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
                                                :class="{
                                                    'bg-yellow-100 text-yellow-800': task.status === 'todo',
                                                    'bg-blue-100 text-blue-800': task.status === 'in-progress',
                                                    'bg-green-100 text-green-800': task.status === 'done',
                                                }"
                                            >
                                                {{ task.status }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            <a v-if="task.url" :href="task.url" target="_blank" class="text-indigo-600 hover:text-indigo-900 underline">Link</a>
                                            <span v-else>-</span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ new Date(task.created_at).toLocaleDateString() }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
