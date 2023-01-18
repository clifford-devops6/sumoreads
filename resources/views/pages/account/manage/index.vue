<template>
    <Head><title>Manage Account</title></Head>
<reader>
   <template #sidebar>
     <manage-account-menu></manage-account-menu>
   </template>
    <div class="my-10 px-5">
        <div class="my-10">
            <h1 class="text-lg font-bold">Members and Groups</h1>
        </div>
        <div class="flex justify-between">
            <div>
                <p class="font-bold text-primary-100">
                    <span class="mr-2"><i class="fa-sharp fa-solid fa-circle-info"></i></span>
                    {{account.data.administrator.slot-account.data.users.length}} of {{account.data.administrator.slot}} Invites available from your current plan</p>
            </div>
            <div class="flex justify-between gap-4">
                <div>
                    <button class="font-bold text-gray-500"><span class="mr-2"><i class="fa-solid fa-plus"></i></span>Add Members</button>
                </div>
                <div>
                    <button class="font-bold text-gray-500"><span class="mr-2"><i class="fa-solid fa-plus"></i></span>Add Group</button>
                </div>
            </div>
        </div>

        <!--account accordions-->
        <div class="my-10">
           <div class="my-3">
               <accordion>
                   <template #title>
                       <h6 class="font-semibold"> Members (6)</h6>

                   </template>
                   <div>
                       <p>Members here</p>
                   </div>
               </accordion>
           </div>
            <div class="my-3">
                <accordion>
                    <template #title>
                        <h6 class="font-semibold"> Invitations (6)</h6>

                    </template>
                    <div>
                        <p>2 Invitations</p>
                    </div>
                </accordion>
            </div>
        </div>

        <div class="my-10">
            <div class="my-3">
                <h6 class="font-bold">Groups (3)</h6>
            </div>
            <table class="table-auto w-full mt-3 border overflow-hidden">
                <thead>
                <tr class="bg-gray-50 h-10 text-teal-900 font-bold">
                    <th class="text-start p-4">Group Name</th>
                    <th class="text-start p-4">Members</th>
                    <th class="text-start p-4">Streams</th>
                    <th class="text-start p-4">Categories</th>
                    <th class="text-start p-4">Action</th>


                </tr>
                </thead>
                <tbody>
                <tr class="border">
                    <td class="py-3 px-4"></td>
                    <td class="py-3 px-4"></td>
                    <td class="py-3 px-4"></td>
                    <td class="py-3 px-4"></td>
                    <td class="py-3 px-4">
                    </td>

                </tr>


                </tbody>

            </table>
        </div>

    </div>
</reader>
</template>

<script setup lang="ts">

import Reader from "@/views/layouts/reader.vue";
import {Head} from "@inertiajs/inertia-vue3";
import ManageAccountMenu from "@/views/components/sidebar/manage-account-menu.vue";
import Accordion from "@/views/components/accordion.vue";

defineProps({
    account:Object
})
</script>

<style scoped>

</style>
