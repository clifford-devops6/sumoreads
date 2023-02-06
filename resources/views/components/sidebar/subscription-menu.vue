<template>
    <div class="text-white">
        <div class="py-4 border-b border-b-white px-2">
            <h6 class="font-bold text-xl">Subscription</h6>
        </div>
        <ul class="divide-y font-semibold">
            <li>
                <Link :href="route('subscription.index')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                      :class="{ 'bg-white text-primary-100': page === route('subscription.index') }"><span>My Subscription</span> </Link>
            </li>

            <li>
                <Link :href="route('profile.index')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                      :class="{ 'bg-white text-primary-100': page === route('profile.index') }"><span>Profile Settings</span> </Link>
            </li>

            <li v-if="auth.role==='Enterprise'">
                <Link :href="route('manage.index')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                      :class="{ 'bg-white text-primary-100': page === route('manage.index') }"><span>Manage Account</span> </Link>
            </li>

        </ul>

    </div>
</template>

<script setup lang="ts">
import {Link, usePage} from "@inertiajs/inertia-vue3";
defineProps({
    page:String
})

const page=usePage()
const auth = page.props.value.auth
</script>

<style scoped>

</style>
