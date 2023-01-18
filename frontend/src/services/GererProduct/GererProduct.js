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
    }
}