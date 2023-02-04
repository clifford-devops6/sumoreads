<template>
<admin>
   <Head><title>{{user.name}}</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">System users</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 mr-2 text-teal-900"><i class="fas fa-info-circle"></i></span>System users should be
                created by the Super admin user</p>
        </template>
    </title-block>
    <div class="my-10 px-3">
        <h5 class="font-semibold text-lg capitalize">{{user.name}} {{user.last_name}}</h5>
        <p><span class="text-primary-100">Email:</span> {{user.email}}</p>
        <p><span class="text-primary-100">Roles:</span> <span class="ml-2" v-for="role in user.roles">{{role.name}},</span></p>
        <p><span class="text-primary-100">Permissions:</span> <span class="ml-2" v-for="permission in user.permissions">{{permission.name}},</span></p>
    <div>
        <Link :href="route('users.edit',user.id)" class="text-sm font-bold p-2  text-start"  as="button">
            <span class="mr-2"><i class="fa-light fa-pen"></i></span>Edit User
        </Link>
        <Link :href="route('users.destroy',user.id)" class="text-red-700 text-sm font-bold p-2 text-start"  method="delete" as="button">
            <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete User
        </Link>
    </div>

    </div>
</admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head,Link} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue";
defineProps({
    user:Object
})
</script>

<style scoped>

</style>
