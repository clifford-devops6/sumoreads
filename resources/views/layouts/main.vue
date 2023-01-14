<template>
    <Teleport to="body">
        <toast :message="message" @remove="remove()"></toast>
    </Teleport>
<header>
    <div class="bg-white grid grid-cols-7 gap-8 px-3 drop-shadow justify-between">
        <div class="py-2 col-span-2">
            <img :src="'/images/readslogo.svg'" class="h-12">
        </div>
        <div class="self-center w-full col-span-4">
            <ul class="flex justify-between gap-8">
                <li class="hover:text-primary-100 font-bold py-2">
                    <Link>News</Link>
                </li>
                <li class="text-gray-800 hover:text-primary-100 font-bold py-2">
                    <Link>Personalize</Link>
                </li>
                <li class="text-gray-800 hover:text-primary-100 font-bold py-2">
                    <Link>Read List</Link>
                </li>
                <li class="text-gray-800 hover:text-primary-100 font-bold py-2">
                    <Link>Sharing</Link>
                </li>
                <li class="text-gray-800 hover:text-primary-100 font-bold py-2">
                    <Link>Pricing</Link>
                </li>
            </ul>

        </div>
        <div class="py-2 pr-3 col-span-1 flex justify-end">
            <Link class="flex px-8 h-12 py-2 bg-primary-100 rounded-full text-white hover:bg-opacity-95">
            <span class="self-center">
                <span class="mr-2"><i class="fa-light fa-user"></i></span>Login
            </span>
            </Link>
        </div>
    </div>
</header>

    <main>
        <slot />
    </main>
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
InertiaProgress.init()
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

<style scoped>

</style>
