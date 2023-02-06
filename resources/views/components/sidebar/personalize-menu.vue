<template>
    <div class="text-white">
        <div class="py-4 border-b border-b-white px-2">
            <h6 class="font-bold text-xl">Personalize Feeds</h6>
        </div>
        <ul class="divide-y font-semibold">
            <li>
                <button @click="$emit('streamsFilter')"  class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full"
                ><span class="mr-2"><i class="fal fa-pen"></i></span>Streams</button>
            </li>
            <li>
                <button @click="$emit('categoriesFilter')"  class="py-4 px-3 text-start hover:bg-white hover:text-primary-100 w-full h-full"
                ><span class="mr-2"><i class="fal fa-pen"></i></span>Categories</button>
            </li>

        </ul>

    </div>
</template>

<script setup lang="ts">
import {defineEmits} from "vue";

defineEmits(['streamsFilter','categoriesFilter'])

</script>

<style scoped>

</style>
