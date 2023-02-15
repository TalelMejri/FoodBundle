<template>
  <div>
    <div style="z-index:25; !important" class="sidebar_position">
        <SideBar :etatsidbar="true"></SideBar>
    </div>
    <div class="popup-below">
            <v-container fluid fill-height>
                <v-layout class="mt-5 py-5" align-center justify-center>
                   <v-flex  sm8 md4>
                      <v-card class="elevation-12">
                         <v-toolbar dark color="#E84C03">
                            <v-toolbar-title >
                               <div class="d-flex justify-content-center mt-5">
                                   <p>S'incrire</p>
                               </div>
                            </v-toolbar-title>
                         </v-toolbar>
                         <v-card-text>
                         <form  @submit.prevent="Rgister()" enctype="multipart/form-data">

                              <div class="row">
                                 <div class="col-md-6">
                                  <v-text-field
                                  name="Name"
                                  label="Nom"
                                  :error-messages="name_error"
                                  v-model="name"
                                  type="text"
                                  placeholder="Tapez Nom"
                                ></v-text-field>
                             
                                 </div>
                                 <div class="col-md-6">
                                  <v-text-field
                                  name="LastName"
                                  :error-messages="lastname_error"
                                  label="Prenom"
                                  v-model="lastname"
                                  type="text"
                                  placeholder="Tapez Prenom"
                                ></v-text-field>

                                 </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                 <v-text-field
                                 :error-messages="email_error"
                                 name="Email"
                                 label="Email"
                                 type="text"
                                 v-model="email"
                                 placeholder="Entrer Email"
                               ></v-text-field>
                               <small class="mx-3" style="color:red !important" v-if="email_error_final!=''">
                                {{ email_error_final}}
                               </small>
                                </div>
                             </div>
                             <div class="row">
                              <div class="col-md-12">
                                <v-text-field
                                 :error-messages="password_error"
                                  name="password"
                                  label="Mot de passe"
                                  type="password"
                                  v-model="password"
                                  placeholder="Mot de passe"
                               ></v-text-field>
                              </div>
                           </div>
                           <div class="row">
                            <div class="col-md-12">
                              <input   
                                   class="form-control"
                                   :error-messages="photo_error"
                                   type="file" ref="photo"
                                   @change="uploadFile"
                              >   
                            </div>
                             <small class="mx-3" style="color:red !important" v-if="photo_error!=''">
                                {{ photo_error[0] }}
                             </small>
                            <div class="col-md-12">
                             <v-text-field
                             name="N° Phone"
                             label="N° Télephone"
                             :error-messages="numero_tlf_error"
                             v-model="numero_tlf"
                             type="text"
                             placeholder="+216"
                           ></v-text-field>
                            </div>
                         </div>
                        <v-checkbox :error-messages="check_error" v-model="check" >
                          <template v-slot:label>
                            <div>
                           je suis d'accord avec le
                              <span style="color:blue"> Termes et conditions </span>  
                                est génial
                            </div>
                            <div>
                             
                            </div>
                          </template>
                      
                        </v-checkbox> 
                        <div>
                        </div>
                                <div class="mt-3 text-center ">
                                    <v-btn :loading="load" type="submit" class="mt-4 " style="color:#fff !important" color="#E84C03" value="Sign Up">S'incrire</v-btn>
                                    <router-link to="/" class="text-decoration-none  mx-2"> <v-btn type="button" class="mt-4 " color="gray" value="close">Fermer</v-btn></router-link>
                                </div>
                                <div class="text-center mt-3">
                                  Vous avez déjà un compte ?<router-link to="login" class="text-decoration-none  mx-2">  <span>Connexion</span></router-link>
                                </div>
                          </form>
                         </v-card-text>
                      </v-card>
                   </v-flex>
                </v-layout>
             </v-container>
            </div>
         <div>
    <div style="z-index:2; !important" class="content" >
        <div class="ma-5 pa-5" id="home">
          <v-container >
            <v-row>
              <v-col
                cols="auto"
                class="mr-auto"
              >
               <h2> <span style="color:#E84C03;">Food</span>Bundle</h2>
              </v-col>
              <v-col cols="auto">
                <v-row
                align="center"
                justify="space-around"
                gap="4px"
              >  <router-link  to="login" class="text-decoration-none">
                <v-btn class="login mx-2"   >
                  Connexion
                </v-btn>
              </router-link> 
              <router-link to="/signup" class="text-decoration-none">
                <v-btn class="signup" >
                  S'incrire
                </v-btn>
              </router-link> 
              </v-row>
              </v-col>
            </v-row>
             <v-content class="home my-5 py-5 d-flex justify-content-center"  >
              <v-container class="mt-5 py-5" >
                <div class="row mb-6 mt-5 gap-5"
                >
                  <div class="mt-5 py-5 col-lg-6">
                       <p class="py-5 mt-5 paragh" >
                        Goûtez notre<br>
                              Nourriture délicieuse
                       </p>
                       <p  >
                        lore"Lorem ipsum dolor sit amet, consectetur adipiscing 
                        elit, sed do eiusmod tempor incididunt ut labore et dolor
                         magna aliqua. 
                       </p>
                      </div>
                  <div
                    class="col-lg-6 d-lg-block d-none text-center"
                  >
                      <img class="image" src="../../assets/home-img.png" alt="">
                    </div>
                </div>
                <v-btn class="btn">Voir Menu</v-btn>
              </v-container>
             </v-content>
          </v-container>
        </div>
        </div>
        </div>
</div>
</template>

