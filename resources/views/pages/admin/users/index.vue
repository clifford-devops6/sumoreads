<template>
<admin>
<Head><title>Users</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">System users</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 mr-2 text-teal-900"><i class="fas fa-info-circle"></i></span>System users should be
            created by the Super admin user</p>
        </template>
    </title-block>
    <template #sidebar>
        <Sidelink :link="route('users.create')"><span class="mr-2"><i class="fa-regular fa-plus"></i></span>Create users</Sidelink>
    </template>

    <div class="my-10">
        <table class="table-auto w-full mt-3 border-t">
            <thead>
            <tr class="bg-gray-50 h-10 text-teal-900 font-bold text-sm">
                <th class="text-start py-3 px-4">Id</th>
                <th class="text-start py-3 px-4">Name</th>
                <th class="text-start py-3 px-4">Last Name</th>
                <th class="text-start py-3 px-4">Email</th>
                <th  class="py-3 px-4 text-start">Action</th>


            </tr>
            </thead>
            <tbody>
            <tr class="border-b"  v-for="user in users.data" :key="user.id">
                <td class="py-3 px-4">{{ user.id }}</td>
                <td class="py-3 px-4">{{ user.name }}</td>
                <td class="py-3 px-4">{{ user.last_name }}</td>
                <td class="py-3 px-4">{{ user.email }}</td>
                <td  class="py-3 px-4">
                    <dropdown placement="bottom">
                        <template #trigger="{ toggle }">
                            <Button @click="toggle" >
                                Action <span class="self-center"><i class="far fa-ellipsis-v-alt"></i></span>
                            </Button>
                        </template>
                        <div class="shadow w-36">
                            <ul class="divide-y">
                                <li class="hover:bg-gray-100 ">
                                    <Link :href="route('users.show',user.id)" class="text-sm font-bold p-2 w-full h-full text-start"  as="button">
                                        <span class="mr-2"><i class="fa-light fa-bookmark"></i></span>Details
                                    </Link>
                                </li>
                                <li class="hover:bg-gray-100 ">
                                    <Link :href="route('users.edit',user.id)" class="text-sm font-bold p-2 w-full h-full text-start"  as="button">
                                        <span class="mr-2"><i class="fa-light fa-pen"></i></span>Edit
                                    </Link>
                                </li>
                                <li class="hover:bg-gray-100 ">
                                    <Link :href="route('users.destroy',user.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
                                        <span class="mr-2"><i class="far fa-trash-alt"></i></span>Delete
                                    </Link>
                                </li>


                            </ul>
                        </div>
                    </dropdown>

                </td>

            </tr>


            </tbody>

        </table>

        <direct-pagination :data="users"></direct-pagination>
    </div>
</admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import {Head,Link} from "@inertiajs/inertia-vue3";
import TitleBlock from "@/views/components/title-block.vue";
import Sidelink from "@/views/components/sidelink.vue";
import {Dropdown} from "flowbite-vue";
import DirectPagination from "@/views/components/direct-pagination.vue";
defineProps({
    users:Object
})
</script>
