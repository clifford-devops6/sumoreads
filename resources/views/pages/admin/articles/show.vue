<template>
<admin>
    <Head><title>Articles</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">{{article.data.title}}</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                {{article.data.title}}</p>
        </template>
    </title-block>
    <div class="my-10 px-3 grid grid-cols-6 gap-3">
      <div class="col-span-2 border shadow p-2">
          <h6 class="font-bold">{{article.data.title}}</h6>
          <div class="text-xs mt-2">
              <p class="inline-block m-1"><span class="mr-2"><i class="fa-solid fa-rss"></i></span>{{article.data.source.name}}</p>
              <p class="inline-block m-1"><span class="mr-2"><i class="fa-light fa-calendar"></i></span>{{new Date(article.data.published).toDateString()}}</p>
          </div>
          <div class="mt-2">
              <img :src="article.data.image">
          </div>
          <div class="mt-2">
              <Link preserve-scroll :href="route('articles.destroy',article.data.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
                  <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete
              </Link>
          </div>
      </div>
        <div class="col-span-4 border shadow p-2">
         <p><span class="font-bold">Description:</span>{{article.data.description}}</p>
            <p class="mt-2">{{article.data.content}}</p>
        </div>
    </div>
</admin>
</template>

<script setup lang="ts">
import Admin from "@/views/layouts/admin.vue";
import {Head, Link} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue"
defineProps({
    article:Object
})
</script>

<style scoped>

</style>
