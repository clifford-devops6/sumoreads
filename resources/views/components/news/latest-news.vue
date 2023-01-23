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
    <div class="my-5 relative">
        <div v-show="slideActive===index" class="grid grid-cols-3 gap-2" v-for="(article,index) in latest" :key="index">
            <div @click="submitPost(article[0].id)" class="grid cursor-pointer">
                <div class="rounded-lg overflow-hidden h-[220px] grid">
                    <img :src="article[0].image" :alt="article[0].title" class="object-cover w-full h-full">
                </div>
                <div class="my-2">
                    <h2 class="font-libre font-bold text-lg">{{useTruncate(article[0].title,60)}}</h2>
                    <p class="my-1 text-gray-800">{{useTruncate(article[0].description,120)}}</p>
                </div>
            </div>

            <div @click="submitPost(article[1].id)" class="grid cursor-pointer">
                <div class="rounded-lg overflow-hidden h-[220px] grid">
                    <img :src="article[1].image" :alt="article[1].title" class="object-cover w-full h-full" >
                </div>
                <div class="my-2">
                    <h2 class="font-libre font-bold text-lg">{{useTruncate(article[1].title,60)}}</h2>
                    <p class="my-1 text-gray-800">{{useTruncate(article[1].description,120)}}</p>
                </div>
            </div>

            <div class="grid">
                <div class="rounded-lg overflow-hidden h-[220px] grid bg-black">
                  <h6 class="text-white">Advertisement</h6>
                </div>
                <div class="my-2">
                    <h2 class="font-libre font-bold text-lg">Ad title</h2>
                    <p class="my-1 text-gray-800">Ad description</p>
                </div>
            </div>
        </div>
        <div>
            <button @click="slidePrevious()" class="absolute rounded-full bg-white/60
                            top-0 bottom-0 left-1 my-auto p-2 h-12 w-12 text-black hover:bg-white/70">
                <span><i class="far fa-angle-left"></i></span>
            </button>
            <button @click="slideNext()" class="absolute rounded-full bg-white/60
                          top-0 bottom-0 right-1 my-auto p-2 h-12 w-12 text-black hover:bg-white/70">
                <span><i class="far fa-angle-right"></i></span>
            </button>
        </div>
    </div>
    <post-modal v-if="postModal"  :show="postModal" @close="postModal=false" :posts="articles" :currentPost="currentPost"></post-modal>
</div>
</template>

<script setup lang="ts">
import {chunk} from "@/scripts/use/useChunk";
import {useTruncate} from "@/scripts/use/useTruncate";
import {ref} from "vue";
import PostModal from "@/views/components/news/post-modal.vue";
let props=defineProps({
    categories:Object,
    sources:Object,
    articles:Object
})
const articles=props.articles
const slideActive=ref(0)
const latest=chunk(articles,2)
function slideNext(){
    if (slideActive.value<latest.length-1){
        slideActive.value++
    }else{
        slideActive.value=0
    }
}
function slidePrevious(){
    if (slideActive.value){
        slideActive.value--
    }else{
        slideActive.value=latest.length-1
    }
}

const postModal=ref(false)
const currentPost=ref<Number>()
const submitPost=(post:Number)=>{
    currentPost.value=articles.findIndex(article => article.id === post);
    postModal.value=true
}
</script>

