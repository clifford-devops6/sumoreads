<template>
<admin>
    <Head><title>Sources</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">News Sources</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                These sources are used to fetch news fro the api</p>
        </template>
    </title-block>
    <div class="my-10">
        <div class="flex justify-end mt-5">

            <div >

                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input v-model="search" type="search" id="product-search" class="block p-2 pl-10 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-sky-600 focus:border-sky-600" placeholder="Search products..." required>

                </div>
            </div>
        </div>
        <div>
            <!--table search and name-->
            <table class="table-auto w-full mt-3 border-t">
                <thead>
                <tr class="bg-gray-50 h-10 text-teal-900 font-bold text-sm">
                    <th class="text-start py-3 px-4">Id</th>
                    <th class="text-start py-3 px-4">Logo</th>
                    <th class="text-start py-3 px-4">Name</th>
                    <th class="text-start py-3 px-4">Domain</th>
                    <th class="text-start py-3 px-4">Category</th>
                    <th class="text-start py-3 px-4">Country</th>
                    <th class="text-start py-3 px-4">Pull Status</th>
                    <th class="text-start py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-start">Action</th>


                </tr>
                </thead>
                <tbody>
                <tr class="border-b text-sm" v-if="sources.data" v-for="source in sources.data" :key="source.id">
                    <td class="py-3 px-4">{{ source.id }}</td>
                    <td class="py-3 px-4">
                        <img :src="source.logo" :alt="source.name" class="w-14">
                    </td>
                    <td class="py-3 px-4">{{ source.name }}</td>
                    <td class="py-3 px-4">{{source.domain}}</td>
                    <td class="py-3 px-4">{{source.category.name}}</td>
                    <td class="py-3 px-4 uppercase">{{source.country.code}}</td>
                    <td class="py-3 px-4">
                        <div v-if="source.pulls"><span class="text-gray-800">Fetching</span></div>
                        <div v-else>Retry</div>
                    </td>
                    <td class="py-3 px-4">
                        <span v-if="source.status.name==='Enabled'">Active</span>
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
                                    <li class="hover:bg-gray-100 ">
                                        <Link preserve-scroll :href="route('sources.destroy',source.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
                                            <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete
                                        </Link>
                                    </li>
                                    <li class="hover:bg-gray-100">
                                        <Link class="p-2 w-full h-full text-start" as="button" :href="route('sources.edit',source.id)">
                                            <span class="mr-2"><i class="fal fa-pen"></i></span>Edit
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </dropdown>

                    </td>

                </tr>


                </tbody>

            </table>

        </div>
        <div class="bg-gray-50 p-3 flex justify-between">
            <div class="self-center">
                <h6 class="font-medium">Showing <span class="text-sky-800">{{ sources.meta.current_page }}</span> of <span
                    class="text-sky-800">{{ sources.meta.last_page }}</span> Page(s)</h6>
            </div>
            <div class="flex">
                <Link :href="sources.links.prev" class="btn-primary text-xs m-1" v-if="sources.links.prev"><span
                    class="mr-2"><i class="far fa-angle-left"></i></span>Prev
                </Link>
                <Link :href="sources.links.next" class="btn-primary text-xs m-1" v-if="sources.links.next">Next
                    <span class="ml-2"><i class="far fa-angle-right"></i></span></Link>

            </div>

        </div>
    </div>
    <template #sidebar>
        <sidelink :link="route('sources.create')"><span class="mr-2"><i class="fa-solid fa-plus"></i></span>Add A Source</sidelink>
    </template>
</admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head,Link} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue";
import { Dropdown} from 'flowbite-vue'
import Sidelink from "@/views/components/sidelink.vue";
import {watch,ref} from "vue";
import {Inertia} from "@inertiajs/inertia";
import _ from "lodash";
let props=defineProps({
    sources:Object,
    filters:Object
})
const search=ref(props.filters.search)
watch(search, _.debounce(function (value:any) {
    Inertia.get(route('sources.index'),{
        search:value
    }, {preserveState:true, replace:true});
}, 300))
</script>

<style scoped>

</style>
