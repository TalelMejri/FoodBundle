<template>
    <div class="mt-5 py-5">
        <template class="mt-5 py-5">
            <v-card >
              <v-toolbar 
                color="green"
                dark
                >
                <div class="row text-center">
                    <div class="col-lg-4">
                          <v-btn :color="page==0 ? '#000' : ''" text @click="page=0">
                             Changer Information Personnel
                          </v-btn>
                    </div>
                    <div class="col-lg-4">
                        <v-btn  :color="page==1 ? '#000' : ''" text @click="page=1">
                            Changer Password
                        </v-btn>
                    </div>
                    <div class="col-lg-4">
                        <v-btn  :color="page==2 ? '#000' : ''" text @click="page=2">
                            Changer Email
                        </v-btn>
                    </div>
                </div>
            </v-toolbar>
              <v-card-text v-if="page==0" >
               <form  @submit.prevent="EditUser()" enctype="multipart/form-data">
                 <div class="mx-5 px-5">
                    <div class="row">
                        <div class="col-lg-6">
                            <v-text-field
                            v-model="name"
                            :error-messages="name_error"
                            label="Name"
                          ></v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            v-model="lastname"
                            :error-messages="lastname_error"
                            label="Lastname"
                          ></v-text-field>
                        </div>
                        <div class="col-lg-6">
                            <v-text-field
                            v-model="numero_tlf"
                            :error-messages="numero_tlf_error"
                            label="N°tlf"
                          ></v-text-field>
                        </div>
                        <div class="col-lg-6">
                                <v-text-field
                                    readonly
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
                            <small style="color:red !important" v-if="photo_error!=''">
                                {{ photo_error[0] }}
                             </small>
                      
                    </div>
                 </div>
               <v-divider></v-divider>
              <v-card-actions class="justify-end">
                <v-btn :loading="load" class="mx-2" type="submit" color="green"
                    >
                 Changer
                </v-btn>
                <router-link  v-if="store.isAdmin!=1" style="text-decoration:none !important" to="/">
                <v-btn  type="submit" color="gray"
                     >
                    Fermer
                </v-btn>
             </router-link>
              </v-card-actions>
              </form>
             </v-card-text>


             <v-card-text v-else-if="page==1">
                <form  @submit.prevent="ChangerPassword()" >
                  <div class="mx-5 px-5">
                    <div class="col-xl-9 col-lg-6 text-center">
                     <div class="row d-flex justify-content-center">
                         <div class="col-lg-12">
                             <v-text-field
                             v-model="old_password"
                             :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                             :type="show ? 'text' : 'password'"
                             @click:append="show = !show"
                             :error-messages="password_error"
                             label="Ancien Mot de passe"
                           ></v-text-field>
                         </div>

                         <div class="col-lg-12">
                            <v-text-field
                            v-model="new_password"
                            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                            :type="show1 ? 'text' : 'password'"
                            @click:append="show1 = !show1"
                            :error-messages="new_password_error"
                            label="Nouvelle Mot de passe"
                          ></v-text-field>
                        </div>
                        <br>
                        <div class="col-lg-12">
                            <v-text-field
                            v-model="confirm_password"
                            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                            :type="show2 ? 'text' : 'password'"
                            @click:append="show2 = !show2"
                            :error-messages="confirm_password_error"
                            label="Confirme Mot de passe"
                          ></v-text-field>
                        </div>
                     </div>
                    </div>
                  </div>
                <v-divider></v-divider>
               <v-card-actions class="justify-end">
                 <v-btn class="mx-2" type="submit" color="green" :loading="load"
                     >
                  Changer
                 </v-btn>
                 <router-link  v-if="store.isAdmin!=1" style="text-decoration:none !important" to="/">
                 <v-btn  type="submit" color="gray"
                      >
                     Fermer
                 </v-btn>
              </router-link>
               </v-card-actions>
               </form>
              </v-card-text>

              <v-card-text v-else>
                <form  @submit.prevent="ChangerPassword()" >
                  <div class="mx-5 px-5">
                     <div class="row">
                         <div class="col-lg-6">
                             <v-text-field
                             v-model="email"
                             label="email"
                           ></v-text-field>
                         </div>
                     </div>
                  </div>
                <v-divider></v-divider>
               <v-card-actions class="justify-end">
                 <v-btn class="mx-2" type="submit" color="green"
                     >
                  Changer
                 </v-btn>
                 <router-link  v-if="store.isAdmin!=1" style="text-decoration:none !important" to="/">
                 <v-btn  type="submit" color="gray"
                      >
                     Fermer
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
import { required ,numeric, minLength ,maxLength,sameAs}   from 'vuelidate/lib/validators'
export default{
    name:'edit',
    props:{
        direction:String
    },
    validations:{
        name:{
            required
        },
        lastname:{
            required
        },
        numero_tlf:{
              required,
              numeric,
              minLength:minLength(8),
              maxLength:maxLength(8)
        },
        file:{
            typeFile(val){
                    if(!val){
                         return true;
                     }
                    console.log(val);
                   const regex = new RegExp('\.(gif|jpe?g|svg|png)$');
                   console.log(regex.test(val.type));
                   return regex.test(val.type);
            }
        },
        password:{
            required
        },
        old_password:{
            required,
            async sameas(value) {
                if (value === "") {
                  return true;
                }
                  const response=await axios.get('user/samePassword/'+value);
                  return response.status == 201 || value == "";
              },
        },
        new_password:{
            required,
              minLength:minLength(6),
              maxLength:maxLength(12),
              containsUppercase: function(value) {
                  return /[A-Z]/.test(value);
              },
              containsLowercase: function(value) {
                  return /[a-z]/.test(value);
              },
              containsNumber: function(value) {
                  return /[0-9]/.test(value);
              },
              containsSpecial: function(value) {
                  return /[#?!@$%^&*-]/.test(value);
              }
        },
        confirm_password:{
            required,
            sameas:sameAs('new_password')
        }
    },
    created(){
        this.name=this.store.user['name'];
        this.lastname=this.store.user['lastname'];
        this.email= this.store.user['email'];
        this.numero_tlf= this.store.user['numero_tlf'];
        this.photo=this.store.user['Photo'];
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
            password:'',
            page:0,
            name:'',
            numero_tlf:'',
            lastname:'',
            email:'',
            photo:'',
            show:false,
            show1:false,
            show2:false,
            iduser:'',
            avatarupload:0,
            load:false,
            old_password:'',
            new_password:'',
            confirm_password:''
        }
    },
    methods:{
        UploadFile(){
           //this.file=e.target.files[0];
           this.file=this.$refs.photo.files[0];
           this.avatarupload=1;
        },
        EditUser(){
           console.log(this.password);
            this.$v.name.$touch();
            this.$v.lastname.$touch();
            this.$v.numero_tlf.$touch();
            this.$v.file.$touch();
            if (this.$v.name.$invalid || this.$v.lastname.$invalid || this.$v.numero_tlf.$invalid || this.$v.file.$invalid ) {
                this.load = false;
                return;
              }
              this.load=true;
            service_user.UpdateUser(
               {
                 name:this.name,
                 lastname:this.lastname,
                 photo:this.file,
                 email:this.email,
                 tlf:this.numero_tlf,
                 avatarupload:this.avatarupload
            }).then((response)=>{
                 this.load = false;
                 this.store.login(this.store.user['token'],response.data.data,this.store.getisadmin);
                 if(this.direction=='home'){
                    this.$router.push({name:"home", query: {content: 'Modifier le compte avec succès'}});
                 }else{
                    this.load = false;
                    this.$emit('returnstate');
                 }
               /*console.log(response.data.data);
                 console.log(this.store.user);*/
            }).catch((error)=>{
                this.load = false;
                console.log("error");
            })
        },
        ChangerPassword(){
            this.$v.old_password.$touch();
            this.$v.new_password.$touch();
            this.$v.confirm_password.$touch();
             if (this.$v.old_password.$invalid || this.$v.new_password.$invalid || this.$v.confirm_password.$invalid ) {
                this.load = false;
                return;
              }
              this.load = true;
              service_user.changer_motdepasse(this.new_password).then((res)=>{
                 this.load=false;
                // this.store.login(this.store.user['token'],res.data.data,this.store.getisadmin);
                 if(this.direction=='home'){
                    this.$router.push({name:"home", motdepasse: {content: 'Mot de passe changé avec succès'}});
                 }else{
                    this.load = false;
                    this.$emit('returnstate');
                 }
                 console.log(res);
              }).catch((error)=>{
                 this.load = false;
                 console.log(error);
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
            lastname_error(){
            const errors=[];
              if (!this.$v.lastname.$dirty) return errors;
                !this.$v.lastname.required && errors.push('Prénom obligatoire');
                return errors;
            },
            photo_error(){
                const errors=[];
                if ( !this.$v.file.$dirty) return errors;
                !this.$v.file.typeFile && errors.push('image doit étre de type ( jpg,jpeg,png,svg,gif) ');
                return errors;
            },
            numero_tlf_error(){
             const errors=[];
             if (!this.$v.numero_tlf.$dirty) return errors;
             !this.$v.numero_tlf.required && errors.push('numero obligatoire');
             !this.$v.numero_tlf.maxLength && errors.push('Veuillez entrer numero avec un maximum de 8 number');
             !this.$v.numero_tlf.minLength && errors.push('Veuillez entrer numero avec un minimum de 8 number');
             !this.$v.numero_tlf.numeric && errors.push('numero tlf doit etre entier');
             return errors;
          },
          password_error(){
             const errors=[];
             if (!this.$v.old_password.$dirty) return errors;
              !this.$v.old_password.required && errors.push('Mot de passe obligatoire');
              !this.$v.old_password.sameas && errors.push('Mot de passe incorrect');
              return errors;
          },
          new_password_error(){
            const errors=[];
             if (!this.$v.new_password.$dirty) return errors;
             !this.$v.new_password.required && errors.push('un mot de passe obligatoire');
             !this.$v.new_password.maxLength && errors.push('Veuillez entrer un mot de passe avec un maximum de 12 caractères');
             !this.$v.new_password.minLength && errors.push('Veuillez entrer un mot de passe avec un minimum de 6 caractères');
             !this.$v.new_password.containsUppercase && errors.push('le mot de passe doit contenir des majuscules');
             !this.$v.new_password.containsLowercase && errors.push('le mot de passe doit contenir des minuscule');
             !this.$v.new_password.containsNumber && errors.push('le mot de passe doit contenir des numbers');
             !this.$v.new_password.containsSpecial && errors.push('le mot de passe doit contenir d\'un caractére spécial');
             return errors;
          },
          confirm_password_error(){
            const errors=[];
             if (!this.$v.confirm_password.$dirty) return errors;
             !this.$v.confirm_password.required && errors.push('confirme mot de passe obligatoire');
             !this.$v.confirm_password.sameas && errors.push('confirme mot de passe doit étre identique que le mot de passe');
             return errors;
            }
    }
}
</script>