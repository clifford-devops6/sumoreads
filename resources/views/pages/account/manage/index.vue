<template>
    <Head><title>Manage Account</title></Head>
<reader>
   <template #sidebar>
     <manage-account-menu @sendInvitation="addMemberModal=true" @createGroup="addGroupModal=true"></manage-account-menu>
   </template>
    <div class="my-10 px-5">
        <div class="my-10">
            <h1 class="text-lg font-bold">Members and Groups</h1>
        </div>
        <div class="flex justify-between">
            <div>
                <p class="font-bold text-primary-100">
                    <span class="mr-2"><i class="fa-sharp fa-solid fa-circle-info"></i></span>
                    {{account.data.administrator.slot- users.length}} of {{account.data.administrator.slot}} Invites available from your current plan

                </p>
            </div>
            <div class="flex justify-between gap-2">
                <div>
                    <button @click="slotModal=true" class="btn-primary btn-small"><span class="mr-2"><i class="fa-solid fa-plus"></i></span>Add Members</button>
                </div>
                <div>
                    <button @click="addMemberModal=true" class="btn-primary btn-small"><span class="mr-2"><i class="fa-solid fa-plus"></i></span>Invite</button>
                </div>
                <div>
                    <button @click="addGroupModal=true" class="btn-primary btn-small"><span class="mr-2"><i class="fa-solid fa-plus"></i></span>New Group</button>
                </div>
            </div>
        </div>

        <!--account accordions-->
        <div class="my-10">
           <div class="my-3">
               <!--members-->
               <accordion>
                   <template #title>
                       <h6 class="font-semibold"> Members ({{users.length+account.data.invitations.length}})</h6>

                   </template>
                   <div>
                       <div class="divide-y space-y-2">
                           <div class="flex justify-between py-2 " v-for="user in account.data.users" :key="user.id">
                               <div>
                                   <p class="capitalize flex gap-1"><span>{{user.name}}</span><span>{{user.last_name}}</span>
                                   <span v-if="user.id===account.data.administrator.user_id" class="text-primary-100">(Primary user)</span></p>
                               </div>
                               <div>
                                   <button @click="cancelSubscription(user.id)" v-if="user.id!==account.data.administrator.user_id" class="text-gray-800 font-bold">Cancel Subscription</button>
                               </div>
                           </div>
                           <div class=" text-gray-500 flex justify-between py-2 " v-for="invite in account.data.invitations" :key="invite.id">
                               <div>
                                   <p class="flex gap-3">{{invite.email}} (Pending Acceptance)</p>
                               </div>
                               <div>
                                   <button @click="cancelInvitation(invite.id)"  class="text-gray-800 font-bold">Cancel Subscription</button>
                               </div>
                           </div>
                       </div>

                   </div>
               </accordion>
           </div>

        </div>

        <!--groups-->
        <div class="my-10">
            <div class="my-3">
                <h6 class="font-bold">Groups ({{groups.data.length}})</h6>
            </div>
            <div class="border rounded-lg overflow-hidden">
                <table class="table-auto w-full">
                    <thead>
                    <tr class="bg-gray-100  text-teal-900 font-bold border-b">
                        <th class="text-start p-4">Group Name</th>
                        <th class="text-start p-4">Members</th>
                        <th class="text-start p-4">Streams</th>
                        <th class="text-start p-4">Categories</th>
                        <th class="text-start p-4">Action</th>


                    </tr>
                    </thead>
                    <tbody class="divide-y">
                    <tr  v-for="group in groups.data" :key="group.id">
                        <td class="py-3 px-4">
                            <button @click="updateGroupModal=true" class="text-primary-100 font-bold">{{group.name}}<span class="ml-2"><i class="fa-light fa-pen"></i></span></button>
                            <update-group  :show="updateGroupModal" @close="updateGroupModal=false" :group="group"></update-group>
                        </td>
                        <td class="py-3 px-4">
                            <button class="hover:text-primary-100" @click="groupUserModal=true">
                                <span v-if="group.users.length">{{group.users.length}}</span>
                                <span> Member(s) <span class="ml-2"><i class="fa-light fa-pen"></i></span></span>
                            </button>
                            <group-users :key="group.id"  :show="groupUserModal" @close="groupUserModal=false"  :group="group" :admin="account.data.administrator.user_id"></group-users><!--add members to a group-->
                        </td>
                        <td class="py-3 px-4">
                            <button class="hover:text-primary-100" @click="groupSourceModal=true">
                                <span v-if="group.sources.length">{{group.sources.length}}</span>
                                <span> Streams(s) <span class="ml-2"><i class="fa-light fa-pen"></i></span></span>
                            </button>
                            <group-source :key="group.id" :show="groupSourceModal" @close="groupSourceModal=false" :group="group"></group-source>
                        </td>
                        <td class="py-3 px-4">
                            <button class="hover:text-primary-100" @click="groupCategoryModal=true">
                                <span v-if="group.categories.length">{{group.categories.length}}</span>
                                <span> Categories<span class="ml-2"><i class="fa-light fa-pen"></i></span></span>
                            </button>
                            <group-category :key="group.id" :show="groupCategoryModal" @close="groupCategoryModal=false" :group="group"></group-category>
                        </td>
                        <td class="py-3 px-4">
                            <Link :href="route('group.delete',group.id)" class="text-red-800" as="button" method="delete">
                                Delete <span><i class="fas fa-trash-alt"></i></span>
                            </Link>
                        </td>

                    </tr>


                    </tbody>

                </table>
            </div>
        </div>

    </div>
    <!-- Modals-->
    <div>
        <add-member :show="addMemberModal" @close="addMemberModal=false" :account="account.data"></add-member><!--add member-->
        <add-group :show="addGroupModal" @close="addGroupModal=false" :account="account.data"></add-group><!--create group-->
        <add-slot :show="slotModal" @close="slotModal=false" :account="account.data"></add-slot>

    </div>

    <!--sweet alerts-->

