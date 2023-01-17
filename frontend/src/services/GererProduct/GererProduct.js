import "@/plugins/axios";
import Axios from "axios";

export default{
    addCategory(product){

        let data=new FormData();
        data.append('name',product.name);
        data.append('option',product.option);
        data.append('file',product.file);

        const config={
            headers:{
                "Content-Type":"multipart/form-data",
            }
        };

       // console.log(data.append);
        return Axios.post('product/addCategory',data,config);
    }
}