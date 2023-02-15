<template>
    <div>
        <v-card class="elevation-12">
            <v-toolbar dark color="yellow">
               <v-toolbar-title >
                  <div class="d-flex justify-content-center">
                      <p style="text-align:center !important;color:#000">Modifier Produit  </p>
                  </div>
               </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                  <form @submit.prevent="update()" >
                    <div class="row">
                        <div class="col-lg-6">
                            <v-text-field
                            name="Name"
                            v-model="formdata.name_food"
                            :error-messages="name_error"
                            label="Name"
                            type="text"
                         ></v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                             name="prix"
                             v-model="formdata.prix_food"
                             :error-messages="prix_produit_error"
                             label="prix"
                             type="text"
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <v-select
                                :items="types"
                                item-text="name"
                                item-value="id"
                                :error-messages="category_error"
                                v-model="formdata.id_category"
                                label="Categorie"
                       ></v-select>
                 
                        </div>
                    </div>

                         <div class="text-center">
                            <div>
                                <img style="border-radius:25px" width="30%" height="20%" :src="formdata.file_food" :alt="formdata.name_food">
                            </div>
                            <div>
                               <input type="file" @change="base64()" id="file" >
                               <small style="color:red" v-if="file_error!=''">{{ file_error }}}</small>
                            </div>
                        </div>
                        <div class="mt-3">
                                 <v-btn :loading="load" type="submit" class="mx-2" color="yellow">
                                        Modifier
                                 </v-btn>
                                 <v-btn @click="close('close')">
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
import service_category from "@/services/GererCategory/category"
import service from "@/services/GererProduct/GererProduct"
 export default{

    validations:{
        formdata:{
          name_food:{
             required
         },
         prix_food:{
             required,
             numeric
         },
         id_category:{
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
      }
    },
    created(){

        service_category.getAllTypeCategory().then((response)=>{
            for(let i=0;i<(response.data).length;i++){
                this.types.push({name:response.data[i].name,id:response.data[i].id});
            }
        });

       service.findProductByIid(this.id).then((response)=>{
              this.formdata.name_food=response.data.data.nameProduct;
              this.formdata.file_food=response.data.data.PhotoProduct;
              this.formdata.prix_food=response.data.data.PrixProduct;
              this.formdata.id_category=response.data.data.id_category;
        })
        
    },
     name:'update',
     
     data(){
        return{
            load:false,
            formdata:{
                    name_food:'',
                    prix_food:'',
                    file_food:'',
                    id_category:''
                },
            types:[],
            file_food:'',
            selectIndice:0
        }
     },
     props:{
        id:Number,
     },
     methods:{
        close(check){
            this.$emit("retourn_consulte_from_update",check);
        },
        base64(){
            const filee = document.querySelector("#file").files[0];
            const reader = new FileReader();
            reader.onloadend = () => {
             this.file = reader.result;
           };
           reader.readAsDataURL(filee);
        },
       
        update(){
            this.$v.formdata.$touch();
             if (this.$v.formdata.$invalid) {
                this.load = false;
                return;
              }
              this.load = true;
            service.UpdateProduct(this.id,{
                id:this.formdata.id_category,
                prix:this.formdata.prix_food,
                name:this.formdata.name_food,
                file:this.formdata.file_food
            }).then(()=>{
                 this.load = false;
                 this.close('updated');
            }).catch(()=>{
                 console.log("error");
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
              if (!this.$v.formdata.id_category.$dirty) return errors;
                !this.$v.formdata.id_category.required && errors.push('Categorie obligatoire');
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
     }
 }

</script>