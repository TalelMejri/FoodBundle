import { ref,computed } from "vue"
import { defineStore } from "pinia";

export const ProductStore=defineStore('ProductStore',()=>{

    const Products=ref(JSON.parse(localStorage.getItem('Products'))??null);

    const getProducts=computed(()=>Products.value);

    function AddProduct(p){
        localStorage.setItem('Products',JSON.stringify(p));
    }

    function ClearProducts(){
        localStorage.removeItem('Products');
    }

    return {Products,getProducts,AddProduct,ClearProducts}
    
})

    

