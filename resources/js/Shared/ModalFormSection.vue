<script setup>
import { computed, useSlots } from 'vue';

defineEmits(['submitted']);

const hasActions = computed(() => !! useSlots().actions);
</script>

<template>
    <div
        class="mt-5 md:mt-0 px-4 py-5 bg-white sm:p-6 sm:rounded-md"
    >
        <form @submit.prevent="$emit('submitted')">
            <div
                class="px-4 py-5 bg-white sm:p-6 border border-gray-200 sm:rounded-md border-b-1'"
            >
                <div class="space-y-6">
                    <slot name="form" />
                </div>
            </div>

            <div v-if="hasActions" class="flex items-center justify-end py-3 text-right">
                <slot name="actions" />
            </div>
        </form>
    </div>
</template>
