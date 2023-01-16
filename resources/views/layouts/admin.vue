<script setup lang="ts">
import { InertiaProgress } from '@inertiajs/progress'
InertiaProgress.init()
import {Link, usePage} from "@inertiajs/inertia-vue3";
import Toast from "@/views/components/toast.vue";
import {ref} from "vue";
import {Inertia} from "@inertiajs/inertia";
defineProps({
    auth:Object
})
const page=usePage()
const message=ref('')
let removeEventListener=Inertia.on("finish",()=>{
    if (page.props.value.status){
        message.value=page.props.value.status
    }
})
function remove(){
    message.value=null
}
</script>
<template>
    <Teleport to="body">
        <toast :message="message" @remove="remove()"></toast>
    </Teleport>
    <div class="relative min-h-screen">
        <div class="flex gap-2">
            <div class="relative">
                <aside class="w-64 top-0">
                    <div class="fixed w-64">
                        <div class="mt-5 px-3">
                            <h1 class="font-bold">SUMOREADS</h1>
                        </div>
                        <div class="w-full mt-12">
                            <div class="flex gap-3 px-3">
                                <div class="rounded-full h-12 w-12 overflow-hidden">
                                    <img :src="'/images/no-user.png'" title="User Icon">
                                </div>
                                <div class="self-center">
                                    <div class="flex justify-between gap-4">
                                        <div>

                                            <h6 class="capitalize font-semibold">{{$page.props.auth.name}} {{$page.props.auth.last_name}}</h6>
                                            <Link :href="route('admin.logout')"
                                                  method="post" as="button"
                                                  class="text-primary-200 text-sm font-bold">
                                                <span class="mr-1"><i class="fa-light fa-lock"></i></span>
                                                Log Out
                                            </Link>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!--search-->
                            <div class="mt-8 px-3">
                                <form>
                                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
                                    <div class="relative">
                                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <input type="search" id="default-search" class="block p-3 pl-10 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-primary-200 focus:border-primary-200 " placeholder="Search Sumoreads..." required>

                                    </div>
                                </form>
                            </div>

                            <div class="mt-7">
                                <ul>
                                    <li>
                                        <Link href="/">
                                            <div class="hover:bg-gray-100 w-full rounded-md px-3 py-3">
                                                <p class="font-semibold text-sm"> <span class="mr-3 text-primary-200"><i class="fa-light fa-house"></i></span>Home</p>
                                            </div>
                                        </Link>

                                    </li>
                                    <li>
                                        <Link :href="route('admin.index')">
                                            <div class="hover:bg-gray-100 w-full rounded-md px-3 py-3">
                                                <p class="font-semibold text-sm"> <span class="mr-3 text-primary-200"><i class="fa-regular fa-sliders"></i></span>Dashboard</p>
                                            </div>
                                        </Link>

                                    </li>
                                    <li>
                                        <Link href="#">
                                            <div class="hover:bg-gray-100 w-full rounded-md px-3 py-3">
                                                <p class="font-semibold text-sm"> <span class="mr-3 text-primary-200"><i class="fa-regular fa-gear"></i></span>Profile Settings</p>
                                            </div>
                                        </Link>

                                    </li>


                                </ul>
                            </div>
                        </div>
                        <div class="mt-8 mx-4">
                            <h5 class="font-semibold text-lg text-primary-200">Links</h5>
                            <ul>
                                <li>
                                    <Link :href="route('languages.index')">
                                        <div class="w-full rounded-md px-3 py-1">
                                            <p class="font-semibold hover:text-primary-200 text-sm text-gray-800"><span class="mr-2 text-primary-200"><i class="far fa-angle-right"></i></span>Languages</p>
                                        </div>
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('categories.index')">
                                        <div class="w-full rounded-md px-3 py-1">
                                            <p class="font-semibold hover:text-primary-200 text-sm text-gray-800"><span class="mr-2 text-primary-200"><i class="far fa-angle-right"></i></span>Categories</p>
                                        </div>
                                    </Link>
                                </li>

                                <li>
                                    <Link :href="route('sources.index')">
                                        <div class="w-full rounded-md px-3 py-1">
                                            <p class="font-semibold hover:text-primary-200 text-sm text-gray-800"><span class="mr-2 text-primary-200"><i class="far fa-angle-right"></i></span>Sources</p>
                                        </div>
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('articles.index')">
                                        <div class="w-full rounded-md px-3 py-1">
                                            <p class="font-semibold hover:text-primary-200 text-sm text-gray-800"><span class="mr-2 text-primary-200"><i class="far fa-angle-right"></i></span>Articles</p>
                                        </div>
                                    </Link>
                                </li>

                                <li>
                                    <Link :href="route('messages.index')">
                                        <div class="w-full rounded-md px-3 py-1">
                                            <p class="font-semibold hover:text-primary-200 text-sm text-gray-800"><span class="mr-2 text-primary-200"><i class="far fa-angle-right"></i></span>Messages</p>
                                        </div>
                                    </Link>
                                </li>

                                <li>
                                    <Link :href="route('bugs.index')">
                                        <div class="w-full rounded-md px-3 py-1">
                                            <p class="font-semibold hover:text-primary-200 text-sm text-gray-800"><span class="mr-2 text-primary-200"><i class="far fa-angle-right"></i></span>Bug Reports</p>
                                        </div>
                                    </Link>
                                </li>
                                <li>
                                    <Link :href="route('account-types.index')">
                                        <div class="w-full rounded-md px-3 py-1">
                                            <p class="font-semibold hover:text-primary-200 text-sm text-gray-800"><span class="mr-2 text-primary-200"><i class="far fa-angle-right"></i></span>Account Types</p>
                                        </div>
                                    </Link>
                                </li>

                            </ul>

                        </div>



                    </div>
                </aside>
            </div>

            <div class="bg-white w-full min-h-screen pb-5">

                <div>
                    <slot/>
                </div>

            </div>
            <div class="w-full min-h-screen w-72 px-3">
                <div class="fixed ">
                    <div class="pt-8 ">
                        <h6 class="font-bold text-teal-900">Quick links</h6>
                    </div>
                    <div class="">
                        <slot name="sidebar"></slot>
                    </div>
                </div>

            </div>
        </div>
        <div class="bg-gray-900 py-3 px-3 relative z-50">
            <div class="">
                <ul class="flex gap-2 text-white">
                    <li><p><span><i class="far fa-copyright"></i></span> Sumoreads {{new Date().getFullYear()}}</p></li>
                </ul>
            </div>
        </div>
    </div>


</template>
