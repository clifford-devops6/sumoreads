<template>
<admin>
<Head><title>Create adverts</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">Create Advertisements</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 mr-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                Create and run adverts</p>
        </template>
    </title-block>
    <div class="my-10 px-3">
        <form @submit.prevent="form.post(route('advertisement.store'))">
            <div class="grid">
                <label for="source-name" class="read-label">Advert Title:</label>
                <input type="text" class="read-input" id="source-name" placeholder="Enter advert title"
                       required v-model="form.title"/>
                <div v-if="form.errors.title" class="read-error">
                    <span>{{ form.errors.title }}</span>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-5 gap-2">
                <div>
                    <label for="source-name" class="read-label">Expiry Date:</label>
                    <input type="date" class="read-input" id="source-name"
                           required v-model="form.expiry"/>
                    <div v-if="form.errors.expiry" class="read-error">
                        <span>{{ form.errors.expiry}}</span>
                    </div>
                </div>

                <div>
                    <div>
                        <label class="read-label">Select Status:</label>
                        <select required class="read-input" v-model="form.status">
                            <option selected value="">Select Status</option>
                            <option value="1" >Active</option>
                            <option value="0" >Inactive</option>

                        </select>
                        <div v-if="form.errors.status" class="creative-error">
                            <span>{{ form.errors.status}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid mt-3">
                <label for="source-name" class="read-label">Advert Description:</label>
                <div>
                    <small>Provide a maximum of  60 words</small>
                </div>
                <textarea v-model="form.description" placeholder="Enter advert description" rows="5" class="read-text-input"></textarea>
                <div v-if="form.errors.description" class="read-error">
                    <span>{{ form.errors.description }}</span>
                </div>
            </div>
            <div class="grid mt-5">
                <label for="source-name" class="read-label">Advert Link:</label>
                <input type="text" class="read-input" id="source-name" placeholder="Enter the link to this advert"
                       required v-model="form.url"/>
                <div v-if="form.errors.url" class="read-error">
                    <span>{{ form.errors.url }}</span>
                </div>
            </div>
            <div class="mt-5">
                <div>
                    <label for="source-logo" class="read-label">Advert image:</label>
                </div>
                <div>
                    <span class="text-xs">Maximum file size 2MB. Allowed formats are jpeg,png,jpg, and gif</span>
                </div>
                <input type="file"  id="source-logo" class="mt-3"
                       required  @input="form.image=$event.target.files[0]" accept="image/*"/>

                <div v-if="form.errors.image" class="read-error">
                    <span>{{ form.errors.image }}</span>
                </div>
            </div>
            <div class="my-3 flex justify-end">
                <button type="submit" class="btn-primary">Save and run advert</button>
            </div>
        </form>
    </div>
</admin>
</template>

<script setup lang="ts">
import Admin from "@/views/layouts/admin.vue";
import TitleBlock from "@/views/components/title-block.vue";
import {Head, useForm} from "@inertiajs/inertia-vue3";

let form=useForm({
    title:'',
    description:'',
    status:'',
    image:'',
    url:'',
    expiry:''
})
</script>

<style scoped>

</style>
