import "@/plugins/axios";
import axios from "axios";

export default{

    deleteProduct(id){
        return axios.delete('product/deleteProduct/'+id);
    },

    UpdateProduct(id,Product){
        return axios.post('product/UpdateProduct/'+id,Product);
    },

    Add_Product(Product){
        return axios.post('product/Add_Product',Product);   
    },

    GetProductCategoryOption(idcategory,search,page){
        return axios.get(`product/GetProductCategoryOption?${search ? 'search='+search : ''}&idcategory=${idcategory!=-1 ? idcategory : -1}&page=${page}`);   
    },

    findProductByIid(idProduct){
        return axios.get('product/findProductByIid/'+idProduct);   
    },

    countproduct(){
        return axios.get('product/countproduct');   
    },

    getallProduct(){
        return axios.get('product/AllProduct');
    },

    getProductByIdCategory(id){
        return axios.get('product/getProductByIdCategory/'+id);
    },


    GetProudctOptionSpecifiqueCategory(id,search,prix,typeordered,page){
        return axios.get(`product/GetProudctOptionSpecifiqueCategory?id=${id}&${search ? 'search='+search : ''}&prix=${prix}&${typeordered ? 'typeordered='+typeordered : ''}&page=${page}`);
    }


}