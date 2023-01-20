<template>
    <div>
        <v-card class="elevation-12">
            <v-toolbar dark color="#E84C03">
               <v-toolbar-title >
                  <div class="d-flex justify-content-center">
                      <p style="text-align:center !important">Add Product {{select_type_food}}</p>
                  </div>
               </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
            <form @submit.prevent="Add_Product()" enctype="multipart/form-data">
                 <div class="row">
                      <div class="col-md-6">
                        <v-text-field
                         name="Name"
                         v-model="name_food"
                         label="Name Food"
                         type="text"
                         placeholder="Enter Name"
                      ></v-text-field>
                    </div>
              <div class="col-md-6">
                   <v-select
                      :items="types"
                      @change="chercherId"
                      item-text="name"
                      item-value="id"
                      v-model="select_id"
                      label="Type"
                  ></v-select>
              </div>
           </div>
           <div class="row">
            <div class="col-md-6">
                <v-text-field
                    name="Prix"
                    label="Prix Food"
                    v-model="total_Prix"
                    type="text"
                    placeholder="Enter Prix"
                 ></v-text-field>
            </div>
          <div class="col-md-6">
             <v-text-field
                 name="file"
                 id="file"
                 label="File Product"
                 @change="base64()"
                 type="file"
            ></v-text-field>
        </div>
        <div class="col-md-12 text-center">
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
            type="number"
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
            <v-combobox
                v-model="Option_food"
                :items="Option_food"
                @change="fixIndice()"
                item-text="nameOption"
                item-value="nameOption"
                label="Option"
                multiple
                outlined
                dense
     ></v-combobox>
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
import service from "@/services/GererProduct/GererProduct";
export default{

    created(){
        service.getAllTypeCategory().then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.types.push({name:response.data[i].name,id:response.data[i].id});
            }
        })
    },
    data(){
        return{ 
         select_type_food:'',
         select_option_food:'',
         types:[],
         Option_food:[],
         select: [],
         items:[],
         prix:0,
         select_id:0,
         name_food:'',
         prix_food:0,
         file_food:'',
         id_category:'',
         dialog:false,
         current_item:''
        }
    },
    methods:{
        fixIndice(){
          this.current_item=this.Option_food.length-1;
          let index=this.Option_food.findIndex((v)=>v.name==this.Option_food[this.current_item]);
          if(index==-1){
            this.dialog=true;
          }
        },
        base64(){
            const filee = document.querySelector("#file").files[0];
            const reader = new FileReader();
            reader.onloadend = () => {
             this.file_food = reader.result;
           };
           reader.readAsDataURL(filee);
        },
        chercherId(){
            service.getOptionByIdCategory({id:this.select_id}).then((response)=>{
                this.Option_food=response.data.data;
           })
        },
        addprix(){
                this.items.push({name:this.Option_food[this.current_item],prix:parseFloat(this.prix)});
                this.dialog=false;
          },
        Add_Product(){
               service.Add_Product({
                 'name_product':this.name_food,
                 'file':this.file_food,
                 'options':this.items,
                 'idCategory':this.select_id,
                 'prixFood':this.total_Prix
               }).then((res)=>{
                  console.log("OKKKKK");
               }).catch((error)=>{
                 console.log("nooooooooo");
               })
        }
    },

    computed:{
        total_Prix(){
            let total=0;
            for(let i=0;i<this.Option_food.length;i++){
                 if(this.Option_food[i].prixOption!=null){
                    total+=this.Option_food[i].prixOption;
                 }
            }
            if(this.items!=''){
                for(let i=0;i<this.items.length;i++){
                    total+=this.items[i].prix;
                }
            }
 
            return total;
        }
    }
 
}
</script>