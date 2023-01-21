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
     },

     UpdateUser(id,user){
          let data=new FormData();
          data.append('name',user.name);
          data.append('lastname',user.lastname);
          data.append('email',user.email);
          data.append('photo',user.photo);
          data.append('avatarupload',user.avatarupload);
          const config={
               headers:{
                   "Content-Type":"multipart/form-data",
               }
           };

           return Axios.post('user/Updateuser/'+id,data,config);

     }




}