<template layout>
    <Head>
        <title>Login</title>
        <meta  name="description" content="Login to access Backend" />

    </Head>
    <div class="h-screen grid place-content-center">
        <div class="bg-white rounded-3xl shadow overflow-hidden w-96">
            <div class=" py-5 px-5 ">
                <h1 class="font-semibold text-xl text-center mt-5">Admin Login</h1>
            </div>
            <div class="py-5 px-5">
                <form @submit.prevent="form.post(route('admin.authenticate'))">
                    <div class="mt-3">
                        <label for="form-input" class="read-label"><span class="mr-2 text-teal-700"><i class="fal fa-envelope"></i></span>Email:</label>
                        <input type="email" class="read-input" id="form-input" placeholder="Enter your email" required v-model="form.email"/>
                        <div v-if="form.errors.email" class="read-error">
                            <span><span class="mr-2"><i class="fal fa-exclamation-circle"></i></span>{{ form.errors.email }}</span>
                        </div>
                    </div>
                    <div class="mt-7">
                        <label for="password" class="read-label"><span class="mr-2 text-teal-700"><i class="fal fa-lock"></i></span>Password:</label>
                        <input type="password" class="read-input" id="password" placeholder="Enter your password" required v-model="form.password"/>
                        <div v-if="form.errors.password" class="read-error">
                            <span><span class="mr-2"><i class="fal fa-exclamation-circle"></i></span>{{ form.errors.password}}</span>
                        </div>
                    </div>
                    <div class="flex mt-4 place-content-end">
                        <button type="submit" class="btn-primary  m-1">Login</button>
                    </div>
                    <div class="flex">
                        <p class="font-medium">
                            <Link href="/admin/auth/password-reset" title="Password Reset" class="hover:text-sky-800">Forgot password</Link> |
                            <Link :href="route('admin.register')" title="Register" class="hover:text-sky-800">Register</Link>
                        </p>

                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script setup lang="ts">
import {Head} from "@inertiajs/inertia-vue3";
import {useForm} from "@inertiajs/inertia-vue3";
import {Link} from "@inertiajs/inertia-vue3";

let form=useForm({
    email: '',
    password: '',

})
let submit=()=>{
    form.post('/admin/auth/authenticate');
}

</script>

<style scoped>

</style>
