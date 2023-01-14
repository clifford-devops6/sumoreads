<template>
    <div class="bg-gray-50 p-3 flex justify-between">
        <div class="self-center">
            <h6 class="font-medium">Showing <span class="text-sky-800">{{ data.meta.current_page }}</span> of <span
                class="text-sky-800">{{ data.meta.last_page }}</span> Page(s)</h6>
        </div>
        <div class="flex">
            <Link :href="data.links.prev" class="btn-primary text-xs m-1" v-if="data.links.prev"><span
                class="mr-2"><i class="far fa-angle-left"></i></span>Prev
            </Link>
            <Link :href="data.links.next" class="btn-primary text-xs m-1" v-if="data.links.next">Next
                <span class="ml-2"><i class="far fa-angle-right"></i></span></Link>

        </div>

    </div>
</template>

<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3";
defineProps({
    data:Object
})
</script>

<style scoped>

</style>
