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
            <div  v-if="show" class="inset-0 fixed bg-gray-900 bg-opacity-70 z-50 grid place-items-center p-5" >
                <div class="bg-white lg:w-3/4  w-full rounded-xl">
                    <header class="p-3">
                        <div class="flex justify-between">
                            <div>
                                <Link @click="$emit('close')" class="text-primary-100">
                                    <span class="mr-3"><i class="fa-light fa-arrow-left-long"></i></span>Back
                                </Link>
                            </div>
                            <div>
                                <div class="text-end">
                                    <button class="bg-teal-900 rounded-full h-8 w-8" type="button" @click="$emit('close')"><span class="text-white text-lg"><i
                                        class="fal fa-times"></i></span></button>
                                </div>
                            </div>
                        </div>

                    </header>
                    <div class="p-3">
                        <div class="text-center">
                            <h6 class="font-bold text-xl my-2">Manage {{group.name}} Group Members</h6>
                            <hr>
                        </div>
                        <div class="my-4 w-2/5 px-3">
                            <input type="search" placeholder="Search members in Enterprise..."
                                   class="w-full rounded-full">
                        </div>
                        <div class="grid grid-cols-6 gap-3 px-3">
                           <div class="col-span-3 border rounded-lg p-3">
                               <div class="flex justify-between font-bold">
                                   <div>
                                       <p>{{selectedUser.length}} Selected of {{users.length}}</p>
                                   </div>
                                   <div>
                                       <button @click="selectAll">Select all</button>
                                   </div>
                               </div>
                               <hr class="my-3">
                               <div class="my-3 space-y-3">
                                   <div v-for="user in users" :key="user.id" class="">
                                       <label class="read-label flex gap-3 justify-between">
                                           <input name="selectedUser" type="checkbox" :value="user.id" class="peer hidden" v-model="selectedUser">
                                           <span class="capitalize peer-checked:bg-primary-100 p-1 rounded peer-checked:text-white">{{user.name}} {{user.last_name}}</span>
                                           <span v-if="user.id===admin" class="p-1 text-primary-100">Primary User</span>
                                       </label>
                                   </div>
                               </div>
                           </div>
                            <div class="col-span-2"></div>
                            <div class="col-span-3"></div>
                        </div>

                    </div>

                </div>
            </div>
        </Transition>
    </teleport>
</template>

<script setup lang="ts">
import {useForm} from "@inertiajs/inertia-vue3";
import {computed, reactive,ref} from "vue";
import {Link} from "@inertiajs/inertia-vue3";
const emits=defineEmits(['close'])
emits("close")
let props=defineProps({
    show:Boolean,
    group:Object,
    users:Object,
    admin:Number

})
const selectedUser=ref ([]);
const  selectAll=()=>{
    selectedUser.value= props.users.map((user: { id: any; }) => user.id)
}




</script>

<style scoped>

</style>
