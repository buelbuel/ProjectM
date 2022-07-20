<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="w-full border-0 border-b border-gray-200 hover:border-blue-600 focus:border-blue-600 focus:ring-0 focus:bg-gray-50 hover:bg-gray-50"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
