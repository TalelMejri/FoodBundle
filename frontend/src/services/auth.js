import "@/plugins/axios";
import Axios from "axios";

import {AuthStore} from "@/store/StoreAuth";

export default{

     CreateUser(user){
        let data =new FormData();
        data.append('Photo',user.photo);
        data.append('name',user.name);
        data.append('email',user.email);
        data.append('password',user.password);
        data.append('lastname',user.lastname);
        data.append('numero_tlf',user.numero_tlf);
        const config={
            Headers:{
                "content-Type":'multipart/form-data',
            },
        };
        return Axios.post('auth/registerUser',data,config);
     },

    async LoginUser(email,password){
        const store=AuthStore();
        const res= await Axios.post('auth/loginUser',{email,password});
        if(res.status===200){
            store.login(res.data.data.token,res.data.data.user,res.data.data.isAdmin);
        }else{
            store.logout();
        }
     }  

}