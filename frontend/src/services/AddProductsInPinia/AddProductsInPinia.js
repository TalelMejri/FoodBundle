

import {ProductStore} from "@/store/StoreProducts";

export default{

        Add(p){
            const store=ProductStore();
            store.AddProduct(p);
         } 

}