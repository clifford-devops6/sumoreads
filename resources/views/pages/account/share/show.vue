<template>
    <Head><title>Sharing</title></Head>
    <reader>
        <template #sidebar>
            <share-menu :groups="groups.data" :users="users.data" :page="route('share.show',user_id)"></share-menu>
        </template>
        <div v-if="shareds.data.length" class="my-10 space-y-3">
            <div  :key="index" v-for="(share,index) in  chunk(shareds.data,3)" class="space-y-3">
                <div @click="submitPost(post.id)" :key="post.id" v-for="post in  share" class=" cursor-pointer grid border shadow grid-cols-6 gap-2">
                    <div class="col-span-1 grid">
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

                <div  class="grid border shadow grid-cols-6 gap-2 cursor-pointer">
                    <div class="col-span-1 grid bg-black">
                        <p class="text-white">Advertisement image</p>
                    </div>
                    <div class="col-span-5 p-1">
                        <h1 class="font-bold text-lg">Advertisement title</h1>
                        <p>Advertisement description</p>

                    </div>
                </div>
            </div>

        </div>
        <div v-else class="flex justify-center">
            <h1 class="font-bold text-lg">No articles have been shred with you!</h1>
        </div>
        <div>
            <share-modal v-if="postModal" :show="postModal" @close="postModal=false" :posts="shareds.data" :currentPost="currentPost"></share-modal>
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
