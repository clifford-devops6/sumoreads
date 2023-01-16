<template>
<admin>
    <Head><title>{{contact.subject}}</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">{{contact.subject}}</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
                Message from {{contact.name}}</p>
        </template>
    </title-block>
    <div class="my-10 px-3">
     <h6 class="font-bold text-lg"> From {{contact.name}}</h6>
        <p><span class="text-primary-100">Subject:</span> {{ contact.subject}}</p>
        <p><span class="text-primary-100">Date:</span> {{ new Date(contact.created_at).toDateString() }}</p>
        <p><span class="text-primary-100">Email:</span> {{ contact.email }}</p>
        <p class="mt-2">{{contact.message}}</p>
        <Link :href="route('messages.destroy',contact.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
            <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete Message
        </Link>
    </div>
</admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue"
import {Link} from "@inertiajs/inertia-vue3";

defineProps({
   contact:Object
})
</script>

<style scoped>

</style>
