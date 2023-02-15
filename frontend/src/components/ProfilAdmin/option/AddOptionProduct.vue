<template>
    <div>
        <template >
            <v-card>
              <v-toolbar
                color="red"
                dark
              >Ajouter Option  </v-toolbar>
              <v-card-text>
               <form @submit.prevent="AddNewOption()">
                 <div class="mx-5 px-5">
                  <v-text-field
                  v-model="formdata.name"
                  :error-messages="name_error"
                  :counter="8"
                  label="Name"
                ></v-text-field>
               
                <v-text-field
                v-model="formdata.prix"
                :counter="5"
                :error-messages="prix_error"
                label="Prix"
              ></v-text-field>
             
                 </div>
               <v-divider></v-divider>
              <v-card-actions class="justify-end">
                <v-btn type="submit"
                  text
                  :loading="load"
                 >Ajouter</v-btn>
                <v-btn
                text
                @click="closeAdd()"
              >Fermer</v-btn>
              </v-card-actions>
              </form>
             </v-card-text>
            </v-card>
          </template>
    </div>
</template>
<script>
import { required,numeric }   from 'vuelidate/lib/validators'
import service from "@/services/GererOption/option"
export default{
    name:'add',
    props:{
        id:Number
    },
    validations:{
        formdata:{
          name:{
             required
         },
         prix:{
             required,
             numeric
         },
      }
    },
    data(){
        return{
          formdata:{
            prix:'',
            name:'',
          },
          load:false
        }
    },
    methods:{
        closeAdd(){
            this.$emit('closeAdd');
        },
        AddNewOption(){
             this.$v.formdata.$touch();
             if (this.$v.formdata.$invalid) {
                this.load = false;
                return;
              }
              this.load = true;
            service.addOptionSpecifique({id:this.id,name:this.formdata.name,prix:this.formdata.prix}).then((res)=>{
               this.load = false;  
               this.$emit('closeAdd'); 
            }).catch((error)=>{
                  this.load = false;
                 /*this.name_error=error.response.data.errors.nameOptionSpecifique
                                    ? error.response.data.errors.nameOptionSpecifique[0] : '';
                 this.prix_error=error.response.data.errors.prixOptionSpecifique
                                      ? error.response.data.errors.prixOptionSpecifique
                                                  [0] : '';*/
            })
        }
    },
    computed:{
            name_error(){
            const errors=[];
              if (!this.$v.formdata.name.$dirty) return errors;
                !this.$v.formdata.name.required && errors.push('name obligatoire');
                return errors;
            },
            prix_error(){
              const errors=[];
              if (!this.$v.formdata.prix.$dirty) return errors;
                !this.$v.formdata.prix.required && errors.push('prix obligatoire');
                !this.$v.formdata.prix.numeric && errors.push('doit étre numerique');
                return errors;
            }
    }
}
</script>