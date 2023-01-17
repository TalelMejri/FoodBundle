import { ref,computed } from "vue"
import { defineStore } from "pinia";
import router from "@/router";

export const AuthStore=defineStore('auth',()=>{

    const token=ref(localStorage.getItem('token')??null);
    const isauth=ref(false);
    const user=ref(JSON.parse(localStorage.getItem('user'))??null);
    const isAdmin=ref(localStorage.getItem('isAdmin')??null);

    const getToken=computed(()=>token.value);
    const getisauth=computed(()=>isauth.value);
    const getuser=computed(()=>user.value);
    const getisadmin=computed(()=>isAdmin.value);

    function login(t,u,admin_client){
        token.value=t;
        isauth.value=true;
        isAdmin.value=admin_client;
        user.value=u;
        localStorage.setItem('token',t);
        localStorage.setItem('isauth',true);
        localStorage.setItem('isAdmin',admin_client);
        localStorage.setItem('user',JSON.stringify(u));
    }

    function logout(){
        token.value=null;
        isauth.value=false;
        isAdmin.value=null;
        user.value=null;
        localStorage.removeItem('token');
        localStorage.removeItem('isauth');
        localStorage.removeItem('isAdmin');
        localStorage.removeItem('user');
        router.push('login');
    }

    return {login,logout,token,user,isauth,isAdmin,getToken,getisadmin,getisauth,getuser}
  
})

    

