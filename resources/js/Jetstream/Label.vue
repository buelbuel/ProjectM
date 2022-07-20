<script setup>
defineProps({
    value: String,
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700 px-3">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
