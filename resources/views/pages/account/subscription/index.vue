<template>
    <Head><title>Subscription</title></Head>

<reader>
<template #sidebar>
    <subscription-menu :page="route('subscription.index')">

    </subscription-menu>
</template>
    <div class="my-10 w-full">
        <h1 class="font-bold text-lg">Subscription</h1>
        <div class="border rounded-lg p-3 my-5">
         <h6 class="font-semibold">{{user.data.name}} {{user.data.last_name}}</h6>
            <div class="flex my-3 gap-3">
                <p><span class="text-primary-100">Account Type: </span>{{account.type.name}}</p>
                <p v-if="auth.role==='Enterprise'"><span class="text-primary-100">Groups: </span>{{account.groups_count}}</p>
                <p v-if="auth.role==='Enterprise'"><span class="text-primary-100">Member(s): </span>{{account.users_count}}</p>
                <p v-if="auth.role==='Enterprise'">{{account.administrator.slot-account.users_count}} of {{account.administrator.slot}} slots Available from current plan</p>
                <p v-if="auth.role==='Enterprise'"><span class="text-primary-100">Invitations: </span>{{account.invitations_count}}</p>
            </div>
            <div class="my-3">
               <p>Your next bill is for <span class="text-primary-100 font-semibold">USD {{account.type.price*account.administrator.slot}}</span> on {{new Date(token).toDateString()}}</p>
            </div>
            <div class="py-5 flex gap-2">
                <button class="btn-primary" @click="payModal=true">
                    Pay Now
                </button>
                <button v-if="auth.role==='Enterprise'" class="btn-primary" @click="slotModal=true">
                   Add more slots
                </button>
            </div>
        </div>
    </div>
    <!--- pay now and extend slots modal-->
    <div>
        <pay-now :show="payModal" @close="payModal=false" :account="account" :expiry="token">

        </pay-now>
        <!-- add number of available slots--->
        <div v-if="auth.role==='Enterprise'">
            <add-slot :show="slotModal" @close="slotModal=false" :account="account"></add-slot>
        </div>

    </div>
</reader>
</template>

<script setup lang="ts">

import Reader from "@/views/layouts/reader.vue";
import {Head, usePage} from "@inertiajs/inertia-vue3";
import SubscriptionMenu from "@/views/components/sidebar/subscription-menu.vue";
import PayNow from "@/views/components/enterprise/pay-now.vue";
import {ref} from "vue";
import AddSlot from "@/views/components/enterprise/add-slot.vue";
defineProps({
    user:Object,
    account:Object,
    token:String
})
const page=usePage()
const auth = page.props.value.auth
const payModal= ref(false)
const slotModal= ref(false)
</script>

<style scoped>

</style>
