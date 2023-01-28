<template>
    <Head><title>Personalize Feeds</title></Head>
<reader>
    <template #sidebar>
        <personalize-menu @categoriesFilter="switchCategory" @StreamsFilter="switchStream"></personalize-menu>
    </template>
    <div class="my-10">
        <div v-if="showStreams">
            <div class="flex justify-between px-3">
                <div>
                    <h1 class="font-bold text-xl">Streams</h1>
                </div>
                <div class="flex gap-4">
                    <button @click="enterpriseModal=true" v-if="auth.role==='Enterprise'"  class="font-bold text-primary-100"><span class="mr-2"><i class="fal fa-pen"></i></span>Customize enterprise</button>
                    <button @click="personalSource=true" class="font-bold text-primary-100"><span class="mr-2"><i class="fal fa-pen"></i></span>Customize Personal</button>
                </div>
            </div>
            <div class="my-8">
                <div class="block">
                    <div v-for="source in account.data.sources"
                         class="p-2 m-1 inline-block border rounded-lg text-center bg-white">
                        <div class="grid justify-center">
                            <img :src="source.logo" :alt="source.name" class="h-8 place-self-center">
                            <h6 class="">{{ source.name }}</h6>
                            <div>
                                <span class="text-[9px] bg-primary-300 text-white p-1 rounded">Enterprise</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block">

                    <div v-for="source in user.data.sources"
                         class="p-2 m-1 inline-block border rounded-lg text-center bg-white">
                        <div class="grid justify-center">
                            <img :src="source.logo" :alt="source.name" class="h-8 place-self-center">
                            <h6 >{{ source.name }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16" v-if="showCategories">
            <div class="flex justify-between px-3">
                <div>
                    <h1 class="font-bold text-xl">Categories</h1>
                </div>
                <div class="flex gap-4">
                    <button @click="enterpriseCategory=true" v-if="auth.role==='Enterprise'"  class="font-bold text-primary-100"><span class="mr-2"><i class="fal fa-pen"></i></span>Customize enterprise</button>
                    <button @click="personalCategory=true" class="font-bold text-primary-100"><span class="mr-2"><i class="fal fa-pen"></i></span>Customize Personal</button>
                </div>
            </div>
            <div class="my-8">
                <div class="block">
                    <div v-for="category in account.data.categories"
                         class="p-2 m-1 inline-block border rounded-lg text-center bg-white">
                        <div class="grid justify-center">

                            <h6><span class="mr-2" v-html="category.icon"></span>{{ category.name }}</h6>
                            <div>
                                <span class="text-[9px] bg-primary-300 text-white p-1 rounded">Enterprise</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block">

                    <div v-for="category in user.data.categories"
                         class="p-2 m-1 inline-block border rounded-lg text-center bg-white">
                        <div class="grid justify-center">
                            <h6><span class="mr-2" v-html="category.icon"></span>{{ category.name }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--modals-->
    <div>
        <enterprise-sources :show="enterpriseModal" @close="enterpriseModal=false" :mySources="account.data.sources"></enterprise-sources>
        <personal-source :show="personalSource" @close="personalSource=false" :my-sources="user.data.sources"></personal-source>
        <enterprise-category :show="enterpriseCategory" @close="enterpriseCategory=false" :my-categories="account.data.categories"></enterprise-category>
        <personalize-category :show="personalCategory" @close="personalCategory=false" :my-categories="user.data.categories"></personalize-category>
    </div>
</reader>
</template>

<script setup lang="ts">

import Reader from "@/views/layouts/reader.vue";
import {Head, usePage} from "@inertiajs/inertia-vue3";
import PersonalizeMenu from "@/views/components/sidebar/personalize-menu.vue";
import EnterpriseSources from "@/views/components/enterprise/enterprise-sources.vue";
import {ref} from "vue";
import PersonalSource from "@/views/components/enterprise/personal-source.vue";
import EnterpriseCategory from "@/views/components/enterprise/enterprise-category.vue";
import PersonalizeCategory from "@/views/components/enterprise/personalize-category.vue";
defineProps({
    account:Object,
    user:Object
})
const page=usePage()
const auth=page.props.value.auth
const enterpriseModal=ref(false)
const personalSource=ref(false)
const personalCategory=ref(false)
const enterpriseCategory=ref(false)

//streams and categories filter

const showStreams=ref(true)
const showCategories=ref(true)

const switchCategory=()=>{
    showCategories.value=true;
    showStreams.value=false
}
const switchStream=()=>{
    showStreams.value=true
    showCategories.value=false;

}
</script>

<style scoped>

</style>
