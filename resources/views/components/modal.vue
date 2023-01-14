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
            <div v-if="show" class="inset-0 fixed bg-gray-900 bg-opacity-70 z-50 grid place-items-center p-5" >
                <div class="bg-white lg:w-1/2  w-full rounded-xl">
                    <header class="p-3">
                        <div class="flex justify-between">

                            <slot name="header">
                                <div class="font-bold text-black-100 text-lg">
                                    <h6>Modal Header</h6>
                                </div>
                            </slot>
                            <div>
                                <div class="text-end">
                                    <button class="bg-teal-900 rounded-full h-8 w-8" type="button" @click="$emit('close')"><span class="text-white text-lg"><i
                                        class="fal fa-times"></i></span></button>
                                </div>
                            </div>
                        </div>

                    </header>

                    <div class="p-3.5 ">
                        <slot>
                            Default body
                        </slot>
                    </div>

                    <footer class="p-3.5">
                        <slot name="footer">

                        </slot>
                    </footer>
                </div>
            </div>
        </Transition>
    </teleport>
</template>

<script setup lang="ts">

const emits=defineEmits(['close'])
emits("close")
let props=defineProps({
    show:Boolean,

})

</script>

<style scoped>

</style>
