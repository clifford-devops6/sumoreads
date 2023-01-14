<template>
<admin>
    <Head>
        <title>Languages</title>
    </Head>
    <title-block>
        <h6 class="font-bold text-sm">Languages</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
            All languages in which news articles can be pulled from api. Current default is English</p>
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
                    <th class="text-start py-3 px-4">Abbreviation</th>
                    <th class="text-start py-3 px-4">Created on</th>
                    <th class="text-start py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-start">Action</th>


                </tr>
                </thead>
                <tbody>
                <tr class="border-b" v-if="languages.data" v-for="language in languages.data" :key="language.id">
                    <td class="py-3 px-4">{{ language.id }}</td>
                    <td class="py-3 px-4">{{ language.name }}</td>
                    <td class="py-3 px-4">{{ language.abbreviation }}</td>
                    <td class="py-3 px-4">{{ new Date(language.created_at).toDateString()}}</td>
                    <td class="py-3 px-4">
                        <span v-if="language.status.name==='Enabled'">Active</span>
                        <span v-else>Inactive</span>
                    </td>
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
                                        <Link :href="route('languages.destroy',language.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
                                            <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete
                                        </Link>
                                    </li>
                                    <li class="hover:bg-gray-100">
                                        <button class="p-2 w-full h-full text-start" @click="editLanguage(language)">
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
            <div class="bg-gray-50 p-3 flex justify-between">
                <div class="self-center">
                    <h6 class="font-medium">Showing <span class="text-sky-800">{{ languages.current_page }}</span> of <span
                        class="text-sky-800">{{ languages.last_page }}</span> Page(s)</h6>
                </div>
                <div class="flex">
                    <Link :href="languages.prev_page_url" class="btn-primary text-xs m-1" v-if="languages.prev_page_url"><span
                        class="mr-2"><i class="far fa-angle-left"></i></span>Prev
                    </Link>
                    <Link :href="languages.next_page_url" class="btn-primary text-xs m-1" v-if="languages.next_page_url">Next
                        <span class="ml-2"><i class="far fa-angle-right"></i></span></Link>

                </div>

            </div>
        </div>
    </div>
    <template #sidebar>
        <div>
            <button type="button" class="btn-primary btn-small m-1" @click="showModal=true" > <span class="mr-2"><i class="fal fa-plus"></i></span>Language</button>
        </div>
        <modal :show="showModal" @close="showModal=false">
            <template #header>
                <h6 class="font-bold text-lg">Create Languages</h6>
            </template>
            <div>
                <form @submit.prevent="submit" id="role-form">
                    <div class="mt-3">
                        <label for="language-name" class="read-label">Language Name:</label>
                        <input type="text" class="read-input" id="language-name" placeholder="Enter Language name"
                               required v-model="form.name"/>
                        <div v-if="form.errors.name" class="read-error">
                            <span>{{ form.errors.name }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="mt-5">
                            <label for="language-abbr" class="read-label">Language Abbreviation(ISO Code):</label>
                            <input type="text" class="read-input" id="language-abbr" placeholder="Enter Language Abbreviation"
                                   required v-model="form.abbreviation"/>
                            <div v-if="form.errors.abbreviation" class="read-error">
                                <span>{{ form.errors.abbreviation }}</span>
                            </div>
                        </div>
                        <div class="mt-5">
                            <label class="creative-label">Select Status:</label>
                            <select required class="read-input" v-model="form.status_id">
                                <option selected value="">Select Status</option>
                                <option :value="status.id" v-for="status in statuses" :key="status.id">{{status.name}}</option>

                            </select>

                            <div v-if="form.errors.status_id" class="creative-error">
                                <span>{{ form.errors.status_id }}</span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <template #footer >
                <div class="flex justify-end">
                    <button class="btn-primary text-sm" type="submit" form="role-form">Save Language</button>
                </div>
            </template>

        </modal>

        <modal :show="showEditModal" @close="showEditModal=false">
            <template #header>
                <h6 class="font-bold text-lg">Edit Language</h6>
            </template>
            <div>
                <form @submit.prevent="update" id="role-form">
                    <div class="mt-3">
                        <label for="edit-language-name" class="read-label">Language Name:</label>
                        <input type="text" class="read-input" id="edit-language-name" placeholder="Enter Language name"
                               required v-model="editForm.name"/>
                        <div v-if="editForm.errors.name" class="read-error">
                            <span>{{ editForm.errors.name }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="mt-5">
                            <label for="edit-language-abbr" class="read-label">Language Abbreviation(ISO Code):</label>
                            <input type="text" class="read-input" id="edit-language-abbr" placeholder="Enter Language Abbreviation"
                                   required v-model="editForm.abbreviation"/>
                            <div v-if="editForm.errors.abbreviation" class="read-error">
                                <span>{{ editForm.errors.abbreviation }}</span>
                            </div>
                        </div>
                        <div class="mt-5">
                            <label class="read-label">Select Status:</label>
                            <select required class="read-input" v-model="editForm.status_id">
                                <option selected value="">Select Status</option>
                                <option :value="status.id" v-for="status in statuses" :key="status.id">{{status.name}}</option>

                            </select>

                            <div v-if="editForm.errors.status_id" class="creative-error">
                                <span>{{ editForm.errors.status_id }}</span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <template #footer >
                <div class="flex justify-end">
                    <button class="btn-primary text-sm" type="submit" form="role-form">Save Language</button>
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
    languages:Object,
    statuses:Object
})

const showModal=ref(false)
let form=useForm({
    name:'',
    abbreviation:'',
    status_id:''
})

let submit=()=>{
    form.post(route('languages.store'),{
        onSuccess:()=>{
            form.reset()
            showModal.value=false

        }
    })}
//Edit modal
const showEditModal=ref(false)
const editForm=useForm({
    name:'',
    abbreviation:'',
    status_id:'',
    id:'',
    _method:'PATCH'
})
const editLanguage= (language:any)=>{
    editForm.name=language.name;
    editForm.abbreviation=language.abbreviation;
    editForm.status_id=language.status_id;
    editForm.id=language.id
    showEditModal.value=true;
}
const update=()=>{
    editForm.post(route('languages.update',editForm.id))
    showEditModal.value=false;
}
</script>

<style scoped>

</style>
