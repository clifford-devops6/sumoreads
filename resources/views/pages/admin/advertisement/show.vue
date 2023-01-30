<template>
<admin>
    <Head><title>{{advert.data.title}}</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">{{advert.data.title}}</h6>
        <template #info>
            <p class="text-sm">
                <span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                Create and run adverts</p>
        </template>
    </title-block>

    <div class="my-10 px-3">
        <div class="grid">
            <img :src="advert.data.image" :alt="advert.data.title">
            <h6 class="my-2 font-bold">Advert Image</h6>
        </div>
        <div class="grid my-3">
            <p>{{advert.data.description}}</p>
            <div class="my-2 flex gap-3">
                <p><span class="text-primary-100 font-bold">Created at:</span> {{new Date(advert.data.created_at).toDateString()}}</p>
                <p><span class="text-primary-100 font-bold">Expires:</span> {{new Date(advert.data.expiry).toDateString()}}</p>
                <p><span class="text-primary-100 font-bold">Status:</span>
                 <span v-if="advert.data.status">Active</span>
                    <span v-else>Inactive</span>
                </p>

            </div>
            <div>
                <Link preserve-scroll :href="route('advertisement.destroy',advert.data.id)" class="btn-danger"  method="delete" as="button">
                    <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete Advert
                </Link>
            </div>
        </div>
    </div>
    <template #sidebar>
        <Sidelink :link="route('advertisement.index')">All Adverts</Sidelink>
    </template>
</admin>
</template>

<script setup lang="ts">
import Admin from "@/views/layouts/admin.vue";
import TitleBlock from "@/views/components/title-block.vue";
import Sidelink from "@/views/components/sidelink.vue";
import {Link} from "@inertiajs/inertia-vue3";


defineProps({
    advert:Object
})
</script>

<style scoped>

</style>
