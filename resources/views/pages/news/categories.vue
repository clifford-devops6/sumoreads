<template >
    <Head><title>{{category.name}}</title></Head>
    <reader>
        <template #sidebar>
            <news-menu :page="route('news.category',category.slug)"></news-menu>
        </template>
        <div class="bg-primary-100 py-3 flex justify-center">
            <h1 class="text-lg font-bold text-white">{{category.name}}</h1>
        </div>
        <div class="mx-5">
            <div class="my-10">
                <div class="flex justify-between my-5">
                    <div>
                        <h1 class="font-bold text-3xl">Trending Now</h1>
                    </div>
                    <div class="flex gap-1">
                        <div>
                            <button class="bg-primary-100 text-white h-10 w-10 rounded-lg"><span><i class="fa-solid fa-arrows-retweet"></i></span></button>
                        </div>
                        <div>
                            <select v-model="trending_source" class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                                <option value=""  :selected="true">All Streams</option>
                                <option v-for="source in sources" :value="source.id" :key="source.id">{{source.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <trending :articles="trending.data"></trending>
            </div>
            <div class="my-14">
                <!--latest news filter-->
                <div class="flex justify-between my-3">
                    <div>
                        <h1 class="font-bold text-3xl">Latest News</h1>
                    </div>
                    <div class="flex gap-1">
                        <div>
                            <button @click="$forceUpdate" class="bg-primary-100 text-white h-10 w-10 rounded-lg"><span><i class="fa-solid fa-arrows-retweet"></i></span></button>
                        </div>

                        <div>
                            <select v-model="latest_source" class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                                <option value="">All Streams</option>
                                <option v-for="source in sources" :value="source.id" :key="source.id">{{source.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!--end of latest news filter-->
                <latest-news  :articles="latest.data"></latest-news>
            </div>


        </div>
        <div class="py-3 bg-gray-100">
            <div class="px-5">
                <div class="flex justify-between my-5">
                    <div>
                        <h1 class="font-bold text-3xl">Latest News</h1>
                    </div>
                    <div class="flex gap-1">
                        <div>
                            <button @click="$forceUpdate" class="bg-primary-100 text-white h-10 w-10 rounded-lg"><span><i class="fa-solid fa-arrows-retweet"></i></span></button>
                        </div>
                        <div>
                            <select v-model="source" class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                                <option value="">All Streams</option>
                                <option v-for="source in sources" :value="source.id" :key="source.id">{{source.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <all-news :articles="posts.data" :link="route('news.index')"></all-news>
            </div>
        </div>
    </reader>

</template>

<script setup lang="ts">
import {Head} from "@inertiajs/inertia-vue3";
import Trending from "@/views/components/news/trending.vue";
import LatestNews from "@/views/components/news/latest-news.vue";
import AllNews from "@/views/components/news/all-news.vue";
import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import NewsMenu from "@/views/components/sidebar/news-menu.vue";
import Reader from "@/views/layouts/reader.vue";

let props=defineProps({
    trending:Object,
    category:Object,
    sources:Object,
    latest:Object,
    posts:Object,
    filters:Object
})

//Filter Trending Post

const trending_source=ref(props.filters.trending_source?props.filters.trending_source:'')

watch(trending_source,()=>{
    Inertia.get(route('news.category',props.category.slug),{
        trending_source:trending_source.value
    }, {preserveState:true, replace:true,preserveScroll:true})
})

//filter latest news

const latest_source=ref(props.filters.latest_source?props.filters.latest_source:'')

watch(latest_source,()=>{
    Inertia.get(route('news.category',props.category.slug),{
        latest_source:latest_source.value
    }, {preserveState:true, replace:true,preserveScroll:true})
})

//All news filter
const source=ref<Number>(props.filters.source?props.filters.source:'')

watch(source,()=>{
    Inertia.get(route('news.category',props.category.slug),{
        source:source.value
    }, {preserveState:true, replace:true,preserveScroll:true})
})
</script>

<style scoped>

</style>
