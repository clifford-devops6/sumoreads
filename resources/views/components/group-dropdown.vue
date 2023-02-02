<template>
    <button
        @click="toggleAccordion()"
        class="flex  w-full py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full"
        :aria-expanded="isOpen"
        :aria-controls="id"
    >

        <span class="flex justify-between w-full h-full  hover:bg-white hover:text-primary-100">
           <span><span class="mr-2"><i class="fa-regular fa-rss"></i></span> Enterprise Streams</span>
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

                      <li v-if="groups.length" :key="group.id" v-for="group in groups">
                          <Link :href="route('news.group',group.slug)" class="py-3 px-3 text-start  w-full h-full" as="button">
                            {{group.name}}
                          </Link>
                      </li>
                      <li v-else>
                          <Link href="#" class="py-3 px-3 text-start  w-full h-full" as="button">
                             No groups available
                          </Link>
                      </li>

                  </ul>
                </div>

            </div>
        </Transition>




    </div>
</template>

<script setup lang="ts">
import {Link, usePage} from "@inertiajs/inertia-vue3";
import {onMounted, ref} from "vue";
import axios from "axios";
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
const account=page.props.value.auth.account_id
const groups=ref([])
onMounted(()=>{
    axios
        .get('api/get/groups/'+account)
        .then((response: { data: never[]; }) => {
            groups.value = response.data;

        })
        .catch((error: any) => console.log(error))

})
</script>

<style scoped>
.accord{
    transition: 200ms ease-in-out;
}
</style>
