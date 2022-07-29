<script setup>
import { Link } from '@inertiajs/inertia-vue3'

defineProps({
    links: Array,
});
</script>

<template>
  <div v-if="links.length > 3">
    <div class="btn-group justify-center">
      <template v-for="(link, key) in links">
        <Link v-if="link.url === null" :key="key" class="btn btn-sm btn-disabled" v-html="link.label" />
        <Link v-else :key="`link-${key}`" class="btn btn-sm" :class="{ 'btn-active': link.active }" :href="link.url" v-html="link.label" preserve-scroll />
      </template>
    </div>
  </div>
</template>