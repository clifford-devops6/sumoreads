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
            <div @click.self="$emit('close')" v-if="show" class="inset-0 fixed bg-gray-900 bg-opacity-70 z-50 grid place-items-center p-5" >
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
                                <h6 class="text-lg font-bold">Make Payment</h6>
                                <p class="my-3 text-xl">Payment for {{account.type.name}} Account</p>
                            </div>

                            <form @submit.prevent="form.post(route('pay.now'))">
                                <div class="grid grid-cols-2 gap-2 px-10 my-10">
                                    <div class="group p-2 border rounded-lg flex gap-3" :class="{'bg-primary-100 bg-opacity-30':form.package==='1'}">
                                        <div>
                                            <input value="1" type="radio" name="package" class="w-5 h-5 checked:ring-primary-100
                                            border-primary-100 checked:bg-primary-100  checked:outline-primary-100" v-model="form.package" required>
                                        </div>
                                        <div>
                                            <p class="my-1">1 Month period</p>
                                            <p class="font-bold my-1">Amount USD {{Number(account.administrator.slot *account.type.price).toFixed(2)}}</p>
                                            <p class="my-1">Expires {{month}}</p>
                                        </div>

                                    </div>
                                    <div class=" p-2 border rounded-lg flex gap-3" :class="{'bg-primary-100 bg-opacity-30':form.package==='12'}">
                                        <div>
                                            <input value="12" type="radio" name="package" class="w-5 h-5 checked:ring-primary-100
                                            border-primary-100 checked:bg-primary-100  checked:outline-primary-100" v-model="form.package" required>
                                        </div>
                                        <div>
                                            <p class="my-1">1 Year period</p>
                                            <p class="font-bold my-1">Amount USD {{Number(account.administrator.slot *account.type.price*12).toFixed(2)}}</p>
                                            <p class="my-1">Expires {{annual}}</p>
                                        </div>

                                    </div>
                                </div>
                                <div class="flex justify-center my-10">
                                    <button class="btn-primary">Pay Now <span v-if="form.processing" class="animate-ping"><i class="fa-solid fa-ellipsis"></i></span></button>
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
    account:Object,
    expiry:String

})

let form=useForm({
    package:'',
    account_id:props.account.id
})

const month=computed(()=>{
    var myDate = new Date(props.expiry);
    return  new Date(myDate.setMonth(1)).toDateString();


})

const annual=computed(()=>{
    var myDate = new Date(props.expiry);
    return  new Date(myDate.setMonth(12)).toDateString();


})

</script>

<style scoped>

</style>
