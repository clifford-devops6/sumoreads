<template layout="main">
<Head>
    <title>Favorite Streams in one Place</title>
</Head>
    <div class="bg-white py-16">
        <div class=" text-center py-8">
            <h1 class="font-bold text-4xl text-primary-100">Organize your News streams for just $ 1.00 a month</h1>
        </div>
        <div class="py-10">
         <div class="px-14 text-center">
             <img :alt="source.name" v-for="source in sources.data" :key="source.id" :src="source.logo" class="h-10 inline-block m-1">
         </div>
        </div>



    </div>
    <div class="py-10 bg-primary-400">
        <div class="py-5">
            <p class="text-center  text-lg font-semibold">The leading news integration. Access over thousands of articles around the world</p>

        </div>
        <div class="flex gap-2 py-5 justify-center">
            <div class="border rounded-xl w-1/4">
                <div class="text-center p-3 border-b">
                    <h6 class="uppercase font-bold text-xl">{{free.name}}</h6>
                </div>
                <div class="mt-8 px-5">
                    <ul class="space-y-4">
                        <li>
                            <p class="flex gap-2">
                                <span class="text-primary-100"><i class="far fa-badge-check"></i></span>
                                <span>Access to all articles</span>
                            </p>
                        </li>
                        <li>
                            <p class="flex gap-2">
                                <span class="text-primary-100"><i class="far fa-badge-check"></i></span>
                                <span>Save articles to your read list</span>
                            </p>
                        </li>
                        <li>
                            <p class="flex gap-2">
                                <span class="text-primary-100"><i class="far fa-badge-check"></i></span>
                                <span >Share favourite articles with friends</span>
                            </p>
                        </li>
                        <li>
                            <p class="flex gap-2">
                                <span class="text-primary-100"><i class="far fa-badge-check"></i></span>
                                <span class="line-through">Unlimited access</span>
                            </p>
                        </li>
                    </ul>
                </div>

                <div class="mt-10 text-center p-5">
                    <h5 class="text-xl font-bold">$ <span class="text-5xl text-primary-100">{{Number(free.price).toFixed(2)}}</span>/Month</h5>
                    <div class="mt-8 grid">
                        <Link :href="route('register')" class="bg-primary-100 py-3 px-5 text-white font-bold rounded-lg" title="Start Free">Start Free</Link>
                    </div>
                </div>
            </div>

            <div class="border rounded-xl w-1/4">
                <div class="text-center p-3 border-b">
                    <h6 class="uppercase font-bold text-xl">{{enterprise.name}}</h6>
                </div>
                <div class="mt-8 px-5">
                    <ul class="space-y-4">
                        <li>
                            <p class="flex gap-2">
                                <span class="text-primary-100"><i class="far fa-badge-check"></i></span>
                                <span>Access to all articles</span>
                            </p>
                        </li>
                        <li>
                            <p class="flex gap-2">
                                <span class="text-primary-100"><i class="far fa-badge-check"></i></span>
                                <span>Share subscription with members</span>
                            </p>
                        </li>
                        <li>
                            <p class="flex gap-2">
                                <span class="text-primary-100"><i class="far fa-badge-check"></i></span>
                                <span>Create reading groups</span>
                            </p>
                        </li>
                        <li>
                            <p class="flex gap-2">
                                <span class="text-primary-100"><i class="far fa-badge-check"></i></span>
                                <span>Without ads interruption</span>
                            </p>
                        </li>
                    </ul>
                </div>

                <div class="mt-10 text-center p-5">
                    <h5 class="text-xl font-bold">$ <span class="text-5xl text-primary-100">{{Number(enterprise.price).toFixed(2)}}</span>/Month/User</h5>
                    <div class="mt-8 grid">
                        <Link :href="route('enterprise.register')" class="bg-primary-100 py-3 px-5 text-white font-bold rounded-lg" title="Start Free">Buy Now</Link>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="p-10">
     <trending :articles="articles.data"></trending>
    </div>
</template>
<script setup lang="ts">
import {Head} from "@inertiajs/inertia-vue3";
import {Link} from "@inertiajs/inertia-vue3";
import Trending from "@/views/components/news/trending.vue";
let props=defineProps({
    sources:Object,
    free:Object,
    enterprise:Object,
    articles:Object
})



</script>
