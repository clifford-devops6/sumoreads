<template layout="auth">
    <Head><title>Register for Sumoreads</title></Head>
    <div class="flex place-content-center h-screen">
        <div class="bg-white shadow-xl rounded-xl self-center md:w-1/2 p-4">
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
            <div class="text-center font-bold text-xl mt-5">
                <h6>Register for Sumoreads <span class="text-primary-100">Corporate Account</span></h6>
                <p class="mt-2 text-center text-primary-100 text-sm">Primary user details</p>
            </div>
            <div class="mt-10 px-14 overflow-y-scroll h-[50vh] custom-scrolling">
                <form @submit.prevent="form.post(route('corporate.create'))">
                    <div class="mt-5">

                        <input type="email" class="read-input"  placeholder="Enter your email" required v-model="form.email"/>
                        <div v-if="form.errors.email" class="read-error">
                            <span>{{ form.errors.email }}</span>
                        </div>
                    </div>
                    <div class="mt-5 grid grid-cols-2 gap-2">
                        <div>
                            <input type="text" class="read-input"  placeholder="Enter First Name" required v-model="form.name"/>
                            <div v-if="form.errors.name" class="read-error">
                                <span>{{ form.errors.name }}</span>
                            </div>
                        </div>
                        <div>
                            <input type="text" class="read-input"  placeholder="Enter Last Name" required v-model="form.last_name"/>
                            <div v-if="form.errors.last_name" class="read-error">
                                <span>{{ form.errors.last_name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">

                        <input type="password" class="read-input" id="password" autocomplete="new-password" placeholder="Enter your password" required v-model="form.password"/>
                        <div v-if="form.errors.password" class="read-error">
                            <span>{{ form.errors.password}}</span>
                        </div>
                    </div>
                    <div class="mt-5">

                        <input type="password" class="read-input" id="password"  placeholder="Confirm your password" required v-model="form.password_confirmation"/>
                        <div v-if="form.errors.password_confirmation" class="read-error">
                            <span>{{ form.errors.password_confirmation}}</span>
                        </div>
                    </div>
                    <!-- company details-->
                    <div class="py-5">
                        <h6 class="font-bold">Company Details</h6>
                        <hr class="mt-3">
                    </div>
                    <div class="mt-5 grid grid-cols-2 gap-2">
                        <div>
                            <input type="text" class="read-input"  placeholder="Enter Company Name" required v-model="form.company_name"/>
                            <div v-if="form.errors.company_name" class="read-error">
                                <span>{{ form.errors.company_name }}</span>
                            </div>
                        </div>
                        <div>
                            <input type="text" class="read-input"  placeholder="Enter Company Address" required v-model="form.address"/>
                            <div v-if="form.errors.address" class="read-error">
                                <span>{{ form.errors.address }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-2">
                        <div>
                            <input type="text" class="read-input"  placeholder="City" required v-model="form.city"/>
                            <div v-if="form.errors.city" class="read-error">
                                <span>{{ form.errors.city}}</span>
                            </div>
                        </div>
                        <div>
                            <input type="text" class="read-input"  placeholder="Country" required v-model="form.country"/>
                            <div v-if="form.errors.country" class="read-error">
                                <span>{{ form.errors.country }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label class="read-label">
                            <input type="checkbox" required class="mr-2 rounded">
                            By clicking create account, I agree that I have read and accepted the Terms of use and Privacy Policy
                        </label>
                    </div>
                    <div class="grid mt-5">
                        <button type="submit" class="btn-primary  m-1">Create Account <span v-if="form.processing" class="animate-ping"><i class="fa-regular fa-ellipsis"></i></span></button>
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
    password:'',
    name:'',
    last_name:'',
    password_confirmation:'',
    company_name:'',
    address:'',
    city:'',
    country:''
})
</script>

<style scoped>

</style>
