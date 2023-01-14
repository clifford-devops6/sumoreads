<template>
    <admin>
        <Head><title>Add a News Source</title></Head>
        <title-block>
            <h6 class="font-bold text-sm">News Sources</h6>
            <template #info>
                <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                    Add a source</p>
            </template>
        </title-block>

        <div class="my-10 px-3">
            <div class="my-5">
                <img :src="source.logo" :alt="source.name">
            </div>
            <form @submit.prevent="form.post(route('sources.update',source.id))">
                <div class="grid grid-cols-2 mt-3 gap-2">
                    <div>
                        <label for="source-name" class="read-label">Source Name:</label>
                        <input type="text" class="read-input" id="source-name" placeholder="E.g. cnn"
                               required v-model="form.name"/>
                        <div v-if="form.errors.name" class="read-error">
                            <span>{{ form.errors.name }}</span>
                        </div>
                    </div>
                    <div>
                        <label for="domain-name" class="read-label">Source Domain:</label>
                        <input type="text" class="read-input" id="domain-name" placeholder="E.g. cnn.com"
                               required v-model="form.domain"/>
                        <span class="text-xs">The domain must be inputted according to the example cnn.com</span>
                        <div v-if="form.errors.domain" class="read-error">
                            <span>{{ form.errors.domain }}</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 mt-3 gap-2">
                    <div>
                        <label class="read-label">Select Status:</label>
                        <select required class="read-input" v-model="form.status_id">
                            <option selected value="">Select Status</option>
                            <option :value="status.id" v-for="status in statuses" :key="status.id">{{status.name}}</option>

                        </select>
                        <div v-if="form.errors.status_id" class="creative-error">
                            <span>{{ form.errors.status_id }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="read-label">Select Category:</label>
                        <select required class="read-input" v-model="form.category_id">
                            <option selected value="">Select Category</option>
                            <option :value="category.id" v-for="category in categories" :key="category.id">{{category.name}}</option>

                        </select>
                        <div v-if="form.errors.category_id" class="creative-error">
                            <span>{{ form.errors.category_id }}</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 mt-3 gap-2">
                    <div>
                        <label class="read-label">Select Country:</label>
                        <select required class="read-input" v-model="form.country_id">
                            <option selected value="">Select Country</option>
                            <option :value="country.id" v-for="country in countries" :key="country.id">{{country.name}}</option>

                        </select>
                        <div v-if="form.errors.country_id" class="creative-error">
                            <span>{{ form.errors.country_id }}</span>
                        </div>
                    </div>
                    <div>
                        <div>
                            <label for="source-logo" class="read-label">Source Logo:</label>
                        </div>
                        <div>
                            <span class="text-xs">Maximum file size 2MB. Allowed formats are jpeg,png,jpg, and gif</span>
                        </div>
                        <input type="file"  id="source-logo" class="mt-3"
                                @input="form.logo=$event.target.files[0]" accept="image/*"/>

                        <div v-if="form.errors.logo" class="read-error">
                            <span>{{ form.errors.logo }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-5">
                    <button type="submit" class="btn-primary">Save Source</button>
                </div>
            </form>
        </div>
    </admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head,useForm} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue";
let props=defineProps({
    categories:Object,
    statuses:Object,
    countries:Object,
    source:Object
})
let form=useForm({
    name:props.source.name,
    domain:props.source.domain,
    category_id:props.source.category_id,
    country_id:props.source.country_id,
    logo:'',
    status_id:props.source.status_id,
    _method:'PATCH'
})
</script>

<style scoped>

</style>
