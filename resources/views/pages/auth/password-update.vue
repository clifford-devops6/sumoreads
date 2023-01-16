<template layout="auth">
    <Head><title>Forgot Password</title></Head>
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
            <div class="text-center font-bold text-lg mt-5">Update your Password</div>
            <div class="mt-10 px-14">
                <form @submit.prevent="form.post(route('new.password'))">
                    <div class="mt-5">

                        <input type="text" class="read-input" id="form-input" placeholder="Enter OTP Code" required v-model="form.code"/>
                        <div v-if="form.errors.code" class="read-error">
                            <span>{{ form.errors.code }}</span>
                        </div>
                    </div>
                    <div class="mt-5">

                        <input type="password" class="read-input" autocomplete="new-password" placeholder="Enter your password" required v-model="form.password"/>
                        <div v-if="form.errors.password" class="read-error">
                            <span>{{ form.errors.password}}</span>
                        </div>
                    </div>
                    <div class="mt-5">

                        <input type="password" class="read-input"   placeholder="Confirm your password" required v-model="form.password_confirmation"/>
                        <div v-if="form.errors.password_confirmation" class="read-error">
                            <span>{{ form.errors.password_confirmation}}</span>
                        </div>
                    </div>

                    <div class="grid mt-4">
                        <button type="submit" class="btn-primary  m-1">Update password</button>
                    </div>
                    <div class="py-3" v-if="$page.props.status">
                        <p class="text-sm" ><span class="ml-2 text-teal-900"><i class="fas fa-info-circle"></i></span> {{$page.props.status}}</p>
                    </div>
                    <div class="flex mt-5 justify-center">
                        <p class="font-medium">
                            <Link :href="route('login')" title="Password Reset" class="hover:text-sky-800">Login</Link> |
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
let props=defineProps({
    token:String
})
let form=useForm({
    code:'',
    password:'',
    password_confirmation:'',
    token:props.token
})
</script>

<style scoped>

</style>
