<script setup>
const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [Number, String],
        required: true,
    },
    tone: {
        type: String,
        default: 'slate',
    },
});

const toneClasses = {
    slate: 'border-slate-200 bg-slate-50 text-slate-800',
    amber: 'border-amber-200 bg-amber-50 text-amber-800',
    blue: 'border-blue-200 bg-blue-50 text-blue-800',
    emerald: 'border-emerald-200 bg-emerald-50 text-emerald-800',
};
</script>

<template>
    <div
        class="rounded-xl border p-5 shadow-sm"
        :class="toneClasses[tone] ?? toneClasses.slate"
    >
        <p class="text-sm font-medium opacity-80">{{ title }}</p>
        <p class="mt-2 text-3xl font-bold leading-none">{{ value }}</p>
    </div>
</template>
