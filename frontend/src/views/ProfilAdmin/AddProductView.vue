<template>
    <div>
        <v-card class="elevation-12">
            <v-toolbar dark color="#E84C03">
               <v-toolbar-title >
                  <div class="d-flex justify-content-center">
                      <p style="text-align:center !important">Add Product</p>
                  </div>
               </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
            <form @submit.prevent="Add_Product()" enctype="multipart/form-data">
                 <div class="row">
                    <div class="col-md-6">
                     <v-text-field
                     name="Name"
                     label="Name Food"
                     type="text"
                     placeholder="Enter Name"
                   ></v-text-field>
              </div>
              <div class="col-md-6">
                <v-select
                v-model="select_type_food"
                :items="types"
                 label="Select"
                 persistent-hint
                 return-object
                 single-line
              ></v-select>
         </div>
           </div>
           <div class="row">
            <div class="col-md-6">
             <v-text-field
             name="Prix"
             label="Prix Food"
             type="text"
             placeholder="Enter Prix"
           ></v-text-field>
      </div>
        <div class="col-md-6">
          
            <v-combobox
                v-model="select_option_food"
                 :items="Option_food"
                  item-text="name"
                  item-value="name"
                  label="Option"
                  multiple
                  outlined
                  dense
          ></v-combobox>
         </div>
        </div>
        <div class="row text-center">
             <div class="col-lg-12">
                <input    
                  class="form-control"
                  type="file" ref="photo"
                 >
             </div>
        </div>
        <div class="text-center mt-5 ">
            <v-btn type="submit" style="color:#fff !important" color="#E84C03">
                Add Product
           </v-btn>
        </div>
             </form>
            </v-card-text>
         </v-card>
    </div>
</template>

<script>
import service from "../../services/GererProduct/GererProduct";
export default{
    created(){
        service.getAllTypeCategory().then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.types.push(response.data[i].name);
            }
        })
    },
    data(){
        return{ 
         select_type_food:'',
         types:[],
        }
    },
    methods:{
        Add_Product(){
             console.log();
        }
    },
    computed:{
       Option_food(){
         if(this.select_type_food=='Pizza'){
             return [
                        {name:'jambon',prix:15},
                        {name:'ddd',prix:25},
                ];
         }else if(this.select_type_food=='Pasta'){
            return [
                      {name:'pastaaaa',prix:15},
                      {name:'aaaaa',prix:25}
                ];
         }else if(this.select_type_food=='Dessert'){
            return [
                      {name:'pastaaaa',prix:15},
                      {name:'eeeeeee',prix:25}
                ];
         }else if(this.select_type_food=='Drinks'){
            return [
                      {name:'Drinksssssssssssss',prix:15},
                      {name:'ddddddddddd',prix:25}
                ];
         }else if(this.select_type_food=='Sandwish'){
            return [ 
                      {name:'Sandwishshhhhshshhs',prix:15},
                      {name:'sssssssss',prix:25}
                ];
         }
        }
    }
}
</script>