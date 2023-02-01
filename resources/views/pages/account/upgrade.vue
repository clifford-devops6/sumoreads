<template layout="main">
<Head><title>Upgrade you account</title></Head>
    <div class="flex place-content-center h-screen">
        <div class="bg-white shadow-xl rounded-xl self-center md:w-1/2 p-4">
            <div class="flex justify-between">
                <Link href="/" class="text-primary-100">
                    <span class="mr-3"><i class="fa-light fa-arrow-left-long"></i></span>Back
                </Link>
                <Link href="/" class="text-white bg-primary-100 p-1 rounded-full h-8 w-8" as="button">
            <span>
                <i class="fa-light fa-xmark"></i>
            </span>
                </Link>
            </div>
            <div class="text-center font-bold text-xl mt-5">Upgrade to {{type.name}} Package</div>
            <div class="mt-10 px-14 overflow-y-auto custom-scrolling h-[50vh]">
                <div class="px-10">
                    <div class="border rounded-lg p-3 text-center shadow-md py-10">
                        <p> A minimum of {{min_slots}} members</p>
                        <p class="mt-3">(1 Primary user plus {{1-min_slots}} {{type.name}} users)</p>
                        <div class="flex justify-end mt-4">
                            <p class="font-bold"><span class="text-primary-100 text-lg">{{type.price*min_slots}}</span> per month</p>
                        </div>
                    </div>
                    <div class="mt-10 text-center">
                        <h6 class="text-lg">Do you have more than {{min_slots}} members?</h6>
                        <div class="mt-3">
                            <form @submit.prevent="form.post(route('initiate.upgrade',account.data.id))" id="package-form">
                                <input type="number" v-model="form.members" :min="min_slots" class="rounded-full">
                                <div v-if="form.errors.members" class="read-error">
                                    <span>{{ form.errors.members }}</span>
                                </div>
                            </form>
                            <p class="my-5">Extra members will be charged at a rate of USD {{type.price}} each per month</p>
                            <p class="my-5 text-primary-100">Subscription expires on {{paymentDate(1)}}</p>
                        </div>
                    </div>
                    <div class="my-10">
                        <hr>
                        <div class="my-5 flex justify-between">
                            <h6 class="font-bold">Total</h6>
                            <h6 class="font-bold text-primary-100">USD {{form.members*type.price}}</h6>
                        </div>
                        <div class="grid my-10">
                            <button form="package-form" type="submit" class="bg-primary-100 rounded-lg my-3 text-white font-semibold py-3">
                                Proceed to upgrade package
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {Head, Link, useForm} from "@inertiajs/inertia-vue3";

let props=defineProps({
    account:Object,
    min_slots:Number,
    type:Object
})

let form=useForm({
    members:props.min_slots,
    price:props.type.price
})




function paymentDate (months) {
    const date = new Date()
    date.setMonth(date.getMonth() + months)

    return date.toDateString()
}
</script>

<style scoped>

</style>
