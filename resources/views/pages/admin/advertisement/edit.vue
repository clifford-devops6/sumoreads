<template>
    <admin>
        <Head><title>Update adverts</title></Head>
        <title-block>
            <h6 class="font-bold text-sm">Update Advertisement</h6>
            <template #info>
                <p class="text-sm"><span class="ml-2 mr-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                    {{advert.title}}</p>
            </template>
        </title-block>
        <div class="my-10 px-3">
            <form @submit.prevent="form.post(route('advertisement.update',advert.id))">
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
                        <label for="source-name" class="read-label">Start Date:</label>
                        <input type="date" class="read-input" id="source-name"
                               required v-model="form.start"/>
                        <div v-if="form.errors.start" class="read-error">
                            <span>{{ form.errors.start}}</span>
                        </div>
                    </div>
                    <div>
                        <label for="source-name" class="read-label">End Date:</label>
                        <input type="date" class="read-input" id="source-name"
                               required v-model="form.expiry"/>
                        <div v-if="form.errors.expiry" class="read-error">
                            <span>{{ form.errors.expiry}}</span>
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
                    <span class="text-xs">Maximum file size 2MB. Allowed formats are jpeg,png,jpg, and gif.
                    <span class="font-bold">Allowed dimensions 600px by 400px</span></span>
                    </div>
                    <input type="file"  id="source-logo" class="mt-3"
                            @input="form.image=$event.target.files[0]" accept="image/*"/>

                    <div v-if="form.errors.image" class="read-error">
                        <span>{{ form.errors.image }}</span>
                    </div>
                </div>
                <div class="my-3">
                    <hr>
                </div>
                <div class="grid grid-cols-2 mt-5 gap-2">
                    <div class="col-span-1">
                        <label for="source-name" class="read-label">Pricing:</label>
                        <div>
                            <small>Advert pricing (USD). The total amount charged for running the advert</small>
                        </div>
                        <input type="text" class="read-input" id="source-name" placeholder="Enter price in USD"
                               required v-model="form.price"/>
                        <div v-if="form.errors.price" class="read-error">
                            <span>{{ form.errors.price }}</span>
                        </div>
                    </div>
                </div>
                <div class="grid mt-5">
                    <label for="source-name" class="read-label">Remarks(optional):</label>
                    <textarea v-model="form.remarks" placeholder="Enter your remarks (optional)" rows="5" class="read-text-input"></textarea>
                    <div v-if="form.errors.remarks" class="read-error">
                        <span>{{ form.errors.remarks }}</span>
                    </div>
                </div>
                <div class="my-3 flex justify-end">
                    <button type="submit" class="btn-primary">Save and run advert</button>
                </div>
            </form>
        </div>

        <template #sidebar>
            <div class="my-3">
                <h6>Advert Image</h6>
                <img :src="advert.image" :alt="advert.title">
            </div>
        </template>
    </admin>
</template>

<script setup lang="ts">
import Admin from "@/views/layouts/admin.vue";
import TitleBlock from "@/views/components/title-block.vue";
import {Head, useForm} from "@inertiajs/inertia-vue3";
let props=defineProps({
    advert:Object
})

const advert=props.advert.data
let form=useForm({
    title:advert.title,
    description:advert.description,
    image:'',
    url:advert.url,
    expiry:advert.expiry,
    start:advert.start,
    remarks:advert.remarks,
    price:advert.price,
    _method:'PATCH'
})
</script>

<style scoped>

</style>
