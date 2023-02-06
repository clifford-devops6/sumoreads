<template>
<admin>
<Head><title>Dashboard</title></Head>
    <div class="my-10 px-3">
     <div class="grid grid-cols-6 gap-2">

         <div class="col-span-1 border shadow rounded-lg p-2 hover:bg-primary-400">
             <Link class="w-full h-full " :href="route('articles.index')">
                 <div>
                     <h6 class="font-bold my-2 text-lg">Articles</h6>
                     <p><span class="text-primary-100">Available:</span> {{articles}}</p>
                 </div>
             </Link>
         </div>

         <div class="col-span-2 border shadow rounded-lg p-2 hover:bg-primary-400">
             <Link class="w-full h-full " :href="route('advertisement.index')">
                 <div>
                     <h6 class="font-bold my-2 text-lg">Advertisement</h6>
                     <div>
                         <p class="inline-block mr-2"><span class="text-primary-100">Running:</span> {{active_advert}}</p>
                         <p class="inline-block mr-2"><span class="text-primary-100">Scheduled:</span> {{active_advert}}</p>
                         <p class="inline-block mr-2"><span class="text-primary-100">Expired:</span> {{inactive_advert}}</p>
                     </div>
                 </div>
             </Link>
         </div>

         <div class="col-span-1 border shadow rounded-lg p-2 hover:bg-primary-400" :class="{'bg-green-500/30':bugs}">
             <Link class="w-full h-full " :href="route('bugs.index')">
                 <div>
                     <h6 class="font-bold my-2 text-lg">Bug Reports</h6>
                     <p><span class="text-primary-100">Unreviewed:</span> {{bugs}}</p>
                 </div>
             </Link>
         </div>
         <div class="col-span-1 border shadow rounded-lg p-2 hover:bg-primary-400" :class="{'bg-green-500/30':messages}">
             <Link class="w-full h-full " :href="route('messages.index')">
                 <div>
                     <h6 class="font-bold my-2 text-lg">Messages</h6>
                     <p><span class="text-primary-100">Unread:</span> {{messages}}</p>
                 </div>
             </Link>
         </div>

         <div class="col-span-1 border shadow rounded-lg p-2 hover:bg-primary-400">
             <Link class="w-full h-full " :href="route('sources.index')">
                 <div>
                     <h6 class="font-bold my-2 text-lg">Sources</h6>
                     <p><span class="text-primary-100">Available:</span> {{sources}}</p>
                 </div>
             </Link>
         </div>
     </div>
    </div>
</admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, Link} from "@inertiajs/inertia-vue3";
defineProps({
    articles:Number,
    active_advert:Number,
    inactive_advert:Number,
    scheduled_advert:Number,
    bugs:Number,
    messages:Number,
    sources:Number
})
</script>

<style scoped>

</style>
