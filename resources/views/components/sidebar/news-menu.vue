<template>
    <div class="text-white">

        <ul class="divide-y font-semibold">
            <li>
                <Link :href="route('news.index')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                      :class="{ 'bg-white text-primary-100': page === route('news.index') }">
                    <span class="mr-2"><i class="fa-light fa-newspaper"></i></span><span>News</span> </Link>
            </li>
            <li>
                <Link :href="route('home.index')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                      :class="{ 'bg-white text-primary-100': page === route('home.index') }">
                    <span><span class="mr-2"><i class="fa-regular fa-house-chimney"></i></span>My Home</span> </Link>
            </li>

            <li>
                <Link :href="route('readlist.index')" class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full" as="button"
                      :class="{ 'bg-white text-primary-100': page === route('readlist.index') }">
                    <span><span class="mr-2"><i class="fa-light fa-bookmark"></i></span>My Read List</span> </Link>
            </li>

            <li v-show="accounType==='Corporate'">
                <group-dropdown>
                </group-dropdown>
            </li>
            <li v-show="accounType==='Corporate'">
                <enterprise-categories></enterprise-categories>
            </li>
            <li>
                <personal-stream></personal-stream>
            </li>
            <li>
                <personal-categories></personal-categories>
            </li>

        </ul>

    </div>
</template>

<script setup lang="ts">
import {Link, usePage} from "@inertiajs/inertia-vue3";
import GroupDropdown from "@/views/components/group-dropdown.vue";
import EnterpriseCategories from "@/views/components/enterprise-categories.vue";
import PersonalStream from "@/views/components/personal-stream.vue";
import PersonalCategories from "@/views/components/personal-categories.vue";
defineProps({
    page:String
})
const type=usePage()
const accounType=type.props.value.account_type
</script>

<style scoped>

</style>

