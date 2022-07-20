<script setup>
import { computed, useSlots } from 'vue';
import JetSectionTitle from './SectionTitle.vue';

defineEmits(['submitted']);

const hasActions = computed(() => !! useSlots().actions);
</script>

<template>
    <div
        class="mt-5 md:mt-0 px-4 py-5 bg-white sm:p-6 sm:rounded-md"
    >
        <JetSectionTitle>
            <template #title>
                <slot name="title" />
            </template>
            <template #description>
                <slot name="description" />
            </template>
        </JetSectionTitle>

        <form @submit.prevent="$emit('submitted')">
            <div
                class="px-4 py-5 bg-white sm:p-6 border border-b-0 border-gray-200"
                :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md border-b-1'"
            >
                <div class="space-y-6">
                    <slot name="form" />
                </div>
            </div>

            <div v-if="hasActions" class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 border border-gray-200 sm:rounded-bl-md sm:rounded-br-md">
                <slot name="actions" />
            </div>
        </form>
    </div>
</template>
