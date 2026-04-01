<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { X } from 'lucide-vue-next';

const props = defineProps({
    type: {
        type: String,
        default: 'info',
    },
    message: {
        type: String,
        required: true,
    },
    dismissible: {
        type: Boolean,
        default: false,
    },
    autoCloseSeconds: {
        type: Number,
        default: 0,
    },
    pauseOnHover: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);
const intervalId = ref(null);
const remainingMs = ref(0);
const lastTickAt = ref(0);

const clearCloseTimer = () => {
    if (intervalId.value) {
        clearInterval(intervalId.value);
        intervalId.value = null;
    }
};

const closeAlert = () => {
    clearCloseTimer();
    emit('close');
};

const startCloseTimer = () => {
    clearCloseTimer();

    if (remainingMs.value <= 0) {
        closeAlert();
        return;
    }

    lastTickAt.value = Date.now();
    intervalId.value = setInterval(() => {
        const now = Date.now();
        const elapsed = now - lastTickAt.value;
        lastTickAt.value = now;

        remainingMs.value = Math.max(0, remainingMs.value - elapsed);

        if (remainingMs.value <= 0) {
            closeAlert();
        }
    }, 100);
};

const handleMouseEnter = () => {
    if (!props.pauseOnHover || props.autoCloseSeconds <= 0) {
        return;
    }

    if (!intervalId.value) {
        return;
    }

    clearCloseTimer();
};

const handleMouseLeave = () => {
    if (!props.pauseOnHover || props.autoCloseSeconds <= 0) {
        return;
    }

    startCloseTimer();
};

onMounted(() => {
    if (props.autoCloseSeconds > 0) {
        remainingMs.value = props.autoCloseSeconds * 1000;
        startCloseTimer();
    }
});

onBeforeUnmount(() => {
    clearCloseTimer();
});

const secondsLeft = computed(() => Math.ceil(remainingMs.value / 1000));

const classes = computed(() => {
    if (props.type === 'success') {
        return 'border-emerald-200 bg-emerald-50 text-emerald-800';
    }

    if (props.type === 'error') {
        return 'border-red-200 bg-red-50 text-red-800';
    }

    if (props.type === 'warning') {
        return 'border-amber-200 bg-amber-50 text-amber-800';
    }

    return 'border-blue-200 bg-blue-50 text-blue-800';
});
</script>

<template>
    <div
        class="w-full rounded-lg border px-4 py-3 text-sm shadow-sm"
        :class="classes"
        role="alert"
        @mouseenter="handleMouseEnter"
        @mouseleave="handleMouseLeave"
    >
        <div class="flex items-start justify-between gap-3">
            <p class="leading-relaxed">{{ message }}</p>

            <div class="flex items-center gap-2">
                <span
                    v-if="autoCloseSeconds > 0"
                    class="rounded bg-black/5 px-1.5 py-0.5 text-xs font-medium"
                >
                    {{ secondsLeft }}s
                </span>

                <button
                    v-if="dismissible"
                    type="button"
                    class="inline-flex rounded p-1 hover:bg-black/5"
                    aria-label="Close alert"
                    @click="closeAlert"
                >
                    <X class="h-4 w-4" />
                </button>
            </div>
        </div>
    </div>
</template>