<script>
import service from "../../services/auth";
import SideBar from "../../components/SideBar.vue"
import axios from "axios";
import { required,minLength,maxLength,numeric,email } from 'vuelidate/lib/validators'
    export default{
        name:"signup",
        validations:{
             photo:{
                required,
                typeFile(val){
                   const regex = new RegExp('\.(gif|jpe?g|svg|png)$');
                   return regex.test(val.type);
                }
             },
             name:{
              required,
              minLength:minLength(4),
              maxLength:maxLength(9)
             },
             check:{
               required
             },
             email:{
              email,
              required,
              async exists(value) {
                if (value === "") {
                  return true;
                }
                  const response=await axios.get('auth/exist/'+value);
                  return response.status != 201 || value == "";
              },
             },
             password:{
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
             lastname:{
              required,
              minLength:minLength(4),
              maxLength:maxLength(9)
            },
             numero_tlf:{
              required,
              numeric,
              minLength:minLength(8),
              maxLength:maxLength(8)
             },
         
        },
        data(){
          return{
             checkbox: false,
             load:false,
             name:'',
             check:'',
             email:'',
             email_error_final:'',
             password:'',
             lastname:'',
             numero_tlf:'',
             photo:''
          }
        },
        components:{
            SideBar
        },
        methods:{
          uploadFile(){
            //this.photo.value =e.target.files[0];
            this.photo =this.$refs.photo.files[0];
          },
          Rgister(){
            this.$v.$touch();
             if (this.$v.$invalid) {
                this.load = false;
                return;
              }
            this.load=true;
            service.CreateUser({
               name:this.name,
               photo:this.photo,
               email:this.email,
               password:this.password,
               lastname:this.lastname,
               numero_tlf:this.numero_tlf
            }).then((response)=>{
              this.name="";
              this.photo="";
              this.email="";
              this.password="";
              this.lastname="";
              this.numero_tlf="";
              this.check="";
              this.load=false;
              this.$router.push({name:"login", query: {content: 'Inscrivez-vous avec succès'}});
            }).catch((error)=>{
              // this.name.error=error.response.data.errors.name ? error.response.data.errors.name[0] : '';
              // this.photo.error=error.response.data.errors.Photo ? error.response.data.errors.Photo[0] : '';
              // this.email_error_final=error.response.data.errors.email ? error.response.data.errors.email[0] : '';
              // this.password.error=error.response.data.errors.password ? error.response.data.errors.password[0] : '';
              // this.lastname.error=error.response.data.errors.lastname ? error.response.data.errors.lastname[0] : '';
              // this.numero_tlf.error=error.response.data.errors.numero_tlf ? error.response.data.errors.numero_tlf[0] : '';
              // this.check.error=this.check.value==false ? 'check Agree obligatoire' : '' ;
              this.load=false;
            })
          }
        },
        computed:{
          photo_error(){
            const errors=[];
            if (!this.$v.photo.$dirty) return errors;
             !this.$v.photo.required && errors.push('image obligatoire');
             !this.$v.photo.typeFile && errors.push('image doit étre de type ( jpg,jpeg,png,svg,gif) ');
             return errors;
          },
          name_error(){
            const errors=[];
            if (!this.$v.name.$dirty) return errors;
             !this.$v.name.required && errors.push('Nom obligatoire');
             !this.$v.name.maxLength && errors.push('Veuillez entrer Nom avec un maximum de 9 caractères');
             !this.$v.name.minLength && errors.push('Veuillez entrer Nom avec un minimum de 4 caractères');
             return errors;
          },
          lastname_error(){
            const errors=[];
             if (!this.$v.lastname.$dirty) return errors;
             !this.$v.lastname.required && errors.push('Prenom obligatoire');
             !this.$v.lastname.maxLength && errors.push('Veuillez entrer Prenom avec un maximum de 9 caractères');
             !this.$v.lastname.minLength && errors.push('Veuillez entrer Prenom avec un minimum de 4 caractères');
             return errors;
          },
         email_error(){
            const errors=[];
             if (!this.$v.email.$dirty) return errors;
             !this.$v.email.required && errors.push('email obligatoire');
             !this.$v.email.email && errors.push('email invalid');
             !this.$v.email.exists && errors.push('email est exite');
             return errors;
         },
            password_error(){
            const errors=[];
             if (!this.$v.password.$dirty) return errors;
             !this.$v.password.required && errors.push('un mot de passe obligatoire');
             !this.$v.password.maxLength && errors.push('Veuillez entrer un mot de passe avec un maximum de 12 caractères');
             !this.$v.password.minLength && errors.push('Veuillez entrer un mot de passe avec un minimum de 6 caractères');
             !this.$v.password.containsUppercase && errors.push('le mot de passe doit contenir des majuscules');
             !this.$v.password.containsLowercase && errors.push('le mot de passe doit contenir des minuscule');
             !this.$v.password.containsNumber && errors.push('le mot de passe doit contenir des numbers');
             !this.$v.password.containsSpecial && errors.push('le mot de passe doit contenir d\'un caractére spécial');
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
          check_error(){
              const errors=[];
             if (!this.$v.check.$dirty) return errors;
                !this.$v.check.required && errors.push('check obligatoire');
             return errors;
          }
        }
    }
</script>

<style>
.popup-below {
    position: fixed; /* Stay in place */
    z-index: 999999999;
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.popup_form{
    position: fixed;
    top: 50%;
    left:50%;
    flex-direction: column;
    transform: translate(-50%,-50%)scale(0.9);
    background: #fff;
    width:70%;
    border-radius: 10px;
    height:60%;
    z-index: 999999999;
    display: flex;
    justify-content: center;
    align-items: center;
    padding:88px;
}

small{
  color:gray !important;
  font-size: 13px !important;
}

.move_input {
  animation: animate 0.5s;
}

@keyframes animate {
  0% {
    transform: translateX(10px);
  }
  50% {
    transform: translateX(-10px);
  }
  100% {
    transform: translateX(0);
  }
}
</style>