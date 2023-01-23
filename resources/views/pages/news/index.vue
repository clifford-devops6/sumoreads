<template layout="reader">
<Head><title>News Organized</title></Head>
   <div class="mx-5">
       <div class="my-10">
           <trending :articles="trending" :categories="categories" :sources="sources"></trending>
       </div>
       <div class="my-14">
           <latest-news :categories="categories" :sources="sources" :articles="latest.data"></latest-news>
       </div>


   </div>
    <div class="py-3 bg-gray-100">
      <div class="px-5">
          <all-news :categories="categories" :sources="sources"></all-news>
      </div>
    </div>

</template>

<script setup lang="ts">
import {Head} from "@inertiajs/inertia-vue3";
import Trending from "@/views/components/news/trending.vue";
import LatestNews from "@/views/components/news/latest-news.vue";
import AllNews from "@/views/components/news/all-news.vue";
defineProps({
    trending:Object,
    categories:Object,
    sources:Object,
    latest:Object,
    posts:Object
})
</script>

<style scoped>

</style>
