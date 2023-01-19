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
                     <div class="text-center">
                         <h6 class="font-bold text-lg">Add Members</h6>
                         <p class="font-bold my-3">
                             {{account.administrator.slot-account.users.length}} of {{account.administrator.slot}}
                             slots available from your current plan
                         <Link :href="route('subscription.index')" class="text-primary-100 underline">
                             Add slots here
                         </Link>
                         </p>
                     </div>
                        <div>
                            <form @submit.prevent="submit">
                                <div class="grid px-10 my-5">
                                    <div>
                                        <p>Add multiple emails separated by comma</p>
                                    </div>
                                    <input type="email"  v-model="form.email" class="read-input" required>
                                    <div v-if="form.errors.email" class="read-error">
                                        <span>{{ form.errors.email }}</span>
                                    </div>
                                    <div class="my-5">
                                        <button type="submit" class="btn-primary" :disabled="form.processing">
                                            Send Invitation
                                        <span v-if="form.processing" class="animate-ping"><i class="fa-solid fa-ellipsis"></i></span></button>
                                    </div>
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
    email:'',
    account_id:props.account.id
})

const submit=()=>{
    form.post(route('send.invitation'),{
        onSuccess:()=>{
            form.reset();
            emits('close');
        }
    })
}


</script>

<style scoped>

</style>
