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
        <div class="p-3 flex gap-2 bg-primary-400">
            <div class="flex gap-1 justify-between">
               <div class="self-center">
                   <h6 class="text-primary-100">Status:</h6>
               </div>
                <select v-model="status" class="filter-select">
                    <option value="">All</option>
                    <option value="1">Active</option>
                    <option value="2">Scheduled</option>
                    <option value="3">Inactive</option>
                </select>
            </div>
            <div class="flex gap-1 justify-between">
                <div class="self-center">
                    <h6 class="text-primary-100">Start Date:</h6>
                </div>
               <div>
                   <input v-model="start" type="date" class="filter-select">
               </div>
            </div>
            <div class="flex gap-1 justify-between">
                <div class="self-center">
                    <h6 class="text-primary-100">End Date:</h6>
                </div>
                <div>
                    <input v-model="end" type="date" class="filter-select">
                </div>
            </div>

            <div class="flex gap-1 justify-between">
                <div class="self-center">
                    <h6 class="text-primary-100">Search:</h6>
                </div>
                <div>
                    <input v-model="search" type="search" class="filter-select" placeholder="Search by title...">
                </div>
            </div>
            <div v-show="showReset" class="flex gap-1">
                <button @click="clearFilters" class="btn-primary btn-small">Reset</button>
            </div>
        </div>
        <table class="table-auto w-full  border-t">
            <thead>
            <tr class="bg-gray-50 h-10 text-teal-900 font-bold text-sm">
                <th class="text-start py-3 px-4">Id</th>
                <th class="text-start py-3 px-4">Title</th>
                <th class="text-start py-3 px-4">Posted on</th>
                <th class="text-start py-3 px-4">Start Date</th>
                <th class="text-start py-3 px-4">End Date</th>
                <th class="text-start py-3 px-4">Status</th>
                <th class="py-3 px-4 text-start">Action</th>


            </tr>
            </thead>
            <tbody>
            <tr class="border-b text-sm" v-if="adverts.data" v-for="advert in adverts.data" :key="advert.id">
                <td class="text-start py-3 px-4">{{ advert.id }}</td>
                <td class="text-start py-3 px-4">{{useTruncate( advert.title,30)}}</td>
                <td class="text-start py-3 px-4">{{new  Date(advert.created_at).toDateString()}}</td>
                <td class="text-start py-3 px-4">{{new Date(advert.start).toDateString()}}</td>
                <td class="text-start py-3 px-4">{{new Date(advert.expiry).toDateString()}}</td>
                <td class="text-start py-3 px-4">
                    <span v-if="advert.status===1" class="text-green-600">Active</span>
                    <span v-else-if="advert.status===2" class="text-orange-400">Scheduled</span>
                    <span v-else class="text-red-600">Inactive</span>
                </td>
                <td class="text-start py-3 px-4">
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
import _ from "lodash"
import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
let props=defineProps({
    adverts:Object,
    filters:Object
})
const showReset=ref(false)
const search=ref(props.filters.search)
const status=ref(props.filters.status?props.filters.status:'')
const start=ref(props.filters.start)
const end=ref(props.filters.end)
watch([search, start,status,end], _.debounce(function (value:any) {
    showReset.value=true
    Inertia.get(route('advertisement.index'),{
        search:search.value,
        start:start.value,
        status:status.value,
        end:end.value
    }, {preserveState:true, replace:true});
}, 300))

const clearFilters=()=>{
    search.value='',
        start.value='',
        status.value='',
        end.value=''

}
</script>

<style scoped>

</style>
