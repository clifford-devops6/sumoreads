<template>
    <div class="text-white">
        <div class="py-3 border-b border-b-white px-2">
            <h6 class="font-bold text-xl">Manage Account</h6>
        </div>
        <ul class="divide-y font-semibold">
            <li>
                <button @click="$emit('sendInvitation')"  class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full"
                     ><span class="mr-2"><i class="fa-solid fa-plus"></i></span>Add Members</button>
            </li>
            <li>
                <button @click="$emit('createGroup')"  class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full"
                ><span class="mr-2"><i class="fa-solid fa-plus"></i></span>Add Group</button>
            </li>

        </ul>

    </div>
</template>

<script setup lang="ts">
import {Link} from "@inertiajs/inertia-vue3";

</script>

<style scoped>

</style>
