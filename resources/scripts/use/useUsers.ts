import axios from "axios"
import {ref} from "vue";

export function useUsers(id:number){
    const users=ref([])
    axios.get('api/group/user/'+id)
        .then(function (response) {
            // handle success
            users.value = response.data;
            //console.log(response.data)

        })

    return {
        users
    }
}
