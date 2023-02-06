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
                        <h6 class="font-bold text-xl my-2">Manage {{group.name}} Group Members</h6>
                        <hr>
                    </div>
                    <div class="p-3">


                        <div class="my-2 w-2/6 px-3">
                            <input v-model="search" type="search" placeholder="Search members in Enterprise..."
                                   class="w-full p-1 border-t-0 border-l-0 border-r-0 focus:outline-none focus:ring-0">
                        </div>
                        <div class="px-3 flex justify-between">
                            <h6>Enterprise Users</h6>
                            <h6>Available in group</h6>
                        </div>

                        <div class="grid grid-cols-8 gap-3 px-3 py-5">
                           <div class="col-span-3 border rounded-lg p-3 shadow">


                               <div class="flex justify-between font-bold">
                                   <div>
                                       <p>{{selectedUser.length}} Selected of {{users.length}}</p>
                                   </div>
                                   <div>
                                       <button v-if="selectedUser.length" @click="unselectAll">UnSelect All</button>
                                       <button v-else @click="selectAll">Select all</button>
                                   </div>
                               </div>
                               <hr class="my-3">
                               <div class="p-1">
                                   <div class="my-3 space-y-3 h-[180px] overflow-y-auto custom-scrolling">
                                       <div v-for="user in filteredPeople" :key="user.id" class="">
                                           <label class="read-label flex gap-3 justify-between" >
                                               <input :disabled="ids.includes(user.id)" name="selectedUser" type="checkbox" :value="user.id" class="peer hidden" v-model="selectedUser">
                                               <span class="capitalize peer-checked:bg-primary-100 p-1 rounded peer-checked:text-white" :class="{'text-gray-400 cursor-not-allowed':ids.includes(user.id)}">{{user.name}} {{user.last_name}}</span>
                                               <span v-if="user.id===admin" class="p-1 text-primary-100">Primary User</span>

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
                                        <p>{{availableUser.length}} Selected of {{ group.users.length}}</p>
                                    </div>
                                    <div>
                                        <button v-if="availableUser.length" @click="unselectExisting">UnSelect All</button>
                                        <button v-else @click="selectExisting">Select all</button>
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="p-1">
                                    <div class="my-3 space-y-3 h-[180px] overflow-y-auto custom-scrolling">
                                        <div v-for="user in group.users" :key="user.id" class="">
                                            <label class="read-label flex gap-3 justify-between">
                                                <input name="selectedUser" type="checkbox" :value="user.id" class="peer hidden" v-model="availableUser">
                                                <span class="capitalize peer-checked:bg-primary-100 p-1 rounded peer-checked:text-white">{{user.name}} {{user.last_name}}</span>
                                                <span v-if="user.id===admin" class="p-1 text-primary-100">Primary User</span>

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
    admin:Number

})
const page=usePage()
const account=page.props.value.auth.account_id
const users=ref([])

const selectedUser=ref ([]);
const availableUser=ref([]);
const  selectAll=()=>{
    selectedUser.value=users.value.map((user: { id: any; }) => user.id)
}
const unselectAll=()=>{
    selectedUser.value=[]
}
const selectExisting=()=>{
    availableUser.value=props.group.users.map((user: { id: any; }) => user.id)
}

const unselectExisting=()=>{
    availableUser.value=[]
}

const search=ref('')
const searchAvailable=ref('')


onMounted(()=>{
    axios
        .get('api/group/user/'+account)
        .then((response: { data: never[]; }) => {
            users.value = response.data;
        })
        .catch((error: any) => console.log(error))

})


let filteredPeople = computed(() =>
    search.value === ''
        ? users.value
        : users.value.filter((user: { name: string; }) =>
            user.name
                .toLowerCase()
                .replace(/\s+/g, '')
                .includes(search.value.toLowerCase().replace(/\s+/g, ''))
        )
)



//save to group
const addToGroup=()=>{

        Inertia.post(route('group.add.users'),{
            ids:selectedUser.value,
            group:props.group.id
        },{
            onSuccess:()=>{
                selectedUser.value=[]
            }
        })


}

//remove from group
const removeFromGroup=()=>{
    Inertia.post(route('group.remove.users'),{
        ids:availableUser.value,
        group:props.group.id
    },{
        onSuccess:()=>{
            availableUser.value=[]
        }
    })
}

const ids= computed(() =>{
    let items = []
    props.group.users.forEach((element) =>{
        items.push(element.id)
    })

    return items
})
</script>

<style scoped>

</style>
