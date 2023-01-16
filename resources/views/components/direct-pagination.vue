<template>
    <div class="bg-gray-50 p-3 flex justify-between">
        <div class="self-center">
            <h6 class="font-medium">Showing <span class="text-sky-800">{{ data.current_page }}</span> of <span
                class="text-sky-800">{{ data.last_page }}</span> Page(s)</h6>
        </div>
        <div class="flex">
            <Link :href="data.prev_page_url" class="btn-primary text-xs m-1" v-if="data.prev_page_url"><span
                class="mr-2"><i class="far fa-angle-left"></i></span>Prev
            </Link>
            <Link :href="data.next_page_url" class="btn-primary text-xs m-1" v-if="data.next_page_url">Next
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
