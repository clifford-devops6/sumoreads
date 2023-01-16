<template layout="auth">
    <Head><title>Please login</title></Head>
<div class="flex place-content-center h-screen">
<div class="bg-white shadow-xl rounded-xl self-center md:w-2/5 p-4">
    <div class="flex justify-between">
        <Link href="/" class="text-primary-100">
            <span class="mr-3"><i class="fa-light fa-arrow-left-long"></i></span>Back
        </Link>
        <Link href="/" class="text-white bg-primary-100 p-1 rounded-full h-8 w-8" as="button">
            <span>
                <i class="fa-light fa-xmark"></i>
            </span>
        </Link>
    </div>
   <div class="text-center font-bold text-lg mt-5">Please Login</div>
    <div class="mt-10 px-14">
        <form @submit.prevent="form.post(route('authenticate'))">
            <div class="mt-5">

                <input type="email" class="read-input" id="form-input" placeholder="Enter your email" required v-model="form.email"/>
                <div v-if="form.errors.email" class="read-error">
                    <span>{{ form.errors.email }}</span>
                </div>
            </div>
            <div class="mt-7">

                <input type="password" class="read-input" id="password" placeholder="Enter your password" required v-model="form.password"/>
                <div v-if="form.errors.password" class="read-error">
                    <span>{{ form.errors.password}}</span>
                </div>
            </div>
            <div class="grid mt-4">
                <button type="submit" class="btn-primary  m-1">Login</button>
            </div>
            <div class="flex mt-5 justify-center">
                <p class="font-medium">
                    <Link :href="route('forgot.password')" title="Password Reset" class="hover:text-sky-800">Forgot password</Link> |
                    <Link :href="route('pricing')" title="Register" class="hover:text-sky-800">Sign Up</Link>
                </p>

            </div>
            <div class="text-center text-sm mt-5">
                <p>Protected by reCAPTCHA and subject to the Cuboid Privacy Policy and Terms of use</p>
            </div>
        </form>
    </div>
</div>
</div>
</template>

<script setup lang="ts">
import {Head,Link,useForm} from "@inertiajs/inertia-vue3";
let form=useForm({
    email:'',
    password:''
})
</script>

<style scoped>

</style>
