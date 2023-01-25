<template>
    <teleport to="body">
        <Transition
            enter-from-class="opacity-0 scale-125"
            enter-to-class="opacity-100 scale-100"
            enter-active-class="transition duration-300"
            leave-active-class="transition duration-200"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-125"
           >
            <div @click.self="$emit('close')" v-if="show" class="inset-0 fixed bg-black bg-opacity-80 z-[10000] grid place-items-center p-5" >
                <div class="lg:w-3/5  w-full rounded-xl overflow-hidden">
                    <div class="relative">
                        <div class="absolute p-3 right-0">
                            <button class="bg-primary-100 rounded-full h-8 w-8" type="button" @click="$emit('close')"><span class="text-white text-lg"><i
                                class="fal fa-times"></i></span></button>
                        </div>
                        <div v-show="index===slideActive" v-for="(post, index) in posts" :key="post.id" class="bg-black text-white">
                            <div class="h-[45vh] bg-no-repeat bg-cover bg-center" :style="{ 'background-image': 'url(' + post.image + ')' }">
                                <div>
                                    <button @click="slidePrevious()" class="absolute rounded-full bg-white
                                    top-0 border border-primary-100 bottom-0 left-1 my-auto p-2 h-12 w-12 text-black ">
                                        <span><i class="far fa-angle-left"></i></span>
                                    </button>
                                    <button @click="slideNext()" class="absolute rounded-full bg-white
                                    top-0 border border-primary-100 bottom-0 right-1 my-auto p-2 h-12 w-12 text-black ">
                                        <span><i class="far fa-angle-right"></i></span>
                                    </button>
                                </div>
                            </div>
                            <div class="p-3">
                                <p class="my-2 flex justify-between"><span>| {{post.source.name}}</span> <span>{{post.category.name}} |</span></p>
                                <h6 class="font-libre text-xl font-bold">{{post.title}}</h6>
                                <p class="my-2">{{post.description}}</p>
                                <div class="my-3 flex justify-end gap-2">
                                    <a class="btn-secondary" :href="post.article_url" target="_blank">Read full article</a>
                                    <Link v-show="auth" preserve-scroll as="button" method="patch" :href="route('readlist.update',post.id)" class="btn-primary" title="Save to read list">Read later<span class="ml-2"><i class="fa-light fa-bookmark"></i></span></Link>
                                    <button @click="sharePost(post)" type="button" v-show="auth"  class="btn-primary" title="Share articles">Share<span class="ml-2"><i class="fa-light fa-share-nodes"></i></span></button>

                                </div>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </Transition>
        <div>
            <share v-if="shareModal" :article="article"   :show="shareModal" @closeShare="shareModal=false">

            </share>
        </div>
    </teleport>
</template>

<script setup lang="ts">
import {Link, usePage} from "@inertiajs/inertia-vue3";
import {computed, ref} from "vue";
import Share from "@/views/components/news/share.vue";
const emits=defineEmits(['close'])

let props=defineProps({
    show:Boolean,
    posts:Object,
    currentPost:Number

})
const posts=props.posts
const page=usePage()
const auth=page.props.value.auth


function slideNext(){
    if (slideActive.value< props.posts.length-1){
        slideActive.value++
    }else{
        slideActive.value=0
    }
}
function slidePrevious(){
    if (slideActive.value){
        slideActive.value--
    }else{
        slideActive.value= props.posts.length-1
    }
}
const slideActive=ref(props.currentPost);
const article=ref()
const shareModal =ref(false)

const sharePost=(post:any)=>{
    article.value=post
    shareModal.value=true
}
</script>

