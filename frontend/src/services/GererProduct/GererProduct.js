import "@/plugins/axios";
import Axios from "axios";

export default{

    addCategory(product){
        /*var data=new FormData();
        data.append('name',product.name);
        data.append('option',product.option);
        data.append('file',product.file);*/
        const config={
            headers:{
                "Content-Type":"Undefined",
            }
        };
        //console.log(product.option);
        return Axios.post('product/addCategory',product);
    },

    getAllTypeCategory(){
        return Axios.get('product/AllTypeCategorie');
    },

    getAllCategorieOptions(search,page){
        return Axios.get(`product/GetOptionForCategorie?${search ? "search="+search : ""}&page=${page}`);
    },

    deleteCategory(id){
        return Axios.delete('product/deleteCategory/'+id);
    },

    deleteOption(id){
        return Axios.delete('product/deleteOption/'+id);
    },

    UpdateOption(id,option){
        return Axios.post('product/UpdateOption/'+id,option);
    },
    
    UpdateCategory(id,category){
        return Axios.post('product/UpdateCategory/'+id,category);
    },

    findCategoryByIid(id){
        return Axios.get('product/findCategoryByIid/'+id);
    },

    findOptionByIid(id){
        return Axios.get('product/findOptionByIid/'+id);
    },

    addOption(option){
        return Axios.post('product/addOption',option);
    },

    CountCategory(){
        return Axios.get('product/CountCategory');
    },

    getOptionByIdCategory(user){
        return Axios.get('product/getOptionByIdCategory/'+user.id);   
    },

    Add_Product(Product){
        return Axios.post('product/Add_Product',Product);   
    }

}