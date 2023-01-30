<template>
    <Head><title>My read list</title></Head>
   <reader>
    <template #sidebar>
        <readlist-menu :page="route('unread.readlist')"></readlist-menu>
    </template>
   <div class="px-3">
       <div class="my-10">
           <div v-for="(article, index) in chunk(articles.data,chunker)" :key="index">
               <div class="grid grid-cols-2 gap-2">
                   <div @click="submitPost(post.id)" v-for="post in article" :key="post.id" :class="{'bg-gray-200':post.read_status}">
                       <div class="grid grid-cols-6 gap-1 rounded-lg overflow-hidden h-[150px] border shadow cursor-pointer">
                           <div class="col-span-2 grid bg-cover bg-center bg-black" :style="{ 'background-image': 'url(' + post.article.image + ')' }">

                           </div>
                           <div class="col-span-4 grid p-1 py-2 relative">
                               <h6 class="font-libre font-bold text-lg">{{useTruncate(post.article.title,100)}}</h6>
                               <div class="absolute bottom-2 flex justify-end w-full px-2 gap-3">
                                   <p class="text-sm"><span class="text-primary-100 font-semibold">{{post.article.source.name }}</span> | <span>{{post.article.category.name }}</span></p>

                               </div>
                           </div>

                       </div>
                   </div>

                   <div v-show="accountType==='Free'">
                       <a target="_blank" :href="advert.url" :title="advert.title" v-show="advertActive===index"  v-for="(advert, index) in adverts" :key="advert.id">
                           <div
                               class="grid grid-cols-6 gap-1 rounded-lg overflow-hidden h-[150px] border shadow cursor-pointer">
                               <div class="col-span-2 grid bg-cover bg-center bg-black" :style="{ 'background-image': 'url(' + advert.image + ')' }">
                                   <div class="p-2">
                                       <span class="bg-primary-300 text-white rounded text-xs p-1 my-2">Ad</span>
                                   </div>
                               </div>
                               <div class="col-span-4 grid p-1 py-2 relative">
                                   <h6 class="font-libre font-bold text-lg">{{useTruncate(advert.title,100)}}</h6>
                                   <p>{{useTruncate(advert.description,120)}}</p>
                                   <div class="absolute bottom-2 flex justify-end w-full px-2 gap-3 ">
                                       <span class="bg-primary-300 text-white rounded text-xs p-1 my-2">Ad</span>
                                   </div>
                               </div>

                           </div>
                       </a>
                   </div>
               </div>
           </div>
       </div>
       <div>

           <second-post-modal v-if="postModal" :show="postModal" @close="postModal=false" :posts="articles.data" :currentPost="currentPost"></second-post-modal>
       </div>
   </div>
   </reader>
</template>
<script setup lang="ts">
import Reader from "@/views/layouts/reader.vue"
import PostModal from "@/views/components/news/post-modal.vue"
import SecondPostModal from "@/views/components/news/second-post-modal.vue"
import ReadlistMenu from "@/views/components/sidebar/readlist-menu.vue"
import { useTruncate } from "@/scripts/use/useTruncate";
import { chunk } from "@/scripts/use/useChunk";
import {onMounted, ref} from "vue";
import {Head, usePage} from "@inertiajs/inertia-vue3";
import axios from "axios";

let props=defineProps({
    articles:Object
})


const postModal=ref(false)
const currentPost=ref<Number>()
const submitPost=(post:Number)=>{

    currentPost.value=props.articles.data.findIndex(article => article.id === post);

    postModal.value=true
}
const page =usePage()
const adverts=ref([])

//fetch advertisement. limit 20 ads in random order
onMounted(()=>{
    axios
        .get('api/get/advertisement')
        .then((response: { data: never[]; }) => {
            adverts.value = response.data;
        })
        .catch((error: any) => console.log(error));
    adsInterval();
    chunkAmount()

})
//advert slider. Initial value 0;
const advertActive=ref(0)
const chunker=ref<Number>()
const chunkAmount=()=>{
    if (accountType==='Free'){
        chunker.value=5
    }else {
        chunker.value=4
    }

}
//get account type: Free account run ads, Paid account turn off Ads
const accountType=page.props.value.account_type

function advertNext(){
    if (advertActive.value<adverts.value.length-1){
        advertActive.value++
    }else{
        advertActive.value=0
    }
}

function adsInterval(){
    setInterval(advertNext, 4000)
}
</script>
