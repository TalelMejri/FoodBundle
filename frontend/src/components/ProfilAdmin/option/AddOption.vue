<template>
    <div>
        <template >
            <v-card>
              <v-toolbar
                color="red"
                dark
              >Ajouter Option</v-toolbar>
              <v-card-text>
               <form @submit.prevent="AddNewOption()">
                 <div class="mx-5 px-5">
                  <v-text-field
                  v-model="name"
                  :error-messages="name_error"
                  :counter="8"
                  label="Name"
                ></v-text-field>
              
                 </div>
               <v-divider></v-divider>
              <v-card-actions class="justify-end">
                <v-btn type="submit"
                color="red"
                :loading="load"
                 >Ajouter</v-btn>
                <v-btn
                color="gray"
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
import { required }   from 'vuelidate/lib/validators'
import service from "@/services/GererOption/option"
export default{
    name:'add',
    props:{
        id:Number
    },
    validations:{
          name:{
             required
         },
    },
    data(){
        return{
            name:'',
            load:false
        }
    },
    methods:{
        closeAdd(){
            this.$emit('closeAdd');
        },
        AddNewOption(){
            this.$v.name.$touch();
             if (this.$v.name.$invalid) {
                this.load = false;
                return;
              }
              this.load=true;
            service.addOption({id:this.id,nameOption:this.name}).then(()=>{
                this.load=false;
                this.$emit('closeAdd');
            }).catch((error)=>{
                this.load=false;
                 //this.name_error=error.response.data.errors.nameOption ? error.response.data.errors.nameOption[0] : '';
            })
        }
    },
    computed:{
        name_error(){
            const errors=[];
              if (!this.$v.name.$dirty) return errors;
                !this.$v.name.required && errors.push('name obligatoire');
                return errors;
            },
    }
}
</script>