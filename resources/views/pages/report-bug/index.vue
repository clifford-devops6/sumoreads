<template layout="main">
    <Head><title>Report a Bug</title></Head>
    <div class="my-10">
        <div class="flex justify-center w-full">
            <div class="py-3 w-1/2">
                <div class="w-full ">
                    <h1 class="font-bold text-3xl text-center">Report a Bug</h1>
                    <p class="mt-3 text-center">At Sumoreads we are dedicated to developing the best product. With your help, we can identify bugs in our product
                        and improve the production for better experience</p>

                    <div class="mt-5  flex justify-center">
                        <form class="w-full" @submit.prevent="submit">
                            <div class="grid ">
                                <div class="mt-3">
                                    <label for="bug-url" class="read-label">Page url (Optional):</label>
                                    <input type="text" class="read-input" id="bug-url" placeholder="Enter page url"  v-model="form.url"/>
                                    <div v-if="form.errors.url" class="read-error">
                                        <span>{{ form.errors.url }}</span>
                                    </div>
                                </div>

                            </div>
                            <div class="grid mt-5">
                                <div >
                                    <label for="bug-message" class="read-label">Description the bug:</label>
                                    <textarea rows="6"  class="read-text-input " id="bug-message" placeholder="Your Message" required v-model="form.description"></textarea>

                                    <div v-if="form.errors.description" class="read-error">
                                        <span>{{ form.errors.description}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid mt-5">
                                <div>
                                    <label for="bug-screenshot" class="read-label">Attach Screenshot (Optional):</label>
                                </div>
                                <div>
                                    <span class="text-xs">Maximum file size 2MB. Allowed formats are jpeg,png,jpg, and gif</span>
                                </div>
                                <input type="file"  id="bug-screenshot" class="mt-3"
                                       required  @input="form.screenshot=$event.target.files[0]" accept="image/*"/>

                                <div v-if="form.errors.screenshot" class="read-error">
                                    <span>{{ form.errors.screenshot }}</span>
                                </div>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn-primary" :disabled="form.processing">Report Bug <span class="ml-3"><i class="fa-regular fa-arrow-right-long"></i></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {Head,useForm} from "@inertiajs/inertia-vue3";

let form=useForm({
    url:'',
    description:'',
    screenshot:''
})
const submit=()=>{
    form.post(route('report-bug.store'),{
        onSuccess:()=>{
            form.reset()
        }
    })
}
</script>

<style scoped>

</style>
