<template>
    <Teleport to="body">
        <toast :message="message" @remove="remove()"></toast>
    </Teleport>
    <header class="fixed w-screen z-[1000]">
        <div class="bg-white grid grid-cols-7 gap-8 px-3 drop-shadow justify-between">
            <div class="py-2 col-span-2">
                <Link href="/">
                    <img :src="'/images/readslogo.svg'" class="h-12">
                </Link>
            </div>
            <div class="self-center w-full col-span-4">
                <ul class="flex justify-between gap-8">
                    <li class="hover:text-primary-100 font-bold py-5" :class="{ 'border-b border-b-2 border-b-primary-100': $page.url === '/news' }">
                        <Link :href="route('news.index')" title="News">News</Link>
                    </li>
                    <li class="text-gray-800 hover:text-primary-100 font-bold py-5" :class="{ 'border-b border-b-2 border-b-primary-100': $page.url === '/account/personalize' }">
                        <Link :href="route('personalize.index')" title="Personalize feeds">Personalize</Link>
                    </li>
                    <li class="text-gray-800 hover:text-primary-100 font-bold py-5" :class="{ 'border-b border-b-2 border-b-primary-100': $page.url === '/readlist' }">
                    <Link class="flex" :href="route('readlist.index')" title="My Read list">Read List <span v-if="readlist" class="self-center bg-primary-100 text-white p-1
                        rounded-full ml-2 h-6 w-6 text-xs flex place-content-center"><span>{{ readlist }}</span></span></Link>
                    </li>
                    <li class="text-gray-800 hover:text-primary-100 font-bold py-5" :class="{ 'border-b border-b-2 border-b-primary-100': $page.url === '/account/share' }">
                        <Link class="flex" :href="route('share.index')" title="Sharing">Sharing
                            <span v-if="shares" class="self-center bg-primary-100 text-white p-1
                        rounded-full ml-2 h-6 w-6 text-xs flex place-content-center"><span>{{ shares }}</span></span>
                        </Link>
                    </li>

                </ul>

            </div>
            <div class="py-2 pr-3 col-span-1 flex justify-end">
                <div>
                    <Link v-if="!$page.props.auth" :href="route('login')" class="flex px-8 h-12 py-2 bg-primary-100 rounded-full text-white hover:bg-opacity-95">
            <span class="self-center">
                <span class="mr-2"><i class="fa-light fa-user"></i></span>Login
            </span>
                    </Link>
                </div>
                <div class="self-center mr-3" v-if="auth">
                    <dropdown   class="relative">
                        <template #trigger>
                            <div class="cursor-pointer flex gap-1">
                                <img :src="'/images/no-user.png'" class="w-8 h-8">
                                <span class="self-center"><i class="fa-regular fa-angle-down"></i></span>
                            </div>
                        </template>
                        <div class="divide-y mt-3 overflow-hidden  w-52 bg-white rounded  absolute -right-10">
                            <div class="p-3">
                                <Link :href="route('profile.index')" class="hover:text-primary-100"><span class="mr-1"><i class="fa-light fa-gear"></i></span>Profile Settings</Link>
                            </div>
                            <div v-if="auth.role==='Enterprise'" class="p-3">
                                <Link :href="route('manage.index')" class="hover:text-primary-100"><span class="mr-1"><i class="fa-light fa-building"></i></span>Manage Account</Link>
                            </div>
                            <div class="p-3" v-if="auth.role==='Enterprise'">
                                <Link :href="route('subscription.index')" class="hover:text-primary-100"><span class="mr-1"><i class="fa-light fa-calendar-range"></i></span>Billing & Subscription</Link>
                            </div>
                            <div class="p-3" v-if="auth.role==='Free'">
                                <Link href="#" class="hover:text-primary-100"><span class="mr-1"><i class="fa-solid fa-arrow-up-from-bracket"></i></span>Upgrade Account</Link>
                            </div>
                            <div class="text-center hover:bg-primary-100 hover:text-white ">
                                <Link as="button" :href="route('logout')"
                                      method="post" class="h-full w-full py-3"><span class="mr-1"><i class="fa-light fa-lock"></i></span>Logout</Link>
                            </div>
                        </div>

                    </dropdown>
                </div>


            </div>
        </div>
    </header>
<div>

    <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <aside id="default-sidebar" class="fixed top-0 left-0 z-20 w-64 bg-primary-100 h-full" aria-label="Sidebar">
        <div class="h-full py-5 overflow-y-auto pt-16">
           <slot name="sidebar"/>
        </div>
    </aside>

    <div class="py-10 ml-64 min-h-screen pt-16">
        <slot/>
    </div>

</div>

    <footer class="relative bg-gray-200 z-[1000] p-2 flex justify-center">
           <ul class="flex justify-center gap-5 py-3 ">
               <li>
                   <Link href="#" title="Terms and Conditions" class="font-medium hover:text-primary-100">Terms and Conditions</Link>
               </li>
               <li>
                   <Link href="#" title="Privacy Policy" class="font-medium hover:text-primary-100">Privacy policy</Link>
               </li>
               <li>
                   <Link href="#" title="Privacy Policy" class="font-medium hover:text-primary-100">FAQS</Link>
               </li>
               <li>
                   <Link href="#" title="Partners" class="font-medium hover:text-primary-100">Partners</Link>
               </li>
               <li>
                   <Link :href="route('contact-us.index')" title="Contact us" class="font-medium hover:text-primary-100">Contact</Link>
               </li>
               <li>
                   <Link :href="route('report-bug.index')" title="Report bug" class="font-medium hover:text-primary-100">Report Bug</Link>
               </li>
           </ul>
       </footer>

</template>

<script setup lang="ts">
import {Link,usePage} from "@inertiajs/inertia-vue3";
import { InertiaProgress } from '@inertiajs/progress'
import { Dropdown } from 'flowbite-vue'
import { Sidebar } from 'flowbite-vue'
InertiaProgress.init()
import Toast from "@/views/components/toast.vue";
import {reactive, ref} from "vue";
import {Inertia} from "@inertiajs/inertia";
const page=usePage()
const message=ref('')
const readlist=ref(page.props.value.readlist )
const shares=ref(page.props.value.shares )
const auth=page.props.value.auth
let removeEventListener=Inertia.on("finish",()=>{
    if (page.props.value.status){
        message.value=page.props.value.status
    }
    if(page.props.value.readlist){
        readlist.value=page.props.value.readlist
    }
    if(page.props.value.shares){
        shares.value=page.props.value.shares
    }
})
function remove(){
    message.value=null
}


</script>

<style scoped>

</style>
