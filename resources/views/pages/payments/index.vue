<template layout="auth">
    <Head><title>Process Payment</title></Head>
    <div class="flex place-content-center h-screen">
        <div class="bg-white shadow-xl rounded-xl self-center md:w-1/2 p-4">
            <div class="flex justify-between">
                <Link :href="route('clearBalance', balance.id)" as="button" method="patch" class="text-primary-100">
                    <span class="mr-3"><i class="fa-light fa-arrow-left-long"></i></span>Back
                </Link>
                <Link href="/" class="text-white bg-primary-100 p-1 rounded-full h-8 w-8" as="button">
            <span>
                <i class="fa-light fa-xmark"></i>
            </span>
                </Link>
            </div>
            <div class="text-center mt-5 px-8">
                <h6 class="font-bold text-xl">Please Process Payments</h6>
                <p v-if="balance.balance_type==='Conversion-Enterprise'" class="my-5 text-primary-100">Upgrade to Enterprise Account</p>
                <p v-else class="my-5 text-primary-100">Subscription for {{type.name}} Account</p>
                <hr>
            </div>
            <div class="my-16 px-8">
             <div class="flex justify-between">
                 <p>{{balance.description}}</p>
                 <p>USD {{Number(balance.amount).toFixed(2)}}</p>
             </div>
                <hr class="my-3">
                <div class="flex justify-between my-3 font-bold">
                    <p>Total Amount Payable</p>
                    <p>USD {{Number(balance.amount).toFixed(2)}}</p>
                </div>
                <div class="py-3" v-if="$page.props.status">
                    <p class="text-sm text-red-600" ><span class="ml-2 text-teal-900"><i class="fas fa-info-circle"></i></span> {{$page.props.status}}</p>
                </div>
                <div class="my-5">
                    <p> Subscription renews on <span class="text-primary-100">{{new Date(balance.expires).toDateString()}}</span></p>
                </div>
                <div class="my-8">
                    <a :href="payment.redirect_url" target="_blank" class="btn-primary" title="Pay Now">
                        Pay Now <span class="ml-8"><i class="fa-regular fa-arrow-right-long"></i></span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup lang="ts">
import {Head,Link} from "@inertiajs/inertia-vue3";
defineProps({
    type:Object,
    payment:Object,
    balance:Object
})

</script>

<style scoped>

</style>

