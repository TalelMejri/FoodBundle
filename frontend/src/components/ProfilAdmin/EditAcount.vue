<template>
    <div class="mt-5 py-5">
        <template class="mt-5 py-5">
            <v-card >
              <v-toolbar 
                color="green"
                dark
                >Edit User  </v-toolbar>
              <v-card-text >
               <form  @submit.prevent="EditUser()" enctype="multipart/form-data">
                 <div class="mx-5 px-5">
                    <div class="row">

                        <div class="col-lg-6">
                            <v-text-field
                            v-model="name"
                            label="Name"
                          ></v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            v-model="lastname"
                            label="Lastname"
                          ></v-text-field>
                        </div>

                        <div class="col-lg-6">
                                <v-text-field
                                    v-model="email"
                                    type="email"
                                    label="email"
                                 ></v-text-field>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <input
                                @change="UploadFile()"
                                type="file"
                                ref="photo"
                             />
                             <img width="80px" height="80px" :src="'http://127.0.0.1:8000'+photo" alt="">
                        </div>
                    </div>
                 </div>
               <v-divider></v-divider>
              <v-card-actions class="justify-end">
                <v-btn class="mx-2" type="submit" color="green"
                    >
                 Edit
                </v-btn>
                <router-link  v-if="store.isAdmin!=1" style="text-decoration:none !important" to="/">
                <v-btn  type="submit" color="gray"
                     >
                    Close
                </v-btn>
             </router-link>
              </v-card-actions>
              </form>
             </v-card-text>
            </v-card>
          </template>
    </div>
</template>

<script>
import service_user from "@/services/GererUser/GererUser"
import {AuthStore} from "@/store/StoreAuth"

export default{
    name:'edit',
    props:{
        direction:String
    },
    created(){
        this.name=this.store.user['name'];
        this.lastname=this.store.user['lastname'];
        this.email= this.store.user['email'];
        this.photo=this.store.user['Photo'];
        this.iduser=this.store.user['id'];
       },
    setup(){
        const store=AuthStore();
        return{
            store
        }
    },
    data(){
        return{
            file:'',
            name:'',
            lastname:'',
            email:'',
            photo:'',
            iduser:'',
            avatarupload:0
        }
    },
    methods:{
        UploadFile(){
           //this.file=e.target.files[0];
           this.file=this.$refs.photo.files[0];
           this.avatarupload=1;
        },
        EditUser(){

            service_user.UpdateUser(this.iduser,{
                 name:this.name,
                 lastname:this.lastname,
                 photo:this.file,
                 email:this.email,
                 avatarupload:this.avatarupload
            }).then((response)=>{
                 this.store.login(this.store.user['token'],response.data.data,this.store.getisadmin);
                 if(this.direction=='home'){
                    this.$router.push({name:"home", query: {content: 'Edit Account With Success'}});
                 }else{
                    this.$emit('returnstate');
                 }
               /*console.log(response.data.data);
                 console.log(this.store.user);*/
            }).catch((error)=>{
                console.log("error");
            })
        }
    },
    computed:{
       
    }
}
</script>