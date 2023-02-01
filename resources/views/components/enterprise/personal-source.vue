<template>
    <Teleport to="body">
        <toast :message="message" @remove="remove()"></toast>
    </Teleport>
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
                        <h6 class="font-bold text-xl my-2">Manage Personal Sources</h6>
                        <hr>
                    </div>
                    <div class="p-3">


                        <div class="my-2 w-2/6 px-3">
                            <input v-model="search" type="search" placeholder="Search sources..."
                                   class="w-full p-1 border-t-0 border-l-0 border-r-0 focus:outline-none focus:ring-0">
                        </div>
                        <div class="px-3 flex justify-between">
                            <h6>Sources</h6>
                            <h6>Personal Sources</h6>
                        </div>

                        <div class="grid grid-cols-8 gap-3 px-3 py-5">
                            <div class="col-span-3 border rounded-lg p-3 shadow">


                                <div class="flex justify-between font-bold">
                                    <div>
                                        <p>{{selectedSource.length}} Selected of {{sources.length}}</p>
                                    </div>
                                    <div>
                                        <button v-if="selectedSource.length" @click="unselectAll">UnSelect All</button>
                                        <button v-else @click="selectAll">Select all</button>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="p-1">
                                    <div class="my-3 space-y-3 h-[180px] overflow-y-auto custom-scrolling">
                                        <div v-for="source in filteredSource" :key="source.id" class="flex gap-2">
                                            <div class="self-center">
                                                <img :src="source.logo" :alt="source.name" class="w-8">
                                            </div>
                                            <label class="read-label flex gap-3 justify-between cursor-pointer self-center">
                                                <input :disabled="ids.includes(source.id)" name="selectedUser" type="checkbox" :value="source.id" class="peer hidden" v-model="selectedSource">
                                                <span class="capitalize peer-checked:bg-primary-100 p-1 rounded peer-checked:text-white"
                                                      :class="{'text-gray-500':ids.includes(source.id)}">{{source.name}}</span>

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
                                        <p>{{availableSource.length}} Selected of {{ mySources.length}}</p>
                                    </div>
                                    <div>
                                        <button v-if="availableSource.length" @click="unselectExisting">UnSelect All</button>
                                        <button v-else @click="selectExisting">Select all</button>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="p-1">
                                    <div class="my-3 space-y-3 h-[180px] overflow-y-auto custom-scrolling">
                                        <div v-for="source in mySources" :key="source.id" class="flex gap-2">
                                            <div class="self-center">
                                                <img :src="source.logo" :alt="source.name" class="w-8">
                                            </div>
                                            <label class="read-label flex gap-3 self-center cursor-pointer">
                                                <input name="selectedUser" type="checkbox" :value="source.id" class="peer hidden" v-model="availableSource">

                                                <span class="capitalize peer-checked:bg-primary-100 p-1 rounded peer-checked:text-white">{{source.name}}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button class="btn-primary" @click="saveClose">Save and Close</button>
                        </div>

                    </div>

                </div>
            </div>
        </Transition>
    </teleport>
</template>

<script setup lang="ts">
import Toast from "@/views/components/toast.vue";
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import {computed, reactive, ref,onMounted} from "vue";
import axios from "axios";
import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
const emits=defineEmits(['close'])
emits("close")
let props=defineProps({
    show:Boolean,
    mySources:Object,
})
const page=usePage()
const user=page.props.value.auth.id
const sources=ref([])

const selectedSource=ref ([]);
const availableSource=ref([]);
const  selectAll=()=>{
    selectedSource.value=sources.value.map((source: { id: any; }) => source.id)
}
const unselectAll=()=>{
    selectedSource.value=[]
}
const selectExisting=()=>{
    availableSource.value=props.group.sources.map((source: { id: any; }) => source.id)
}

const unselectExisting=()=>{
    availableSource.value=[]
}

const search=ref('')



onMounted(()=>{
    axios
        .get('api/get/sources')
        .then((response: { data: never[]; }) => {
            sources.value = response.data.data;

        })
        .catch((error: any) => console.log(error))

})


let filteredSource = computed(() =>
    search.value === ''
        ? sources.value
        : sources.value.filter((source: { name: string; }) =>
            source.name
                .toLowerCase()
                .replace(/\s+/g, '')
                .includes(search.value.toLowerCase().replace(/\s+/g, ''))
        )
)



//save to group
const addToGroup=()=>{

    Inertia.post(route('personalize.add.sources'),{
        ids:selectedSource.value,
        user_id:user
    },{
        onSuccess:()=>{
            selectedSource.value=[]
        }
    })


}

//remove from group
const removeFromGroup=()=>{
    Inertia.post(route('personalize.remove.sources'),{
        ids:availableSource.value,
        user_id:user
    },{
        onSuccess:()=>{
            availableSource.value=[]
        }
    })
}

const ids= computed(() =>{
    let items = []
    props.mySources.forEach((element) =>{
        items.push(element.id)
    })

    return items
})
const message=ref('')
function remove(){
    message.value=null
}
const saveClose=()=>{
    emits('close')
    message.value='Sources Successfully updated'
}
</script>

<style scoped>

</style>
