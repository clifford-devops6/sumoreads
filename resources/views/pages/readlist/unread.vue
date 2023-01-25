<template>
    <Head><title>My read list</title></Head>
   <reader>
    <template #sidebar>
        <readlist-menu :page="route('unread.readlist')"></readlist-menu>
    </template>
    <div class="my-10">
        <div v-for="(article, index) in chunk(articles.data,5)" :key="index">
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

            <div>
                <div class="grid grid-cols-6 gap-1 rounded-lg overflow-hidden h-[150px] border shadow cursor-pointer">
                    <div class="col-span-2 grid bg-cover bg-center bg-black">
                        <h6 class="text-white">Advertisement</h6>

                    </div>
                    <div class="col-span-4 grid p-1 py-2 relative">
                        <h6 class="font-libre font-bold text-lg">Advertisement title</h6>
                        <div class="absolute bottom-2 flex justify-end w-full px-2 gap-3">
                            <p class="text-sm"><span class="text-primary-100 font-semibold">Advertisement description</span></p>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <div>
       
    <second-post-modal v-if="postModal" :show="postModal" @close="postModal=false" :posts="articles.data" :currentPost="currentPost"></second-post-modal>
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
import { ref } from "vue";
import { Head } from "@inertiajs/inertia-vue3";

let props=defineProps({
    articles:Object
})


const postModal=ref(false)
const currentPost=ref<Number>()
const submitPost=(post:Number)=>{
    
    currentPost.value=props.articles.data.findIndex(article => article.id === post);
    
    postModal.value=true
}
</script>
