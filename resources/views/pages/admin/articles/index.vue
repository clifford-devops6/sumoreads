<template>
<admin>
    <Head><title>Articles</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">Articles</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                Articles retrieved from news API</p>
        </template>
    </title-block>
    <div class="my-10">
        <div class="flex justify-end my-5 px-3">

            <div class="flex gap-1">
                <div>
                    <input v-model="search" type="search" placeholder="Search by title" class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                </div>
                <div>
                    <select  v-model="category" class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                        <option value="" selected>All categories</option>
                        <option v-for="category in categories" :value="category.id" :key="category.id">{{category.name}}</option>
                    </select>
                </div>
                <div>
                    <select v-model="source" class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                        <option value=""  :selected="true">All Streams</option>
                        <option v-for="source in sources" :value="source.id" :key="source.id">{{source.name}}</option>
                    </select>
                </div>
            </div>
        </div>
        <table class="table-auto w-full mt-3 border-t">
            <thead>
            <tr class="bg-gray-50 h-10 text-teal-900 font-bold text-sm">
                <th class="text-start py-3 px-4">Id</th>
                <th class="text-start py-3 px-4">Title</th>
                <th class="py-3 px-4 text-start">Action</th>


            </tr>
            </thead>
            <tbody>
            <tr class="border-b text-sm" v-if="articles.data" v-for="article in articles.data" :key="article.id">
                <td class="py-3 px-4">{{ article.id }}</td>
                <td class="py-3 px-4">{{ article.title}}</td>
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
                                    <Link preserve-scroll :href="route('articles.destroy',article.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
                                        <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete
                                    </Link>
                                </li>
                                <li class="hover:bg-gray-100">
                                    <Link class="p-2 w-full h-full text-start" as="button" :href="route('articles.show',article.slug)">
                                        <span class="mr-2"><i class="fa-light fa-bookmark"></i></span>View
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </dropdown>

                </td>

            </tr>


            </tbody>

        </table>

        <pagination :data="articles"></pagination>
    </div>
</admin>
</template>

<script setup lang="ts">
import {Head, Link} from "@inertiajs/inertia-vue3";
import Admin from "@/views/layouts/admin.vue";
import TitleBlock from "@/views/components/title-block.vue"
import { Dropdown} from 'flowbite-vue'
import Pagination from "@/views/components/pagination.vue";
import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
let props=defineProps({
    articles:Object,
    filters:Object,
    sources:Object,
    categories:Object
})

const category=ref(props.filters.category?props.filters.category:'')
const source=ref(props.filters.source?props.filters.source:'')
const search=ref(props.filters.search)
watch([category,source,search],()=>{
    Inertia.get(route('articles.index'),{
        category:category.value,
        source:source.value,
        search:search.value
    }, {preserveState:true, replace:true,preserveScroll:true})
})
</script>

<style scoped>

</style>
