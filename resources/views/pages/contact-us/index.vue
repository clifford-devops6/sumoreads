<template layout="main">
<Head><title>Contact Us</title></Head>
    <div class="my-10">
        <div class="flex justify-center w-full">
            <div class="py-3 w-1/2">
                <div class="w-full ">
                    <h1 class="font-bold text-3xl text-center">Contact Us</h1>
                    <p class="mt-3 text-center">Having something in mind? Feel free to reach out</p>

                    <div class="mt-5  flex justify-center">
                        <form class="w-full" @submit.prevent="submit">
                            <div v-if="!auth" class="grid grid-cols-2 gap-2">
                                <div class="mt-3">
                                    <label for="contact-name" class="read-label">Name:</label>
                                    <input type="text" class="read-input" id="contact-name" placeholder="Enter your name" required v-model="form.name"/>
                                    <div v-if="form.errors.name" class="read-error">
                                        <span>{{ form.errors.name }}</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="contact-email" class="read-label">Last name:</label>
                                    <input type="email" class="read-input" id="contact-email" placeholder="Enter your email" required v-model="form.email"/>
                                    <div v-if="form.errors.email" class="read-error">
                                        <span>{{ form.errors.email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid mt-5">
                                <div >
                                    <label for="contact-subject" class="read-label">Subject:</label>
                                    <select required class="read-input" v-model="form.subject">
                                        <option selected value="">Select Status</option>
                                        <option :value="subject.id" v-for="subject in subjects" :key="subject.id">{{subject.name}}</option>

                                    </select>
                                    <div v-if="form.errors.subject" class="read-error">
                                        <span>{{ form.errors.subject }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid mt-5">
                                <div >
                                    <label for="contact-message" class="read-label">Message:</label>
                                    <textarea rows="6"  class="read-text-input " id="contact-message" placeholder="Your Message" required v-model="form.message"></textarea>

                                    <div v-if="form.errors.message" class="read-error">
                                        <span>{{ form.errors.message }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn-primary" :disabled="form.processing">Send Message <span class="ml-3"><i class="fa-regular fa-arrow-right-long"></i></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {Head, useForm, usePage} from "@inertiajs/inertia-vue3";
defineProps({
    subjects:Object
})
const page=usePage()
const auth=page.props.value.auth
let form=useForm({
    name:auth?auth.name:'',
    email:auth?auth.email:'',
    subject:'',
    message:''
})
const submit=()=>{
    form.post(route('contact-us.store'),{
        onSuccess:()=>{
            form.reset()
        }
    })
}


</script>

<style scoped>

</style>
