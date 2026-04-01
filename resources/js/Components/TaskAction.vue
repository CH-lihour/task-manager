<script setup>
import { Link } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
import Button from '@/Components/Button.vue';

const props = defineProps({
    editHref: {
        type: String,
        default: null,
    },
    onDelete: {
        type: Function,
        default: null,
    },
});

const emit = defineEmits(['edit', 'delete']);

const handleEdit = () => {
    if (!props.editHref) {
        emit('edit');
    }
};

const handleDelete = () => {
    if (confirm('Are you sure you want to delete this task?')) {
        if (props.onDelete) {
            props.onDelete();
        } else {
            emit('delete');
        }
    }
};
</script>

<template>
    <div class="flex items-center gap-2">
        <!-- Edit Action -->
        <Button
            v-if="editHref"
            :href="editHref"
            variant="warning"
            size="sm"
            class="flex items-center gap-1.5"
        >
            <template #iconLeft>
                <Pencil class="w-3.5 h-3.5" />
            </template>
            Edit
        </Button>
        <Button
            v-else
            variant="warning"
            size="sm"
            class="flex items-center gap-1.5"
            @click="handleEdit"
        >
            <template #iconLeft>
                <Pencil class="w-3.5 h-3.5" />
            </template>
            Edit
        </Button>

        <!-- Delete Action -->
        <Button
            variant="danger"
            size="sm"
            class="flex items-center gap-1.5"
            @click="handleDelete"
        >
            <template #iconLeft>
                <Trash2 class="w-3.5 h-3.5" />
            </template>
            Delete
        </Button>
    </div>
</template>
