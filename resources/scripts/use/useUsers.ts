import axios from "axios"
import {ref} from "vue";

export function useUsers(){
    const users=ref([])
    axios.get('api/get/users')
        .then(function (response) {
            // handle success
            users.value = response.data.data;
            //console.log(response.data.data)

        })

    return {
        users
    }
}
