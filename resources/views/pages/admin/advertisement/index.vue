<template>
<admin>
    <Head><title>Advertisement</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">Advertisements</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                Create and run adverts</p>
        </template>
    </title-block>
    <div class="my-10">
        <table class="table-auto w-full mt-3 border-t">
            <thead>
            <tr class="bg-gray-50 h-10 text-teal-900 font-bold text-sm">
                <th class="text-start py-3 px-4">Id</th>
                <th class="text-start py-3 px-4">Title</th>
                <th class="text-start py-3 px-4">Posted on</th>
                <th class="text-start py-3 px-4">Expires</th>
                <th class="text-start py-3 px-4">Status</th>
                <th class="py-3 px-4 text-start">Action</th>


            </tr>
            </thead>
            <tbody>
            <tr class="border-b text-sm" v-if="adverts.data" v-for="advert in adverts.data" :key="advert.id">
                <td class="py-3 px-4">{{ advert.id }}</td>
                <td class="py-3 px-4">{{useTruncate( advert.title,30)}}</td>
                <td>{{new  Date(advert.created_at).toDateString()}}</td>
                <td>{{new Date(advert.expiry).toDateString()}}</td>
                <td>
                    <span v-if="advert.status">Active</span>
                    <span v-else>Inactive</span>
                </td>
                <td class="py-3 px-4">
                    <dropdown placement="bottom">
                        <template #trigger="{ toggle }">
                            <button @click="toggle" >
                                Action <span class="self-center"><i class="far fa-ellipsis-v-alt"></i></span>
                            </button>
                        </template>
                        <div class="shadow w-36">
                            <ul class="divide-y">
                                <li class="hover:bg-gray-100">
                                    <Link class="p-2 w-full h-full text-start" as="button" :href="route('advertisement.show',advert.id)">
                                        <span class="mr-2"><i class="fa-light fa-bookmark"></i></span>View
                                    </Link>
                                </li>
                                <li class="hover:bg-gray-100">
                                    <Link class="p-2 w-full h-full text-start" as="button" :href="route('advertisement.edit',advert.id)">
                                        <span class="mr-2"><i class="fa-light fa-pen"></i></span>Edit
                                    </Link>
                                </li>
                                <li class="hover:bg-gray-100 ">
                                    <Link preserve-scroll :href="route('advertisement.destroy',advert.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
                                        <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete
                                    </Link>
                                </li>

                            </ul>
                        </div>
                    </dropdown>

                </td>

            </tr>


            </tbody>

        </table>

        <pagination :data="adverts"></pagination>
    </div>
    <template #sidebar>
        <Sidelink :link="route('advertisement.create')"><span class="mr-2"><i class="fa-regular fa-plus"></i></span>Create Ads</Sidelink>
    </template>
</admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue"
import Sidelink from "@/views/components/sidelink.vue";
import { Dropdown} from 'flowbite-vue'
import {useTruncate} from "@/scripts/use/useTruncate";
import Pagination from "@/views/components/pagination.vue";
defineProps({
    adverts:Object
})
</script>

<style scoped>

</style>
