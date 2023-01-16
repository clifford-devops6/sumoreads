<template>
    <admin>
        <Head><title>Bug Report</title></Head>
        <title-block>
            <h6 class="font-bold text-sm">Bug Report</h6>
            <template #info>
                <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                    Bug Reported by the User</p>
            </template>
        </title-block>
        <div class="my-10 px-3">
            <h6 class="font-bold text-lg">Reported on {{ new Date(bug.created_at).toDateString() }}</h6>
            <p class="mt-2">{{bug.description}}</p>
            <div v-if="bug.media">
                <h6>Screenshot</h6>
                <img :src="bug.media[0].original_url">
            </div>
            <Link :href="route('bugs.destroy',bug.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
                <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete Report
            </Link>
        </div>
    </admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue"
import {Link} from "@inertiajs/inertia-vue3";

defineProps({
    bug:Object
})
</script>

<style scoped>

</style>
