<template>
    <admin>
        <Head>
            <title>Roles</title>
        </Head>
        <title-block>
            <h6 class="font-bold text-sm">System Roles</h6>
            <template #info>
                <p class="text-sm"><span class="ml-2 text-teal-900"><i class="fas fa-info-circle"></i></span> Adjusting roles will affect user access level</p>
            </template>
        </title-block>

        <!--page content-->
        <div class="flex justify-between px-3 py-2">
            <div>
                <h6 class="font-bold">Roles ({{ roles.data.length }})</h6>

            </div>

            <div class=" mr-3">

                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input v-model="search" type="search" id="default-search" class="block p-2 pl-10 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-sky-600 focus:border-sky-600" placeholder="Search roles..." required>

                </div>
            </div>
        </div>
        <div>
            <!--table search and name-->
            <table class="table-auto w-full mt-3 border-t">
                <thead>
                <tr class="bg-gray-50 h-10 text-teal-900 font-bold text-sm">
                    <th class="text-start py-3 px-4">Id</th>
                    <th class="text-start py-3 px-4">Name</th>
                    <th class="text-start py-3 px-4">Guard</th>
                    <th class="py-3 px-4 text-start">Action</th>


                </tr>
                </thead>
                <tbody>
                <tr class="border-b" v-if="roles.data" v-for="role in roles.data" :key="role.id">
                    <td class="py-3 px-4">{{ role.id }}</td>
                    <td class="py-3 px-4">{{ role.name }}</td>
                    <td class="py-3 px-4">{{ role.guard_name }}</td>
                    <td class="py-3 px-4">
                        <dropdown placement="bottom">
                            <template #trigger="{ toggle }">
                                <Button @click="toggle" >
                                    Action <span class="self-center"><i class="far fa-ellipsis-v-alt"></i></span>
                                </Button>
                            </template>
                            <div class="shadow w-36">
                                <ul class="divide-y">
                                    <li class="hover:bg-gray-100 ">
                                        <Link :href="route('roles.destroy',role.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
                                            <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete
                                        </Link>
                                    </li>
                                    <li class="hover:bg-gray-100">
                                        <button class="p-2 w-full h-full text-start" @click="editRole(role)">
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
                    <h6 class="font-medium">Showing <span class="text-sky-800">{{ roles.current_page }}</span> of <span
                        class="text-sky-800">{{ roles.last_page }}</span> Page(s)</h6>
                </div>
                <div class="flex">
                    <Link :href="roles.prev_page_url" class="btn-primary text-xs m-1" v-if="roles.prev_page_url"><span
                        class="mr-2"><i class="far fa-angle-left"></i></span>Prev
                    </Link>
                    <Link :href="roles.next_page_url" class="btn-primary text-xs m-1" v-if="roles.next_page_url">Next
                        <span class="ml-2"><i class="far fa-angle-right"></i></span></Link>

                </div>

            </div>
        </div>



        <template #sidebar>
            <sidelink :link="route('roles.index')" class="text-teal-900">Roles</sidelink>
            <sidelink :link="route('permissions.index')">Permissions</sidelink>
            <div>
                <button type="button" class="btn-primary btn-small m-1" @click="showModal=true"> <span class="mr-2"><i class="fal fa-plus"></i></span>role</button>
            </div>

            <!--Role create modal-->

            <modal :show="showModal" @close="showModal=false">
                <template #header>
                    <h6 class="font-bold text-lg">Create Roles</h6>
                </template>
                <div>
                    <form @submit.prevent="submit" id="role-form">
                        <div class="mt-3">
                            <label for="role-name" class="creative-label">Role Name:</label>
                            <input type="text" class="creative-input" id="role-name" placeholder="Enter role name"
                                   required v-model="form.name"/>
                            <div v-if="form.errors.name" class="creative-error">
                                <span>{{ form.errors.name }}</span>
                            </div>
                        </div>
                        <div class="mt-5">
                            <label for="role-guard" class="creative-label">Role Guard:</label>
                            <input type="text" class="creative-input" id="role-guard" placeholder="Enter role guard"
                                   required v-model="form.guard_name"/>
                            <div v-if="form.errors.guard_name" class="creative-error">
                                <span>{{ form.errors.guard_name }}</span>
                            </div>
                        </div>

                    </form>
                </div>
                <template #footer >
                    <div class="flex justify-end">
                        <button class="btn-primary text-sm" type="submit" form="role-form">Save Role</button>
                    </div>
                </template>

            </modal>

            <!-- Edit Role create modal-->
            <modal :show="showEditModal" @close="showEditModal=false">
                <template #header>
                    <h6 class="font-bold text-lg">Update Role</h6>
                </template>
                <div>
                    <form @submit.prevent="update" id="role-form-update">
                        <div class="mt-3">
                            <label for="role-name" class="creative-label">Role Name:</label>
                            <input type="text" class="creative-input" id="role-name" placeholder="Enter role name"
                                   required v-model="updateForm.name"/>
                            <div v-if="updateForm.errors.name" class="creative-error">
                                <span>{{updateForm.errors.name }}</span>
                            </div>
                        </div>
                        <div class="mt-5">
                            <label for="role-guard" class="creative-label">Role Guard:</label>
                            <input type="text" class="creative-input" id="role-guard" placeholder="Enter role guard"
                                   required v-model="updateForm.guard_name"/>
                            <div v-if="updateForm.errors.guard_name" class="creative-error">
                                <span>{{updateForm.errors.guard_name }}</span>
                            </div>
                        </div>

                    </form>
                </div>
                <template #footer >
                    <div class="flex justify-end">
                        <button class="btn-primary text-sm" type="submit" form="role-form-update">Update Role</button>
                    </div>
                </template>

            </modal>

        </template>
    </admin>
</template>

<script setup lang="ts">
import { Dropdown} from 'flowbite-vue'
import Admin from "@/views/layouts/admin.vue";
import {Head} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue";
import {Link} from "@inertiajs/inertia-vue3";
import Sidelink from "@/views/components/sidelink.vue";
import Modal from "@/views/components/modal.vue";
import {ref, watch} from "vue";
import _ from "lodash"
import {Inertia} from "@inertiajs/inertia";
import {useForm} from "@inertiajs/inertia-vue3";

let props=defineProps({
    roles:Object,
    filters:Object
})

let form=useForm({
    name:'',
    guard_name:''
})
const showModal=ref(false)
const showEditModal=ref(false)

let search=ref(props.filters.search)
watch(search, _.debounce(function (value) {
    Inertia.get(route('roles.index'),{
        search:value
    }, {preserveState:true, replace:true});
}, 300))
//save role
let submit=()=>{
    form.post(route('roles.store'),{
        onSuccess:()=>{
            form.reset()
            showModal.value=false

        }
    })}

//edit role
let updateForm=useForm({
    name:'',
    guard_name:'',
    id:''
})
const editRole=(role)=>{

    updateForm.name=role.name;
    updateForm.guard_name=role.guard_name;
    updateForm.id=role.id
    showEditModal.value=true

}

let update=()=>{
    updateForm.patch(route('roles.update',updateForm.id),{
        onSuccess:()=>{
            updateForm.reset()
            showEditModal.value=false

        }
    })}
</script>

<style scoped>

</style>
