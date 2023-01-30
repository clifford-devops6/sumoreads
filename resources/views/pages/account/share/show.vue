<template>
    <Head><title>Sharing</title></Head>
    <reader>
        <template #sidebar>
            <share-menu :groups="groups.data" :users="users.data" :page="route('share.show',user_id)"></share-menu>
        </template>
        <div class="px-3">
            <div v-if="shareds.data.length" class="my-10 space-y-3">
                <div  :key="index" v-for="(share,index) in  chunk(shareds.data,3)" class="space-y-3">
                    <div @click="submitPost(post.id)" :key="post.id" v-for="post in  share" class=" cursor-pointer grid border shadow grid-cols-6 gap-2">
                        <div class="col-span-1 grid relative">
                            <img :src="post.article.image" :alt="post.article.title" class=" h-full">

                        </div>
                        <div class="col-span-5 p-1">
                            <h1 class="font-bold text-lg">{{post.article.title}}</h1>
                            <p>{{post.article.description}}</p>
                            <p v-if="post.comment" class="text-gray-400 p-2">
                                <span>{{post.comment}}</span>
                            </p>
                            <div class="flex justify-end px-2">
                                <p class="text-sm">Shared by <span class="font-bold">{{post.sender.name}} {{post.sender.last_name}}</span></p>
                            </div>
                        </div>
                    </div>
                    <div v-show="accountType==='Free'" class="grid">
                        <a target="_blank" :href="advert.url" :title="advert.title" v-show="advertActive===index"  v-for="(advert, index) in adverts" :key="advert.id">
                            <div  class="grid border shadow grid-cols-6 gap-2 cursor-pointer">
                                <div class="col-span-1 grid bg-black relative">
                                    <img :src="advert.image" :alt="advert.title" class=" h-full">
                                    <span class="bg-primary-300 text-white rounded text-xs p-1  absolute top-1 left-1">Ad</span>
                                </div>
                                <div class="col-span-5 p-1">
                                    <h1 class="font-bold text-lg">{{advert.title}}</h1>
                                    <p>{{advert.description}}</p>

                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <div v-else class="flex justify-center my-16">
                <h1 class="font-bold text-lg">No articles have been shared with you!</h1>
            </div>
            <div>
                <share-modal v-if="postModal" :show="postModal" @close="postModal=false" :posts="shareds.data" :currentPost="currentPost"></share-modal>
            </div>
        </div>
    </reader>
</template>

<script setup lang="ts">

import Reader from "@/views/layouts/reader.vue";
import {Head} from "@inertiajs/inertia-vue3";
import ShareMenu from "@/views/components/sidebar/share-menu.vue";
import {chunk} from "@/scripts/use/useChunk";
import {ref} from "vue";
import ShareModal from "@/views/components/news/share-modal.vue";
let props=defineProps({
    shareds:Object,
    users:Object,
    user_id:Number,
    groups:Object
})

const postModal=ref(false)
const currentPost=ref<Number>()
const submitPost=(post:Number)=>{
    console.log(post)
    currentPost.value=props.shareds.data.findIndex(share => share.id === post);

    postModal.value=true
}
</script>

<style scoped>

</style>
