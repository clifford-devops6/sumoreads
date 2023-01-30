<template>
    <reader>
        <!---Sidebar menu-->
        <template #sidebar>
            <profile-menu :page="route('profile.security')">
            </profile-menu>
        </template>
        <div class="my-10 w-full px-3">
            <h1 class="text-xl font-semibold">Update Password</h1>
            <div class="border rounded-lg p-5 my-5 w-full">
                <h6 class="text-lg my-5">Update Password</h6>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="read-label" for="update-password">Current Password</label>
                            <input type="password" class="read-input" id="update-password" required v-model="form.password"/>
                            <div v-if="form.errors.password" class="read-error">
                                <span>{{ form.errors.password }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="read-label" for="update-last-name">New Password</label>
                            <input type="password" class="read-input" id="update-last-name" required v-model="form.new_password"/>
                            <div v-if="form.errors.new_password" class="read-error">
                                <span>{{ form.errors.new_password }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <button type="submit" class="btn-primary">Update password</button>
                    </div>
                </form>
            </div>

            <div class="border rounded-lg p-5 my-5 w-full">
                <h6 class="text-lg my-5">Delete Account</h6>
                <p>This action will delete this user account, including profile and all data related to the current logged in user.
                This action is irreversible</p>
                <div class="my-3">
                    <button @click="deleteAccount" class="btn-danger">Delete account</button>
                </div>

            </div>
        </div>
    </reader>
</template>

<script setup lang="ts">
import {useForm} from "@inertiajs/inertia-vue3";
import Reader from "@/views/layouts/reader.vue";
import ProfileMenu from "@/views/components/sidebar/profile-menu.vue";
import swal from 'sweetalert';
import {Inertia} from "@inertiajs/inertia";
let props=defineProps({
    user:Object
})
let form=useForm({
    password:'',
    new_password:''
})
function deleteUser(){
    Inertia.delete(route('profile.destroy',props.user.id))
}
const deleteAccount=()=>{
    swal({
        title: "Are you sure you?",
        text: "Once deleted, you will not be able to recover this account!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((result) => {
            if (result.isConfirmed){
                deleteUser();
            }

        });
}

const submit=()=>{
    form.patch(route('profile.password',props.user.id),{
        onSuccess: ()=>{
            form.reset();
        }
    });
}
</script>

<style scoped>

</style>
