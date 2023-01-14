<template>

    <TransitionGroup
        enter-from-class="translate-x-full opacity-0"
        enter-active-class="duration-500"
        leave-active-class="duration-500"
        leave-to-class="translate-x-full opacity-0"
    >
        <div v-if="message"  class="z-[10000] fixed top-4 right-4 flex items-center p-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow " role="alert">
            <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-teal-500 bg-teal-100 rounded-lg">
                <span><i class="far fa-info-circle"></i></span>
            </div>
            <div class="ml-3 text-sm font-normal">{{message}}</div>
            <button @click="$emit('remove')" type="button" class="ml-auto  bg-white text-gray-400 hover:text-gray-900 rounded-full focus:ring-2 focus:ring-gray-300 hover:bg-gray-100 inline-flex place-content-center h-8 w-8 p-1">
                <span class="self-center"><i class="fal fa-times"></i></span>
            </button>
        </div>
    </TransitionGroup>


</template>

<script setup lang="ts">
import { watch} from "vue";

let props=defineProps({
    message:String,
})

const emits=defineEmits(['remove'])

watch(props,()=>{
    setTimeout(()=>emits('remove'),2000)
})
</script>

<style scoped>

</style>
