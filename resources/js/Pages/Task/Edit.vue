<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Button from '@/Components/Button.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    title: props.task.title,
    url: props.task.url ?? '',
    status: props.task.status,
});

const submit = () => {
    form.put(route('tasks.update', props.task.id));
};
</script>

<template>
    <Head title="Edit Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Task
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg max-w-2xl mx-auto border border-gray-100">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel for="title" value="Title" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                    placeholder="Enter task title"
                                />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div>
                                <InputLabel for="url" value="URL (Optional)" />
                                <TextInput
                                    id="url"
                                    type="url"
                                    class="mt-1 block w-full"
                                    v-model="form.url"
                                    placeholder="https://example.com"
                                />
                                <InputError class="mt-2" :message="form.errors.url" />
                            </div>

                            <div>
                                <InputLabel for="status" value="Status" />
                                <select
                                    id="status"
                                    v-model="form.status"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition-colors"
                                >
                                    <option value="todo">To Do</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="done">Done</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.status" />
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                                <Button
                                    variant="secondary"
                                    :href="route('tasks.index')"
                                >
                                    Cancel
                                </Button>
                                <Button
                                    type="submit"
                                    variant="primary"
                                    :disabled="form.processing"
                                    :loading="form.processing"
                                >
                                    Update Task
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
