<template>
<div class="text-white">
    <div class="py-4 border-b border-b-white px-2">
        <h6 class="font-bold text-xl">Profile Settings</h6>
    </div>
    <ul class="divide-y font-semibold">
        <li>
            <Link :href="route('profile.index')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                  :class="{ 'bg-white text-primary-100': page === route('profile.index') }"><span>General Settings</span> </Link>
        </li>

        <li>
            <Link :href="route('profile.security')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                  :class="{ 'bg-white text-primary-100': page === route('profile.security') }"><span>Security Settings</span> </Link>
        </li>

    </ul>

</div>
</template>

<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3";
defineProps({
    page:String
})
</script>

<style scoped>

</style>
