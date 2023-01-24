import axios from "axios"
import {ref} from "vue";



export function useArticles(limit:number){
    const articles=ref([])
    //get a task
    axios.get('/api/get/posts',{
        params: {
            limit:limit
    
        }
    })
        .then(function (response) {
            // handle success
            articles.value = response.data.data;
            //console.log(response.data.data)

        })

    return {
        articles
    }
}
