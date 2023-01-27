<template>
    <button
        @click="toggleAccordion()"
        class="flex  w-full py-4 px-3 text-start  hover:bg-white hover:text-primary-100 w-full h-full"
        :aria-expanded="isOpen"
        :aria-controls="id"
    >

        <span class="flex justify-between w-full h-full  hover:bg-white hover:text-primary-100">
           <span><span class="mr-2"><i class="fa-regular fa-rss"></i></span>My Streams</span>
            <span> <span><i class="fa-regular fa-angle-down " :class="{'rotate-180 ':isOpen}"></i></span></span>
        </span>

    </button>
    <div class="text-start w-full h-full">

        <Transition
            name="accordion"
            v-on:before-enter="beforeEnter" v-on:enter="enter"
            v-on:before-leave="beforeLeave" v-on:leave="leave"
        >
            <div v-show="isOpen" :id="id" class="mt-1 accord pr-2">
                <div class="custom-scrolling max-h-[250px] overflow-y-auto">
                    <ul class="pl-3">

                        <li :key="source.id" v-for="source in sources">
                            <Link :href="route('home.index')" class="py-3 px-3 text-start  w-full h-full" as="button">
                                {{source.name}}
                            </Link>
                        </li>
                        <li>
                            <button @click="personalSource=true"  class="py-3 px-3 text-start  w-full h-full">
                               <span class="mr-2"><i class="fa-regular fa-plus"></i></span> Add Streams
                            </button>
                        </li>
                    </ul>
                </div>

            </div>
        </Transition>

        <personal-source :show="personalSource" @close="personalSource=false" :my-sources="sources"></personal-source>
    </div>
</template>

<script setup lang="ts">
import {Link, usePage} from "@inertiajs/inertia-vue3";
import {onMounted, ref} from "vue";
import axios from "axios";
import PersonalSource from "@/views/components/enterprise/personal-source.vue";
import {Inertia} from "@inertiajs/inertia";
defineProps({
    id:Number
})


const isOpen=ref(false)
const toggleAccordion=()=>{
    isOpen.value = !isOpen.value;
}

const beforeEnter=(el)=>{
    el.style.height = '0';
}
const enter=(el)=>{
    el.style.height = el.scrollHeight + 'px';
}
const leave=(el)=>{
    el.style.height = '0';
}
const beforeLeave=(el)=>{
    el.style.height = el.scrollHeight + 'px';
}
const page=usePage()
const user=page.props.value.auth.id
const sources=ref([])
onMounted(()=>{
    axios
        .get('api/get/personal-streams/'+user)
        .then((response: { data: never[]; }) => {
            sources.value = response.data;

        })
        .catch((error: any) => console.log(error))

})
const personalSource=ref(false)

let removeEventListener=Inertia.on("finish",()=>{
    axios
        .get('api/get/personal-streams/'+user)
        .then((response: { data: never[]; }) => {
            sources.value = response.data;

        })
        .catch((error: any) => console.log(error))
})
</script>

<style scoped>
.accord{
    transition: 200ms ease-in-out;
}
</style>
