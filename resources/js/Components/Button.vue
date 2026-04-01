<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    href: {
        type: String,
        default: null,
    },
    type: {
        type: String,
        default: 'button',
    },
    variant: {
        type: String,
        default: 'primary',
    },
    size: {
        type: String,
        default: 'md', 
    },
    loading: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

const baseClasses = 'inline-flex items-center justify-center rounded-lg font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

const variantClasses = {
    primary: 'bg-indigo-600 text-white hover:bg-indigo-700 active:bg-indigo-800 focus:ring-indigo-500 shadow-sm hover:shadow',
    secondary: 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 active:bg-gray-100 focus:ring-gray-400',
    danger: 'bg-red-600 text-white hover:bg-red-700 active:bg-red-800 focus:ring-red-500 shadow-sm hover:shadow',
    warning: 'bg-amber-500 text-white hover:bg-amber-600 active:bg-amber-700 focus:ring-amber-400 shadow-sm hover:shadow',
    success: 'bg-emerald-600 text-white hover:bg-emerald-700 active:bg-emerald-800 focus:ring-emerald-500 shadow-sm hover:shadow',
    outline: 'bg-transparent border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 active:bg-indigo-100 focus:ring-indigo-500',
    ghost: 'bg-transparent text-gray-600 hover:bg-gray-100 active:bg-gray-200 focus:ring-gray-300',
};

const sizeClasses = {
    sm: 'px-3 py-1.5 text-xs',
    md: 'px-5 py-2.5 text-sm',
    lg: 'px-6 py-3.5 text-base',
};

const classes = computed(() => {
    return [
        baseClasses,
        variantClasses[props.variant] || variantClasses.primary,
        sizeClasses[props.size] || sizeClasses.md,
    ].join(' ');
});
</script>

<template>
    <Link v-if="href" :href="href" :class="classes">
        <slot name="iconLeft" />
        <slot />
        <slot name="iconRight" />
    </Link>
    <button v-else :type="type" :class="classes" :disabled="disabled || loading">
        <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <slot name="iconLeft" />
        <span :class="{ 'opacity-0': loading }">
            <slot />
        </span>
        <slot name="iconRight" />
    </button>
</template>
