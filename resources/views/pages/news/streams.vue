<template >
    <Head><title>News Organized</title></Head>
    <reader>
        <template #sidebar>
            <news-menu :page="route('news.index')"></news-menu>
        </template>
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
                            <select  v-model="trending_category" class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                                <option value="" selected>All categories</option>
                                <option v-for="category in categories" :value="category.id" :key="category.id">{{category.name}}</option>
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
                            <select v-model="latest_category" class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                                <option value="">All categories</option>
                                <option v-for="category in categories" :value="category.id" :key="category.id">{{category.name}}</option>
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
                            <select v-model="category" class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                                <option value="">All categories</option>
                                <option v-for="category in categories" :value="category.id" :key="category.id">{{category.name}}</option>
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
    categories:Object,
    source:Object,
    latest:Object,
    posts:Object,
    filters:Object
})

//Filter Trending Post
const trending_category=ref(props.filters.trending_category?props.filters.trending_category:'')


watch(trending_category,()=>{
    Inertia.get(route('news.stream',props.source.slug),{
        trending_category:trending_category.value,

    }, {preserveState:true, replace:true,preserveScroll:true})
})

//filter latest news
const latest_category=ref(props.filters.latest_category?props.filters.latest_category:'')


watch(latest_category,()=>{
    Inertia.get(route('news.stream',props.source.slug),{
        latest_category:latest_category.value,

    }, {preserveState:true, replace:true,preserveScroll:true})
})

//All news filter

const category=ref<Number>(props.filters.category?props.filters.category:'')
watch(category,()=>{
    Inertia.get(route('news.stream',props.source.slug),{
        category:category.value,
    }, {preserveState:true, replace:true,preserveScroll:true})
})
</script>

<style scoped>

</style>
