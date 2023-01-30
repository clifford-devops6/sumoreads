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
            <div @click.self="$emit('close')" v-if="show" class="inset-0 fixed bg-gray-900 bg-opacity-70 z-[10000] grid place-items-center p-5" >
                <div class="bg-white lg:w-1/2  w-full rounded-xl">
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
                        <div>
                            <div class="text-center">
                                <h6 class="text-lg font-bold">Add Members</h6>
                                <p class="my-3 text-primary-100 text-lg">{{account.administrator.slot-account.users_count}} of {{account.administrator.slot}} slots Available from current plan</p>
                                <p>You will be charged USD {{Number(account.type.price).toFixed(2)}} for each slot added</p>
                            </div>

                            <form @submit.prevent="form.post(route('add.slot'))">
                                <div class="my-5 grid justify-center">
                                    <div class="my-2">
                                        <label class="font-bold">How many members do you want to add?</label>
                                    </div>
                                    <input type="number" v-model="form.slots"  class="rounded-full">
                                    <div v-if="form.errors.slots" class="read-error">
                                        <span>{{ form.errors.slots }}</span>
                                    </div>
                                </div>
                                <div class="flex justify-center my-10">
                                    <button class="btn-primary">Add slots <span v-if="form.processing" class="animate-ping"><i class="fa-solid fa-ellipsis"></i></span></button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </Transition>
    </teleport>
</template>

<script setup lang="ts">
import {useForm} from "@inertiajs/inertia-vue3";
import {computed} from "vue";
import {Link} from "@inertiajs/inertia-vue3";
const emits=defineEmits(['close'])
emits("close")
let props=defineProps({
    show:Boolean,
    account:Object

})

let form=useForm({
    slots:'',
    account_id:props.account.id
})


</script>

<style scoped>

</style>
