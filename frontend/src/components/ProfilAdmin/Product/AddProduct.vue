<template>
    <div>
        <v-card class="elevation-12">
            <v-toolbar dark color="#E84C03">
               <v-toolbar-title >
                  <div class="d-flex justify-content-center">
                      <p style="text-align:center !important">Ajouter Produit {{select_type_food}}</p>
                  </div>
               </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
            <form @submit.prevent="Add_Product()" enctype="multipart/form-data">
                 <div class="row">
                      <div class="col-md-6">
                        <v-text-field
                         name="Name"
                         :error-messages="name_error"
                         v-model="formdata.name_food"
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
                      :error-messages="category_error"
                      v-model="formdata.select_id"
                      label="Category"
                  ></v-select>
              </div>
           </div>
           <div class="row">
            <div class="col-md-6">
                <v-text-field
                    name="Prix"
                    label="Prix Food"
                    :error-messages="prix_produit_error"
                    v-model="formdata.prix_food"
                    type="text"
                    placeholder="Enter Prix"
                 ></v-text-field>
                 
            </div>
          <div class="col-md-6">
             <v-text-field
                 name="file"
                 id="file"
                 :error-messages="file_error"
                 label="File Product"
                 @change="base64()"
                 type="file"
            ></v-text-field>
        </div>
        <div class="col-md-12 text-center">
        
    <div class="row">
      <div class="col-lg-6">
        <v-combobox
           v-model="Option_food"
           :items="Option_food"
           readonly
           item-text="nameOption"
           item-value="nameOption"
           label="Option Global"
           multiple
           outlined
           dense
     ></v-combobox>
      </div>
      <div class="col-lg-6">
        <v-combobox
            v-model="select"
            :items="items"
              @change="fixIndice()"
              item-text="name"
             item-value="name"
             label="Option Specifique"
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
            label="prix"
            type="text"
            :error-messages="prix_error"
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
          Fermer
        </v-btn>
          <v-btn
            color="primary"
            text
            @click="addprix()"
          >
            Ajouter Option
          </v-btn>
        </v-card-actions>
      </form>
      </v-card>
    </v-dialog>
      </div>
    </div>

         </div>
        </div>
        <div class="text-center mt-5 ">
          <!-- :disabled="v$.formdata.$invalid" -->
            <v-btn :loading="load"  type="submit" style="color:#fff !important" color="#E84C03" class="mx-2">
                Ajouter Produit
           </v-btn>
           <v-btn @click="close_add('fermer')"  style="color:#000 !important" color="gray">
                Fermer
            </v-btn>
        </div>
             </form>
            </v-card-text>
         </v-card>
    </div>
</template>

<script>
import { required,numeric }   from 'vuelidate/lib/validators'
import service from "@/services/GererProduct/GererProduct";
import service_option from "@/services/GererOption/option"
import service_category from "@/services/GererCategory/category"
export default{
    created(){
      service_category.getAllTypeCategory().then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.types.push({name:response.data[i].name,id:response.data[i].id});
            }
        })
    },
    validations:{
        formdata:{
          name_food:{
             required
         },
         prix_food:{
             required,
             numeric
         },
         select_id:{
             required,
         },
         file_food:{
                required,
                typeFile(val){
                   const tab_ext_dispo=['jpg','gif','png','svg','jpeg'];
                   const extention=val.split(';')[0].split('/')[1];
                   return tab_ext_dispo.find((v)=>v==extention) ? true : false ;
                }
          },
      },
      prix:{required,numeric}
    },
    data(){
        return{ 
         select_type_food:'',
         select_option_food:'',
         types:[],
         load:false,
         Option_food:[],
         select: [],
         items:[],
         Option_food_option:[],
         prix:'',
         formdata:{
          name_food:'',
          prix_food:'',
          select_id:'',
          file_food:'',
         },
         id_category:0,
         //file_food:'',
         dialog:false,
         current_item:'',
         snackbar:false
        }
    },
    methods:{
      close_add(check){
        this.$emit("retourn_consulte",check);
      },
        fixIndice(){
            this.current_item=this.select.length-1;
            let index=this.items.findIndex((v)=>v.name==this.select[this.current_item]);
            if(index==-1){
              this.dialog=true;
            }
        },
        base64(){
            const file = document.querySelector("#file").files[0];
            const reader = new FileReader();
            reader.onloadend = () => {
             this.formdata.file_food = reader.result;
           };
           reader.readAsDataURL(file);
        },
        chercherId(){
          service_option.getOptionByIdCategory({id:this.formdata.select_id}).then((response)=>{
                this.Option_food=response.data.data;
           })
        },
        addprix(){
             this.$v.prix.$touch();
             if (this.$v.prix.$invalid) {
                this.dialog=true;
                return;
              }
                this.items.push({name:this.select[this.current_item],prix:parseFloat(this.prix)});
                this.dialog=false;
                this.prix=0;
          },
        Add_Product(){
             this.$v.formdata.$touch();
             if (this.$v.formdata.$invalid) {
                this.load = false;
                return;
              }
              this.load=true;
               service.Add_Product({
                 'name_product':this.formdata.name_food,
                 'file':this.formdata.file_food,
                 'options':this.items,
                 'idCategory':this.formdata.select_id,
                 'prixFood':this.formdata.prix_food
               }).then((res)=>{
                this.formdata.name_food="";
                this.formdata.file_food="";
                this.items=[];
                this.formdata.select_id='';
                this.total_Prix=0;
                this.load=false;
                this.$emit("retourn_consulte",'added');
               }).catch((error)=>{
                  console.log("error");
                  this.load=false;
               })
        }
    },
    computed:{
          name_error(){
            const errors=[];
              if (!this.$v.formdata.name_food.$dirty) return errors;
                !this.$v.formdata.name_food.required && errors.push('name obligatoire');
                return errors;
            },
            category_error(){
              const errors=[];
              if (!this.$v.formdata.select_id.$dirty) return errors;
                !this.$v.formdata.select_id.required && errors.push('Categorie obligatoire');
                return errors;
            },
            prix_produit_error(){
              const errors=[];
              if (!this.$v.formdata.prix_food.$dirty) return errors;
                !this.$v.formdata.prix_food.required && errors.push('Prix obligatoire');
                !this.$v.formdata.prix_food.numeric && errors.push('Prix doit etre numerique');
                return errors;
            },
            file_error(){
              const errors=[];
            if (!this.$v.formdata.file_food.$dirty) return errors;
                  !this.$v.formdata.file_food.required && errors.push('image obligatoire');
                   !this.$v.formdata.file_food.typeFile && errors.push('image doit étre de type ( jpg,jpeg,png,svg,gif) ');
             return errors;
            },
            prix_error(){
                const errors=[];
                if (!this.$v.prix.$dirty) return errors;
                   !this.$v.prix.required && errors.push('prix obligatoire');
                   !this.$v.prix.numeric && errors.push('prix doit etre numerique ');
                return errors;
            }
        /*total_Prix(){
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
        }*/
    }
 
}
</script>