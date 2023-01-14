<template layout="default">
    <Head>
        <title>Register</title>
        <meta  name="description" content="Register to access backend" />

    </Head>
    <div class="grid grid-cols-1 place-content-center h-screen place-items-center p-2">
        <div class="bg-white rounded-3xl shadow overflow-hidden w-96 md:w-1/2 lg:w-5/12 p-2">
            <div class=" py-5 px-5 ">
                <h1 class="font-semibold text-xl text-center mt-5">Admin Register</h1>
            </div>
            <div class="py-5 px-5">
                <form @submit.prevent="form.post(route('admin.save'))">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="mt-3">
                            <label for="first_name" class="read-label"><span class="mr-2 text-sky-800"><i class="fal fa-user-circle"></i></span>First Name:</label>
                            <input type="text" class="read-input" id="first_name" placeholder="Enter your first name" required v-model="form.name"/>
                            <div v-if="form.errors.name" class="read-error">
                                <span><span><i class="fal fa-exclamation-circle"></i></span>{{ form.errors.name }}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="last_name" class="read-label"><span class="mr-2 text-sky-800"><i class="fal fa-user-circle"></i></span>Last name:</label>
                            <input type="text" class="read-input" id="last_name" placeholder="Enter your last name" required v-model="form.last_name"/>
                            <div v-if="form.errors.last_name" class="read-error">
                                <span><span><i class="fal fa-exclamation-circle"></i></span>{{ form.errors.last_name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-7">
                        <label for="form-input" class="read-label"><span class="mr-2 text-sky-800"><i class="fal fa-envelope"></i></span>Email:</label>
                        <input type="email" class="read-input" id="form-input" placeholder="Enter your email" required v-model="form.email"/>
                        <div v-if="form.errors.email" class="read-error">
                            <span><span><i class="fal fa-exclamation-circle"></i></span>{{ form.errors.email }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-7">
                        <div class="mt-3">
                            <label for="password" class="read-label"><span class="mr-2 text-sky-800"><i class="fal fa-lock"></i></span>Password:</label>
                            <input type="password" class="read-input" id="password" placeholder="Enter your password" required v-model="form.password"/>
                            <div v-if="form.errors.password" class="read-error">
                                <span><span><i class="fal fa-exclamation-circle"></i></span>{{ form.errors.password}}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="password_confirmation" class="read-label"><span class="mr-2 text-sky-800"><i class="fal fa-lock"></i></span>Confirm Password:</label>
                            <input type="password" class="read-input" id="password_confirmation" placeholder="Confirm your password" required v-model="form.password_confirmation"/>
                        </div>

                    </div>
                    <div class="flex mt-4 place-content-end">
                        <button type="submit" class="btn-primary  m-1" :disabled="form.processing">Register</button>
                    </div>
                    <div class="text-center">
                        <Link :href="route('admin.login')" title="Login" class="hover:text-primary-200 text-sm">Login</Link> |
                        <Link :href="route('admin.login')" title="Login" class="hover:text-primary-200 text-sm">Terms & Conditions</Link>



                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script setup lang="ts">
import {Head} from "@inertiajs/inertia-vue3";
import {Link} from "@inertiajs/inertia-vue3";
import {useForm} from "@inertiajs/inertia-vue3";
let form=useForm({
    name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation:'',
})

</script>

<style scoped>

</style>
