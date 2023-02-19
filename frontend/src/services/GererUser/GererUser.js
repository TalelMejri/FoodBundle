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

     UpdateUser(user){
          let data=new FormData();
          data.append('name',user.name);
          data.append('lastname',user.lastname);
          data.append('email',user.email);
          data.append('photo',user.photo);
          data.append('tlf',user.tlf);
          data.append('avatarupload',user.avatarupload);
          const config={
               headers:{
                   "Content-Type":"multipart/form-data",
               }
           };

           return Axios.post('user/Updateuser',data,config);
     },
     
     addLiked(id){
          return Axios.post('user/AddLiked/'+id);
     },

     deleteFavorite(id){
          return Axios.delete('user/deleteFavorite/'+id);
     },

     checkLiked(id){
          return Axios.get('user/checkLiked/'+id);
     },

     countLiked(id){
          return Axios.get('user/countLiked/'+id);
     },

     GetAllLikedProduct(id){
          return Axios.get('user/GetAllLikedProduct/'+id);
     },

     getAllProductLiekd(id,page){
          return Axios.get(`user/getAllProductLiekd/${id}&page=${page}`);
     },

     same_password(password){
          return Axios.get('user/samePassword/'+password);
     },
     changer_motdepasse(password){
          return Axios.put('user/changerPassword/'+password);
     }

}