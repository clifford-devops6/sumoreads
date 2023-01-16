<template>
<admin>
<Head><title>Account Types</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">Account Types</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
               Each User account has a type. Billings are based on account types</p>
        </template>
    </title-block>
    <div class="my-10 px-3">
        <table class="table-auto w-full mt-3 border-t">
            <thead>
            <tr class="bg-gray-50 h-10 text-teal-900 font-bold text-sm">
                <th class="text-start py-3 px-4">Id</th>
                <th class="text-start py-3 px-4">Name</th>
                <th class="text-start py-3 px-4">Price($)</th>
                <th class="py-3 px-4 text-start">Action</th>


            </tr>
            </thead>
            <tbody>
            <tr class="border-b" v-for="type in types" :key="type.id">
                <td class="py-3 px-4">{{type.id }}</td>
                <td class="py-3 px-4">{{type.name }}</td>
                <td class="py-3 px-4">{{type.price}}</td>
                <td class="py-3 px-4">
                    <button class="p-2 w-full h-full text-start" @click="editType(type)">
                        <span class="mr-2"><i class="fal fa-pen"></i></span>Edit
                    </button>
                </td>

            </tr>


            </tbody>

        </table>
    </div>
    <div>
        <modal :show="showEditModal" @close="showEditModal=false">
            <template #header>
                <h6 class="font-bold text-lg">Edit Account type</h6>
            </template>
            <div>
                <form @submit.prevent="update" id="role-form">
                    <div class="grid">
                        <div class="mt-5">
                            <label for="account-name" class="read-label">Account type Name:</label>
                            <input type="text" class="read-input" id="account-name" placeholder="Account type name"
                                   required v-model="form.name"/>
                            <div v-if="form.errors.name" class="read-error">
                                <span>{{ form.errors.name }}</span>
                            </div>
                        </div>

                    </div>

                    <div class="grid">
                        <div class="mt-5">
                            <label for="account-price" class="read-label">Account type Price:</label>
                            <input type="text" class="read-input" id="account-price" placeholder="Account type price"
                                   required v-model="form.price"/>
                            <div v-if="form.errors.price" class="read-error">
                                <span>{{ form.errors.price }}</span>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <template #footer >
                <div class="flex justify-end">
                    <button class="btn-primary text-sm" type="submit" form="role-form">Update Account type</button>
                </div>
            </template>

        </modal>
    </div>
</admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import TitleBlock from "@/views/components/title-block.vue";
import Modal from "@/views/components/modal.vue"
import {Head,Link,useForm} from "@inertiajs/inertia-vue3";
import {ref} from "vue";
defineProps({
    types:Object
})
const showEditModal=ref(false)
let form=useForm({
    name:'',
    price:'',
    id:'',
    _method:'PATCH'
})
const editType=(type:any)=>{
    form.name=type.name;
    form.price=type.price;
    form.id=type.id;
    showEditModal.value=true;
}
const update=()=>{
    form.post(route('account-types.update',form.id),{
        onSuccess:()=>{
            form.reset();
            showEditModal.value=false
        }
    })
}
</script>

<style scoped>

</style>
