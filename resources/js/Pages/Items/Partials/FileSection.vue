<script setup>
import JetButton from '@/Jetstream/Button.vue';
</script>

<template>
    <div class="p-3 inline-flex justify-between w-full">
        <h3 class="font-semibold text-2xl font-bold text-gray-800 leading-tight">
            Files
        </h3>
        <JetButton @click="createItem()">
            Upload
        </JetButton>
    </div>
    <div class="mt-2 mx-3 bg-gray-50 border border-gray-200 hover:border-blue-600 focus:border-blue-600">
        <div class="text-center text-gray-400 py-12">
            Nothing here yet.
        </div>
    </div>
</template>