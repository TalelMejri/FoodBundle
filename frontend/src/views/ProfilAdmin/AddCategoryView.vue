<template>
    <div>
        <v-card class="elevation-12">
            <v-toolbar dark color="#E84C03">
               <v-toolbar-title >
                  <div class="d-flex justify-content-center">
                      <p style="text-align:center !important">Add Category</p>
                  </div>
               </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
            <form @submit.prevent="AddCategory()" enctype="multipart/form-data"> 
                 <div class="row">
                    <div class="col-md-6">
                     <v-text-field
                     name="Name"
                     v-model="name"
                     label="Name "
                     type="text"
                     placeholder="Enter Name"
                   ></v-text-field>
              </div>
              <div class="col-md-6">
                <v-combobox
                    v-model="select"
                    :items="items"
                    @change="fixIndice()"
                    item-text="name"
                    item-value="name"
                    label="Option"
                    multiple
                    outlined
                    dense
                 ></v-combobox>

               <v-dialog
                     style="z-index:9999999999999999999 !important"
                     v-model="dialog"
                     max-width="290"
               >
                 <v-card>
                   <v-card-title class="text-h5">
                       Donner Prix de {{ select[current_item] }}
                   </v-card-title>
                    <form @submit.prevent="addprix()">
                        <div>
                            <v-text-field
                            name="prix"
                            label="prix "
                            type="text"
                            v-model="prix"
                            placeholder="Enter Prix"
                          ></v-text-field>
                        </div>
                   <v-card-actions>
                     <v-spacer></v-spacer>
                     <v-btn
                       color="green darken-1"
                       text
                       @click="dialog = false"
                     >
                       Cancel
                     </v-btn>
           
                     <v-btn
                       color="green darken-1"
                       text
                       type="submit"
                     >
                       Add Prix
                     </v-btn>
                   </v-card-actions>
                   <div class="row">
                  
               </div>
             </form>
                 </v-card>
               </v-dialog>
           </div>
           </div>
           
           <div class="col-lg-6">
            <input    
              class="form-control"
              type="file" ref="file"
              @change="upplaodFile()"
             >
         </div>
        <div class="text-center mt-5 ">
            <v-btn type="submit" style="color:#fff !important" color="#E84C03">
                Add Category
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
    data(){
        return{ 
            select: [],
            current_item:0,
            dialog:false,
            items:[],
            prix:0,
            file:'',
            name:''
        }
    },
    methods:{
        fixIndice(){
            this.dialog=true;
            this.current_item=this.select.length-1;
        },
        addprix(){
            this.items.push({name:this.select[this.current_item],prix:this.prix});
            this.dialog=false;
            this.prix=0;
            console.log(this.items);
        },
        upplaodFile(){
            this.file =this.$refs.file.files[0];
            console.log(this.file);
        },
        AddCategory(){
            service.addCategory({
                'name':this.name,
                'file':this.file,
                'option':this.items
            }).then(()=>{
                 console.log("fff");
            }).catch(()=>{
                console.log("error");
            })
        }
    },
    computed:{
       /*Option_food(){
         if(this.select_type_food=='Pizza'){
             return [
                   {name:'jambon',prix:15},
                   {name:'Thon',prix:25},
                ];
         }else if(this.select_type_food=='Pasta'){
            return [
                    {name:'Formage',prix:15},
                ];
         }else if(this.select_type_food=='Dessert'){
            return [
                    {name:'Chocolate',prix:15},
                ];
         }else if(this.select_type_food=='Drinks'){
            return [
                    {name:'lait',prix:15},
                ];
         }else if(this.select_type_food=='Sandwish'){
            return [ 
                    {name:'Salami',prix:15},
                    {name:'Formage',prix:25}
                ];
         }
        } */
    }
}
</script>