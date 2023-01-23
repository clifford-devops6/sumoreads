<template>
<div>
    <div class="flex justify-between my-8">
        <div>
            <h1 class="font-bold text-3xl">Latest News</h1>
        </div>
        <div class="flex gap-1">
            <div>
                <button class="bg-primary-100 text-white h-10 w-10 rounded-lg"><span><i class="fa-solid fa-arrows-retweet"></i></span></button>
            </div>
            <div>
                <select class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                    <option>All categories</option>
                    <option v-for="category in categories" :value="category.name" :key="category.id">{{category.name}}</option>
                </select>
            </div>
            <div>
                <select class="rounded-lg h-10 focus:border-primary-100 focus:ring-primary-100 w-56">
                    <option>All Streams</option>
                    <option v-for="source in sources" :value="source.name" :key="source.id">{{source.name}}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="my-5">
        <Suspense>
            <posts></posts>
        </Suspense>
    </div>

</div>
</template>

<script setup lang="ts">

import Posts from "@/scripts/use/posts.vue";

let props=defineProps({
    categories:Object,
    sources:Object
})

</script>

