<template>
    <div class="py-1">
        <Link :href="link" class="text-sm hover:text-teal-900 font-bold" ><slot>Link</slot></Link>
    </div>
</template>

<script setup lang="ts">
defineProps({
    link:String,

})
import {Link} from "@inertiajs/inertia-vue3";
</script>

<style scoped>

</style>
