import "@/plugins/axios";
import Axios from "axios";

export default{

    CoutUser(){
         return Axios.get('user/countUser');
    },

    getallUser(search){
       // return Axios.get(`user/getuser?${search ? "search="+search : ""}`);
       return Axios.get("user/getuser");
   },

     deleteUser(id){
           return Axios.delete('user/deleteUser/'+id);
     }
}