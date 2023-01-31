<template>
    <admin>
        <Head>
            <title>Subjects</title>
        </Head>
        <title-block>
            <h6 class="font-bold text-sm">Message Subjects</h6>
            <template #info>
                <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                    Create subject for contact form</p>
            </template>
        </title-block>
        <div class="my-10">
            <div>
                <!--table search and name-->
                <table class="table-auto w-full mt-3 border-t">
                    <thead>
                    <tr class="bg-gray-50 h-10 text-teal-900 font-bold text-sm">
                        <th class="text-start py-3 px-4">Id</th>
                        <th class="text-start py-3 px-4">Name</th>
                        <th class="text-start py-3 px-4">Created on</th>
                        <th class="py-3 px-4 text-start">Action</th>


                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-b" v-if="subjects" v-for="subject in subjects" :key="subject.id">
                        <td class="py-3 px-4">{{ subject.id }}</td>

                        <td class="py-3 px-4">{{ subject.name }}</td>
                        <td class="py-3 px-4">{{ new Date(subject.created_at).toDateString()}}</td>
                        <td class="py-3 px-4">
                            <dropdown placement="bottom">
                                <template #trigger="{ toggle }">
                                    <button @click="toggle" >
                                        Action <span class="self-center"><i class="far fa-ellipsis-v-alt"></i></span>
                                    </button>
                                </template>
                                <div class="shadow w-36">
                                    <ul class="divide-y">
                                        <li class="hover:bg-gray-100 ">
                                            <Link :href="route('subject.destroy',subject.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
                                                <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete
                                            </Link>
                                        </li>
                                        <li class="hover:bg-gray-100">
                                            <button class="p-2 w-full h-full text-start" @click="editSubject(subject)">
                                                <span class="mr-2"><i class="fal fa-pen"></i></span>Edit
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </dropdown>

                        </td>

                    </tr>


                    </tbody>

                </table>

            </div>
        </div>
        <template #sidebar>
            <div>
                <button type="button" class="btn-primary btn-small m-1" @click="showModal=true" > <span class="mr-2"><i class="fal fa-plus"></i></span>subject</button>
            </div>
            <modal :show="showModal" @close="showModal=false">
                <template #header>
                    <h6 class="font-bold text-lg">Create Contact form subject</h6>
                </template>
                <div>
                    <form @submit.prevent="submit" id="role-form">
                        <div class="mt-3">
                            <label for="subject-name" class="read-label">subject Name:</label>
                            <input type="text" class="read-input" id="subject-name" placeholder="Enter subject name"
                                   required v-model="form.name"/>
                            <div v-if="form.errors.name" class="read-error">
                                <span>{{ form.errors.name }}</span>
                            </div>
                        </div>

                    </form>
                </div>
                <template #footer >
                    <div class="flex justify-end">
                        <button class="btn-primary text-sm" type="submit" form="role-form">Save subject</button>
                    </div>
                </template>

            </modal>

            <modal :show="showEditModal" @close="showEditModal=false">
                <template #header>
                    <h6 class="font-bold text-lg">Edit Subject</h6>
                </template>
                <div>
                    <form @submit.prevent="update" id="role-form">
                        <div class="mt-3">
                            <label for="edit-subject-name" class="read-label">Subject Name:</label>
                            <input type="text" class="read-input" id="edit-subject-name" placeholder="Enter subject name"
                                   required v-model="editForm.name"/>
                            <div v-if="editForm.errors.name" class="read-error">
                                <span>{{ editForm.errors.name }}</span>
                            </div>
                        </div>


                    </form>
                </div>
                <template #footer >
                    <div class="flex justify-end">
                        <button class="btn-primary text-sm" type="submit" form="role-form">Update subject</button>
                    </div>
                </template>

            </modal>

        </template>
    </admin>
</template>

<script setup lang="ts">
import Modal from "@/views/components/modal.vue";
import Admin from "@/views/layouts/admin.vue";
import {Head} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue";
import {Link,useForm} from "@inertiajs/inertia-vue3";
import { Dropdown} from 'flowbite-vue'
import {ref} from "vue";

defineProps({
    subjects:Object,

})

const showModal=ref(false)
let form=useForm({
    name:'',

})

let submit=()=>{
    form.post(route('subject.store'),{
        onSuccess:()=>{
            form.reset()
            showModal.value=false

        }
    })}
//Edit modal
const showEditModal=ref(false)
const editForm=useForm({
    name:'',
    _method:'PATCH'
})
const editSubject= (subject:any)=>{
    editForm.name=subject.name;
    editForm.id=subject.id;
    showEditModal.value=true;
}
const update=()=>{
    editForm.post(route('subject.update',editForm.id))
    showEditModal.value=false;
}
</script>

<style scoped>

</style>
