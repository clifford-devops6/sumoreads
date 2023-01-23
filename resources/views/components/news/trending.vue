<template>
   <div class="relative">
       <div class="flex justify-between my-8">
           <div>
               <h1 class="font-bold text-3xl">Trending Now</h1>
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
       <div class="relative">
           <div v-show="slideActive===index" class="grid gap-2  my-2" v-for="(trend, index) in trending" :key="index">
               <div  class="grid grid-cols-2 gap-2" >
                   <div @click="submitPost(trend[0].id)" class="cursor-pointer grid  text-white h-[50vh] bg-no-repeat bg-cover bg-center rounded-lg overflow-hidden" :style="{ 'background-image': 'url(' + trend[0].image + ')' }">
                       <div class="grid relative bg-gradient-to-b from-transparent to-black h-full w-full">
                           <div class="absolute bottom-2 p-3">
                               <h6 class="font-libre text-2xl font-bold">{{useTruncate(trend[0].title,100)}}</h6>
                               <p class="my-2 flex justify-between"><span>| {{trend[0].source.name}}</span> <span>{{trend[0].source.category.name}} |</span></p>
                           </div>
                       </div>
                   </div>
                   <div class="grid gap-2">
                       <div class="grid grid-cols-2 gap-2">
                           <div @click="submitPost(trend[1].id)" class="cursor-pointer grid bg-no-repeat bg-cover bg-center rounded-lg overflow-hidden w-full h-full" :style="{ 'background-image': 'url(' + trend[1].image + ')' }">
                               <div class="grid relative bg-gradient-to-b from-transparent to-black h-full w-full">
                                   <div class="absolute bottom-2 p-2 text-white w-full">
                                       <h6 class="font-libre text-lg font-bold">{{useTruncate(trend[1].title,60)}}</h6>
                                       <p class="my-1 flex justify-between"><span>| {{trend[1].source.name}}</span> <span>{{trend[1].source.category.name}} |</span></p>
                                   </div>
                               </div>
                           </div>
                           <div @click="submitPost(trend[2].id)" class="cursor-pointer grid bg-no-repeat bg-cover bg-center rounded-lg overflow-hidden w-full h-full" :style="{ 'background-image': 'url(' + trend[2].image + ')' }">
                               <div class="grid relative bg-gradient-to-b from-transparent to-black h-full w-full">
                                   <div class="absolute bottom-2 p-2 text-white w-full">
                                       <h6 class="font-libre text-lg font-bold">{{useTruncate(trend[2].title,60)}}</h6>
                                       <p class="my-1 flex justify-between"><span>| {{trend[2].source.name}}</span> <span>{{trend[2].source.category.name}} |</span></p>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="grid grid-cols-2 gap-2">
                           <div @click="submitPost(trend[3].id)" class="cursor-pointer grid bg-no-repeat bg-cover bg-center rounded-lg overflow-hidden w-full h-full" :style="{ 'background-image': 'url(' + trend[3].image + ')' }">
                               <div class="grid relative bg-gradient-to-b from-transparent to-black h-full w-full">
                                   <div class="absolute bottom-2 p-2 text-white w-full">
                                       <h6 class="font-libre text-lg font-bold">{{useTruncate(trend[3].title,60)}}</h6>
                                       <p class="my-1 flex justify-between"><span>| {{trend[3].source.name}}</span> <span>{{trend[3].source.category.name}} |</span></p>
                                   </div>
                               </div>
                           </div>
                           <div class="grid bg-no-repeat bg-cover bg-center rounded-lg overflow-hidden w-full h-full">
                               <div class="grid relative bg-black h-full w-full">
                                   <div class="absolute bottom-2 p-2 text-white w-full">

                                       <p class="my-1 flex justify-between">Advertisement</p>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>

               </div>
           </div>
           <div>
               <button @click="slidePrevious()" class="absolute rounded-full bg-white/40
                            top-0 bottom-0 left-1 my-auto p-2 h-12 w-12 text-black hover:bg-white/70">
                   <span><i class="far fa-angle-left"></i></span>
               </button>
               <button @click="slideNext()" class="absolute rounded-full bg-white/40
                          top-0 bottom-0 right-1 my-auto p-2 h-12 w-12 text-black hover:bg-white/70">
                   <span><i class="far fa-angle-right"></i></span>
               </button>
           </div>
       </div>

   </div>
    <post-modal v-if="postModal"  :show="postModal" @close="postModal=false" :posts="articles" :currentPost="currentPost"></post-modal>
</template>

<script setup lang="ts">
import {chunk} from "@/scripts/use/useChunk";
import {useTruncate} from "@/scripts/use/useTruncate";
import {ref} from "vue";
import PostModal from "@/views/components/news/post-modal.vue";


let props=defineProps({
    articles:Object,
    sources:Object,
    categories:Object
})

const articles=props.articles.data
const trending=chunk(articles,4)
const slideActive=ref(0)
function slideNext(){
    if (slideActive.value<trending.length-1){
        slideActive.value++
    }else{
        slideActive.value=0
    }
}
function slidePrevious(){
    if (slideActive.value){
        slideActive.value--
    }else{
        slideActive.value=trending.length-1
    }
}

//Post modal
const postModal=ref(false)
const currentPost=ref<Number>()
const submitPost=(post:Number)=>{
      currentPost.value=articles.findIndex(article => article.id === post);
      postModal.value=true
}


</script>

