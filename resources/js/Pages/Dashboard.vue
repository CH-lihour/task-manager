<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatsCard from '@/Components/StatsCard.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            total: 0,
            todo: 0,
            inProgress: 0,
            done: 0,
        }),
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <StatsCard title="Total Tasks" :value="props.stats.total" tone="slate" />
                    <StatsCard title="To Do" :value="props.stats.todo" tone="amber" />
                    <StatsCard title="In Progress" :value="props.stats.inProgress" tone="blue" />
                    <StatsCard title="Done" :value="props.stats.done" tone="emerald" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
