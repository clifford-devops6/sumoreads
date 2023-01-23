<template>
    <div class="grid grid-cols-2 gap-2">
        <div @click="submitPost(article.id)" v-for="article in articles" :key="article.id">
            <div class="grid grid-cols-6 gap-1 rounded-lg overflow-hidden h-[150px] border shadow cursor-pointer">
                <div class="col-span-2 grid bg-cover bg-center" :style="{ 'background-image': 'url(' + article.image + ')' }">

                </div>
                <div class="col-span-4 grid p-1 py-2 relative">
                    <h6 class="font-libre font-bold text-lg">{{useTruncate(article.title,100)}}</h6>
                    <div class="absolute bottom-2 flex justify-end w-full px-2 gap-3">
                        <p class="text-sm"><span class="text-primary-100 font-semibold">{{article.source.name}}</span> | <span>{{article.source.category.name}}</span></p>
                        <Link title="Save to read list"><span class="text-primary-100"><i class="fa-solid fa-bookmark"></i></span></Link>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div ref="el">
    </div>
    <div>
        <post-modal v-if="postModal"  :show="postModal" @close="postModal=false" :posts="articles" :currentPost="currentPost"></post-modal>
    </div>
</template>

<script setup lang="ts">
import {useIntersectionObserver } from "@vueuse/core";
import useGetPosts from "./useGetPosts";
import {useTruncate} from "./useTruncate";
import PostModal from "@/views/components/news/post-modal.vue";
import {ref} from "vue";
import {Link} from "@inertiajs/inertia-vue3";

const el=ref<HTMLElement | null>(null)
const showPosts=2;
const articles=ref(await useGetPosts(showPosts,0));
const fetchingData=ref(false)
const getPostsOnScroll= async()=>{
    fetchingData.value=true
    try {
        const newPosts= await useGetPosts(
            showPosts,
            articles.value.length
        );
        articles.value.push(...newPosts);
    }catch (err){
        console.log(err)
    }
    fetchingData.value=false
}
useIntersectionObserver (
    el,
    async ()=>{
        await getPostsOnScroll()
    },
    {
        threshold: 0.5,
    }
);
const postModal=ref(false)
const currentPost=ref<Number>()
const submitPost=(post:Number)=>{
    currentPost.value=articles.value.findIndex(article => article.id === post);
    postModal.value=true
}
</script>

<style scoped>

</style>
