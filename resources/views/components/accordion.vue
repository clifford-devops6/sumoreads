<template>
    <div class="w-full">
        <div
            @click="toggleAccordion()"
            class="flex  cursor-pointer w-full"
            :aria-expanded="isOpen"
            :aria-controls="id"
        >

            <div class="flex justify-between w-full rounded-lg bg-gray-100 px-3 drop-shadow py-4 border">
                <slot name="title" />
                <span><i :class="{'far fa-plus':!isOpen, 'far fa-minus':isOpen}"></i></span>
            </div>

        </div>

        <Transition
            name="accordion"
            v-on:before-enter="beforeEnter" v-on:enter="enter"
            v-on:before-leave="beforeLeave" v-on:leave="leave"
        >
            <div v-show="isOpen" :id="id" class="mt-1 accord">
                <div class="border px-3 py-4 rounded-lg">
                    <slot  />

                </div>

            </div>
        </Transition>




    </div>
</template>

<script setup lang="ts">
defineProps({
    id:Number
})
import {ref} from "vue";

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
</script>

<style scoped>
.accord{
    transition: 200ms ease-in-out;
}
</style>
