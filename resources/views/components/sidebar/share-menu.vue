<template>
    <div class="text-white">
        <div class="py-3 border-b border-b-white px-2">
            <h6 class="font-bold text-xl">Sharing</h6>
        </div>
        <ul class="divide-y font-semibold">
            <li :key="user.id" v-for="user in users">
                <Link :href="route('share.show',user.id)" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full"
                      as="button"
                      :class="{ 'bg-white text-primary-100': page === route('share.show',user.id) }">
                    <span><span class="mr-2"><i class="fa-light fa-user"></i></span>{{user.name}}</span> </Link>
            </li>

            <!--<li :key="groups.id" v-for="group in groups">
                <Link :href="route('group.share',group.id)" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full"
                      as="button"
                      :class="{ 'bg-white text-primary-100': page === route('group.share',group.id) }">
                    <span><span class="mr-2"><i class="fa-light fa-users"></i></span>{{group.name}}</span> </Link>
            </li>-->

        </ul>

    </div>
</template>

<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3";
defineProps({
    page:String,
    users:Object,
    groups:Object
})
</script>

<style scoped>

</style>
