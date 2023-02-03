<template>
<admin>
<Head><title>Users</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">System System users</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 mr-2 text-teal-900"><i class="fas fa-info-circle"></i></span>System users should be
            created by the Super admin user</p>
        </template>
    </title-block>
    <template #sidebar>
        <Sidelink :link="route('users.create')"><span class="mr-2"><i class="fa-regular fa-plus"></i></span>Create users</Sidelink>
    </template>
</admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue";
import Sidelink from "@/views/components/sidelink.vue";

</script>
