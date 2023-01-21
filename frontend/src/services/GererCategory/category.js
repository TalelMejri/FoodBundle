import "@/plugins/axios";
import axios from "axios";


export default{

    addCategory(product){
        /*var data=new FormData();
        data.append('name',product.name);
        data.append('option',product.option);
        data.append('file',product.file);*/
       
        //console.log(product.option);
        return axios.post('category/addCategory',product);
    },

    getAllTypeCategory(){
        return axios.get('category/AllTypeCategorie');
    },

    getAllCategorieOptions(search,page){
        return axios.get(`category/GetOptionForCategorie?${search ? "search="+search : ""}&page=${page}`);
    },

    deleteCategory(id){
        return axios.delete('category/deleteCategory/'+id);
    },

    UpdateCategory(id,category){
        return axios.post('category/UpdateCategory/'+id,category);
    },

    findCategoryByIid(id){
        return axios.get('category/findCategoryByIid/'+id);
    },

    CountCategory(){
        return axios.get('category/CountCategory');
    },
    
    getAllCategorie(){
        return axios.get('category/getAllCategorie');
    }
}