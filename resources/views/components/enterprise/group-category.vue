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
            <div @click.self="$emit('close')"  v-if="show" class="inset-0 fixed bg-gray-900 bg-opacity-70  z-[10000] grid place-items-center p-5" >
                <div class="bg-white lg:w-4/6  w-full rounded-xl">
                    <header class="p-3">
                        <div class="flex justify-between">
                            <div>
                                <Link @click="$emit('close')" class="text-primary-100">
                                    <span class="mr-3"><i class="fa-light fa-arrow-left-long"></i></span>Back
                                </Link>
                            </div>
                            <div>
                                <div class="text-end">
                                    <button class="bg-teal-900 rounded-full h-8 w-8" type="button" @click="$emit('close')"><span class="text-white text-lg"><i
                                        class="fal fa-times"></i></span></button>
                                </div>
                            </div>
                        </div>

                    </header>
                    <div class="text-center">
                        <h6 class="font-bold text-xl my-2">Manage {{group.name}} Group Categories</h6>
                        <hr>
                    </div>
                    <div class="p-3">


                        <div class="my-2 w-2/6 px-3">
                            <input v-model="search" type="search" placeholder="Search categories in Enterprise..."
                                   class="w-full p-1 border-t-0 border-l-0 border-r-0 focus:outline-none focus:ring-0">
                        </div>
                        <div class="px-3 flex justify-between">
                            <h6>Categories</h6>
                            <h6>Available in group</h6>
                        </div>

                        <div class="grid grid-cols-8 gap-3 px-3 py-5">
                            <div class="col-span-3 border rounded-lg p-3 shadow">


                                <div class="flex justify-between font-bold">
                                    <div>
                                        <p>{{selectedCategory.length}} Selected of {{categories.length}}</p>
                                    </div>
                                    <div>
                                        <button v-if="selectedCategory.length" @click="unselectAll">UnSelect All</button>
                                        <button v-else @click="selectAll">Select all</button>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="p-1">
                                    <div class="my-3 space-y-3 h-[180px] overflow-y-auto custom-scrolling">
                                        <div v-for="category in filteredCategory" :key="category.id" class="">
                                            <label class="read-label flex gap-3 justify-between">
                                                <input name="selectedUser" type="checkbox" :value="category.id" class="peer hidden" v-model="selectedCategory">
                                                <span class="capitalize peer-checked:bg-primary-100 p-1 rounded peer-checked:text-white">{{category.name}}</span>


                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2  self-center grid gap-2">
                                <button @click="addToGroup" class="text-start flex justify-between hover:text-white hover:bg-primary-100
                                border rounded-lg p-3 shadow py-2"><span>Add to Group</span> <span><i class="fa-solid fa-caret-right"></i></span></button>
                                <button @click="removeFromGroup" class="text-start flex justify-between hover:text-white hover:bg-primary-100
                                border rounded-lg p-3 shadow py-2"> <span><i class="fa-solid fa-caret-left"></i></span><span>Remove from Group</span></button>

                            </div>
                            <div class="col-span-3 border rounded-lg p-3 shadow">
                                <div class="flex justify-between font-bold">
                                    <div>
                                        <p>{{availableCategory.length}} Selected of {{ group.categories.length}}</p>
                                    </div>
                                    <div>
                                        <button v-if="availableCategory.length" @click="unselectExisting">UnSelect All</button>
                                        <button v-else @click="selectExisting">Select all</button>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="p-1">
                                    <div class="my-3 space-y-3 h-[180px] overflow-y-auto custom-scrolling">
                                        <div v-for="category in group.categories" :key="category.id" class="">
                                            <label class="read-label flex gap-3 justify-between">
                                                <input name="selectedUser" type="checkbox" :value="category.id" class="peer hidden" v-model="availableCategory">
                                                <span class="capitalize peer-checked:bg-primary-100 p-1 rounded peer-checked:text-white">{{category.name}}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button class="btn-primary" @click="$emit('close')">Close</button>
                        </div>

                    </div>

                </div>
            </div>
        </Transition>
    </teleport>
</template>

<script setup lang="ts">
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import {computed, reactive, ref,onMounted} from "vue";
import axios from "axios";
import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
const emits=defineEmits(['close'])
emits("close")
let props=defineProps({
    show:Boolean,
    group:Object,


})

const categories=ref([])

const selectedCategory=ref ([]);
const availableCategory=ref([]);
const  selectAll=()=>{
    selectedCategory.value=categories.value.map((category: { id: any; }) => category.id)
}
const unselectAll=()=>{
    selectedCategory.value=[]
}
const selectExisting=()=>{
    availableCategory.value=props.group.categories.map((category: { id: any; }) => category.id)
}

const unselectExisting=()=>{
    availableCategory.value=[]
}

const search=ref('')



onMounted(()=>{
    axios
        .get('api/get/categories')
        .then((response: { data: never[]; }) => {
            categories.value = response.data;
        })
        .catch((error: any) => console.log(error))

})


let filteredCategory = computed(() =>
    search.value === ''
        ? categories.value
        : categories.value.filter((category: { name: string; }) =>
            category.name
                .toLowerCase()
                .replace(/\s+/g, '')
                .includes(search.value.toLowerCase().replace(/\s+/g, ''))
        )
)



//save to group
const addToGroup=()=>{

    Inertia.post(route('group.add.categories'),{
        ids:selectedCategory.value,
        group:props.group.id
    },{
        onSuccess:()=>{
            selectedCategory.value=[]
        }
    })


}

//remove from group
const removeFromGroup=()=>{
    Inertia.post(route('group.remove.categories'),{
        ids:availableCategory.value,
        group:props.group.id
    },{
        onSuccess:()=>{
            availableCategory.value=[]
        }
    })
}
</script>

<style scoped>

</style>
