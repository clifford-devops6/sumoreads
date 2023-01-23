import axios from "axios";
const useGetPosts= async(limit:any, skip:any)=>{
    const posts=await axios.get(`/api/get/posts?limit=${limit}&skip=${skip}`)
    return posts.data.data
};
export default useGetPosts;
