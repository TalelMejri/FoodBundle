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
      v-model="dialog"
      width="500"
    >


      <v-card>
        <v-card-title class="text-h5 grey lighten-2">
          Prix
        </v-card-title>

        <v-card-text>
          Enter Prix For {{ select[current_item] }}
        </v-card-text> 

        <form @submit.prevent="addprix()">

          <div class="mx-5 px-5">
            <v-text-field
            name="prix"
            label="prix "
            type="text"
            v-model="prix"
            placeholder="Enter Prix"
          ></v-text-field>
          </div>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
          color="gray"
          text
          @click="dialog = false"
        >
          Close
        </v-btn>
          <v-btn
            color="primary"
            text
            @click="addprix()"
          >
            Add Product
          </v-btn>
        </v-card-actions>
      </form>
      </v-card>
    </v-dialog>
           </div>
           </div>
           <div class="col-lg-6">
            <input    
            ref="file_identity"
            type="file"
            id="identity"
            class="form-control"
            @change="createBase64Image"
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
         <v-snackbar
         v-model="snackbar"
       >
          Category Added
       <template v-slot:action="{ attrs }">
        <v-btn
          color="green"
             text
             v-bind="attrs"
             @click="snackbar = false"
        >
          Close
         </v-btn>
        </template>
       </v-snackbar>
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
            snackbar:false,
            file:'',
            categories:[],
            final_items:[],
            name:'',
            selectedImage:''
        }
    },
    methods:{
   createBase64Image(image) {
      const filee = document.querySelector("#identity").files[0];
      const reader = new FileReader();
      let rawImg = this;
      reader.onloadend = () => {
        rawImg.file = reader.result;
        console.log(rawImg.file);
      };
      reader.readAsDataURL(filee);
    },
        fixIndice(){
            this.current_item=this.select.length-1;
            this.dialog=true;
        },
        addprix(){
                this.items.push({name:this.select[this.current_item],prix:parseFloat(this.prix)});
                this.dialog=false;
                this.prix=0;
          },
        upplaodFile(e){
            const selectedImage = e.target.files[0];
            this.createBase64Image(selectedImage);
        },

        AddCategory(){
          let i=0;
          let j=0;
          while(j<this.select.length){

            if(this.items[i]['name']!=this.select[j]){
                i++;
            }else{
              this.final_items.push((this.items[i]));
              j++;
            }
        
          }

          console.log( this.final_items);
            service.addCategory({
                'name':this.name,
                'file':this.file,
                'option':this.final_items
            }).then(()=>{
                 console.log("Success");
                 this.snackbar=true;
                 this.final_items=[];
                 this.items=[];
                 this.select=[];
                 this.name="";
                 this.file=null;
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