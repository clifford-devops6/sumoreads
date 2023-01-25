<template>
    <teleport to="body">
        <Transition
            enter-from-class="opacity-0 scale-125"
            enter-to-class="opacity-100 scale-100"
            enter-active-class="transition duration-300"
            leave-active-class="transition duration-200"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-125"
         >
            <div @click.self="activeSearch=false" v-if="show" class="inset-0 fixed bg-gray-900 bg-opacity-70 z-[10000] grid place-items-center p-5" >
                <div @click.self="activeSearch=false" class="bg-white lg:w-1/2  w-full rounded-xl p-3">
                    <div class="text-end">
                        <button class="bg-primary-100 rounded-full h-8 w-8" type="button" @click="$emit('closeShare')"><span
                                class="text-white text-lg"><i class="fal fa-times"></i></span></button>
                    </div>
                    <div>
                        <div class="text-center">
                            <h6 class="text-lg font-bold">Share this article</h6>
                        </div>
                        <div @click.self="activeSearch=false" class="my-5 px-3">
                            <form id="share-form" @submit.prevent="submit">
                                <div class="relative">
                                    <div>
                                        <input @focus="activeSearch=true" v-model="form.share" type="text" class="read-input" placeholder="Search for a member, group or enter their email to share..">
                                        <div v-if="form.errors.share" class="read-error">
                                            <span>{{ form.errors.share }}</span>
                                        </div>
                                    </div>
                                    <div @mouseleave="activeSearch=false"  v-show="activeSearch" class="border mt-1 p-2 shadow absolute w-full bg-white space-y-2 overflow-y-auto custom-scrolling h-[200px]">
                                        <label :key="user.id" v-for="user in filteredUser" class="flex gap-2 cursor-pointer">
                                            <input name="selectedUsers" :value="user"  v-model="form.selectedUsers" type="checkbox" class="self-center read-check">
                                            <span class="capitalize"><span class="mr-2"><i class="fa-solid fa-user"></i></span>{{user.name}}  {{user.last_name}}</span>
                                        </label>

                                        <label :key="group.id" v-for="group in filteredGroup" class="flex gap-2 cursor-pointer">
                                            <input name="selectedGroups" :value="group"  v-model="form.selectedGroups" type="checkbox" class="self-center read-check">
                                            <span class="capitalize"><span class="mr-2"><i class="fa-solid fa-users"></i></span>{{group.name}} </span>
                                        </label>

                                    </div>
                                    <div class="py-1 block">
                                        <span  :key="user.id" v-for="user in form.selectedUsers" class="bg-primary-100 p-1 rounded text-white m-1 inline-block text-xs">
                                            {{user.name}} {{user.last_name}}</span>
                                        <span  :key="grouping.id" v-for="grouping in form.selectedGroups" class="bg-primary-100 p-1 rounded text-white m-1 inline-block text-xs">
                                            {{grouping.name}}</span>

                                    </div>
                                </div>
                                <div>
                                    <textarea v-model="form.comment" class="read-text-input" rows="4" placeholder="Add  message if you'd like..."></textarea>
                                    <div v-if="form.errors.comment" class="read-error">
                                        <span>{{ form.errors.comment }}</span>
                                    </div>
                                </div>
                            </form>
                            <div class="bg-gray-100 p-3 rounded-lg my-3">
                                <div class="grid grid-cols-5 gap-2">
                                    <div class="col-span-1">
                                        <img :src="article.image" alt="post.title">
                                    </div>
                                    <div class="col-span-4">
                                        <h6 class="font-bold text-lg">{{article.title}}</h6>
                                    </div>
                                </div>

                            </div>
                            <div class="pt-5 flex justify-end">
                                <button type="submit" class="btn-primary" form="share-form">
                                    Share Article <span class="ml-2 animate-ping" v-if="form.processing"><i class="fa-solid fa-ellipsis"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </Transition>
    </teleport>
</template>

<script setup lang="ts">

import {usePage, useForm} from "@inertiajs/inertia-vue3";
import {computed, onMounted, ref} from "vue";
import axios from "axios";
import {pluck} from "@/scripts/use/usePluck";
const emits=defineEmits(['closeShare'])
let props=defineProps({
    show:Boolean,
    article:Object
})
const share=ref('')
const page=usePage()
const account=page.props.value.auth.account_id
const users=ref([])
const groups=ref([])
//Get all users in enterprise account and groups
onMounted(()=>{
    axios
        .get('api/group/user/'+account)
        .then((response: { data: never[]; }) => {
            users.value = response.data;
        })
        .catch((error: any) => console.log(error))

    axios
        .get('api/get/groups/'+account)
        .then((response: { data: never[]; }) => {
            groups.value = response.data;
        })
        .catch((error: any) => console.log(error))

})

let filteredUser = computed(() =>
    share.value === ''
        ? users.value
        : users.value.filter((user: { name: string; }) =>
            user.name
                .toLowerCase()
                .replace(/\s+/g, '')
                .includes(share.value.toLowerCase().replace(/\s+/g, ''))
        )
)

let filteredGroup = computed(() =>
    share.value === ''
        ? groups.value
        : groups.value.filter((group: { name: string; }) =>
            group.name
                .toLowerCase()
                .replace(/\s+/g, '')
                .includes(share.value.toLowerCase().replace(/\s+/g, ''))
        )
)

const activeSearch=ref(false)

let form=useForm({
    share:share,
    selectedGroups:[],
    selectedUsers:[],
    comment:'',
    article_id:props.article.id

})

const submit=()=>{
    form.post(route('share.store'),{
        onSuccess:()=>{
            form.reset();
            emits('closeShare')
        }
    })

}
</script>

<style scoped>

</style>
