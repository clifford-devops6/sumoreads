<template>
    <admin>
        <Head><title>Update User</title></Head>
        <title-block>
            <h6 class="font-bold text-sm">Update user details</h6>
            <template #info>
                <p class="text-sm"><span class="ml-2 mr-2 text-teal-900"><i class="fas fa-info-circle"></i></span>System users should be
                    created by the Super admin user</p>
            </template>
        </title-block>

        <div class="my-10 px-3">
            <form @submit.prevent="form.patch(route('users.update',user.id))">
                <div class="grid grid-cols-2 gap-2 mt-5">
                    <div class="grid">
                        <label for="first_name" class="read-label">First Name:</label>
                        <input type="text" class="read-input" id="first_name" placeholder="Enter your first name" required v-model="form.name"/>
                        <div v-if="form.errors.name" class="read-error">
                            <span>{{ form.errors.name }}</span>
                        </div>
                    </div>
                    <div class="grid">
                        <label for="last_name" class="read-label">Last name:</label>
                        <input type="text" class="read-input" id="last_name" placeholder="Enter your last name" required v-model="form.last_name"/>
                        <div v-if="form.errors.last_name" class="read-error">
                            <span>{{ form.errors.last_name }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <label for="form-input" class="read-label">Email:</label>
                    <input type="email" class="read-input" id="form-input" placeholder="Enter your email" required v-model="form.email"/>
                    <div v-if="form.errors.email" class="read-error">
                        <span>{{ form.errors.email }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 mt-7">
                    <div class="grid">
                        <label for="password" class="read-label">Password:</label>
                        <input type="password" class="read-input" id="password" placeholder="Enter your password"  v-model="form.password"/>
                        <div v-if="form.errors.password" class="read-error">
                            <span>{{ form.errors.password}}</span>
                        </div>
                    </div>
                    <div class="grid">
                        <label for="password_confirmation" class="read-label">Confirm Password:</label>
                        <input type="password" class="read-input" id="password_confirmation" placeholder="Confirm your password"  v-model="form.password_confirmation"/>
                    </div>

                </div>
                <div class="my-8">
                    <h6 class="my-2 font-bold">Roles and Permission</h6>
                    <hr>
                    <p class="my-3">Select at least one role and permission for the user</p>
                </div>
                <div class="grid grid-cols-2">
                    <div class="grid">
                        <h6 class="font-bold">Roles</h6>

                        <div>
                            <label class="read-label inline-block m-2" v-for="role in roles" :key="role.id" >
                                <input type="checkbox" class="read-check" :value="role.id" v-model="form.role_id">
                                <span class="ml-2">{{role.name}}</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid">
                        <h6 class="font-bold">Permissions</h6>

                        <div>
                            <label class="read-label inline-block m-2" v-for="permission in permissions" :key="permission.id">
                                <input type="checkbox" class="read-check" :value="permission.id" v-model="form.permission_id">
                                <span class="ml-2">{{permission.name}}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="my-5">
                    <button class="btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head, useForm} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue"
let props=defineProps({
    roles:Object,
    permissions:Object,
    user:Object,
    user_roles:Object,
    user_permissions:Object
})
let form=useForm({
    name:props.user.name,
    last_name:props.user.last_name,
    email:props.user.email,
    password:'',
    password_confirmation:'',
    role_id:props.user_roles,
    permission_id:props.user_permissions
})
</script>

<style scoped>

</style>
