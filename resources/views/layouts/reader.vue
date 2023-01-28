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
                            <div class="p-3">
                                <Link :href="route('subscription.index')" class="hover:text-primary-100"><span class="mr-1"><i class="fa-light fa-calendar-range"></i></span>Billing & Subscription</Link>
                            </div>
                            <div class="p-3">
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
<div class="grid grid-cols-12 min-h-screen overflow-hidden">
    <div class="col-span-2 grid overflow-hidden">
        <aside class="top-0 relative bg-primary-100 min-h-screen shadow-lg overflow-hidden">
            <div class="min-h-screen  w-full pt-20 overflow-hidden">
             <div class="fixed w-64 h-screen overflow-hidden">
                 <slot name="sidebar"></slot>
             </div>
            </div>
        </aside>
    </div>
    <div class="col-span-10 mt-16  w-full">
        <main>
            <slot />
        </main>
    </div>
</div>

    <footer class="bg-gray-200 p-2 flex justify-center">
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
