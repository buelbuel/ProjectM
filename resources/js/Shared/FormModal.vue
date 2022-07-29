<script setup>
import Modal from '@/Jetstream/Modal.vue';

const emit = defineEmits(['close']);

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const close = () => {
    emit('close');
};
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="text-lg font-black text-gray-600 px-12 pt-6">
            <slot name="title" />
        </div>

        <slot name="content" />
    </Modal>
</template>
