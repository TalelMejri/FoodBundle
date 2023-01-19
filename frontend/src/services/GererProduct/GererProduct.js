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
    getAllCategorieOptions(search){
        return Axios.get(`product/GetOptionForCategorie?${search ? "search="+search : ""}`);
    },
    deleteCategory(id){
        return Axios.delete('product/deleteCategory/'+id);
    },
    deleteOption(id){
        return Axios.delete('product/deleteOption/'+id);
    }
}