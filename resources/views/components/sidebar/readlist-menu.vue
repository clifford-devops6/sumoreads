<template>
    <div class="text-white">
        <div class="py-4 border-b border-b-white px-2">
            <h6 class="font-bold text-xl">My Read list</h6>
        </div>
        <ul class="divide-y font-semibold">
            <li>
                <Link :href="route('readlist.index')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                      :class="{ 'bg-white text-primary-100': page === route('readlist.index') }"><span>All</span> </Link>
            </li>
            <li>
                <Link :href="route('unread.readlist')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                      :class="{ 'bg-white text-primary-100': page === route('unread.readlist') }"><span>Unread</span> </Link>
            </li>

            <li>
                <Link :href="route('read.readlist')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                      :class="{ 'bg-white text-primary-100': page === route('read.readlist') }"><span>Read</span> </Link>
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
