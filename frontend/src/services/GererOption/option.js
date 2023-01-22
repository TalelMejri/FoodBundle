import "@/plugins/axios";
import axios from "axios";


export default{

    deleteOptionSpecifique(id){
        return axios.delete('option/deleteOptionSpecifique/'+id);
    },

    deleteOption(id){
        return axios.delete('option/deleteOption/'+id);
    },

    UpdateOption(id,option){
        return axios.post('option/UpdateOption/'+id,option);
    },

    UpdateOptionSpecifique(id,option){
        return axios.post('option/UpdateOptionSpecifique/'+id,option);
    },
       
    findOptionByIid(id){
        return axios.get('option/findOptionByIid/'+id);
    },

    addOption(option){
        return axios.post('option/addOption',option);
    },

    addOptionSpecifique(option){
        return axios.post('option/addOptionSpecifique',option);
    },

    getOptionByIdCategory(category){
        return axios.get('option/getOptionByIdCategory/'+category.id);   
    },

    countOption(){
        return axios.get('option/countOption');   
    },

    CountOptionSpecifique(){
        return axios.get('option/CountOptionSpecifique');   
    },

    getOptionGlobal(id,search,page){
         return axios.get(`option/getOptionGlobal?${search ? 'search='+search : ''}&id=${id!=-1 ? id :-1}&page=${page}`);
    },

    getOptionSpecifique(id,search,page){
        return axios.get(`option/getOptionSpecifique?${search ? 'search='+search : ''}&id=${id!=-1 ? id :-1}&page=${page}`);
    }
    



}