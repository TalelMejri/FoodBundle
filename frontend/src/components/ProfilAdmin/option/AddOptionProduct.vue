<template>
    <div>
        <template >
            <v-card>
              <v-toolbar
                color="red"
                dark
              >Add Option  </v-toolbar>
              <v-card-text>
               <form @submit.prevent="AddNewOption()">
                 <div class="mx-5 px-5">
                  <v-text-field
                  v-model="name_new"
                  :counter="8"
                  label="Name"
               
                ></v-text-field>
                <!-- <small v-if="name_error!=''">{{name_error}}</small> -->
                <v-text-field
                v-model="prix_new"
                :counter="5"
                label="Prix"
              
              ></v-text-field>
              <!-- <small v-if="prix_error!=''">{{prix_error}}</small> -->
                 </div>
               <v-divider></v-divider>
              <v-card-actions class="justify-end">
                <v-btn type="submit"
                  text
                 >Add</v-btn>
                <v-btn
                text
                @click="closeAdd()"
              >close</v-btn>
              </v-card-actions>
              </form>
             </v-card-text>
            </v-card>
          </template>
    </div>
</template>
<script>

import service from "@/services/GererOption/option"
export default{
    name:'add',
    props:{
        id:Number
    },
    data(){
        return{
            prix_new:'',
            name_new:'',
            name_error:'',
            prix_error:''
        }
    },
    methods:{
        closeAdd(){
            this.$emit('closeAdd');
        },
        AddNewOption(){
            service.addOptionSpecifique({id:this.id,name:this.name_new,prix:this.prix_new}).then(()=>{
                this.$emit('closeAdd');
            }).catch((error)=>{
                 /*this.name_error=error.response.data.errors.nameOption ? error.response.data.errors.nameOption[0] : '';
                 this.prix_error=error.response.data.errors.prixOption ? error.response.data.errors.prixOption[0] : '';*/
            })
        }
    }
}
</script>