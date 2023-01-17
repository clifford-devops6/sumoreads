<template>
<reader>
   <!---Sidebar menu-->
    <template #sidebar>
        <profile-menu :page="route('profile.index')">
        </profile-menu>
    </template>
    <div class="my-10 w-full">
        <h1 class="text-xl font-semibold">General Settings</h1>
        <div class="border rounded-lg p-5 my-5 w-full">
            <h6 class="text-lg my-5">Personal Information</h6>
            <form @submit.prevent="form.patch(route('profile.update',user.id))">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="read-label" for="update-name">First name</label>
                        <input type="text" class="read-input" id="update-name" required v-model="form.name"/>
                        <div v-if="form.errors.name" class="read-error">
                            <span>{{ form.errors.name }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="read-label" for="update-last-name">Last name</label>
                        <input type="text" class="read-input" id="update-last-name" required v-model="form.last_name"/>
                        <div v-if="form.errors.last_name" class="read-error">
                            <span>{{ form.errors.last_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="my-5">
                    <button type="submit" class="btn-primary">Update info</button>
                </div>
            </form>
        </div>

        <div class="border rounded-lg p-5 my-5 w-full">
            <h6 class="text-lg my-5">Update email</h6>
            <form @submit.prevent="formEmail.patch(route('update.email',user.id))">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="read-label" for="update-email">Email</label>
                        <input type="text" class="read-input" id="update-email" required v-model="formEmail.email"/>
                        <div v-if="formEmail.errors.email" class="read-error">
                            <span>{{ formEmail.errors.email }}</span>
                        </div>
                    </div>

                </div>
                <div class="my-5">
                    <button type="submit" class="btn-primary">Update email</button>
                </div>
            </form>
        </div>
    </div>
</reader>
</template>

<script setup lang="ts">
import {Link,useForm} from "@inertiajs/inertia-vue3";
import Reader from "@/views/layouts/reader.vue";
import ProfileMenu from "@/views/components/sidebar/profile-menu.vue";
let props=defineProps({
    user:Object
})
let form=useForm({
    name:props.user.name,
    last_name:props.user.last_name
})
let formEmail=useForm({
    email:props.user.email
})
</script>

<style scoped>

</style>
