<template layout="main">
<Head><title>{{article.data.title}}</title></Head>
    <div class="my-10 px-28 flex justify-center">
       <div class="w-3/4">
           <div class="my-4">
               <h1 class="font-bold text-2xl">{{article.data.title}}</h1>
           </div>
           <div class="my-3">
               <img :src="article.data.image" :alt="article.data.title" >
               <p class="my-2">{{article.data.description}}</p>
               <div class="flex gap-2">
                   <a class="btn-secondary" :href="article.data.article_url" target="_blank">Read full article</a>
                   <Link  preserve-scroll as="button" method="patch" :href="route('readlist.update',article.data.id)" class="btn-primary" title="Save to read list">Read later<span class="ml-2"><i class="fa-light fa-bookmark"></i></span></Link>
               </div>
           </div>
       </div>
    </div>
</template>

<script setup lang="ts">
import {Head,Link} from "@inertiajs/inertia-vue3";
defineProps({
    article:Object
})

</script>

<style scoped>

</style>