</reader>
</template>

<script setup lang="ts">

import Reader from "@/views/layouts/reader.vue";
import {Head, Link} from "@inertiajs/inertia-vue3";
import ManageAccountMenu from "@/views/components/sidebar/manage-account-menu.vue";
import Accordion from "@/views/components/accordion.vue";
import AddMember from "@/views/components/enterprise/add-member.vue";
import {ref} from "vue";
import swal from "sweetalert";
import {Inertia} from "@inertiajs/inertia";
import AddGroup from "@/views/components/enterprise/add-group.vue";
import UpdateGroup from "@/views/components/enterprise/update-group.vue";
import GroupUsers from "@/views/components/enterprise/group-users.vue";
import GroupSource from "@/views/components/enterprise/group-source.vue";
import GroupCategory from "@/views/components/enterprise/group-category.vue";
import AddSlot from "@/views/components/enterprise/add-slot.vue";

let props=defineProps({
    account:Object,
    groups:Object
})
const users=props.account.data.users
const addMemberModal=ref(false)
const slotModal= ref(false)
const cancelSubscription=(user)=>{
    swal({
        title: "Are you sure you?",
        text: "Please not that the user will no longer be associated with this account",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((result) => {
            if (result){
                removeUser(user);
            }

        });
}

function removeUser(user:Number){
    Inertia.patch(route('remove.user',user))
}

//Cancel invite
const cancelInvitation=(invite:Number)=>{
    swal({
        title: "Are you sure you?",
        text: "Please not that the user will no longer be associated with this account",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((result) => {
            console.log(result)
            if (result){
                deleteInvite(invite);
            }

        });
}

function deleteInvite(invite:Number){
    Inertia.delete(route('invite.delete',invite))
}
//group create
const addGroupModal=ref(false)
//update group
const updateGroupModal=ref(false)
//add members to group
const groupUserModal=ref(false)
const groupSourceModal=ref(false)
const groupCategoryModal=ref(false)


</script>

<style scoped>

</style>
