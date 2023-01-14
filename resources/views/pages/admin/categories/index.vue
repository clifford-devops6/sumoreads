<template>
    <admin>
        <Head>
            <title>Categories</title>
        </Head>
        <title-block>
            <h6 class="font-bold text-sm">Categories</h6>
            <template #info>
                <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                    Each News source is classified by a category</p>
            </template>
        </title-block>
        <div class="my-10">
            <div>
                <!--table search and name-->
                <table class="table-auto w-full mt-3 border-t">
                    <thead>
                    <tr class="bg-gray-50 h-10 text-teal-900 font-bold text-sm">
                        <th class="text-start py-3 px-4">Id</th>
                        <th class="text-start py-3 px-4">Icon</th>
                        <th class="text-start py-3 px-4">Name</th>
                        <th class="text-start py-3 px-4">Created on</th>
                        <th class="text-start py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-start">Action</th>


                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-b" v-if="categories.data" v-for="category in categories.data" :key="category.id">
                        <td class="py-3 px-4">{{ category.id }}</td>
                        <td class="py-3 px-4">
                            <span v-html="category.icon"></span>
                        </td>
                        <td class="py-3 px-4">{{ category.name }}</td>
                        <td class="py-3 px-4">{{ new Date(category.created_at).toDateString()}}</td>
                        <td class="py-3 px-4">
                            <span v-if="category.status.name==='Enabled'">Active</span>
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
                                            <Link :href="route('categories.destroy',category.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
                                                <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete
                                            </Link>
                                        </li>
                                        <li class="hover:bg-gray-100">
                                            <button class="p-2 w-full h-full text-start" @click="editCategory(category)">
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
                <button type="button" class="btn-primary btn-small m-1" @click="showModal=true" > <span class="mr-2"><i class="fal fa-plus"></i></span>category</button>
            </div>
            <modal :show="showModal" @close="showModal=false">
                <template #header>
                    <h6 class="font-bold text-lg">Create categories</h6>
                </template>
                <div>
                    <form @submit.prevent="submit" id="role-form">
                        <div class="mt-3">
                            <label for="category-name" class="read-label">Category Name:</label>
                            <input type="text" class="read-input" id="category-name" placeholder="Enter category name"
                                   required v-model="form.name"/>
                            <div v-if="form.errors.name" class="read-error">
                                <span>{{ form.errors.name }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">

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
                            <div class="mt-5">
                                <label for="category-icon" class="read-label">Category Icon(Font Awesome v6 Icon):</label>

                                <input type="text" class="read-input" id="category-icon" placeholder="Enter category icon"
                                       required v-model="form.icon"/>
                                <div v-if="form.errors.icon" class="read-error">
                                    <span>{{ form.errors.icon }}</span>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <template #footer >
                    <div class="flex justify-end">
                        <button class="btn-primary text-sm" type="submit" form="role-form">Save category</button>
                    </div>
                </template>

            </modal>

            <modal :show="showEditModal" @close="showEditModal=false">
                <template #header>
                    <h6 class="font-bold text-lg">Edit category</h6>
                </template>
                <div>
                    <form @submit.prevent="update" id="role-form">
                        <div class="mt-3">
                            <label for="edit-category-name" class="read-label">Category Name:</label>
                            <input type="text" class="read-input" id="edit-category-name" placeholder="Enter category name"
                                   required v-model="editForm.name"/>
                            <div v-if="editForm.errors.name" class="read-error">
                                <span>{{ editForm.errors.name }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">

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
                            <div class="mt-5">
                                <label for="category-icon" class="read-label">Category Icon(Font Awesome v6 Icon):</label>

                                <input type="text" class="read-input" id="category-icon" placeholder="Enter category icon"
                                       required v-model="editForm.icon"/>
                                <div v-if="editForm.errors.icon" class="read-error">
                                    <span>{{ editForm.errors.icon }}</span>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <template #footer >
                    <div class="flex justify-end">
                        <button class="btn-primary text-sm" type="submit" form="role-form">Update Category</button>
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
    categories:Object,
    statuses:Object
})

const showModal=ref(false)
let form=useForm({
    name:'',
    status_id:'',
    icon:''
})

let submit=()=>{
    form.post(route('categories.store'),{
        onSuccess:()=>{
            form.reset()
            showModal.value=false

        }
    })}
//Edit modal
const showEditModal=ref(false)
const editForm=useForm({
    name:'',
    status_id:'',
    id:'',
    icon:'',
    _method:'PATCH'
})
const editCategory= (category:any)=>{
    editForm.name=category.name;
    editForm.status_id=category.status_id;
    editForm.icon=category.icon;
    editForm.id=category.id;
    showEditModal.value=true;
}
const update=()=>{
    editForm.post(route('categories.update',editForm.id))
    showEditModal.value=false;
}
</script>

<style scoped>

</style>
