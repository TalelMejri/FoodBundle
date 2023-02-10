import axios from "axios";
import '@/plugins/axios';

export default{

     ForgotPassword(email){
        return axios.post('resetPassword/forgot_password',email);
     },

     ChangerPassword(data){
        return axios.post('resetPassword/changer_password',data);
     } 
     
}