<template>
<admin>
    <Head><title>Messages</title></Head>
    <title-block>
        <h6 class="font-bold text-sm">Messages</h6>
        <template #info>
            <p class="text-sm"><span class="ml-2 text-primary-100"><i class="fas fa-info-circle"></i></span>
               Messages submitted via contact form</p>
        </template>
    </title-block>
    <div class="my-10 px-3">
        <table class="table-auto w-full mt-3 border-t">
            <thead>
            <tr class="bg-gray-50 h-10 text-teal-900 font-bold text-sm">
                <th class="text-start py-3 px-4">Id</th>
                <th class="text-start py-3 px-4">Date</th>
                <th class="text-start py-3 px-4">Sender</th>
                <th class="text-start py-3 px-4">Email</th>
                <th class="text-start py-3 px-4">Subject</th>
                <th class="text-start py-3 px-4">Status</th>
                <th class="py-3 px-4 text-start">Action</th>


            </tr>
            </thead>
            <tbody>
            <tr class="border-b"  v-for="contact in contacts.data" :key="contact.id">
                <td class="py-3 px-4">{{ contact.id }}</td>
                <td class="py-3 px-4">{{ new Date(contact.created_at).toDateString() }}</td>
                <td class="py-3 px-4">{{ contact.name }} {{ contact.last_name }}</td>
                <td class="py-3 px-4">{{ contact.email }}</td>
                <td class="py-3 px-4">{{ contact.subject.name}}</td>
                <td class="py-3 px-4">
                    <span v-if="contact.status">Read</span>
                    <span v-else class="text-green-900">Unread</span>
                </td>
                <td class="py-3 px-4">
                    <dropdown placement="bottom">
                        <template #trigger="{ toggle }">
                            <button @click="toggle" >
                                Action <span class="self-center"><i class="far fa-ellipsis-v-alt"></i></span>
                            </button>
                        </template>
                        <div class="shadow w-36">
                            <ul class="divide-y">
                                <li class="hover:bg-gray-100 ">
                                    <Link :href="route('messages.show',contact.id)" class="text-sm font-bold p-2 w-full h-full text-start"  as="button">
                                        <span class="mr-2"><i class="fa-light fa-bookmark"></i></span>View Message
                                    </Link>
                                </li>
                                <li class="hover:bg-gray-100 ">
                                    <Link :href="route('messages.destroy',contact.id)" class="text-red-700 text-sm font-bold p-2 w-full h-full text-start"  method="delete" as="button">
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
        <div>
            <direct-pagination :data="contacts"></direct-pagination>
        </div>
    </div>
</admin>
</template>

<script setup lang="ts">

import Admin from "@/views/layouts/admin.vue";
import TitleBlock from "@/views/components/title-block.vue";
import {Head, Link} from "@inertiajs/inertia-vue3";
import {Dropdown} from "flowbite-vue";
import DirectPagination from "@/views/components/direct-pagination.vue";
defineProps({
    contacts:Object
})

</script>

<style scoped>

</style>
