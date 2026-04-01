<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Button from '@/Components/Button.vue';
import TaskAction from '@/Components/TaskAction.vue';
import { Head, router } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

const props = defineProps({
    tasks: Array
});

const deleteTask = (id) => {
    if (confirm('Are you sure you want to delete this task?')) {
        router.delete(route('tasks.destroy', id));
    }
};
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
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg border border-gray-100">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Task List</h3>
                            <Button variant="primary" size="md" :href="route('tasks.create')">
                                <template #iconLeft>
                                    <Plus class="w-4 h-4 mr-2" />
                                </template>
                                Create Task
                            </Button>
                        </div>

                        <div v-if="tasks.length === 0" class="text-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-500 text-lg">No tasks found. Create one to get started!</p>
                        </div>
                        <div v-else class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            URL
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            Created
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="task in tasks" :key="task.id" class="hover:bg-gray-50/50 transition-colors duration-150">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ task.title }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                                            <span
                                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize"
                                                :class="{
                                                    'bg-amber-100 text-amber-800': task.status === 'todo',
                                                    'bg-blue-100 text-blue-800': task.status === 'in-progress',
                                                    'bg-emerald-100 text-emerald-800': task.status === 'done',
                                                }"
                                            >
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full mr-1.5"
                                                    :class="{
                                                        'bg-amber-400': task.status === 'todo',
                                                        'bg-blue-400': task.status === 'in-progress',
                                                        'bg-emerald-400': task.status === 'done',
                                                    }"
                                                ></span>
                                                {{ task.status.replace('-', ' ') }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            <a v-if="task.url" :href="task.url" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-medium inline-flex items-center group">
                                                Link
                                                <svg class="w-3.5 h-3.5 ml-1 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                            </a>
                                            <span v-else class="text-gray-400">N/A</span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            {{ new Date(task.created_at).toLocaleDateString() }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <TaskAction
                                                class="justify-end"
                                                :editHref="route('tasks.edit', task.id)"
                                                :onDelete="() => deleteTask(task.id)"
                                            />
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

