<template>
<div>

    <div v-if="articles.length" class="my-5 relative">
        <div v-show="slideActive===index" class="grid grid-cols-3 gap-2" v-for="(article,index) in chunk(articles,3)" :key="index">
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
            <div v-if="article[2] && accountType==='Corporate'" @click="submitPost(article[2].id)" class="grid cursor-pointer">
                <div class="rounded-lg overflow-hidden h-[220px] grid">
                    <img :src="article[2].image" :alt="article[2].title" class="object-cover w-full h-full" >
                </div>
                <div class="my-2">
                    <h2 class="font-libre font-bold text-lg">{{useTruncate(article[2].title,60)}}</h2>
                    <p class="my-1 text-gray-800">{{useTruncate(article[2].description,120)}}</p>
                </div>
            </div>

            <div v-else class="grid" v-show="advertActive===index"  v-for="(advert, index) in adverts" :key="advert.id">
                <a :href="advert.url" target="_blank">
                    <div class="rounded-lg overflow-hidden h-[220px] grid relative">
                        <img :src="advert.image" :alt="advert.title" class="object-cover w-full h-full" >
                        <span class="bg-primary-300 text-white rounded text-xs p-1 my-2 absolute top-1 left-1">Ad</span>
                    </div>
                    <div class="my-2">
                        <h2 class="font-libre font-bold text-lg">{{advert.title}}</h2>
                        <p class="my-1 text-gray-800">{{useTruncate(advert.description,120)}}</p>
                    </div>
                </a>
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
    <div v-else class="py-5">
        <p class="text-2xl">No articles in trending!</p>
    </div>
    <post-modal v-if="postModal"  :show="postModal" @close="postModal=false" :posts="articles" :currentPost="currentPost"></post-modal>
</div>
</template>

<script setup lang="ts">
import {chunk} from "@/scripts/use/useChunk";
import {useTruncate} from "@/scripts/use/useTruncate";
import {onMounted, ref} from "vue";
import PostModal from "@/views/components/news/post-modal.vue";
import axios from "axios";
import {usePage} from "@inertiajs/inertia-vue3";
let props=defineProps({
    articles:Object
})
const page=usePage()
const slideActive=ref(0)

function slideNext(){
    if (slideActive.value<chunk(props.articles,3).length-1){
        slideActive.value++
    }else{
        slideActive.value=0
    }
}
function slidePrevious(){
    if (slideActive.value){
        slideActive.value--
    }else{
        slideActive.value=chunk(props.articles,3).length-1
    }
}

const postModal=ref(false)
const currentPost=ref<Number>()
const submitPost=(post:Number)=>{
    currentPost.value=props.articles.findIndex(article => article.id === post);
    postModal.value=true
}

const adverts=ref([])

//fetch advertisement. limit 20 ads in random order
onMounted(()=>{
    axios
        .get('api/get/advertisement')
        .then((response: { data: never[]; }) => {
            adverts.value = response.data;
        })
        .catch((error: any) => console.log(error));
    adsInterval()

})
//advert slider. Initial value 0;
const advertActive=ref(0)
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

