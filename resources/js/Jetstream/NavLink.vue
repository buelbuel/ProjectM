<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-pink-600 focus:outline-none transition'
        : 'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-800 hover:text-blue-800 focus:outline-none focus:text-gray-700 transition';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
